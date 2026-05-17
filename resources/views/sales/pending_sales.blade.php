<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')

<style>
    .dt-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 15px;
        width: 100%;
    }

    .dt-buttons .btn {
        background-color: #fff;
        border: 1px solid #eaedf1;
        color: #5d6679;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }

    .dt-buttons .btn:hover {
        background-color: #f8f9fa;
        color: #2A2E72;
        border-color: #2A2E72;
        transform: translateY(-1px);
    }

    .dt-buttons .btn i {
        margin-right: 5px;
        font-size: 1.1rem;
        vertical-align: middle;
        position: relative;
        top: -1px;
    }

    .product-search-wrapper {
        width: 100%;
        max-width: 550px;
    }

    #searchResults {
        width: 100%;
        z-index: 1000;
        display: none;
        max-height: 300px;
        overflow-y: auto;
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Pending Sales</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Sales Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pending List</li>
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
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listStock"
                                            role="tab">Pending List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-none" id="addSalesTab" data-bs-toggle="tab"
                                            href="#addStock" role="tab">Edit Sale</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="listStock" role="tabpanel">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="pendingSalesTable"
                                                class="table table-bordered table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Invoice No</th>
                                                        <th>Customer</th>
                                                        <th>Location</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="addStock" role="tabpanel">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="card-title mb-0" style="color:#2A2E72">Edit Pending Sale</h5>
                                        </div>

                                        <form id="saleForm" class="needs-validation" novalidate
                                            enctype="multipart/form-data">
                                            @csrf

                                            @php
                                                $Formlocations = staff_locations();
                                            @endphp
                                            <input type="hidden" name="is_split_payment" id="is_split_payment"
                                                value="0">


                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark">Store Location:
                                                        <span class="text-danger">*</span></label>
                                                    <select class="form-select bg-light" name="location" id="location"
                                                        required>
                                                        <option value="">Please Select</option>
                                                        @foreach ($Formlocations as $loc)
                                                            <option value="{{ $loc->bl_id }}">{{ $loc->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please Select Store Location.
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Customer: <span class="text-danger">*</span>
                                                    </label>

                                                    <div class="input-group">
                                                        <select class="form-select bg-light" name="customer_id"
                                                            id="customer_id" required>
                                                            <option value="" selected disabled>Select Customer
                                                            </option>

                                                            <option value="walkin">➕ Walk-In Customer</option>

                                                            @foreach ($customers as $cust)
                                                                @php
                                                                    $fullName = trim(
                                                                        $cust->first_name .
                                                                            ' ' .
                                                                            $cust->middle_name .
                                                                            ' ' .
                                                                            $cust->last_name,
                                                                    );

                                                                    if (empty($fullName) && $cust->is_business) {
                                                                        $fullName = $cust->business_name;
                                                                    }
                                                                @endphp
                                                                <option value="{{ $cust->contact_master_id }}">
                                                                    {{ $fullName }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <div class="invalid-feedback">
                                                            Please Select Customer.
                                                        </div>

                                                        <!-- ➕ Button -->
                                                        {{-- <button class="btn btn-outline-primary" type="button"
                                                            id="openWalkInModal" title="Add Walk-In Customer">
                                                            <i class="bx bx-plus"></i>
                                                        </button> --}}
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row g-3 mb-4">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Date:<span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0 text-muted">
                                                            <i class="bx bx-calendar"></i>
                                                        </span>
                                                        <input type="text" class="form-control  bg-light "
                                                            id="sale_date" name="sale_date" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Invoice No:
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="invoice_no"
                                                            id="invoice_no" placeholder="Enter Invoice No" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Full Name
                                                        <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control  bg-light"
                                                            name="full_name" id="full_name" placeholder="Full Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Mobile Number
                                                        No: <span class="text-danger">*</span></label>
                                                    <div class="input-group">

                                                        <input type="text" class="form-control  bg-light "
                                                            name="mobile_no" id="mobile_no" maxlength="10"
                                                            placeholder="Mobile No" required>
                                                        <div class="invalid-feedback">
                                                            Please Enter Mobile Number.
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Email <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="text" class="form-control  bg-light "
                                                            name="email" id="email" placeholder="Email">
                                                        <div class="invalid-feedback">
                                                            Please Enter Email.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">ID Number
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="text" class="form-control  bg-light "
                                                            name="id_no" id="id_no" placeholder="Id No">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Id Proof Type:
                                                    </label>
                                                    <div class="input-group">

                                                        <div class="flex-grow-1">
                                                            <select class="form-select  bg-light " id="id_proof"
                                                                name="id_proof">
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
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">ID File</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control bg-light"
                                                            name="file_id" id="file_id"
                                                            accept=".jpeg,.png,.jpg,.doc,.docx,.pdf">

                                                        <input type="hidden" name="existing_file_id"
                                                            id="existing_file_id">
                                                    </div>
                                                    <div id="id_file_preview" class="mt-1"></div>
                                                </div>



                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Bill Status: <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">

                                                        <div class="flex-grow-1">
                                                            <select class="form-select  bg-light " id="bill_status"
                                                                name="bill_status" required>
                                                                <option value="">Please Select</option>
                                                                <option value="Draft">Draft</option>
                                                                <option value="Paid">Paid</option>
                                                                <option value="Return">Return</option>
                                                            </select>

                                                            <div class="invalid-feedback">
                                                                Please select Bill Status.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <h6 class="fw-semibold text-dark mb-3">Search Products</h6>

                                                <!-- 🔍 Search Box (from reference style) -->
                                                <div class="d-flex justify-content-center">
                                                    <div class="product-search-wrapper position-relative mb-3"
                                                        style="width: 100%; max-width: 420px;">
                                                        <div
                                                            class="input-group shadow-sm border rounded-2 overflow-hidden">
                                                            <span
                                                                class="input-group-text bg-light border-0 text-muted ps-3">
                                                                <i class="bx bx-search fs-5"></i>
                                                            </span>
                                                            <input type="text"
                                                                class="form-control bg-light border-0 ps-2 py-2"
                                                                id="productSearch"
                                                                placeholder="Type product name or sku"
                                                                autocomplete="off">
                                                        </div>

                                                        <ul id="searchResults"
                                                            class="list-group position-absolute w-100 shadow bg-white rounded-bottom"
                                                            style="z-index: 1000; display: none; max-height: 300px; overflow-y: auto;">
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- 📦 Product Table (original columns preserved) -->
                                                <div class="table-responsive border rounded-2"
                                                    style="max-height: 400px; overflow-y: auto;">
                                                    <table
                                                        class="table table-borderless text-center align-middle mb-0">
                                                        <thead class="bg-light text-muted sticky-top">
                                                            <tr>
                                                                <th class="fw-semibold text-start ps-4"
                                                                    width="25%">Product</th>
                                                                <th class="fw-semibold" width="15%">Description
                                                                </th>
                                                                <th class="fw-semibold" width="20%">HSN Code</th>
                                                                <th class="fw-semibold" width="5%">Qty</th>
                                                                <th class="fw-semibold" width="20%">Price</th>
                                                                <th class="fw-semibold" width="10%">Total</th>
                                                                <th class="fw-semibold" width="5%">
                                                                    <i class="bx bx-trash"></i>
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="productTableBody">
                                                            <tr id="noProductsRow">
                                                                <td colspan="7" class="py-4 text-muted small">
                                                                    No products added yet
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                        <tfoot class="border-top  bg-white">
                                                            <tr>
                                                                <td colspan="5"></td>
                                                                <td class="text-end pe-4 fw-bold text-dark">
                                                                    Total: <span id="grandTotal">0.00</span>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-dark">Discount:</label>
                                                    <input type="number" class="form-control bg-light"
                                                        name="discount" id="discount" value="0" min="0"
                                                        step="0.01">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-dark d-block">GST
                                                        Applicable:</label>
                                                    <div class="form-check form-check-inline mt-1">
                                                        <input class="form-check-input" type="radio"
                                                            name="gst_applicable" id="gst_yes" value="yes"
                                                            checked>
                                                        <label class="form-check-label" for="gst_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mt-1">
                                                        <input class="form-check-input" type="radio"
                                                            name="gst_applicable" id="gst_no" value="no">
                                                        <label class="form-check-label" for="gst_no">No</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4" id="gst_number_container">
                                                    <label class="form-label fw-semibold text-dark">GST Number:</label>
                                                    <input type="text" class="form-control bg-light"
                                                        name="gst_number" id="gst_number">
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-dark">GST:</label>
                                                    <div class="input-group">
                                                        <select class="form-select bg-light" name="gst_display"
                                                            id="gst_display">
                                                            <option value="">Select GST</option>
                                                            <option value="5">5%</option>

                                                            @foreach ($gst_data as $gst)
                                                                @if ($gst->percentage != 5)
                                                                    @php
                                                                        $rate = rtrim(
                                                                            rtrim(
                                                                                number_format(
                                                                                    $gst->tax_rate,
                                                                                    2,
                                                                                    '.',
                                                                                    '',
                                                                                ),
                                                                                '0',
                                                                            ),
                                                                            '.',
                                                                        );
                                                                    @endphp

                                                                    <option value="{{ $gst->tax_rate }}">
                                                                        {{ $rate }}%
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>

                                                        <input type="text" class="form-control bg-light"
                                                            id="gst_amount" name="gst_amount" value="0.00"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-dark">TCS (%):</label>
                                                    <div class="input-group">
                                                        <select class="form-select bg-light" name="tcs_percentage"
                                                            id="tcs_percentage">
                                                            <option value="1">1%</option>
                                                            @foreach ($tcs_data as $tcs)
                                                                @if ($tcs->percentage != 1)
                                                                    <option value="{{ $tcs->percentage }}">
                                                                        {{ $tcs->percentage }}%
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <input type="text" class="form-control bg-light"
                                                            name="tcs_display" id="tcs_display" value="0.00"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center mb-4">

                                                <div class="col-md-12">

                                                    <!-- 🔘 Toggle Switch -->
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="toggle_split_payment" style="cursor: pointer;">
                                                        <label class="form-check-label fw-semibold"
                                                            for="toggle_split_payment" style="cursor: pointer;">
                                                            Add Split Payment
                                                        </label>
                                                    </div>

                                                    <!-- 🔢 Split Section (Hidden Initially) -->
                                                    <div id="split_payment_section" class="split-section">

                                                        <div class="d-flex align-items-center gap-3 mb-2">
                                                            <div style="width:150px;">
                                                                <label class="form-label mb-1">Number of Splits</label>
                                                                <input type="number" min="1" max="10"
                                                                    value="1" id="split_count"
                                                                    class="form-control form-control-sm">
                                                            </div>
                                                        </div>

                                                        <div id="payment_split_container"></div>
                                                    </div>

                                                </div>

                                                <div class="col-md-12 text-end mt-2">
                                                    <h5 class="mb-0 text-muted">
                                                        Remaining Amount:
                                                        <span id="remaining_amount"
                                                            class="fw-bold text-dark">0.00</span>
                                                        <input type="hidden" name="remaining_amount"
                                                            id="remaining_amount_input" value="0.00">
                                                    </h5>
                                                </div>

                                            </div>



                                            <div class="d-flex flex-column align-items-end mt-4 pt-3 border-top">
                                                <h5 class="fw-bold mb-3 text-dark"> Total Amount: <span
                                                        id="finalTotal">0.00</span>
                                                    <input type="hidden" name="final_total" id="finalTotal_input"
                                                        value="0.00">
                                                </h5>
                                                <div>
                                                    <button type="submit" class="btn btn-primary px-5"
                                                        id="saveBtn">
                                                        <i class="bx bx-save me-1"></i> Save
                                                    </button>
                                                    <button class="btn btn-primary px-5 d-none" type="button"
                                                        id="loadingBtn" disabled>
                                                        <span class="spinner-border spinner-border-sm align-middle"
                                                            role="status" aria-hidden="true"></span>
                                                        <span class="ms-2">Saving...</span>
                                                    </button>
                                                </div>
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

        <div class="modal fade" id="viewSaleModal" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title d-flex align-items-center"><i class="bx bx-receipt me-2"></i> Sale
                            Details</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="printArea">
                        <div id="saleDetailsContent"></div>
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
        let paymentMethods = @json($payment_method);
        let splitIndex = 0;

        $(document).ready(function() {

            // ─────────────────────────────────────────────
            // 1. INIT DATATABLE
            // ─────────────────────────────────────────────
            var pendingTable = $('#pendingSalesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('sales.pending.list') }}",
                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sale_date'
                    },
                    {
                        data: 'invoice_no'
                    },
                    {
                        data: 'customer'
                    },
                    {
                        data: 'location'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'bill_status'
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
                pageLength: 10,
                dom: "<'row mb-2 align-items-center'<'col-lg-2 col-md-3'l><'col-lg-7 col-md-6 text-center'B><'col-lg-3 col-md-3 text-end'f>>rtip",
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'btn',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> CSV',
                        className: 'btn',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Excel',
                        className: 'btn',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'btn',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bx bx-file-blank"></i> PDF',
                        className: 'btn',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search pending sales..."
                }
            });

            // ─────────────────────────────────────────────
            // 2. INIT PICKERS & SELECT2
            // ─────────────────────────────────────────────
            $("#sale_date").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                allowInput: false
            });

            $('#location, #bill_status, #id_proof, #customer_id, #tcs_percentage, #gst_display').select2({
                placeholder: "Please Select",
                allowClear: true,
                width: '100%'
            });

            // ─────────────────────────────────────────────
            // 3. GST TOGGLE (show/hide GST number field)
            // ─────────────────────────────────────────────
            function toggleGSTContainer() {
                if ($('#gst_yes').is(':checked')) {
                    $('#gst_number_container').show();
                } else {
                    $('#gst_number_container').hide();
                    $('#gst_number').val('');
                }
            }
            $('#gst_yes, #gst_no').on('change', toggleGSTContainer);
            toggleGSTContainer();

            // ─────────────────────────────────────────────
            // 4. SPLIT PAYMENT — ADD ROW
            // ─────────────────────────────────────────────
            function addPaymentRow() {
                let options = '';
                paymentMethods.forEach(function(method) {
                    let selected = method.payment === 'Cash' ? 'selected' : '';
                    options += `<option value="${method.payment}" ${selected}>${method.payment}</option>`;
                });

                let row = `
        <div class="card p-3 mb-2 payment-row" data-index="${splitIndex}">
            <input type="hidden" name="payment_split[${splitIndex}][payment_id]" value="">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Method</label>
                    <select name="payment_split[${splitIndex}][method]" class="form-select payment-method">
                        ${options}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pay Amount</label>
                    <input name="payment_split[${splitIndex}][amount]" class="form-control pay-amount" value="0">
                </div>
                <div class="col-md-4 extra-field"></div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-payment">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        </div>`;

                $('#payment_split_container').append(row);
                splitIndex++;
                updateRemainingAmount();
            }

            // ─────────────────────────────────────────────
            // 5. SPLIT PAYMENT — EXTRA FIELDS BY METHOD
            // ─────────────────────────────────────────────
            $(document).on('change', '.payment-method', function() {
                let method = $(this).val();
                let row = $(this).closest('.payment-row');
                let index = row.data('index');
                let extra = row.find('.extra-field');

                extra.html('');

                if (method === 'Cash') return;

                if (method === 'Cheque') {
                    extra.html(
                        `<label class="form-label">Cheque No</label>
                <input type="text" name="payment_split[${index}][cheque_no]" class="form-control" placeholder="Cheque Number">`
                    );

                } else if (method === 'Online Bank Transfer') {
                    extra.html(`<div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Transaction No</label>
                    <input type="text" name="payment_split[${index}][transaction_no]" class="form-control" placeholder="Transaction No">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bank Account No</label>
                    <input type="text" name="payment_split[${index}][bank_account_no]" class="form-control" placeholder="Bank Account">
                </div>
            </div>`);

                } else if (method === 'Card') {
                    extra.html(
                        `<label class="form-label">Card No</label>
                <input type="text" name="payment_split[${index}][card_no]" class="form-control" maxlength="16" placeholder="Card Number">`
                    );

                } else {
                    extra.html(
                        `<label class="form-label">Transaction No</label>
                <input type="text" name="payment_split[${index}][transaction_no]" class="form-control" placeholder="Transaction No">`
                    );
                }
            });

            // ─────────────────────────────────────────────
            // 6. REMOVE PAYMENT ROW
            // ─────────────────────────────────────────────
            $(document).on('click', '.remove-payment', function() {
                $(this).closest('.payment-row').remove();

                if ($('.payment-row').length === 0) {
                    $('#toggle_split_payment').prop('checked', false).trigger('change');
                    return;
                }
                updateRemainingAmount();
            });

            // ─────────────────────────────────────────────
            // 7. SPLIT PAYMENT TOGGLE
            // ─────────────────────────────────────────────
            $('#toggle_split_payment').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#is_split_payment').val(1);
                    $('#split_payment_section').addClass('show');
                    $('#split_count').val(1);
                    $('#payment_split_container').html('');
                    splitIndex = 0;
                    addPaymentRow();
                } else {
                    $('#is_split_payment').val(0);
                    $('#split_payment_section').removeClass('show');
                    $('#payment_split_container').html('');
                    $('#split_count').val(1);
                    splitIndex = 0;
                    $('#remaining_amount').text('0.00');
                    $('#remaining_amount_input').val('0.00');
                }
            });

            // ─────────────────────────────────────────────
            // 8. SPLIT COUNT INPUT
            // ─────────────────────────────────────────────
            $('#split_count').on('input', function() {
                if (!$('#toggle_split_payment').is(':checked')) return;

                let count = parseInt($(this).val()) || 1;
                if (count < 1) count = 1;
                if (count > 10) count = 10;
                $(this).val(count);

                let current = $('.payment-row').length;
                if (count > current) {
                    for (let i = current; i < count; i++) addPaymentRow();
                } else {
                    $('.payment-row').slice(count).remove();
                }
                updateRemainingAmount();
            });

            $(document).on('input', '.pay-amount', function() {
                updateRemainingAmount();
            });

            // ─────────────────────────────────────────────
            // 9. NORMALIZE PAYMENT INDEXES
            // ─────────────────────────────────────────────
            function normalizePaymentIndexes() {
                $('.payment-row').each(function(i) {
                    $(this).attr('data-index', i);
                    $(this).find('[name]').each(function() {
                        let name = $(this).attr('name');
                        if (!name) return;
                        name = name.replace(/payment_split\[\d+\]/, 'payment_split[' + i + ']');
                        $(this).attr('name', name);
                    });
                });
            }

            // ─────────────────────────────────────────────
            // 10. UPDATE REMAINING AMOUNT
            // ─────────────────────────────────────────────
            function updateRemainingAmount() {
                let total = parseFloat($('#finalTotal').text()) || 0;

                if (!$('#toggle_split_payment').is(':checked')) {
                    $('#remaining_amount').text('0.00');
                    $('#remaining_amount_input').val('0.00');
                    return;
                }

                let paid = 0;
                $('.pay-amount').each(function() {
                    paid += parseFloat($(this).val()) || 0;
                });

                if (paid > total) {
                    let excess = paid - total;
                    let last = $('.pay-amount').last();
                    let fixed = parseFloat(last.val()) - excess;
                    last.val(fixed > 0 ? fixed.toFixed(2) : 0);
                    paid = total;

                    iziToast.warning({
                        title: 'Warning',
                        message: 'Payment cannot exceed Total Amount',
                        position: 'topRight',
                        timeout: 3000
                    });
                }

                let remaining = total - paid;
                $('#remaining_amount').text(remaining.toFixed(2));
                $('#remaining_amount_input').val(remaining.toFixed(2));
            }

            // ─────────────────────────────────────────────
            // 11. CALCULATE GRAND TOTAL
            // ─────────────────────────────────────────────
            window.calculateGrandTotal = function() {
                let subtotal = 0;
                let maxSinglePrice = 0;

                $('#productTableBody tr').not('#noProductsRow').each(function() {
                    let qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    let price = parseFloat($(this).find('.price-input').val()) || 0;
                    if (price > maxSinglePrice) maxSinglePrice = price;
                    let rowTotal = qty * price;
                    $(this).find('.row-total').text(rowTotal.toFixed(2));
                    subtotal += rowTotal;
                });

                $('#grandTotal').text(subtotal.toFixed(2));

                // Discount
                let discount = parseFloat($('#discount').val()) || 0;
                if (discount > subtotal) discount = subtotal;
                let taxableAmount = subtotal;

                // GST
                let gstPercent = parseFloat($('#gst_display').val()) || 0;
                let gstAmount = 0;

                if ($('#gst_yes').is(':checked')) {
                    $('#gst_display').prop('disabled', false).removeClass('bg-light');
                    $('#gst_amount').prop('disabled', false).prop('readonly', true).removeClass('bg-light');
                    if (gstPercent > 0) gstAmount = taxableAmount * (gstPercent / 100);
                } else {
                    $('#gst_display').val('').prop('disabled', true).addClass('bg-light').trigger(
                        'change.select2');
                    $('#gst_amount').val('0.00').prop('disabled', true).addClass('bg-light');
                    gstAmount = 0;
                }
                $('#gst_amount').val(gstAmount.toFixed(2));

                // TCS
                let tcsPercent = parseFloat($('#tcs_percentage').val()) || 0;
                let tcsAmount = 0;

                if (maxSinglePrice >= 1000000) {
                    $('#tcs_percentage').prop('disabled', false).removeClass('bg-light');
                    $('#tcs_display').prop('disabled', false).prop('readonly', true).removeClass('bg-light');
                    if (tcsPercent > 0) tcsAmount = subtotal * (tcsPercent / 100);
                } else {
                    $('#tcs_percentage').val('1').prop('disabled', true).addClass('bg-light').trigger(
                        'change.select2');
                    $('#tcs_display').val('0.00').prop('disabled', true).addClass('bg-light');
                    tcsAmount = 0;
                }
                $('#tcs_display').val(tcsAmount.toFixed(2));

                // Final total
                let finalTotal = subtotal + gstAmount + tcsAmount - discount;
                $('#finalTotal').text(finalTotal.toFixed(2));
                $('#finalTotal_input').val(finalTotal.toFixed(2));

                updateRemainingAmount();
            };

            // Recalculate on these changes
            $('#gst_display, #tcs_percentage, #discount').on('change input', function() {
                calculateGrandTotal();
            });
            $('input[name="gst_applicable"]').on('change', function() {
                calculateGrandTotal();
            });

            // ─────────────────────────────────────────────
            // 12. PRODUCT SEARCH
            // ─────────────────────────────────────────────
            let searchTimeout;
            $('#productSearch').on('keyup', function() {
                let query = $(this).val();
                let $list = $('#searchResults');
                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    $list.hide().html('');
                    return;
                }

                let locFrom = $('#location').val();

                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('product.search_autocomplete') }}",
                        type: "GET",
                        data: {
                            q: query,
                            location_id: locFrom
                        },
                        success: function(data) {
                            $list.html('');
                            if (data.length > 0) {
                                data.forEach(item => {

                                    let imgSrc = item.image ?
                                        item.image :
                                        'https://placehold.co/50x50?text=No+Img';

                                    let isOutStock = item.out_stock == 1;

                                    // ✅ Remove unwanted fields
                                    let cleanItem = {
                                        id: item.id,
                                        name: item.name,
                                        price: item.price,
                                        unit: item.unit,
                                        image: item.image,
                                        hsn_code: item.hsn_code,
                                        pro_sku: item.pro_sku
                                    };

                                    let listItem = `
<li class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-2
${isOutStock ? 'opacity-50 disabled-product' : 'cursor-pointer'}"
${!isOutStock ? `onclick='addProductToTable(${JSON.stringify(cleanItem)})'` : ''}>

    <img src="${imgSrc}" class="rounded border"
        style="width:40px;height:40px;object-fit:cover;">

    <div class="flex-grow-1">
        <div class="fw-semibold text-dark small">
            ${item.name}
            ${isOutStock ? '<span class="badge bg-danger ms-2">Out of Stock</span>' : ''}
        </div>

        <div class="text-muted small">
            Price: ${parseFloat(item.price).toFixed(2)} | Unit: ${item.unit}
        </div>
    </div>
</li>`;

                                    $list.append(listItem);
                                });

                                $list.show();
                            } else {
                                $list.html(
                                    '<li class="list-group-item text-muted small">No products found</li>'
                                ).show();
                            }
                        }
                    });
                }, 300);
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.position-relative').length) $('#searchResults').hide();
            });

            // ─────────────────────────────────────────────
            // 13. ADD PRODUCT TO TABLE
            // ─────────────────────────────────────────────
            window.addProductToTable = function(product) {
                $('#searchResults').hide();
                $('#productSearch').val('');
                $('#noProductsRow').remove();

                let rowId = 'row_' + Date.now();
                let imgSrc = product.image ? product.image : 'https://placehold.co/50x50?text=No+Img';

                $('#productTableBody').append(`
        <tr id="${rowId}" class="align-middle border-bottom">
            <td class="ps-3" style="width:25%;">
                <div class="d-flex align-items-center gap-2">
                    <img src="${imgSrc}" class="rounded border" style="width:35px;height:35px;object-fit:cover;">
                    <div>
                        <span class="fw-semibold text-dark d-block" style="font-size:.85rem;">${product.name}</span>
                        <input type="hidden" name="product_id[]" value="${product.id}">
                    </div>
                </div>
            </td>
            <td style="width:20%;"><input type="text" name="description[]" class="form-control" value="${product.product_desc || ''}"></td>
            <td style="width:12%;"><input type="text" name="hsn_code[]" class="form-control form-control-sm text-center" value="${product.hsn_code || ''}"></td>
            <td style="width:8%;"><input type="number" name="qty[]" class="form-control form-control-sm text-center qty-input" value="1" min="1" oninput="calculateGrandTotal()"></td>
            <td style="width:17%;"><input type="number" name="unit_price[]" class="form-control form-control-sm text-center price-input" value="${parseFloat(product.price).toFixed(2)}" step="0.01" oninput="calculateGrandTotal()"></td>
            <td class="row-total fw-bold text-dark text-end pe-3" style="width:13%;">0.00</td>
            <td class="text-center" style="width:5%;">
                <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeProductRow('${rowId}')">
                    <i class="bx bx-trash fs-5"></i>
                </button>
            </td>
        </tr>`);

                calculateGrandTotal();
            };

            // ─────────────────────────────────────────────
            // 14. REMOVE PRODUCT ROW
            // ─────────────────────────────────────────────
            window.removeProductRow = function(rowId) {
                $('#' + rowId).remove();
                if ($('#productTableBody tr').length === 0) {
                    $('#productTableBody').append(
                        '<tr id="noProductsRow"><td colspan="7" class="py-4 text-muted small">No products added yet</td></tr>'
                    );
                }
                calculateGrandTotal();
            };

            // ─────────────────────────────────────────────
            // 15. RESET FORM HELPER
            // ─────────────────────────────────────────────
            function resetPendingForm() {
                $('#saleForm')[0].reset();
                $('#saleForm').removeClass('was-validated');
                $('#saleForm').find('.form-control, .form-select').removeClass('is-valid is-invalid');
                $('#productTableBody').html(
                    '<tr id="noProductsRow"><td colspan="7" class="py-4 text-muted small">No products added yet</td></tr>'
                );
                $('.select2').val(null).trigger('change');
                $('#edit_sales_id').remove();
                $('#grandTotal').text('0.00');
                $('#finalTotal').text('0.00');
                $('#remaining_amount').text('0.00');
                $('#id_file_preview').html('');
                $('#existing_file_id').val('');
                $('#saveBtn').html('<i class="bx bx-save me-1"></i> Save');

                if (document.querySelector("#sale_date")?._flatpickr) {
                    document.querySelector("#sale_date")._flatpickr.clear();
                }

                $('#toggle_split_payment').prop('checked', false).trigger('change');
                $('#is_split_payment').val(0);
                splitIndex = 0;
            }

            // Switch back to list tab → reset form
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                if ($(e.target).attr('href') === '#listStock') {
                    $('#addSalesTab').addClass('d-none');
                    resetPendingForm();
                }
            });

            // ─────────────────────────────────────────────
            // 16. EDIT SALE — LOAD INTO FORM
            // ─────────────────────────────────────────────
            $(document).on('click', '.editSales', function() {
                let saleId = $(this).data('id');
                let url = "{{ route('sales.edit', ':id') }}".replace(':id', saleId);

                // Open edit tab
                let tabEl = document.querySelector('a[href="#addStock"]');
                if (tabEl) new bootstrap.Tab(tabEl).show();

                $('#addSalesTab').removeClass('d-none').text('Edit Sale');

                // Reset form first
                resetPendingForm();

                // Inject hidden sales_id
                $('<input>').attr({
                        type: 'hidden',
                        id: 'edit_sales_id',
                        name: 'sales_id',
                        value: saleId
                    })
                    .appendTo('#saleForm');

                $('#saveBtn').html('<i class="bx bx-save me-1"></i> Update');

                // Fetch sale data
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(res) {
                        if (res.status !== 200) {
                            iziToast.error({
                                title: 'Error',
                                message: 'Sale not found',
                                position: 'topRight'
                            });
                            return;
                        }

                        let s = res.sale;
                        let products = res.products || [];
                        let payments = res.payments || [];

                        // ── Split Payments ──────────────────────
                        if (payments.length > 0) {
                            $('#toggle_split_payment').prop('checked', true).trigger('change');
                            $('#is_split_payment').val(1);
                            $('#split_count').val(payments.length).trigger('input');

                            setTimeout(function() {
                                payments.forEach(function(pay, i) {
                                    let row = $('.payment-row').eq(i);
                                    if (!row.length) return;

                                    // Inject existing payment IDs for update
                                    row.append(`
                                <input type="hidden" class="payment-id"
                                    name="payment_split[${i}][payment_id]"
                                    value="${pay.sp_id || ''}">
                                <input type="hidden"
                                    name="payment_split[${i}][sales_id]"
                                    value="${pay.sales_id || ''}">
                            `);

                                    row.find('.payment-method').val(pay
                                        .payment_id || pay.method).trigger(
                                        'change');
                                    row.find('.pay-amount').val(parseFloat(pay
                                        .recieved_amount || 0).toFixed(
                                        2)).trigger('input');

                                    if (pay.cheque_no) row.find(
                                        'input[name*="[cheque_no]"]').val(
                                        pay.cheque_no);
                                    if (pay.transaction_no) row.find(
                                            'input[name*="[transaction_no]"]')
                                        .val(pay.transaction_no);
                                    if (pay.bank_acc) row.find(
                                            'input[name*="[bank_account_no]"]')
                                        .val(pay.bank_acc);
                                    if (pay.card_no) row.find(
                                        'input[name*="[card_no]"]').val(pay
                                        .card_no);
                                });

                                normalizePaymentIndexes();
                                updateRemainingAmount();
                            }, 150);

                        } else {
                            $('#toggle_split_payment').prop('checked', false).trigger('change');
                            $('#is_split_payment').val(0);
                        }

                        // ── Main Form Fields ────────────────────
                        $('#location').val(s.location).trigger('change');

                        if ($('#customer_id').find("option[value='" + s.customer_id + "']")
                            .length === 0) {
                            $('#customer_id').append(new Option(s.full_name, s.customer_id,
                                true, true));
                        }
                        $('#customer_id').val(s.customer_id).trigger('change');

                        if (document.querySelector("#sale_date")?._flatpickr) {
                            document.querySelector("#sale_date")._flatpickr.setDate(s
                                .sale_date);
                        }

                        $('#invoice_no').val(s.invoice_no);
                        $('#full_name').val(s.full_name);
                        $('#mobile_no').val(s.mobile_no);
                        $('#email').val(s.email);
                        $('#id_no').val(s.id_no);
                        $('#id_proof').val(s.id_proof).trigger('change');
                        $('#discount').val(s.discount);

                        if (s.gst_applicable === 'yes') {
                            $('#gst_yes').prop('checked', true);
                        } else {
                            $('#gst_no').prop('checked', true);
                        }
                        toggleGSTContainer();

                        $('#gst_number').val(s.gst_number);
                        $('#gst_display').val(s.gst_display).trigger('change');
                        $('#gst_amount').val(s.gst_amount);
                        $('#tcs_percentage').val(s.tcs_percentage).trigger('change');
                        $('#tcs_display').val(s.tcs_display);
                        $('#bill_status').val(s.bill_status).trigger('change');
                        $('#file_id').prop('disabled', false);

                        // ── Products ────────────────────────────
                        $('#productTableBody').empty();

                        if (products.length === 0) {
                            $('#productTableBody').html(
                                '<tr id="noProductsRow"><td colspan="7" class="py-4 text-muted small">No products added yet</td></tr>'
                            );
                        } else {
                            let assetBase = "{{ $actual_url . '/admin_assets/brand' }}";

                            products.forEach(function(p) {
                                let rowId = 'row_' + p.product_id + '_' + Date.now() +
                                    Math.random().toString(36).substr(2, 5);
                                let qty = parseFloat(p.qty) || 1;
                                let salesPrice = parseFloat(p.sales_price) || 0;
                                let unitPrice = qty > 0 ? (salesPrice / qty) : 0;
                                let imgSrc = 'https://placehold.co/50x50?text=No+Img';

                                if (p.pro_image && p.brand_folder && p.product_folder) {
                                    imgSrc =
                                        `${assetBase}/${p.brand_folder}/${p.product_folder}/image/${p.pro_image}`;
                                }

                                $('#productTableBody').append(`
                        <tr id="${rowId}" class="align-middle border-bottom">
                            <td class="ps-3" style="width:25%;">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="${imgSrc}" class="rounded border" style="width:35px;height:35px;object-fit:cover;">
                                    <div>
                                        <span class="fw-semibold d-block" style="font-size:.85rem;">${p.pro_name || 'Unknown'}</span>
                                        <input type="hidden" name="product_id[]" value="${p.product_id}">
                                    </div>
                                </div>
                            </td>
                            <td style="width:20%;"><input type="text" name="description[]" class="form-control" value="${p.description || ''}"></td>
                            <td style="width:12%;"><input type="text" name="hsn_code[]" class="form-control form-control-sm text-center" value="${p.hsn_code || ''}"></td>
                            <td style="width:8%;"><input type="number" name="qty[]" class="form-control form-control-sm text-center qty-input" value="${qty}" min="1" oninput="calculateGrandTotal()"></td>
                            <td style="width:17%;"><input type="number" name="unit_price[]" class="form-control form-control-sm text-center price-input" value="${unitPrice.toFixed(2)}" step="0.01" oninput="calculateGrandTotal()"></td>
                            <td class="row-total fw-bold text-dark text-end pe-3" style="width:13%;">${salesPrice.toFixed(2)}</td>
                            <td class="text-center" style="width:5%;">
                                <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeProductRow('${rowId}')">
                                    <i class="bx bx-trash fs-5"></i>
                                </button>
                            </td>
                        </tr>`);
                            });
                        }

                        calculateGrandTotal();

                        // ── File Preview ────────────────────────
                        if (s.file_id) {
                            $('#existing_file_id').val(s.file_id);
                            let fileUrl =
                                "{{ $actual_url . '/admin_assets/sales_document' }}/" + s
                                .file_id;
                            $('#id_file_preview').html(
                                `<a href="${fileUrl}" target="_blank" class="text-primary small">View File</a>`
                            );
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to load sale data',
                            position: 'topRight'
                        });
                    }
                });
            });

            // ─────────────────────────────────────────────
            // 17. FORM SUBMIT — UPDATE PENDING SALE
            // ─────────────────────────────────────────────
            $('#saleForm').on('submit', function(e) {
                normalizePaymentIndexes();

                let form = this; // ✅ DEFINE FORM

                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(form).addClass('was-validated'); // shows invalid-feedback
                    return;
                }
                e.preventDefault();

                // Basic Validation
                if ($('#productTableBody input[name="product_id[]"]').length === 0) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Please add at least one product.',
                        position: 'topRight'
                    });
                    return;
                }

                $('#saveBtn').addClass('d-none');
                $('#loadingBtn').removeClass('d-none');

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('sales.pending.update') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#saveBtn').removeClass('d-none');
                        $('#loadingBtn').addClass('d-none');

                        if (response.status === 200) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });

                            console.log(response.redirect); // ✅ debug check

                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1000);
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#saveBtn').removeClass('d-none');
                        $('#loadingBtn').addClass('d-none');

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                iziToast.error({
                                    title: 'Validation',
                                    message: value[0],
                                    position: 'topRight'
                                });
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: 'Something went wrong.',
                                position: 'topRight'
                            });
                        }
                    }
                });
            });

            // ─────────────────────────────────────────────
            // 18. APPROVE SALE
            // ─────────────────────────────────────────────
            $(document).on('click', '.approve-sale', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to approve this sale?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then(function(result) {
                    if (!result.isConfirmed) return;
                    $.ajax({
                        url: "{{ route('sales.approve') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status === 200) {
                                Swal.fire('Approved!', res.message, 'success');
                                pendingTable.ajax.reload(null, false);
                            } else {
                                Swal.fire('Error!', res.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                });
            });

            // ─────────────────────────────────────────────
            // 19. DELETE SALE
            // ─────────────────────────────────────────────
            $(document).on('click', '.delete-sale', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(result) {
                    if (!result.isConfirmed) return;
                    $.ajax({
                        url: "{{ route('sales.pending.delete') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status === 200) {
                                Swal.fire('Deleted!', res.message, 'success');
                                if ($.fn.DataTable.isDataTable('#pendingSalesTable')) {
                                    $('#pendingSalesTable').DataTable().ajax.reload(
                                        null, false);
                                }
                            } else {
                                Swal.fire('Error!', res.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                });
            });

            // ─────────────────────────────────────────────
            // 20. CANCEL SALE
            // ─────────────────────────────────────────────
            $(document).on('click', '.cancel-sale', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to cancel this sale?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f0ad4e',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then(function(result) {
                    if (!result.isConfirmed) return;
                    $.ajax({
                        url: "{{ route('sales.cancel') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status === 200) {
                                Swal.fire('Cancelled!', res.message, 'success');
                                pendingTable.ajax.reload(null, false);
                            } else {
                                Swal.fire('Error!', res.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                });
            });

            // ─────────────────────────────────────────────
            // 21. PRINT & VIEW SALE
            // ─────────────────────────────────────────────
            $(document).on('click', '.printSale', function() {
                window.open("{{ route('sales.print', ':id') }}".replace(':id', $(this).data('id')),
                    '_blank');
            });

            $(document).on('click', '.view-sale', function() {
                let url = "{{ route('sales.show', ':id') }}".replace(':id', $(this).data('id'));

                $.get(url, function(response) {
                    if (response.status !== 200) return;

                    let d = response.data;
                    let products = response.products || [];

                    let productRows = '';
                    if (products.length > 0) {
                        products.forEach(function(p, i) {
                            productRows += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${p.pro_name || 'Product'}<br><small class="text-muted">${p.description || ''}</small></td>
                        <td>${p.hsn_code || '-'}</td>
                        <td class="text-center">${p.qty}</td>
                        <td class="text-end">${parseFloat(p.mrp).toFixed(2)}</td>
                        <td class="text-end fw-bold">${parseFloat(p.sales_price).toFixed(2)}</td>
                    </tr>`;
                        });
                    } else {
                        productRows =
                            '<tr><td colspan="6" class="text-center text-muted">No products found</td></tr>';
                    }

                    $('#saleDetailsContent').html(`
            <div class="row mb-4">
                <div class="col-md-6 border-end">
                    <h6 class="fw-bold text-primary mb-3">Invoice Info</h6>
                    <div class="d-flex mb-2"><span class="fw-semibold me-2 w-25">Invoice No:</span><span>${d.invoice_no}</span></div>
                    <div class="d-flex mb-2"><span class="fw-semibold me-2 w-25">Date:</span><span>${d.sale_date}</span></div>
                    <div class="d-flex mb-2"><span class="fw-semibold me-2 w-25">Location:</span><span>${d.location_name}</span></div>
                    <h6 class="fw-bold text-primary mt-4 mb-3">Customer Details</h6>
                    <div class="d-flex mb-2"><span class="fw-semibold me-2 w-25">Name:</span><span>${d.customer_name}</span></div>
                    <div class="d-flex mb-2"><span class="fw-semibold me-2 w-25">Mobile:</span><span>${d.mobile_no}</span></div>
                    <div class="d-flex mb-2"><span class="fw-semibold me-2 w-25">Email:</span><span>${d.email}</span></div>
                </div>
                <div class="col-md-6 ps-4">
                    <h6 class="fw-bold text-primary mb-3">Payment Status</h6>
                    <div class="d-flex mb-2 align-items-center">
                        <span class="fw-semibold me-2 w-25">Bill Status:</span>
                        <span class="badge bg-${d.bill_status === 'Paid' ? 'success' : 'warning'}">${d.bill_status}</span>
                    </div>
                    <div class="d-flex mb-2"><span class="fw-semibold me-2 w-25">GST No:</span><span>${d.gst_number || 'N/A'}</span></div>
                    <div class="p-3 bg-light rounded border mt-3">
                        <div class="d-flex justify-content-between mb-1 text-muted"><span>GST Amount:</span><span>+ ${parseFloat(d.gst_amount).toFixed(2)}</span></div>
                        <div class="d-flex justify-content-between mb-1 text-muted"><span>TCS Amount:</span><span>+ ${parseFloat(d.tcs_display).toFixed(2)}</span></div>
                        <div class="d-flex justify-content-between mb-1 text-danger"><span>Discount:</span><span>- ${parseFloat(d.discount).toFixed(2)}</span></div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between fs-5 fw-bold text-primary"><span>Grand Total:</span><span>${parseFloat(d.finalTotal).toFixed(2)}</span></div>
                        <div class="d-flex justify-content-between mt-2 small text-muted"><span>Paid:</span><span>${parseFloat(d.payment_split_amount).toFixed(2)}</span></div>
                        <div class="d-flex justify-content-between small text-danger fw-bold"><span>Balance:</span><span>${parseFloat(d.remaining_amount).toFixed(2)}</span></div>
                    </div>
                </div>
            </div>
            <div class="table-responsive border rounded-2 mt-2">
                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-primary text-white">
                        <tr><th>#</th><th>Product</th><th>HSN</th><th class="text-center">Qty</th><th class="text-end">MRP</th><th class="text-end">Total</th></tr>
                    </thead>
                    <tbody>${productRows}</tbody>
                </table>
            </div>`);

                    $('#viewSaleModal').modal('show');
                });
            });

        }); // end document.ready
    </script>
</body>

</html>
