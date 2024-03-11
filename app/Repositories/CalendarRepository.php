<?php
namespace App\Repositories;

use App\Models\Appointment;
use App\Models\AppointmentAssignment;
use App\Models\CalendarAppointmentFileUpload;
use App\Models\Jobsite;
use App\Models\Lead;
use App\Models\User;
use App\Services\S3Manager;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class CalendarRepository
{
    /**
     * @return mixed
     */
    public function getAppointments(): mixed
    {
        $lead_id = '';
        $select = 'a.appointment_id, 
                    a.title, 
                    a.street, 
                    a.city, 
                    a.state, 
                    a.zipcode, 
                    a.description, 
                    a.Meeting_date, 
                    a.start_date, 
                    a.end_date, 
                    a.stage, 
                    a.guests, 
                    a.attachment, 
                    a.color, 
                    a.entityType, 
                    a.entityId, 
                    a.reminder_sms, 
                    a.reminder_email, 
                    a.assignedToUserId, 
                    l.lead_id, 
                    l.opportunity_phone, 
                    cust.email';
        $lead_base = ($lead_id != '') ? 'AND la.lead_id = ' . $lead_id : '';

        $appointmentResult = DB::select("SELECT
				$select,
				-- CONCAT(a.street, ' ', a.city, ' ', a.state, ' ', a.zipcode) AS address,
				CONCAT(cust.first_name, ' ',cust.last_name) as cx_name,
				GROUP_CONCAT(DISTINCT users.display_name SEPARATOR ', ') AS assign_to,
				GROUP_CONCAT(DISTINCT users.user_id SEPARATOR ', ') AS assign_to_user_id,
				MAX(la.lead_id) as lead_id
			FROM appointment as a
			LEFT JOIN appointment_assignment as ap_ass ON ap_ass.appointment_id = a.appointment_id
			LEFT JOIN users ON users.user_id = ap_ass.user_id
			LEFT JOIN lead_appointments as la ON la.appointment_id = a.appointment_id
			LEFT JOIN leads as l on l.lead_id = la.lead_id
			LEFT JOIN customers as cust on cust.cust_id = l.cust_id
            WHERE a.start_date IS NOT NULL
			$lead_base
			GROUP BY $select
			ORDER BY a.Meeting_date DESC");

        foreach ($appointmentResult as $app) {
            $app->date = $app->Meeting_date;
            $app->start = $app->start_date;
            $app->end = $app->end_date;
            $app->reminder_sms = (bool) $app->reminder_sms;
            $app->reminder_email = (bool) $app->reminder_email;
        }

        return $appointmentResult;

    }

    public function getJobsite()
    {
        return Jobsite::all();
    }

    public function getLeads()
    {
        return Lead::select('lead_id', 'opportunity_title')->get();
    }

    public function getUser()
    {
        return User::select('user_id', 'display_name')->get();
    }

    public function getUploadFile($appointmentId)
    {
        $files = CalendarAppointmentFileUpload::where('appointment_id', $appointmentId)->get();
        $s3FileUrl = [];
        $s3 = new S3Manager();

        foreach($files as $file) {
            $s3FileUrl[] = $s3->getUrl($file->s3_path);
        }

        return $s3FileUrl;
    }

    public function saveAppointment($request)
    {
        if (!empty($request['appointment_id'])) {
            $appointment = Appointment::find($request['appointment_id']);
            if (!$appointment) {
                $appointment = new Appointment();
            }
        } else {
            $appointment = new Appointment();
        }
        $appointment->title = $request['title'];
        $appointment->street = (isset($request['streetAddress'])) ? $request['streetAddress'] : "";
        $appointment->city = (isset($request['city'])) ? $request['city'] : "";
        $appointment->state = (isset($request['state'])) ? $request['state'] : "";
        $appointment->zipcode = (isset($request['zipcode'])) ? $request['zipcode'] : "";
        $appointment->description = $request['description'];
        $appointment->date = Carbon::now();
        $appointment->guests = $request['guest'];
        //        $appointment->Stage = $request['stage'];
        $appointment->Meeting_date = date('Y-m-d H:i:s', strtotime($request['startDate']));
        $appointment->start_date = date('Y-m-d H:i:s', strtotime($request['startDate']));
        $appointment->end_date = date('Y-m-d H:i:s', strtotime($request['endDate']));
        $appointment->entityType = $request['entityType'];
        $appointment->entityId = $request['entityId'];
        $appointment->reminder_sms = (int) $request['reminder_sms'];
        $appointment->reminder_email = (int) $request['reminder_email'];
        $appointment->assignedToUserId = $request['assignedToUserId'];
        $appointment->created_by =  Auth::user()->user_id;
        $appointment->save();

        if (isset($request['file'])) {
            $this->saveFile($appointment->appointment_id, $request['file']);
        }

        if (!empty($request['leadId'])) {
            $appointmentAssignment = new AppointmentAssignment();
            $appointmentAssignment->appointment_id = $appointment->appointment_id;
            $appointmentAssignment->user_id = $request['assignedToUserId'];
            $appointmentAssignment->save();
        }

        return $appointment;
    }

    private function saveFile($appointmentId, $files): void
    {
        foreach($files as $file) {

            $s3KeyFileName = 'calendar/appointment/fileupload/'.$appointmentId.'-'.$file->getClientOriginalName();
            $fileUpload = new CalendarAppointmentFileUpload();
            $fileUpload->appointment_id = $appointmentId;
            $fileUpload->file_name = $file->getClientOriginalName();
            $fileUpload->file_type = $file->getClientOriginalExtension();
            $fileUpload->s3_path = $s3KeyFileName;
            $fileUpload->save();

            $s3 = new S3Manager();
            $s3->store($file, $s3KeyFileName);
        }

    }
}