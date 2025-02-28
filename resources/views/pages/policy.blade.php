@extends('layouts.site')

@section('title', 'Privacy Policy')

@section('content')
<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Blogwizard</span>
                    <h1 class="text-capitalize mb-2 text-lg">Privacy Policy</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="list-inline-item"><span class="text-white">/</span></li>
                        <li class="list-inline-item text-white-50">Privacy Policy</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<main>
    <div class="container mt-4">
        <div class="card p-4">
            {!! str_replace(['{', '}'], '', $policy->content) !!}

        </div>
    </div>

    <div class="container mt-5">
        <div class="container">
            <div class="cta-block p-5 rounded">
                <div class="row justify-content-center align-items-center ">
                    <div class="col-lg-7 text-center text-lg-left">
                        <span class="text-color">For Every type business</span>
                        <h2 class="mt-2 text-white">Entrust Your Project to Our Best Team of Professionals</h2>
                    </div>
                    <div class="col-lg-4 text-center text-lg-right mt-4 mt-lg-0">
                        <a href="{{ route('pages.contact') }}" class="btn btn-main btn-round-full">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
