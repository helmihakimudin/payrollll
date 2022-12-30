@extends('admin-layout.base',[
	'pages'=>'setting',
	'subpages'=>'branch'
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Profil Perusahaan</h3>
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
                    <a href="{{route('company.index')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-minus"></i>
                        Kembali 
                    </a>
                    @can('Update Perusahaan')
                    <button type="submit" form="form-company" class="btn btn-success btn-elevate btn-icon-sm">
                        <i class="la la-save"></i>
                        Simpan 
                    </button>
                    @endcan
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->
    @include('message')
	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body">
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <form action="{{route('company.save',$branch->id)}}" method="POST" class="form" id="form-company" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                @if($branch->logo != null)
                                <img class="w-125px h-125px" src="{{ asset('storage/logo'.'/'.$branch->logo)}}" alt="$branch->logo">
                                @else
                                <img class="w-125px h-125px" src="{{ asset('logo/notfound.png')}}" alt="$branch->logo" width="10%">
                                @endif
                                <div class="form-group">
                                    <label>Gambar Logo</label>
                                    <input type="file" class="form-control form-control-lg" placeholder="Tambahkan Logo" name="gambaredit" />
                                    <span class="form-text text-danger">Size Gambar Maksimal 1024kb</span>
                                </div>
                                <div class="form-group">
                                    <label>Kantor Cabang</label>
                                    <input type="text" class="form-control" name="name" value="{{$branch->name}}"  placeholder="Enter Branch">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{$branch->email}}"  placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" name="telepon" value="{{$branch->telepon}}"  placeholder="Enter Phone">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" name="alamat" value="{{$branch->alamat}}"  placeholder="Enter Address">
                                </div>
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" class="form-control" name="kodepos" value="{{$branch->kodepos}}"  placeholder="Enter Postal Code">
                                </div>
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" class="form-control" name="provinsi" value="{{$branch->provinsi}}"  placeholder="Enter Province">
                                </div>
                                <div class="form-group">
                                    <label>Negara</label>
                                    <input type="text" class="form-control" name="country" value="{{$branch->country}}"  placeholder="Enter Country">
                                </div>
                            </div>
                        </div>	
                    </form>			
                </div>
            </div>
        </div>
    </div>	
    
	
	<!-- end:: Content -->
</div>
@endsection
@push('script')

@endpush