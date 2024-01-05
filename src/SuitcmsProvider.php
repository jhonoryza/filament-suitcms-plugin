<?php

namespace Fajar\Filament\Suitcms;

use Fajar\Filament\Suitcms\Commands\GenerateCmsPolicy;
use Fajar\Filament\Suitcms\Commands\GenerateNewSuperAdmin;
use Fajar\Filament\Suitcms\Commands\GenerateSetting;
use Fajar\Filament\Suitcms\Commands\SyncCmsPermission;
use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\Permission;
use Fajar\Filament\Suitcms\Models\Role;
use Fajar\Filament\Suitcms\Models\SeoMeta;
use Fajar\Filament\Suitcms\Models\Setting;
use Fajar\Filament\Suitcms\Policies\AdminPolicy;
use Fajar\Filament\Suitcms\Policies\PermissionPolicy;
use Fajar\Filament\Suitcms\Policies\RolePolicy;
use Fajar\Filament\Suitcms\Policies\SeoMetaPolicy;
use Fajar\Filament\Suitcms\Policies\SettingPolicy;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SuitcmsProvider extends PackageServiceProvider
{
    protected $policies = [
        Admin::class => AdminPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Setting::class => SettingPolicy::class,
        SeoMeta::class => SeoMetaPolicy::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-suitcms')
            ->hasMigrations([
                'create_admins_table',
                'create_settings_table',
                'create_seo_metas_table',
                'create_admin_password_reset_tokens',
            ])
            ->runsMigrations()
            ->hasConfigFile(['cms/auth-guards', 'cms/auth-providers', 'cms/auth-passwords', 'cms/permissions'])
            ->hasViews()
            ->hasCommands([
                SyncCmsPermission::class,
                GenerateCmsPolicy::class,
                GenerateNewSuperAdmin::class,
                GenerateSetting::class,
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToRunMigrations()
                    ->endWith(function (InstallCommand $com) {
                        $com->call('cms:permission-sync -n');
                        $com->call('cms:admin-generate', [
                            'name' => 'admin',
                            'email' => 'admin@admin.com',
                            'password' => 'password',
                        ]);
                        $com->call('cms:setting-generate');
                    });
            });
    }

    public function register()
    {
        $this->mergeConfig('cms/auth-guards.php', 'auth.guards');
        $this->mergeConfig('cms/auth-providers.php', 'auth.providers');
        $this->mergeConfig('cms/auth-passwords.php', 'auth.passwords');
        $this->mergeConfig('cms/permissions.php', 'cms/permissions');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-suitcms');

        return parent::register();
    }

    protected function mergeConfig(string $configPath, string $packagePath): void
    {
        if (file_exists(config_path($configPath))) {
            $this->mergeConfigFrom(config_path($configPath), $packagePath);
        } else {
            $this->mergeConfigFrom(__DIR__.'/../config/'.$configPath, $packagePath);
        }
    }

    public function boot()
    {
        return parent::boot();
    }
}
