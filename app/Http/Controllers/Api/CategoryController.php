<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([]);
    }

    public function show(Request $request, $id)
    {
        return response()->json(['id' => $id]);
    }

    public function viewTip(Request $request, $id)
    {
        return response()->json(['id' => $id]);
    }
}

