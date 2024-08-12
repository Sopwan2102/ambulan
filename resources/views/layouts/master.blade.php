<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('images/favicon.ico')}}">

    <title>Dashboard</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{asset('admin/css/vendors_css.css')}}">

    <!-- Style-->
    <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/skin_color.css')}}">

</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>

        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">
                <a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent" data-toggle="push-menu" role="button">
                    <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                </a>
                <!-- Logo -->
                <a href="{{route('dashboard.index')}}" class="logo">
                    <!-- logo-->
                    <div class="logo-lg">
                        <!-- <span class="light-logo"><img src="../images/logo-dark-text.png" alt="logo"></span>
                        <span class="dark-logo"><img src="../images/logo-light-text.png" alt="logo"></span> -->
                        @if(auth()->user()->role == 'admin')
                            <span>Administrator</span>
                        @endif

                        @if(auth()->user()->role == 'driver')
                            <span>Driver</span>
                        @endif
                    </div>
                </a>
            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                        <li class="btn-group nav-item d-md-none">
                            <a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu" role="button">
                                <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                            </a>
                        </li>
                        <li class="btn-group nav-item d-none d-xl-inline-block">
                            <a href="#" class="waves-effect waves-light nav-link svg-bt-icon" title="Chat">
                                <i class="icon-Chat"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        </li>
                        <li class="btn-group nav-item d-none d-xl-inline-block">
                            <a href="#" class="waves-effect waves-light nav-link svg-bt-icon" title="Mailbox">
                                <i class="icon-Mailbox"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        </li>
                        <li class="btn-group nav-item d-none d-xl-inline-block">
                            <a href="#" class="waves-effect waves-light nav-link svg-bt-icon" title="Taskboard">
                                <i class="icon-Clipboard-check"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                            <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen" title="Full Screen">
                                <i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        </li>
                        <li class="btn-group d-lg-inline-flex d-none">
                            <div class="app-menu">
                                <div class="search-bx mx-5">
                                    <form>
                                        <div class="input-group">
                                            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addon3"><i class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        <!-- Notifications -->

                        <!-- User Account-->
                        <li class="dropdown user user-menu">
                            <a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="User">
                                <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                            <ul class="dropdown-menu animated flipInX">
                                <li class="user-body">
                                    <a class="dropdown-item" href="{{url('/')}}"><i class="ti-lock text-muted me-2"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <!-- sidebar-->
            <section class="sidebar position-relative">
                <div class="multinav">
                    <div class="multinav-scroll" style="height: 100%;">
                        <!-- sidebar menu-->
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">Dashboard</li>
                            <li class="">
                                <a href="{{route('dashboard.index')}}">
                                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Dashboard</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                            <li class="header">MENU </li>
                            <li class="">
                                <a href="{{route('ambulan.index')}}">
                                    <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Ambulans</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                            @if(auth()->user()->role == 'admin')
                            <li class="">
                                <a href="{{route('driver.index')}}">
                                    <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Data Driver</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{route('driver.konfirmasi')}}">
                                    <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Konfirmasi Driver</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </section>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            &copy; 2024 <a href="https://www.multipurposethemes.com/">Ambulance Siap Jemput</a>. All Rights Reserved.
        </footer>

        <!-- Control Sidebar -->

        <!-- /.control-sidebar -->

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->


    <!-- Vendor JS -->
    <script src="{{asset('admin/js/vendors.min.js')}}"></script>
    <script src="{{asset('admin/js/pages/chat-popup.js')}}"></script>
    <script src="{{asset('/assets/icons/feather-icons/feather.min.js')}}"></script>

    <script src="{{asset('/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js')}}"></script>
    <script src="{{asset('/assets/vendor_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('/assets/vendor_components/fullcalendar/fullcalendar.js')}}"></script>

    <!-- EduAdmin App -->
    <script src="{{asset('admin/js/template.js')}}"></script>
    <script src="{{asset('admin/js/pages/dashboard.js')}}"></script>
    <script src="{{asset('admin/js/pages/calendar.js')}}"></script>

</body>

</html>