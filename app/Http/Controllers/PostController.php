<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // return response()->json([
        //     'message' => 'Api is working'
        // ]);
    }

    public function show($id)
    {
        // return response()->json([
        //     'message' => 'Api is working',
        //     'id' => $id
        // ]);
    }

    public function store(Request $request)
    {
        // return response()->json([
        //     'message' => 'Api is working',
        //     'data' => $request->all()
        // ]);
    }

    public function update(Request $request, $id)
    {
        // return response()->json([
        //     'message' => 'Api is working',
        //     'id' => $id,
        //     'data' => $request->all()
        // ]);
    }

    public function destroy($id)
    {
        // return response()->json([
        //     'message' => 'Api is working',
        //     'id' => $id
        // ]);
    }
}
