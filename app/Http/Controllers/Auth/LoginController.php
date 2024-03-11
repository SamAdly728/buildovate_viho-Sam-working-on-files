<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCredential;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $checkActiveUser = UserCredential::select('account_status')->where('email', $request->get('email'))->first();

        if ($checkActiveUser && $checkActiveUser->account_status == 0) {
            return back()->withErrors([
                'email' => 'Account has been deactivated.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            $user = Auth::user(); 
            
            $userData = $user->user;
            
            $company = null;
            if (isset($userData->ownedCompany)) {
                $company = $userData->ownedCompany;
            }
            else if (isset($userData->partOfCompany) && $userData->partOfCompany->isNotEmpty()) {
                $company = $userData->partOfCompany->first()->company;
            }
            
            $primaryLocation = $company ? $company->primaryLocation : null;
            
            $role_name = '';
            $u = User::select('role_id')->where('user_id', $user->user_id)->first();
            if(isset($u->role_id))
            {
                $role_name = Role::select('role_name')->where('company_roles_id',$u->role_id)->first()->role_name;
            }

            $sessionFormData = [
                'user_id' => $user->user_id,
                'role_name' => $role_name,
                'email' => $user->email,
                'username' => $user->username,
                'first_name' => $userData->first_name,
                'last_name' => $userData->last_name,
                'user_display_name' => $userData->display_name,
                'plaid_access_token' => $user->plaid_access_token,
                // 'logo' => isset($company->logo) ? $company->logo : '',
                'logo' => isset($company->company_name) ? $company->company_name : '',
                'company_id' => isset($company->company_id) ? $company->company_id : 0,
                'company_name' => isset($company->company_name) ? $company->company_name : '',
                'company_license_number' => isset($company->license_number) ? $company->license_number : '',
                'company_address' => $primaryLocation->location_address ?? 'No Primary Address',
                'company_city' => $primaryLocation->location_city ?? 'No Primary Address',
                'company_state' => $primaryLocation->location_state ?? 'No Primary Address',
                'company_zipcode' => $primaryLocation->location_zipcode ?? 'No Primary Address',
                'plaid_access_token' => $user->plaid_access_token
            ];

            User::where('user_id', $user->user_id)->update(['last_logged_in' => now()]);

            Session::put($sessionFormData);
            return Inertia::location('/projects');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->flush();
        return Inertia::location('/');
    }
}
