<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">
@include('partials.header_link')
<style>
    /* Custom styles for better UI */
    .filter-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    .filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .filter-control {
        border-radius: 10px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .filter-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .btn-view {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border: none;
        border-radius: 10px;
        padding: 8px 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        height: 38px;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
    }

    .date-range-wrapper {
        position: relative;
    }

    .date-range-wrapper i {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        pointer-events: none;
        z-index: 4;
    }

    #CustomerDateRange {
        background-color: white;
        cursor: pointer;
        padding-right: 35px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        height: 38px;
    }

    .badge-filter {
        background: linear-gradient(145deg, #e9ecef, #dee2e6);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        color: #495057;
    }

    .table thead th {
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
        transition: all 0.3s ease;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }

    .modal-header {

        padding: 15px 20px;
    }

    .invoice-details-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .info-row {
        display: flex;
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px dashed #dee2e6;
    }

    .info-label {
        font-weight: 600;
        width: 120px;
        color: #495057;
    }

    .info-value {
        color: #212529;
        flex: 1;
    }

    .table-invoice-products {
        border-radius: 15px;
        overflow: hidden;
    }

    .table-invoice-products thead {
        background: linear-gradient(145deg, #e9ecef, #dee2e6);
    }




    .summary-card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .summary-item {
        text-align: center;
        padding: 15px;
        border-right: 1px solid #e9ecef;
    }

    .summary-item:last-child {
        border-right: none;
    }

    .summary-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4e73df;
    }

    @media (max-width: 768px) {
        .summary-item {
            border-right: none;
            border-bottom: 1px solid #e9ecef;
            padding: 10px;
        }

        .summary-item:last-child {
            border-bottom: none;
        }
    }
</style>

<body>
    @include('partials.switcher')
    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">Invoice Report</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Report</a></li>
                <li class="breadcrumb-item active" aria-current="page">Invoice Report</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="summary-card">
                                    <div class="row g-0">
                                        <div class="col-md-3 col-6 summary-item">
                                            <div class="summary-label">Total Invoices</div>
                                            <div class="summary-value" id="totalInvoices">0</div>
                                        </div>
                                        <div class="col-md-3 col-6 summary-item">
                                            <div class="summary-label">Store Invoices</div>
                                            <div class="summary-value" id="storeInvoices">0</div>
                                        </div>
                                        <div class="col-md-3 col-6 summary-item">
                                            <div class="summary-label">Online Invoices</div>
                                            <div class="summary-value" id="onlineInvoices">0</div>
                                        </div>
                                        <div class="col-md-3 col-6 summary-item">
                                            <div class="summary-label">Total Amount</div>
                                            <div class="summary-value" id="totalAmount">0.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card filter-card">
                                <div class="card-body p-4">
                                    <div class="row align-items-end g-3">
                                        <!-- Invoice Type -->
                                        <div class="col-lg-2 col-md-4">
                                            <div class="filter-label">
                                                <i class="bx bx-receipt me-1"></i>Invoice Type
                                            </div>
                                            <select id="saleFilter" class="form-select filter-control select2">
                                                <option value="">All Invoices</option>
                                                <option value="store">Store Invoice</option>
                                                <option value="online">Online Invoice</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 col-md-4 d-none" id="locationFilterWrapper">
                                            <div class="filter-label">
                                                <i class="bx bx-map me-1"></i>Store Location
                                            </div>

                                            <select id="locationFilter" class="form-select filter-control select2">
                                                <option value="">All Locations</option>
                                            </select>
                                        </div>

                                        <!-- Period Preset -->
                                        <div class="col-lg-2 col-md-4">
                                            <div class="filter-label">
                                                <i class="bx bx-calendar me-1"></i>Quick Period
                                            </div>
                                            <select id="dateRangePreset" class="form-select filter-control select2">
                                                <option value="" selected>Select Period</option>
                                                <option value="today">Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="last_7_days">Last 7 Days</option>
                                                <option value="this_week">This Week</option>
                                                <option value="previous_week">Previous Week</option>
                                                <option value="this_month">This Month</option>
                                                <option value="previous_month">Previous Month</option>
                                                <option value="this_quarter">This Quarter</option>
                                                <option value="previous_quarter">Previous Quarter</option>
                                                <option value="this_year">This Year</option>
                                                <option value="previous_year">Previous Year</option>
                                                <option value="custom">Custom Range</option>
                                            </select>
                                        </div>

                                        <!-- Date Range -->
                                        <div class="col-lg-4 col-md-8">
                                            <div class="filter-label">
                                                <i class="bx bx-calendar-week me-1"></i>Date Range
                                            </div>
                                            <div class="date-range-wrapper">
                                                <input type="text" id="CustomerDateRange"
                                                    class="form-control filter-control"
                                                    placeholder="DD-MM-YYYY to DD-MM-YYYY" readonly>
                                                <i class="bx bx-calendar"></i>
                                            </div>
                                        </div>

                                        <!-- Filter Buttons -->
                                        <div class="col-lg-2 col-md-4">
                                            <button id="filterBtn" class="btn btn-view w-100 text-white">
                                                <i class="bx bx-search me-2"></i>Apply Filters
                                            </button>
                                        </div>

                                        <div class="col-lg-2 col-md-4">
                                            <button id="resetBtn" class="btn btn-light w-100">
                                                <i class="bx bx-reset me-2"></i>Reset
                                            </button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover w-100" id="invoiceReportTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Invoice No</th>
                                        <th width="15%">Customer Name</th>
                                        <th width="12%">Mobile</th>
                                        <th width="15%">Email</th>
                                        <th width="10%">Total</th>
                                        <th width="10%">Bill Date</th>
                                        <th width="8%">Type</th>
                                        <th width="8%">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="invoiceReportModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title d-flex align-items-center">
                            <i class="bx bx-receipt me-2"></i> Invoice Details
                        </h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4" id="printArea">
                        <div id="quickSaleDetailsContent"></div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>
    @include('partials.footer_link')

    <script>
        $(document).ready(function() {

            // Initialize date range picker
            let selectedStart = null,
                selectedEnd = null;

            $('#saleFilter').select2({
                placeholder: "Select Invoice Type",
                allowClear: true,
                width: "100%"
            });

            $('#dateRangePreset').select2({
                placeholder: "Select Date Range",
                allowClear: true,
                width: "100%"
            });

            $('#locationFilter').select2({
                placeholder: "Select Location",
                allowClear: true,
                width: "100%"
            });

            $('#saleFilter').on('change', function() {

                let type = $(this).val();

                if (type === 'store') {
                    $('#locationFilterWrapper').removeClass('d-none');
                    loadStoreLocations(); // fetch locations
                } else {
                    $('#locationFilterWrapper').addClass('d-none');
                    $('#locationFilter').val('').trigger('change');
                }

                updateActiveFilters();
                table.ajax.reload();
            });


            function loadStoreLocations() {

                $.ajax({
                    url: "{{ route('invoice.store.locations') }}",
                    type: "GET",
                    success: function(res) {

                        let options = '<option value="">All Locations</option>';

                        res.forEach(function(loc) {
                            options += `<option value="${loc.bl_id}">
                                ${loc.name}
                            </option>`;
                        });

                        $('#locationFilter').html(options).trigger('change');
                    }
                });
            }

            let fp = flatpickr("#CustomerDateRange", {
                mode: "range",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                allowInput: true,
                placeholder: "DD-MM-YYYY to DD-MM-YYYY",
                defaultDate: null,
                onReady: function(selectedDates, dateStr, instance) {
                    instance.clear();
                },
                onChange: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        selectedStart = selectedDates[0];
                        selectedEnd = selectedDates[1];
                        updateActiveFilters();
                    } else {
                        selectedStart = null;
                        selectedEnd = null;
                    }
                }
            });

            // Handle period preset change
            $('#dateRangePreset').on('change', function() {
                const value = $(this).val();

                if (value === 'custom') {
                    fp.open();
                    return;
                }

                if (!value) {
                    fp.clear();
                    selectedStart = null;
                    selectedEnd = null;
                    updateActiveFilters();
                    return;
                }

                const today = new Date();
                let start, end;

                switch (value) {
                    case 'today':
                        start = end = new Date();
                        break;

                    case 'yesterday':
                        start = new Date();
                        start.setDate(start.getDate() - 1);
                        end = new Date(start);
                        break;

                    case 'last_7_days':
                        end = new Date();
                        start = new Date();
                        start.setDate(start.getDate() - 6);
                        break;

                    case 'this_week':
                        start = new Date(today);
                        start.setDate(today.getDate() - today.getDay());
                        end = new Date(today);
                        break;

                    case 'previous_week':
                        start = new Date(today);
                        start.setDate(today.getDate() - today.getDay() - 7);
                        end = new Date(start);
                        end.setDate(start.getDate() + 6);
                        break;

                    case 'this_month':
                        start = new Date(today.getFullYear(), today.getMonth(), 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        break;

                    case 'previous_month':
                        start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        end = new Date(today.getFullYear(), today.getMonth(), 0);
                        break;

                    case 'this_quarter':
                        const currentQuarter = Math.floor(today.getMonth() / 3);
                        start = new Date(today.getFullYear(), currentQuarter * 3, 1);
                        end = new Date(today.getFullYear(), (currentQuarter * 3) + 3, 0);
                        break;

                    case 'previous_quarter':
                        const prevQuarter = Math.floor(today.getMonth() / 3) - 1;
                        start = new Date(today.getFullYear(), prevQuarter * 3, 1);
                        end = new Date(today.getFullYear(), (prevQuarter * 3) + 3, 0);
                        break;

                    case 'this_year':
                        start = new Date(today.getFullYear(), 0, 1);
                        end = new Date(today.getFullYear(), 11, 31);
                        break;

                    case 'previous_year':
                        start = new Date(today.getFullYear() - 1, 0, 1);
                        end = new Date(today.getFullYear() - 1, 11, 31);
                        break;

                    default:
                        return;
                }

                selectedStart = start;
                selectedEnd = end;
                fp.setDate([start, end], true);
                updateActiveFilters();
            });

            // Update active filters display
            function updateActiveFilters() {
                // Update type filter display
                const typeVal = $('#saleFilter').val();
                const typeText = $('#saleFilter option:selected').text();
                $('#activeType').text(typeVal ? typeText : 'All Types');

                // Update date filter display
                if (selectedStart && selectedEnd) {
                    const startFormatted = formatDate(selectedStart);
                    const endFormatted = formatDate(selectedEnd);
                    $('#activeDate').text(`${startFormatted} to ${endFormatted}`);
                } else {
                    $('#activeDate').text('All Dates');
                }
            }

            // Format date helper
            function formatDate(date) {
                const d = new Date(date);
                return `${d.getDate().toString().padStart(2, '0')}-${(d.getMonth()+1).toString().padStart(2, '0')}-${d.getFullYear()}`;
            }

            // Initialize DataTable with server-side processing
            var table = $('#invoiceReportTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('invoice.report.list') }}",
                    data: function(d) {
                        d.sale_type = $('#saleFilter').val();
                        d.location_id = $('#locationFilter').val();
                        d.start_date = selectedStart ? formatDateForServer(selectedStart) : '';
                        d.end_date = selectedEnd ? formatDateForServer(selectedEnd) : '';

                    },
                    dataSrc: function(json) {
                        // Update summary cards
                        if (json.summary) {
                            $('#totalInvoices').text(json.summary.total || 0);
                            $('#storeInvoices').text(json.summary.store || 0);
                            $('#onlineInvoices').text(json.summary.online || 0);
                            $('#totalAmount').text(
                                parseFloat(json.summary.amount || 0)
                                .toLocaleString('en-IN', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })
                            );
                        }
                        return json.data;
                    }
                },
                dom: "<'row mb-2 align-items-center'" +
                    "<'col-lg-2 col-md-3'l>" +
                    "<'col-lg-7 col-md-6 text-center'B>" +
                    "<'col-lg-3 col-md-3 text-end'f>" +
                    ">" +
                    "rtip",

                buttons: [

                    // COPY → remove image column (index 1)
                    {
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },

                    // CSV → include image column (URL)
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            orthogonal: 'export'
                        }
                    },

                    // EXCEL → include image column (URL)
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            orthogonal: 'export'
                        }
                    },

                    // PRINT → remove image column
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',

                    },

                    //COLUMN VISIBILITY (keep image controllable in UI)
                    {
                        extend: 'colvis',
                        text: '<i class="bx bx-columns"></i> Column visibility',
                        className: 'dt-btn-light'
                    },

                    // PDF → remove image column
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bx bx-file-blank"></i> Export to PDF',
                        className: 'dt-btn-light',
                        orientation: 'landscape',
                        pageSize: 'A4',

                        customize: function(doc) {
                            doc.pageMargins = [10, 10, 10, 10];
                            var table = doc.content[1].table;
                            table.widths = Array(table.body[0].length).fill('*');
                        }
                    }
                ],
                columns: [{
                        data: 'sr_no'
                    },
                    {
                        data: 'invoice_num'
                    },
                    {
                        data: 'fullname'
                    },
                    {
                        data: 'mobile_num'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'final_total',
                        className: 'text-end fw-bold',
                        render: function(data) {
                            return '₹ ' + data;
                        }
                    },
                    {
                        data: 'bill_date'
                    },
                    {
                        data: 'sale_type',
                        render: function(data) {
                            if (data === 'store') {
                                return '<span class="badge bg-success-light text-success"><i class="bx bx-store me-1"></i>Store</span>';
                            } else {
                                return '<span class="badge bg-info-light text-info"><i class="bx bx-globe me-1"></i>Online</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [6, 'desc']
                ],
                pageLength: 10,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    search: '<i class="bx bx-search"></i>',
                    searchPlaceholder: 'Search invoices...'
                }
            });

            // Apply filter button click
            $('#filterBtn').on('click', function() {
                table.ajax.reload();
            });

            // Reset all filters
            $('#resetBtn').on('click', function() {
                $('#saleFilter').val('').trigger('change');
                $('#dateRangePreset').val('').trigger('change');
                fp.clear();
                selectedStart = null;
                selectedEnd = null;
                updateActiveFilters();
                table.ajax.reload();
            });

            // Auto reload on filter change
            $('#saleFilter').on('change', function() {
                updateActiveFilters();
                table.ajax.reload();
            });

            // Format date for server
            function formatDateForServer(date) {
                const d = new Date(date);
                return `${d.getFullYear()}-${(d.getMonth()+1).toString().padStart(2, '0')}-${d.getDate().toString().padStart(2, '0')}`;
            }

            function indianMoney(val) {
                return parseFloat(val || 0).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // View invoice details
            $(document).on('click', '.viewInvoice', function() {
                let id = $(this).data('id');
                let type = $(this).data('type');

                let url = "{{ route('invoice.report.show', ['type' => 'TYPE', 'id' => 'ID']) }}"
                    .replace('TYPE', type)
                    .replace('ID', id);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(res) {
                        let sale = res.sale;
                        let products = res.products;

                        let productRows = '';
                        let subtotal = 0;

                        products.forEach((p, i) => {
                            subtotal += parseFloat(p.total_price);
                            productRows += `
                                <tr>
                                    <td class="text-center">${i+1}</td>
                                    <td>${p.product_name}</td>
                                    <td class="text-center">${p.hsn_code ?? '-'}</td>
                                    <td class="text-center">${p.qty}</td>
      <td class="text-end">₹ ${indianMoney(p.price)}</td>
<td class="text-end">₹ ${indianMoney(p.total_price)}</td>
                                </tr>`;
                        });

                        let customerName = sale.full_name ||
                            (sale.shipping_first_name && sale.shipping_last_name ?
                                `${sale.shipping_first_name} ${sale.shipping_last_name}` : 'N/A'
                            );

                        let html = `
                            <div class="invoice-details-card">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Invoice Information</h5>
                                        <div class="info-row">
                                            <span class="info-label">Invoice No:</span>
                                            <span class="info-value fw-bold text-primary">${sale.invoice_no ?? sale.invoice_num}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Invoice Type:</span>
                                            <span class="info-value">
                                                ${sale.sale_type === 'store' ?
                                                    '<span class="badge bg-success">Store Invoice</span>' :
                                                    '<span class="badge bg-info">Online Invoice</span>'}
                                            </span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Bill Date:</span>
                                            <span class="info-value">${sale.bill_date || sale.sale_date || sale.order_date}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Customer Details</h5>
                                        <div class="info-row">
                                            <span class="info-label">Name:</span>
                                            <span class="info-value">${customerName}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Mobile:</span>
                                            <span class="info-value">${sale.mobile_no || sale.shipping_phone || 'N/A'}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Email:</span>
                                            <span class="info-value">${sale.email || sale.shipping_email || 'N/A'}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mb-3">Products Details</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-invoice-products">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="40%">Product</th>
                                            <th width="10%">HSN</th>
                                            <th width="10%">Qty</th>
                                            <th width="15%">Price</th>
                                            <th width="15%">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${productRows}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end fw-bold">Subtotal:</td>
  <td class="text-end fw-bold">
    ₹ ${indianMoney(subtotal)}
</td>
                                      </tr>

${sale.discount_amount ? `
        <tr>
            <td colspan="5" class="text-end">Discount:</td>
            <td class="text-end text-danger">
                - ₹ ${indianMoney(sale.discount_amount)}
            </td>
        </tr>
        ` : ''}

${sale.tax_amount ? `
        <tr>
            <td colspan="5" class="text-end">Tax:</td>
            <td class="text-end">
                + ₹ ${indianMoney(sale.tax_amount)}
            </td>
        </tr>
        ` : ''}

                                        <tr class="table-primary">
                                            <td colspan="5" class="text-end fw-bold">Grand Total:</td>
     <td class="text-end fw-bold text-primary">
    ₹ ${indianMoney(sale.final_total || sale.grand_total)}
</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        `;

                        $('#quickSaleDetailsContent').html(html);
                        $('#invoiceReportModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Error loading invoice details');
                    }
                });
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add custom CSS for DataTables buttons
            $('.dt-buttons').addClass('mb-3').find('button').addClass('me-2');
        });
    </script>
</body>

</html>
