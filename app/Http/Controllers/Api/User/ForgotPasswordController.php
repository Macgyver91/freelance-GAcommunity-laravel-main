<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */
    use SendsPasswordResetEmails, ApiResponser;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function send_link(Request $request)
    {
        // schema validation for input
        $request->validate(['email' => 'required|email']);

        // Send the forgot password link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // handle response
        return $status === Password::RESET_LINK_SENT
            ? $this->success(null, __($status))
            : $this->error(__($status), 400);
    }
}
