<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

/**
 * Actions inside this controller:
 * - Show create user form
 * - handle create user request
 * - Show edit user form
 * - handle update user request
 * - Show delete user form
 * - handle destroy user request
 */

class UserManipController extends Controller
{
    use ApiResponser;

    // Middleware to protect all admin routes except login
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create_users', ['only' => ['create_user', 'store_user']]);
        $this->middleware('permission:edit_users', ['only' => ['edit_user', 'update_user']]);
        $this->middleware('permission:delete_users', ['only' => ['destroy_user']]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_user(Request $request)
    {

        /**
         * Create user logique: 
         * - le super admin ou l'admin créer un compte utilisateur a partir de son email et en définissant son role
         * - L'utilisateur reçoit une mail avec une lien qui redirige vers un formulaire pour remplir ses informations
         * - apres le remplissage du formulaire, l'utilisateur peut se connecter
         */

        // Schema validation for the input data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users|max:255',
            'roles' => 'required'
        ]);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        try {
            // Store the data inside DB
            $user = User::create([
                'email' => $request->email
            ]);

            $user->assignRole($request->input('roles'));

            event(new Registered($user));

            // Define password by user logic:
            // generate token and save it into DB: define password,
            // Send the generated token to the user's email
            // and when the user click to the button, it send this token to the server
            // The server check if the token is the same as the stored inside define_password table
            // if true, the user can define his password

            $token = Str::random(64);
            $role_user = $request->roles;

            DB::table('define_passwords')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('email.define_password', ['token' => $token, 'role_user' => $role_user], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Creation de compte');
            });

            // Redirect to the admin dashboard with flash message if success
            return $this->success($user, 'User created successfully');
        } catch (QueryException $exception) {
            // Send flash message if error
            error_log($exception->getMessage());
            return $this->error('An error occured, please try again', 400);
        }
    }

    /**
     * Update the user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update_user(Request $request, User $user)
    {

        // Schema validation for the input data
        $validator = Validator($request->all(), [
            // 'username' => 'required',
            'email' => 'required',
            'roles' => 'required'
        ]);

        if($validator->fails()) {
            $this->error('Invalid data', 400);
        }

        // try to Update user
        try {
            // $user->username = $request->username;
            $user->email = $request->email;
            $user->syncRoles($request->input('roles'));
            $user->save();

            return $this->success($user, 'User updated successfully');
        } catch (QueryException $exception) {
            // Send flash message if error
            // dd($exception->getMessage());
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Username or email is not available', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy_user(User $user)
    {
        $user->delete();
        return $this->success($user, 'User deleted successfully');
    }

}