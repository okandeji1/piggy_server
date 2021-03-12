<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\User;
use App\Models\Account;
use App\Models\Fund;
use App\Models\Investment;
use App\Models\Employment;
use App\Models\Laundering;
use Illuminate\Http\Request;
use Validator;


class PersonalController extends Controller
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
        // return response()->json($request);
        $validator = Validator::make($request->all(),[
            'phoneNumber' => 'required',
            'citizenship' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'zipCode' => 'required',
            'maritalStatus' => 'required',
            'employmentStatus' => 'required',
            'employer' => 'required',
            'industryCategory' => 'required',
            'jobTitle' => 'required',
            'totalIncome' => 'required',
            'reason' => 'required',
            'description' => 'required',
            'horizon' => 'required',
            'riskTolerance' => 'required',
            'investmentObjective' => 'required',
            'saved' => 'required',
            'propertyValue' => 'required',
            'debtValue' => 'required',
            'stocks' => 'required',
            'bonds' => 'required',
            'mutualFunds' => 'required',
            'etf' => 'required',
            'account' => 'required',
            'thirdParty' => 'required',
            'politicallyEmployed' => 'required',
            'insider' => 'required',
            // 'identification' => 'required|file'
        ]);
        // failed validation
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $userId = auth()->user()->id;
        $phoneNumber = $request->phoneNumber;
        $citizenship = $request->citizenship;
        $gender = $request->gender;
        $address = $request->address;
        $zipCode = $request->zipCode;
        $maritalStatus = $request->maritalStatus;
        $employmentStatus = $request->employmentStatus;
        $employer = $request->employer;
        $industryCategory = $request->industryCategory;
        $jobTitle = $request->jobTitle;
        $totalIncome = $request->totalIncome;
        $reason = $request->reason;
        $description = $request->description;
        $horizon = $request->horizon;
        $riskTolerance = $request->riskTolerance;
        $investmentObjective = $request->investmentObjective;
        $saved = $request->saved;
        $propertyValue = $request->propertyValue;
        $debtValue = $request->debtValue;
        $stocks = $request->stocks;
        $bonds = $request->bonds;
        $mutualFunds = $request->mutualFunds;
        $etf = $request->etf;
        $account = $request->account;
        $thirdParty = $request->thirdParty;
        $politicallyEmployed = $request->politicallyEmployed;
        $insider = $request->insider;
        $accountNumber = rand(0, 9999999999);
        // FIXME: we will work on image processing from front end
        // $identification = $request->file('identification');
        // $base64Image = base64_decode($identification);
        //   $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $identification));

        // $fileName = '';
        // if($identification === null){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Identification cannot be empty'
        //     ], 400);
        // }else {
        //     $generateName = uniqid().'_'.time().date('Ymd').'_IMG';
        //     $base64Image = $identification;
        //     $fileBin = file_get_contents($base64Image);
        //     $mimeType = mime_content_type($fileBin);
        //     // Validation
        //     if('image/png' === $mimeType){
        //         $fileName = $generateName.'.png';
        //     }else if('image/jpg' === $mimeType){
        //         $fileName = $generateName.'jpg';
        //     }else if('image/jpeg' === $mimeType){
        //         $fileName = $generateName.'jpeg';
        //     }else {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Only png, jpg, and jpeg are allowed for identification'
        //         ], 400);
        //     }
        // }
        // $image_data = base64_decode($fileName, $fileBin);

        /**
         * Sort the model that has relationship
         * accounts, funds, 
         */
        // Update user model
        try {
            // Process file to cloudinary
            // if($request->hasFile('identification')){
            //     $identificationUrl = cloudinary()->upload($identification->getRealPath())->getSecurePath();
            //     return response()->json([
            //         'data' => $identificationUrl
            //     ]);
            // }
            // Get investment id
            $investment = Investment::where('account', $account)->firstOrFail();
            $investmentId = $investment->id;
            
            //user model...
            $user = User::find($userId);
            $user->phone = $phoneNumber;
            $user->gender = $gender;
            $user->citizenship = $citizenship;
            $user->zip_code = $zipCode;
            $user->marital_status = $maritalStatus;
            $user->is_completed = 1;

            //employment model
            $employment = new Employment();
            $employment->user_id = $userId;
            $employment->status = $employmentStatus;
            $employment->employer = $employer;
            $employment->industry_category = $industryCategory;
            $employment->total_income = $totalIncome;
            
            //employment model
            $laundering = new Laundering();
            $laundering->user_id = $userId;
            $laundering->is_thirdParty = $thirdParty;
            $laundering->is_politicallyExposed = $politicallyEmployed;
            $laundering->is_insider = $insider;
            // $laundering->identification = $identificationUrl;

            //personal model
            $personal = new Personal();
            $personal->user_id = $userId;
            $personal->reason = $reason;
            $personal->description = $description;
            $personal->horizon = $horizon;
            $personal->risk_tolerance = $riskTolerance;
            $personal->investment_objective = $investmentObjective;
            $personal->saved = $saved;
            $personal->property_value = $propertyValue;
            $personal->debt_value = $debtValue;
            $personal->stocks = $stocks;
            $personal->bonds = $bonds;
            $personal->mutual_funds = $mutualFunds;
            $personal->etf = $etf;
            /**
             * Get the investment id, i.e the type of account selected by the user
             * Store in the following models
             */

            //account model
            $account = new Account();
            $account->user_id = $userId;
            $account->investment_id = $investmentId;
            $account->account_number = $accountNumber;
            try {
                /**
                 * save or updating all models after the other
                 */
                $user->save();
                $employment->save();
                $laundering->save();
                $personal->save();
                $account->save();
                // Create access token
                return response()->json([
                    'success' => true,
                    'message' => 'Account setup completed'
                ], 200);
            } catch (\Throwable $th) {
                // throw $th;
                return response()->json([
                    'success' => false,
                    'message' => 'Internal server error' .$th
                ], 500);
            }
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Internal server error' .$th
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function show(Personal $personal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function edit(Personal $personal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personal $personal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personal $personal)
    {
        //
    }
}
