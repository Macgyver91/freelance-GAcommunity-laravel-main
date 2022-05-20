<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    // Middleware to protect all admin routes except login
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create_users', ['only' => ['create_user', 'store_user']]);
        $this->middleware('permission:edit_users', ['only' => ['edit_user', 'update_user']]);
        $this->middleware('permission:delete_users', ['only' => ['destroy_user']]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_user()
    {
        $role_users = [];

        // filter roles to not include SUPER_ADMIN because there is only 1 SUPER_ADMIN 
        if (auth()->user()->hasRole("SUPER_ADMIN")) {
            $role_users = Role::whereNotIn('name', ["SUPER_ADMIN"])->pluck('name', 'name');
        }

        // filter roles when ADMIN create user to not include SUPER_ADMIN & ADMIN because ADMIN cannot create another ADMIN account
        if (auth()->user()->hasRole("ADMIN")) {
            $role_users = Role::whereNotIn('name', ["SUPER_ADMIN", "ADMIN"])->pluck('name', 'name');
        }

        return view("admin.users_manipulation.create_user", [
            'role_users' => $role_users
        ]);
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
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:255',
            'roles' => 'required'
        ]);

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
            return redirect()->route('admin.dashboard')->with("message", "Un utilisateur a été crée avec succès");
        } catch (QueryException $exception) {
            // Send flash message if error
            error_log($exception->getMessage());
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    /**
     * Show the form for editing user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit_user($id)
    {
        // find the user by id, then inject it to the view
        $user = User::find($id);
        $role_users = Role::pluck('name', 'name')->all();

        return view('admin.users_manipulation.update_user', [
            "user" => $user,
            "role_users" => $role_users
        ]);
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
        $this->validate($request, [
            // 'username' => 'required',
            'email' => 'required',
            'roles' => 'required'
        ]);

        // try to Update user
        try {
            // $user->username = $request->username;
            $user->email = $request->email;
            $user->syncRoles($request->input('roles'));
            $user->save();

            return redirect()->route('admin.dashboard')->with("message", "Un utilisateur a été modifiée avec succès");
        } catch (QueryException $exception) {
            // Send flash message if error
            // dd($exception->getMessage());
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Nom d'utilisateur ou adresse email non disponible, essayer à nouveau");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
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

        return back()->with("message", "Un utilisateur a été supprimée avec succès");
    }

    public function show_user($id)
    {
        // Find user and inject it inside view
        $user = User::find($id);

        if ($user) {
            return view('admin.users_manipulation.show_user', [
                "user" => $user
            ]);
        } else {
            return back()->with("error", "Cet utilisateur n'existe pas, essayer une autre compte");
        }
    }
}