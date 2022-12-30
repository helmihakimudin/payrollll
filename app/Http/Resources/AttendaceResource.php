<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendaceResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'attendance_employee' => $this->attendance_code,
        //     'date' => $this->date,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at
        // ];
    }
}
