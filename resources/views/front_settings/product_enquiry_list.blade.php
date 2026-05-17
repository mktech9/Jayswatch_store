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
            <h4 class="fw-medium mb-0">Product Enquiry</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Front Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product Enquiry List</li>
            </ol>
        </div>



        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="card custom-card">

                    <!-- CARD HEADER WITH TABS -->
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="listEnquiryTab" data-bs-toggle="tab" href="#listEnquiry"
                                    role="tab">
                                    Enquiry List
                                </a>
                            </li>
                            @if (routePermission(session('current_page_route') ?? '', 'create'))
                                <li class="nav-item">
                                    <a class="nav-link" id="addEnquiryTab" data-bs-toggle="tab" href="#addEnquiry"
                                        role="tab">
                                        Add Enquiry
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <div class="d-flex gap-2 mb-2" id="exportWrapper">
                            <button class="btn btn-sm btn-primary" id="refreshTable">
                                <i class='bx bx-refresh'></i> Refresh
                            </button>

                            @if (routePermission(session('current_page_route') ?? '', 'export'))
                                <button class="btn btn-success" id="exportEnquiryBtn">
                                    <span class="btn-text">
                                        <i class="bx bx-export"></i> Export
                                    </span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            @endif
                        </div>

                    </div>

                    <!-- TAB CONTENT -->
                    <div class="tab-content">

                        <!-- ================= LIST TAB ================= -->
                        <div class="tab-pane fade show active p-0" id="listEnquiry" role="tabpanel">
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-bordered w-100" id="prodEnquiryTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">Action</th>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Last Follow Up</th>
                                                <th>Product Info</th>
                                                <th>City</th>
                                                <th>Submitted From</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ================= ADD TAB ================= -->
                        <div class="tab-pane fade" id="addEnquiry" role="tabpanel">
                            <div class="card-body">
                                <form id="enquiryForm" method="POST" class="needs-validation" novalidate>
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Product Name <span
                                                    class="text-danger">*</span></label>
                                            <select name="pro_name" id="productSelect" class="form-select" required>
                                                <option value="">Select Product</option>

                                                @foreach ($product_data as $product)
                                                    <option value="{{ $product->pro_name }}"
                                                        data-model="{{ $product->pro_model ?? '' }}"
                                                        data-sku="{{ $product->pro_sku ?? '' }}">
                                                        {{ $product->pro_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Select Product.</div>
                                        </div>

                                        <!-- Model Number -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Model Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="model_number" id="modelNumber"
                                                class="form-control" placeholder="Enter Model Number" required>
                                            <div class="invalid-feedback">Model Number is required.</div>
                                        </div>

                                        {{-- <div class="col-md-4 mb-3">
                                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                                            <input type="text" name="sku" id="skuField" class="form-control"
                                                placeholder="Enter SKU" required>
                                            <div class="invalid-feedback">SKU is required.</div>
                                        </div> --}}


                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter full name" required>
                                            <div class="invalid-feedback">Name is required.</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Enter email address" required>
                                            <div class="invalid-feedback">Enter a valid email.</div>

                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                Mobile <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="mobile" class="form-control" id="mobile"
                                                placeholder="Enter mobile number" maxlength="10" pattern="[0-9]{10}"
                                                required>

                                            <div class="invalid-feedback">
                                                Please Enter Valid 10 Digit Mobile Number.
                                            </div>
                                        </div>


                                        <div class="col-md-3 mb-3">
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

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">State <span class="text-danger">*</span></label>
                                            <select class="form-select" name="state" id="state_id" required
                                                disabled>
                                                <option value="">Select State</option>
                                            </select>
                                            <div class="invalid-feedback">State is required</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">City <span class="text-danger">*</span></label>
                                            <select class="form-select" name="city" id="city_id" required
                                                disabled>
                                                <option value="">Select City</option>
                                            </select>
                                            <div class="invalid-feedback">City is required</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                Price Range <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <input type="number" name="price_from" class="form-control"
                                                    placeholder="500000" min="0" required>

                                                <span class="input-group-text">-</span>

                                                <input type="number" name="price_to" class="form-control"
                                                    placeholder="700000" min="0" required>
                                            </div>

                                            <div class="invalid-feedback">
                                                Please Enter Valid Price Range.
                                            </div>
                                        </div>


                                        <!-- Year Preference Range -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">
                                                Year Preference Range <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">

                                                <input type="text" name="year_from"
                                                    class="form-control year-input" placeholder="2020" maxlength="4"
                                                    pattern="[0-9]{4}" required>

                                                <span class="input-group-text">-</span>

                                                <input type="text" name="year_to" class="form-control year-input"
                                                    placeholder="2024" maxlength="4" pattern="[0-9]{4}" required>

                                            </div>

                                            <div class="invalid-feedback">
                                                Please Enter Valid Year Range.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Message <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="message" class="form-control" placeholder="Write your message" required></textarea>
                                            <div class="invalid-feedback">Message is required.</div>
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <span class="btn-text">Save Enquiry</span>
                                            <span class="spinner-border spinner-border-sm d-none"
                                                role="status"></span>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewEnquiryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title">Product Enquiry Details</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row mb-4" id="enquiryDetailsArea"></div>
                        <hr>
                        <h6 class="fw-bold mb-3"><i class="bx bx-list-plus me-1"></i> Add Follow-up</h6>
                        <form id="prodFollowupForm">
                            @csrf
                            <input type="hidden" name="enquiry_id" id="modal_enquiry_id">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-7">
                                    <textarea name="note" id="f_note" class="form-control" rows="2" placeholder="Enter note..." required></textarea>
                                </div>

                                <div class="col-md-3">
                                    <select name="curr_status" id="f_status" class="form-select select2-modal"
                                        required>
                                        <option value="">Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive mt-4">
                            <table class="table table-sm table-bordered w-100" id="prodFollowupTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Note</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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

            // ✅ Only numbers allow
            $(document).on('input', '#mobile', function() {

                this.value = this.value.replace(/[^0-9]/g, '');

                // limit 10 digit
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

            // ✅ Custom validation
            $(document).on('blur', '#mobile', function() {

                let mobile = $(this).val();

                if (mobile.length !== 10) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            $('#addEnquiryTab').on('shown.bs.tab', function() {
                $('#exportWrapper').addClass('d-none');
            });

            $('#listEnquiryTab').on('shown.bs.tab', function() {
                $('#exportWrapper').removeClass('d-none');
            });
            const table = $('#prodEnquiryTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,

                ajax: {
                    url: "{{ route('product.enquiry.data') }}"
                },

                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'last_followup'
                    },
                    {
                        data: 'product'
                    },
                    {
                        data: 'city'
                    },
                    {
                        data: 'from_panel'
                    }
                ],

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

                buttons: [
                    @if (routePermission(session('current_page_route') ?? '', 'export'))
                        {
                            extend: 'copyHtml5',
                            text: '<i class="bx bx-copy"></i> Copy',
                            className: 'dt-btn-light',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },

                        {
                            extend: 'csvHtml5',
                            text: '<i class="bx bx-file"></i> Export to CSV',
                            className: 'dt-btn-light',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },

                        {
                            extend: 'excelHtml5',
                            text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                            className: 'dt-btn-light',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },

                        {
                            extend: 'print',
                            text: '<i class="bx bx-printer"></i> Print',
                            className: 'dt-btn-light',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },



                        {
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
                        },
                    @endif {
                        extend: 'colvis',
                        text: '<i class="bx bx-columns"></i> Column visibility',
                        className: 'dt-btn-light'
                    }
                ]
            });

            $('#refreshTable').on('click', function() {

                let btn = $(this);

                // 🔄 Add spinning effect
                btn.find('i').addClass('bx-spin');

                // 🔄 Reload DataTable
                table.ajax.reload(null, false);

                // ⏳ Stop spin after reload
                setTimeout(() => {
                    btn.find('i').removeClass('bx-spin');
                }, 800);

            });

            $('.select2-modal').select2({
                dropdownParent: $('#viewEnquiryModal'),
                width: '100%'
            });
            $(document).on('click', '.viewEnquiry', function() {
                const id = $(this).data('id');
                $('#modal_enquiry_id').val(id);
                let url = "{{ route('product.enquiry.show', ':id') }}".replace(':id', id);

                $.get(url, function(res) {
                    if (res.status === 200) {
                        const d = res.data;

                        const priceRange = d.price_range || 'N/A';
                        const yearPreference = d.year_range || 'N/A';

                        $('#enquiryDetailsArea').html(`
                <div class="col-md-5 border-end">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-user fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Customer Name</p>
                            <p class="fw-semibold mb-0">${d.name}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-envelope fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Email Address</p>
                            <p class="fw-semibold mb-0">${d.email}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-phone fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Mobile Number</p>
                            <p class="fw-semibold mb-0">${d.mobile}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-purchase-tag fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Product Name</p>
                            <p class="fw-semibold mb-0">${d.product_name}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-barcode fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Model / SKU</p>
                            <p class="fw-semibold mb-0">${d.model_number || 'N/A'} / ${d.sku || 'N/A'}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-money fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Price Range</p>
                            <p class="fw-semibold mb-0">${priceRange}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-calendar fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Year Preference Range</p>
                            <p class="fw-semibold mb-0">${yearPreference}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="bx bx-map-pin fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">City</p>
                            <p class="fw-semibold mb-0">${d.city || 'N/A'}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 ps-md-4 mt-3 mt-md-0">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bx bx-message-detail fs-4 text-primary me-2"></i>
                        <h6 class="fw-bold mb-0">Enquiry Message</h6>
                    </div>
                    <div class="p-3 bg-light rounded border-start border-primary border-4 shadow-sm"
                         style="height: 23rem; overflow-y: auto; background-color: #fcfcfc !important;">
                        <p class="text-dark mb-0" style="line-height: 1.6; white-space: pre-wrap;">${d.message || 'N/A'}</p>
                    </div>
                </div>
            `);

                        loadFollowups(id);
                        $('#viewEnquiryModal').modal('show');
                    }
                });
            });

            function loadFollowups(id) {
                let url = "{{ route('product.followup.list', ':id') }}".replace(':id', id);
                $.get(url, function(res) {
                    let html = '';
                    res.data.forEach(r => {
                        html +=
                            `<tr><td>${r.note}</td><td>${r.status}</td><td>${r.datetime}</td><td class="text-center">${r.action}</td></tr>`;
                    });
                    $('#prodFollowupTable tbody').html(html ||
                        '<tr><td colspan="4" class="text-center">No history</td></tr>');
                });
            }

            $('#prodFollowupForm').on('submit', function(e) {
                e.preventDefault();
                $.post("{{ route('product.followup.store') }}", $(this).serialize(), function() {
                    iziToast.success({
                        title: 'Success',
                        message: 'FollowUp added successfully',
                        position: 'topRight'
                    });
                    table.ajax.reload(null, false);
                    $('#f_note').val('');
                    $('#f_status').val(null).trigger('change');
                    loadFollowups($('#modal_enquiry_id').val());
                });
            });

            $(document).on('click', '.deleteProdFollowup', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Delete FollowUpnote?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) $.post("{{ route('product.followup.delete') }}", {
                        _token: "{{ csrf_token() }}",
                        id: id
                    }, function() {
                        loadFollowups($('#modal_enquiry_id').val());
                    });
                });
            });

            $(document).on('click', '.deleteEnquiry', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to remove this product enquiry.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('product.enquiry.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(res) {
                                if (res.success) {
                                    iziToast.success({
                                        title: 'Deleted',
                                        message: res.message,
                                        position: 'topRight'
                                    });
                                    // Reload the main table
                                    $('#prodEnquiryTable').DataTable().ajax.reload(null,
                                        false);
                                }
                            },
                            error: function() {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Failed to delete enquiry.',
                                    position: 'topRight'
                                });
                            }
                        });
                    }
                });
            });

            //Product Enquiry Add
            $('#productSelect').select2({
                placeholder: "Select Product",
                allowClear: true,
                width: '100%',
                tags: true, // ✅ allow manual input
                createTag: function(params) {

                    let term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
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

            $('#productSelect').on('change', function() {

                let selected = $(this).find(':selected');

                let model = selected.data('model') || '';
                let sku = selected.data('sku') || '';

                $('#modelNumber').val(model);
                $('#skuField').val(sku);

            });

            $('#enquiryForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('#submitBtn');

                // Bootstrap validation
                if (!this.checkValidity()) {
                    form.addClass('was-validated');
                    return;
                }

                let formData = form.serialize();

                // 🔄 Start Loading
                btn.prop('disabled', true);
                btn.find('.btn-text').text('Saving...');
                btn.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: "{{ route('enquiry.store') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },

                    success: function(response) {

                        if (response.status) {

                            form[0].reset();
                            form.removeClass('was-validated');

                            $('#listEnquiryTab').tab('show');


                            table.ajax.reload(null, false);

                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },

                    error: function(xhr) {

                        let errors = xhr.responseJSON.errors;

                        $('.is-invalid').removeClass('is-invalid');

                        $.each(errors, function(key, value) {
                            let input = $('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').text(value[0]);
                        });

                        iziToast.error({
                            title: 'Error',
                            message: 'Please fix the errors and try again.',
                            position: 'topRight'
                        });
                    },

                    complete: function() {
                        // 🔄 Stop Loading (always runs)
                        btn.prop('disabled', false);
                        btn.find('.btn-text').text('Save Enquiry');
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });

            });




            //Export Data
            $('#exportEnquiryBtn').on('click', function() {

                let btn = $(this);

                // 🔄 Start spinner
                btn.prop('disabled', true);
                btn.find('.btn-text').text('Exporting...');
                btn.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: "{{ route('enquiry.export') }}",
                    method: "GET",
                    xhrFields: {
                        responseType: 'blob' // important
                    },

                    success: function(data) {

                        let blob = new Blob([data], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });

                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "product_enquiry.xlsx";
                        link.click();

                        iziToast.success({
                            title: 'Success',
                            message: 'Export completed',
                            position: 'topRight'
                        });
                    },

                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Export failed',
                            position: 'topRight'
                        });
                    },

                    complete: function() {
                        // 🔄 Stop spinner
                        btn.prop('disabled', false);
                        btn.find('.btn-text').html('<i class="bx bx-export"></i> Export');
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });

            });


        });
    </script>
</body>

</html>
