<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    .dt-buttons {
        white-space: nowrap;
        overflow-x: auto;
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Business Location</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Business Location</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">

                        <div class="card custom-card">

                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listLocation"
                                            role="tab">
                                            Location List
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#addLocation" role="tab"
                                            id="addLocationTabLink">
                                            Add Location
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="listLocation" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="locationTable"
                                                class="table table-bordered table-striped text-center w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Location Id</th>

                                                        <th>City</th>
                                                        <th>Pin Code</th>
                                                        <th>State</th>
                                                        <th>Country</th>

                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="addLocation" role="tabpanel">
                                        <form action="" method="POST" id="addLocationForm"
                                            class="row g-3 needs-validation" novalidate>
                                            @csrf
                                            <input type="hidden" name="bl_id" id="bl_id">

                                            <div class="col-md-4">
                                                <label class="form-label">Location Name
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Enter Location Name" required>
                                                <div class="invalid-feedback">Location name is required</div>

                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Location ID <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="location_id"
                                                    placeholder="Enter Location ID" required>
                                                <div class="invalid-feedback">Location ID is required</div>
                                            </div>





                                            <div class="col-md-4">
                                                <label class="form-label">Country <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="country_id" id="country_id" required>
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Country is required</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">State <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="state_id" id="state_id" required
                                                    disabled>
                                                    <option value="">Select State</option>
                                                </select>
                                                <div class="invalid-feedback">State is required</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">City <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="city_id" id="city_id" required
                                                    disabled>
                                                    <option value="">Select City</option>
                                                </select>
                                                <div class="invalid-feedback">City is required</div>
                                            </div>



                                            <div class="col-md-4">
                                                <label class="form-label">Pin Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="zip_code"
                                                    placeholder="Enter Zip Code" required>
                                                <div class="invalid-feedback">Pin code is required</div>
                                            </div>

                                            <div class="col-md-8">
                                                <label class="form-label">Address <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" name="address" rows="2" placeholder="Enter Address" required></textarea>
                                                <div class="invalid-feedback">Address is required</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">GST Number <span
                                                        class="text-danger">*</span></label>

                                                <input type="text" class="form-control" name="gst_number"
                                                    placeholder="Enter GST Number" required
                                                    pattern="^([0-9]{2})([A-Z]{5})([0-9]{4})([A-Z]{1})([0-9A-Z]{1})(Z)([0-9A-Z]{1})$">

                                                <div class="invalid-feedback">
                                                    Enter valid GST number (e.g., 27ABCDE1234F1Z5)
                                                </div>
                                            </div>




                                            <div class="col-md-4">
                                                <label class="form-label">Mobile Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="mobile"
                                                    placeholder="Enter Mobile No" required>
                                                <div class="invalid-feedback">Contact Detail is required</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Alternate Contact</label>
                                                <input type="text" class="form-control" name="alternate_contact"
                                                    placeholder="Enter Alternate No">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Enter Email">
                                                <div class="invalid-feedback">Valid email is required</div>
                                            </div>


                                            {{-- <div class="col-md-12">
                                                <label class="form-label">POS Screen Featured Products</label>

                                                <select class="form-control" id="pos_featured_products"
                                                    name="product[]" multiple data-placeholder="Select Products">
                                                    @foreach ($pos_screen_data as $product)
                                                        <option value="{{ $product->pro_id }}">
                                                            {{ $product->pro_name }} - {{ $product->pro_sku }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div> --}}

                                            <div class="col-md-6">
                                                <label class="form-label d-block fw-semibold mb-2">Payment
                                                    Options</label>
                                                <div class="border p-3 rounded bg-light">
                                                    <div class="row">
                                                        @if (isset($payment_options) && count($payment_options) > 0)
                                                            @foreach ($payment_options as $option)
                                                                <div class="col-md-3 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" name="payment_options[]"
                                                                            value="{{ $option->p_id }}"
                                                                            id="pay_opt_{{ $option->p_id }}" checked>
                                                                        <label class="form-check-label"
                                                                            for="pay_opt_{{ $option->p_id }}">
                                                                            {{ $option->payment }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-12 text-center text-muted">
                                                                <small>No payment options available.</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
    <label class="form-label fw-semibold mb-2">Monthly Turnover</label>
    <input type="number" name="monthly_turnover" class="form-control"
        placeholder="Enter Monthly Turnover">
</div>


                                            <div class="col-12 d-flex justify-content-end mt-4">
                                                <button type="button" class="btn btn-light me-2"
                                                    id="cancelBtn">Cancel</button>
                                                <button type="submit" class="btn btn-primary px-4"
                                                    id="submitBtn">Save
                                                    Location</button>
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
        $(document).ready(function() {
        let isEditMode = false;



            $('#country_id').select2({
                placeholder: "Select Country",
                width: '100%'
            });

            $('#state_id').select2({
                placeholder: "Select State",
                width: '100%'
            });

            $('#city_id').select2({
                placeholder: "Select City",
                width: '100%'
            });

            $('#pos_featured_products').select2({
                width: '100%',
                allowClear: true
            });


            // Load states on country change
            $('#country_id').on('change', function() {

                let countryId = $(this).val();

                $('#state_id').empty().append('<option value="">Select State</option>').prop('disabled',
                    true);
                $('#city_id').empty().append('<option value="">Select City</option>').prop('disabled',
                    true);

                if (!countryId) return;

                let url = "{{ route('get.states', ':country_id') }}";
                url = url.replace(':country_id', countryId);

                $.get(url, function(data) {

                    $('#state_id').prop('disabled', false);

                    $.each(data, function(key, state) {
                        $('#state_id').append('<option value="' + state.id + '">' + state
                            .name + '</option>');
                    });

                    $('#state_id').trigger('change.select2');
                });
            });


            // State → Cities
            $('#state_id').on('change', function() {

                let stateId = $(this).val();

                $('#city_id').empty().append('<option value="">Select City</option>').prop('disabled',
                    true);

                if (!stateId) return;

                let url = "{{ route('get.cities', ':state_id') }}";
                url = url.replace(':state_id', stateId);

                $.get(url, function(data) {

                    $('#city_id').prop('disabled', false);

                    $.each(data, function(key, city) {
                        $('#city_id').append('<option value="' + city.id + '">' + city
                            .name + '</option>');
                    });

                    $('#city_id').trigger('change.select2');
                });
            });


            var table = $('#locationTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('business_location.list') }}",
                columns: [{
                        data: 'sr_no',
                        orderable: false
                    }, {
                        data: 'name'
                    }, {
                        data: 'location_id'
                    }, {
                        data: 'city'
                    }, {
                        data: 'zip_code'
                    }, {
                        data: 'state'
                    }, {
                        data: 'country'
                    },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                    targets: '_all',
                    className: 'text-start'
                }],
                order: [
                    [0, 'desc']
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: 10,
                dom: "<'row mb-2 align-items-center'" +
                    "<'col-lg-2 col-md-3'l>" +
                    "<'col-lg-7 col-md-6 text-center'B>" +
                    "<'col-lg-3 col-md-3 text-end'f>" +
                    ">" +
                    "rtip",
                buttons: [{
                    extend: 'copyHtml5',
                    text: '<i class="bx bx-copy"></i> Copy',
                    className: 'dt-btn-light',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'csvHtml5',
                    text: '<i class="bx bx-file"></i> Export to CSV',
                    className: 'dt-btn-light',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'excelHtml5',
                    text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                    className: 'dt-btn-light',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'print',
                    text: '<i class="bx bx-printer"></i> Print',
                    className: 'dt-btn-light',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'colvis',
                    text: '<i class="bx bx-columns"></i> Column visibility',
                    className: 'dt-btn-light'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="bx bx-file-blank"></i> Export to PDF',
                    className: 'dt-btn-light',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    customize: function(doc) {
                        doc.pageMargins = [10, 10, 10, 10];
                        if (doc.content[1] && doc.content[1].table) {
                            var table = doc.content[1].table;
                            table.widths = Array(table.body[0].length).fill('*');
                        }
                    }
                }]
            });

            // 1. FORM SUBMISSION
            $('#addLocationForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                // Determine URL based on whether hidden ID exists
                let updateId = $('#bl_id').val();
                let url = updateId ? "{{ route('business_location.update') }}" :
                    "{{ route('business_location.store') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 200) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });

                            // Reset form and switch tab
                            resetForm();
                            $('a[href="#listLocation"]').tab('show');
                            table.ajax.reload(null, false);

                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    }
                });
            });

          $(document).on('click', '.editLocation', function () {

    let id = $(this).data('id');
    isEditMode = true;

    resetForm(); // reset first

    let url = "{{ route('business_location.edit', ':id') }}".replace(':id', id);

    $.get(url, function (response) {

        if (response.status !== 200) {
            iziToast.error({ message: "Record not found" });
            return;
        }

        let data = response.data;

        // Open Add/Edit tab safely
        const tab = new bootstrap.Tab(document.querySelector('#addLocationTabLink'));
        tab.show();

        // ---- BASIC FIELDS ----
        $('#bl_id').val(data.bl_id);
        $('input[name="name"]').val(data.name);
        $('input[name="location_id"]').val(data.location_id);
        $('input[name="zip_code"]').val(data.zip_code);
        $('input[name="mobile"]').val(data.mobile);
        $('input[name="alternate_contact"]').val(data.alternate_contact);
        $('input[name="email"]').val(data.email);
        $('textarea[name="address"]').val(data.address);
        $('input[name="gst_number"]').val(data.gst_number);
        $('input[name="monthly_turnover"]').val(data.monthly_turnover);

        // ---- PAYMENT OPTIONS ----
        $('input[name="payment_options[]"]').prop('checked', false);
        if (data.payment_options) {
            data.payment_options.split(',').forEach(v => {
                $(`input[value="${v}"]`).prop('checked', true);
            });
        }

        // ---- TAB TEXT ----
        $('#addLocationTabLink').text('Edit Location');
        $('#submitBtn').text('Update Location');

        // ---- COUNTRY → STATE → CITY ----
        $('#country_id').val(data.country).trigger('change');

        let stateUrl = "{{ route('get.states', ':cid') }}".replace(':cid', data.country);
        $.get(stateUrl, function (states) {

            $('#state_id').prop('disabled', false).empty()
                .append('<option value="">Select State</option>');

            states.forEach(state => {
                $('#state_id').append(`<option value="${state.id}">${state.name}</option>`);
            });

            $('#state_id').val(data.state).trigger('change');

            let cityUrl = "{{ route('get.cities', ':sid') }}".replace(':sid', data.state);
            $.get(cityUrl, function (cities) {

                $('#city_id').prop('disabled', false).empty()
                    .append('<option value="">Select City</option>');

                cities.forEach(city => {
                    $('#city_id').append(`<option value="${city.id}">${city.name}</option>`);
                });

                $('#city_id').val(data.city).trigger('change');
            });
        });

        // ---- POS FEATURED PRODUCTS ----
if (data.product) {
    let products = Array.isArray(data.product)
        ? data.product
        : data.product.split(',');

    $('#pos_featured_products')
        .val(products)
        .trigger('change');
}

    });
});


            // 3. TAB SWITCH EVENT (Reset on switching to List)
$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {

    const target = $(e.target).attr('href');

    if (target === '#listLocation') {
        resetForm();
        isEditMode = false;
    }

    if (target === '#addLocation' && !isEditMode) {
        resetForm();
    }
});



            // 4. CANCEL BUTTON
            $('#cancelBtn').on('click', function() {
                $('a[href="#listLocation"]').tab('show');
            });

           function resetForm() {

    $('#addLocationForm')[0].reset();
    $('#bl_id').val('');

    // Remove validation
    $('#addLocationForm').removeClass('was-validated');
    $('.is-valid, .is-invalid').removeClass('is-valid is-invalid');

    // Payment options
    $('input[name="payment_options[]"]').prop('checked', false);
   $('#pos_featured_products').val(null).trigger('change');
    // Select2 resets
    $('#country_id').val(null).trigger('change');
    $('#state_id').empty().append('<option value="">Select State</option>')
        .prop('disabled', true).val(null).trigger('change');
    $('#city_id').empty().append('<option value="">Select City</option>')
        .prop('disabled', true).val(null).trigger('change');

    // Tab text reset
    $('#addLocationTabLink').text('Add Location');
    $('#submitBtn').text('Save Location');
}



            // 5. DELETE BUTTON CLICK
            $(document).on('click', '.deleteLocation', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');

                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Delete Confirmation',
                    message: 'Are you sure you want to delete <b>' + name + '</b>?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');

                            $.ajax({
                                url: "{{ route('business_location.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    bl_id: id
                                },
                                success: function(response) {
                                    if (response.status) {
                                        iziToast.success({
                                            title: 'Deleted',
                                            message: response.message,
                                            position: 'topRight'
                                        });
                                        table.ajax.reload(null, false);
                                    } else {
                                        iziToast.error({
                                            title: 'Error',
                                            message: 'Failed to delete'
                                        });
                                    }
                                }
                            });
                        }, true],
                        ['<button>NO</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }]
                    ]
                });
            });

            $(document).on("input", "input[name='gst_number']", function() {

                const gstRegex = /^([0-9]{2})([A-Z]{5})([0-9]{4})([A-Z]{1})([0-9A-Z]{1})Z([0-9A-Z]{1})$/;

                if (gstRegex.test($(this).val().toUpperCase())) {
                    $(this).removeClass("is-invalid").addClass("is-valid");
                } else {
                    $(this).removeClass("is-valid").addClass("is-invalid");
                }
            });

            $('#addLocationTabLink').on('click', function () {
    isEditMode = false;
    resetForm();
});






        });
    </script>
</body>

</html>
