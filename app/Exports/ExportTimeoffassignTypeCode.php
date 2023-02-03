<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;

class ExportTimeoffassignTypeCode implements FromView, WithTitle
{
    public function title(): string
    {
         return 'Type';
    }
    public function view(): View
    {
        return view('admin.timeoff.export-timeofftype');
    }
}
