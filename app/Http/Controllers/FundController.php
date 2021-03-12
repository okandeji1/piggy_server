<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Investment;
use Illuminate\Http\Request;
use Validator;


class FundController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

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
        $validator = Validator::make($request->all(),[
            'account' => 'required',
            'amount' => 'required|numeric',
            'schedule' => 'required',
            'startDate' => 'required|date',
        ]);
        // failed validation
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->toArray()
            ], 400);
        }
        $userId = auth()->user()->id;
        $account = $request->account;
        $amount = $request->amount;
        $schedule = $request->schedule;
        $startDate = $request->startDate;
        try {
            //code...
            // Get investment id
            $investment = Investment::where('account', $account)->firstOrFail();
            $investmentId = $investment->id;

            $newFund = new Fund();
            $newFund->user_id = $userId;
            $newFund->investment_id = $investmentId;
            $newFund->amount = $amount;
            $newFund->schedule = $schedule;
            $newFund->start_date = $startDate;
            $newFund->save();
            return response()->json([
                'success' => true,
                'message' => 'Fund added successfully'
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Internal server error' .$th
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function edit(Fund $fund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fund $fund)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund)
    {
        //
    }

    public function upload(Request $request)
    {
        dd($request->img);
        try {
            //code...
            if($request->hasFile('img')){
                $response = cloudinary()->upload($request->file('img')->getRealPath())->getSecurePath();
            }
           return response()->json($response);
        // return response()->json($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
