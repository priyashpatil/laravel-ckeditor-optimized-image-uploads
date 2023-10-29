@extends('layouts.admin')

@section('content')
    <div class="container py-3" style="max-width: 600px">
        <h1 class="mb-3">Blog Index</h1>

        <ul>
            @foreach($blogPosts as $blogPost)
                <li><a href="{{route('blog-posts.edit', $blogPost)}}">{{$blogPost->title}}</a></li>
            @endforeach
        </ul>

        {{$blogPosts->links()}}
    </div>
@endsection
