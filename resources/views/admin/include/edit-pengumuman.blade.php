
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
            <form  action="{{route('admin.pengumuman.update',$pengumuman->id)}}" method="POST" id="announcement-posting">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Announcement Title</label>
                    <input name="announcement_title" id="announcement_title" class="form-control" value="{{$pengumuman->announcement_title}}" required/>
                </div>
                <div class="form-group">
                    <label for="">Are you have announcement ?</label>
                    <textarea name="announcement" id="announcement{{$pengumuman->id}}" class="form-control" cols="2" rows="2">{!!$pengumuman->announcement!!}</textarea>
                </div>
            </form>

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-secondary btn-cancel">Cancel</button>
                    <button type="submit" form="announcement-posting" class="btn btn-label-brand btn-bold">Re-posting</button>
                </div>
            </div>
        </div>
    </div>
</div>

