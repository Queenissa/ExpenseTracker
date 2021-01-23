<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;


class UserController extends Controller
{
    
    //method for user registration
    public function register(Request $request) {
        $validator  =   Validator::make($request->all(), [
            "firstname"  =>  "required",
            "lastname"  =>  "required",
            "email"  =>  "required|email",
            "password"  =>  "required|min:8"
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $inputs = $request->all();
        $inputs["password"] = Hash::make($request->password);

        $user = User::create($inputs);

        if(!is_null($user)) {
            return response()->json(["status" => "success", "message" => "Success! registration completed", "data" => $user]);
        }
        else {
            return response()->json(["status" => "failed", "message" => "Registration failed!"]);
        }       
    }



    //method for user login with api token
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            "password" =>  "required",
        ]);

        if($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $user = User::where("email", $request->email)->first();

        if(is_null($user)) {
            return response()->json(["status" => "failed", "message" => "Failed! email not found"]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('my-app-token')->plainTextToken;

            return response()->json(["status" => "success", "login" => true, "token" => $token, "data" => $user]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! invalid password"]);
        }
    }




        //method for user logout and delete user's api token
        public function logout(Request $request)
        {
            $user = Auth::user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Token deleted successfully.'
            ]);
        }





    //method for updating user profile
    public function updateUserProfile(Request $request)
    {
      
        $user = Auth::user();
        $validator      =       Validator::make($request->all(), [
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required|email",
            "password" => "required|min:8"

        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $userUpdate = DB::table('users')->where('id', $user->id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(["status" => "success", "message" => "Success! profile updated"]);

    }


    
    
}
