<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\popup_ad;
use App\restaurant;
use App\top_ad;
use Illuminate\Http\Request;

class TopAdsController extends Controller
{
    // ========== VIEW ALL Ads DATA ==========//
    public function TopAdsIndex()
    {
        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;
        $restaurants = restaurant::all();
        $TopAds = top_ad::with('restaurant')->get();

        // fix language
        foreach ($restaurants as $restaurant) {
            if ($restaurant->language == 2) {
                $restaurant->name = $restaurant->name_ar;
            }
        }

        // fix language
        foreach ($TopAds as $ad) {
            if ($ad->restaurant->language == 2) {
                $ad->restaurant->name = $ad->restaurant->name_ar;
            }
        }
        // moderator
        if ($userRole == 2) {

            $allAds = array();
            foreach ($TopAds as $ad) {
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
            return view('ads.TopAds', ['TopAds' => $allAds,  'restaurants' => $allRestaurants]);
        }

        // super admin
        elseif ($userRole == 1) {
            return view('ads.TopAds', ['TopAds' => $TopAds,  'restaurants' => $restaurants]);
        }
    }
    // ========== CREATE NEW Ads DATA ==========//
    public function createTopAds(Request $request)
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
            $imagePath = public_path('assets/images/TopAdPhoto');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW MENU DATA INTO DATABASE
        $newTopAd = new top_ad();
        if ($request->is_visible == 1) {
            $ads = top_ad::all();
            foreach ($ads as $ad) {
                if ($ad->is_visible == 1) {
                    $request->validate([
                        'is_visible' => 'unique:top_ad|required|string|min:1',
                    ]);
                }
            }
        }
        $newTopAd->description = $request->description;
        $newTopAd->video_url = $request->video_url;
        $newTopAd->ad_link = $request->ad_link;
        if ($request->hasFile('photo')) {
            $newTopAd->photo = $request->photo;
            $newTopAd->photo = $path;
        }
        $newTopAd->main = $request->main;
        $newTopAd->is_visible = $request->is_visible;
        $newTopAd->restaurant_id = $request->restaurant_id;
        $newTopAd->save();
    }
    // ========== edit specific Ads DATA ==========//
    public function editTopAds($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $restaurant = restaurant::all();
        $ads = top_ad::where('id', $id)->with('restaurant')->get();

         // not found
         if (count($ads) == 0) {
            abort(404);
        }
        if ($userID === $ads[0]->restaurant->user_id || $userRole === 1) {
            return view('ads.editTopAds', ['ads' => $ads, 'restaurants' => $restaurant]);
        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }

    }
    // =============== UPDATE AD DATA ================//
    public function updateTopAds(Request $request, $id)
    {
        // {{-- validate request data --}}
        $request->validate([
            'description' => 'max:255',
            'video_url' => 'max:255',
            'ad_link' => 'string|max:255',
            'photo' => 'mimes:jpeg,png,jpg,gif,svg',
            'main' => 'required|min:1',
            'restaurant_id' => 'required',
        ]);
        // SAVE MENU PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/TopAdPhoto');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }
        // INSERT NEW MENU DATA INTO DATABASE
        $newTopAd = top_ad::find($id);
        if ($request->is_visible == 1) {
            $ads = top_ad::all();
            foreach ($ads as $ad) {
                if ($ad->is_visible == 1 &&  $ad->id !==  $newTopAd->id) {
                    $request->validate([
                        'is_visible' => 'unique:top_ad|required|string|min:1',
                    ]);
                }
            }
        }
        $newTopAd->description = $request->description;
        $newTopAd->video_url = $request->video_url;
        $newTopAd->ad_link = $request->ad_link;
        if ($request->hasFile('photo')) {
            $newTopAd->photo = $request->photo;
            $newTopAd->photo = $path;
        }
        $newTopAd->main = $request->main;
        $newTopAd->is_visible = $request->is_visible;
        $newTopAd->restaurant_id = $request->restaurant_id;
        $newTopAd->save();
    }
    // ========== DELETE THE AD FROM DATATABLE ========//
    public function deleteTopAds($id)
    {
        $ad =  top_ad::find($id);
        if (!$ad) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/TopAdPhoto' . "/" . $ad->photo))) {
            File::delete(public_path('assets/images/TopAdPhoto' . "/" . $ad->photo));
        }
        $ad->delete();
    }
}
