<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'picture' => $this->getPicture(),
            'date' => $this->getUpdateDate(),
            'author_link' => $this->user->getLink(),
            'author_fullname' => $this->user->getFullname(),
            'title' => $this->title,
            'description' => $this->getShortBody(),
            'link' => $this->getLink(),
            'likes' => $this->likes()->count(),
            'comments' => $this->comments()->count(),
            'views' => $this->views()->count(),
        ];
    }
}
