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
                    <li class="list-unstyled">
                        <div class="comment">
                            <strong>{{$comment->author->name}}</strong> {{$comment->content}}
                        </div>
                        <div class="actions d-flex justify-content-between">
                            @if ($comment->liked)
                                <a class="reaction-btn" href="{{route('comment.dislike', $comment->id)}}">
                                    <i class="fas fa-thumbs-up"></i> {{$comment->like_count}}
                                </a>
                            @else
                                <a class="reaction-btn" href="{{route('comment.like', $comment->id)}}">
                                    <i class="far fa-thumbs-up"></i> {{$comment->like_count}}
                                </a>
                            @endif
                                <form action="{{route('comment.comment', $comment->id)}}" method="post">
                                @csrf
                                <div class="form-group d-flex justify-content-between">
                                    <input type="text" name="comment" class="form-control" placeholder="write your comment here...">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <ul class="comments">
                            @foreach($comment->replies as $reply)
                                <li class="list-unstyled">
                                    <div class="reply">
                                        <strong>{{$reply->author->name}}</strong> {{$reply->content}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <hr>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .reaction-btn {
            color: #333;
            text-decoration: none;
        }
    </style>
@endsection
