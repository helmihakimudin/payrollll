<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Add Position office
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-subheader__wrapper">
                <a href="javascript:;" class="btn btn-brand btn-elevate btn-icon-sm btn-close">
                    <i class="la la-minus"></i>
                    Close 
                </a>
                <button type="submit" form="form-designation" class="btn btn-success btn-elevate btn-icon-sm">
                    <i class="la la-save"></i>
                    Save 
                </button>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="{{route('designation.store')}}" method="POST" class="form" id="form-designation" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <input type="hidden" name="created_by" value="{{Auth::user()->id}}" >        
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" class="form-control" name="name"  placeholder="Enter Designation">
                    </div>
                </div>
            </div>
        </form>	
    </div>
</div>