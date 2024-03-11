<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\Task;

use Inertia\Inertia;

class TasksController extends Controller
{

    public function save(Request $request)
    {
        $req = (object)$request::all();
        if(isset($req->title) && $req->title!='')
        {
            if(is_numeric($req->edit_id))
            {
                // UPDATE
                $success = Knowledgebase::where('id',$req->edit_id)
                           ->update([
                                'project_id' => $req->project_id,
                                'jobsite_id' => $req->jobsite_id,
                                'title' => $req->title,
                                'description' => $req->description,
                                'updated_by'=>Auth::user()->id
                           ]);

                $status = 'Success! Task Updated.';

                return response()->json([
                    'success' => $success,
                    'status'  => $status
                ]);

            }else{

                // ADD
                $check = Task::where('project_id',$req->project_id)
                        ->where('jobsite_id',$req->jobsite_id)
                        ->where('title',$req->title)
                        ->count();
                if($check==0)
                {
                    $lastID =  Task::insertGetId([
                                'project_id' => $req->project_id,
                                'jobsite_id' => $req->jobsite_id,
                                'title' => $req->title,
                                'description' => $req->description,
                                'created_by' => Session::get('user_id'),
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                    
                    return response()->json([
                        'success' => ($lastID>0) ? true : false,
                        'status'  => 'Success! Task Added.'
                    ]);

                }else{

                    return response()->json([
                        'success' => false,
                        'status'  => "A-Huh! Looks Like It's Already Added."
                    ]);
                }
            }

        }
    }

    public function set_status(Request $request)
    {
        $req = (object)$request::all();
        $success = false;
        $status = '';

        if(is_numeric($req->id))
        {
            $success = Task::where('id',$req->id)->update(['status'=>$req->status]);
            $status = 'Success! Status Updated.';
        }

        return response()->json([
            'success' => $success,
            'status'  => $status
        ]);
    }

    public function destroy($id)
    {
        $success = false;
        $status = '';

        if(is_numeric($id))
        {
            $success = Task::where('id',$id)->delete();
            $status = 'Success! Deleted.';
        }

        return response()->json([
            'success' => $success,
            'status'  => $status
        ]);
    }

    
    
}
