<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Helper\TopicHelper;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => (new TopicHelper)->setExcerpt($this->content, 100),
            'categories ' => $this->categories,
            'date' => $this->date,
            'link' => $this->link,
            'featured_media_url' => $this->featured_media_url,
        ];
    }

}
