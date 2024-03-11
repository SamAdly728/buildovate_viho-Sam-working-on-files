<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendFollowUp;
use App\Models\FollowUpGapi;
use Illuminate\Http\Request;
use Google\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
// use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Facades\Socialite;
use nadar\quill\Debug;
use nadar\quill\Lexer;

class FollowupGoogleConnectController extends Controller
{
    //
    public function index(Request $request){
        // config([
        //     'services.google.client_id' => env('FOLLOW_UP_GOOGLE_CLIENT_ID'),
        //     'services.google.client_secret' => env('FOLLOW_UP_GOOGLE_CLIENT_SECRET'),
        //     'services.google.redirect' => env('FOLLOW_UP_GOOGLE_REDIRECT_URI'),
        // ]);
        // return Socialite::driver('google')->redirect();


        $emailContentHTML = "
            <p>Hi, {first-name}<br>My name is {salesperson-name} with {company-name}!<br><br>We just received your request for a quote, and would like to schedule a date & time to discuss your request in more detail!</p>

            <strong>To select a date & time,</strong> <strong>click the button below to visit our online scheduler:</strong>

            <p>{view-request-button}</p>

            <p>You may also reach us via phone: {company-phone}<br><br>We look forward to being of service!<br><br>Thank you for the opportunity,<br>{salesperson-name} with {company-name}</p>
        ";

        // $contents = new Lexer($emailContentDelta);

        // echo $contents;

        // $debug = new Debug($contents);
        // echo $debug->debugPrint();
        // dd($contents);

        $userEmail = 'mariomanayon77@gmail.com';
        Mail::to($userEmail)->send(new SendFollowUp($emailContentHTML));

    }

    // public function handleGoogleCallback(Request $request){

    //     // $user = Socialite::driver('google')->user();

    //     $userId = Session::get('user_id');

    //     dd($request->all(),$userId);

    //     $followupGapi = FollowUpGapi::updateOrCreate(
    //         ['user_id' => $userId],
    //         [
    //             'code' => $user->token,
    //             'access_token' => $user->token,
    //             'expires_in' => $user->expiresIn,
    //             'refresh_token' => $user->refreshToken,
    //             'token_type' => $user->tokenType,
    //             // Add other fields as needed
    //         ]
    //     );
        
    //     return Socialite::driver('google')->redirect();
        
    // }
}
