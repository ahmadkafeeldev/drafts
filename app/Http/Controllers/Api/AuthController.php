<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Models\User;
use Image;
use Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['verify_data', 'signup', 'login', 'forgot_password', 'reset_password', 'login_with_facebook', 'login_with_google', 'login_with_apple', 'verify_phone']);
        // $this->middleware('auth:sanctum')->except('functionName');
        // $this->middleware('auth:sanctum')->except(['firstFunctionName','secondFunctionName']);
    }

    public function ifEmailExists($email)
    {
        $data = User::where('email', $email)->first();
        
        if($data){           
            throw new \ErrorException('Email has already been Taken');
        }
    }

    public function login_model($user_id)
    {
        $user = User::where('id', $user_id)->first();

        return $user;
    }

    //Verify Data
    public function verify_data(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[               
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'phone' => 'required|unique:users',
            ]);

            if($validator->fails())
            {
                return $this->error($validator->errors()->first());
            }else{
                return $this->success(['Given Data is Unique']);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //Signup
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            // 'country_code' => 'sometimes|nullable',
            // 'phone' => 'sometimes|nullable|unique:users',         
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|min:6|same:password',            
        ]);

        if($validator->fails())
        {
            return $this->error($validator->errors()->first());
        }

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if($request->has('country_code') && !empty($request->country_code))
        {
            $user->country_code = $request->country_code;
        }
        if($request->has('phone') && !empty($request->phone))
        {
            $user->phone = $request->phone;
        }
        
        $user->password = bcrypt($request->password);
        $user->type = 1;
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
    }

    //Login
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), ['login' => 'required', 'password' => 'required']);

            if($validator->fails()){
                return $this->error($validator->errors()->first());
            }

            $search_term = $request->login;            
            $res = '%'.$search_term.'%';

            $user = User::orWhere('email', $search_term)
            ->first();
            
            if(!empty($user)){
                if(Hash::check($request->password, $user->password)){
                    $user->onesignal_id = $request->onesignal_id;
                    $user->save();
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
                }else{
                    return $this->error('Invalid Credentials');
                }
            }else{
                return $this->error('Invalid Credentials');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }     
    }

    //User Data
    public function user_data()
    {
        try{
            // return $this->success(["User Data Found", $this->login_model(auth()->user()->id)]);
            return response()->json([
                'status' => true,
                'message' => 'User Data Found',
                'data' => $this->login_model(auth()->user()->id)
            ]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    //Forgot Password
    public function forgot_password($email)
    {
        // try{
            // $checkmail = $this->ifEmailExists(User::class, $email);
            $checkmail = User::where('email', '=', $email)->first();
            if($checkmail){
                $code = Rand(1111, 9999);            
                \Mail::to($email)->send(new ForgotPassword($code));
                return $this->success(['A verification code has been sent to your Email', ['email' => $email, 'code' => $code]]);           
            }else{
                return $this->error('Your Email is not valid OR not found' );           
            }
            // $code = Rand(1111, 9999);            
            // \Mail::to($email)->send(new ForgotPassword($code));

        // }catch(\Exception $e){
        //     return $this->error($e->getMessage());
        // }
    }

    //Reset Password
    public function reset_password(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed'
            ]);

            if($validator->fails()){
                return $this->error($validator->errors()->first());
            }

            $user = User::where('email', $request->email)->first();
            if(empty($user))
            {
                return $this->error('User does not Exists');
            }

            $user->password = bcrypt($request->password);
            $user->save();

            return $this->success(['Password Changed']);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //Update Profile
    public function update_profile(Request $request)
    {
        try {
            $user = auth()->user();
            if ($request->has('first_name') && $request->first_name != "") {
                $user->first_name = $request->first_name;
            }
            if ($request->has('last_name') && $request->last_name != "") {
                $user->last_name = $request->last_name;
            }
            if ($request->has('email') && $request->email != "") {
                $already = User::where('email', $request->email)->where('id', '!=', $user->id)->first('id');
                if ($already) {
                    return $this->error('Email has already been taken');
                }
                $user->email = strtolower($request->email);
            }
          	
            if ($request->has('profile_image')) {
                if ($request->profile_image->getClientOriginalExtension() == 'PNG' || $request->profile_image->getClientOriginalExtension() == 'png' || $request->profile_image->getClientOriginalExtension() == 'JPG' || $request->profile_image->getClientOriginalExtension() == 'jpg' || $request->profile_image->getClientOriginalExtension() == 'jpeg' || $request->profile_image->getClientOriginalExtension() == 'JPEG') {
                    $this->deleteExistingImage($user->id);

                    $newfilename = md5(mt_rand()) . '.' . $request->profile_image->getClientOriginalExtension();
                    $request->file('profile_image')->move(public_path("/uploads/profile_images"), $newfilename);
                    $new_path1 = 'uploads/profile_images/' . $newfilename;
                    $user->profile_image = $new_path1;
                } else {
                    return $this->error('Choose a Valid Image');
                }
            }
            if ($request->has('weight') && $request->weight != "") {
                $user->weight = $request->weight;
            }
            if ($request->has('device_type') && $request->device_type != "") {
                $user->device_type = $request->device_type;
            }
            if ($request->has('fcm_token') && $request->fcm_token != "") {
                $user->fcm_token = $request->fcm_token;
            }
                   
            $user->save();
            // return $this->success(['Profile Updated', $this->login_model(auth()->user()->id)]);
            return response()->json([
                'status' => true,
                'message' => 'Profile Updated',
                'data' => $this->login_model(auth()->user()->id)
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    //Update FCM Token
    public function update_fcm_token(Request $request)
    {
        try{
            $user = auth()->user();
            $user->device_type = $request->device_type;
            $user->fcm_token = $request->token;
            $user->save();
            
            return $this->success(['FCM token Updated']);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    //Change Password
    public function change_password(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), ['old_password' => 'required', 'new_password' => 'required']);

            if($validator->fails()){
                return $this->error($validator->errors()->first());
            }
            $user = auth()->user();
            if(Hash::check($request->old_password, $user->password)){   
                $user->password = bcrypt($request->new_password);

                if($user->save()){                    
                    return $this->success(['Password Changed Successfully', $this->login_model($user->id)]);
                }
            }else{                    
                return $this->error('Wrong Password Entered');              
            }
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    //Delete Account
    public function delete_account()
    {
        try{
            if(auth()->user()->id == '2')
            {
                return $this->error('This account can not delete');
            }

            $this->deleteExistingImage(auth()->user()->id);

            auth()->user()->delete();

            return $this->success(['Account Deleted']);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    //Logout
    public function logout()
    {
        try{
            auth()->user()->currentAccessToken()->delete();

            return $this->success(['Logout']);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    //Login with Facebook
    public function login_with_facebook(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), ['facebook_id' => 'required', 'first_name' => 'required|string|max:255', 'email' => 'required|email|max:100']);

            if($validator->fails()){
                return $this->error($validator->errors()->first());
            }

            $already = User::orWhere('facebook_id', $request->facebook_id)->orWhere('email', $request->email)->first();
            
            if(!empty($already)){
                if($already->facebook_id == "" || empty($already->facebook_id)){
                    $already->facebook_id = $request->facebook_id;
                    $already->save();
                }
                $token = $already->createToken('auth_token')->plainTextToken;
                return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
            }else{
                $this->ifEmailExists($request->email);
                $user = new User;
                $user->facebook_id = $request->facebook_id;
                $user->first_name = $request->first_name;
                $user->email = $request->email;
                $user->save();

                $token = $user->createToken('auth_token')->plainTextToken;
                return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //Login with Google
    public function login_with_google(Request $request)
    {
        try{
            $already = User::orWhere('google_id', $request->google_id)->orWhere('email', $request->email)->first();
            
            if(!empty($already)){
                if($already->google_id == "" || empty($already->google_id)){
                    $already->google_id = $request->google_id;
                    $already->save();
                }
                $token = $already->createToken('auth_token')->plainTextToken;
                return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
            }else{
                $validator = Validator::make($request->all(), ['google_id' => 'required', 'first_name' => 'required|string|max:255', 'last_name' => 'required|string|max:255','email' => 'required|email|max:100']);

                if($validator->fails()){
                    return $this->error($validator->errors()->first());
                }

                $this->ifEmailExists($request->email);
                $user = new User;
                $user->google_id = $request->google_id;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                $token = $user->createToken('auth_token')->plainTextToken;
                return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //Login with Apple
    public function login_with_apple(Request $request)
    {
        try{
            $already = User::orWhere('apple_id', $request->google_id)->orWhere('email', $request->email)->first();
            
            if(!empty($already)){
                if($already->apple_id == "" || empty($already->apple_id)){
                    $already->apple_id = $request->apple_id;
                    $already->save();
                }
                $token = $already->createToken('auth_token')->plainTextToken;
                return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
            }else{
                $validator = Validator::make($request->all(), ['apple_id' => 'required', 'first_name' => 'required|string|max:255', 'last_name' => 'required|string|max:255','email' => 'required|email|max:100']);

                if($validator->fails()){
                    return $this->error($validator->errors()->first());
                }
                $this->ifEmailExists($request->email);
                $user = new User;
                $user->apple_id = $request->apple_id;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                $token = $user->createToken('auth_token')->plainTextToken;
                return $this->success(["Glad You've Joined Us", ['token' => $token, 'token_type' => 'Bearer']]);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //Verify Phone number
    public function verify_phone(Request $request)
    {
        try{      
            $code = rand(1111, 9999);            
            $message = $code." is your verification code";
            
            $country_code = preg_replace('/^\+?1|\|1|\D/', '', ($request->country_code));
            
            // $phone_number = "923236691890";
            $phone_number = $country_code.$request->phone;
            
            $this->phone_otp($message, $phone_number);

            return $this->success(['Verification code has been sent to your Mobile', $code]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    public function interests()
    {
        try{
            $interests = Interest::all();
            return $this->success([$interests->count() > 0 ? 'Interests Found': 'No Interests Found', $interests]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

}
