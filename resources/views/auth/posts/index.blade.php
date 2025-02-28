@extends('layouts.auth')

@section('title', 'Posts')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"/>
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" /><style>
    #outer {
        text-align: center;
    }
    .inner {
        display: inline-block;
    }
    .filter-dropdown {
        display: inline-block;
        margin-left: 10px;
    }
    .image-container{
        width: 100%;
    height: 100%;
    overflow: hidden;
    position: relative;
}

.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
@endsection

@section('content')

<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header">
                <h2>Posts</h2>
                <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3 " style="float: right;">Add Post</a>

            </div>

            @if (Session::has('alert-success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong> {{ Session::get('alert-success') }}
            </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-body" style="width: 1050px">
                @if (count($posts) > 0)
                <form method="GET" action="{{ route('posts.index') }}">
                    <div class="row ml-5">
                        <!-- Title Filter -->
                        <div class="col-md-2">
                            <input type="text" id="titleFilter" name="search" class="form-control" placeholder="Filter by title" value="{{ request('search') }}">
                        </div>

                        <!-- Category Filter -->
                        <div class="col-md-2">
                            <select id="categoryFilter" name="category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tag Filter -->
                        <div class="col-md-2">
                            <select id="tagFilter" name="tag" class="form-control">
                                <option value="">All Tags</option>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- User Filter -->
                        <div class="col-md-2">
                            <select id="usernameFilter" name="user" class="form-control">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-2">
                            <select id="statusFilter" name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Add this inside your existing form, after the Status Filter -->
                        <div class="col-md-3 mt-2">
                            <input type="date" id="dateFilter" name="date" class="form-control" value="{{ request('date') }}">
                        </div>

                        <!-- Submit & Reset -->
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary mt-2" >Apply Filters</button>
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary  mt-2">Reset</a>
                        </div>
                    </div>
                </form>
                <table class="table" id="post">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Details</th>
                            <th scope="col">Categories</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Users</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr>
                            <td >
                                <div class="image-container">
                                    @if($post->gallery)
                                    @foreach($post->gallery->images as $image)
                                        @if($image->size === 'small')
                                            <img src="{{ asset($image->path) }}" alt="Image" >
                                        @endif
                                    @endforeach
                                @else
                                    <img src="{{ asset('default-image.jpg') }}" style="width: 80px; height: 60px" alt="default image">
                                @endif
                                </div>

                            </td>
                            <td>{{ Str::limit($post->title, 10) }}</td>
                            <td>{!! Str::limit($post->description, 15) !!}</td>
                            <td>
                                @if($post->categories->isNotEmpty())
                                    @foreach($post->categories->take(3) as $category) <!-- Limit to 3 categories -->
                                        <span class="badge badge-primary">{{ $category->name }}</span>
                                    @endforeach
                                    @if($post->categories->count() > 3) <!-- Check if there are more than 3 categories -->
                                        <span class="badge badge-light">+{{ $post->categories->count() - 3 }} more</span>
                                    @endif
                                @else
                                    <span>No Categories</span>
                                @endif
                            </td>
                            <td>
                                @if($post->tags->isNotEmpty())
                                    @foreach($post->tags->take(3) as $tag) <!-- Limit to 3 tags -->
                                        <span class="badge badge-secondary">{{ $tag->name }}</span>
                                    @endforeach
                                    @if($post->tags->count() > 3) <!-- Check if there are more than 3 tags -->
                                        <span class="badge badge-light">+{{ $post->tags->count() - 3 }} more</span>
                                    @endif
                                @else
                                    <span>No Tags</span>
                                @endif
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                @if($post->status == 0)
                                    <span class="badge badge-warning">Draft</span>
                                @elseif($post->status == 1 && $post->published_at && $post->published_at > now())
                                    <span class="badge badge-info">Scheduled</span>
                                @elseif($post->status == 1)
                                    <span class="badge badge-success">Published</span>
                                @endif
                            </td>
                            <td>{{ date('d M Y', strtotime($post->created_at)) }}</td>
                            <td id="outer">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-success inner"><i class="fas fa-eye"></i></a>
                                <br>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-info inner mt-1"><i class="fas fa-edit"></i></a>
                                <br>
                                <form method="post" action="{{ route('posts.destroy', $post->id) }}" class="inner" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mt-1"><i class="fas fa-trash"></i></button>
                                </form>
                                <a class="btn btn-sm btn-primary mt-1 ml-2 mb-1" href="{{ route('posts.comments', $post->id) }}">
                                    <i class="fas fa-comments"></i> {{ $post->comments->where('approved', true)->count() }}
                                </a>
                                <form action="{{ route('posts.toggleComments', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $post->disable_comments ? 'btn-secondary' : 'btn-warning' }}">
                                        <i class="fas {{ $post->disable_comments ? 'fa-unlock' : 'fa-lock' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h3 class="text-center text-danger">No Post Found</h3>
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
        var table = $('#post').DataTable({
            "bLengthChange": false,
            "pageLength": 10, // Set the number of posts to display per page
            "paging": true, // Enable pagination
            "info": true, // Show info about the current page
            "searching": true // Enable searching
        });

        // Title Filter
        $('#titleFilter').on('keyup', function() {
            table.column(1).search(this.value).draw();
        });

        // Category Filter
        $('#categoryFilter').on('change', function() {
            let selectedCategory = $(this).val();
            table.column(3).search(selectedCategory ? '^' + selectedCategory + '$' : '', true, false).draw();
        });

        // Tag Filter
        $('#tagFilter').on('change', function() {
            let selectedTag = $(this).val();
            table.column(4).search(selectedTag ? '^' + selectedTag + '$' : '', true, false).draw();
        });

        // User Filter
        $('#usernameFilter').on('change', function() {
            let selectedUser     = $(this).val();
            table.column(4).search(selectedUser     ? '^' + selectedUser     + '$' : '', true, false).draw();
        });

        // Status Filter
        $('#statusFilter').on('change', function() {
            let selectedStatus = $(this).val();
            if (selectedStatus) {
                table.column(5).search(selectedStatus, true, false).draw();
            } else {
                table.column(5).search('').draw();
            }
        });
        // Date Filter
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedDate = $('#dateFilter').val();
                var postDate = new Date(data[6]); // Assuming the date is in the 7th column (index 6)

                if (selectedDate === "") {
                    return true; // If no date is selected, show all posts
                }

                // Compare the selected date with the post date
                return postDate.toISOString().split('T')[0] === selectedDate;
            }
        );

        // Event listener to the date filter input
        $('#dateFilter').change(function() {
            table.draw();
        });
    });
</script>

@endsection
