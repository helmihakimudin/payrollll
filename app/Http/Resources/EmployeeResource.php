<?php

namespace App\Http\Resources;

use App\Calendar;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPSTORM_META\map;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        // foreach ($data as $key => $value) {
        //     $data[$key]['shift_id'] = new CalendarResource($this->calendars);
        // }
        // dd($data);
        return [
            'success' => true,
            'message' => 'get data user',
            'data' => [
                'id' => $this->id,
                'user' => new UserResource($this->user),
                // 'user' => $this->user_id,
                'shift' => new ShiftResource($this->shift),
                // 'location' => new LocationResource($this->locations),
                // 'shift' => $this->shift_id,
                'name' => $this->name,
                'dob' => $this->dob,
                'pob' => $this->pob,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'id_card' => $this->id_card,
                'employee_status' => $this->employee_status,
                'merriage_status' => $this->merriage_status,
                'family_card' => $this->family_card,
                'id_card_address' => $this->id_card_address,
                'number_children' => $this->number_children,
                'address' => $this->address,
                'email' => $this->email,
                'password' => $this->password,
                'contract_status' => $this->contract_status,
                'employee_id' => $this->employee_id,
                'branch_id' => $this->branch_id,
                'department_id' => $this->department_id,
                'designation_id' => $this->designation_id,
                'company_id' => $this->company_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'documents' => $this->documents,
                'account_holder_name' => $this->account_holder_number,
                'account_number' => $this->account_number,
                'bank_number' => $this->bank_number,
                'bank_name' => $this->bank_name,
                'bank_identifier_code' => $this->bank_identifier_code,
                'branch_location' => $this->branch_location,
                'tax_payer_id' => $this->tax_payer_id,
                'salary_type' => $this->salary_type,
                'salary' => $this->salary,
                'calculate_work' => $this->calculate_work,
                'amount_work' => $this->amount_work,
                'calculate_salary' => $this->calculate_salary,
                'amount_salary' => $this->amount_salary,
                'net_salary' => $this->net_salary,
                'keterangan' => $this->keterangan,
                'is_active' => $this->is_active,
                'amount_of_leave' => $this->amount_of_leave,
                'amount_paid_leave' => $this->amount_paid_leave,
                'reason' => $this->reason,
                'first_login_password' => $this->first_login_password,
                'created_by' => $this->created_by,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
