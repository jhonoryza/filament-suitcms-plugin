<?php

namespace Fajar\Filament\Suitcms\Policies;

use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('view-any Role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Role $role): bool
    {
        return $admin->hasPermissionTo('view Role');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('create Role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Role $role): bool
    {
        return $admin->hasPermissionTo('update Role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Role $role): bool
    {
        return $admin->hasPermissionTo('delete Role');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Role $role): bool
    {
        return $admin->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Role $role): bool
    {
        return $admin->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
