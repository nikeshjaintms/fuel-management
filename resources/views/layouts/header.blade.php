<div class="main-panel">
    <div class="main-header">
        <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="index.html" class="logo">
                    <img src="{{ asset('backend/assets/logo/logo.png') }}" alt="navbar brand"
                        class="navbar-brand" height="20" />
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
        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">

                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">


                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                            aria-expanded="false">

                            <span class="profile-username">
                                <span class="op-7">Hi,</span>
                                <span class="fw-bold">{{ Auth::guard('admin')->user()->name ?? Auth::guard('web')->user()->name }}</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">

                                        <div class="u-text">
                                            <h4>{{ Auth::guard('admin')->user()->name ?? Auth::guard('web')->user()->name}}</h4>
                                            <p class="text-muted">{{ Auth::guard('admin')->user()->email ?? Auth::guard('web')->user()->email}}</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Change Password</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout')}}">Logout</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>
