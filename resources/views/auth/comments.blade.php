@extends('layouts.auth')

@section('title', 'Comments')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<style>
    #outer {
        text-align: center;
    }

    .inner {
        display: inline-block;
    }

    .reply-section {
        margin-left: 30px; /* Indent replies */
    }
</style>
@endsection

@section('content')

<div class="content-wrapper">
    <div class="content">
        <!-- Display Comments -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Comments</h2>
                <a href="{{ route('comments.spam.index') }}" class="btn btn-secondary ml-1 mt-2">spam</a>

            </div>

            <div class="card-body">

                <!-- Filter Form -->
                <form method="GET" action="{{ route('comments.index') }}" class="mb-4">
                    <div class="row">
                        <!-- Filter by Title -->
                        <div class="col-md-3">
                            <input type="text" name="title" class="form-control" placeholder="Search by Title" value="{{ request('title') }}">
                        </div>

                        <!-- Filter by Author -->
                        <div class="col-md-3 ">
                            <select name="author" class="form-control">
                                <option value="">Filter by Author</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter by Status -->
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Filter by Status</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>Spam</option> <!-- Added Spam Option -->
                            </select>
                        </div>

                        <!-- Filter by Date -->
                        <div class="col-md-3">
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Select Date">
                        </div>

                        <button type="submit" class="btn btn-primary mt-2 ml-3">Apply Filters</button>
                        <a href="{{ route('comments.index') }}" class="btn btn-secondary ml-1 mt-2">Reset</a>
                    </div>
                </form>

                @if (session('alert-success'))
                    <div class="alert alert-success">
                        {{ session('alert-success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($comments) > 0)
                <table class="table" id="comments">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Post Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions
                                <i class="fas fa-exclamation-triangle ml-1" title="Spam Comments: {{ $spamCount }}"> {{ $spamCount }}</i>
                                <i class="fas fa-window-close ml-1" title="Unapproved Comments: {{ $unapprovedCount }}"> {{ $unapprovedCount }}</i>
                                <i class="fas fa-check-square ml-1" title="Approved Comments: {{ $approvedCount }}"> {{ $approvedCount }}</i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->post->title }}</td>
                            <td>{{ $comment->user ? $comment->user->name : 'Guest' }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ date('d M Y', strtotime($comment->created_at)) }}</td>
                            <td>
                                @if ($comment->approved)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <!-- Mark as Spam Button -->
                                <form action="{{ route('comments.spam', $comment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to mark this comment as spam?');">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </button>
                                </form>

                                <!-- Delete Button -->
                                <form action="{{ route('comments.delete') }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <!-- Approve/Unapprove Button -->
                                @if ($comment->approved)
                                    <!-- Unapprove Button -->
                                    <form action="{{ route('comments.unapprove', $comment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to unapprove this comment?');">
                                            <i class="fas fa-window-close"></i>
                                        </button>
                                    </form>
                                @else
                                    <!-- Approve Button -->
                                    <form action="{{ route('comments.approve', $comment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check-square"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        @foreach ($comment->commentReplies as $reply) <!-- Display Replies -->
                        <tr class="reply-section">
                            <td>{{ $reply->id }}</td>
                            <td>{{ $comment->post->title }}</td>
                            <td>{{ $reply->user ? $reply->user->name : 'Guest' }}</td>
                            <td>{!! str_replace(['{', '}'], '', $reply->comment) !!}</td>
                            <td>
                                @if ($reply->approved)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <!-- Delete Button for Reply -->
                                <form action="{{ route('comment.reply.delete') }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="reply_id" value="{{ $reply->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reply?');">
                                        Delete
                                    </button>
                                </form>

                                <!-- Approve Button for Reply -->
                                @if (!$reply->approved)
                                <form action="{{ route('comment.reply.approve', $reply->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
@else
<h3 class="text-center text-danger">No Comments Found</h3>
@endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#comments').DataTable({
            "bLengthChange": false
        });
    });
</script>
@endsection
