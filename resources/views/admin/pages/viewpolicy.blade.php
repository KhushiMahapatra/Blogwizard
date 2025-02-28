@extends('layouts.auth')

@section('title', 'Privacy Policy')
@section('content')

<div class="card card-default mt-5 ml-3 mr-3">

    <div class="container mt-4 mb-4">
        <div class="card p-4">
            {!! str_replace(['{', '}'], '', $policy->content) !!}

        </div>
    </div>

</div>


@endsection


