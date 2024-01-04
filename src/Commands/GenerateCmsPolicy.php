<?php

namespace Fajar\Filament\Suitcms\Commands;

use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\Permission;
use Fajar\Filament\Suitcms\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateCmsPolicy extends Command
{
    private mixed $config;

    protected $signature = 'cms:policy-generate';

    protected $description = 'Generates policies through config cms/permissions.php';

    public function __construct()
    {
        parent::__construct();
        $this->config = config('cms/permissions');
    }

    public function handle(): void
    {
        $filesystem = new Filesystem();

        $stub = '/stubs/genericPolicy.stub';

        // Ensure the policies folder exists
        File::ensureDirectoryExists(app_path('Policies/'));

        $skip = [Admin::class, Role::class, Permission::class];

        foreach ($this->config as $class => $permissions) {

            // skip admin, role and permission class
            if (in_array($class, $skip)) {
                continue;
            }

            $contents = $filesystem->get(__DIR__.$stub);
            $model = (new \ReflectionClass($class));
            $modelName = $model->getShortName();

            $policyVariables = [
                'class' => $modelName.'Policy',
                'namespacedModel' => $model->getName(),
                'namespacedUserModel' => (new \ReflectionClass(Admin::class))->getName(),
                'namespace' => 'App\Policies',
                'user' => class_basename(Admin::class),
                'model' => $modelName,
                'modelVariable' => $modelName == 'Admin' ? 'model' : Str::lower($modelName),
            ];

            foreach ($permissions as $permission) {
                $key = match ($permission) {
                    'view-any' => 'viewAnyPermission',
                    'view' => 'viewPermission',
                    'create' => 'createPermission',
                    'update' => 'updatePermission',
                    'delete' => 'deletePermission',
                    'restore' => 'restorePermission',
                    'force-delete' => 'forceDeletePermission',
                };
                $contents = Str::replace('{{ '.$key.' }}', $permission.' '.$modelName, $contents);
            }

            foreach ($policyVariables as $search => $replace) {
                if ($modelName == class_basename(Admin::class) && $search == 'namespacedModel') {
                    $contents = Str::replace('use {{ namespacedModel }};', '', $contents);
                } else {
                    $contents = Str::replace('{{ '.$search.' }}', $replace, $contents);
                }
            }

            if (! $filesystem->exists(app_path('Policies/'.$modelName.'Policy.php'))) {
                $filesystem->put(app_path('Policies/'.$modelName.'Policy.php'), $contents);
                $this->comment('Creating Policy: '.$modelName);
            }

        }
    }
}
