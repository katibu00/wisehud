<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title -->
    <title>Wisehud AI - Register an Account</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    {{-- <link rel="manifest" href="manifest.json"> --}}
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
      <div class="custom-container">
        {{-- <div class="text-center px-4"><img class="login-intro-img" src="img/bg-img/36.png" alt=""></div> --}}
        <!-- Register Form -->
        <div class="register-form mt-4">
          <h6 class="mb-3 text-center">Register to continue to Wisehud AI.</h6>
          <form id="register-form">
            <div class="form-group text-start mb-3">
              <input class="form-control" type="text" name="name" placeholder="Enter your Name">
            </div>
            <div class="form-group text-start mb-3">
              <input class="form-control" type="text" name="phone" placeholder="Enter your Phone Number">
            </div>
            <div class="form-group text-start mb-3">
              <input class="form-control" type="email" name="email" placeholder="Enter your Email (optional)">
            </div>
            <div class="form-group text-start mb-3">
              <input class="form-control" type="email" name="referral_code" placeholder="Enter Referral Code (optional)">
            </div>
            <div class="form-group text-start mb-3 position-relative">
              <input class="form-control" id="psw-input" type="password" name="password" placeholder="New password">
              <div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></div>
            </div>
            <div class="mb-3" id="pswmeter"></div>
            {{-- <div class="form-check mb-3">
              <input class="form-check-input" id="checkedCheckbox" type="checkbox" value="" checked>
              <label class="form-check-label text-muted fw-normal" for="checkedCheckbox">I agree with the terms &amp; policy.</label>
            </div> --}}
            <button class="btn btn-primary w-100" type="submit">Sign Up</button>
          </form>
        </div>
        <!-- Login Meta -->
        <div class="login-meta-data text-center">
          <p class="mt-3 mb-0">Already have an account? <a class="stretched-link" href="{{ route('login') }}">Login</a></p>
        </div>
      </div>
    </div>
    <!-- All JavaScript Files -->
    <script src="/theme/js/bootstrap.bundle.min.js"></script>
    <script src="/theme/js/internet-status.js"></script>
    <script src="/theme/js/dark-rtl.js"></script>
    <!-- Password Strenght -->
    <script src="/theme/js/pswmeter.js"></script>
    <script src="/theme/js/active.js"></script>
    <!-- PWA -->
    <script src="/theme/js/pwa.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   

    <script>
      $(document).ready(function() {
          $('#register-form').submit(function(event) {
              event.preventDefault();
              var submitButton = $(this).find('button[type="submit"]');
              submitButton.prop('disabled', true).html(
                  '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait...'
              );
  
              var formData = new FormData(this);
  
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  url: '/register',
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response) {
                      submitButton.prop('disabled', false).text('Login');
  
                      if (response.message) {
                          Swal.fire({
                              icon: 'success',
                              title: 'Success',
                              text: response.message
                          }).then(() => {
                              window.location.href = '/login';
                          });
                      }
                  },
                  error: function(xhr, status, error) {
                      submitButton.prop('disabled', false).text('Login');
  
                      var response = xhr.responseJSON;
                      if (response && response.errors) {
                          var errorMessage = '';
                          $.each(response.errors, function(field, messages) {
                              errorMessage += messages[0] + '\n';
                          });
                          Swal.fire({
                              icon: 'warning',
                              title: 'Validation Error',
                              text: errorMessage
                          });
                      } else if (response && response.error) {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: response.error
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: 'An error occurred. Please try again.'
                          });
                      }
                  }
              });
          });
      });
  </script>
  
  </body>
</html>