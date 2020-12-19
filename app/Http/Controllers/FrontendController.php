<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use App\Models\Comments;

class FrontendController extends Controller
{
    public function home()
    {
        $posts = Post::latest()->take(4)->get();

        $news = News::latest()->take(4)->get();

        return view('home', compact('posts', 'news'));
    }

    public function posts()
    {
        $posts = Post::latest()->paginate(6);

        return view('posts', compact('posts'));
    }

    public function news()
    {
        $news = News::latest()->paginate(6);

        return view('news', compact('news'));
    }

    public function postShow($id)
    {
        $post = Post::findOrFail($id);

        $comments = $post->comments()->paginate(5);

        $sub_comments = $post->sub_comments()->whereIn('parent_id', $comments->pluck('id')->toArray())->get();

        return view('post', compact('post', 'comments', 'sub_comments'))->with('type', 'posts');
    }

    public function newsShow($id)
    {
        $article = News::findOrFail($id);

        $comments = $article->comments()->paginate(5);

        $sub_comments = $article->sub_comments()->whereIn('parent_id', $comments->pluck('id')->toArray())->get();

        return view('article', compact('article', 'comments', 'sub_comments'))->with('type', 'news');
    }
}
