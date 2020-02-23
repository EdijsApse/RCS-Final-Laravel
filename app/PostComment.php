<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PostComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment', 'user_id'];

    /**
     *
     * @return string Date when comment was created
     *
     */
    public function getCreateDate()
    {
        return Carbon::parse($this->created_at)->format('m.d.Y');
    }

    /**
     * Get the author of the comment
     *
     * @return User Model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post of the comment.
     *
     * @return User Model
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
