<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsPaper;
use App\Models\NewsGroup;
use App\Models\Borough;
use App\Models\Area;


class NewsPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news_papers = NewsPaper::orderBy('id', 'desc')->get();
        foreach ($news_papers as $news_paper) {
            $news_group = NewsGroup::where('id', $news_paper->news_group)->first();
            $news_paper->news_group = $news_group ? $news_group->name : 'Unknown Group';
    
            $borough = Borough::where('id', $news_paper->borough)->first();
            $news_paper->borough = $borough ? $borough->name : 'Unknown Borough';
            
            $area1 = Area::where('id', $news_paper->area)->first();
            $news_paper->area = $area1 ? $area1->name : 'Unknown Area';
        }
    
        $groups = NewsGroup::orderBy('id', 'desc')->get();
        $boroughs = Borough::orderBy('id', 'desc')->get();
        $area = Area::orderBy('id', 'desc')->get();
    
        return view('admin.news_paper.index', compact('news_papers', 'groups', 'boroughs', 'area'));
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
        $news_paper = new NewsPaper;
        $news_paper->name  = $request->name;
        $news_paper->email = $request->email;
        $news_paper->borough = $request->borough;
        $news_paper->area = $request->area;
        $news_paper->booking_deadline  = $request->booking_deadline;
        $news_paper->publish_date = $request->publish_date;
        $news_paper->news_group = $request->news_group;
        $news_paper->rate  = $request->rate;
        $news_paper->save();  
        
        return back()->with('message','News Paper Add successfully'); 
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news_paper = NewsPaper::findOrFail($id);
        $groups = NewsGroup::orderBy('id', 'desc')->get();
        $boroughs = Borough::orderBy('id', 'desc')->get();
        $area = Area::orderBy('id', 'desc')->get();
        
        return view('admin.news_paper.index', compact('news_paper', 'groups', 'boroughs', 'area'));
    }


    
    public function update(Request $request, string $id)
    {
        $news_paper = NewsPaper::findOrFail($id);
        $news_paper->name = $request->name;
        $news_paper->email = $request->email;
        $news_paper->borough = $request->borough;
        $news_paper->area = $request->area;
        $news_paper->booking_deadline = $request->booking_deadline;
        $news_paper->publish_date = $request->publish_date;
        $news_paper->news_group = $request->news_group;
        $news_paper->rate = $request->rate;
        $news_paper->save();  
    
        return back()->with('message', 'News Paper updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         try{
            $news_paper = NewsPaper::find($id);

            if(empty($news_paper))
            {
                return back()->with('error', 'News Paper does not Exists!');
            }            

            $news_paper->delete();

            return back()->with('message', 'News Paper  Deleted');

        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action!');
        }
    }
}
