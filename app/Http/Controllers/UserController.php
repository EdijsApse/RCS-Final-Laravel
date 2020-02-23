<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index() {
        return view('user.index', ['users' => User::where('id', '!=' , Auth::id())->orderBy('created_at')->get()]);
    }

    public function view(User $user)
    {
        if ($user->id != Auth::id() && Auth::check()) {
            $user->profileViews()->create(['user_id' => Auth::id()]);
        }

        return view('user.view', ['user' => $user]);
    }

    public function profile()
    {
        return view('user.view', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255|min:4',
            'surname' => 'required|string|max:255|min:4',
            'email' => 'required|string|email|max:255|'.Rule::unique('users')->ignore(Auth::id()),
            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($request->file('picture')) {
            $data["picture"] = Storage::disk('local')->putFile('public/user/'.Auth::id(), $request->file('picture'));
        }

        Auth::user()->update($data);

        return redirect('profile')->withSuccess('Profile updated successfully!');;
    }
}
