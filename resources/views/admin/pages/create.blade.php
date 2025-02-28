@extends('layouts.auth')

@section('title', 'Add Page')

@section('content')


<div class="card card-default mt-5 ml-3 mr-3">
    <div class="container mt-4">
        <h2>Add New Page</h2>

        <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" onclick="tinyMCE.triggerSave(true,true);">
            @csrf

            <!-- Title -->
            <div class="form-group mt-3">
                <label>Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <!-- Slug (Editable Page Link) -->
            <div class="form-group mt-3">
                <label>Link <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control" required placeholder="example-page">
                <small class="text-muted">This will be used in the page URL. Example: <strong>yourdomain.com/page/example-page</strong></small>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label>Description <span class="text-danger">*</span></label>
                <textarea class="form-control mypage" name="description" required></textarea>
            </div>

            <!-- Publish Status -->
            <div class="form-group mt-3">
                <label>Publish Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" id="publish_status">
                    <option value="draft">Draft</option>
                    <option value="published">Publish Immediately</option>
                    <option value="scheduled">Schedule Publish</option>
                </select>
            </div>

            <!-- Publish Date -->
            <div class="form-group mt-3" id="publish_date_group" style="display: none;">
                <label>Publish Date & Time</label>
                <input type="datetime-local" name="published_at" class="form-control">
            </div>

            <button type="submit" class="btn btn-success mb-3">Save</button>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

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
    document.getElementById("publish_status").addEventListener("change", function () {
        if (this.value === "scheduled") {
            document.getElementById("publish_date_group").style.display = "block";
        } else {
            document.getElementById("publish_date_group").style.display = "none";
        }
    });
</script>

<script>
    document.getElementById("title").addEventListener("input", function () {
        let slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-'); // Remove multiple hyphens

        checkSlugAvailability(slug); // Call function to check if slug exists
    });

    function checkSlugAvailability(slug) {
        fetch(`/check-slug?slug=${slug}`) // Send request to backend
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    let count = 1;
                    let newSlug = slug;
                    
                    function checkNextSlug() {
                        fetch(`/check-slug?slug=${newSlug}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.exists) {
                                    count++;
                                    newSlug = slug + '-' + count;
                                    checkNextSlug(); // Recursively check next slug
                                } else {
                                    document.getElementById("slug").value = newSlug; // Set unique slug
                                }
                            });
                    }

                    checkNextSlug();
                } else {
                    document.getElementById("slug").value = slug;
                }
            });
    }
</script>

</script>

@endsection
