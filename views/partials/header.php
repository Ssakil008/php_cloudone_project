<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Bulona - Bootstrap Admin Dashboard Template')</title>
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- simplebar CSS-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="assets/css/sidebar-menu.css" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="assets/css/app-style.css" rel="stylesheet" />
    <!-- skins CSS-->
    <link href="assets/css/skins.css" rel="stylesheet" />

    <link rel="stylesheet" href="alertify/themes/alertify.core.css" />
    <link rel="stylesheet" href="alertify/themes/alertify.default.css" />

</head>

<body>

    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->

    <!-- Start wrapper-->
    <div id="wrapper">
        <!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <a href="dashboard" style="margin-left: 10px;">
                <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                <h5 class="logo-text">Bulona Admin</h5>
            </a>

            <!-- Search input field -->
            <input type="text" id="searchInput" style="width: 90%; margin-left: 20px; padding: 5px; border-radius: 5px;" placeholder="Search menu">
            <ul class="sidebar-menu" id="sidebarMenu">
                <li>
                    <!-- <a href="javaScript:void();" class="waves-effect"> -->
                    <a href="dashboard">
                        <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span><i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <!-- <ul class="sidebar-submenu">
                        <li><a href="pages-403.html"><i class="zmdi zmdi-dot-circle-alt"></i> 403 Error</a></li>
                        <li><a href="pages-404.html"><i class="zmdi zmdi-dot-circle-alt"></i> 404 Error</a></li>
                        <li><a href="pages-500.html"><i class="zmdi zmdi-dot-circle-alt"></i> 500 Error</a></li>
                    </ul> -->
                </li>

                <!-- <li>
                    <a href="user_profile"><i class="zmdi zmdi-dot-circle-alt"></i> Credential For Server</a>
                </li>
                <li>
                    <a href="user_setup"><i class="zmdi zmdi-dot-circle-alt"></i> User Setup</a>
                </li>
                <li>
                    <a href="role"><i class="zmdi zmdi-dot-circle-alt"></i> Role</a>
                </li> -->
            </ul>
        </div>
        <!--End sidebar-wrapper-->

        <!--Start topbar header-->
        <header class="topbar-nav">
            <nav id="header-setting" class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <form class="search-bar">
                            <input type="text" class="form-control" placeholder="Enter keywords">
                            <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                        </form>
                    </li> -->
                </ul>
                <!-- Third nav-item positioned on the right -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                            <span class="user-profile"><i class="icon-user mr-2"></i>@auth {{auth()->user()->username}} @endauth</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><i class="icon-user mr-2"></i>@auth {{auth()->user()->username}} @endauth</div>
                                        <!-- <div class="media-body">
                                        <h6 class="mt-2 user-title">Sarajhon Mccoy</h6>
                                        <p class="user-subtitle">mccoy@example.com</p>
                                        </div> -->
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a href="#"><i class="icon-envelope mr-2"></i> Inbox</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a href="#"><i class="icon-wallet mr-2"></i> Account</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a href="#"><i class="icon-settings mr-2"></i> Setting</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item" id="logout"><a href="logout"><i class="icon-power mr-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <!--End topbar header-->

        <!--Success  Modal -->
        <div class="modal fade" id="successmodal">
            <div class="modal-dialog">
                <div class="modal-content border-success">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white">Successful</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center" id="successmessage">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!--End Modal -->

        <!--Error Modal -->
        <div class="modal fade" id="errormodal">
            <div class="modal-dialog">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Error</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center" id="errormessage">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!--End Modal -->

        <!-- Delete Confirmation Modal -->
        <!-- <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmBtn" class="btn btn-danger"></button>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- End Modal -->