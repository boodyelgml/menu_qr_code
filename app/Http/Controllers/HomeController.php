<?php

namespace App\Http\Controllers;

use App\categories;
use App\menus;
use App\items;
use App\restaurant;
use App\users;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // get all data
        $users = users::all();
        $restaurants = restaurant::all();
        $TenRestaurants = restaurant::take(10)->orderBy('created_at', 'desc')->get();
        $menus = menus::all();
        $categories = categories::all();
        $items = items::all();
        //==========================================================================
        // ================= USE FAKER TO GENERATE SOME DUMMY DATA =================
        //==========================================================================
        // $user =  factory(Users::class, 100)->create();
        // $restaurant = factory(restaurant::class, 100)->create();
        // $menu = factory(menus::class, 100)->create();
        // $menu = factory(categories::class, 100)->create();
        // $menu = factory(items::class, 100)->create();
        //return home view
        return view(
            'home',
            [
                'restaurants' => $restaurants,
                'TenRestaurants' => $TenRestaurants,
                'menus' => $menus,
                'categories' => $categories,
                'items' => $items,
                'users' => $users
            ]
        );
    }
}
