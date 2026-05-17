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
            <h4 class="fw-medium mb-0">Ecommerce Customer</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);" class="text-white-50">Contact</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Ecommerce Customer</li>
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
                                            Ecommerce Customer List
                                        </a>
                                    </li>
                                    <li class="nav-item d-none">
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

                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Citizen</th>
                                                <th>Pan No.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
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










            // FilePond initialization

            const table = $('#masterTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ecom.cust.list') }}",
                columns: [{
                    data: 'sr_no'
                }, {
                    data: 'name'
                }, {
                    data: 'mobile'
                }, {
                    data: 'email'
                },
                {
                    data: 'citizen'
                },
                {
                    data: 'pan_no'
                },
                {
                    data: 'action'
                }]
            });




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
