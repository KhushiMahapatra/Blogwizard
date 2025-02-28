@extends('layouts.auth')

@section('title', 'Spam Comments')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
@endsection


@section('content')
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
<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header">
                <h2>Spam Comments</h2>
                <a href="{{ route('comments.index') }}" class="btn btn-secondary ml-1 mt-2">Back To Post comments</a>



            </div>

             <!-- Filter Form -->
            <form method="GET" action="{{ route('comments.spam.index') }}" class="mb-4">
                <div class="row ml-3">
                    <!-- Filter by Title -->
                    <div class="col-md-2">
                        <input type="text" name="title" class="form-control" placeholder="Search by Title" value="{{ request('title') }}">
                    </div>

                    <!-- Filter by Author -->
                    <div class="col-md-3">
                        <select name="author" class="form-control">
                            <option value="">Filter by Author</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Filter by Date -->
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Select Date">
                    </div>

                    <button type="submit" class="btn btn-primary  ml-3">Apply Filters</button>
                    <a href="{{ route('comments.spam.index') }}" class="btn btn-secondary ml-1">Reset</a>
                </div>
            </form>

            <div class="card-body">
                @if (count($spamComments) > 0)
                <table class="table" id="postspam">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Post Title</th>
                            <th scope="col">Author</th>
                            <th scope="col" >Comment</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($spamComments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->post->title }}</td>
                            <td>{{ $comment->user ? $comment->user->name : 'Guest' }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ date('d M Y', strtotime($comment->created_at)) }}</td>
                            <td>
                                <form action="{{ route('comments.unmarkSpam', $comment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to unmark this comment as spam?');">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                <form action="{{ route('comments.spam.delete', $comment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</button>
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

<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function(){
          // Initialize DataTable with pagination to show 10 posts
          var table = $('#postspam').DataTable({
              "bLengthChange": false,
              "pageLength": 10, // Set the number of posts to display per page
              "paging": true, // Enable pagination
              "info": true, // Show info about the current page
              "searching": true // Enable searching
          });


      });
  </script>

@endsection
