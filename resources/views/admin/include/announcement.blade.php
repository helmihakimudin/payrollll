@include('admin.include.modal')
<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Create Announcement
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__top">
                        <div class="kt-widget__media">
                            <img src="{{$avatar}}" alt="image">
                        </div>
                        <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-bolder kt-font-light kt-hidden">
                            JM
                        </div>
                        <div class="kt-widget__content">
                            <div class="kt-widget__head">
                                <div class="kt-widget__user">
                                    <a href="#" class="kt-widget__username">
                                        {{Auth::user()->name}}
                                    </a>
                                    <span class="kt-badge kt-badge--bolder kt-badge kt-badge--inline kt-badge--unified-success">{{"Head HR"}}</span>

                                </div>	
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__desc">
                                    <form  action="{{route('admin.pengumuman.store')}}" method="POST" id="announcement-form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Announcement Title</label>
                                            <input name="announcement_title" id="announcement_title" class="form-control " required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Are you have announcement ?</label>
                                            <textarea name="announcement" id="announcement" class="form-control " cols="2" rows="2" required></textarea>
                                        </div>
                                    </form>
                                    
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" form="announcement-form" class="btn btn-label-brand btn-bold">Posting</button>
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
</div>

<div class="row">
    @foreach($pengumuman as $p)
        <div class="col-lg-12">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body">
                    <div class="kt-widget kt-widget--user-profile-3">
                        <div class="kt-widget__top">
                            <div class="kt-widget__media kt-hidden-">
                                <img src="{{$avatar}}" alt="image">
                            </div>
                            <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">
                                JM
                            </div>
                            <div class="kt-widget__content" id="content-post{{$p->id}}">
                                <div class="kt-widget__head">
                                    <a href="#" class="kt-widget__username">
                                        {{Auth::user()->name}}
                                        <i class="flaticon2-correct kt-font-success"></i>
                                    </a>
                                    <div class="kt-widget__action">
                                        <button type="button" data-attr="{{route('admin.pengumuman.edit',$p->id)}}" data-id="{{$p->id}}" class="btn btn-label-warning btn-icon btn-edit" title="Edit" ><i class="flaticon-edit "></i></button>
                                         &nbsp;
                                        <button type="button"data-attr="{{route('admin.pengumuman.show',$p->id)}}" class="btn btn-label-danger btn-icon btn-show" title="Delete"><i class="flaticon-delete"></i></button>
                                    </div>
                                </div>
                                <div class="kt-widget__subhead">
                                    <a href="#"><i class="flaticon-calendar-3"></i>{{date('d M Y h:i:s',strtotime($p->created_at))}} wib</a>
                                </div>
                                <div class="kt-widget__subhead">
                                   <h5>{!! $p->announcement_title !!}</h5>
                                </div>
                                <div class="kt-widget__info">
                                    <div class="kt-widget__desc content-desc text-justify elips-text" id="less{{$p->id}}">
                                        {!! $p->announcement !!}
                                    </div>
                                    <div class="kt-widget__desc content-desc text-justify d-none" id="more{{$p->id}}">
                                        {!! $p->announcement !!}
                                    </div>
                                </div>
                                <a href="javascript:;" class="text text-inline" data-id="{{$p->id}}" onclick="ReadLessMore(this)" id="btn-read{{$p->id}}">Read More</a>
                            </div>
                            <div class="kt-widget__content d-none" id="content-edit{{$p->id}}">
                                {{-- edit form --}}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="text-center">
    {{ $pengumuman->links() }}
</div>


