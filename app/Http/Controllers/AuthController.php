<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    protected $user;

    public function __construct()
    {
        // $this->user = new User();
        $this->middleware('auth:api', ['except' => [ 'register', 'login']]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // failed validation
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->toArray()
            ], 400);
        }
        // Inputs
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $token = null;

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }
            $user = auth()->user();
            // $user->createToken('piggyalpha')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user'=> $user
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Register user
     */
    public function register(Request $request)
    {
        // return response()->json($request);
        $validator = Validator::make($request->all(),[
            'firstname' => 'required|string|max:20',
            'lastname' => 'required|string|max:20',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'dob' => 'required|date',
            'sinNumber' => 'required'
        ]);
        // failed validation
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $email = $request->email;
        $password = $request->password;
        $dob = $request->dob;
        $sinNumber = $request->sinNumber;
        $hashPassword = bcrypt($password);
        // Check if user already exist
        if(User::where('email', $email)->exists()){
            return response()->json([
                'success' => false,
                'message' => 'Email already exist!'
            ], 401);
        }
        // Save data
        try {
            //code...
            $user = new User();
            // $user->uuid = Uuid::uuid4();
            $user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->email = $email;
            $user->password = $hashPassword;
            $user->dob = $dob;
            $user->sin_number = $sinNumber;
            $user->save();
            // Create access token
            return response()->json([
                'success' => true,
                'message' => 'Registration successful. Please login'
            ], 200);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);
    }
}
