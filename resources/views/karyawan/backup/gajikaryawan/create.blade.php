@extends('admin-layout.base',[
	'pages'=>'payroll',
	'subpages'=>'gaji'
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Gaji Karyawan</h3>
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
					<a href="{{route('gaji')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-minus"></i>
                        Kembali 
                    </a>
                    <button type="submit" form="form-gaji" class="btn btn-success btn-elevate btn-icon-sm">
                        <i class="la la-save"></i>
                        Simpan 
                    </button>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->
    
	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <form action="{{route('gaji.simpan')}}" method="POST" class="form" id="form-gaji" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-12">
                <div class="kt-portlet kt-portlet--mobile">
                    @include('message')
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nama Karyawan</label>
                                    <select name="employee_id" class="form-control select2" id="employee_id">
                                        <option value=""selected>Pilih</option>
                                        @foreach(DB::table('employees')->where('salary',null)->get() as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Gaji</label>
                                    <select name="salary_type" class="form-control select2" id="salary_type">
                                        <option value=""selected>Pilih</option>
                                        @foreach(DB::table('payslip_types')->get() as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Gaji</label>
                                    <input type="number" name="salary" class="form-control" id="salary">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>	
        </form>			
	</div>
	<!-- end:: Content -->
</div>
@endsection
@push('script')

@endpush