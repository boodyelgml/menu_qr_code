<?php

namespace App\Http\Controllers;

use App\categories;
use App\menus;
use App\restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenusController extends Controller
{
    // ========== VIEW ALL MENU DATA ==========//
    public function index()
    {
        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;
        // get all users from database
        $restaurants = restaurant::all();
        $menus = menus::with('restaurant', 'categories')->get();

        foreach ($menus as $menu) {
            if (strlen($menu->photo) == 0) {
                $menu->photo == 'placeholder.png';
            }
            if ($menu->restaurant->language == 2) {
                $menu->restaurant->name = $menu->restaurant->name_ar;
                $menu->name = $menu->name_ar;
                $menu->description = $menu->description_ar;
                foreach ($menu->categories as $category) {
                    $category->name = $category->name_ar;
                }
            }
        }
        // moderator
        if ($userRole == 2) {
            $allMenus = array();
            foreach ($menus as $menu) {
                if ($menu->restaurant->user_id == $moderatorID) {
                    $allMenus[] = $menu;
                }
            }
            $allRestaurants = array();
            foreach ($restaurants as $restaurant) {
                if ($restaurant->user_id == $moderatorID) {
                    $allRestaurants[] = $restaurant;
                }
            }
            return view('menu.menus', ['menus' => $allMenus, 'restaurants' => $allRestaurants]);
        }

        // super admin
        elseif ($userRole == 1) {
            return view("menu.menus", ['menus' => $menus, 'restaurants' => $restaurants]);
        }
    }
    // ========== CREATE NEW MENU DATA ==========//
    public function store(Request $request)
    {
        //validate data
        $request->validate([
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $this->validator($request);
        $newMenu = new menus();
        $this->thenSave($request, $newMenu);

        if ($request->category_id) {
            $newMenu->categories()->syncWithoutDetaching($request->category_id);
        }
        if ($request->branch_id) {
            $newMenu->branches()->syncWithoutDetaching($request->branch_id);
        }
    }
    // ========== VIEW ALL MENU DATA ==========//
    public function show($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $menus = menus::where("id", $id)->with('restaurant', 'categories', 'branches')->get();
        // not found
        if (count($menus) == 0) {
            abort(404);
        }
        foreach($menus as $menu){
            if (strlen($menu->photo) == 0){
                $menu->photo = 'placeholder.png';
            }
            if($menu->restaurant->language == 2){
                $menu->name = $menu->name_ar;
                $menu->restaurant->name = $menu->restaurant->name_ar;
            }
            foreach(($menu->categories) as $category){
                if(strlen($category->photo) == 0){
                    $category->photo = 'placeholder.png';
                }
                $category->name = $category->name_ar;
                $category->description = $category->description_ar;
                foreach($category->items as $item){
                    $item->name = $item->name_ar;
                }
            }
            foreach ($menu->restaurant->categories as $category){
                $category->name = $category->name_ar;
            }
            foreach ($menu->restaurant->branches as $branch){
                $branch->branch_address = $branch->branch_address_ar;
            }
        }
        //authorized
        if ($userID === $menus[0]->restaurant->user_id || $userRole === 1) {

            return view("menu.showMenu", ['menus' => $menus]);

        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }
    }
    // ========== SHOW SINGLE MENU BY ID  ==========//
    public function edit($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
         $menus = menus::with('restaurant')->where('id', $id)->get();
         // not found
        if (count($menus) == 0) {
            abort(404);
        }

         //authorized
         if ($userID === $menus[0]->restaurant->user_id || $userRole === 1) {

            return view("menu.editMenu", ['menus' => $menus]);

        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }
    }
    // ========== UPDATE MENU DATA ==========//
    public function update(Request $request, $id)
    {
        // validate data
        $this->validator($request);
        $menu = menus::find($id);
        $this->thenSave($request, $menu);
    }
    // ========== DELETE MENU DATA ==========//
    public function destroy($id)
    {
        $menu = menus::find($id);
        if (!$menu) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/menuPhoto' . "/" . $menu->photo))) {
            File::delete(public_path('assets/images/menuPhoto' . "/" . $menu->photo));
        }
        $menu->delete();
    }
    // ========== Validator ==========//
    public function validator($request)
    {
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
    // ========== Then store ==========//
    public function thenSave($request, $menu)
    {
        // SAVE MENU PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/menuPhoto');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW MENU DATA INTO DATABASE
        $menu->is_visible = $request->is_visible;
        $menu->name = $request->name;
        $menu->name_ar = $request->name_ar;
        $menu->description = $request->description;
        $menu->description_ar = $request->description_ar;
        if ($request->hasFile('photo')) {
            $menu->photo = $request->photo;
            $menu->photo = $path;
        }
        $menu->sort_no = $request->sort_no;
        $menu->restaurant_id = $request->restaurant_id;
        $menu->save();
    }
}
