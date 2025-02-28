@extends('layouts.site')

@section('title', 'Other Pages')

@section('styles')

@endsection

@section('content')

<section class="page-title bg-1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <span class="text-white">Other Pages</span>
            <h1 class="text-capitalize mb-4 text-lg">Explore More Pages</h1>
            <ul class="list-inline">
              <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
              <li class="list-inline-item"><span class="text-white">/</span></li>
              <li class="list-inline-item text-white-50">Other Pages</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="card card-default mt-5 ml-3 mr-3">
        <div class="container mt-4">
            <h2 style="color:rgb(247, 87, 87)">Click on the name of the page you want to visit!</h2>
            @foreach($pages as $page)
                @if($page->status == 'published')
                    <h4 class="mt-3 mb-3">
                        <a href="{{ route('site.othersinglepage', $page->slug) }}">{{ $page->title }}</a>
                    </h4>
                @endif
            @endforeach
        </div>
    </div>
 </section>

@endsection
@section('scripts')

@endsection
