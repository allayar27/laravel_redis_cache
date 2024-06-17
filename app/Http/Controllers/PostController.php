<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    public function index()
    {

        $posts = Post::query()->where('likes', '<',  50)->get();
        foreach ($posts as $post) {
            Redis::set('posts:'. $post->id .':user', $post->likes);
        }

        return count($posts)."posts where less than 50 likes";
    }

}
