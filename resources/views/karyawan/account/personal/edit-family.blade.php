<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Family Information</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('emp.account.personal.family.update',$family->id)}}" method="POST" class="form" id="form-personal-family" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$family->name}}">
                </div>
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" class="form-control" name="relationship" value="{{$family->relationship}}">
                </div>
                <div class="form-group">
                    <label for="">Birthdate</label>
                    <input type="text" name="birthdate" class="form-control datepicker-modal" value="{{date("m/d/Y",strtotime($family->birthdate))}}" placeholder="Birthday">
                </div>
                <div class="form-group">
                    <label><span style="color:red">*</span> Select Marital Status</label>
                    <select name="marital_status" id="marital_status" class="form-control select-custom" required>
                        @if($family->marital_status == 'Married')
                            <option value="Married" selected>Married</option>
                            <option value="Not married yet">Not Married Yet</option>
                        @elseif($family->marital_status == 'Not married yet"')
                            <option value="Not married yet" selected>Not Married Yet</option>
                            <option value="Married" >Married</option>
                        @else 
                            <option value="" selected>Select</option>
                            <option value="Married">Married</option>
                            <option value="Not married yet">Not Married Yet</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label><span style="color:red">*</span> Select Marital Status</label>
                    <select name="gender" id="gender" class="form-control select-custom" required>
                        @if($family->gender == 'Male')
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                        @elseif($family->gender == 'Female')
                            <option value="Female"selected>Male</option>
                            <option value="Male" >Female</option>
                        @else 
                            <option value="" selected>Select</option>
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Job</label>
                    <input type="text" name="job" value="{{$family->job}}" class="form-control">
                </div>
                <div class="form-group">
                    <label><span style="color:red">*</span>Religion</label>
                    <select name="religion" id="religion" class="form-control select-custom" required>
                        @if($family->religion == 'Islam')
                            <option value="Islam" selected>Islam</option>
                            <option value="Catholic">Catholic</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Confucius">Confucius</option>
                            <option value="Hindu">Hindu</option>
                        @elseif($family->religion == 'Catholic')    
                            <option value="Catholic" selected>Catholic</option>
                            <option value="Islam">Islam</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Confucius">Confucius</option>
                            <option value="Hindu">Hindu</option>
                        @elseif($family->religion == 'Christian')
                            <option value="Christian" selected>Christian</option>
                            <option value="Islam">Islam</option>
                            <option value="Catholic">Catholic</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Confucius">Confucius</option>
                            <option value="Hindu">Hindu</option>
                        @elseif($family->religion == 'Buddha')
                            <option value="Buddha" selected>Buddha</option>
                            <option value="Islam">Islam</option>
                            <option value="Catholic">Catholic</option>
                            <option value="Christian">Christian</option>
                            <option value="Confucius">Confucius</option>
                            <option value="Hindu">Hindu</option>
                        @elseif($family->religion == 'Confucius')
                            <option value="Confucius" selected>Confucius</option>
                            <option value="Islam">Islam</option>
                            <option value="Catholic">Catholic</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Hindu">Hindu</option>
                        @elseif($family->religion == 'Hindu')
                            <option value="Hindu" selected>Hindu</option>
                            <option value="Islam">Islam</option>
                            <option value="Catholic">Catholic</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Confucius">Confucius</option>
                        @else 
                            <option value="" selected>Select</option>
                            <option value="Islam">Islam</option>
                            <option value="Catholic">Catholic</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Confucius">Confucius</option>
                            <option value="Hindu">Hindu</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-personal-family" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        update 
    </button>
</div>