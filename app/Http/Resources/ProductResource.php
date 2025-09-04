<?php

namespace App\Http\Resources;

use App\Models\ProductDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Use ::make for single related model
            'detail'      => ProductDetailResource::make($this->whenLoaded('detail')),

            // Use ::collection for hasMany
            'reviews'     => ReviewResource::collection($this->whenLoaded('reviews')),

        ];
    }
}
