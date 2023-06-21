<?php

namespace App\Http\Resources;

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
        return [
            'id'                   => $this->resource->id,
            'name'                 => $this->resource->name,
            'email'                => $this->resource->email,
            'role'                 => $this->resource->role,
            'created_at'           => $this->resource->created_at,
            'updated_at'           => $this->resource->updated_at,
            'posts_count'          => $this->resource->posts_count,
            'recentPostsWithLimit' => PostResource::collection($this->whenLoaded('recentPostsWithLimit'))
        ];
    }
}
