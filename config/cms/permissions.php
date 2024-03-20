<?php

return [
    \App\Models\Admin::class => ['view-any', 'view', 'create', 'update', 'delete', 'restore', 'force-delete'],
    \App\Models\Role::class => ['view-any', 'view', 'create', 'update', 'delete'],
    \App\Models\Permission::class => ['view-any', 'view', 'create', 'update', 'delete'],
    \App\Models\Setting::class => ['view-any', 'view', 'update', 'create', 'update', 'delete'],
    \App\Models\SeoMeta::class => ['view-any', 'view', 'update', 'create', 'update', 'delete'],
];
