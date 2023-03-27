<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parent\StoreParentRequest;
use App\Http\Requests\Parent\UpdateParentRequest;
use App\Models\UserParent;
use Illuminate\Http\Request;

class ParentController extends Controller
{
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
     * @param  \App\Http\Requests\StoreParentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserParent  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(UserParent $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserParent  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(UserParent $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateParentRequest  $request
     * @param  \App\Models\UserParent  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParentRequest $request, UserParent $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserParent  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserParent $teacher)
    {
        //
    }
}
