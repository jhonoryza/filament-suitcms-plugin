<?php

namespace Fajar\Filament\Suitcms\Resources\AdminResource\Pages;

use Fajar\Filament\Suitcms\Resources\AdminResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Eloquent\Model;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $model = static::getModel()::create($data);
        app()->bind(
            SendEmailVerificationNotification::class
        );
        event(new Registered($model));

        return $model;
    }
}
