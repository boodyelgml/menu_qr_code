<?php

namespace App\Http\Controllers;

use App\branch;
use App\menu;
use App\branch_menu;
use App\category_menu;
use App\menus;
use Illuminate\Http\Request;

class BranchMenuController extends Controller
{
    // ========== get branches After Choose Restaurant ==========//
    public function getBranchesAfterChooseRestaurant(Request $request)
    {
        $restaurantRequestId = $request->restaurantID;
        $branch = branch::where('restaurant_id', $restaurantRequestId)->get();
        return response()->json(['branch' => $branch]);
    }
    // =========== disattach branch inside menu view ====================== //
    public function disattachbranchInsideMenu($branchID, $menuID)
    {
        $menuCategoryRelation = branch_menu::where('branch_id', $branchID)->where('menu_id', $menuID)->delete();
    }
    // ================= attach branch inside menu view ==================== //
    public function attachBranchInsideMenu(Request $request)
    {
        $getmenu = menus::find($request->menu_id);
        $getmenu->branches()->syncWithoutDetaching($request->branch_id);
    }
    // ================= delete branch ==================== //
    public function deleteBranch($id)
    {
        $branch =  branch::where('id', $id)->delete();
    }
}
