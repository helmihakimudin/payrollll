@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'gaji',
    'menuaside'=>''
])
@section('content')
<!--begin::Modal-->
<div class="modal fade" id="kasbon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Pemotongan Kasbon</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="{{route('gaji.kasbon.potongankasbon',$karyawan->id)}}" id="form-kasbon">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group">
                        <input type="hidden" name="employee_id" value="{{$karyawan->id}}" class="form-control">
                        <label for="">Jumlah Potongan Kasbon</label>
                        <input type="number" name="amount" class="form-control" placeholder="Masukkan Potongan Kasbon">
                    </div>
                </form>
			</div>
			<div class="modal-footer">
                <button type="submit" form="form-kasbon" class="btn btn-primary" data-dismiss="modal">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<!--end::Modal-->
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">
                    <button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
                    Gaji Karyawan</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
				
                @can('Hapus Gaji')
				<a href="{{ route('gaji.destroy',$karyawan->id)}}" class="btn btn-danger btn-elevate btn-icon-sm" title="Delete">
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
					<a href="{{route('gaji')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-minus"></i>
                        Kembali 
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
                                        {{-- <img src="{{asset('documents/'.$row->document4)}}" alt="" style="width:180px;height:200px;"> --}}
                                        <div class="kt-widget__media">
                                            <img src="{{asset('documents/'.$row->document4)}}" alt="image">
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
                                <div class="kt-widget__content">
                                    <div class="kt-widget__section">
                                        <a href="#" class="kt-widget__username">
                                            {{$karyawan->full_name}}
                                            @if($karyawan->employee_status == 'Aktif')
                                            <i class="flaticon2-correct kt-font-success"></i>
                                            @else 
                                            <i class="flaticon2-correct kt-font-danger"></i>
                                            @endif
                                        </a>
                                        <span class="kt-widget__subtitle">
                                           {{$jobpositionName}}
                                        </span>
                                        <span class="kt-widget__subtitle">
                                            {{$departmentname}}
                                         </span>
                                    </div>
                                    <div class="kt-widget__action">
                                        <a href="https://api.whatsapp.com/send?phone=+62{{substr($karyawan->phone,1)}}" target="_blank" class="btn btn-info btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                              </svg> chat
                                        </a>&nbsp;
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
                                        <span class="kt-widget__label">Kasbon:</span>
                                        <span class="kt-widget__data">{{"Rp.".number_format($kasbon,2,',','.')}}</span>
                                    </div>
                                </div>
                                <div class="kt-widget__items">
                                    
                                    <a href="{{route('gaji.edit',$karyawan->id)}}" class="kt-widget__item @if($menuaside == 'gaji') kt-widget__item--active @endif">
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
                                    <a href="{{route('gaji.edit',$karyawan->id)}}" class="kt-widget__item @if($menuaside == 'tunjangan') kt-widget__item--active @endif">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                            <i class="flaticon2-fast-back"></i>
                                            </span>
                                            <span class="kt-widget__desc">
                                                Pendapatan
                                            </span>
                                        </span>
                                    </a>
                                    <a href="{{route('gaji.edit',$karyawan->id)}}" class="kt-widget__item @if($menuaside == 'pengurangan') kt-widget__item--active @endif">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <i class="flaticon2-fast-next"></i></span>
                                            <span class="kt-widget__desc">
                                                Pemotongan
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
                    @include('message')
                    <div class="col-xl-12">
                        <div class="kt-portlet">
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
