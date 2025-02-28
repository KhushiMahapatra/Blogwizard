<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Category;
use Intervention\Image\Facades\Image;


class BlogController extends Controller
{
    public function index(Request $request) {

        $query = Post::where('status', Post::PUBLISHED);

        $status = $request->input('status');

        $query->when(!empty($status), function ($query) use ($status) {
            if ($status == 'draft') {
                $query->where('status', 0);
            } elseif ($status == 'published') {
                $query->where('status', 1)
                      ->whereNotNull('published_at')
                      ->where('published_at', '<=', now());
            } elseif ($status == 'scheduled') {
                $query->where('status', 1)
                      ->whereNotNull('published_at')
                      ->where('published_at', '>', now());
            }
        });

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('tag') && $request->tag != '') {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->tag . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        $blogs = $query->simplePaginate(10);

        $tags = Tag::all();
        $categories = Category::all();

        return view('site.index', compact('blogs', 'tags', 'categories'));
    }
    public function openSingleBlog($slug) {

        $blog = Post::where('slug', $slug)->where('status', Post::PUBLISHED)->first();

        $blog = Post::with('gallery.images')->where('slug', $slug)->where('status', Post::PUBLISHED)->first();


        if (!$blog) {
            abort(404);
        }
        $comments = Comment::where('post_id', $blog->id)
                            ->where('approved', true)
                            ->paginate(5);

        $latestPosts = Post::where('slug', '!=', $blog->slug)
                            ->where('status', Post::PUBLISHED)
                            ->latest()
                            ->limit(5)
                            ->get();

        $tags = $blog->tags;
        $categories = Category::all();
        $tags = Tag::all();

        return view('site.single', compact('blog', 'comments', 'latestPosts', 'tags', 'categories'));
        }

    public function categoryPosts($slug)
        {
            $category = Category::where('slug', $slug)->firstOrFail();

            \Log::info('Category Retrieved: ', ['category' => $category]);

            $blogs = $category->posts()->where('status', Post::PUBLISHED)->paginate(5);

            \Log::info('Blogs Retrieved: ', ['blogs' => $blogs]);

            $categories = Category::all();
            $tags = Tag::all();

            return view('site.category-posts', compact('category', 'blogs', 'categories', 'tags'));
        }

    public function tagPosts($slug)
        {
            $tag = Tag::where('slug', $slug)->firstOrFail();

            $blogs = $tag->posts()->where('status', Post::PUBLISHED)->paginate(5);

            $categories = Category::all();
            $tags = Tag::all();

            return view('site.tag-posts', compact('blogs', 'tag', 'categories', 'tags'));
        }

}
