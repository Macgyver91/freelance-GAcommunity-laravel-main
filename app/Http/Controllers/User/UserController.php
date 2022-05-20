<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Middleware to protect all admin routes except login
    public function __construct()
    {
        $this->middleware(["guest"])->only(["show_login", "store_login"]);

        $this->middleware(["auth"])->except(["show_login", "store_login"]);
    }

    /**
     * Display the login form.
     *
     * @return \Illuminate\Http\Response
     */

    public function show_login()
    {
        return view('user.auth.login');
    }

    /**
     * handle login request, compare credentials with the stored inside DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_login(Request $request)
    {
        // schema validation for request
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required'
        ]);

        // generate remember token when remember me is selected
        $remember = $request->remember;

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        if (auth()->attempt($request->only($login_type, 'password'), $remember)) {
            return redirect()->route("home");
        } else {
            return back()->with('error', "Invalide login details");
        }
    }

    /**
     * Show the form for editing user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(User $user)
    {
        // inject the user into the view
        return view('user.edit', [
            "user" => $user
        ]);
    }

    /**
     * Update the user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, User $user)
    {
        // the user can update his own information only
        $this->authorize('update', $user);

        // Schema validation for the input data
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required'
        ]);

        // try to update the user
        try {
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            return redirect()->route('user.show_profile', $user)->with("message", "Votre profile a ete modifiée");
        } catch (QueryException $exception) {
            // Send flash message if error
            // dd($exception->getMessage());
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "username ou email non disponible, essayer a nouveau");
            }
            return back()->with("error", "Une erreur s'est produit, essayer a nouveau");
        }
    }

    public function show_profile($id)
    {
        // query user by id and inject it into the view
        $user = User::find($id);
        if ($user) {
            return view('user.show_profile', [
                "user" => $user
            ]);
        } else {
            return back()->with("error", "Utilisateur non trouver");
        }
    }

    /**
     * logout
     *
     * @return \Illuminate\Http\Response
     */

    public function logout()
    {
        Auth::logout();

        return redirect()->route('user.login');
    }
}
