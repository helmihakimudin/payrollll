@extends('layout-karyawan.base',[
	'pages'=>'dashboard',
	'subpages'=>''
])



@section('content')
@include('karyawan.include.banner')
<div class="row">
	<div class="col-lg-3">
		@include('karyawan.include.quick')
	</div>
	<div class="col-lg-6">
		@include('karyawan.include.announcement')		
	</div>
	<div class="col-lg-3">
		@include('karyawan.include.cuti')
		@include('karyawan.include.list-employee-off')
	</div>
</div>
@endsection

@push('scriptjs')
<script>
function ReadLessMore(id){
	var id = $(id).data("id");
	var less = document.getElementById("less"+id);
	var more = document.getElementById("more"+id);
	var btn  = document.getElementById("btn-read"+id);
	
	if(btn.innerHTML == "Read More"){
		btn.innerHTML = "Read less"; 
		$("#less"+id).addClass("d-none");
		$("#more"+id).removeClass("d-none");
	}else{
		btn.innerHTML = "Read More"; 
		$("#less"+id).removeClass("d-none");
		$("#more"+id).addClass("d-none");
	}		
}
</script>
@endpush