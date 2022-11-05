@extends('layouts.app')

@section('title')
    Task List
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            {{$header}}
            <a href="{{route('task.create')}}">Create Task</a>
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                @if (count($tasks)>0)
                    @foreach ($tasks as $task)
                        <li class="d-flex justify-content-between mt-3">
                            <a href="{{route('task.show', $task->id)}}"> {{$task->title}}</a>
                            <div>
                                <a class="btn btn-info" href="{{route('task.edit', $task->id)}}">Edit</a>
                                <a class="btn btn-danger" href="{{route('task.delete', $task->id)}}"
                                   onclick="return confirm('Do you want to delete?')">Delete</a>
                            </div>
                        </li>
                        <hr>
                    @endforeach
                @else
                    <li>No Task Available</li>
                @endif
            </ul>
        </div>
    </div>
@endsection
