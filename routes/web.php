<?php

use App\Http\Controllers\InternalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\FinancialsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WebhooksController;
// use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\FooterLinksController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CRONController;
use App\Http\Controllers\QuickStartController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FollowupDealStageController;
use App\Http\Controllers\FollowupSequenceController;
use App\Http\Controllers\TemplatesController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\FollowupDripController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\FollowupGoogleConnectController;
use Inertia\Inertia;
use App\Models\User;

use Stevenmaguire\OAuth2\Client\Provider\Yelp;




Route::get('/', function () {
    if(Session::get('user_id')>0)
    {
        return Inertia::location('/projects');
    }else{
        return Inertia::render('Login');
    }
})->name('home');

// Route::get('login', function () {
//     return Inertia::render('Login');
// })->name('login');

Route::get('register', function () {
    return Inertia::render('Register');
})->name('register');

Route::post('auth/login', [LoginController::class,'login']);
Route::get('auth/logout', [LoginController::class,'logout']);
Route::get('portal/', [PortalController::class, 'index']);
Route::get('portal/pros/', [PortalController::class, 'pros']);


Route::group(['middleware' => ['web', 'auth']], function () {

    // Route::get('company', [CompanyController::class,'index'])->name('company');
    // Route::any('projects', [ProjectsController::class,'index'])->name('projects');
    Route::get('getstarted', [CompanyController::class,'getstarted'])->name('getstarted');
    Route::get('main', [CompanyController::class,'main'])->name('main');

    Route::group(['prefix' => 'projects'], function () {
        Route::any('', [ProjectsController::class,'index'])->name('projects');
        Route::get('todo', [ProjectsController::class,'kanban']);
        Route::get('installer-status', [ProjectsController::class,'installer_status']);
        Route::get('schedule', [ProjectsController::class,'schedule']);
        Route::get('receivables', [ProjectsController::class,'receivables']);
        Route::get('payables', [ProjectsController::class,'payables']);
        Route::get('checklists', [ProjectsController::class,'checklists']);
        Route::get('reports', [ProjectsController::class,'reports']);
        Route::get('agreements', [ProjectsController::class,'agreements']);
        Route::get('timelines', [ProjectsController::class,'timelines']);
        Route::get('payments', [ProjectsController::class,'payments']);
    });

    //timeline
    Route::prefix('settings')->middleware('auth:sanctum')->group(function () {
        Route::get('timeline', [TimelineController::class, 'index']);
    });
    
    Route::get('calendar', [CalendarController::class,'index'])->name('calendar');
    Route::get('auth/google', [CalendarController::class, 'redirect']);
    Route::get('auth/google/callback', [CalendarController::class, 'callback']);
    Route::get('google/events', [CalendarController::class, 'getEvents']);
    Route::get('google/disconnect', [CalendarController::class, 'diconnectGoogleCalendar']);

    Route::group(['prefix' => 'admin'], function() {
        Route::get('index', [AdminController::class,'index'])->name('index');
        Route::get('subscription', [AdminController::class,'subscription'])->name('subscription');
        Route::get('permissions-roles', [AdminController::class,'permissionsAndRoles'])->name('permissionsAndRoles');

        Route::get('phone-number-management', [AdminController::class,'phoneNumberManagement']);

        Route::group(['prefix' => 'templates'], function () {
            Route::any('', [TemplatesController::class,'index']);
        });
    });

    Route::get('production', [ProductionController::class,'index']);
    Route::get('files', [FilesController::class,'index']);
    Route::get('financials', [FinancialsController::class,'index']);
    Route::get('internal', [InternalController::class, 'index']);

    // Route::get('todos', [TodoController::class,'index']);
    Route::group(['prefix' => 'todos'], function () {
        Route::get('', [TodoController::class,'index']);
        Route::get('kanban', [TodoController::class,'kanban']);
    });

    Route::prefix('dashboard')->middleware('role:admin')->group( function () {
        Route::get('', [CompanyController::class,'index']);
        Route::get('metrics', [CompanyController::class,'marketing']);
        Route::get('portfolio', [CompanyController::class,'portfolio'])->middleware('role:project_manager,office_manager,dispatcher,accounting,engineer_architect,salesrepresentative');
        Route::post('portfolio/add-folder', [CompanyController::class,'add_folder']);
        Route::post('portfolio/save-folder-name', [CompanyController::class,'save_folder_name']);
        
        Route::get('buildovate-professionals', [CompanyController::class,'buildovate_professionals'])->middleware('role:project_manager,office_manager,engineer_architect,salesrepresentative');
        Route::get('catalog', [CompanyController::class,'catalog']);     
    });

    Route::group(['prefix' => 'company'], function () {        

        Route::get('', [CompanyController::class,'index']);
        
        Route::group(['prefix' => 'details'], function () {
            Route::get('', [CompanyController::class, 'details']);
            Route::get('hours', [CompanyController::class, 'hours']);
            Route::get('overhead', [CompanyController::class, 'overhead']);
            Route::get('numbers', [CompanyController::class, 'numbers']);
            Route::get('emails', [CompanyController::class, 'emails']);
            Route::get('locations', [CompanyController::class, 'locations']);
            Route::get('websites', [CompanyController::class, 'websites']);
            Route::get('socials', [CompanyController::class, 'socials']);
        });
        // Route::get('details/basic', [CompanyController::class,'basic']);
        // Route::get('details/hours', [CompanyController::class,'hours']);

        Route::get('reminders', [CompanyController::class,'reminders']);
        Route::get('settings', [CompanyController::class,'settings']);
        Route::get('templates', [CompanyController::class,'templates']);
        Route::get('follow-up', [CompanyController::class,'followUp']);
        Route::get('reports', [CompanyController::class,'reports']);
        Route::get('marketing', [CompanyController::class,'marketing']);
        Route::get('buildovate-professionals', [CompanyController::class,'buildovate_professionals']);
        Route::get('portfolio', [CompanyController::class,'portfolio']);
        Route::post('portfolio/add-folder', [CompanyController::class,'add_folder']);
        Route::post('portfolio/save-folder-name', [CompanyController::class,'save_folder_name']);

        Route::get('become-a-pro', [CompanyController::class,'become_a_pro']);
        Route::get('portfolio/content/{folderId?}', [CompanyController::class,'portfolio_folder_content']);

        Route::post('marketing/auto-leads/unsubscribe', [CompanyController::class,'marketing_auto_leads_unsubscribe']);

        Route::prefix('users')->middleware('role:admin')->group( function() {
            Route::get('', [CompanyController::class, 'users']);
            Route::post('get-all', [CompanyController::class, 'get_all_users']);
            Route::post('/send-invite', [CompanyController::class, 'users_send_invite']);
            Route::post('users/add-crew', [CompanyController::class, 'users_add_crew']);
            Route::post('revoke-access', [CompanyController::class, 'revoke_user_access']);
            Route::post('/save/payrate', [CompanyController::class, 'save_pay_rate']);
            Route::post('/get/payrate', [CompanyController::class, 'get_user_payrate']);
        });

        Route::group(['prefix' => 'follow-up/deal-stages'], function() {
            Route::get('/', [FollowupDealStageController::class, 'index']);
            Route::get('/show/{id}', [FollowupDealStageController::class, 'show']);
            Route::post('/store', [FollowupDealStageController::class, 'store']);
            Route::put('/update/{id}', [FollowupDealStageController::class, 'update']);
            Route::delete('/delete/{id}', [FollowupDealStageController::class, 'destroy']);
            Route::get('/all', [FollowupDealStageController::class, 'indexAll']);
            
        });

        Route::group(['prefix' => 'follow-up/sequence'], function() {
            Route::get('/', [FollowupSequenceController::class, 'index']);
            Route::get('/show/{id}', [FollowupSequenceController::class, 'show']);
            Route::post('/store', [FollowupSequenceController::class, 'store']);
            Route::put('/update/{id}', [FollowupSequenceController::class, 'update']);
            Route::delete('/delete/{id}', [FollowupSequenceController::class, 'destroy']);
            
        });

        Route::group(['prefix' => 'follow-up/drips'], function() {
            Route::get('/', [FollowupDripController::class, 'index']);
            Route::get('/show/{id}', [FollowupDripController::class, 'show']);
            Route::post('/store', [FollowupDripController::class, 'store']);
            Route::put('/update/{id}', [FollowupDripController::class, 'update']);
            Route::delete('/delete/{id}', [FollowupDripController::class, 'destroy']);
            
        });


        Route::group(['prefix' => 'follow-up/google'], function() {
            Route::get('/', [FollowupGoogleConnectController::class, 'index']);
            Route::any('/callback', [FollowupGoogleConnectController::class, 'handleGoogleCallback']);
        });

        

        


        
        // Route::post('details/overhead', [CompanyController::class, 'saveOrEditMonthlyOverHead']);
        // Route::post('details/delete/overhead', [CompanyController::class, 'deleteOverHead']);
        // Route::post('details/phone-number', [CompanyController::class, 'saveOrEditPhoneNumber']);
        // Route::post('details/delete/phone-number', [CompanyController::class, 'deletePhoneNumber']);
        // Route::post('details/save/email', [CompanyController::class, 'saveEmail']);
        // Route::post('details/delete/email', [CompanyController::class, 'deleteEmail']);
        // Route::post('details/save/address', [CompanyController::class, 'saveAddress']);
        // Route::post('details/delete/address', [CompanyController::class, 'deleteAddress']);
        // Route::post('details/save/website', [CompanyController::class, 'saveWebsite']);
        // Route::post('details/delete/website', [CompanyController::class, 'deleteWebsite']);
        // Route::post('details/save/social-media-url', [CompanyController::class, 'saveOrUpdateSocialMedia']);
        // Route::post('details/update/business-hours', [CompanyController::class, 'updateBusinessHours']);
        // Route::post('details/save/basic-info', [CompanyController::class, 'saveBasicInfo']);
                
    });

    Route::group(['prefix' => 'calendar'], function() {
        Route::post('save-appointment', [CalendarController::class, 'saveAppointment']);
        Route::post('save-file-upload', [CalendarController::class, 'saveFileUpload']);
        Route::get('search-lead', [CalendarController::class, 'searchLead']);
        Route::get('get-upload', [CalendarController::class, 'getUpload']);
    });

    Route::group(['prefix' => 'sales'], function () {
        Route::get('/', [SalesController::class, 'index']);
        Route::get('activities', [SalesController::class,'activities']);
        Route::get('estimator-tool', [SalesController::class,'estimator_tool']);
        Route::get('smart-estimates', [SalesController::class,'smart_estimates']);
        Route::get('change-orders', [SalesController::class,'change_orders']);
        Route::get('catalogs', [SalesController::class,'catalogs']);
        Route::get('map', [SalesController::class,'map']);

        Route::group(['prefix' => 'smart-estimates'], function() {
            Route::get('builder', [SalesController::class, 'estimate_builder']);
            Route::get('import', [SalesController::class, 'import_test']);
            Route::get('builder/{id}', [SalesController::class, 'estimate_builder']);
            Route::get('/', [SalesController::class, 'smart_estimates']);
        });        

        Route::group(['prefix' => 'lead-management'], function() {
            Route::get('/', [SalesController::class, 'lead_list']);
            Route::get('new', [SalesController::class, 'edit_lead']);
            Route::get('view-lead/{id?}', [SalesController::class, 'view_lead']);
            Route::get('edit/{id?}', [SalesController::class, 'edit_lead']);
            Route::get('proposal/{proposal_id?}/{lead_id?}', [SalesController::class, 'proposal']);
            Route::get('change_order/{proposal_id?}/{lead_id?}', [SalesController::class, 'change_order']);
        });
        
        Route::group(['prefix' => 'proposals'], function() {
            Route::get('/', [SalesController::class, 'proposals']);
            Route::get('proposal/{proposal_id?}/{lead_id?}', [SalesController::class, 'proposal']);
            Route::get('change_order/{proposal_id?}/{lead_id?}', [SalesController::class, 'change_order']);
        });

        
    });

    Route::group(['prefix' => 'reports'], function() {
        Route::get('/', [CompanyController::class,'reports']);
        Route::get('lead-management', [ReportsController::class, 'coming_soon']);
        Route::get('sales-report', [ReportsController::class,'coming_soon']);
        Route::get('missing-results', [ReportsController::class,'coming_soon']);
        Route::get('receivables', [ReportsController::class,'coming_soon']);
        Route::get('payables', [ReportsController::class,'coming_soon']);
    });

    Route::group(['prefix' => 'inbox'], function () {
        Route::get('', [InboxController::class,'gmail']);
        Route::post('log-message', [InboxController::class,'log_message']);
        Route::post('get-room-messages', [InboxController::class,'get_room_messages']);

        Route::group(['prefix' => 'facebook'], function() {
            Route::post('get-messages', [InboxController::class, 'getConversationMessages']);
            Route::post('handle-reply', [InboxController::class, 'handleFacebookReply']);
            Route::get('get-facebook-messages-and-threads', [InboxController::class, 'getFacebookMessages']);
        });
        
        //gapi - gmail api 
        Route::group(['prefix' => 'gmail'], function () {
            Route::get('', [InboxController::class,'gmail']);
            Route::get('drafts', [InboxController::class,'gmail_drafts']);
            Route::post('get-mail-totals', [InboxController::class,'gmail_mail_totals']);
            Route::post('messages', [InboxController::class,'gmail_messages']);
            Route::post('list-messages', [InboxController::class,'gmail_list_messages']);
            Route::post('get-message', [InboxController::class,'gmail_get_message']);
            Route::post('get-thread', [InboxController::class,'gmail_get_thread']);
            Route::post('send-message', [InboxController::class,'gmail_send_message']);
            Route::post('draft-message', [InboxController::class,'gmail_draft_message']);
            Route::get('get-gmail-messages-and-thread', [InboxController::class, 'getGmailMessages']);
        });

        Route::group(['prefix' => 'settings'], function () {
            Route::get('', [InboxController::class,'settings']);
            Route::get('set-status', [InboxController::class,'settings_set_status']);
            Route::get('disconnect-gmail', [InboxController::class,'disconnectGmail']);
            Route::get('new', [InboxController::class,'settings_new']);
            Route::get('edit/{id}', [InboxController::class,'settings_edit']);
            Route::post('save-team-inbox', [InboxController::class,'settings_save_team_box']);
            Route::get('fb-login', [InboxController::class, 'loginToFB']);
            Route::get('fb-handle-callback', [InboxController::class, 'handleFacebookCallback']);
            Route::get('fb-handle-disconnect', [InboxController::class, 'disconnectFacebook']);
            Route::get('yelp-login', [InboxController::class, 'loginToYelp']);
            Route::get('yelp-handle-callback', [InboxController::class, 'handleYelpCallback']);
        });
        
        Route::get('text-messages', [InboxController::class,'text_messages']);
        Route::get('instagram', [InboxController::class,'instagram']);
        Route::get('fb-messenger', [InboxController::class,'fb_messenger']);
        Route::get('yelp', [InboxController::class,'yelp']);
        Route::get('website-live-chat', [InboxController::class,'website_live_chat']);
        Route::get('whatsapp', [InboxController::class,'whatsapp']);

    });
    
    Route::group(['prefix' => 'customers'], function () {
        Route::post('add', [CustomersController::class,'add']);
        Route::post('get-customer', [CustomersController::class,'get_customer']);
        Route::post('save-or-edit', [CustomersController::class,'save_edit_customer_info']);
        Route::post('save-contact-info', [CustomersController::class,'save_contact_info']);
        Route::post('save-relationship', [CustomersController::class,'save_relationship']);
        Route::post('save-details', [CustomersController::class,'save_details']);
        Route::delete('remove-phone-number/{id}', [CustomersController::class,'remove_phone_number']);
        Route::delete('remove-email/{id}', [CustomersController::class,'remove_email']);
        Route::delete('remove-address/{id}', [CustomersController::class,'remove_address']);
    });

    Route::group(['prefix' => 'production'], function () {
        Route::get('material-take-off', [ProductionController::class,'material_take_off']);
        Route::get('material-orders', [ProductionController::class,'material_orders']);
        Route::get('production-calendar', [ProductionController::class,'production_calendar']);
        Route::get('crew-management', [ProductionController::class,'crew_management']);
        
        Route::group(['prefix' => 'plans-and-permits'], function () {
            Route::get('', [ProductionController::class,'plans_and_permits']);
            Route::get('site-plan', [ProductionController::class,'site_plan']);
            Route::get('engineering-plan', [ProductionController::class,'engineering_plan']);
            Route::get('permit-services', [ProductionController::class,'permit_services']);
            // Route::get('floor-plan', [ProductionController::class,'floor_plan']);
            // Route::get('landscape-plan', [ProductionController::class,'landscape_plan']);
            // Route::get('structural-plan', [ProductionController::class,'structural_plan']);
            // Route::get('plumbing-plan', [ProductionController::class,'plumbing_plan']);
            // Route::get('electrical-plan', [ProductionController::class,'electrical_plan']);
        });
        
    });

    Route::group(['prefix' => 'files'], function () {
        Route::post('/save/user-upload', [FilesController::class, 'saveUserUploadFile']);
        Route::post('/delete/user-upload', [FilesController::class, 'deleteUserFileUpload']);
        Route::post('/update/user-upload/favorite', [FilesController::class, 'updateFavorite']);
        Route::post('/restore/user-upload/trashed', [FilesController::class, 'restoreTrashed']);
        Route::post('/download/user-upload/bulk-download', [FilesController::class, 'bulkDownload']);
        Route::post('/save_new_folder', [FilesController::class, 'saveNewFolder']);
        Route::post('/move-to', [FilesController::class, 'moveFileTo']);
        Route::get('/folders/content/{folderId?}', [FilesController::class, 'getFolderContent']);
        Route::get('/jobs/{jobid?}', [FilesController::class, 'getJobsFile']);
        Route::get('/preview/user-upload/{key?}', [FilesController::class, 'previewFile']);
        Route::get('/user_files/design', [FilesController::class, 'designs']);
        Route::get('/user_files/contract', [FilesController::class, 'contracts']);
        Route::get('/user_files/checklist', [FilesController::class, 'checklists']);
        Route::get('/user_files/engineering', [FilesController::class, 'engineerings']);
        Route::get('/user_files/site', [FilesController::class, 'sites']);
        Route::get('/user_files/architectural', [FilesController::class, 'architecturals']);
        Route::get('/user_files/permit', [FilesController::class, 'permits']);
        Route::get('/user_files/inspection', [FilesController::class, 'inspections']);
        Route::get('/user_files/warranty', [FilesController::class, 'warranties']);
        Route::get('/user_files/document', [FilesController::class, 'documents']);
        Route::get('/user_files/photos', [FilesController::class,'photos']);
        Route::get('/user_files/videos', [FilesController::class,'videos']);
        Route::get('/user_files/googleDrive', [FilesController::class,'googleDrive']);
        Route::get('/user_files/dropbox', [FilesController::class,'dropbox']);
        Route::get('/user_files/starred', [FilesController::class,'starred']);
        Route::get('/user_files/trash', [FilesController::class,'trash']);
        Route::get('/user_files/settings', [FilesController::class,'settings']);
    });

    Route::group(['prefix' => 'financials'], function () {
        Route::get('expense-tracking', [FinancialsController::class,'expense_tracking']);
        Route::get('accounts-receivable', [FinancialsController::class,'accounts_receivable']);
        Route::get('accounts-payable', [FinancialsController::class,'accounts_payable']);
        Route::get('budget', [FinancialsController::class,'budget']);
        Route::get('stage-payments', [FinancialsController::class,'stage_payments']);
        Route::get('payments-report', [FinancialsController::class,'payments_report']);
    });
    
    Route::group(['prefix' => 'user'], function () {
        Route::get('settings', [UserController::class,'settings']);
        Route::get('roadmap', [UserController::class,'roadmap']);
        Route::get('live-chat', [UserController::class,'live_chat']);
        Route::any('profile', [UserController::class,'profile']);
        Route::post('update-password', [UserController::class,'update_password']);
        Route::post('update-profile', [UserController::class,'update_profile']);
        Route::get('security', [UserController::class,'security']);
        Route::get('knowledgebase', [UserController::class,'knowledgebase']);
        Route::get('knowledgebase/details', [UserController::class,'knowledgebase_details']);
    });

    Route::group(['prefix' => 'tasks'], function () {
        Route::post('save', [TasksController::class,'save']);
        Route::post('set-status', [TasksController::class,'set_status']);
        Route::delete('destroy/{id}', [TasksController::class,'destroy']);
    });

    Route::group(['prefix' => 'kanban'], function () {
        Route::get('', [KanbanController::class,'index']);
        Route::post('add-list', [KanbanController::class,'add_list']);
        Route::delete('remove-list', [KanbanController::class,'remove_list']);
        Route::post('get-cards', [KanbanController::class,'get_cards']); //get cards belonging to a list
        Route::post('get-card', [KanbanController::class,'get_card']); //get single card details
        Route::post('add-card', [KanbanController::class,'add_card']);
        Route::post('remove-card', [KanbanController::class,'remove_card']);
    });

    Route::group(['prefix' => 'chatgpt'], function () {
        // Route::get('/chat', [ChatGPTController::class, 'index']);
        Route::post('/generate-email-reply', [ChatGPTController::class,'generate_email_reply']);
    });

    Route::group(['prefix' => 'quickstart'], function () {
        Route::post('load', [QuickStartController::class,'load']);
        Route::post('load-body', [QuickStartController::class,'load_body']);
        Route::post('check-progress', [QuickStartController::class,'check_progress']);
    });
    
    Route::any('test', [TestController::class,'test']);
    Route::any('email', [EmailController::class,'test']);

});//END OF WEB, AUTH ROUTES

Route::get('invitation', [CompanyController::class, 'new_user_invitation']);
Route::post('/invitation/accept', [CompanyController::class, 'accept_invitation']);
Route::get('/password-reset', [CompanyController::class, 'reset_password']);
Route::post('/send-password-reset-email', [CompanyController::class, 'send_password_reset_email']);

//Route::get('accept-invite', [WebhooksController::class,'user_accept_invite']);

Route::group(['prefix' => 'webhooks'], function () {
    Route::any('facebook-leads', [WebhooksController::class,'facebook_leads']);
    Route::any('facebook-leads-test', [WebhooksController::class,'facebook_leads_test']);
    //temp routes
    Route::post('save-facebook-token', [WebhooksController::class,'save_facebook_token']);
    Route::post('regen-facebook-token', [WebhooksController::class,'regen_facebook_token']);

    Route::any('gmail-api', [WebhooksController::class,'gmail_api']);
});

Route::group(['prefix' => 'cron'], function () {
    Route::get('inbox-send-later', [CRONController::class,'inbox_send_later']);
});

Route::get('privacy-policy', [FooterLinksController::class,'privacy_policy']);
Route::get('terms-of-service', [FooterLinksController::class,'terms_of_service']);

Route::get('/guest/proposal-preview', [SalesController::class,'proposal_preview']);
Route::get('/proposal-email', function () {
    return view('emails.send-proposal', [
        'SEND_BY' => 'LOUIE',
        'COMPANY_NAME' => 'TESTING',
        'DISPLAY_NAME'  => 'TESTING',
        'CODE' => 'TESTING'
    ]);
});


Route::get('test', [\App\Http\Controllers\ProUserController::class,'search']);