<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Karyawan;
use App\Branch;
use App\Department;
use App\Designation;
use Auth;


class KaryawanImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {

        $cek = Karyawan::where('email',$row['email'])->exists();
        if($cek){
            return null;
        }else{
            $branch = Branch::where('name',$row['cabang'])->first();
            if(isset($branch->name)){
                $perusahaan = $branch->id;
            }else{
                $perusahaan = 0;
            }
            $departemen = Department::where('name',$row['departemen'])->first();
            if(isset($departemen->name)){
                $departemen = $departemen->id;
            }else{
                $departemen = 0;
            }
            $designation = Designation::where('name',$row['jabatan'])->first();
            if(isset($designation->name)){
                $jabatan = $designation->id;
            }else{
                $jabatan = 0;
            }
            $tanggal_lahir  = intval($row['tanggal_lahir']);
            $company        = intval($row['tanggal_bergabung']);
            $endate         = intval($row['sampai_tanggal']);
            $karyawan =  new Karyawan([
                'user_id' => 0,
                'net_salary' => 0,
                'name' => $row['nama']?? "-",
                'pob' => $row['tempat_lahir']??"-",
                'dob' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_lahir))?? " ",
                'gender' => $row['jenis_kelamin']??"-",
                'employee_status'=>$row['status_karyawan']??"-",
                'merriage_status'=>$row['status_pernikahan']??"-",
                'number_children'=>$row['jumlah_anak']??0,
                'contract_status'=>$row['status_kontrak']??"-",
                'phone' => $row['nomor_handphone']??0,
                'id_card' => $row['nomor_ktp']??0,
                'family_card' => $row['nomor_kk']??0,
                'id_card_address' => $row['alamat_ktp']??0,
                'address' => $row['alamat']??"-",
                'branch_id' => $perusahaan ??0,
                'department_id' => $departemen??0,
                'designation_id' => $jabatan??0,
                'email' => $row['email']??"-",
                'password' => \Hash::make($row['password'])??"-",
                'employee_id' => 0,
                'documents' => "-",
                'company_doj' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($company))??date("Y-m-d"),
                'start_date' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($company))??date("Y-m-d"),
                'end_date' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($endate)) ??date("Y-m-d"),
                'account_holder_name' => $row['nama_rekening']??"-",
                'account_number' => $row['nomor_rekening']??0,
                'bank_name' => $row['nama_bank']??"-",
                'tax_payer_id'=>$row['npwp']??0,
                'created_by'=>Auth::user()->id
            ]);

         return $karyawan;
        }

    }
}
