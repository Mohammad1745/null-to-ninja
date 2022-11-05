@extends('layouts.app')

@section('title')
    Post List
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            {{$header}}
            <a href="{{route('post.create')}}">Create Post</a>
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                @if (count($posts)>0)
                    @foreach ($posts as $post)
                        <li class="d-flex justify-content-between mt-3">
                            <a href="{{route('post.show', $post->id)}}"> {{$post->title}}</a>
                            <div>
                                <a class="btn btn-info" href="{{route('post.edit', $post->id)}}">Edit</a>
                                <a class="btn btn-danger" href="{{route('post.delete', $post->id)}}"
                                   onclick="return confirm('Do you want to delete?')">Delete</a>
                            </div>
                        </li>
                        <hr>
                    @endforeach
                @else
                    <li>No Post Available</li>
                @endif
            </ul>
        </div>
    </div>
@endsection
