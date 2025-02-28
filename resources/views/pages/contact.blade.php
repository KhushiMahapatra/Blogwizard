@extends('layouts.site')

@section('title', 'Contact')

@section('content')

<!-- Page Title -->
<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Blogwizard</span>
                    <h1 class="text-capitalize mb-2 text-lg">Contact Us</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Blogwizard</a></li>
                        <li class="list-inline-item"><span class="text-white">/</span></li>
                        <li class="list-inline-item text-white-50">Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Display success message -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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

<!-- Contact Form Section -->
<section class="contact-form-wrap section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <form id="contact-form" class="contact__form" method="post" action="{{ route('pages.contact.submit') }}">
                    @csrf <!-- CSRF token for security -->
                    <h3 class="text-md mb-4">Contact Form</h3>
                    <div class="form-group">
                        <input name="name" type="text" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="form-group-2 mb-4">
                        <textarea name="message" class="form-control" rows="4" placeholder="Your Message" required></textarea>
                    </div>
                    <button class="btn btn-main" name="submit" type="submit">Send Message</button>
                </form>
            </div>

            <!-- Contact Information Section -->
            <div class="col-lg-5 col-sm-12">
                <div class="contact-content pl-lg-5 mt-5 mt-lg-0">
                    <span class="text-muted">We are Professionals</span>
                    <h2 class="mb-5 mt-2">Don’t Hesitate to Contact Us for Any Kind of Information</h2>

                    <ul class="address-block list-unstyled">
                        <li>
                            <i class="ti-direction mr-3"></i>
                            {{ $contact->address ?? 'Address not available' }}
                        </li>
                        <li>
                            <i class="ti-email mr-3"></i>
                            Email: {{ $contact->email ?? 'Email not available' }}
                        </li>
                        <li>
                            <i class="ti-mobile mr-3"></i>
                            Phone: {{ $contact->phone ?? 'Phone number not available' }}
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
