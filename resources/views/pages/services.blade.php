@extends('layouts.site')

@section('title', 'Services')

@section('content')

<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Blogwizard</span>
                    <h1 class="text-capitalize mb-2 text-lg">Services</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="list-inline-item"><span class="text-white">/</span></li>
                        <li class="list-inline-item text-white-50">Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mt-5">
    <div class="row">
        <div class="card p-4">
            @foreach($services as $service)
                <p>{!! str_replace(['{', '}'], '', $service->description) !!}</p>
        @endforeach
        </div>

    </div>
</section>

@endsection
