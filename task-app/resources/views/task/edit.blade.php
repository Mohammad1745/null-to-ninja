@extends('layouts.app')

@section('title', "Edit Task")

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Edit Task
        </div>
        <div class="card-body">
            <form action="{{route('task.update')}}" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{$task->id}}">
                <div class="form-group">
                    <labe>Title</labe>
                    <input type="text" name="title" class="form-control" placeholder="Enter task title"
                           value="{{old('title') ? old('title') : $task->title}}">
                    @if (isset($errors) && $errors->has('title'))
                        <span class="text-danger"><strong>{{ $errors->first('title') }}</strong></span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <labe>Description</labe>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Enter task description">{{old('description') ? old('description') : $task->description}}</textarea>
                    @if (isset($errors) && $errors->has('description'))
                        <span class="text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
