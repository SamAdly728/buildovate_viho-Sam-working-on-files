<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use App\Models\Customer;
use App\Models\CustomersEmail;
use App\Models\CustomersPhoneNumber;
use App\Models\CustomersAddress;
use App\Models\CustomersRelationship;

class CustomersController extends Controller
{
    private $cx;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->cx = $customerRepository;
    }
    public function add(Request $request)
    {
        $status = '';
        $check = Customer::where('email',$request->email)->count();
        if($check==0)
        {

            Customer::insert([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'display_name' => $request->display_name,
                'company' => $request->company,
                'street_address' => $request->address,
                'state' => $request->state,
                'zip_code' => $request->zipcode,
                'city' => $request->city,
                'password' => '-',
                'created_on' => date('Y-m-d H:i:s')
            ]);

            $status = 'added';
        }
        
        return response()->json([
            'status' => $status
        ]);
    }

    public function get_customer(Request $request)
    {
        $status = '';
        $phone_numbers = [];
        $emails = [];
        $relationships = [];
        $customer = Customer::where('email',$request->email)->first(); 
        if(isset($customer->cust_id))
        {
            $status = 'ok';
            //get phone numbers
            $phone_numbers = CustomersPhoneNumber::select('id','phone_number','label','is_bad_number')->where('rel_id',0)->where('cust_id',$customer->cust_id)->get();
            //get phone numbers
            $emails = CustomersEmail::select('id','email')->where('rel_id',0)->where('cust_id',$customer->cust_id)->get();
            //get relationships
            $get_relationships = CustomersRelationship::select('id','cust_id','first_name','last_name','relationship')->where('cust_id',$customer->cust_id)->get();

            if($get_relationships)
            {
                foreach($get_relationships as $r)
                {
                    $relationships[] = [
                        'relation' => $r,
                        'phone_numbers' => CustomersPhoneNumber::select('id','phone_number','label','is_bad_number')->where('rel_id',$r->id)->where('cust_id',$r->cust_id)->get(),
                        'emails' => CustomersEmail::select('id','email')->where('rel_id',$r->id)->where('cust_id',$r->cust_id)->get(),
                        'addresses' => CustomersAddress::where('rel_id',$r->id)->where('cust_id',$r->cust_id)->get()
                    ];
                }
            }
        }

        return response()->json([
            'status' => $status,
            'customer' => $customer,
            'phone_numbers' => $phone_numbers,
            'emails' => $emails,
            'relationships' => $relationships
        ]);
    }

    public function save_edit_customer_info(Request $request)
    {
        return $this->cx->saveOrEdit($request->all());
    }

    public function save_contact_info(Request $request)
    {
        return Customer::saveOrUpdateContactInfo($request);
    }

    public function save_relationship(Request $request)
    {
        return Customer::saveOrUpdateRelationship($request);
    }

    public function save_address(Request $request)
    {
        return Customer::saveOrUpdateAddress($request);
    }

    public function save_details(Request $request){
       
        return response()->json(['data' => '']);
    }

    public function remove_phone_number($id, Request $request)
    {
        $success = CustomersPhoneNumber::where('id',$id)
                   ->where('created_by',Session::get('user_id'))
                   ->delete();
        return response()->json([
            'success' => $success
        ]);
    }

    public function remove_email($id, Request $request)
    {
        $success = CustomersEmail::where('id',$id)
                   ->where('created_by',Session::get('user_id'))
                   ->delete();
        return response()->json([
            'success' => $success
        ]);
    }

    public function remove_address($id, Request $request)
    {
        $success = CustomersAddress::where('id',$id)
                   ->where('created_by',Session::get('userId'))
                   ->delete();
        return response()->json([
            'success' => $success
        ]);
    }

}