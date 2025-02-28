@extends('layouts.auth')

@section('title', 'Edit Contact Info')

@section('content')


<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="container mt-5 mb-5">
                <h2 class="mb-3">Edit Contact Information</h2>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.contact.update') }}">
                    @csrf
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{ $contact->address ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $contact->email ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $contact->phone ?? '' }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
