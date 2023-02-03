@extends('layout-karyawan.base',[
	'pages'=>'employees',
	'subpages'=>''
])

@section('content')
<div class="row">
	<div class="col-lg-12">
		<!--begin::Portlet-->
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Employees
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 mt-0">
						<thead>
								<tr>
									<th>Employee Name</th>
									<th>Employee ID</th>
									<th>Organization</th>
									<th>Job Position</th>
									<th>Email</th>
								</tr>
						</thead>
						<tbody>
							@foreach ($all as $alls)
								<tr>
									<td>{{ $alls->full_name }}</td>
									<td>{{ $alls->employee_id }}</td>
									<td>{{ $alls->organization->name }}</td>
									<td>@if(isset($alls->jobPosition->name))
                                        {{$alls->jobPosition->name}}
                                        @else
                                            -
                                        @endif</td>
									<td>{{ $alls->email }}</td>
								</tr>
							@endforeach
						</tbody>
				</table>
				<!--end: Datatable -->
			</div>
		</div>
		<!--end::Portlet-->
	</div>
</div>
@endsection

@push('scriptjs')
<script>
	$(".kt_table_1").DataTable({
		responsive: true,
		lengthMenu: [10, 25, 50],
		pageLength: 10,
		language: {
				lengthMenu: "Display _MENU_",
		},
		autoWidth: true,
		// Order settings
		order: [[1, "asc"]],
	});
</script>
@endpush
