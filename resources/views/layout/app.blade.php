<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affan - PWA Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- Title -->
    <title> Wisehud AI - @yield('pageTitle')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="/theme/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/theme/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/theme/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/theme/img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="/theme/css/bootstrap-icons.css">
    <link rel="stylesheet" href="/theme/css/tiny-slider.css">
    <link rel="stylesheet" href="/theme/css/baguetteBox.min.css">
    <link rel="stylesheet" href="/theme/css/rangeslider.css">
    <link rel="stylesheet" href="/theme/css/vanilla-dataTables.min.css">
    <link rel="stylesheet" href="/theme/css/apexcharts.css">
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="/theme/style.css">
    <!-- Web App Manifest -->
    {{-- <link rel="manifest" href="/theme/manifest.json"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    @yield('css')
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
      <div class="container">
        <!-- # Paste your Header Content from here -->
        <!-- # Header Five Layout -->
        <!-- # Copy the code from here ... -->
        <!-- Header Content -->
        <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
          <!-- Logo Wrapper -->
          <div class="logo-wrapper"><a href="page-home.html"><img src="img/core-img/logo.png" alt=""></a></div>
          <!-- Navbar Toggler -->
          <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
        </div>
        <!-- # Header Five Layout End -->
      </div>
    </div>
    <!-- # Sidenav Left -->
    <!-- Offcanvas -->
    @include('layout.sidebar.sidebar')
    @yield('content')
    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
      <div class="container px-0">
        <!-- =================================== -->
        <!-- Paste your Footer Content from here -->
        <!-- =================================== -->
        <!-- Footer Content -->
        @include('layout.footer')
      </div>
    </div>
    @yield('js')
    <!-- All JavaScript Files -->
    <script src="/theme/js/bootstrap.bundle.min.js"></script>
    <script src="/theme/js/slideToggle.min.js"></script>
    <script src="/theme/js/internet-status.js"></script>
    <script src="/theme/js/tiny-slider.js"></script>
    <script src="/theme/js/baguetteBox.min.js"></script>
    <script src="/theme/js/countdown.js"></script>
    <script src="/theme/js/rangeslider.min.js"></script>
    <script src="/theme/js/vanilla-dataTables.min.js"></script>
    <script src="/theme/js/index.js"></script>
    <script src="/theme/js/magic-grid.min.js"></script>
    <script src="/theme/js/dark-rtl.js"></script>
    <script src="/theme/js/active.js"></script>
    <!-- PWA -->
    <script src="/theme/js/pwa.js"></script>
  
  </body>
</html>