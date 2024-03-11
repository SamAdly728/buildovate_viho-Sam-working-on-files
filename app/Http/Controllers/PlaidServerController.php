<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class PlaidServerController extends Controller
{
    private $nodeServerUrl;

    public function __construct()
    {

    }

    public function createLinkToken() {
        $nodeServerUrl = env('NODE_SERVER_URL') . '/create_link_token';
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_VERBOSE => true,
            CURLOPT_URL => $nodeServerUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
        ]);
    
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $err = curl_error($curl);
            Log::error("createLinkToken Error: " . $err);
            curl_close($curl);
    
            return response()->json(['error' => 'cURL error: ' . $err], 500);
        }else{
            $info = curl_getinfo($curl);
            Log::info("createLinkToken info: ", $info);
        }
    
        curl_close($curl);
        $data = json_decode($response, true);
        
        return response()->json($data);
    }    

    public function exchangePublicToken(Request $request){
        $nodeServerUrl = env('NODE_SERVER_URL') . '/exchange_public_token';
        $curl = curl_init();
        $postData = [
            'public_token' => $request->input('public_token')
        ];
        $postFields = json_encode($postData);
        curl_setopt_array($curl, $this->setCurlOption($nodeServerUrl, "POST", $postFields));

    
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        Log::error("exchangePublicToken response: " . $response);

        if ($response === false) {
            $err = curl_error($curl);
            Log::error("exchangePublicToken Error: " . $err);
            curl_close($curl);
    
            return response()->json(['error' => 'cURL error: ' . $err], 500);
        }else{
            $info = curl_getinfo($curl);
            Log::info("exchangePublicToken info: ", $info);
        }
    
        curl_close($curl);
        $data = json_decode($response, true);
        
        return response()->json($data);
    }

    public function transactionSync(Request $request)
    {
        $nodeServerUrl = env('NODE_SERVER_URL') . '/transaction_sync';
        $curl = curl_init();
        $postData = [
            'access_token' => $request->input('access_token'),
            'start_date' => date('Y-m-01'), // First day of the current month
            'end_date' => date('Y-m-t') // Last day of the current month
        ];
        $postFields = json_encode($postData);
        curl_setopt_array($curl, $this->setCurlOption($nodeServerUrl, "POST", $postFields));

        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        Log::error("transactionSync response: " . $response);

        if ($response === false) {
            $err = curl_error($curl);
            Log::error("transactionSync Error: " . $err);
            curl_close($curl);
    
            return response()->json(['error' => 'cURL error: ' . $err], 500);
        }else{
            $info = curl_getinfo($curl);
            Log::info("transactionSync info: ", $info);
        }
    
        curl_close($curl);
        $data = json_decode($response, true);
        
        return response()->json($data);
    }

    public function saveAccessToken(Request $request)
    {
        try {
            // Assuming you're using the default guard, Auth::user() will retrieve the authenticated user.
            $user = Auth::user(); // This should be an instance of UserCredential.
    
            // Ensure you're getting the token from the request.
            $accessToken = $request->input('access_token');
            if (!$accessToken) {
                throw new \Exception("No public token provided in the request.");
            }
            $user->plaid_access_token = $accessToken;
            $user->save();
    
            Session::put('plaid_access_token', $accessToken);
            return response()->json($user->plaid_access_token);
        } catch (\Exception $e) {
            Log::error('Error in savePublicToken: ' . $e->getMessage());
        }
    }

    function setCurlOption($url, $method, $postFields = null){
        $options = [
            CURLOPT_VERBOSE => true,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
        ];

        if($postFields !== null){
            $options[CURLOPT_POSTFIELDS] = $postFields;
        }
    
        return $options;
    }
}
