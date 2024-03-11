<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\UserCredential;
use App\Models\Role;
use App\Models\UserBizInfo;
use App\Models\CompanyUser;
use App\Models\Company;
use App\Models\Knowledgebase;
use App\Models\KnowledgebaseCategory;
use App\Repositories\ContactRepository;

use Inertia\Inertia;

class UserController extends Controller
{

    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getAllContacts()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $contacts = $this->contactRepository->getAllContacts();

        return response()->json([
            'status' => 'success',
            'data' => $contacts
        ]);
    }

    public function settings(Request $request)
    {
        $user = User::where('id',Session::get('user_id'))->first();

        return Inertia::render('user/Settings',
            ['user' => $user, 'pageTitle' => "User Profile"]);
    }

    public function roadmap(Request $request)
    {
        return Inertia::render('user/RoadMap',
            ['pageTitle' => "Road Map"]);
    }

    public function live_chat(Request $request)
    {
        return Inertia::render('user/LiveChat',
            ['pageTitle' => "Live Chat"]);
    }

    public function profile(Request $request)
    {

        $user = User::select('first_name', 'last_name', 'role_id','display_name','email','profile_picture')->where('user_id',Session::get('user_id'))->first();
        //get role
        $role = Role::select('role_name')->where('role_id',$user->role_id)->first();
        $user->role = isset($role->role_name) ? $role->role_name : '';
        //get business info
        $bus = UserBizInfo::where('user_id',Session::get('user_id'))->first();
        // echo Session::get('userId')."<pre>";
        // print_r($user->display_name);
        // exit();
        return Inertia::render('user/Profile',
            [
                "pageTitle" => "Your Profile",
                "user" => $user,
                "bus" => $bus
            ]);
    }

    public function update_password(Request $request)
    {
        $new_password = $request->new_password;
        if($new_password!='' && $new_password!='password')
        {
            //update password
            $success = UserCredential::where('user_id',Session::get('userId'))
                    ->update(['password'=>bcrypt($new_password)]);
            
            if($success)
            {
                //send email notification
                $this->send_password_changed_email($new_password);
            }

            return response()->json([
                'success' => $success
            ]);
        }
    }

    public function update_profile(Request $request)
    {
        $user = User::find(session()->get('user_id'));
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->save();

        $busInfo = UserBizInfo::where('user_id', session()->get('user_id'))->first();
        $busInfo->business_street = $request->get('street');
        $busInfo->business_city = $request->get('city');
        $busInfo->business_state = $request->get('country');
        $busInfo->business_zipcode = $request->get('zipcode');
        $busInfo->save();

        return response()->json([
            'success' => true
        ]);

    }

    public function send_password_changed_email($new_password)
    {
        $msg_data = [
            'FIRST_NAME' => ucwords(strtolower(Session::get('first_name'))),
            'EMAIL' => Session::get('email'),
            'PASSWORD' => $new_password,
        ];

        $this->subject = "Your Buildovate Account password has been updated.";
        $this->email = Session::get('email');

        \Mail::send('emails.password-updated', $msg_data, function ($message) {
            $message->to($this->email)
                    ->subject($this->subject);
        });

        return true;
    }

    public function security(Request $request)
    {
        return Inertia::render('user/Security',
            ['pageTitle' => "Security"]);
    }
    
    public function knowledgebase(Request $request)
    {
        $categories = KnowledgebaseCategory::select('id','title')
                      ->orderBy('sort_order','asc')
                      ->get();

        $articles = Knowledgebase::select('id','categ_id','title')
                   ->where('status',1)
                   ->orderBy('id','asc')
                //    ->groupBy('categ_id')
                   ->get()
                   ->toArray();

        $arts = array();
        foreach($articles as $art)
        {
            $art = (object)$art;
            $arts[$art->categ_id][] = $art;
        }

        return Inertia::render('user/Knowledgebase',
            [
                'categories'=> $categories,
                'articles'  => $arts,
                'pageTitle' => "Knowledgebase"
            ]);
    }

    public function knowledgebase_details(Request $request)
    {
        $article = Knowledgebase::select('id','categ_id','title','content')
                    ->where('id',$request::get('id'))->first();
        if($article)
        {
            $article->categ_name = KnowledgebaseCategory::get_name($article->categ_id);

            return Inertia::render('user/KnowledgebaseDetails',
            [
                'article'=>$article, 
                'pageTitle' => "Knowledgebase Details"
            ]);
        }
    }
    
    //API FUNCTIONSs
    public function getAll()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');

        if (!$companyId) {
            return response()->json(['message' => 'No company ID found in session.'], 422);
        }
        
        $company = Company::with('user')->find($companyId);

        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $owner = $company->user;
        $companyUsers = $company->companyUsers()->with('user')->get();

        $users = $companyUsers->map(function ($companyUser) {
            return $companyUser->user;
        });

        if ($owner) {
            $users->prepend($owner);
        }

        return response()->json(['data' => $users]);
    }

}
