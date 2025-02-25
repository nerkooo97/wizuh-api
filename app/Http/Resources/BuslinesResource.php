<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuslinesResource extends JsonResource
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
            'company' => $this->company,
            'amenities' => json_decode($this->amenities),
            'cityStart' => CityResource::make($this->cityStart),
            'cityEnd' => CityResource::make($this->cityEnd),
            'stations' => json_decode($this->stations),
            'days_in_week' => $this->days_in_week,
        ];
    }
}
