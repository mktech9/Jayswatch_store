<!DOCTYPE html>
<html lang="en">

<title>
    {{ request('tab', 'signup') === 'login' ? 'Log In' : 'Sign Up' }} | Jay's Watch Store
</title>

@php
    $activeTab = request('tab', 'signup'); // 'login' or 'signup'
@endphp

@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')


    <style>
        .auth-wrapper {
            min-height: 90vh;
            background: #f7f7f8;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .auth-card {
            display: flex;
            flex-direction: row;
            background: #fff;
            box-shadow: 0 10px 30px rgba(58, 58, 76, .05);
            /*border-radius: 20px;*/
            overflow: hidden;
            max-width: 1280px;
            min-width: 720px;
            width: 100%
        }

        .auth-image-panel {
            flex: 1 1 0;
            background: url('https://jayswatchstore.com/front/assets/images/collection.png') center/cover no-repeat;
            min-height: 400px
        }

        .auth-form-panel {
            flex: 1 1 0;
            padding: 32px 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center
        }

        @media(max-width:900px) {
            .auth-card {
                flex-direction: column;
                min-width: 350px
            }

            .auth-image-panel {
                min-height: 180px;
                height: 180px
            }
        }

        /* Tabs */
        .auth-tabs {
            display: flex;
            gap: 6px;
            background: #f3f4f6;
            padding: 6px;
            /*border-radius: 12px;*/
            width: max-content;
            margin: 0 0 22px
        }

        .auth-tab {
            border: 0;
            background: transparent;
            padding: 10px 16px;

            font-weight: 600;
            font-size: 14px;
            color: #6b7280;
            cursor: pointer
        }

        .auth-tab.is-active {
            background: #fff;
            color: #111;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06)
        }

        .auth-form-panel h2 {
            font-size: 24px;
            font-weight: 500;
            margin: 8px 0 18px;
            color: #232323
        }

        .auth-form {
            margin-bottom: 18px
        }

        .auth-input {
            width: 100%;
            border: 1px solid #e4e4e4;
            border-radius: 0px;
            padding: 13px 15px;
            margin-bottom: 14px;
            font-size: 15px;
            background: #fafafc
        }

        .auth-submit-btn {
            width: fit-content;
            ;
            background: #212529;
            color: #fff;
            border: 0;
            padding: 11px 20px;
            /*border-radius: 7px;*/
            font-weight: 600;
            transition: background .2s;
            margin-bottom: 10px;
            cursor: pointer
        }

        .auth-submit-btn:hover {
            background: #212529
        }

        .auth-divider {
            text-align: center;
            color: #bbb;
            margin: 14px 0;
            font-size: 13px
        }

        .auth-social-row {
            display: flex;
            gap: 8px;
            margin-bottom: 10px
        }

        .auth-social-btn {
            flex: 1;
            background: #f3f4f6;
            border: 0;
            border-radius: 7px;
            padding: 11px 0;
            font-size: 14px;
            color: #555;
            cursor: pointer
        }

        .auth-link {
            color: #4868be;
            text-decoration: none;
            font-size: 14px;
            margin-left: 4px
        }

        /* panels */
        .panel {
            display: none
        }

        .panel.is-active {
            display: block
        }

        /* Change SweetAlert info icon color */

        /* INFO ICON */
        .swal2-icon.swal2-info.swal-info-dark {
            border-color: #212529 !important;
            color: #212529 !important;
        }

        .swal2-icon.swal2-info.swal-info-dark .swal2-icon-content {
            color: #212529 !important;
        }

        /* TITLE */
        .swal2-title.swal-title-dark {
            color: #212529 !important;
            font-weight: 600;
        }

        /* OK BUTTON */
        .swal2-confirm.swal-btn-dark {
            background-color: #212529 !important;
            color: #ffffff !important;
            border-radius: 6px;
            padding: 10px 26px;
            box-shadow: none !important;
        }

        /* Button hover */
        .swal2-confirm.swal-btn-dark:hover {
            background-color: #111 !important;
        }
    </style>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-form-panel">
                <!-- Tabs -->
                <div class="auth-tabs" role="tablist" aria-label="Authentication tabs">
                    <button id="tab-signup" class="auth-tab {{ $activeTab === 'signup' ? 'is-active' : '' }}"
                        role="tab" aria-controls="panel-signup"
                        aria-selected="{{ $activeTab === 'signup' ? 'true' : 'false' }}">Sign
                        up</button>
                    <button id="tab-login" class="auth-tab {{ $activeTab === 'login' ? 'is-active' : '' }}"
                        role="tab" aria-controls="panel-login"
                        aria-selected="{{ $activeTab === 'login' ? 'true' : 'false' }}">Log in</button>
                </div>

                <!-- Sign up -->
                <div id="panel-signup" class="panel {{ $activeTab === 'signup' ? 'is-active' : '' }}" role="tabpanel"
                    aria-labelledby="tab-signup">
                    <h2>Create Your Account</h2>
                    <form id="registerForm" class="auth-form" method="POST" novalidate>
                        @csrf

                        <div class="form-group">
                            <input type="text" name="name" class="auth-input form-control" placeholder="Name">
                            <div class="invalid-feedback mb-2">Please enter your name.</div>
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" id="emailInput" class="auth-input form-control"
                                placeholder="Email address">
                            <div class="invalid-feedback mb-2">Please enter a valid email address.</div>
                        </div>

                        <div class="form-group position-relative">

                            <input type="password" name="password" id="passwordInput"
                                class="auth-input form-control pe-5" placeholder="Password">

                            <!-- Toggle Icon -->
                            <span toggle="#passwordInput"
                                class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                style="cursor: pointer;">
                                <i class="bx bx-hide"></i>
                            </span>

                            <div class="invalid-feedback mb-2">Please enter your password.</div>
                        </div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label style="font-size:14px;">
                                <input type="checkbox" id="agreeTerms">
                                By Signing up you agree to our
                                <a href="{{ route('terms_and_condtion') }}" style="font-weight: 600;"
                                    target="_blank">Terms and Conditions</a> &amp;
                                <a href="{{ route('privacy_policy') }}" style="font-weight: 600;"
                                    target="_blank">Privacy Policy</a>
                            </label>
                            <div class="invalid-feedback">You must agree to the terms and privacy policy.</div>
                            <div class="form-group mb-3 mt-3">
                                <div class="g-recaptcha" id="signupCaptcha"
                                    data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}">
                                </div>

                                <div class="text-danger mt-1 captcha-error"></div>
                            </div>
                        </div>

                        <button class="auth-submit-btn" id="signupBtn" type="submit">Sign up</button>
                    </form>


                    <!--<div class="auth-divider">or</div>-->
                    <!--<div class="auth-social-row">-->
                    <!--  <button class="auth-social-btn" type="button">Sign in with Google</button>-->
                    <!--  <button class="auth-social-btn" type="button">Sign in with Apple</button>-->
                    <!--</div>-->

                    <div style="margin-top:12px;font-size:14px;">
                        Already have an account?
                        <a href="{{ url()->current() }}?tab=login" class="auth-link js-switch" data-tab="login">Log
                            in</a>
                    </div>
                </div>

                <!-- Log in -->
                <div id="panel-login" class="panel {{ $activeTab === 'login' ? 'is-active' : '' }}" role="tabpanel"
                    aria-labelledby="tab-login">
                    <h2>Welcome back!</h2>
                    <form id="loginForm" class="auth-form" method="POST" novalidate>
                        @csrf

                        <input type="hidden" id="redirect_after_login" value="{{ $redirect ?? '' }}">
                        <input type="hidden" id="tracking_num_field" value="{{ $tracking_num ?? '' }}">
                        <input type="hidden" id="order_id_field" value="{{ $order_id ?? '' }}">


                        <input type="email" name="loginemail" id="loginemail" class="auth-input form-control"
                            placeholder="Email address" required>
                        <div class="invalid-feedback"></div>


                        <div class="form-group position-relative">

                            <input type="password" name="loginpassword" id="loginPasswordInput"
                                class="auth-input form-control pe-5" placeholder="Password" required>

                            <!-- Toggle Icon -->
                            <span class="toggle-login-password position-absolute top-50 end-0 translate-middle-y me-3"
                                style="cursor: pointer;">
                                <i class="bx bx-hide"></i>
                            </span>

                        </div>
                        <div class="invalid-feedback"></div>

                        <div style="margin-bottom:12px;">
                            <label style="font-size:14px;">
                                <input type="checkbox" name="remember" id="remember"> Remember me
                            </label>
                            <a href="javascript:void(0);" class="auth-link" id="forgotPasswordLink"
                                style="float:right;margin:0;">
                                Forgot password?
                            </a>
                        </div>
                        <div class="form-group mb-3 mt-3">
                            <div class="g-recaptcha" id="loginCaptcha"
                                data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}">
                            </div>

                            <div class="text-danger mt-1 login-captcha-error"></div>
                        </div>

                        <button class="auth-submit-btn" type="submit">Log in</button>
                    </form>



                    <!--<div class="auth-divider">or</div>-->
                    <!--<div class="auth-social-row">-->
                    <!--  <button class="auth-social-btn" type="button">Continue with Google</button>-->
                    <!--  <button class="auth-social-btn" type="button">Continue with Apple</button>-->
                    <!--</div>-->

                    <div style="margin-top:12px;font-size:14px;">
                        Don’t have an account?
                        <a href="{{ url()->current() }}?tab=signup" class="auth-link js-switch"
                            data-tab="signup">Sign up</a>
                    </div>
                </div>
            </div>

            <div class="auth-image-panel" aria-hidden="true"></div>
        </div>
    </div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordForm" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="forgotEmail" class="form-label">Enter your registered email</label>
                            <input type="email" class="form-control" id="forgotEmail" name="email"
                                placeholder="Enter registered email address">
                            <div class="invalid-feedback">
                                Please enter a valid registered email address.
                            </div>
                        </div>

                        <button type="submit" class="btn auth-submit-btn" style="background:#212529;color:#fff">
                            Send Reset Link
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')
    <script src="https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit" async defer></script>
    <script>
        let signupCaptchaId = null;
        let loginCaptchaId = null;

        function onRecaptchaLoad() {
            signupCaptchaId = grecaptcha.render('signupCaptcha', {
                sitekey: "{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"
            });

            loginCaptchaId = grecaptcha.render('loginCaptcha', {
                sitekey: "{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"
            });
        }
    </script>
    <script>
        document.querySelector(".toggle-login-password").addEventListener("click", function() {
            const input = document.querySelector("#loginPasswordInput");
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bx-hide");
                icon.classList.add("bx-show");
            } else {
                input.type = "password";
                icon.classList.remove("bx-show");
                icon.classList.add("bx-hide");
            }
        });
    </script>
    <script>
        document.querySelector(".toggle-password").addEventListener("click", function() {
            const input = document.querySelector("#passwordInput");
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bx-hide");
                icon.classList.add("bx-show");
            } else {
                input.type = "password";
                icon.classList.remove("bx-show");
                icon.classList.add("bx-hide");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            const email = getCookie('remember_email');
            const password = getCookie('remember_password');

            if (email && password) {
                $('#loginemail').val(email);
                $('input[name="loginpassword"]').val(password);
                $('#remember').prop('checked', true);
            }
        });
    </script>


    <script>
        (function() {
            const qsTab = new URLSearchParams(window.location.search).get('tab');
            const initial = (qsTab === 'login' || qsTab === 'signup') ? qsTab : '{{ $activeTab }}';

            function switchTo(tab, push = false) {
                const signTab = document.getElementById('tab-signup');
                const logTab = document.getElementById('tab-login');
                const signPane = document.getElementById('panel-signup');
                const logPane = document.getElementById('panel-login');

                [signTab, logTab].forEach(b => b.classList.remove('is-active'));
                [signPane, logPane].forEach(p => p.classList.remove('is-active'));

                if (tab === 'login') {
                    logTab.classList.add('is-active');
                    logTab.setAttribute('aria-selected', 'true');
                    signTab.setAttribute('aria-selected', 'false');
                    logPane.classList.add('is-active');
                } else {
                    signTab.classList.add('is-active');
                    signTab.setAttribute('aria-selected', 'true');
                    logTab.setAttribute('aria-selected', 'false');
                    signPane.classList.add('is-active');
                }
                const url = new URL(window.location);
                url.searchParams.set('tab', tab);
                history.replaceState({}, '', url); // keep URL in sync without reload
                document.title = (tab === 'login' ? 'Log In' : 'Sign Up') + " | Jay's Watch Store";
            }

            // tab buttons
            document.getElementById('tab-signup').addEventListener('click', () => switchTo('signup', true));
            document.getElementById('tab-login').addEventListener('click', () => switchTo('login', true));

            // inline links
            document.querySelectorAll('.js-switch').forEach(a => {
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    switchTo(this.dataset.tab, true);
                });
            });

            // initialize from query
            switchTo(initial, false);
        })();
    </script>


    <script>
        $(document).ready(function() {

            const passwordField = document.querySelector('input[name="password"]');

            // ---------- PASSWORD VALIDATION FUNCTION ----------
            function validatePassword(pwd) {
                let errorMsg = "";

                // Rules
                if (pwd.length < 8 || pwd.length > 20) errorMsg = "Password must be 8–20 characters.";
                else if (!/[A-Z]/.test(pwd)) errorMsg = "Must contain at least 1 uppercase letter.";
                else if (!/[a-z]/.test(pwd)) errorMsg = "Must contain at least 1 lowercase letter.";
                else if (!/[0-9]/.test(pwd)) errorMsg = "Must contain at least 1 number.";
                else if (!/[@#$%^&*()_+\-=\!?]/.test(pwd)) errorMsg = "Must contain at least 1 special character.";
                else if (/\s/.test(pwd)) errorMsg = "Password cannot contain spaces.";
                else if (/([a-zA-Z0-9])\1{3,}/.test(pwd)) errorMsg =
                    "Password cannot contain repeating characters.";
                else {
                    // sequential check
                    const sequences = [
                        "123456", "234567", "345678", "456789",
                        "abcdef", "bcdefg", "cdefgh", "defghi",
                        "ABCDEF", "BCDEFG", "CDEFGH"
                    ];
                    for (let seq of sequences) {
                        if (pwd.includes(seq)) {
                            errorMsg = "Password cannot contain sequential characters.";
                            break;
                        }
                    }
                }

                if (errorMsg !== "") {
                    $(passwordField).addClass("is-invalid");
                    $(passwordField).next(".invalid-feedback").text(errorMsg).show();
                    return false;
                }

                $(passwordField).removeClass("is-invalid").addClass("is-valid");
                $(passwordField).next(".invalid-feedback").hide();
                return true;
            }

            // ---------- FORM SUBMIT ----------
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                // Reset feedback
                $('.invalid-feedback').hide();
                $('.form-control, input[type="checkbox"]').removeClass('is-invalid');

                let valid = true;

                // NAME VALIDATION
                let name = $('input[name="name"]');
                if ($.trim(name.val()) === "") {
                    name.addClass("is-invalid");
                    name.next(".invalid-feedback").text("Name is required.").show();
                    valid = false;
                }

                // EMAIL VALIDATION
                let email = $('input[name="email"]');
                const emailPattern =
                    /^(?!.*\.\.)(?!.*\.$)(?!^\.)[A-Za-z0-9._+\-]+@[A-Za-z0-9\-]+\.[A-Za-z]{2,10}$/;

                if ($.trim(email.val()) === "") {
                    email.addClass("is-invalid");
                    email.next(".invalid-feedback").text("Email is required.").show();
                    valid = false;
                } else if (!emailPattern.test(email.val())) {
                    email.addClass("is-invalid");
                    email.next(".invalid-feedback").text("Enter a valid email address.").show();
                    valid = false;
                }

                // PASSWORD VALIDATION
                if (!validatePassword(passwordField.value)) {
                    valid = false;
                }

                // TERMS CHECKBOX
                const checkbox = $('#agreeTerms');
                if (!checkbox.is(':checked')) {
                    checkbox.addClass("is-invalid");
                    checkbox.closest('.form-group')
                        .find('.invalid-feedback')
                        .text("You must agree to the terms & privacy policy.")
                        .show();
                    valid = false;
                }

                let captcha = grecaptcha.getResponse(signupCaptchaId);

                if (captcha.length === 0) {
                    $('.captcha-error')
                        .text('Please verify that you are not a robot.');
                    valid = false;
                } else {
                    $('.captcha-error').text('');
                }

                // ❌ INVALID → STOP + RESTORE BUTTON
                if (!valid) {
                    $('#signupBtn').prop('disabled', false).html('Sign up');
                    $('html, body').animate({
                        scrollTop: $('.is-invalid:first').offset().top - 100
                    }, 300);
                    return;
                }

                // ✅ VALID → SHOW SPINNER
                $('#signupBtn').prop('disabled', true).html(
                    '<i class="fa fa-spinner fa-spin"></i> Signing up...');

                // AJAX REQUEST
                $.ajax({
                    url: "{{ route('custregister') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: name.val(),
                        email: email.val(),
                        password: passwordField.value,
                        g_recaptcha_response: grecaptcha.getResponse(signupCaptchaId)
                    },
                    success: function(response) {

                        // RESTORE BUTTON
                        $('#signupBtn').prop('disabled', false).html('Sign up');

                        if (response.success) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Verification Required',
                                text: response.message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    icon: 'swal-info-dark',
                                    title: 'swal-title-dark',
                                    confirmButton: 'swal-btn-dark'
                                }
                            });



                            grecaptcha.reset(signupCaptchaId);
                            $('#registerForm')[0].reset();



                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        $('#signupBtn').prop('disabled', false).html('Sign up');

                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Please try again later.'
                        });
                    }
                });

            });


        });
    </script>


    <script>
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const d = new Date();
                d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + d.toUTCString();
            }
            document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
        }

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? decodeURIComponent(match[2]) : null;
        }

        function deleteCookie(name) {
            document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        }
    </script>

    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            $('.invalid-feedback').hide().text('');
            $('.form-control').removeClass('is-invalid');

            let valid = true;

            const loginemail = $('input[name="loginemail"]');
            const loginpassword = $('input[name="loginpassword"]');

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if ($.trim(loginemail.val()) === '' || !emailPattern.test(loginemail.val())) {
                loginemail.addClass('is-invalid');
                loginemail.next('.invalid-feedback').text('Enter a valid email address.').show();
                valid = false;
            }

            if ($.trim(loginpassword.val()) === '') {
                loginpassword.addClass('is-invalid');
                loginpassword.next('.invalid-feedback').text('Password is required.').show();
                valid = false;
            }

            let loginCaptcha = grecaptcha.getResponse(loginCaptchaId);

            if (loginCaptcha.length === 0) {
                $('.login-captcha-error')
                    .text('Please verify that you are not a robot.');
                valid = false;
            } else {
                $('.login-captcha-error').text('');
            }

            if (!valid) return;

            const form = $(this);
            const submitBtn = form.find('.auth-submit-btn');
            submitBtn.prop('disabled', true).text('Please wait...');
            $('#login_recaptcha_response').val(grecaptcha.getResponse(loginCaptchaId));

            $.ajax({
                url: "{{ route('customer.login') }}",
                type: "POST",
                data: form.serialize(),

                success: function(response) {
                    submitBtn.prop('disabled', false).text('Log in');

                    if (response.success) {

                        // ✅ Save remember me
                        if ($('#remember').is(':checked')) {
                            setCookie('remember_email', loginemail.val(), 30);
                            setCookie('remember_password', loginpassword.val(), 30);
                        } else {
                            deleteCookie('remember_email');
                            deleteCookie('remember_password');
                        }


                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: response.message || 'Welcome back!',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        grecaptcha.reset(loginCaptchaId);

                        // ================================
                        // 🛒 Merge Cart
                        // ================================
                        fetch("{{ route('get.db.cart') }}")
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    let browserCart = JSON.parse(sessionStorage.getItem('cart')) ||
                                        [];
                                    let mergedCart = Array.from(new Set([...browserCart, ...data
                                        .cart
                                    ]));
                                    sessionStorage.setItem('cart', JSON.stringify(mergedCart));
                                }
                            });

                        // ================================
                        // ❤️ SAVE WISHLIST TO DB
                        // ================================
                        let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

                        if (wishlist.length > 0) {
                            fetch("{{ route('save.wishlist') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        wishlist: wishlist
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    console.log("Wishlist saved:", data);

                                });
                        }

                        // ================================
                        // Redirect
                        // ================================
                        setTimeout(function() {
                            const redirectType = $('#redirect_after_login').val();
                            const trackingNum = $('#tracking_num_field').val();
                            const orderId = $('#order_id_field').val();

                            if (redirectType === 'tracking' && trackingNum && orderId) {
                                window.location.href = "{{ url('/order-tracking') }}/" +
                                    trackingNum + "/" + orderId;
                            } else {
                                window.location.href = response.redirect ||
                                    "{{ route('product') }}";
                            }
                        }, 1500)

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message || 'Invalid credentials!',
                        });
                    }
                },

                error: function() {
                    submitBtn.prop('disabled', false).text('Log in');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Server error. Please try again later.',
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to get URL query parameter
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Get email from URL
            let emailFromUrl = getQueryParam('email');

            // Prefill input if email exists
            if (emailFromUrl) {
                $('#loginemail').val(emailFromUrl);
            }
        });
    </script>



    <script>
        $(document).ready(function() {

            // Open modal on click
            $('#forgotPasswordLink').on('click', function() {
                $('#forgotPasswordModal').modal('show');
            });

            // Handle form submit
            $('#forgotPasswordForm').on('submit', function(e) {
                e.preventDefault();

                const emailInput = $('#forgotEmail');
                const submitBtn = $(this).find('button[type="submit"]');
                const email = emailInput.val().trim();

                // Reset state
                emailInput.removeClass('is-invalid');

                // Email pattern
                const emailPattern =
                    /^(?!.*\.\.)(?!.*\.$)(?!^\.)[A-Za-z0-9._+\-]+@[A-Za-z0-9\-]+\.[A-Za-z]{2,10}$/;

                // ❌ Validation
                if (email === '' || !emailPattern.test(email)) {
                    emailInput.addClass('is-invalid');

                    iziToast.warning({
                        title: 'Invalid Email',
                        message: 'Please enter a valid registered email address.',
                        position: 'topRight'
                    });
                    return;
                }

                // Disable button
                submitBtn.prop('disabled', true).text('Please wait...');

                $.ajax({
                    url: "{{ route('forgot.custpassword') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email
                    },
                    success: function(response) {

                        if (response.success) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });

                            $('#forgotPasswordModal').modal('hide');
                            $('#forgotPasswordForm')[0].reset();
                            submitBtn.text('Sent');
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });

                            submitBtn.prop('disabled', false).text('Send Reset Link');
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Server Error',
                            message: 'Something went wrong. Please try again.',
                            position: 'topRight'
                        });

                        submitBtn.prop('disabled', false).text('Send Reset Link');
                    }
                });
            });

        });
    </script>


    <script>
        const emailField = document.getElementById("emailInput");

        const usernameAllowed = /^[A-Za-z0-9._\-+]+$/;
        const domainAllowed = /^[A-Za-z0-9\-\.]+$/;

        emailField.addEventListener("keypress", function(e) {
            const char = String.fromCharCode(e.which);
            let value = this.value;

            // ❌ Block spaces
            if (char === " ") return e.preventDefault();

            // ❌ Cannot start with ., -, @
            if (value.length === 0 && (char === "." || char === "-" || char === "@")) {
                return e.preventDefault();
            }

            // ⭐ Allow @ only once and not at start
            if (char === "@") {
                if (value.includes("@")) return e.preventDefault();
                if (value.length === 0) return e.preventDefault();
                return; // allow @
            }

            // BEFORE @ → username
            if (!value.includes("@")) {
                if (!usernameAllowed.test(char)) return e.preventDefault();
            }

            // AFTER @ → domain
            if (value.includes("@")) {
                if (!domainAllowed.test(char)) return e.preventDefault();
            }

            // ⭐ EXTENSION LIMIT (PREVENT INPUT AFTER .xxxx)
            const atIndex = value.indexOf("@");
            if (atIndex !== -1) {
                const lastDot = value.lastIndexOf(".");

                if (lastDot > atIndex) { // extension exists
                    const extension = value.substring(lastDot + 1);

                    // ❌ Prevent more than 10 letters in extension
                    if (extension.length >= 10) {
                        return e.preventDefault();
                    }

                    // ❌ Prevent invalid characters in extension (only letters allowed)
                    if (!/[A-Za-z]/.test(char)) {
                        return e.preventDefault();
                    }
                }
            }
        });

        // 🛠 Cleanup + validate full email
        emailField.addEventListener("input", function() {
            let v = this.value;

            v = v.replace(/\s+/g, ""); // remove spaces
            v = v.replace(/\.\.+/g, "."); // remove double dots
            v = v.replace(/^[-\.]+/, ""); // no starting with dot/hyphen
            v = v.replace(/@[-\.]+/, "@"); // no domain starting with dot/hyphen

            this.value = v;

            const pattern =
                /^(?!.*\.\.)(?!.*\.$)(?!^\.)[A-Za-z0-9._+\-]+@[A-Za-z0-9\-]+\.[A-Za-z]{2,10}$/;

            if (pattern.test(this.value)) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            } else {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");
            }
        });
    </script>



</body>

</html>
