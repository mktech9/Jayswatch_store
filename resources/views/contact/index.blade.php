<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')

<body>
    @include('partials.switcher')

    <!-- ✅ PAGE START -->
    <div class="page">

        @include('partials.header')
        @include('partials.sidebar')

        <!-- ✅ PAGE HEADER -->
        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">Contact</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);" class="text-white-50">Contact</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Contact</li>
            </ol>
        </div>

        <!-- ✅ MAIN CONTENT -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">

                        <div class="card custom-card">

                            <!-- ✅ CARD HEADER -->
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listTab">
                                            Contacts List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="formTabBtn" data-bs-toggle="tab" href="#formTab">
                                            Add Contact
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- ✅ TAB CONTENT -->
                            <div class="tab-content">

                                <!-- ✅ LIST TAB -->
                                <div class="tab-pane fade show active p-3" id="listTab">
                                    <table class="table table-bordered w-100" id="masterTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Contact ID</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <!-- ✅ FORM TAB -->
                                <div class="tab-pane fade p-4" id="formTab">
                                    <form id="contactMasterForm" enctype="multipart/form-data" novalidate>
                                        @csrf

                                        <input type="hidden" name="contact_master_id" id="contact_master_id">

                                        <!-- ✅ BASIC DETAILS -->
                                        <div class="row g-3 mb-4">

                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Contact Type</label>
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input type-toggle" type="radio"
                                                            name="is_business" value="0" id="individual" checked>
                                                        <label class="form-check-label"
                                                            for="individual">Individual</label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input type-toggle" type="radio"
                                                            name="is_business" value="1" id="business">
                                                        <label class="form-check-label" for="business">Business</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Contact ID (Manual/Auto)</label>
                                                <input type="text" name="contact_id" id="contact_id_val"
                                                    class="form-control" placeholder="Leave empty for auto">
                                            </div>

                                            <!-- ✅ INDIVIDUAL -->
                                            <div class="col-md-2 individual-row">
                                                <label class="form-label">Prefix</label>
                                                <select name="prefix" id="prefix" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 individual-row">
                                                <label class="form-label">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="first_name" id="first_name"
                                                    class="form-control req-field" placeholder="Enter First Name">
                                                <div class="invalid-feedback">First name is required</div>
                                            </div>

                                            <div class="col-md-3 individual-row">
                                                <label class="form-label">Middle Name</label>
                                                <input type="text" name="middle_name" id="middle_name"
                                                    class="form-control" placeholder="Enter Middle Name">
                                            </div>

                                            <div class="col-md-4 individual-row">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" name="last_name" id="last_name"
                                                    class="form-control" placeholder="Enter Last Name">
                                            </div>

                                            <div class="col-md-4 individual-row">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" name="date_of_birth" id="date_of_birth"
                                                    class="form-control flatpickr-date" placeholder="Select DOB">
                                            </div>

                                            <!-- ✅ BUSINESS -->
                                            <div class="col-md-8 business-row d-none">
                                                <label class="form-label">Business Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="business_name" id="business_name"
                                                    class="form-control" placeholder="Enter Business Name">
                                            </div>

                                            <!-- ✅ CONTACT -->
                                            <div class="col-md-4">
                                                <label class="form-label">Mobile <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="mobile" id="mobile"
                                                    class="form-control req-field" placeholder="Enter Mobile Number">
                                                <div class="invalid-feedback">Mobile number is required</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Alternate Number</label>
                                                <input type="text" name="alternate_contact_number"
                                                    id="alternate_contact_number" class="form-control"
                                                    placeholder="Enter Alternate Number">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Landline</label>
                                                <input type="text" name="landline" id="landline"
                                                    class="form-control" placeholder="Enter Phone No.">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="email" id="email"
                                                    class="form-control req-field" placeholder="Enter Email ID">
                                                <div class="invalid-feedback">Email is required</div>
                                            </div>

                                            <div class="col-md-4 business-row d-none">
                                                <label class="form-label">GST Number</label>
                                                <input type="text" name="gst_number" id="gst_number"
                                                    class="form-control" placeholder="Enter GST Number">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- ✅ FILE UPLOAD -->
                                        <div class="row g-3 mb-4 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label">ID Proof Type</label>
                                                <select name="id_proof_type" id="id_proof_type"
                                                    class="form-select select2-master">
                                                    <option value="">Please Select</option>
                                                    <option value="Aadhar Card">Aadhar Card</option>
                                                    <option value="Pan Card">Pan Card</option>
                                                    <option value="Driving Licence">Driving Licence
                                                    </option>
                                                    <option value="Voter Id">Voter Id</option>
                                                    <option value="Passport">Passport</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">ID Number</label>
                                                <input type="text" name="id_number" id="id_number"
                                                    class="form-control" placeholder="Enter ID Number">
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">ID File (Image/PDF/DOC)</label>
                                                <input type="file" name="id_file_path" class="filepond">
                                            </div>
                                        </div>


                                        <hr>
                                        <div class="row g-3 mb-4 mt-2">

                                            <div class="col-md-6">
                                                <label class="form-label">Address Line 1</label>
                                                <textarea name="address_line_1" id="address_line_1" class="form-control" rows="3"
                                                    placeholder="Enter Address Line 1"></textarea>
                                            </div>

                                            <!-- Address Line 2 -->
                                            <div class="col-md-6">
                                                <label class="form-label">Address Line 2</label>
                                                <textarea name="address_line_2" id="address_line_2" class="form-control" rows="3"
                                                    placeholder="Enter Address Line 2"></textarea>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">Country <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="country" id="country_id" required>
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Country is required</div>
                                            </div>


                                            <div class="col-md-3">
                                                <label class="form-label">State <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="state" id="state_id" required
                                                    disabled>
                                                    <option value="">Select State</option>
                                                </select>
                                                <div class="invalid-feedback">State is required</div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">City <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="city" id="city_id" required
                                                    disabled>
                                                    <option value="">Select City</option>
                                                </select>
                                                <div class="invalid-feedback">City is required</div>
                                            </div>



                                            <div class="col-md-3">
                                                <label class="form-label">Pin Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="zip_code"
                                                    id="zip_code" placeholder="Enter Zip Code" required>
                                                <div class="invalid-feedback">Pin code is required</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-primary px-5" id="saveBtn">
                                                <span class="btn-text">
                                                    <i class="bx bx-save me-1"></i> Save
                                                </span>

                                                <span class="btn-spinner d-none">
                                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                                    Saving...
                                                </span>
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

        @include('partials.footer')

    </div>
    <!-- ✅ PAGE END -->


    <!-- ✅ MODAL OUTSIDE PAGE -->
    <div class="modal fade" id="viewContactModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">
                        <i class="bx bx-user-circle me-2"></i> Contact Details
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4" id="viewContactContent"></div>
            </div>
        </div>
    </div>


    @include('partials.footer_link')




    <!-- ✅ SCRIPT -->
    <script>
        let pond; // ✅ global variable
        $(document).ready(function() {



            $(".flatpickr-date").flatpickr({
                maxDate: "today",
                dateFormat: "d-m-Y",
                allowInput: true
            });

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

            $('#prefix').select2({
                placeholder: "Select Prefix",
                width: '100%'
            });


            $('.select2-master').select2({
                placeholder: "Select Option",
                allowClear: true,
                width: '100%'
            });



            $('#country_id').on('change', function() {
                let countryId = $(this).val();
                $('#state_id').empty().append('<option value="">Select State</option>').prop('disabled',
                    true);
                $('#city_id').empty().append('<option value="">Select City</option>').prop('disabled',
                    true);

                if (!countryId) return;

                let url = "{{ route('get.states', ':country_id') }}".replace(':country_id', countryId);
                $.get(url, function(data) {
                    $('#state_id').prop('disabled', false);
                    $.each(data, function(key, state) {
                        $('#state_id').append('<option value="' + state.id + '">' + state
                            .name + '</option>');
                    });
                    $('#state_id').trigger('change.select2');
                });
            });

            // Load cities on state change
            $('#state_id').on('change', function() {
                let stateId = $(this).val();
                $('#city_id').empty().append('<option value="">Select City</option>').prop('disabled',
                    true);

                if (!stateId) return;

                let url = "{{ route('get.cities', ':state_id') }}".replace(':state_id', stateId);
                $.get(url, function(data) {
                    $('#city_id').prop('disabled', false);
                    $.each(data, function(key, city) {
                        $('#city_id').append('<option value="' + city.id + '">' + city
                            .name + '</option>');
                    });
                    $('#city_id').trigger('change.select2');
                });
            });

            // FilePond initialization
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginImagePreview,
                FilePondPluginFileValidateSize // ✅ ADD
            );

            pond = FilePond.create(document.querySelector('.filepond'), {
                storeAsFile: true,
                allowImagePreview: true,
                imagePreviewHeight: 170,
                maxFileSize: '2MB', // ✅ LIMIT HERE
                labelMaxFileSizeExceeded: 'File is too large',
                labelMaxFileSize: 'Maximum file size is {filesize}',
                credits: false
            });

            pond.on('removefile', function() {
                $('#fileViewLink').remove(); // ✅ hide button
            });

            const table = $('#masterTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('contact.master.list') }}",
                columns: [{
                    data: 'sr_no'
                }, {
                    data: 'contact_id'
                }, {
                    data: 'name'
                }, {
                    data: 'mobile'
                }, {
                    data: 'email'
                }, {
                    data: 'action'
                }]
            });

            // Handle Individual vs Business toggle
            $('.type-toggle').on('change', function() {
                if ($(this).val() == '1') {
                    $('.individual-row').addClass('d-none');
                    $('.business-row').removeClass('d-none');
                    $('#business_name').addClass('req-field');
                    $('#first_name').removeClass('req-field');
                } else {
                    $('.individual-row').removeClass('d-none');
                    $('.business-row').addClass('d-none');
                    $('#first_name').addClass('req-field');
                    $('#business_name').removeClass('req-field');
                }
            });

            $('#contactMasterForm').on('submit', function(e) {

                e.preventDefault();

                const btn = $('#saveBtn');

                // prevent double click
                if (btn.prop('disabled')) return;

                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.btn-spinner').removeClass('d-none');

                // helper to reset button
                const resetBtn = () => {
                    btn.prop('disabled', false);
                    btn.find('.btn-text').removeClass('d-none');
                    btn.find('.btn-spinner').addClass('d-none');
                };

                let valid = true;

                /* ================= REQUIRED FIELD CHECK ================= */
                $('#contactMasterForm')
                    .find('[required], .req-field')
                    .filter(':visible')
                    .each(function() {

                        let value = $(this).val();

                        if (!value || value.toString().trim() === '') {
                            valid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                if (!valid) {
                    resetBtn();
                    return false;
                }

                /* ================= MOBILE VALIDATION ================= */
                const mobile = $('#mobile').val().trim();
                const alternateMobile = $('#alternate_contact_number').val().trim();
                const phoneRegex = /^[0-9]{10}$/;

                if (!phoneRegex.test(mobile)) {
                    iziToast.error({
                        title: 'Invalid Mobile',
                        message: 'Mobile number must be exactly 10 digits.',
                        position: 'topRight'
                    });
                    $('#mobile').addClass('is-invalid');
                    resetBtn();
                    return;
                }

                if (alternateMobile !== "" && !phoneRegex.test(alternateMobile)) {
                    iziToast.error({
                        title: 'Invalid Alternate Mobile',
                        message: 'Alternate number must be exactly 10 digits.',
                        position: 'topRight'
                    });
                    $('#alternate_contact_number').addClass('is-invalid');
                    resetBtn();
                    return;
                }

                /* ================= FILE VALIDATION ================= */
                const files = pond.getFiles();
                const hasError = files.some(file => file.status === 8);

                if (hasError) {
                    iziToast.error({
                        title: 'Invalid File',
                        message: 'Please upload a valid file within allowed size.',
                        position: 'topRight'
                    });
                    resetBtn();
                    return false;
                }

                /* ================= AJAX SUBMIT ================= */
                let fd = new FormData(this);

                if (pond.getFiles().length) {
                    fd.set('id_file_path', pond.getFiles()[0].file);
                }

                $.ajax({
                    url: "{{ route('contact.master.store') }}",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        iziToast.success({
                            message: res.message,
                            position: 'topRight'
                        });

                        table.ajax.reload();
                        bootstrap.Tab.getOrCreateInstance(
                            document.querySelector('a[href="#listTab"]')
                        ).show();

                        resetMasterForm();
                    },

                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to save contact.',
                            position: 'topRight'
                        });
                    },

                    // ✅ FIXED (comma added before complete)
                    complete: function() {
                        resetBtn();
                    }
                });

            });

            function loadNextContactId() {
                console.log('Calling next ID...');
                $.get("{{ route('contact.next.id') }}", function(res) {
                    // console.log(res);
                    $('#contact_id_val').val(res.contact_id);
                });
            }

            //view Handler


            $(document).on('click', '.viewContact', function() {
                const id = $(this).data('id');

                // Use the Laravel route helper with a placeholder for the ID
                let url = "{{ route('contact.master.show', ':id') }}";
                url = url.replace(':id', id);

                $.get(url, function(res) {
                    if (res.status === 200) {
                        const d = res.data;
                        const format = (val) => (val && val !== null ? val : '-');

                        let name = "";
                        if (d.is_business == 1) {
                            name = format(d.business_name);
                        } else {
                            let nameParts = [d.prefix, d.first_name, d.middle_name, d.last_name]
                                .filter(part => part && part.trim() !== "");

                            name = nameParts.length > 0 ? nameParts.join(' ') : '-';
                        }

                        let html = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom pb-2 mb-3 text-primary">Core Information</h6>
                        <p class="mb-2"><i class="bx bx-id-card me-2 text-muted"></i><strong>Type:</strong> ${d.is_business == 1 ? 'Business' : 'Individual'}</p>
                        <p class="mb-2"><i class="bx bx-hash me-2 text-muted"></i><strong>Contact ID:</strong> ${format(d.contact_id)}</p>
                        <p class="mb-2"><i class="bx bx-user me-2 text-muted"></i><strong>Name:</strong> ${name}</p>
                        <p class="mb-2"><i class="bx bx-phone me-2 text-muted"></i><strong>Mobile:</strong> ${format(d.mobile)}</p>
                        <p class="mb-2"><i class="bx bx-envelope me-2 text-muted"></i><strong>Email:</strong> ${format(d.email)}</p>
                        <p class="mb-2"><i class="bx bx-cake me-2 text-muted"></i><strong>DOB:</strong> ${format(d.date_of_birth)}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom pb-2 mb-3 text-primary">Financial & CRM</h6>
                        <p class="mb-2"><i class="bx bx-receipt me-2 text-muted"></i><strong>Tax Number:</strong> ${format(d.tax_number)}</p>
                        ${d.is_business == 1 ? `<p class="mb-2"><i class="bx bx-file me-2 text-muted"></i><strong>GST Number:</strong> ${format(d.gst_number)}</p>` : ''}
                        <p class="mb-2"><i class="bx bx-wallet me-2 text-muted"></i><strong>Opening Balance:</strong> ${format(d.opening_balance)}</p>
                        <p class="mb-2"><i class="bx bx-timer me-2 text-muted"></i><strong>Pay Term:</strong> ${format(d.pay_term)} ${format(d.pay_term_period)}</p>
                        <p class="mb-2"><i class="bx bx-credit-card-front me-2 text-muted"></i><strong>Credit Limit:</strong> ${format(d.credit_limit)}</p>
                        <p class="mb-2"><i class="bx bx-user-voice me-2 text-muted"></i><strong>Assigned To:</strong> ${format(d.assigned_to)}</p>
                    </div>
                    <div class="col-12">
                        <h6 class="fw-bold border-bottom pb-2 mb-3 text-primary">Documentation & Address</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><i class="bx bx-certification me-2 text-muted"></i><strong>ID Type:</strong> ${format(d.id_proof_type)} (${format(d.id_number)})</p>
                                <p class="mb-2"><i class="bx bx-map me-2 text-muted"></i><strong>Address:</strong> ${format(d.address_line_1)} ${format(d.address_line_2)}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><i class="bx bx-buildings me-2 text-muted"></i><strong>City/State:</strong> ${format(d.city_name)}, ${format(d.state_name)}</p>
                                <p class="mb-2"><i class="bx bx-globe me-2 text-muted"></i><strong>Country/Zip:</strong> ${format(d.country_name)} - ${format(d.zip_code)}</p>
                            </div>
                        </div>
                    </div>
                </div>`;

                        $('#viewContactContent').html(html);
                        $('#viewContactModal').modal('show');
                    }
                });
            });

            $(document).on('click', '.editContact', function() {
                const id = $(this).data('id');

                let url = "{{ route('contact.master.show', ':id') }}";
                url = url.replace(':id', id);

                $.get(url, function(res) {
                    if (res.status === 200) {
                        const d = res.data;
                        $('#contact_master_id').val(d.contact_master_id);
                        $('#id_proof_type').val(d.id_proof_type).trigger('change');
                        $(`.type-toggle[value="${d.is_business}"]`).prop('checked', true).trigger(
                            'change');
                        $('.type-toggle').prop('disabled', true);

                        $('#contact_id_val').val(d.contact_id);
                        $('#prefix').val(d.prefix).trigger('change');
                        $('#first_name').val(d.first_name);
                        $('#middle_name').val(d.middle_name);
                        $('#last_name').val(d.last_name);
                        if (d.date_of_birth) {

                            // convert YYYY-MM-DD → DD-MM-YYYY
                            let parts = d.date_of_birth.split('-');
                            let formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];

                            document.querySelector("#date_of_birth")
                                ._flatpickr.setDate(formattedDate, true);
                        }
                        $('#business_name').val(d.business_name);
                        $('#mobile').val(d.mobile);
                        $('#alternate_contact_number').val(d.alternate_contact_number);
                        $('#landline').val(d.landline);
                        $('#email').val(d.email);
                        $('#gst_number').val(d.gst_number);
                        $('#id_number').val(d.id_number);
                        $('#assigned_to').val(d.assigned_to);
                        $('#tax_number').val(d.tax_number);
                        $('#opening_balance').val(d.opening_balance);
                        $('#pay_term').val(d.pay_term);
                        $('#pay_term_period').val(d.pay_term_period);
                        $('#credit_limit').val(d.credit_limit);
                        $('#address_line_1').val(d.address_line_1);
                        $('#address_line_2').val(d.address_line_2);
                        $('#country_id').val(d.country).trigger('change');

                        if (d.country) {
                            let stateUrl = "{{ route('get.states', ':cid') }}".replace(':cid', d
                                .country);
                            $.get(stateUrl, function(states) {
                                $('#state_id').prop('disabled', false).empty().append(
                                    '<option value="">Select State</option>');
                                states.forEach(state => {
                                    $('#state_id').append(
                                        `<option value="${state.id}">${state.name}</option>`
                                    );
                                });
                                $('#state_id').val(d.state).trigger('change');

                                if (d.state) {
                                    let cityUrl = "{{ route('get.cities', ':sid') }}"
                                        .replace(':sid', d.state);
                                    $.get(cityUrl, function(cities) {
                                        $('#city_id').prop('disabled', false)
                                            .empty().append(
                                                '<option value="">Select City</option>'
                                            );
                                        cities.forEach(city => {
                                            $('#city_id').append(
                                                `<option value="${city.id}">${city.name}</option>`
                                            );
                                        });
                                        $('#city_id').val(d.city).trigger('change');
                                    });
                                }
                            });
                        }
                        $('#zip_code').val(d.zip_code);

                        // remove old view button first
                        $('#fileViewLink').remove();

                        if (d.file_url) {

                            pond.removeFiles();

                            pond.addFile(d.file_url, {
                                type: 'local',
                                file: {
                                    name: d.id_file_path,
                                    size: d.file_size, // ✅ VERY IMPORTANT
                                    type: 'application/octet-stream'
                                }
                            });

                            // add view button
                            $('.filepond').after(`
        <a id="fileViewLink"
           href="${d.file_url}"
           target="_blank"
           class="btn btn-sm btn-primary mt-2">
           View Document
        </a>
    `);
                        }

                        $('#formTabBtn').text('Edit Contact');
                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#formTabBtn'))
                            .show();
                    }
                });
            });

            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr("href");

                // When opening Add Contact
                if (target === "#formTab" && $('#formTabBtn').text() !== 'Edit Contact') {
                    resetMasterForm();
                    loadNextContactId(); // ✅ AUTO GENERATE HERE
                }

                // When going back to list
                if (target === "#listTab") {
                    resetMasterForm();
                }
            });

            $(document).on('click', '.statusToggle', function() {
                $.post("{{ route('contact.master.toggle') }}", {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id'),
                    status: $(this).data('status')
                }, () => table.ajax.reload());
            });

            $(document).on('click', '.deleteContact', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true
                }).then(r => {
                    if (r.isConfirmed) $.post("{{ route('contact.master.delete') }}", {
                        _token: "{{ csrf_token() }}",
                        id: $(this).data('id')
                    }, () => table.ajax.reload());
                });
            });
        });

        function resetMasterForm() {
            $('#fileViewLink').remove();
            $('#contact_master_id').val('');
            $('#contactMasterForm')[0].reset();
            $('.select2-master').val(null).trigger('change');
            document.querySelectorAll(".flatpickr-date").forEach(el => {
                if (el._flatpickr) el._flatpickr.clear();
            });
            $('.type-toggle').prop('disabled', false);
            $('.type-toggle[value="0"]').prop('checked', true).trigger('change');
            $('#formTabBtn').text('Add Contact');
            pond.removeFiles();
            $('.form-control').removeClass('is-invalid');

            $('#country_id').val(null).trigger('change');
            $('#state_id').empty().append('<option value="">Select State</option>').prop('disabled', true).val(null)
                .trigger('change');
            $('#city_id').empty().append('<option value="">Select City</option>').prop('disabled', true).val(null).trigger(
                'change');
        }
    </script>

</body>

</html>
