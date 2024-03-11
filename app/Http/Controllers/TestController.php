<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// use App\Events\MessageSent;
use App\Models\GAPI;
use App\Models\Message;
use App\Models\UserCredential;
use App\Models\UserBizInfo;
use App\Models\Customer;
// use App\Models\ChatRoom;
// use App\Models\ChatMessage;
// use App\Mail\ChatEmailSent;

use Inertia\Inertia;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\ModifyThreadRequest;
use Google\Service\Gmail\Thread;
use Google\Service\Gmail\Resource\UsersThreads;

use App\Models\Task;



// use Vinkla\Pusher\Facades\Pusher as LaravelPusher;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $tasks = Task::list_tasks();
        return Inertia::render('tests/Kanban',
            [
                "pageTitle" => "Kanban",
                'tasks' => $tasks,
            ]);
    }

    public function test_email(Request $request)
    {
        return Inertia::render('tests/ImageCropper',
            [
                "pageTitle" => "Test"
            ]);

        $data = [
            'INVITED_BY' => 'Ferd',
            'FIRST_NAME' => "tThere",
            'CODE' => base64_encode('testme@gmail.com'),
            'COMPANY_NAME' => '4K PATIOS'
        ];
        
        $this->email = 'louiefuentes.dev@gmail.com'; //rcvr
        $this->subject = "Accept Ferd's invitation to join Buildovate!";

        \Mail::send('emails.invite-user', $data, function ($message) {
           $message->to($this->email)
                   ->subject($this->subject);
        });
        
        echo 'sent';
        
        return view('emails/invite-user', $data);

        // return Inertia::render('tests/Test',
        //     [
        //         "pageTitle" => "Test"
        //     ]);
    }
}
