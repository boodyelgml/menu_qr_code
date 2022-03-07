<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\popup_ad;
use App\restaurant;
use Illuminate\Http\Request;

class popUpAdsController extends Controller
{
    // ========== all popup ads ==========//
    public function PopUpAdsIndex()
    {
        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;
        $restaurants = restaurant::all();
        $PopAds = popup_ad::with('restaurant')->get();



        // fix language
        foreach ($restaurants as $restaurant) {
            if ($restaurant->language == 2) {
                $restaurant->name = $restaurant->name_ar;
            }
        }
        // fix language
        foreach ($PopAds as $ad) {
            if ($ad->restaurant->language == 2) {
                $ad->restaurant->name = $ad->restaurant->name_ar;
            }
        }

        // moderator
        if ($userRole == 2) {

            $allAds = array();
            foreach ($PopAds as $ad) {
                if ($ad->restaurant->user_id == $moderatorID) {
                    $allAds[] = $ad;
                }
            }

            $allRestaurants = array();
            foreach ($restaurants as $restaurant) {
                if ($restaurant->language == 2) {
                    $restaurant->name = $restaurant->name_ar;
                }
                if ($restaurant->user_id == $moderatorID) {

                    $allRestaurants[] = $restaurant;
                }
            }
            return view('ads.PopUpAds', ['popupAds' => $allAds,  'restaurants' => $allRestaurants]);
        }

        // super admin
        elseif ($userRole == 1) {
            return view('ads.PopUpAds', ['popupAds' => $PopAds, 'restaurants' => $restaurants]);
        }


    }
    // ========== add new add ==========//
    public function createPopUpAds(Request $request)
    {
        // {{-- validate request data --}}
        $request->validate([
            'description' => 'string|max:255',
            'video_url' => 'string|max:255',
            'ad_link' => 'string|max:255',
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'main' => 'required|min:1',
            'restaurant_id' => 'required',
        ]);
        // SAVE MENU PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/popUpAdPhoto');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW MENU DATA INTO DATABASE
        $newpopUpAd = new popup_ad();
        if ($request->is_visible == 1) {
            $ads = popup_ad::all();
            foreach ($ads as $ad) {
                if ($ad->is_visible == 1) {
                    $request->validate([
                        'is_visible' => 'unique:popup_ad|required|string|min:1',
                    ]);
                }
            }
        }
        $newpopUpAd->description = $request->description;
        $newpopUpAd->video_url = $request->video_url;
        $newpopUpAd->ad_link = $request->ad_link;
        if ($request->hasFile('photo')) {
            $newpopUpAd->photo = $request->photo;
            $newpopUpAd->photo = $path;
        }
        $newpopUpAd->main = $request->main;
        $newpopUpAd->is_visible = $request->is_visible;
        $newpopUpAd->restaurant_id = $request->restaurant_id;
        $newpopUpAd->save();
    }
    // ========== edit popup ad ==========//
    public function editPopUpAds($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $restaurant = restaurant::all();
        $ads = popup_ad::where('id', $id)->with('restaurant')->get();

         // not found
         if (count($ads) == 0) {
            abort(404);
        }

        if ($userID === $ads[0]->restaurant->user_id || $userRole === 1) {
            return view('ads.editPopUpAds', ['ads' => $ads, 'restaurants' => $restaurant]);
        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }
    }
    // =============== update popup ad ================//
    public function PopUpAdsupdate(Request $request, $id)
    {
        // {{-- validate request data --}}
        $request->validate([
            'description' => 'string|max:255',
            'video_url' => 'string|max:255',
            'ad_link' => 'string|max:255',
            'photo' => 'mimes:jpeg,png,jpg,gif,svg',
            'main' => 'required|min:1',
            'restaurant_id' => 'required',
        ]);
        // SAVE MENU PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/popUpAdPhoto');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW MENU DATA INTO DATABASE
        $updatePopUpAd = popup_ad::find($id);
        if ($request->is_visible == 1) {
            $ads = popup_ad::all();
            foreach ($ads as $ad) {
                if ($ad->is_visible == 1 &&  $ad->id !==  $updatePopUpAd->id) {
                    $request->validate([
                        'is_visible' => 'unique:popup_ad|required|string|min:1',
                    ]);
                }
            }
        }
        $updatePopUpAd->description = $request->description;
        $updatePopUpAd->video_url = $request->video_url;
        $updatePopUpAd->ad_link = $request->ad_link;
        if ($request->hasFile('photo')) {
            $updatePopUpAd->photo = $request->photo;
            $updatePopUpAd->photo = $path;
        }
        $updatePopUpAd->main = $request->main;
        $updatePopUpAd->is_visible = $request->is_visible;
        $updatePopUpAd->restaurant_id = $request->restaurant_id;
        $updatePopUpAd->save();
    }
    // ========== delete popup ad ========//
    public function deletePopUpAds($id)
    {
        $ad =  popup_ad::find($id);
        if (!$ad) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/TopAdPhoto' . "/" . $ad->photo))) {
            File::delete(public_path('assets/images/TopAdPhoto' . "/" . $ad->photo));
        }
        $ad->delete();
    }
}
