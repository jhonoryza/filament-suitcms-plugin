## Installation

install [filament package](https://filamentphp.com/docs/3.x/panels/installation)

```bash
composer require filament/filament:"^3.1"
```

you need to install package [spatie permission](https://spatie.be/index.php/docs/laravel-permission/v6/introduction) and [spatie media library](https://spatie.be/docs/laravel-medialibrary/v10/introduction) to use this package

```bash
composer require spatie/laravel-permission:"^6.3"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

composer require spatie/laravel-medialibrary:"^10.0"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider"
```

then install filament-suitcms plugin package via composer:

```bash
composer require jhonoryza/filament-suitcms
```

install filament-suitcms plugin

```bash
php artisan filament-suitcms:install
```

this command will do :

1. publish filament-suitcms config to folder `config/cms`
2. ask to run migration, if you get asked `Would you like to run the migrations now?` choose `yes`, this will run migration for media and roles permission
3. sync permission data
4. generate default super admin user, default admin user is `admin@admin.com` with password : `password`
5. generate default setting data

now you can create filament panel builder using this command :

```bash
php artisan filament:install --panels
```

then open `PanelProvider` add this line

```php hl_lines="4"
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugin(SuitcmsToolkit::make()); // add this line
    }
```
