<?php

namespace Johhann\Telebirr\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallConfigFile extends Command
{
    protected $signature = 'telebirr:install';

    protected $description = 'Install the telebirr configuration file';

    public function handle()
    {
        $this->info('Installing Telebirr configuration file...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('telebirr.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration.');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration(forcePublish: true);
            } else {
                $this->info('Skipping configuration installation...');
            }
        }

        $this->info('Installed telebirr configuration file.');
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Johhann\Telebirr\TelebirrServiceProvider",
            '--tag' => 'telebirr.config',
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}
