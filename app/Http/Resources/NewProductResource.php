<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Double;

class NewProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $qtn = $this->pivot->quantity;
        $price_for_one = (float) ($qtn *  $this->sale_price);
        return [
            'name' => $this->name,
            'quantity' => $qtn,
            'total_price_for_only_one_product' => $price_for_one,
        ];
    }
}
