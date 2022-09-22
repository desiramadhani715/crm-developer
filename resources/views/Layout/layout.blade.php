<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{asset('images/icon2.png')}}" style="width: 80%">
    <title>Makuta Pro</title>

    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/jqvmap/jqvmap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css"/>

    {{-- <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/jqvmap/jqvmap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('dist/html/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist/html/assets/css/app.css" type="text/css')}}" /> --}}
    <style>
        .be-wrapper.be-fixed-sidebar .be-left-sidebar .left-sidebar-wrapper .left-sidebar-spacer .left-sidebar-scroll .left-sidebar-content .sidebar-elements>li a{
            border: 0 !important;
            background: transparent;
            color: #000;
            /* border-radius: 0 !important; */
            text-transform: capitalize;
            font-size: 13px;
            padding: 2px 20px;
            display: block;
            letter-spacing: 0.07em;
            font-weight: 500;
            /* -webkit-transition: all 0.5s ease; */
            /* transition: all 0.5s ease; */
            position: relative;
        }
        .be-wrapper.be-fixed-sidebar .be-left-sidebar .left-sidebar-wrapper .left-sidebar-spacer .left-sidebar-scroll .left-sidebar-content .sidebar-elements>li a i{
            color: #000;
        }
        .be-wrapper.be-fixed-sidebar .be-left-sidebar .left-sidebar-wrapper .left-sidebar-spacer .left-sidebar-scroll .left-sidebar-content .sidebar-elements>li a.nav-link:hover{
            background-color: #e7a163b6;
            color: #000;
            /* -webkit-transition: all 0.5s ease;
            transition: all 0.5s ease; */
            position: relative;
            border-radius: 20px;
        }
        .active2{
            background-color: #e7a163b6;
            color: #fff;
            /* -webkit-transition: all 0.5s ease;
            transition: all 0.5s ease; */
            position: relative;
            border-radius: 20px;
        }
    </style>
    @yield('header')

  </head>
  <body>
    <div class="be-wrapper be-fixed-sidebar">
        <nav class="navbar navbar-expand fixed-top be-top-header">
            <div class="container-fluid">
                <div class="be-navbar-header">
                    <a class="" href="{{url('/')}}"><img src="{{asset('images/logo brand new.png')}}" alt="" class="ml-3 img-fluid" style="width : 90%; height : auto;" ></a>
                </div>
                <div class="be-right-navbar">
                    <ul class="nav navbar-nav float-right be-user-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"  data-toggle="dropdown" role="button" aria-expanded="false"><img src="{{ Auth::user()->LogoPT != null ? asset('images/logo/'.Auth::user()->LogoPT) : asset('storage/uploaded/user.jpg') }}" class="rounded-circle logo"  ></a>
                            <div class="dropdown-menu" role="menu">
                                <div class="user-info">
                                    <div class="username">{{Auth::User()->NamaPT}}</div>
                                    <div class="user-position online">Available</div>
                                </div>
                                <a class="dropdown-item" href="{{url('logout')}}"><span class="icon mdi mdi-power"></span>Logout</a>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right be-icons-nav">
                        <li class="nav-item mt-4 mr-2 mr-lg-0 namaPT"><strong>{{Auth::user()->NamaPT}}</strong></li>
                    </ul>
                </div>
            </div>
        </nav>
f
        <div class="be-left-sidebar" style="background-color: #fff; font-family: sans-serif;">
            <div class="left-sidebar-wrapper"><a class="left-sidebar-toggle" id="menu">Dashboard</a>
                <div class="left-sidebar-spacer" id="menu1">
                    <div class="left-sidebar-scroll">
                        <div class="left-sidebar-content">
                            <ul class="sidebar-elements" >
                                <li >
                                    <div class="text-center mt-4 mb-3 d-none d-sm-block">
                                        <img src="{{ Auth::user()->LogoPT != null ? asset('images/logo/'.Auth::user()->LogoPT) : asset('storage/uploaded/user.jpg') }}" class="rounded-circle img-thumbnail" alt="logo" width="150px" >
                                    </div>
                                </li>
                                <li class="divider" style="color: #FB8C2E"><hr>Menu</li>
                                <li class="mx-3 my-1  my-1 {{Route::is('dashboard*') ? 'active2' : ''}}">
                                    <a class="nav-link " href="{{url('/')}}"><i class="icon mdi mdi-home" ></i>Dashboard</a>
                                </li>
                                <li class="mx-3 my-1  {{Route::is('prospect*') ? 'active2' : ''}}">
                                    <a class="nav-link" href="{{url('prospects')}}"><i class="icon mdi mdi-format-list-bulleted"></i>Prospects</a>
                                </li>
                                <li class="mx-3 my-1  {{Route::is('project*') ? 'active2' : ''}}">
                                    <a class="nav-link" href="{{url('projects')}}"><i class="icon mdi mdi-border-all"></i>Projects</a>
                                </li>
                                <li class="mx-3 my-1  {{Route::is('agent*') ? 'active2' : ''}}">
                                    <a class="nav-link" href="{{url('agent')}}"><i class="icon mdi mdi-accounts"></i>Agent</a>
                                </li>
                                <li class="mx-3 my-1  {{Route::is('demografi*') ? 'active2' : ''}}">
                                    <a class="nav-link" href="{{url('demografi')}}"><i class="icon mdi mdi-chart"></i>Demographics</a>
                                </li>
                                <li class="mx-3 my-1  {{Route::is('notinterested*') ? 'active2' : ''}}">
                                    <a class="nav-link" href="{{url('notInterested')}}" ><i class="icon mdi mdi-block-alt"></i>Not Interested</a>
                                </li>
                                <li class="mx-3 my-1  {{Route::is('roas*') ? 'active2' : ''}}">
                                    <a class="nav-link" href="{{url('roas')}}" ><i class="icon mdi mdi-money"></i>ROAS</a>
                                </li>
                                <li class="mx-3 my-1  {{Route::is('unit*') ? 'active2' : ''}}">
                                    <a class="nav-link" href="{{route('unit.index')}}" ><i class="icon mdi mdi-map"></i>Unit Type</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="be-left-sidebar">
            <div class="left-sidebar-wrapper"><a class="left-sidebar-toggle" href="#">Dashboard </a>
                <div class="left-sidebar-spacer">
                    <div class="left-sidebar-scroll">
                        <div class="left-sidebar-content">
                            <ul class="sidebar-elements">
                                <li class="divider">Menu</li>
                                <li class="active"><a href="index.html"><i class="icon mdi mdi-home"></i><span>Dashboard</span></a>
                                </li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-face"></i><span>UI Elements</span></a>
                                    <ul>
                                        <li><a href="ui-alerts.html">Alerts</a>
                                        </li>
                                        <li><a href="ui-buttons.html">Buttons</a>
                                        </li>
                                        <li><a href="ui-cards.html"><span class="badge badge-primary float-right">New</span>Cards</a>
                                        </li>
                                        <li><a href="ui-panels.html">Panels</a>
                                        </li>
                                        <li><a href="ui-general.html">General</a>
                                        </li>
                                        <li><a href="ui-modals.html">Modals</a>
                                        </li>
                                        <li><a href="ui-notifications.html">Notifications</a>
                                        </li>
                                        <li><a href="ui-icons.html">Icons</a>
                                        </li>
                                        <li><a href="ui-grid.html">Grid</a>
                                        </li>
                                        <li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a>
                                        </li>
                                        <li><a href="ui-nestable-lists.html">Nestable Lists</a>
                                        </li>
                                        <li><a href="ui-typography.html">Typography</a>
                                        </li>
                                        <li><a href="ui-dragdrop.html"><span class="badge badge-primary float-right">New</span>Drag &amp; Drop</a>
                                        </li>
                                        <li><a href="ui-sweetalert2.html"><span class="badge badge-primary float-right">New</span>Sweetalert 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent"><a href="charts.html"><i class="icon mdi mdi-chart-donut"></i><span>Charts</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="charts-flot.html">Flot</a>
                                        </li>
                                        <li><a href="charts-sparkline.html">Sparklines</a>
                                        </li>
                                        <li><a href="charts-chartjs.html">Chart.js</a>
                                        </li>
                                        <li><a href="charts-morris.html">Morris.js</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-dot-circle"></i><span>Forms</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="form-elements.html">Elements</a>
                                        </li>
                                        <li><a href="form-validation.html">Validation</a>
                                        </li>
                                        <li><a href="form-multiselect.html">Multiselect</a>
                                        </li>
                                        <li><a href="form-wizard.html">Wizard</a>
                                        </li>
                                        <li><a href="form-masks.html">Input Masks</a>
                                        </li>
                                        <li><a href="form-wysiwyg.html">WYSIWYG Editor</a>
                                        </li>
                                        <li><a href="form-upload.html">Multi Upload</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-border-all"></i><span>Tables</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="tables-general.html">General</a>
                                        </li>
                                        <li><a href="tables-datatables.html">Data Tables</a>
                                        </li>
                                        <li><a href="tables-filters.html"><span class="badge badge-primary float-right">New</span>Table Filters</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-layers"></i><span>Pages</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="pages-blank.html">Blank Page</a>
                                        </li>
                                        <li><a href="pages-blank-header.html">Blank Page Header</a>
                                        </li>
                                        <li><a href="pages-login.html">Login</a>
                                        </li>
                                        <li><a href="pages-login2.html">Login v2</a>
                                        </li>
                                        <li><a href="pages-404.html">404 Page</a>
                                        </li>
                                        <li><a href="pages-sign-up.html">Sign Up</a>
                                        </li>
                                        <li><a href="pages-forgot-password.html">Forgot Password</a>
                                        </li>
                                        <li><a href="pages-profile.html">Profile</a>
                                        </li>
                                        <li><a href="pages-pricing-tables.html">Pricing Tables</a>
                                        </li>
                                        <li><a href="pages-pricing-tables2.html">Pricing Tables v2</a>
                                        </li>
                                        <li><a href="pages-timeline.html">Timeline</a>
                                        </li>
                                        <li><a href="pages-timeline2.html">Timeline v2</a>
                                        </li>
                                        <li><a href="pages-invoice.html"><span class="badge badge-primary float-right">New</span>Invoice</a>
                                        </li>
                                        <li><a href="pages-calendar.html">Calendar</a>
                                        </li>
                                        <li><a href="pages-gallery.html">Gallery</a>
                                        </li>
                                        <li><a href="pages-code-editor.html"><span class="badge badge-primary float-right">New    </span>Code Editor</a>
                                        </li>
                                        <li><a href="pages-booking.html"><span class="badge badge-primary float-right">New</span>Booking</a>
                                        </li>
                                        <li><a href="pages-loaders.html"><span class="badge badge-primary float-right">New</span>Loaders</a>
                                        </li>
                                        <li><a href="pages-ajax-loader.html"><span class="badge badge-primary float-right">New</span>AJAX Loader</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="divider">Features</li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-inbox"></i><span>Email</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="email-inbox.html">Inbox</a>
                                        </li>
                                        <li><a href="email-read.html">Email Detail</a>
                                        </li>
                                        <li><a href="email-compose.html">Email Compose</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-view-web"></i><span>Layouts</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="layouts-primary-header.html">Primary Header</a>
                                        </li>
                                        <li><a href="layouts-success-header.html">Success Header</a>
                                        </li>
                                        <li><a href="layouts-warning-header.html">Warning Header</a>
                                        </li>
                                        <li><a href="layouts-danger-header.html">Danger Header</a>
                                        </li>
                                        <li><a href="layouts-search-input.html">Search Input</a>
                                        </li>
                                        <li><a href="layouts-offcanvas-menu.html">Off Canvas Menu</a>
                                        </li>
                                        <li><a href="layouts-top-menu.html"><span class="badge badge-primary float-right">New</span>Top Menu</a>
                                        </li>
                                        <li><a href="layouts-nosidebar-left.html">Without Left Sidebar</a>
                                        </li>
                                        <li><a href="layouts-nosidebar-right.html">Without Right Sidebar</a>
                                        </li>
                                        <li><a href="layouts-nosidebars.html">Without Both Sidebars</a>
                                        </li>
                                        <li><a href="layouts-fixed-sidebar.html">Fixed Left Sidebar</a>
                                        </li>
                                        <li><a href="layouts-boxed-layout.html"><span class="badge badge-primary float-right">New</span>Boxed Layout</a>
                                        </li>
                                        <li><a href="pages-blank-aside.html">Page Aside</a>
                                        </li>
                                        <li><a href="layouts-collapsible-sidebar.html">Collapsible Sidebar</a>
                                        </li>
                                        <li><a href="layouts-sub-navigation.html"><span class="badge badge-primary float-right">New</span>Sub Navigation</a>
                                        </li>
                                        <li><a href="layouts-mega-menu.html"><span class="badge badge-primary float-right">New</span>Mega Menu</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-pin"></i><span>Maps</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="maps-google.html">Google Maps</a>
                                        </li>
                                        <li><a href="maps-vector.html">Vector Maps</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent"><a href="#"><i class="icon mdi mdi-folder"></i><span>Menu Levels</span></a>
                                    <ul class="sub-menu">
                                        <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 1</span></a>
                                            <ul class="sub-menu">
                                                <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
                                                </li>
                                                <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
                                                    <ul class="sub-menu">
                                                        <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
                                                        </li>
                                                        <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 1</span></a>
                                            <ul class="sub-menu">
                                                <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
                                                </li>
                                                <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
                                                    <ul class="sub-menu">
                                                        <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
                                                        </li>
                                                        <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="documentation.html"><i class="icon mdi mdi-book"></i><span>Documentation</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="progress-widget">
                    <div class="progress-data"><span class="progress-value">60%</span><span class="name">Current Project</span></div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary" style="width: 60%;"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        @yield('content')
    </div>

    @yield('footer')
     <script src="{{asset('dist/html/assets/lib/jquery-flot/jquery.flot.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jquery-flot/jquery.flot.pie.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jquery-flot/jquery.flot.time.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jquery-flot/jquery.flot.resize.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js')}}" type="text/javascript">
     </script>
     <script src="{{asset('dist/html/assets/lib/jquery-flot/plugins/curvedLines.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jquery-flot/plugins/jquery.flot.tooltip.js')}}" type="text/javascript">
     </script>
     <script src="{{asset('dist/html/assets/lib/jquery.sparkline/jquery.sparkline.min.js')}}" type="text/javascript">
     </script>
     <script src="{{asset('dist/html/assets/lib/countup/countUp.min.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jqvmap/jquery.vmap.min.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/lib/jqvmap/maps/jquery.vmap.world.js')}}" type="text/javascript"></script>
     <script src="{{asset('dist/html/assets/js/app-dashboard.js')}}" type="text/javascript"></script>
     <script type="text/javascript">
     $(document).ready(function() {
         //-initialize the javascript
         App.init();
         App.dashboard();
        var  element = document.getElementById("menu");
        var paragraf = document.querySelectorAll("#menu1");
        element.onclick = function(){
            paragraf[1].classList.add("open");
        }
     });

     </script>

  </body>
</html>
