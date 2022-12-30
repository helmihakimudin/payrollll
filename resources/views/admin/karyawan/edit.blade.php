@extends('admin-layout.base',[
	'pages'=>'staff',
	'subpages'=>'karyawan'
])
@section('content')
@if(!empty($karyawan->documents))
@php 
    $doc = json_decode($karyawan->documents);
@endphp
@foreach($doc as $key => $row)
<!--begin modal-->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Document KTP</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                 @if(isset($row->document1))
                <embed src="{{asset('documents/'.$row->document1)}}" frameborder="0" width="100%" height="700px">
                @else 
                <h3>File Tidak Ditemukan</h3>
                @endif
			</div>
			<div class="modal-footer">
                @if(isset($row->document1))
                 <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document1)}}"> <i class="fas fa-graduation-cap"></i> Download</a>
                 @endif
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Document KK</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                @if(isset($row->document2))
                <embed src="{{asset('documents/'.$row->document2)}}" frameborder="0" width="100%" height="700px">
                @else 
                <h3>File Tidak Ditemukan</h3>
                @endif
			</div>
			<div class="modal-footer">
                @if(isset($row->document2))
                <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document2)}}"> <i class="fas fa-graduation-cap"></i> Download</a>
                @endif
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal3" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Document NPWP</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                @if(isset($row->document3))
                <embed src="{{asset('documents/'.$row->document3)}}" frameborder="0" width="100%" height="700px">
                @else 
                <h3>File Tidak Ditemukan</h3>
                @endif
			</div>
			<div class="modal-footer">
                @if(isset($row->document3))
                <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document3)}}"> <i class="fas fa-graduation-cap"></i> Download</a>
                @endif
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal4" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Document Foto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                @if(isset($row->document4))
                <embed src="{{asset('documents/'.$row->document4)}}" frameborder="0" width="100%" height="700px">
                @else 
                <h3>File Tidak Ditemukan</h3>
                @endif
			</div>
			<div class="modal-footer">
                @if(isset($row->document4))
                <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document4)}}"> <i class="fas fa-graduation-cap"></i> Download</a>
                @endif
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Document Ijazah </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                @if(isset($row->document5))
                <embed src="{{asset('documents/'.$row->document5)}}" frameborder="0" width="100%" height="700px">
                @else 
                <h3>File Tidak Ditemukan</h3>
                @endif
			</div>
			<div class="modal-footer">
                @if(isset($row->document5))
                <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document5)}}"> <i class="fas fa-graduation-cap"></i> Download</a>
                @endif
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal6" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Document Kontrak Kerja</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                @if(isset($row->document6))
                <embed src="{{asset('documents/'.$row->document6)}}" frameborder="0" width="100%" height="700px">
                @else 
                <h3>File Tidak Ditemukan</h3>
                @endif
			</div>
			<div class="modal-footer">
                @if(isset($row->document6))
                <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document6)}}"> <i class="fas fa-graduation-cap"></i> Download</a>
                @endif
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

@endforeach
@endif
<!--end modal-->
<!--begin::Modal-->
<div class="modal fade" id="kt_modal1acc" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail Penonaktifan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('karyawan.nonaktif')}}" method="POST" class="form" id="form-penonaktifan" enctype="multipart/form-data">
					{{ csrf_field() }}
                    <input type="hidden" name="id1" value="{{$karyawan->id}}">
					<input type="hidden" name="name1" value="{{$karyawan->name}}">
                    <input type="hidden" name="dob1" value="{{$karyawan->dob}}">
                    <input type="hidden" name="old1" value="Tidak Aktif">
                    <input type="hidden" name="employee_status1" value="Aktif">
					<input type="hidden" name="gender1" value="{{$karyawan->gender}}">
                    <input type="hidden" name="merriage_status1" value="{{$karyawan->merriage_status}}">
					<input type="hidden" name="number_children1" value="{{$karyawan->number_children}}">
                    <input type="hidden" name="contract_status1" value="{{$karyawan->contract_status}}">
                    <input type="hidden" name="employee_id1" value="0">
					<input type="hidden" name="phone1" value="{{$karyawan->phone}}">
                    <input type="hidden" name="id_card1" value="{{$karyawan->id_card}}">
					<input type="hidden" name="family_card1" value="{{$karyawan->family_card}}">
                    <input type="hidden" name="id_card_address1" value="{{$karyawan->id_card_address}}">
					<input type="hidden" name="address1" value="{{$karyawan->address}}">
                    <input type="hidden" name="email1" value="{{$karyawan->email}}">
					<input type="hidden" name="password1" value="{{$karyawan->password}}">
					<input type="hidden" name="documents1" value="{{$karyawan->documents}}">
                    <input type="hidden" name="account_holder_name1" value="{{$karyawan->account_holder_name}}">
					<input type="hidden" name="account_number1" value="{{$karyawan->account_number}}">
                    <input type="hidden" name="bank_name1" value="{{$karyawan->bank_name}}">
					<input type="hidden" name="tax_payer_id1" value="{{$karyawan->tax_payer_id}}">
					<div class="form-group">
						<label>Alasan Penonaktifan</label>
						<select name="reason1" id="reason" onchange="myFunction1()" class="form-control">
                            <option value="Resign">Resign</option>
							<option value="Diberhentikan">Diberhentikan</option>
                            <option value="Mutasi">Mutasi</option> 
                        </select>
					</div>
                    <div class="form-group">
						<label>Tanggal Penonaktifan</label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
							<input type="text" name="end_date1" class="form-control datepicker"  required>
						</div>
					</div>
					<div id="data-mutasi" style="display: none;">
                        <h4 class="kt-portlet__head-title">
                                    Data Mutasi  
                        </h4>
                        <div class="form-group">
                            <label>Kantor Cabang</label>
                            <select name="branch_id1" class="form-control" id="branch_id">
                                <option value=""selected>Pilih</option>
                                @foreach(DB::table('branches')->get() as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Departement</label>
                            <select name="department_id1" class="form-control" id="department_id">
                                <option value=""selected>Pilih</option>
                                @foreach(DB::table('departments')->get() as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select name="designation_id1" class="form-control" id="designation_id">
                                @foreach(DB::table('designations')->get() as $row)
                                    <option @if($karyawan->designation_id == $row->id) {{"selected"}} @endif value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" >Tanggal Bergabung </label>
                            <input type="text" name="company_doj1" class="form-control datepicker" autocomplete="off" readonly  id="company_doj" required>
                        </div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="form-penonaktifan" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="kt_modal1" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
            <div class="modal-body">
                <p>Dokumen tidak ada, klik ubah untuk menambahkan.</p>
            </div>
			<div class="modal-footer">
                <button type="submit" form="form-employee" class="btn btn-success btn-elevate btn-icon-sm"> <i class="la la-save"></i> Ubah</button>
			</div>
		</div>
	</div>
</div>
<!--end::Modal-->
<input type="hidden" id="documents1" value="{{$karyawan->documents}}">
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Karyawan</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
				
                
                @can('Hapus Karyawan')
				<a href="{{ route('karyawan.destroy',$karyawan->id)}}" class="btn btn-danger  btn-elevate btn-icon-sm" title="Delete">
                    <i class="la flaticon-delete"></i>Hapus
                </a>
                @endcan
				<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
					<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
					<span class="kt-input-icon__icon kt-input-icon__icon--right">
						<span><i class="flaticon2-search-1"></i></span>
					</span>
				</div>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
					<a href="{{route('karyawan')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-minus"></i>
                        Kembali 
                    </a>
                    @can('Update Karyawan')
                    <button type="submit" form="form-employee" class="btn btn-success btn-elevate btn-icon-sm">
                        <i class="la la-save"></i>
                        Ubah 
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
        <form action="{{route('karyawan.update',$karyawan->id)}}" method="POST" class="form" id="form-employee" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-6">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand flaticon flaticon-user"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                Data Karyawan  
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
                
                    <div class="kt-portlet__body">
            
                        <!--begin: Datatable -->
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    @if(!empty($karyawan->documents))
                                        @php 
                                            $doc = json_decode($karyawan->documents);
                                        @endphp
                                        @foreach($doc as $row)
                                             @if(isset($row->document4))
                                                <div class="kt-widget__media">
                                                    <img src="{{asset('documents/'.$row->document4)}}" alt="image" width="20%">
                                                </div>
                                             @else 
                                             <div class="kt-widget__media">
                                                <img src="{{asset('logo/notfound.png')}}" alt="" alt="image" width="20%">
                                             </div>
                                             @endif   
                                        @endforeach
                                    @else
                                    <div class="kt-widget__media">
                                        <img src="{{asset('logo/notfound.png')}}" alt="" alt="image" width="20%">
                                     </div>
                                    @endif
                                </div>
                            </div>
                        </div> <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >No KTP:</label>
                                    <input type="number" name="no_ktp" class="form-control" value="{{$karyawan->id_card}}" autocomplete="off"  id="no_ktp" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Status Karyawan</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            @if($karyawan->employee_status =="Aktif")
                                            <input type="radio" value="Aktif" name="employee_status" checked> Aktif
                                            @else 
                                            <input type="radio" value="Aktif" name="employee_status"> Aktif
                                            @endif
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                           
                                            @if($karyawan->employee_status =="Tidak Aktif")
                                            <input type="radio" value="Tidak Aktif" name="employee_status" checked> Tidak Aktif
                                            @else 
                                            <input type="radio"  value="Tidak Aktif" name="employee_status"> Tidak Aktif
                                            @endif
                                            <span></span>
                                            <span></span>
                                        </label> 
                                    </div>
                                    <span class="form-text text-muted">centang salah satu</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" >Nama Lengkap</label>
                                    <input type="text" name="name" value="{{$karyawan->name}}" class="form-control" autocomplete="off" id="name" required>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" >Tempat Lahir</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-home"></i></span></div>
                                        <input type="text" name="pob" class="form-control" value="{{$karyawan->pob}}" autocomplete="off" id="pob" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" >Tanggal lahir</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
                                        @if($karyawan->dob == null)
                                        <input type="text" name="birthday" class="form-control datepicker"  autocomplete="off" readonly  id="birthday" required>
                                        @elseif(date('Y-m-d',strtotime($karyawan->end_date)) =='1970-01-01')
                                        <input type="text" name="birthday" class="form-control datepicker" autocomplete="off" readonly  id="birthday" required>
                                        @else
                                        <input type="text" name="birthday" class="form-control datepicker" value="{{date("m/d/Y",strtotime($karyawan->dob))}}" autocomplete="off" readonly  id="birthday" required>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            @if($karyawan->gender=="Laki-Laki")
                                            <input type="radio" value="Laki-Laki" name="gender" checked> Laki- Laki
                                            @else 
                                            <input type="radio" value="Laki-Laki" name="gender"> Laki- Laki
                                            @endif
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            @if($karyawan->gender =="Perempuan")
                                            <input type="radio" value="Perempuan" name="gender" checked> Perempuan
                                            @else 
                                            <input type="radio" value="Perempuan" name="gender"> Perempuan
                                            @endif
                                            <span></span>
                                        </label> 
                                    </div>
                                    <span class="form-text text-muted">centang salah satu</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Status Perkawinan</label>
                                    <select name="merried_status" class="form-control select2" id="merried_status">
                                        @if($karyawan->merriage_status != ' ')
                                        <option value="{{$karyawan->merriage_status}}"selected>{{$karyawan->merriage_status}}</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Belum Menikah">Belum Menikah</option> 
                                        @else 
                                        <option value="{{$karyawan->merriage_status}}"selected>{{$karyawan->merriage_status}}</option> 
                                        <option value="Menikah">Menikah</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" >No KK:</label>
                                    <input type="number" name="no_kk" class="form-control" value="{{$karyawan->family_card}}" autocomplete="off"  id="no_ktp" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" >Jumlah anak:</label>
                                    <input type="number" name="number_children" class="form-control"  value="{{$karyawan->number_children}}" autocomplete="off"  id="number_children" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >No. Telp:</label>
                                    <input type="number" name="no_telp" class="form-control" value="{{$karyawan->phone}}"  autocomplete="off"  id="no_telp" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >No. NPWP:</label>
                                    <input type="number" name="tax_payer_id" class="form-control" value="{{$karyawan->tax_payer_id}}"  autocomplete="off"  id="tax_payer_id" required>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Status Kontrak</label>
                                    <select name="status_kontrak" class="form-control select2" id="status_kontrak">
                                        @foreach(DB::table('contract')->get() as $row)
                                        <option @if($karyawan->contract_status == $row->contract_name) {{"selected"}} @endif value="{{$row->contract_name}}">{{$row->contract_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >Email:</label>
                                    <input type="email" name="email" class="form-control" autocomplete="off" value="{{$karyawan->email}}"  id="email" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >Password:</label>
                                    <input type="password" name="password" class="form-control" autocomplete="off"   id="password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >Alamat KTP:</label>
                                    <textarea name="address_ktp" id="address_ktp" class="form-control" cols="30" rows="3">{{$karyawan->id_card_address}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >Alamat Domisili:</label>
                                    <textarea name="domisili" id="domisili" class="form-control" cols="30" rows="3">{{$karyawan->address}}</textarea>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                @if(!empty($karyawan->documents))
                                @php 
                                    $doc = json_decode($karyawan->documents);
                                @endphp
                                 @foreach($doc as $key => $row)
                                <div class="form-group">
                                    <label>KTP</label>
                                    @if(isset($row->document1))
                                    <input type="file"name="ktp" value="{{$row->document1}}" class="form-control">
                                    <input type="hidden"name="ktps" value="{{$row->document1}}" class="form-control">
                                    @else 
                                     <input type="file"name="ktp"  class="form-control">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>KK</label>
                                    @if(isset($row->document2))
                                    <input type="file"name="kk" value="{{$row->document2}}" class="form-control">
                                    <input type="hidden"name="kks" value="{{$row->document2}}" class="form-control">
                                    @else 
                                    <input type="file"name="kk"  class="form-control">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>NPWP</label>
                                    @if(isset($row->document3))
                                    <input type="file"name="npwp" value="{{$row->document3}}" class="form-control">
                                    <input type="hidden"name="npwps" value="{{$row->document3}}" class="form-control">
                                    @else 
                                    <input type="file"name="npwp"  class="form-control">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    @if(isset($row->document4))
                                    <input type="file"name="foto" value="{{$row->document4}}" class="form-control">
                                    <input type="hidden"name="fotos" value="{{$row->document4}}" class="form-control">
                                    @else 
                                    <input type="file"name="foto"   class="form-control">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Ijazah</label>
                                    @if(isset($row->document5))
                                    <input type="file"name="ijazah" value="{{$row->document5}}" class="form-control">
                                    <input type="hidden"name="ijazahs" value="{{$row->document5}}" class="form-control">
                                    @else 
                                    <input type="file" name="ijazah"  class="form-control">
                                    <input type="hidden" name="ijazahs"  class="form-control">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Kontrak</label>
                                    @if(isset($row->document6))
                                    <input type="file"name="kontrak" value="{{$row->document6}}" class="form-control">
                                    <input type="hidden"name="kontraks" value="{{$row->document6}}" class="form-control">
                                    @else 
                                    <input type="file"name="kontrak"  class="form-control">
                                    <input type="hidden"name="kontraks"  class="form-control">
                                    @endif
                                </div>
                                @endforeach
                                @endif
                            </div> 
                            <div class="col-lg-6">
                            @if(!empty($karyawan->documents))
                                <label for="">Dokuemen</label>
                                <div class="form-group">
                                    &nbsp;
                                </div>
                                @php 
                                    $doc = json_decode($karyawan->documents);
                                @endphp
                                 @foreach($doc as $key => $row)
                                 <div class="form-group">
                                    @if(isset($row->document1))
                                    {{-- <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document1)}}"><i class="fa fa-user"></i> KTP</a> --}}
                                    <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal1"><i class="fas fa-user"></i>KTP</a>
                                    @else 
                                    <a class="btn btn-dark form-control" target="_blank" href="javascript:;"><i class="fa fa-user"></i> KTP</a>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if(isset($row->document2))
                                    {{-- <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document2)}}">  <i class="fa fa-users"></i>Kartu Keluarga</a> --}}
                                    <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal2"><i class="fas fa-users"></i> Kartu Keluarga</a>
                                    @else 
                                    <a class="btn btn-dark form-control" target="_blank" href="javascript:;">  <i class="fa fa-users"></i>Kartu Keluarga</a>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if(isset($row->document3))
                                    {{-- <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document3)}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                            <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                        </svg> NPWP
                                    </a> --}}
                                    <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal3"><i class="fas fa-file-signature"></i> NPWP</a>
                                    @else 
                                    <a class="btn btn-dark form-control" target="_blank" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                            <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                        </svg> NPWP
                                    </a>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if(isset($row->document4))
                                    {{-- <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document4)}}"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-image" viewBox="0 0 16 16">
                                            <path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12V2z"/>
                                        </svg>
                                        Foto
                                    </a> --}}
                                    <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal4"><i class="fas fa-clipboard-list"></i> Foto</a>
                                    @else 
                                    <a class="btn btn-dark form-control" target="_blank" href="javascript:;"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-image" viewBox="0 0 16 16">
                                            <path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12V2z"/>
                                        </svg>
                                        Foto
                                    </a>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if(isset($row->document5))
                                    {{-- <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document5)}}"> <i class="fas fa-graduation-cap"></i> Ijazah</a> --}}
                                    <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal5"><i class="fas fa-file-image"></i> Ijazah</a>
                                    @else 
                                    <a class="btn btn-dark form-control" target="_blank" href="javascript:;"> <i class="fas fa-graduation-cap"></i> Ijazah</a>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if(isset($row->document6))
                                    {{-- <a class="btn btn-primary form-control" target="_blank" href="{{asset('documents/'.$row->document6)}}"><i class="fas fa-clipboard-list"></i> Kontrak</a> --}}
                                    <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal6"><i class="fas fa-clipboard-list"></i> Kontrak</a>
                                    
                                    @else 
                                    <a class="btn btn-dark form-control" target="_blank" href="javascript:;"> <i class="flaticon-list-1"></i> Kontrak</a>
                                    @endif
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <!--end: Datatable -->
                    </div>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon flaticon-home"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Data Perusahaan  
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
                        <div class="kt-portlet__body">
                
                            <!--begin: Datatable -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Kantor Cabang</label>
                                        <select name="branch_id" class="form-control select2" id="branch_id">
                                            @foreach(DB::table('branches')->get() as $row)
                                            <option @if($karyawan->branch_id == $row->id) {{"selected"}} @endif value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Departement</label>
                                        <select name="department_id" class="form-control select2" id="department_id">
                                            @foreach(DB::table('departments')->get() as $row)
                                            <option @if($karyawan->department_id == $row->id) {{"selected"}} @endif value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select name="designation_id" class="form-control select2" id="designation_id">
                                            @foreach(DB::table('designations')->get() as $row)
                                            <option @if($karyawan->designation_id == $row->id) {{"selected"}} @endif value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" >Tanggal Bergabung </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
                                            @if($karyawan->dob == null)
                                                <input type="text" name="company_doj" class="form-control datepicker" autocomplete="off" readonly  id="company_doj" style="color:bisque" required readonly>
                                            @elseif(date('Y-m-d',strtotime($karyawan->end_date)) =='1970-01-01')
                                                <input type="text" name="company_doj" class="form-control datepicker"  autocomplete="off" readonly  id="company_doj" style="color:bisque" required readonly>
                                            @else 
                                                <input type="text" name="company_doj" class="form-control datepicker" value="{{date("m/d/Y",strtotime($karyawan->company_doj))}}" autocomplete="off" readonly  id="company_doj" required>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" >Tanggal Kontrak Mulai </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
                                            @if($karyawan->start_date == null)
                                                <input type="text" name="start_date" class="form-control datepicker" autocomplete="off" readonly  id="start_date" required>
                                            @elseif(date('Y-m-d',strtotime($karyawan->start_date)) =='1970-01-01')
                                                <input type="text" name="start_date" class="form-control datepicker"  autocomplete="off" readonly  id="start_date" required>
                                            @else 
                                                <input type="text" name="start_date" class="form-control datepicker" value="{{date("m/d/Y",strtotime($karyawan->start_date))}}" autocomplete="off" readonly  id="start_date" required>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" >Tanggal Kontrak Berakhir  </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
                                            @if($karyawan->end_date == null)
                                            <input type="text" name="end_date" class="form-control datepicker" autocomplete="off" readonly  id="end_date" required>
                                            @elseif(date('Y-m-d',strtotime($karyawan->end_date)) =='1970-01-01')
                                            <input type="text" name="end_date" class="form-control datepicker" autocomplete="off" readonly  id="end_date" required>
                                            @else
                                            <input type="text" name="end_date" value="{{date("m/d/Y",strtotime($karyawan->end_date))}}" class="form-control datepicker" autocomplete="off" readonly  id="end_date" required>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div> 
                            </div>
                          
                            <!--end: Datatable -->
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon flaticon2-document"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Data Rekening Karyawan
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
                        <div class="kt-portlet__body">
                            <!--begin: Datatable -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nama Bank</label>
                                        <input type="text" name="bank_name" value="{{$karyawan->bank_name}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Pemegang Rekening</label>
                                        <input type="text" name="account_holder_name" value="{{$karyawan->account_holder_name}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Rekening</label>
                                        <input type="number" name="account_number" value="{{$karyawan->account_number}}" class="form-control">
                                    </div>
                                </div> 
                            </div>
                            <!--end: Datatable -->
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
<script>
	function myFunction1() {
  var x = document.getElementById("reason").value;
  if(x == 'Mutasi'){
	  $('#data-mutasi').attr("style", "display:block");
  }
  else{
	$('#data-mutasi').attr("style", "display:none");
  }

//document.getElementById("demo").innerHTML = "You selected: " + x;
}

</script>
<script>
$(document).ready(function() 
    {
        $yy = $('#documents1').val();
        if($yy != ''){
            
        }else
        {
            $('#kt_modal1').modal('show');
        };
        
        $('input[type="radio"][name="employee_status"]').on('change', function() {
            if($(this).is(':checked') && $(this).val()=='Tidak Aktif'){
                $('#kt_modal1acc').modal('show');
            }
        });
    });
</script>
@endpush