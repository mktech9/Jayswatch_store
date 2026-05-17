<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Jayswatch Admin Panel </title>
    {{-- <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="simple admin panel template html css,admin panel html,bootstrap 5 admin template,admin,bootstrap dashboard,bootstrap 5 admin panel template,html and css,admin panel,admin panel html template,simple html template,bootstrap admin template,admin dashboard,admin dashboard template,admin panel template,template dashboard"> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->

    <link rel="icon" href="{{ $actual_url . '/admin_assets/favicon.ico' }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/css/iziToast.min.css' }}">
    <!-- Main Theme Js -->
    <script src="{{ $actual_url . '/admin_assets/js/authentication-main.js' }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ $actual_url . '/admin_assets/libs/bootstrap/css/bootstrap.min.css' }}"
        rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ $actual_url . '/admin_assets/css/styles.min.css' }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ $actual_url . '/admin_assets/css/icons.min.css' }}" rel="stylesheet">

    <style>
        /* =====================
       DESKTOP (DEFAULT)
    ====================== */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
                url("{{ $actual_url . '/admin_assets/jayswatch_login.png' }}");
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            min-height: 100vh;
        }

        /* =====================
       MOBILE & TABLET
    ====================== */
        @media (max-width: 991.98px) {
            body {
                background:
                    linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
                    url("https://jayswatchstore.com/front/assets/images/collection.png");
                background-repeat: no-repeat;
                background-position: center center;
                background-attachment: scroll;
                /* better performance on mobile */
                background-size: cover;
            }
        }
    </style>

    <style>
        #loginForm label {
            font-weight: 500;
        }

        #loginForm .input-group .btn {
            border-radius: 0 10px 10px 0 !important;
        }

        @media (max-width: 576px) {
            #loginForm .btn-lg {
                font-size: 15px;
            }
        }
    </style>
    <style>
        /* FIX BOOTSTRAP MODAL BACKDROP */
        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1055 !important;
        }

        /* Ensure modal is not trapped inside page stacking context */
        body.modal-open {
            overflow: hidden;
        }
    </style>

</head>

<body>



    <div class="page error-bg" id="particles-js">
        <!-- Start::error-page -->
        <div class="error-page  ">
            <div class="container">
                <!-- Start::row-1 -->
                <div class="row justify-content-end">
                    <div class="col-xl-8 col-md-12 col-sm-10 ">
                        <div class="card custom-card  rectangle2">
                            <div class="card-body p-0 ">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 ps-0 text-fixed-white rounded-0 d-none d-md-block">
                                        <div class="card custom-card mb-0 cover-background overflow-hidden rounded-0">
                                            <div
                                                class="card-img-overlay d-flex align-items-center justify-content-center p-0 rounded-0">

                                                <!-- Background Image -->
                                                <img src="https://jayswatchstore.com/front/assets/images/collection.png"
                                                    alt="Login Banner" class="w-100 h-100 position-absolute"
                                                    style="object-fit: cover;">

                                                <!-- 🔥 BLACK OVERLAY -->
                                                <div class="w-100 h-100 position-absolute"
                                                    style="background: rgba(0,0,0,0.55);">
                                                </div>

                                                <!-- TEXT -->
                                                <div class="position-relative text-center">
                                                    <h1 class="fw-bold text-white text-center"
                                                        style="letter-spacing: 2px; font-size: 28px; font-family: emoji;">
                                                        {{-- CUSTOMIZE <br>SOFTWARE AND ERP --}}
                                                    </h1>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-md-6 pe-sm-0">
                                        <div class="p-sm-5 p-4">

                                            <!-- Heading + Logo -->
                                            <div class="mb-3 d-flex align-items-center justify-content-between">

                                                <!-- Left: Text -->
                                                <div>
                                                    <p class="h4 fw-semibold mb-1">Sign In</p>
                                                    <p class="text-muted mb-0">Welcome back!</p>
                                                </div>

                                                <!-- Right: Logo -->
                                                <div class="ms-3">
                                                    <img src="{{ $actual_url . '/admin_assets/logo.png' }}"
                                                        alt="Logo" class="img-fluid" style="max-height: 70px;">
                                                </div>




                                            </div>





                                            <form id="loginForm" autocomplete="off" class="mt-2">

                                                @csrf

                                                <!-- Username -->
                                                <div class="mb-3">
                                                    <label for="signin-username" class="form-label text-default">User
                                                        Name</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        name="username" id="signin-username"
                                                        placeholder="Enter user name" autofocus>
                                                </div>

                                                <!-- Password -->
                                                <div class="mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label for="signin-password"
                                                            class="form-label text-default mb-0">Password</label>

                                                        <a href="javascript:void(0)" class="text-primary small"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#forgotPasswordModal">
                                                            Forgot password?
                                                        </a>
                                                    </div>

                                                    <div class="input-group mt-1">
                                                        <input type="password" class="form-control form-control-lg"
                                                            name="password" id="signin-password"
                                                            placeholder="Enter password">

                                                        <button class="btn btn-light" type="button"
                                                            onclick="createpassword('signin-password',this)">
                                                            <i class="ri-eye-off-line"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Remember Me -->
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="remember_me" id="defaultCheck1">

                                                        <label class="form-check-label" for="defaultCheck1">
                                                            Remember me
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Button -->
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-lg btn-primary" id="loginBtn">
                                                        Sign In
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
        </div>
    </div>
    <!-- End::error-page -->
    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="forgotPasswordForm" novalidate>
                    @csrf

                    <div class="modal-body">

                        <p class="text-muted mb-3">
                            Enter your registered email address. We will send reset instructions.
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="forgot-email"
                                placeholder="Enter email" required>

                            <div class="invalid-feedback">
                                Please enter a valid registered email.
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>

                    <button type="submit" class="btn btn-primary" id="forgotBtn">
    <span class="btn-text">Send Reset Link</span>

    <span class="spinner-border spinner-border-sm ms-2 d-none"
          id="forgotSpinner"
          role="status"
          aria-hidden="true"></span>
</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- Bootstrap JS -->
    <script src="{{ $actual_url . '/admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js' }}"></script>

    <!-- Show Password JS -->
    <script src="{{ $actual_url . '/admin_assets/js/show-password.js' }}"></script>
    <script src="{{ $actual_url . '/admin_assets/js/iziToast.min.js' }}"></script>
    <script>
        $(document).ready(function() {

            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const username = $('#signin-username').val().trim();
                const password = $('#signin-password').val().trim();

                if (!username || !password) {
                    iziToast.warning({
                        title: 'Required',
                        message: 'Username & password required',
                        position: 'topRight'
                    });
                    return;
                }

                // 🔹 Change button to loader
                let btn = $('#loginBtn');
                btn.prop('disabled', true);
                btn.html(`
            <span class="spinner-border spinner-border-sm align-middle" role="status" aria-hidden="true"></span>
            <span class="ms-2">Signing in...</span>
        `);

                $.ajax({
                    url: "{{ route('login.check') }}",
                    type: "POST",
                    data: $(this).serialize(),

                    success: function(res) {

                        if (res.status) {
                            iziToast.success({
                                title: 'Success',
                                message: 'Login successful',
                                position: 'topRight'
                            });

                            setTimeout(() => {
                                window.location.href = res.redirect;
                            }, 800);
                        } else {
                            iziToast.error({
                                title: 'Login Failed',
                                message: res.message || 'Invalid credentials',
                                position: 'topRight'
                            });
                        }
                    },

                    error: function(xhr) {

                        // try reading custom message from backend
                        let msg = 'Invalid credentials';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }

                        iziToast.error({
                            title: 'Login Failed',
                            message: msg,
                            position: 'topRight'
                        });
                    },


                    complete: function() {
                        // 🔹 Reset button after request completes (if not redirected)
                        btn.prop('disabled', false);
                        btn.html('Sign In');
                    }
                });
            });



         $('#forgotPasswordForm').on('submit', function(e) {
    e.preventDefault();

    let email = $('#forgot-email').val();

    // ✅ Start Loading
    $('#forgotBtn').prop('disabled', true);
    $('#forgotSpinner').removeClass('d-none');
    $('#forgotBtn .btn-text').text('Sending...');

    $.ajax({
        url: "{{ route('forgot.password') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            email: email
        },

        success: function(res) {

            iziToast.success({
                title: 'Success',
                message: res.message,
                position: 'topRight',
                timeout: 3000
            });

            $('#forgotPasswordModal').modal('hide');

            // ✅ Reset form
            $('#forgotPasswordForm')[0].reset();
        },

        error: function(xhr) {

            iziToast.info({
                title: 'Info',
                message: xhr.responseJSON?.message || 'Something went wrong',
                position: 'topRight',
                timeout: 3000
            });
        },

        complete: function() {
            // ✅ Stop Loading (runs on success + error)
            $('#forgotBtn').prop('disabled', false);
            $('#forgotSpinner').addClass('d-none');
            $('#forgotBtn .btn-text').text('Send Reset Link');
        }
    });
});



        });
    </script>
@if (session('toast_message'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    iziToast.{{ session('toast_type', 'info') }}({
        title: "{{ ucfirst(session('toast_type', 'info')) }}",
        message: @json(session('toast_message')),
        position: 'topRight',
        timeout: 4000
    });

});
</script>
@endif


</body>

</html>
