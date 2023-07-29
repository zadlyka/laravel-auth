<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
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
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => RoleResource::collection($this->collection)
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
