<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimestampsResource extends JsonResource
{
    private function formatDate(array $timestamps): array
    {
        foreach($timestamps as $key => $timestamp) {
            if( ! $timestamp) {
                $timestamps[$key] = null;

                continue;
            }

            $now = now();
            $timestamps[$key] = Carbon::parse($timestamps[$key]);

            if($timestamp->diffInDays($now) >= 1)
                $timestamps[$key] = $timestamps[$key]->format('M d, Y');
            else if ($timestamp->diffInDays($now) < 1)
                $timestamps[$key] = $timestamps[$key]->format('G:i');
        }

        return $timestamps;
    }

    public function toArray($request): array
    {
        $timestamps = [
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

        $timestamps = $this->formatDate($timestamps);

        return [
            'createdAt' => $timestamps['createdAt'],
            'updatedAt' => $timestamps['updatedAt'],
        ];
    }

}
