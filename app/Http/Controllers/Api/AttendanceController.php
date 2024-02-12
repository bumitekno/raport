<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceScore;
use App\Models\StudentClass;
use App\Models\SchoolYear;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
        $request->validate([
            'nis' => 'required',
            'school_year' => 'required'
        ]);

        $school_year = SchoolYear::where('name', '=', $request->school_year)->first();

        if (empty($school_year)) {
            return response()->json(['message' => $request->school_year . ' tidak di temukan !', 'result' => false, 'data' => '']);
        }

        $studentClass = StudentClass::with('student')->whereHas('student', function ($query) use ($request) {
            return $query->where('nis', '=', $request->nis);
        })->where('status', '=', '1')->first();

        if (empty($studentClass)) {
            return response()->json(['message' => $request->nis . ' tidak di temukan !', 'result' => false, 'data' => '']);
        }

        $data = [
            'id_student_class' => $studentClass->id,
            'ill' => $request->sakit,
            'excused' => $request->izin,
            'unexcused' => $request->alpha,
            'id_school_year' => $school_year->id
        ];

        $list = AttendanceScore::updateOrCreate([
            'id_student_class' => $studentClass->id,
            'id_school_year' => $school_year->id
        ], $data);

        return response()->json(['message' => $request->nis . ' Presensi Telah Di Update  !', 'result' => true, 'data' => $list]);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}