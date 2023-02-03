<?php

namespace App\Exports;

use App\Timeoff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportTimeOffCode implements FromView, WithTitle
{
    public function title(): string
    {
         return 'Time Off';
    }
    public function view(): View
    {
        
        $timeoff = Timeoff::all();

        return view('admin.timeoff.export-timeoffcode',compact('timeoff'));
    }
}
