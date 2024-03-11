<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\FacebookAPI;
use App\Repositories\InboxRepository;
use Google\Client as GoogleClient;
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
use App\Models\InboxSetting;
use App\Models\AccessToken;
// use App\Models\ChatRoom;
// use App\Models\ChatMessage;
// use App\Mail\ChatEmailSent;

use Inertia\Inertia;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Authentication\AccessToken as toke;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\ModifyThreadRequest;
use Google\Service\Gmail\Thread;
use Google\Service\Gmail\Draft;
use Google\Service\Gmail\Resource\UsersThreads;

// use PhpMimeMailParser\Parser;
use eXorus\PhpMimeMailParser\Parser;
use eXorus\PhpMimeMailParser\Attachment;

// use Vinkla\Pusher\Facades\Pusher as LaravelPusher;

use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client as guzzle;
use DateTime;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class InboxController extends Controller
{
    private InboxRepository $inboxRepository;
    private Facebook $facebook;

    /**
     * @throws FacebookSDKException
     */
    public function __construct(InboxRepository $inboxRepository)
    {
        $this->inboxRepository = $inboxRepository;

        $this->facebook = new Facebook([
            'app_id' => env('FBAPP_ID'),
            'app_secret' => env('FBAPP_SECRET'),
            'default_graph_version' => 'v18.0',
        ]);

    }

    public function index(Request $request)
    {
        $messages = array();

        // $res = GAPI::labels();
        // echo "<pre>";
        // print_r($res);
        // exit();

        return Inertia::render('Inbox',
            [
                "pageTitle" => "",
                "messages"=>$messages
            ]);
    }

    public function gmail()
    {

//        $messages = [];
//        $messageCount = 0;
//        $previousPageToken = '';
//        $nextPageToken = '';
//        $resultSizeEstimate = 0;
//        $opts = [];
//        $res = GAPI::messages('INBOX', $opts);
//
//        if($res->status=='ok') {
//            $messages = $res->messages;
//            $previousPageToken = $res->previousPageToken;
//            $nextPageToken = $res->nextPageToken;
//            $resultSizeEstimate = $res->resultSizeEstimate;
//            $messageCount = $res->count;
//        }

        // Check if data exists in the cache
        if (Cache::has('fb_data')) {
            $facebookData = Cache::get('fb_data');
        } else {
            // Fetch data from the API
            $facebookData = [];
            // Cache the data for 1 hour
            Cache::put('fb_data', $facebookData, now()->addHour());
        }


        $settings = [
            'gmail' => (bool)GAPI::where('user_id', session()->get('user_id'))->first(),
            'facebook' => (bool)FacebookAPI::where('user_id', session()->get('user_id'))->first()
        ];


        return Inertia::render('inbox/Gmail',
            [
                "pageTitle" => "",
//                'gmailCount' => $messageCount,
//                "messages"=>$messages,
//                "previousPageToken"=>$previousPageToken,
//                "nextPageToken"=>$nextPageToken,
//                "resultSizeEstimate"=>$resultSizeEstimate,
                "settings" => $settings,
                'facebook' => $facebookData
            ]);
    }

    public function getGmailMessages(): array
    {
        $messages = [];
        $messageCount = 0;
        $previousPageToken = '';
        $nextPageToken = '';
        $resultSizeEstimate = 0;
        $opts = [];
        $res = GAPI::messages('INBOX', $opts);


        if($res->status=='ok') {
            $messages = $res->messages;
            $previousPageToken = $res->previousPageToken;
            $nextPageToken = $res->nextPageToken;
            $resultSizeEstimate = $res->resultSizeEstimate;
            $messageCount = $res->count;
        }

        return [
            'facebookCount' => $this->getFacebookMessages()['threads'],
            'gmailCount' => $messageCount,
            "messages"=> $messages,
            "previousPageToken"=>$previousPageToken,
            "nextPageToken"=>$nextPageToken,
            "resultSizeEstimate"=>$resultSizeEstimate,
        ];
    }

    public function gmail_list_messages(Request $request)
    {
        $messages = array();
        $previousPageToken = '';
        $nextPageToken = '';
        $resultSizeEstimate = 0;
        $prev_next = $request->get('prev_next');
        $search = $request->get('search');

        $opts = [];
        $opts['pageToken'] = $request->pageToken;
        if($search!='')
        {
            $opts['q'] = $search;
        }

        $res = GAPI::messages('INBOX', $opts);

        if($res->status=='ok')
        {
            return response()->json([
                'count' => $res->count,
                'messages' => $res->messages,
                'previousPageToken' => $request->pageToken,
                'nextPageToken' => $res->nextPageToken,
                'resultSizeEstimate' => $res->resultSizeEstimate
            ]);
        }

    }

    public function gmail_drafts(Request $request)
    {
        $messages = array();
        $opts = [];
        $res = GAPI::messages('DRAFT', $opts);

        if($res->status=='ok')
        {
            $messages = $res->messages;
        }

        return Inertia::render('inbox/Gmail',
            [
                "pageTitle" => "",
                "messages"=>$messages,
            ]);
    }

    public function gmail_mail_totals(Request $request)
    {
        $get_unread = GAPI::get_mail_total('UNREAD');
        $unread = ($get_unread->status=='ok') ? $get_unread->total : 0;

        $get_drafts = GAPI::get_mail_total('DRAFT');
        $drafts = ($get_drafts->status=='ok') ? $get_drafts->total : 0;

        return response()->json([
            'unread' => $unread,
            'drafts' => $drafts,
        ]);
    }

    public function gmail_messages(Request $request)
    {
        $prev_next = $request->get('prev_next');
        $check = GAPI::getClient();
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

                return response()->json([
                    'status' => 'ok',
                    'messages' => $disp
                ]);

            }
            catch(Exception $e) {
                // TODO(developer) - handle error appropriately
                // echo 'Message: ' .$e->getMessage();

                return response()->json([
                    'status' => 'error',
                    'messages' => $e->getMessage()
                ]);
            }

        }else if($check->status=='auth'){

            return response()->json([
                'status' => $check->status,
                'authUrl' => $check->authUrl
            ]);
        }
    }

    public function gmail_get_message(Request $request)
    {
        $messageId = $request->get('messageId');
        $threadId = $request->get('threadId');

        $res = GAPI::get_message($messageId, $threadId);

        return response()->json([
            'message' => $res->message,
            'threads' => $res->threads
        ]);
    }

    public function gmail_get_thread(Request $request)
    {
        $threadId = $request->get('id');

        $res = GAPI::get_thread($threadId);

        return response()->json([
            'message' => $res->message
        ]);
    }

    public function gmail_send_message(Request $request)
    {
        $status = '';
        if($request->message!='')
        {
            $check = GAPI::getClient();
            if($check->status=='ok')
            {
                $client = $check->client;
                $service = new Gmail($client);

                try{
                    // Print the labels in the user's account.
                    $user = 'me';
                    $opts = [];

                    $userId = 'me';

                    // if(isset($request->targetDate))
                    // {
                    //     $message = GAPI::formatLaterMessage($request);
                    // }else{
                    $message = GAPI::formatMessage($request);
                    // }

                    $result = $service->users_messages->send($userId, $message, array());

                    // Create a new ModifyThreadRequest object.
                    $thread = new ModifyThreadRequest();

                    $thread->setAddLabelIds(['INBOX']);

                    $thread->setRemoveLabelIds(['UNREAD']);

                    // $thread->setId($result->threadId);
                    // $thread->setSnippet('This is the new thread snippet.');

                    $optParams = ['format' => 'metadata'];
                    // Execute the request.
                    $resp = $service->users_threads->modify('me', $request->threadId, $thread, [] );

                    if(isset($resp->id))
                    {
                        $status = 'ok';
                    }else{
                        $status = 'failed';
                    }

                    return response()->json([
                        'status' => $status,
                        // 'messages' => $disp
                    ]);
                }
                catch(Exception $e) {
                    // TODO(developer) - handle error appropriately
                    // echo 'Message: ' .$e->getMessage();

                    return response()->json([
                        'status' => 'error',
                        'messages' => $e->getMessage()
                    ]);
                }

            }else if($check->status=='auth'){

                return response()->json([
                    'status' => $check->status,
                    'authUrl' => $check->authUrl
                ]);
            }
        }
    }

    public function gmail_draft_message(Request $request)
    {
        $status = '';
        if($request->message!='')
        {
            $check = GAPI::getClient();
            if($check->status=='ok')
            {
                $client = $check->client;
                $service = new Gmail($client);

                try{
                    // Print the labels in the user's account.
                    $user = 'me';
                    $opts = [];

                    $userId = 'me';

                    $message = GAPI::formatLaterMessage($request);

                    // $draft = new Draft();
                    // $draft->setMessage($message);

                    // $draft = $service->users_drafts->create($user, $draft);

                    $draftId = 1;//$draft->getId();

                    $target_date = date_create($request->targetDate);
                    $target_date = date_format($target_date,"Y-m-d H:i:s");

                    DB::table('inbox_email_que')
                    ->insert([
                        'user_id' => Session::get('user_id'),
                        'draft_id' => $draftId,
                        'target_date' => $target_date,
                        'message' => serialize($message),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    if($draftId>0)
                    {
                        $status = 'ok';
                    }else{
                        $status = 'failed';
                    }

                    return response()->json([
                        'status' => $status,
                        // 'messages' => $disp
                    ]);
                }
                catch(Exception $e) {
                    // TODO(developer) - handle error appropriately
                    // echo 'Message: ' .$e->getMessage();

                    return response()->json([
                        'status' => 'error',
                        'messages' => $e->getMessage()
                    ]);
                }

            }else if($check->status=='auth'){

                return response()->json([
                    'status' => $check->status,
                    'authUrl' => $check->authUrl
                ]);
            }
        }
    }

    public function settings(Request $request)
    {
        $settings = InboxSetting::orderBy('name','asc')->get();
        return Inertia::render('inbox/Settings',
            [
                "pageTitle" => "Inbox Settings",
                "settings" => $settings
            ]);
    }

    public function settings_set_status(Request $request)
    {
        $client = new GoogleClient();
        $client->setApplicationName('Buildovate');
        $client->setRedirectUri('http://localhost:8000/webhooks/gmail-api');
//        $client->setRedirectUri(env('APP_URL').'/webhooks/gmail-api');
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

        return redirect($client->createAuthUrl());
    }

    public function disconnectGmail()
    {
        $user = GAPI::where('user_id', session()->get('user_id'))->first();
        $client = new GoogleClient();
        $client->revokeToken($user->access_token);
        $user->delete();

        return redirect('/inbox');
    }

    public function googleGmailCallback()
    {
        return $this->inboxRepository->googleGmailCallback();
    }

    public function settings_new(Request $request)
    {
        return Inertia::render('inbox/settings/New',
            [
                "pageTitle" => "New Settings"
            ]);
    }

    public function settings_edit(Request $request, $id)
    {
        $setting = InboxSetting::findOrFail($id);

        return Inertia::render('inbox/settings/Edit',
            [
                "pageTitle" => "Edit Settings",
                "setting" => $setting
            ]);
    }

    public function settings_save_team_box(Request $request)
    {
        $id = $request->get('id');
        $status = false;
        $msg = '';

        $data = [
            'name' => $request->name,
            'updated_by'=>Session::get('user_id'),
            'phone_number'=>$request->phone_number,
            'do_not_disturb'=>($request->do_not_disturb) ? 1 : 0,
            'call_forwarding'=>($request->call_forwarding=='voicemail') ? 1 : 0,
        ];

        if(is_numeric($id) && $id>0 && $request->name!='')
        {
            $data['updated_by']= Session::get('user_id');
            $data['updated_at'] = date("Y-m-d H:i:s");
            $status = InboxSetting::where('id',$id)->update($data);
            $msg = ($status) ? 'Success! Team Inbox updated.' : 'Action Failed! Please try again later.';

        }else{

            $exist = InboxSetting::where('name',$request->name)
                    ->where('created_by',Session::get('user_id'))
                    ->count();
            if($exist>0)
            {
                $msg = 'Action Failed! Team Inbox already exist.';
            }else{
                $data['created_by']= Session::get('user_id');
                $data['created_at'] = date("Y-m-d H:i:s");
                $status = InboxSetting::insert($data);
                $msg = ($status) ? 'Success! Team Inbox created.' : 'Action Failed! Please try again later.';
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
    }

    public function text_messages(Request $request)
    {
        return Inertia::render('inbox/TextMessages',
            [
                "pageTitle" => "Text Messages"
            ]);
    }

    public function instagram(Request $request)
    {
        return Inertia::render('inbox/Instagram',
            [
                "pageTitle" => "Instagram"
            ]);
    }

    public function fb_messenger(Request $request)
    {
        $hasFBToken = AccessToken::select('token')
                            ->where('lead_type','fb')
                            ->where('user_id',Session::get('user_id'))
                            ->count();

        return Inertia::render('inbox/FBMessenger',
            [
                'pageTitle' => "FB Messenger",
                'hasFBToken' => $hasFBToken,
                'fb_app_id'=>env('FBAPP_ID'),
                'fb_page_id'=>env('FB_PAGE_ID'),
            ]);
    }

    public function yelp(Request $request)
    {
        return Inertia::render('inbox/Yelp',
            [
                "pageTitle" => "Yelp"
            ]);
    }

    public function website_live_chat(Request $request)
    {
        return Inertia::render('inbox/WebsiteLiveChat',
            [
                "pageTitle" => "Website Live Chat"
            ]);
    }

    public function whatsapp(Request $request)
    {
        return Inertia::render('inbox/WhatsApp',
            [
                "pageTitle" => "WhatsApp"
            ]);
    }

    public function loginToFB()
    {
        return Socialite::driver('facebook')
            ->scopes(['pages_messaging', 'user_photos', 'pages_read_engagement'])->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $buildovateUser = FacebookAPI::where('user_id', session()->get('user_id'))->first();

        if(!$buildovateUser) {
            $newBuildovateUser = new FacebookAPI();
            $newBuildovateUser->user_id = session()->get('user_id');
            $newBuildovateUser->facebook_user_id = $facebookUser->getId();
            $newBuildovateUser->facebook_user_name = $facebookUser->getName();
            $newBuildovateUser->facebook_user_email = $facebookUser->getEmail();
            $newBuildovateUser->facebook_user_token = $facebookUser->token;
            $newBuildovateUser->facebook_user_avatar_url = $facebookUser->getAvatar();
            $newBuildovateUser->save();
        }

        $this->facebook->setDefaultAccessToken($facebookUser->token);

        return redirect('/inbox');
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws FacebookSDKException
     */
    public function getFacebookMessages(): \Illuminate\Http\JsonResponse|array
    {
        $buildovateUser = FacebookAPI::where('user_id', session()->get('user_id'))->first();
        $getMessage = [];
        $conversationArray = [];
        $messageFromAndImage = [];

        if (!$buildovateUser) {
            return [
                'threads' => 0,
                'from' => []
            ];
        }
//        $accessToken = new toke($buildovateUser->facebook_user_token);
//
//        if ($accessToken->getExpiresAt() < time()) {
////            $response = $this->facebook->post('/oauth/access_token', [
////                'client_id' => env('FBAPP_ID'),
////                'client_secret' => env('FBAPP_SECRET'),
////                'grant_type' => 'fb_exchange_token',
////                'fb_exchange_token' => $buildovateUser->facebook_user_token,
////            ],$buildovateUser->facebook_user_token);
////
////            $newAccessToken = $response->getGraphNode()['access_token'];
//            $oAuth2Client = $this->facebook->getOAuth2Client();
//            $longLivedToken = $oAuth2Client->getLongLivedAccessToken($buildovateUser->facebook_user_token);
//            dd($longLivedToken->getValue());
////            $userToke =
//        } else {
//            $userToke = $buildovateUser->facebook_user_token;
//        }

        // Get user's page
        $response = $this->facebook->get('me/accounts', $buildovateUser->facebook_user_token);
        $page = $response->getDecodedBody()['data'][0];

        $buildovateUser->page_token = $page['access_token'];
        $buildovateUser->page_id = $page['id'];
        $buildovateUser->page_name = $page['name'];
        $buildovateUser->save();

        $url = "https://graph.facebook.com/v18.0/{$buildovateUser->page_id}/conversations?platform=messenger&access_token={$buildovateUser->page_token}";

        $conversation = json_decode(file_get_contents($url), true)['data'];

        foreach ($conversation as $con) {
            $conversationArray[] = json_decode(file_get_contents("https://graph.facebook.com/v18.0/{$con['id']}?fields=messages&access_token={$buildovateUser->page_token}"));
        }

        foreach ($conversationArray as $conv) {
            $con = (object)json_decode(file_get_contents("https://graph.facebook.com/v18.0/{$conv->messages->data[0]->id}?fields=id,created_time,from,to,message&access_token={$buildovateUser->page_token}"));
            $from = null;
            $otherUserId = null;
            if($con->from->id != $buildovateUser->page_id) {
                $from = $con->from->name;
                $otherUserId = $con->from->id;
            }else{
                $from = $con->to->data[0]->name;
                $otherUserId = $con->to->data[0]->id;
            }

            $messageFromAndImage[] = [
                'from' => $from,
                'avatar' => null,
                'conId' => $conv->id,
                'userId' => $otherUserId
            ];

        }

        return [
            'threads' => count($conversationArray),
            'from' => $messageFromAndImage
        ];
    }

    public function getConversationMessages(Request $request)
    {
        $buildovateUser = FacebookAPI::where('user_id', session()->get('user_id'))->first();
        $messages = (object)json_decode(file_get_contents("https://graph.facebook.com/v18.0/{$request->get('key-id')}?fields=messages&access_token={$buildovateUser->page_token}"))->messages->data;

        $dataArray = [];
        $dataMessage = [];

        foreach($messages as $mes) {
            $dataArray[] = (object)json_decode(file_get_contents("https://graph.facebook.com/v18.0/{$mes->id}?fields=id,created_time,from,to,message&access_token={$buildovateUser->page_token}"));
        }

        foreach($dataArray as $d) {
            $date = new DateTime($d->created_time);
            $formattedDate = $date->format('D g:i A');
            $dataMessage[] = [
                'date' => $formattedDate,
                'position' => ($d->from->id != $buildovateUser->page_id) ? 'right':'left',
                'message' => $d->message
            ];
        }

        return $dataMessage;
    }

    public function handleFacebookReply(Request $request)
    {
        $buildovateUser = FacebookAPI::where('user_id', session()->get('user_id'))->first();

        $guz = new guzzle();
        $endpoint = "https://graph.facebook.com/v18.0/me/messages?access_token={$buildovateUser->page_token}";

        $response = $guz->post($endpoint, [
            'json' => [
                'recipient' => [
                    'id' => $request->get('psid')
                ],
                'message' => [
                    'text' => $request->get('message')
                ]
            ]
        ]);

        return $response->getStatusCode();
    }

    public function disconnectFacebook()
    {
        $user = FacebookAPI::where('user_id', session()->get('user_id'))->first();
        $response = $this->facebook->delete('/me/permissions', [], $user->facebook_user_token);

        $user->delete();

        return redirect('/inbox');
    }

    public function loginToYelp()
    {

        return Socialite::driver('yelp')->redirect();
//        $query = http_build_query([
//            'client_id' => env('YELP_ID'),
//            'redirect_uri' => env('YELP_REDIRECT'),
//            'response_type' => 'code',
//            'scope' => 'r2r_get_businesses', // Replace with actual scope required by your app
//            'state' => bin2hex('abcefghijklmnopqrstuvwxyz'), // Generate a random string for state
//        ]);
//
//        return redirect('https://biz.yelp.com/oauth2/authorize?' . $query);
    }

    public function handYelpCallback(Request $request)
    {
        dd($request);
        $response = Http::asForm()->post('https://biz.yelp.com/oauth2/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'client_id' => env('YELP_CLIENT_ID'),
            'client_secret' => env('YELP_CLIENT_SECRET'),
            'redirect_uri' => env('YELP_REDIRECT_URI'),
        ]);

        $accessToken = $response->json()['access_token'];
        return redirect('/home');
//        $code = $request->get('code');
//
//        // Exchange the code for an access token
//        $accessToken = $this->getYelpAccessToken($code);
//
//        // Use $accessToken to make Yelp API requests or store it for later use
//
//        return redirect('/inbox');
    }

    protected function getYelpAccessToken($code)
    {
        $clientId = 'y5gLhvnGr91HlHCKiq56Cw';
        $clientSecret = 'uASufUeBl4pjZd9qhJwp2O5MblDirBLxCGUalwImtfeEslXUpeB5b5Pmi9hcRn9lTpbxf8iQMYzIGNGXzHsRY2G6ssNs6R89SlUt2yBjt_j9y5ILPrSJly4D2zilZXYx';
        $redirectUri = url('/inbox/settings/yelp-handle-callback');

        $client = new Client();

        $response = $client->post('https://api.yelp.com/oauth2/token', [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['access_token'];
    }
}
