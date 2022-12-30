<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use DB;
use App\RequestPermission;
use Auth;

class exportPermission implements FromView,WithEvents
{
    private $export;


    public function __construct($export)
    {
        $this->export = $export;        
    }
    
    public function view(): View{
        $temp  = RequestPermission::join('employees','request_permissions.employee_id','=','employees.id')
                ->join('permission_types','request_permissions.permission_type_id','=','permission_types.id')
                ->select('request_permissions.id','employees.name as employee_name','permission_types.permission_type','permission_types.time','request_permissions.status','request_permissions.time_permission','request_permissions.time_result','request_permissions.status_permission','request_permissions.created_at')
                ->where('request_permissions.head_employee_id',Auth::user()->id)
                ->where('request_permissions.created_at',$this->export)
                ->get();
        return view('request-permission.export',compact('temp'));
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
                $event->sheet->getColumnDimension('A')->setWidth(25);
                $event->sheet->getColumnDimension('B')->setWidth(25);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(25);
                $event->sheet->getColumnDimension('F')->setWidth(25);
                $event->sheet->getColumnDimension('G')->setWidth(25);
                $event->sheet->getColumnDimension('I')->setWidth(25);
             
            },
        ];
    }
}
