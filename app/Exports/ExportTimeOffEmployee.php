<?php

namespace App\Exports;

use App\TimeOffEmployee;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportTimeOffEmployee implements FromView, WithTitle
{
    public function title(): string
     {
          return 'Time Off Employee';
     }

    public function view(): View
    {
        $timeoffemployee = TimeOffEmployee::all();

        return view('admin.timeoff.export-timeoffemployee',compact('timeoffemployee'));
    }
}


