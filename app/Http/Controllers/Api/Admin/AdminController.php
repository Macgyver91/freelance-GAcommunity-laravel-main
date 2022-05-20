<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use App\Traits\ApiResponser;
use Spatie\Permission\Models\Role;

/**
 * Actions inside this controller:
 * - Show login form
 * - handle login request
 * - Show admin dashboard
 */

class AdminController extends Controller
{
    use ApiResponser;

    // Middleware to protect all admin routes except login
    public function __construct()
    {
        $this->middleware(['auth', 'role:SUPER_ADMIN|ADMIN']);
    }


    /**
     * handle login request, compare credentials with the stored inside DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function show_dashboard()
    {
        // get all users and inject it into the view
        $users = User::get();
        $role_users = Role::pluck('name', 'name')->all();

        return $this->success([
            'users' => $users,
            'role_users'=>$role_users
        ], 'All users and role_users');
    }
}