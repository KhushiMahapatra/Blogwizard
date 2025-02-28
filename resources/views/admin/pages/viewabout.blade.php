@extends('layouts.auth')

@section('title', 'About Us')

@section('content')

<div class="card card-default mt-5 ml-3 mr-3">
    <!-- Page Content -->
    <section class="section about-2 position-relative">
        <div class="container">
            <div class="about-item pr-3 mb-5 mb-lg-0">
                <span class="h6 text-color">What we are</span>
                <h2 class="mt-3 mb-4 position-relative content-title">We are a dynamic team of creative people</h2>
                <p class="mb-5"> {!! str_replace(['{', '}'], '', $about->description) !!} </p>
            </div>
        </div>
    </section>
   
</div>


@endsection
