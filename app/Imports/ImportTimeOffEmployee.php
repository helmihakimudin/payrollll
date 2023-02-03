<?php

namespace App\Imports;

use App\TimeOffEmployee;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ImportTimeOffEmployee implements WithMultipleSheets, SkipsUnknownSheets, WithStartRow
{
    public function sheets(): array
    {
        return [
            'Time Off Employee' => new ImportTimeOffEmployee(),
        ];
    }
    
    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }

    public function startRow(): int
    {
        return 2;
    }


}
