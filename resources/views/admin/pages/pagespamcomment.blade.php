@extends('layouts.auth')

@section('title', 'Pages Spam Comments')



@section('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"/>
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />

@endsection


@section('content')

<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header">
                <h2>Spam Comments</h2>
                <a href="{{ route('admin.pages.pagescomments') }}" class="btn btn-secondary ml-1 mt-2">Back To Page comments</a>

            </div>

            <form method="GET" action="{{ route('admin.pages.pagespamcomment') }}" class="mb-4">
                <div class="row ml-3">
                    <!-- Filter by Title -->
                    <div class="col-md-2">
                        <input type="text" name="title" class="form-control" placeholder="Search by Title" value="{{ request('title') }}">
                    </div>



                    <!-- Filter by Date -->
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Select Date">
                    </div>

                    <button type="submit" class="btn btn-primary ml-3">Apply Filters</button>
                    <a href="{{ route('admin.pages.pagespamcomment') }}" class="btn btn-secondary ml-1">Reset</a>
                </div>
            </form>



            <div class="card-body">
                @if ($spamComments->count() > 0)
                <table class="table" id="pagespam">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Page Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($spamComments as $spam)
                        <tr>
                            <td>{{ $spam->id }}</td>
                            <td>{{ $spam->page->title }}</td>
                            <td>{{ $spam->user ? $spam->user->name : 'Guest' }}</td>
                            <td>{{ $spam->comment }}</td>
                            <td>{{ $spam->created_at->format('d M Y') }}</td>

                            <td>
                                <form action="{{ route('admin.page.comments.unspam', $spam->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Restore this comment?');">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.page.comments.deleteSpam', $spam->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this spam comment?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <h3 class="text-center text-danger">No Spam Comments Found</h3>
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
        var table = $('#pagespam').DataTable({
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
