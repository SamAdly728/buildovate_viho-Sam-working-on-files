<?php

namespace App\Http\Controllers;

use App\Services\S3Manager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\CalendarRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\ToDo;
use App\Models\ToDoAttachments;
use App\Models\ToDoMembers;
use App\Models\ToDoActivities;
use App\Models\ToDoLabels;
use App\Models\Label;
use App\Models\User;
use App\Models\Jobsite;
use App\Models\Lead;

class TodoController extends Controller
{

    private CalendarRepository $calendar;

    public function __construct(CalendarRepository $calendar)
    {
        $this->calendar = $calendar;
    }

    public function index(Request $request)
    {

        $id = null;
        if(isset($request->id)) {
            $id = $request->id;
        }
        $type = null;
        if(isset($request->type)) {
            $type = $request->type;
        }
        return Inertia::render('todo/Todo',
            [
                'pageTitle' => "To Do",
                'type' => $type,
                'id' => $id,
                'leads' => $this->calendar->getLeads(),
                'jobsites' => $this->calendar->getJobsite(),
            ]);
    }

    public function kanban(Request $request)
    {
        $id = null;
        if(isset($request->id)) {
            $id = $request->id;
        }
        $type = null;
        if(isset($request->type)) {
            $type = $request->type;
        }
        return Inertia::render('todo/Kanban',
            [
                'pageTitle' => "To Do",
                'type' => $type,
                'id' => $id,
                'leads' => $this->calendar->getLeads(),
                'jobsites' => $this->calendar->getJobsite(),
            ]);
    }

    public function getTodo(Request $request) {
        try {

            $user = Auth::user(); 

            $entityId = $request->entityId;
            $entityType = $request->entityType;

            $records = ToDo::where('user_id', session()->get('user_id'))->where('is_deleted', 0);
                
            if (intval($entityId) > 0) {
                $records->where('entityId', $entityId);
            }
            if(in_array($entityType, ["projects", "leads","non-work"])) {
                $records->where('entityType', $request->entityType);
            }

            $records = $records->get();
            
            $data = [];
            $card_data = [];
            foreach($records as $record) {
                foreach ($record->todoActivities as $todoActivity) {
                    $user = $todoActivity->user;
                }
                
                $todoActivities = $record->todoActivities;
                $toDoMembers = $record->toDoMembers;
                $toDoAttachments = $record->toDoAttachments;
                $toDoLabels = $record->toDoLabels;

                $record['entityName'] = $record->entityType;
                // Format the date
                if ($record->reminder_date) {
                    $record->reminder_date = Carbon::parse($record->reminder_date)->format('Y-m-d');
                }
                if ($record->entityId) {
                    
                    if ($record->entityType == "projects") {
                        $jobSite = Jobsite::find($record->entityId);
                        $record['entityName'] = $jobSite->jobsite_name;
                    }
                    if ($record->entityType == "leads") {
                        $lead = Lead::find($record->entityId);
                        $record['entityName'] = $lead->opportunity_title;
                    }
                    
                }
                $data[] = $record;

                /////////////////////////////////////// cards details //////////////////////////////////////////
                if(!isset($card_data[$record->entityType]))
                {
                    $card_data[$record->entityType] = array();
                }
                
                $card_data[$record->entityType][] = (object)[
                    'id' => $record->id,
                    'entityId' => $record->entityId,
                    'entityType' => $record->entityType,
                    'title' => $record->title,
                    'description' => $record->description,
                    'thumbnail' => "",
                    'display_deadline' => Carbon::parse($record->reminder_date)->format('M d'),
                    'start_date' =>  Carbon::parse($record->start_date)->format('Y-m-d h:m'),
                    'due_date' =>  Carbon::parse($record->due_date)->format('Y-m-d h:m'),
                    'due_time' =>  $record->due_time,
                    'reminder' =>  $record->reminder,
                    'reminder_date' =>  Carbon::parse($record->reminder_date)->format('Y-m-d h:m'),
                    'labels' =>  $record->labels,
                    'has_comments' => rand(1,8),
                    'has_description' => rand(1,8),
                    'has_attachments' => rand(1,8),
                    'has_members' => rand(1,8),
                    'has_labels' => false,
                ];
            }

            if($records) {
                return response()->json(['status' => 'success', 'data' => $data, 'cards' => $card_data]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
            
            
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function saveTodo(Request $request) {
        try {

            $user = Auth::user(); 
            // Validate the request data
            $validatedData = $request->validate([
                // 'entityId' => 'required|integer',
                'title' => 'required|string',
            ]);

            $payload = $request->all();
            $payload['user_id'] = session()->get('user_id');

            $record = ToDo::create($payload);
            if($record) {
                return response()->json(['status' => 'success', 'data' => $record]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
            
            
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function markTodo(Request $request, $id) {
        try {

            $user = Auth::user(); 
            // Validate the request data
            $validatedData = $request->validate([
                'is_completed' => 'required|integer'
            ]);

            $record = ToDo::find($id)->update(['is_completed' => $request->is_completed]);
            if($record) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function removeTodo(Request $request, $id) {
        try {

            $user = Auth::user(); 
            $record = ToDo::find($id)->update(['is_deleted' => 1]);
            if($record) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function updateTodo(Request $request, $id) {
        try {

            $user = Auth::user(); 
            // Validate the request data
            $validatedData = $request->validate([
                'entityId' => 'required|integer',
                'entityType' => 'required|string',
                'title' => 'required|string',
                'description' => 'required|string',
            ]);

            $payload = $request->all();

            $record = ToDo::find($id)->update($payload);
            if($record) {
                return response()->json(['status' => 'success', 'data' => $record]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to update To Do record']);    
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function saveListTodo(Request $request) {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'card.title' => 'required|string',
                'card.entityType' => 'required|string',
            ]);

            $payload = $request->card;
            $payload['user_id'] = session()->get('user_id');

            $record = ToDo::create($payload);

            ////////////////// Save Activities List ////////////////////////////
            $activities = $request->activities;
            if ($activities && $record) {
                foreach ($activities as $activity) {
                    ToDoActivities::create([
                        'todo_id' => $record->id, 
                        'user_id' => session()->get('user_id'), 
                        'description' => $activity["description"],
                    ]);
                }
            }

            ////////////////// Save Members List ////////////////////////////
            $members = $request->members;
            if ($members && $record) {
                foreach ($members as $member) {
                    ToDoMembers::create([
                        'todo_id' => $record->id, 
                        'user_id' => $member["user_id"], 
                        'owner' => session()->get('user_id'),
                    ]);
                }
            }

            ////////////////// Save Labels List ////////////////////////////
            $labels = $request->labels;
            if ($labels && $record) {
                foreach ($labels as $label) {
                    ToDoLabels::create([
                        'todo_id' => $record->id, 
                        'label_id' => $label["id"], 
                        'user_id' => session()->get('user_id'),
                        'is_deleted' => 0,
                    ]);
                }
            }

            if($record) {
                return response()->json(['status' => 'success', 'data' => $record]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    /////////////////////////////////////////////////// TODO Activities ////////////////////////////////////////////////
    
    public function getActivities(Request $request) {
        try {
            $user = Auth::user(); 
            // Validate the request data
            $validatedData = $request->validate([
                'todo_id' => 'required|integer',
            ]);

            $todo_id = $request->todo_id;
            $user_id = session()->get('user_id');

            $records = ToDoActivities::where('todo_id', $todo_id)->where('is_deleted', 0)->orderBy('id', 'desc');
            $records = $records->get();
            foreach ($records as $record) {
                $user = $record->user;
                //$record->userDetails = $user;
            }
            
            if($records) {
                return response()->json(['status' => 'success', 'data' => $records]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function saveActivity(Request $request) {
        try {

            $user = Auth::user(); 
            // Validate the request data
            $validatedData = $request->validate([
                'description' => 'required|string',
            ]);

            $payload = $request->all();
            $payload['user_id'] = session()->get('user_id');

            $identifier = ['id' => $request->id];

            $record = ToDoActivities::updateOrCreate($identifier, $payload);

            if($record) {
                $todo_id = $request->todo_id;
                $records = ToDoActivities::where('todo_id', $todo_id)->where('is_deleted', 0)->orderBy('id', 'desc');
                $records = $records->get();
                foreach ($records as $record) {
                    $user = $record->user;
                }
                return response()->json(['status' => 'success', 'data' => $records]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }
    
    public function deleteActivity(Request $request) {
        try {
            $id = $request->id;
            $record = ToDoActivities::find($id);
            $record->is_deleted = 1;
            $record->save();

            if($record) {
                $todo_id = $request->todo_id;
                $records = ToDoActivities::where('todo_id', $todo_id)->where('is_deleted', 0)->orderBy('id', 'desc');
                $records = $records->get();
                foreach ($records as $record) {
                    $user = $record->user;
                }

                return response()->json(['status' => 'success', 'data' => $records, 'result' => $record]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete To Do Activity record']);    
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    /////////////////////////////////////////////////// TODO Activities ////////////////////////////////////////////////

    /////////////////////////////////////////////////// TODO Members ////////////////////////////////////////////////

    public function searchMembers(Request $request) {
        try {
            $query = $request->input('query');
            $type =  $request->input('type');

            if($type == "all"){
                $results = User::limit(10)->get();
            }else{
                $results = User::where('display_name', 'like', "%$query%")->get();
            }
            
            if($results) {
                return response()->json(['status' => 'success', 'data' => $results]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function saveMember(Request $request) {
        try {

            $user = Auth::user(); 
            // Validate the request data
            $validatedData = $request->validate([
                'todo_id' => 'required',
                'user_id' => 'required',
            ]);

            $payload = $request->all();

            $identifier = ['todo_id' => $request->todo_id,'user_id' => $request->user_id];

            $todoMember = ToDoMembers::where('todo_id', $request->todo_id)->where('user_id', $request->user_id)->first();

            if ($todoMember) {
                $todoMember->is_deleted = 1;
                $todoMember->save();
                $record = $todoMember;
            } else {
                $record = ToDoMembers::create([
                    'todo_id' => $request->todo_id,
                    'user_id' => $request->user_id,
                ]);
            }

            if($record) {
                $todo_id = $request->todo_id;
                $records = ToDoMembers::where('todo_id', $todo_id)->where('is_deleted', 0);
                $records = $records->get();
                foreach ($records as $record) {
                    $user = $record->user;
                }
                return response()->json(['status' => 'success', 'data' => $records]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }
    
    public function deleteMember(Request $request) {
        try {
            $id = $request->id;
            $record = ToDoMembers::find($id);
            $record->is_deleted = 1;
            $record->save();

            if($record) {
                $todo_id = $request->todo_id;
                $records = ToDoMembers::where('todo_id', $todo_id)->where('is_deleted', 0);
                $records = $records->get();
                foreach ($records as $record) {
                    $user = $record->user;
                }

                return response()->json(['status' => 'success', 'data' => $records, 'result' => $record]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete To Do Activity record']);    
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }
    
    /////////////////////////////////////////////////// TODO Members ////////////////////////////////////////////////
    
    /////////////////////////////////////////////////// TODO Attachments ////////////////////////////////////////////////

    public function upload(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $s3Path = 'todos/attachments/'.session()->get('user_id').'/'.$request->todo_id.'_'.md5(rand(1000,1000)).'-'.$file->getClientOriginalName();

        $attachment = new ToDoAttachments();
        $attachment->user_id = session()->get('user_id');
        $attachment->todo_id = $request->todo_id;
        $attachment->file_name = $file->getClientOriginalName();
        $attachment->file_type = $file->getClientOriginalExtension();
        $attachment->file_size = $file->getSize();
        $attachment->s3_path = $s3Path;

        $s3 = new S3Manager();
        $s3->store($file, $s3Path);

        $attachment->s3_url = $s3->getUrl($attachment->s3_path);
        $attachment->save();


        // return response()->json(['success' => true, 'data' => $attachment]);
        $records = $this->getUploads($request->todo_id);
        if($records) {
            return response()->json(['status' => 'success', 'data' => $records]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete To Do Activity record']);    
        }
    }
    public function deleteUpload(Request $request){
        try {
            $id = $request->id;
            $record = ToDoAttachments::find($id);
            $record->deleted_at = Carbon::now();
            $record->save();

            if($record) {
                $records = $this->getUploads($request->todo_id);
                return response()->json(['status' => 'success', 'data' => $records]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete To Do Activity record']);    
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function getAllUploads(Request $request) {
        $records = $this->getUploads($request->todo_id);
        if($records) {
            return response()->json(['status' => 'success', 'data' => $records]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
        }
    }

    private function getUploads($todo_id){
        try {
            $user_id = session()->get('user_id');

            $records = ToDoAttachments::where('todo_id', $todo_id)->where('deleted_at', NULL)->orderBy('id', 'desc');
            $records = $records->get();
            
            if($records) {
                return $records;
            } else {
                return array();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    /////////////////////////////////////////////////// TODO Attachments ////////////////////////////////////////////////

    /////////////////////////////////////////////////// TODO LABELS ////////////////////////////////////////////////

        public function getLabels(Request $request) {
            try {
                $results = Label::limit(10)->get();
                
                if($results) {
                    return response()->json(['status' => 'success', 'data' => $results]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
                }
                
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['status' => 'error', 'errors' => $e->errors()]);
            }
        }
    
        public function saveTodoLabels(Request $request) {
            try {
    
                $user = Auth::user(); 
                // Validate the request data
                $validatedData = $request->validate([
                    'todo_id' => 'required',
                    'label_id' => 'required',
                ]);
                
                $payload = $request->all();
                $todoLabel = ToDoLabels::where('todo_id', $request->todo_id)->where('label_id', $request->label_id)->first();
    
                if ($todoLabel) {
                    $todoLabel->is_deleted = 1;
                    $todoLabel->save();
                    $record = $todoLabel;
                } else {
                    $user_id = session()->get('user_id');
                    $record = ToDoLabels::create([
                        'todo_id' => $request->todo_id,
                        'label_id' => $request->label_id,
                        'user_id' => $user_id,
                    ]);
                }
    
                if($record) {
                    $todo_id = $request->todo_id;
                    $records = ToDoLabels::where('todo_id', $todo_id)->where('is_deleted', 0);
                    $records = $records->get();
                    foreach ($records as $record) {
                        $label = $record->label;
                    }
                    return response()->json(['status' => 'success', 'data' => $records]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to add new To Do record']);    
                }
                
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['status' => 'error', 'errors' => $e->errors()]);
            }
        }
        
        public function deleteTodoLabels(Request $request) {
            try {
                $id = $request->id;
                $record = ToDoLabels::find($id);
                $record->is_deleted = 1;
                $record->save();
    
                if($record) {
                    $todo_id = $request->todo_id;
                    $records = ToDoLabels::where('todo_id', $todo_id)->where('is_deleted', 0);
                    $records = $records->get();
                    foreach ($records as $record) {
                        $label = $record->label;
                    }
    
                    return response()->json(['status' => 'success', 'data' => $records, 'result' => $record]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to delete To Do Activity record']);    
                }
        
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['status' => 'error', 'errors' => $e->errors()]);
            }
        }
        
        /////////////////////////////////////////////////// TODO LABELS ////////////////////////////////////////////////
}
