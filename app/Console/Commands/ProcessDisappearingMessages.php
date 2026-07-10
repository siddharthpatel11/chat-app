<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessDisappearingMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:process-disappearing-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and delete expired disappearing messages';

    /**
     * Execute the console command.
     */
    public function handle(\App\Services\DisappearingMessageService $service)
    {
        $this->info('Processing disappearing messages...');
        $service->processExpiredMessages();
        $this->info('Done processing disappearing messages.');
    }
}
