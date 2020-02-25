<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id', 'picture'];


    /**
     *
     * @return string Short body
     *
    */
    public function getShortBody()
    {
        return substr($this->body, 0, 50);
    }

    /**
     *
     * @return string Url of post
     *
    */
    public function getLink()
    {
        return url('/post/'.$this->id);
    }

    /**
     *
     * @return string Date when post was last time updated
     *
     */
    public function getUpdateDate()
    {
        return Carbon::parse($this->updated_at)->format('m.d.Y');
    }

    public function getPicture()
    {
        if (Storage::disk('local')->exists($this->picture)) {
            return Storage::url($this->picture);
        }

        return asset('/img/no-image.png');
    }

    /**
     *
     * @return bool True if user is created post
     *
     */
    public function canEdit()
    {
        return ($this->user_id == Auth::id() ? true:false);
    }

    /**
     *
     * @return bool True if user can like post!
     *
     */
    public function canBeLiked()
    {
        if ($this->user_id == Auth::id()) {
            return false;
        }

        if ($this->likes()->where('user_id', Auth::id())->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Get the author of the post.
     *
     * @return User Model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @return ModelCollection of Post Comments
    */
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    /**
     *
     * @return ModelCollection of Post Likes
    */
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     *
     * @return ModelCollection of Post Likes
    */
    public function views()
    {
        return $this->hasMany(PostView::class);
    }
}
