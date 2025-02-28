<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Posts\CreateRequest;
use App\Http\Requests\Auth\Posts\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $categories = Category::all();
    $tags = Tag::all();
    $users = User::all();

    $search = $request->input('search');
    $category = $request->input('category');
    $tag= $request->input('tag');

    $user = $request->input('user');
    $status = $request->input('status');
    $date = $request->input('date');



    // Query the posts with optional filtering
    $posts = Post::with(['gallery', 'category', 'user', 'tags', 'comments'])
    ->when($status !== null, function ($query) use ($status) {
        if ($status == 'draft') {
            $query->where('status', 0); // Drafts
        } elseif ($status == 'published') {
            $query->where('status', 1)
                  ->whereNotNull('published_at')
                  ->where('published_at', '<=', now()); // Only published posts whose time has arrived
        } elseif ($status == 'scheduled') {
            $query->where('status', 1)
                  ->whereNotNull('published_at')
                  ->where('published_at', '>', now()); // Only scheduled posts (future)
        } else {
            $query->whereIn('status', [0, 1]); // Get all statuses if no specific filter is applied
        }
    })
    ->when($search, function ($query) use ($search) {
        return $query->where('title', 'like', '%' . $search . '%');
    })
    ->when($category, function ($query) use ($category) {
        return $query->where('category_id', $category);
    })
    ->when($tag, function ($query) use ($tag) {
        return $query->whereHas('tags', function ($q) use ($tag) {
            $q->where('tags.id', $tag);
        });
    })
    ->when($user, function ($query) use ($user) {
        return $query->where('user_id', $user);
    })
    ->when($date, function ($query) use ($date) {
        return $query->whereDate('published_at', $date);
    })
    ->orderByDesc('published_at') // Show most recent first
    ->get();

    return view('auth.posts.index', compact('posts', 'categories', 'tags', 'users'));
}
public function toggleComments(Post $post)
{

    $post->disable_comments = !$post->disable_comments;
    $post->save();

    return redirect()->back()->with('success', 'Comments have been ' . ($post->disable_comments ? 'disabled' : 'enabled') . ' successfully.');
}



    /**
     * Store a newly created resource in storage.
     */




public function store(CreateRequest $request)
{
    try {
        DB::beginTransaction();

        $gallery = null;

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug',
            'excerpt' => 'required|string|max:500',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
            'publish_type' => 'nullable|in:immediate,scheduled',
            'published_at' => 'nullable|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'file' => 'required|image|max:2048'
        ]);

        // Generate a slug if not provided
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle file upload

        if ($file = $request->file('file')) {
            try {
                $gallery = $this->storeImage($file);
            } catch (\Exception $e) {
                \Log::error('Image upload failed: ' . $e->getMessage());
                return back()->withErrors(['file' => 'Image upload failed.']);
            }
        }

        $publishedAt = null;
        if ($request->status == 1) { // If Published
            if ($request->publish_type === 'scheduled' && $request->published_at) {
                $publishedAt = $request->published_at;
            } else {
                $publishedAt = now();
            }
        }

        // Create the post
        $post = Post::create([
            'gallery_id' => $gallery ? $gallery->id : null,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'description' => $request->description,
            'status' => $request->status,
            'published_at' => $publishedAt,
        ]);

        // Attach categories and tags
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        DB::commit();

        $request->session()->flash('alert-success', 'Post Created Successfully');

        return to_route('posts.index');
    } catch (\Exception $ex) {
        DB::rollBack();
        \Log::error('Post creation failed: ' . $ex->getMessage());
        return back()->withErrors(['error' => 'Post creation failed. Please try again.']);
    }
}
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Post $post)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:posts,slug,' . $post->id,
                'excerpt' => 'required|string|max:500',
                'description' => 'required|string',
                'status' => 'required|in:0,1',
                'publish_type' => 'nullable|in:immediate,scheduled',
                'published_at' => 'nullable|date',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id',
                'tags' => 'required|array',
                'tags.*' => 'exists:tags,id',
                'file' => 'nullable|image|max:2048'
            ]);

            if ($file = $request->file('file')) {
                // Ensure the post has a gallery
                if (!$post->gallery) {
                    $gallery = new Gallery();
                    $gallery->save();
                    $post->gallery()->associate($gallery);
                    $post->save();
                } else {
                    $gallery = $post->gallery;
                }

                // Delete old images
                foreach ($gallery->images as $image) {
                    $imagePath = public_path($image->path);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $image->delete();
                }

                // Upload new file
                $gallery = $this->storeImage($file);
                $post->update(['gallery_id' => $gallery->id]);
            }
                            $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
                $originalSlug = $slug;
                $count = 1;

                while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }

                \Log::info("Old Slug: " . $post->slug);
                \Log::info("New Slug: " . $slug);

                $post->forceFill(['slug' => $slug])->save();


            $publishedAt = $post->published_at; // Keep the existing value unless updated
            if ($request->status == 1) { // If Published
                if ($request->publish_type === 'scheduled' && $request->published_at) {
                    $publishedAt = $request->published_at;
                } elseif ($post->status == 0) {
                    $publishedAt = now();
                }
            } else {
                $publishedAt = null;
            }
            $post->update([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'slug' => $slug,
                'excerpt' => $request->excerpt,
                'description' => $request->description,
                'status' => $request->status,
                'published_at' => $publishedAt,
            ]);

            // Sync tags and categories
            $post->tags()->sync($request->tags);
            $post->categories()->sync($request->categories);

            DB::commit();

            $request->session()->flash('alert-success', 'Post Updated Successfully');

            return to_route('posts.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }
    }
    /**
     * Upload the file to the storage path.
     */
    private function uploadFile($file)
    {
        $fileName = rand(10000, 3000000) . time() . '.' . $file->getClientOriginalExtension();
        $filePath = public_path('/storage/auth/posts/');
        $file->move($filePath, $fileName);

        return $fileName;
    }
    /**
     * Store the uploaded file in the gallery table.
     */
    protected function storeImage($file)
{
    $imageSizes = [
        'small'  => [100, 70],
        'medium' => [700, 800],
        'large'  => [500, 400],
    ];

    $gallery = new Gallery();
    $gallery->save();

    $uploadPath = public_path("uploads/gallery/");

    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // Save Original Image
    $originalFileName = time() . "_original." . $file->getClientOriginalExtension();
    $originalFilePath = "uploads/gallery/{$originalFileName}";

    $file->move($uploadPath, $originalFileName);

    $gallery->images()->create([
        'path' => $originalFilePath,
        'size' => 'original',
    ]);

    // Resize images with both fixed width and height
    foreach ($imageSizes as $size => [$width, $height]) {
        $image = Image::make($uploadPath . $originalFileName);

        // Resize image while keeping aspect ratio and fitting into given dimensions
        $image->fit($width, $height);

        // Save the final image
        $fileName = time() . "_{$size}." . $file->getClientOriginalExtension();
        $filePath = "uploads/gallery/{$fileName}";

        $image->save($uploadPath . $fileName);

        // Store the resized image details in the database
        $gallery->images()->create([
            'path' => $filePath,
            'size' => $size,
        ]);
    }

    return $gallery;
}

    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('auth.posts.create')->with('categories', $categories)->with('tags', $tags);
    }


    public function showComments()
{
    $comments = Comment::with('post', 'user')->get(); // Load related post and user data
    return view('auth.comments', compact('comments'));
}


    public function edit(string $id)
{
    $post = Post::findOrFail($id);
    $categories = Category::all();
    $tags = Tag::all();

    $image = $post->gallery ? asset('storage/auth/posts/' . $post->gallery->image) : null;

    $fileName = $post->gallery ? $post->gallery->image : null;

    return view('auth.posts.edit', compact('post', 'categories', 'tags', 'image', 'fileName'));
}


/**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        try {
            DB::beginTransaction();

            // Detach all tags
            $post->tags()->sync($request->tags);

            // Delete gallery image
            if ($post->gallery) {
                $imageName = $post->gallery->image;
                $imagePath = public_path('storage/auth/posts/');

                if (file_exists($imagePath . $imageName)) {
                    unlink($imagePath . $imageName);
                }

                $post->gallery->delete();
            }

            // Delete the post
            $post->delete();

            DB::commit();

            // Flash success message
            $request->session()->flash('alert-success', 'Post Deleted Successfully');

            return to_route('posts.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }
    }



    public function show(Post $post) {
        \Log::info('Showing post: ' . $post->id);
        return view('auth.posts.show', compact('post'));
    }
    // In App\Http\Controllers\Auth\PostController.php


}
