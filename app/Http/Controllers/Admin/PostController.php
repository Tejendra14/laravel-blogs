<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Mail\PostApproved;
use App\Mail\PostRejected;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])->latest()->paginate(10);
        return view('admin.post.index', compact('posts'));
    }

    public function pending()
    {
        $posts = Post::with(['user', 'category'])
                    ->where('status', 'pending')
                    ->latest()
                    ->paginate(10);
        return view('admin.post.pending', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'excerpt'       => 'nullable|string',
            'category_id'   => 'required|exists:categories,id',
            'status'        => 'required|in:draft,pending,published',
            'published_at'  => 'nullable|date',
            'featured_image'=> 'nullable|image|max:2048',
            'tags'          => 'nullable|array',
            'tags.*'        => 'exists:tags,id',
        ]);

        $data = $request->only(['title', 'content', 'excerpt', 'category_id', 'status', 'published_at']);
        $data['user_id'] = auth()->id();
        $data['slug'] = $this->createUniqueSlug($request->input('title'));

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post = Post::create($data);

        if ($request->filled('tags')) {
            $post->tags()->attach($request->tags);
        }

        if ($post->status === 'published' && is_null($post->published_at)) {
            $post->update(['published_at' => now()]);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.create', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'excerpt'       => 'nullable|string',
            'category_id'   => 'required|exists:categories,id',
            'status'        => 'required|in:draft,pending,published',
            'published_at'  => 'nullable|date',
            'featured_image'=> 'nullable|image|max:2048',
            'tags'          => 'nullable|array',
            'tags.*'        => 'exists:tags,id',
            'remove_image'  => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'content', 'excerpt', 'category_id', 'status', 'published_at']);

        if ($post->title !== $request->input('title')) {
            $data['slug'] = $this->createUniqueSlug($request->input('title'), $post->id);
        }

        if ($request->filled('remove_image') && $post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
            $data['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $originalStatus = $post->status;
        $post->update($data);

        $post->tags()->sync($request->tags ?? []);

        if ($post->status === 'published' && $originalStatus !== 'published') {
            $post->update(['published_at' => now()]);
            Mail::to($post->user->email)->send(new PostApproved($post));
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

   public function approve(Post $post)
{
    \Log::info("Attempting to send approval email to: " . $post->user->email);
    
    $post->update([
        'status' => 'published',
        'published_at' => now()
    ]);

    try {
        Mail::to($post->user->email)->send(new PostApproved($post));
        \Log::info("Email sent successfully");
    } catch (\Exception $e) {
        \Log::error("Email failed: " . $e->getMessage());
    }

    return redirect()->back()->with('success', 'Post approved and published successfully.');
}
    public function reject(Post $post)
    {
        logger()->info('Attempting to send rejection email to: ' . $post->user->email);
        
        $post->update(['status' => 'draft']);

        try {
            Mail::to($post->user->email)->send(new PostRejected($post));
            logger()->info('Rejection email sent successfully');
        } catch (\Exception $e) {
            logger()->error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Post rejected and moved back to drafts.');
    }

    public function submitForReview(Post $post)
    {
        $post->update(['status' => 'pending']);

        return redirect()->back()->with('success', 'Post submitted for review successfully.');
    }

    protected function createUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }
}