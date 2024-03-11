<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InternalController extends Controller
{
    public function index()
    {
        return Inertia::render('Internal');
    }
}
