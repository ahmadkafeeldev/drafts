<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use App\Models\NewsPaper;
use App\Models\Bookings;
use App\Models\Borough;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use DB;
use Mail;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
        public function index()
    {
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';   
        }

        return view('users.bookings.index', compact('bookings'));
    }
    */
    
    public function index()
    {
        $user_id = Auth::user()->id;
        $bookings = Bookings::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        
        $bookingDetails = []; // Temporary array to store additional data
    
        foreach ($bookings as $booking) {
            // Fetch related data (news_paper, area, borough)
            $user = User::where('id', $booking->user_id)->first();
            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $area = Area::where('id', $booking->area)->first();
            $borough = Borough::where('id', $booking->borough)->first();
            
            // Store additional data in the temporary array
            $bookingDetails[] = [
                'booking' => $booking,
                'user_details' => $user,
                'news_paper_name' => isset($news_paper->name) ? $news_paper->name : '',
                'area_name' => isset($area->name) ? $area->name : '',
                'borough_name' => isset($borough->name) ? $borough->name : ''
            ];
            
            // Define allowed time period for both Permanent and Temporary orders
            $allowedTimePeriod = ($booking->booking_type === 'Permanent') ? 21 : 14; // Permanent = 21 days, Temporary = 14 days
            $lastDate = $booking->publish_date;  // Assuming the publish_date is the date of "Notice of Intent"
            $deadlineDate = date('Y-m-d', strtotime($lastDate . " + $allowedTimePeriod days"));
        
            // Check if "Notice of Making" is missing for both "Permanent" and "Temporary" Traffic Orders
            if ($booking->notice_type === 'Notice of Intent') {
                // Check if "Notice of Making" exists for the same booking
                $makingNotice = Bookings::where('user_id', $user_id)
                                        ->where('borough', $booking->borough)
                                        ->where('booking_type', $booking->booking_type)
                                        ->where('title', $booking->title)
                                        ->where('notice_type', 'Notice of Making')
                                        ->first();
        
                // If "Notice of Making" is not found and the deadline has passed, cancel the booking
                if (!$makingNotice && date('Y-m-d') > $deadlineDate) {
                    $booking->status = 'cancelled';
                    $booking->save();
                }
            }
        }
        
        return view('users.bookings.index', ['bookingDetails' => $bookingDetails]);
    }



    
    

    public function temporary_intent()
    {
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('user_id', $user_id)->where('booking_type', 'temporary')->where('notice_type', 'Notice of Intent')->orderBy('id', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';   
        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function temporary_making()
    {
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('user_id', $user_id)->where('booking_type', 'temporary')->where('notice_type', 'Notice of Making')->orderBy('id', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';    
        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function permanent_intent()
    {
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('user_id', $user_id)->where('booking_type', 'Permanent')->where('notice_type', 'Notice of Intent')->orderBy('id', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';    
        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function permanent_making()
    {
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('user_id', $user_id)->where('booking_type', 'Permanent')->where('notice_type', 'Notice of Making')->orderBy('id', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';    
        }

        return view('users.bookings.index', compact('bookings'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Order by 'name' in ascending order to display alphabetically
        $papers = NewsPaper::orderBy('name', 'asc')->get();
        $areas = Area::orderBy('name', 'asc')->get();
        $boroughs = Borough::orderBy('name', 'asc')->get();
    
        // Fetch existing titles with all related data for dropdown
        $existingTitles = Bookings::where('user_id', Auth::user()->id)
            ->with(['newsPaper', 'area', 'borough'])
            ->get();
        
        return view('users.bookings.create', compact('papers', 'areas', 'boroughs', 'existingTitles'));
    }
    
    

    
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'news_paper_id' => 'required|integer|exists:news_papers,id',
            'title' => 'required|string|max:255',
            'borough' => 'required|integer|exists:boroughs,id',
            'area' => 'required|string|max:255',
            'publish_date' => 'required|date',
            'booking_type' => 'required|in:temporary,Permanent',
            'notice_type' => 'required|string|max:255',
            'document' => 'nullable|mimes:doc,docx,odt,pdf|max:2048', // Max size 2MB
        ]);
    
        $isNewNotice = $request->input('new_notice_title', false);
    
        // Check for existing bookings
        $existingBookings = Bookings::where('user_id', $request->user_id)
                                    ->where('borough', $request->borough)
                                    ->where('booking_type', $request->booking_type)
                                    ->where('title', $isNewNotice ? $request->new_notice_title : $request->title)
                                    ->get();
    
        // Handle "Notice of Intent"
        if ($request->notice_type === 'Notice of Intent') {
            $intentCount = $existingBookings->where('notice_type', 'Notice of Intent')->count();
            if ($intentCount >= 1) {
                return back()->with('error', 'You have already added Notice of Intent.');
            }
        }
    
        // Handle "Notice of Making"
        if ($request->notice_type === 'Notice of Making') {
            $makingCount = $existingBookings->where('notice_type', 'Notice of Making')->count();
            if ($makingCount >= 2) {
                return back()->with('error', 'You have completed the limit of Notice of Making.');
            }
        }
    
        // Handle booking constraints for "Temporary" type
        if ($request->booking_type === 'temporary') {
            $existingBooking = $existingBookings->first();
    
            if ($existingBooking) {
                $last_date = $existingBooking->publish_date;
                $date1 = date('Y-m-d', strtotime($last_date . ' + 7 days'));
                $date2 = date('Y-m-d', strtotime($last_date . ' + 14 days'));
    
                // Check if publish_date is neither $date1 nor $date2
                if ($request->publish_date != $date1 && $request->publish_date != $date2) {
                    return back()->with('error', 'You can book Temporary Notice only on ' . $date1 . ' and ' . $date2 . ' in the same News Paper. Please select one of these dates.');
                }
    
                // Check if there are already 2 bookings
                $bookingCount = $existingBookings->where('booking_type', 'temporary')->count();
                if ($bookingCount >= 2) {
                    return back()->with('error', 'You have already used all your tries for this Temporary Booking.');
                }
            }
        }
    
        // Handle booking constraints for "Permanent" type
        if ($request->booking_type === 'Permanent') {
            $existingBooking = $existingBookings->first();
    
            if ($existingBooking) {
                $last_date = $existingBooking->publish_date;
                $date21DaysLater = date('Y-m-d', strtotime($last_date . ' + 21 days'));
    
                // Check if publish_date is not equal to $date21DaysLater
                if ($request->publish_date != $date21DaysLater) {
                    return back()->with('error', 'You can book Permanent Notice only on ' . $date21DaysLater . ' in the same News Paper. Please select this date.');
                }
            }
        }
    
        // Set booking_date to be three days before publish_date
        $booking_date = date('Y-m-d', strtotime($request->publish_date . ' - 3 days'));
    
        // Proceed with storing the booking if conditions are met
        $booking = new Bookings;
        $booking->user_id = $request->user_id;
        $booking->news_paper_id = $request->news_paper_id;
        $booking->title = $isNewNotice ? $request->new_notice_title : $request->title;
        $booking->borough = $request->borough;
        $booking->area = $request->area;
        $booking->publish_date = $request->publish_date;
        $booking->booking_date = $booking_date; // Set booking_date to be three days before publish_date
        $booking->booking_type = $request->booking_type;
        $booking->notice_type = $request->notice_type;
        $booking->payment_status = 'Unpaid';
        $booking->status = 'pending';
    
        // Set london_gazette based on booking_type
        if ($request->booking_type === 'Permanent') {
            $booking->london_gazette = 'London Gazette';
        } else {
            $booking->london_gazette = null;
        }
    
        // Handle document upload
        if ($request->has('document')) {
            $doc = $request->document;
    
            if (in_array($doc->getClientOriginalExtension(), ['doc', 'docx', 'odt', 'pdf'])) {
                $new_name = rand() . '.' . $doc->getClientOriginalExtension();
                $doc->move(public_path('/uploads'), $new_name);
                $doc_path = 'uploads/' . $new_name;
                $booking->document = $doc_path;
            } else {
                return back()->with('error', 'Please choose a valid document!');
            }
        }
    
        // Save booking
        $booking->save();
    
        // Send email notification
        $user = User::where('id', $booking->user_id)->first();
        $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
        $borough = Borough::where('id', $booking->borough)->first();
    
        $array = [
            'subject' => 'New Booking',
            'email' => env('ADMIN_MAIL'),
            'user' => $user,
            'booking' => $booking,
            'news_paper' => $news_paper,
            'borough' => $borough,
        ];
        Mail::send('emails.new_booking', $array, function ($message) use ($array) {
            $message->to($array['email'])->subject($array['subject']);
        });
    
        // Send notifications
        $notification = new Notification;
        $notification->notification_from = 1;
        $notification->notification_to = $request->user_id;
        $notification->notification = $user->first_name . ' Your booking has been submitted successfully!';
        $notification->notification_type = 'booking';
        $notification->save();
    
        $notification = new Notification;
        $notification->notification_from = $request->user_id;
        $notification->notification_to = 1;
        $notification->notification = $user->first_name . ' has sent you a new booking with title: ' . $request->title;
        $notification->notification_type = 'booking';
        $notification->save();
    
        // Provide message about completed bookings
        $makingCount = $existingBookings->where('notice_type', 'Notice of Making')->count();
        $intentCount = $existingBookings->where('notice_type', 'Notice of Intent')->count();
    
        if ($intentCount >= 1 && $makingCount >= 2) {
            return back()->with('message', 'Booking has been completed with one Intent and two Making Notice Types.');
        }
    
        return back()->with('message', 'Advertisement submitted successfully.');
    }




    /**
     * Display the specified resource.
     */
    public function show(FoodCourse $foodCourse)
    {
        //
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodCourse $foodCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodCourseRequest $request, FoodCourse $foodCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         try{
            $booking = Bookings::find($id);

            if(empty($booking))
            {
                return back()->with('error', 'Booking does not Exists!');
            }            

            $booking->delete();

            return back()->with('message', 'Booking Deleted');

        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action!');
        }
    }


    public function update_proof_doc_status($booking_id , $doc_status)
    {
        // try{
            $booking = Bookings::where('id', $booking_id)->first();
            // dd($booking);
            if(!empty($booking))
            {
                $booking->pdf_status = $doc_status;
                $booking->save();
            }else{
                return back()->with('error', 'Booking does not Exists!');
            }

            $user = User::where('id', $booking->user_id)->first();

            $notification = new Notification;
            $notification->notification_from = 1;
            $notification->notification_to = $booking->user_id;
            $notification->notification = 'You '.$doc_status.' Your Booking Proof Reading Document.'; 
            $notification->notification_type = 'booking';
            $notification->save();

            $notification = new Notification;
            $notification->notification_from = $booking->user_id;
            $notification->notification_to = 1;
            $notification->notification = $user->first_name.' '.$doc_status.' Proof Reading Document With Booking Title: '.$booking->title; 
            $notification->notification_type = 'booking';
            $notification->save();

            $array = [
              'subject' => 'Proof Reading Document '.$doc_status,
              'email' => env('ADMIN_MAIL'),
              'user' => $user,
              'username' =>  'Admin',
              'booking' => $booking,
              'content' => $user->first_name.' '.$doc_status.' Proof Reading Document.',
                ];
                Mail::send('emails.proof_document', $array, function($message) use ($array) {
                  $message->to($array['email'])
                  ->subject($array['subject']);
                });


            return back()->with('message', 'Proof Reading Document Status Updated Successfully!');
        // }catch(\Exception $e)
        // {
        //     return back()->with('error', 'There is Some Trouble , Sorry !');
        // }
    }
}