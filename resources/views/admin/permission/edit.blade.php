@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'permission'
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Permission</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
				
				{{--  --}}
				<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
					<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
					<span class="kt-input-icon__icon kt-input-icon__icon--right">
						<span><i class="flaticon2-search-1"></i></span>
					</span>
				</div>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
					<a href="{{route('permission')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-minus"></i>
                        Kembali 
                    </a>
                    <button type="submit" form="form-permission" class="btn btn-success btn-elevate btn-icon-sm">
                        <i class="la la-save"></i>
                        Ubah 
                    </button>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->
    
	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <form action="{{route('permission.update',$permission->id)}}" method="POST" class="form" id="form-permission" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon flaticon-user"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Detail Data Permission  
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <div class="kt-portlet__head-actions">
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                @include('message')
                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" >Nama:</label>
                                <input type="text" name="name" class="form-control" value="{{$permission->name}}" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" >Nama Guard:</label>
                                <input type="text" name="guard_name" class="form-control" value="web" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <!--end: Datatable -->
                </div>
            </div>
        </form>			
	</div>
	<!-- end:: Content -->
</div>
@endsection
@push('script')

@endpush