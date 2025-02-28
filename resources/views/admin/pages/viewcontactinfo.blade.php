@extends('layouts.auth')

@section('title', 'Contact Info')
@section('content')

<div class="card card-default mt-5 ml-3 mr-3">

    <div class="col-lg-5 col-sm-12 mt-5 mb-5">
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


@endsection


