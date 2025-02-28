@extends('layouts.auth')

@section('title', 'Comments Page')

@section('content')

<div class="card card-default mt-5 ml-3 mr-3">
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <h1>Comments for: {{ $page->title }}</h1>

                {{-- Display Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Display Comments --}}
                @if($comments->isEmpty())
                    <p>No comments yet!</p>
                @else
                    <ul class="list-group mt-3">
                        @foreach($comments as $comment)
                            @if ($comment->approved)
                                <li class="list-group-item">
                                    <strong>
                                        {{ $comment->user ? $comment->user->name : 'Guest' }}:
                                    </strong>
                                    {{ $comment->comment }}
                                    <span class="text-muted float-right">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary mt-3">Back to Pages</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection
