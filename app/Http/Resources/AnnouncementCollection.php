<?php

namespace App\Http\Resources;

use App\Announcement;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AnnouncementCollection extends ResourceCollection
{
    public $status;
    public $message;

    public $collects = Announcement::class;

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

    public function toArray($request)
    {
            return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->collection,
        ];
    }
}
