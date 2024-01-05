<?php

return [
    \Fajar\Filament\Suitcms\Models\Admin::class => ['view-any', 'view', 'create', 'update', 'delete', 'restore', 'force-delete'],
    \Fajar\Filament\Suitcms\Models\Role::class => ['view-any', 'view', 'create', 'update', 'delete'],
    \Fajar\Filament\Suitcms\Models\Permission::class => ['view-any', 'view', 'create', 'update', 'delete'],
    \Fajar\Filament\Suitcms\Models\Setting::class => ['view-any', 'view', 'update', 'create', 'update', 'delete'],
    \Fajar\Filament\Suitcms\Models\SeoMeta::class => ['view-any', 'view', 'update', 'create', 'update', 'delete'],
];
