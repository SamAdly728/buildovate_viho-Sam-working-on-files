<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

// use PhpMimeMailParser\Parser;
// use \PhpMimeMailParser\Parser;
use eXorus\PhpMimeMailParser\Parser;

class GAPI extends Model
{
    protected $table = 'inbox_gapi';
    use HasFactory;

    public static function getClient()
    {
        $client = new Client();
        $client->setApplicationName('Buildovate');

        // $client->setScopes(Google_Service_Gmail::MAIL_GOOGLE_COM);

//         $client->setRedirectUri('http://localhost:8000/webhooks/gmail-api');
        $client->setRedirectUri(env('APP_URL').'/webhooks/gmail-api');

        $SCOPES = 'https://mail.google.com/';
        $SCOPES .=' https://www.googleapis.com/auth/gmail.modify';
        $SCOPES .=' https://www.googleapis.com/auth/gmail.compose';
        $SCOPES .=' https://www.googleapis.com/auth/gmail.readonly';
        // $SCOPES .=' https://www.googleapis.com/auth/gmail.metadata';
        $SCOPES .=' https://www.googleapis.com/auth/gmail.send';

        $client->setScopes($SCOPES);

        $client->setAuthConfig(base_path().'/public/conf/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.

        //check saved token
        $access_token = '';
        $gapi = self::where('user_id',Session::get('user_id'))
                ->select('id','code','access_token','refresh_token','expires_in','updated_at')
                ->first();

        if(isset($gapi->id))
        {
            //set access token
            if($gapi->access_token!='')
            {
                //TODO: check expiry
                $access_token = $gapi->access_token;

                // return $access_token;
                $expired = self::isExpired($gapi->updated_at, $gapi->expires_in);

                if($expired)
                {
                    //expired - refetch
                    $res = $client->fetchAccessTokenWithRefreshToken($gapi->refresh_token);

                    if(isset($res['access_token']))
                    {
                        self::save_access_tokens($res);
                        //assign the new access token
                        $client->setAccessToken($res['access_token']);
                    }

                }else{
                    //good
                    $client->setAccessToken($access_token);
                }

                return (object)['status'=>'ok', 'client'=>$client];

            }
        }
        else {
            return (object)['status'=>'error', 'client'=>null];
        }
//        else{
//
//            $authUrl = $client->createAuthUrl();
//
//            return (object)['status'=>'auth', 'authUrl'=>$authUrl];
//        }

        // $tokenPath = base_path().'/public/conf/token'.Session::get('user_id').'.json';
        // if (file_exists($tokenPath)) {
        //     $accessToken = json_decode(file_get_contents($tokenPath), true);
        //     $client->setAccessToken($accessToken);
        // }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                if(isset($gapi->code))
                {
                    //generate access token from refresh token
                    $authCode = trim($gapi->code);

                    // Exchange authorization code for an access token.
                    $res = $client->fetchAccessTokenWithAuthCode($authCode);

                    if(isset($res['error']) && $res['error']=='invalid_grant')
                    {
                        $authUrl = $client->createAuthUrl();
                        return (object)['status'=>'auth', 'authUrl'=>$authUrl];

                    }else if(isset($res['access_token']) && $res['access_token']!=''){

                        //save to db
                        self::save_access_tokens($res);

                        $accessToken = $res['access_token'];

                        $client->setAccessToken($accessToken);

                        // Check to see if there was an error.
                        if (array_key_exists('error', $res)) {
                            throw new Exception(join(', ', $res));
                        }

                    }else{

                        return (object)['status'=>'error', 'res'=>$res];
                    }
                    

                }
                else{
                    return (object)['status'=>'error', 'client'=>null];
                }
//                else{
//
//                    // Request authorization from the user.
//                    $authUrl = $client->createAuthUrl();
//
//                    return (object)['status'=>'auth', 'authUrl'=>$authUrl];
//                }

                
            }

            // Save the token to a file.
            // if (!file_exists(dirname($tokenPath))) {
            //     mkdir(dirname($tokenPath), 0700, true);
            // }

            //save token
            // file_put_contents($tokenPath, json_encode($client->getAccessToken()));

        }

        return (object)['status'=>'ok', 'client'=>$client];
    }

    public static function isExpired($updated_at, $expires_in)
    {
        $time_start  = strtotime($updated_at);
        $time_curr = strtotime(date('Y-m-d H:i:s'));
        $diff = $time_curr - $time_start;

        if($diff < $expires_in)
        {
            return false;
        }
        
        return true;
    }

    private static function save_access_tokens($res)
    {
        $request = (object)$res;
        $check = self::where('user_id',Session::get('user_id'))->first();

        $data = [
            'access_token' => $request->access_token,
            'expires_in' => $request->expires_in,
            'refresh_token' => $request->refresh_token,
            'token_type' => $request->token_type,
            'created' => $request->created
        ];

        if(isset($check->id))
        {
            self::where('user_id',Session::get('user_id'))->update($data);

        }else{

            $data['user_id'] = Session::get('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            self::insert($data);

        }
    }
    
    public static function get_mail_total($label)
    {
        $check = self::getClient();
        if($check->status=='ok')
        {
            $client = $check->client;
            $service = new Gmail($client);

            try{
                // Print the labels in the user's account.
                $user = 'me';
                $opts = [
                    'maxResults'=>500,
                    'labelIds'=>[$label]
                ];

                $results = $service->users_messages->listUsersMessages($user, $opts); 
                
                return (object)['status' => 'ok', 'total' => count($results->getMessages())];
                
            }
            catch(Exception $e) {
                // TODO(developer) - handle error appropriately
                // echo 'Message: ' .$e->getMessage();
                return (object)['status' => 'error', 'messages' => $e->getMessage()];

            }

        }else if($check->status=='auth'){

            return (object)['status' => $check->status, 'authUrl' => $check->authUrl];

        }
        
    }

    public static function messages($label, $opts)
    {
        $check = self::getClient();
        if($check->status=='ok')
        {
            $client = $check->client;
            $service = new Gmail($client);

            try{
                // Print the labels in the user's account.
                $user = 'me';
                $opts['maxResults'] = 10;
                if($label=='UNREAD')
                {
                    $opts['labelIds'] = [$label];
                } else if($label=='INBOX'){
                    $opts['labelIds'] = ['INBOX'];
                } else {
                    $opts['labelIds'] = [$label];
                }

                $results = $service->users_messages->listUsersMessages($user, $opts);
                $count = $service->users_messages->listUsersMessages($user, ['q' => 'is:unread']);

                $disp = array();
                $previousPageToken = '';
                $nextPageToken = '';
                $resultSizeEstimate = 0;

                if (count($results->getMessages()) > 0) 
                {
                    $previousPageToken = isset($results->previousPageToken) ? $results->previousPageToken : '';
                    $nextPageToken = isset($results->nextPageToken) ? $results->nextPageToken : '';
                    $resultSizeEstimate = $results->resultSizeEstimate;

                    foreach ($results->getMessages() as $m) 
                    {
                        $opts = [
                            // 'fields'=>['id,threadId','internalDate','snippet','payload'],
                            'format'=>'metadata'
                        ];

                        $msg =  $service->users_messages->get($user, $m->id, $opts);
                        // return $msg;

                        $disp[] = self::formatDisp($msg, $service);
                        
                    }
                }

                return (object)['count' => count($count->getMessages()), 'status' => 'ok', 'messages' => $disp, 'previousPageToken'=>$previousPageToken, 'nextPageToken'=>$nextPageToken, 'resultSizeEstimate'=>$resultSizeEstimate];

            }
            catch(Exception $e) {
                // TODO(developer) - handle error appropriately
                // echo 'Message: ' .$e->getMessage();
                return (object)['status' => 'error', 'messages' => $e->getMessage()];

            }

        }else {
            return (object)['count' => 0, 'status' => 'ok', 'messages' => [], 'previousPageToken'=>null, 'nextPageToken'=>null, 'resultSizeEstimate'=>null];
        }

//        else if($check->status=='auth'){
//
//            return (object)['status' => $check->status, 'authUrl' => $check->authUrl];
//
//        }

    }

    public static function get_message($messageId, $threadId)
    {
        $check = self::getClient();
        $threads = array();
        $message = '';

        if($check->status=='ok')
        {
            $client = $check->client;
            $service = new Gmail($client);

            try{
                // Print the labels in the user's account.
                $user = 'me';

                //get threads
                if($messageId!=$threadId)
                {
                    $resp = $service->users_threads->get($user, $threadId, ['format'=>'minimal']);
                    if(isset($resp->messages))
                    {
                        $threads = $resp->messages;
                    }
                }

                //get message
                $result = $service->users_messages->get($user, $messageId, ['format'=>'raw']);
                if(isset($result->raw))
                {
                    $raw = base64_decode(str_replace(array('-', '_'), array('+', '/'), $result->raw)); 
                    // $message = $raw;
                    $parser = new Parser();
                    $parser->setText($raw);
                    $message = $parser->getMessageBody('html');
                }

            }catch(Exception $e) {
                // TODO(developer) - handle error appropriately
                // echo 'Message: ' .$e->getMessage();
                $message = 'error';//(object)['status' => 'error', 'message' => $e->getMessage()];
            }

        }else if($check->status=='auth'){

            $message = 'auth';//(object)['status' => $check->status, 'authUrl' => $check->authUrl];

        }
        
        return (object)['threads'=>$threads, 'message'=>$message];
    }

    public static function get_thread($threadId)
    {
        $check = self::getClient();
        $message = '';

        if($check->status=='ok')
        {
            $client = $check->client;
            $service = new Gmail($client);

            try{
                // Print the labels in the user's account.
                $user = 'me';

                $resp = $service->users_threads->get($user, $threadId, ['format'=>'minimal']);
                // echo "<pre>";
                // print_r($resp);
                // exit();
                
            }catch(Exception $e) {
                // TODO(developer) - handle error appropriately
                // echo 'Message: ' .$e->getMessage();
                $message = 'error';//(object)['status' => 'error', 'message' => $e->getMessage()];
            }

        }else if($check->status=='auth'){

            $message = 'auth';//(object)['status' => $check->status, 'authUrl' => $check->authUrl];

        }
        
        return (object)['message'=>$message];
    }

    public static function cleanTo($emailTo)
    {
        $e = explode('<',$emailTo);
        if(isset($e[1]))
        {
            $e = str_replace('>','',$e[1]);
        }else{
            $e = $e[0];
        }
        return $e;
    }

    public static function formatMessage($request)//$sender, $to, $subject, $messageText) 
    {
        $sender = 'me';
        $to = self::cleanTo($request->to);
        // return $to;

        $message = new Message();

        $rawMessageString = "From: <{$sender}>\r\n";
        $rawMessageString .= "To: <{$to}>\r\n";
        $rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($request->subject) . "?=\r\n";
        $rawMessageString .= "MIME-Version: 1.0\r\n";
        $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
        $rawMessageString .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $rawMessageString .= "{$request->message}\r\n";
        $rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
        $message->setRaw($rawMessage);
        $message->setThreadId($request->threadId);
        $message->setId($request->messageId);
        return $message;
    }

    public static function formatLaterMessage($request)
    {
        // messageId:this.messageId,
        // threadId:this.threadId, 
        // to:this.emailTo,
        // subject:this.emailSubject,
        // message:this.message,
        // targetDate:targetDate

        // Prepare the RFC 5322 formatted email message
        $sender = 'me';
        $to = self::cleanTo($request->to);

        $message = new Message();

        $rawMessageString = "From: <{$sender}>\r\n";
        $rawMessageString .= "To: <{$to}>\r\n";
        $rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($request->subject) . "?=\r\n";
        $rawMessageString .= 'Date: '.$request->targetDate;
        $rawMessageString .= "MIME-Version: 1.0\r\n";
        $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
        $rawMessageString .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $rawMessageString .= "{$request->message}\r\n";

        // $message = '
        // From: <'.$sender.'>
        // To: <'.$to.'>
        // Subject: Hello Jane
        // Date: Mon, 23 Oct 2023 13:00:00 +0800
        // Content-Type: text/plain; charset="UTF-8"

        // This is a test email message.
        // ';

        // Convert the message to a MIME format
        $mimeMessage = rtrim(strtr(base64_encode($rawMessageString), '+/', '-_'), '=');

        // Prepare the message payload
        $message->setRaw($mimeMessage);
        $message->setThreadId($request->threadId);
        $message->setId($request->messageId);
        return $message;

        // Send the email message
        // $sendMessage = $gmail->users_messages->send('me', $message);
        // echo 'Message sent with ID: ' . $sendMessage->getId();
    }

    private static function formatDisp($msg, $service)
    {
        $d = [
            'id'=>$msg->id,
            'threadId'=>$msg->threadId,
            'threadTotal'=>1,
            'from'=>'',
            'from2'=>'',
            'subject'=>'',
            'snippet'=>$msg->snippet,
            'sender'=>'',
            'replyto'=>'',
            'date'=>'',
        ];

        if(isset($msg->payload->headers))
        {
            foreach($msg->payload->headers as $k=>$obj)
            {
                switch($obj->name)
                {
                    case 'Sender' : $d['sender'] = $obj->value; break;
                    case 'Reply-To' : $d['replyto'] = $obj->value; break;
                    case 'Subject' : $d['subject'] = $obj->value; break;
                    case 'Date' : $d['date'] = $obj->value; break;
                    case 'From' : 
                        $d['from2'] = $obj->value;
                        $v = str_replace('"','',$obj->value);
                        $v = explode('<',$v);
                        // $v = str_replace('<','<span style="font-size:10px;display:block;color:#ccc;" class="from-email"',$v);
                        // $v = str_replace('>','</span>',$v);
                        // $v = str_replace('-email"','-email">',$v);
                        $name = isset($v[0]) ? $v[0] : '';
                        $from_email = isset($v[1]) ? str_replace('>','',$v[1]) : '';

                        $d['from'] = $name;
                        $d['from_email'] = $from_email;
                        break;
                }
            }
        }

        //get total threads
        if($msg->id!=$msg->threadId)
        {
            $resp = $service->users_threads->get('me', $msg->threadId, ['format'=>'minimal']);
            if(isset($resp->messages))
            {
                $d['threadTotal'] = count($resp->messages);
            }
        }

        return $d;
    }

    public static function labels()
    {
        $check = self::getClient();
        if($check->status=='ok')
        {
            $client = $check->client;
            $service = new Gmail($client);

            try{
                // Print the labels in the user's account.
                $user = 'me';
                
                $results = $service->users_labels->listUsersLabels($user);

                $disp = array();
                if (count($results->getLabels()) == 0) {
                    $disp[] = "No labels found.";
                } else {
                    
                    $disp[] = "Labels:";
                    foreach ($results->getLabels() as $label) {
                        $disp[] = $label->getName();
                    }
                    
                }

                return (object)['status' => 'ok', 'messages' => $disp];

            }
            catch(Exception $e) {
                // TODO(developer) - handle error appropriately
                // echo 'Message: ' .$e->getMessage();
                return (object)['status' => 'error', 'messages' => $e->getMessage()];

            }

        }else if($check->status=='auth'){

            return (object)['status' => $check->status, 'authUrl' => $check->authUrl];

        }
        
    }


}
