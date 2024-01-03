<?php

namespace Fajar\Filament\Suitcms;

use Fajar\Filament\Suitcms\Commands\GenerateCmsPolicy;
use Fajar\Filament\Suitcms\Commands\GenerateNewSuperAdmin;
use Fajar\Filament\Suitcms\Commands\SyncCmsPermission;
use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\Permission;
use Fajar\Filament\Suitcms\Models\Role;
use Fajar\Filament\Suitcms\Policies\AdminPolicy;
use Fajar\Filament\Suitcms\Policies\PermissionPolicy;
use Fajar\Filament\Suitcms\Policies\RolePolicy;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SuitcmsProvider extends PackageServiceProvider
{
    protected $policies = [
        Admin::class => AdminPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-suitcms')
            ->hasMigrations([
                'create_admins_table',
                'create_admin_password_reset_tokens',
            ])
            ->hasConfigFile(['cms/auth-guards', 'cms/auth-providers', 'cms/auth-passwords', 'cms/permissions'])
            ->hasViews()
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations();
            })
            ->hasCommands([
                SyncCmsPermission::class,
                GenerateCmsPolicy::class,
                GenerateNewSuperAdmin::class
            ]);
    }

    public function register()
    {
        if (file_exists(config_path('cms/auth-guards.php'))) {
            $this->mergeConfigFrom(config_path('cms/auth-guards.php'), 'auth.guards');
        } else {
            $this->mergeConfigFrom(__DIR__.'/../config/cms/auth-guards.php', 'auth.guards');
        }

        if (file_exists(config_path('cms/auth-providers.php'))) {
            $this->mergeConfigFrom(config_path('cms/auth-providers.php'), 'auth.providers');
        } else {
            $this->mergeConfigFrom(__DIR__.'/../config/cms/auth-providers.php', 'auth.providers');
        }

        if (file_exists(config_path('cms/auth-passwords.php'))) {
            $this->mergeConfigFrom(config_path('cms/auth-passwords.php'), 'auth.passwords');
        } else {
            $this->mergeConfigFrom(__DIR__.'/../config/cms/auth-passwords.php', 'auth.passwords');
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-suitcms');

        return parent::register();
    }

    public function boot()
    {
        return parent::boot();
    }
}
