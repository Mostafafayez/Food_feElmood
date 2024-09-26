<?php

namespace App\Http\Controllers;

use App\Models\SpinerFood;
use Illuminate\Http\Request;

class FoodSpinerController extends Controller
{
    /**
     * Get all foods where status is 'true'
     */
    public function getAllFoodsWithStatusTrue()
    {
        // Retrieve all records where status is 'true'
        $foods = SpinerFood::where('status', 'true')->get();

        return response()->json($foods);
    }

    /**
     * Get the food with the highest priority where status is 'true'
     */
    public function getMostPriorityFood()
    {
        // Retrieve all foods where status is 'true'
        $foods = SpinerFood::where('status', 'true')->get();

        if ($foods->isEmpty()) {
            return response()->json(['message' => 'No food found with status true'], 404);
        }


      
        














        
        return response()->json(['message' => 'No food found with status true'], 404);
    }

}
