@extends('layouts.auth')

@section('title', 'Edit Page')

@section('content')

<div class="card card-default mt-5 ml-3 mr-3">
    <div class="container mt-4">
        <h2>Edit Page</h2>
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title Field -->
            <div class="form-group mb-2 mt-2">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
            </div>


            <div class="form-group mt-3">
                <label>Page Link (Slug) <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $page->slug) }}" required>
            </div>

            <!-- Description Field -->
            <div class="form-group">
                <label>Description</label>
                <textarea  name="description" class="form-control mypage" required>
                    {{ $page->description }}</textarea>
            </div>

            <!-- Publish Status -->
            <div class="form-group mt-3">
                <label>Publish Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" id="publish_status">
                    <option value="draft" {{ $page->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $page->status == 'published' ? 'selected' : '' }}>Publish Immediately</option>
                    <option value="scheduled" {{ $page->status == 'scheduled' ? 'selected' : '' }}>Schedule Publish</option>
                </select>
            </div>

            <!-- Publish Date & Time (Only Show If Scheduled) -->
            <div class="form-group mt-3" id="publish_date_group" style="display: {{ $page->status == 'scheduled' ? 'block' : 'none' }};">
                <label>Publish Date & Time</label>
                <input type="datetime-local" name="published_at" class="form-control"
                       value="{{ $page->published_at ? date('Y-m-d\TH:i', strtotime($page->published_at)) : '' }}">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success mb-2">Update</button>
        </form>

    </div>
</div>


@endsection

@section('scripts')

<script>
tinymce.init({
    selector: 'textarea.mypage',
    plugins: 'code table lists textcolor colorpicker image imagetools media',
    menubar: true,
    toolbar: 'undo redo | bold italic | forecolor backcolor | fontselect | fontsizeselect | alignleft aligncenter alignright | indent outdent | bullist numlist | image',

    automatic_uploads: true,
    file_picker_types: 'image',
    images_upload_url: '/upload-image', // Backend route for image upload

    // Custom file picker for images
    file_picker_callback: function(callback, value, meta) {
        let input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function() {
            let file = this.files[0];

            let formData = new FormData();
            formData.append('file', file);

            fetch('/upload-image', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.location) {
                    callback(data.location); // Insert image URL into TinyMCE editor
                } else {
                    alert('Image upload failed: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error uploading image: ' + error.message);
            });
        };

        input.click();
    },

    images_upload_handler: function(blobInfo, success, failure) {
        let formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        fetch('/upload-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.location) {
                success(data.location);
            } else {
                failure('Image upload failed: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            failure('Error: ' + error.message);
        });
    }
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusSelect = document.getElementById("publish_status");
        const publishDateGroup = document.getElementById("publish_date_group");

        function togglePublishDateField() {
            if (statusSelect.value === "scheduled") {
                publishDateGroup.style.display = "block";
            } else {
                publishDateGroup.style.display = "none";
            }
        }

        statusSelect.addEventListener("change", togglePublishDateField);
        togglePublishDateField(); // Ensure correct visibility on page load
    });
    </script>

@endsection
