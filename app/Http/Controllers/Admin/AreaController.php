<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use DB;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Area::orderBy('id', 'desc')->get();

        return view('admin.area.index', compact('areas'));
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
        
        
        $area = new Area;
        $area->name  = $request->name;
        
        $area->save();       
        return back()->with('message','Area Add successfully');      
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
        $area = Area::findOrFail($id);
        $area->name = $request->name;
        $area->save();  
    
        return back()->with('message', 'Area updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         try{
            $area = Area::find($id);

            if(empty($area))
            {
                return back()->with('error', 'Area does not Exists!');
            }            

            $area->delete();

            return back()->with('message', 'Area  Deleted');

        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action!');
        }
    }
}