<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FooterLinksController extends Controller
{
    public function privacy_policy(Request $request)
    {
        return Inertia::render('footer_links/PrivacyPolicy',
            ['pageTitle' => "Privay Policy"]);
    }

    public function terms_of_service(Request $request)
    {
        return Inertia::render('footer_links/TermsOfService',
            ['pageTitle' => "Terms Of Service"]);
    }
        
}
