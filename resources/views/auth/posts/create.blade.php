@extends('layouts.auth')

@section('title', 'Create Post | Admin Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/auth/css/multi-dropdown.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header">
                <h2>Create Post</h2>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data" onclick="tinyMCE.triggerSave(true,true);">
                    @csrf
                    <div class="form-group">
                        <label>Title<span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ request()->input('title') }}" class="form-control" placeholder="Title" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>Link(Slug)<span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control" placeholder="example-post" required>
                        <small class="text-muted">This will be used in the post URL. Example: <strong>yourdomain.com/post/example-post</strong></small>
                    </div>


                    <div class="form-group">
                        <label>Excerpt<span class="text-danger">*</span></label>
                        <textarea name="excerpt" class="form-control" cols="30" rows="3" style="resize:none" placeholder="Excerpt">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Description<span class="text-danger">*</span></label>
                        <textarea name="description" id="mypost" class="form-control" cols="30" rows="3" style="resize:none" placeholder="Description">{{ request()->old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Publication Status<span class="text-danger">*</span></label>
                        <select name="status" class="form-control" id="publication_status">
                            <option value="" disabled {{ request()->old('status') === null ? 'selected' : '' }}>Choose Option</option>
                            <option value="0" {{ request()->old('status') == "0" ? 'selected' : '' }}>Draft</option>
                            <option value="1" {{ request()->old('status') == "1" ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <!-- Publish Options (Hidden by Default) -->
                    <div class="form-group" id="publish_options" style="display: none;">
                        <label>Publish Options</label>
                        <select name="publish_type" class="form-control" id="publish_type">
                            <option value="immediate" selected>Publish Immediately</option>
                            <option value="scheduled">Schedule for Later</option>
                        </select>
                    </div>

                    <!-- Scheduled Publish Date/Time -->
                    <div class="form-group" id="publish_datetime" style="display: none;">
                        <label>Publish Date & Time</label>
                        <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at') }}">
                    </div>

                    <div class="form-group">
                        <label>Categories<span class="text-danger">*</span></label>
                        <select name="categories[]" class="form-control selectpicker" multiple data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, request()->old('categories', [])) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tags<span class="text-danger">*</span></label>
                        <select name="tags[]" class="form-control selectpicker" multiple data-live-search="true">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, request()->old('tags', [])) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label>Image<span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" autocomplete="off">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/auth/js/multi-dropdown.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const publicationStatus = document.getElementById('publication_status');
        const publishOptions = document.getElementById('publish_options');
        const publishType = document.getElementById('publish_type');
        const publishDateTime = document.getElementById('publish_datetime');

        function togglePublishOptions() {
            if (publicationStatus.value == "1") {
                publishOptions.style.display = "block";
                if (publishType.value === "scheduled") {
                    publishDateTime.style.display = "block";
                } else {
                    publishDateTime.style.display = "none";
                }
            } else {
                publishOptions.style.display = "none";
                publishDateTime.style.display = "none";
            }
        }

        publicationStatus.addEventListener('change', togglePublishOptions);
        publishType.addEventListener('change', togglePublishOptions);

        togglePublishOptions(); // Initialize on page load
    });


</script>

<script>
    document.getElementById("title").addEventListener("input", function () {
        let slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-'); // Remove multiple hyphens

        document.getElementById("slug").value = slug;
    });
    </script>


<script>
    tinymce.init({
        selector: 'textarea#mypost',
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


@endsection
