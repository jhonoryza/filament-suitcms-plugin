<?php

namespace Fajar\Filament\Suitcms\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateDefaultModel extends Command
{
    protected $description = 'Generate default model';

    protected $signature = 'cms:default-model';

    public function handle(): void
    {
        $filesystem = new Filesystem();

        $stub = '/stubs/defaultModel.stub';

        $classes = [
            'Admin',
            'Role',
            'Permission',
            'SeoMeta',
            'Setting',
        ];

        foreach ($classes as $class) {
            $contents = $filesystem->get(__DIR__ . $stub);
            $contents = Str::replace('{{ $class }}', $class, $contents);
            // cek apakah file model sudah ada
            if (!File::exists(app_path('Models/' . $class . '.php'))) {
                $filesystem->put(app_path('Models/' . $class . '.php'), $contents);
            }
        }
    }
}