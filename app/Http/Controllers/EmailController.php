<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function send(Request $request){
        $data = $request->input('data');
        $recipient = $request->input('recipient'); //THIS IS AN ARRAY OF EMAIL ADDRESS
        $cc = $request->input('cc'); //THIS IS AN ARRAY OF EMAIL ADDRESS
        $this->subject = $request->input('subject');
        $view = $request->input('view');

        $this->recipientString = '';
        $this->ccString = '';
        if(count($recipient) != 0){
            $this->recipientString = implode(',', $recipient);
        }

        if(count($cc) != 0){
            $this->ccString = implode(',', $cc);
        }

        try {
            \Mail::send($view, $data, function ($message) {
                $message->to(explode(',', $this->recipientString))
                        ->cc(explode(',', $this->ccString))
                        ->subject($this->subject);
            });

            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            // Handle the error
            return response()->json(['message' => 'Failed to send email', 'error' => $e->getMessage()], 500);
        }
    }

    public function test(Request $request)
    {
        $data = [
            'SEND_BY' => 'LOUIE',
            'DISPLAY_NAME' => "Kayle and Louie",
            'CODE' => base64_encode('33'),
            'COMPANY_NAME' => '4K PATIOS'
        ];

        $this->email = 'louiefuentes.dev@gmail.com,dev@buildovate.com';
        $this->ccEmail = 'joe@buildovate.com,dev@buildovate.com';
        $this->subject = "Buildovate Proposal Confirmation!";
        
        try {
            \Mail::send('emails.send-proposal', $data, function ($message) {
                $message->to(explode(',', $this->email)) // Support multiple recipients
                        ->cc(explode(',', $this->ccEmail)) // Support multiple CC addresses
                        ->subject($this->subject);
            });
    
            // If the mail is sent successfully
            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            // Handle the error
            return response()->json(['message' => 'Failed to send email', 'error' => $e->getMessage()], 500);
        }
    }
}
