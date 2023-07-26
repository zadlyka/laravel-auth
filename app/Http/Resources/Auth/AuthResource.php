<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public $status_code;
    public $message;

    public function __construct($resource, $status_code = 200, $message = 'success')
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
        return parent::toArray($request);
    }

    public function with(Request $request): array
    {
        return [
            'status_code' => $this->status_code,
            'message' => $this->message
        ];
    }
}
