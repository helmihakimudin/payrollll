@extends('layout-admin.base',[
	'pages'=>'inbox',
	'subpages'=>''
])

@push('css')
		<link href="{{asset('demo10/assets/css/pages/inbox/inbox.css')}}" rel="stylesheet" type="text/css" />
		<style>
		.kt-inbox
		.kt-inbox__list
		.kt-inbox__items
		.kt-inbox__item.kt-inbox__item--unread{
				background: aliceblue;
			}

			.kt-inbox .kt-inbox__list .kt-inbox__items .kt-inbox__item:hover, .kt-inbox .kt-inbox__list .kt-inbox__items .kt-inbox__item.kt-inbox__item--selected {
				background-color: #f2f3f7 !important;
			}

			.select2-container {
		display: block;
		}

		.kt-inbox__view{
			display: block !important;
		}
		</style>
@endpush

@section('content')
		<div class="kt-grid kt-grid--desktop kt-grid--ver-desktop  kt-inbox" id="kt_inbox">
			<!--Begin:: Inbox View-->
			<div class="kt-grid__item kt-grid__item--fluid  m-0 kt-portlet kt-inbox__view kt-inbox__view--shown-" id="kt_inbox_view">
				<div class="kt-portlet__head">
					<div class="kt-inbox__toolbar">
						<div class="kt-inbox__actions">
							<a href="{{route('inbox')}}" class="kt-inbox__icon kt-inbox__icon--back">
								<i class="flaticon2-left-arrow-1"></i>
							</a>
							<h5 class="m-0 kt-inbox__text">
								@if($detail->type!="employee_message")
									Need Approval {{ucfirst(@$detail->type)}}
								@else
									{{$detail->title}}
								@endif
							</h5>
						</div>
						<div class="kt-inbox__controls">
							<button class="kt-inbox__icon" data-toggle="kt-tooltip" title="Delete">
								<i class="la la-trash-o fa-lg text-danger"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="kt-portlet__body kt-portlet__body--fit-x pb-0">
					<div class="kt-inbox__messages m-0">
						<div class="kt-inbox__message kt-inbox__message--expanded pb-0">
							<div class="kt-inbox__head">
								<span class="kt-media kt-media--md kt-media--dark">
									<span>{{ substr(@$detail->employeeSender->full_name, 0, 1)}}</span>
								</span>
								<div class="kt-inbox__info">
									<div class="kt-inbox__author" data-toggle="expand">
										<a href="#" class="kt-inbox__name">{{@$detail->employeeSender->full_name}}</a>
									</div>
									<div class="kt-inbox__details">
										<div class="kt-inbox__tome">
											<span class="kt-inbox__label" data-toggle="dropdown">
												to me <i class="flaticon2-down"></i>
											</span>
											<div class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-left">
												<table class="kt-inbox__details">
													<tr>
														<td>Employee ID:</td>
														<td>{{@$detail->employeeSender->employee_id}}</td>
													</tr>
													<tr>
														<td>Organization:</td>
														<td>{{@$detail->employeeSender->organization->name}}</td>
													</tr>
													<tr>
														<td>Job position:</td>
														<td>{{@$detail->employeeSender->jobPosition->name}}</td>
													</tr>
													<tr>
														<td>Job level:</td>
														<td>{{@$detail->employeeSender->jobLevel->name}}</td>
													</tr>
													<tr>
														<td>Branch:</td>
														<td>{{@$detail->employeeSender->branch->name}}</td>
													</tr>
												</table>
											</div>
										</div>
										<div class="kt-inbox__desc" data-toggle="expand">
											{{@$detail->message}}
										</div>
									</div>
								</div>
								<div class="kt-inbox__actions">
									<div class="kt-inbox__datetime" data-toggle="expand">
										{{ \Carbon\carbon::parse($detail->created)->format('d M Y')}}
									</div>
								</div>
							</div>
							<div class="kt-inbox__body">
								<div class="kt-inbox__text">
									<p>Hi {{@$detail->employeeRecipient->full_name}},</p>
									<p class="kt-margin-t-25">
										{{@$detail->message}}
									</p>
									
									<p class="kt-margin-t-25">
										Best regards,
									</p>
									<p>
										{{@$detail->employeeSender->full_name}}
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--End:: Inbox View-->
		</div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('demo10/assets/js/pages/custom/inbox/inbox.js')}}" type="text/javascript"></script>

<script>
	$('.kt-select2').select2({
		placeholder: "Select on option",
	});
</script>
@endpush
