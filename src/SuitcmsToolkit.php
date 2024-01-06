<?php

namespace Fajar\Filament\Suitcms;

use Fajar\Filament\Suitcms\Concerns\HasResources;
use Fajar\Filament\Suitcms\Resources\AdminResource;
use Fajar\Filament\Suitcms\Resources\PermissionResource;
use Fajar\Filament\Suitcms\Resources\RoleResource;
use Fajar\Filament\Suitcms\Resources\SeoMetaResource;
use Fajar\Filament\Suitcms\Resources\SettingResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SuitcmsToolkit implements Plugin
{
    use HasResources;

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
        $resources = $this->getResources();
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
