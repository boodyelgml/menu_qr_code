<!DOCTYPE html>
<html>
<head>
    {{-- title yielded here --}}
    <title>Magints QR Menus Scanner</title>
    {{-- Meta links --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Menu QR scanner" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App icon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <!-- Sweet Alert css -->
    <link href="{{asset('plugins/sweet-alert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    {{-- styles yielded here --}}
    @yield("styles")
    {{-- hover css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css">
    <!-- DataTables -->
    <link href="{{asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/customStyle.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('assets/js/modernizr.min.js')}}"></script>
    <script src="{{asset('assets/js/easy.qrcode.js')}}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-175216814-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-175216814-1');
    </script>
    <style>
         .QrDiv img , .QrDiv canvas{
        height: 100px;
        width: 100px;
    }
    </style>
</head>
<body>
    <div class='loaderContainer'>
        <div class='loader'>
            <div class='loader--dot'></div>
            <div class='loader--dot'></div>
            <div class='loader--dot'></div>
            <div class='loader--dot'></div>
            <div class='loader--dot'></div>
            <div class='loader--dot'></div>
            <div class='loader--text'></div>
        </div>
    </div>
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Start Top Bar Start -->
        <!-- ============================================================== -->
        <div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
                <a href="{{route('home')}}" class="logo">
                    <span>
                        <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/logo.png')}}" alt="" height="50" class="hvr-grow ">
                    </span>
                    <i>
                        <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/logo_sm.png')}}" alt="" height="28" class="hvr-grow ">
                    </i>
                </a>
            </div>
            <!----------------- Login & register buttons ------------------>
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-right-menu float-right mb-0">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><span class="mx-3">Login</span></a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><span class="mx-3">Register</span></a>
                    </li>
                    @endif
                    @else
                    <!----------------- logout & profile buttons ------------------>
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="user" class="rounded-circle hvr-grow">
                            <span class="ml-1">{{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i> </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            {{-- profile --}}
                            <a href="{{route("showModerators" , auth()->id())}}" class="dropdown-item notify-item">
                                <i class="dripicons-scale"></i> <span>My Profile</span>
                            </a>
                            {{-- logout --}}
                            <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                                <i class="fi-head"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
                {{-- left side bar toggle icon --}}
                @auth
                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left waves-light waves-effect">
                            <i class="dripicons-menu"></i>
                        </button>
                    </li>
                </ul>
                @endauth
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- Start left sidebar -->
        <!-- ============================================================== -->
        @auth
        <div class="left side-menu">
            <div class="slimscroll-menu" id="remove-scroll">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title">Navigation</li>
                        @if (Auth::user()->role === 1)
                        <li>
                            <a href="{{ route("home") }}">
                                <i class="fi-air-play"></i> <span> Dashboard </span>
                            </a>
                        </li>
                        {{-- moderators --}}
                        <li>
                            <a href="{{ route("moderators") }}">
                                <i class="fi-head"></i> <span> Moderators </span>
                            </a>
                        </li>
                        @endif
                        {{-- restaurant --}}
                        <li>
                            <a href="javascript: void(0);"><i class="dripicons-store"></i><span> Restaurants </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level collapse" aria-expanded="false">
                                <li><a href="{{ route('restaurants') }}">Restaurants List</a></li>
                                <li class="">
                                    <a href="javascript: void(0);" aria-expanded="false">Advertisements <span class="menu-arrow"></span></a>
                                    <ul class="nav-third-level nav collapse" aria-expanded="false">
                                        <li><a href="{{ route('TopAds') }}">Top Ads</a></li>
                                        <li><a href="{{ route('PopUpAds') }}">Pop Up Ads</a></li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="javascript: void(0);" aria-expanded="false">Feedback <span class="menu-arrow"></span></a>
                                    <ul class="nav-third-level nav collapse" aria-expanded="false">
                                        <li><a href="{{ route('questions') }}">Questions</a></li>
                                        <li><a href="{{ route('answers') }}">Answers</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        {{-- menus --}}
                        <li>
                            <a href="{{ route('menus') }}">
                                <i class="  dripicons-to-do"></i> <span> Menus </span>
                            </a>
                        </li>
                        {{-- categories --}}
                        <li>
                            <a href="{{ route('categories') }}">
                                <i class=" dripicons-copy"></i> <span> Categories </span>
                            </a>
                        </li>
                        {{-- items --}}
                        <li>
                            <a href="{{ route('items') }}">
                                <i class="  dripicons-view-apps"></i> <span> Items </span>
                            </a>
                        </li>
                        {{-- links --}}
                        <li>
                            <a href="{{ route('links') }}">
                                <i class="dripicons-link"></i> <span> Links </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -left -->
        </div>
        <!-- Left Sidebar End -->
        @endauth
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            {{-- Start content --}}
            <div class="content ">
                <div class="container-fluid">
                    {{-- top address and title bar --}}
                    @auth
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title float-left">@yield('title')</h4>
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Magints scanner</a></li>
                                    @yield('breadcrumps')
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    @endauth
                    <div class="row">
                        {{-- Content yield here --}}
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- Modal -->
    <!-- Large modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-center d-inline-block">
                <img data-toggle="modal" data-target=".bd-example-modal-lg" src="" id="targetImage" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    @guest
    <style>
        .content-page {
            margin-left: 0px;
        }

    </style>
    @endguest
    <!-- jQuery  -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/js/waves.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('plugins/waypoints/lib/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('plugins/counterup/jquery.counterup.min.js')}}"></script>
    <!-- Chart JS -->
    <script src="{{asset('plugins/chart.js/chart.bundle.js')}}"></script>
    <!-- Modal-Effect -->
    <script src="{{asset('plugins/custombox/js/custombox.min.js')}}></script>
      <script src=" {{asset('plugins/custombox/js/legacy.min.js')}}></script>
    @yield("scripts")
    <!-- Required datatable js -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
    <!-- Modal-Effect -->
    <script src="{{asset('plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('plugins/custombox/js/legacy.min.js')}}"></script>
    <script src="{{asset('plugins/sweet-alert/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('assets/js/jquery.core.js')}}"></script>
    <script src="{{asset('assets/js/jquery.app.js')}}"></script>
    <script>
        //preview uploaded photos
        $("#customFile").change(function() {
            $('.placeholder_image').hide();
            readURL(this);
        });
        // preview picture before upload
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }







        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.loaderContainer').fadeOut(200);

            // put tfoot after thead
            $('tfoot').each(function() {
                $(this).insertAfter($(this).siblings('thead'));
            });
        })


        $('img').on('click', function() {
            var src = $(this).attr('src');
            console.log(src)
            $('#targetImage').attr('src', src);
        })

    </script>
</body>
</html>
