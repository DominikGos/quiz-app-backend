<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content' => $this->content,
            'image' => $this->image,
            'isCorrect' => $this->is_correct,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'question' => QuestionResource::make($this->whenLoaded('question')),
        ];
    }
}
