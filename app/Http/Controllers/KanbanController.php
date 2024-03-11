<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\KanbanList;
use App\Models\KanbanCard;

use Inertia\Inertia;

class KanbanController extends Controller
{

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
        
        // echo "<pre>";
        // print_r($boards);
        // exit();

        return Inertia::render('Kanban',
            [
                'pageTitle' => "Kanban",
                'lists' => $lists,
                'cards' => $card_data
            ]);
    }

    public function add_list(Request $request)
    {
        $title = trim($request->get('list_title'));
        $success = false;
        $msg = '';
        $last_id = 0;
        if($title!='')
        {
            $exist = KanbanList::where('title',$title)->where('created_by',Session::get('user_id'))->count();
            if($exist>0)
            {
                $msg = 'List already exist';
            }else{
                $last_id = KanbanList::insertGetId([
                            'title' => $title,
                            'created_by' => Session::get('user_id'),
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                if($last_id>0)
                {
                    $success = true; 
                    $msg = 'List added.';
                }
            }

            return response()->json([
                'success' => $success,
                'message' => $msg,
                'last_id' => $last_id
            ]);
        }
    }

    //get cards belonging to a list
    public function get_cards(Request $request)
    {
        $list_id = $request->get('list_id');
        if($list_id>0)
        {
            $cards = KanbanCard::select('id','title','thumbnail','deadline','description')
                    ->where('kanban_list_id',$list_id)
                    ->where('created_by',Session::get('user_id'))
                    ->orderBy('sort','asc')
                    ->get();
            if($cards)
            {
                $data = array();
                foreach($cards as $card)
                {
                    $data[] = (object)[
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

            return response()->json([
                'cards' => $data
            ]);
        }
    }
    
    // get single card details
    public function get_card(Request $request)
    {
        $card_id = $request->get('card_id');
        if($card_id>0)
        {
            $card = KanbanCard::select('id','title','thumbnail','deadline','description')
                    ->where('id',$card_id)
                    ->where('created_by',Session::get('user_id'))
                    ->orderBy('sort','asc')
                    ->first();

            return response()->json([
                'card' => $card
            ]);
        }
    }

    public function add_card(Request $request)
    {
        $list_id = trim($request->get('list_id'));
        $title = trim($request->get('card_title'));

        $success = false;
        $msg = '';
        $last_id = 0;

        if($list_id>0 && $title!='')
        {
            $exist = KanbanCard::where('title',$title)->where('created_by',Session::get('user_id'))->count();
            if($exist>0)
            {
                $msg = 'Card already exist';
            }else{
                $last_id = KanbanCard::insertGetId([
                            'kanban_list_id' => $list_id,
                            'title' => $title,
                            'created_by' => Session::get('user_id'),
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                if($last_id>0)
                {
                    $success = true; 
                    $msg = 'Card added.';
                }
            }

            return response()->json([
                'success' => $success,
                'message' => $msg,
                'last_id' => $last_id
            ]);
        }
    }

    
    
}
