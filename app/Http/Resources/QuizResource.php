<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'isPublished' => $this->is_published,
            'timestamps' => TimestampsResource::make($this),
            'user' => UserResource::make($this->whenLoaded('user')),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories'))
        ];
    }
}
