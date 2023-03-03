<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'unread_exceptions' => $this->unread_exceptions_count,
            'total_exceptions'  => (int) $this->total_exceptions,
            'last_error_at'     => $this->last_error_at,
            'created_at'        => $this->created_at,
        ];
    }
}
