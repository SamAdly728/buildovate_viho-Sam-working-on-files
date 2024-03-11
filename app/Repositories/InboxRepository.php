<?php

namespace App\Repositories;

use App\Http\Controllers\InboxController;
use App\Models\InboxSetting;
use Google\Client as GoogleClient;
use Google\Service\Gmail;

class InboxRepository
{
    public function updateApiConnectionStatus($request)
    {
//        $inbox = InboxSetting::where('id', $request['id'])->first();
        return $this->googleGmailRidirect();
//        return InboxSetting::where('id', $request['id'])->update(['status'=>$request['status']]);
    }

    public function googleGmailRidirect()
    {
        $client = new GoogleClient();
        $client->setApplicationName('Buildovate');
        $client->setRedirectUri('http://localhost:8000/webhooks/gmail-api');
        //$client->setRedirectUri(env('APP_URL').'/webhooks/gmail-api');
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

        return $client->createAuthUrl();
    }

    public function googleGmailCallback()
    {

    }
}