<?php

namespace App\Http\Controllers;

use App\Models\SubjectTeacher;
use Illuminate\Http\Request;

class SubjectTeacherController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubjectTeacher  $subjectTeacher
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdateItem(Request $request, $id = null)
    {
        $item = $id ? Item::findOrFail($id) : new Item();

        $item->name = $request->name;
        $item->description = $request->description;
        $item->save();

        session()->flash('success', $id ? 'Data berhasil diupdate.' : 'Data berhasil disimpan.');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubjectTeacher  $subjectTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(SubjectTeacher $subjectTeacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubjectTeacher  $subjectTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubjectTeacher $subjectTeacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubjectTeacher  $subjectTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubjectTeacher $subjectTeacher)
    {
        //
    }
}
