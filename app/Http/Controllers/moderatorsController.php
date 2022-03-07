<?php

namespace App\Http\Controllers;

use App\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class moderatorsController extends Controller
{
    // ========== all moderators ==========//
    public function index()
    {
        $users = users::with('restaurants')->get();
        return view("users.moderators", ['users' => $users]);
    }
    // ========== show one moderator ==========//
    public function show($id)
    {
        $users = users::where("id", $id)->with('restaurants')->get();
        return view("users.showModerator", ['users' => $users]);
    }
    // ========== ADD NEW USER TO DATATABLE ==========//
    public function store(Request $request)
    {
        // {{-- validate request data --}}
        $request->validate([
            'photo' => 'mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:4',
            'phone' => 'required|numeric|min:4',
            'role' => 'required|min:1',
        ]);
        // SAVE USER PHOTO
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $photoPath = public_path('assets/images/moderators');
            $path = $file->move($photoPath, $fileName)->getFilename();
        }
        // INSERT NEW USER DATA INTO DATABASE
        $newUser = new users();
        if ($request->hasFile('photo')) {
            $newUser->photo = $path;
        }
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);
        $newUser->phone_number = $request->phone;
        $newUser->role = $request->role;
        $newUser->save();
    }
    // ========== edit one moderator ==========//
    public function edit($id)
    {
        $users = users::where("id", $id)->get();
        return view("users.editModerator", ['users' => $users]);
    }
    // ========== update one moderator ==========//
    // validate and update user data {step 2}
    public function update(Request $request, $id)
    {
        $request->validate([
            'phote' => 'mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric|min:4',
            'role' => 'required|min:1',
        ]);
        // save image if exists
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $photoPath = public_path('assets/images/moderators');
            $path = $file->move($photoPath, $fileName)->getFilename();
        }
        // update user data
        $User = users::find($id);
        $User->name = $request->name;
        $User->email = $request->email;
        if ($request->hasFile('photo')) {
            $User->photo = $path;
        }
        if ($request->password > 4) {
            $request->validate([
                'password' => 'required|string|min:4',
            ]);
            $User->password = Hash::make($request->password);
        }
        $User->phone_number = $request->phone;
        $User->role = $request->role;
        $User->save();
    }
    // ========== delete moderator ==========//
    public function destroy($id)
    {
        $users = users::find($id);
        if (!$users) {
            abort(404);
        }
        if (File::exists(public_path('assets/images/moderators' . "/" . $users->photo))) {
            File::delete(public_path('assets/images/moderators' . "/" . $users->photo));
        }
        $users->delete();
    }
}
