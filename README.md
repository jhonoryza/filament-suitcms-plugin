# Filament Suitcms Plugin

## Description

This plugin is built on top of [Spatie's Permission](https://spatie.be/docs/laravel-permission/v6/introduction) package.

Provides Resources for Roles and Permissions

## Dependencies

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
```

install filament-suitcms

```bash
php artisan filament-suitcms:install
```

this command will run :

1. ask to run migration, if you get asked `Would you like to run the migrations now?` choose `yes`
2. sync permission data
3. generate default super admin user, default admin user is `admin@admin.com` with password : `password`
4. generate default setting data

now you can create filament panel builder using this command :

```bash
php artisan filament:install --panels
```

then open `PanelProvider` add this line

```php
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugin(SuitcmsToolkit::make()); // add this line
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

## Recommended Package for easily generate model, factory and migration

- [https://blueprint.laravelshift.com/docs/installation/](https://blueprint.laravelshift.com/docs/installation/)

## Security

If you discover any security related issues, please create an issue.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
