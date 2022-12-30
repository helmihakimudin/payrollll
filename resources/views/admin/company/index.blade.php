@extends('admin-layout.base',[
	'pages'=>'setting',
	'subpages'=>'company'
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Perusahaan</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>

                   	
				<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
					<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
					<span class="kt-input-icon__icon kt-input-icon__icon--right">
						<span><i class="flaticon2-search-1"></i></span>
					</span>
				</div>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->

	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            @foreach($branch as $row)
            @if($row->logo != null)
                @php $loogo = asset('/storage/logo/'.$row->logo); @endphp
            @else
                @php $loogo = asset('logo/notfound.png');@endphp
            @endif
            <div class="col-xl-3">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                            </h3>
                        </div>
                        @if($row->id == \Auth::user()->branch_id)
                        <div class="kt-portlet__head-toolbar">
                            <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                <i class="flaticon-more-1 kt-font-brand"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="kt-nav">
                                    <li class="kt-nav__item">
                                        <a href="{{route('company.edit',['id' => $row->id])}}" class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-settings"></i>
                                            <span class="kt-nav__link-text">Edit</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="{{route('company.destroy',['id' => $row->id])}}" class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-delete"></i>
                                            <span class="kt-nav__link-text">Hapus</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="kt-portlet__body">
                        <!--begin::Widget -->
                        <div class="kt-widget kt-widget--user-profile-2">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <img class="kt-widget__img kt-hidden-" style=" border-radius: 50%;" src="{{$loogo}}" alt="image">
                                    <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden">
                                        ChS
                                    </div>
                                </div>
                                <div class="kt-widget__info">
                                    <a href="#" class="kt-widget__username">
                                        {{$row->name}}
                                    </a>
                                    <!-- @php 
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
                                    @endif -->
                               
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
                                        <a href="#" class="kt-widget__data">{{$row->telepon}}</a>
                                    </div>
                                   
                                </div>                        
                            </div>
                            @if($row->id == \Auth::user()->branch_id)
                            <div class="kt-widget__footer">
                                <a href="" class="btn btn-label-success btn-lg btn-upper">Dikelola admin</a>
                            </div>
                            @else 
                            <div class="kt-widget__footer">
                                <a href="" class="btn btn-label-danger btn-lg btn-upper">Tidak dikelola admin</a>
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
@push('script')
<script>

</script>
@endpush