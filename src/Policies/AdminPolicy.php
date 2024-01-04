<?php

namespace Fajar\Filament\Suitcms\Policies;

use Fajar\Filament\Suitcms\Models\Admin;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('view-any Admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Admin $model): bool
    {
        return $admin->hasPermissionTo('view Admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('create Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Admin $model): bool
    {
        return $admin->hasPermissionTo('update Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Admin $model): bool
    {
        return $admin->hasPermissionTo('delete Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Admin $model): bool
    {
        return $admin->checkPermissionTo('restore Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Admin $model): bool
    {
        return $admin->checkPermissionTo('force-delete Admin');
    }
}
