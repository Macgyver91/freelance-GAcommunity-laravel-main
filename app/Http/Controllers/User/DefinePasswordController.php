<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DefinePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DefinePasswordController extends Controller
{
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    public function show($token)
    {
        return view('user.auth.define-password', ['token' => $token]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:6', // must be at least 6 characters in length
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/' // must contain a special character
            ],
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'username' => 'required|unique:users|max:255'
        ], [
            "password.regex" => "password doit contenir au moins une lettre majuscule, minuscule, un chiffre et un caractère spéciale"
        ]);

        // Query inside table define_passwords if the email & token used to defined password is there
        $updatePassword = DB::table('define_passwords')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        // if email & token is not inside DB, block the execution of the code
        if (!$updatePassword) {
            return back()->withErrors(['email' => [__("Invalid email")]]);
        }

        // If nothing wrong, update the user's password
        User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'username' => $request->username,
                "email_verified_at" => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        DB::table('define_passwords')->where(['email' => $request->email])->delete();

        return redirect()->route('user.login')->with('status', 'Your password has been defined!');
    }

    public function show_resend_define()
    {
        return view('user.auth.resend-define-pwd');
    }

    public function resend_define(Request $request)
    {
        // Schema validation for the input data
        $this->validate($request, [
            'email' => 'required',
        ]);

        // find email inside the define_passwords table if the account exists
        $define_password = DefinePassword::where('email', $request->email)->first();

        // if exist, generate token and resend email with this generated token
        // Update inside define_passwords table the tokens with the generated token
        if (isset($define_password)) {
            $token = Str::random(64);

            $define_password->token = $token;
            $define_password->created_at = Carbon::now();
            $define_password->save();


            Mail::send('email.define_password', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Define Password');
            });

            // Send success message if success
            return back()->with("message", "Un utilisateur a été crée avec succès");
        } else {
            // Send error message if error
            return back()->with("error", "Ce compte n'existe pas");
        }
    }
}