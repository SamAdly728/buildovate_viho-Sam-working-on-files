<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

class Task extends Model
{
    use HasFactory;

    public static function user_tasks($search, $filter)
    {
        if($search!='undefined' && $search!='null' && $search!='')
        {
            return DB::table('tasks as t')
                        ->leftJoin('projects as p', 'p.id', '=', 't.project_id')
                        ->leftJoin('jobsite as j', 'j.jobsite_id', '=', 't.jobsite_id')
                        ->select(
                            'p.title as project_name',
                            'j.jobsite_name',
                            't.title as task_name',
                            't.description',
                            't.status',
                            't.id')
                        ->where('t.title','LIKE','%'.$search.'%')
                        ->where('t.created_by',Session::get('user_id'))
                        ->orderBy('t.id','desc')
                        ->paginate(10);
        }else{
            return DB::table('tasks as t')
                        ->leftJoin('projects as p', 'p.id', '=', 't.project_id')
                        ->leftJoin('jobsite as j', 'j.jobsite_id', '=', 't.jobsite_id')
                        ->select(
                            'p.title as project_name',
                            'j.jobsite_name',
                            't.title as task_name',
                            't.description',
                            't.status',
                            't.id')
                        ->where('t.created_by',Session::get('user_id'))
                        ->orderBy('t.id','desc')
                        ->paginate(10);
        }
        
    }

    public static function list_tasks()
    {
        return self::select('id','title')
               ->where('created_by',Session::get('user_id'))
               ->orderBy('id','asc')
               ->get(); 
    }

    public static function get_filters()
    {
        return [
            "daily-checklist" => "Daily Checklist",
            "todays-task" => "Today's Tasks",
            "delayed-tasks" => "Delayed Tasks",
            "upcoming-tasks" => "Upcoming Tasks",
            "this-week-tasks" => "This Week Tasks",
            "this-month-tasks" => "This Month Tasks",
            "assigned-to-me" => "Assigned To Me",
            "my-tasks" => "My Tasks"
        ];
    }
}
