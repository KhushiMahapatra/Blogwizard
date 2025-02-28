@extends('layouts.site')

@section('title', $page->title)

@section('styles')
<style>
    .content img {
        width: 250px;
        height: 150px;
    }
</style>
@endsection

@section('content')

<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Other Pages</span>
                    <h1 class="text-capitalize mb-4 text-lg">{{ $page->title }}</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="list-inline-item"><span class="text-white">/ Other Pages</span></li>
                        <li class="list-inline-item text-white-50"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section>


    @if ($page->status === 'published' || ($page->status === 'scheduled' && $page->published_at <= now()))
    <!-- Page content goes here -->
    @else
        <div class="container mt-5">
            <h4 class="text-danger">This page is not available.</h4>
        </div>
    @endif


    <div class="container mt-5">
        <h2>{{ $page->title }}</h2>
        <p class="content">{!! $page->description !!}</p>
    </div>
</section>

<!-- Comments Section -->
@if ($page->comments_enabled)
    <!-- Comments Section -->
    <section class="mt-5">
        <div class="container">
            <h4>Comments</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('page.comment', $page->id) }}">
                @csrf
                <textarea name="comment" class="form-control" rows="3" placeholder="Leave a comment..." required></textarea>
                <button class="btn btn-info mt-2">Submit</button>
            </form>


            <h3 class="mt-3">{{ $page->comments()->where('approved', true)->count() }} Comments</h3>

            <ul class="list-unstyled mt-4">
                @foreach ($page->comments()->where('approved', true)->get() as $comment)
                    <li class="mb-3">
                        <div class="comment-area-box">
                            <img src="{{ asset('assets/site/images/user-image.jpg') }}" class="mt-2 img-fluid float-left mr-3" style="width: 30px">
                            <h5 class="mb-1" style="margin: 0;">{{ $comment->user ? $comment->user->name : 'Anonymous' }}</h5>
                            <span style="color: #6c757d;">{{ $comment->user ? $comment->user->email : 'No email provided' }}</span>
                            <div class="comment-meta float-right">
                                <span class="date-comm">Posted On {{ date('d M Y', strtotime($comment->created_at)) }}</span>

                                <!-- Edit Button -->
                                <button class=" btn-sm btn-primary edit-comment-btn" data-comment-id="{{ $comment->id }}"><i class="fas fa-edit"></i></button>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.page.comments.delete', $comment->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Delete this comment?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Display Comment -->
                        <p id="comment-text-{{ $comment->id }}">{{ $comment->comment }}</p>

                        <!-- Edit Form (Initially Hidden) -->
                        <form method="POST" action="{{ route('page.comment.update', $comment->id) }}" class="edit-comment-form" id="edit-form-{{ $comment->id }}" style="display: none;">
                            @csrf
                            @method('PUT')
                            <textarea name="comment" class="form-control" rows="2" required></textarea>
                            <button class="btn btn-sm btn-success mt-1">Update</button>
                            <button type="button" class="btn btn-sm btn-secondary cancel-edit" data-comment-id="{{ $comment->id }}">Cancel</button>
                        </form>

                        <!-- Reply Button -->
                        <button class="btn btn-sm btn-link text-primary reply-btn" data-reply-form="reply-form-{{ $comment->id }}">Reply</button>

                        <!-- Reply Form (Initially Hidden) -->
                        <form method="POST" action="{{ route('page.comment.reply', $comment->id) }}" class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
                            @csrf
                            <textarea name="comment" class="form-control" rows="2" placeholder="Enter reply..." required></textarea>
                            <button class="btn btn-sm btn-info mt-1">Submit Reply</button>
                        </form>

                        <!-- Display Replies -->
                        @php
                            $approvedReplies = $comment->replies->where('approved', true);
                        @endphp

                        @if ($approvedReplies->count() > 0)
                        <ul class="list-unstyled reply-section mt-2" style="list-style-type: none;">
                            @foreach ($approvedReplies as $reply)
                                <li class="mb-2 ml-4">
                                    <div class="reply-box">
                                        <strong>{{ $reply->user ? $reply->user->name : 'Anonymous' }}:</strong>
                                        <span id="reply-text-{{ $reply->id }}">{{ $reply->comment }}</span>
                                        <span class="text-muted" style="font-size: 12px;">(Posted On {{ date('d M Y', strtotime($reply->created_at)) }})</span>

                                        <!-- Edit Reply Button -->
                                        <form action="{{ route('admin.page.comments.delete', $comment->id) }}" method="POST" style="float: right">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Delete this comment?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <button class=" btn-sm btn-primary edit-reply-btn mr-1" style="float: right" data-reply-id="{{ $reply->id }}"><i class="fas fa-edit"></i></button>

                                    </div>

                                    <!-- Edit Reply Form (Initially Hidden) -->
                                    <form method="POST" action="{{ route('page.comment.updateReply', $reply->id) }}" class="edit-reply-form" id="edit-reply-form-{{ $reply->id }}" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="comment" class="form-control" rows="2" required></textarea>
                                        <button class="btn btn-sm btn-success mt-1">Update</button>
                                        <button type="button" class="btn btn-sm btn-secondary cancel-edit-reply mt-1" data-reply-id="{{ $reply->id }}">Cancel</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                @endforeach
            </ul>



        </div>


    </section>


@else
    <div class="container mt-5">
        <h4 class="text-muted">Comments are disabled for this page.</h4>
    </div>

@endif



</section>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".reply-btn").forEach(button => {
            button.addEventListener("click", function () {
                let replyFormId = this.getAttribute("data-reply-form");
                let replyForm = document.getElementById(replyFormId);
                replyForm.style.display = (replyForm.style.display === "none") ? "block" : "none";
            });
        });
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Edit Comment
        document.querySelectorAll('.edit-comment-btn').forEach(button => {
            button.addEventListener('click', function () {
                let commentId = this.dataset.commentId;
                document.getElementById('comment-text-' + commentId).style.display = 'none';
                document.getElementById('edit-form-' + commentId).style.display = 'block';
            });
        });

        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function () {
                let commentId = this.dataset.commentId;
                document.getElementById('comment-text-' + commentId).style.display = 'block';
                document.getElementById('edit-form-' + commentId).style.display = 'none';
            });
        });

        // Edit Reply
        document.querySelectorAll('.edit-reply-btn').forEach(button => {
            button.addEventListener('click', function () {
                let replyId = this.dataset.replyId;
                document.getElementById('reply-text-' + replyId).style.display = 'none';
                document.getElementById('edit-reply-form-' + replyId).style.display = 'block';
            });
        });

        document.querySelectorAll('.cancel-edit-reply').forEach(button => {
            button.addEventListener('click', function () {
                let replyId = this.dataset.replyId;
                document.getElementById('reply-text-' + replyId).style.display = 'block';
                document.getElementById('edit-reply-form-' + replyId).style.display = 'none';
            });
        });


    });

</script>

@endsection

