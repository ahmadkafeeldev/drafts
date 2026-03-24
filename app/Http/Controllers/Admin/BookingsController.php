<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use App\Models\NewsPaper;
use App\Models\Bookings;
use App\Models\Borough;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;
use Mail;
use App\Mail\NewsPaperMail;
use App\Mail\AccountConfirmation;


class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = isset($user) ? $user : '';

            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : Null;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
        }

        // dd($bookings);

        return view('admin.bookings.index', compact('bookings','papers','staff'));
    }

    public function processing_bookings()
    {
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'processing')->orderBy('created_at', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = isset($user) ? $user : '';

            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : Null;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
        }

        return view('admin.bookings.index', compact('bookings','papers','staff'));
    }

    public function completed_bookings()
    {
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'completed')->orderBy('created_at', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = isset($user) ? $user : '';

            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : Null;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
        }

        return view('admin.bookings.index', compact('bookings','papers','staff'));
    }

    public function cancelled_bookings()
    {
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'cancelled')->orderBy('created_at', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = isset($user) ? $user : '';

            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : Null;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
        }

        return view('admin.bookings.index', compact('bookings','papers','staff'));
    }

     public function showBookingById($id)
    {
        $bookings = Bookings::where('id', $id)->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = $news_paper->name;

            $area = Area::where('id', $booking->area)->first();
            $booking->area = $area->name;     
        }
        return response()->json($bookings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
        $booking = new Bookings;
        $booking->name  = $request->name;
        
        $booking->save();       
        return back()->with('message','Bookings Add successfully');      
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $booking = Bookings::find($request->booking_id);
        if(empty($booking))
        {
            return back()->with('error', 'Booking does not Exists!');
        }
        if($request->has('news_paper_id'))
        {
            $booking->news_paper_id  = $request->news_paper_id;
        }
        $booking->price  = $request->price;
        $booking->currency_symbol  = $request->currency_symbol;
        $booking->save();

        return back()->with('message', 'Booking Updated Successfully!');

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


    // Mail Controller
    public function showBookingByIdForMail($id)
    {
        $booking = Bookings::findOrFail($id);

        $user = User::where('id', 3)->first();
        
        return view('emails.bookingMail', compact('booking', 'user'));
    }

    public function acceptBooking(Request $request, $id)
    {
        $booking = Bookings::findOrFail($id);

        // Ensure user details are included in the email
        $user = User::find($booking->user_id);

        // dd($user->email);

        if (!$user->email) {
            return redirect()->back()->with('error', 'Email address is not set for this booking.');
        }

        // Send email
        // Mail::to($user->email)->send(new AcceptOrRejectBookingMail($user));
        // \Mail::to($user->email)->send(new AccountConfirmation($user->first_name, $request->last_name, $request->password));


        return redirect()->route('admin.bookings.index')->with('message', 'Booking accepted and email sent.');
    }

    public function mail($id) 
    {
        $booking = Bookings::findOrFail($id);
        $user = User::where('id', $booking->user_id)->first();
        return view('emails.bookingMail', compact('booking', 'user'));
    }
    
    public function recipientDetails($id) 
    {
        $booking = Bookings::findOrFail($id);
        $user = User::where('id', $booking->user_id)->first();
        return view('admin.bookings.recipientDetails', compact('booking', 'user'));
    }

    public function proof_pdf(Request $request) 
    {
        // dd($request);
        $booking = Bookings::findOrFail($request->booking_id);
        if(empty($booking))
        {
            return back()->with('error', 'Booking does not Exists!');
        }

        if($request->has('pdf'))
        {
            $doc = $request->pdf;
            if($doc->getClientOriginalExtension() == 'pdf')
            {
                $new_name = rand().'.'.$doc->getClientOriginalExtension();
                $doc->move(public_path('/uploads'), $new_name);
                $doc_path = 'uploads/'.$new_name;  
            }else{  
                return back()->with('error', 'Please Choose a Valid Pdf Document!');
            }         
            $booking->proof_pdf = $doc_path;       
        }
        $booking->pdf_status  = 'pending';
        $booking->save();

        $user = User::where('id', $booking->user_id)->first();

        $notification = new Notification;
        $notification->notification_from = 1;
        $notification->notification_to = $booking->user_id;
        $notification->notification = 'Admin Sends You A Booking Proof Reading Document Kindly Read Document Carefully and Accept/Reject the Document.'; 
        $notification->notification_type = 'booking';
        $notification->save();

        $array = [
          'subject' => 'Booking Proof Reading Document',
          'email' => $user->email,
          'user' => $user,
          'username' => $user->first_name,
          'booking' => $booking,
          'content' => 'Admin Sends You A Booking Proof Reading Document Kindly Read Document Carefully and Accept/Reject the Document So Admin Can Proceed Your Booking.',
        ];
        Mail::send('emails.proof_document', $array, function($message) use ($array) {
          $message->to($array['email'])
          ->subject($array['subject']);
        });


        return back()->with('message', 'Booking Proof Reading Document Submitted Successfully.');
    }

    public function update_booking_status($booking_id, $booking_status)
    {
        // Retrieve the booking record
        $booking = Bookings::where('id', $booking_id)->first();
    
        if (!empty($booking)) {
            // Update the payment status or the booking status based on the provided status
            if ($booking_status == 'Paid' || $booking_status == 'Due') {
                $booking->payment_status = $booking_status;
            } else {
                $booking->status = $booking_status;
            }
            $booking->save();
        } else {
            return back()->with('error', 'Booking does not exist!');
        }
    
        // Notify the user about the status update
        $user = User::where('id', $booking->user_id)->first();
    
        // Notification for the user
        $notification = new Notification;
        $notification->notification_from = 1;
        $notification->notification_to = $booking->user_id;
        $notification->notification = 'Admin updated your booking status to ' . $booking_status . '.'; 
        $notification->notification_type = 'booking';
        $notification->save();
    
        // Notification for the admin
        $notification = new Notification;
        $notification->notification_from = $booking->user_id;
        $notification->notification_to = 1;
        $notification->notification = 'You updated ' . $user->first_name . '\'s booking status to ' . $booking_status . ' with booking title: ' . $booking->title; 
        $notification->notification_type = 'booking';
        $notification->save();
    
        // Prepare email data for the user
        $array = [
            'subject' => 'Booking Status Updated to ' . $booking_status,
            'email' => $user->email,
            'user' => $user,
            'username' => $user->first_name,
            'booking' => $booking,
            'content' => 'Admin updated your booking status to ' . $booking_status . '.',
        ];
    
        // try {
            Mail::send('emails.proof_document', $array, function ($message) use ($array) {
                $message->to($array['email'])
                    ->subject($array['subject']);
            });
        
         return back()->with('message', 'Booking status updated successfully!');
    }
    
    public function newspaper_mail($booking_id)
    {
        $booking = Bookings::where('id', $booking_id)->first();
        if (empty($booking)) {
            return back()->with('error', 'Booking does not exist!');
        }
        
        if( is_null($booking->proof_pdf) || empty($booking->proof_pdf) ){
            return back()->with('error', 'Proof Reading Document does not exist Mail sent TO News Paper After Document Uploaded!');
        }
        
        $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
        if (empty($news_paper)) {
            return back()->with('error', 'Booking does not exist!');
        }
        $array = [
            'subject' => 'News Paper Booking',
            'email' => $news_paper->email,
            'filePath' => IMAGE_URL . $booking->proof_pdf,
            'content' => 'This is the ‘' . $booking->booking_type . ' ' . $booking->notice_type . '’ we would like you to publish in your ' . $news_paper->name . ' on ' . $booking->publish_date . '. Please send us the booking confirmation, size, and cost, and we shall send you our approval within 24 hours.',
        ];


        Mail::to($array['email'])->send(new NewsPaperMail($array));
            
         return back()->with('message', 'Mail sent TO News Paper successfully!');
    }


    public function assign_staff($booking_id, $staff_id)
    {
        $staff = User::where('id', $staff_id)->first();
        if (empty($staff)) {
            return back()->with('error', 'Staff does not exist!');
        }

        $booking = Bookings::where('id', $booking_id)->first();
        if (!empty($booking)) {
            
            if( is_null($booking->proof_pdf) || empty($booking->proof_pdf) ){
                return back()->with('error', 'Proof Reading Document does not exist Staff Assign After Document Uploaded!');
            }
            
            $booking->assign_to = $staff_id;
            $booking->delivery_status = 'Pending';
            $booking->save();
        } else {
            return back()->with('error', 'Booking does not exist!');
        }
    
        // Notification for the user
        $notification = new Notification;
        $notification->notification_from = 1;
        $notification->notification_to = $staff_id;
        $notification->notification = 'Admin Assign you A New booking With Title ' . $booking->title . '.'; 
        $notification->notification_type = 'booking_assign';
        $notification->save();
    
        // Notification for the admin
        $notification = new Notification;
        $notification->notification_from = $staff_id;
        $notification->notification_to = 1;
        $notification->notification = 'You Assign A Booking To Staff ' . $staff->first_name . $staff->last_name . ' with Booking title: ' . $booking->title; 
        $notification->notification_type = 'booking_assign';
        $notification->save();
    
        // Prepare email data for the user
        $array = [
            'subject' => 'Admin Assign you A New booking',
            'email' => $staff->email,
            'user' => $staff,
            'username' => $staff->first_name,
            'booking' => $booking,
            'content' =>  'Admin Assign you A New booking With Title ' . $booking->title . '.',
        ];
    
        Mail::send('emails.booking_assign', $array, function ($message) use ($array) {
            $message->to($array['email'])->subject($array['subject']);
        });
        
         return back()->with('message', 'Booking Assign To Staff successfully!');
    }
    
    
    
    // 
    // PLO Orders Related
   public function plo_index()
    {
        // Show all pending bookings (status 'pending')
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'pending')
                    ->where('work_title', '!=', '')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        foreach ($bookings as $booking) {
            // Fetch user details
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;
            
            // Fetch assigned staff details
            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : null;
    
            // Fetch related newspaper details
            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';
    
            // Fetch area details
            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 
    
            // Fetch borough details
            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
    
            // Include work-specific fields
            $booking->start_date = $booking->start_date;
            $booking->end_date = $booking->end_date;
            $booking->work_area = $booking->work_area;
    
            // Add file upload links or paths (if they exist)
            $booking->upload_plan_map = $booking->upload_plan_map ? asset($booking->upload_plan_map) : null;
            $booking->upload_documents = $booking->upload_documents ? asset($booking->upload_documents) : null;
        }
    
        // Pass data to the view
        return view('admin.bookings.plo_index', compact('bookings', 'papers', 'staff'));
    }


    public function plo_processing_bookings()
    {
        // Show all pending bookings (status 'pending')
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'processing')
                    ->where('work_title', '!=', '')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        foreach ($bookings as $booking) {
            // Fetch user details
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;
            
            // Fetch assigned staff details
            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : null;
    
            // Fetch related newspaper details
            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';
    
            // Fetch area details
            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 
    
            // Fetch borough details
            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
    
            // Include work-specific fields
            $booking->start_date = $booking->start_date;
            $booking->end_date = $booking->end_date;
            $booking->work_area = $booking->work_area;
    
            // Add file upload links or paths (if they exist)
            $booking->upload_plan_map = $booking->upload_plan_map ? asset($booking->upload_plan_map) : null;
            $booking->upload_documents = $booking->upload_documents ? asset($booking->upload_documents) : null;
        }
    

        return view('admin.bookings.plo_index', compact('bookings','papers','staff'));
    }

    public function plo_completed_bookings()
    {
        // Show all pending bookings (status 'pending')
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'completed')
                    ->where('work_title', '!=', '')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        foreach ($bookings as $booking) {
            // Fetch user details
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;
            
            // Fetch assigned staff details
            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : null;
    
            // Fetch related newspaper details
            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';
    
            // Fetch area details
            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 
    
            // Fetch borough details
            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
    
            // Include work-specific fields
            $booking->start_date = $booking->start_date;
            $booking->end_date = $booking->end_date;
            $booking->work_area = $booking->work_area;
    
            // Add file upload links or paths (if they exist)
            $booking->upload_plan_map = $booking->upload_plan_map ? asset($booking->upload_plan_map) : null;
            $booking->upload_documents = $booking->upload_documents ? asset($booking->upload_documents) : null;
        }
    

        return view('admin.bookings.plo_index', compact('bookings','papers','staff'));
    }

    public function plo_cancelled_bookings()
    {
        // Show all pending bookings (status 'pending')
        $staff = User::where('type', '2')->orderBy('id', 'desc')->get();
        $papers = NewsPaper::orderBy('id', 'desc')->get();
        $bookings = Bookings::where('status', 'cancelled')
                    ->where('work_title', '!=', '')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        foreach ($bookings as $booking) {
            // Fetch user details
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;
            
            // Fetch assigned staff details
            $assign = User::where('id', $booking->assign_to)->first();
            $booking->assign_to = isset($assign) ? $assign : null;
    
            // Fetch related newspaper details
            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';
    
            // Fetch area details
            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 
    
            // Fetch borough details
            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough->name) ? $borough->name : '';     
    
            // Include work-specific fields
            $booking->start_date = $booking->start_date;
            $booking->end_date = $booking->end_date;
            $booking->work_area = $booking->work_area;
    
            // Add file upload links or paths (if they exist)
            $booking->upload_plan_map = $booking->upload_plan_map ? asset($booking->upload_plan_map) : null;
            $booking->upload_documents = $booking->upload_documents ? asset($booking->upload_documents) : null;
        }
    

        return view('admin.bookings.plo_index', compact('bookings','papers','staff'));
    }

}