@extends('layouts.app')

@section('title')
    {{$post->title}}
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Post Details
            <div>
                <a class="btn btn-info" href="{{route('post.edit', $post->id)}}">Edit</a>
                <a class="btn btn-danger" href="{{route('post.delete', $post->id)}}"
                   onclick="return confirm('Do you want to delete?')">Delete</a>
            </div>
        </div>
        <div class="card-body">
            <div class="card-header">{{$post->title}}</div>
            <div class="card-body">{{$post->content}}</div>
        </div>
    </div>
@endsection
