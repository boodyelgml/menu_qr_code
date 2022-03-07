<?php

namespace App\Http\Controllers;

use App\links;
use App\links_visits_counter;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class linksController extends Controller
{
    // ========== VIEW ALL ITEMs DATA ==========//
    public function index()
    {
        $allLinks = links::all();
        return view('links.links', ['allLinks' => $allLinks]);
    }
    // ========== CREATE NEW url DATA ==========//
    public function storeUrl(Request $request)
    {
        $request->validate([
            'url' => 'unique:links|required',
            'photo' => 'mimes:png',
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:20',
        ]);

        // SAVE ITEM PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/LinksQrLogo');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }

        $newUrl = new links();
        $newUrl->file = '';
        $newUrl->url = $request->url;
        if ($request->hasFile('photo')) {
            $newUrl->photo = $path;
        }
        $newUrl->name = $request->name;
        $newUrl->description = $request->description;
        $newUrl->save();
    }
    // ========== edit url  ==========//
    public function edit($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $links = links::where('id', $id)->get();

        // not found
        if (count($links) == 0) {
            abort(404);
        }


        if ($userRole === 1) {
            return view('links.editLink', ['links' => $links]);
        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }
    }

    // ========== UPDATE ITEM DATA ==========//
    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required',
            'photo' => 'mimes:png',
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:20',
        ]);
        $link = links::find($id);

        // SAVE ITEM PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/LinksQrLogo');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }

        $link->file = '';
        $link->url = $request->url;
        if ($request->hasFile('photo')) {
            $link->photo = $request->photo;
            $link->photo = $path;
        }
        $link->name = $request->name;
        $link->description = $request->description;
        $link->save();
    }

    // ========== DELETE ITEM DATA ==========//
    public function destroy($id)
    {
        $link =  links::find($id);
        if (!$link) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/LinksQrLogo' . "/" . $link->photo))) {
            File::delete(public_path('assets/images/LinksQrLogo' . "/" . $link->photo));
        }
        $link->delete();
    }

    // ===========================//
    // ==========  File ==========//
    // ===========================//
    public function storeFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf',
            'photo' => 'mimes:png',
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:20',
        ]);

        // SAVE ITEM PHOTO
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photoPath = public_path('assets/images/FilesQrLogo');
            $FinalPhoto = $photo->move($photoPath, $photoName)->getFilename();
        }

        // SAVE ITEM PHOTO
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = public_path('assets/files/uploadedFiles');
            $FinalFile = $file->move($filePath, $fileName)->getFilename();
        }

        $newFile = new links();
        $newFile->url = '';
        $newFile->file = $FinalFile;
        if ($request->hasFile('photo')) {
            $newFile->photo = $FinalPhoto;
        }
        $newFile->name = $request->name;
        $newFile->description = $request->description;
        $newFile->save();
    }
    // ========== edit file  ==========//
    public function editFile($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $links = links::where('id', $id)->get();

        // not found
        if (count($links) == 0) {
            abort(404);
        }


        if ($userRole === 1) {
            return view('links.editFile', ['links' => $links]);
        } else { // unauthorized
            return view("unAuthorized.unAuthorized");
        }
    }
    // ========== UPDATE ITEM DATA ==========//
    public function updateFile(Request $request, $id)
    {
        $request->validate([
            'file' => 'mimes:pdf',
            'photo' => 'mimes:png',
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:20',
        ]);
        $link = links::find($id);

        // SAVE ITEM PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = public_path('assets/images/LinksQrLogo');
            $path = $file->move($imagePath, $fileName)->getFilename();
        }

        // SAVE ITEM PHOTO
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = public_path('assets/files/uploadedFiles');
            $FinalFile = $file->move($filePath, $fileName)->getFilename();
        }

        $link->url = '';
        if ($request->hasFile('file')) {
            if (File::exists(public_path('assets/files/uploadedFiles' . "/" . $link->file))) {
                File::delete(public_path('assets/files/uploadedFiles' . "/" . $link->file));
            }
            $link->file =  $FinalFile;
        }
        if ($request->hasFile('photo')) {
            $link->photo = $request->photo;
            $link->photo = $path;
        }
        $link->name = $request->name;
        $link->description = $request->description;
        $link->save();
    }




    // ========== Redirect ==========//
    public function redirect($id)
    {
        $link = links::find($id);
        $visitCount = ($link->visit_count) + 1;
        $link->visit_count = $visitCount;
        $link->save();

        $link_counter = new links_visits_counter;
        $link_counter->link_id = $link->id;
        $link_counter->save();

        return view("links.redirectLink", ['link' => $link]);
    }
// ========== visit counter ==========//
    public function visitsCounter($id){
        $visits = links_visits_counter::where('link_id' , $id)->get();
        return view('links.visits_count' , ['visits'=> $visits]);
    }
}
