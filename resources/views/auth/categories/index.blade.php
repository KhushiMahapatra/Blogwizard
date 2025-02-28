@extends('layouts.auth')

@section('title', 'Categories')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"/>
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
            @if(session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Categories</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                   Add Category
                </button>
            </div>

            <div class="card-body">
                @if (count($categories) > 0)
                <table class="table" id="categories">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Parent Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if ($category->parent_id)
                                        {{ $category->parent->name }} <!-- Display Parent Category Name -->
                                    @else
                                        N/A <!-- If no parent category -->
                                    @endif
                                </td>
                                <td>{{ Str::limit($category->description, 50) }}</td> <!-- Display Description -->
                                <td>
                                    <button class="btn btn-custom btn-sm" data-toggle="modal" data-target="#editCategoryModal"
                                            data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-description="{{ $category->description }}"         data-parent-id="{{ $category->parent_id }}"
                                            style="background-color: #8561b4;color: white;float:right">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;float:right">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mr-1" onclick="return confirm('Are you sure you want to delete this category?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h3 class="text-center text-danger">No categories found</h3>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="categoryDescription">Description</label>
                        <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="parentCategory">Parent Category</label>
                        <select class="form-control" id="parentCategory" name="parent_id">
                            <option value="">Select Parent Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editCategoryName">Category Name</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editCategoryDescription">Description</label>
                        <textarea class="form-control" id="editCategoryDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editParentCategory">Parent Category</label>
                        <select class="form-control" id="editParentCategory" name="parent_id">
                            <option value="">Select Parent Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function(){
        // Initialize DataTable
        $('#categories').DataTable({
            "bLengthChange": false
        });

        // Handle edit button click
        $('#editCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var name = button.data('name');
            var description = button.data('description'); // Get the description
            var parentId = button.data('parent-id'); // Get the parent_id

            // Update the modal's content
            var modal = $(this);
            modal.find('.modal-body #editCategoryName').val(name);
            modal.find('.modal-body #editCategoryDescription').val(description); // Set the current description
            modal.find('form').attr('action', '/categories/' + id); // Set the form action to the edit route

            // Set the selected parent category
            modal.find('.modal-body #editParentCategory').val(parentId); // Set the selected parent category
        });
    });
</script>

@endsection
