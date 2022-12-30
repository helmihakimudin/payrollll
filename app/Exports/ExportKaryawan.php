<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Karyawan;
use App\Branch;
use App\Department;
use App\Designation;
use App\Contract;
class ExportKaryawan implements FromView,WithEvents,WithColumnFormatting
{
    public function view(): View
    {
  
        $employees =  Karyawan::all();

        $data = array();

     
        foreach ($employees as $employee) {
            $arr['id'] = $employee->id;
            $arr['user_id'] = $employee->user_id;
            $arr['name'] = $employee->name;
            $arr['email'] = $employee->email;
            $arr['pob'] = $employee->pob;
            $arr['dob'] = date('n/d/Y',strtotime($employee->dob));
            $arr['gender'] = $employee->gender;
            $arr['family_card'] = $employee->family_card;
            $arr['employee_status'] = $employee->employee_status;
            $arr['merriage_status'] = $employee->merriage_status;
            $arr['number_children'] = $employee->number_children;
            $arr['contract_status'] = $employee->contract_status;
            $arr['phone'] = $employee->phone;
            $arr['id_card'] = $employee->id_card;
            $arr['family_card'] = $employee->family_card;
            $arr['id_card_address'] = $employee->id_card_address;
            $arr['address'] = $employee->address;
            $arr['password'] = $employee->password;
            $arr['employee_id'] = $employee->employee_id;
            $arr['branch_id'] = $employee->branch_id;
            $arr['department_id'] = $employee->department_id;
            $arr['designation_id'] = $employee->designation_id;
            $arr['company_doj'] = date('n/d/Y',strtotime($employee->company_doj));
            $arr['end_date'] = date('n/d/Y',strtotime($employee->end_date));
            $arr['account_holder_name'] = $employee->account_holder_name;
            $arr['account_number'] = $employee->account_number;
            $arr['bank_name'] = $employee->bank_name;
            $arr['tax_payer_id'] = $employee->tax_payer_id;
            $arr['salary_type'] = $employee->salary_type;
            $arr['salary'] = $employee->salary; 
            $arr['tax_payer_id'] = $employee->tax_payer_id; 
            array_push($data, $arr);
        }
        return view('admin.karyawan.export', [
            'data' => $data
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
            'P' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'T' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'U' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->freezePane('A1');
                $event->sheet->freezePane('E3');
                $alignmentArray  =[
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],   
                ];
                $borderArray =[
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '0000000'],
                            'bold'=>true,
                        ],
                    ],
                ];
                $borderArrayBold =[
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '0000000'],
                            'bold'=>true,
                        ],
                    ],
                ];

                /* border */
                $event->sheet->getStyle('A1')->applyFromArray($borderArray);
                $event->sheet->getStyle('B1')->applyFromArray($borderArray);
                $event->sheet->getStyle('C1')->applyFromArray($borderArray);
                $event->sheet->getStyle('D1')->applyFromArray($borderArray);
                $event->sheet->getStyle('E1')->applyFromArray($borderArray);
                $event->sheet->getStyle('F1')->applyFromArray($borderArray);
                $event->sheet->getStyle('G1')->applyFromArray($borderArray);
                $event->sheet->getStyle('H1')->applyFromArray($borderArray);
                $event->sheet->getStyle('I1')->applyFromArray($borderArray);
                $event->sheet->getStyle('J1')->applyFromArray($borderArray);
                $event->sheet->getStyle('K1')->applyFromArray($borderArray);
                $event->sheet->getStyle('L1')->applyFromArray($borderArray);
                $event->sheet->getStyle('M1')->applyFromArray($borderArray);
                $event->sheet->getStyle('N1')->applyFromArray($borderArray);
                $event->sheet->getStyle('O1')->applyFromArray($borderArray);
                $event->sheet->getStyle('P1')->applyFromArray($borderArray);
                $event->sheet->getStyle('Q1')->applyFromArray($borderArray);
                $event->sheet->getStyle('R1')->applyFromArray($borderArray);
                $event->sheet->getStyle('S1')->applyFromArray($borderArray);
                $event->sheet->getStyle('T1')->applyFromArray($borderArray);
                $event->sheet->getStyle('V1')->applyFromArray($borderArray);
                $event->sheet->getStyle('W1')->applyFromArray($borderArray);
                $event->sheet->getStyle('X1')->applyFromArray($borderArray);
                $event->sheet->getStyle('Y1')->applyFromArray($borderArray);
                $event->sheet->getStyle('Z1')->applyFromArray($borderArray);
                $event->sheet->getDelegate()->setAutoFilter('A1:'.$event->sheet->getDelegate()->getHighestColumn().'1');

                /* color */
                $event->sheet->getStyle('B1:Z1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC');
                /* font */
                $event->sheet->getStyle('A1:Z1')->getFont()->setBold(true);

                /*wrap text */
                $event->sheet->getStyle('A1:Z1')->getAlignment()->setWrapText(true);

                /*alignment Array */
                $event->sheet->getStyle('A1:Z1')->applyFromArray($alignmentArray);

                /* width & height */
                $event->sheet->getRowDimension('1')->setRowHeight(30);
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(0);
                $event->sheet->getColumnDimension('C')->setWidth(25);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(25);
                $event->sheet->getColumnDimension('F')->setWidth(25);
                $event->sheet->getColumnDimension('G')->setWidth(25);
                $event->sheet->getColumnDimension('H')->setWidth(28);
                $event->sheet->getColumnDimension('I')->setWidth(23);
                $event->sheet->getColumnDimension('J')->setWidth(25);
                $event->sheet->getColumnDimension('K')->setWidth(25);
                $event->sheet->getColumnDimension('L')->setWidth(18);
                $event->sheet->getColumnDimension('M')->setWidth(20);
                $event->sheet->getColumnDimension('N')->setWidth(20);
                $event->sheet->getColumnDimension('O')->setWidth(20);
                $event->sheet->getColumnDimension('P')->setWidth(20);
                $event->sheet->getColumnDimension('Q')->setWidth(25);
                $event->sheet->getColumnDimension('R')->setWidth(25);
                $event->sheet->getColumnDimension('S')->setWidth(25);
                $event->sheet->getColumnDimension('T')->setWidth(25);
                $event->sheet->getColumnDimension('U')->setWidth(25);
                $event->sheet->getColumnDimension('V')->setWidth(25);
                $event->sheet->getColumnDimension('W')->setWidth(25);
                $event->sheet->getColumnDimension('X')->setWidth(25);
                $event->sheet->getColumnDimension('Y')->setWidth(25);
                $event->sheet->getColumnDimension('Z')->setWidth(25);

                $n=2;
                $count = Karyawan::count();
                $total = $n + $count;
        
                for($n;$n<$total;$n++){
                    $branch = Branch::all();
                    $arr = array();
                    foreach($branch as $row){
                        $arr[] = $row->name;
                    }
                    $Department = Department::all();
                    $arr2 = array();
                    foreach($Department as $row){
                        $arr2[] = $row->name;
                    }

                    $Designation = Designation::all();
                    $arr3 = array();
                    foreach($Designation as $row){
                        $arr3[] = $row->name;
                    }
                    
                    $Contract = Contract::all();
                    $arr4 = array();
                    foreach($Contract as $row){
                        $arr4[] = $row->contract_name;
                    }

                    
                    $text  = implode(",",$arr);
                    $text2 = implode(",",$arr2);
                    $text3 = implode(",",$arr3);
                    $text4 = implode(",",$arr4);

                    
                    $event->sheet->setCellValue('Q'.strval($count+2), "Pilih Perusahaan");
                    $event->sheet->setCellValue('R'.strval($count+2), "Pilih Departement");
                    $event->sheet->setCellValue('S'.strval($count+2), "Pilih Jabatan");
                    $event->sheet->setCellValue('V'.strval($count+2), "Pilih Status Kontrak");
                    $event->sheet->setCellValue('G'.strval($count+2), "Pilih Jenis Kelamin");
                    $event->sheet->setCellValue('H'.strval($count+2), "Pilih Status");
                    $event->sheet->setCellValue('I'.strval($count+2), "Pilih Status Pernikahan");
                    
                    $configs  = $text;
                    $configs2 = $text2;
                    $configs3 = $text3;
                    $configs4 = $text4;
                    $configs5 = "Laki-laki,Perempuan";
                    $configs6 = "Aktif,Tidak Aktif";
                    $configs7 = "Menikah,Belum Menikah";

                    $objValidation = $event->sheet->getCell('Q'.strval($count+2))->getDataValidation();
                    $objValidation->setType(DataValidation::TYPE_LIST);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setFormula1('"' . $configs . '"');
                   
                    $objValidation2 = $event->sheet->getCell('R'.strval($count+2))->getDataValidation();
                    $objValidation2->setType(DataValidation::TYPE_LIST);
                    $objValidation2->setShowInputMessage(true);
                    $objValidation2->setShowErrorMessage(true);
                    $objValidation2->setShowDropDown(true);
                    $objValidation2->setFormula1('"' . $configs2 . '"');

                    $objValidation3 = $event->sheet->getCell('S'.strval($count+2))->getDataValidation();
                    $objValidation3->setType(DataValidation::TYPE_LIST);
                    $objValidation3->setShowInputMessage(true);
                    $objValidation2->setShowErrorMessage(true);
                    $objValidation3->setShowDropDown(true);
                    $objValidation3->setFormula1('"' . $configs3 . '"');

                    $objValidation4 = $event->sheet->getCell('V'.strval($count+2))->getDataValidation();
                    $objValidation4->setType(DataValidation::TYPE_LIST);
                    $objValidation4->setShowInputMessage(true);
                    $objValidation4->setShowErrorMessage(true);
                    $objValidation4->setShowDropDown(true);
                    $objValidation4->setFormula1('"' . $configs4 . '"');

                    $objValidation5 = $event->sheet->getCell('G'.strval($count+2))->getDataValidation();
                    $objValidation5->setType(DataValidation::TYPE_LIST);
                    $objValidation5->setShowInputMessage(true);
                    $objValidation5->setShowErrorMessage(true);
                    $objValidation5->setShowDropDown(true);
                    $objValidation5->setFormula1('"' . $configs5 . '"');

                    $objValidation6 = $event->sheet->getCell('H'.strval($count+2))->getDataValidation();
                    $objValidation6->setType(DataValidation::TYPE_LIST);
                    $objValidation6->setShowInputMessage(true);
                    $objValidation6->setShowErrorMessage(true);
                    $objValidation6->setShowDropDown(true);
                    $objValidation6->setFormula1('"' . $configs6 . '"');

                    $objValidation7 = $event->sheet->getCell('I'.strval($count+2))->getDataValidation();
                    $objValidation7->setType(DataValidation::TYPE_LIST);
                    $objValidation7->setShowInputMessage(true);
                    $objValidation7->setShowErrorMessage(true);
                    $objValidation7->setShowDropDown(true);
                    $objValidation7->setFormula1('"' . $configs7 . '"');
    
                    $event->sheet->getStyle('B'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('C'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('D'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('E'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('F'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('G'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('H'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('I'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('J'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('K'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('L'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('M'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('N'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('O'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('P'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('Q'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('R'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('S'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('T'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('U'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('V'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('W'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('X'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('Y'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('Z'.strval($n))->getAlignment()->setHorizontal('right');

                    if($n % 2 == 0){
                        $event->sheet->getStyle('A'.strval($n).':Z'.strval($n))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
                    }else{
                        $event->sheet->getStyle('A'.strval($n).':Z'.strval($n))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC'); 
                    }
                    $event->sheet->getStyle('A'.strval(2).':A'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('B'.strval(2).':B'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('C'.strval(2).':C'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('D'.strval(2).':D'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('E'.strval(2).':E'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('F'.strval(2).':F'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('G'.strval(2).':G'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('H'.strval(2).':H'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('I'.strval(2).':I'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('J'.strval(2).':J'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('K'.strval(2).':K'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('L'.strval(2).':L'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('M'.strval(2).':M'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('N'.strval(2).':N'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('O'.strval(2).':O'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('P'.strval(2).':P'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('Q'.strval(2).':Q'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('R'.strval(2).':R'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('S'.strval(2).':S'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('T'.strval(2).':T'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('U'.strval(2).':U'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('V'.strval(2).':V'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('W'.strval(2).':W'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('X'.strval(2).':X'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('Y'.strval(2).':Y'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('Z'.strval(2).':Z'.strval($count+1))->applyFromArray($borderArray);
                }
            }
        ];
    }
}
