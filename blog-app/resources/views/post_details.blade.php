@extends('layouts.app')

@section('title')
    {{$post->title}}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{$post->title}}</div>
        <div class="card-body">{{$post->content}}</div>
        <div class="card-footer">
            <form action="">
                <div class="form-group">
                    <label for="comment">Comments</label>
                    <input type="text" name="comment" class="form-control" placeholder="write your comment here...">
                </div>
            </form>
        </div>
    </div>
@endsection
