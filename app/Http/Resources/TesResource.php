<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TesResource extends JsonResource
{
    //define properti
    public $success;
    public $message;
    public $data;

    /**
     * __construct
     *
     * @param  mixed $success
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($success, $message, $data)
    {
        // parent::__construct($data);
        $this->data = $data;
        $this->success  = $success;
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
            "success" => $this->success,
            "message" => $this->message,
            "data" => $this->data
        ];
    }
}
