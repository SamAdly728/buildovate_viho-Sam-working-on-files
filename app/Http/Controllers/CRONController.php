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

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Draft;

class CRONController extends Controller
{
    
    public function inbox_send_later(Request $request)
    {
        $msg_drafts = DB::table('inbox_email_que')
                  ->where('user_id',Session::get('user_id'))
                  ->get();
        if($msg_drafts)
        {
            $check = GAPI::getClient();
            if($check->status=='ok')
            {
                $client = $check->client;
                $service = new Gmail($client);

                foreach($msg_drafts as $d)
                {

                    try{
                        // Print the labels in the user's account.
                        $user = 'me';
                        $opts = [];
                        

                        // $draft = $service->users_drafts->get($user, $d->draft_id, []);

                        $message = unserialize($d->message);
                        // echo "draft->getMessage() <pre>";
                        // print_r($draft->getMessage());
                        // exit();

                        $sendMessage = $service->users_messages->send($user, $message);
                        // { "error": { "code": 400, "message": "'raw' RFC822 payload message string or uploading message via /upload/* URL required", "errors": [ { "message": "'raw' RFC822 payload message string or uploading message via /upload/* URL required", "domain": "global", "reason": "invalidArgument" } ], "status": "INVALID_ARGUMENT" } }
                        echo "sendMessage <pre>";
                        print_r($sendMessage);
                        exit();
                        
                    }
                    catch(Exception $e) {
                        // TODO(developer) - handle error appropriately
                        echo 'Message: ' .$e->getMessage();
                    }

                    exit();
                }

            }else{
                
                echo "<pre>";
                print_r($check);
                exit();
                
            }

        }
        
    }


}
