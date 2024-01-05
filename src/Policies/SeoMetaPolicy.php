<?php

namespace Fajar\Filament\Suitcms\Policies;

use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\SeoMeta;

class SeoMetaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('view-any SeoMeta');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, SeoMeta $seometa): bool
    {
        return $admin->hasPermissionTo('view SeoMeta');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('create SeoMeta');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, SeoMeta $seometa): bool
    {
        return $admin->hasPermissionTo('update SeoMeta');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, SeoMeta $seometa): bool
    {
        return $admin->hasPermissionTo('delete SeoMeta');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, SeoMeta $seometa): bool
    {
        return $admin->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, SeoMeta $seometa): bool
    {
        return $admin->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
