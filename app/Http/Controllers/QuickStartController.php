<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Quickstart;
use App\Models\QuickstartContent;
use App\Models\UsersQuickstart;

class QuickStartController extends Controller
{
    
    public function load(Request $request)
    {
        $qs = Quickstart::select('id','title','url')->orderBy('id','asc')->get();
        $uq = $uq = UsersQuickstart::select('quickstarts')->where('user_id',Session::get('user_id'))->first();
        $checklists = array();
        if(isset($uq->quickstarts))
        {
            $checklists = unserialize($uq->quickstarts);
        }

        foreach($qs as $q)
        {
            if(isset($checklists[$q->id]))
            {
                $q->status = $checklists[$q->id]['status'];
            }
        }

        // echo "<pre>";
        // print_r($qs);
        // exit();

        return response()->json([
            'quickstarts' => $qs
        ]);
    }

    public function load_body(Request $request)
    {
        $qs_id = $request->get('id');
        if(is_numeric($qs_id))
        {
            $qs = Quickstart::select('description','image','url')->where('id',$qs_id)->first();
            $description = $qs->description;
            $image = $qs->image;
            $url = $qs->url;
            $checklists = array();

            //get user quickstart
            $uq = UsersQuickstart::select('quickstarts')->where('user_id',Session::get('user_id'))->first();
            if(isset($uq->quickstarts))
            {
                $quickstarts = unserialize($uq->quickstarts);
                if(isset($quickstarts[$qs_id]))
                {
                    $checklists = $quickstarts[$qs_id];
                }
            }

            // $qb = QuickstartContent::where('qs_id',$qs_id)->select('qs_body')->first();
            $body = '';//isset($qb->qs_body) ? $qb->qs_body : '';

            return response()->json([
                'description'=>$description, 
                'image'=>$image, 
                'body'=>$body, 
                'checklists'=>$checklists, 
                'url'=> $url
            ]);
        }
    }

    public function check_progress(Request $request)
    {
        $progress = $this->check_user_progress();
        $percent = isset($progress->percent) ? $progress->percent : 0;

        //assign color
        if($percent>65 && $percent<=100){
            $color = '#89cff0'; //baby blue
        }else if($percent>=32 && $percent<=65){
            $color = '#BAB86C'; //olive green
        }else{
            $color = '#ff5349'; //red orange
        }

        return response()->json([
            'percent'=>$percent, 
            'color'=>$color
        ]);
    }

    private function check_user_progress()
    {
        $uid = Session::get('user_id');
        $userq = []; //user quickstart
        $quickstarts = Quickstart::select('id')->orderBy('id','asc')->get();

        $co = DB::table('companies')
                ->select('company_id','company_name','timezone','date_format','time_format','first_day')
                ->where('user_id',$uid)
                ->first();

        $companyId = isset($co->company_id) ? $co->company_id : 0;
        foreach($quickstarts as $q)
        {
            $qid = $q->id;
            switch($qid)
            {
                // Setup your company profile
                case 1:
                    if($companyId>0)
                    {
                        $userq[$qid]['company'] = $co->company_name!='' ? 1 : 0;
                        $userq[$qid]['timezone'] = $co->timezone!='' ? 1 : 0;
                        $userq[$qid]['date_format'] = $co->date_format!='' ? 1 : 0;
                        $userq[$qid]['time_format'] = $co->time_format!='' ? 1 : 0;
                        $userq[$qid]['first_day'] = $co->first_day!='' ? 1 : 0;
                        
                        $phone_numbers = DB::table('company_number')
                                        ->where('company_number','!=','')
                                        ->where('company_id',$companyId)
                                        ->count();
                        $userq[$qid]['phone_numbers'] = $phone_numbers>0 ? 1 : 0;

                        $emails = DB::table('company_email')
                                    ->where('company_email','!=','')
                                    ->where('company_id',$companyId)
                                    ->count();
                        $userq[$qid]['emails'] = $emails>0 ? 1 : 0;

                        $hours = DB::table('company_hours')
                                ->where('day','!=','')
                                ->where('start_time','!=','')
                                ->where('end_time','!=','')
                                ->where('company_id',$companyId)
                                ->count();
                        $userq[$qid]['hours'] = $hours>0 ? 1 : 0;

                        $location = DB::table('company_location')
                                    ->where('location_address','!=','')
                                    ->where('company_id',$companyId)
                                    ->count();
                        $userq[$qid]['location'] = $location>0 ? 1 : 0;

                        $set = false;
                        foreach($userq as $qid=>$arr)
                        {
                            foreach($arr as $key=>$v)
                            {
                                if($v==1)
                                {
                                    $userq[$qid]['status'] = 1;
                                    $set = true;
                                    break;
                                }
                            }

                            if($set){
                                break;
                            }
                        }

                    }
                break;
                // Add your company users
                case 2:
                    if($companyId>0)
                    {
                        $users = DB::table('company_users')
                                    ->where('company_id',$companyId)
                                    ->count();
                        $userq[$qid]['users'] = $users>0 ? 1 : 0;
                        $userq[$qid]['status'] = $users>0 ? 1 : 0;
                    }
                break;
                // Add your monthly overhead  
                case 3:
                    if($companyId>0)
                    {
                        $overhead = DB::table('company_monthly_overhead')
                                    ->where('expense_name','!=','')
                                    ->where('expense_amount','!=','')
                                    ->where('company_id',$companyId)
                                    ->count();
                        $userq[$qid]['overhead'] = $overhead>0 ? 1 : 0;
                        $userq[$qid]['status'] = $overhead>0 ? 1 : 0;
                    }
                break;
                // Add your first lead  
                case 4:
                    if($companyId>0)
                    {
                        $leads = DB::table('company_leads')
                                    ->where('lead_id','!=','')
                                    ->where('company_id',$companyId)
                                    ->count();
                        $userq[$qid]['leads'] = $leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = $leads>0 ? 1 : 0;
                    }
                break;
                // Add your products and services 
                case 5:
                    if($companyId>0)
                    {
                        // $products = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['products'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break; 
                // Setup your smart estimates 
                case 6:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['estimates'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break; 
                // Connect your calendars 
                case 7:
                        $calendars = DB::table('appointment')
                                    ->where('created_by',$uid)
                                    ->count();
                        $userq[$qid]['calendars'] = $calendars>0 ? 1 : 0;
                        $userq[$qid]['status'] = $calendars>0 ? 1 : 0;
                break; 
                // Connect your financials tracker 
                case 8:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['financial'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Connect your Quickbooks
                case 9:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['quickbooks'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Connect your email 
                case 10:
                        $email = DB::table('inbox_gapi')
                                    ->where('user_id',$uid)
                                    ->count();
                        $userq[$qid]['email'] = $email>0 ? 1 : 0;
                        $userq[$qid]['status'] = $email>0 ? 1 : 0;
                break;
                // Connect your text messaging
                case 11:
                    if($companyId>0)
                    {
                        // $text_messaging = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['text_messaging'] = 0;//$text_messaging>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Connect your social media 
                case 12:
                    if($companyId>0)
                    {
                        // $social_media = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['social_media'] = 0;//$social_media>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Receive online payments from your customers
                case 13:
                    if($companyId>0)
                    {
                        // $online_payments = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['online_payments'] = 0;//$online_payments>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Setup your SMS and Email automation
                case 14:
                    if($companyId>0)
                    {
                        // $sms_email_auto = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['sms_email_auto'] = 0;//$sms_email_auto>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Setup your company's magazine and postcards
                case 15:
                    if($companyId>0)
                    {
                        // $postcards = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['postcards'] = 0;//$postcards>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Setup your online marketing 
                case 16:
                    if($companyId>0)
                    {
                        // $marketing = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['marketing'] = 0;//$marketing>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Add your engineers 
                case 17:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['engineers'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Add your subcontractors  
                case 19:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['subcontractors'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Add your project photos to gallery   
                case 20:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['photos'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Review your jobsite checklists   
                case 21:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['jobsites'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Create your first proposal 
                case 22:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['proposals'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Create your first job
                case 23:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['jobs'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;//$users>0 ? 1 : 0;
                    }
                break;
                // Download the Buildovate app
                case 24:
                    if($companyId>0)
                    {
                        // $estimates = DB::table('company_leads')
                        //             ->where('lead_id','!=','')
                        //             ->where('company_id',$companyId)
                        //             ->count();
                        $userq[$qid]['app'] = 0;//$leads>0 ? 1 : 0;
                        $userq[$qid]['status'] = 0;// $users>0 ? 1 : 0;
                    }
                break; 
            }
        }//end of loop

        // echo "<pre>";
        // print_r($userq);
        // exit();
        
        //get percent
        $total = 0;
        $completed = 0;
        foreach ($userq as $qid => $arr) 
        {
            foreach($arr as $k=>$v)
            {
                if($v==1)
                {
                    $completed++;
                }
                $total++;
            }
        }

        $percent = ($completed>0) ? ( $completed / $total ) * 100 : 0;

        //save
        $uq = UsersQuickstart::where('user_id',Session::get('user_id'))->first();
        if(isset($uq->id))
        {
            UsersQuickstart::where('id',$uq->id)
            ->update([
                'percentage' => $percent,
                'quickstarts'=> serialize($userq)
            ]);

        }else{

             UsersQuickstart::insert([
                'user_id' => Session::get('user_id'),
                'percentage' => $percent,
                'quickstarts'=> serialize($userq),
                'created_at'=> date('Y-m-d H:i:s')
             ]);
        }

        return (object)['percent'=>number_format($percent,0), 'user_quickstart'=>$userq];
    }

}
