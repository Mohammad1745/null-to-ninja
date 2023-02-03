<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostCommentStoreRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Services\PostService;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Application|Factory|View
     */
    public function index (): View|Factory|Application
    {
        return view('post.index');
    }

    /**
     * @return JsonResponse
     */
    public function getList (): JsonResponse
    {
        return response()->json( $this->service->getList());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getSingle (int $id): JsonResponse
    {
        return response()->json( $this->service->getPost($id));
    }

    /**
     * @param PostStoreRequest $request
     * @return JsonResponse
     */
    public function store (PostStoreRequest $request): JsonResponse
    {
        return response()->json( $this->service->store( $request->all()));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit ($id): View|Factory|Application
    {
        $data['post'] = Post::find($id);
        return view('post.edit', $data);
    }

    /**
     * @param PostUpdateRequest $request
     * @return RedirectResponse
     */
    public function update (PostUpdateRequest $request): RedirectResponse
    {
        $allData = $request->all();
        $id = $allData['id'];
        $post = Post::find($id);
        if (is_null($post)) {
            return redirect()->back()->with('error', "Post doesn't exist!");
        }

        $data =  [
            'title' => $allData['title'],
            'content' => $allData['content']
        ];
        Post::where('id', $id)->update($data);

        return redirect()->route('post.show', $id)->with('success', "Post updated successfully.");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy ($id): RedirectResponse
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return redirect()->back()->with('error', "Post doesn't exist!");
        }
        $post->delete();

        return redirect()->route('post.index')->with('success', "Post deleted successfully.");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function like ($id): RedirectResponse
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return redirect()->back()->with('error', "Post doesn't exist!");
        }
        $liked = PostReaction::where('post_id', $post->id)->where('user_id', Auth::id())->exists();
        if ($liked) {
            return redirect()->back()->with('error', "Post already liked");
        }
        PostReaction::create([
            'post_id' => $post->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', "Post liked successfully.");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function dislike ($id): RedirectResponse
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return redirect()->back()->with('error', "Post doesn't exist!");
        }
        $liked = PostReaction::where('post_id', $post->id)->where('user_id', Auth::id())->exists();
        if (!$liked) {
            return redirect()->back()->with('error', "Post already disliked");
        }
        PostReaction::where('post_id', $post->id)->where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', "Post disliked successfully.");
    }


    /**
     * @param $id
     * @param PostCommentStoreRequest $request
     * @return RedirectResponse
     */
    public function comment ($id, PostCommentStoreRequest $request): RedirectResponse
    {
        $allData = $request->all();

        $data =  [
            'post_id' => $id,
            'user_id' => Auth::id(),
            'content' => $allData['comment']
        ];

        PostComment::create($data);
        return redirect()->back()->with('success', "Comment successful.");
    }
}
