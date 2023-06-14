<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="ukmisau" />
    <!-- Stylesheets
 ============================================= -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/style.css" type="text/css" />

    <link rel="stylesheet" href="/css/dark.css" type="text/css" />
    <link rel="stylesheet" href="/css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="/css/magnific-popup.css" type="text/css" />
    
    <link rel="stylesheet" href="/css/custom.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="/css/colors.php?color=0275d8" type="text/css" />


    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .account-card {
            background-color: #00a1b4;
            /* Change the background color here */
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }



        #account-carousel {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .owl-carousel .owl-item .account-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #00a1b4;

            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .owl-carousel .owl-item .account-card h6 {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
        }

        .owl-carousel .owl-item .account-card p {
            margin-bottom: 5px;
            font-size: 14px;
            color: #fff;
        }


       
        .whatsapp-btn {
            position: fixed;
            bottom: 70px;
            right: 20px;
        }

        .whatsapp-btn .btn {
            width: 100%;
            border-radius: 20px;
            text-align: left;
            background: linear-gradient(to right, #25D366, #128C7E);
            color: #fff;
        }
    </style>

    <!-- Document Title
 ============================================= -->
    <title>@yield('PageTitle') | DataLinks</title>
    <link rel="stylesheet" href="/toastr/toastr.min.css">

</head>

<body class="stretched search-overlay">

    <!-- Document Wrapper
 ============================================= -->
    <div id="wrapper" class="clearfix">


        <!-- Header
  ============================================= -->
        <header id="header" class="full-header header-size-md" data-mobile-sticky="true">
            <div id="header-wrap">
                <div class="container">
                    <div class="header-row">

                        <!-- Logo
      ============================================= -->
                        <div id="logo">
                            <a href="#" class="standard-logo"><img src="/logo.jpg" alt="logo"></a>
                            <a href="#" class="retina-logo"><img src="/logo.jpg" alt="logo"></a>
                        </div>
                        <div class="header-misc ms-0">

                            <!-- Top Account
       ============================================= -->
                            <div class="header-misc-icon">
                                <a href="#" id="notifylink" data-bs-toggle="dropdown" data-bs-offset="0,15"
                                    aria-haspopup="true" aria-expanded="false" data-offset="12,12"><i
                                        class="icon-line-bell notification-badge"></i></a>
                                <div class="dropdown-menu dropdown-menu-end py-0 m-0 overflow-auto"
                                    aria-labelledby="notifylink" style="width: 320px; max-height: 300px">
                                    <span
                                        class="dropdown-header border-bottom border-f5 fw-medium text-uppercase ls1">Notifications</span>
                                    <div class="list-group list-group-flush">

                                        <a href="#" class="d-flex list-group-item">
                                            {{-- <i class="icon-line-check badge-icon bg-success text-white me-3 mt-1"></i> --}}
                                            <div class="media-body">
                                                <h5 class="my-0 fw-normal text-muted"><span class="text-dark fw-bold">No
                                                        New Notification</h5>
                                                {{-- <small class="text-smaller">2 days ago</small> --}}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Top Account
       ============================================= -->
                            <div class="header-misc-icon profile-image">
                                <a href="#" id="profilelink" data-bs-toggle="dropdown" data-bs-offset="0,15"
                                    aria-haspopup="true" aria-expanded="false" data-offset="12,12"><img
                                        class="rounded-circle" src="/default.png"
                                        alt="{{ auth()->user()->first_name }}"></a>
                                <div class="dropdown-menu dropdown-menu-end py-0 m-0" aria-labelledby="profilelink">
                                    <a class="dropdown-item" href="{{ route('logout') }}"><i
                                            class="icon-line-log-out me-2"></i>Sign Out</a>
                                </div>
                            </div>

                        </div>

                        <div id="primary-menu-trigger">
                            <svg class="svg-trigger" viewBox="0 0 100 100">
                                <path
                                    d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20">
                                </path>
                                <path d="m 30,50 h 40"></path>
                                <path
                                    d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20">
                                </path>
                            </svg>
                        </div>

                        @php
                            $route = Route::current()->getName();
                        @endphp

                        <nav class="primary-menu">

                            <ul class="menu-container">

                                @if (auth()->user()->user_type == 'regular')
                                    @include('layout.regular')
                                @endif
                                @if (auth()->user()->user_type == 'admin')
                                    @include('layout.admin')
                                @endif

                            </ul>

                        </nav>

                    </div>
                </div>
            </div>
            <div class="header-wrap-clone"></div>
        </header><!-- #header end -->

        <!-- Content
  ============================================= -->
        @yield('content')
        <!-- Footer
  ============================================= -->
        <footer id="footer" class="border-0" style="background-color: #F5F5F5;">


            <div class="line m-0"></div>

            <!-- Copyrights
   ============================================= -->
            <div id="copyrights" style="background-color: #FFF">
                <div class="container clearfix">

                    <div class="w-100 center m-0">
                        <span>Copyrights &copy; 2023 All Rights Reserved - DataLinks Ltd.</span>
                    </div>

                </div>
            </div><!-- #copyrights end -->
        </footer><!-- #footer end -->

    </div><!-- #wrapper end -->

    <!-- Go To Top
 ============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>
    <a href="https://api.whatsapp.com/send?phone=YOUR_PHONE_NUMBER" class="whatsapp-btn">
        <button type="button" class="btn btn-success">
            <i class="fab fa-whatsapp"></i> Contact Us on WhatsApp
        </button>
    </a>

    <!-- JavaScripts
 ============================================= -->
    <script src="/js/jquery.js"></script>
    <script src="/js/plugins.min.js"></script>

    <!-- TinyMCE Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!-- Bootstrap Select Plugin -->
    <script src="/js/components/bs-select.js"></script>

    <!-- Select Splitter Plugin -->
    <script src="/js/components/selectsplitter.js"></script>

    <!-- Footer Scripts
 ============================================= -->
    <script src="/js/functions.js"></script>
    <script src="/toastr/toastr.min.js"></script>

    @yield('js')

</body>

</html>
