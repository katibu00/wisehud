<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-nav .nav-link {
            color: #fff;
            margin: 0 10px;
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

        .form-group input::placeholder {
            opacity: 0.7;
        }

        .form-group input[type="password"] {
            padding-right: 30px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="height: 93vh;">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Register New Account</div>
                    <div class="card-body">
                        <form id="login-form">
                            @csrf
                            <div class="form-group">
                                <label class="mb-1"><strong>Full Name</strong><span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="name" id="full-name" placeholder="Enter your full name">
                                @error('full_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1"><strong>Phone Number</strong><span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="phone" id="phone-number" placeholder="Enter your phone number">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1"><strong>Email</strong> <span class="text-muted">(optional)</span></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                           
                            <div class="form-group">
                                <label class="mb-1"><strong>Referral Code</strong> <span class="text-muted">(optional)</span></label>
                                <input type="text" class="form-control" name="referral_code" placeholder="Enter referral code">
                            </div>
                            <div class="form-group">
                                <label class="mb-1"><strong>Password</strong><span class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password">
                                    <div class="input-group-append">
                                        <span class="input-group-text password-toggle"
                                            onclick="togglePasswordVisibility()">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                        Don't Have an Account? <a href="{{ route('register') }}">Register Here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand navbar-dark">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">How to Fund</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Useful Codes</a>
            </li>
        </ul>
    </nav>

    <a href="https://api.whatsapp.com/send?phone=YOUR_PHONE_NUMBER" class="whatsapp-btn">
        <button type="button" class="btn btn-success">
            <i class="fab fa-whatsapp"></i> Contact Us on WhatsApp
        </button>
    </a>
    <!-- Scripts here -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var passwordToggle = document.querySelector(".password-toggle");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordInput.type = "password";
                passwordToggle.innerHTML = '<i class="fa fa-eye"></i>';
            }
        }

        var passwordInput = document.getElementById("password");
        passwordInput.addEventListener("focus", function() {
            var passwordToggle = document.querySelector(".password-toggle");
            passwordToggle.style.opacity = "1";
        });

        passwordInput.addEventListener("blur", function() {
            var passwordToggle = document.querySelector(".password-toggle");
            passwordToggle.style.opacity = "0.7";
        });


        $(document).ready(function() {
            $('#login-form').submit(function(event) {
                event.preventDefault();
                var submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );

                var formData = new FormData(this);
                $.ajax({
                    url: '/register',
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
