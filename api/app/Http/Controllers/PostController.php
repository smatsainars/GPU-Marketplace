<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index','show'])
        ];
    }
    
    public function index()
    {
        return Post::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
        
        $post = $request->user()->posts()->create($fields);

        return ['post' => $post, 'user' => $post->user];
    }

    public function show(Post $post)
    {
        return ['post' => $post, 'user' => $post->user];
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);

        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
        
        $post->update($fields);

        return ['post' => $post, 'user' => $post->user];
    }

    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);

        $post->delete();

        return ['message' => "Your post has been deleted!"];
    }
}
