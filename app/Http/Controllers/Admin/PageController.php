<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Comment;
use App\Models\PageComment;
use App\Models\PageSpamComment;
use Carbon\Carbon;
use Illuminate\Support\Str;


class PageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pages = Page::when($search, function ($query) use ($search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        })->paginate(10);

        return view('admin.pages.index', compact('pages', 'search'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published,scheduled',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
        ]);

        // Generate slug if not provided
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        
        // Create the page
        Page::create([
            'title' => $request->title,
            'slug' => $slug, // Ensure slug is always set
            'description' => $request->description,
            'published_at' => $request->status === 'published' ? now() : ($request->status === 'scheduled' ? $request->published_at : null),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page added successfully.');
    }


    public function create()
{
    return view('admin.pages.create'); // Ensure this Blade file exists
}



    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }



    public function update(Request $request, $id)
    {
        // Validate form inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:draft,published,scheduled', // Validate status
            'published_at' => 'nullable|date', // Ensure valid date format
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id, // Ensure unique slug except for this page
        ]);

        // Find the page
        $page = Page::findOrFail($id);

        // Generate or update slug
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // Ensure the slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Page::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Update fields
        $page->title = $request->input('title');
        $page->slug = $slug; // Update the slug
        $page->description = $request->input('description');
        $page->status = $request->input('status');

        // Handle publish date
        if ($request->status === 'scheduled') {
            $page->published_at = $request->published_at; // Save scheduled date
        } elseif ($request->status === 'published') {
            $page->published_at = now(); // Publish immediately
        } else {
            $page->published_at = null; // Drafts should not have a publish date
        }

        // Save the page
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
    public function show($id)
    {
        $page = Page::where('id', $id)
            ->where(function ($query) {
                $query->where('status', 'published')
                      ->orWhere(function ($q) {
                          $q->where('status', 'scheduled')
                            ->where('published_at', '<=', now());
                      });
            })
            ->first();

        if (!$page) {
            abort(404, 'Page not found or not yet published.');
        }

        return view('admin.pages.show', compact('page'));
    }


    public function pages()
    {
        $pages = Page::all();
        return view('site.otherpages', compact('pages'));
    }

    public function editComment(PageComment $comment)
    {
        return response()->json([
            'comment' => $comment->comment
        ]);
    }

    // Update Comment
    public function updateComment(Request $request, PageComment $comment)
{
    $request->validate([
        'comment' => 'required|string|max:500',
    ]);

    $comment->update([
        'comment' => $request->comment
    ]);

    return redirect()->back()->with('success', 'Comment updated successfully!');
}

    // Edit Reply
    public function editReply(PageComment $reply)
    {
        return response()->json([
            'comment' => $reply->comment
        ]);
    }

    // Update Reply
    public function updateReply(Request $request, PageComment $reply)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $reply->update([
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Reply updated successfully!');
    }

    public function showOtherSinglepage($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $comments = $page->comments()->where('approved', true)->get();

        return view('site.othersinglepage', compact('page', 'comments'));
    }


    public function storePageComment(Request $request, $pageId)
{
    $request->validate([
        'comment' => 'required|string|max:500',
    ]);

    PageComment::create([
        'page_id' => $pageId, // Correctly linking the comment to the page
        'user_id' => auth()->id(), // Store user ID if logged in
        'comment' => $request->comment,
        'approved' => false, // Admin approval required
    ]);

    return redirect()->route('site.othersinglepage', $pageId)->with('success', 'Comment submitted for approval.');
}

public function showPageComments()
{
    $comments = PageComment::latest()->paginate(10);
    return view('admin.pages.pagescomment', compact('comments'));
}

public function filterPageComments(Request $request)
{
    $query = PageComment::with('page', 'user');

    // Filter by Title (if provided)
    if ($request->filled('title')) {
        $query->whereHas('page', function ($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->title . '%');
        });
    }

    // Filter by Date (if provided)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $comments = $query->latest()->paginate(10);
    return view('admin.pages.pagescomment', compact('comments'));
}
public function markAsSpam($id)
{
    $comment = PageComment::findOrFail($id);

    // Store in PageSpamComment
    PageSpamComment::create([
        'page_id' => $comment->page_id,
        'user_id' => $comment->user_id,
        'comment' => $comment->comment,
    ]);

    // Delete from original comments table
    $comment->delete();

    return redirect()->back()->with('success', 'Comment marked as spam.');
}
public function showSpamComments(Request $request)
{



    // Fetch filtered comments with pagination
    $spamComments = PageSpamComment::latest()->paginate(10);

    return view('admin.pages.pagespamcomment', compact('spamComments'));
}

public function showCommentsForPage($pageId)
{
    // Retrieve the page using the provided ID
    $page = Page::findOrFail($pageId);

    // Fetch only comments related to the given page, including user info
    $comments = $page->comments()->with('user')->latest()->get();

    return view('admin.pages.comment-page', compact('page', 'comments'));
}


public function filterSpamComments(Request $request){
// Initialize the query
$query = PageSpamComment::with('page', 'user');

    // Filter by Post Title (if provided)
    if ($request->filled('title')) {
        $query->whereHas('page', function ($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->title . '%');
        });
    }

    // Filter by Date (if provided)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Fetch filtered comments with pagination
    $spamComments = $query->latest()->paginate(10);

    return view('admin.pages.pagespamcomment', compact('spamComments'));

}
public function unspamComment($id)
{
    $spamComment = PageSpamComment::findOrFail($id);

    // Move the comment back to the main comments table
    PageComment::create([
        'page_id' => $spamComment->page_id,
        'user_id' => $spamComment->user_id,
        'comment' => $spamComment->comment,
        'approved' => false, // Admin needs to re-approve
    ]);

    // Delete from spam table
    $spamComment->delete();

    return redirect()->back()->with('success', 'Comment restored successfully.');
}

public function deleteSpamComment($id)
{
    $spamComment = PageSpamComment::findOrFail($id);
    $spamComment->delete();

    return redirect()->back()->with('success', 'Spam comment deleted successfully.');
}
public function disableComments($id)
{
    $page = Page::findOrFail($id);
    $page->comments_enabled = false;
    $page->save();

    return redirect()->back()->with('success', 'Comments disabled for this page.');
}

public function enableComments($id)
{
    $page = Page::findOrFail($id);
    $page->comments_enabled = true;
    $page->save();

    return redirect()->back()->with('success', 'Comments enabled for this page.');
}


public function approvePageComment($id)
{
    $comment = PageComment::findOrFail($id);
    $comment->approved = true;
    $comment->save();

    return redirect()->back()->with('success', 'Comment approved successfully.');
}
public function unapprove($id)
{
    $comment = PageComment::findOrFail($id);
    $comment->approved = false;
    $comment->save();

    return redirect()->back()->with('success', 'Comment has been unapproved.');
}
public function deletePageComment($id)
{
    $comment = PageComment::findOrFail($id);
    $comment->delete();

    return redirect()->back()->with('success', 'Comment deleted successfully.');
}

public function storeCommentReply(Request $request, $commentId)
{
    $request->validate([
        'comment' => 'required|string|max:500',
    ]);

    $comment = PageComment::findOrFail($commentId);

    try {
        $reply = PageComment::create([
            'page_id' => $comment->page_id,
            'parent_id' => $commentId,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'approved' => false,
        ]);

        return redirect()->back()->with('success', 'Reply submitted for approval.');
    } catch (\Exception $e) {
        \Log::error('Reply creation failed: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Could not submit reply.']);
    }
}
public function uploadImage(Request $request)
{
    if ($request->hasFile('file')) {
        $image = $request->file('file');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Store the image in the public folder
        $image->move(public_path('uploads/pages'), $imageName);

        // Return the full URL to the uploaded image
        return response()->json(['location' => asset('uploads/pages/' . $imageName)]);
    }

    return response()->json(['error' => 'No file uploaded'], 400);
}

}
