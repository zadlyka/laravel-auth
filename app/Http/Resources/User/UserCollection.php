<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => UserResource::collection($this->collection)
        ];
    }

    public function with(Request $request): array
    {
        return [
            'status_code' => $this->status_code,
            'message' => $this->message
        ];
    }
}
