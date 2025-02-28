@extends('layouts.site')

@section('title', 'Terms & Conditions')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/site/css/term.css') }}">
@endsection

@section('content')
<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Blogwizard</span>
                    <h1 class="text-capitalize mb-2 text-lg">Terms & Conditions</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Blogwizard</a></li>
                        <li class="list-inline-item"><span class="text-white">/</span></li>
                        <li class="list-inline-item text-white-50">Terms & Conditions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<main>
        <div class="card p-4">
            {!! str_replace(['{', '}'], '', $term->content) !!}
        </div>

</main>

@endsection

@section('scripts')
@endsection
