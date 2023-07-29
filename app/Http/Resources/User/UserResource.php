<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $status_code;
    private $message;

    public function __construct($resource, $status_code = Response::HTTP_OK, $message = 'Success')
    {
        parent::__construct($resource);
        $this->status_code = $status_code;
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
