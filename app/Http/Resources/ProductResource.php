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
        // return parent::toArray($request);
        return [
            'name' => $this->name,
            'img' => asset('uploads/products_image/' . $this->img),
            'description' => $this->desc,
            'stock' => $this->stock,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
