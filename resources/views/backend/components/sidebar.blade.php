<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div class="">
        <div class="sidebar-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="">
                <img src="{{ isset($settings) && $settings->logo ? asset('storage/' . $settings->logo) : asset('images/logo.png') }}"
                    alt="site logo" class="light-logo">
                <img src="{{ isset($settings) && $settings->backend_logo ? asset('storage/' . $settings->backend_logo) : (isset($settings) && $settings->logo ? asset('storage/' . $settings->logo) : asset('images/logo-light.png')) }}"
                    alt="site logo" class="dark-logo">
                <img src="{{ isset($settings) && $settings->favicon ? asset('storage/' . $settings->favicon) : asset('images/logo-icon.png') }}"
                    alt="site logo" class="logo-icon">
            </a>
            <button type="button" class="text-xxl d-xl-flex d-none line-height-1 sidebar-toggle text-neutral-500"
                aria-label="Collapse Sidebar">
                <i class="ri-contract-left-line"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">

            {{-- Dashboard --}}
            @can('dashboard-view')
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="ri-home-4-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endcan
            <li>
                <a href="{{ route('registration-types.index') }}">
                    <i class="ri-home-4-line"></i>
                    <span>Registration Types</span>
                </a>
            </li>

            {{-- Alumni (Dropdown) --}}

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <i class="ri-graduation-cap-line"></i>
                    <span>Alumni</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'membership']) }}"
                            class="{{ request('filter') == 'membership' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Membership
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'summit']) }}"
                            class="{{ request('filter') == 'summit' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Membership + Global Summit
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'accommodation']) }}"
                            class="{{ request('filter') == 'accommodation' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Accommodation
                        </a>
                    </li>

                </ul>
            </li>
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <i class="ri-graduation-cap-line"></i>
                    <span>Abstract</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'membership']) }}"
                            class="{{ request('filter') == 'membership' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Abstract Submission
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'summit']) }}"
                            class="{{ request('filter') == 'summit' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            My Review Queue
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'accommodation']) }}"
                            class="{{ request('filter') == 'accommodation' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Reviewer Assignement
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'accommodation']) }}"
                            class="{{ request('filter') == 'accommodation' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Abstract Categories
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alumni-registrations.index', ['filter' => 'accommodation']) }}"
                            class="{{ request('filter') == 'accommodation' ? 'active-menu' : '' }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Abstract Themes
                        </a>
                    </li>

                </ul>
            </li> --}}



            <li class="dropdown">
                <a href="javascript:void(0)">
                    <i class="ri-graduation-cap-line"></i>
                    <span>Administration</span>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ route('users.index') }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Admin Users
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('roles.index') }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Roles
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('permissions.index') }}">
                            <i class="ri-circle-fill circle-icon w-auto"></i>
                            Permissions
                        </a>
                    </li>

                </ul>
            </li>

           
        </ul>
    </div>
</aside>
