<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Employee;


class ExportGaji implements FromView,WithEvents
{


    public function view(): View
    {
       $karyawan = Employee::leftjoin('payroll_employee_component','employees.id','=','payroll_employee_component.employee_id')->leftjoin('import_payrolls','employees.id','=','import_payrolls.employee_id')->leftjoin('pay_slips','employees.id','=','pay_slips.employee_id')->leftjoin('job_position','employees.job_position_id','=','job_position.id')
                            ->select('employees.id','employees.full_name','employees.employee_id','employees.email','employees.gender','employees.marital_status','job_position.name as jobposition_name','employees.join_date','employees.employeement_status','pay_slips.basic_salary','pay_slips.net_payble','payroll_employee_component.component','import_payrolls.total_attendance','import_payrolls.total_working_permonth')
                            ->where('employees.employee_status','Active')
                            ->get();
       return view('admin.karyawan.export-gaji',compact('karyawan'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->freezePane('A2');
                $event->sheet->freezePane('C3');
            },
        ];
    }
}
