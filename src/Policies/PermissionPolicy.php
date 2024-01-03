<?php

namespace Fajar\Filament\Suitcms\Policies;

use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('view-any Permission');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Permission $permission): bool
    {
        return $admin->hasPermissionTo('view Permission');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('create Permission');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Permission $permission): bool
    {
        return $admin->hasPermissionTo('update Permission');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Permission $permission): bool
    {
        return $admin->hasPermissionTo('delete Permission');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Permission $permission): bool
    {
        return $admin->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Permission $permission): bool
    {
        return $admin->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
