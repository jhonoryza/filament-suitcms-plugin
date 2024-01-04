<?php

namespace Fajar\Filament\Suitcms\Resources\SettingResource\Pages;

use Fajar\Filament\Suitcms\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
