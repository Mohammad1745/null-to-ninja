@extends('layouts.app')

@section('title')
    {{$task->title}}
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Task Details
            <div>
                <a class="btn btn-info" href="{{route('task.edit', $task->id)}}">Edit</a>
                <a class="btn btn-danger" href="{{route('task.delete', $task->id)}}"
                   onclick="return confirm('Do you want to delete?')">Delete</a>
            </div>
        </div>
        <div class="card-body">
            <div class="card-header">{{$task->title}}</div>
            <div class="card-body">{{$task->description}}</div>
        </div>
    </div>
@endsection
