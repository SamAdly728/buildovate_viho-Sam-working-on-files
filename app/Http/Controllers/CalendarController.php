<?php
namespace App\Http\Controllers;

use App\Models\CalendarGAPI;
use App\Services\S3Manager;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\CalendarRepository;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Socialite;
use Google_Client;
use Google_Service_Calendar;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Appointment;

class CalendarController extends Controller
{
    /**
     * @var CalendarRepository
     */
    private CalendarRepository $calendar;

    /**
     * @var S3Manager
     */
    private S3Manager $s3;

    private $googleToken;

    /**
     * @param CalendarRepository $calendar
     * @param S3Manager $s3
     */
    public function __construct(CalendarRepository $calendar, S3Manager $s3)
    {
        $this->calendar = $calendar;
        $this->s3 = $s3;
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        // Check if user is already connected to google calendar
        $dbCheck = CalendarGAPI::where('user_id', session()->get('user_id'))->first();

        if ($dbCheck) {
            $token = $this->checkTokenIfExpired($dbCheck->token, $dbCheck->refresh_token);
        }

        $checkCal = false;
        $checkDisconnect = false;

        if (session()->get('google_cal_connected')) {
            $checkCal = true;
        }

        if (session()->get('google_cal_disconnected')) {
            $checkDisconnect = true;
        }

        session()->forget('google_cal_connected');
        session()->forget('google_cal_disconnected');

        if ($dbCheck) {
            $newArr = array_merge($this->calendar->getAppointments(), $this->getEvents($token));
        } else {
            $newArr = $this->calendar->getAppointments();
        }

        // Return the index view will the appointment's data
        return Inertia::render('Calendar',
            [
            'customData' => $newArr,
                'leads' => $this->calendar->getLeads(),
                'users' => $this->calendar->getUser(),
                'jobsites' => $this->calendar->getJobsite(),
                'google_cal' => $checkCal,
                'db_check' => $dbCheck,
                'check_dis' => $checkDisconnect
        ]);
    }

    /**
     * @param Request $request
     * @return \App\Models\Appointment
     */
    public function saveAppointment(Request $request): \App\Models\Appointment
    {
        return $this->calendar->saveAppointment($request->all());
    }

    public function getUpload(Request $request)
    {
        //        dd($request->get('appointmentId'));

        return $this->calendar->getUploadFile($request->get('appointmentId'));

    }

    public function saveFileUpload(Request $request)
    {
        dd($request->file('file'));
        $this->s3->store($request);

    }

    public function searchLead(Request $request)
    {
        $this->calendar->getLeads();
    }

    public function redirect()
    {
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(base_path().'/public/conf/google_cal_creds.json');
        $googleClient->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $googleClient->addScope(Google_Service_Calendar::CALENDAR);
        $googleClient->setAccessType('offline');
        $googleClient->setPrompt('select_account consent');

        return redirect($googleClient->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(base_path().'/public/conf/google_cal_creds.json');
        $googleClient->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $code = $request->get('code');

        if ($code) {
            $googleClient->fetchAccessTokenWithAuthCode($code);
            $accessToken = $googleClient->getAccessToken();
            $refreshToken = $googleClient->getRefreshToken();

            $calendar = new CalendarGAPI();
            $calendar->user_id = session()->get('user_id');
            $calendar->code = $code;
            $calendar->token = $accessToken['access_token'];;
            $calendar->expiration = $accessToken['expires_in'];
            $calendar->refresh_token = $refreshToken;
            $calendar->token_type = $accessToken['token_type'];
            $calendar->save();

            session()->put('google_cal_connected', 1);

            return redirect()->to('/calendar');
        }
    }

    public function diconnectGoogleCalendar()
    {
        $dbEntry = CalendarGAPI::where('user_id', session()->get('user_id'))->first();
        $client = new Google_Client();
        $client->revokeToken($dbEntry->token);

        $dbEntry->delete();

        session()->put('google_cal_disconnected', 1);

        return redirect()->to('/calendar');

    }
    public function getEvents($token)
    {
        $client = new Google_Client();
        $client->setAccessToken($token); // Retrieve this from your database

        $service = new Google_Service_Calendar($client);

        $calendars = $service->calendarList->listCalendarList();

        $eventsArray = [];

        foreach ($calendars->getItems() as $eve) {
            $events = $service->events->listEvents($eve->getId());
            foreach($events->getItems() as $item) {
                $eventsArray[] = [
                    'title' => $item->getSummary(),
                    'start' => $item->getStart()->getDateTime() ?? $item->getStart()->getDate(),
                    'end' => $item->getEnd()->getDateTime() ?? $item->getStart()->getDate(),
                    'backgroundColor' => $item->getColorId()
                ];
            }
        }

        return $eventsArray;

    }

    private function checkTokenIfExpired($token, $refreshToken)
    {
        $client = new Google_Client();
        $client->setAuthConfig(base_path().'/public/conf/google_cal_creds.json');
        $client->setAccessToken($token);

        // Check if the access token is expired
        if ($client->isAccessTokenExpired()) {

            $client->fetchAccessTokenWithRefreshToken($refreshToken);
            $dbData = CalendarGAPI::where('user_id', session()->get('user_id'))->first();
            $dbData->token = $client->getAccessToken()['access_token'];
            $dbData->save();

            return $client->getAccessToken()['access_token'];
        }

        return $token;
    }

    public function getData(Request $request){
        $appointments = $this->calendar->getAppointments();
    }

    public function getLib(Request $request){
        $leads = $this->calendar->getLeads();
        $users = $this->calendar->getUser();
        $jobsites = $this->calendar->getJobsite();

        return response()->json(
            [
                'status' => 'success',
                'leads' => $leads,
                'users' => $users,
                'jobsites' => $jobsites
            ]
        );

    }

    public function getDataBySalesPeople(Request $request){

        // Assuming $userIds is an array of user IDs you want to match
        $userIds = $request->salesperson_ids; // Example user IDs

        $appointments = Appointment::whereHas('appointmentAssignment', function ($query) use ($userIds) {
            $query->whereIn('user_id', $userIds);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $appointments
        ]);

    }
}