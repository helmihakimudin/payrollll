@extends('karyawan.account.index',[
	'pages'=>'payroll',
	'subpages'=>'payroll-info'
])
@section('content-account')

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Payroll Info
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="bpjs">BPJS Ketenagakerjaan</label>
                    <input type="text" value="123" class="form-control">
                </div>
                <div class="form-group">
                    <label for="npwp">NPWP</label>
                    <input type="text" value="00.00000.00000.0000" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Bank Account">Bank Account</label>
                    <input type="text" value="{{Auth::guard("emp")->user()->account_number}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="PTKP Status">PTKP Status</label>
                    <input type="text" value="{{"TK/0"}}" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="bpjs kesehatan">BPJS Kesehatan</label>
                    <input type="text" value="123" class="form-control">
                </div>
                <div class="form-group">
                    <label for="bank name">Bank Name</label>
                    <input type="text" value="{{Auth::guard("emp")->user()->bank_name}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="account-holder-name">Bank Account Holder Name</label>
                    <input type="text" value="{{Auth::guard("emp")->user()->account_holder_name}}"class="form-control">
                </div>
            </div>
       </div>
    </div>
    <!--end::Form-->
</div>
@endsection
@push('scriptjs')
<script>

</script>
@endpush