<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'content' => $this->content,
            'image' => $this->image,
            'timestamps' => TimestampsResource::make($this),
            'quiz' => QuizResource::make($this->whenLoaded('quiz')),
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),
        ];
    }
}
