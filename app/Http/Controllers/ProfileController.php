<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\User\ProfileRequest;
use App\Models\StudyClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        switch (session('role')) {
            case 'admin':
                return view('content.profiles.v_admin');
                break;
            case 'teacher':
                $classes = StudyClass::where('status', 1)->get();
                return view('content.profiles.v_teacher', compact('classes'));
                break;

            default:
                # code...
                break;
        }
        // dd('profile');

    }

    public function update(ProfileRequest $request)
    {
        // dd($request);
        $user = Auth::user();
        $data = $request->validated();
        // dd($data);
        $user->name = $data['name'];

        // Handle avatar upload if provided
        if ($request->hasFile('file')) {
            $data = ImageHelper::upload_asset($request, 'file', 'profile', $data);
            $user->file = $data['file'];
        }

        // Update email only if user is an admin
        if ($request->has('email') && Auth::guard('admin')->check()) {
            $user->email = $data['email'];
        }

        // Update date of birth
        $dateOfBirth = Carbon::createFromFormat('Y-m-d', $data['year'] . '-' . $data['month'] . '-' . $data['day']);
        $user->date_of_birth = $dateOfBirth;

        // Update other fields
        $user->phone = $data['phone'];
        $user->gender = $data['gender'];
        $user->place_of_birth = $data['place_of_birth'];
        $user->address = $data['address'];

        // Update password if provided
        if ($data['password']) {
            $user->password = bcrypt($data['password']);
        }
        // dd($user);
        $user->save();
        Helper::toast('Berhasil mengupdate profile', 'success');
        return redirect()->back();
    }
}
