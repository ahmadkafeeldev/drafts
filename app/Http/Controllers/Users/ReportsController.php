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

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id=Auth::user()->id;
        $boroughs = Borough::get();
        foreach($boroughs as $borough)
        {
            $bookings = Bookings::where('user_id', $user_id)->where('borough', $borough->id)->where('status', 'completed')->get();
            $borough->total_bookings = $bookings->count();
            $borough->total_amount = $bookings->sum('price');
        }
        return view('users.reports.index', compact('boroughs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borough_id = $id;
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('borough', $id)->where('status', 'completed')->where('user_id', $user_id)->orderBy('id', 'desc')->get();
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

        return view('users.reports.bookings', compact('bookings','borough_id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download_borough_bookings(string $id)
    {
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('borough', $id)->where('status', 'completed')->where('user_id', $user_id)->orderBy('id', 'desc')->get();
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


        $fileName = 'report.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
    
        $columns = array('ID', 'News Paper', 'Title', 'Area', 'Borough', 'Price', 'Submission Date', 'Booking Date', 'Publish Date', 'Attached Document','Traffic Order Type', 'Notice Type', 'Proof Reading Document', 'Proof Document Status','Payment Status', 'Progress Status');
    
        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $row['ID']  = $booking->id;
                $row['News Paper']    = $booking->news_paper;
                $row['Title']    = $booking->title;
                $row['Area']    = $booking->area;
                $row['Borough']    = $booking->borough;
                $row['Price']    = $booking->price;
                $row['Submission Date']    = $booking->created_at;
                $row['Booking Date']    = $booking->booking_date;
                $row['Publish Date']    = $booking->publish_date;
                $row['Attached Document'] = IMAGE_URL.$booking->document;
                $row['Traffic Order Type']  = $booking->booking_type;
                $row['Notice Type']  = $booking->notice_type;
                $row['Proof Reading Document']  = IMAGE_URL.$booking->proof_pdf;
                $row['Proof Document Status']  = $booking->pdf_status;
                $row['Payment Status']  = $booking->payment_status;
                $row['Progress Status']  = $booking->status;
                
                fputcsv($file, array($row['ID'], $row['News Paper'], $row['Title'], $row['Area'], $row['Borough'],$row['Price'],$row['Submission Date'], $row['Booking Date'], $row['Publish Date'], $row['Attached Document'], $row['Traffic Order Type'], 
                $row['Notice Type'], $row['Proof Reading Document'], $row['Proof Document Status'], $row['Payment Status'],$row['Progress Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }


    public function download_all_bookings()
    {
        $user_id=Auth::user()->id;
        $bookings = Bookings::where('status', 'completed')->where('user_id', $user_id)->orderBy('id', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user = User::where('id', $booking->user_id)->first();
            $booking->user_details = $user;

            $news_paper = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper->name) ? $news_paper->name : '';

            $area = Area::where('id', $booking->area)->first();
            $booking->area = isset($area->name) ? $area->name : ''; 

            $borough = Borough::where('id', $booking->borough)->first();
            $booking->borough = $borough->name;    
        }


        $fileName = 'report.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
    
        $columns = array('ID', 'News Paper', 'Title', 'Area', 'Borough', 'Price', 'Submission Date', 'Booking Date', 'Publish Date', 'Attached Document','Traffic Order Type', 'Notice Type', 'Proof Reading Document', 'Proof Document Status','Payment Status', 'Progress Status');
    
        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $row['ID']  = $booking->id;
                $row['News Paper']    = $booking->news_paper;
                $row['Title']    = $booking->title;
                $row['Area']    = $booking->area;
                $row['Borough']    = $booking->borough;
                $row['Price']    = $booking->price;
                $row['Submission Date']    = $booking->created_at;
                $row['Booking Date']    = $booking->booking_date;
                $row['Publish Date']    = $booking->publish_date;
                $row['Attached Document'] = IMAGE_URL.$booking->document;
                $row['Traffic Order Type']  = $booking->booking_type;
                $row['Notice Type']  = $booking->notice_type;
                $row['Proof Reading Document']  = IMAGE_URL.$booking->proof_pdf;
                $row['Proof Document Status']  = $booking->pdf_status;
                $row['Payment Status']  = $booking->payment_status;
                $row['Progress Status']  = $booking->status;
                
                fputcsv($file, array($row['ID'], $row['News Paper'], $row['Title'], $row['Area'], $row['Borough'],$row['Price'],$row['Submission Date'], $row['Booking Date'], $row['Publish Date'], $row['Attached Document'], $row['Traffic Order Type'], 
                $row['Notice Type'], $row['Proof Reading Document'], $row['Proof Document Status'], $row['Payment Status'],$row['Progress Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }

}