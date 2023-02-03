<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportTimeOffEmployeeMultipleSheets implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Worksheet 1' => new ExportTimeOffEmployee(),
            'Worksheet 2' => new ExportTimeOffCode(),
            'Worksheet 3' => new ExportEmployeeCode(),
            'Worksheet 4' => new ExportTimeoffassignTypeCode(),

        ];
    }

}
