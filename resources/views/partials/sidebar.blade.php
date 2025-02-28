<!-- resources/views/partials/sidebar.blade.php -->
<div class="sidebar-widget bg-white rounded tags p-4 mb-3">
    <h5 class="mb-4">Tags</h5>
    @if (!empty($tags) && count($tags) > 0) {{-- Safely check if $tags exists --}}
        @foreach ($tags as $tag)
            <a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}</a>
        @endforeach
    @else
        <h6 class="text-danger text-center">No Tags Found!</h6>
    @endif
</div>


<div class="sidebar-widget bg-white rounded tags p-4 mb-3">
    <h5 class="mb-4">Categories</h5>
    @if (!empty($categories) && count($categories) > 0)
        @foreach ($categories as $category)
            <a href="{{ route('category.posts', $category->slug) }}">{{ $category->name }}</a>
        @endforeach
    @else
        <h6 class="text-danger text-center">No Category Found!</h6>
    @endif
</div>
