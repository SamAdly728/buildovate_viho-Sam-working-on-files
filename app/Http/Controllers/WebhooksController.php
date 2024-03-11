<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\AccessToken;
use App\Models\GAPI;
use App\Models\User;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

use Inertia\Inertia;

class WebhooksController extends Controller
{
    

    public function facebook_leads_test(Request $request)
    {
        $ad_id = $request->get('ad_id');
        
        $fb = AccessToken::where('user_id',Session::get('user_id'))
             ->where('lead_type','fb')
             ->first();
             
        echo "userId: ".Session::get('user_id')."<pre>";
        // print_r($fb);
        // echo $fb->access_token;
        
        // get user's name
        // $url = "https://graph.facebook.com/".$fb->lead_user_id."?access_token=".$fb->access_token;
        
        //get page lead
        
        $url = "https://graph.facebook.com/".$fb->lead_user_id."/leads?access_token=".$fb->access_token."&ad_id=".$ad_id;
        
        print_r($url);
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => "",
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 30,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $data = json_decode($response, true);

        echo "data: <pre>";
        print_r($data);
        exit();
        
        
        if(isset($request->accessToken) && $request->accessToken!='')
        {
            $data = [
                'user_id'=>Session::get('user_id'),
                'lead_type'=>'fb',
                'lead_user_id'=>$request->leadUserID,
                'access_token'=>$request->accessToken,
                'expires_in'=>$request->expiresIn
            ];

            // echo "<pre>";
            // print_r($data);
            // exit();

            //check
            $access = AccessToken::select('id')
                     ->where('user_id',Session::get('user_id'))
                     ->where('lead_type','fb')
                     ->first();
            if(isset($access->id))
            {
                $status = AccessToken::where('id',$access->id)->update($data);
            }else{
                $status = AccessToken::insert($data);
            }

            return response()->json([
                'req' => $request->all(),
                'status'  => $status
            ]);
            exit();
        }

        return Inertia::render('TestFBLogin',
            [
                'facebook_app_id'=>env('FBAPP_ID'),
                'pageTitle' => "TestFBLogin",
            ]);
    }

    public function save_facebook_token(Request $request)
    {
        if(isset($request->accessToken) && $request->accessToken!='')
        {
            $data = [
                'user_id'=>Session::get('user_id'),
                'lead_type'=>'fb',
                'lead_user_id'=>$request->leadUserID,
                'access_token'=>$request->accessToken,
                'expires_in'=>$request->expiresIn,
                'data_access_expiry'=>$request->dataAccessExpiry,
                'signed_request'=>$request->signedRequest
            ];

            //check
            $access = AccessToken::select('id')
                     ->where('user_id',Session::get('user_id'))
                     ->where('lead_type','fb')
                     ->first();
            if(isset($access->id))
            {
                $status = AccessToken::where('id',$access->id)->update($data);
            }else{
                $status = AccessToken::insert($data);
            }

            return response()->json([
                'req' => $request->all(),
                'status'  => $status
            ]);
        }
    }

    public function regen_facebook_token(Request $request)
    {
        $status = $this->refresh_access_token();
        
        return response()->json([
            'req' => $request->all(),
            'status'  => $status
        ]);
    }

    private function refresh_access_token() 
    {
        $fb = AccessToken::select('id','access_token')->where('user_id',Session::get('user_id'))-first();
        
        if(isset($fb->access_token))
        {
            $url = "https://graph.facebook.com/{graph-api-version}/oauth/access_token?";
            $url .=  "grant_type=fb_exchange_token&";
            $url .=  "client_id=".env('FBAPP_ID')."&";
            $url .=  "client_secret=".env('FBAPP_SECRET')."&";
            $url .=  "fb_exchange_token=".$fb->access_token;
            
            print_r($url);
            
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            
            $data = json_decode($response, true);

            // if(isset($data['access_token']))
            // {
            //     //update access_token
            //     return AccessToken::where('id',$fb->id)
            //             ->update([
            //                 'access_token'=>$data['access_token'],
            //                 'expires_in'=>$data['expires_in'],
            //                 'updated_at'=>date("Y-m-d H:i:s")
            //             ]);
            // }

            echo "data: <pre>";
            print_r($data);
            exit();

            return false;
        }
    }

    public function facebook_leads(Request $request)
    {
        //get headers
        $headers = apache_request_headers();

        //receive xml data
        // $data = trim(file_get_contents('php://input'));
        $data = $request->all();

        if(isset($request->test) && $request->test!='')
        {
            switch($request->test)
            {
                case 'generate_access_token':
                    $access_token = $this->generate_access_token();
                    echo $access_token;
                break;

                case 'get_user_id':
                    $user_id = $this->get_user_id();
                break;

                case 'get_page_id':
                    $page_id = $this->get_page_id();
                break;

            }
            
            
        }else{

        // exit();
        // Array
        // (
        //     [hub_mode] => subscribe
        //     [hub_challenge] => 45678574
        //     [hub_verify_token] => iAmNothing
        // )
        
        // $data = DB::table('zlogs')->where('id',1)->first();
        // echo "<pre>";
        // print_r(unserialize($data->data));
        // exit();
        
            if($request->hub_verify_token=='iAmNothing')
            {
            
                DB::table('zlogs')
                ->insert([
                    'name'=>'facebook-lead',
                    'data'=>serialize($request->all()),
                    'created_at'=>date('Y-m-d H:i:s')
                ]);
                
                http_response_code(200);
                header("HTTP/1.1 200 OK");
                header("Status: 200 OK");
                // return 200;
                return $data->hub_challenge;
            }

            //log temporarily
            //save to db
            // DB::table('zlogs')->insert([
            //   'name'=>'facebook-lead',
            //   'data'=>serialize($data),
            //   'created_at'=>date('Y-m-d H:i:s')
            // ]);

            http_response_code(200);
            header("HTTP/1.1 200 OK");
            header("Status: 200 OK");
            return 200;
        }
    }

    public function gmail_api(Request $request)
    {
        // DB::table('zlogs')
        // ->insert([
        //     'name' => 'gmail-api',
        //     'data' =>serialize($request->all())
        // ]);

        // exit();

        if(isset($request->code))
        {
            $check = GAPI::where('user_id',Session::get('user_id'))->first();

            $data = [
                'code' => $request->code,
                // 'access_token' => $request->access_token,
                // 'expires_in' => $request->expires_in,
                // 'refresh_token' => $request->refresh_token,
                // 'token_type' => $request->token_type,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if(isset($check->id))
            {
                GAPI::where('user_id',Session::get('user_id'))->update($data);

            }else{

                $data['user_id'] = Session::get('user_id');
                $data['created_at'] = date('Y-m-d H:i:s');
                GAPI::insert($data);

            }      
            
            // temporary redirect
            return redirect('/inbox');

            http_response_code(200);
            header("HTTP/1.1 200 OK");
            header("Status: 200 OK");
        }

    }

    private function generate_access_token()
    {
        // curl -X GET "https://graph.facebook.com/oauth/access_token
        //     ?client_id={your-app-id}
        //     &client_secret={your-app-secret}
        //     &grant_type=client_credentials"

        // curl -i -X GET "https://graph.facebook.com/{api-endpoint}&access_token={your-app_id}|{your-app_secret}"   

        $appID = env('FBAPP_ID'); //'874226064045292';
        $appSecret = env('FBAPP_SECRET'); //'be9e7cab1c6fb015fe422ffc91cf4bf4';

        $url = "https://graph.facebook.com/oauth/access_token?client_id=".$appID."&client_secret=".$appSecret."&grant_type=client_credentials";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_POSTFIELDS => $data,
            // CURLOPT_HTTPHEADER => [
            //     "x-api-key: 6fu2tfl9wqaw25fp5pbh1y94",
            //     "Content-Type: application/x-www-form-urlencoded; charset=utf-8"
            // ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if($response)
        {
            $res = json_decode($response);
            
            return $res->access_token;

            // echo "<pre>";
            // print_r($res);
            // stdClass Object
            // (
            //     [access_token] => 874226064045292|Y4nkdorEQFSZxXhCNTvYfgbR1_w
            //     [token_type] => bearer
            // )
        }

        return false;
    }

    private function get_user_id()
    {
        // curl -X GET "https://graph.facebook.com/oauth/access_token
        //     ?client_id={your-app-id}
        //     &client_secret={your-app-secret}
        //     &grant_type=client_credentials"

        // curl -i -X GET "https://graph.facebook.com/{api-endpoint}&access_token={your-app_id}|{your-app_secret}"   


        // $userID = '856725812648399';//785089483145366;
        // $access_token = '874226064045292|Y4nkdorEQFSZxXhCNTvYfgbR1_w';
        // $access_token = "EAAMbGp4ANOwBOzlvKH94GUkvUqu71kd0ddJZBylzPoPo430131TdLY1jZBNrLBhPsugwGlBA7XFgtJREeNQYT62JeYIxHop3PKtUBhr9yEzZBBqQ0lTwqkiI2ZAtEft0PZCcmL5i4JvNV2V35nONCZBZBrotR8ARzqrYqgl9oTn6sjiGw9EeRecbB5EhxhgAAKTWoNLg4Smj5UbtuJBdwZDZD";

        // $url = "https://graph.facebook.com/v18.0/".$userID."/accounts?access_token=".$access_token;

        $url = "https://graph.facebook.com/v18.0/me?fields=id%2Cname&access_token=EAAMbGp4ANOwBOzlvKH94GUkvUqu71kd0ddJZBylzPoPo430131TdLY1jZBNrLBhPsugwGlBA7XFgtJREeNQYT62JeYIxHop3PKtUBhr9yEzZBBqQ0lTwqkiI2ZAtEft0PZCcmL5i4JvNV2V35nONCZBZBrotR8ARzqrYqgl9oTn6sjiGw9EeRecbB5EhxhgAAKTWoNLg4Smj5UbtuJBdwZDZD";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if($response)
        {
            $res = json_decode($response);
            
            return $res->id;

            // echo "<pre>";
            // print_r($res);
            // exit();
            // stdClass Object
            // (
            //     [id] => 856725812648399
            //     [name] => Xavier Ferd
            // )
        }
    }

    private function get_page_id()
    {
        // curl -X GET "https://graph.facebook.com/oauth/access_token
        //     ?client_id={your-app-id}
        //     &client_secret={your-app-secret}
        //     &grant_type=client_credentials"

        // curl -i -X GET "https://graph.facebook.com/{api-endpoint}&access_token={your-app_id}|{your-app_secret}"   


        $userID = '856725812648399';//785089483145366;
        // $access_token = '874226064045292|Y4nkdorEQFSZxXhCNTvYfgbR1_w';
        $access_token = "EAAMbGp4ANOwBOzlvKH94GUkvUqu71kd0ddJZBylzPoPo430131TdLY1jZBNrLBhPsugwGlBA7XFgtJREeNQYT62JeYIxHop3PKtUBhr9yEzZBBqQ0lTwqkiI2ZAtEft0PZCcmL5i4JvNV2V35nONCZBZBrotR8ARzqrYqgl9oTn6sjiGw9EeRecbB5EhxhgAAKTWoNLg4Smj5UbtuJBdwZDZD";

        $url = "https://graph.facebook.com/v18.0/".$userID."/accounts?access_token=".$access_token;

        // $url = "https://graph.facebook.com/v18.0/me?fields=id%2Cname&access_token=EAAMbGp4ANOwBOzlvKH94GUkvUqu71kd0ddJZBylzPoPo430131TdLY1jZBNrLBhPsugwGlBA7XFgtJREeNQYT62JeYIxHop3PKtUBhr9yEzZBBqQ0lTwqkiI2ZAtEft0PZCcmL5i4JvNV2V35nONCZBZBrotR8ARzqrYqgl9oTn6sjiGw9EeRecbB5EhxhgAAKTWoNLg4Smj5UbtuJBdwZDZD";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if($response)
        {
            $res = json_decode($response);
            
            // return $res->id;

            echo "<pre>";
            print_r($res);
            exit();
            // stdClass Object
            // (
            //     [id] => 856725812648399
            //     [name] => Xavier Ferd
            // )
        }
    }

    //check accept invites from user
    //init from CompanyController::class,'users_send_invite
    public function user_accept_invite(Request $request)
    {
        $code = $request->get('code');
        $comId = $request->get('c');
        $email = base64_decode($code);

        //check 
        $user = User::select('user_id','email','first_name','last_name')->where('email',$email)->first();
        $user->company = Company::select('company_name')->where('company_id',$comId)->first()->company_name;

        if(isset($user->user_id))
        {
            //show form to add password
            return Inertia::render('company/AcceptInvite',[
                'user' => $user
            ]) ;
        }else{
            //show invalid code page
            echo "code invalid ";
        }
        
    }

}
