<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- Title -->
    <title>Forgot Password | Subnow</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">
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
    <!-- Back Button-->
    <div class="login-back-button"><a href="{{ route('login') }}">
        <svg class="bi bi-arrow-left-short" width="32" height="32" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
        </svg></a></div>
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
      <div class="custom-container">
        <div class="text-center px-4"><img class="login-intro-img" src="/logo.jpg" alt=""></div>
        @if(session('status'))
            <div class="alert alert-success mt-3">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <div class="register-form mt-4">
            <form action="{{ route('password.send.reset.link') }}" method="POST">
                @csrf
                <div class="form-group text-start mb-3">
                    <input class="form-control" type="email" name="email" placeholder="Enter your email address">
                </div>
                <button class="btn btn-primary w-100" type="submit">Reset Password</button>
            </form>
            
        </div>



        <style>
          .whatsapp-float {
            position: fixed;
            bottom: 70px;
            right: 20px;
            z-index: 1000;
            display: flex;
            align-items: center;
          }
        
          .whatsapp-chat {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #25d366;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: #fff;
            font-size: 24px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
            margin-left: 10px; /* Added space between text and icon */
          }
        
          .whatsapp-chat:hover {
            background-color: #128c7e;
          }
        
          .whatsapp-text {
            color: #000; /* Black color for the text */
            font-size: 12px; /* Smaller font size */
          }
        </style>
        @php
        $number = App\Models\Charges::select('whatsapp_number')->first();
        @endphp
        
        <div class="whatsapp-float">
          <span class="whatsapp-text">Need Help?</span> <!-- Text is now to the left -->
          <a href="https://wa.me/{{ $number->whatsapp_number }}?text=Hello!%20SubNow%20NG..." target="_blank" class="whatsapp-chat">
              <i class="mx-auto bi bi-whatsapp"></i>
          </a>
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
    <script src="/theme/js/dark-rtl.js"></script>
    <script src="/theme/js/active.js"></script>
    <!-- PWA -->
    <script src="/theme/js/pwa.js"></script>
  </body>
</html>