@extends('layouts.app')

@section('title')
    Post List
@endsection

@section('style')
    <style>
        .create-form-card {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 50vw;
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Post List
            <span class="btn btn-info" id="create_btn">Create Post</span>
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
            handleCreateButton()
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
            postsDom.innerHTML = ''
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

        function handleCreateButton() {
            const createBtn = document.getElementById('create_btn')
            createBtn.addEventListener('click', () => {
                showCreateForm()
            })
        }

        function showCreateForm() {
            const formCard = document.getElementById('create_form_card')
            if (!formCard) {
                const container = document.getElementById('container')
                container.insertAdjacentHTML('beforeend', `
                    <div class="card create-form-card" id="create_form_card">
                        <div class="card-header">
                            Create Post
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="form-group">
                                    <labe>Title</labe>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" value="">
                                    <span class="text-danger"><strong id="title_validation_error"></strong></span>
                                </div>
                                <div class="form-group mt-3">
                                    <labe>Description</labe>
                                    <textarea name="content" id="content" class="form-control" rows="3" placeholder="Enter post content"></textarea>
                                    <span class="text-danger"><strong id="content_validation_error"></strong></span>
                                </div>
                                <button class="btn btn-primary mt-3" id="create_form_submit_btn">Submit</button>
                            </div>
                        </div>
                    </div>
                `)
                handleCreateFormSubmitButton()
            }
        }
        function handleCreateFormSubmitButton() {
            const createFormSubmitBtn = document.getElementById('create_form_submit_btn')
            createFormSubmitBtn.addEventListener('click', () => {
                const title = document.getElementById('title').value
                const content = document.getElementById('content').value
                const titleValidationError = document.getElementById('title_validation_error')
                const contentValidationError = document.getElementById('content_validation_error')
                titleValidationError.innerHTML = ''
                contentValidationError.innerHTML = ''

                axios({
                        method: 'POST',
                        url: "{{route('post.store')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            title,
                            content
                        }
                    })
                        .then(res => res.data)
                        .then(res => {
                            if (res.success) {
                                const formCard = document.getElementById('create_form_card')
                                if (formCard) formCard.remove()
                                loadTasks()
                            }
                        })
                        .catch(err => {
                            console.log(err)
                            if (err.response.data.errors) {
                                showValidationError(err.response.data.errors)
                            }
                        })
            })
        }


        function showValidationError(errors) {
            Object.keys(errors).forEach(key => {
                const dom =  document.getElementById(key+'_validation_error')
                dom.innerHTML = errors[key][0]
            })
        }
    </script>
@endsection
