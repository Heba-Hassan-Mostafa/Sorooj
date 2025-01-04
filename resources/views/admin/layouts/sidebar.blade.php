<aside id="layout-menu" class="layout-menu menu-vertical menu cairo pt-5 grayBgColorStyle">
    <div class="app-brand  m-auto">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link justify-content-center">
          <img src="{{ asset('assets/admin/images/logo.png') }}" alt="" class="w-60" style="">
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 mt-5 ">
        <!-- Dashboards -->

        <li class="menu-item {{ url()->current() == route('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div>{{ trans('dashboard.main') }} </div>
            </a>
        </li>

        <!-- users & roles-->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.roles') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.roles.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.roles') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ url()->current() == route('admin.admins.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.admins.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.admins') }}</div>
                    </a>
                </li>
            </ul>




        <!-- courses & categories-->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.courses') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.courses.category.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.courses.category.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.courses-categories') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ url()->current() == route('admin.courses.courses.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.courses.courses.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.courses') }}</div>
                    </a>
                </li>
            </ul>

{{--            <ul class="menu-sub">--}}
{{--                <li class="menu-item {{ url()->current() == route('admin.users.index') ? 'active' : '' }}">--}}
{{--                    <a href="{{ route('admin.users.index') }}" class="menu-link">--}}
{{--                        <div>{{ trans('dashboard.users') }}</div>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
        </li>

        <!-- books & categories-->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.books') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.books.category.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.books.category.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.books-categories') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ url()->current() == route('admin.books.books.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.books.books.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.books') }}</div>
                    </a>
                </li>
            </ul>

            {{--            <ul class="menu-sub">--}}
            {{--                <li class="menu-item {{ url()->current() == route('admin.users.index') ? 'active' : '' }}">--}}
            {{--                    <a href="{{ route('admin.users.index') }}" class="menu-link">--}}
            {{--                        <div>{{ trans('dashboard.users') }}</div>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--            </ul>--}}
        </li>



        <!-- blogs & categories-->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.blogs') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.blogs.category.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.category.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.blogs-categories') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ url()->current() == route('admin.blogs.blogs.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.blogs.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.blogs') }}</div>
                    </a>
                </li>
            </ul>

            {{--            <ul class="menu-sub">--}}
            {{--                <li class="menu-item {{ url()->current() == route('admin.users.index') ? 'active' : '' }}">--}}
            {{--                    <a href="{{ route('admin.users.index') }}" class="menu-link">--}}
            {{--                        <div>{{ trans('dashboard.users') }}</div>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--            </ul>--}}
        </li>

        <!-- videos & categories-->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.videos') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.videos.category.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.videos.category.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.videos-categories') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ url()->current() == route('admin.videos.videos.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.videos.videos.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.videos') }}</div>
                    </a>
                </li>
            </ul>

        </li>



        <!-- questions & answers-->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.questions_answers') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.fatwa.questions.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.fatwa.questions.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.questions') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ url()->current() == route('admin.fatwa.answers.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.fatwa.answers.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.answers') }}</div>
                    </a>
                </li>
            </ul>

        </li>
        <!-- home & sections -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('dashboard.sidebar.home-sections') }}</span>
        </li>
        <li class="menu-item {{ url()->current() == route('admin.slider.slider.index') ? 'active' : '' }}">
            <a href="{{ route('admin.slider.slider.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div>{{ trans('dashboard.sidebar.slider') }}</div>
            </a>
        </li>

        <!-- events -->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.upcoming-events') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.events.upcoming-events.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.events.upcoming-events.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.upcoming-events') }}</div>
                    </a>
                </li>
               <li class="menu-item {{ url()->current() == route('admin.events.past-events') ? 'active' : '' }}">
                    <a href="{{ route('admin.events.past-events') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.past-events') }}</div>
                    </a>
                </li>
            </ul>

        </li>
        <li class="menu-item {{ url()->current() == route('admin.clients.index') ? 'active' : '' }}">
            <a href="{{ route('admin.clients.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div>{{ trans('dashboard.sidebar.clients') }}</div>
            </a>
        </li>
        <li class="menu-item {{ url()->current() == route('admin.subscribers.index') ? 'active' : '' }}">
            <a href="{{ route('admin.subscribers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div>{{ trans('dashboard.sidebar.subscribers') }}</div>
            </a>
        </li>

        <li class="menu-item {{ url()->current() == route('admin.management-members.index') ? 'active' : '' }}">
            <a href="{{ route('admin.management-members.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div>{{ trans('dashboard.sidebar.management-members') }}</div>
            </a>
        </li>
        <li class="menu-item {{ url()->current() == route('admin.settings.live') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.live') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div>{{ trans('dashboard.sidebar.live') }}</div>
            </a>
        </li>
        <!-- settings-->
        <li class="menu-item ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ trans('dashboard.sidebar.settings') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ url()->current() == route('admin.settings.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.settings-contacts') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ url()->current() == route('admin.settings.aboutCenter') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.aboutCenter') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.settings-about') }}</div>
                    </a>
                </li>

                <li class="menu-item {{ url()->current() == route('admin.settings.websiteSettings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.websiteSettings') }}" class="menu-link">
                        <div>{{ trans('dashboard.sidebar.website-settings') }}</div>
                    </a>
                </li>
            </ul>


    </ul>
</aside>
