<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request)
    {
        return [
            'message'     => $this->resource['message'],
            'description' => $this->resource['description'] ?? null,
            'code'        => $this->resource['code'] ?? Response::HTTP_INTERNAL_SERVER_ERROR
        ];
    }

}
