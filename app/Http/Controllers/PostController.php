<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function index()
    {

        if (request()->has('limit')) {

            $data = [];

            $isMore = false;
            foreach(Post::orderBy('id', 'desc')->offset(request()->get('offset'))->limit(request()->get('limit'))->get() as $post){
                $data[] = new PostResource($post);
            }

            if (count($data) >= request()->get('limit')) {//If number of posts is returned exactly what was asked then check if any posts will be returned in next ajax call
                $nextOffset = request()->get('offset') + request()->get('limit');
                if (Post::orderBy('id', 'desc')->offset($nextOffset)->limit(1)->get()->count()) {
                    $isMore = true;
                }
            }

            return json_encode(['success' => true, 'data' => $data, 'isMore' => $isMore]);
        }

        return view('post.index', [
            'latestPost' => Post::orderBy('id', 'desc')->first(),
            'posts' => Post::orderBy('id', 'desc')->limit(4)->get()
        ]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function edit(Post $post)
    {
        if ($post->canEdit()) {
            return view('post.update', ['post' => $post]);
        }

        return redirect('posts');//@todo 403
    }

    public function update(Post $post, Request $request)
    {
        $data = $this->validator($request);

        $post->update($data);

        return redirect($post->getLink())->withSuccess('Post updated successfuly! Good Job!');
    }

    public function view(Post $post)
    {
        if (!$post->canEdit()) {//If Post is not Main, dont add View
            $post->views()->create(['user_id' => Auth::id()]);
        }

        return view('post.view', [
            'post' => $post,
            'nextPosts' => Post::inRandomOrder()->limit(3)->get()
        ]);
    }

    public function store(Request $request)
    {

        $data = $this->validator($request);

        Auth::user()->posts()->create($data);

        return redirect('posts')->withSuccess('Post created successfuly! Good Job!');;

    }

    public function commentPost(Post $post, Request $request) {
        //If validator fails, returns redirect back with error bag
        $data = $request->validate([
            'comment' => 'required|min:5|max:255',
        ]);

        $post->comments()->create(array_merge($data, ['user_id' => Auth::id()]));

        return redirect($post->getLink())->withSuccess('You commnted post! Checkout next post!');
    }

    public function like(Post $post)
    {
        if ($post->canBeLiked()) {
            $post->likes()->create(['user_id' => Auth::id()]);
            return [
                'success' => true,
                'error' => false,
                'newLikeCount' => $post->likes()->count()
            ];
        }

        return [
            'success' => false
        ];
    }

    /**
     *
     * @return array Of validated values if success, else, redirect back with error messages
     */

    protected function validator(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5|max:255',
            'body' => 'required|min:10',
            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($request->file('picture')) {
            $data["picture"] = Storage::disk('local')->putFile('public/post', $request->file('picture'));
        }

        return $data;
    }
}
