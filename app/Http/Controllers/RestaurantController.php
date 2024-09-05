<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantImage;
use App\Models\RestaurantUrl;
use App\Models\RestaurantMenu;
use App\Models\RestaurantPhoneNumber;
use App\Models\Branch;
use App\Models\BranchPhoneNumber;
use App\Models\WeeklySchedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class RestaurantController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'main_image' => 'nullable|string',
            'review' => 'nullable|string',
            'location' => 'nullable|string',
            'food_id' => 'required|exists:SpinerFood,id',
            'status' => 'nullable|in:pending,recommend',
            'route' => 'nullable|string', // Added validation for route
            'images.*' => 'nullable|string',
            'urls' => 'nullable|array',
            'urls.facebook_url' => 'nullable|string',
            'urls.youtube_url' => 'nullable|string',
            'urls.twitter_url' => 'nullable|string',
            'urls.whatsapp_url' => 'nullable|string',
            'urls.instagram_url' => 'nullable|string',
            'urls.tiktok_url' => 'nullable|string',
            'menus.*' => 'nullable|string',
            'phone_numbers.*' => 'nullable|string',
            'branches.*' => 'array',
            'branches.*.location' => 'nullable|string',
            'branches.*.phone_numbers.*' => 'nullable|string',
            'schedule' => 'nullable|array',
            'schedule.saturday_opening_time' => 'nullable|date_format:H:i',
            'schedule.saturday_closing_time' => 'nullable|date_format:H:i',
            'schedule.sunday_opening_time' => 'nullable|date_format:H:i',
            'schedule.sunday_closing_time' => 'nullable|date_format:H:i',
            'schedule.monday_opening_time' => 'nullable|date_format:H:i',
            'schedule.monday_closing_time' => 'nullable|date_format:H:i',
            'schedule.tuesday_opening_time' => 'nullable|date_format:H:i',
            'schedule.tuesday_closing_time' => 'nullable|date_format:H:i',
            'schedule.wednesday_opening_time' => 'nullable|date_format:H:i',
            'schedule.wednesday_closing_time' => 'nullable|date_format:H:i',
            'schedule.thursday_opening_time' => 'nullable|date_format:H:i',
            'schedule.thursday_closing_time' => 'nullable|date_format:H:i',
        ]);

        // Create the restaurant
        $restaurant = Restaurant::create([
            'name' => $validated['name'],
            'main_image' => $validated['main_image'],
            'review' => $validated['review'],
            'location' => $validated['location'],
            'food_id' => $validated['food_id'],
            'status' => $validated['status'],
            'route' => $validated['route'], // Added route field
        ]);

        // Create images
        if (isset($validated['images'])) {
            foreach ($validated['images'] as $image) {
                RestaurantImage::create([
                    'restaurant_id' => $restaurant->id,
                    'image_url' => $image,
                ]);
            }
        }

        // Create URLs
        if (isset($validated['urls'])) {
            RestaurantUrl::create(array_merge(
                ['restaurant_id' => $restaurant->id],
                $validated['urls']
            ));
        }

        // Create menus
        if (isset($validated['menus'])) {
            foreach ($validated['menus'] as $menu) {
                RestaurantMenu::create([
                    'restaurant_id' => $restaurant->id,
                    'menu_image' => $menu,
                ]);
            }
        }

        // Create phone numbers
        if (isset($validated['phone_numbers'])) {
            foreach ($validated['phone_numbers'] as $phoneNumber) {
                RestaurantPhoneNumber::create([
                    'restaurant_id' => $restaurant->id,
                    'phone_number' => $phoneNumber,
                ]);
            }
        }

        // Create branches
        if (isset($validated['branches'])) {
            foreach ($validated['branches'] as $branchData) {
                $branch = Branch::create([
                    'restaurant_id' => $restaurant->id,
                    'location' => $branchData['location'],
                ]);

                if (isset($branchData['phone_numbers'])) {
                    foreach ($branchData['phone_numbers'] as $phoneNumber) {
                        BranchPhoneNumber::create([
                            'branch_id' => $branch->id,
                            'phone_number' => $phoneNumber,
                        ]);
                    }
                }
            }
        }

        // Create weekly schedule
        if (isset($validated['schedule'])) {
            WeeklySchedule::create(array_merge(
                ['restaurant_id' => $restaurant->id],
                $validated['schedule']
            ));
        }

        return response()->json(['message' => 'Restaurant information created successfully.'], 201);
    }





       public function index()
    {
        $restaurants = Restaurant::with([
            'images',
            'urls',
            'menus',
            'phoneNumbers',
            'branches.phoneNumbers',
            'weeklySchedule'
        ])->get();

        return response()->json($restaurants);
    }

    public function get()
    {
        // Fetch all restaurants with specified fields
        $restaurants = Restaurant::all(['id', 'name', 'main_image', 'review', 'location', 'food_id', 'status', 'route']);

        // Return the restaurants as a JSON response
        return response()->json($restaurants);
    }





    public function show($id)
    {
        try {
            $restaurant = Restaurant::with([
                'images',
                'urls',
                'menus',
                'phoneNumbers',
                'branches.phoneNumbers',
                'weeklySchedule'
            ])->findOrFail($id);

            return response()->json($restaurant);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Restaurant not found.'], 404);
        }
    }


    public function search(Request $request)
    {
        $query = Restaurant::query();

        // Apply filters based on request parameters
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('food_type')) {
            $query->where('food_type', $request->input('food_type'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }


        if ($request->has('branch_location')) {
            $query->whereHas('branches', function ($q) use ($request) {
                $q->where('location', 'like', '%' . $request->input('branch_location') . '%');
            });
        }

        // You can add more filters here based on other columns if needed

        $restaurants = $query->get();

        return response()->json(['data' => $restaurants], 200);
    }



    public function getRecommendedRestaurants()
    {
        $recommendedRestaurants = Restaurant::where('status', 'recommend')->get();

        if ($recommendedRestaurants->isEmpty()) {
            return response()->json(['message' => 'Restaurant not found.'], 404);
        }
        \DB::listen(function ($query) {
            \Log::info($query->sql, $query->bindings);
        });

        return response()->json(['data' => $recommendedRestaurants], 200);
    }




    public function getByFoodId($food_id)
    {
        // Validate that the food_id is numeric (Optional)
        if (!is_numeric($food_id)) {
            return response()->json(['error' => 'Invalid food ID'], 400);
        }


        $restaurants = Restaurant::where('food_id', $food_id)->get();


        if ($restaurants->isEmpty()) {
            return response()->json(['message' => 'No restaurants found for this food type'], 404);
        }

        // Return the restaurants as a JSON response
        return response()->json($restaurants, 200);
    }



    public function getRestaurantsSortedByPrice()
    {
        $restaurants = Restaurant::query()
        ->leftJoin('visitor_actions', 'restaurants.id', '=', 'visitor_actions.restaurant_id')
        ->select('restaurants.id', 'restaurants.name', 'restaurants.main_image', 'restaurants.review', 'restaurants.location', 'restaurants.status', 'restaurants.food_id', 'restaurants.cost')
        ->selectRaw('COUNT(visitor_actions.id) as visitor_count') // Count the number of occurrences in visitor_actions
        ->groupBy('restaurants.id', 'restaurants.name', 'restaurants.main_image', 'restaurants.review', 'restaurants.location', 'restaurants.status', 'restaurants.food_id', 'restaurants.cost') // Group by restaurant columns
        ->orderBy('restaurants.cost', 'desc') // Sort by cost (high to low)
        ->orderBy('visitor_count', 'desc') // If costs are the same, sort by visitor_count (high to low)
        ->get();

        return response()->json($restaurants, 200);
    }

    public function getAllRestaurantsRandomly()
    {
        // Retrieve all restaurants in a random order
        $restaurants = Restaurant::inRandomOrder()->get();

        // Return the list of restaurants
        return response()->json($restaurants, 200);
    }
}
