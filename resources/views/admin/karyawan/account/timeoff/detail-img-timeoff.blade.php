@if ($img->images)
    @foreach ($imgs as $key => $item)
         <img src="{{$item}}" alt="" srcset="" style="width: 100%; height: auto" class="mb-3 mt-3">
    @endforeach
@else
    <div class="text-center font-weight-bold">Image Not Found</div>
@endif
