<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Proposal;
use Inertia\Inertia;

class ReportsController extends Controller
{

    public function coming_soon(Request $request)
    {
        return Inertia::render('reports/ComingSoon',
            ['pageTitle' => ""]);
    }

}