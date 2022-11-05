@extends('layouts.app')

@section('title', "Create Post")

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Create Post
            <a href="{{route('post.index')}}">Post List</a>
        </div>
        <div class="card-body">
            <form action="{{route('post.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <labe>Title</labe>
                    <input type="text" name="title" class="form-control" placeholder="Enter post title"
                           value="{{old('title')}}">
                    @if (isset($errors) && $errors->has('title'))
                        <span class="text-danger"><strong>{{ $errors->first('title') }}</strong></span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <labe>Description</labe>
                    <textarea name="content" class="form-control" rows="3"
                              placeholder="Enter post content">{{old('content')}}</textarea>
                    @if (isset($errors) && $errors->has('content'))
                        <span class="text-danger"><strong>{{ $errors->first('content') }}</strong></span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
