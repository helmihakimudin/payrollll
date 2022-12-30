<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Edit Rules
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-subheader__wrapper">
                <a href="javascript:;" class="btn btn-brand btn-elevate btn-icon-sm btn-close">
                    <i class="la la-minus"></i>
                    Close 
                </a>
                <button type="submit" form="form-rules" class="btn btn-success btn-elevate btn-icon-sm">
                    <i class="la la-save"></i>
                    Update 
                </button>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="{{route('peran.update',$peran->id)}}" method="POST" class="form" id="form-rules" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-control-label" >Nama:</label>
                        <input type="text" name="name" class="form-control" value="{{$peran->name}}" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" >Nama Guard:</label>
                        <input type="text" name="guard_name" value="{{$peran->guard_name}}" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label >Pilih Akses :</label>
                        <select class="form-control select-custom"  style="width:100%;" id="permission_id" name="permission_id[]" multiple="multiple" required>
                            <option value="">Select Akses</option>
                            @php 
                                $select = implode(",",$arraypermission);
                                $selected2 = explode(",",$select); 
                            @endphp
                            @foreach(DB::table('permissions')->get() as $row)
                            <option value="{{ $row->id }}" {{ (in_array($row->id, $selected2)) ? 'selected' : '' }}>{{ $row->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>	
    </div>
</div>