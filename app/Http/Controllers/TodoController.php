<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $todos = Todo::all();
            // dd($todos);
            return response()->json([
                'message' => 'Todos retrieved successfully',
                'todos' => TodoResource::collection($todos)  // need to call resource collection Todo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Todos retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'status' => 'required|in:pending,in_progress,completed',
        // ]);

        $validator = validator(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'status' => 'required|in:pending,in_progress,completed',
            ], [
                'title.required' => 'Title is required',
                'description.max' => 'Description must not be greater than 255 characters',
                'status.in' => 'Status must be pending, in_progress, or completed',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $todo = Todo::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status ?? 'pending',
            ]);

            return response()->json([
                'message' => 'Todo created successfully',
                'todo' => $todo
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Todo creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        return response()->json([
            'message' => 'Todo retrieved successfully',
            'todo' => TodoResource::make($todo)  // use for single data
        ], 200);
        return response()->json([
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }

    /** Show the form for editing the specified resource. */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // $validated = $request->validate([
            //     'title' => 'required|string|max:255',
            //     'description' => 'nullable|string',
            //     'status' => 'required|in:pending,in_progress,completed',
            // ]);
            $validator = validator($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'status' => 'required|in:pending,in_progress,completed',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            $todo = Todo::find($id);
            if (!$todo) {
                return response()->json([
                    'message' => 'Todo not found',
                    ''
                ], 404);
            }

            $todo->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status ?? 'pending',
            ]);

            return response()->json([
                'message' => 'Todo updated successfully',
                'todo' => $todo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Todo update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json([
                'message' => 'Todo not found',
                // 'id' => $id
            ], 404);
        }
        $todo->delete();
        return response()->json([
            'message' => 'Todo deleted successfully',
            // 'todo' => $todo
        ], 200);
    }
}
