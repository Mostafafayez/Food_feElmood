<?php

namespace App\Http\Controllers;

use App\Models\VisitorAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VisitorActionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|string|ip',
            'action' => 'required|string|max:255',
            'restaurant_id' => 'nullable|exists:restaurants,id'
        ]);

        $visitorAction = VisitorAction::create([
            'ip_address' => $validated['ip_address'],
            'action' => $validated['action'],
            'restaurant_id' => $validated['restaurant_id']
        ]);

        return response()->json(['message' => 'Visitor action logged successfully', 'data' => $visitorAction], 201);
    }


    public function actionCounts(Request $request)
    {
        // Fetch counts of each action
        $actionCounts = VisitorAction::select('action', DB::raw('count(*) as count'))
            ->groupBy('action')
            ->get();

        return response()->json(['data' => $actionCounts], 200);
    }





    public function actionCountsById(Request $request, $id)
    {
        // Fetch counts of each action for the specific id
        $actionCounts = VisitorAction::select('action', DB::raw('count(*) as count'))
            ->where('restaurant_id', $id)  // Add condition to filter by id
            ->groupBy('action')
            ->get();

        return response()->json(['data' => $actionCounts], 200);
    }


    public function getHomepageActions()
    {
        // Fetch actions where restaurant_id is null and group by action
        $actions = VisitorAction::select('action', \DB::raw('count(*) as count'))
            ->whereNull('restaurant_id')
            ->groupBy('action')
            ->get();

        return response()->json($actions);
    }



    public function getVisitorCount()
    {
        // Count visitors grouped by ip_address and restaurant_id
        $visitorCounts = VisitorAction::select('restaurant_id', 'ip_address', \DB::raw('count(*) as count'))
            ->groupBy('restaurant_id', 'ip_address')
            ->get();

        return response()->json($visitorCounts);
    }


    public function getUniqueVisitorCount()
    {
        // Count unique visitors grouped by restaurant_id
        $visitorCounts = VisitorAction::select('restaurant_id',\DB::raw('count(*) as total_visitors'))
            ->groupBy('restaurant_id')
            ->get();

        return response()->json($visitorCounts);
    }

}
