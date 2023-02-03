@if ($img->images)
    <img src="{{$img->images}}" alt="" srcset="" style="width: 100%; height: auto">
@else
    <div class="text-center font-weight-bold">No Image</div>
@endif
