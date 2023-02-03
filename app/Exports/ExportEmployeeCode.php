<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;


class ExportEmployeeCode implements FromView, WithTitle
{
    public function title(): string
    {
         return 'Employee';
    }
    public function view(): View
    {
        
        $employee = Employee::select('id', 'employee_id', 'full_name')->orderBy('full_name')->get();

        return view('admin.timeoff.export-employeecode',compact('employee'));
    }
}

