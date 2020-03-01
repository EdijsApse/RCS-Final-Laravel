<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Improvement extends Model
{

    CONST STATUS_NEW = 0;
    CONST STATUS_PROGRESS = 1;
    CONST STATUS_DONE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'title', 'description', 'priority'
    ];


    /**
     *
     * @return array Of Improvement status details
     *
    */
    public static function getStatuses()
    {
      return [
          ['status' => self::STATUS_NEW, 'title' => 'New'],
          ['status' => self::STATUS_PROGRESS, 'title' => 'In Progress'],
          ['status' => self::STATUS_DONE, 'title' => 'Done'],
      ];
    }

    /**
     *
     * @return array Of Improvement priorities
     *
    */
    public static function getPriorities()
    {
      return [
        "Low",
        "Medium",
        "High"
      ];
    }

    /**
     *
     * @return string Update time in human readable format
     *
     */
    public function getUpdateTime()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }

    /**
     *
     * @return string user name if improvement was created by user
     *
     */
    public function getUserName()
    {
        $user = $this->getUser();

        return ($user ? $user->getFullName() : "Anonymous User");
    }

    /**
     *
     * @return string of pictures url
     *
     */

    public function getUserPicture()
    {
        $user = $this->getUser();

        return ($user ? $user->getProfilePicture() : asset('/img/no-image.png'));
    }


    /**
     *
     * @return User||bool Return user if improvement was created by authorized user
     *
     */
    protected function getUser()
    {
        if (!$this->user_id) {
            return false;
        }

        $user = User::where('id', $this->user_id)->first();

        return ($user ? $user : false);
    }
}
