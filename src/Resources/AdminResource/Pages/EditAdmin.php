<?php

namespace Fajar\Filament\Suitcms\Resources\AdminResource\Pages;

use Fajar\Filament\Suitcms\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
