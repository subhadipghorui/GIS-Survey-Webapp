<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }
    public function profile()
    {
        $user = User::find(Auth::user()->id);

        return view('user.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        //    VAlidate
        $this->validate($request, [
            'name' => 'required',
            'userid' => "required|max:255|unique:users,userid,".$user->id,
            'about' => 'required|max:254',
            'image' => 'sometimes|image|mimes:jpeg,bmp,png,jpg|max:1000', //500kb
        ]);

        $image = $request->file('image');
        $slug = Str::slug($request->name);


        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            // check dir
            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }
            //

            // check file and delete old profile pic
            if ($user->image !== 'default.jpg' && Storage::disk('public')->exists('profile/'.$user->image)) {
                Storage::disk('public')->delete('profile/'.$user->image);
            }

            // resize the content
            $profile = Image::make($image)->fit(200, 200)->stream();
            // save new image to db and local
            Storage::disk('public')->put('profile/'.$imageName, $profile);
        } else {
            $imageName = $user->image;
        }
        // Update to db
        $user->name = $request->name;
        $user->userid = $request->userid;
        $user->about = $request->about;
        $user->image = $imageName;

        $user->save();

        // redirect with msg
        Toastr::success('Details Successfully Saved', 'Success');

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        // validate
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed', //confirm password name field must be "password_confirmation"
        ]);
        $hashedPassword = Auth::user()->password; //user old pass

        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = User::findOrFail(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();

                // redirect with msg
                Toastr::success('Password Successfully Saved', 'Success');
                // logout
                Auth::logout();

                // Logout from all device
                // Auth::logoutOtherDevices($request->password);

                return redirect()->back();
            } else {
                // redirect with msg
                Toastr::error('New password cannot be same as old password :(', 'Error');

                return redirect()->back();
            }
        } else {
            // redirect with msg
            Toastr::error('Enter correct old password :(', 'Error');

            return redirect()->back();
        }
    }
}
