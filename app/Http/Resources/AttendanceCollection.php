<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttendanceCollection extends ResourceCollection
{
    public $status;
    public $message;

    public $collects = AttendaceResource::class;

    /**
     * __construct
     * @param mixed $status
     * @param mixed $message
     * @param mixed $resource
     * @return void
     */


    public function __construct($status, $message, $collects)
    {
        parent::__construct($collects);
        $this->status = $status;
        $this->message = $message;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->collection,
        ];
    }
}
