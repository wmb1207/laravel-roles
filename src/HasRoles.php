<?php

namespace Mate\Roles;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Mate\Roles\Models\Role;
use Mate\Roles\Models\UserPermissions;
use Mate\Roles\Models\RoleUser;

trait HasRoles
{
    /**
     * The roles that the user has.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            RoleUser::class,
            'user_id',
            'role_id'
        );
    }

    /**
     * The permissions that the user has.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(
            UserPermissions::class,
            'user_id',
            'id'
        );
    }

    /**
     * Check if the user has the given role.
     */
    public function hasRole(string $role): bool
    {
        $key = 'roles_'.$this->id.'_'.$role;

        return Cache::remember($key, '30', function () use ($role) {
            return $this->roles()
                ->where('name', $role)
                ->exists();
        });
    }

    /**
     * Checks if the user based on the role has the given permissions
     */
    public function hasPermission(string $permission): bool
    {
        // Based on the user roles, checks on each role if the role has the
        // given permissions on role_permissions table

        $key = 'permissions_'.$this->id.'_'.$permission;

        return Cache::remember($key, '30', function () use ($permission) {
            return $this->roles()
                ->whereHas('permissions', function ($query) use ($permission) {
                    $query->where('permission', $permission);
                })->exists() || $this->permissions()->where('permission', $permission)->exists();
        });
    }

    /**
     * Checks if the user based on the role has the given permissions
     */
    public function hasPermissions(array $permissions): bool
    {
        // Based on the user roles, checks on each role if the role has the
        // given permissions on role_permissions table
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissions) {
                $query->whereIn('permission', $permissions);
            })->exists() || $this->permissions()->whereIn('permission', $permissions)->exists();
    }

    /**
     * Updates the user permissions based in the array.
     */
    public function updateUserPermissions(array $permissions): void
    {
        DB::beginTransaction();
        try {
            $forCreate = [];

            foreach ($permissions as $permission => $value) {
                //Transforming the array to be used in the createMany method.
                $forCreate[$value] = ['permission' => $value];
            }
            $this->permissions()->delete();
            $this->permissions()->createMany($forCreate);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
