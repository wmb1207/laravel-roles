<?php

namespace Mate\Roles\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

/**
 * Controller or managing user roles
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('has-permissions:manage permissions');
    }

    /**
     * Shows the roles available for the user
     */
    public function index(Request $request, User $user): View
    {
        return view('roles::user_form', [
            'model' => $user,
        ]);
    }

    /**
     * Updates the user roles
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->roles()->sync($request->input('roles', []));

        return redirect(route(config('roles.routes.users.index'), ['user' => $user->id]))
            ->with('success', 'Permissions updated successfully.');
    }
}
