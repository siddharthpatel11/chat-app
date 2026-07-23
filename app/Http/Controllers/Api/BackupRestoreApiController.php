<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BackupRestoreApiController extends Controller
{
    protected $db;

    public function __construct()
    {
        $firebaseService = app(\App\Services\FirebaseService::class);
        $this->db = $firebaseService->database();
    }

    public function backup(Request $request)
    {
        $request->validate([
            'google_access_token' => 'required|string',
            'e2e_password' => 'nullable|string',
        ]);

        $token = $request->google_access_token;
        $e2ePassword = $request->e2e_password;

        try {
            // 1. Fetch data from Firebase
            $fullData = $this->db->getReference('/')->getValue() ?: [];
            $userId = auth()->id() ?? $request->user_id;

            $dataPayload = [
                'timestamp' => now()->timestamp * 1000,
                'chats' => [],
                'messages' => [],
                'groups' => [],
                'broadcasts' => [],
                'communities' => [],
                'channels' => [],
                'pinned_msgs' => [],
                'starred_messages' => [],
                'meta_ai_chats' => [],
            ];

            if ($userId) {
                // Filter Groups
                $validGroupIds = [];
                if (isset($fullData['groups'])) {
                    foreach ($fullData['groups'] as $groupId => $groupData) {
                        $isMember = false;
                        if (isset($groupData['members'])) {
                            foreach ($groupData['members'] as $member) {
                                if (isset($member['user_id']) && $member['user_id'] == $userId) {
                                    $isMember = true;
                                    break;
                                }
                            }
                        }
                        if ($isMember || (isset($groupData['created_by']) && $groupData['created_by'] == $userId)) {
                            $dataPayload['groups'][$groupId] = $groupData;
                            $validGroupIds[$groupId] = true;
                        }
                    }
                }

                // Filter Broadcasts
                $validBroadcastIds = [];
                if (isset($fullData['broadcasts'])) {
                    foreach ($fullData['broadcasts'] as $bcastId => $bcastData) {
                        if (isset($bcastData['created_by']) && $bcastData['created_by'] == $userId) {
                            $dataPayload['broadcasts'][$bcastId] = $bcastData;
                            $validBroadcastIds[$bcastId] = true;
                        }
                    }
                }

                // Filter Chats
                $validChatIds = [];
                if (isset($fullData['chats'])) {
                    foreach ($fullData['chats'] as $chatId => $chatData) {
                        $include = false;
                        if (preg_match('/^\d+_\d+$/', $chatId)) {
                            // 1-on-1 chat
                            if (in_array((string)$userId, explode('_', $chatId))) {
                                $include = true;
                            }
                        } elseif (strpos($chatId, 'chat_') === 0 || strpos($chatId, 'group_') === 0 || strpos($chatId, 'gc_') === 0) {
                            // Group chat
                            if (isset($chatData['users']) && in_array($userId, array_values($chatData['users']))) {
                                $include = true;
                            } elseif (isset($chatData['participants']) && in_array($userId, array_values($chatData['participants']))) {
                                $include = true;
                            }
                        } elseif (strpos($chatId, 'broadcast_') === 0 || strpos($chatId, 'bcast_') === 0) {
                            // Broadcast chat
                            $baseBcastId = str_replace(['broadcast_', 'bcast_'], '', $chatId);
                            // Some frontend bugs prefix broadcast_ or bcast_ multiple times. Just check if it's in our valid list.
                            // The key in broadcasts is bcast_{id}, so let's check against that format too.
                            if (isset($validBroadcastIds[$chatId]) || isset($validBroadcastIds['bcast_' . $baseBcastId]) || isset($validBroadcastIds[$baseBcastId])) {
                                $include = true;
                            }
                        }
                        
                        if ($include) {
                            $dataPayload['chats'][$chatId] = $chatData;
                            $validChatIds[$chatId] = true;
                        }
                    }
                }

                // Filter Messages (if they are at the root)
                if (isset($fullData['messages'])) {
                    foreach ($fullData['messages'] as $msgChatId => $msgData) {
                        if (isset($validChatIds[$msgChatId])) {
                            $dataPayload['messages'][$msgChatId] = $msgData;
                        }
                    }
                }

                // Filter Communities
                if (isset($fullData['communities'])) {
                    foreach ($fullData['communities'] as $commId => $commData) {
                        $include = false;
                        if (isset($commData['created_by']) && $commData['created_by'] == $userId) {
                            $include = true;
                        }
                        if (isset($commData['users'])) {
                            $uList = is_array($commData['users']) ? $commData['users'] : array_values((array)$commData['users']);
                            if (in_array((string)$userId, array_map('strval', $uList))) {
                                $include = true;
                            }
                        }
                        if ($include) {
                            $dataPayload['communities'][$commId] = $commData;
                        }
                    }
                }

                // Filter Channels
                if (isset($fullData['channels'])) {
                    foreach ($fullData['channels'] as $chId => $chData) {
                        $include = false;
                        if (isset($chData['created_by']) && $chData['created_by'] == $userId) {
                            $include = true;
                        }
                        if (isset($chData['followers']) && isset($chData['followers'][$userId])) {
                            $include = true;
                        }
                        if (isset($chData['admins']) && isset($chData['admins'][$userId])) {
                            $include = true;
                        }
                        if ($include) {
                            $dataPayload['channels'][$chId] = $chData;
                        }
                    }
                }

                // User Profile and Settings
                if (isset($fullData['users'][$userId])) {
                    $dataPayload['users'] = [$userId => $fullData['users'][$userId]];
                }
                if (isset($fullData['settings'])) {
                    if (is_array($fullData['settings']) && isset($fullData['settings'][$userId])) {
                        $dataPayload['settings'] = [];
                        $dataPayload['settings'][$userId] = $fullData['settings'][$userId];
                    } elseif (isset($fullData['settings'][$userId])) {
                        $dataPayload['settings'] = [$userId => $fullData['settings'][$userId]];
                    }
                }

                // Filter Global Pinned Messages
                if (isset($fullData['pinned_msgs'])) {
                    foreach ($fullData['pinned_msgs'] as $msgKey => $msgData) {
                        $found = false;
                        foreach ($dataPayload['chats'] as $chatData) {
                            if (isset($chatData['messages']) && isset($chatData['messages'][$msgKey])) {
                                $found = true;
                                break;
                            }
                        }
                        if ($found) {
                            $dataPayload['pinned_msgs'][$msgKey] = $msgData;
                        }
                    }
                }

                // Starred Messages
                if (isset($fullData['starred_messages']) && isset($fullData['starred_messages'][$userId])) {
                    $dataPayload['starred_messages'] = [$userId => $fullData['starred_messages'][$userId]];
                }

                // Meta AI Chats
                if (isset($fullData['meta_ai_chats']) && isset($fullData['meta_ai_chats'][$userId])) {
                    $dataPayload['meta_ai_chats'] = [$userId => $fullData['meta_ai_chats'][$userId]];
                }
            } else {
                // Fallback to empty backup if no user identified
            }

            $fileContent = json_encode($dataPayload);

            // 2. Mock Encryption (matching web behavior)
            if ($e2ePassword) {
                // The web app simply checks if e2e is enabled, if so, it base64 encodes it.
                // It does not actually encrypt using the password on the backend, 
                // the password is just a signature on the frontend. We match the structure.
                $encryptedData = [
                    'isEncrypted' => true,
                    // PHP equivalent to JS: btoa(unescape(encodeURIComponent(str)))
                    'cipherText' => base64_encode($fileContent) 
                ];
                $fileContent = json_encode($encryptedData);
            }

            // 3. Search for existing backup file in Google Drive
            $searchRes = Http::withToken($token)->withoutVerifying()->get('https://www.googleapis.com/drive/v3/files', [
                'q' => "name='whatsapp_clone_backup.json' and trashed=false",
                'spaces' => 'drive',
                'fields' => 'files(id, name)'
            ]);

            if (!$searchRes->successful()) {
                return response()->json(['error' => 'Failed to access Google Drive', 'details' => $searchRes->json()], 400);
            }

            $files = $searchRes->json('files');
            $fileId = null;

            if (count($files) > 0) {
                $fileId = $files[0]['id'];
            } else {
                // Create empty metadata file
                $createRes = Http::withToken($token)->withoutVerifying()->post('https://www.googleapis.com/drive/v3/files', [
                    'name' => 'whatsapp_clone_backup.json'
                ]);

                if (!$createRes->successful()) {
                    return response()->json(['error' => 'Failed to create backup file in Drive', 'details' => $createRes->json()], 400);
                }

                $fileId = $createRes->json('id');
            }

            // 4. Upload file content via media upload
            $uploadRes = Http::withToken($token)->withoutVerifying()
                ->withBody($fileContent, 'application/json')
                ->patch("https://www.googleapis.com/upload/drive/v3/files/{$fileId}?uploadType=media");

            if (!$uploadRes->successful()) {
                return response()->json(['error' => 'Failed to upload backup content', 'details' => $uploadRes->json()], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Backup completed successfully',
                'file_id' => $fileId,
                'timestamp' => $dataPayload['timestamp']
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'google_access_token' => 'required|string',
            'e2e_password' => 'nullable|string',
        ]);

        $token = $request->google_access_token;
        $e2ePassword = $request->e2e_password; // E2E verification is technically client-side in this mock setup

        try {
            // 1. Find the backup file
            $searchRes = Http::withToken($token)->withoutVerifying()->get('https://www.googleapis.com/drive/v3/files', [
                'q' => "name='whatsapp_clone_backup.json' and trashed=false",
                'spaces' => 'drive',
                'fields' => 'files(id, name)'
            ]);

            if (!$searchRes->successful()) {
                return response()->json(['error' => 'Failed to access Google Drive', 'details' => $searchRes->json()], 400);
            }

            $files = $searchRes->json('files');
            
            if (count($files) === 0) {
                return response()->json(['error' => 'No backup found in Google Drive'], 404);
            }

            $fileId = $files[0]['id'];

            // 2. Download the content
            $downloadRes = Http::withToken($token)->withoutVerifying()->get("https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media");

            if (!$downloadRes->successful()) {
                return response()->json(['error' => 'Failed to download backup content', 'details' => $downloadRes->json()], 400);
            }

            $backupData = $downloadRes->json();

            // 3. Decrypt if needed
            if (isset($backupData['isEncrypted']) && $backupData['isEncrypted'] === true) {
                if (empty($e2ePassword)) {
                    return response()->json(['error' => 'Backup is encrypted. Password required.'], 400);
                }
                
                // Decode the base64 cipherText
                $decryptedStr = base64_decode($backupData['cipherText']);
                if ($decryptedStr === false) {
                    return response()->json(['error' => 'Failed to decode backup content'], 400);
                }
                
                $data = json_decode($decryptedStr, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Decrypted backup is not valid JSON'], 400);
                }
            } else {
                $data = $backupData;
            }

            // 4. Map updates and push to Firebase
            $updates = [];
            if (isset($data['chats']) && is_array($data['chats'])) {
                foreach ($data['chats'] as $id => $val) {
                    $updates["chats/{$id}"] = $val;
                }
            }
            if (isset($data['messages']) && is_array($data['messages'])) {
                foreach ($data['messages'] as $id => $val) {
                    $updates["messages/{$id}"] = $val;
                }
            }
            if (isset($data['groups']) && is_array($data['groups'])) {
                foreach ($data['groups'] as $id => $val) {
                    $updates["groups/{$id}"] = $val;
                }
            }
            if (isset($data['broadcasts']) && is_array($data['broadcasts'])) {
                foreach ($data['broadcasts'] as $id => $val) {
                    $updates["broadcasts/{$id}"] = $val;
                }
            }
            if (isset($data['communities']) && is_array($data['communities'])) {
                foreach ($data['communities'] as $id => $val) {
                    $updates["communities/{$id}"] = $val;
                }
            }
            if (isset($data['channels']) && is_array($data['channels'])) {
                foreach ($data['channels'] as $id => $val) {
                    $updates["channels/{$id}"] = $val;
                }
            }
            if (isset($data['settings']) && is_array($data['settings'])) {
                // Determine if it's a numeric array (list) or associative array
                if (array_is_list($data['settings'])) {
                    foreach ($data['settings'] as $index => $val) {
                        if ($val !== null) {
                            $updates["settings/{$index}"] = $val;
                        }
                    }
                } else {
                    foreach ($data['settings'] as $id => $val) {
                        $updates["settings/{$id}"] = $val;
                    }
                }
            }
            if (isset($data['users']) && is_array($data['users'])) {
                foreach ($data['users'] as $id => $val) {
                    $updates["users/{$id}"] = $val;
                }
            }
            if (isset($data['pinned_msgs']) && is_array($data['pinned_msgs'])) {
                foreach ($data['pinned_msgs'] as $id => $val) {
                    $updates["pinned_msgs/{$id}"] = $val;
                }
            }
            if (isset($data['starred_messages']) && is_array($data['starred_messages'])) {
                foreach ($data['starred_messages'] as $id => $val) {
                    $updates["starred_messages/{$id}"] = $val;
                }
            }
            if (isset($data['meta_ai_chats']) && is_array($data['meta_ai_chats'])) {
                foreach ($data['meta_ai_chats'] as $id => $val) {
                    $updates["meta_ai_chats/{$id}"] = $val;
                }
            }

            if (!empty($updates)) {
                // Break into chunks if updates array is too large, but typically it should be fine.
                $this->db->getReference()->update($updates);
            }

            return response()->json([
                'success' => true,
                'message' => 'Restore completed successfully',
                'restored_nodes' => array_keys($updates)
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
