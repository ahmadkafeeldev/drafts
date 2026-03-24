<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use App\Models\NewsPaper;
use App\Models\Bookings;
use App\Models\Borough;
use App\Models\DraftsModel;
use App\Models\DraftBookings;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use DB;
use Mail;

class DraftBookingsController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;
        $bookings = DraftBookings::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        // Check if bookings are found
        if ($bookings->isEmpty()) {
            $message = 'No records found for drafts.';
            return view('users.bookings.index', compact('bookings', 'message'));
        }


        foreach ($bookings as $booking) {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

        }
        return view('users.bookings.index', compact('bookings'));
    }

    public function download($id)
    {
        // Fetch the booking by ID
        $booking = DraftBookings::where('id', $id)->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        // Fetch related user and borough details
        $booking->user_details = User::find($booking->user_id);
        $booking->borough_name = Borough::find($booking->borough)->name ?? '';

        if($booking->relevant_order == "14 (1)" || $booking->relevant_order == "15(2)" || $booking->relevant_order == "14 (2)" || $booking->relevant_order == "16(A)" )
        {
            return view('users.bookings.download', compact('booking'));
        }
        else if($booking->relevant_order == "Section 23 Padesterian")
        {
            // Use $this to refer to the current object
            return $this->downloadSection23($id);
        }
        else if($booking->relevant_order == "Section 6")
        {
            // Use $this to refer to the current object
            return $this->downloadSection6($id);
        }
        // else if($booking->relevant_order == "14 (2)")
        // {
            // Use $this to refer to the current object
            // return $this->relevant_order($id);
        // }

        // If no valid condition is met, return an error or fallback view
        return redirect()->back()->with('error', 'Invalid section type.');
    }

    public function downloadSection23($id)
    {
        // Fetch the booking by ID
        $booking = DraftBookings::where('id', $id)->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        // Fetch related user and borough details
        $booking->user_details = User::find($booking->user_id);
        $booking->borough_name = Borough::find($booking->borough)->name ?? '';

        // Pass the booking to the view
        return view('users.bookings.download-section-23', compact('booking'));
    }

    public function downloadSection6($id)
    {
        // Fetch the booking by ID
        $booking = DraftBookings::where('id', $id)->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        // Fetch related user and borough details
        $booking->user_details = User::find($booking->user_id);
        $booking->borough_name = Borough::find($booking->borough)->name ?? '';

        // Pass the booking to the view
        return view('users.bookings.download-section-6', compact('booking'));
    }

    public function downloadSection15_2($id)
    {
        // Fetch the booking by ID
        $booking = DraftBookings::where('id', $id)->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        // Fetch related user and borough details
        $booking->user_details = User::find($booking->user_id);
        $booking->borough_name = Borough::find($booking->borough)->name ?? '';

        // Pass the booking to the view
        return view('users.bookings.section_15_2', compact('booking'));
    }



    public function create_tmplan()
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

    public function temporary_intent()
    {
        $user_id = Auth::user()->id;
        $bookings = DraftBookings::where('user_id', $user_id)
                                  ->where('booking_type', 'temporary')
                                  ->where('notice_type', 'Notice of Intent')
                                  ->orderBy('id', 'desc')
                                  ->get();

        // Check if bookings are found
        if ($bookings->isEmpty()) {
            $message = 'No records found for temporary bookings with Notice of Intent.';
            return view('users.bookings.index', compact('bookings', 'message'));
        }

        foreach ($bookings as $booking) {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

        }

        return view('users.bookings.index', compact('bookings'));
    }


    public function temporary_making()
    {


        $user_id=Auth::user()->id;
        $bookings = DraftBookings::where('user_id', $user_id)->where('booking_type', 'temporary')->where('notice_type', 'Notice of Making')->orderBy('id', 'desc')->get();

        // Check if bookings are found
        if ($bookings->isEmpty()) {
            $message = 'No records found for temporary bookings with Notice of Making.';
            return view('users.bookings.index', compact('bookings', 'message'));
        }

        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function permanent_intent()
    {


        $user_id=Auth::user()->id;
        $bookings = DraftBookings::where('user_id', $user_id)->where('booking_type', 'Permanent')->where('notice_type', 'Notice of Intent')->orderBy('id', 'desc')->get();

        // Check if bookings are found
        if ($bookings->isEmpty()) {
            $message = 'No records found for permanent bookings with Notice of Intent.';
            return view('users.bookings.index', compact('bookings', 'message'));
        }

        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function permanent_making()
    {


        $user_id=Auth::user()->id;
        $bookings = DraftBookings::where('user_id', $user_id)->where('booking_type', 'Permanent')->where('notice_type', 'Notice of Making')->orderBy('id', 'desc')->get();

         // Check if bookings are found
        if ($bookings->isEmpty()) {
            $message = 'No records found for permanent bookings with Notice of making.';
            return view('users.bookings.index', compact('bookings', 'message'));
        }

        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function experimental_intent()
    {
        $user_id=Auth::user()->id;
        $bookings = DraftBookings::where('user_id', $user_id)->where('booking_type', 'Experimental')->where('notice_type', 'Notice of Intent')->orderBy('id', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function experimental_making()
    {
        $user_id=Auth::user()->id;
        $bookings = DraftBookings::where('user_id', $user_id)->where('booking_type', 'Experimental')->where('notice_type', 'Notice of Making')->orderBy('id', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

        }

        return view('users.bookings.index', compact('bookings'));
    }

    public function create()
    {
        // Order by 'name' in ascending order to display alphabetically
        // $papers = NewsPaper::orderBy('name', 'asc')->get();
        $areas = Area::orderBy('name', 'asc')->get();
        $boroughs = Borough::orderBy('name', 'asc')->get();

        $draftBoking = new DraftBookings();

        // Fetch existing titles with all related data for dropdown
        // $existingTitles = Bookings::where('user_id', Auth::user()->id)->with(['newsPaper', 'area', 'borough'])->get();
        $drafts = DraftsModel::all();

        // dd($drafts, $boroughs);
        // Pass drafts to the view
        // return view('users.public_notice')->with('drafts', $drafts);

        return view('users.bookings.create', compact('drafts', 'areas', 'boroughs'));
    }

    public function store(Request $request)
    {
        // try
        // {
            // dd($request->all());
            // Validate the incoming request
            // $request->validate([
            //     'user_id' => 'nullable|integer|exists:users,id',
            //     'booking_type' => 'nullable|string|max:255',
            //     'notice_type' => 'nullable|string|max:255',
            //     'relevant_order' => 'nullable|string|max:255',
            //     'plan' => 'nullable',
            //     'work_permit' => 'nullable|string|max:255',
            //     'permit_number' => 'nullable|string|max:255',

            //     'authourities' => 'nullable|string|max:255',
            //     'work_place' => 'nullable|string|max:255',
            //     'borough' => 'nullable|string|max:255',
            //     'closure_type' => 'nullable|string|max:255',
            //     'work_purpose' => 'nullable|string|max:255',
            //     'effect_of_the_order' => 'nullable|string|max:255',
            //     'vehicle_from' => 'nullable|string|max:255',
            //     'prohibition_traffic' => 'nullable|string|max:255',
            //     'order_year' => 'nullable|string|max:255',
            //     'order_under_section' => 'nullable|string|max:255',
            //     'order_type' => 'nullable|string|max:255',
            //     'place_at' => 'nullable|string|max:255',
            //     'diversion_plans' => 'nullable|string|max:255',

            //     'start_time' => 'nullable|time',
            //     'end_time' => 'nullable|time',
            //     'from_date' => 'nullable|date',
            //     'to_date' => 'nullable|date|after:from_date',

            //     'transport_for' => 'nullable|string|max:255',
            //     'copy_of_the_order' => 'nullable|string|max:255',
            //     'road' => 'nullable|string|max:255',
            //     'road_affected_by_the_order' => 'nullable|string|max:255',
            //     'reasons_for_the_proposals' => 'nullable|string|max:255',
            //     'proposed_order' => 'nullable|string|max:255',
            //     'objections' => 'nullable|string|max:255',
            //     'quoting_reference' => 'nullable|string|max:255',
            //     'bus_priority' => 'nullable|string|max:255',

            //     'person_title' => 'nullable|string|max:255',
            //     'palestra_address' => 'nullable|string|max:255',


            // ]);

            // Get the authenticated user
            $currentUser = Auth::user();

            // Create new booking instance
            $booking = new DraftBookings();

            // type_suspension_values
            if(!$request->has('plan_doc'))
            {
                 return back()->with('message', 'You must need a plan');
            }
            $booking->user_id = $request->user_id ?? $currentUser->id;
            $booking->booking_type = $request->booking_type ?? '';
            $booking->type_suspension_values = $request->type_suspension_values ?? '';
            $booking->notice_type = $request->notice_type ?? '';
            $booking->relevant_order = $request->relevant_order ?? '';
            $booking->plan = $request->plan ?? '';
            $booking->work_permit = $request->work_permit ?? '';
            $booking->permit_number = $request->permit_number ?? '';
            $booking->authourities = $request->authourities ?? '';
            // $booking->title = $request->title ?? '';
            $booking->work_place = $request->work_place ?? '';
            // $booking->booking_title = $request->title_order_type ?? '';
            // $booking->junction_address = $request->junction_address ?? ''; // Set to '' if not provided
            $booking->borough = $request->borough ?? '';
            // $booking->work_place_borough = $request->work_place_borough ?? '';
            $booking->agreement_101 = $request->agreement_101 ?? '';
            $booking->closure_type = $request->closure_type ?? '';
            $booking->work_purpose = $request->work_purpose ?? '';
            $booking->effect_orders = $request->effect_orders ?? '';
            $booking->vehicle_from = $request->vehicle_from ?? '';
            $booking->prohibition_traffic = $request->prohibition_traffic ?? '';
            $booking->order_year = $request->order_year ?? '';
            $booking->order_under_section = $request->order_under_section ?? '';
            $booking->order_type = $request->order_type ?? '';
            $booking->place_at = $request->place_at ?? '';
            $booking->diversion_plans = $request->diversion_plans ?? '';


            $booking->start_time = $request->start_time ?? ''; // Set to '' if not provided
            $booking->end_time = $request->end_time ?? ''; // Set to '' if not provided
            $booking->from_date = $request->from_date ?? ''; // Set to '' if not provided
            $booking->to_date = $request->to_date ?? ''; // Set to '' if not provided


            $booking->transport_for = $request->transport_for ?? $request->transport_for_london;
            $booking->road = $request->road ?? '';
            $booking->road_affected_by_the_order = $request->road_affected_by_the_order ?? '';
            $booking->copy_of_the_order = $request->copy_of_the_order ?? ''; // //
            $booking->reasons_for_the_proposals = $request->reasons_for_the_proposals   ?? '';
            $booking->bus_priority = $request->bus_priority   ?? '';
            $booking->proposed_order = $request->proposed_order ?? '';
            $booking->objections = $request->objections ?? '';
            $booking->quoting_reference = $request->quoting_reference   ?? '';


            $booking->person_title = $request->person_title ??  $request->s23_person_title;
            // $booking->palestra_address = $request->s23_palestra_address   ?? '';
            $booking->palestra_address = $request->palestra_address   ?? $request->s23_palestra_address ?? '';
            // $booking->status = 'pending'; // Default status
            $booking->status = 'saved'; // Default status


            if ($request->has('plan_doc')) {
                $doc = $request->plan_doc;
                $new_name = rand() . '.' . $doc->getClientOriginalExtension();
                $doc->move(public_path('/uploads'), $new_name);
                $doc_path = 'uploads/' . $new_name;
                $booking->plan_document = $doc_path;
            } else {
                $booking->plan_document = '';
            }

            if ($request->has('signature')) {
                $doc = $request->signature;
                $new_name = rand() . '.' . $doc->getClientOriginalExtension();
                $doc->move(public_path('/uploads'), $new_name);
                $doc_path = 'uploads/' . $new_name;
                $booking->signature = $doc_path;
            } else {
                $booking->signature = '';
            }

            // Save the booking
            $booking->save();

            // Send email notification
            $user = User::find($booking->user_id);
            $news_paper = NewsPaper::find($request->news_paper_id);
            $borough = Borough::find($request->borough);

            // $array = [
            //     'subject' => 'New Drafting Booking'. $request->relevant_order,
            //     'email' => env('ADMIN_MAIL'),
            //     'user' => $user,
            //     'booking' => $booking,
            //     'borough' => $borough,
            // ];
            // Mail::send('emails.new_draft', $array, function ($message) use ($array) {
            //     $message->to($array['email'])->subject($array['subject']);
            // });

            // Send notifications
            $notification = new Notification;
            $notification->notification_from = 1; // Assuming 1 is the admin
            $notification->notification_to = $request->user_id;
            $notification->notification = $user->first_name . ' Your drafting booking has been Saved Successfully!';
            $notification->save();

            return back()->with('message', 'Booking Draft Created');
        // }
        // catch (\Exception $e)
        // {
        //     return back()->with('error', 'Booking Draft Could not be created: ' . $e->getMessage());
        // }
    }






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
            $booking = DraftBookings::where('id', $id);

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
