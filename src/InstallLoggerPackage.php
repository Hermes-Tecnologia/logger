<?php

namespace HermesTecnologia\Logger;

use Illuminate\Console\Command;

class InstallLoggerPackage extends Command
{
    protected $signature = 'logger:install';
    protected $description = 'Install the Logger package';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => 'HermesTecnologia\Logger\LoggerServiceProvider',
            '--tag' => 'config',
            '--force' => true
        ]);
        
        $this->info('Logger package installed successfully!');
    }
}