<?php

namespace Fajar\Filament\Suitcms;

use Fajar\Filament\Suitcms\Commands\GenerateCmsPolicy;
use Fajar\Filament\Suitcms\Commands\GenerateDefaultModel;
use Fajar\Filament\Suitcms\Commands\GenerateNewSuperAdmin;
use Fajar\Filament\Suitcms\Commands\GenerateSetting;
use Fajar\Filament\Suitcms\Commands\SyncCmsPermission;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSuitcmsPluginProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-suitcms')
            ->hasMigrations([
                '0000_00_00_000000_create_admins_table',
                '0000_00_00_000000_create_settings_table',
                '0000_00_00_000000_create_seo_metas_table',
                '0000_00_00_000000_create_admin_password_reset_tokens',
            ])
            ->runsMigrations()
            ->hasConfigFile(['cms/permissions'])
            ->hasViews()
            ->hasCommands([
                SyncCmsPermission::class,
                GenerateCmsPolicy::class,
                GenerateNewSuperAdmin::class,
                GenerateSetting::class,
                GenerateDefaultModel::class,
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToRunMigrations()
                    ->endWith(function (InstallCommand $com) {
                        $com->call('cms:default-model');
                        $com->call('cms:permission-sync', ['option' => 'sync']);
                        $com->call('cms:policy-generate');
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
        $this->mergeConfig('cms/permissions.php', 'cms/permissions');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-suitcms');

        return parent::register();
    }

    protected function mergeConfig(string $configPath, string $packagePath): void
    {
        if (file_exists(config_path($configPath))) {
            $this->mergeConfigFrom(config_path($configPath), $packagePath);
        } else {
            $this->mergeConfigFrom(__DIR__ . '/../config/' . $configPath, $packagePath);
        }
    }
}
