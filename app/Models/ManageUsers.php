<?php

namespace App\Models;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\Role;

class ManageUsers extends Model
{
    use HasFactory;

    public static function get_users($filter)
    {
        $cond = 'u.user_id>0 and u.user_id = uc.user_id';
        if(isset($filter['role_id']) && is_numeric($filter['role_id'])) {
            $cond .= ' AND u.role_id="'.$filter['role_id'].'" ';
        }

        if (isset($filter['account_status']) && is_numeric($filter['account_status'])) {
            $cond .= ' AND uc.account_status="'.$filter['account_status'].'"';
        }

        return DB::table('users AS u')
                ->leftJoin('users_account_details AS ud','u.user_id','=','ud.user_id')
                ->leftJoin('company_roles AS r','u.role_id','=','r.company_roles_id')
                ->leftJoin('users_credentials as uc', 'uc.user_id', '=', 'u.user_id')
                ->select('u.user_id', 'u.display_name', 'u.email', 'u.phone', 'r.role_display_name', 'r.company_roles_id', 'uc.account_status', 'u.created_on', 'u.last_logged_in', 'uc.username', 'u.first_name', 'u.last_name')
                ->whereRaw($cond)
                ->orderBy('u.created_on','desc')
                ->paginate(10);
    }

    public static function send_invite($request)
    {
//        dd($request->get('userType'));
        $status = 'ok';
        $message = '';

        $email = strtolower(trim($request->email));

        $user = User::where('email',$email)->first();


        if($user) {
           return (object)[
               'success' => false,
               'email' => $email
           ];
        }

//        if(isset($user->user_id)){
//            //update
//            $user_id = $user->user_id;
//            User::where('user_id',$user_id)
//            ->update([
//                'role_id' => $request->userType,
//                'display_name' => $request->first_name.' '.$request->last_name,
//                'first_name' => $request->first_name,
//                'last_name' => $request->last_name,
//           ]);
//
//           $acc = DB::table('users_account_details')
//                  ->select('invite_status')
//                  ->where('user_id',$user_id)
//                  ->first();
//
//            if($acc->invite_status==0) {
//                $invite_status = 1;
//            }else if($acc->invite_status==1){
//                $invite_status = 4;
//            }
//
//            //update
//            DB::table('users_account_details')
//            ->where('user_id',$user_id)
//            ->update(['invite_status'=>$invite_status]);
//
//        }else{

            //add
            $user_id = User::insertGetId([
                            'role_id' => $request->userType,
                            'display_name' => $request->first_name.' '.$request->last_name,
                            'email' => $email,
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'created_on' => date('Y-m-d H:i:s'),
                       ]);

//                        DB::table('users_account_details')
//                        ->insert([
//                            'user_id' => $user_id,
//                            'invite_status' => 1
//                        ]);
//        }

        $user_creds_id = UserCredential::insertGetId([
            'user_id' => $user_id,
            'email' => $email,
            'account_status' => 2
        ]);

        if ($request->get('userType')) {
            $new = new UserRole();
            $new->user_id = $user_id;
            $new->user_cred_id = $user_creds_id;
            $new->role_id = $request->get('userType');
            $new->slug = Role::where('company_roles_id', $request->get('userType'))->first()->role_name;
            $new->save();
        }

        $co = Company::select('company_name', 'company_id')->where('user_id',Session::get('user_id'))->first();

        //send email
        $viewData = [
            'INVITED_BY' => Session::get('name'),
            'FIRST_NAME' => ucwords($request->first_name),
            'CODE' => base64_encode($email),
            'COMPANY_NAME' => $co->company_name ?? '[NOCOMPANY]',
            'COMPANY_ID' => $co->company_id ?? null,
            'USER_CREDS_ID' => $user_creds_id
        ];

        $subject = "Accept ".Session::get('name')."'s invitation to join Buildovate!";

        Mail::send('emails.invite-user', $viewData, function ($message) use ($subject, $email) {
           $message->to($email)
                   ->subject($subject);
        });

        return (object)[
                'success' => true,
                'message' => 'Email invitation has been sent to <h4 class="text-primary-v2"><i> '.$email.' </i></h4>'
            ];
    }

    public static function new_user_invitation($request)
    {
        $code = $request->get('code');
        $comId = $request->get('c');
        $email = base64_decode($code);

        //check
        $user = User::select('user_id','email','first_name','last_name')->where('email',$email)->first();
        $user->company = Company::select('company_name')->where('company_id',$comId)->first()->company_name;

        return $user;
    }

    public static function accept_invitation($request)
    {
        $newUser = UserCredential::where('user_id', $request->get('user_id'))->first();
//        $newUser->email = $request->get('email');
//        $newUser->user_id = $request->get('user_id');
        $newUser->username = $request->get('username');
        $newUser->password = bcrypt($request->get('password'));
        $newUser->account_status = 1;
        $newUser->save();
        return $newUser;
    }

    public static function send_password_reset_email($request)
    {
        $email = $request->get('email');
        $viewData = [
            'CODE' => base64_encode($email),
            'USER_CREDS_ID' => $request->get('user_id')
        ];

        $subject = "Password Reset";

        Mail::send('emails.password-reset', $viewData, function ($message) use ($subject, $email) {
            $message->to($email)
                ->subject($subject);
        });

        return (object)[
            'success' => true,
            'message' => 'Email for password reset has been sent to <h4 class="text-primary-v2"><i> '.$email.' </i></h4>'
        ];
    }

    public static function reset_password($request)
    {
//        $user = UserCredential::where('user_id', $request->get('uc'))->first();
    }

    public static function get_roles()
    {
        return CompanyRole::select('company_roles_id as id','role_description', 'role_display_name')
            ->where('status', 1)->where('role_name', '!=', 'pros')->orderBy('role_description','asc')->get();
    }

    public static function get_pros()
    {
        return DB::table('users as u')->leftJoin('pro_users as pu', 'u.user_id', '=', 'pu.user_id')->paginate(10);
    }

    public static function get_user_payrate($request)
    {
        return UserPayRate::where('user_id' ,$request->get('userId'))->first();
    }

    public static function save_pay_rate($request)
    {
        $userPayRate = UserPayRate::where('user_id', $request->get('userId'))->first();
        if ($userPayRate) {
            $userPayRate->pay_rate = $request->get('payRate');
            $userPayRate->save();
            return $userPayRate;
        }else{
            $new = new UserPayRate();
            $new->user_id = $request->get('userId');
            $new->pay_rate = $request->get('payRate');
            $new->added_by = session()->get('user_id');
            $new->save();
            return $new;
        }
    }

    public static function get_deactivated()
    {
        return self::get_users(['account_status' => 0]);
    }

    public static function get_pending()
    {
        return self::get_users(['account_status' => 2]);
    }

    public static function revoke_access($request)
    {
       $user = UserCredential::where('user_id', $request->get('userId'))->first();
       $user->account_status = $request->get('action');
       $user->save();
       return $user;
    }
}
