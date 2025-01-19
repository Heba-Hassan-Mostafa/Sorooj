<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <span class="d-none d-md-inline-block text-muted">{{trans('dashboard.main')}}</span>
                </a>
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Language -->
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                @if (App::getLocale() == 'ar')
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        {{ LaravelLocalization::getCurrentLocaleName() }}
                        <img src="{{ asset('assets/admin/images/KW.png') }}" alt="">
                    </a>
                @else
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        {{ LaravelLocalization::getCurrentLocaleName() }}
                        <img src="{{ asset('assets/admin/images/US.png') }}" alt="">
                    </a>
                @endif
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <span class="align-middle">  {{ $properties['native'] }}</span>
                            </a>
                        @endforeach
                    </li>
                </ul>
            </li>
            <!--/ Language -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if (!empty(auth()->user()->avatar))
                            <img src="{{ auth()->user()->avatar }}" alt class="rounded-circle" />
                        @else
                            <img src="{{ asset('assets/admin/avatar.jpg') }}" alt class="rounded-circle" />
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        @if (!empty(auth()->user()->avatar))
                                            <img src="{{ auth()->user()->avatar }}" alt class="rounded-circle" />
                                        @else
                                            <img src="{{ asset('assets/admin/avatar.jpg') }}" alt class="rounded-circle" />
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block">
                                        {{ auth()->user()->fullName() }}
                                    </span>
                                    <small class="text-muted">
                                        @if (!empty(auth()->user()->getRoleNames()))
                                            @foreach (auth()->user()->getRoleNames() as $v)
                                                {{ $v }}
                                            @endforeach
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="ti ti-user-check me-2 ti-sm"></i>
                            <span class="align-middle">{{ trans('dashboard.profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.show-change-password') }}">
                            <i class="ti ti-key me-2 ti-sm"></i>
                            <span class="align-middle">{{ trans('dashboard.change-password') }}</span>
                        </a>
                    </li>

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>

                    <li>

                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <a class="dropdown-item" href="#"  onclick="event.preventDefault();this.closest('form').submit();">
                                <i class="ti ti-logout me-2 ti-sm"></i>
                                <span class="align-middle">{{ trans('dashboard.logout') }}</span>
                            </a>
                        </form>


                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input
            type="text"
            class="form-control search-input container-xxl border-0"
            placeholder="Search..."
            aria-label="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
</nav>
