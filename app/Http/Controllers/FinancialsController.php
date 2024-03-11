<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FinancialsController extends Controller
{
    public function index(Request $request)
    {
        $plaid_access_token = Session::get('plaid_access_token');
        return Inertia::render('Financials',
            ['pageTitle' => "Financials", 'accessToken' => $plaid_access_token]);
    }

    public function expense_tracking(Request $request)
    {
        $plaidToken = $request->session()->get('plaid_access_token');
        return Inertia::render('financials/ExpenseTracking', [
            'pageTitle' => "Expense Tracking",
            'plaidToken' => $plaidToken
        ]);
    }

    public function accounts_receivable(Request $request)
    {
        return Inertia::render('financials/AccountsReceivable',
            ['pageTitle' => "Accounts Receivable"]);
    }

    public function accounts_payable(Request $request)
{
        return Inertia::render('financials/AccountsPayable',
            ['pageTitle' => "Accounts Payable"]);
    }

    public function budget(Request $request)
    {
        return Inertia::render('financials/Budget',
            ['pageTitle' => "Budget"]);
    }

    public function stage_payments(Request $request)
    {
        return Inertia::render('financials/StagePayments',
            ['pageTitle' => "Stage Payments"]);
    }

    public function payments_report(Request $request)
    {
        return Inertia::render('financials/PaymentsReport',
            ['pageTitle' => "Payments Report"]);
    }

}