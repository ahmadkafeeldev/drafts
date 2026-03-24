<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use App\Models\NewsPaper;
use App\Models\Bookings;
use App\Models\Borough;

class AdminNavigationController extends Controller
{
    public function dashboard(Request $request)
    {
        $users = User::where('type', '1')->count();
        $area = Area::count();
        $news_paper = NewsPaper::count();
        $borough = Borough::count();

        // Count all the Pending, Processing, Completed, Cancelled
        $bookingsCount = [
            "pending" => Bookings::where('status', 'pending')->count(),
            "processing" => Bookings::where('status', 'processing')->count(),
            "completed" => Bookings::where('status', 'completed')->count(),
            "cancelled" => Bookings::where('status', 'cancelled')->count()
        ];

        $bookings = Bookings::orderBy('created_at', 'desc')->get();
        foreach($bookings as $booking)
        {
            $user1 = User::where('id', $booking->user_id)->first();
            $booking->user_details = isset($user1) ? $user1 : '';

            $news_paper1 = NewsPaper::where('id', $booking->news_paper_id)->first();
            $booking->news_paper = isset($news_paper1->name) ? $news_paper1->name : '';

            $area1 = Area::where('id', $booking->area)->first();
            $booking->area = isset($area1->name) ? $area1->name : ''; 

            $borough1 = Borough::where('id', $booking->borough)->first();
            $booking->borough = isset($borough1->name) ? $borough1->name : '';     
        }
        

        return view('admin.dashboard', compact('borough','users','area','news_paper', 'bookingsCount','bookings'));
    }  
}
