<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')


<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Staff Management</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Staff-Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add Staff</li>
            </ol>
        </div>
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-12">

                        <div class="card custom-card">


                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">


                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listUsers"
                                            role="tab">
                                            Staff List
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#addUsers" role="tab">
                                            Add Staff
                                        </a>
                                    </li>

                                </ul>
                            </div>


                            <div class="tab-content">


                                <div class="tab-pane fade show active" id="listUsers" role="tabpanel">
                                    <div class="table-responsive">
                                        <table id="userTable"
                                            class="table table-bordered table-striped text-center w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User Name</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="addUsers" role="tabpanel">
                                    <form id="userForm" class="needs-validation" novalidate>
                                        @csrf

                                        <!-- ================= BASIC INFO ================= -->
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h6 class="mb-3">Add Staff</h6>

                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Prefix</label>
                                                        <select class="form-select" id="prefix" name="prefix">
                                                            <option value="">Mr / Mrs / Miss</option>
                                                            <option>Mr</option>
                                                            <option>Mrs</option>
                                                            <option>Miss</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">First Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="first_name"
                                                            required>
                                                        <div class="invalid-feedback">First name is required</div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" name="last_name">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Email <span
                                                                class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" name="email_id"
                                                            required>
                                                        <div class="invalid-feedback">Valid email is required</div>
                                                    </div>

                                                    <div class="col-md-2 d-flex align-items-center mt-4">
                                                        <div class="form-check form-switch"
                                                            style="margin-top:1.5rem !important; cursor: pointer;">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="is_active" name="active_status" checked
                                                                style="cursor: pointer;">
                                                            <label class="form-check-label" for="is_active"
                                                                style="cursor: pointer;">
                                                                Is Active?
                                                            </label>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <!-- ================= ROLES & PERMISSIONS ================= -->
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h6 class="mb-3">Roles and Permissions</h6>

                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <div class="form-check form-switch" style="cursor: pointer;">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="allow_login" name="login_status" checked
                                                                style="cursor: pointer;">
                                                            <label class="form-check-label" for="allow_login"
                                                                style="cursor: pointer;">
                                                                Allow login
                                                            </label>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="user_name">
                                                        <small class="text-muted">Leave blank to auto-generate</small>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Password <span
                                                                class="text-danger">*</span></label>

                                                        <div class="input-group">
                                                            <input type="password" class="form-control password-field"
                                                                name="password" id="password"
                                                                autocomplete="new-password" required
                                                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$">





                                                            <span class="input-group-text toggle-password"
                                                                data-target="#password" style="cursor:pointer;">
                                                                <i class="ri-eye-line"></i>
                                                            </span>

                                                               <div class="invalid-feedback">
                                                                Password is required.
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Confirm Password <span
                                                                class="text-danger">*</span></label>

                                                        <div class="input-group">
                                                            <input type="password" class="form-control password-field"
                                                                id="confirm_password" autocomplete="new-password"
                                                                required>

                                                            <span class="input-group-text toggle-password"
                                                                data-target="#confirm_password"
                                                                style="cursor:pointer;">
                                                                <i class="ri-eye-line"></i>
                                                            </span>
                                                             <div class="invalid-feedback">Confirm password required</div>
                                                        </div>


                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">
                                                            Role <span class="text-danger">*</span>
                                                        </label>

                                                        <select name="role_id" id="role_id" class="form-select"
                                                            required>
                                                            <option value="">Select Role</option>

                                                            @foreach ($role_data as $role)
                                                                <option value="{{ $role->role_id }}">
                                                                    {{ $role->role_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <div class="invalid-feedback">
                                                            Role is required
                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <label class="fw-semibold">Access Locations</label>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="all_locations">
                                                    <label class="form-check-label" for="all_locations">
                                                        All Locations
                                                    </label>
                                                </div>

                                                <div class="ms-3 mt-2" id="locationList">

                                                    @foreach ($locations as $location)
                                                        <div class="form-check">
                                                            <input class="form-check-input location-checkbox"
                                                                type="checkbox" name="access_location[]"
                                                                value="{{ $location->bl_id }}"
                                                                id="location_{{ $location->bl_id }}">
                                                            <label class="form-check-label"
                                                                for="location_{{ $location->bl_id }}">
                                                                {{ $location->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                    <div class="col-md-4 d-flex align-items-center mt-4">
                                                        <div class="form-check form-switch" style="cursor:pointer;">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="allow_contact" name="allow_contact" checked
                                                                style="cursor:pointer;">
                                                            <label class="form-check-label" for="allow_contact"
                                                                style="cursor:pointer;">
                                                                Allow Selected Contacts
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                        <!-- ================= SALES ================= -->
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h6 class="mb-3">Sales</h6>

                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Sales Commission (%)</label>
                                                        <input type="number" class="form-control"
                                                            name="sales_commission">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Max sales discount (%)</label>
                                                        <input type="number" class="form-control"
                                                            name="sales_discount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h6 class="mb-3">More Information</h6>

                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Date of Birth</label>
                                                        <div class="input-group">
                                                            <div class="input-group-text text-muted"> <i
                                                                    class="ri-calendar-line"></i> </div>
                                                            <input type="text" class="form-control" name="dob"
                                                                id="dob" placeholder="Choose date">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Gender</label>
                                                        <select class="form-select" id="gender" name="gender">
                                                            <option value="">Select</option>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Mobile Number</label>
                                                        <input type="text" class="form-control"
                                                            name="contact_number">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Alternate Contact</label>
                                                        <input type="text" class="form-control"
                                                            name="alt_contact_number">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Facebook Link</label>
                                                        <input type="url" class="form-control"
                                                            name="facebook_link"
                                                            placeholder="https://facebook.com/username">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Twitter Link</label>
                                                        <input type="url" class="form-control"
                                                            name="twitter_link"
                                                            placeholder="https://twitter.com/username">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Permanent Address</label>
                                                        <textarea class="form-control" name="permanent_address"></textarea>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Current Address</label>
                                                        <textarea class="form-control" name="current_address"></textarea>
                                                    </div>
                                                </div>

                                                {{-- <hr>

                                                <h6 class="mb-3">Bank Details</h6>

                                                <div class="row g-3">
                                                    <div class="col-md-3"><input class="form-control" name="acc_holder_name" placeholder="Account Holder Name"></div>
                                                    <div class="col-md-3"><input class="form-control" name="acc_number" placeholder="Account Number"></div>
                                                    <div class="col-md-3"><input class="form-control" name="bank_name" placeholder="Bank Name"></div>
                                                    <div class="col-md-3"><input class="form-control" name="bank_code" placeholder="IFSC Code"></div>
                                                    <div class="col-md-3"><input class="form-control" name="bank_branch" placeholder="Branch"></div>
                                                    <div class="col-md-3"><input class="form-control" name="tax_payer_id" placeholder="Tax Payer ID"></div>
                                                </div> --}}
                                            </div>
                                        </div>

                                        <div class="text-end mb-4">
                                            <button type="submit" class="btn btn-primary px-5" id="saveBtn">
                                                Save
                                            </button>
                                            <button class="btn btn-primary-light px-5 d-none" type="button"
                                                id="loadingBtn" disabled>
                                                <span class="spinner-border spinner-border-sm align-middle"
                                                    role="status" aria-hidden="true"></span>
                                                <span class="ms-2">Saving...</span>
                                            </button>
                                        </div>
                                        {{-- <button class="btn btn-primary-light px-5 d-none" type="button" id="loadingBtn" disabled>
                                            <span class="spinner-border spinner-border-sm align-middle" role="status" aria-hidden="true"></span>
                                            <span class="ms-2">Saving...</span>
                                        </button> --}}
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <!-- End::row-1 -->

            </div>
        </div>




        @include('partials.footer')




    </div>


    @include('partials.footer_link')


    <script>
        let dobPicker;
        let isEditMode = false;



        // 👁 Toggle password visibility
        $(document).on('click', '.toggle-password', function() {

            let input = $($(this).data('target'));
            let icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
            } else {
                input.attr('type', 'password');
                icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
            }
        });

        function loadStaffForEdit(staffId) {
            $.ajax({
                url: "{{ route('staff.edit', '__id__') }}".replace('__id__', staffId),
                type: 'GET',
                success: function(res) {
                    isEditMode = true;
                    if (!res.status) return;

                    const d = res.data;




                    new bootstrap.Tab(document.querySelector('a[href="#addUsers"]')).show();

                    $('a[href="#addUsers"]').text('Edit User');
                    $('#userForm h6:first').text('Edit User');
                    $('#userForm button[type="submit"]').text('Update');


                    $('[name="prefix"]').val(d.prefix).trigger('change');
                    $('[name="first_name"]').val(d.first_name);
                    $('[name="last_name"]').val(d.last_name);
                    $('[name="email_id"]').val(d.email_id);

                    $('#is_active').prop('checked', d.active_status == 0);


                    $('#allow_login').prop('checked', d.login_status == 0);
                    $('[name="user_name"]').val(d.user_name);
                    $('#role_id').val(d.role_id).trigger('change');


                 $('[name="password"]')
    .prop('required', false)
    .attr('placeholder', 'Leave blank to keep current pass.')
    .removeAttr('pattern')   // ⭐ IMPORTANT
    .removeClass('is-invalid is-valid');

$('#confirm_password')
.attr('placeholder', 'Leave blank to keep current pass.')
    .prop('required', false)
    .removeClass('is-invalid is-valid');

                    let locations = [];

                    if (d.access_location) {
                        locations = d.access_location.split(',');
                    }

                    $('.location-checkbox').prop('checked', false);

                    locations.forEach(loc => {
                        $('.location-checkbox[value="' + loc.trim() + '"]').prop('checked', true);
                    });

                    $('#all_locations').prop(
                        'checked', $('.location-checkbox:checked').length === $('.location-checkbox').length
                    );

                    $('#allow_contact').prop('checked', d.allow_contact == 0);


                    $('[name="sales_commission"]').val(d.sales_commission);
                    $('[name="sales_discount"]').val(d.sales_discount);


                    if (d.dob) {
                        dobPicker.setDate(d.dob, true);
                    } else {
                        dobPicker.clear();
                    }

                    $('[name="gender"]').val(d.gender).trigger('change');
                    $('[name="contact_number"]').val(d.contact_number);
                    $('[name="alt_contact_number"]').val(d.alt_contact_number);
                    $('[name="facebook_link"]').val(d.facebook_link);
                    $('[name="twitter_link"]').val(d.twitter_link);
                    $('[name="permanent_address"]').val(d.permanent_address);
                    $('[name="current_address"]').val(d.current_address);


                    $('[name="acc_holder_name"]').val(d.acc_holder_name);
                    $('[name="acc_number"]').val(d.acc_number);
                    $('[name="bank_name"]').val(d.bank_name);
                    $('[name="bank_code"]').val(d.bank_code);
                    $('[name="bank_branch"]').val(d.bank_branch);
                    $('[name="tax_payer_id"]').val(d.tax_payer_id);


                    $('#userForm').append(
                        `<input type="hidden" name="staff_id" value="${d.staff_id}">`
                    );
                }
            });
        }
        $(document).ready(function() {




            $("#all_locations").on("change", function() {
                $(".location-checkbox").prop("checked", this.checked);
            });

            // Individual → All
            $(".location-checkbox").on("change", function() {
                let total = $(".location-checkbox").length;
                let checked = $(".location-checkbox:checked").length;

                $("#all_locations").prop("checked", total === checked);
            });
            $('#role_id').select2({
                placeholder: 'Select Role',
                allowClear: true,
                width: '100%'
            });

            $('#gender').select2({
                placeholder: 'Select Gender',
                allowClear: true,
                width: '100%'
            });

            $('#prefix').select2({
                width: '100%'
            });

            dobPicker = flatpickr("#dob", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "F j, Y",
                allowInput: false,
                maxDate: "today",
                yearSelectorType: "dropdown",
                disableMobile: true
            });




            $("#userForm").on("submit", function(e) {
                e.preventDefault();


                let isValid = true;

                $(this).find('[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    }
                });

                if (!isValid) {
                    iziToast.warning({
                        title: 'Required',
                        message: 'Please fill up all required fields',
                        position: 'topRight',
                        timeout: 3000
                    });
                    return false;
                }


                let password = $("input[name='password']").val();
                let confirmPassword = $("#confirm_password").val();


                // Only check match if password entered
if (password.length > 0 && password !== confirmPassword) {
    $("#confirm_password").addClass("is-invalid");

    iziToast.error({
        title: 'Password Mismatch',
        message: 'Password and Confirm Password do not match',
        position: 'topRight'
    });

    return false;
}

               let strongPassword =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;

// ✅ ADD MODE → password required
if (!isEditMode && !strongPassword.test(password)) {
    iziToast.error({
        title: 'Weak Password',
        message: 'Password must contain uppercase, lowercase, number and special character.',
        position: 'topRight'
    });
    return false;
}

// ✅ EDIT MODE → validate ONLY if user entered password
if (isEditMode && password.length > 0 && !strongPassword.test(password)) {
    iziToast.error({
        title: 'Weak Password',
        message: 'Password must contain uppercase, lowercase, number and special character.',
        position: 'topRight'
    });
    return false;
}

                let payload = {};
                let formData = $(this).serializeArray();

                $.each(formData, function(_, field) {
                    if (field.name !== "access_location[]") {
                        payload[field.name] = field.value;
                    }
                });

                let locations = [];
                $("input[name='access_location[]']:checked").each(function() {
                    locations.push($(this).val());
                });

                payload.access_location = locations.join(",");
                payload.active_status = $("#is_active").is(":checked") ? 0 : 1;
                payload.login_status = $("#allow_login").is(":checked") ? 0 : 1;
                payload.allow_contact = $("#allow_contact").is(":checked") ? 0 : 1;

                $("#saveBtn").addClass("d-none");
                $("#loadingBtn").removeClass("d-none");
                $.ajax({
                    url: "{{ route('staff.store') }}",
                    type: "POST",
                    data: payload,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Success',
                            message: res.message,
                            position: 'topRight',
                            timeout: 2500
                        });


                        resetUserForm();
                        $('a[href="#listUsers"]').tab('show');
                        userTable.ajax.reload(null, false);
                        $("#loadingBtn").addClass("d-none");
                        $("#saveBtn").removeClass("d-none");
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong while saving data',
                            position: 'topRight'
                        });
                        $("#loadingBtn").addClass("d-none");
                        $("#saveBtn").removeClass("d-none");
                    }
                });
            });


            var userTable = $('#userTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('users.list') }}",

                columns: [{
                    data: 'sr_no',
                    orderable: false
                }, {
                    data: 'user_name'
                }, {
                    data: 'name'
                }, {
                    data: 'role'
                }, {
                    data: 'email'
                }, {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }],

                columnDefs: [{
                    targets: '_all',
                    className: 'text-start'
                }],

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
                        var table = doc.content[1].table;
                        table.widths = Array(table.body[0].length).fill('*');
                    }
                }]

            });



            $(document).on('click', '.viewUser', function() {
                let id = $(this).data('id');
                let url = "{{ route('users.view', ':id') }}".replace(':id', id);
                window.location.href = url;
            });





            $(document).on('click', '.editUser', function() {

                const staffId = $(this).data('id');
                loadStaffForEdit(staffId);

            });

            $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function(e) {

                const target = $(e.target).attr('href');

                // 🔁 When switching BACK to list
                if (target === '#listUsers') {
                    isEditMode = false;
                    resetUserForm();
                }

                // 🔁 When clicking Add Users manually (not edit)
                if (target === '#addUsers' && !isEditMode) {
                    resetUserForm();
                }
            });


            function resetUserForm() {



                $('a[href="#addUsers"]').text('Add Staff');
                $('#userForm h6:first').text('Add Staff');
                $('#userForm button[type="submit"]').text('Save');


                $('#userForm')[0].reset();


                $('#userForm input[name="staff_id"]').remove();

                dobPicker.clear();


                $('#is_active').prop('checked', true);
                $('#allow_login').prop('checked', true);
                $('#allow_contact').prop('checked', true);


                $('.location-checkbox').prop('checked', false);
                $('#all_locations').prop('checked', false);


                $('#role_id').val(null).trigger('change');
                $('#gender').val(null).trigger('change');
                $('#prefix').val(null).trigger('change');

$('[name="password"]')
    .prop('required', true)
    .attr(
        'pattern',
        '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&]).{8,}$'
    );

    $('#confirm_password')
    .prop('required', true)
    .attr(
        'pattern',
        '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&]).{8,}$'
    );
                $('#userForm')
                    .removeClass('was-validated')
                    .find('.is-invalid, .is-valid')
                    .removeClass('is-invalid is-valid');
            }

            $(document).on('click', '.deleteUser', function() {

                const staffId = $(this).data('id');
                const staffName = $(this).data('name');

                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    title: 'Confirm Delete',
                    message: `Are you sure you want to delete <b>${staffName}</b>?`,
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function(instance, toast) {

                            $.ajax({
                                url: "{{ route('staff.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    staff_id: staffId
                                },
                                success: function(res) {

                                    // ✅ CLOSE CONFIRM TOAST FIRST
                                    instance.hide({
                                        transitionOut: 'fadeOut'
                                    }, toast, 'button');

                                    if (res.status) {

                                        iziToast.success({
                                            title: 'Deleted',
                                            message: res.message,
                                            position: 'topRight'
                                        });

                                        // 🔁 Reload DataTable
                                        userTable.ajax.reload(null, false);
                                    }
                                },
                                error: function() {

                                    instance.hide({
                                        transitionOut: 'fadeOut'
                                    }, toast, 'button');

                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Unable to delete user',
                                        position: 'topRight'
                                    });
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

        });
    </script>
    @if (!empty($editStaffId))
        <script>
            $(document).ready(function() {

                // Open Add Users tab
                new bootstrap.Tab(
                    document.querySelector('a[href="#addUsers"]')
                ).show();

                // Load edit data
                loadStaffForEdit(@json($editStaffId));

            });
        </script>
    @endif




</body>

</html>
