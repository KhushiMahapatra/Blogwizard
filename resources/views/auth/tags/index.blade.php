@extends('layouts.auth')

@section('title', 'Tags')

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
</style>
@endsection

@section('content')

<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Tags</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addTagModal">
                     Add Tag
                </button>
            </div>

            <div class="card-body">
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

                @if (count($tags) > 0)
                <table class="table" id="tags">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ Str::limit($tag->description, 50) }}</td>
                            <td>
                                <button class="btn btn-custom btn-sm" data-toggle="modal" data-target="#editTagModal" data-id="{{ $tag->id }}" data-name="{{ $tag->name }}" data-description="{{ $tag->description }}" style="background-color: #7b58bd; color: white; float:right">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('tags.delete', $tag->id) }}" method="POST" style="display:inline-block; float:right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mr-1" onclick="return confirm('Are you sure you want to delete this tag?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h3 class="text-center text-danger">No Tags Found</h3>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Tag Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTagModalLabel">Add New Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tags.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tagName">Tag Name</label>
                        <input type="text" class="form-control" id="tagName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="tagDescription">Description</label>
                        <textarea class="form-control" id="tagDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Tag Modal -->
<div class="modal fade" id="editTagModal" tabindex="-1" role="dialog" aria-labelledby="editTagModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTagModalLabel">Edit Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTagForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTagName">Tag Name</label>
                        <input type="text" class="form-control" id="editTagName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editTagDescription">Description</label>
                        <textarea class="form-control" id="editTagDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#tags').DataTable({
            "bLengthChange": false,
        });

        // Handle edit button click
        $('#editTagModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var tagId = button.data('id'); // Extract info from data-* attributes
            var tagName = button.data('name');
            var tagDescription = button.data('description');

            // Update the modal's content
            var modal = $(this);
            modal.find('#editTagName').val(tagName); // Set the current tag name
            modal.find('#editTagDescription').val(tagDescription); // Set the current tag description
            modal.find('#editTagForm').attr('action', '/tags/' + tagId); // Set the action URL
        });
    });
</script>
@endsection
