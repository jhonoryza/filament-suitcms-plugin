<?php

namespace Fajar\Filament\Suitcms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SeoMeta extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    const IMAGE_COL = 'seo_image';

    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'locale',
        'seo_url',
        'seo_title',
        'seo_description',
        'seo_content',
        'open_graph_type',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::IMAGE_COL)
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->registerMediaConversions(function () {
                $this->addMediaConversion('seo_image_large')
                    ->crop('crop-center', 1200, 630)
                    ->quality(95)
                    ->sharpen(5)
                    ->optimize();

                $this->addMediaConversion('seo_image_small')
                    ->crop('crop-center', 240, 126)
                    ->quality(95)
                    ->sharpen(10)
                    ->optimize();
            });
    }
}
