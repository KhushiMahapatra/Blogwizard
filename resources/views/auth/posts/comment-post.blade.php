@extends('layouts.auth')

@section('title', 'Comments for ' . $post->title)

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/auth/css/multi-dropdown.css') }}">
@endsection

@section('content')

<div class="card card-default ml-3 mr-3 mt-3 mb-3">
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <h1>Comments of : {{ $post->title }}</h1>

                {{-- Display Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Display Comments --}}
                @if($comments->isEmpty())
                    <p>No comments yet. Be the first to comment!</p>
                @else
                    <ul class="list-group mt-3">
                        @foreach($comments as $comment)
                            @if ($comment->approved)
                                <li class="list-group-item">
                                    <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                                    <span class="text-muted float-right">{{ $comment->created_at->diffForHumans() }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/auth/js/multi-dropdown.js') }}"></script>
@endsection
