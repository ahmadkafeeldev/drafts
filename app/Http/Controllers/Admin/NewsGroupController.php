<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsGroup;
use Illuminate\Http\Request;
use DB;

class NewsGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = NewsGroup::orderBy('id', 'desc')->get();

        return view('admin.news_group.index', compact('groups'));
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
    // public function store(StoreFoodCourseRequest $request)
    // {
        //
    // }
    public function store(Request $request)
    {
        
        
        $group = new NewsGroup;
        $group->name  = $request->name;
        
        $group->save();       
        return back()->with('message','News Group Add successfully');      
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

    
     public function update(Request $request, string $id)
    {
        $group = NewsGroup::findOrFail($id);
        $group->name = $request->name;
        $group->save();  
    
        return back()->with('message', 'News Group updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         try{
            $group = NewsGroup::find($id);

            if(empty($group))
            {
                return back()->with('error', 'News Group does not Exists!');
            }            

            $group->delete();

            return back()->with('message', 'News Group Deleted');

        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action!');
        }
    }
}