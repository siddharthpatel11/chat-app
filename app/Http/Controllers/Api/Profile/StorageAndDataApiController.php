<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class StorageAndDataApiController extends Controller
{
    use ApiResponse;

    protected $db;

    public function __construct()
    {
        if (file_exists(storage_path('app/firebase.json'))) {
            $factory = (new Factory)
                ->withServiceAccount(storage_path('app/firebase.json'))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

            $this->db = $factory->createDatabase();
        }
    }

    /**
     * Get user's storage and data settings
     */
    public function getSettings(Request $request)
    {
        if (!$this->db) {
            return $this->errorResponse('Firebase not configured', 500);
        }

        $userId = $request->user()->id;

        try {
            $reference = $this->db->getReference("users/{$userId}/settings");
            $snapshot = $reference->getSnapshot();
            
            $settings = $snapshot->exists() ? $snapshot->getValue() : [];

            // Extract only the fields we care about, with defaults
            $data = [
                'use_less_data_calls' => isset($settings['use_less_data_calls']) ? filter_var($settings['use_less_data_calls'], FILTER_VALIDATE_BOOLEAN) : false,
                
                'media_upload_quality' => $settings['media_upload_quality'] ?? 'HD quality',
                'auto_download_quality' => $settings['auto_download_quality'] ?? 'HD quality',
                
                'media_auto_download' => [
                    'mobile_data' => $settings['media_auto_download_mobile_data'] ?? ['photos'],
                    'wifi' => $settings['media_auto_download_wifi'] ?? ['photos'],
                    'roaming' => $settings['media_auto_download_roaming'] ?? [],
                ],
                
                'proxy' => [
                    'enabled' => isset($settings['proxy_enabled']) ? filter_var($settings['proxy_enabled'], FILTER_VALIDATE_BOOLEAN) : false,
                    'config' => $settings['proxy_config'] ?? null,
                ]
            ];

            return $this->successResponse($data, 'Storage and data settings retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch settings: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update user's storage and data settings
     */
    public function updateSettings(Request $request)
    {
        if (!$this->db) {
            return $this->errorResponse('Firebase not configured', 500);
        }

        $userId = $request->user()->id;
        
        $request->validate([
            'use_less_data_calls' => 'nullable|boolean',
            'media_upload_quality' => 'nullable|string',
            'auto_download_quality' => 'nullable|string',
            
            'media_auto_download' => 'nullable|array',
            'media_auto_download.mobile_data' => 'nullable|array',
            'media_auto_download.wifi' => 'nullable|array',
            'media_auto_download.roaming' => 'nullable|array',
            
            'proxy' => 'nullable|array',
            'proxy.enabled' => 'nullable|boolean',
            'proxy.config' => 'nullable|array',
        ]);

        try {
            $updates = [];

            if ($request->has('use_less_data_calls')) {
                $updates["users/{$userId}/settings/use_less_data_calls"] = filter_var($request->use_less_data_calls, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
            }

            if ($request->has('media_upload_quality')) {
                $updates["users/{$userId}/settings/media_upload_quality"] = $request->media_upload_quality;
            }

            if ($request->has('auto_download_quality')) {
                $updates["users/{$userId}/settings/auto_download_quality"] = $request->auto_download_quality;
            }

            if ($request->has('media_auto_download')) {
                $mad = $request->media_auto_download;
                if (array_key_exists('mobile_data', $mad)) {
                    $updates["users/{$userId}/settings/media_auto_download_mobile_data"] = $mad['mobile_data'] ?: [];
                }
                if (array_key_exists('wifi', $mad)) {
                    $updates["users/{$userId}/settings/media_auto_download_wifi"] = $mad['wifi'] ?: [];
                }
                if (array_key_exists('roaming', $mad)) {
                    $updates["users/{$userId}/settings/media_auto_download_roaming"] = $mad['roaming'] ?: [];
                }
            }

            if ($request->has('proxy')) {
                $proxy = $request->proxy;
                if (array_key_exists('enabled', $proxy)) {
                    $updates["users/{$userId}/settings/proxy_enabled"] = filter_var($proxy['enabled'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
                }
                if (array_key_exists('config', $proxy)) {
                    $config = $proxy['config'];
                    if (is_array($config)) {
                        $config['updated_at'] = now()->toIso8601String();
                        $updates["users/{$userId}/settings/proxy_config"] = $config;
                    }
                }
            }
            
            if (!empty($updates)) {
                $this->db->getReference()->update($updates);
            }

            return $this->successResponse(null, 'Storage and data settings updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update settings: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get manage storage stats by aggregating media sizes from chats
     */
    public function getManageStorageStats(Request $request)
    {
        if (!$this->db) {
            return $this->errorResponse('Firebase not configured', 500);
        }

        $userId = $request->user()->id;

        try {
            // Fetch relevant data from Firebase
            $chatsSnap = $this->db->getReference('chats')->getSnapshot();
            $messagesSnap = $this->db->getReference('messages')->getSnapshot();
            $usersSnap = $this->db->getReference('users')->getSnapshot();
            
            $chats = $chatsSnap->exists() ? $chatsSnap->getValue() : [];
            $messages = $messagesSnap->exists() ? $messagesSnap->getValue() : [];
            $usersData = $usersSnap->exists() ? $usersSnap->getValue() : [];

            $totalMediaBytes = 0;
            $largerThan5mb = [];
            $chatStorageMap = [];

            // 1. Identify which chats the user is part of and compute sizes
            foreach ($chats as $chatId => $chatData) {
                if (isset($chatData['users']) && in_array($userId, $chatData['users'])) {
                    // Determine the name of the chat (other user's name)
                    $chatName = 'Unknown Chat';
                    $avatar = '';
                    foreach ($chatData['users'] as $uId) {
                        if ($uId != $userId && isset($usersData[$uId])) {
                            $chatName = $usersData[$uId]['saved_name'] ?? $usersData[$uId]['name'] ?? $usersData[$uId]['phone'] ?? 'Unknown User';
                            $avatar = $usersData[$uId]['avatar'] ?? "https://ui-avatars.com/api/?name=".urlencode($chatName)."&background=random&color=fff";
                            break;
                        }
                    }

                    $chatBytes = 0;
                    
                    if (isset($messages[$chatId])) {
                        foreach ($messages[$chatId] as $msgId => $msg) {
                            if (isset($msg['file_size']) && isset($msg['file_url'])) {
                                $size = (int) $msg['file_size'];
                                $chatBytes += $size;
                                $totalMediaBytes += $size;

                                if ($size > 5 * 1024 * 1024) {
                                    $largerThan5mb[] = [
                                        'message_id' => $msgId,
                                        'chat_id' => $chatId,
                                        'file_url' => $msg['file_url'],
                                        'file_name' => $msg['file_name'] ?? 'Media',
                                        'file_type' => $msg['type'] ?? 'unknown',
                                        'size_bytes' => $size,
                                        'size_formatted' => $this->formatBytes($size)
                                    ];
                                }
                            }
                        }
                    }

                    if ($chatBytes > 0) {
                        $chatStorageMap[] = [
                            'id' => $chatId,
                            'name' => $chatName,
                            'avatar' => $avatar,
                            'type' => 'chat',
                            'size_bytes' => $chatBytes,
                            'size_formatted' => $this->formatBytes($chatBytes)
                        ];
                    }
                }
            }

            // We can also add logic for groups and channels here similarly if they are in 'groups' and 'channels' nodes

            // Sort chat map by size descending
            usort($chatStorageMap, function($a, $b) {
                return $b['size_bytes'] <=> $a['size_bytes'];
            });

            // Sort >5MB by size descending
            usort($largerThan5mb, function($a, $b) {
                return $b['size_bytes'] <=> $a['size_bytes'];
            });

            $data = [
                'total_media_bytes' => $totalMediaBytes,
                'total_media_formatted' => $this->formatBytes($totalMediaBytes),
                'larger_than_5mb' => $largerThan5mb,
                'chat_storage_details' => $chatStorageMap
            ];

            return $this->successResponse($data, 'Storage statistics fetched successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch storage stats: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get user's network usage stats
     */
    public function getNetworkUsageStats(Request $request)
    {
        if (!$this->db) {
            return $this->errorResponse('Firebase not configured', 500);
        }

        $userId = $request->user()->id;

        try {
            $reference = $this->db->getReference("users/{$userId}/network_stats");
            $snapshot = $reference->getSnapshot();
            
            if ($snapshot->exists()) {
                $stats = $snapshot->getValue();
            } else {
                // Default stats structure if none exists
                $stats = [
                    'since_date' => now()->format('d/m/Y'),
                    'categories' => [
                        ['id' => 'calls', 'name' => 'Calls', 'sent_bytes' => 0, 'received_bytes' => 0, 'outgoing_count' => 0, 'incoming_count' => 0],
                        ['id' => 'media', 'name' => 'Media', 'sent_bytes' => 0, 'received_bytes' => 0],
                        ['id' => 'google_storage', 'name' => 'Google storage', 'sent_bytes' => 0, 'received_bytes' => 0],
                        ['id' => 'messages', 'name' => 'Messages', 'sent_bytes' => 0, 'received_bytes' => 0, 'outgoing_count' => 0, 'incoming_count' => 0],
                        ['id' => 'status', 'name' => 'Status', 'sent_bytes' => 0, 'received_bytes' => 0, 'outgoing_count' => 0, 'incoming_count' => 0],
                        ['id' => 'roaming', 'name' => 'Roaming', 'sent_bytes' => 0, 'received_bytes' => 0]
                    ]
                ];
                // Save default stats
                $reference->set($stats);
            }

            $totalSent = 0;
            $totalReceived = 0;
            
            if (isset($stats['categories']) && is_array($stats['categories'])) {
                foreach ($stats['categories'] as $cat) {
                    $totalSent += $cat['sent_bytes'] ?? 0;
                    $totalReceived += $cat['received_bytes'] ?? 0;
                }
            }

            $data = [
                'total_sent_bytes' => $totalSent,
                'total_received_bytes' => $totalReceived,
                'total_sent_formatted' => $this->formatBytes($totalSent),
                'total_received_formatted' => $this->formatBytes($totalReceived),
                'since_date' => $stats['since_date'] ?? now()->format('d/m/Y'),
                'categories' => $stats['categories'] ?? []
            ];

            return $this->successResponse($data, 'Network usage fetched successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch network usage: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Reset user's network usage stats
     */
    public function resetNetworkUsageStats(Request $request)
    {
        if (!$this->db) {
            return $this->errorResponse('Firebase not configured', 500);
        }

        $userId = $request->user()->id;

        try {
            $stats = [
                'since_date' => now()->format('d/m/Y'),
                'categories' => [
                    ['id' => 'calls', 'name' => 'Calls', 'sent_bytes' => 0, 'received_bytes' => 0, 'outgoing_count' => 0, 'incoming_count' => 0],
                    ['id' => 'media', 'name' => 'Media', 'sent_bytes' => 0, 'received_bytes' => 0],
                    ['id' => 'google_storage', 'name' => 'Google storage', 'sent_bytes' => 0, 'received_bytes' => 0],
                    ['id' => 'messages', 'name' => 'Messages', 'sent_bytes' => 0, 'received_bytes' => 0, 'outgoing_count' => 0, 'incoming_count' => 0],
                    ['id' => 'status', 'name' => 'Status', 'sent_bytes' => 0, 'received_bytes' => 0, 'outgoing_count' => 0, 'incoming_count' => 0],
                    ['id' => 'roaming', 'name' => 'Roaming', 'sent_bytes' => 0, 'received_bytes' => 0]
                ]
            ];

            $this->db->getReference("users/{$userId}/network_stats")->set($stats);

            return $this->successResponse(null, 'Network usage reset successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to reset network usage: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Helper to format bytes
     */
    private function formatBytes($bytes)
    {
        if ($bytes > 1024 * 1024 * 1024) return number_format($bytes / (1024 * 1024 * 1024), 1) . ' GB';
        if ($bytes > 1024 * 1024) return number_format($bytes / (1024 * 1024), 1) . ' MB';
        return number_format($bytes / 1024, 1) . ' KB';
    }
}
