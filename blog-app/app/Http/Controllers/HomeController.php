<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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
        return view('post_details', $data);
    }
}
