@extends('layouts.auth')

@section('title', 'Page Comments')

@section('styles')
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header">
                <h2>Page Comments</h2>
                <a href="{{ route('admin.pages.pagespamcomment') }}" class="btn btn-secondary ml-1 mt-2">spam</a>

            </div>
            <form method="GET" action="{{ route('admin.pages.pagescomment') }}" class="mb-4">
                <div class="row ml-3">
                    <!-- Filter by Title -->
                    <div class="col-md-3">
                        <input type="text" name="title" class="form-control" placeholder="Search by Title" value="{{ request('title') }}">
                    </div>

                    <!-- Filter by Date -->
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Select Date">
                    </div>

                    <button type="submit" class="btn btn-primary ml-3">Apply Filters</button>
                    <a href="{{ route('admin.pages.pagescomment') }}" class="btn btn-secondary ml-1">Reset</a>
                </div>
            </form>



            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($comments->count() > 0)
                <table class="table" id="pagecomment">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Page Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->page->title }}</td>
                            <td>{{ $comment->user ? $comment->user->name : 'Guest' }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ $comment->created_at->format('d M Y') }}</td>

                            <td>
                                @if ($comment->approved)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if (!$comment->approved)
                                    <form action="{{ route('admin.page.comments.approve', $comment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check-square"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.page.comments.unapprove', $comment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-window-close"></i></button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.page.comments.spam', $comment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Mark this comment as spam?');">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.page.comments.delete', $comment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this comment?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                               
                            </td>

                        </tr>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script>
  $(document).ready(function(){
        // Initialize DataTable with pagination to show 10 posts
        var table = $('#pagecomment').DataTable({
            "bLengthChange": false,
            "pageLength": 10, // Set the number of posts to display per page
            "paging": true, // Enable pagination
            "info": true, // Show info about the current page
            "searching": true // Enable searching
        });

        // Event listener to the date filter input
        $('#dateFilter').change(function() {
            table.draw();
        });
    });
</script>

@endsection

