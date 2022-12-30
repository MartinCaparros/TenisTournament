<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TournamentListPaginatedResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'current_page'   => $this->currentPage(),
            'data'           => TournamentListResource::collection($this->collection),
            'first_page_url' => $this->url(1),
            'from'           => $this->firstItem(),
            'last_page'      => $this->lastPage(),
            'last_page_url'  => $this->url($this->lastPage()),
            'next_page_url'  => $this->nextPageUrl(),
            'per_page'       => $this->perPage(),
            'prev_page_url'  => $this->previousPageUrl(),
            'to'             => $this->lastItem(),
            'total'          => $this->total()
        ];
    }
}
