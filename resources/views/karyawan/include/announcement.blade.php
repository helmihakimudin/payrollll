@include('admin.include.modal')
<div class="row">
    @foreach($pengumuman as $p)
        <div class="col-lg-12">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body">
                    <div class="kt-widget kt-widget--user-profile-3">
                        <div class="kt-widget__top">
                            <div class="kt-widget__media kt-hidden-">
                                <img src="{{ asset('demo10/assets/media/users/100_12.jpg')}}" alt="image">
                            </div>
                            <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">
                                JM
                            </div>
                            <div class="kt-widget__content" id="content-post{{$p->id}}">
                                <div class="kt-widget__head">
                                    <div class="kt-widget__username">
                                        {{$p->name}}
                                        <i class="flaticon2-correct kt-font-success"></i>
                                    </div>
                                </div>
                                <div class="kt-widget__subhead">
                                    <a><i class="flaticon-calendar-3"></i>{{date('d M Y h:i:s',strtotime($p->created_at))}} wib</a>
                                </div>
                                <div>
                                    &nbsp;
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


