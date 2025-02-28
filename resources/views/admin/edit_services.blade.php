@extends('layouts.auth')

@section('title', 'Edit Services')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif



    <!-- Edit Existing Services -->
    <div class="card p-4">
        <h3 class="mb-3">Edit Services</h3>
        <div class="row" style="display: block">
            @foreach($services as $service)

                <!-- Update Form -->
                <form action="{{ route('admin.services.update') }}" method="POST" onclick="tinyMCE.triggerSave(true,true);">
                    @csrf

                    <div class="form-group">
                        <label for="description-{{ $service->id }}">Description</label>
                        <textarea class="myeditorinstance form-control" id="myeditpage" name="services[{{ $service->id }}][description]" required>{{ old('services.' . $service->id . '.description', $service->description) }}</textarea>
                    </div>

                    <!-- Update Button -->
                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </form>

            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TinyMCE for all textareas with the class 'myeditorinstance'

    });
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
