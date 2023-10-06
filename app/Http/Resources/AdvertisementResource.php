<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'video' => $this->videoUrl(),
            'image' => $this->imageUrl(),
        ];
    }

    /**
     * Get the URL for the video attachment.
     *
     * @return string|null
     */
    private function videoUrl()
    {
        if ($this->video) {
            return url("attachments/advertisements/{$this->id}/{$this->video}");
        }

        return null;
    }

    /**
     * Get the URL for the image attachment.
     *
     * @return string|null
     */
    private function imageUrl()
    {
        if ($this->image) {
            return url("attachments/advertisements/{$this->id}/{$this->image}");
        }

        return null;
    }
}

