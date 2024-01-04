<?php

namespace Fajar\Filament\Suitcms;

use Fajar\Filament\Suitcms\Resources\AdminResource;
use Fajar\Filament\Suitcms\Resources\PermissionResource;
use Fajar\Filament\Suitcms\Resources\RoleResource;
use Fajar\Filament\Suitcms\Resources\SettingResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SuitcmsToolkit implements Plugin
{
    public static function make(): self
    {
        return new self();
    }

    public function getId(): string
    {
        return 'filament-suitcms';
    }

    public function register(Panel $panel): void
    {
        $resources = [
            AdminResource::class,
            RoleResource::class,
            PermissionResource::class,
            SettingResource::class,
        ];
        $panel
            ->authGuard('cms')
            ->authPasswordBroker('cms')
            ->resources($resources)
            ->font('Quicksand')
            ->profile(AdminResource\Pages\EditProfile::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
