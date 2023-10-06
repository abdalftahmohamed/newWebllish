<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImagesProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $bank_id=$this->imageable->bank_id;
        return [
            'id' => $this->id,
            'image' => url('attachments/products/'.$bank_id.'/'.$this->imageable_id.'/'. $this->file_name),
        ];
    }
}
