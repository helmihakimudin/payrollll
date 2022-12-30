@extends('layout-admin.base',[
	'pages'=>'staff',
	'subpages'=>'pengguna'
])
@section('content')
@include('admin.pengguna.modal')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Users</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <h3 class="kt-subheader__title">List</h3>  	
				<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
					<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
					<span class="kt-input-icon__icon kt-input-icon__icon--right">
						<span><i class="flaticon2-search-1"></i></span>
					</span>
				</div>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
					<a href="{{route('pengguna.buat')}}" class="btn btn-brand btn-elevate btn-icon-sm btn-add">
                        <i class="la la-plus"></i>
                        Add users 
                    </a>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->

	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            @foreach($pengguna as $row)
            @if(file_exists(public_path().'/storage/avatar/'.$row->avatar))
                @if($row->avatar != null)
                    @php $avatar = asset('/storage/avatar/'.$row->avatar); @endphp
                @else
                
                    @php $avatar = asset('image/avatar-uknown.png'); @endphp
                @endif
                @else
                @php $avatar = asset('image/avatar-uknown.png'); @endphp
            @endif
            <div class="col-xl-3">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                <i class="flaticon-more-1 kt-font-brand"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="kt-nav">
                                    <li class="kt-nav__item">
                                        <a href="{{route('pengguna.edit',['id' => $row->id])}}" class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-settings"></i>
                                            <span class="kt-nav__link-text">Edit</span>
                                        </a>
                                    </li>
                                    @if(Auth::user()->id != $row->id)
                                    <li class="kt-nav__item">
                                        <a href="javascript:;" data-attr="{{route('pengguna.show',['id' => $row->id])}}" class="kt-nav__link btn-show">
                                            <i class="kt-nav__link-icon flaticon2-delete"></i>
                                            <span class="kt-nav__link-text">Delete</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <!--begin::Widget -->
                        <div class="kt-widget kt-widget--user-profile-2">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <img class="kt-widget__img kt-hidden-" style=" border-radius: 50%;" src="{{$avatar}}" alt="image">
                                    <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden">
                                        ChS
                                    </div>
                                </div>
                                <div class="kt-widget__info">
                                    <a href="#" class="kt-widget__username">
                                        {{$row->name}}
                                    </a>
                                    @php 
                                    $roles = DB::table('roles')->where('id',$row->role_id)->first();
                                    @endphp 
                                    @if(isset($roles->name))
                                    <span class="kt-widget__desc">
                                        {{$roles->name}}
                                    </span>
                                    @else 
                                    <span class="kt-widget__desc">
                                        {{"-"}}
                                    </span>
                                    @endif
                               
                                </div>
                            </div>
                            <div class="kt-widget__body"> 
                                <div class="kt-widget__item">
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">Email:</span>
                                        <a href="#" class="kt-widget__data">{{$row->email}}</a>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">Phone:</span>
                                        <a href="#" class="kt-widget__data">{{$row->no_telp}}</a>
                                    </div>
                                    @php 
                                    $branch = DB::table('branches')->where('id',$row->branch_id)->first();
                                    $branchs="-";
                                    if(isset($branch->name)){
                                        $branchs=$branch->name;
                                    }else{
                                        $branchs="-";
                                    }
                                    @endphp 
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">Perusahaan:</span>
                                        <a href="#" class="kt-widget__data">{{$branchs}}</a>
                                    </div>
                                </div>                        
                            </div>
                            @if($row->is_active ==1)
                            <div class="kt-widget__footer">
                                <a href="{{route('pengguna.deactive',['id' => $row->id])}}" class="btn btn-label-success btn-lg btn-upper">Aktif</a>
                            </div>
                            @else 
                            <div class="kt-widget__footer">
                                <a href="{{route('pengguna.active',['id' => $row->id])}}" class="btn btn-label-danger btn-lg btn-upper">Tidak Aktif</a>
                            </div>
                            @endif
                        </div>
                        <!--end::Widget -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
	<!-- end:: Content -->
</div>
@endsection
@push('scriptjs')
<script>
$(document).on('click','.btn-show',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});

</script>
@endpush