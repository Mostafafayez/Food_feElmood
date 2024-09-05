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

        // Calculate the total weight (sum of all weights)
        $totalWeight = 0;

        // Array to hold weights of each food item
        $weightedFoods = [];

        foreach ($foods as $food) {
            // Weight calculation: The lower the priority number, the higher the weight
            $weight = 1 / ($food->priority ?: 1);  // Ensure no division by zero
            $totalWeight += $weight;
            $weightedFoods[] = ['food' => $food, 'weight' => $weight];
        }

        // Select a random item based on the weights
        $randomValue = mt_rand() / mt_getrandmax();  // Random float between 0 and 1
        $cumulativeWeight = 0;

        foreach ($weightedFoods as $weightedFood) {
            $cumulativeWeight += $weightedFood['weight'] / $totalWeight;  // Normalize weight

            if ($randomValue <= $cumulativeWeight) {
                return response()->json($weightedFood['food']);
            }
        }

        return response()->json(['message' => 'No food found with status true'], 404);
    }

}
