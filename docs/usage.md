## Add `SuitcmsToolkit` to your filament panel provider

add to your filament panel provider add this line

```php hl_lines="4"
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugin(SuitcmsToolkit::make()); // add this line
    }
```

you can disable specific resource using this syntax

```php hl_lines="4-7"
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugin(
                SuitcmsToolkit::make()
                    ->settingResource(condition: false);
            )
    }
```

this will disable setting resources

another available function 

```php hl_lines="2-5"
SuitcmsToolkit::make()
    ->seoMetaResource(condition: false)
    ->permissionResource(condition: false)
    ->roleResource(condition: false)
    ->adminResource(condition: false)
```

## Register default resources instead using `SuitcmsToolkit`

you can register some resources like this

```php hl_lines="2-9"
    $panel
        ->authGuard('cms')
        ->authPasswordBroker('cms')
        ->resources([
            AdminResource::class,
            RoleResource::class,
            PermissionResource::class,
            SeoMetaResource::class,
            SettingResource::class,
        ])
        ->profile(AdminResource\Pages\EditProfile::class);
```

## Generate Admin User Command

```bash
php artisan cms:admin-generate
```

## Generate Permissions Command

add new permission map in `config/cms/permission.php` file

You can generate Permissions by running

```bash
php artisan cms:permission-sync
```

## Generate Policy Command

```bash
php artisan cms:policy-generate
```

for admins, roles, permissions, settings and seo_metas resource the policy class already generated and loaded from the package, so you don't need to regenerate.

## Important

you can add new permission to config file in `config/cms/permissions.php` file

```php
<?php

return [
    \Fajar\Filament\Suitcms\Models\Admin::class => ['view-any', 'view', 'create', 'update', 'delete', 'restore', 'force-delete'],
    \Fajar\Filament\Suitcms\Models\Role::class => ['view-any', 'view', 'create', 'update', 'delete'],
    \Fajar\Filament\Suitcms\Models\Permission::class => ['view-any', 'view', 'create', 'update', 'delete'],
    \Fajar\Filament\Suitcms\Models\Setting::class => ['view-any', 'view', 'update', 'create', 'update', 'delete'],
    \Fajar\Filament\Suitcms\Models\SeoMeta::class => ['view-any', 'view', 'update', 'create', 'update', 'delete'],
];
```

then run generate permission and policy command to regenerate permission data and policy class

if you didn't generate policy class your authorization will not works eventhough you have the correct permission and role data to the related admin.

## Override default resources

let's say we want to override `SettingResource`

first we need to disable like this

```php
SuitcmsToolkit::make()
    ->settingResource(condition: false);
```

then we create model setting using `php artisan make:model Setting`

then adjust the class to extend from `\Fajar\Filament\Suitcms\Models\Setting`

lets generate resource using `php artisan make:filament-resource -G Setting`

lets adjust `SettingResource` class to extend from `\Fajar\Filament\Suitcms\Resources\SettingResource`

then we need to override this function

```php hl_lines="1-3 8-10"
use App\Filament\Resources\SettingResource\Pages\ListSettings;
use App\Filament\Resources\SettingResource\Pages\CreateSetting;
use App\Filament\Resources\SettingResource\Pages\EditSetting;

    public static function getPages(): array
    {
        return [
            'index' => ListSettings::route('/'),
            'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }
```
