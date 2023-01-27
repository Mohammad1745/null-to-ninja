@extends('layouts.app')

@section('title')
    Post List
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Post List
            <a href="{{route('post.create')}}">Create Post</a>
        </div>
        <div class="card-body">
{{--            <ul class="list-unstyled">--}}
{{--                @if (count($posts)>0)--}}
{{--                    @foreach ($posts as $post)--}}
{{--                        <li class="d-flex justify-content-between mt-3">--}}
{{--                            <a href="{{route('post.show', $post->id)}}"> {{$post->title}}</a>--}}
{{--                            <div>--}}
{{--                                <a class="btn btn-info" href="{{route('post.edit', $post->id)}}">Edit</a>--}}
{{--                                <a class="btn btn-danger" href="{{route('post.delete', $post->id)}}"--}}
{{--                                   onclick="return confirm('Do you want to delete?')">Delete</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <hr>--}}
{{--                    @endforeach--}}
{{--                @else--}}
{{--                    <li>No Post Available</li>--}}
{{--                @endif--}}
{{--            </ul>--}}
            <div class="posts" id="posts">

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            loadTasks()
        })

        function loadTasks () {
            axios({
                method: 'GET',
                url: "{{route('post.list')}}"
            })
                .then(res => res.data)
                .then(res => {
                    if (res.success) {
                        renderTasks(res.data.posts)
                    }
                    else {
                        let postsDom = document.getElementById('posts')
                        postsDom.innerHTML = res.message
                    }
                })
                .catch(err => console.log('err: ', err))
        }

        function renderTasks(posts) {
            let postsDom = document.getElementById('posts')
            if (posts.length===0) {
                postsDom.innerHTML = 'No Task Available'
            }
            else {
                for (let i=0; i<posts.length; i++) {
                    appendTask(posts[i], i)
                }
            }
        }

        function appendTask (post, index) {
            let postsDom = document.getElementById('posts')
            postsDom.insertAdjacentHTML('beforeend', `
                <div class="post-item d-flex justify-content-between mt-3">
                    <div class="post-title">
                        <span class="details-btn cursor-pointer" data-index="${index}">${post.title}</a>
                    </div>
                    <div class="post-actions">
                        <span class="btn btn-info edit-btn" data-index="${index}">Edit</span>
                        <span class="btn btn-danger delete-btn" data-index="${index}">Delete</span>
                    </div>
                </div>
            `)
        }
    </script>
@endsection
