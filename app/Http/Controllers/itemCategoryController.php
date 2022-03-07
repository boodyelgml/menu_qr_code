<?php

namespace App\Http\Controllers;

use App\categories;
use App\item_category;
use App\items;
use App\restaurant;
use Illuminate\Http\Request;

class itemCategoryController extends Controller
{
    // ========== attach Items inside Category ==========//
    public function attachItemInsideCategory(Request $request, $id)
    {
        $category = categories::find($id);
        $category->items()->syncWithoutDetaching($request->item_id);
    }
    // ========== disattach Item Inside Category ==========//
    public function disattachItemInsideCategory($itemID, $categoryID)
    {
        $menuCategoryRelation = item_category::where('item_id', $itemID)->where('category_id', $categoryID)->delete();
    }
    // ========== attach Category inside items ==========//
    public function attachCategoryInsideItem(Request $request, $id)
    {
        $item = items::find($id);
        $item->categories()->syncWithoutDetaching($request->category_id);
    }
    // ========= disattach Category Inside Item ======//
    public function disattachCategoryInsideItem($categoryID, $itemID)
    {
        $pivotTableRelation = item_category::where('category_id', $categoryID)->where('item_id', $itemID)->delete();
    }
    // ========== get items to show in categories view =============//
    public function getItemsInsideCategories(Request $request)
    {
        $restaurants = restaurant::find($request->restaurantID);
        return response()->json(['items' => $restaurants->items]);
    }
    // ==== get items to show in categories view =====//
    public function GetMenusInsideCategories(Request $request)
    {
        $restaurants = restaurant::find($request->restaurantID);
        return response()->json(['menus' => $restaurants->Menus]);
    }
    // ========== get Categories After Choose Restaurant ==========//
    public function getCategoriesAfterChooseRestaurant(Request $request)
    {
        $restaurantRequestId = $request->restaurantID;
        $catgories = categories::where('restaurant_id', $restaurantRequestId)->get();
        return response()->json(['categories' => $catgories]);
    }
}
