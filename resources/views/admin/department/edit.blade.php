<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Edit Department Office
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-subheader__wrapper">
                <a href="javascript:;" class="btn btn-brand btn-elevate btn-icon-sm btn-close">
                    <i class="la la-minus"></i>
                    Close 
                </a>
                <button type="submit" form="form-department" class="btn btn-success btn-elevate btn-icon-sm">
                    <i class="la la-save"></i>
                    Update 
                </button>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="{{route('department.update',$department->id)}}" method="POST" class="form" id="form-department" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                <input type="hidden" name="created_by" value="{{Auth::user()->id}}" >
            
                    <div class="form-group">
                        <label>Kantor Cabang</label>
                        <select name="branch_id"  class="form-control" id="branch_id kt_select2_custom_2">
                            @if ($branch->count())
                                @foreach($branch as $brnch)
                                    <option value="{{ $brnch->id }}" {{ $selectedBranch == $brnch->id ? 'selected="selected"' : '' }}>{{ $brnch->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" class="form-control" name="name" value="{{$department->name}}"  placeholder="Enter Department">
                    </div>
                </div>
            </div>	
        </form>		
    </div>
</div>