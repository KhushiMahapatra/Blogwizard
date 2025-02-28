@extends('layouts.site')

@section('title', 'Blog')

@section('styles')
<style>
     .image-container1 {
        width: 100%;
        height: 100%;

}

.image-container1 img {
    max-width: 100%;
    height: 100%;
    object-fit: cover;
}
.image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.image{
    width: 100%;
    height: 100%;
}
</style>
@endsection

@section('content')

<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">{{ $blog->user->name }}</span>
                    <h1 class="text-capitalize mb-4 text-lg">{{ $blog->title }}</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Blogs</a></li>
                        <li class="list-inline-item"><span class="text-white">/</span></li>
                        <li class="list-inline-item text-white-50">{{ $blog->title }}'s Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



@if ($blog)
<section class="section blog-wrap bg-gray">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <div class="single-blog-item">

                            <div class="image" >
                                @if($blog->gallery) <!-- Check if the blog has a gallery -->
                                @foreach($blog->gallery->images as $image) <!-- Iterate over the images -->
                                    @if($image->size === 'medium') <!-- Check for large images -->
                                        <img src="{{ asset($image->path) }}" alt="Image"  >
                                    @endif
                                @endforeach
                            @else
                                <img src="{{ asset('default-image.jpg') }}" style="width: 80px; height: 60px" alt="default image">
                            @endif
                            </div>
                            <div class="blog-item-content bg-white p-5">
                                <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                                    <span class="text-muted text-capitalize d-inline-block mr-3"><i class="ti-comment mr-2"></i>{{ $blog->comments->where('approved', true)->count() }} Comments</span>
                                    <span class="text-black text-capitalize d-inline-block" style="float: right"><i class="ti-time mr-1"></i>{{ date('d M Y', strtotime($blog->created_at)) }}</span>
                                </div>

                                <h2 class="mt-3 mb-4">{{ $blog->title }}</h2>
                                <p class="lead mb-4">{!! $blog->description !!}</p>

                                <div class="tag-option mt-5 d-block d-md-flex justify-content-between align-items-center">
                                    <ul class="list-inline">
                                        <li>Tags:</li>
                                        @foreach ($blog->tags as $tag)
                                            <li class="list-inline-item"><a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}<br></a></li>
                                        @endforeach
                                    </ul>
                                </div>


                                <div class="tag-option mt-5 d-block d-md-flex justify-content-between align-items-center">
                                    <ul class="list-inline">
                                        <li> Category:</li>
                                        @if($blog->categories->isNotEmpty())
                                        @foreach($blog->categories as $category)
                                            <span ><a href="{{ route('category.posts', $category->slug) }}">{{ $category->name }}<br></a></span>
                                        @endforeach
                                    @else
                                        <span>No Categories</span>
                                    @endif
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>


                        @if(!$blog->disable_comments)

                        <div class="col-lg-12 mb-5">

                            @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (Session::has('alert-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ Session::get('alert-success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                        </div>
                        <div class="col-lg-12 mb-5">
                            <form method="POST" action="{{ route('post.comment', $blog->id) }}">
                                @csrf
                                <div class="form-group">
                                    <label for="comment"><strong>Comment</strong></label>
                                    <textarea name="comment"  class="form-control" cols="20" rows="3" placeholder="Enter comment here..." style="width: 100%;"></textarea>
                                                <button class="btn btn-sm btn-info mt-3" style="float:right;">Comment</button>
                                </div>
                            </form>
                        </div>

                        @if (count($comments) > 0)

                        <div class="comment-area card border-0 p-5 col-lg-12 mb-5" id="comment-section">
                            <h4 class="mb-4">{{ count($comments) }} Comments</h4>
                            <ul class="comment-tree list-unstyled">

                                @foreach ($comments as $comment)
                                    @if ($comment->approved) <!-- Only display approved comments -->
                                    <li>
                                        <div class="comment-area-box mb-5">
                                            <img loading="lazy" alt="comment-author" src="{{ asset('assets/site/images/user-image.jpg') }}" class="mt-2 img-fluid float-left mr-3" style="width: 30px">

                                            <h5 class="mb-1" style="margin: 0;">{{ $comment->user ? $comment->user->name : 'Anonymous' }}</h5>
                                            <span style="color: #6c757d;">{{ $comment->user ? $comment->user->email : 'No email provided' }}</span>
                                            <div class="comment-meta mt-4 mt-lg-0 mt-md-0 float-lg-right float-md-right">
                                                <span class="date-comm">
                                                    Posted On {{ $comment->created_at ? date('d M Y', strtotime($comment->created_at)) : 'Unknown date' }}
                                                </span>

                                                <!-- Edit Button -->
                                                <button type="button" class="btn-primary" data-toggle="modal" data-target="#editCommentModal-{{ $comment->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Delete Form -->
                                                <form action="{{ route('comment.delete') }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                    <button type="submit" class="btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- Edit Comment Modal -->
                                            <div class="modal fade" id="editCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
                                                <div class="modal-dialog"> 
                                                    <form action="{{ route('comment.edit') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="comment">Comment</label>
                                                                    <textarea name="comment" class="form-control" rows="3" required>{{ $comment->comment}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="comment-content mt-3">
                                                <p>{!! str_replace(['{', '}'], '', $comment->comment) !!}</p>
                                            </div>

                                            <div class="ml-5">
                                                @if ($comment->commentReplies)
                                                    @foreach ($comment->commentReplies as $reply)
                                                        @if ($reply->approved) <!-- Only display approved replies -->
                                                            <div class="comment-meta mt-4 mt-lg-0 mt-md-0 float-lg-right float-md-right">
                                                                <span class="date-comm">
                                                                    Posted {{ $reply->created_at ? date('d M Y', strtotime($reply->created_at)) : 'Unknown date' }}
                                                                </span>
                                                                <form action="{{ route('comment.reply.delete') }}" method="post" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="reply_id" value="{{ $reply->id }}">
                                                                    <button type="submit" class="btn-danger" id="reply-delete-btn" title="Delete Reply">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                                <!-- Edit Button -->
                                                                <button type="button" class="btn-primary" data-toggle="modal" data-target="#editReplyModal-{{ $reply->id }}" title="Edit Reply">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </div>

                                                            <!-- Edit Reply Modal -->
                                                            <div class="modal fade" id="editReplyModal-{{ $reply->id }}" tabindex="-1" aria-labelledby="editReplyModalLabel-{{ $reply->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <form action="{{ route('comment.reply.edit') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="reply_id" value="{{ $reply->id }}">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editReplyModalLabel-{{ $reply->id }}">Edit Reply</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="reply">Reply</label>
                                                                                    <textarea name="comment" class="form-control" rows="3" required>{{ old('comment', $reply->comment) }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="comment-content mt-3">
                                                                <p>{!! str_replace(['{', '}'], '', $reply->comment) !!}</p>
                                                            </div>
                                                        @endif <!-- End of approved reply check -->
                                                    @endforeach
                                                @endif
                                            </div>
                                            <span class="show-reply" style="float: right; cursor: pointer;">Reply</span>

                                        </div>

                                        <div class="form-group comment-reply-div" style="height: 150px; display: none; margin-top: 10px;">
                                            <form method="post" action="{{ route('comment.reply', $comment->id) }}">
                                                @csrf
                                                <textarea name="comment"  class="form-control" cols="20" rows="3" placeholder="Enter comment here..." style="width: 100%;"></textarea>
                                                <button class="btn btn-sm btn-info mt-3" style="float:right;">Reply</button>
                                            </form>
                                        </div>
                                    </li>
                                    @endif <!-- End of approved comment check -->
                                @endforeach
                            </ul>
                        </div>

                        @endif
                        <div class="col-md-12 mt-">
                            <span>
                                {{ $comments->links() }}
                            </span>
                        </div>

                        @else
                        <div class="container mt-5">
                            <h4 class="text-muted">Comments are disabled for this page.</h4>
                        </div>

                        @endif






                    <div class="col-lg-12 mb-5">

                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="sidebar-wrap">

                    @if (count($latestPosts) > 0)

                    <div class="sidebar-widget latest-post card border-0 p-4 mb-3">
                        <h5>Latest Posts</h5>

                        @foreach ($latestPosts as $post)
                        <div class="media border-bottom py-3">
                            <a href="{{ route('single-blog', $post->slug) }}">
                                <div class="image-container1">
                                    @if($post->gallery && $post->gallery->images->isNotEmpty()) <!-- Check if the blog has a gallery and if it has images -->
                                        @foreach($post->gallery->images as $image) <!-- Iterate over the images -->
                                            @if($image->size === 'small') <!-- Check for large images -->
                                                <img src="{{ asset($image->path) }}" alt="Image" >
                                            @endif
                                        @endforeach
                                    @else
                                        <img src="{{ asset('default-image.jpg') }}" style="width: 80px; height: 60px;" alt="default image">
                                    @endif
                                </div>
                            <div class="media-body">
                                <h6 class="my-2 ml-3">
                                    <a href="{{ route('single-blog', $post->slug) }}">{{ $post->title }}</a>
                                </h6>
                                <span class="text-sm text-muted ml-3">{{ date('d M Y', strtotime($post->created_at)) }}</span>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    @endif

                    <div class="sidebar-widget bg-white rounded tags p-4 mb-3">
                        <h5 class="mb-4">Tags</h5>
                        @if (count($tags) > 0) {{-- Safely check if $tags exists --}}
                            @foreach ($tags as $tag)
                                <a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}</a>
                            @endforeach
                        @else
                            <h6 class="text-danger text-center">No Tags Found!</h6>
                        @endif
                    </div>

                    <div class="sidebar-widget bg-white rounded tags p-4 mb-3">
                        <h5 class="mb-4">Categories</h5>
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <a href="{{ route('category.posts', $category->slug) }}">{{ $category->name }}</a>
                            @endforeach
                        @else
                            <h6 class="text-danger text-center">No Category Found!</h6>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

@else
<h3 class="text-danger text-center mt-5">Unable to locate the blog, Please go back and try again!</h3>
@endif

@endsection

@section('scripts')




<script>


tinymce.init({
        selector: 'textarea#myeditorinstance',
        plugins: 'code table lists',
        menubar: false,
        toolbar: 'undo redo |  bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist '

    });

    $(document).ready(function() {
        $('.show-reply').click(function() {
            // Toggle the visibility of the corresponding reply div
            $(this).closest('li').find('.comment-reply-div').toggle();
        });

        // Show the reply button when the textarea is focused
        $('.comment-reply-div textarea').focus(function() {
            $(this).siblings('button').show(); // Show the reply button
        });

        // Hide the reply button when the textarea is empty and loses focus
        $('.comment-reply-div textarea').blur(function() {
            if ($(this).val() === '') {
                $(this).siblings('button').hide(); // Hide the reply button
            }
        });
    });
</script>

<script>
    $('html, body').animate({
        scrollTop: $("#comment-section").offset().top
    }, 2000);
</script>

<script>
    $(document).ready(function() {
    $('form').on('submit', function(e) {
        const comment = $('#comment').val();
        const sqlRegex = /SELECT|INSERT|UPDATE|DELETE|DROP|;|--|\/\*|\*\/|<|>/i;

        if (sqlRegex.test(comment)) {
            e.preventDefault(); // Prevent form submission
            alert('Your comment contains invalid characters or SQL queries. Please revise your comment.');
        }
    });
});
$(document).ready(function() {
    // Show the edit modal
    $('.btn-primary').click(function() {
        const replyId = $(this).closest('.comment-area-box').find('input[name="reply_id"]').val();
        console.log('Editing reply ID:', replyId); // Check if the correct ID is being logged
    });
});

$(document).ready(function() {
    $('form').on('submit', function(e) {
        console.log('Form submitted!'); // Debugging
    });
});

</script>

@endsection
