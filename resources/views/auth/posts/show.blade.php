@extends('layouts.auth')

@section('title', 'View Post')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"/>
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />

@endsection

@section('content')

<div class="content-wrapper">
	<div class="content">
		<!-- Masked Input -->
		<div class="card card-default">
			<div class="card-header">
				<h2>View Post</h2>
			</div>


            <div class="card-body">

                @if ($post)
                <table class="table" id="posts">
                    <tbody>
                      <tr>
                        <th scope="col">Title</th>
                        <td>{{ $post->title }}</td>
                      </tr>
                      <tr>
                        <th scope="col">Image</th>
                        <td>
                            @if($post->gallery && $post->gallery->images->isNotEmpty()) <!-- Check if the gallery exists and has images -->
                                <img src="{{ asset($post->gallery->images->first()->path) }}" alt="post image">
                            @else
                                <img src="{{ asset('default-image.jpg') }}" style="width: 80px; height: 60px;" alt="default image">
                            @endif
                        </td>
                    </tr>

                      <tr>
                        <th scope="col">Description</th>
                        <td>{!! str_replace(['{', '}'], '', $post->description) !!}</td>
                      </tr>
                      <tr>
                        <th scope="col">Excerpt</th>
                        <td>{{ $post->excerpt }}</td> <!-- Display the excerpt with a limit -->
                      </tr>

                  <tr>
                    <th scope="col">Categories</th>
                    <td>
                        @if($post->categories->isNotEmpty())
                            @foreach($post->categories as $category)
                                <span class="badge badge-info">{{ $category->name }}</span>
                            @endforeach
                        @else
                            <span>No Categories</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th scope="col">Tags</th>
                    <td>
                        @if($post->tags->isNotEmpty())
                            @foreach($post->tags as $tag)
                                <span class="badge badge-secondary">{{ $tag->name }}</span>
                            @endforeach
                        @else
                            <span>No Tags</span>
                        @endif
                    </td>
                </tr>

                      <tr>
                        <th scope="col">User</th>
                        <td>{{ $post->user->name }}</td>
                      </tr>

                      <tr>
                        <th scope="col">Status</th>
                        <td>{{ $post->status === 1? 'published' : 'Draft' }}</td>
                      </tr>



                    </tbody>
                  </table>

                  <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to Posts</a>


                @else
                <h3 class="text-center text-danger">No Post Found</h3>
                @endif

            </div>
        </div>
	</div>
</div>



@endsection

