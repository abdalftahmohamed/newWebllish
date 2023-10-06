<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = json_decode($this->data, true);
        return [
            'id' => $this->id,
            'user_create' => $data['user_create'] ?? null,
            'name' => $data['name'] ?? null,

        ];
    }
}
