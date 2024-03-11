<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function saveOrEdit($request)
    {
        $cx = Customer::find($request['cusId']);
        $cx->first_name = $request['cusName'];
        $cx->last_name = $request['cusLastName'];
        $cx->display_name = $request['cusDisplayName'];
        $cx->email = $request['cusEmail'];
        $cx->street_address = $request['cusAddress'];
        $cx->city = $request['cusCity'];
        $cx->state = $request['cusState'];
        $cx->zip_code = $request['cusZip'];
        $cx->save();

        return $cx;
    }
}