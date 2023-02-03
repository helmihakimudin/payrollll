@if(file_exists(public_path().'/storage/avatar/'.Auth::user()->avatar))
@if(Auth::user()->avatar != null)
    @php $avatar = asset('/storage/avatar/'.Auth::user()->avatar); @endphp
@else
<img class="kt-hidden-" alt="Pic" src="{{ asset('image/avatar-uknown.png')}}" />
    @php $avatar = asset('image/user-logo.png'); @endphp
@endif
@else
@php $avatar = asset('image/avatar-uknown.png'); @endphp
@endif

@php
//get employee by login user id
$employee = \App\Employee::where(['user_id'=> Auth::user()->id])->first();

//get inbox by user id
$inbox = \App\Inbox::where('request_to', $employee->id)->orderBy('id', 'desc')->limit(4)->get();

//get total unread
$totalInboxByEmployee = \App\Inbox::where('request_to', $employee->id)->where('status_read',0)->count();
@endphp
<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
    <div class="kt-header__top">
        <div class="kt-container ">
            <!-- begin:: Brand -->
            <div class="kt-header__brand kt-grid__item kt-header--fluid" id="kt_header_brand">
                <div class="kt-header__brand-logo">
                    <a href="javascript:;">
                        <img alt="Logo" src="{{ asset('logo/e-smart-logo.png')}}" width="140px;" height="30px;" class="kt-header__brand-logo-default" />
                    </a>
                </div>
                <div class="kt-header-menu-wrapper pl-5" id="kt_header_menu_wrapper">
                    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-tab ">
                        <ul class="kt-menu__nav">
                            <li class="kt-menu__item pl-2 @if($pages=="dashboard") {{'kt-menu__item kt-menu__item--active'}} @endif"> <a href="{{route('dashboard')}}" class="kt-menu__link  btn btn-default rounded-pill btn btn-sm"><span class="kt-menu__link-text  font-8px">Dashboard</span></a></li>
                            <li class="kt-menu__item pl-2 @if($pages=="employee")  {{'kt-menu__item kt-menu__item--active'}}  @endif"> <a href="{{route('employee')}}" class="kt-menu__link  btn btn-default rounded-pill btn-sm"><span class="kt-menu__link-text font-8px">Employees</span></a></li>
                            <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel pl-2 @if($pages=="Time Management"){{"kt-menu__item kt-menu__item--active"}} @endif" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link  btn btn-default kt-menu__toggle rounded-pill btn-sm"><span class="kt-menu__link-text  font-8px" >Time Management</span></a><div class="kt-menu__submenu  kt-menu__submenu--fixed kt-menu__submenu--left">
                                    <div class="kt-menu__subnav">
                                        <ul class="kt-menu__content">
                                            <li class="kt-menu__item ">
                                                <ul class="kt-menu__inner">
                                                    <li class="kt-menu__item pt-3" aria-haspopup="true"><a href="{{route('time')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-customer"></i></span><span class="kt-menu__link-text">Attendance</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('time.schedule')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon2-schedule"></i></span><span class="kt-menu__link-text">Schedule</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('timeoff')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-stopwatch"></i></span><span class="kt-menu__link-text">Time Off</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('overtime')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-notes"></i></span><span class="kt-menu__link-text">Overtime</span></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="kt-menu__item pl-2 @if($pages=="Finance"){{"kt-menu__item kt-menu__item--active"}} @endif "><a href="javascript:;" class="kt-menu__link  btn btn-default rounded-pill btn-sm"><span class="kt-menu__link-text font-8px">Finance</span></a></li>
                            <li class="kt-menu__item pl-2 @if($pages=="payroll"){{"kt-menu__item kt-menu__item--active"}} @endif "><a href="{{route("payroll")}}" class="kt-menu__link  btn btn-default rounded-pill btn-sm"><span class="kt-menu__link-text font-8px">Payroll</span></a></li>
                            <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel pl-2" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link  btn btn-default kt-menu__toggle rounded-pill btn-sm"><span class="kt-menu__link-text  font-8px" >Settings</span></a>
                                <div class="kt-menu__submenu  kt-menu__submenu--fixed kt-menu__submenu--left">
                                    <div class="kt-menu__subnav">
                                        <ul class="kt-menu__content">
                                            <li class="kt-menu__item ">
                                                <ul class="kt-menu__inner">
                                                    <li class="kt-menu__item pt-3" aria-haspopup="true"><a href="{{route('approval')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon2-calendar-5"></i></span><span class="kt-menu__link-text">Approval</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('branch.index')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon2-architecture-and-city"></i></span><span class="kt-menu__link-text">Company</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('department.index')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-map"></i></span><span class="kt-menu__link-text">Department</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('designation.index')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-share"></i></span><span class="kt-menu__link-text">Position</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('pengguna')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-users-1"></i></span><span class="kt-menu__link-text">Users</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('peran')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-customer"></i></span><span class="kt-menu__link-text">Rules</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('payslip-type.index')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon2-checking"></i></span><span class="kt-menu__link-text">Type Salary</span></a></li>
                                                    <li class="kt-menu__item" aria-haspopup="true"><a href="{{route('contract.index')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><i class="flaticon-list"></i></span><span class="kt-menu__link-text">Contract</span></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end:: Brand -->
            <!-- begin:: Header Topbar -->
            <div class="kt-header__topbar kt-grid__item kt-grid__item--fluid">
                <!--begin: Notifications -->
                <div class="kt-header__topbar-item dropdown">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                        <span class="position-relative kt-header__topbar-icon kt-header__topbar-icon--success">
                            <i class="flaticon2-new-email"></i>
                            {{-- Badge Notif --}}
                            @if ($totalInboxByEmployee > 0)
                            <div class="position-absolute bg-danger rounded-circle text-center m-auto" style="width:20px;height:20px; top:-10%; left:-34%; font-size:12px;line-height:20px">
                                <small class="text-white kt-font-bold">{{$totalInboxByEmployee}}</small>
                            </div>
                            @endif
                            {{-- End Badge Notif --}}
                        </span>
                        <span class="kt-hidden kt-badge kt-badge--danger"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                        <form>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                                    <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                        @foreach($inbox as $listInbox)
                                        <a href="{{route('inbox')}}" class="kt-notification__item @if($listInbox->status_read==1) kt-notification__item--read @endif">
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title">
                                                    {{$listInbox->employeeSender->full_name}} @if($listInbox->status_read==0) <span class="btn btn-label-danger btn-sm btn-bold btn-font-sm px-2 py-1 ml-3">new</span> @endif
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    <small>
                                                        @if($listInbox->type!=="employee_message")
                                                            {{$listInbox->title}} | Need Approval {{ucfirst($listInbox->type)}}
                                                        @else
                                                            {{$listInbox->title}} 
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end: Notifications -->
                <!--begin: User bar -->
                <div class="kt-header__topbar-item kt-header__topbar-item--user">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                        <span class="kt-hidden kt-header__topbar-welcome">Hi,</span>
                        <span class="kt-hidden kt-header__topbar-username">{{Auth::user()->name}}</span>
                        <img class="kt-hidden-" alt="Pic" src="{{ asset($avatar)}}" />
                        <span class="kt-header__topbar-icon kt-header__topbar-icon--brand kt-hidden"><b>S</b></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                        <!--begin: Head -->
                        <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                            <div class="kt-user-card__avatar">
                                <img class="kt-hidden-" alt="Pic" src="{{$avatar}}" />

                                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                            </div>
                            <div class="kt-user-card__name">
                                {{Auth::user()->name}}
                            </div>
                        </div>

                        <!--end: Head -->

                        <!--begin: Navigation -->
                        <div class="kt-notification" style="z-index: 2 !important;">
                            <a href="{{route('signature.index')}}" class="kt-notification__item ">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-pen"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        Sign Contract
                                    </div>
                                    <div class="kt-notification__item-time">
                                        Employee Signature
                                    </div>
                                </div>
                            </a>
                            @if(isset($employee['id']))
                            <a href="{{route('employee.account', $employee['id'])}}" class="kt-notification__item">
                            @else
                            <a href="#" class="kt-notification__item">
                            @endif
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-calendar-3 kt-font-success"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        My Profile
                                    </div>
                                    <div class="kt-notification__item-time">
                                        Account settings and more
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('inbox')}}" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-mail kt-font-warning"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        My Messages
                                    </div>
                                    <div class="kt-notification__item-time">
                                        Inbox and tasks
                                    </div>
                                </div>
                            </a>
                            <!-- <a href="custom/apps/user/profile-2.html" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-rocket-1 kt-font-danger"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        My Activities
                                    </div>
                                    <div class="kt-notification__item-time">
                                        Logs and notifications
                                    </div>
                                </div>
                            </a>
                            <a href="custom/apps/user/profile-3.html" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-hourglass kt-font-brand"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        My Tasks
                                    </div>
                                    <div class="kt-notification__item-time">
                                        latest tasks and projects
                                    </div>
                                </div>
                            </a>
                            <a href="custom/apps/user/profile-1/overview.html" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-cardiogram kt-font-warning"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        Billing
                                    </div>
                                    <div class="kt-notification__item-time">
                                        billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span>
                                    </div>
                                </div>
                            </a> -->
                            <div class="kt-notification__custom kt-space-between">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
                            </div>
                        </div>
                        <!--end: Navigation -->
                    </div>
                </div>
                <!--end: User bar -->
            </div>
            <!-- end:: Header Topbar -->
        </div>
    </div>
</div>
<!-- end:: Header -->
