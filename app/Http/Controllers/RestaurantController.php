<?php

namespace App\Http\Controllers;

use App\branch;
use Illuminate\Support\Facades\File;
use App\restaurant;
use App\users;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    // ========== all restaurant ==========//
    public function index()
    {
        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;


        $users = users::all();
        $restaurants = restaurant::with('user', 'menus')->get();
        $restaurantFixedLanguage = array();

        // fix all languages
        foreach ($restaurants as $restaurant) {
            if ($restaurant->language == 2) {
                $restaurant->name = $restaurant->name_ar;
                $restaurant->type = $restaurant->type_ar;
                $restaurant->address = $restaurant->address_ar;
                $restaurant->description = $restaurant->description_ar;
            }
            if (strlen($restaurant->logo) == 0) {
                $restaurant->logo = 'placeholder.png';
            }
            foreach ($restaurant->menus as $menu){
                $menu->name = $menu->name_ar;
            }

            $restaurantFixedLanguage[] = $restaurant;
        }

        // moderator
        if ($userRole == 2) {

            $allRestaurants = array();
            foreach ($restaurantFixedLanguage as $restaurant) {
                if ($restaurant->user_id == $moderatorID) {
                    $allRestaurants[] = $restaurant;
                }
            }
            return view('restaurant.restaurants', [ 'users' => $users, 'restaurants' => $allRestaurants]);
        }

        // super admin
        elseif ($userRole == 1) {
            return view('restaurant.restaurants', [ 'users' => $users , 'restaurants' => $restaurantFixedLanguage]);
        }


    }
    // ========== add restaurant ==========//
    public function store(Request $request)
    {

        $request->validate([
            'website' => 'required|unique:restaurant|string|min:4',
            'theme' => 'required',
            'phone_number' => 'required|numeric|min:4',
            'logo' => 'required|mimes:png',
            'user_id' => 'required',

        ]);

        //if english & arabic
        if ($request->language == 0) {
            $request->validate([
                'name' => 'required|unique:restaurant|string|max:255',
                'name_ar' => 'required|unique:restaurant|string|max:255',
                'type' => 'required|string|min:4',
                'type_ar' => 'required|string|min:4',
                'address' => 'required|unique:restaurant|string|min:4',
                'address_ar' => 'required|unique:restaurant|string|min:4',
                'description' => 'required|string|min:4',
                'description_ar' => 'required|string|min:4',
            ]);
        }
        //if only english
        elseif ($request->language == 1) {
            $request->validate([
                'name' => 'required|unique:restaurant|string|max:255',
                'type' => 'required|string|min:4',
                'address' => 'required|unique:restaurant|string|min:4',
                'description' => 'required|string|min:4',
            ]);
            //reset any arabic input value
            $request->name_ar = null;
            $request->type_ar = null;
            $request->address_ar = null;
            $request->description_ar = null;
            $request->branch_address_ar == null;
        }
        // if only arabic
        elseif ($request->language == 2) {
            $request->validate([
                'name_ar' => 'required|unique:restaurant|string|max:255',
                'type_ar' => 'required|string|min:4',
                'address_ar' => 'required|unique:restaurant|string|min:4',
                'description_ar' => 'required|string|min:4',
            ]);
            //reset any english input value
            $request->name = null;
            $request->type = null;
            $request->address = null;
            $request->description = null;
            $request->branch_address == null;
        }

        //save data
        $newRestaurant = new restaurant();
        $newRestaurant->language = $request->language;
        $this->thenSave($request,$newRestaurant);

         // ==== start add branches if exist ====//
        $branch_address = $request->branch_address;
        $branch_address_ar = $request->branch_address_ar;
        for ($count = 0; $count < count($branch_address); $count++) {
            $data = array(
                'branch_address' => $branch_address[$count],
                'branch_address_ar'  => $branch_address_ar[$count],
                'restaurant_id' => $newRestaurant->id,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $insert_data[] = $data;
        }
        if (strlen($data['branch_address']) !== 0 && strlen($data['branch_address']) !== null) {
            $branch = new branch();
            $branch->insert($insert_data);
        } else {
            return true;
        }
    }
    // ========== show restaurant ==========//
    public function show($id)
    {
        $userID = \Auth::user()->id;
        $userRole = \Auth::user()->role;
        $restaurants =  restaurant::where("id", $id)->with('user', 'menus')->get();

        if (count($restaurants) == 0) {
            abort(404);
        }
        if ($userID === $restaurants[0]->user_id || $userRole === 1) {


            foreach ($restaurants as $restaurant){
                //fix language
                if($restaurant->language == 2){
                    foreach($restaurant->menus as $menu){
                        if (strlen($menu->photo) == 0){
                            $menu->photo = 'placeholder.png';
                        }
                        $menu->name = $menu->name_ar;
                        $menu->description = $menu->description_ar;
                        foreach($menu->categories as $category){
                            $category->name = $category->name_ar;
                            foreach($category->items as $item){
                                $item->name = $item->name_ar;
                            }
                        }
                    }
                }
            }

            return view("restaurant.showRestaurant", ['restaurants' => $restaurants]);
        }else{
            return view("unAuthorized.unAuthorized");
        }


    }
    // ========== edit one restaurant ==========//
    public function edit($id)
    {
        $users = users::all();
        $restaurant =  restaurant::where("id", $id)->get();
        if (!$restaurant) {
            abort(404);
        }
        return view("restaurant.editRestaurant", ['restaurants' => $restaurant, 'users' => $users]);
    }
    // ========== update one restaurant ==========//
    public function update(Request $request, $id)
    {
        $request->validate([
            'website' => 'required|string|min:4',
            'theme' => 'required',
            'phone_number' => 'required|numeric|min:4',
            'logo' => 'mimes:png',
            'user_id' => 'required',
        ]);

        // if english & arabic
        if ($request->language == 0) {
            $request->validate([
                'name' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'type' => 'required|string|min:4',
                'type_ar' => 'required|string|min:4',
                'address' => 'required|string|min:4',
                'address_ar' => 'required|string|min:4',
                'description' => 'required|string|min:4',
                'description_ar' => 'required|string|min:4',
            ]);
            // if only english
        } elseif ($request->language == 1) {
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string|min:4',
                'address' => 'required|string|min:4',
                'description' => 'required|string|min:4',
            ]);
            $request->name_ar = null;
            $request->type_ar = null;
            $request->address_ar = null;
            $request->description_ar = null;
            // if only arabic
        } elseif ($request->language == 2) {
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'type_ar' => 'required|string|min:4',
                'address_ar' => 'required|string|min:4',
                'description_ar' => 'required|string|min:4',
            ]);
            $request->name = null;
            $request->type = null;
            $request->address = null;
            $request->description = null;
        }

        // save data
        $editRestaurant = restaurant::find($id);
        $this->thenSave($request,$editRestaurant);



         // ==== start add branches if exist ====//
        $branch_address = $request->branch_address;
        $branch_address_ar = $request->branch_address_ar;
        for ($count = 0; $count < count($branch_address); $count++) {
            $data = array(
                'branch_address' => $branch_address[$count],
                'branch_address_ar'  => $branch_address_ar[$count],
                'restaurant_id' => $editRestaurant->id,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $insert_data[] = $data;
        }
        if (strlen($data['branch_address']) !== 0 && strlen($data['branch_address']) !== null) {
            $branch = new branch();
            $branch->insert($insert_data);
        } else {
            return true;
        }
    }
    // ========== delete restaurant ==========//
    public function destroy($id)
    {
        $restaurant =  restaurant::find($id);
        if (!$restaurant) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/restauranLogo' . "/" . $restaurant->logo))) {
            File::delete(public_path('assets/images/restauranLogo' . "/" . $restaurant->logo));
        }
        $restaurant->delete();
    }
    //============== then save ==============//
    public function thenSave($request , $restaurant){
        // SAVE USER PHOTO
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/restauranLogo');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW USER DATA INTO DATABASE
        $restaurant->name = $request->name;
        $restaurant->name_ar = $request->name_ar;
        $restaurant->type = $request->type;
        $restaurant->type_ar = $request->type_ar;
        $restaurant->address = $request->address;
        $restaurant->address_ar = $request->address_ar;
        $restaurant->description = $request->description;
        $restaurant->description_ar = $request->description_ar;
        $restaurant->website = $request->website;
        $restaurant->theme = $request->theme;
        $restaurant->phone_number = $request->phone_number;
        if ($request->hasFile('logo')) {
            $restaurant->logo = $request->logo;
            $restaurant->logo = $path;
        }
        $restaurant->user_id = $request->user_id;
        $restaurant->save();
    }
}
