<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Edit Deduction
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-subheader__wrapper">
                <a href="javascript:;" class="btn btn-brand btn-elevate btn-icon-sm btn-close">
                    <i class="la la-minus"></i>
                    Close 
                </a>
                <button type="submit" form="form-deduction-option" class="btn btn-success btn-elevate btn-icon-sm">
                    <i class="la la-save"></i>
                    Update 
                </button>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="{{route('deduction-option.update',$deductionoption->id)}}" method="POST" class="form" id="form-deduction-option" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="created_by" value="{{Auth::user()->id}}" >
                    <div class="form-group">
                        <label>Deduction</label>
                        <input type="text" class="form-control" name="name" value="{{$deductionoption->name}}"  placeholder="Enter Deduction Option">
                    </div>
                </div>
            </div>	
        </form>	
    </div>
</div>