<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use DB;
use App\categories;
use App\category_menu;
use App\items;
use App\menus;
use App\restaurant;
use App\users;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToArray;

class CategoryController extends Controller
{
    // ==========   ALL category  ==========//
    public function index()
    {
        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;

        $restaurants = restaurant::all();
        $categories = categories::get();




        foreach ($categories as $category) {
            if ($category->restaurant->language == 2) {
                $category->name = $category->name_ar;
                $category->description = $category->description_ar;
                $category->restaurant->name = $category->restaurant->name_ar;

                foreach ($category->menus as $menu){
                    $menu->name = $menu->name_ar;
                }
                foreach ($category->items as $item){
                    $item->name = $item->name_ar;
                }


            }
            if (strlen($category->photo) == 0) {
                $category->photo = 'placeholder.png';
            }

        }

        if ($userRole == 2) {

            $allCategories = array();
            foreach ($categories as $category) {
                if ($category->restaurant->user_id == $moderatorID) {
                    $allCategories[] = $category;
                }
            }

            $allRestaurants = array();
            foreach ($restaurants as $restaurant) {
                if ($restaurant->user_id == $moderatorID) {
                    $allRestaurants[] = $restaurant;
                }
            }
            return view('category.categories', ['categories' => $allCategories, 'restaurants' => $allRestaurants]);
        }

        // super admin
        elseif ($userRole == 1) {
            return view('category.categories', ['categories' => $categories, 'restaurants' => $restaurants]);
        }

    }
    // ========== add category ==========//
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);
            $this->validator($request);
            $newCategory = new categories();
            $this->thenSave($request,$newCategory);


        if ($request->item_id) {
            $newCategory->items()->syncWithoutDetaching($request->item_id);
        }
        if ($request->menu_id) {
            $newCategory->menus()->syncWithoutDetaching($request->menu_id);
        }
    }
    // ========== show one category ==========//
    public function show($id)
    {

        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $categories =  categories::where("id", $id)->with('restaurant')->get();

         // not found
         if (count($categories) == 0) {
            abort(404);
        }

             //authorized
             if ($userID === $categories[0]->restaurant->user_id || $userRole === 1) {

                //fix language
                foreach ($categories as $category) {
                    if($category->restaurant->language == 2){
                        $category->name = $category->name_ar;

                        foreach ($category->restaurant->menus as $menu){
                            $menu->name = $menu->name_ar;
                        }

                        foreach ($category->menus as $menu){
                            $menu->name = $menu->name_ar;
                            $menu->description = $menu->description_ar;
                        }
                        foreach ($category->restaurant->items as $item){
                            $item->name = $item->name_ar;
                            $item->description = $item->description_ar;
                        }
                        foreach ($category->items as $item){
                            $item->name = $item->name_ar;
                            $item->description = $item->description_ar;
                        }
                    }
                    if(strlen($category->photo == 0)){
                        $category->photo = 'placeholder.png';
                    }

                    return view("category.showCategory", ['categories' => $categories]);
                }
            } else { // unauthorized
                return view("unAuthorized.unAuthorized");
            }

    }
    // ========== edit one category ==========//
    public function edit($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $categories = categories::where('id', $id)->with('restaurant')->get();

         // not found
         if (count($categories) == 0) {
            abort(404);
        }

        if ($userID === $categories[0]->restaurant->user_id || $userRole === 1) {
            return view('category.editCategory', ['categories' => $categories]);
        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }

    }
    // ========== update one category ==========//
    public function update(Request $request, $id)
    {

        $this->validator($request);
        $category = categories::find($id);
        $this->thenSave($request,$category);

    }
    // ========== delete one category  ==========//
    public function destroy($id)
    {
        $category =  categories::find($id);
        if (!$category) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/categoryPhoto' . "/" . $category->photo))) {
            File::delete(public_path('assets/images/categoryPhoto' . "/" . $category->photo));
        }
        $category->delete();
    }
    // ========== then save  ==========//
    public function thenSave($request , $category){
        if ($request->hasFile('photo')) {       // SAVE MENU PHOTO
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/categoryPhoto');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW MENU DATA INTO DATABASE
        $category->name = $request->name;
        $category->name_ar = $request->name_ar;
        $category->is_visible = $request->is_visible;
        $category->description = $request->description;
        $category->description_ar = $request->description_ar;
        if ($request->hasFile('photo')) {
            $category->photo = $request->photo;
            $category->photo = $path;
        }
        $category->sort_no = $request->sort_no;
        $category->restaurant_id = $request->restaurant_id;
        $category->save();
    }
    // ========== validator  ==========//
    public function validator($request){
        $request->validate([
            'photo' => 'mimes:jpeg,png,jpg,gif,svg',
            'is_visible' => 'required|string|min:1',
            'sort_no' => 'required|string|min:1',
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
        } elseif ($request->language == 1) {          //if only english
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|min:4',
            ]);
            $request->name_ar = null;       //reset any arabic input value
            $request->description_ar = null;
        }
        // if only arabic
        elseif ($request->language == 2) {
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'description_ar' => 'required|string|min:4',
            ]);
            $request->name = null;      //reset any arabic input value
            $request->description = null;
        }
    }
}
