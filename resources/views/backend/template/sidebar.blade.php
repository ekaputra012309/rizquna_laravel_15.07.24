<aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('backend/img/logo2.png') }}" alt="AdminLTE Logo" style="width: 150px;">
    </a>
    <div class="sidebar">
        <br>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @if (in_array($role, ['superadmin', 'admin', 'marketing', 'finance', 'visa']))
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @endif

                @if (in_array($role, ['superadmin', 'admin']))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Master Data<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('agent.index') }}" class="nav-link {{ request()->routeIs('agent.index') ? 'active' : '' }}">
                                <p>Agent</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hotel.index') }}" class="nav-link {{ request()->routeIs('hotel.index') ? 'active' : '' }}">
                                <p>Hotel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('room.index') }}" class="nav-link {{ request()->routeIs('room.index') ? 'active' : '' }}">
                                <p>Room</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rekening.index') }}" class="nav-link {{ request()->routeIs('rekening.index') ? 'active' : '' }}">
                                <p>Rekening</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if (in_array($role, ['superadmin', 'admin', 'marketing', 'finance', 'visa']))
                <li class="nav-header">Transaction</li>
                @endif

                @if (in_array($role, ['superadmin', 'admin', 'marketing']))
                <li class="nav-item">
                    <a href="{{ route('booking.index') }}" class="nav-link {{ request()->routeIs('booking.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hotel"></i>
                        <p>Booking Hotels</p>
                    </a>
                </li>
                @endif
                @if (in_array($role, ['superadmin', 'admin', 'finance']))
                <li class="nav-item">
                    <a href="{{ route('payment.index') }}" class="nav-link {{ request()->routeIs('payment.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>Payment Hotels</p>
                    </a>
                </li>
                @endif
                @if (in_array($role, ['superadmin', 'admin', 'visa', 'finance']))
                <li class="nav-item">
                    <a href="{{ route('visa.index') }}" class="nav-link {{ request()->routeIs('visa.index') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-cc-visa"></i>
                        <p>Payment Visa</p>
                    </a>
                </li>
                @endif

                @if (in_array($role, ['superadmin', 'admin', 'marketing', 'finance']))
                <li class="nav-header">Report</li>
                @endif

                @if (in_array($role, ['superadmin', 'admin', 'marketing', 'finance']))
                <li class="nav-item">
                    <a href="{{ route('agents.report.index') }}" class="nav-link {{ request()->routeIs('agents.report.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Report Agent</p>
                    </a>
                </li>
                @endif

                @if (in_array($role, ['superadmin', 'admin']))
                <li class="nav-header">Settings</li>
                @endif

                @if (in_array($role, ['superadmin', 'admin']))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Konfigurasi<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('privilage.index') }}" class="nav-link {{ request()->routeIs('privilage.index') ? 'active' : '' }}">
                                <p>Privilage</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                                <p>Manage User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>