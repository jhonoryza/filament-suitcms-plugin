<?php

namespace Fajar\Filament\Suitcms\Resources\SeoMetaResource\Pages;

use Fajar\Filament\Suitcms\Resources\SeoMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeoMeta extends EditRecord
{
    protected static string $resource = SeoMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
