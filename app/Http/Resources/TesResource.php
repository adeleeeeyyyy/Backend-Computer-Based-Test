<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TesResource extends JsonResource
{
    //define properti
    public $status;
    public $message;
    public $data;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $data)
    {
        parent::__construct($data);
        $this->status  = $status;
        $this->message = $message;
    }

    /**
     * toArray
     *
     * @param  mixed $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return  [
            "status" => $this->status,
            "message" => $this->message,
            "data" => $this->data
        ];
    }
}
