<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller
{
    public function index()
    {
        return response()->json([]);
    }

    public function foodCourses(Request $request, $id)
    {
        return response()->json(['id' => $id]);
    }

    public function popularCourses(Request $request, $id)
    {
        return response()->json(['id' => $id]);
    }

    public function viewCourse(Request $request, $id)
    {
        return response()->json(['id' => $id]);
    }

    public function recipes(Request $request)
    {
        return response()->json([]);
    }

    public function recipe_details(Request $request, $id)
    {
        return response()->json(['id' => $id]);
    }
}

