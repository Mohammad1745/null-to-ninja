@extends('layouts.app')

@section('title')
    Post List
@endsection

@section('style')
    <style>
        .popup-bg {
            position: absolute;
            left: 0;
            top: 0;
            height: 100vh;
            width: 100vw;
            background-color: rgba(0,0,0,0.5);
        }
        .create-form-card {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 50vw;
            transform: translate(-50%, -50%);
            z-index: 2;
        }
        .post-details-card {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 80vw;
            transform: translate(-50%, -50%);
            z-index: 2;
        }
        .cursor-pointer {
            cursor: pointer;
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
            loadPosts()
            handleCreateButton()
        })

        function loadPosts () {
            axios({
                method: 'GET',
                url: "{{route('post.list')}}"
            })
                .then(res => res.data)
                .then(res => {
                    if (res.success) {
                        renderPosts(res.data.posts)
                        handleDetailsButtons()
                    }
                    else {
                        let postsDom = document.getElementById('posts')
                        postsDom.innerHTML = res.message
                    }
                })
                .catch(err => console.log('err: ', err))
        }

        function renderPosts(posts) {
            let postsDom = document.getElementById('posts')
            postsDom.innerHTML = ''
            if (posts.length===0) {
                postsDom.innerHTML = 'No Post Available'
            }
            else {
                for (let i=0; i<posts.length; i++) {
                    appendPost(posts[i], i)
                }
            }
        }

        function appendPost (post, index) {
            let postsDom = document.getElementById('posts')
            postsDom.insertAdjacentHTML('beforeend', `
                <div class="post-item d-flex justify-content-between mt-3">
                    <div class="post-title">
                        <span class="details-btn cursor-pointer" data-id="${post.id}">${post.title}</a>
                    </div>
                    <div class="post-actions">
                        <span class="btn btn-info edit-btn" data-id="${post.id}">Edit</span>
                        <span class="btn btn-danger delete-btn" data-id="${post.id}">Delete</span>
                    </div>
                </div>
            `)
        }

        function handleCreateButton() {
            const createBtn = document.getElementById('create_btn')
            createBtn.addEventListener('click', () => {
                showCreateForm()
                handleCreateFormSubmitButton()
                handleCloseCreateFormBtn()
            })
        }

        function showCreateForm() {
            showPopupBg()

            const formCard = document.getElementById('create_form_card')
            if (!formCard) {
                const container = document.getElementById('container')
                container.insertAdjacentHTML('beforeend', `
                    <div class="card create-form-card" id="create_form_card">
                        <div class="card-header d-flex justify-content-between">
                            Create Post
                            <button class="btn btn-dark" id="close_create_form_btn">x</button>
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
                                hidePopupBg()
                                loadPosts()
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

        function handleDetailsButtons() {
            let detailsBtns = document.querySelectorAll('.details-btn')
            for (let i=0; i<detailsBtns.length; i++) {
                detailsBtns[i].addEventListener('click', function () {
                    let postId = detailsBtns[i].getAttribute('data-id')
                    loadPost(postId)
                })
            }
        }
        function loadPost (postId) {
            axios({
                method: 'GET',
                url: `{{route('post.index')}}/${postId}`
            })
                .then(res => res.data)
                .then(res => {
                    if (res.success) {
                        showPostDetails(res.data.post)
                        handleClosePostDetailsBtn()
                    }
                    else {
                        console.log(res.message)
                    }
                })
                .catch(err => console.log('err: ', err))
        }
        function showPostDetails (post) {
            hidePostDetailsPopup()
            showPopupBg()
            const container = document.getElementById('container')

            container.insertAdjacentHTML('beforeend', `
                <div class="card post-details-card" id="post_details_card">
                    <div class="card-header d-flex justify-content-between">
                        Post Details
                        <button class="btn btn-dark" id="close_post_details_btn">x</button>
                    </div>
                    <div class="card-body">
                        <div class="card-header">${post.title}</div>
                        <div class="card-body">${post.content}</div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-info" href="">Edit</a>
                        <a class="btn btn-danger" href=""
                           onclick="return confirm('Do you want to delete?')">Delete</a>
                    </div>
                </div>
            `)
        }

        function handleCloseCreateFormBtn ()
        {
            const button = document.getElementById('close_create_form_btn')
            button.addEventListener('click', () => {
                hidePopupBg()
                hideCreteFormPopup()
            })
        }

        function handleClosePostDetailsBtn ()
        {
            const button = document.getElementById('close_post_details_btn')
            button.addEventListener('click', () => {
                hidePopupBg()
                hidePostDetailsPopup()
            })
        }

        function hideCreteFormPopup () {
            const formCard = document.getElementById('create_form_card')
            if (formCard) formCard.remove()
        }

        function hidePostDetailsPopup () {
            const detailsCard = document.getElementById('post_details_card')
            if (detailsCard) detailsCard.remove()
        }

        function showPopupBg() {
            hidePopupBg()
            const body = document.getElementById('body')
            body.insertAdjacentHTML('beforeend', `<div class="popup-bg" id="popup_bg"></div>`)
        }

        function hidePopupBg() {
            const popupBg = document.getElementById('popup_bg')
            if (popupBg) popupBg.remove()
        }

        function showValidationError(errors) {
            Object.keys(errors).forEach(key => {
                const dom =  document.getElementById(key+'_validation_error')
                dom.innerHTML = errors[key][0]
            })
        }
    </script>
@endsection
