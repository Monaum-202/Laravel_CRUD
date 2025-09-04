<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'product_id'     => $this->product_id,
            'specifications' => $this->specifications,
            'manufacturer'   => $this->manufacturer,
            'warranty'       => $this->warranty,
        ];
    }
}
