@extends('layout-admin.base',[
	'pages'=>'dashboard',
	'subpages'=>''
])
@section('content')
@include('admin.include.banner')
@include('admin.include.cart')
<div class="row">
	<div class="col-lg-3">
		@include('admin.include.quick')
	</div>
	<div class="col-lg-6">
		@include('admin.include.announcement')		
	</div>
	<div class="col-lg-3">
		@include('admin.include.cuti')
		@include('admin.include.list-employee-off')
	</div>
</div>
@endsection
@push('scriptjs')
<script>
	const labels = [
		'Probation',
		'Contract',
		'Permanent',
	];
	const data = {
		labels: labels,
		datasets: [
			{
				
				label: 'Probation',
				backgroundColor: '#B8860B',
				data: [12,0,0],
				
			},
			{
				
				label: 'Contract',
				backgroundColor: '#7FFF00',
				data: [0,10,0],
				
			},
			{
				
				label: 'Permanent',
				backgroundColor: '#0000FF',
				data: [0,0,90],
				
			},
				
		]
	};
	const config = {
		type: 'bar',
		data: data,
		options: {}
	};
	const myChart = new Chart(
		document.getElementById('myChart1'),
		config
	);

	/* length of service */ 
	const labels2 = [
		'< 1 Years',
		'1 - 3 Years',
		'3 -5 Years',
		'5 -10 Years',
	];
	const data2 = {
		labels: labels2,
		datasets: [
			{
				
				label: '< 1 Years',
				backgroundColor: '#B8860B',
				data: [300,0,0,0],
				
			},
			{
				
				label: '1 - 3 Years',
				backgroundColor: '#7FFF00',
				data: [0,250,0,0],
				
			},
			{
				
				label: '3 - 5 Years',
				backgroundColor: '#0000FF',
				data: [0,0,100,0],
				
			},
			{
				
				label: '5 - 10 Years',
				backgroundColor: '#8B0000',
				data: [0,0,0,90],
				
			},
				
		]
	};
	
	const config2 = {
		type: 'bar',
		data: data2,
		options: {}
	};
		
	const myChart2 = new Chart(
		document.getElementById('myChart2'),
		config2
	);

	/* Job Level */
	const labels3 = [
		'Staff Junior',
		'Staff Senior',
		'Head',
		'Managing Director',
		'Director'
	];
	const data3 = {
		labels: labels3,
		datasets: [
			{
				
				label: 'Staff Junior',
				backgroundColor: '#B8860B',
				data: [300,0,0,0,0],
				
			},
			{
				
				label: 'Staff Senior',
				backgroundColor: '#7FFF00',
				data: [0,250,0,0,0],
				
			},
			{
				
				label: 'Head',
				backgroundColor: '#0000FF',
				data: [0,0,100,0,0],
				
			},
			{
				
				label: 'Managing Director',
				backgroundColor: '#8B0000',
				data: [0,0,0,90,0],
				
			},
			{
				
				label: 'Director',
				backgroundColor: '#2F4F4F',
				data: [0,0,0,0,10],
				
			},
				
		]
	};
	const config3 = {
		type: 'bar',
		data: data3,
		options: {}
	};
		
	const myChart3 = new Chart(
		document.getElementById('myChart3'),
		config3
	);
																																																																																																																																																								  
	/* Gende Diversity */
	const labels4 = [
		'Pria',
		'Wanita',
	];
	const data4 = {
		labels: labels4,
		datasets: [
			{
				
				label: ['Pria','Wanita'],
				backgroundColor: ['#B8860B','#7FFF00'],
				data: [300,100],
				
			},
				
		]
	};
	const config4= {
		type: 'pie',
		data: data4,
		options: {}
	};
		
	const myChart4 = new Chart(
		document.getElementById('myChart4'),
		config4
	);


	CKEDITOR.replace('announcement');
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
	$(document).on('click','.btn-edit',function(e){
		e.preventDefault();
		var edit = $(this).attr('data-attr');
		var id   = $(this).data('id');
		$.ajax({
			url: edit,
			success: function(result) {
				
				$("#content-edit"+id).html(result);
				$("#content-edit"+id).removeClass('d-none');
				$("#content-post"+id).addClass('d-none');
				CKEDITOR.replace('announcement'+id);
				$('.btn-cancel').on('click',function(){		
					$("#content-post"+id).removeClass('d-none');
					$("#content-edit"+id).addClass('d-none');
					
				});
			},
			timeout: 8000
		});
	});


	$(document).on('click','.btn-show',function(e){
		e.preventDefault();
		var edit = $(this).attr('data-attr');
		$.ajax({
			url: edit,
			success: function(result) {
				$('#modalform .modal-title').html('Edit Akses izin');
				$('#modalform').modal("show");
				$('#modalcontent').html(result).show();	
			},
			timeout: 8000
		});
	});
</script>
@endpush