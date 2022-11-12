<?php

namespace App\Http\Controllers;


use App\Models\CommentComment;
use App\Models\CommentReaction;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index (): View|Factory|Application
    {
        $data['header'] = "Post List";
        $posts = Post::where('user_id', '!=', Auth::id())->get();
        foreach ($posts as $post) {
            $post->author = User::find($post->user_id);
            $post->like_count = PostReaction::where('post_id', $post->id)->count();
            if (Auth::user()) {
                $post->liked = PostReaction::where('post_id', $post->id)->where('user_id', Auth::id())->exists();
            }
        }
        $data['posts'] = $posts;

        return view('home', $data);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function showDetails ($id): View|Factory|Application
    {
        $data['post'] = Post::find($id);
        $comments = PostComment::where('post_id', $id)->orderBy('id', 'desc')->get();
        foreach ($comments as $comment) {
            $comment->author = User::find($comment->user_id);
            $comment->like_count = CommentReaction::where('post_comment_id', $comment->id)->count();
            $comment->liked = CommentReaction::where('post_comment_id', $comment->id)->where('user_id', Auth::id())->exists();
            $replies =  CommentComment::where('post_comment_id', $comment->id)->orderBy('id', 'desc')->get();
            foreach($replies as $reply) {
                $reply->author = User::find($reply->user_id);
            }
            $comment->replies = $replies;
        }
        $data['comments'] = $comments;

        return view('post_details', $data);
    }
}
