<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PortalController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->query('token');
        return Inertia::render('portal/CustomerPortal', ['token' => $token]);
    }

    public function pros(Request $request)
    {
        $token = $request->query('token');
        return Inertia::render('portal/WorkOrderPortal', ['token' => $token]);
    }
}