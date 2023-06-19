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
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title -->
    <title>deMentor - Welcome</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="/theme/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="/theme/img/icons/icon-96x96.png">
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
    <link rel="manifest" href="/theme/manifest.json">
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Hero Block Wrapper -->
    <div class="hero-block-wrapper bg-primary">
      <!-- Styles -->
      <div class="hero-block-styles">
        <div class="hb-styles1" style="background-image: url('theme/img/core-img/dot.png')"></div>
        <div class="hb-styles2"></div>
        <div class="hb-styles3"></div>
      </div>
      <div class="custom-container">
        <!-- Skip Page -->
        <div class="skip-page"><a href="{{ route('register') }}">Register</a></div>
        <!-- Hero Block Content -->
        <div class="hero-block-content"><img class="mb-4" src="img/bg-img/19.png" alt="">
          <h2 class="display-4 text-white mb-3">Welcome to deMentor</h2>
          <p class="text-white">This is a platform where you can ask questions, seek help with assignments, and get instant answers. You can also connect with writers for any writing needs.</p><a class="btn btn-warning btn-lg w-100" href="{{ route('login') }}">Get Started</a>
        </div>
      </div>
    </div>
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
    <script src="js/dark-rtl.js"></script>
    <script src="/theme/js/active.js"></script>
    <!-- PWA -->
    <script src="/theme/js/pwa.js"></script>
  </body>
</html>