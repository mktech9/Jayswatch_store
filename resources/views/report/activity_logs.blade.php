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
                <i class="bx bx-history me-2"></i>{{ $page_title }}
            </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Activity Logs</li>
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
                                        <div class="avatar avatar-lg bg-white bg-opacity-25 rounded-circle">
                                            <i class="bx bx-list-ul fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Total Activities</p>
                                        <h3 class="text-white mb-0 fw-bold" id="totalActivities">0</h3>
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
                                            <i class="bx bx-user fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Unique Users</p>
                                        <h3 class="text-white mb-0 fw-bold" id="uniqueUsers">0</h3>
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
                                            <i class="bx bx-grid-alt fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Menu Types</p>
                                        <h3 class="text-white mb-0 fw-bold" id="menuTypes">0</h3>
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
                                            <i class="bx bx-chip fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-white text-opacity-75 mb-1">Log Types</p>
                                        <h3 class="text-white mb-0 fw-bold" id="logTypes">0</h3>
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
                            <i class="bx bx-filter me-2"></i>Filter Activity Logs
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end g-3">
                            <!-- Menu Type Filter -->
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-menu me-1"></i>Menu Type
                                </label>
                                <select name="menu_type" id="menu_type" class="form-select select2">
                                    <option value="">All Menus</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>

                            <!-- Log Type Filter -->
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-log-in me-1"></i>Log Type
                                </label>
                                <select name="log_type" id="log_type" class="form-select select2">
                                    <option value="">All Log Types</option>

                                </select>
                            </div>

                            <!-- User Filter -->
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-user me-1"></i>User
                                </label>
                                <select name="user_id" id="user_id" class="form-select select2">
                                    <option value="">All Users</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>

                            <!-- Period Preset -->
                            <div class="col-lg-2 col-md-6">
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
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-calendar-week me-1"></i>Date Range
                                </label>
                                <div class="input-group">
                                    <input type="text" id="activityDateRange" class="form-control"
                                        placeholder="DD-MM-YYYY to DD-MM-YYYY" readonly>
                                    <span class="input-group-text">
                                        <i class="bx bx-calendar"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="col-lg-12 col-md-12">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button id="filterBtn" class="btn btn-primary">
                                        <i class="bx bx-search me-2"></i>Apply Filters
                                    </button>
                                    <button id="resetBtn" class="btn btn-light">
                                        <i class="bx bx-reset me-2"></i>Reset
                                    </button>
                                    <button id="exportBtn" class="btn btn-success">
                                        <i class="bx bx-export me-2"></i>Export
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="fw-semibold">Active Filters:</span>
                                    <span class="badge bg-light text-dark px-3 py-2" id="activeMenu">
                                        <i class="bx bx-menu me-1"></i>All Menus
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2" id="activeLogType">
                                        <i class="bx bx-log-in me-1"></i>All Log Types
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2" id="activeUser">
                                        <i class="bx bx-user me-1"></i>All Users
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2" id="activeDate">
                                        <i class="bx bx-calendar me-1"></i>All Dates
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Logs Table Card -->
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="bx bx-list-ul me-2"></i>Activity Logs Details
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover w-100" id="activityLogsTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Menu Type</th>
                                        <th width="8%">Log Type</th>
                                        <th width="10%">User</th>
                                        <th width="12%">Log Date</th>
                                        <th width="25%">Description</th>
                                        {{-- <th width="8%">Status</th> --}}
                                        <th width="10%">IP Address</th>
                                        {{-- <th width="12%">Created At</th> --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Details Modal -->
        <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewDetailsModalLabel">
                            <i class="bx bx-detail me-2"></i>Activity Log Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                {{-- <tr>
                                    <th width="30%">Log ID</th>
                                    <td id="detail_log_id"></td>
                                </tr> --}}
                                <tr>
                                    <th>Menu Type</th>
                                    <td id="detail_menu_type"></td>
                                </tr>
                                <tr>
                                    <th>Log Type</th>
                                    <td id="detail_log_type"></td>
                                </tr>
                                <tr>
                                    <th>User Info</th>
                                    <td id="detail_user_id"></td>
                                </tr>
                                <tr>
                                    <th>Log Date</th>
                                    <td id="detail_log_date"></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td id="detail_description"></td>
                                </tr>
                                {{-- <tr>
                                    <th>Status</th>
                                    <td id="detail_status"></td>
                                </tr> --}}
                                <tr>
                                    <th>IP Address</th>
                                    <td id="detail_ip_address"></td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td id="detail_created_at"></td>
                                </tr>
                                {{-- <tr>
                                    <th>Created By</th>
                                    <td id="detail_created_by"></td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td id="detail_updated_at"></td>
                                </tr>
                                <tr>
                                    <th>Updated By</th>
                                    <td id="detail_updated_by"></td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            overflow: hidden;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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

        .table th {
            font-weight: 600;
            color: #344767;
            border-bottom-width: 1px;
            background-color: #f8f9fa;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #e9ebec;
        }

        .badge-log-type {
            padding: 5px 10px;
            font-weight: 500;
        }

        .log-create {
            background-color: #d4edda;
            color: #155724;
        }

        .log-update {
            background-color: #fff3cd;
            color: #856404;
        }

        .log-delete {
            background-color: #f8d7da;
            color: #721c24;
        }

        .log-view {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .log-login {
            background-color: #cce5ff;
            color: #004085;
        }

        .dt-buttons {
            margin: 0 10px;
        }

        .dt-btn-light {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
            margin: 0 2px;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }

        .dt-btn-light:hover {
            background: #e2e6ea;
            border-color: #dae0e5;
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

            $('#menu_type').select2({
                placeholder: "Select Menu Type",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#menu_type').parent() // Fix if inside card/modal
            });

            $('#log_type').select2({
                placeholder: "Select Log Type",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#log_type').parent() // Fix if inside card/modal
            });

            $('#user_id').select2({
                placeholder: "Select User",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#user_id').parent() // Fix if inside card/modal
            });

            // Load filter options
            loadFilterOptions();

            function loadFilterOptions() {
                $.ajax({
                    url: "{{ route('activity.logs.filters') }}",
                    type: 'GET',
                    success: function(response) {

                        // Menu Types
                        let menuOptions = '<option value="">All Menus</option>';
                        response.menu_types.forEach(function(menu) {
                            menuOptions += `<option value="${menu}">${menu}</option>`;
                        });
                        $('#menu_type').html(menuOptions);

                        // ✅ Log Types (Dynamic)
                        let logOptions = '<option value="">All Log Types</option>';
                        response.log_types.forEach(function(log) {
                            logOptions += `<option value="${log}">${log}</option>`;
                        });
                        $('#log_type').html(logOptions);

                        // Users
                        let userOptions = '<option value="">All Users</option>';
                        response.users.forEach(function(user) {
                            userOptions +=
                                `<option value="${user.user_id}">${user.user_name}</option>`;
                        });
                        $('#user_id').html(userOptions);
                    }
                });
            }

            // Initialize Flatpickr
            let fp = flatpickr("#activityDateRange", {
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
                // Update menu filter display
                const menuType = $('#menu_type').val();
                const menuText = $('#menu_type option:selected').text();
                $('#activeMenu').html(`<i class="bx bx-menu me-1"></i>${menuText || 'All Menus'}`);

                // Update log type filter display
                const logType = $('#log_type').val();
                const logText = $('#log_type option:selected').text();
                $('#activeLogType').html(`<i class="bx bx-log-in me-1"></i>${logText || 'All Log Types'}`);

                // Update user filter display
                const userId = $('#user_id').val();
                const userText = $('#user_id option:selected').text();
                $('#activeUser').html(`<i class="bx bx-user me-1"></i>${userText || 'All Users'}`);

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

            // Format datetime
            function formatDateTime(dateTimeStr) {
                if (!dateTimeStr) return 'N/A';
                const date = new Date(dateTimeStr);
                return date.toLocaleString('en-IN', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });
            }

            // Get log type badge class
            function getLogTypeBadge(logType) {
                switch (logType) {
                    case 'CREATE':
                        return 'badge bg-success text-white';
                    case 'UPDATE':
                        return 'badge bg-warning text-dark';
                    case 'DELETE':
                        return 'badge bg-danger text-white';
                    case 'VIEW':
                        return 'badge bg-info text-white';
                    case 'LOGIN':
                        return 'badge bg-primary text-white';
                    case 'LOGOUT':
                        return 'badge bg-secondary text-white';
                    case 'EXPORT':
                        return 'badge bg-dark text-white';
                    case 'IMPORT':
                        return 'badge bg-purple text-white';
                    case 'PRINT':
                        return 'badge bg-indigo text-white';
                    default:
                        return 'badge bg-light text-dark';
                }
            }

            // Get status badge
            function getStatusBadge(status) {
                if (status === 'SUCCESS' || status === 'ACTIVE') {
                    return '<span class="badge bg-success text-white">Success</span>';
                } else if (status === 'FAILED' || status === 'ERROR') {
                    return '<span class="badge bg-danger text-white">Failed</span>';
                } else if (status === 'PENDING') {
                    return '<span class="badge bg-warning text-dark">Pending</span>';
                } else {
                    return '<span class="badge bg-secondary text-white">' + (status || 'N/A') + '</span>';
                }
            }

            // Initialize DataTable
            var table = $('#activityLogsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('activity.logs.list') }}",
                    data: function(d) {
                        d.menu_type = $('#menu_type').val();
                        d.log_type = $('#log_type').val();
                        d.user_id = $('#user_id').val();
                        d.start_date = selectedStart ? formatDateForServer(selectedStart) : '';
                        d.end_date = selectedEnd ? formatDateForServer(selectedEnd) : '';
                    },
                    dataSrc: function(json) {
                        // Update summary cards
                        if (json.summary) {
                            $('#totalActivities').text(json.summary.total_activities || 0);
                            $('#uniqueUsers').text(json.summary.unique_users || 0);
                            $('#menuTypes').text(json.summary.menu_types || 0);
                            $('#logTypes').text(json.summary.log_types || 0);
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
                        text: '<i class="bx bx-file-blank"></i> Export to PDF',
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
                        text: '<i class="bx bx-columns"></i> Columns Visibility',
                        className: 'dt-btn-light',
                    }
                ],
                columns: [{
                        data: 'sr_no',
                        className: 'fw-medium'
                    },
                    {
                        data: 'menu_type',
                        render: function(data) {
                            return data ? data.toUpperCase() : 'N/A';
                        }
                    },
                    {
                        data: 'log_type',
                        render: function(data) {
                            return `<span class="${getLogTypeBadge(data)}">${data || 'N/A'}</span>`;
                        }
                    },
                    {
                        data: 'user_name',
                        render: function(data) {
                            return data || 'N/A';
                        }
                    },
                    {
                        data: 'log_date',
                        render: function(data) {
                            return data ? formatDateTime(data) : 'N/A';
                        }
                    },
                    {
                        data: 'log_description',
                        render: function(data) {
                            return data || 'N/A';
                        }
                    },
                    // {
                    //     data: 'log_status',
                    //     render: function(data) {
                    //         return getStatusBadge(data);
                    //     }
                    // },
                    {
                        data: 'ip_address',
                        render: function(data) {
                            return data || 'N/A';
                        }
                    }
                    // {
                    //     data: 'created_at',
                    //     render: function(data) {
                    //         return data ? formatDateTime(data) : 'N/A';
                    //     }
                    // }
                ],
                order: [
                    [0, 'desc']
                ], // Sort by log_id descending
                pageLength: 25,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    search: '<i class="bx bx-search"></i>',
                    searchPlaceholder: 'Search activities...',
                    emptyTable: 'No activity logs found',
                    zeroRecords: 'No matching activities found'
                },
                createdRow: function(row, data, dataIndex) {
                    // Add click event for row
                    $(row).css('cursor', 'pointer');
                    $(row).on('click', function() {
                        viewActivityDetails(data);
                    });
                }
            });

            // View activity details
            function viewActivityDetails(data) {
                // $('#detail_log_id').text(data.log_id || 'N/A');
                $('#detail_menu_type').text(
                    data.menu_type ? data.menu_type.toUpperCase() : 'N/A'
                );
                $('#detail_log_type').html(
                    `<span class="${getLogTypeBadge(data.log_type)}">${data.log_type || 'N/A'}</span>`);
                $('#detail_user_id').text(data.user_name || 'N/A');
                $('#detail_log_date').text(data.log_date ? formatDateTime(data.log_date) : 'N/A');
                $('#detail_description').text(
                    data.log_description ?
                    data.log_description.replace(/<\/?[^>]+(>|$)/g, "") :
                    'N/A'
                );
                // $('#detail_status').html(getStatusBadge(data.log_status));
                $('#detail_ip_address').text(data.ip_address || 'N/A');
                $('#detail_created_at').text(data.created_at ? formatDateTime(data.created_at) : 'N/A');
                // $('#detail_created_by').text(data.created_by || 'N/A');
                // $('#detail_updated_at').text(data.updated_at ? formatDateTime(data.updated_at) : 'N/A');
                // $('#detail_updated_by').text(data.updated_by || 'N/A');

                $('#viewDetailsModal').modal('show');
            }

            // Apply filter button click
            $('#filterBtn').on('click', function() {
                table.ajax.reload(null, false);
            });

            // Reset all filters
            $('#resetBtn').on('click', function() {
                $('#menu_type').val('').trigger('change');
                $('#log_type').val('').trigger('change');
                $('#user_id').val('').trigger('change');
                $('#dateRangePreset').val('').trigger('change');
                fp.clear();
                selectedStart = null;
                selectedEnd = null;
                updateActiveFilters();
                table.ajax.reload();
            });

            // Export button click
            $('#exportBtn').on('click', function() {
                // Trigger Excel export
                table.button('.buttons-excel').trigger();
            });

            // Auto reload on filter change
            $('#menu_type, #log_type, #user_id').on('change', function() {
                updateActiveFilters();
                table.ajax.reload();
            });

            // Initial update of active filters
            updateActiveFilters();

            // Add hover effect to table rows
            $('#activityLogsTable tbody').on('mouseenter', 'tr', function() {
                $(this).addClass('shadow-sm');
            }).on('mouseleave', 'tr', function() {
                $(this).removeClass('shadow-sm');
            });
        });
    </script>
</body>

</html>
