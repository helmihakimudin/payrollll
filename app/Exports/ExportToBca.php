<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Payslip;

class ExportToBca implements FromView,WithEvents
{
    private $salary_month;
  

    public function __construct($salary_month)
    {
        $this->salary_month  = $salary_month;       
    }
  
    public function view(): View
    {
       
       $payslip = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
                  ->select('employees.name','employees.account_holder_name','employees.account_number','pay_slips.salary_month','pay_slips.basic_salary','pay_slips.net_payble')
                  ->where('pay_slips.salary_month',$this->salary_month)->get();
       return view('admin.slipgaji.export',['payslip'=>$payslip,'salary_month'=>$this->salary_month]);
     
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '0000000'],
                            'bold'=>true,
                        ],
                    ],
                    $borderArray =[
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '0000000'],
                                'bold'=>true,
                            ],
                        ],
                    ],
                    $styleArray2 = [
                        'borders' => [
                            'outline' => [
                                'color' => ['argb' => '0000000'],
                                'bold'=>true,
                            ],
                        ],
                      
                    ],

                    
                  
                ];

                //width
                $event->sheet->getColumnDimension('A')->setWidth(30);
                $event->sheet->getColumnDimension('B')->setWidth(25);
                $event->sheet->getColumnDimension('C')->setWidth(30);
   
                /* font */
                $event->sheet->getStyle('A1:C1')->getFont()->setBold(true);

                //align
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('left');
                $event->sheet->getStyle('B1')->getAlignment()->setHorizontal('left');
                $event->sheet->getStyle('C1')->getAlignment()->setHorizontal('center');

                $event->sheet->getStyle('A1:C1')->applyFromArray($borderArray);

               
                $event->sheet->getStyle('A1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                $event->sheet->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');


         
                $count = Payslip::where('pay_slips.salary_month',$this->salary_month)->count();
                $n=1;
                $i=2;
                $total = $n + $count;
                for($i; $i<=$total;$i++){
                    // if($i%2 == 0){
                    //     $event->sheet->getStyle('A'.strval($i).':C'.strval($i))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC');
                    // }else{
                    //     $event->sheet->getStyle('A'.strval($i).':C'.strval($i))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
                    // }
                    $event->sheet->getStyle('A'.strval($i))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('B'.strval($i))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('C'.strval($i))->getAlignment()->setHorizontal('left');


                    $event->sheet->getStyle('A'.strval($n).':A'.strval($i))->applyFromArray($borderArray);
                    $event->sheet->getStyle('B'.strval($n).':B'.strval($i))->applyFromArray($borderArray);
                    $event->sheet->getStyle('C'.strval($n).':C'.strval($i))->applyFromArray($borderArray);
             
                }
            },
        ];
    }
}
