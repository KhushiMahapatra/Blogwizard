@extends('layouts.auth')

@section('title', 'Pages')

@section('content')

<div class="card card-default mt-5 ml-3 mr-3">
    <!-- Page Content -->
<section class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="page-content mb-5">
                <h2>{{ $page->title }}</h2>
                <p class="mt-5 ">{!! str_replace(['{', '}'], '', $page->description) !!}</p>
            </div>
        </div>
    </div>
</section>
</div>


@endsection
