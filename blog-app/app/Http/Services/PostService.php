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
}
