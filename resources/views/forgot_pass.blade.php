<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>



    <link rel="icon" href="{{ $actual_url . '/admin_assets/favicon.ico' }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/css/iziToast.min.css' }}">
    <!-- Main Theme Js -->
    <script src="{{ $actual_url . '/admin_assets/js/authentication-main.js' }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ $actual_url . '/admin_assets/libs/bootstrap/css/bootstrap.min.css' }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ $actual_url . '/admin_assets/css/styles.min.css' }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ $actual_url . '/admin_assets/css/icons.min.css' }}" rel="stylesheet">
</head>

<style>
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
            url("{{ $actual_url . '/admin_assets/jayswatch_login.png' }}");
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: fixed;
        background-size: cover;
        min-height: 100vh;
    }

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

    @media (max-width: 991.98px) {
        .left-banner {
            display: none !important;
        }
    }

    @media (max-width: 991.98px) {
        .rectangle2 {
            margin-top: 40px;
        }
    }
</style>

<body>

    <div class="page error-bg" id="particles-js">
        <!-- Start::error-page -->
        <div class="error-page  ">

            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-xl-8 col-md-12 col-sm-10">
                        <div class="card custom-card rectangle2">
                            <div class="card-body p-0">
                                <div class="row">

                                    <!-- LEFT IMAGE SECTION -->
                                    <div class="col-xl-6 col-lg-6 ps-0 text-fixed-white rounded-0 left-banner">
                                        <div class="card custom-card mb-0 cover-background overflow-hidden rounded-0">
                                            <div
                                                class="card-img-overlay d-flex align-items-center justify-content-center p-0">

                                                <!-- Background Image -->
                                                <img src="https://jayswatchstore.com/front/assets/images/collection.png"
                                                    class="w-100 h-100 position-absolute" style="object-fit:cover;">

                                                <!-- Overlay -->
                                                <div class="w-100 h-100 position-absolute"
                                                    style="background:rgba(0,0,0,0.55);">
                                                </div>

                                                <div class="position-relative text-center">
                                                    <h1 class="fw-bold text-white"
                                                        style="letter-spacing:2px;font-size:26px;">
                                                        RESET<br>PASSWORD
                                                    </h1>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- RIGHT FORM SECTION -->
                                    <div class="col-xl-6 col-lg-6 col-12 pe-sm-0">
                                        <div class="p-sm-5 p-4">

                                            <!-- Heading + Logo -->
                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="h4 fw-semibold mb-1">Reset Password</p>
                                                    <p class="text-muted mb-0">Create your new password</p>
                                                </div>

                                                <div class="ms-3">
                                                    <img src="{{ $actual_url . '/admin_assets/logo.png' }}"
                                                        class="img-fluid" style="max-height:70px;">
                                                </div>
                                            </div>

                                            <!-- FORM -->
                                            <form id="resetPasswordForm" method="POST"
                                                action="{{ route('password.update') }}" class="mt-3" novalidate>

                                                @csrf
                                                <input type="hidden" name="token" value="{{ $token }}">

                                                <!-- New Password -->
                                                <div class="mb-3">
                                                    <label class="form-label text-default">
                                                        New Password
                                                    </label>

                                                    <div class="input-group">
                                                        <input type="password" id="password" name="password"
                                                            class="form-control form-control-lg"
                                                            placeholder="Enter new password">

                                                        <button class="btn btn-light" type="button"
                                                            onclick="createpassword('password',this)">
                                                            <i class="ri-eye-off-line"></i>
                                                        </button>
                                                    </div>

                                                    <div class="invalid-feedback">
                                                        Password is required
                                                    </div>
                                                </div>

                                                <!-- Confirm Password -->
                                                <div class="mb-3">
                                                    <label class="form-label text-default">
                                                        Confirm Password
                                                    </label>

                                                    <div class="input-group">
                                                        <input type="password" id="password_confirmation"
                                                            name="password_confirmation"
                                                            class="form-control form-control-lg"
                                                            placeholder="Confirm password">

                                                        <button class="btn btn-light" type="button"
                                                            onclick="createpassword('password_confirmation',this)">
                                                            <i class="ri-eye-off-line"></i>
                                                        </button>
                                                    </div>

                                                    <div class="invalid-feedback">
                                                        Passwords do not match
                                                    </div>
                                                </div>

                                                <!-- Submit -->
                                                <div class="d-grid mt-4">
                                                    <button type="submit" class="btn btn-lg btn-primary">
                                                        Reset Password
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                    <!-- END RIGHT -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- Bootstrap JS -->
    <script src="{{ $actual_url . '/admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js' }}"></script>

    <!-- Show Password JS -->
    <script src="{{ $actual_url . '/admin_assets/js/show-password.js' }}"></script>
    <script src="{{ $actual_url . '/admin_assets/js/iziToast.min.js' }}"></script>

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;
            let password = document.getElementById('password');
            let confirmPassword = document.getElementById('password_confirmation');

            // ✅ Strong password regex
            const strongPassword =
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&^#()[\]{}\-_=+|\\:;"'<>,./~`]).{8,}$/;

            // reset states
            password.classList.remove('is-invalid');
            confirmPassword.classList.remove('is-invalid');

            let hasError = false;

            // Empty password
            if (password.value.trim() === '') {
                password.classList.add('is-invalid');
                hasError = true;
            }

            // ❗ Strength validation
            else if (!strongPassword.test(password.value)) {
                password.classList.add('is-invalid');

                iziToast.error({
                    title: 'Weak Password',
                    message: 'Password must include Uppercase, Lowercase, Number & Special Character',
                    position: 'topRight'
                });

                hasError = true;
            }

            // Password mismatch
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                hasError = true;

                iziToast.error({
                    title: 'Error',
                    message: 'Password and Confirm Password do not match',
                    position: 'topRight'
                });
            }

            if (hasError) return;

            form.submit();
        });
    </script>

</body>

</html>
