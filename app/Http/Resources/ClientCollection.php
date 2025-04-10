<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        // return parent::toArray($request);
        // return ClientResource::collection($this->collection);
        return [
            'data' => $this->collection, // البيانات الأساسية
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'next_page_url' => $this->nextPageUrl(),
                'prev_page_url' => $this->previousPageUrl(),
            ],
        ];
        // return [
        //     'data' => $this->collection->map(function ($client) {
        //         return [
        //             // 'id' => $client->id,
        //             'name' => $client->name,
        //             'phone' => $client->phone,
        //             'address' => $client->address,
        //             'created_at' => $client->created_at->format('Y-m-d H:i:s'),
        //         ];
        //     }),
        //     'meta' => [
        //         'total' => $this->total(),
        //         'per_page' => $this->perPage(),
        //         'current_page' => $this->currentPage(),
        //         'last_page' => $this->lastPage(),
        //     ],
        // ];
    }
}
