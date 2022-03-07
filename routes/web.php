<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ================================================ //
// ==============  Home  Routes =================== //
// ================================================ //

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('redirect/{id}', "linksController@redirect")->name("redirectLink");

Route::get('/menuView/{menuID}', 'menuClientViewController@menuView')->name('menuView');

// ================================================ //
// ==============  Moderator Routes =============== //
// ================================================ //

Route::group(['prefix' => 'moderators', 'middleware' => 'auth'], function () {
    Route::get('/', "moderatorsController@index")->name("moderators");
    //========= view single moderator route =========
    Route::get('{id}', "moderatorsController@show")->name("showModerators");
    //========= edit single moderator route =========
    Route::get('edit/{id}', "moderatorsController@edit")->name("editModerators");
    Route::put('update/{id}', "moderatorsController@update")->name("updateModerators");
    //========= add new single moderator route =========
    Route::post('store', "moderatorsController@store")->name("createModerators");
    //========= delete single moderator route =========
    Route::delete('delete/{id}', "moderatorsController@destroy")->name("deleteModerator");
});

// ================================================ //
// ==============  Restaurant Routes =============== //
// ================================================ //

Route::group(['prefix' => 'restaurant', 'middleware' => 'auth'], function () {
    Route::get('/', "RestaurantController@index")->name("restaurants");
    //========= view single Restaurant route =========
    Route::get('{id}', "RestaurantController@show")->name("showRestaurant");
    //========= edit single moderator route =========
    Route::get('edit/{id}', "RestaurantController@edit")->name("editRestaurant");
    Route::put('update/{id}', "RestaurantController@update")->name("updateRestaurant");
    //========= add new single moderator route=========
    Route::post('store', "RestaurantController@store")->name("createRestaurant");
    //========= delete single moderator route=========
    Route::delete('delete/{id}', "RestaurantController@destroy")->name("deleteRestaurant");
});

// ================================================ //
// ==============  Menu Routes =============== //
// ================================================ //

Route::group(['prefix' => 'menu', 'middleware' => 'auth'], function () {
    Route::get('/', "MenusController@index")->name("menus");
    //========= view single Menu route =========
    Route::get('/getCategoriesAfterChooseRestaurant', 'itemCategoryController@getCategoriesAfterChooseRestaurant')->name('getCategoriesAfterChooseRestaurant');
    Route::get('{id}', "MenusController@show")->name("showMenu");
    //========= edit single moderator route =========
    Route::get('edit/{id}', "MenusController@edit")->name("editMenu");
    Route::put('update/{id}', "MenusController@update")->name("updateMenu");
    //========= add new single moderator route=========
    Route::post('store', "MenusController@store")->name("createMenu");
    //========= delete single moderator route=========
    Route::delete('delete/{id}', "MenusController@destroy")->name("deleteMenu");
    //========= delete single moderator route=========

});

// ================================================ //
// ==============  category Routes =============== //
// ================================================ //

Route::group(['prefix' => 'category', 'middleware' => 'auth'], function () {
    Route::get('/', "CategoryController@index")->name("categories");
    //========= view single Category route =========
    Route::get('/getItemsInsideCategories', "itemCategoryController@getItemsInsideCategories")->name("getItemsInsideCategories");
    Route::get('/GetMenusInsideCategories', "itemCategoryController@GetMenusInsideCategories")->name("GetMenusInsideCategories");
    Route::get('{id}', "CategoryController@show")->name("showCategory");
    //========= edit single moderator route =========
    Route::get('edit/{id}', "CategoryController@edit")->name("editCategory");
    Route::put('update/{id}', "CategoryController@update")->name("updateCategory");
    //========= add new single moderator route=========
    Route::post('store', "CategoryController@store")->name("createCategory");
    //========= delete single moderator route=========
    Route::delete('delete/{id}', "CategoryController@destroy")->name("deleteCategory");
});

// ================================================ //
// ==============  Items Routes =============== //
// ================================================ //

Route::group(['prefix' => 'item', 'middleware' => 'auth'], function () {
    Route::get('/', "ItemController@index")->name("items");
    //========= view single item route =========
    Route::get('{id}', "ItemController@show")->name("showItem");
    //========= edit single item route =========
    Route::get('edit/{id}', "ItemController@edit")->name("editItem");
    Route::put('update/{id}', "ItemController@update")->name("updateItem");
    //========= add new single item route=========
    Route::post('store', "ItemController@store")->name("createItem");
    //========= delete single item route=========
    Route::delete('delete/{id}', "ItemController@destroy")->name("deleteItem");
});

// ================================================ //
// ==============  item-category routes =============== //
// ================================================ //
Route::group(['prefix' => 'itemCategory', 'middleware' => 'auth'], function () {

    //========= attach category  inside items ========= //
    Route::put('attachCategoryInsideItem/{id}', "itemCategoryController@attachCategoryInsideItem")->name("attachCategoryInsideItem");
    //========= disattach Category Inside Item ========= //
    Route::delete('disattachCategoryInsideItem/{categoryID}/{itemID}', "itemCategoryController@disattachCategoryInsideItem")->name("disattachCategoryInsideItem");
    //========= attach items inside category ========= //
    Route::put('attachItemInsideCategory/{id}', "itemCategoryController@attachItemInsideCategory")->name("attachItemInsideCategory");
    //========= disattach items inside category ========= //
    Route::delete('disattachItemInsideCategory/{itemID}/{categoryID}', "itemCategoryController@disattachItemInsideCategory")->name("disattachItemInsideCategory");
});


// ================================================ //
// ==============  category-menu routes =============== //
// ================================================ //
Route::group(['prefix' => 'categoryMenu', 'middleware' => 'auth'], function () {

    //========= add exist category from menu categories list =========
    Route::put('attachCategoryInsideMenu', "CategoryMenuController@attachCategoryInsideMenu")->name("attachCategoryInsideMenu");
    //========= remove exist category from menu categories list =========
    Route::delete('disattachCategoryInsideMenu/{categoryID}/{menuID}', "CategoryMenuController@disattachCategoryInsideMenu")->name("disattachCategoryInsideMenu");
    //========= attach menu inside category ========= //
    Route::put('attachMenuInsideCategory/{id}', "CategoryMenuController@attachMenuInsideCategory")->name("attachMenuInsideCategory");
    //========= disattach menu inside category ========= //
    Route::delete('disattachMenuInsideCategory/{menuID}/{categoryID}', "CategoryMenuController@disattachMenuInsideCategory")->name("disattachMenuInsideCategory");
});

// ================================================ //
// ==============  Branch-menu routes =============== //
// ================================================ //


Route::group(['prefix' => 'branchMenu', 'middleware' => 'auth'], function () {
    //========= delete branch ========= //
    Route::delete('deleteBranch/{id}', "BranchMenuController@deleteBranch")->name("deleteBranch");
    //========= get Branches After Choose Restaurant ========= //
    Route::get('/getBranchesAfterChooseRestaurant', 'BranchMenuController@getBranchesAfterChooseRestaurant')->name('getBranchesAfterChooseRestaurant');
    //========= attach Branch Inside Menu ========= //
    Route::put('/attachBranchInsideMenu', 'BranchMenuController@attachBranchInsideMenu')->name('attachBranchInsideMenu');
    //========= disattach branch Inside Menu ========= //
    Route::delete('/disattachbranchInsideMenu/{branchID}/{menuID}', 'BranchMenuController@disattachbranchInsideMenu')->name('disattachbranchInsideMenu');
});



// // ================================================ //
// // ============== top ads Routes =============== //
// // ================================================ //

Route::group(['prefix' => 'vertise', 'middleware' => 'auth'], function () {
    Route::get('/', "TopAdsController@TopAdsIndex")->name("TopAds");
    //========= edit single Top ad route =========
    Route::get('editTopAds/{id}', "TopAdsController@editTopAds")->name("editTopAds");
    Route::put('updateTopAds/{id}', "TopAdsController@updateTopAds")->name("updateTopAds");
    //========= add new single Top ad route=========
    Route::post('createTopAds', "TopAdsController@createTopAds")->name("createTopAds");
    //========= delete single Top ad route=========
    Route::delete('deleteTopAds/{id}', "TopAdsController@deleteTopAds")->name("deleteTopAds");
});


//===========================================================//
//============== pop up ads routes ================//
//===========================================================//
Route::group(['prefix' => 'popUpvertise', 'middleware' => 'auth'], function () {

    Route::get('PopUpAds/', "popUpAdsController@PopUpAdsIndex")->name("PopUpAds");
    //========= edit single popUp ad route =========
    Route::get('editPopUpAds/{id}', "popUpAdsController@editPopUpAds")->name("editPopUpAds");
    Route::put('PopUpAdsupdate/{id}', "popUpAdsController@PopUpAdsupdate")->name("PopUpAdsupdate");
    //========= add new single popUp ad route=========
    Route::post('createPopUpAds', "popUpAdsController@createPopUpAds")->name("createPopUpAds");
    //========= delete single popUp ad route=========
    Route::delete('deletePopUpAds/{id}', "popUpAdsController@deletePopUpAds")->name("deletePopUpAds");
});

// ================================================ //
// ==============  question Routes =============== //
// ================================================ //

Route::group(['prefix' => 'question', 'middleware' => 'auth'], function () {
    Route::get('/', "QuestionsController@index")->name("questions");
    //========= edit single question route =========
    Route::get('edit/{id}', "QuestionsController@edit")->name("editQuestion");
    Route::put('update/{id}', "QuestionsController@update")->name("updateQuestion");
    //========= add new single question route=========
    Route::post('create', "QuestionsController@create")->name("createFeedbackQuestion");
    //========= delete single question route=========
    Route::delete('delete/{id}', "QuestionsController@destroy")->name("deleteQuestion");
});



// ================================================ //
// ==============  answers Routes =============== //
// ================================================ //

Route::group(['prefix' => 'answer', 'middleware' => 'auth'], function () {
    Route::get('/', "AnswersController@index")->name("answers");
    //========= add new single moderator route=========
    Route::post('create', "AnswersController@create")->name("createAnswer");
});

// ================================================ //
// ==============  Links Routes =============== //
// ================================================ //

Route::group(['prefix' => 'links', 'middleware' => 'auth'], function () {
    Route::get('/', "linksController@index")->name("links");
    //========= add new link route=========
    Route::post('createUrl', "linksController@storeUrl")->name("createUrl");
    Route::post('createFile', "linksController@storeFile")->name("createFile");
    //========= edit file=========
    Route::get('editFile/{id}', "linksController@editFile")->name("editFile");
    Route::put('updateFile/{id}', "linksController@updateFile")->name("updateFile");
    //========= edit url=========
    Route::get('edit/{id}', "linksController@edit")->name("editLink");
    Route::put('update/{id}', "linksController@update")->name("updateLink");
    //========= delete link route=========
    Route::delete('delete/{id}', "linksController@destroy")->name("deleteLink");
    //========= visits counter =========
    Route::get('visits_counter/{id}', "linksController@visitsCounter")->name("visitsCounter");

});
