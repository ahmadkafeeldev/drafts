<?php

namespace App\Http\Controllers\Drafts;

use App\Http\Controllers\Controller;
use App\Models\DraftsModel;
use App\Models\Bookings;
use App\Models\NewsPaper;
use App\Models\Area;
use App\Models\Borough;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DraftsController extends Controller
{
    
    public function index()
    {
            // Retrieve all records from the DraftsModel
            $drafts = DraftsModel::all();
    
    
            // Pass drafts to the view
            return view('users.public_notice')->with('drafts', $drafts);
        }
    
   
    public function create()
    {
        // Retrieve all records from the DraftsModel
        $drafts = DraftsModel::all();


        // Pass drafts to the view
        return view('users.public_notice')->with('drafts', $drafts);
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
    

    public function map()
    {
        return view('users.google_map');
    }

    public function troGisMap()
    {
        return view('users.tro_gis_map');
    }
    
    public function profile()
    {
        return view('users.profile');
    }
    
    public function destroy($id)
    {
         try{
            $drafts = DraftsModel::find($id);

            if(empty($drafts))
            {
                return back()->with('error', 'Drafts does not Exists!');
            }            

            $drafts->delete();

            return back()->with('message', 'Drafts  Deleted');

        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action!');
        }
    }
    
    public function drafts_list()
    {
        // Retrieve all records from the DraftsModel
        $drafts = DraftsModel::all();


        // Pass drafts to the view
        return view('users.index')->with('drafts', $drafts);
    }
    
    public function store(Request $request)
    {
        $draft = new DraftsModel;
        $draft->booking_type  = $request->booking_type;
        $draft->order_type  = $request->order_type;
        $draft->notice_type  = $request->notice_type;
        
        $draft->save();       
        return back()->with('message','Draft Added successfully');      
    }
    
    public function update(Request $request, string $id)
    {
        $draft = DraftsModel::findOrFail($id);
        $draft->booking_type  = $request->booking_type;
        $draft->order_type  = $request->order_type;
        $draft->notice_type  = $request->notice_type;
        $draft->save();       
        
        
        return back()->with('message','Draft updated successfully');
    }


}
