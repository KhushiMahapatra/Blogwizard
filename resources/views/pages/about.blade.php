@extends('layouts.site')

@section('title', 'About')

@section('styles')

@endsection

@section('content')
<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Blogwizard</span>
                    <h1 class="text-capitalize mb-2 text-lg">About Us</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Blogwizard</a></li>
                        <li class="list-inline-item"><span class="text-white">/</span></li>
                        <li class="list-inline-item text-white-50">About Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section About Start -->
<section class="section about-2 position-relative">
    <div class="container">
                <div class="about-item pr-3 mb-5 mb-lg-0">
                    <p class="mb-5"> {!! str_replace(['{', '}'], '', $about->description) !!}
                    </p>
                </div>
    </div>
</section>



@endsection

@section('scripts')

@endsection
