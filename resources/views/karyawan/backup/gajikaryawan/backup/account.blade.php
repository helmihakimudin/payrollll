@extends('karyawan-layout.base',[
	'pages'=>'profil',
	'subpages'=>''
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
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    <button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
                    Profil Saya</h3>
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
                    <a href="{{route('karyawan.dashboard')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-minus"></i>
                        Dashboard 
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

            <!--Begin:: App Aside Mobile Toggle-->
            <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
                <i class="la la-close"></i>
            </button>

            <!--End:: App Aside Mobile Toggle-->

            <!--Begin:: App Aside-->
            <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

                <!--begin:: Widgets/Applications/User/Profile1-->
                <div class="kt-portlet ">
                    <div class="kt-portlet__head  kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                          {{--  --}}
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fit-y">

                        <!--begin::Widget -->
                        <div class="kt-widget kt-widget--user-profile-1">
                            <div class="kt-widget__head">
                                @if(!empty($karyawan->documents))
                                @php 
                                    $doc = json_decode($karyawan->documents);
                                @endphp
                                @foreach($doc as $row)
                                     @if(isset($row->document4))
                                        <div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
                                            <img class="kt-avatar__holder" src="{{asset('documents/'.$row->document4)}}" alt="" width="20%">
                                           
                                            <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </div>
                                     @else 
                                     <div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
                                        <img class="kt-avatar__holder"  src="{{asset('logo/notfound.png')}}" alt="" alt="image" width="20%">
                                     </div>
                                     @endif   
                                @endforeach
                                @else
                                    <div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
                                        <img class="kt-avatar__holder"  src="{{asset('logo/notfound.png')}}" alt="" alt="image" width="20%">
                                    </div>
                                @endif
                              
                                <div class="kt-widget__content">
                                    <div class="kt-widget__section">
                                        <a href="#" class="kt-widget__username">
                                            {{$karyawan->name}}
                                            <i class="flaticon2-correct kt-font-success"></i>
                                        </a>
                                        <span class="kt-widget__subtitle">
                                           {{$desginationname}}
                                        </span>
                                        <span class="kt-widget__subtitle">
                                            {{$departmentname}}
                                         </span>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class="kt-widget__body">
                                <div class="kt-widget__content">
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Email:</span>
                                        <a href="#" class="kt-widget__data"> {{$karyawan->email}}</a>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Telp:</span>
                                        <a href="#" class="kt-widget__data">{{$karyawan->phone}}</a>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Perusahaan:</span>
                                        <span class="kt-widget__data">{{$branchname}}</span>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Tanggal Bergabung: </span>
                                        @if($karyawan->company_doj != null || date('d F Y',strtotime($karyawan->company_doj)) =='1970-01-01' )
                                        <span class="kt-widget__data">{{date('d F Y',strtotime($karyawan->company_doj))}}</span>
                                        @else 
                                        <span class="kt-widget__data">-</span>
                                        @endif 
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Tanggal Kontrak Mulai:</span>
                                        @if($karyawan->start_date != null || date('d F Y',strtotime($karyawan->start_date)) =='1970-01-01' )
                                        <span class="kt-widget__data">{{date('d F Y',strtotime($karyawan->start_date))}}</span>
                                        @else 
                                        <span class="kt-widget__data">-</span>
                                        @endif 
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Tanggal Kontrak Berakhir:</span>
                                        @if($karyawan->end_date != null || date('d F Y',strtotime($karyawan->end_date)) =='1970-01-01')
                                        <span class="kt-widget__data">{{date('d F Y',strtotime($karyawan->end_date))}}</span>
                                        @else 
                                        <span class="kt-widget__data">-</span>
                                        @endif
                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        <!--end::Widget -->
                    </div>
                </div>

                <!--end:: Widgets/Applications/User/Profile1-->
            </div>

            <!--End:: App Aside-->

            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="row">
                    
                    <div class="col-xl-12">
                        <div class="kt-portlet">
                            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                                <div class="kt-wizard-v4" id="kt_user_add_user" data-ktwizard-state="step-first">
                            
                                    <!--begin: Form Wizard Nav -->
                                    <div class="kt-wizard-v4__nav">
                                        <div class="kt-wizard-v4__nav-items nav">
                            
                                            <!--doc: Replace A tag with SPAN tag to disable the step link click -->
                                            <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step" data-ktwizard-state="current">
                                                <div class="kt-wizard-v4__nav-body">
                                                    <div class="kt-wizard-v4__nav-number">
                                                        1
                                                    </div>
                                                    <div class="kt-wizard-v4__nav-label">
                                                        <div class="kt-wizard-v4__nav-label-title">
                                                            Data Pribadi 
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label-desc">
                                                            Informasi Karyawan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step">
                                                <div class="kt-wizard-v4__nav-body">
                                                    <div class="kt-wizard-v4__nav-number">
                                                        2
                                                    </div>
                                                    <div class="kt-wizard-v4__nav-label">
                                                        <div class="kt-wizard-v4__nav-label-title">
                                                            Rekening
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label-desc">
                                                            Informasi Rekening
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step">
                                                <div class="kt-wizard-v4__nav-body">
                                                    <div class="kt-wizard-v4__nav-number">
                                                        3
                                                    </div>
                                                    <div class="kt-wizard-v4__nav-label">
                                                        <div class="kt-wizard-v4__nav-label-title">
                                                            Data Pajak
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label-desc">
                                                            Informasi Data Pajak 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step">
                                                <div class="kt-wizard-v4__nav-body">
                                                    <div class="kt-wizard-v4__nav-number">
                                                        4
                                                    </div>
                                                    <div class="kt-wizard-v4__nav-label">
                                                        <div class="kt-wizard-v4__nav-label-title">
                                                            File Karyawan
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label-desc">
                                                            Informasi File Karyawan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!--end: Form Wizard Nav -->
                                    <div class="kt-portlet">
                                        <div class="kt-portlet__body">
                                            <div class="kt-grid">
                                                <div class="kt-grid__item ">
                                                    <!--begin: Form Wizard Form-->
                                                        <!--begin: Form Wizard Step 1-->
                                                        <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                                            <div class="kt-section kt-section--first">
                                                                <div class="kt-wizard-v4__form">
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <div class="kt-section__body">
                                                                          
                                                                                <div class="form-group">
                                                                                    <label>No Ktp</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->id_card}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Tempat Lahir</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->pob}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Tanggal Lahir</label>
                                                                                    <input type="text" class="form-control" disabled value="{{date('d F Y',strtotime($karyawan->dob))}}">
                                                                                </div>
                                                                    
                                                                                <div class="form-group">
                                                                                    <label>Gender</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->gender}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Status Karyawan</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->employee_status}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Status Pernikahan</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->merriage_status}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>No. Kartu keluarga</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->family_card}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Jumlah Anak</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->number_children}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Status Kontrak</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->contract_status}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Alamat KTP</label>
                                                                                    <textarea name="" id="" cols="30" rows="5" class="form-control" disabled>{{$karyawan->id_card_address}}</textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Alamat Domisili</label>
                                                                                    <textarea name="" id="" cols="30" rows="5" class="form-control" disabled>{{$karyawan->address}}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <form action="{{route('karyawan.changeemailpassword',$karyawan->id)}}" method="POST" class="form" id="form-changeemailpassword" enctype="multipart/form-data">
                                                                                {{ csrf_field() }}
                                                                                @method('PUT')
                                                                                <div class="form-group">
                                                                                    <label>Change Password </label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-lock"></i></span></div>
                                                                                        <input type="password" name="password" id="password" class="form-control"  >
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <div class="form-group">
                                                                               <button type="submit" class="btn btn-primary"  form="form-changeemailpassword"><i class="flaticon-edit-1"></i> Ubah Password</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Form Wizard Step 1-->
                            
                                                        <!--begin: Form Wizard Step 2-->
                                                        <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                                            <div class="kt-section kt-section--first">
                                                                <div class="kt-wizard-v4__form">
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <div class="kt-section__body">
                                                                                <div class="form-group row">
                                                                                    <div class="col-lg-9 col-xl-6">
                                                                                        {{--  --}}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Nama Rekekning</label>
                                                                                    <input type="text" class="form-control" disabled value="{{$karyawan->account_holder_name}}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                  <label>No Rekening</label>
                                                                                  <input type="text" class="form-control" disabled value="{{$karyawan->account_number}}">
                                                                              </div>
                                                                              <div class="form-group">
                                                                                  <label>Nama Bank</label>
                                                                                  <input type="text" class="form-control" disabled value="{{$karyawan->bank_name}}">
                                                                              </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <!--end: Form Wizard Step 2-->
                            
                                                        <!--begin: Form Wizard Step 3-->
                                                        <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                                            <div class="kt-heading kt-heading--md"></div>
                                                            <div class="kt-form__section kt-form__section--first">
                                                                <div class="kt-wizard-v4__form">
                                                                    <div class="form-group">
                                                                        <label>Nomor Pajak</label>
                                                                        <input type="text" class="form-control" disabled value="{{$karyawan->tax_payer_id}}">
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                        </div>
                                                        <!--end: Form Wizard Step 3-->
                            
                                                        <!--begin: Form Wizard Step 4-->
                                                        <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                                            <div class="kt-heading kt-heading--md"></div>
                                                            <div class="kt-form__section kt-form__section--first">
                                                                <div class="kt-wizard-v4__review">
                                                                <form action="{{route('karyawan.changedocuments',$karyawan->id)}}" method="POST" class="form" id="form-changedocument" enctype="multipart/form-data">
                                                                    {{ csrf_field() }}
                                                                    @method('PUT')
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
                                                                                <input type="file"name="ijazah"  class="form-control">
                                                                                @endif
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Kontrak</label>
                                                                                @if(isset($row->document6))
                                                                                <input type="file"name="kontrak" value="{{$row->document6}}" class="form-control">
                                                                                <input type="hidden"name="kontraks" value="{{$row->document6}}" class="form-control">
                                                                                @else 
                                                                                <input type="file"name="kontrak"  class="form-control">
                                                                                @endif
                                                                            </div>
                                                                            @endforeach
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <label for="">Document</label>
                                                                            <div class="form-group">
                                                                            
                                                                            </div>
                                                                            @if(!empty($karyawan->documents))
                                                                            @php 
                                                                                $doc = json_decode($karyawan->documents);
                                                                            @endphp
                                                                            @foreach($doc as $key => $row)
                                                                            <div class="form-group">
                                                                                @if(isset($row->document1))
                                                                                <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal1"><i class="fas fa-user"></i>KTP</a>
                                                                                @else 
                                                                                <a class="btn btn-dark form-control" target="_blank" href="javascript:;"><i class="fa fa-user"></i> KTP</a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="form-group">
                                                                                @if(isset($row->document2))
                                                                                <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal2"><i class="fas fa-users"></i> Kartu Keluarga</a>
                                                                                @else 
                                                                                <a class="btn btn-dark form-control" target="_blank" href="javascript:;">  <i class="fa fa-users"></i>Kartu Keluarga</a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="form-group">
                                                                                @if(isset($row->document3))
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
                                                                                <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal5"><i class="fas fa-file-image"></i> Ijazah</a>
                                                                                @else 
                                                                                <a class="btn btn-dark form-control" target="_blank" href="javascript:;"> <i class="fas fa-graduation-cap"></i> Ijazah</a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="form-group">
                                                                                @if(isset($row->document6))
                                                                                <a href="javascript:;" class="btn btn-primary form-control" data-toggle="modal"  data-target="#modal6"><i class="fas fa-clipboard-list"></i> Kontrak</a>
                                                                                @else 
                                                                                <a class="btn btn-dark form-control" target="_blank" href="javascript:;"> <i class="fas fa-clipboard-list"></i> Kontrak</a>
                                                                                @endif
                                                                            </div>
                                                                            @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary"  form="form-changedocument"><i class="flaticon-edit-1"></i> Ubah</button>
                                                                 </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Form Wizard Step 4-->
                                                    <!--end: Form Wizard Form-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--End:: App Content-->
        </div>		
	</div>
</div>

@endsection
@push('script')
<script src="{{ asset('demo1/assets/js/pages/custom/user/add-user.js')}}" type="text/javascript"></script>
@endpush
