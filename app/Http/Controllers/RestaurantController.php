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
use Illuminate\Support\Facades\Log; // Import the Log facade

class RestaurantController extends Controller
{
//     public function store(Request $request)
//     {
//         // Validate the request
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Fixed typo
//             'review' => 'nullable|string',
//             'location' => 'nullable|string',
//             'food_id' => 'required|exists:spiner_food,id',
//             'status' => 'nullable|in:pending,recommend',
//             'route' => 'nullable|string', // Added validation for route
//             'cost' => 'required|numeric|min:0', // Corrected spelling and added numeric validation

//             'images.*' => 'nullable|array|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'urls' => 'nullable|array',
//             'urls.facebook_url' => 'nullable|string',
//             'urls.youtube_url' => 'nullable|string',
//             'urls.twitter_url' => 'nullable|string',
//             'urls.whatsapp_url' => 'nullable|string',
//             'urls.instagram_url' => 'nullable|string',
//             'urls.tiktok_url' => 'nullable|string',
//             'menus.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'phone_numbers.*' => 'nullable|string',
//             'branches.*' => 'array',
//             'branches.*.location' => 'nullable|string',
//             'branches.*.phone_numbers.*' => 'nullable|string',
//             'schedule' => 'nullable|array',
//             'schedule.saturday_opening_time' => 'nullable|date_format:H:i',
//             'schedule.saturday_closing_time' => 'nullable|date_format:H:i',
//             'schedule.sunday_opening_time' => 'nullable|date_format:H:i',
//             'schedule.sunday_closing_time' => 'nullable|date_format:H:i',
//             'schedule.monday_opening_time' => 'nullable|date_format:H:i',
//             'schedule.monday_closing_time' => 'nullable|date_format:H:i',
//             'schedule.tuesday_opening_time' => 'nullable|date_format:H:i',
//             'schedule.tuesday_closing_time' => 'nullable|date_format:H:i',
//             'schedule.wednesday_opening_time' => 'nullable|date_format:H:i',
//             'schedule.wednesday_closing_time' => 'nullable|date_format:H:i',
//             'schedule.thursday_opening_time' => 'nullable|date_format:H:i',
//             'schedule.thursday_closing_time' => 'nullable|date_format:H:i',
//         ]);

//         // Log::info('Request validated successfully.', ['validated_data' => $validated]);


//         // Handle main_image upload
//         $mainImageFileName = $request->hasFile('main_image')
//             ? $request->file('main_image')->store('restaurant_images', 'public')
//             : null;

//         // Handle thumbnail_image upload
//         $thumbnailImageFileName = $request->hasFile('thumbnail_image')
//             ? $request->file('thumbnail_image')->store('restaurant_images', 'public')
//             : null;

//         // Create the restaurant
//         $restaurant = Restaurant::create([
//             'name' => $validated['name'],
//             'main_image' => $mainImageFileName,
//             'thumbnail_image' => $thumbnailImageFileName,
//             'review' => $validated['review'] ?? null,
//             'location' => $validated['location'] ?? null,
//             'food_id' => $validated['food_id'],
//             'status' => $validated['status'] ?? null,
//             'route' => $validated['route'] ?? null,
//             'cost' => $validated['cost']// Added route field
//         ]);


// //cost
//         // Handle images upload
//         if ($request->hasFile('images')) {
//             foreach ($request->file('images') as $image) {
//                 $imagePath = $image->store( 'public');
//                 $restaurant->images()->create([
//                     'image_url' => $imagePath,
//                 ]);

//             }
//             return response()->json([
//                 'message' => 'Images uploaded successfully.',
//                 'uploaded_images' => $imagePath,
//             ], 201);
//         }


//         // Handle menus upload
//         if ($request->hasFile('menus')) {
//             dd($request->file('menus'));
//             $uploadedMenus = [];

//             foreach ($request->file('menus') as $menu) {

//                 $menuPath = $menu->store( 'public');


//                 $restaurant->menus()->create([
//                     'menu_image' => $menuPath,
//                 ]);

//                 // Add the uploaded menu path to the array
//                 $uploadedMenus[] = $menuPath;
//             }

//             // Check if any menus were uploaded
//             if (!empty($uploadedMenus)) {
//                 return response()->json([
//                     'message' => 'Menus uploaded successfully.',
//                     'uploaded_menus' => $uploadedMenus,
//                 ], 201);
//             }
//         }

//         // If no menus were uploaded, return a different response
//         return response()->json([
//             'message' => 'No menus were uploaded.'
//         ], 200);

//         // Create URLs
//         if (isset($validated['urls'])) {
//             RestaurantUrl::create(array_merge(
//                 ['restaurant_id' => $restaurant->id],
//                 $validated['urls']
//             ));
//         }

//         // Create phone numbers
//         if (isset($validated['phone_numbers'])) {
//             foreach ($validated['phone_numbers'] as $phoneNumber) {
//                 RestaurantPhoneNumber::create([
//                     'restaurant_id' => $restaurant->id,
//                     'phone_number' => $phoneNumber,
//                 ]);
//             }
//         }

//         // Create branches
//         if (isset($validated['branches'])) {
//             foreach ($validated['branches'] as $branchData) {
//                 $branch = Branch::create([
//                     'restaurant_id' => $restaurant->id,
//                     'location' => $branchData['location'] ?? null,
//                 ]);

//                 if (isset($branchData['phone_numbers'])) {
//                     foreach ($branchData['phone_numbers'] as $phoneNumber) {
//                         BranchPhoneNumber::create([
//                             'branch_id' => $branch->id,
//                             'phone_number' => $phoneNumber,
//                         ]);
//                     }
//                 }
//             }
//         }

//         // Create weekly schedule
//         if (isset($validated['schedule'])) {
//             WeeklySchedule::create(array_merge(
//                 ['restaurant_id' => $restaurant->id],
//                 $validated['schedule']
//             ));
//         }
//         $response_data['restaurant_id'] = $restaurant->id;

//         // Return all request data including uploaded files
//         return response()->json([
//             'message' => 'Restaurant information created successfully.',
//             'data' => $response_data
//         ], 201);
//     }

public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'name_ar' => 'nullable|string|max:255', // Added Arabic name field
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'review' => 'nullable|string',
        'review_ar' => 'nullable|string', // Added Arabic review field
        'location' => 'nullable|string',
        'food_id' => 'required|exists:spiner_food,id',
        'status' => 'nullable|in:pending,recommend',
        'route' => 'nullable|string', // Added validation for route
        'route_ar' => 'nullable|string', // Added Arabic route field
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'urls' => 'nullable|array',
        'urls.facebook_url' => 'nullable|string',
        'urls.youtube_url' => 'nullable|string',
        'urls.twitter_url' => 'nullable|string',
        'urls.whatsapp_url' => 'nullable|string',
        'urls.instagram_url' => 'nullable|string',
        'urls.tiktok_url' => 'nullable|string',
        'menus.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'menu_ar' => 'nullable|array', // Added Arabic menus array
        'menu_ar.*' => 'nullable|string', // Each menu item in Arabic
        'phone_numbers.*' => 'nullable|string',
        'branches.*' => 'array',
        'branches.*.location' => 'nullable|string',
        'branches.*.location_ar' => 'nullable|string', // Added Arabic branch location field
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

    // Initialize an array to store response data
    $response_data = $validated;

    // Handle 'main_image' upload
    if ($request->hasFile('main_image')) {
        $mainImagePath = $request->file('main_image')->store('restaurant_images', 'public');
        $response_data['main_image'] = asset('storage/' . $mainImagePath);
    }

    // Handle 'thumbnail_image' upload
    if ($request->hasFile('thumbnail_image')) {
        $thumbnailImagePath = $request->file('thumbnail_image')->store('restaurant_images', 'public');
        $response_data['thumbnail_image'] = ('storage/' . $thumbnailImagePath);
    }

    // Create the restaurant
    $restaurant = Restaurant::create([
        'name' => $validated['name'],
        'name_ar' => $validated['name_ar'] ?? null, // Save Arabic name
        'main_image' => $mainImagePath ?? null,
        'thumbnail_image' => $thumbnailImagePath ?? null,
        'review' => $validated['review'],
        'review_ar' => $validated['review_ar'] ?? null, // Save Arabic review
        'location' => $validated['location'],
        'food_id' => $validated['food_id'],
        'status' => $validated['status'],
        'route' => $validated['route'], // Save route
        'route_ar' => $validated['route_ar'] ?? null, // Save Arabic route
    ]);

    // Handle 'images' upload
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('restaurant_images', 'public');
            $restaurant->images()->create([
                'image_url' => $imagePath,
            ]);
        }
    }

    // Handle 'menus' upload
    if ($request->hasFile('menus')) {
        foreach ($request->file('menus') as $menu) {
            $menuPath = $menu->store('restaurant_menus', 'public');
            $restaurant->menus()->create([
                'menu_image' => $menuPath,
            ]);
        }
    }

    // Handle 'menu_ar' creation (Arabic menu names)
    if (isset($validated['menu_ar'])) {
        foreach ($validated['menu_ar'] as $menuName) {
            $restaurant->menus()->create([
                'menu_name_ar' => $menuName, // Assuming there's a field to save Arabic menu names
            ]);
        }
    }

    // Handle 'urls' creation
    if (isset($validated['urls'])) {
        RestaurantUrl::create(array_merge(
            ['restaurant_id' => $restaurant->id],
            $validated['urls']
        ));
    }

    // Handle 'phone_numbers' creation
    if (isset($validated['phone_numbers'])) {
        foreach ($validated['phone_numbers'] as $phoneNumber) {
            RestaurantPhoneNumber::create([
                'restaurant_id' => $restaurant->id,
                'phone_number' => $phoneNumber,
            ]);
        }
    }

    // Handle 'branches' creation
    if (isset($validated['branches'])) {
        foreach ($validated['branches'] as $branchData) {
            $branch = Branch::create([
                'restaurant_id' => $restaurant->id,
                'location' => $branchData['location'],
                'location_ar' => $branchData['location_ar'] ?? null, // Save Arabic branch location
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

    // Handle 'schedule' creation
    if (isset($validated['schedule'])) {
        WeeklySchedule::create(array_merge(
            ['restaurant_id' => $restaurant->id],
            $validated['schedule']
        ));
    }

    // Retrieve all related data
    $restaurant->load('images', 'menus', 'urls', 'phoneNumbers', 'branches.phoneNumbers', 'weeklySchedule');

    // Format images and menus for response
    $response_data['images'] = $restaurant->images->map(function ($image) {
        return asset('storage/' . $image->image_url);
    });

    $response_data['menus'] = $restaurant->menus->map(function ($menu) {
        return asset('storage/' . $menu->menu_image);
    });

    // Add restaurant data to the response
    $response_data['restaurant'] = $restaurant;

    // Return all request data including uploaded files and related data
    return response()->json([
        'message' => 'Restaurant information created successfully.',
        'data' => $response_data
    ], 201);
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
        $restaurants = Restaurant::all(['id', 'name', 'main_image', 'review', 'location', 'food_id','thumbnail_image', 'status', 'route']);

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
        $recommendedRestaurants = Restaurant::where('status', 'recommend')
            ->orderBy('value', 'asc')  // Sort by priority field
            ->get();
            return response()->json(['data' => $recommendedRestaurants], 200);    }


    public function getRecommendedRestaurantsbylang($language)
    {
        $recommendedRestaurants = Restaurant::where('status', 'recommend')
            ->orderBy('value', 'asc')  // Sort by priority field
            ->get();

        if ($recommendedRestaurants->isEmpty()) {
            return response()->json(['message' => 'Restaurant not found.'], 404);
        }

        $restaurants = $recommendedRestaurants->map(function($restaurant) use ($language) {
            if ($language === 'en') {
                return [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'main_image' => $restaurant->main_image,
                    'thumbnail_image' => $restaurant->thumbnail_image,
                    'review' => $restaurant->review,
                    'location' => $restaurant->location,
                    'area' => $restaurant->area,
                    'route' => $restaurant->route,
                    'value' => $restaurant->value  // Include priority in the response
                ];
            } elseif ($language === 'ar') {
                return [
                    'id' => $restaurant->id,
                    'name_ar' => $restaurant->name_ar,
                    'main_image' => $restaurant->main_image,
                    'thumbnail_image' => $restaurant->thumbnail_image,
                    'review_ar' => $restaurant->review_ar,
                    'location_ar' => $restaurant->location_ar,
                    'area_ar' => $restaurant->area_ar,
                    'route_ar' => $restaurant->route_ar,
                    // 'value' => $restaurant->value  // Include priority in the response
                ];
            }
        });

        return response()->json(['data' => $restaurants], 200);
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
