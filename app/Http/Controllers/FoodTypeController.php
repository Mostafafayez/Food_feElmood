<?php

namespace App\Http\Controllers;

use App\Models\SpinerFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class FoodTypeController extends Controller
{
    // Get all rows
    public function index()
    {
        $foods = SpinerFood::all();  // Retrieve all records
        return response()->json($foods);
    }

    // Add a new row
    public function store(Request $request)
    {
        $request->validate([
            'food_type' => 'required|string|max:255',
            'status' => 'nullable|in:true,false',
           ]);

        // Create new SpinerFood entry with priority as the row count
        $food = SpinerFood::create([
            'food_type' => $request->food_type,
            'status' => $request->status,
            'priority' => SpinerFood::count() + 1,
        ]);
        log::info( $food);

        return response()->json($food, 201);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'food_type' => 'nullable|string|max:255',
            'priority' => 'nullable|integer',
            'status' => 'nullable|in:true,false',
        ]);

        $food = SpinerFood::find($id);  // Find the row by ID

        if (!$food) {
            return response()->json(['message' => 'Food not found'], 404);
        }


        if ($request->has('food_type')) {
            $food->food_type = $request->food_type;
        }
        if ($request->has('priority')) {
            $food->priority = $request->priority;
        }
        if ($request->has('status')) {
            $food->status = $request->status;
        }

        $food->save();  // Save the updated row

        return response()->json($food);
    }


    public function destroy($id)
    {
        $food = SpinerFood::find($id);  // Find the row by ID

        if (!$food) {
            return response()->json(['message' => 'Food not found'], 404);
        }

        $food->delete();  // Delete the row

        return response()->json(['message' => 'Food deleted successfully']);
    }
}
