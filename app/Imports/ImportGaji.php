<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\ImportKaryawan;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ImportGaji implements ToModel,WithCalculatedFormulas, WithStartRow
{
    public function model(array $row)
    {

    }

    private $setStartRow = 1;

    public function setStartRow($setStartRow){
        $this->setStartRow = $setStartRow;
    }

    public function startRow() : int{
        return $this->setStartRow;
    }
}
