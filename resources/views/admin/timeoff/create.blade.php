@extends('layout-admin.base', [
    'pages' => 'Setting Attemdance',
    'subpages' => 'Setting Attemdance',
])

@push('css')
<style>
    .btn:focus, .btn.focus {
        outline: 0;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }

    .el-none, .el-none1, .el-none2{
        display: none;
    }
    #alert_err{
        background-color: transparent;
        color: red;
        border: red;
    }
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Add New Time Off</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('timeoff')}}" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                    <i class="la la-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="kt-portlet__body">
            <form class="kt-form" action="{{route('timeoff.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Name Time Off*</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                            @error('name')
                                <div class="alert alert-danger" id="alert_err">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Code Time Off*</label>
                            <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror">
                            @error('code')
                                <div class="alert alert-danger" id="alert_err">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Description Time Off <small>(optional)</small></label>
                            <input type="text" id="description" name="description" class="form-control @error('description') is-invalid @enderror">
                            @error('description')
                                <div class="alert alert-danger alert-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Effective as off*</label>
                            <div class="input-group date">
                                <input type="text" id="effective_date" name="effective_date" class="form-control datepicker @error('effective_date') is-invalid @enderror" id="kt_datepicker_3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            @error('effective_date')
                                <div class="alert alert-danger" id="alert_err">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Expired Date</label>
                            <div class="input-group date">
                                <input type="text" id="expired_date" name="expired_date" class="form-control datepicker @error('expired_date') is-invalid @enderror" id="kt_datepicker_3">
                                @error('expired_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 text-right">
                        <hr>
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
@endpush
