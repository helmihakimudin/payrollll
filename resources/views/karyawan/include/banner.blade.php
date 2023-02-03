
<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body position-relative">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="mb-lg-5">
                            <small>Good Afternoon</small>
                            <h3 class="kt-portlet__head-title user-hello">
                                {{" ".Auth::guard('emp')->user()->full_name}}
                            </h3>
                            <label class="font-11px">It's {{ Carbon\Carbon::now()->locale('en')->isoFormat('dddd, D MMMM') }}</label>
                        </div>
                        <label>Shortcut</label>
                        <div class="form-group row">
                            <a href="{{route('emp.account.attendance',Auth::guard('emp')->user()->id)}}" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill mb-3 w-24">
                                Request Attendance
                            </a>
                            <a href="{{route('emp.account.timeoff',Auth::guard('emp')->user()->id)}}" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill  mb-3 w-24">
                                Request Time Off
                            </a>
                            <a href="{{route('emp.account.overtime',Auth::guard('emp')->user()->id)}}" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill  mb-3 w-24">
                                Request Over Time
                            </a>
                            <a href="{{route('emp.account.shift',Auth::guard('emp')->user()->id)}}" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill mb-3 w-22">
                                Request Change Shift
                            </a>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-2 position-absolute" style="top: 0%; bottom:0%; right:0%">
                    @if($gender->gender == 'Male')
                    <img src="{{asset('logo/boy_working-1.png')}}" class="w-100">
                    @elseif($gender->gender == 'Female') 
                    <img src="{{asset('logo/girl_working-1.png')}}" class="w-100">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>