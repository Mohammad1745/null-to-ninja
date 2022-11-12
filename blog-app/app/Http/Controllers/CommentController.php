<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentCommentStoreRequest;
use App\Models\CommentComment;
use App\Models\CommentReaction;
use App\Models\PostComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * @param $id
     * @return RedirectResponse
     */
    public function like ($id): RedirectResponse
    {
        $comment = PostComment::find($id);
        if (is_null($comment)) {
            return redirect()->back()->with('error', "Comment doesn't exist!");
        }
        $liked = CommentReaction::where('post_comment_id', $comment->id)->where('user_id', Auth::id())->exists();
        if ($liked) {
            return redirect()->back()->with('error', "Comment already liked");
        }
        CommentReaction::create([
            'post_comment_id' => $comment->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', "Comment liked successfully.");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function dislike ($id): RedirectResponse
    {
        $comment = PostComment::find($id);
        if (is_null($comment)) {
            return redirect()->back()->with('error', "Comment doesn't exist!");
        }
        $liked = CommentReaction::where('post_id', $comment->id)->where('user_id', Auth::id())->exists();
        if (!$liked) {
            return redirect()->back()->with('error', "Comment already disliked");
        }
        CommentReaction::where('post_id', $comment->id)->where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', "Comment disliked successfully.");
    }


    /**
     * @param $id
     * @param CommentCommentStoreRequest $request
     * @return RedirectResponse
     */
    public function comment ($id, CommentCommentStoreRequest $request): RedirectResponse
    {
        $allData = $request->all();

        $data =  [
            'post_comment_id' => $id,
            'user_id' => Auth::id(),
            'content' => $allData['comment']
        ];

        CommentComment::create($data);
        return redirect()->back()->with('success', "Comment successful.");
    }
}
