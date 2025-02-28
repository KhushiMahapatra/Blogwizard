<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Site\Comments\CreateRequest;
use App\Http\Requests\Site\Comments\Reply\ReplyCreateRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\User;
use App\Mail\CommentAdded;
use App\Notifications\CommentAddedNotification;

class CommentController extends Controller
{
    // Store a new comment
    public function postComment(CreateRequest $request, $postId)
    {
        if (auth()->check()) {
            // Find the post by ID
            $post = Post::find($postId);

            if (!$post) {
                return back()->with('error', 'Unable to find the post, please refresh the webpage and try again!');
            }

            // Create the comment with "approved" set to false by default
            $comment = Comment::create([
                'post_id' => $postId,
                'user_id' => auth()->id(),
                'comment' => $request->comment,
                'approved' => false, // Unapproved by default
            ]);

            // Send notification to the post owner
            if ($post->user) { // Ensure the post has an associated user
                try {
                    $post->user->notify(new CommentAddedNotification($comment, $post));
                } catch (\Exception $e) {
                    \Log::error('Notification Failed: ' . $e->getMessage());
                    return back()->withErrors('Comment added but notification failed!');
                }
            }

            // Flash success message to the session
            $request->session()->flash('alert-success', 'Comment added successfully! Your comment is awaiting approval.');
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to post a comment.');
        }

        return back();
    }

    // Store a reply to a comment
    public function postCommentReply(ReplyCreateRequest $request, $commentId)
    {
        if (auth()->check()) {
            $comment = Comment::find($commentId);

            if (!$comment) {
                return back()->withErrors('Comment not found!');
            }

            // Ensure the comment is approved before allowing replies
            if (!$comment->approved) {
                return back()->withErrors('Cannot reply to an unapproved comment.');
            }

            try {
                CommentReply::create([
                    'comment_id' => $comment->id,
                    'user_id' => auth()->id(),
                    'comment' => $request->comment,
                ]);

                $request->session()->flash('alert-success', 'Comment reply added successfully. Your comment is awaiting approval.');
            } catch (\Exception $ex) {
                return back()->withErrors($ex->getMessage());
            }
        }

        return back();
    }

    // Delete a comment reply
    public function deleteCommentReply(Request $request)
    {
        $replyId = $request->reply_id;

        $reply = CommentReply::find($replyId);
        if (!$reply) {
            return back()->withErrors('Unable to locate the reply, please try again!');
        }
        $reply->delete();
        $request->session()->flash('alert-success', 'Comment reply deleted successfully!');

        return back();
    }

    // Delete a comment and its replies
    public function deleteComment(Request $request)
    {
        $commentId = $request->comment_id;

        $comment = Comment::find($commentId);
        if (!$comment) {
            return back()->withErrors('Unable to locate the comment. Please try again!');
        }

        // Delete all replies associated with the comment
        CommentReply::where('comment_id', $commentId)->delete();

        // Delete the comment itself
        $comment->delete();

        $request->session()->flash('alert-success', 'Comment deleted successfully!');

        return back();
    }

    // Edit a comment
    public function editComment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'comment' => 'required|string|max:500',
        ]);

        $comment = Comment::find($request->comment_id);

        if (!$comment) {
            return back()->withErrors('Unable to locate the comment. Please try again!');
        }

        // Ensure only the owner of the comment can edit it
        if ($comment->user_id !== auth()->id()) {
            return back()->withErrors('You are not authorized to edit this comment.');
        }

        $comment->update([
            'comment' => $request->comment,
        ]);

        $request->session()->flash('alert-success', 'Comment updated successfully!');

        return back();
    }

    public function editCommentReply(Request $request)
    {
        \Log::info('Editing reply with request:', $request->all()); // Debugging

        // Validate request
        $request->validate([
            'reply_id' => 'required|exists:comment_replies,id',
            'comment' => 'required|string|max:500',
        ]);

        // Find the reply
        $reply = CommentReply::find($request->reply_id);

        // Check if reply exists
        if (!$reply) {
            \Log::error('Reply not found: ' . $request->reply_id);
            return back()->withErrors('Reply not found.');
        }

        // Authorization: Ensure user is the owner
        if ($reply->user_id !== auth()->id()) {
            \Log::warning('Unauthorized edit attempt by user: ' . auth()->id());
            return back()->withErrors('You are not authorized to edit this reply.');
        }

        try {
            // Update reply
            $reply->comment = $request->comment;
            $reply->save();

            \Log::info('Reply updated successfully!');
            return back()->with('alert-success', 'Reply updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating reply: ' . $e->getMessage());
            return back()->withErrors('An error occurred while updating the reply.');
        }
    }
    // Show all comments for management
    public function showComments(Request $request)
{
    // Start with a base query that includes related models
    $query = Comment::with('post', 'user', 'commentReplies.user');

    $query->where('spam', false);

    $approvedCount = Comment::where('approved', true)->count();
    $spamCount = Comment::where('spam', true)->count();
    $unapprovedCount = Comment::where('approved', false)->count();


    // Filter by Post Title (if provided)
    if ($request->filled('title')) {
        $query->whereHas('post', function ($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->title . '%');
        });
    }

    // Filter by Author (if provided)
    if ($request->filled('author')) {
        $query->where('user_id', $request->author);
    }

    // Filter by Status (if provided)
    if ($request->filled('status')) {
        if ($request->status === 'approved') {
            $query->where('approved', true);
        } elseif ($request->status === 'pending') {
            $query->where('approved', false);
        } elseif ($request->status === 'spam') {
            $query->where('spam', true); // Assuming you have a 'spam' column in your comments table
        }
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Fetch filtered comments
    $comments = $query->get();

    // Fetch all unique authors for the filter dropdown
    $authors = User::select('id', 'name')->get();

    // Return the view with filtered comments
    return view('auth.comments', compact('comments', 'authors', 'approvedCount', 'spamCount', 'unapprovedCount'));
}

    // Approve a comment
    public function approve($id)
    {
        \Log::info("Approving comment with ID: $id"); // Log the ID being approved
        $comment = Comment::findOrFail($id);
        $comment->approved = true; // Approve the comment
        $comment->save();

        return redirect()->back()->with('alert-success', 'Comment approved successfully!');
    }
    public function unapproveComment(Request $request, $commentId)
{
    // Find the comment by ID
    $comment = Comment::find($commentId);
    if (!$comment) {
        return back()->withErrors('Unable to locate the comment. Please try again!');
    }

    // Set the comment as unapproved
    $comment->approved = false;
    $comment->save();

    $request->session()->flash('alert-success', 'Comment unapproved successfully!');

    return back();
}

    // Approve a reply to a comment
    public function approveReply($id)
    {
        \Log::info("Approving reply with ID: $id"); // Log the ID being approved
        $reply = CommentReply::findOrFail($id);
        $reply->approved = true; // Approve the reply
        $reply->save();

        return redirect()->back()->with('alert-success', 'Reply approved successfully!');
    }



    // Store a new comment (alternative method)
    public function store(Request $request, $postId)
    {
        // Validate the comment input
        $request->validate([
            'content' => 'required|string|max:500|regex:/^(?!.*(SELECT|INSERT|UPDATE|DELETE|DROP|;|--|\/\*|\*\/|<|>)).*$/i',
        ]);

        // Find the associated post
        $post = Post::findOrFail($postId);

        // Create the comment with "approved" set to false by default
        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'comment' => strip_tags($request->input('content')), // Sanitize input to remove HTML tags
            'approved' => false, // Unapproved by default
        ]);

        return redirect()->route('posts.show', $postId)
            ->with('success', 'Your comment has been submitted and is awaiting approval!');
    }
    public function addReply(Request $request, $commentId)
{
    $request->validate([
        'comment' => 'required|string|max:255',
    ]);

    $reply = new CommentReply();
    $reply->comment = $request->comment;
    $reply->comment_id = $commentId; // Assuming you have a foreign key to the comment
    $reply->user_id = auth()->id(); // Assuming the user is logged in
    $reply->approved = false; // Set to false initially
    $reply->save();

    return redirect()->back()->with('alert-success', 'Comment reply added successfully. Your comment is awaiting approval.');
}
    public function showCommentsForPost(Post $post)
    {
        // Fetch only comments related to the given post
        $comments = $post->comments()->with('user')->latest()->get();

        return view('auth.posts.comment-post', compact('post', 'comments'));
    }

    public function markAsSpam($id)
{
    $comment = Comment::findOrFail($id);

    // Mark the comment as spam (you may want to add a 'spam' column in your comments table)
    $comment->spam = true; // Assuming you have a 'spam' column in your comments table
    $comment->save();

    return redirect()->back()->with('alert-success', 'Comment marked as spam successfully.');
}

public function spamComments(Request $request)
{
    // Start with the Comment model
    $query = Comment::where('spam', true)->with('post', 'user');

    // Filter by Post Title (if provided)
    if ($request->filled('title')) {
        $query->whereHas('post', function ($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->title . '%');
        });
    }

    // Filter by Author (if provided)
    if ($request->filled('author')) {
        $query->where('user_id', $request->author);
    }

    // Filter by Date (if provided)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Fetch filtered comments with pagination
    $spamComments = $query->paginate(10);

    // Fetch all unique authors for the filter dropdown
    $authors = User::select('id', 'name')->get();

    return view('auth.spam', compact('spamComments', 'authors'));
}
public function unmarkSpam($id)
{
    $comment = Comment::findOrFail($id);

    // Unmark the comment as spam
    $comment->spam = false; // Assuming you have a 'spam' column in your comments table
    $comment->save();

    return redirect()->back()->with('alert-success', 'Comment unmarked as spam successfully.');
}

public function deleteSpamComment(Request $request, $commentId)
{
    // Debugging: Log the attempt to delete the comment
    \Log::info('Attempting to delete comment with ID: ' . $commentId);

    // Find the comment by ID
    $comment = Comment::find($commentId);
    if (!$comment) {
        \Log::error('Comment not found: ' . $commentId);
        return back()->withErrors('Unable to locate the comment. Please try again!');
    }

    // Delete all replies associated with the comment
    CommentReply::where('comment_id', $commentId)->delete();

    // Delete the comment itself
    $comment->delete();

    // Flash success message
    $request->session()->flash('alert-success', 'Comment deleted successfully!');

    return back();
}


}
