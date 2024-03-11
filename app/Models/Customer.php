<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

use App\Models\CustomersEmail;
use App\Models\CustomersPhoneNumber;
use App\Models\CustomersRelationship;

class Customer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';  

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cust_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // Since you have a custom `created_on` and no updated_on field
    const CREATED_AT = 'created_on';
    const UPDATED_AT = null; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logout',
        'company_id',
        'first_name',
        'last_name',
        'password', // Be careful when dealing with password fields. You may want to make this unfillable and handle it separately.
        'display_name',
        'street_address',
        'city',
        'state',
        'zip_code',
        'phone',
        'cell_phone',
        'email',
        'company',
        'created_on' // You may or may not want this to be fillable. Consider using Laravel's automatic timestamps instead.
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    /**
     * Get the name of the "created at" column.
     *
     * @return string
     */
    public function getCreatedAtColumn()
    {
        return 'created_on';
    }

    public static function saveOrUpdateContactInfo($request)
    {
        $cust_id = $request->get('cust_id');
        $phone_numbers = $request->get('phone_numbers');
        $emails = $request->get('emails');
        // $success = false;
        if(is_numeric($cust_id) && (count($phone_numbers)>0 || count($emails)>0))
        {

            if(count($phone_numbers)>0)
            {
            
                foreach ($phone_numbers as $key => $arr)
                {
                    $phone_number = trim($arr['phone_number']);

                    $data = [
                        'phone_number' => $phone_number,
                        'label' => $arr['label'],
                        'is_bad_number' => $arr['is_bad_number']
                    ];

                    //check 
                    $check = CustomersPhoneNumber::select('id')->where('cust_id',$cust_id)
                             ->where('phone_number',$phone_number)
                             ->first();
                    if(isset($check->id))
                    {
                        //update
                        $data['updated_by'] = Session::get('user_id');
                        $data['created_at'] = date('Y-m-d H:i:s');
                        CustomersPhoneNumber::where('id',$check->id)->update($data);
                    }else{
                        //save
                        $data['cust_id'] = $cust_id;
                        $data['created_by'] = Session::get('user_id');
                        $data['created_at'] = date('Y-m-d H:i:s');
                        CustomersPhoneNumber::insert($data);
                    }
                }
            }


            if(count($emails)>0)
            {
            
                foreach ($emails as $key => $email)
                {
                    $email = strtolower(trim($email));

                    $data = [
                        'email' => $email
                    ];

                    //check 
                    $check = CustomersEmail::select('id')->where('cust_id',$cust_id)
                             ->where('email',$email)
                             ->first();
                    if(isset($check->id))
                    {
                        //update
                        $data['updated_by'] = Session::get('user_id');
                        CustomersEmail::where('id',$check->id)->update($data);
                    }else{
                        //save
                        $data['cust_id'] = $cust_id;
                        $data['created_by'] = Session::get('user_id');
                        $data['created_at'] = date('Y-m-d H:i:s');
                        CustomersEmail::insert($data);
                    }
                }
            }

        }
        // $success = CustomersPhoneNumber::
        return response()->json(['success' => true]);
    }

    public static function saveOrUpdateRelationship($request)
    {
        $cust_id = $request->get('cust_id');
        $relation = $request->get('relation');
        $phone_numbers = $request->get('phone_numbers');
        $emails = $request->get('emails');
        // $success = false;
        if(is_numeric($cust_id) && $relation['first_name']!='' && $relation['last_name']!='')
        {
            $data = [
                'first_name' => $relation['first_name'],
                'last_name' => $relation['last_name'],
                'relationship' => $relation['relationship'],
            ];
            //check 
            $rel = CustomersRelationship::select('id')
                   ->where('cust_id',$cust_id)
                   ->where('first_name',$relation['first_name'])
                   ->where('last_name',$relation['last_name'])
                   ->where('relationship',$relation['relationship'])
                   ->first();
            $rel_id = 0;
            if(isset($rel->id))
            {
                //update
                $rel_id = $rel->id;
                $data['updated_by'] = Session::get('user_id');
                CustomersRelationship::where('id',$rel_id)->update($data);

            }else{

                //create
                $data['cust_id'] = $cust_id;
                $data['created_by'] = Session::get('user_id');
                $data['created_at'] = date('Y-m-d H:i:s');
                $rel_id = CustomersRelationship::insertGetId($data);
            }

            if($rel_id>0 && count($phone_numbers)>0)
            {
            
                foreach ($phone_numbers as $key => $arr)
                {
                    $phone_number = trim($arr['phone_number']);

                    $data = [
                        'phone_number' => $phone_number,
                        'label' => $arr['label'],
                        'is_bad_number' => $arr['is_bad_number'],
                        'rel_id'=>$rel_id
                    ];

                    //check 
                    $check = CustomersPhoneNumber::select('id')->where('cust_id',$cust_id)
                             ->where('phone_number',$phone_number)
                             ->first();
                    if(isset($check->id))
                    {
                        //update
                        $data['updated_by'] = Session::get('user_id');
                        $data['created_at'] = date('Y-m-d H:i:s');
                        CustomersPhoneNumber::where('id',$check->id)->update($data);
                    }else{
                        //save
                        $data['cust_id'] = $cust_id;
                        $data['created_by'] = Session::get('user_id');
                        $data['created_at'] = date('Y-m-d H:i:s');
                        CustomersPhoneNumber::insert($data);
                    }
                }
            }


            if($rel_id>0 && count($emails)>0)
            {
            
                foreach ($emails as $key => $email)
                {
                    $email = strtolower(trim($email));

                    $data = [
                        'email' => $email,
                        'rel_id'=>$rel_id
                    ];

                    //check 
                    $check = CustomersEmail::select('id')->where('cust_id',$cust_id)
                             ->where('email',$email)
                             ->first();
                    if(isset($check->id))
                    {
                        //update
                        $data['updated_by'] = Session::get('user_id');
                        CustomersEmail::where('id',$check->id)->update($data);
                    }else{
                        //save
                        $data['cust_id'] = $cust_id;
                        $data['created_by'] = Session::get('user_id');
                        $data['created_at'] = date('Y-m-d H:i:s');
                        CustomersEmail::insert($data);
                    }
                }
            }

        }
        // $success = CustomersPhoneNumber::
        return response()->json(['success' => true]);
    }
}
