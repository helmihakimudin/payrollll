<?php

namespace App\Exports;

use App\TimeOffEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTimeOffEmployee implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TimeOffEmployee::all();
    }
}
