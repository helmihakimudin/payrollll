@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'pengguna'
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Add Users
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-subheader__wrapper">
                    <a href="{{route('pengguna')}}" class="btn btn-brand btn-elevate btn-icon-sm btn-close">
                        <i class="la la-minus"></i>
                        Close 
                    </a>
                    <button type="submit" form="form-pengguna" class="btn btn-success btn-elevate btn-icon-sm">
                        <i class="la la-save"></i>
                        Save 
                    </button>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <form action="{{route('pengguna.store')}}" method="POST" class="form" id="form-pengguna" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" >Name:</label>
                            <select name="employee_id" id="employee_name" class="form-control select2" required style="width:100%">
                                <option value="" selected>Select</option>
                                @foreach($employee as $row)
                                <option value="{{$row->id}}" name="{{$row->full_name}}" selected>{{$row->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" >Phone Number:</label>
                            <input type="number" name="no_telp" id="mobile_phone"  class="form-control" autocomplete="off" required readonly>
                        </div>
                        <div class="form-group">
                            <label >Branch Office :</label>
                            <select class="form-control select2" style="width:100%;" id="branch_id_user" name="branch_id" required>
                                <option value="">Pilih perusahaan</option>
                                @foreach(DB::table('branches')->get() as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" >Email:</label>
                            <input type="email" name="email" id="user_email" class="form-control" autocomplete="off" required readonly>
                        </div>
                        <div class="form-group">
                            <!-- <label class="form-control-label" >Password:</label> -->
                            <input type="hidden" name="password" class="form-control" id="password" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label >Rules :</label>
                            <select class="form-control select2"  style="width:100%;" id="type" name="type">
                                <option value="">Choose Rules</option>
                                @foreach(DB::table('roles')->get() as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group pt-3">
                            <button type="button" id="avatarfile"  class="btn btn-primary btn-elevate btn-pill"><i class="fa fa-user"></i>Upload Avatar</button>
                            <div class="progress pro1  mt-3" style="height: 25px">
                                <div class="progress-bar pro-bar1 progress-bar-striped progress-bar-animated  bg-warning" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 100%"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Show Avatar</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-file-image"></i></span></div>
                                <input type="text" name="avatar" readonly style="background-color:#F0FFFF" class="form-control"  id="show-avatar" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <button type="button" id="signaturefile"  class="btn btn-primary btn-elevate btn-pill"><i class="fa fa-file-signature"></i>Upload Signature</button>
                            <div class="progress pro2  mt-3" style="height: 25px">
                                <div class="progress-bar pro-bar2 progress-bar-striped progress-bar-animated  bg-primary" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 100%"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Show Signature</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-file-image"></i></span></div>
                                <input type="text" name="signature" readonly style="background-color:#F0FFFF" class="form-control"  id="show-signature" required>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>		
        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script>
    let avatar = $('#avatarfile');
    let resumable = new Resumable({
        target: '{{ route('pengguna.avatar') }}',
        query:{_token:'{{ csrf_token() }}'} ,// CSRF token
        fileType: ['jpg','jpeg','png'],
        headers: {
            'Accept' : 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });
    resumable.assignBrowse(avatar[0]);
    resumable.on('fileAdded', function (file) { 
        showProgress();
        resumable.upload() 
    });
    resumable.on('fileProgress', function (file) { 
        updateProgress(Math.floor(file.progress() * 100));
    });
    resumable.on('fileSuccess', function (file, response) { 
        response = JSON.parse(response)
        $('#show-avatar').val(response.filename);

    });
    let progress = $('.pro1');
    function showProgress() {
        progress.find('.pro-bar1').css('width', '0%');
        progress.find('.pro-bar1').html('0%');
        progress.find('.pro-bar1').removeClass('bg-success');
        progress.show();
    }
    function updateProgress(value) {
        progress.find('.pro-bar1').css('width', `${value}%`)
        progress.find('.pro-bar1').html(`${value}%`)
    }
    function hideProgress() {
        progress.hide();
    }
    

    let signature = $('#signaturefile');
    let resumable2 = new Resumable({
        target: '{{ route('pengguna.signature') }}',
        query:{_token:'{{ csrf_token() }}'} ,// CSRF token
        fileType: ['jpg','jpeg','png'],
        headers: {
            'Accept' : 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });
    resumable2.assignBrowse(signature[0]);
    resumable2.on('fileAdded', function (file2) { 
        showProgress2();
        resumable2.upload() 
    });
    resumable2.on('fileProgress', function (file2) { 
        updateProgress2(Math.floor(file2.progress() * 100));
    });
    resumable2.on('fileSuccess', function (file2, response2) { 
        response2 = JSON.parse(response2)
        $('#show-signature').val(response2.filename);

    });
    let progress2 = $('.pro2');
    function showProgress2() {
        progress2.find('.pro-bar2').css('width', '0%');
        progress2.find('.pro-bar2').html('0%');
        progress2.find('.pro-bar2').removeClass('bg-success');
        progress2.show();
    }
    function updateProgress2(value2) {
        progress2.find('.pro-bar2').css('width', `${value2}%`)
        progress2.find('.pro-bar2').html(`${value2}%`)
    }
    function hideProgress2() {
        progress2.hide();
    }
    $('.select2').select2();
    $('#branch_id_user').select2().enable(true);
    $('#employee_name').on('select2:select',function(event) {
        var val = event.params.data.id;
        console.log(val);
        var urlUser = "{{route('pengguna.autogenerate', ':id')}}";
        generateUser = urlUser.replace(':id', val);
        console.log('generate user : '+generateUser)
        $.ajax({
            type:'GET',
            url: generateUser,
            _token:"{{ csrf_token() }}",
            success: function (data) {  
				var dataParse = JSON.parse(data);
				if (dataParse.length != 0) {
					$('#mobile_phone').val(dataParse.mobile_phone);
                    $("#branch_id_user").val(dataParse.branch_id).trigger("change");
					$('#user_email').val(dataParse.email);
                    $('#password').val(dataParse.password);
                }
            }
        });
    });

</script>
@endpush