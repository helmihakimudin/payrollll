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

		.disabled{
			cursor: not-allowed !important;
			pointer-events: auto !important;
			opacity: .3 !important;
    } 
		</style>
@endpush

@section('content')
		<div class="kt-grid kt-grid--desktop kt-grid--ver-desktop  kt-inbox" id="kt_inbox">
			<!--Begin:: Inbox List-->
			<div class="kt-grid__item kt-grid__item--fluid  m-0  kt-portlet kt-inbox__list kt-inbox__list--shown" id="kt_inbox_list">
				<div class="kt-portlet__head">
					<div class="kt-inbox__toolbar kt-inbox__toolbar--extended">
						<div class="kt-inbox__actions kt-inbox__actions--expanded">
							<div class="kt-inbox__check">
								<label class="kt-checkbox kt-checkbox--single kt-checkbox--tick kt-checkbox--brand">
									<input type="checkbox">
									<span></span>
								</label>
							</div>
							<div class="kt-inbox__panel">
								<button class="kt-inbox__icon mx-3" data-toggle="kt-tooltip" title="Delete">
									<i class="la la-trash-o fa-lg text-danger"></i>
								</button>
								<div class="d-flex align-self-center">
									<h5 class="m-0">INBOX</h5>
								</div>
							</div>
						</div>
						<div class="kt-inbox__search">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search">
								<div class="input-group-append">
									<span class="input-group-text">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
												<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
											</g>
										</svg> </span>
								</div>
							</div>
						</div>
						<div class="kt-inbox__controls">
							<div class="kt-inbox__pages" data-toggle="kt-tooltip" title="Records per page">
								<span class="kt-inbox__perpage">{{ $inbox->currentPage() }} - {{ $inbox->perPage() }} of {{ $inbox->total() }}</span>
							</div>
							@if ($inbox->links())
								<ul class="pagination m-0">
									{{-- Previous Page Link --}}
									@if ($inbox->onFirstPage())
									<button class="disabled kt-inbox__icon">
										<i class="flaticon2-left-arrow"></i>
									</button>
									@else
									<a href="{{ $inbox->previousPageUrl() }}" class="kt-inbox__icon" data-toggle="kt-tooltip" title="Previose page">
										<i class="flaticon2-left-arrow"></i>
									</a>
									@endif
									
									{{-- Next Page Link --}}
									@if ($inbox->hasMorePages())
										<a href="{{ $inbox->nextPageUrl() }}" class="kt-inbox__icon" data-toggle="kt-tooltip" title="Next page">
											<i class="flaticon2-right-arrow"></i>
										</a>
									@else
										<button class="disabled kt-inbox__icon">
											<i class="flaticon2-right-arrow"></i>
										</button>
									@endif
								</ul>
							@endif
							<div class="kt-inbox__sort" data-toggle="kt-tooltip" title="Sort">
								<button type="button" class="kt-inbox__icon" data-toggle="dropdown">
									<i class="flaticon2-console"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-xs">
									<ul class="kt-nav">
										<li class="kt-nav__item kt-nav__item--active">
											<a href="#" class="kt-nav__link">
												<span class="kt-nav__link-text">Newest</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<span class="kt-nav__link-text">Olders</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="#" class="kt-nav__link">
												<span class="kt-nav__link-text">Unread</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<button data-toggle="modal" data-target="#kt_modal_2" class="mx-3 btn btn-sm btn-brand btn-elevate btn-icon-sm">
								<i class="la la-plus"></i>
								New Inbox
							</button>
						</div>
					</div>
				</div>
				<div class="kt-portlet__body kt-portlet__body--fit-x">
					<div class="kt-inbox__items" data-type="inbox">		
						@foreach($inbox as $value)
						<div class="card">
							<div class="kt-inbox__item @if($value->status_read==0) kt-inbox__item--unread @endif" data-id="1" data-type="inbox">
								<div class="kt-inbox__info px-0 col-lg-2">
									<div class="kt-inbox__actions">
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--tick kt-checkbox--brand">
											<input type="checkbox">
											<span></span>
										</label>
									</div>
									<div class="kt-inbox__sender" data-toggle="view">
										<a href="{{route('inbox.detail', $value->id)}}" class="kt-inbox__author stretched-link">{{$value->employeeSender->full_name}}</a>
									</div>
								</div>
								<div class="kt-inbox__details px-0 mt-0 col-lg overflow-hidden" data-toggle="view">
									<div class="kt-inbox__message overflow-hidden" style="white-space:nowrap; text-overflow:ellipsis;">
										<span class="kt-inbox__subject"><a href="{{route('inbox.detail', $value->id)}}" class="stretched-link">{{$value->title}}</a> - </span>
										<span class="kt-inbox__summary">{{$value->message}}</span>
									</div>
								</div>
								<div class="kt-inbox__datetime px-0 mt-0 col-lg-auto" data-toggle="view">
									{{ \Carbon\carbon::parse($value->created)->format('d M Y')}}
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			<!--End:: Inbox List-->
		</div>

		<!-- Modal Create -->
    <div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
						<div class="modal-content">
								<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">New Message</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										</button>
								</div>
								<form class="kt-form" action="{{route('inbox.message')}}" method="post">
									@csrf
									<div class="modal-body">
										<div class="form-group">
											 	<label for="recipient">Recipient <span class="text-danger">*</span></label>
												<select class="form-control kt-select2" multiple id="recipient" name="recipients[]">
														<option></option>
														@foreach($recipients as $employee)
															<option value="{{$employee->id}}">{{$employee->employee_id}} - {{$employee->full_name}}</option>
														@endforeach
												</select>
										</div>
										<div class="form-group">
												<label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control">
										</div>
										<div class="form-group">
												<label for="message">Message</label>
												<textarea class="form-control" id="message" name="message" rows="4"></textarea>
										</div>
									</div>
									<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Send</button>
									</div>
								</form>
				</div>
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
