<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<head>
    <style>
        @media (max-width: 420px) {
    #smtpForm .text-end {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        text-align: center !important;
    }

    #smtpForm .btn {
        width: 100%;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
}
    </style>
</head>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Mail Settings</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mail</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">



                            <div class="card-body">
                                <div class="tab-content">



                                    <div class="tab-pane fade show active" id="addTax" role="tabpanel">
                                        <form method="POST" id="smtpForm" class="needs-validation" novalidate>

                                            @csrf
                                            <input type="hidden" name="smtp_id" value="{{ $smtp->smtp_id ?? '' }}">

                                            <div class="row">

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Mailer</label>
                                                    <input type="text" name="mailer" class="form-control"
                                                        value="{{ old('mailer', $smtp->mailer ?? '') }}" required>
                                                    <div class="invalid-feedback">Mailer is required</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Host</label>
                                                    <input type="text" name="host" class="form-control"
                                                        value="{{ old('host', $smtp->host ?? '') }}" required>
                                                    <div class="invalid-feedback">Host is required</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Port</label>
                                                    <input type="number" name="port" class="form-control"
                                                        value="{{ old('port', $smtp->port ?? '') }}" required>
                                                    <div class="invalid-feedback">Port is required</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Encryption</label>
                                                    <select name="encryption" class="form-select" required>
                                                        <option value="">Select</option>
                                                        <option value="tls"
                                                            {{ ($smtp->encryption ?? '') == 'tls' ? 'selected' : '' }}>
                                                            TLS</option>
                                                        <option value="ssl"
                                                            {{ ($smtp->encryption ?? '') == 'ssl' ? 'selected' : '' }}>
                                                            SSL</option>
                                                    </select>
                                                    <div class="invalid-feedback">Encryption is required</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="0"
                                                            {{ ($smtp->status ?? 0) == 0 ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="1"
                                                            {{ ($smtp->status ?? 0) == 1 ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Username</label>
                                                    <input type="text" name="username" class="form-control"
                                                        value="{{ old('username', $smtp->username ?? '') }}" required>
                                                </div>
<div class="col-md-6 mb-3">
    <label class="form-label">Password</label>

    <div class="input-group">
        <input type="password" name="password" id="smtpPassword" class="form-control"
            value="{{ old('password', $smtp->password ?? '') }}" required>

        <span class="input-group-text" style="cursor: pointer;"
            onclick="togglePassword('smtpPassword', this)">
            <i class="bi bi-eye"></i>
        </span>
    </div>
</div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">From Address</label>
                                                    <input type="email" name="from_address" class="form-control"
                                                        value="{{ old('from_address', $smtp->from_address ?? '') }}"
                                                        required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">From Name</label>
                                                    <input type="text" name="from_name" class="form-control"
                                                        value="{{ old('from_name', $smtp->from_name ?? '') }}"
                                                        required>
                                                </div>

                                            </div>

                                            <div class="text-end mt-4">
             <button type="button" class="btn btn-outline-success px-4" id="testMailBtn">
    Test SMTP
</button>

                                                <button type="submit" class="btn btn-primary px-4">
                                                    Save SMTP Settings
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

        @include('partials.footer')
    </div>

    @include('partials.footer_link')
<script>
    function togglePassword(inputId, el) {
        const input = document.getElementById(inputId);
        const icon = el.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
    <script>
        $(document).ready(function() {
$('#smtpForm').on('submit', function (e) {
    e.preventDefault();

    let form = $(this);
    let submitBtn = form.find('button[type=submit]');
    let originalText = submitBtn.html();

    if (this.checkValidity() === false) {
        e.stopPropagation();
        form.addClass('was-validated');
        return;
    }

    $.ajax({
        url: "{{ route('smtp.update') }}",
        type: "POST",
        data: form.serialize(),

        beforeSend: function () {
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="bx bx-loader-alt bx-spin"></i> Saving...');
        },

        success: function (response) {
            if (response.status) {
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
            }
        },

        error: function () {
            iziToast.error({
                title: 'Error',
                message: 'Something went wrong',
                position: 'topRight'
            });
        },

        complete: function () {
            submitBtn.prop('disabled', false);
            submitBtn.html(originalText);
        }
    });
});

          $('#testMailBtn').on('click', function () {

    let btn = $(this);
    let originalText = btn.html();

    $.ajax({
        url: "{{ route('smtp.test.mail') }}",
        type: "GET",

        beforeSend: function () {
            btn.prop('disabled', true);
            btn.html('<i class="bx bx-loader-alt bx-spin"></i> Sending...');
        },

        success: function (response) {
            if (response.status) {
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
            } else {
                iziToast.error({
                    title: 'Error',
                    message: response.message,
                    position: 'topRight'
                });
            }
        },

        error: function () {
            iziToast.error({
                title: 'Error',
                message: 'SMTP test failed',
                position: 'topRight'
            });
        },

        complete: function () {
            btn.prop('disabled', false);
            btn.html(originalText);
        }
    });
});

        });
    </script>

</body>

</html>
