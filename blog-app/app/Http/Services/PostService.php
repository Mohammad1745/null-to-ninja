<?php

namespace App\Http\Services;

use App\Jobs\SendEmailJob;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PostService extends Service
{
    /**
     * @return array
     */
    public function getList (): array
    {
        try {
            $posts = Post::where('user_id', Auth::id())->get();

            return $this->responseSuccess("Done!", ['posts' => $posts]);
        }
        catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function getPost (int $id): array
    {
        try {
            $post = Post::where('user_id', Auth::id())->where('id', $id)->first();

            return $this->responseSuccess("Done!", ['post' => $post]);
        }
        catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }

    public function store (array $data)
    {
        try {
            Post::create([
                'user_id' => Auth::id(),
                'title' => $data['title'],
                'content' => $data['content']
            ]);
            return $this->responseSuccess("Post added successfully!");
        }
        catch (\Exception $exception) {
            return $this->responseError( $exception->getMessage());
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function update (array $data): array
    {
        try {
            $post = Post::where('user_id', Auth::id())->where('id', $data['id'])->first();
            if (is_null($post)) {
                return $this->responseError("Post doesn't exist!");
            }
            $post->update([
                'title' => $data['title'],
                'content' => $data['content']
            ]);
            return $this->responseSuccess("Post updated successfully!");
        }
        catch (\Exception $exception) {
            return $this->responseError( $exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function delete (int $id): array
    {
        try {
            $post = Post::where('user_id', Auth::id())->where('id', $id)->first();
            if (is_null($post)) {
                return $this->responseError("Post doesn't exist!");
            }
            $post->delete();

            return $this->responseSuccess("Post deleted successfully.");
        }
        catch (\Exception $exception) {
            return $this->responseError( $exception->getMessage());
        }
    }
}
