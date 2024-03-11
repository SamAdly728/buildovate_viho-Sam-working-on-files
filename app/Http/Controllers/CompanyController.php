<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\FollowupDealStage;
use App\Models\ProUser;
use App\Repositories\CompanyRepository;
use App\Repositories\FilesRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\Company;
use App\Models\AccessToken;
use App\Models\User;
use App\Models\ManageUsers;
use App\Models\CompanyRole;
use App\Models\Role;

use App\Config\CompanyBasicInformation;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Services\ReportsManager;
class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private CompanyRepository $companyDetails;

    /**
     * @var CompanyBasicInformation
     */
    private CompanyBasicInformation $basicInformation;

    /**
     * @var FilesRepository
     */
    private $file;

    public function __construct(CompanyRepository $companyDetails, CompanyBasicInformation $basicInformation, FilesRepository $file)
    {
        $this->companyDetails = $companyDetails;
        $this->basicInformation = $basicInformation;
        $this->file = $file;
    }

    public function index(Request $request)
    {
        return Inertia::render('company/Main');
    }

    public function getstarted(Request $request)
    {
        return Inertia::render('company/GetStarted');
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function details(Request $request): \Inertia\Response
    {
        return Inertia::render('company/Details',
            [
                'companyDetails' => $this->companyDetails->getCompanyDetails(),
                'timezone' => $this->basicInformation->timezone(),
                'dateFormat' => $this->basicInformation->dateFormat(),
                'timeFormat' => $this->basicInformation->timeFormat(),
                'daysOfWeek' => $this->basicInformation->daysOfWeek(),
                'companyOverHead' => $this->companyDetails->getCompanyMonthlyOverhead(),
                'companyNumber' => $this->companyDetails->getCompanyPhoneNumbers(),
                'companyEmail' => $this->companyDetails->getCompanyEmail(),
                'companyLocation' => $this->companyDetails->getCompanyLocation(),
                'companyWebsite' => $this->companyDetails->getCompanyWebsites(),
                'socialMedia' => $this->companyDetails->getSocialMedia(),
                'companyHours' => $this->companyDetails->getCompanyHours()
            ]);
    }

    public function basic(Request $request){
        return Inertia::render('company/details/BasicInfo');
    }
    
    public function hours(Request $request){
        return Inertia::render('company/details/Hours');
    }

    public function overhead(Request $request){
        return Inertia::render('company/details/MonthlyOverhead');
    }

    public function numbers(Request $request){
        return Inertia::render('company/details/PhoneNumbers');
    }

    public function emails(Request $request){
        return Inertia::render('company/details/Emails');
    }

    public function locations(Request $request){
        return Inertia::render('company/details/Locations');
    }

    public function websites(Request $request){
        return Inertia::render('company/details/Websites');
    }

    public function socials(Request $request){
        return Inertia::render('company/details/SocialMedias');
    }

    public function templates(Request $request){
        return Inertia::render('company/Templates');
    }

    public function followUp(Request $request){

        $dealStage = FollowupDealStage::with('sequences.drips')->get();
        return Inertia::render('company/FollowUp', [
            'dealStages' => $dealStage,
        ]);
    }

    public function catalog(Request $request){
        return Inertia::render('company/Catalog');
    }
    public function reminders(Request $request){
        return Inertia::render('company/Reminders');
    }
    public function settings(Request $request){
        return Inertia::render('company/Settings');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveBasicInfo(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->saveCompanyBasicInfo($request->all())) {

            // if($request->file('logo')!=null)// && $request->file('logo')->isValid())
            // {
            //     $this->saveLogo($request->file('logo'));
            // }
            Session::put('logo',$request->name);

            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    private function saveLogo($file)
    {
        //check canvas images
        $destinationPath = base_path().'/public/uploads/logos/';

        $filename = Session::get('user_id') ."logo.png";// .$file->getClientOriginalExtension();
            
        $file->move($destinationPath, $filename);

        $data['logo'] = $filename;

        Session::put('logo',$filename);

        return Company::where('user_id', Session::get('user_id'))->update($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOrEditMonthlyOverHead(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->saveOrEditMonthlyOverHead($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOverHead(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($this->companyDetails->deleteOverhead($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully deleted!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOrEditPhoneNumber(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->saveOrEditPhoneNumber($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePhoneNumber(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($this->companyDetails->deletePhoneNumber($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully deleted!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->saveEmail($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($this->companyDetails->deleteEmail($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully deleted!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAddress(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->saveAddress($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAddress(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->deleteAddress($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveWebsite(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->saveWebsite($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteWebsite(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->deleteWebsite($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOrUpdateSocialMedia(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->saveOrUpdateSocialMedia($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBusinessHours(Request $request): \Illuminate\Http\JsonResponse
    {
        if($this->companyDetails->updateBusinessHours($request->all())) {
            return response()->json(['status' => true, 'message' => 'Data was successfully saved!!!']);
        }

        return response()->json(['status' => false, 'message' => 'Something went wrong!!!']);
    }

    public function reports(Request $request)
    {
        return Inertia::render('company/Reports',
            ['pageTitle' => "Reports"]);
    }

    public function marketing(Request $request)
    {
        $hasFBToken = AccessToken::select('token')
                            ->where('lead_type','fb')
                            ->where('user_id',Session::get('user_id'))
                            ->count();

        return Inertia::render('company/Marketing',
            [
                'pageTitle' => "Marketing",
                'hasFBToken' => $hasFBToken,
                'fb_app_id'=>env('FBAPP_ID')
            ]);
    }

    public function marketing_auto_leads_unsubscribe(Request $request)
    {
        $lead = $request->get('lead');

        if($lead!='')
        {
            $status = '';
            $message = '';

            switch($lead)
            {
                case "FBL": 
                //clear access_tokens
                $status = AccessToken::where('lead_type','fb')
                        ->where('user_id',Session::get('user_id'))
                        ->delete();

                $message = ($status>0) ? 'Success!' : 'Action failed! Please try again later.';
                break;
                // case "IGL": alert(boxId); break;
                // case "HAL": alert(boxId); break;
                // case "WCL": alert(boxId); break;
                // case "ALL": alert(boxId); break;
                // case "TTL": alert(boxId); break;
                // case "BZL": alert(boxId); break;
                // case "HL": alert(boxId); break;
                // case "CJL": alert(boxId); break;
            }

            return response()->json([
                'status'  => $status,
                'message' => $message
            ]);
        }
    }

    /**
     * @return \Inertia\Response
     */
    public function users(): \Inertia\Response
    {
        return Inertia::render('company/Users',[
            'users' => ManageUsers::get_users([]),
            'roles' => ManageUsers::get_roles(),
            'prosUsers' => ManageUsers::get_pros(),
            'deactivatedUsers' => ManageUsers::get_deactivated(),
            'pendingUsers' => ManageUsers::get_pending()
        ]) ;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function revoke_user_access(Request $request): mixed
    {
        return ManageUsers::revoke_access($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all_users(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'users'  => ManageUsers::get_users(['role_id'=>$request->get('role_id')]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function users_send_invite(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = ManageUsers::send_invite($request);

        if (!$result->success) {
            return response()->json([
                'success' => false,
                'message' => 'User with this email <h4 class="text-danger"><i>'.$result->email.'</i></h4> already exist...'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $result->message
        ]);
    }

    /**
     * @param Request $request
     * @return \Inertia\Response|void
     */
    public function new_user_invitation(Request $request)
    {
        $user = ManageUsers::new_user_invitation($request);

        if(isset($user->user_id)) {
            return Inertia::render('company/AcceptInvite',[
                'user' => $user
            ]) ;
        }else{
            //show invalid code page
            abort('401', 'Unauthorized');;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function accept_invitation(Request $request)
    {
        $newUser = ManageUsers::accept_invitation($request);

        if($newUser) {
            return response()->json([
                'success' => true,
                'message' => 'Accound has been successfully created.'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return object
     */
    public function send_password_reset_email(Request $request): object
    {
        return ManageUsers::send_password_reset_email($request);
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function reset_password(Request $request): \Inertia\Response
    {
        return Inertia::render('PasswordReset', ['user_id' => $request->get('uc')]);
    }

    /**
     * @param Request $request
     * @return \App\Models\UserPayRate
     */
    public function save_pay_rate(Request $request): \App\Models\UserPayRate
    {
        return ManageUsers::save_pay_rate($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function get_user_payrate(Request $request): mixed
    {
        return ManageUsers::get_user_payrate($request);
    }


    public function buildovate_professionals(Request $request)
    {
        $reportsManager = new ReportsManager();
        $records = $reportsManager->specialty_categories();

        // Iterate through the data array
        foreach ($records as $category) {
            $categoryId = $category['id'];
            $categoryName = $category['name'];
            $subCategories = $category['sub_categories'];
            
            // Initialize sub category array for this category
            $categoryArray = [];
            
            // Iterate through sub categories
            foreach ($subCategories as $subCategory) {
                $subCategoryId = $subCategory['id'];
                $subCategoryName = $subCategory['name'];
                $specialties = $subCategory['specialties'];
                
                // Initialize specialties array for this sub category
                $subCategoryArray = [];
                
                // Iterate through specialties
                foreach ($specialties as $specialty) {
                    $specialtyId = $specialty['id'];
                    $specialtyName = $specialty['name'];
                    
                    // Add specialty to sub category array
                    $subCategoryArray[] = [
                        'id' => $specialtyId,
                        'checkboxItem' => $specialtyName
                    ];
                }
                
                // Add sub category array to category array
                $categoryArray[$subCategoryName] = $subCategoryArray;
            }
            
            // Add category array to result
            $result[] = [
                
                $categoryName => [$categoryArray]
            ];
        }

        // Encode result array to JSON
        // $resultJson = json_encode($result, JSON_PRETTY_PRINT);

        // Output the result JSON
        // echo $resultJson;exit;
        
        return Inertia::render('company/BuildovateProfessionals',
            ['pageTitle' => "Buildovate Professionals", "records" => $result]);
    }

    public function portfolio(Request $request)
    {
        return Inertia::render('company/Portfolio',[
                'folders' => $this->companyDetails->getPortfolioFolders(),
                'allFiles' => $this->file->getFiles(null, null, null, 'portfolio'),
                'deletedFiles' => $this->file->getTrashed('portfolio')
        ]);
    }

    public function portfolio_folder_content(Request $request, $folderId)
    {
        return Inertia::render('company/PortfolioFolderContent', [
            'foldersFile' => $this->file->getFiles(null, null, $folderId),
//            'foldersFile' => $this->companyDetails->getPortfolioFilesWithFolder($folderId),
            'folderInfo' => $this->companyDetails->getPortFolioFolderInfo($folderId)
        ]);
    }

    public function savePortfolioFiles(Request $request)
    {
        return $this->companyDetails->savePortFolioFiles($request->all());
    }

    public function save_folder_name(Request $request)
    {
        return $this->companyDetails->saveFolderName($request->all());
    }

    public function become_a_pro()
    {
        $user = User::find(session()->get('user_id'));
        $pro_user = \App\Models\ProUser::where('user_id', $user->user_id)->first();
        return Inertia::render('company/BecomeAPro', ['user' => $user, 'pro_user' => $pro_user]);
    }

    public function add_folder(Request $request)
    {
        return $this->companyDetails->saveNewFolder($request->all());
    }
}
