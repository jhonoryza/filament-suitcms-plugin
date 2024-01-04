<?php

namespace Fajar\Filament\Suitcms\Policies;

use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\Setting;

class SettingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('view-any Setting');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Setting $setting): bool
    {
        return $admin->hasPermissionTo('view Setting');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('create Setting');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Setting $setting): bool
    {
        return $admin->hasPermissionTo('update Setting');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Setting $setting): bool
    {
        return $admin->hasPermissionTo('delete Setting');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Setting $setting): bool
    {
        return $admin->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Setting $setting): bool
    {
        return $admin->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
