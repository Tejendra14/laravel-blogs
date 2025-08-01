<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuperAdminPostController extends Controller
{
    public function index()
{
    Log::channel('admin')->info('SuperAdmin accessed post list', [
        'admin' => auth()->user()->email,
        'ip' => request()->ip(),
        'time' => now()->toDateTimeString()
    ]);

    $posts = Post::with(['user', 'category'])  // Changed 'author' to 'user'
                ->latest()
                ->paginate(10);
                
    return view('superadmin.post.index', compact('posts'));
}

    public function show(Post $post)
    {
        Log::channel('admin')->debug('SuperAdmin viewing post', [
            'admin' => auth()->user()->email,
            'post_id' => $post->id
        ]);

        return view('superadmin.post.show', compact('post'));
    }

    public function approve(Post $post)
    {
        try {
            $post->update(['status' => 'published']);
            
            Log::channel('admin')->info('Post approved', [
                'admin' => auth()->user()->email,
                'post_id' => $post->id,
                'title' => $post->title,
                'ip' => request()->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return back()->with('success', "Post '{$post->title}' approved successfully.");

        } catch (\Exception $e) {
            Log::channel('admin')->error('Post approval failed', [
                'admin' => auth()->user()->email,
                'post_id' => $post->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Post approval failed. Please try again.');
        }
    }

    public function reject(Post $post)
    {
        try {
            $post->update(['status' => 'rejected']);
            
            Log::channel('admin')->info('Post rejected', [
                'admin' => auth()->user()->email,
                'post_id' => $post->id,
                'title' => $post->title,
                'ip' => request()->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return back()->with('success', "Post '{$post->title}' rejected.");

        } catch (\Exception $e) {
            Log::channel('admin')->error('Post rejection failed', [
                'admin' => auth()->user()->email,
                'post_id' => $post->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Post rejection failed. Please try again.');
        }
    }
}