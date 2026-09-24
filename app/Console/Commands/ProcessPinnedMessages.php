<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PinnedMessageService;

class ProcessPinnedMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:process-pinned-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and delete expired pinned messages';

    /**
     * Execute the console command.
     */
    public function handle(PinnedMessageService $service)
    {
        $this->info('Processing pinned messages...');
        $service->processExpiredPins();
        $this->info('Done processing pinned messages.');
    }
}
