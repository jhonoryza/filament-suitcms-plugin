# Filament Suitcms Plugin

## Description

This plugin is built on top of [Spatie's Permission](https://spatie.be/docs/laravel-permission/v6/introduction) package. 

Provides Resources for Roles and Permissions

## Depedencies

you need to install this library to use this package

```bash
composer require filament/filament
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

## Installation

You can install the package via composer:

```bash
composer require jhonoryza/filament-suitcms
php artisan filament-suitcms:install
php artisan migrate
```

now you can create filament panel builder using this command :

```bash 
php artisan filament:install --panels
```

then open `PanelProvider` add this line

```php
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugin(new SuitcmsToolkit()); // add this line
    }
```

## Usage

### Generate Admin User

```bash
php artisan cms:admin-generate
```

### Generate Permissions

add new permission map in `config/cms/permission.php` file

You can generate Permissions by running
```bash
php artisan cms:permission-sync
```

### Generate Policy

```bash
php artisan cms:policy-generate
```

## Security

If you discover any security related issues, please create an issue.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

