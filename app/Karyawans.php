<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Karyawan extends Model
{
    protected $table ="employees";

    protected $fillable = [
        'id',
        'full_name',
        'first_name',
        'last_name',
        'email',
        'mobile_phone',
        'phone',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'marital_status',
        'blood_type',
        'religion',
        'identity_type',
        'identity_number',
        'expired_identity',
        'postal_code',
        'citizien_id_address',
        'residential_address',
        'employee_id',
        'barcode',
        'employee_status',
        'company_doj',
        'end_date',
        'branch_id',
        'organization_id',
        'job_position_id',
        'job_level_id',
        'schedule_id',
        'approval_line_id',
        'basic_salary',
        'salary_type',
        'payment_schedule',
        'preorate_setting',
        'cost_center_category',
        'allowance_overtime',
        'account_holder_name',
        'account_number',
        'bank_name',
        'npwp',
        'ptkp_status',
        'tax_method',
        'tax_salary',
        'taxable_date',
        'employeement_tax_status',
        'netto',
        'pph21',
        'bpjs_kerja_date',
        'bpjs_kesehatan_number',
        'bpjs_kesehatan_family',
        'bpjs_kesehatan_date',
        'bpjs_kesehatan_cost',
        'bpjs_jht_cost',
        'jaminan_pensiun_cost',
        'jaminan_pensiun_date',
        'employeement_status',
        'created_by',
    ];

    public function employeePayrollComponent()
    {
        return $this->belongsTo("App\EmployeePayrollComponent");

    }

    public static function gajibersih($id){

        $tunjangan = Allowance::where('employee_id',$id)->where('month',date('Y-m'))->get();
        $total_tunjangan = 0;
        foreach ($tunjangan as $row) {
            $total_tunjangan = $row->amount + $total_tunjangan;
        }

        $pengurangan      = SaturationDeduction::where('employee_id', '=', $id)->where('month',date('Y-m'))->get();
        $total_pengurangan = 0;
        foreach ($pengurangan as $row) {
            $total_pengurangan = $row->amount + $total_pengurangan;
        }

        $advance_salary = $total_tunjangan  - $total_pengurangan;
        $employee       = Karyawan::where('id', '=', $id)->first();
        $net_salary = $advance_salary + $employee->net_salary;
        $employee->save();
        return $net_salary;
    }

    public static function tunjangan($id){
        $tunjangan = Allowance::join('allowance_options','allowances.allowance_option','=','allowance_options.id')->where('allowances.employee_id',$id)->where('allowances.month',date('Y-m'))->orderBy('allowance_options.name','ASC')->get();
        $total_tunjangan = 0;
        foreach ($tunjangan as $row) {
            $total_tunjangan = $row->amount + $total_tunjangan;
        }

        $tunjangan_json = json_encode($tunjangan);

        return $tunjangan_json;
    }

    public static function pengurangan($id){
        $pengurangan      = SaturationDeduction::join('deduction_options','saturation_deductions.deduction_option','=','deduction_options.id')->where('saturation_deductions.employee_id', '=', $id)->where('saturation_deductions.month',date('Y-m'))->orderBy('deduction_options.name','ASC')->get();
        $total_pengurangan = 0;
        foreach ($pengurangan as $row) {
            $total_pengurangan = $row->amount + $total_pengurangan;
        }
        $pengurangan_json = json_encode($pengurangan);

        return $pengurangan_json;
    }


    /*update json slip gaji */
    public static function updategajibersih($salary_month, $id){

        $tunjangan = Allowance::where('employee_id',$id)->where('month',date('Y-m',strtotime($salary_month)))->get();
        $total_tunjangan = 0;
        foreach ($tunjangan as $row) {
            $total_tunjangan = $row->amount + $total_tunjangan;
        }

        $pengurangan      = SaturationDeduction::where('employee_id', '=', $id)->where('month',date('Y-m',strtotime($salary_month)))->get();
        $total_pengurangan = 0;
        foreach ($pengurangan as $row) {
            $total_pengurangan = $row->amount + $total_pengurangan;
        }

        $advance_salary = $total_tunjangan  - $total_pengurangan;
        $employee       = Karyawan::where('id', '=', $id)->first();
        $net_salary = $advance_salary + $employee->net_salary;
        $employee->save();
        return $net_salary;
    }

    public static function updatetunjangan($salary_month, $id){

        $tunjangan = Allowance::join('allowance_options','allowances.allowance_option','=','allowance_options.id')->where('allowances.employee_id',$id)->where('allowances.month',date('Y-m',strtotime($salary_month)))->orderBy('allowance_options.name','ASC')->get();
        $total_tunjangan = 0;
        foreach ($tunjangan as $row) {
            $total_tunjangan = $row->amount + $total_tunjangan;
        }

        $tunjangan_json = json_encode($tunjangan);

        return $tunjangan_json;
    }

    public static function updatepengurangan($salary_month, $id){
        $pengurangan      = SaturationDeduction::join('deduction_options','saturation_deductions.deduction_option','=','deduction_options.id')->where('saturation_deductions.employee_id', '=', $id)->where('saturation_deductions.month',date('Y-m',strtotime($salary_month)))->orderBy('deduction_options.name','ASC')->get();
        // dd($pengurangan,date('Y-m',strtotime(salary_month)),$id);
        $total_pengurangan = 0;
        foreach ($pengurangan as $row) {
            $total_pengurangan = $row->amount + $total_pengurangan;
        }
        $pengurangan_json = json_encode($pengurangan);

        return $pengurangan_json;
    }


}
