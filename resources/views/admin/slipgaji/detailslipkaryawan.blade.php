<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Slipgaji Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
   <form action="{{route('slipgaji.detail.karyawan.update',$payslips->id)}}" method="POST" id="form-slip-edit" >
    @csrf
    @method('PUT')
       <div class="row">
           <div class="col-lg-6">
               <div class="form-group">
                    <label for="">Nama Karyawan</label>
                    <input type="hidden" class="form-control" name="employee_id" value="{{$payslips->employee_id}}" readonly>
                   <input type="text" class="form-control" value="{{$payslips->name}}" readonly>
               </div>
           </div>
           <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Gaji Bulan</label>
                    <input type="text" name="salary_month" class="form-control" value="{{date('M Y',strtotime($payslips->salary_month))}}" readonly>
                </div>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Detail Pendapatan : </label>
                </div>
                @foreach($allowance as $row)
                <div class="form-group">
                    <label for="">{{$row->jenis_pendapatan}}  </label>
                    <input type="hidden" value="{{$row->id}}" name="allowances_id[]">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">Rp. </span></div>
                        <input type="text" name="amount_allowances[]" class="form-control nominal" value="{{number_format($row->amount,0,',',',')}}">
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Detail Pemotongan : </label>
                </div>
                @foreach($deductions as $row)
                <div class="form-group">
                    <label for="">{{$row->jenis_pemotongan}}  </label>
                    <input type="hidden" value="{{$row->id}}" name="deductions_id[]">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">Rp. </span></div>
                        <input type="text" name="amount_deductions[]" class="form-control nominal" value="{{number_format($row->amount,0,',',',')}}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
   </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" form="form-slip-edit" class="btn btn-primary">Update</button>
</div>