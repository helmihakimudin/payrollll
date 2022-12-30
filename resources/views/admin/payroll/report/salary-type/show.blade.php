<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Salary </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <div class="kt-widget kt-widget--user-profile-3">
        <div class="kt-widget__top">
            <div class="kt-widget__media">
                <img src="{{ asset('demo10/assets/media/users/100_12.jpg')}}" alt="image">
            </div>
            <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-bolder kt-font-light kt-hidden">
                JM
            </div>
            <div class="kt-widget__content">
                <div class="kt-widget__head">
                    <div class="kt-widget__user">
                        <a href="#" class="kt-widget__username">
                            {{$payslip->full_name}}
                        </a>
                        <span class="kt-badge kt-badge--bolder kt-badge kt-badge--inline kt-badge--unified-success">{{$payslip->job_position}}</span>
                    </div>
                </div>
                <div class="kt-widget__subhead">
                    <a href="#"><i class="flaticon2-calendar-3"></i>{{$payslip->organization}}</a>
                    <a href="#"><i class="flaticon2-placeholder"></i>{{$payslip->branch}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Allowance
                        </h3>
                    </div>
                </div>
                <div class="kt-form kt-form--label-left">
                    @php 
                     $allowance = json_decode($payslip->allowance);
                    @endphp
                    <div class="kt-portlet__body">
                        @foreach($allowance as $row)
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">{{$row->component}}:</label>
                            <div class="col-8">
                                <span class="form-control-plaintext kt-font-bolder">{{"Rp.".number_format($row->amount)}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Deduction
                        </h3>
                    </div>
                </div>
                <div class="kt-form kt-form--label-left">
                    @php 
                     $deductions = json_decode($payslip->deduction);
                    @endphp
                    <div class="kt-portlet__body">
                        @foreach($deductions as $row)
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">{{$row->component}}:</label>
                            <div class="col-8">
                                <span class="form-control-plaintext kt-font-bolder">{{"Rp.".number_format($row->amount)}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            &nbsp;
        </div>
        <div class="col-lg-6">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Take Home Pay
                        </h3>
                    </div>
                </div>
                <div class="kt-form kt-form--label-left">
                    <div class="kt-portlet__body">
                        <h1>{{"Rp.".number_format($payslip->net_payble)}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
</div>