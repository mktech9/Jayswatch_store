<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">
@include('partials.header_link')

<body>
    @include('partials.switcher')
    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <!-- Page Header -->
        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">
                <i class="bx bx-package me-2"></i>Inventory Report
            </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventory Report</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card custom-card summary-card bg-primary-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-lg bg-white bg-opacity-50 rounded-circle">
                                            <i class="bx bx-package fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Total Products</p>
                                        <h3 class="text-white mb-0 fw-bold" id="totalProducts">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card custom-card summary-card bg-success-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-lg bg-white bg-opacity-25 rounded-circle">
                                            <i class="bx bx-cart fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Total Units Sold</p>
                                        <h3 class="text-white mb-0 fw-bold" id="totalUnitsSold">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card custom-card summary-card bg-warning-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-lg bg-white bg-opacity-25 rounded-circle">
                                            <i class="bx bx-rupee fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Total Sales Value</p>
                                        <h3 class="text-white mb-0 fw-bold" id="totalSalesValue">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card custom-card summary-card bg-info-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-lg bg-white bg-opacity-25 rounded-circle">
                                            <i class="bx bx-store fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Active Brands</p>
                                        <h3 class="text-white mb-0 fw-bold" id="totalBrands">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Card -->
                <div class="card custom-card filter-card mb-4">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="bx bx-filter me-2"></i>Filter Inventory
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end g-3">
                            <!-- Store Selection -->
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-store me-1"></i>Select Store
                                </label>
                                <select name="store_id" id="store_id" class="form-select select2">
                                    <option value="">All Stores</option>
                                    @foreach ($store_data as $store)
                                        <option value="{{ $store->bl_id }}">
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Period Preset -->
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-calendar me-1"></i>Quick Period
                                </label>
                                <select id="dateRangePreset" class="form-select select2">
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
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-calendar-week me-1"></i>Date Range
                                </label>
                                <div class="input-group">
                                    <input type="text" id="inventoryDateRange" class="form-control"
                                        placeholder="DD-MM-YYYY to DD-MM-YYYY" readonly>
                                    <span class="input-group-text">
                                        <i class="bx bx-calendar"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="col-lg-2 col-md-6">
                                <div class="d-flex gap-2">
                                    <button id="filterBtn" class="btn btn-primary flex-fill">
                                        <i class="bx bx-search me-2"></i>Apply
                                    </button>
                                    <button id="resetBtn" class="btn btn-light flex-fill">
                                        <i class="bx bx-reset me-2"></i>Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="fw-semibold">Active Filters:</span>
                                    <span class="badge bg-light text-dark px-3 py-2" id="activeStore">
                                        <i class="bx bx-store me-1"></i>All Stores
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2" id="activeDate">
                                        <i class="bx bx-calendar me-1"></i>All Dates
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Table Card -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="bx bx-list-ul me-2"></i>Product Inventory Details
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover w-100" id="inventoryReportTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Product Name</th>
                                        <th width="10%">Model</th>
                                        <th width="10%">SKU</th>
                                        <th width="12%">Brand</th>
                                        <th width="10%" class="text-end">Sold Qty</th>
                                        <th width="12%" class="text-end">Unit Price</th>
                                        <th width="12%" class="text-end">Total Sales</th>
                                        <th width="8%">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>
    @include('partials.footer_link')

    <style>
        /* Custom Styles */
        .summary-card {
            transition: transform 0.2s;
        }

        .summary-card:hover {
            transform: translateY(-5px);
        }

        .bg-primary-gradient {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }

        .bg-success-gradient {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        }

        .bg-warning-gradient {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        }

        .bg-info-gradient {
            background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        }

        .filter-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .active-filters .badge {
            font-size: 13px;
            font-weight: 500;
        }

        .table th {
            font-weight: 600;
            color: #344767;
            border-bottom-width: 1px;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #e9ebec;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize variables
            let selectedStart = null;
            let selectedEnd = null;

            // Initialize Select2
            $('.select2').select2({
                width: '100%',
                minimumResultsForSearch: 5
            });

            // Initialize Flatpickr
            let fp = flatpickr("#inventoryDateRange", {
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
                    } else if (selectedDates.length === 1) {
                        selectedStart = selectedDates[0];
                        selectedEnd = selectedDates[0]; // 👈 important
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
                        start.setDate(today.getDate() - today.getDay() + (today.getDay() === 0 ? -6 : 1));
                        end = new Date(today);
                        end.setDate(start.getDate() + 6);
                        break;
                    case 'previous_week':
                        start = new Date(today);
                        start.setDate(today.getDate() - today.getDay() - 6);
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
                // Update store filter display
                const storeId = $('#store_id').val();
                const storeText = $('#store_id option:selected').text();
                $('#activeStore').html(`<i class="bx bx-store me-1"></i>${storeText || 'All Stores'}`);

                // Update date filter display
                if (selectedStart && selectedEnd) {
                    const startFormatted = formatDate(selectedStart);
                    const endFormatted = formatDate(selectedEnd);
                    $('#activeDate').html(
                    `<i class="bx bx-calendar me-1"></i>${startFormatted} to ${endFormatted}`);
                } else {
                    $('#activeDate').html('<i class="bx bx-calendar me-1"></i>All Dates');
                }
            }

            // Format date helper
            function formatDate(date) {
                const d = new Date(date);
                return `${d.getDate().toString().padStart(2, '0')}-${(d.getMonth()+1).toString().padStart(2, '0')}-${d.getFullYear()}`;
            }

            // Format date for server
            function formatDateForServer(date) {
                const d = new Date(date);
                return `${d.getFullYear()}-${(d.getMonth()+1).toString().padStart(2, '0')}-${d.getDate().toString().padStart(2, '0')}`;
            }

            // Format currency
            function formatCurrency(amount) {
                return '₹ ' + parseFloat(amount || 0).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Initialize DataTable
            var table = $('#inventoryReportTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('inventory.report.list') }}",
                    data: function(d) {
                        d.store_id = $('#store_id').val();
                        d.start_date = selectedStart ? formatDateForServer(selectedStart) : '';
                        d.end_date = selectedEnd ? formatDateForServer(selectedEnd) : '';
                    },
                    dataSrc: function(json) {
                        // Update summary cards
                        if (json.summary) {
                            $('#totalProducts').text(json.summary.total_products || 0);
                            $('#totalUnitsSold').text(json.summary.total_units_sold || 0);
                            $('#totalSalesValue').text(
                                parseFloat(json.summary.total_sales_value || 0).toLocaleString(
                                    'en-IN', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })
                            );
                            $('#totalBrands').text(json.summary.total_brands || 0);
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
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bx bx-file-blank"></i> Export toPDF',
                        className: 'dt-btn-light',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        customize: function(doc) {
                            doc.pageMargins = [10, 10, 10, 10];
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 9;
                            doc.styles.tableHeader.fillColor = '#4e73df';
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="bx bx-columns"></i> Column Visibility',
                        className: 'dt-btn-light',
                    }
                ],
                columns: [{
                        data: 'sr_no',
                        className: 'fw-medium'
                    },
                    {
                        data: 'pro_name',
                        className: 'fw-semibold'
                    },
                    {
                        data: 'pro_model',
                        className: 'text-muted'
                    },
                    {
                        data: 'pro_sku',
                        render: function(data) {
                            return '<span class="badge bg-light text-dark">' + (data || 'N/A') +
                                '</span>';
                        }
                    },
                    {
                        data: 'brand_name',
                        render: function(data) {
                            return data || 'N/A';
                        }
                    },
                    {
                        data: 'sold_qty',
                        className: 'text-end fw-bold',
                        render: function(data) {
                            return parseInt(data).toLocaleString('en-IN');
                        }
                    },
                    {
                        data: 'unit_price',
                        className: 'text-end',
                        render: function(data) {
                            return formatCurrency(data);
                        }
                    },
                    {
                        data: 'total_sales',
                        className: 'text-end fw-bold text-success',
                        render: function(data) {
                            return formatCurrency(data);
                        }
                    },
                    {
                        data: 'status',
                        className: 'text-center',
                        render: function(data) {
                            if (data === 'active') {
                                return '<span class="badge bg-success-light text-success">Active</span>';
                            } else {
                                return '<span class="badge bg-danger-light text-danger">Inactive</span>';
                            }
                        }
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                pageLength: 25,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    search: '<i class="bx bx-search"></i>',
                    searchPlaceholder: 'Search products...',
                    emptyTable: 'No inventory data found',
                    zeroRecords: 'No matching products found'
                },
                createdRow: function(row, data, dataIndex) {
                    // Add row class based on stock status
                    if (parseInt(data.sold_qty) === 0) {
                        $(row).addClass('table-danger');
                    }
                }
            });

            // Apply filter button click
            $('#filterBtn').on('click', function() {
                table.ajax.reload(null, false);
            });

            // Reset all filters
            $('#resetBtn').on('click', function() {
                $('#store_id').val('').trigger('change');
                $('#dateRangePreset').val('').trigger('change');
                fp.clear();
                selectedStart = null;
                selectedEnd = null;
                updateActiveFilters();
                table.ajax.reload();
            });

            // Auto reload on filter change
            $('#store_id').on('change', function() {
                updateActiveFilters();
                table.ajax.reload();
            });

            // Initial update of active filters
            updateActiveFilters();

            // Add some animation to the table rows
            $('#inventoryReportTable tbody').on('mouseenter', 'tr', function() {
                $(this).addClass('shadow-sm');
            }).on('mouseleave', 'tr', function() {
                $(this).removeClass('shadow-sm');
            });
        });
    </script>
</body>

</html>
