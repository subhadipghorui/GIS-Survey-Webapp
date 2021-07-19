<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('superadmin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'userid' => 'required|max:255|unique:users',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|max:255|confirmed',
            'role_id' => 'required',
            'image' => 'sometimes|image',
            'about' => 'sometimes|max:2000',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->userid = $request->userid;
        $user->email = $request->email;
        $user->about = $request->about;
        if (isset($request->verified)) {
            $user->email_verified_at = now()->addSeconds(5);
        }

        $image = $request->file('image');
        $slug = Str::slug($request->name);

        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // check dir
            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }

            // check file and delete old profile pic
            if ($user->image !== 'default.jpg' && Storage::disk('public')->exists('profile/' . $user->image)) {
                Storage::disk('public')->delete('profile/' . $user->image);
            }

            // resize the content
            $profile = Image::make($image)->fit(200, 200)->stream();
            // save new image to db and local
            Storage::disk('public')->put('profile/' . $imageName, $profile);
        } else {
            $imageName = 'default.jpg';
        }
        /**
         * Only Super Admins Can Create Admins
         */

        $user->role_id = $request->role_id;
        $user->image = $imageName;
        $user->password = Hash::make($request->password);
        $user->save();
        Toastr::success('Success', 'User created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::id() == $id) {
            Toastr::error('Error', 'You cannot edit yourself. Goto Profile to update.');
            return redirect()->back();
        }
        $user = User::findOrFail($id);
          $this->validate($request, [
                'name' => 'required|max:255',
                'userid' => "required|max:255|unique:users,userid,".$user->id,
                'email' => 'required|max:255|unique:users,email,'.$user->id,
                'password' => 'sometimes|max:255|confirmed',
                'role_id' => 'required',
                'image' => 'sometimes|image|mimes:jpg,png,bmp,jpeg|max:2000',
                'about' => 'sometimes|max:2000',
            ]);


        $user->name = $request->name;
        $user->userid = $request->userid;
        $user->email = $request->email;
        $user->about = $request->about;
        if (isset($request->verified)) {
            $user->email_verified_at = now()->addSeconds(5);
        }

        if (isset($request->image)) {
            $image = $request->file('image');
            $slug = Str::slug($request->name);

            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // check dir
            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }

            // check file and delete old profile pic
            if ($user->image !== 'default.jpg' && Storage::disk('public')->exists('profile/' . $user->image)) {
                Storage::disk('public')->delete('profile/' . $user->image);
            }

            // resize the content
            $profile = Image::make($image)->fit(200, 200)->stream();
            // save new image to db and local
            Storage::disk('public')->put('profile/' . $imageName, $profile);
        } else {
            $imageName = $user->image;
        }

        $user->role_id = $request->role_id;
        $user->image = $imageName;

        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        Toastr::success('Success', 'User updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // only Super Admin Can Delete Users
        if ($user->id == Auth::user()->id) {
            Toastr::error('Error', 'You can\'t delete your own account.');
            return redirect()->back();
        } else {
            $user->delete();
            Toastr::success('Success', 'User Deleted successfully.');
            return redirect()->back();
        }
    }
}
