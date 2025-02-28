@extends('layouts.auth')

@section('content')

<div class="card card-default ml-3 mr-3 mt-5">
    <div class="container ">
        <h1 class="mt-5 mb-5 ">About Us</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.about.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="myeditpage" class="form-control">{{ $about->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Update</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    tinymce.init({
        selector: 'textarea#myeditpage',
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
