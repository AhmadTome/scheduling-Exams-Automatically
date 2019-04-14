<!doctype html>
<html class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Dashboard | JSOFT Themes | JSOFT-Admin</title>
    <meta name="keywords" content="HTML5 Admin Template"/>
    <meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
    <meta name="author" content="JSOFT.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}"/>

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/morris/morris.css')}}"/>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}"/>

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>

</head>
<body>
<section class="body">

    <!-- start: header -->
    <header class="header">
        <div class="logo-container">
            <a href="" class="logo">
                <img src="{{asset('assets/images/logo.png')}}" height="40" alt="JSOFT Admin"/>
            </a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
                 data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <!-- start: search & user box -->
        <div class="header-right">

            <form action="pages-search-results.html" class="search nav-form">
                <div class="input-group input-search">
                    <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                    <span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
                </div>
            </form>

            <span class="separator"></span>

            <div id="userbox" class="userbox">
                <a href="#" data-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="{{asset('assets/images/!logged-user.jpg')}}" alt="Joseph Doe" class="img-circle"
                             data-lock-picture="{{asset('assets/images/!logged-user.jpg')}}"/>
                    </figure>
                    <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
                        <span class="name">{{{ isset(Auth::user()->name) ? Auth::user()->name : " " }}}</span>
                        <span class="role">administrator</span>
                    </div>

                    <i class="fa custom-caret"></i>
                </a>

                <div class="dropdown-menu">
                    <ul class="list-unstyled">
                        <li class="divider"></li>

                        <li>
                            <a role="menuitem" tabindex="-1" href="{{ url('/logout') }}"><i class="fa fa-power-off"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end: search & user box -->
    </header>
    <!-- end: header -->

    <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left">

            <div class="sidebar-header">
                <div class="sidebar-title">
                    Navigation
                </div>
                <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html"
                     data-fire-event="sidebar-left-toggle">
                    <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>

            <div class="nano">
                <div class="nano-content">
                    <nav id="menu" class="nav-main" role="navigation">
                        <ul class="nav nav-main">

                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-book" aria-hidden="true"></i>
                                    <span>Course</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="{{url('course')}}">
                                            Add
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('ED_course')}}">
                                            Edit & Delete
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>Room</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="{{url('room')}}">
                                            Add
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('ED_room')}}">
                                            Edit & Delete
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                    <span>Major</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="{{url('major')}}">
                                            Add
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('ED_major')}}">
                                            Edit & Delete
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <span>Schedule</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="{{url('schedule/add')}}">
                                            Add
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            Edit & Delete
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <span>Schedule Maker</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="{{url('scheduleMaker/show')}}">
                                            Show
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            Edit & Delete
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li>
                                <a href="http://themeforest.net/item/JSOFT-responsive-html5-template/4106987?ref=JSOFT"
                                   target="_blank">
                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                    <span>Front-End <em class="not-included">(Not Included)</em></span>
                                </a>
                            </li>
                        </ul>
                    </nav>


                </div>


            </div>

        </aside>
        <!-- end: sidebar -->

        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Dashboard</h2>

                <div class="right-wrapper pull-right" style="margin-right: 10px;">
                    <ol class="breadcrumbs">
                        <li>
                            <a href="index.html">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li><span>Dashboard</span></li>
                    </ol>

                </div>
            </header>
        @include('partials.errors')
        @include('partials.success')
        @yield('content')




        <!-- end: page -->
        </section>
    </div>


</section>

<!-- Vendor -->
<script src="{{asset('assets/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/nanoscroller/nanoscroller.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/vendor/magnific-popup/magnific-popup.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>

<!-- Specific Page Vendor -->
<script src="{{asset('assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-appear/jquery.appear.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-easypiechart/jquery.easypiechart.js')}}"></script>
<script src="{{asset('assets/vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('assets/vendor/flot-tooltip/jquery.flot.tooltip.js')}}"></script>
<script src="{{asset('assets/vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('assets/vendor/flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('assets/vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-sparkline/jquery.sparkline.js')}}"></script>
<script src="{{asset('assets/vendor/raphael/raphael.js')}}"></script>
<script src="{{asset('assets/vendor/morris/morris.js')}}"></script>
<script src="{{asset('assets/vendor/gauge/gauge.js')}}"></script>
<script src="{{asset('assets/vendor/snap-svg/snap.svg.js')}}"></script>
<script src="{{asset('assets/vendor/liquid-meter/liquid.meter.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/jquery.vmap.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/data/jquery.vmap.sampledata.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js')}}"></script>
<script src="{{asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js')}}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset('assets/javascripts/theme.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('assets/javascripts/theme.custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('assets/javascripts/theme.init.js')}}"></script>


<!-- Examples -->
<script src="{{asset('assets/javascripts/dashboard/examples.dashboard.js')}}"></script>
</body>
</html>