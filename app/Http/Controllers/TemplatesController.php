<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TemplatesController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Templates',
            ['pageTitle' => "Templates"]);
    }

    public function proposalDefault(Request $request){
        $data = [
            'DISPLAY_NAME' => $request->input('DISPLAY_NAME', '[ DISPLAY_NAME ]'),
            'CUSTOMER_PHONE' => $request->input('CUSTOMER_PHONE', '[ CUSTOMER_PHONE ]'),
            'DATE_PRINTED' => $this->currentDate(),
            'JOBSITE_ADDRESS' => $request->input('JOBSITE_ADDRESS', '[ JOBSITE_ADDRESS ]'),
            'JOBSITE_CITY' => $request->input('JOBSITE_CITY', '[ JOBSITE_CITY ]'),
            'JOBSITE_STATE' => $request->input('JOBSITE_STATE', '[ JOBSITE_STATE ]'),
            'JOBSITE_ZIPCODE' => $request->input('JOBSITE_ZIPCODE', '[ JOBSITE_ZIPCODE ]'),
            'COMPANY_LICENSE' => $request->input('COMPANY_LICENSE', '[ COMPANY_LICENSE ]'),
            'COMPANY_ADDRESS' => $request->input('COMPANY_ADDRESS', '[ COMPANY_ADDRESS ]'),
            'COMPANY_CITY' => $request->input('COMPANY_CITY', '[ COMPANY_CITY ]'),
            'COMPANY_STATE' => $request->input('COMPANY_STATE', '[ COMPANY_STATE ]'),
            'COMPANY_ZIPCODE' => $request->input('COMPANY_ZIPCODE', '[ COMPANY_ZIPCODE ]'),
            'COMPANY_EMAIL' => $request->input('COMPANY_EMAIL', '[ COMPANY_EMAIL ]'),
            'COMPANY_NUMBER' => $request->input('COMPANY_NUMBER', '[ COMPANY_NUMBER ]'),
            'COMPANY_WEBSITE' => $request->input('COMPANY_WEBSITE', '[ COMPANY_WEBSITE ]'),
            // 'ITEMS' => $request->input('ITEMS', '[ ITEMS ]'),
        ];

        $front_page = view('templates.proposal_default.front_page', $data)->render();
        $table_of_content = view('templates.proposal_default.table_of_content', $data)->render();
        $scope_of_work = view('templates.proposal_default.scope_of_work', $data)->render();
        $related_photos = view('templates.proposal_default.related_photos', $data)->render();
        $terms_and_condition = view('templates.proposal_default.terms_and_condition', $data)->render();
        $terms_and_condition_2 = view('templates.proposal_default.terms_and_condition_2', $data)->render();
        $terms_and_condition_3 = view('templates.proposal_default.terms_and_condition_3', $data)->render();
        $payment_schedule = view('templates.proposal_default.payment_schedule', $data)->render();
        $feedbacks = view('templates.proposal_default.feedbacks', $data)->render();
        $contract = view('templates.proposal_default.contract', $data)->render();
        $insurance = view('templates.proposal_default.insurance', $data)->render();

        return [$front_page, $table_of_content, $scope_of_work, $related_photos, $terms_and_condition, $terms_and_condition_2, $terms_and_condition_3, $payment_schedule, $feedbacks, $contract, $insurance];
    }

    public function currentDate(){
        return (new \DateTime())->format('Y-m-d');
    }    
}
