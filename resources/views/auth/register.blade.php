<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Magints QR Menus Scanner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Generate & Manage Your Restaurant Digital Menus" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('assets/js/modernizr.min.js')}}"></script>

</head>


<body class="bg-accpunt-pages">
    <!-- HOME -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <div class="wrapper-page">

                        <div class="account-pages">

                            <div class="text-center">
                                <img data-toggle="modal" data-target=".bd-example-modal-lg"class="hvr-grow img-fluid" src="{{asset('assets/images/logo.png')}}" />
                            </div>
                            <div class="account-box">
                                <div class="account-logo-box">
                                    <h2 class="text-uppercase text-center">
                                        <a href="index.html" class="text-success">
                                            {{-- login logo --}}
                                            <img data-toggle="modal" data-target=".bd-example-modal-lg"class="hvr-grow img-fluid"
                                                src="{{asset('assets/images/qr-scanner.jpg')}}" width="100%" />

                                        </a>
                                    </h2>
                                </div>
                                <div class="account-content">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf




                                        <div class="form-group m-b-20 row">
                                            <div class="col-12">
                                                {{-- name --}}
                                                <label>Name</label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group m-b-20 row">
                                            <div class="col-12">
                                                {{-- name --}}
                                                <label>Email</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">


                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="form-group m-b-20 row">
                                            <div class="col-12">
                                                {{-- name --}}
                                                <label>Phone</label>
                                                <input id="phone" type="number"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" value="{{ old('phone') }}" required
                                                    autocomplete="phone">

                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group m-b-20 row">
                                            <div class="col-12">
                                                {{-- name --}}
                                                <label>Password</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group m-b-20 row">
                                            <div class="col-12">
                                                {{-- confirm password --}}
                                                <label>confirm Password</label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">


                                            </div>
                                        </div>


                                        {{-- login button --}}
                                        <div class="form-group row text-center m-t-10">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-block btn-gradient waves-effect waves-light">
                                                    {{ __('Register') }}
                                                </button>

                                            </div>


                                        </div>

                                    </form>

                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <p class="text-muted">Already have an account? <a href="login"
                                                    class="text-dark m-l-5"><b>log in</b></a></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end card-box-->

                    </div>
                    <!-- end wrapper -->

                </div>
            </div>
        </div>
    </section>

    </div>
    <!-- jQuery  -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/js/waves.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('plugins/waypoints/lib/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('plugins/counterup/jquery.counterup.min.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('assets/js/jquery.core.js')}}"></script>
    <script src="{{asset('assets/js/jquery.app.js')}}"></script>

</body>

</html>
