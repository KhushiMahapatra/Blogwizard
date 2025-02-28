@extends('layouts.auth')

@section('title', 'Services')

@section('content')

<div class="card card-default mt-5 ml-3 mr-3">

<section class="container mt-5">

    <div class="row" style="display: block">
        @foreach($services as $service)

            <div class="service-item mb-4 ml-7 mr-5">
                <p>{!! str_replace(['{', '}'], '', $service->description) !!}</p>
            </div>

        @endforeach
    </div>
</section>
</div>


@endsection
