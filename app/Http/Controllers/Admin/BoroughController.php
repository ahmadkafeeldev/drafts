<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borough;
use Illuminate\Http\Request;
use DB;

class BoroughController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boroughs = Borough::orderBy('id', 'desc')->get();

        return view('admin.borough.index', compact('boroughs'));
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
        
        
        $borough = new Borough;
        $borough->name  = $request->name;
        
        $borough->save();       
        return back()->with('message','Borough Add successfully');      
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
     public function update(Request $request, string $id)
    {
        $borough = Borough::findOrFail($id);
        $borough->name = $request->name;
        $borough->save();  
    
        return back()->with('message', 'Borough updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         try{
            $borough = Borough::find($id);

            if(empty($borough))
            {
                return back()->with('error', 'Borough does not Exists!');
            }            

            $borough->delete();

            return back()->with('message', 'Borough Deleted');

        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action!');
        }
    }
}