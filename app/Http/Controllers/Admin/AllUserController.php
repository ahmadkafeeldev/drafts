<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Mail\AccountConfirmation;
use Mail;

class AllUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('type', '1')->orderBy('id', 'desc')->get();

        return view('admin.users.index', compact('users'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::select('id','first_name', 'last_name', 'email', 'profile_image', 'country_code','phone', 'created_at')->find($id);
        // dd($userRides);
        return view('admin.users.view', compact('user'));
        
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
        try{
            $user = User::where('id', $id)->first();

            if(empty($user))
            {
                return back()->with('error', 'User does not Exists');
            }

            // $user->is_verified = 0;
            // $user->save();
            $user->delete();

            return back()->with('message', 'User Deleted.....!');
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }
    }

    public function verify_user(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required|min:6'
            ]);

            if($validator->fails())
            {
                return back()->with('error', $validator->errors()->first());
            }

            $user = User::where('id', $request->user_id)->first();
            if(empty($user))
            {
                return back()->with('error', 'User does not Exists');
            }
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->is_verified = '1';
            $user->save();
            
            // \Mail::to($user->email)->send(new AccountConfirmation($user->name, $request->username, $request->password));

            return back()->with('message', 'User Verified');
        }catch(\Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
    }

    public function verified_users()
    {
        $users = User::where('type', '1')->where('is_verified', '1')->orderBy('id', 'desc')->get();

        return view('admin.users.verified', compact('users'));
    }

    
    // get user info 
    public function user_model($user_id)
    {
        $user = User::where('id', $user_id)->first(['id', 'first_name', 'last_name', 'profile_image']);
        return $user;
    }
}
