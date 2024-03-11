<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CalendarGAPI;
use App\Services\S3Manager;
use Google_Client;
use Google_Service_Calendar;

use App\Repositories\FilesRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Input;

use Inertia\Inertia;

use App\Models\Jobsite;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

use App\Models\KanbanList;
use App\Models\KanbanCard;


use App\Repositories\CalendarRepository;

class ProjectsController extends Controller
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
     * @var FilesRepository
     */
    private FilesRepository $file;
    public function __construct(CalendarRepository $calendar, S3Manager $s3, FilesRepository $file)
    {
        $this->file = $file;
        $this->calendar = $calendar;
        $this->s3 = $s3;
    }

    public function index(Request $request)
    {

        $lists = KanbanList::select('id','title')->orderBy('sort','asc')->get();

        $cards = KanbanCard::select('kanban_list_id as list_id','id','title','thumbnail','deadline','description')
                ->where('created_by',Session::get('user_id'))
                ->orderBy('sort','asc')
                ->get();

        $card_data = array();
        if($cards)
        {
            $data = array();
            foreach($cards as $card)
            {
                if(!isset($card_data[$card->list_id]))
                {
                    $card_data[$card->list_id] = array();
                }
                
                $card_data[$card->list_id][] = (object)[
                    'id' => $card->id,
                    'title' => $card->title,
                    'thumbnail' => $card->thumbnail,
                    'deadline' => date('M d'),//'',$card->deadline,
                    'has_comments' => rand(1,8), //todo
                    'has_description' => rand(1,8), //todo
                    'has_attachments' => rand(1,8), //todo
                    'has_members' => rand(1,8), //todo
                    'has_labels' => false, //todo
                ];
            }
        }

        return Inertia::render('Projects', [
            'lists' => $lists,
            'cards' => $card_data,
            'recentFiles' => $this->file->getRecentFiles(),
            'sessionVars' => session()->all()
        ]);
    }

    public function kanban(Request $request)
    {
        $lists = KanbanList::select('id','title')->orderBy('sort','asc')->get();

        $cards = KanbanCard::select('kanban_list_id as list_id','id','title','thumbnail','deadline','description')
                ->where('created_by',Session::get('user_id'))
                ->orderBy('sort','asc')
                ->get();

        $card_data = array();
        if($cards)
        {
            $data = array();
            foreach($cards as $card)
            {
                if(!isset($card_data[$card->list_id]))
                {
                    $card_data[$card->list_id] = array();
                }
                
                $card_data[$card->list_id][] = (object)[
                    'id' => $card->id,
                    'title' => $card->title,
                    'thumbnail' => $card->thumbnail,
                    'deadline' => date('M d'),//'',$card->deadline,
                    'has_comments' => rand(1,8), //todo
                    'has_description' => rand(1,8), //todo
                    'has_attachments' => rand(1,8), //todo
                    'has_members' => rand(1,8), //todo
                    'has_labels' => false, //todo
                ];
            }
        }

        return Inertia::render('projects/Kanban', [
            'lists' => $lists,
            'cards' => $card_data
        ]);
    }

    public function installer_status(Request $request)
    {
        return Inertia::render('projects/Installers', []);
    }

    public function schedule(Request $request)
    {
        return Inertia::render('projects/Schedule', []);
    }
    
    public function receivables(Request $request)
    {
        return Inertia::render('projects/Receivables', []);
    }

    public function payables(Request $request)
    {
        return Inertia::render('projects/Payables', []);
    }

    public function checklists(Request $request)
    {
        return Inertia::render('projects/Checklists', []);
    }

    public function reports(Request $request)
    {
        return Inertia::render('projects/Reports', []);
    }

    public function agreements(Request $request)
    {
        return Inertia::render('projects/Agreements', []);
    }

    public function timelines(Request $request)
    {
        return Inertia::render('projects/Timelines', []);
    }

    public function payments(Request $request)
    {
        return Inertia::render('projects/Payments', []);
    }

}
