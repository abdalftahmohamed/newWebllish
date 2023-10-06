<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MagazineResource extends JsonResource
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
            'title' => $this->title,
            'datesend' => $this->datesend,
            'author' => $this->author,
            'description'=>$this->description,
//            'video' => $this->videoUrl(),
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
            return url("attachments/magazines/{$this->id}/{$this->video}");
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
            return url("attachments/magazines/{$this->id}/{$this->image}");
        }

        return null;
    }
}
