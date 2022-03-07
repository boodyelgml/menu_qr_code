<?php

namespace App\Http\Controllers;

use App\category_menu;
use App\menus;
use App\categories;
use Illuminate\Http\Request;

class CategoryMenuController extends Controller
{
    // ================== attach category inside menu =================== //
    public function attachCategoryInsideMenu(Request $request)
    {
        $getmenu = menus::find($request->menu_id);
        $getmenu->categories()->syncWithoutDetaching($request->category_id);
    }
    // =========== disattach category inside menu ====================== //
    public function disattachCategoryInsideMenu($categoryID, $menuID)
    {
        $menuCategoryRelation = category_menu::where('category_id', $categoryID)->where('menu_id', $menuID)->delete();
    }
    // ================= attach menu inside category ==================== //
    public function attachMenuInsideCategory(Request $request, $id)
    {
        $getcategory = categories::find($id);
        $getcategory->menus()->syncWithoutDetaching($request->menu_id);
    }
    // ================= disattach menu inside category ==================== //
    public function disattachMenuInsideCategory($menuID, $categoryID)
    {
        $menuCategoryRelation = category_menu::where('menu_id', $menuID)->where('category_id', $categoryID)->delete();
    }
}
