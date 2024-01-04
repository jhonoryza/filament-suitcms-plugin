<?php

namespace Fajar\Filament\Suitcms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $fillable = [
        'key',
        'value',
        'type',
    ];
}
