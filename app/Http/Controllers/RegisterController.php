<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Register',
            ['pageTitle' => "Register"]);
    }
}
