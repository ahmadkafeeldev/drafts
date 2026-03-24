<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TMPlanModel;
use App\Models\Bookings;
use App\Models\Notification;
use Illuminate\Http\Request;
use Auth;
use Mail;

class DraftTMPlanBookingsController extends Controller
{
    public function create()
    {
        // Fetch existing titles for the dropdown
        $existingTitles = Bookings::where('user_id','!=','')
            ->with(['newsPaper', 'area', 'borough'])
            ->get();
        
        return view('users.bookings.tmplan_create', compact('existingTitles'));
    }
    
    public function getMaps(Request $request)
{
    $plans = TMPlanModel::where('user_id','!=','')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'plans'   => $plans
    ]);
}

  public function store(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:512',
        'geojson' => 'required', // since we pass raw object
    ]);

    $plan = new TMPlanModel();
    $plan->user_id = $request->user_id;
    $plan->name    = $request->name;
   $plan->geojson = json_encode($request->geojson);
    $plan->save();

    return response()->json([
        'success' => true,
        'message' => 'Traffic Management Plan saved successfully!',
        'plan'    => $plan
    ]);
}



    // public function store(Request $request)
    // {
        
    //     // Validate the incoming request
    //     $request->validate([
    //         'user_id'               => 'required|integer|exists:users,id',
    //         'source'                => 'required|string|max:255',
    //         'destination'           => 'required|string|max:255',
    //         'distance'              => 'required|string|max:255',
    //     ]);
        
        

    //     // Fetch the user by ID
    //     $user = User::find($request->user_id);
        
    //     if (!$user) {
    //         return back()->with('error', 'User not found!');
    //     }
        
    //     // Create and store the Traffic Management Plan (TMPlan)
        
    //     $plan = new TMPlanModel;
    //     $plan->user_id = $request->user_id;
    //     $plan->source_location = $request->source;
    //     $plan->destination_location = $request->destination;
    //     $plan->total_distance = $request->distance;
    //     $plan->distance_unit = 'km'; 

    //     $plan->save();

        
    
    //     // Send email notification to the user
    //     $emailData = [
    //         'subject' => 'Traffic Management Plan Submitted Successfully',
    //         'email' => $user->email,
    //         'user' => $user,
    //         'plan' => $plan,
    //     ];
        
    //     Mail::send('emails.new_tmplan', $emailData, function ($message) use ($emailData) {
    //         $message->to($emailData['email'])->subject($emailData['subject']);
    //     });

    //     // Send notification to the user
    //     $userNotification = new Notification;
    //     $userNotification->notification_from = 1; // Admin ID
    //     $userNotification->notification_to = $user->id;
    //     $userNotification->notification = 'Your Traffic Management Plan has been submitted successfully!';
    //     $userNotification->notification_type = 'Traffic Management Plan';
    //     $userNotification->save();
    
    //     // Notification for admin
    //     $adminNotification = new Notification;
    //     $adminNotification->notification_from = $user->id; // From the user
    //     $adminNotification->notification_to = 1; // Admin ID
    //     $adminNotification->notification = $user->first_name . ' has submitted a new Traffic Management Plan.';
    //     $adminNotification->notification_type = 'Traffic Management Plan';
    //     $adminNotification->save();
    
    //     // Return success message
    //     return back()->with('message', 'Traffic Management Plan submitted successfully.');
    // }
}
