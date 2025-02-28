@extends('layouts.site')

@section('title', 'Blogwizard')

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
    display: flex;
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
            <span class="text-white">Our blogs</span>
            <h1 class="text-capitalize mb-4 text-lg">Blog articles</h1>
            <ul class="list-inline">
              <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
              <li class="list-inline-item"><span class="text-white">/</span></li>
              <li class="list-inline-item text-white-50">Our blogs</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section blog-wrap bg-gray">
    <div class="container">

        <!-- Search and Filter Form -->
        <div class="row mb-4">
            <div class="col-md-12">
                <form action="{{ route('blogs.index') }}" method="GET" class="form-inline">
                    <input type="text" name="search" class="col-md-12 mb-2 form-control mr-2" placeholder="Search by Title" value="{{ request('search') }}">

                    <select name="tag" class="col-md-12 mb-2 form-control mr-2">
                        <option value="">Select Tag</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>

                    <select name="category" class="col-md-12 mb-2 form-control mr-2">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('blogs.index') }}" class="btn btn-secondary  ml-2">Reset</a>
                </form>
            </div>
        </div>

        @if ($blogs->count() > 0)
        <div class="row">
            @foreach ($blogs as $blog)
                @if ($blog->published_at === null || $blog->published_at <= now()) <!-- Additional check -->
                    <div class="col-lg-6 col-md-6 mb-5" >
                        <div class="blog-item" >
                            <div class="image" >
                                @if($blog->gallery) <!-- Check if the blog has a gallery -->
                                @foreach($blog->gallery->images as $image) <!-- Iterate over the images -->
                                    @if($image->size === 'large') <!-- Check for large images -->
                                        <img src="{{ asset($image->path) }}" alt="Image"  >
                                    @endif
                                @endforeach
                            @else
                                <img src="{{ asset('default-image.jpg') }}" style="width: 80px; height: 60px" alt="default image">
                            @endif
                            </div>
                            <div class="blog-item-content bg-white p-5" >
                                <div class="blog-item-meta bg-gray pt-2 pb-1 px-3">
                                    <span class="text-muted text-capitalize d-inline-block mr-3">
                                        <i class="ti-comment mr-2"></i>{{ $blog->comments->where('approved', true)->count() }} Comments
                                    </span>
                                    <span class="text-black text-capitalize d-inline-block" style="float: right">
                                        <i class="ti-time mr-1"></i>{{ date('d M Y', strtotime($blog->created_at)) }}
                                    </span>
                                </div>
                                <h3 class="mt-3 mb-3">
                                    <a href="{{ route('single-blog', $blog->slug) }}">{{ $blog->title }}</a>
                                </h3>
                                <p class="mb-4">{!! Str::limit($blog->description, 30, '...') !!}</p>

                                <a href="{{ route('single-blog', $blog->slug) }}" class="btn btn-small btn-main btn-round-full">Read More</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row justify-content-left mt-5">
            {{ $blogs->links() }}
        </div>
    @else
        <div class="text-center">
            <h3 class="text-danger">No Blog Posted Yet!</h3>
        </div>
    @endif


    </div>
  </section>

@endsection

@section('scripts')

@endsection
