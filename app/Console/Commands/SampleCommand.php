<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a sample command';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Sample command executed successfully!');
    }
}
