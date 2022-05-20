<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\DefinePassword;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DefinePasswordController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        $input = $request->only(
            'token',
            'email',
            'password',
            'nom',
            'prenom',
            'username'
        );

        // Validate input data
        $validator = Validator::make($input, [
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

        if($validator->fails()) {
            $this->error('Invalid informations', 400);
        }

        // Query inside table define_passwords if the email & token used to defined password is there
        $updatePassword = DB::table('define_passwords')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        // if email & token is not inside DB, block the execution of the code
        if (!$updatePassword) {
            return $this->error('Email is invalid', 400);
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

        return $this->success(null, 'Your password has been defined!');
    }

    public function resend_define(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->email, [
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            return $this->error('Email is not valid', 400);
        }

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
            return $this->success(null, 'User created successfully');
        } else {
            // Send error message if error
            return $this->error('This account does not exist', 400);
        }
    }
}