<?php

namespace Fajar\Filament\Suitcms;

use Fajar\Filament\Suitcms\Resources\AdminResource;
use Fajar\Filament\Suitcms\Resources\PermissionResource;
use Fajar\Filament\Suitcms\Resources\RoleResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SuitcmsToolkit implements Plugin
{
    public function make(): self
    {
        return new self();
    }

    public function getId(): string
    {
        return 'filament-suitcms';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->authGuard('cms')
            ->authPasswordBroker('cms')
            ->resources([
                AdminResource::class,
                RoleResource::class,
                PermissionResource::class
            ])
            ->font('Quicksand')
            ->profile(AdminResource\Pages\EditProfile::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
