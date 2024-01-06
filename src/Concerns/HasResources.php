<?php

namespace Fajar\Filament\Suitcms\Concerns;

use Fajar\Filament\Suitcms\Resources\AdminResource;
use Fajar\Filament\Suitcms\Resources\PermissionResource;
use Fajar\Filament\Suitcms\Resources\RoleResource;
use Fajar\Filament\Suitcms\Resources\SeoMetaResource;
use Fajar\Filament\Suitcms\Resources\SettingResource;

trait HasResources
{
    protected bool $hasSettingResource = true;
    protected bool $hasSeoMetaResource = true;
    protected bool $hasPermissionResource = true;
    protected bool $hasRoleResource = true;
    protected bool $hasAdminResource = true;

    public function getResources(): array
    {
        $resources = [];
        if ($this->hasAdminResource()) {
            $resources[] = AdminResource::class;
        }
        if ($this->hasSettingResource()) {
            $resources[] = SettingResource::class;
        }
        if ($this->hasSeoMetaResource()) {
            $resources[] = SeoMetaResource::class;
        }
        if ($this->hasPermissionResource()) {
            $resources[] = PermissionResource::class;
        }
        if ($this->hasRoleResource()) {
            $resources[] = RoleResource::class;
        }
        return $resources;
    }

    public function settingResource(bool $condition = false): static
    {
        $this->hasSettingResource = $condition;
        return $this;
    }

    public function hasSettingResource(): bool
    {
        return $this->hasSettingResource;
    }

    public function seoMetaResource(bool $condition = false): static
    {
        $this->hasSeoMetaResource = $condition;
        return $this;
    }

    public function hasSeoMetaResource(): bool
    {
        return $this->hasSeoMetaResource;
    }

    public function permissionResource(bool $condition = false): static
    {
        $this->hasPermissionResource = $condition;
        return $this;
    }

    public function hasPermissionResource(): bool
    {
        return $this->hasPermissionResource;
    }

    public function roleResource(bool $condition = false): static
    {
        $this->hasRoleResource = $condition;
        return $this;
    }

    public function hasRoleResource(): bool
    {
        return $this->hasRoleResource;
    }

    public function adminResource(bool $condition = false): static
    {
        $this->hasAdminResource = $condition;
        return $this;
    }

    public function hasAdminResource(): bool
    {
        return $this->hasAdminResource;
    }
}
