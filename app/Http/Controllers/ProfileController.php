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
            case 'student':
                $classes = StudyClass::where('status', 1)->get();
                return view('content.profiles.v_student', compact('classes'));
                break;
            case 'parent':
                return view('content.profiles.v_parent');
                break;

            default:
                session()->put('message', 'Tidak ada role yang terdaftar');
                return view('pages.v_error');
                break;
        }
        // dd('profile');

    }

    // public function update(Request $request)
    public function update(ProfileRequest $request)
    {
        // dd($request);
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

        // // Update email only if user is an admin
        if (Auth::guard('admin')->check()) {
            $user->gender = $data['gender'];
            $user->place_of_birth = $data['place_of_birth'];
            $dateOfBirth = Carbon::createFromFormat('Y-m-d', $data['year'] . '-' . $data['month'] . '-' . $data['day']);
            $user->date_of_birth = $dateOfBirth;
        }

        if (Auth::guard('teacher')->check()) {
            $user->nip = $data['nip'];
            $user->nik = $data['nik'];
            $user->nuptk = $data['nuptk'];
            $user->religion = $data['religion'];
            $user->type = $data['type'];
            $user->gender = $data['gender'];
            $user->place_of_birth = $data['place_of_birth'];
            $dateOfBirth = Carbon::createFromFormat('Y-m-d', $data['year'] . '-' . $data['month'] . '-' . $data['day']);
            $user->date_of_birth = $dateOfBirth;
            if ($request->has('id_class')) {
                $user->id_class = $data['id_class'];
            }
        }
        if (Auth::guard('user')->check()) {
            $user->nis = $data['nis'];
            $user->nisn = $data['nisn'];
            $user->entry_year = $data['entry_year'];
            $user->religion = $data['religion'];
            $user->family_status = $data['family_status'];
            $user->child_off = $data['child_off'];
            $user->school_from = $data['school_from'];
            $user->accepted_grade = $data['accepted_grade'];
            $user->accepted_date = $data['accepted_date'];
            $user->gender = $data['gender'];
            $user->place_of_birth = $data['place_of_birth'];
            $dateOfBirth = Carbon::createFromFormat('Y-m-d', $data['year'] . '-' . $data['month'] . '-' . $data['day']);
            $user->date_of_birth = $dateOfBirth;
        }
        if (Auth::guard('parent')->check()) {
            $user->nik = $data['nik'];
            $user->type = $data['type'];
            $user->job = $data['job'];
            $user->religion = $data['religion'];
        }


        // Update date of birth


        // Update other fields
        $user->email = $data['email'];
        $user->phone = $data['phone'];

        $user->address = $data['address'];

        // Update password if provided
        if ($data['password']) {
            $user->password = $data['password'];
        }
        // dd($user);
        $user->save();
        Helper::toast('Berhasil mengupdate profile', 'success');
        return redirect()->back();
    }
}
