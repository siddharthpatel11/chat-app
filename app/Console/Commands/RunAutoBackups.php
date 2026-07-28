<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunAutoBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-auto-backups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::whereNotNull('google_drive_refresh_token')
                                 ->whereNotNull('chat_backup_frequency')
                                 ->where('chat_backup_frequency', '!=', 'Off')
                                 ->where('chat_backup_frequency', '!=', 'Only when I tap "Back up"')
                                 ->get();

        if ($users->isEmpty()) {
            return;
        }

        $client = new \Google\Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET', ''));
        
        $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
        $client->setHttpClient($guzzleClient);

        foreach ($users as $user) {
            $lastBackup = $user->last_chat_backup_at ? strtotime($user->last_chat_backup_at) : 0;
            $now = time();
            $freq = $user->chat_backup_frequency;
            
            $shouldBackup = false;
            
            if ($freq === '5 Minutes' && ($now - $lastBackup) > 5 * 60) {
                $shouldBackup = true;
            } else if ($freq === 'Daily' && ($now - $lastBackup) > 24 * 60 * 60) {
                $shouldBackup = true;
            } else if ($freq === 'Weekly' && ($now - $lastBackup) > 7 * 24 * 60 * 60) {
                $shouldBackup = true;
            } else if ($freq === 'Monthly' && ($now - $lastBackup) > 30 * 24 * 60 * 60) {
                $shouldBackup = true;
            }

            if ($shouldBackup) {
                try {
                    $client->refreshToken($user->google_drive_refresh_token);
                    $token = $client->getAccessToken();
                    
                    if (isset($token['access_token'])) {
                        $req = new \Illuminate\Http\Request();
                        $req->merge([
                            'google_access_token' => $token['access_token'],
                            'user_id' => $user->id
                        ]);
                        $req->setUserResolver(function() use ($user) { return $user; });
                        
                        $controller = app(\App\Http\Controllers\Api\BackupRestoreApiController::class);
                        $res = $controller->backup($req);
                        
                        if ($res->getStatusCode() == 200) {
                            $user->last_chat_backup_at = now();
                            $user->save();
                            $this->info("Backup successful for user {$user->id}");
                        } else {
                            $this->error("Backup failed for user {$user->id}: " . $res->getContent());
                        }
                    } else {
                        $this->error("Could not get access token for user {$user->id}");
                    }
                } catch (\Exception $e) {
                    $this->error("Exception for user {$user->id}: " . $e->getMessage());
                }
            }
        }
    }
}
