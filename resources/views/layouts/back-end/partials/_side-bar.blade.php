<div id="sidebarMain" class="d-none">
    <?php $lang = Session::get('locale'); ?>
    <aside style="text-align: {{ $lang == 'ar' ? 'right' : 'left' }};"
        class="bg-white js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset pb-0">
                <div class="navbar-brand-wrapper justify-content-between side-logo">
                    <!-- Logo -->
                    {{-- @php(=\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value) --}}
                    <a class="navbar-brand" href="/" aria-label="Front">
                        <img onerror="this.src='{{ asset('public/assets/back-end/img/900x400/img1.jpg') }}'"
                            class="navbar-brand-logo-mini for-web-logo max-h-30"
                            src="{{ asset('public/assets/back-end/img/logo.jpg') }}" alt="Logo">
                    </a>
                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                        class="d-none js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->

                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                            data-placement="right" title="" data-original-title="Collapse"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                            data-template="<div class=&quot;tooltip d-none d-sm-block&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><div class=&quot;tooltip-inner&quot;></div></div>"
                            data-toggle="tooltip" data-placement="right" title=""
                            data-original-title="Expand"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <!-- Search Form -->
                    <div class="sidebar--search-form pb-3 pt-4">
                        <div class="search--form-group">
                            <button type="button" class="btn"><i class="tio-search"></i></button>
                            <input type="text" class="js-form-search form-control form--control"
                                id="search-bar-input" placeholder="{{ __('general.search_menu') }} ">
                        </div>
                    </div>
                    <!-- End Search Form -->
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('dashboard') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                title="{{ __('dashboard.dashboard') }}" href="{{ route('dashboard') }}">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ __('dashboard.dashboard') }}
                                </span>
                            </a>
                        </li>



                        <li class="nav-item">
                            <small class="nav-subtitle" title="">{{ __('general.web_config') }}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        @can('priority')

                            <li class="navbar-vertical-aside-has-menu {{ Request::is('priority*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:void(0)" title="{{ __('priority.priority') }}">
                                    <i class="tio-arrow-upward  nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ __('priority.priority') }}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{ Request::is('priority*') ? 'block' : 'none' }}">
                                    @can('all_priority')
                                        <li class="nav-item {{ Request::is('priority') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('priority') }}"
                                                title="{{ __('priority.all_priorities') }}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate">
                                                    {{ __('priority.all_priorities') }}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{ \App\Models\Priority::count() ?? 0  }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcan
                        @can('departments')


                            <li class="navbar-vertical-aside-has-menu {{ Request::is('department*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:void(0)" title="{{ __('department.department') }}">
                                    <i class="tio-category nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ __('department.department') }}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{ Request::is('department*') ? 'block' : 'none' }}">
                                    @can('all_department')
                                        <li class="nav-item {{ Request::is('department') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('department') }}"
                                                title="{{ __('department.all_departments') }}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate">
                                                    {{ __('department.all_departments') }}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{ \App\Models\Department::count()  ?? 0  }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endcan


                                </ul>
                            </li>
                        @endcan
                        @can('departments')


                            <li class="navbar-vertical-aside-has-menu {{ Request::is('management_complaint*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:void(0)" title="{{ __('complaint.complaint') }}">
                                    <i class="tio-category nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ __('complaint.main_complaints') }}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{ Request::is('management_complaint*') ? 'block' : 'none' }}">
                                    @can('all_complaints')
                                        <li class="nav-item {{ Request::is('management_complaint') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('complaint_management') }}"
                                                title="{{ __('complaint.all_complaints') }}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate">
                                                    {{ __('complaint.all_complaints') }}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{ \App\Models\ComplaintManagement::count() ?? 0  }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endcan


                                </ul>
                            </li>
                        @endcan
                        @can('complaints')


                            <li class="navbar-vertical-aside-has-menu {{ Request::is('complaint*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:void(0)" title="{{ __('complaint.complaints') }}">
                                    <i class="tio-chat-outlined nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ __('complaint.complaints') }}
                                    </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{ Request::is('complaint*') ? 'block' : 'none' }}">
                                    @can('complaints')
                                        <li class="nav-item {{ Request::is('complaint') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('complaint') }}"
                                                title="{{ __('complaint.all_complaints') }}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate">
                                                    {{ __('complaint.all_complaints') }}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        @if(auth()->user()->role_id == 1)
                                                        {{ \App\Models\Complaint::where('user_id' , auth()->id())->count() ?? 0  }}

                                                        @else
                                                        {{ \App\Models\Complaint::count() ?? 0  }}

                                                        @endif
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ Request::is('complaint/not_fiexed') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('complaint.not_fiexed') }}"
                                                title="{{ __('complaint.all_complaints_not_fiexed') }}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate">
                                                    {{ __('complaint.all_complaints_not_fiexed') }}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        @if(auth()->user()->role_id == 1)
                                                        {{ \App\Models\Complaint::where('status' , '!=' ,1)->orWhereNull('status')->where('user_id' , auth()->id())->count()  ?? 0 }}
                                                        @else
                                                        {{ \App\Models\Complaint::where('status' , '!=' ,1)->orWhereNull('status')->count() ?? 0 }}

                                                        @endif
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endcan


                                </ul>
                            </li>
                        @endcan
                        @can('Admin_Roles')
                        <li class="nav-item  ">
                            <small class="nav-subtitle" title="">{{ __('general.general_management') }}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        @endcan
                        @can('Admin_Roles')
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('roles*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                href="javascript:void(0)" title="{{ __('roles.roles') }}">
                                <i class="tio-key  nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ __('roles.roles') }}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{ Request::is('roles*') ? 'block' : 'none' }}">
                                <li class="nav-item {{ Request::is('roles') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('roles') }}"
                                        title="{{ __('roles.all_roles') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ __('roles.all_roles') }}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{ \App\Models\Role::count() ?? 0 }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('roles/create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('roles.create') }}"
                                        title="{{ __('roles.create_role') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ __('roles.create_role') }}
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endcan
                        @can('user_management')
                        <li
                            class="navbar-vertical-aside-has-menu {{ Request::is('user_management*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                href="javascript:void(0)" title="{{ __('roles.users') }}">
                                <i class="tio-user-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ __('roles.all_users') }}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{ Request::is('user_management*') ? 'block' : 'none' }}">
                                <li class="nav-item {{ Request::is('user_management') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('user_management') }}"
                                        title="{{ __('roles.all_users') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ __('roles.all_users') }}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{ \App\Models\User::count() ?? 0  }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('user_management/create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('user_management.create') }}"
                                        title="{{ __('roles.create_user') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ __('roles.create_user') }}
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endcan


                        <li class="nav-item pt-5">
                        </li>
                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>

@push('script_2')
    <script>
        $(window).on('load', function() {
            if ($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });

        //Sidebar Menu Search
        var $rows = $('.navbar-vertical-content .navbar-nav > li');
        $('#search-bar-input').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
    </script>
@endpush
