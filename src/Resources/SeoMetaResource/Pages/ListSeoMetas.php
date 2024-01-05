<?php

namespace Fajar\Filament\Suitcms\Resources\SeoMetaResource\Pages;

use Fajar\Filament\Suitcms\Resources\SeoMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeoMetas extends ListRecords
{
    protected static string $resource = SeoMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
