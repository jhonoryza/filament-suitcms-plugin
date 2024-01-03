<?php

namespace Fajar\Filament\Suitcms\Resources\PermissionResource\Pages;

use Fajar\Filament\Suitcms\Resources\PermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePermissions extends ManageRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
