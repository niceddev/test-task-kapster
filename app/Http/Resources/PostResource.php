<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->resource['id'],
            'title'           => $this->resource['title'],
            'short'           => substr($this->resource['body'], 0, 100),
            'body'            => $this->resource['body'],
            'status'          => $this->resource['status'],
            'published_at'    => $this->resource['published_at'] ?? now(),
            'blocked_at'      => $this->when(isset($this->resource['blocked_at']), fn() => $this->resource['blocked_at']),
            'blocked_comment' => $this->when(isset($this->resource['blocked_comment']), fn() => $this->resource['blocked_comment']),
        ];
    }
}
