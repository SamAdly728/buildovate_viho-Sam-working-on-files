<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatGPTController extends Controller
{
    public function index() {
        // return your view for the chat interface here
    }

    public function generate_email_reply(Request $request)
    {
        // $subject = $request->get('subject');
        // $message = $request->get('message');
        // $sendToName = $request->get('sendToName');
        // $sendToEmail = $request->get('sendToEmail');
        $sendToName = 'Tyler Grossheim';
        $subject = 'Your proposal from Feel At Home Builders is ready';
        $message = 'Thanks for the quote. 

        We talked about this briefly when meeting you, but because our roof is new we are fairly paranoid about putting holes in it. You mentioned solar does the same thing, which we have experienced first hand. We also experienced that they missed properly sealing one of the anchor points and we had a leak this past winter. They guaranteed their work though and came out to properly seal the missed spot and repair any damage (which thankfully there was be none). Would you provide a similar 1 year warranty for leaks and repairs on the locations you penetrate in our roof?
        
        We like your vision for our patio and love the idea of not having the extra posts. If you could offer some assurance in writing I think we would be good to move forward. 
        
        Thanks,
        Dylan and Tyler';

    
        // $add_prompt = "As a construction company, please respond to this email that we just received from a customer. 
        //             Please understand that customer satisfaction is very important to our construction company so please respond to this customer with a quality response. 
        //             If you need, you may review the chain of emails between the customer and our construction company to have more information for your email response.";
        $add_prompt = "We are a construction company. Please reply to the latest email in this thread. ";

        $prompt = "Dear [".$sendToName."], " .
                  "You recently sent an email with the subject line \"{$subject}\". " .
                  "In this email, you mentioned \"{$message}\". " .
                  "How should I respond to this email? ". $add_prompt;

        $payload = json_encode([
            'prompt' => $prompt,
            'max_tokens' => 150
        ]);
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.openai.com/v1/engines/davinci/completions',
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => "",
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 30,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . env('OPENAI_API_KEY') 
            ],
        ]);

        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $data = json_decode($response, true);

        // echo "data: <pre>";
        // print_r($data);
        // exit();
        
        if(isset($data['error']))
        {
            $status = 'error';
            $message = isset($data['message']) ? $data['message'] : '';
            //Array
            // (
            //     [error] => Array
            //         (
            //             [message] => Internal server error
            //             [type] => auth_subrequest_error
            //             [param] => 
            //             [code] => internal_error
            //         )

            // )
        }else{

            $status = 'ok';
            $message = isset($data['message']['choices'][0]['text']) ? $data['message']['choices'][0]['text'] : '';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);

    }
}
