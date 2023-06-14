<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<meta name="keywords" content="Chatgpt" />
		<meta name="description" content="">
		<meta name="author" content="">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="/vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="/vendor/font-awesome/css/all.min.css" />
		<link rel="stylesheet" href="/vendor/boxicons/css/boxicons.min.css" />
		<link rel="stylesheet" href="/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="/css/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="/css/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="/css/custom.css">

		<!-- Head Libs -->
		<script src="/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				{{-- <a href="/" class="logo float-left">
					<img src="img/logo.png" height="70" alt="Porto Admin" />
				</a> --}}

				<div class="panel card-sign">
					{{-- <div class="card-title-sign mt-3 text-end">
						<h2 class="title text-uppercase font-weight-bold m-0"><i class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Sign In</h2>
					</div> --}}
					<div class="card-body">
						<form id="login-form"> 
							<div class="form-group mb-3">
								<label>Phone Number/Email</label>
								<div class="input-group">
									<input name="email_or_phone" type="text" class="form-control form-control-lg" />
									<span class="input-group-text">
										<i class="bx bx-user text-4"></i>
									</span>
								</div>
							</div>

							<div class="form-group mb-3">
								<div class="clearfix">
									<label class="float-left">Password</label>
									<a href="#" class="float-end">Lost Password?</a>
								</div>
								<div class="input-group">
									<input name="password" type="password" class="form-control form-control-lg" />
									<span class="input-group-text">
										<i class="bx bx-lock text-4"></i>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
									<div class="checkbox-custom checkbox-default">
										<input id="RememberMe" name="rememberme" type="checkbox"/>
										<label for="RememberMe">Remember Me</label>
									</div>
								</div>
								<div class="col-sm-4 text-end">
									<button type="submit" class="btn btn-primary mt-2">Sign In</button>
								</div>
							</div>

							<span class="mt-3 mb-3 line-thru text-center text-uppercase">
								<span>or</span>
							</span>

							<div class="mb-1 text-center">
								<a class="btn btn-facebook mb-3 ms-1 me-1" href="#">Connect with <i class="fab fa-facebook-f"></i></a>
								<a class="btn btn-twitter mb-3 ms-1 me-1" href="#">Connect with <i class="fab fa-twitter"></i></a>
							</div>

							<p class="text-center">Don't have an account yet? <a href="pages-signup.html">Sign Up!</a></p>

						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-3 mb-3">&copy; Copyright 2021. All Rights Reserved.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="/vendor/jquery/jquery.js"></script>
		<script src="/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="/vendor/popper/umd/popper.min.js"></script>
		<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="/vendor/common/common.js"></script>
		<script src="/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

		<!-- Specific Page Vendor -->

		<!-- Theme Base, Components and Settings -->
		<script src="/js/theme.js"></script>

		<!-- Theme Custom -->
		<script src="/js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="/js/theme.init.js"></script>
        <script>
           
    
    
            $(document).ready(function() {
                $('#login-form').submit(function(event) {
                    event.preventDefault();
                    var submitButton = $(this).find('button[type="submit"]');
                    submitButton.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
    
                    var formData = new FormData(this);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/login',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            submitButton.prop('disabled', false).text('Login');
    
                            if (response.success) {
                                toastr.success('Login successful. Redirecting to dashboard...');
                                setTimeout(function() {
                                    window.location.href = response.redirect_url;
                                }, 200);
                            } else {
                                toastr.error('Invalid credentials.');
                            }
                        },
                        error: function(xhr, status, error) {
                            submitButton.prop('disabled', false).text('Login');
    
                            var response = xhr.responseJSON;
                            if (response && response.errors && response.errors.login_error) {
                                toastr.warning(response.errors.login_error[0]);
                            } else if (response && response.message) {
                                toastr.error(response.message);
                            } else {
                                toastr.error('An error occurred. Please try again.');
                            }
                        }
                    });
                });
            });
        </script>
	</body>
</html>