<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponser;

    // Middleware to protect all admin routes except login
    public function __construct()
    {
        $this->middleware(["guest"])->only(["store_login"]);

        $this->middleware(["auth"])->except(["store_login"]);
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

        if (Auth::attempt($request->only($login_type, 'password'), $remember)) {
            $user =  User::find(Auth::id());
            $token = $user->createToken('GA_token')->plainTextToken;
            
            return $this->success([
                'token' => $token,
                'remember_token' => $user->remember_token
            ], 'Authenticated with success');
        }

        return $this->error('Invalid credentials', 401);
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
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required'
        ]);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        // try to update the user
        try {
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            return $this->success($user, 'User profile updated with success');
        } catch (QueryException $exception) {
            // Send flash message if error
            // dd($exception->getMessage());
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('username ou email non disponible, essayer a nouveau', 400);
            }
            return $this->error('Une erreur s\'est produit, essayer a nouveau', 500);
        }
    }

    public function show_profile($id)
    {
        // query user by id and inject it into the view
        $user = User::find($id);
        if ($user) {
            return $this->success($user, "User founds");
        } else {
            return $this->error('User does not found', 404);
        }
    }

    public function logout()
    {
         //revoke all tokens
         $user = User::find(Auth::id());
         $user->tokens()->delete();

        return $this->success(null, 'User logged out with success');
    }
}
