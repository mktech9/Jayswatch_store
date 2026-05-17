<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')

<body>

    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-semibold mb-0">Catalogue</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Front Settings</li>
                <li class="breadcrumb-item active">Catalogue</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form id="catalogueForm" enctype="multipart/form-data" novalidate>
                            @csrf

                            <input type="hidden" name="cg_id" value="{{ $catalogue->cg_id ?? '' }}">

                            <div class="row g-4">

                                {{-- FILE UPLOAD --}}
                                @if (all_admin())
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Catalogue File (PDF only)</label>

                                        <input type="file" name="file" class="form-control"
                                            accept="application/pdf" id="fileInput">

                                        <div class="invalid-feedback">Only PDF file is allowed</div>

                                        {{-- CURRENT FILE --}}

                                    </div>


                                    {{-- DATE --}}
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Date</label>

                                        <input type="text" name="date" id="datePicker" class="form-control"
                                            placeholder="DD-MM-YYYY"
                                            value="{{ $catalogue->date ? \Carbon\Carbon::parse($catalogue->date)->format('d-m-Y') : '' }}">

                                        <div class="invalid-feedback">Please select date</div>
                                    </div>

                                    {{-- STATUS --}}
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold d-block">Status</label>

                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="status"
                                                {{ isset($catalogue->status) && $catalogue->status == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($catalogue->file))
                                    <div class="mt-4 text-center">

                                        {{-- PDF ICON --}}
                                        <div>
                                            <i class="bx bxs-file-pdf text-danger" style="font-size: 90px;"></i>
                                        </div>

                                        {{-- FILE NAME --}}
                                        <div class="mt-2 fw-semibold" style="font-size: 15px; word-break: break-word;">
                                            {{ $catalogue->file }}
                                        </div>

                                        {{-- VIEW BUTTON --}}
                                        <div class="mt-3">
                                            <a href="{{ $actual_url . '/admin_assets/catalogue/' . $catalogue->file }}"
                                                target="_blank" class="btn btn-sm btn-dark">
                                                <i class="bx bx-show"></i> View PDF
                                            </a>
                                        </div>

                                    </div>
                                @endif

                                {{-- SUBMIT --}}
                                @if (all_admin())
                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" id="submitBtn" class="btn btn-primary px-4">
                                            <span id="btnText">Update Catalogue</span>
                                            <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                                        </button>
                                    </div>
                                @endif

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>

        @include('partials.footer')
    </div>

    @include('partials.footer_link')

    {{-- FLATPICKR --}}
    <script>
        flatpickr("#datePicker", {
            dateFormat: "d-m-Y",
            defaultDate: "today"
        });
    </script>

    {{-- FILE VALIDATION --}}
    <script>
        $('#fileInput').on('change', function() {
            let file = this.files[0];

            if (file && file.type !== "application/pdf") {
                $(this).addClass('is-invalid');
                this.value = '';
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    </script>

    {{-- AJAX SUBMIT --}}
    <script>
        $('#catalogueForm').on('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);
            let isValid = true;

            // RESET
            $(form).find('.is-invalid').removeClass('is-invalid');

            // DATE VALIDATION
            if (!$('[name="date"]').val()) {
                $('[name="date"]').addClass('is-invalid');
                isValid = false;
            }

            if (!isValid) return;

            // BUTTON LOADER
            $('#btnText').addClass('d-none');
            $('#btnLoader').removeClass('d-none');

            $.ajax({
                url: "{{ route('catalogue.update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                    iziToast.success({
                        title: 'Success',
                        message: res.message,
                        position: 'topRight'
                    });

                    location.reload();

                },

                error: function(xhr) {

                    iziToast.error({
                        title: 'Error',
                        message: 'Update failed!',
                        position: 'topRight'
                    });

                },

                complete: function() {
                    $('#btnText').removeClass('d-none');
                    $('#btnLoader').addClass('d-none');
                }
            });
        });
    </script>

</body>

</html>
