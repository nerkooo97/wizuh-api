<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'description' => $this->description,
            'category' => $this->getCategory(),
            'city' => $this->getCity(),
            'featured' => $this->featured,
            'image' => $this->image,
            'date' => $this->getEventDate(),
            'time' => $this->getEventTime(),
            'link_type' => $this->link_type,
            'link' => $this->link,
        ];
    }

    private function getEventDate(): string
    {
        return $this->start->format('Y-m-d');
    }

    private function getEventTime(): string
    {
        return $this->start->format('H:i');
    }

    private function getCity(): array
    {   
        return [
            'id' => $this->city,
            'name' => $this->city_name,
        ];
    }

    private function getCategory(): array
    {
        return [
            'id' => $this->category,
            'name' => $this->category_name,
        ];
    }
}
