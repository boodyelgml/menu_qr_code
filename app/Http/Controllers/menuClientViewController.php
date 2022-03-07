<?php

namespace App\Http\Controllers;

use App\menus;
use Illuminate\Http\Request;

class menuClientViewController extends Controller
{
    // ========== menu Client View ==========//
    public function menuView($menuID)
    {
        $getMenu = menus::where('id', $menuID)->get();
        return view('client.menu', ['getMenu' => $getMenu]);
    }
}
