@extends('layouts.auth')

@section('title', 'Edit Post | Admin Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/auth/css/multi-dropdown.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
	<div class="content">
		<!-- Masked Input -->
		<div class="card card-default">
			<div class="card-header">
				<h2>Edit Post</h2>
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
                <form method="post" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Title -->
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control" placeholder="Title" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>Post Link (Slug)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" class="form-control" required>
                        <small class="text-muted">Example: <strong>yourdomain.com/post/example-post</strong></small>
                    </div>


                    <!-- Excerpt -->
                    <div class="form-group">
                        <label>Excerpt</label>
                        <textarea name="excerpt" class="form-control" cols="30" rows="3" style="resize:none" placeholder="Excerpt">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="myeditpost" name="description" class="form-control" cols="30" rows="3" style="resize:none" placeholder="Description">{{ old('description', $post->description) }}</textarea>
                    </div>

                    <!-- Publish Status -->
                    <div class="form-group mt-3">
                        <label>Publish Status</label>
                        <select name="status" class="form-control" id="publication_status">
                            <option value="" disabled>Choose Option</option>
                            <option value="0" {{ old('status', $post->status) == "0" ? 'selected' : '' }}>Draft</option>
                            <option value="1" {{ old('status', $post->status) == "1" ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ old('status', $post->status) == "scheduled" ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>

                    <!-- Publish Options (Hidden by Default) -->
                    <div class="form-group" id="publish_options" style="display: none;">
                        <label>Publish Options</label>
                        <select name="publish_type" class="form-control" id="publish_type">
                            <option value="immediate"
                                {{ old('publish_type', ($post->status == 1 && $post->published_at && $post->published_at <= now()) ? 'immediate' : 'scheduled') == 'immediate' ? 'selected' : '' }}>
                                Publish Immediately
                            </option>
                            <option value="scheduled"
                                {{ old('publish_type', ($post->status == 1 && $post->published_at && $post->published_at > now()) ? 'scheduled' : 'immediate') == 'scheduled' ? 'selected' : '' }}>
                                Schedule for Later
                            </option>
                        </select>
                    </div>

                    <!-- Scheduled Publish Date/Time -->
                    <div class="form-group" id="publish_datetime" style="display: none;">
                        <label>Publish Date & Time</label>
                        <input type="datetime-local" name="published_at" class="form-control"
                            value="{{ old('published_at', $post->published_at ? date('Y-m-d\TH:i', strtotime($post->published_at)) : '') }}">
                    </div>


                    <!-- Categories -->
                    <div class="form-group">
                        <label>Categories</label>
                        <select name="categories[]" class="form-control selectpicker" multiple data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tags -->
                    <div class="form-group">
                        <label>Tags</label>
                        <select name="tags[]" class="form-control selectpicker" multiple data-live-search="true">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" @if ($post->tags->contains('id', $tag->id)) selected @endif>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">Current Image</label>
                        @if(optional($post->gallery)->images->first())
                        <div>
                            <img src="{{ asset(optional($post->gallery)->images->first()->path) }}"
                                 alt="Current Image" style="max-width: 100px; height: auto;">
                        </div>
                    @else
                        <p>No image uploaded.</p>
                    @endif 
                        <input type="file" name="file" class="form-control" id="file">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            </div>

		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/auth/js/multi-dropdown.js') }}"></script>

<script>
    tinymce.init({
        selector: 'textarea#myeditpost',
        plugins: 'code table lists textcolor colorpicker image imagetools media',
        menubar: true,
        toolbar: 'undo redo | bold italic | forecolor backcolor | fontselect | fontsizeselect | alignleft aligncenter alignright | indent outdent | bullist numlist | image',

        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_url: '/upload-image',

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
    const publicationStatus = document.getElementById('publication_status');
    const publishOptions = document.getElementById('publish_options');
    const publishType = document.getElementById('publish_type');
    const publishDateTime = document.getElementById('publish_datetime');

    function togglePublishFields() {
        if (publicationStatus.value == "1") { // If Published
            publishOptions.style.display = "block";
            publishType.value = "immediate";
            publishType.dispatchEvent(new Event('change')); // Ensure UI updates
            publishDateTime.style.display = "none";
        } else if (publicationStatus.value == "scheduled") { // If Scheduled
            publishOptions.style.display = "block";
            publishType.value = "scheduled";
            publishDateTime.style.display = "block";
        } else { // If Draft
            publishOptions.style.display = "none";
            publishDateTime.style.display = "none";
        }
    }

    // Add event listeners
    publicationStatus.addEventListener('change', togglePublishFields);
    publishType.addEventListener('change', function () {
        publishDateTime.style.display = publishType.value === "scheduled" ? "block" : "none";
    });

    togglePublishFields(); // Initialize on page load
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
    document.getElementById('title').addEventListener('keyup', function() {
    let slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    document.getElementById('slug').value = slug;
});

</script>

@endsection
