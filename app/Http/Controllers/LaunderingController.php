<?php

namespace App\Http\Controllers;

use App\Models\Laundering;
use Illuminate\Http\Request;

class LaunderingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
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
     * @param  \App\Models\Laundering  $laundering
     * @return \Illuminate\Http\Response
     */
    public function show(Laundering $laundering)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Laundering  $laundering
     * @return \Illuminate\Http\Response
     */
    public function edit(Laundering $laundering)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laundering  $laundering
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laundering $laundering)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laundering  $laundering
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laundering $laundering)
    {
        //
    }
}
