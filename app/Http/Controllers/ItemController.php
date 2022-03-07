<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use DB;
use App\categories;
use App\menus;
use App\restaurant;
use App\users;
use App\items;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // ========== VIEW ALL ITEM DATA ==========//
    public function index()
    {

        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;

        $items = items::get();
        $itemsFixedLanguage = array();

        $restaurants = restaurant::get();
        $restaurantFixedLanguage = array();

        // fix all languages
        foreach ($items as $item) {
            if ($item->restaurant->language == 2) {
                $item->name = $item->name_ar;
                $item->description = $item->description_ar;
                $item->restaurant->name = $item->restaurant->name_ar;
            }
            if (strlen($item->photo) == 0) {
                $item->photo = 'placeholder.png';
            }

            $itemsFixedLanguage[] = $item;
        }

        foreach ($restaurants as $restaurant) {
            if ($restaurant->language == 2) {
                $restaurant->name = $restaurant->name_ar;
                $restaurant->description = $restaurant->description_ar;
            }
            $restaurantFixedLanguage[] = $restaurant;
        }

        // moderator
        if ($userRole == 2) {

            $allItems = array();
            foreach ($itemsFixedLanguage as $item) {
                if ($item->restaurant->user_id == $moderatorID) {
                    $allItems[] = $item;
                }
            }

            $allRestaurants = array();
            foreach ($restaurantFixedLanguage as $restaurant) {
                if ($restaurant->user_id == $moderatorID) {
                    $allRestaurants[] = $restaurant;
                }
            }
            return view('items.items', ['items' => $allItems, 'restaurants' => $allRestaurants]);
        }

        // super admin
        elseif ($userRole == 1) {
            return view('items.items', ['items' => $itemsFixedLanguage, 'restaurants' => $restaurantFixedLanguage]);
        }
    }
    // ========== CREATE NEW ITEM DATA ==========//
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $this->validateRequest($request);
        $Item = new items();
        $this->thenSave($request,$Item);
        if ($request->category_id) {
            $Item->categories()->syncWithoutDetaching($request->category_id);
        }
    }
    // ========== VIEW ALL ITEM DATA ==========//
    public function show($id)
    {
        $itemsFixedLanguage = array();
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $items =  items::where("id", $id)->get();

        // not found
        if (count($items) == 0) {
            abort(404);
        }

        //authorized
        if ($userID === $items[0]->restaurant->user_id || $userRole === 1) {

            foreach ($items as $item) {
                // fix language
                if ($item->restaurant->language == 2) {
                    $item->name = $item->name_ar;
                    $item->description = $item->description_ar;
                    $item->restaurant->name = $item->restaurant->name_ar;
                    foreach ($item->categories as $category) {
                        $category->name = $category->name_ar;
                        $category->description = $category->description_ar;
                    }
                    foreach ($item->restaurant->categories as $category) {
                        $category->name = $category->name_ar;
                    }
                }
                if (strlen($item->photo) == 0) {
                    $item->photo = 'placeholder.png';
                }
                $itemsFixedLanguage[] = $item;
                return view("items.showItem", ['items' => $itemsFixedLanguage]);
            }
        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }
    }
    // ========== SHOW SINGLE ITEM BY ID  ==========//
    public function edit($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $items = items::where('id', $id)->with('restaurant')->get();

        // not found
        if (count($items) == 0) {
            abort(404);
        }


        if ($userID === $items[0]->restaurant->user_id || $userRole === 1) {
            return view('items.editItem', ['items' => $items]);
        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }
    }
    // ========== UPDATE ITEM DATA ==========//
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $Item = items::find($id);
        $this->thenSave($request,$Item);
    }
    // ========== DELETE ITEM DATA ==========//
    public function destroy($id)
    {
        $item =  items::find($id);
        if (!$item) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/itemPhoto' . "/" . $item->photo))) {
            File::delete(public_path('assets/images/itemPhoto' . "/" . $item->photo));
        }
        $item->delete();
    }
    //===================== validator ===================//
    public function validateRequest($request)
    {

        $request->validate([
            'photo' => 'mimes:jpeg,png,jpg,gif,svg',
            'is_visible' => 'required|string|min:1',
            'sort_no' => 'required|string|min:1',
            'price' => 'required|min:1',
            'restaurant_id' => 'required',
        ]);

        //if english & arabic
        if ($request->language == 0) {
            $request->validate([
                'name' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'description' => 'required|string|min:4',
                'description_ar' => 'required|string|min:4',
            ]);
        }
        //if only english
        elseif ($request->language == 1) {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|min:4',
            ]);
            //reset any arabic input value
            $request->name_ar = null;
            $request->description_ar = null;
        }
        // if only arabic
        elseif ($request->language == 2) {
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'description_ar' => 'required|string|min:4',
            ]);
            //reset any arabic input value
            $request->name = null;
            $request->description = null;
        }
    }
    //================= saver =====================//
    public function thenSave($request, $Item)
    {
        // SAVE ITEM PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/itemPhoto');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW ITEM DATA INTO DATABASE
        $Item->name = $request->name;
        $Item->name_ar = $request->name_ar;
        $Item->description = $request->description;
        $Item->description_ar = $request->description_ar;
        $Item->is_visible = $request->is_visible;
        if ($request->hasFile('photo')) {
            $Item->photo = $request->photo;
            $Item->photo = $path;
        }
        $Item->sort_no = $request->sort_no;
        $Item->price = $request->price;
        $Item->restaurant_id = $request->restaurant_id;
        $Item->save();

    }
}
