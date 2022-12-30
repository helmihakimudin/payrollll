@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'account',
    'menuaside'=>''
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Account</h3>
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
					<a href="{{route('dashboard')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                                <div class="kt-widget__media">
                                    @if(Auth::user()->avatar != null)
                                    <img src="{{ asset('/storage/logo/'.Auth::user()->avatar)}}" alt="" alt="image" width="20%">
                                    @else 
                                    <img src="{{asset('logo/notfound.png')}}" alt="" alt="image" width="20%">
                                    @endif
                                 </div>
                              
                                <div class="kt-widget__content">
                                    <div class="kt-widget__section">
                                        <a href="#" class="kt-widget__username">
                                            {{Auth::user()->name}}
                                            <i class="flaticon2-correct kt-font-success"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="kt-widget__body">
                                <div class="kt-widget__content">
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Email:</span>
                                        <a href="#" class="kt-widget__data"> {{Auth::user()->name}}</a>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Telp:</span>
                                        <a href="#" class="kt-widget__data">{{Auth::user()->no_telp}}</a>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Perusahaan:</span>
                                        <span class="kt-widget__data">{{$branchname="PT DUASISI SEJAHTERA"}}</span>
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
                    @include('message')
                    <div class="col-xl-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">Ubah Data Account Anda</h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <div class="kt-portlet__head-wrapper">
                                        <div class="dropdown dropdown-inline">
                                            <button type="submit" form="form-account" class="btn btn-success btn-sm"><i class="la la-save"></i>Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <form action="{{route('account.simpan')}}" id="form-account" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="kt-widget5">
                                        <div class="kt-widget5__item">
                                                <div class="kt-widget5__content">
                                                    <div class="kt-widget5__pic">
                                                        @if(Auth::user()->signature != null)
                                                        <img class="kt-widget7__img" src="{{ asset('storage/logo/'.Auth::user()->signature)}}" alt="">
                                                        @else 
                                                        <img class="kt-widget7__img" src="{{ asset('logo/notfounds.png')}}" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="kt-widget5__section">
                                                        <a href="#" class="kt-widget5__title">
                                                            Tanda Tangan
                                                        </a>
                                                        <p class="kt-widget5__desc">
                                                            &nbsp;
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="kt-widget5__content">
                                                <div class="form-group">
                                                    <label>Avatar</label>
                                                    <input type="file" name="avatar" id="avatar" value="" class="form-control" >
                                                    <input type="hidden" name="avatars" id="avatars" value="{{ Auth::user()->avatar}}" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanda Tangan</label>
                                                    <input type="file" name="signature" id="signature" value="" class="form-control" >
                                                    <input type="hidden" name="signatures" id="signatures" value="{{ Auth::user()->signature}}" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Perusahaan</label>
                                                <select name="branch_id" class="form-control select2" id="branch_id" width="100%">
                                                    @if(Auth::user()->branch_id != null)
                                                    <option value="" selected></option>
                                                    @foreach(DB::table('branches')->get() as $row)
                                                    <option @if(Auth::user()->branch_id  == $row->id) {{"selected"}} @endif value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                    @else 
                                                    <option value="" selected></option>
                                                    @foreach(DB::table('branches')->get() as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="name" id="name" value="{{Auth::user()->name}}" class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" id="email" value="{{Auth::user()->email}}" class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label>No Telp</label>
                                                <input type="number" name="no_telp" id="no_telp" value="{{Auth::user()->no_telp}}" class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label>Password Baru</label>
                                                <input type="password" name="password" id="password" value="" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
