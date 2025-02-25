<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array | null
    {   
        $type = $this->checkTypeCategory($this->link);

        if ($request->has('category_type') && $request->input('category_type') !== $type) {
            return null;
        }

        return [
            'id' => $this->id,
            'name' => ucfirst($this->name),
            'type' => $type,
            'link' => $this->link,
        ];
    }

    private function checkTypeCategory($category): string
    {
        $parts = explode('/', trim(parse_url($category, PHP_URL_PATH), '/'));
        if (count($parts) > 2) {
            return 'subcategory';
        }
        return 'category';
    }
}
