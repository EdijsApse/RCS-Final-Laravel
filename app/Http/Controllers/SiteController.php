<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Contact;
use App\PostComment;
use App\PostLike;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function index()
    {

        return view('site.index', [
            'latestPosts' => Post::orderBy('updated_at', 'desc' )->take(4)->get(),
            'viewedPots' => Post::with('views')->get()->sortBy(function($post){
                return $post->views->count();
            }, SORT_REGULAR, true)->take(3),
            'likedPosts' => Post::with('likes')->get()->sortBy(function($post){
                return $post->likes->count();
            }, SORT_REGULAR, true)->take(3),
            'activeUsers' => User::with('posts')->get()->sortBy(function($user){
                return $user->posts->count();
            }, SORT_REGULAR, true)->take(3),
            'userCount' => User::get()->count(),
            'postCount' => Post::get()->count(),
            'likesCount' => PostLike::get()->count(),
            'commentCount' => PostComment::get()->count(),
            'contactMessages' => Contact::get()->count()

        ]);
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:4'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'body' => 'required|min:10',
        ]);

        Contact::create($data);

        return redirect('contact')->withSuccess('Message submited successfully! See you soon!');
    }
}
