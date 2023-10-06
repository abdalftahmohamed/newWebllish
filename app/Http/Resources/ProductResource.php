<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description'=>$this->description,
            'accrual' => $this->accrual,
            'age_limit' => $this->age_limit,
            'salary_limit'=>$this->salary_limit,
            'images' =>ImagesProductResource::collection($this->images)
        ];
    }
}
