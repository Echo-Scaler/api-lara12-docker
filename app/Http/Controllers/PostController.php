<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        // dd($posts);
        return response()->json([
            'message' => 'Posts retrieved successfully',
            'posts' => $posts
        ], 200);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Post retrieved successfully',
            'post' => $post
        ], 200);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $post = Post::create(([
            'title' => $request->title,
            'content' => $request->content
        ]));
        return response()->json([
            'message' => 'Post created successfully',
            // 'post' => $post
        ], 201);
    }

    public function update(Request $request, $id)
    {
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
