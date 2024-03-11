<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\PlaidServerController;
use App\Http\Controllers\JobsiteController;
use App\Http\Controllers\UserWorkloadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\CostItemController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProUserController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TemplatesController;
use App\Http\Controllers\WorkOrderContoller;
use App\Http\Controllers\ProductionController;


use App\Events\PrivateMessageEvent;
use App\Events\PublicMessageEvent;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware('auth:sanctum')->get('/getLeadsForUser', [LeadController::class, 'getLeadsForUser']);
Route::middleware('auth:sanctum')->get('/getLeadsForModal', [LeadController::class, 'getLeadsForModal']);
Route::middleware('auth:sanctum')->get('/getLeadDetails/{id?}', [LeadController::class, 'getLeadDetails']);
Route::middleware('auth:sanctum')->post('/saveCustomer', [CustomerController::class, 'create']);
Route::middleware('auth:sanctum')->post('/updateCustomer/{id?}', [CustomerController::class, 'update']);
Route::middleware('auth:sanctum')->get('/getCustomers', [CustomerController::class, 'getAllCustomer']);
Route::middleware('auth:sanctum')->post('/saveLead', [LeadController::class, 'createLead']);
Route::middleware('auth:sanctum')->post('/updateLead/{id?}', [LeadController::class, 'update']);
Route::middleware('auth:sanctum')->post('/deleteLead/{id?}', [LeadController::class, 'delete']);
Route::middleware('auth:sanctum')->get('/getLeadProposals/{id?}', [LeadController::class, 'getLeadProposals']);
Route::middleware('auth:sanctum')->get('/getLeadsGroupedByStage', [LeadController::class, 'getLeadsGroupedByStage']);
Route::middleware('auth:sanctum')->patch('/leads/{lead}/stage', [LeadController::class, 'updateStage']);


Route::middleware('auth:sanctum')->post('/updateProposal/{id?}', [ProposalController::class, 'updateProposal']);
// Route::middleware('auth:sanctum')->get('/getProposalItems/{id?}', [ProposalController::class, 'getProposalItems']);
Route::middleware('auth:sanctum')->get('/getProposalPaymentRequest/{id?}', [ProposalController::class, 'getProposalPaymentRequest']);
// Route::middleware('auth:sanctum')->get('/getProposals', [ProposalController::class, 'getProposals']);
Route::middleware('auth:sanctum')->get('/getProposalByJobsiteId/{id?}', [ProposalController::class, 'getProposalByJobsiteId']);

//LEAD
Route::prefix('leads')->middleware('auth:sanctum')->group(function () {
    Route::get('', [LeadController::class, 'getAll']);
    Route::get('getLeadTitleVersion ', [LeadController::class, 'getLeadTitleVersion']);
});

//CALENDAR
Route::prefix('calendar')->middleware('auth:sanctum')->group(function () {
    Route::get('getData', [CalendarController::class, 'getData']);
    Route::get('getLib', [CalendarController::class, 'getLib']);
});

//PROPOSALS
Route::prefix('proposals')->middleware('auth:sanctum')->group(function () {
    Route::get('', [ProposalController::class, 'getAll']);
    Route::get('/items/{id?}', [ProposalController::class, 'getProposalItems']);
    Route::get('/email/{id?}', [ProposalController::class, 'getEmail']);
    Route::post('', [ProposalController::class, 'createProposal']);
    Route::post('/data/{id?}', [ProposalController::class, 'updateProposalData']);
    Route::post('/email/{id?}', [ProposalController::class, 'addEmail']);
    Route::delete('/{id}', [ProposalController::class, 'delete']);
});
Route::get('customer-proposals/{id?}', [ProposalController::class, 'getAllByLead']);
Route::get('proposal/{id?}', [ProposalController::class, 'getProposal']);
Route::put('proposal/update/{id?}', [ProposalController::class, 'updateProposalData']);
Route::put('proposal/email/{id?}', [ProposalController::class, 'updateEmail']);
Route::prefix('work-orders')->middleware('auth:sanctum')->group(function () {
    Route::get('all/{id}', [WorkOrderContoller::class, 'getAll']);
    Route::get('/{id}', [WorkOrderContoller::class, 'get']);
    Route::post('', [WorkOrderContoller::class, 'add']);
    Route::put('/{id}', [WorkOrderContoller::class, 'edit']);
    Route::delete('/{id}', [WorkOrderContoller::class, 'delete']);
});

//USERS
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('', [UserController::class, 'getAll']);
});

//ALL CONTACTS
Route::prefix('userContacts')->middleware('auth:sanctum')->group(function () {
    Route::get('', [UserController::class, 'getAllContacts']);
});

//TAGS
Route::prefix('tags')->middleware('auth:sanctum')->group(function () {
    Route::get('', [TagController::class, 'getAll']);
    Route::post('', [TagController::class, 'add']);
    Route::put('/{id}', [TagController::class, 'edit']);
    Route::delete('/{id}', [TagController::class, 'delete']);
});

//LEAD SOURCE
Route::prefix('sources')->middleware('auth:sanctum')->group(function () {
    Route::get('', [SourceController::class, 'getAll']);
    Route::post('', [SourceController::class, 'add']);
    Route::put('/{id}', [SourceController::class, 'edit']);
    Route::delete('/{id}', [SourceController::class, 'delete']);
});

//JOB TYPE
Route::prefix('jobTypes')->middleware('auth:sanctum')->group(function () {
    Route::get('', [JobTypeController::class, 'getAll']);
    Route::post('', [JobTypeController::class, 'add']);
    Route::put('/{id}', [JobTypeController::class, 'edit']);
    Route::delete('/{id}', [JobTypeController::class, 'delete']);
});

//COST ITEM
Route::prefix('costItems')->middleware('auth:sanctum')->group(function () {
    Route::get('', [CostItemController::class, 'getAll']);
    Route::get('/{id}', [CostItemController::class, 'get']);
    Route::get('/export', [CostItemController::class, 'export']);
    Route::post('', [CostItemController::class, 'add']);
    Route::post('/import', [CostItemController::class, 'import']);
    Route::put('/{id}', [CostItemController::class, 'edit']);
    Route::delete('/{id}', [CostItemController::class, 'delete']);
});

//Jobsites
Route::prefix('jobsites')->middleware('auth:sanctum')->group(function () {
    Route::get('', [JobsiteController::class, 'getJobsites']);
    Route::get('/transactions', [JobsiteController::class, 'getJobsiteTransactions']);
    Route::post('', [JobsiteController::class, 'saveJobsite']);
    Route::post('/transactions', [JobsiteController::class, 'addTransactions']);
});

//Estimates
Route::prefix('estimates')->middleware('auth:sanctum')->group(function () {
    Route::get('', [EstimateController::class, 'getAll']);
    Route::get('/{id}', [EstimateController::class, 'get']);
    Route::post('', [EstimateController::class, 'add']);
    Route::put('/{id}', [EstimateController::class, 'edit']);
    Route::put('/favorite/{id}', [EstimateController::class, 'changeFavorite']);
    Route::delete('/{id}', [EstimateController::class, 'delete']);
});

Route::prefix('todo')->middleware('auth:sanctum')->group(function () {
    Route::get('', [TodoController::class, 'getTodo']);
    Route::post('', [TodoController::class, 'saveTodo']);
    Route::put('/{id}', [TodoController::class, 'updateTodo']);
    Route::put('/mark/{id}', [TodoController::class, 'markTodo']);
    Route::delete('/{id}', [TodoController::class, 'removeTodo']);

    Route::post('/getActivities', [TodoController::class, 'getActivities']);
    Route::post('/saveActivity', [TodoController::class, 'saveActivity']);
    Route::post('/deleteActivity', [TodoController::class, 'deleteActivity']);

    Route::post('/search-members', [TodoController::class, 'searchMembers']);
    Route::post('/save-member', [TodoController::class, 'saveMember']);

    Route::post('/upload', [TodoController::class, 'upload']);
    Route::post('/getAllUploads', [TodoController::class, 'getAllUploads']);
    Route::post('/deleteUpload', [TodoController::class, 'deleteUpload']);
    
    Route::post('/saveListTodo', [TodoController::class, 'saveListTodo']);
    
    Route::post('/getLabels', [TodoController::class, 'getLabels']);
    Route::post('/saveTodoLabels', [TodoController::class, 'saveTodoLabels']);

});

Route::prefix('pro_users')->middleware('auth:sanctum')->group(function () {
    Route::get('', [ProUserController::class, 'search']);
    Route::post('', [ProUserController::class, 'saveProUser']);
});

//timeline
Route::prefix('timeline')->middleware('auth:sanctum')->group(function () {
    Route::get('fetch', [TimelineController::class, 'fetch']);
    Route::post('store', [TimelineController::class, 'store']);
    Route::post('update', [TimelineController::class, 'update']);
    Route::post('destroy', [TimelineController::class, 'destroy']);
});

//FILE UPLOAD 
Route::middleware('auth:sanctum')->post('/upload', [FilesController::class, 'saveUserUploadFile']);

//PLAID API's
Route::prefix('plaid')->middleware('auth:sanctum')->group(function () {
    Route::get('', [PlaidServerController::class, 'index']);
    Route::post('/save_access_token', [PlaidServerController::class, 'saveAccessToken']);
    Route::post('/create_link_token', [PlaidServerController::class, 'createLinkToken']);
    Route::post('/exchange_public_token', [PlaidServerController::class, 'exchangePublicToken']);
    Route::post('/transaction_sync', [PlaidServerController::class, 'transactionSync']);
});

Route::middleware('auth:sanctum')->get('/userworkloads', [UserWorkloadController::class, 'getAll']);
Route::middleware('auth:sanctum')->post('/userworkloads', [UserWorkloadController::class, 'add']);
Route::middleware('auth:sanctum')->put('/userworkloads/{id}', [UserWorkloadController::class, 'edit']);
Route::middleware('auth:sanctum')->put('/userworkloads/invite/{id}', [UserWorkloadController::class, 'invite']);
Route::middleware('auth:sanctum')->put('/userworkloads/approve/{id}', [UserWorkloadController::class, 'approve']);
Route::middleware('auth:sanctum')->put('/userworkloads/approveAll/{user_id}', [UserWorkloadController::class, 'approveAll']);
Route::middleware('auth:sanctum')->put('/userworkloads/complete/{id}', [UserWorkloadController::class, 'complete']);
Route::middleware('auth:sanctum')->put('/userworkloads/inviteAll/{user_id}', [UserWorkloadController::class, 'inviteAll']);
Route::middleware('auth:sanctum')->delete('/userworkloads/{proposal_item_id}/{user_id}', [UserWorkloadController::class, 'delete']);


Route::get('/proposal-template-default', [TemplatesController::class, 'proposalDefault']);
Route::middleware('auth:sanctum')->post('/send', [EmailController::class, 'send']);

Route::middleware('auth:sanctum')->get('/getProposalsGroupedByStage', [ProductionController::class, 'getProposalsGroupedByStage']);
Route::middleware('auth:sanctum')->patch('/proposals/{proposal}/stage', [ProductionController::class, 'updateStage']);

// Important Note -
// Publishing message through laravel to ably allows request throttling, and filtering + persistent storage for messages.
// Public channel allows to publish messages only through laravel to ably.
// Private/Presence channels allows to send/publish messages in two ways 
// 1. Through laravel to ably [ echo-client1 -> laravel -> ably -> echo-client2, echo-client3, echo-client4... ]
// 2. Through client-events [ echo-client1 -> ably -> echo-client2, echo-client3, echo-client4... ]
// Publishing via client-events is faster than through laravel, since there is no intermediate party involved.
// Read more about client-events => https://laravel.com/docs/broadcasting#client-events

// Public broadcast for a guest user.
// Throttle to 60 requests/1 minute per ip address.
// This is generally to prevent DOS attack/message spamming on public channels.
// If using reverse proxy, make sure to configure IP properly, since all incoming requests will have same IP address.
// https://dev.to/aliadhillon/new-simple-way-of-creating-custom-rate-limiters-in-laravel-8-65n.
Route::post('/public-event', function (Request $request) {
    $channelName = $request->post('channelName');
    $message = $request->post('message');
    broadcast(new PublicMessageEvent( $channelName, $message ));
})->middleware('throttle:60,1'); // 60 requests/minute are allowed.

// Private broadcast for an authenticated user.
// If request throttling is enabled, it will be per user session instead of ip adddress.
// This route is currently unused, client-events are used instead.
Route::post('/private-event', function (Request $request) {
    $channelName = $request->post('channelName');
    $message = $request->post('message');
    if($request->input('to_others')) {
        broadcast(new PrivateMessageEvent($channelName, $message))->toOthers();
    } else {
        broadcast(new PrivateMessageEvent($channelName, $message));
    }
})->middleware('auth'); // Only authenticated users are allowed (https://laravel.com/docs/authentication#protecting-routes)
