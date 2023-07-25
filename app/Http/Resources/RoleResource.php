<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public $status_code;
    public $message;
    public $resource;

    public function __construct($status_code, $message, $resource)
    {
        parent::__construct($resource);
        $this->status_code  = $status_code;
        $this->message = $message;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status_code' => $this->status_code,
            'message'   => $this->message,
            'data' => $this->resource
        ];
    }
}
