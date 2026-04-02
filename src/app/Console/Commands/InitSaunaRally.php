<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class InitSaunaRally extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-sauna-rally';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初期化';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('All data in storage will be deleted. Are you sure you want to proceed?')) {
            $this->info('Canceled.');
            return;
        }

        $this->call('migrate:fresh', ['--seed' => true]);

        $directories = ['content', 'sauna', 'tmp'];
        foreach ( $directories as $directory ) {
            if (Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->deleteDirectory($directory);
                $this->line("Directory [{$directory}] deleted.");
            }
        }

        $this->info('Storage And DB Clean completed.');
    }
}
