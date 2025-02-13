<?php

namespace Mate\Roles\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Mate\Roles\Models\Role;
use Mate\Roles\Models\RolePermissions;

/**
 * Controller for managing permissions
 */
class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('has-permissions:manage permissions');
    }

    /**
     * Displays the Roles Permissions Matrix
     */
    public function index(Request $request): View
    {
        $permissions = config('roles.permissions');
        $roles = Role::all();
        $rolePermissions = RolePermissions::getMatrix();

        return view('roles::index', [
            'permissions' => $permissions,
            'roles' => $roles,
            'role_permissions' => $rolePermissions,
        ]);
    }

    /**
     * Updates the Roles Permissions
     */
    public function update(Request $request): RedirectResponse
    {
        $response = redirect(route(config('roles.routes.permissions.index')));

        if (! empty($request->permissions) && is_array($request->permissions)) {
            RolePermissions::updateMatrix($request->permissions);
            $response->with('success', 'Permissions updated successfully.');
        } else {
            $response->with('error', 'No permissions were selected.');
        }

        return $response;
    }
}
