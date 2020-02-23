<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname', 'picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     * @return string Users Fullname
     *
     */
    public function getFullName()
    {
        return $this->name." ".$this->surname;
    }

    public function getProfilePicture()
    {
        if (Storage::disk('local')->exists($this->picture)) {
            return Storage::url($this->picture);
        }

        return asset('/img/no-image.png');
    }

    /**
     *
     * @return string Url of post
     *
    */
    public function getLink()
    {
        return url('/user/'.$this->id);
    }

    /**
     *
     * @return string Date created at
     *
     */

     public function getRegistrationDate()
     {
         return Carbon::parse($this->cratd_at)->format('d.m.Y');
     }

     public function viewedPosts()
     {
         return $this->hasMany(PostView::class);
     }

    /**
     *
     * @return ModelCollection of Users posts
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     *
     * @return ModelCollection of Comments created by $this
    */
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

        /**
     *
     * @return ModelCollection of Profile Views
    */
    public function profileViews()
    {
        return $this->hasMany(ProfileView::class, 'profile_id');
    }
}
