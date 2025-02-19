<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="{{ asset('backend/assets/logo/logo.png') }}" alt="navbar brand"
                            class="navbar-brand" height="65" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item {{ request()->segment(1) == '' ? 'active' : '' }}">
                            <a href="{{ route('index')}}" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Modules</h4>
                        </li>
                        <li class="nav-item {{ request()->segment(1) == 'vehicles' ? 'active' : '' }}">
                            <a href="{{ route('admin.vehicles.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Vehicles Information</p>
                                <span class="caret"></span>
                            </a>

                        </li>
                        <li class="nav-item {{ request()->segment(1) == 'fuel-filling' ? 'active' : '' }}">
                            <a href="{{ route('admin.fuel_filling.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Fuel Fillings</p>
                                <span class="caret"></span>
                            </a>

                        </li>
                        <li class="nav-item {{ request()->segment(1) == 'customer-info' ? 'active' : '' }}">
                            <a href="{{ route('admin.customer_info.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Customer</p>
                                <span class="caret"></span>
                            </a>

                        </li>
                        <li class="nav-item {{ request()->segment(1) == 'rto' ? 'active' : '' }}">
                            <a href="{{ route('admin.rto.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>RTO</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->segment(1) == 'driver' ? 'active' : '' }}">
                            <a href="{{ route('admin.driver.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Drivers</p>
                                <span class="caret"></span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
