<?php

namespace Fajar\Filament\Suitcms\Resources\RoleResource\Pages;

use Fajar\Filament\Suitcms\Resources\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
        ];
    }
}
