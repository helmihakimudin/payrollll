@if(file_exists(public_path().'/storage/avatar/'.Auth::guard('emp')->user()->avatar))
@if(Auth::guard('emp')->user()->avatar != null)
    @php $avatar = asset('/storage/avatar/'.Auth::user()->avatar); @endphp
@else
@php $avatar = asset('image/avatar-uknown.png'); @endphp
@endif
@else
@php $avatar = asset('image/avatar-uknown.png'); @endphp
@endif
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
                            <li class="kt-menu__item pl-2 @if($pages=="dashboard")      {{'kt-menu__item kt-menu__item--active'}} @endif"><a href="{{route('emp.dashboard')}}" class="kt-menu__link  btn btn-default rounded-pill btn btn-sm"><span class="kt-menu__link-text  font-8px">Dashboard</span></a></li>
                            <li class="kt-menu__item pl-2 @if($pages=="my info")        {{'kt-menu__item kt-menu__item--active'}} @endif"><a href="{{route('emp.account',Auth::guard('emp')->user()->id)}}" class="kt-menu__link  btn btn-default rounded-pill btn btn-sm"><span class="kt-menu__link-text  font-8px">My Info</span></a></li>
                            <li class="kt-menu__item pl-2 @if($pages=="Time Management"){{'kt-menu__item kt-menu__item--active'}} @endif"><a href="#" class="kt-menu__link  btn btn-default rounded-pill btn-sm"><span class="kt-menu__link-text font-8px">Time Management</span></a></li>
                            <li class="kt-menu__item pl-2 @if($pages=="Finance")        {{'kt-menu__item kt-menu__item--active'}} @endif"><a href="javascript:;" class="kt-menu__link  btn btn-default rounded-pill btn-sm"><span class="kt-menu__link-text font-8px">Finance</span></a></li>
                            <li class="kt-menu__item pl-2 @if($pages=="payroll")        {{'kt-menu__item kt-menu__item--active'}} @endif"><a href="{{route("emp.payroll.info",Auth::guard('emp')->user()->id)}}" class="kt-menu__link  btn btn-default rounded-pill btn-sm"><span class="kt-menu__link-text font-8px">Payroll</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end:: Brand -->
            <!-- begin:: Header Topbar -->
            <div class="kt-header__topbar kt-grid__item kt-grid__item--fluid">
                <!--begin: Search -->
                <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                        <span class="kt-header__topbar-icon kt-header__topbar-icon--brand"><i class="flaticon2-search-1"></i></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                        <div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact" id="kt_quick_search_dropdown">
                            <form method="get" class="kt-quick-search__form">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                    <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                    <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                                </div>
                            </form>
                            <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="325" data-mobile-height="200">
                            </div>
                        </div>
                    </div>
                </div>

                <!--end: Search -->

                <!--begin: Notifications -->
                <div class="kt-header__topbar-item dropdown">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                        <span class="kt-header__topbar-icon kt-header__topbar-icon--success"><i class="flaticon2-new-email"></i></span>
                        <span class="kt-hidden kt-badge kt-badge--danger"></span>
                    </div>
                </div>
                <!--end: Notifications -->
                <!--begin: User bar -->
                <div class="kt-header__topbar-item kt-header__topbar-item--user">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                        <span class="kt-hidden kt-header__topbar-welcome">Hi,</span>
                        <span class="kt-hidden kt-header__topbar-username">{{Auth::guard('emp')->user()->name}}</span>
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
                                {{Auth::guard('emp')->user()->name}}
                            </div>
                            <div class="kt-user-card__badge">
                                <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span>
                            </div>
                        </div>

                        <!--end: Head -->

                        <!--begin: Navigation -->
                        <div class="kt-notification">
                            <a href="custom/apps/user/profile-1/personal-information.html" class="kt-notification__item">
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
                            <a href="custom/apps/user/profile-3.html" class="kt-notification__item">
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
                            <a href="custom/apps/user/profile-2.html" class="kt-notification__item">
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
                            </a>
                            <div class="kt-notification__custom kt-space-between">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <a href="{{ route('karyawan.logout') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
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