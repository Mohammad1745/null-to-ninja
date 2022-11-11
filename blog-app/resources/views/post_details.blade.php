@extends('layouts.app')

@section('title')
    {{$post->title}}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{$post->title}}</div>
        <div class="card-body">{{$post->content}}</div>
        <div class="card-footer">
            <form action="{{route('post.comment', $post->id)}}" method="post">
                @csrf
                <div class="form-group d-flex justify-content-between">
                    <button disabled>Comments</button>
                    <input type="text" name="comment" class="form-control" placeholder="write your comment here...">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
            <hr>
            <ul class="comments">
                @foreach($comments as $comment)
                    <li class="list-unstyled"><strong>{{$comment->author->name}}</strong> {{$comment->content}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
