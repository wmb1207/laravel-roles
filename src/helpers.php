<?php

if (! function_exists('has_permissions')) {

    /**
     * Checks if the user has the given permissions.
     */
    function has_permissions(array $permissions): bool
    {
        return app('roles')->hasPermissions($permissions);
    }
}

if (! function_exists('has_role')) {

    /**
     * Checks if the user has the given permissions.
     *
     * @param  array  $permissions
     */
    function has_role($role): bool
    {
        return app('roles')->hasRole($role);
    }
}

if (! function_exists('has_permission')) {

    /**
     * Checks if the user has the given permission.
     */
    function has_permission(string $permission): bool
    {
        return app('roles')->hasPermission($permission);
    }
}

if (! function_exists('role_dropdown_options')) {

    /**
     * Returns available roles for dropdown options.
     *
     * @return array
     *               key: role id
     *               value: role name
     */
    function role_dropdown_options(): array
    {
        return Mate\Roles\Models\Role::dropDownOptions();
    }
}

if (! function_exists('permissions_dropdown_options')) {

    /**
     * Returns available permissions for dropdown options.
     *
     * @return array
     *               key: permission name
     *               value: permission name
     */
    function permissions_dropdown_options(): array
    {
        return Mate\Roles\Models\UserPermissions::dropDownOptions();
    }
}
