<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);


        return  [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_photo' => asset('uploads/users_image/' . $this->img),
            'email' => $this->email,
            // 'created_at' => $this->created_at->format('Y-m-d'),
            'created_at' => Carbon::parse($this->created_at)->toDateString(),
        ];
    }
}
