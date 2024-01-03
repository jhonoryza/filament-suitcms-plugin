<?php

namespace Fajar\Filament\Suitcms\Commands;

use Fajar\Filament\Suitcms\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class SyncCmsPermission extends Command
{
    private mixed $config;

    protected $signature = 'cms:permission-sync';

    protected $description = 'Generates permissions through config cms/permissions.php';

    public function __construct()
    {
        parent::__construct();
        $this->config = config('cms/permissions');
    }

    public function handle(): void
    {
        $choose = select(
            label: 'What do you want to do?',
            options: [
                'clear' => 'Delete All Permissions',
                'sync' => 'Sync New Permissions'
            ],
            default: 'sync'
        );
        match ($choose) {
            'clear' => $this->deleteAllPermission(),
            'sync' => $this->syncPermission(),
            default => $this->info('Invalid choice')
        };
    }

    protected function deleteAllPermission()
    {
        try {
            DB::table(config('permission.table_names.permissions'))->delete();
            $this->comment('Deleted Permissions');
        } catch (\Exception $exception) {
            $this->warn($exception->getMessage());
        }
    }

    protected function syncPermission(): void
    {
        foreach ($this->config as $class => $permissions) {
            foreach ($permissions as $permission) {
                $modelName = (new \ReflectionClass($class))->getShortName();
                Permission::findOrCreate($permission . ' ' . $modelName, 'cms');
                $this->comment('new permission created: ' . $permission . ' ' . $modelName);
            }
        }
    }
}
