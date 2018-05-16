<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::whereEmail($request->input('email'))->first();

        if($user) {
            $token = $this->broker()->createToken($user);
            Mail::send('users.mails.reset', ['user' => $user, 'token' => $token], function($message) use ($user, $token) {
                $message->to($user->email)->subject("LeanWriter - Recuperação de senha");
            });
            return response()->json(['mensagem' => 'Email de mudança de senha enviado'], 200);
        } else {
            return response()->json(['mensagem' => 'Algo deu errado!'], 422);
        }
    }
}
