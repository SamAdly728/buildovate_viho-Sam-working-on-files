<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Timeline;

class TimelineController extends Controller
{
    //
    // Display a listing of the items.
    public function index()
    {
        $items = Timeline::all();
        return Inertia::render('timeline/Timeline',
        [
            'lists' => $items,
        ]);

        //return response()->json($items);
    }

        //
    // Display a listing of the items.
    public function fetch()
    {
        $items = Timeline::all();

        return response()->json($items);
    }

    // Store a newly created item in storage.
    public function store(Request $request)
    {
        $item = Timeline::create($request->all());
        return response()->json($item, 201);
    }

    // Display the specified item.
    public function show($id)
    {
        $item = Timeline::find($id);
        if (!$item) {
            return response()->json(['message' => 'Not Found!'], 404);
        }
        return response()->json($item);
    }

    // Update the specified item in storage.
    public function update(Request $request, $id)
    {
        $item = Timeline::find($id);
        if (!$item) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        $item->update($request->all());
        return response()->json($item);
    }

    // Remove the specified item from storage.
    public function destroy($id)
    {
        $item = Timeline::find($id);
        if (!$item) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        $item->delete();
        return response()->json(['message' => 'Deleted successfully!'], 200);
    }
}
