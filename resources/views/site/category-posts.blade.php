@extends('layouts.site')

@section('styles')


<style>
   .blog-item {
    width: 500px; /* Set a fixed width */
    height: 700px; /* Set a fixed height */
    overflow: hidden; /* Prevent content overflow */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border: 1px solid #ddd; /* Optional: Add a border */
    border-radius: 8px; /* Optional: Add rounded corners */
}
.image{

}

.image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.blog-item-content {
    width: 100%;
    height: 350px;
    padding: 20px;
    flex-direction: column;
    justify-content: space-between;
}

.blog-item-meta {
    font-size: 14px;
    color: #777;
    display: flex;
    justify-content: space-between;
}

.blog-item h3 {
    font-size: 30px;
    margin: 10px 0;
}

.blog-item p {
    flex-grow: 1;
    font-size: 20px;
    color: #555;
}

.blog-item .btn {
    align-self: flex-start;
}


 </style>

@endsection

@section('content')

<section class="page-title bg-1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <span class="text-white">Category</span>
            <h1 class="text-capitalize mb-4 text-lg"> {{ $category->name }}</h1>
            <ul class="list-inline">
              <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
              <li class="list-inline-item"><span class="text-white">/</span></li>
              <li class="list-inline-item text-white-50">{{ $category->name }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

<div class="container mt-5">
    @if ($blogs->count() > 0)
    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-lg-6 col-md-6 mb-5">
                <div class="blog-item">
                    {{-- Blog Image --}}
                    <div class="image" >
                        @if($blog->gallery)
                        @foreach($blog->gallery->images as $image)
                            @if($image->size === 'large')
                                <img src="{{ asset($image->path) }}" alt="Image"  >
                            @endif
                        @endforeach
                    @else
                        <img src="{{ asset('default-image.jpg') }}" style="width: 80px; height: 60px" alt="default image">
                    @endif
                    </div>

                    <div class="blog-item-content bg-gray p-5">
                        {{-- Blog Metadata --}}
                        <div class="blog-item-meta bg-white pt-2 pb-1 px-3" >
                            <span class="text-muted text-capitalize d-inline-block mr-3">
                                <i class="ti-comment mr-2"></i>{{ $blog->comments ? $blog->comments->count() : 0 }} Comments
                            </span>
                            <span class="text-black text-capitalize d-inline-block float-right">
                                <i class="ti-time mr-1"></i>{{ $blog->created_at->format('d M Y') }}
                            </span>
                        </div>
                        <h3 class="mt-3 mb-3"><a href="{{ route('single-blog', $blog->slug) }}">{{ $blog->title }}</a></h3>
                                <p class="mb-4">{!! Str::limit($blog->description, 30, '...') !!}</p>


                        {{-- Display Full Blog Content --}}
                        <div class="blog-content mt-3">
                            {!! $blog->content !!} {{-- Render HTML content safely --}}
                        </div>

                        {{-- Optional "Read More" Button --}}
                        <a href="{{ route('single-blog', $blog->slug) }}" class="btn btn-small btn-main btn-round-full mt-3">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $blogs->links() }}
    </div>
@else
    <h2 class="text-center" style="color: red">No blogs found.</h2>
@endif
@include('partials.sidebar', ['categories' => $categories, 'tags' => $tags])

</div>
@endsection
