<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function getPosts($id)
    {
        $posts = Post::find($id);
        $title = Redis::get('posts:' . $id . ':title');
        return (string) $title;
    }

    public function set()
    {
        $posts = Post::query()->get();
        foreach ($posts as $post) {
            Redis::set('posts:'. $post->id.':title', $post->title);
        }
        return 'set all posts successfully';
    }
}
