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
            <h4 class="fw-medium mb-0">Contact-Us</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Front Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact List</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-body" style="padding: 1rem !important;">
                                <div class="d-flex justify-content-end gap-2 mb-3">
                                    <!-- Refresh Button -->
                                    <button type="button" id="refreshTable" class="btn btn-primary">
                                        <i class="bx bx-refresh"></i> Refresh
                                    </button>

                                    <!-- Export Button -->
                                    <button type="button" id="exportTable" class="btn btn-success">
                                        <i class="bx bx-export"></i> Export
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap w-100" id="contactTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">Action</th>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Last Follow Up</th>
                                                <th>Country</th>
                                                <th>City</th>
                                                <th>Store</th>
                                                <th>Message</th>

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

        <div class="modal fade" id="viewContactModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title">Contact Inquiry Details</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row mb-4" id="contactDetailsArea"></div>

                        <hr>

                        <h6 class="fw-bold mb-3"><i class="bx bx-list-plus me-1"></i> Add Follow-up Note</h6>
                        <form id="followupForm">
                            @csrf
                            <input type="hidden" name="contact_id" id="followup_contact_id">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-7">
                                    <label class="small text-muted">
                                        Follow-up Note <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="note" id="followup_note" class="form-control" rows="2" placeholder="Enter note here..."></textarea>
                                </div>

                                <div class="col-md-3">
                                    <label class="small text-muted">Status <span class="text-danger">*</span></label>
                                    <select name="curr_status" id="followup_status" class="form-select select2-modal">
                                        <option value="">Select Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100"
                                        id="updateFollowupBtn">Update</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table table-sm table-bordered w-100" id="followupTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Note</th>
                                        <th>Status</th>
                                        <th>Date & Time</th>
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
            const contactTable = $('#contactTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,

                ajax: {
                    url: "{{ route('contact.list.data') }}"
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
                        data: 'country'
                    },
                    {
                        data: 'city'
                    },
                    {
                        data: 'store'
                    },
                    {
                        data: 'message'
                    }
                ],

                columnDefs: [{
                    targets: '_all',
                    className: 'text-start align-middle'
                }],

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],

                dom: "<'row mb-3 align-items-center'\
                                                <'col-lg-2 col-md-3 d-flex align-items-center'l>\
                                                <'col-lg-7 col-md-6 d-flex justify-content-center'B>\
                                                <'col-lg-3 col-md-3 d-flex justify-content-end'f>\
                                            >" +
                    "rtip",

                buttons: [{
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
                        extend: 'colvis',
                        text: '<i class="bx bx-columns"></i> Column visibility',
                        className: 'dt-btn-light'
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

                            if (doc.content[1] && doc.content[1].table) {
                                doc.content[1].table.widths =
                                    Array(doc.content[1].table.body[0].length).fill('*');
                            }
                        }
                    }
                ]
            });

            $('#refreshTable').on('click', function() {

                let btn = $(this);

                // 🔄 Add spinning effect
                btn.find('i').addClass('bx-spin');

                // 🔄 Reload DataTable
                contactTable.ajax.reload(null, false);

                // ⏳ Stop spin after reload
                setTimeout(() => {
                    btn.find('i').removeClass('bx-spin');
                }, 800);

            });

            $('.select2-modal').select2({
                dropdownParent: $('#viewContactModal'),
                width: '100%'
            });

            // View Handler
            $(document).on('click', '.viewContact', function() {
                const id = $(this).data('id');
                $('#followupForm')[0].reset();
                $('#followup_contact_id').val(id);
                $('#followup_status').val(null).trigger('change');
                let url = "{{ route('contact.show', ':id') }}";
                url = url.replace(':id', id);

                $.get(url, function(res) {
                    if (res.status === 200) {
                        const d = res.data;
                        const formattedDate = d.date;

                        let html = `
                <div class="col-md-5 border-end">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-user fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Full Name</p>
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
                        <i class="bx bx-calendar fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Inquiry Date</p>
                            <p class="fw-semibold mb-0">${formattedDate}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bx-map-pin fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Location</p>
                            <p class="fw-semibold mb-0">${d.city}, ${d.country}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bx bx-store fs-4 text-primary me-2"></i>
                        <div>
                            <p class="text-muted small mb-0">Preferred Store</p>
                            <p class="fw-semibold mb-0">${d.store}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 ps-md-4 mt-3 mt-md-0">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bx bx-message-detail fs-4 text-primary me-2"></i>
                        <h6 class="fw-bold mb-0">Customer Message</h6>
                    </div>
                    <div class="p-3 bg-light rounded border-start border-primary border-4 shadow-sm"
                         style="height: 250px; overflow-y: auto; background-color: #fcfcfc !important;">
                        <p class="text-dark mb-0" style="line-height: 1.6; white-space: pre-wrap;">${d.message}</p>
                    </div>
                </div>
            `;
                        $('#contactDetailsArea').html(html);
                        loadFollowupList(id);
                        $('#viewContactModal').modal('show');
                    }
                });
            });

            function loadFollowupList(contactId) {
                let url = "{{ route('contact.followup.list', ':id') }}";
                url = url.replace(':id', contactId);

                $.get(url, function(res) {
                    let html = '';
                    res.data.forEach(row => {
                        html += `<tr>
                    <td>${row.note}</td>
                    <td>${row.status}</td>
                    <td>${row.datetime}</td>
                    <td class="text-center">${row.action}</td>
                </tr>`;
                    });
                    $('#followupTable tbody').html(html ||
                        '<tr><td colspan="4" class="text-center">No follow-ups found</td></tr>');
                });
            }

            $('#followupForm').on('submit', function(e) {
                e.preventDefault();
                if (!$('#followup_note').val() || !$('#followup_status').val()) {
                    iziToast.error({
                        title: 'Validation',
                        message: 'Note and Status are required',
                        position: 'topRight'
                    });
                    return;
                }

                $.post("{{ route('contact.followup.store') }}", $(this).serialize(), function(res) {
                    iziToast.success({
                        title: 'Success',
                        message: res.message,
                        position: 'topRight'
                    });
                    contactTable.ajax.reload();
                    $('#followup_note').val('');
                    $('#followup_status').val(null).trigger('change');
                    loadFollowupList($('#followup_contact_id').val());
                });
            });

            $(document).on('click', '.deleteFollowup', function() {
                const id = $(this).data('id');
                const contactId = $('#followup_contact_id').val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to remove this follow-up note.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('contact.followup.delete') }}", {
                            _token: "{{ csrf_token() }}",
                            id: id
                        }, function(res) {
                            if (res.success) {
                                iziToast.success({
                                    title: 'Deleted',
                                    message: res.message,
                                    position: 'topRight'
                                });
                                loadFollowupList(contactId);
                            }
                        }).fail(function() {
                            iziToast.error({
                                title: 'Error',
                                message: 'Failed to delete follow-up note.',
                                position: 'topRight'
                            });
                        });
                    }
                });
            });

            // Delete Handler
            $(document).on('click', '.deleteContact', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to remove this contact entry.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('contact.delete') }}", {
                            _token: "{{ csrf_token() }}",
                            id: id
                        }, function(res) {
                            Swal.fire('Deleted!', res.message, 'success');
                            contactTable.ajax.reload();
                        });
                    }
                });
            });

            // Export button click using AJAX redirect
            $(document).on('click', '#exportTable', function() {
                let $btn = $(this);

                // Prevent double click
                if ($btn.prop('disabled')) {
                    return;
                }

                // Add spinner + disable button
                $btn.prop('disabled', true);
                $btn.html(`
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
        Exporting...
    `);

                // Start download
                window.location.href = "{{ route('contact.export') }}";

                // Re-enable after few seconds (because download response won't trigger ajax complete)
                setTimeout(function() {
                    $btn.prop('disabled', false);
                    $btn.html(`
            <i class="bx bx-export"></i> Export
        `);
                }, 3000);
            });
        });
    </script>
</body>

</html>
