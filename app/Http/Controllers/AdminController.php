<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CompanyNumber;
use App\Models\CompanyRole;
use Google\Service\Directory\Roles;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin',
            ['pageTitle' => "Admin"]);
    }

    /**
     * @return \Inertia\Response
     */
    public function subscription(): \Inertia\Response
    {
        return Inertia::render('admin/Subscription');
    }

    /**
     * @return \Inertia\Response
     */
    public function permissionsAndRoles(): \Inertia\Response
    {
        return Inertia::render('admin/PermissionsAndRoles', ['roles' => CompanyRole::all()]);
    }

    /**
     * @return \Inertia\Response
     */
    public function phoneNumberManagement(): \Inertia\Response
    {

        $companyNumbers = CompanyNumber::get();

        return Inertia::render('admin/PhoneNumberManagement', compact('companyNumbers'));
    }
    
}
