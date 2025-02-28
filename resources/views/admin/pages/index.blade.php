@extends('layouts.auth')

@section('title', 'Pages')

@section('styles')
<style>
    .images img{
        width: 50px;
        height: 50px;
        object-fit: fill;
    }
</style>
@endsection

@section('content')

<div class="card card-default mt-5 ml-3 mr-3">
    <div class="container mt-4 mb-3">
        <h2 class="mb-3">Pages
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary mb-3 " style="float: right;">Add New Page</a>
        </h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Filter Inputs -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="titleFilter" class="form-control" placeholder="Filter by Title">
            </div>
            <div class="col-md-4">
                <input type="text" id="dateFilter" class="form-control datepicker" placeholder="Filter by Date">
            </div>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Reset</a>

        </div>

        <table class="table" id="page">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                   <td class="images">{!! $page->description !!}</td>

                    <td>{{ date('d M Y', strtotime($page->created_at)) }}</td>
                    <td>
                        @if($page->status == 'draft')
                            <span class="badge badge-warning">Draft</span>
                        @elseif($page->status == 'scheduled')
                            <span class="badge badge-info">Scheduled</span>
                        @elseif($page->status == 'published')
                            <span class="badge badge-success">Published</span>
                        @endif

                    </td>
                    <td>
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-info inner ml-1" style=" float:right"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.pages.show', $page->id) }}" class="btn btn-sm btn-success inner ml-1"  style=" float:right"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.pages.delete', $page->id) }}" method="POST" style="display:inline;float:right" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @if ($page->comments_enabled)
                        <form action="{{ route('admin.page.comments.disable', $page->id) }}" method="POST" style="display:inline-block;float:right">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning btn-sm mr-1 ml-1 mt-1"><i class="fas fa-lock"></i></button>
                        </form>
                    @else
                        <form action="{{ route('admin.page.comments.enable', $page->id) }}" method="POST" style="display:inline-block;float:right">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary btn-sm mr-1 ml-1 mt-1"><i class="fas fa-unlock"></i></button>
                        </form>
                    @endif

                    <a class="btn btn-sm btn-primary mt-1 mb-1" href="{{ route('admin.pages.comment-page', $page->id) }}" style=" float:right">
                        <i class="fas fa-comments"></i> {{ $page->comments->where('approved', true)->count() }}
                    </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $pages->links() }}
    </div>
</div>

@endsection

@section('scripts')

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Datepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var table = $('#page').DataTable({
            "bLengthChange": false,
        });

        // Title filter
        $('#titleFilter').on('keyup', function() {
            table.column(1).search(this.value).draw();
        });

        // Date filter with datepicker
        $('.datepicker').datepicker({
            format: 'dd M yyyy',
            autoclose: true
        }).on('changeDate', function() {
            var dateValue = $(this).val();
            table.column(3).search(dateValue).draw();
        });
    });
</script>
@endsection
