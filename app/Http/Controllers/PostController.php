<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::all();
            // dd($posts);
            return response()->json([
                'message' => 'Posts retrieved successfully',
                // response format (customize) use resource
                'posts' => PostResource::collection($posts)  // use for all data response format
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::find($id);
            return response()->json([
                'message' => 'Post retrieved successfully',
                'post' => PostResource::make($post)  // use for single data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // use Request for validation in separate file (PostStoreRequest.php)
        // use custom request validation

        // $validator = validator($request->all(), [
        //     'title' => 'required|string|max:255',
        //     'content' => 'required|string',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Validation failed',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        try {
            $post = Post::create(([
                'title' => $request->title,
                'content' => $request->content
            ]));
            return response()->json([
                'message' => 'Post created successfully',
                'post' => PostResource::make($post)  // use for single data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'Title is required',  // custom error message
            'content.required' => 'Content is required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);
        return response()->json([
            'message' => 'Post updated successfully',
            // 'post' => $post
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully',
            // 'post' => $post
        ], 200);
    }
}
