@extends('karyawan-layout.base',[
	'pages'=>'payroll',
	'subpages'=>'gaji',
    'menuaside'=>''
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">
                    <button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
                    Gaji Karyawan</h3>
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
    
	<!-- begin:: Content -->
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
                                        <a href="{{route('karyawan.account',$karyawan->id)}}" class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Profil Saya">
                                            <i class="fa fa-pen"></i>
                                        </a>
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
                                <div class="kt-widget__items">
                                    <a href="{{route('karyawan.gaji.edit.gaji',$karyawan->id)}}" class="kt-widget__item @if($menuaside == 'gaji') kt-widget__item--active @endif">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z"/>
                                                  </svg> </span>
                                            <span class="kt-widget__desc">
                                                Gaji 
                                            </span>
                                        </span>
                                    </a>
                                    <a href="{{route('karyawan.gaji.edit.tunjangan',$karyawan->id)}}" class="kt-widget__item @if($menuaside == 'tunjangan') kt-widget__item--active @endif">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                            <i class="flaticon2-fast-back"></i>
                                            </span>
                                            <span class="kt-widget__desc">
                                                Pendapatan
                                            </span>
                                        </span>
                                    </a>
                                    <a href="{{route('karyawan.gaji.edit.pengurangan',$karyawan->id)}}" class="kt-widget__item @if($menuaside == 'pengurangan') kt-widget__item--active @endif">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <i class="flaticon2-fast-next"></i></span>
                                            <span class="kt-widget__desc">
                                                Pemotongan
                                            </span>
                                        </span>
                                    </a>
                                    <a href="{{route('karyawan.gaji.edit.riwayatgaji',$karyawan->id)}}" class="kt-widget__item @if($menuaside == 'riwayat-gaji') kt-widget__item--active @endif">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <i class="
                                                flaticon-coins"></i></span>
                                            <span class="kt-widget__desc">
                                               Riwayat Gaji
                                            </span>
                                        </span>
                                    </a>
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
                            @include('message')
                          @yield('content-gaji')
                        </div>
                    </div>
                </div>
            </div>

            <!--End:: App Content-->
        </div>		
	</div>
	<!-- end:: Content -->
</div>
@endsection
