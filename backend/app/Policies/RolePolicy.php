<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy extends BasePolicy
{
    protected $prefix = 'pkx_role_';
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission($this->prefix.'list');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function view(User $user, Role $role): bool
    {
        return $user->hasPermission('pkx_view_single_role');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->hasPermission($this->prefix. 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return $user->hasPermission($this->prefix. 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermission($this->prefix. 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function restore(User $user, Role $role): bool
    {
        return $user->hasPermission($this->prefix. 'restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return $user->hasPermission($this->prefix. 'force_delete');
    }

    public function rolePermission(User $user, Role $role): bool
    {
        return $user->hasPermission($this->prefix. 'role_permission');
    }
}
