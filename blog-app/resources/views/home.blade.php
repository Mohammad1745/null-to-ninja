@extends(\Auth::user() ?'layouts.app' : 'layouts.auth')

@section('title')
    Post List
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Home Page
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                @if (count($posts)>0)
                    @foreach ($posts as $post)
                        <li class="mt-3">
                            <div class="card w-full">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <div class="post-title"> <a href="{{route('post_details', $post->id)}}"> {{$post->title}}</a></div>
                                        <div class="post-author">Posted by: {{$post->author->name}}</div>
                                    </div>
                                    <div>
                                        <span class="like-counter">
                                            @if (\Auth::user())
                                                @if ($post->liked)
                                                    <a class="reaction-btn" href="{{route('post.dislike', $post->id)}}">
                                                        <i class="fas fa-thumbs-up"></i> {{$post->like_count}}
                                                    </a>
                                                @else
                                                    <a class="reaction-btn" href="{{route('post.like', $post->id)}}">
                                                        <i class="far fa-thumbs-up"></i> {{$post->like_count}}
                                                    </a>
                                                @endif
                                            @else
                                                <i class="far fa-thumbs-up"></i> {{$post->like_count}}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">{{$post->content}}</div>
                            </div>

                        </li>
                    @endforeach
                @else
                    <li>No Post Available</li>
                @endif
            </ul>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .post-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .post-author {
            font-size: 0.75rem;
            color: #222;
        }
        .like-counter {
            margin: 5px;
            padding: 5px;
            border-radius: 5px;
        }
        .reaction-btn {
            color: #333;
            text-decoration: none;
        }
    </style>
@endsection
