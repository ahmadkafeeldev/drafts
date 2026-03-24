<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\RidePost;
use App\Models\UserVehicle;
use App\Models\User;
use App\Models\Booking;
use App\Models\event;
use App\Models\Options;
use App\Models\ReviewRating;
use Carbon\Carbon;
use Session;
use Stripe;
use Validator;
use Auth;
use App\Models\PickupPoint;
use App\Models\WithdrawRequest;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        // $this->middleware('auth:sanctum')->except('functionName');
        // $this->middleware('auth:sanctum')->except(['firstFunctionName','secondFunctionName']);
    }

    // get user info
    public function user_model($user_id)
    {
        $user = User::where('id', $user_id)->first(['id', 'first_name', 'last_name', 'profile_image', 'country_code', 'phone']);
        return $user;
    }
    // get vehicle info 
    public function vehicle_model($vehicle_id)
    {
        $vehicle = UserVehicle::where('id', $vehicle_id)->first(['id', 'brand_name', 'model_name', 'number_plate']);
        return $vehicle;
    }

    // get ride info
    public function ride_model($id)
    {
        $post = RidePost::where('id', $id)->first();
        return $post;
    }

    // CRUD on ride post
    public function ride_post(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'action' => 'required|string|in:create,view,edit,delete',
                'post_id' => 'required_if:action,==,edit,delete',
                'vehicle_id' => 'required_if:action,==,create,edit',
                'event_id' => 'sometimes|nullable',
                'ride_type' => 'required_if:action,==,create',
                'ride_title' => 'required_if:action,==,create',
                'ride_description' => 'sometimes|nullable', 
                'per_seat_price' => 'required_if:action,==,create',
                'price_currency' => 'sometimes|nullable',
                'number_of_seats' => 'required_if:action,==,create', 
                'departure_city' => 'required_if:action,==,create', 
                'departure_latitude' => 'required_if:action,==,create', 
                'departure_longitude' => 'required_if:action,==,create', 
                'arrival_city' => 'required_if:action,==,create', 
                'arrival_latitude' => 'required_if:action,==,create', 
                'arrival_longitude' => 'required_if:action,==,create', 
                'pickup_points' => 'required_if:action,==,create', 
                'ride_date' => 'sometimes|nullable',
                'leaving_date' => 'sometimes|nullable',
                'leaving_time' => 'sometimes|nullable',
                'returning_date' => 'sometimes|nullable',
                'returning_time' => 'sometimes|nullable',
                'recurring_at' => 'sometimes|nullable',
                'recurring_time' => 'sometimes|nullable',
                'duration' => 'sometimes|nullable',
            ]);

            if($validator->fails())
            {
                return $this->error($validator->errors()->first());
            }

            if($request->action == "create")
            {   
                $vehicles = UserVehicle::where('user_id', Auth::user()->id)->first();
                if(empty($vehicles))
                {
                    return $this->error('Please add vehicles before creating Post');
                }

                $post = new RidePost;
                $post->user_id = \Auth::user()->id;
                $post->ride_type = $request->ride_type;
                $post->ride_title = $request->ride_title;
                $post->vehicle_id = $request->vehicle_id;
                $post->event_id = $request->event_id==0?null:$request->event_id;
                $post->per_seat_price = $request->per_seat_price;
                $post->price_currency = $request->price_currency;
                $post->number_of_seats = $request->number_of_seats;
                $post->departure_city = $request->departure_city;
                $post->departure_latitude = $request->departure_latitude;
                $post->departure_longitude = $request->departure_longitude;
                $post->arrival_city = $request->arrival_city;
                $post->arrival_latitude = $request->arrival_latitude;
                $post->arrival_longitude = $request->arrival_longitude;
                if($request->ride_type === 'One Way'){
                    $post->leaving_date = Carbon::parse($request->leaving_date)->format('d F Y');
                    $post->leaving_time = Carbon::parse($request->leaving_time)->format('h:i A');
                }else if($request->ride_type === 'Return'){
                    $post->leaving_date = Carbon::parse($request->leaving_date)->format('d F Y');
                    $post->leaving_time = Carbon::parse($request->leaving_time)->format('h:i A');
                    $post->returning_date = Carbon::parse($request->returning_date)->format('d F Y');
                    $post->returning_time = Carbon::parse($request->returning_time)->format('h:i A');
                }else if($request->ride_type == 'Recurring'){
                    $post->ride_date = Carbon::parse($request->ride_date)->format('d F Y');
                    $post->leaving_time = Carbon::parse($request->recurring_at)->format('h:i A');
                    $post->returning_time = Carbon::parse($request->recurring_time)->format('h:i A');
                    $post->duration = $request->duration;                
                }
                $post->save();

                if($request->has('pickup_points') && !empty($request->pickup_points))
                {
                    foreach(json_decode($request->pickup_points) as $point)
                    {
                        $p = new PickupPoint;
                        $p->post_id = $post->id;
                        $p->city = $point->city;
                        $p->location = $point->location;
                        $p->latitude = $point->latitude;
                        $p->longitude = $point->longitude;
                        $p->price = $point->price;
                        $p->price_currency = $point->price_currency;
                        $p->save();
                    }
                }

                return $this->success(['Ride Post Saved']);
            }elseif($request->action == "view")
            {
                // $currentPosts = RidePost::with('pickup_points')->withCount('bookings')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
                // $oldPosts = RidePost::whereHas('bookings', function ($query) {
                //     $query->whereIn('status', ['completed']);
                // })->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

                $current_posts = RidePost::withCount(['bookings' => function ($query) {
                    $query->whereNotIn('status', ['rejected' , 'cancelled']);
                }])->with('event')->where('user_id', \Auth::user()->id)->where('status','active')->orderBy('id', 'desc')->get();
                if(!empty($current_posts))
                {
                    foreach($current_posts as $post)
                    {
                        $post->pickup_points = PickupPoint::where('post_id', $post->id)->get();
                    }
                }
                
                $completed_posts = RidePost::whereHas('bookings', function ($query) {
                        $query->whereIn('status', ['completed']);
                    })->with('event')->where('user_id', \Auth::user()->id)->where('status','completed')->orderBy('id', 'desc')->get();
                if(!empty($completed_posts))
                {
                    foreach($completed_posts as $post)
                    {
                        $post->pickup_points = PickupPoint::where('post_id', $post->id)->get();
                    }
                }

                return $this->success([$current_posts->count() > 0 ? 'Ride Posts Found' : 'No Ride Post Found', ['currentPosts' => $current_posts, 'oldPosts' => $completed_posts]]);
            }elseif($request->action == "edit")
            {
                $post = RidePost::where('id', $request->post_id)->first();
                if(empty($post))
                {
                    return $this->error('Post not found');
                }
                if($request->has('ride_type') && !empty($request->ride_type))
                {
                    $post->ride_type = $request->ride_type;
                }
                if($request->has('vehicle_id') && !empty($request->vehicle_id))
                {
                    $post->vehicle_id = $request->vehicle_id;
                }
                if($request->has('event_id') && !empty($request->event_id))
                {
                    $post->event_id = $request->event_id==0?null:$request->event_id;
                }
                if($request->has('ride_title') && !empty($request->ride_title))
                {
                    $post->ride_title = $request->ride_title;
                }
                if($request->has('ride_description') && !empty($request->ride_description))
                {
                    $post->ride_description = $request->ride_description;
                }
                if($request->has('per_seat_price') && !empty($request->per_seat_price))
                {
                    $post->per_seat_price = $request->per_seat_price;
                }
                if($request->has('price_currency') && !empty($request->price_currency))
                {
                    $post->price_currency = $request->price_currency;
                }
                if($request->has('number_of_seats') && !empty($request->number_of_seats))
                {
                    $post->number_of_seats = $request->number_of_seats;
                }
                if($request->has('departure_city') && !empty($request->departure_city))
                {
                    $post->departure_city = $request->departure_city;
                    $post->departure_latitude = $request->departure_latitude;
                    $post->departure_longitude = $request->departure_longitude;
                }
                if($request->has('arrival_city') && !empty($request->arrival_city))
                {
                    $post->arrival_city = $request->arrival_city;
                    $post->arrival_latitude = $request->arrival_latitude;
                    $post->arrival_longitude = $request->arrival_longitude;
                }
                if($request->has('ride_date') && !empty($request->ride_date))
                {
                    $post->ride_date = Carbon::parse($request->ride_date)->format('d F Y');
                }
                
                if($request->has('ride_time') && !empty($request->ride_time))
                {
                    $post->ride_time = Carbon::parse($request->ride_time)->format('h:i A');
                }
                
                // if($request->has('pickup_latitude') && !empty($request->pickup_latitude))
                // {
                //     $post->pickup_latitude = $request->pickup_latitude;
                // }
                
                // if($request->has('pickup_longitude') && !empty($request->pickup_longitude))
                // {
                //     $post->pickup_longitude = $request->pickup_longitude;
                // }

                $post->save();
                return $this->success(['Ride Post Saved']);
            }elseif($request->action == "delete")
            {
                $post = RidePost::where('id', $request->post_id)->first();
                if(empty($post))
                {
                    return $this->error('Post not found');
                }
                $post->delete();
                return $this->success(['Post Deleted']);
            }else{
                return $this->error('Invalid Action');
            }
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // get Events list 
    public function event_banners(Request $request)
    {
        try{
            $nearby = event::get();
            if(!empty($nearby))
            {
                foreach($nearby as $n)
                {
                    if(!empty($n->event_banner))
                    {
                        $n->event_banner = url('/').'/'.$n->event_banner;
                    }else{
                        $n->event_banner = "";
                    }
                }
            }
            return $this->success([sizeof($nearby) > 0 ? 'Events Found' : 'No Event Found', $nearby]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // search post on basis of event id and date 
    public function search_post(Request $request)
    {
        function getLeavingDateColumn($rideType) {
            switch ($rideType) {
              case 'One Way':
              case 'Return':
                return 'STR_TO_DATE(`leaving_date`, \'%d %M %Y\') > ?';
              case 'Recurring':
                return 'STR_TO_DATE(`ride_date`, \'%d %M %Y\') > ?';
              default:
                return 'leaving_date';
            }
          }
        try{
            $todayDate = Carbon::now()->format('d F Y');
            $validator = Validator::make($request->all(),[
                'ride_type' => 'required',
                'departure_city' => 'required',
                'arrival_city' => 'required',
                // 'event_name' => 'required',
                // 'event_id' =>'required'
            ]);
            if($validator->fails())
            {
                return $this->error($validator->errors()->first());
            }
            $eventId = $request->event_id != 0 ?$request->event_id:null;
            $posts = RidePost::with('event')
                ->where('ride_type', $request->ride_type)
                ->where('departure_city', $request->departure_city)
                ->where('arrival_city', $request->arrival_city)
                ->when(($request->ride_type === 'One Way' ||  $request->ride_type === 'Return'), function ($query) use ($request, $todayDate) {
                    $query->where('leaving_date','>=', $todayDate);
                    // $query->where('leaving_date','>=', $request->ride_date);
                    $query->whereBetween('leaving_date', [$todayDate, $request->ride_date]);
                })
                ->when($request->ride_type === 'Recurring', function ($query) use ($request, $todayDate) {
                    $query->where('ride_date','>=', $todayDate);
                    $query->whereBetween('ride_date', [$todayDate, $request->ride_date]);

                })
                ->where('status', 'active')
                ->orderBy('id', 'desc');

            if (isset($eventId)) {
                $posts->where('event_id', $eventId);
            }
            $posts = $posts->get();
            
            if(!empty($posts))
            {
                foreach($posts as $post)
                {
                    $post->driver_details = $this->user_model($post->user_id);
                    $post->pickup_points = PickupPoint::where('post_id', $post->id)->get();
                }
            }
            // get other post on same date and type without title search 
            $otherPosts = RidePost::with('event')->where('ride_type', $request->ride_type)
                                ->where('departure_city', $request->departure_city)
                                ->where('arrival_city', $request->arrival_city)
                                ->when(($request->ride_type === 'One Way'), function ($query) use ($request, $todayDate) {
                                    $query->where('leaving_date', '>=', $todayDate);
                                    $query->where('leaving_date', '<>', "$request->ride_date");
                                    $query->orwhere('leaving_date', '>', "$request->ride_date");
                                    $query->where('ride_type', $request->ride_type);
                                })
                                ->when(($request->ride_type === 'Return'), function ($query) use ($request, $todayDate) {
                                    $query->where('leaving_date', '>=', $todayDate);
                                    $query->where('leaving_date', '<>', "$request->ride_date");
                                    $query->orwhere('leaving_date', '>', "$request->ride_date");
                                    $query->where('ride_type', $request->ride_type);
                                })
                                ->when($request->ride_type === 'Recurring', function ($query) use ($request, $todayDate) {
                                    // $query->where('ride_date', '>=', $request->ride_date);
                                    $query->where('ride_date', '>=', $todayDate);
                                    $query->where('ride_date', '<>', "$request->ride_date");
                                    $query->orwhere('ride_date', '>', "$request->ride_date");
                                    $query->where('ride_type', $request->ride_type);
                                })
                                ->where('status', 'active')
                                ->orderBy('id', 'desc');

                                // $sql = $otherPosts->toSql();
                                // $bindings = $otherPosts->getBindings();

                                // Combine the SQL query and parameter bindings
                                // $completeSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

                                // Create an array with the SQL query and parameters
                                $otherPosts =  $otherPosts->get();

            // if (!isset($eventId)) {
            //     $posts->where('event_id', '<>', $eventId);
            // }

            if(!empty($otherPosts))
            {
                foreach($otherPosts as $otherpost)
                {
                    $otherpost->other_driver_details = $this->user_model($otherpost->user_id);
                    $otherpost->other_pickup_points = PickupPoint::where('post_id', $otherpost->id)->get();
                }
            }
            return $this->success([$posts->count() > 0 ? 'Ride Found' : 'No Ride Found', ["post"=>$posts, "otherPosts"=>$otherPosts]]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // get single post detail  
    public function post_details($post_id)
    {
        try{
            $post = RidePost::where('id', $post_id)->first();
            $bookingUser = array();
            if(empty($post))
            {
                return $this->error('Post not found');
            }
            $post->pickup_points = PickupPoint::where('post_id', $post->id)->get();
            $post->user_details = $this->user_model($post->user_id);
            $post->vehicle_details = UserVehicle::where('id', $post->vehicle_id)->first();
            $acceptBookings = Booking::select('*')->selectRaw('bookings.created_at as booking_date')->where('ride_post_id', $post->id)->whereIn('status', ['accepted','waiting for payment', 'confirmed'])->orderBy('id', 'desc')->get();
            if(!empty($acceptBookings))
            {
                foreach($acceptBookings as $booking)
                {
                    $booking->user_details = $this->user_model($booking->user_id);
                    $bookingUser[] = $this->user_model($booking->user_id);
                    $booking->pickup_point = PickupPoint::where('id', $booking->pickup_point_id)->first();
                    // $post->bookingUser = $this->user_model($booking->user_id);
                }
            }
            $penddingBookings = Booking::select('*')->selectRaw('bookings.created_at as booking_date')->where('status', 'pending')->where('ride_post_id', $post->id)->orderBy('id', 'desc')->get();
            if(!empty($penddingBookings))
            {
                foreach($penddingBookings as $booking)
                {
                    $booking->user_details = $this->user_model($booking->user_id);
                    $booking->pickup_point = PickupPoint::where('id', $booking->pickup_point_id)->first();
                }
            }
            $post->bookingUser = $bookingUser;
            $post->bookings = ["accepted"=>$acceptBookings, "pending"=>$penddingBookings];
            return $this->success(['Post Details Found', $post]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // get user vehicles 
    public function user_vehicles(Request $request)
    {
        // try{
            $validator = Validator::make($request->all(),[
                'action' => 'required|string|in:create,edit,view,delete',
                'brand_name' => 'sometimes|nullable',
                'model_name' => 'sometimes|nullable',
                'number_plate' => 'sometimes|nullable',
                'color' => 'sometimes|nullable',
                'vehicle_id' => 'required_if:action,==,edit,delete', 
            ]);
            
            if($validator->fails()){
                return $this->error($validator->errors()->first());
            }
            
            if($request->action == 'create')
            {
                $vehicle = new UserVehicle;
                $vehicle->user_id = Auth::user()->id;
                $vehicle->brand_name = $request->brand_name;
                $vehicle->number_plate = $request->number_plate;
                $vehicle->model_name = $request->model_name;
                $vehicle->color = $request->color;
                $vehicle->save();
                
                return $this->success(['Vehicle Saved']);
            }elseif($request->action == "view")
            {
                $vehicles = UserVehicle::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
                return $this->success([$vehicles->count() > 0 ? 'Vehicles Found':'No Vehicle Found', $vehicles]);
            }elseif($request->action == 'edit')
            {
                $vehicle = UserVehicle::where('id', $request->vehicle_id)->first();
                if(empty($vehicle))
                {
                    return $this->error('Vehicle not Found');
                }
                if($request->has('brand_name') && !empty($request->brand_name))
                {
                    $vehicle->brand_name = $request->brand_name;
                }
                if($request->has('number_plate') && !empty($request->number_plate))
                {
                    $vehicle->number_plate = $request->number_plate;
                }
                if($request->has('model_name') && !empty($request->model_name))
                {
                    $vehicle->model_name = $request->model_name;
                }
                if($request->has('color') && !empty($request->color))
                {
                    $vehicle->color = $request->color;
                }             
                
                $vehicle->save();
                return $this->success(['Vehicle Edited']);
            }elseif($request->action == "delete"){
                $vehicle = UserVehicle::where('id', $request->vehicle_id)->first();
                if(empty($vehicle))
                {
                    return $this->error('Vehicle not Found');
                }
                $vehicle->delete();
                return $this->success(['Vehicle Deleted']);
            }else{
                return $this->error('Invalid Action');
            }
        // }catch(\Exception $e)
        // {
        //     return $this->error($e->getMessage());
        // }
    }

    // get and post booking information
    public function booking(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'action' => 'required|string|in:create,view,edit,delete',
                'post_id' => 'required_if:action,==,edit,create|string',
                'pickup_point_id' => 'required_if:action,==,edit,create|string',
                'number_of_seats' => 'required_if:action,==,edit,create|integer',
                'per_seat_price' => 'required_if:action,==,edit,create|integer',
                'total_seats_price' => 'required_if:action,==,edit,create|integer',
                'price_currency' => 'required_if:action,==,edit,create|string',
                'booking_id' => 'required_if:action,==,edit,delete',
            ]);

            if($validator->fails())
            {
                return $this->error($validator->errors()->first());
            }
            if($request->action == 'create'){
                $ridePost = RidePost::where('id', $request->post_id)->first();
                if($ridePost->user_id === Auth::user()->id){
                    return $this->error('Can not Book your own Ride');
                }else{
                    $booking = new Booking;
                    $booking->ride_post_id = $request->post_id;
                    $booking->user_id = Auth::user()->id;
                    $booking->pickup_point_id =  $request->pickup_point_id;
                    $booking->number_of_seats = $request->number_of_seats;
                    $booking->per_seat_price = $request->per_seat_price;
                    $booking->total_seats_price = $request->total_seats_price;
                    $booking->price_currency = $request->price_currency;
                    $booking->status = "pending";
                    $booking->save();
                    
                    return $this->success(['Booking Created', $booking]);
                }
            }elseif($request->action == "view"){
                $currentBookings = Booking::select(['id','ride_post_id', 'pickup_point_id', 'user_id', 'number_of_seats', 'per_seat_price', 'total_seats_price', 'price_currency', 'status', 'paid', 'created_at as booking_date'])
                                            ->where('user_id', Auth::user()->id)
                                            ->whereIn('status', ['pending', 'accepted','waiting for payment', 'confirmed'])
                                            ->orderBy('id', 'desc')->get();
                if(!empty($currentBookings))
                {
                    foreach($currentBookings as $booking)
                    {
                        $booking->booking_date = Carbon::parse($booking->booking_date)->format('d F Y');
                        $booking->booking_time = Carbon::parse($booking->booking_date)->format('h:i A');
                        $booking->user_details = $this->user_model($booking->user_id);
                        $booking->ride_details = $this->ride_model($booking->ride_post_id);
                    }
                }
                $pastBookings = Booking::select(['id','ride_post_id', 'pickup_point_id', 'user_id', 'number_of_seats', 'per_seat_price', 'total_seats_price', 'price_currency', 'status', 'paid', 'created_at as booking_date'])
                                        ->where('user_id', Auth::user()->id)
                                        ->whereIn('status', ['completed', 'rejected','cancelled'])
                                        ->orderBy('id', 'desc')->get();
                if(!empty($pastBookings))
                {
                    foreach($pastBookings as $booking)
                    {
                        $booking->booking_date = Carbon::parse($booking->booking_date)->format('d F Y');
                        $booking->booking_time = Carbon::parse($booking->booking_date)->format('h:i A');
                        $booking->user_details = $this->user_model($booking->user_id);
                        $booking->ride_details = $this->ride_model($booking->ride_post_id);
                    }
                }
                return $this->success([$currentBookings->count() > 0 ? 'Current Booking Found' : 'No Booking Found', ['current_bookings' => $currentBookings, 'past_bookings' => $pastBookings  ]]);
            }elseif($request->action == "edit"){
                $booking = Booking::where('id', $request->booking_id)->where('user_id', Auth::user()->id)->first();
                if(empty($booking))
                {
                    return $this->error('Booking not found');
                }
                if($request->has('post_id')){
                    $booking->ride_post_id = $request->post_id;
                }
                if($request->has('pickup_point_id')){
                    $booking->pickup_point_id = $request->pickup_point_id;
                }
                if($request->has('number_of_seats')){
                    $booking->number_of_seats = $request->number_of_seats;
                }
                if($request->has('per_seat_price')){
                    $booking->per_seat_price = $request->per_seat_price;
                }
                if($request->has('total_seats_price')){
                    $booking->total_seats_price = $request->total_seats_price;
                }
                if($request->has('price_current')){
                    $booking->price_current = $request->price_current;
                }
                $booking->save();   
                return $this->success(['Booking Updated Success']);
            }elseif($request->action == "delete"){
                $booking = Booking::where('id', $request->booking_id)->where('user_id', Auth::user()->id);
                if(empty($booking))
                {
                    return $this->error('Booking not found');
                }
                $booking->delete();
                return $this->success(['Booking Deleted']);
            }else{
                return $this->error('Invalid Action');
            }

        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // change booking status 
    public function change_booking_status(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'booking_id' => 'required|exists:bookings,id',
                'status' => 'required|in:accepted,payment,confirmed,arrived,completed,rejected,cancelled',
                'card_number' => 'required_if:status,==,payment',
                'exp_month' => 'required_if:status,==,payment',
                'exp_year' => 'required_if:status,==,payment',
                'cvv' => 'required_if:status,==,payment',
                'pickup_point_id' => 'required_if:status,==,arrived',
                'ride_post_id' => 'required_if:status,==,completed',
            ]);
            if($validator->fails()){
                return $this->error($validator->errors()->first());
            }
            $booking = Booking::where('id', $request->booking_id)->first();
            if(empty($booking)){
                return $this->error('Booking not found');
            }
            
            if($request->status == "accepted")
            {
                $booking->status = "waiting for payment";
                $booking->save();
                $this->create_notification(Auth::user()->id, $booking->user_id, $booking->id, Auth::user()->first_name.' '.Auth::user()->last_name.' has Accepted your booking request', "booking_request_accepted");
                return $this->success(['Booking Accepted']);
            }elseif($request->status == "payment")
            {
                if($booking->status == "confirmed"){
                    return $this->error('Payment already Confirmed ...!');
                }else{
                    // $stripe = new \Stripe\StripeClient('pk_live_51M9H74HK908kn1bBzzQUD3Ins9I3ygJh4ALKiQHvl5c70tdDxYuI6rKjYpz248EEiSPZMoHpmFndD0YHLlTrd8LP00yrLPTBfE');
                    $stripe = new \Stripe\StripeClient('pk_test_crwKgwLBaPlD6PyegWa6ln6E00AowPrKUI');
                    $token = $stripe->tokens->create(['card' => ['number' => $request->card_number, 'exp_month' => $request->exp_month, 'exp_year' => $request->exp_year, 'cvc' => $request->cvv,]]);
    
                    // Stripe\Stripe::setApiKey('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'); //defined in contants.php helper file
                    Stripe\Stripe::setApiKey('sk_test_BHlJPzC6PloLo7ELEKksI1uy00LlQbLa2X'); //defined in contants.php helper file
                    $pay = Stripe\Charge::create([
                        "amount" => 100 * (float)$booking->total_seats_price,
                        "currency" => 'USD',
                        "source" => $token->id,
                        "description" => "CINCHPayment",
                    ]);
    
                    if ($pay->status == 'succeeded') {
                        $booking->status = "confirmed";
                        $booking->transaction_id = $pay->id;
                        $booking->receipt_url = $pay->receipt_url;
                        $booking->save(); 
    
                        $driver = User::where('id', $booking->ride_post->user_id)->first(['id', 'wallet_balance']);
                        $driver->wallet_balance = (float)$driver->wallet_balance + (float)$booking->total_seats_price;
                        $driver->save();
    
                        $this->create_notification(Auth::user()->id, $booking->ride_post->user_id, $booking->id, Auth::user()->first_name.' '.Auth::user()->last_name.' has Paid Booking amount', "booking_amount_paid");  
                        return $this->success(['Your Booking is Confirmed Now']);
                    }else{
                        return $this->error('There was some issue while payment');
                    }
                }
            }elseif($request->status == "arrived")
            {
                //when driver arrived at pickup points, then notify all users who are booked for that pickup point
                
                
                $users = Booking::where('pickup_point_id', $request->pickup_point_id)->where('status', 'confirmed')->get(['id', 'user_id']);
                if(!empty($users))
                {
                    foreach($users as $user)
                    {
                        $this->create_notification(Auth::user()->id, $user->user_id, $user->id, Auth::user()->first_name.' '.Auth::user()->last_name.' has Arrived', "driver_arrived");
                    }
                }
                
                $bookings = Booking::where('pickup_point_id', $request->pickup_point_id)->get(['id', 'status']);
                if(!empty($bookings))
                {
                    foreach($bookings as $booking)
                    {
                        $booking->status = "arrived";
                        $booking->save();
                    }
                }
                return $this->success(['Arrived to Pickup Point']);

            }elseif($request->status == "completed"){
                $ride_post1 = RidePost::where('id', $request->ride_post_id)->first();
                if(empty($ride_post1))
                {
                    return $this->error('Ride Post not found');
                }
                $ride_post1->status = "completed";
                $ride_post1->save();
                $bookings = Booking::where('ride_post_id', $request->ride_post_id)->where('status', 'arrived')->get();
                if(!empty($bookings))
                {
                    foreach($bookings as $booking)
                    {
                        $booking->status = "completed";
                        $booking->save();
                        $this->create_notification(Auth::user()->id, $booking->user_id, $booking->id, 'Booking Completed', "booking_completed");
                    }
                    return $this->success(['Booking Completed']);
                }else{
                    return $this->error('No booking found');                
                }
            }elseif($request->status == "rejected")
            {
                $booking->status = "rejected";
                $booking->save();
                $this->create_notification(Auth::user()->id, $booking->user_id, $booking->id, Auth::user()->first_name.' '.Auth::user()->last_name.' has Rejected your booking request', "booking_request_rejected");
                return $this->success(['Booking Rejected', [$booking]]);
            }elseif($request->status == "cancelled")
            {
                if($booking->status == "waiting for payment"){
                    $booking->status = "cancelled";
                    $booking->save();
                    $this->create_notification(Auth::user()->id, $booking->user_id, $booking->id, Auth::user()->first_name.' '.Auth::user()->last_name.' has Rejected your booking request', "booking_request_rejected");
                    return $this->success(['Booking Cancelled', [$booking]]);
                }else{
                    return $this->success(['Booking already Confirmed', [$booking]]);
                }
            }else{
                return $this->error('Invalid Action');
            }                        
        }catch(\Exception $e)
        {
            return $this->error($request->status);
        }
    }

    // get user notification List 
    public function notification_list()
    {
        try{
            $user_id = Auth::user()->id;
            $user = $this->ifExists(User::class, $user_id);
            $notifications = Notification::where('to_id', $user_id)->orderBy('id', 'desc')->get();
            if(!empty($notifications))
            {
                foreach($notifications as $notification)
                {
                    $user_details = User::where('id', $notification->from_id)->first();
                    $notification->first_name = $user_details->first_name;
                    $notification->last_name = $user_details->last_name;
                    $notification->image = $user_details->profile_image;
                }
            }
            return $this->success([$notifications->count() > 0 ? 'Notifications Found': 'No Notification Found', $notifications]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }    

    // get booking detail 
    public function booking_details($booking_id)
    {
        try{
            $booking = Booking::with('ride_post')->where('id', $booking_id)->first();
            if(empty($booking))
            {
                return $this->error('Booking not found');
            }
            $booking->user_details = $this->user_model($booking->user_id);
            $booking->ride_post->driver_details = $this->user_model($booking->ride_post->user_id);
            $booking->ride_post->vehicle_details = $this->vehicle_model($booking->ride_post->vehicle_id);
            $booking->pickup_points = PickupPoint::where('id', $booking->pickup_point_id)->first();
            return $this->success(['Booking details found', $booking]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // User Wallet Details
    public function walletDetails(Request $request){
        try {
            $user = User::select(['id','wallet_balance'])->with('drawRequests')->where('id', Auth::user()->id)->first();
            
            return $this->success(['Wallet detail', $user]);
        } catch (\Throwable $th) {
            return $this->error($e->getMessage());
        }
    }

    // withdraw request user 
    public function withdraw_request(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'withdraw_amount' => 'required',
            ]);
            if($validator->fails())
            {
                return $this->error($validator->errors()->first());
            }
            $user = User::select(['id', 'connect_account_id','wallet_balance'])->where('id', Auth::user()->id)->first();
            if($user->wallet_balance < $request->withdraw_amount)
            {
                return $this->error('Insufficient Balance');
            }
            if(empty($user->connect_account_id) || $user->connect_account_id == "")
            {
                return $this->error('You need to complete your driver profile before withdraw request');
            }
            $withdraw = new WithdrawRequest;
            $withdraw->user_id = $user->id;
            $withdraw->withdraw_amount = $request->withdraw_amount;
            $withdraw->status = "pending";
            $withdraw->save();
            // $this->create_notification(Auth::user()->id, $booking->user_id, $booking->id, Auth::user()->first_name.' '.Auth::user()->last_name.' has Accepted your booking request', "booking_request_accepted");
            // $this->create_notification(Auth::user()->id, Auth::user()->first_name.' '.Auth::user()->last_name.' has request for With Draw', "withdrw_request");
            return $this->success(['Withdraw Request Submitted']);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // get Options list 
    public function option_list()
    {
        try{
            $options = Options::orderBy('id', 'desc')->get();
            return $this->success([sizeof($options) > 0 ? 'Options Found' : 'No Option Found', $options]);
        }catch(\Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    // review and rating to driver specific Drivers
    public function reviewAndRating(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'booking_id' => 'required',
                'rating' => 'required',
            ]);
            if($validator->fails())
            {
                return $this->error($validator->errors()->first());
            }
            $booking = Booking::with('ride_post')->where('id', $request->booking_id)->first();
            if(empty($booking))
            {
                return $this->error('Booking not found');
            }
            $user = Auth::user();
            $driver_id = $booking->ride_post->user_id;
            if(empty($user->id)){
                return $this->error('Login First and Review on Booking...!');
            }
            $findReview = ReviewRating::where('user_id', $user->id)->where('booking_id', $booking->id)->first();
            if($findReview){
                return $this->error('Already post Review on this Booking...!');
            }
            $idsString = json_encode($request->options);
            $review = new ReviewRating;
            $review->user_id = $user->id;
            $review->driver_id = $driver_id;
            $review->booking_id = $request->booking_id;
            $review->star_rating = $request->rating;
            $review->comments = $request->comments;
            // $review->options = implode(',',$request->options);
            $review->options = $idsString;
            $review->save();
            return $this->success(['Review Submitted...!']);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage());
        }
    }
}
