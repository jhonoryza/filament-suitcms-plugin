<?php

namespace Fajar\Filament\Suitcms\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class GenerateSetting extends Command
{
    protected $signature = 'cms:setting-generate';

    protected $description = 'Generate Default Setting Data';

    public function handle(): void
    {
        Setting::firstOrCreate([
            'key' => 'copyright-year',
        ], [
            'value' => '2020',
            'type' => 'number',
        ]);

        Setting::firstOrCreate([
            'key' => 'currency-symbol',
        ], [
            'value' => 'Rp. ',
            'type' => 'text',
        ]);

        Setting::firstOrCreate([
            'key' => 'facebook-url',
        ], [
            'value' => 'https://facebook.com/',
            'type' => 'text',
        ]);

        Setting::firstOrCreate([
            'key' => 'instagram-url',
        ], [
            'value' => 'https://instagram.com/',
            'type' => 'text',
        ]);

        Setting::firstOrCreate([
            'key' => 'office-address',
        ], [
            'value' => 'Jl. Pejaten Barat 2 No. 3A',
            'type' => 'textarea',
        ]);

        Setting::firstOrCreate([
            'key' => 'office-email',
        ], [
            'value' => 'contact@suitmedia.com',
            'type' => 'text',
        ]);

        Setting::firstOrCreate([
            'key' => 'office-fax',
        ], [
            'value' => '+6221 719 6877',
            'type' => 'text',
        ]);

        Setting::firstOrCreate([
            'key' => 'office-telephone',
        ], [
            'value' => '+6221 719 6877',
            'type' => 'text',
        ]);

        Setting::firstOrCreate([
            'key' => 'twitter-url',
        ], [
            'value' => 'https://twitter.com/',
            'type' => 'text',
        ]);

        Setting::firstOrCreate([
            'key' => 'youtube-url',
        ], [
            'value' => 'https://youtube.com/',
            'type' => 'text',
        ]);

        $this->info('Default Setting Data generated');
    }
}
