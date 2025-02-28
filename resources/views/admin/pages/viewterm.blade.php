@extends('layouts.auth')

@section('title', 'Terms & Conditions')

@section('content')

<div class="card card-default mt-5 ml-3 mr-3">

    <div class="card p-4">
        {!! str_replace(['{', '}'], '', $term->content) !!}
    </div>
</div>


@endsection
