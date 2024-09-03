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
}
