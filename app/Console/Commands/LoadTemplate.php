<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LoadTemplate extends Command
{
    protected $signature = 'load-template';

    protected $description = 'Command description';

    protected $templates = [
        'empty',
        'simple-crud',
        'sandbox',
        'crm',
        'cms',
    ];

    protected $resources = [
        [
            'path' => 'routes/api.php',
            'type' => 'file'
        ],
        [
            'path' => 'database',
            'type' => 'dir'
        ],
        [
            'path' => 'app/Models',
            'type' => 'dir'
        ],
        [
            'path' => 'app/Http/Controllers',
            'type' => 'dir'
        ],
        [
            'path' => 'app/Resources',
            'type' => 'dir'
        ],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $template = $this->choice('Select template:', $this->templates);
        $this->line('"'.$template.'" template selected. Please wait...');
        try {
            foreach ($this->resources as $resource) {
                if($resource['type'] === 'file'){
                    File::delete(base_path($resource['path']));
                    File::copy(base_path('templates/'.$template.'/'.$resource['path']), base_path($resource['path']));
                } else if ($resource['type'] === 'dir') {
                    File::deleteDirectory(base_path($resource['path']));
                    File::copyDirectory(base_path('templates/'.$template.'/'.$resource['path']), base_path($resource['path']));
                }
            }
            $this->info('Template has been loaded');
        } catch (Exception $e) {
            $this->error('Error! Template loading failed');
        }
    }
}
