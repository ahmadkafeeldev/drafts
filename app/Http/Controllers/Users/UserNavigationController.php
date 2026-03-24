<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use App\Models\NewsPaper;
use App\Models\Bookings;
use Illuminate\Http\Request;
use DB;

class UserNavigationController extends Controller
{
    public function dashboard()
    {
        return view('users.dashboard');
    }

    public function update_profile(Request $request)
    {
        try{
            $user = User::find($request->user_id);
            if(empty($user))
            {
                return back()->with('error', 'User does not exists!');
            }            
            
            if($request->has('profile_image'))
            {
                $image = $request->profile_image;
                
                if($image->getClientOriginalExtension() == 'PNG' ||$image->getClientOriginalExtension() == 'png' || $image->getClientOriginalExtension() == 'JPG' || $image->getClientOriginalExtension() == 'jpg' || $image->getClientOriginalExtension() == 'jpeg' || $image->getClientOriginalExtension() == 'JPEG')
                    {
                        $new_name = rand().'.'.$image->getClientOriginalExtension();
                        $image->move(public_path('/profile_images'), $new_name);
                        $img_path = 'profile_images/'.$new_name;  
                    
                        
                    }else{  
                        return back()->with('error', 'Please Choose a Valid Image!');
                    }         
                

                $user->profile_image = $img_path;       
            }

            if($request->has('first_name'))
            {
                $user->first_name = $request->first_name;
            }

            if($request->has('last_name'))
            {
                $user->last_name = $request->last_name;
            }      

            if($request->has('email'))
            {
                $user->email = $request->email;
            }
            
            if($request->has('company_name'))
            {
                $user->company_name = $request->company_name;
            }
        

            if($user->save())
            {
                $user2 = User::where('id', $request->user_id)->first();

                return back()->with('message', 'Profile Updated Successfully!');
            }
        }catch(\Exception $e)
        {
            if($request->expectsJson())
            {
                return back()->with('error', 'There is some trouble to proceed your action!');
            }
        }
    }
}
