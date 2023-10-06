<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerformanceResource extends JsonResource
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
            'sympol' => $this->sympol,
            'reached_min' => $this->reached_min,
            'reached_max' => $this->reached_max,
            'target'=>$this->target,
            'comment' => $this->comment,
            'month' => $this->months->name,
        ];
    }
}
