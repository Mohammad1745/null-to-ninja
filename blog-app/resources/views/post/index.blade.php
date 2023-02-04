@extends('layouts.app')

@section('title', 'Post List')

@section('style')
    <link rel="stylesheet" href="{{asset("assets/css/post.css")}}" type="text/css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Post List
            <span class="btn btn-info" id="create_btn">Create Post</span>
        </div>
        <div class="card-body">
            <div class="posts" id="posts">
                {{--       Dynamic contents         --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset("assets/js/post/config.js")}}"></script>
    <script src="{{asset("assets/js/post/index.js")}}"></script>
    <script src="{{asset("assets/js/post/details.js")}}"></script>
    <script src="{{asset("assets/js/post/create.js")}}"></script>
    <script>
        let baseUrl = "{{baseUrl()}}";
        let csrfToken = "{{csrf_token()}}";
        document.addEventListener('DOMContentLoaded', function () {
            loadPosts()
            handleCreateButton()
        })
    </script>
@endsection
