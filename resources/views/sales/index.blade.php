<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')

{{-- <style>
    /* Fix Select2 inside Input Group */
    .input-group .select2-container {
        width: 100% !important;
        /* Force full width within the flex item */
        flex: 1 1 auto;
    }

    .input-group .select2-selection {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        height: 38px !important;
        /* Match Bootstrap standard input height */
        border-color: #dee2e6 !important;
        /* Match Input border */
        display: flex;
        align-items: center;
    }

    .input-group .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 12px !important;
    }

    .input-group .select2-selection__arrow {
        height: 36px !important;
    }
</style> --}}

<style>
    .dt-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 15px;
        width: 100%;
    }

    /* ✅ Button Styling matching Contact/Inventory */
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
</style>
<style>
    .product-search-wrapper {
        width: 100%;
        max-width: 550px;
        /* 🔥 adjust size here (400–600 looks best) */
    }

    #searchResults {
        width: 100%;
        z-index: 1000;
        display: none;
        max-height: 300px;
        overflow-y: auto;
    }
</style>
<style>
    #toggle_split_payment {
        cursor: pointer;
    }

    label[for="toggle_split_payment"] {
        cursor: pointer;
    }

    .split-section {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transform: translateY(-10px);
        transition:
            max-height 0.4s ease,
            opacity 0.3s ease,
            transform 0.3s ease;
    }

    .split-section.show {
        max-height: 800px;
        /* adjust if needed */
        opacity: 1;
        transform: translateY(0);
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Sales Management</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Stock-Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add Stock</li>
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
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listStock"
                                            role="tab">
                                            Sale List
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="addSalesTab" data-bs-toggle="tab" href="#addStock"
                                            role="tab">
                                            Add Sale
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="p-3" id="salesFilterSection">
                                <div class="row g-3 align-items-end">

                                    <!-- Business Location -->
                                    <div class="col-md-3">
                                        <label class="form-label">Business Location</label>
                                        <select id="filter_business_location" class="form-select select2">
                                            <option value="">All Locations</option>
                                            @foreach ($store_location as $location)
                                                <option value="{{ $location->bl_id }}">
                                                    {{ $location->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Period -->
                                    <div class="col-md-2">
                                        <label class="form-label small text-muted mb-1">Select Period</label>
                                        <select id="dateRangePreset" class="form-select form-select-sm">
                                            <option value="">Select Period</option>
                                            <option value="today">Today</option>
                                            <option value="this_week">This Week</option>
                                            <option value="this_month">This Month</option>
                                            <option value="this_quarter">This Quarter</option>
                                            <option value="this_year">This Year</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="previous_week">Previous Week</option>
                                            <option value="previous_month">Previous Month</option>
                                            <option value="previous_quarter">Previous Quarter</option>
                                            <option value="previous_year">Previous Year</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </div>

                                    <!-- Date Range -->
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted mb-1">Date Range</label>
                                        <input type="text" id="CustomerDateRange"
                                            class="form-control form-control-sm shadow-none"
                                            placeholder="Select date range" readonly>
                                    </div>

                                    <!-- View Button -->
                                    <div class="col-md-auto">
                                        <button class="btn btn-primary" id="viewFilter" type="button">
                                            <i class="bx bx-filter-alt"></i> View
                                        </button>
                                    </div>


                                </div>
                            </div>


                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="listStock" role="tabpanel">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-end mb-2 gap-2">

                                            <!-- 🔥 Refresh Button -->
                                            <button class="btn btn-sm btn-primary" id="refreshTable">
                                                <i class='bx bx-refresh'></i> Refresh
                                            </button>
                                        </div>
                                        <table id="salesTable"
                                            class="table table-bordered table-striped text-center w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Invoice No</th>
                                                    <th>Customer</th>
                                                    <th>Location</th>
                                                    <th>Remaining Amount</th>
                                                    <th>Total Amount</th>
                                                    <th>Bill Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="addStock" role="tabpanel">
                                    <div class="p-3">
                                        <h5 class="card-title mb-4" style="color:#2A2E72">Add Sale</h5>

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
                                                    <select class="form-select bg-light" name="location"
                                                        id="location" required>
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
                                                        <span
                                                            class="input-group-text bg-light border-end-0 text-muted">
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
                <!-- End::row-1 -->

            </div>
        </div>


        <div class="modal fade" id="viewSaleModal" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title d-flex align-items-center">
                            <i class="bx bx-receipt me-2"></i> Sale Details
                        </h6>
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
        <!-- Description Modal -->
        <div class="modal fade" id="descriptionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Product Description</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="current_row_id">

                        <textarea id="modal_desc_textarea" class="form-control" rows="5" placeholder="Enter description..."></textarea>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" onclick="saveModalDesc()">Save</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editdescriptionModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Product Description</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="descriptionModalBody"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="walkInCustomerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add Walk-In Customer</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form id="walkInForm">
                            @csrf
                            <input type="hidden" name="contact_master_id" value="">

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Contact Type</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input w-type-toggle" type="radio"
                                                name="is_business" value="0" id="w_individual" checked>
                                            <label class="form-check-label" for="w_individual">Individual</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input w-type-toggle" type="radio"
                                                name="is_business" value="1" id="w_business">
                                            <label class="form-check-label" for="w_business">Business</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4 w-individual-row">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="w_first_name"
                                        class="form-control w-req-field">
                                    <div class="invalid-feedback">First Name is required.</div>
                                </div>
                                <div class="col-md-4 w-individual-row">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="middle_name" class="form-control">
                                </div>
                                <div class="col-md-4 w-individual-row">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control">
                                </div>

                                <div class="col-md-6 w-business-row d-none">
                                    <label class="form-label">Business Name <span class="text-danger">*</span></label>
                                    <input type="text" name="business_name" id="w_business_name"
                                        class="form-control">
                                    <div class="invalid-feedback">Business Name is required.</div>
                                </div>
                                <div class="col-md-6 w-business-row d-none">
                                    <label class="form-label">GST Number</label>
                                    <input type="text" name="gst_number" id="w_gst_number" class="form-control">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" id="w_mobile"
                                        class="form-control w-req-field" maxlength="10">
                                    <div class="invalid-feedback">Valid 10-digit Mobile Number is required.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="w_email"
                                        class="form-control w-req-field">
                                    <div class="invalid-feedback">Valid Email is required.</div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">ID Proof Type <span class="text-danger">*</span></label>
                                    <select name="id_proof_type" id="w_id_proof_type"
                                        class="form-select w-req-field">
                                        <option value="">Please Select</option>
                                        <option value="Adhar Card">Adhar Card</option>
                                        <option value="Pan Card">Pan Card</option>
                                        <option value="Driving Licence">Driving Licence</option>
                                        <option value="Voter Id">Voter Id</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select an ID Proof Type.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ID Number <span class="text-danger">*</span></label>
                                    <input type="text" name="id_number" id="w_id_number"
                                        class="form-control w-req-field">
                                    <div class="invalid-feedback">ID Number is required.</div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveWalkInBtn">Save Customer</button>
                    </div>
                </div>
            </div>
        </div>


        @include('partials.footer')
    </div>
    @include('partials.footer_link')
    <script>
        let paymentMethods = @json($payment_method);
    </script>
    <script>
        function numberToWords(num) {
            const a = [
                '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven',
                'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen',
                'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
            ];
            const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

            function inWords(n) {
                if (n < 20) return a[n];
                if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? ' ' + a[n % 10] : '');
                if (n < 1000) return a[Math.floor(n / 100)] + ' Hundred' + (n % 100 ? ' ' + inWords(n % 100) : '');
                if (n < 100000) return inWords(Math.floor(n / 1000)) + ' Thousand' + (n % 1000 ? ' ' + inWords(n % 1000) :
                    '');
                if (n < 10000000) return inWords(Math.floor(n / 100000)) + ' Lakh' + (n % 100000 ? ' ' + inWords(n %
                    100000) : '');
                return inWords(Math.floor(n / 10000000)) + ' Crore' + (n % 10000000 ? ' ' + inWords(n % 10000000) : '');
            }

            return inWords(Math.floor(num)) + ' Only';
        }
        $(document).ready(function() {



            let splitIndex = 0;
            let autoEditId = new URLSearchParams(window.location.search).get('edit_id');


            const params = new URLSearchParams(window.location.search);
            const editId = params.get('edit_id');

            if (editId) {

                console.log('Auto Edit Trigger:', editId);

                // wait for DataTable render (important)


                // clean URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }


            $('#add_payment_split').on('click', function() {
                addPaymentRow();
            });

            $(document).on('focus', '#discount', function() {
                if (this.value == 0) this.value = '';
            });

            $(document).on('blur', '#discount', function() {
                if (this.value === '') this.value = 0;
            });


            // 1️⃣ Initialize datepicker & select2
            $("#sale_date").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: new Date(),
                allowInput: false
            });

            $('#location, #bill_status, #id_proof, #customer_id').select2({
                placeholder: "Please Select",
                allowClear: true,
                width: '100%'
            });

            $('#filter_business_location').select2({
                placeholder: "Select Business Location",
                allowClear: true,
                width: '100%'
            });

            $('#dateRangePreset').select2({
                placeholder: "Select Date range",
                allowClear: true,
                width: '100%'
            });

            let datePicker = flatpickr("#CustomerDateRange", {
                mode: "range",
                dateFormat: "Y-m-d",
                conjunction: " to ", // ✅ VERY IMPORTANT
                allowInput: false
            });



            $('#tcs_percentage', '#gst_display').select2({
                placeholder: "1%",
                minimumResultsForSearch: -1,
                width: '100%'
            });

            $('#w_id_proof_type').select2({
                dropdownParent: $('#walkInCustomerModal'), // This binds it to the modal
                placeholder: "Please Select",
                allowClear: true,
                width: '100%'
            });


            function addPaymentRow() {

                let options = '';
                paymentMethods.forEach(method => {
                    let selected = method.payment === 'Cash' ? 'selected' : '';
                    options += `<option value="${method.payment}" ${selected}>${method.payment}</option>`;
                });

                let row = `
<div class="card p-3 mb-2 payment-row" data-index="${splitIndex}">
   <input type="hidden"
        name="payment_split[${splitIndex}][payment_id]"
        value="">

    <div class="row g-3 align-items-end">

        <div class="col-md-3">
            <label class="form-label">Method</label>
           <select name="payment_split[${splitIndex}][method]"
                    class="form-select payment-method">
                ${options}
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Pay Amount</label>
     <input name="payment_split[${splitIndex}][amount]"
                class="form-control pay-amount"
                value="0">
        </div>

       <div class="col-md-4 extra-field"></div>


     <div class="col-md-2 text-center">
    <button type="button"
        class="btn btn-outline-danger btn-sm remove-payment">
        <i class="bx bx-trash"></i>
    </button>
</div>


    </div>
</div>`;


                $('#payment_split_container').append(row);

                splitIndex++;
                updateRemainingAmount();
                updateTrashButtons();
            }


            function updateTrashButtons() {
                $('.payment-row .remove-payment').show();
            }



            // Change Fields Based On Method
            $(document).on('change', '.payment-method', function() {

                let method = $(this).val();
                let row = $(this).closest('.payment-row');
                let index = row.data('index'); // ✅ GET CORRECT ROW INDEX
                let extraField = row.find('.extra-field');

                extraField.html('');

                if (method === 'Cash') {
                    return;
                }

                if (method === 'Cheque') {

                    extraField.html(`
            <label class="form-label">Cheque No</label>
            <input type="text"
                name="payment_split[${index}][cheque_no]"
                class="form-control"
                placeholder="Enter Cheque Number">
        `);

                } else if (method === 'Online Bank Transfer') {

                    extraField.html(`
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Transaction No</label>
                    <input type="text"
                        name="payment_split[${index}][transaction_no]"
                        class="form-control"
                        placeholder="Enter Transaction Number">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bank Account No</label>
                    <input type="text"
                        name="payment_split[${index}][bank_account_no]"
                        class="form-control"
                        placeholder="Enter Bank Account">
                </div>
            </div>
        `);

                } else if (method === 'Card') {

                    extraField.html(`
            <label class="form-label">Card No</label>
            <input type="text"
                name="payment_split[${index}][card_no]"
                class="form-control"
                maxlength="16"
                placeholder="Enter Card Number">
        `);

                } else {

                    extraField.html(`
            <label class="form-label">Transaction No</label>
            <input type="text"
                name="payment_split[${index}][transaction_no]"
                class="form-control"
                placeholder="Enter Transaction Number">
        `);
                }
            });


            $(document).on('click', '.remove-payment', function() {

                $(this).closest('.payment-row').remove();

                // 🔥 check remaining rows
                let remainingRows = $('.payment-row').length;

                if (remainingRows === 0) {

                    // turn OFF toggle and run its change event
                    $('#toggle_split_payment')
                        .prop('checked', false)
                        .trigger('change');

                    return; // stop further execution
                }

                updateRemainingAmount();
                updateTrashButtons();
            });




            $(document).on('input', '.pay-amount', function() {
                updateRemainingAmount();
            });

            $('#toggle_split_payment').on('change', function() {

                if ($(this).is(':checked')) {

                    $('#is_split_payment').val(1); // ✅ SET ON

                    $('#split_payment_section').addClass('show');

                    $('#split_count').val(1);
                    $('#payment_split_container').html('');
                    addPaymentRow();

                } else {

                    $('#is_split_payment').val(0); // ✅ SET OFF

                    $('#split_payment_section').removeClass('show');
                    $('#payment_split_container').html('');
                    $('#split_count').val(1);

                    $('#remaining_amount').text('0.00');
                    $('#remaining_amount_input').val('0.00');
                }
            });




            $('#split_count').on('input', function() {

                if (!$('#toggle_split_payment').is(':checked')) return;

                let count = parseInt($(this).val()) || 1;

                if (count < 1) count = 1;
                if (count > 10) count = 10;

                $(this).val(count);

                let currentRows = $('.payment-row').length;

                if (count > currentRows) {
                    for (let i = currentRows; i < count; i++) {
                        addPaymentRow();
                    }
                }

                if (count < currentRows) {
                    $('.payment-row').slice(count).remove();
                }

                updateRemainingAmount();
            });


            $('#split_count').on('keypress', function(e) {
                if (e.which === 45 || e.which === 48) {
                    e.preventDefault(); // prevent '-' and leading 0
                }
            });


            $('#dateRangePreset').on('change', function() {

                let val = $(this).val();
                let today = new Date();
                let start, end;

                switch (val) {

                    case 'today':
                        start = end = today;
                        break;

                    case 'yesterday':
                        start = end = new Date(today.setDate(today.getDate() - 1));
                        break;

                    case 'this_week':
                        start = new Date();
                        start.setDate(today.getDate() - today.getDay());
                        end = new Date();
                        break;

                    case 'previous_week':
                        start = new Date();
                        start.setDate(today.getDate() - today.getDay() - 7);
                        end = new Date();
                        end.setDate(start.getDate() + 6);
                        break;

                    case 'this_month':
                        start = new Date(today.getFullYear(), today.getMonth(), 1);
                        end = new Date();
                        break;

                    case 'previous_month':
                        start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        end = new Date(today.getFullYear(), today.getMonth(), 0);
                        break;

                    case 'this_year':
                        start = new Date(today.getFullYear(), 0, 1);
                        end = new Date();
                        break;

                    case 'previous_year':
                        start = new Date(today.getFullYear() - 1, 0, 1);
                        end = new Date(today.getFullYear() - 1, 11, 31);
                        break;

                    case 'custom':
                        datePicker.clear();

                        // 🔥 open calendar automatically
                        setTimeout(function() {
                            datePicker.open();
                        }, 100);

                        return;

                }

                datePicker.setDate([start, end], true);
            });




            var salesTable = $('#salesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sales.list') }}",
                    data: function(d) {

                        d.business_location = $('#filter_business_location').val();

                        let range = $('#CustomerDateRange').val();

                        if (range) {
                            let dates = range.split(" to ");
                            d.start_date = dates[0];
                            d.end_date = dates[1] ?? dates[0];
                        }
                    }
                },
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
                        data: 'remain_amount'
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

                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: 10,

                // ✅ Exact DOM Layout from Product Page
                dom: "<'row mb-2 align-items-center'" +
                    "<'col-lg-2 col-md-3'l>" +
                    "<'col-lg-7 col-md-6 text-center'B>" +
                    "<'col-lg-3 col-md-3 text-end'f>" +
                    ">" +
                    "rtip",

                buttons: [
                    // COPY
                    {
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light', // Ensure this class exists in your CSS
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Exclude Action
                        }
                    },

                    // CSV
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },

                    // EXCEL
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },

                    // PRINT
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },

                    // COLUMN VISIBILITY
                    {
                        extend: 'colvis',
                        text: '<i class="bx bx-columns"></i> Column visibility',
                        className: 'dt-btn-light'
                    },

                    // PDF
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bx bx-file-blank"></i> Export to PDF',
                        className: 'dt-btn-light',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        customize: function(doc) {
                            doc.pageMargins = [10, 10, 10, 10];
                            var table = doc.content[1].table;
                            table.widths = Array(table.body[0].length).fill('*');
                        }
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search sales...",
                }
            });


            $('#refreshTable').on('click', function() {
                salesTable.ajax.reload(null, false);
            });


            $('#salesTable').on('draw.dt', function() {

                if (autoEditId) {

                    console.log('Auto triggering edit for:', autoEditId);

                    let btn = $('.editSales[data-id="' + autoEditId + '"]');

                    if (btn.length) {
                        btn.trigger('click');

                        // run only once
                        autoEditId = null;

                        // clean URL
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                }
            });



            $('#viewFilter').on('click', function() {
                salesTable.ajax.reload();
            });


            function resetSalesForm() {
                $('#saleForm')[0].reset();

                $('#saleForm').removeClass('was-validated');
                $('#saleForm').find('.form-control, .form-select').removeClass('is-valid is-invalid');

                $('#saleForm').find('input, select, textarea').each(function() {
                    $(this).prop('disabled', false);
                    $(this).prop('readonly', false);
                    $(this).removeClass('bg-light');
                });

                $('#sale_date').css('pointer-events', 'auto');
                $('#productSearch').prop('disabled', false).attr('placeholder', 'Type product name or sku');

                $('#saleForm select').val(null).trigger('change');

                $('.locked-hidden-field').remove();
                $('#edit_sales_id').remove();

                $('#saveBtn').text('Save');
                $('#addSalesTab').text('Add Sale');
                $('#productTableBody').html(
                    '<tr id="noProductsRow"><td colspan="7" class="py-4 text-muted small">No products added yet</td></tr>'
                );

                $('#grandTotal').text('0.00');
                $('#finalTotal').text('0.00');
                $('#remaining_amount').text('0.00');
                $('#id_file_preview').html('');
                $('#existing_file_id').val('');

                if (document.querySelector("#sale_date")?._flatpickr) {
                    document.querySelector("#sale_date")._flatpickr.setDate(new Date());
                }

                $('#toggle_split_payment')
                    .prop('checked', false)
                    .trigger('change'); // 🔥 IMPORTANT (runs toggle logic)

                $('#is_split_payment').val(0);
                splitIndex = 0;

                isEditing = false;
            }

            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {

                let target = $(e.target).attr('href');

                // ✅ Hide / Show Filter
                if (target === '#addStock') {
                    $('#salesFilterSection').slideUp(150);
                    resetSalesForm(); // reset when opening Add Sale
                } else if (target === '#listStock') {
                    $('#salesFilterSection').slideDown(150);
                }
            });

            $(document).on('click', '.view-sale', function() {

                var id = $(this).data('id');
                var url = "{{ route('sales.show', ':id') }}".replace(':id', id);

                $.get(url, function(response) {

                    if (response.status === 200) {

                        var d = response.data;
                        var products = response.products || [];
                        var payments = response.payments || [];

                        /* ================= PRODUCTS ================= */

                        var productRows = '';

                        if (products.length > 0) {

                            products.forEach(function(p, index) {

                                productRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>
                                ${p.pro_name || 'Product'}
                                <br>
                                <small class="text-muted">${p.description || ''}</small>
                            </td>
                            <td>${p.hsn_code || '-'}</td>
                            <td class="text-center">${p.qty}</td>
                            <td class="text-end">
    ${(parseFloat(p.mrp) || 0).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}
</td>
                          <td class="text-end fw-bold">
    ${(parseFloat(p.sales_price) || 0).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}
</td>
                        </tr>`;
                            });

                        } else {
                            productRows =
                                '<tr><td colspan="6" class="text-center text-muted">No products found</td></tr>';
                        }


                        /* ================= PAYMENTS ================= */

                        let paymentRows = '';

                        if (payments.length > 0) {

                            payments.forEach(function(pay, i) {

                                paymentRows += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${pay.payment_method || pay.payment_id || '-'}</td>
                          <td class="text-end">
    ${(parseFloat(pay.recieved_amount) || 0).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}
</td>
                            <td>${pay.transaction_no ?? '-'}</td>
                            <td>${pay.card_no ?? pay.cheque_no ?? pay.bank_acc ?? '-'}</td>
                        </tr>`;
                            });

                        } else {

                            paymentRows = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No payment records
                        </td>
                    </tr>`;
                        }


                        /* ================= MODAL HTML ================= */

                        var html = `
            <div class="row mb-4">
                <div class="col-md-6 border-end">

                    <h6 class="fw-bold text-primary mb-3">Invoice Info</h6>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Invoice No:</span>
                        <span>${d.invoice_no}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Date:</span>
                        <span>${new Date(d.sale_date).toLocaleDateString('en-GB')}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Location:</span>
                        <span>${d.location_name}</span>
                    </div>

                    <h6 class="fw-bold text-primary mt-4 mb-3">Customer Details</h6>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Name:</span>
                        <span>${d.customer_name}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Mobile:</span>
                        <span>${d.mobile_no}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Email:</span>
                        <span>${d.email}</span>
                    </div>

                </div>

                <div class="col-md-6 ps-4">

                    <h6 class="fw-bold text-primary mb-3">Payment Status</h6>

                    <div class="d-flex mb-2 align-items-center">
                        <span class="fw-semibold me-2 w-25">Bill Status:</span>
                        <span class="badge bg-${d.bill_status === 'Paid' ? 'success' : 'warning'}">
                            ${d.bill_status}
                        </span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">GST No:</span>
                        <span>${d.gst_number || 'N/A'}</span>
                    </div>

                    <div class="p-3 bg-light rounded border mt-3">
${Number(d.isSameState) === 1 ? `
                                                                    <div class="d-flex justify-content-between text-muted">
                                                                        <span>CGST:</span>
                                                                        <span>+ ${((parseFloat(d.gst_amount) || 0) / 2).toLocaleString('en-IN', {
                                                                            minimumFractionDigits: 2,
                                                                            maximumFractionDigits: 2
                                                                        })}</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between text-muted">
                                                                        <span>SGST:</span>
                                                                        <span>+ ${((parseFloat(d.gst_amount) || 0) / 2).toLocaleString('en-IN', {
                                                                            minimumFractionDigits: 2,
                                                                            maximumFractionDigits: 2
                                                                        })}</span>
                                                                    </div>
                                                                ` : `
                                                                    <div class="d-flex justify-content-between text-muted">
                                                                        <span>IGST:</span>
                                                                        <span>+ ${(parseFloat(d.gst_amount) || 0).toLocaleString('en-IN', {
                                                                            minimumFractionDigits: 2,
                                                                            maximumFractionDigits: 2
                                                                        })}</span>
                                                                    </div>
                                                                `}

                        <div class="d-flex justify-content-between text-muted">
                            <span>TCS Amount:</span>
                            <span>+ ${(parseFloat(d.tcs_display) || 0).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}</span>
                        </div>

                        <div class="d-flex justify-content-between text-danger">
                            <span>Discount:</span>
                          <span>- ${(parseFloat(d.discount) || 0).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
})}</span>
                        </div>

                        <hr>



                        <div class="d-flex justify-content-between small text-muted">
                            <span>Paid:</span>
                            <span>${(parseFloat(d.payment_split_amount) || 0).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
})}</span>
                        </div>

                        <div class="d-flex justify-content-between small text-danger fw-bold">
                            <span>Balance:</span>
                            <span>${(parseFloat(d.remaining_amount) || 0).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
})}</span>
                        </div>
                                              <div class="d-flex justify-content-between fs-5 fw-bold text-primary">
    <span>Grand Total:</span>
    <span>${(parseFloat(d.finalTotal) || 0).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}</span>
</div>

<div class="text-end small text-muted fw-semibold mt-1">
    (${numberToWords(parseFloat(d.finalTotal || 0))})
</div>

                    </div>
                </div>
            </div>

            <!-- PRODUCTS -->
            <div class="table-responsive border rounded-2 mt-2">
                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>HSN</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">MRP</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>${productRows}</tbody>
                </table>
            </div>

            <!-- PAYMENTS -->
            <div class="table-responsive border rounded-2 mt-4">
                <h6 class="fw-bold text-primary p-2">Payment Details</h6>

                <table class="table table-bordered mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Method</th>
                            <th class="text-end">Amount</th>
                            <th>Transaction No</th>
                            <th>Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${paymentRows}
                    </tbody>
                </table>
            </div>
            `;

                        $('#saleDetailsContent').html(html);
                        $('#viewSaleModal').modal('show');
                    }
                });
            });


            function normalizePaymentIndexes() {

                $('.payment-row').each(function(i) {

                    $(this).attr('data-index', i);

                    // update all input names
                    $(this).find('[name]').each(function() {

                        let name = $(this).attr('name');

                        if (!name) return;

                        name = name.replace(/payment_split\[\d+\]/, 'payment_split[' + i + ']');

                        $(this).attr('name', name);
                    });
                });

            }


            // ------------------------------------------
            // 2. Handle Form Submission (Insert)
            // ------------------------------------------
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
                    url: "{{ route('sales.store') }}",
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


            // 2️⃣ Disable same location in both dropdowns
            function updateLocationDropdowns(sourceId, targetId) {
                let selectedValue = $(sourceId).val();
                $(targetId).find('option').prop('disabled', false);
                if (selectedValue) {
                    $(targetId).find('option[value="' + selectedValue + '"]').prop('disabled', true);
                }
                $(targetId).trigger('change.select2');
            }

            $('#location').on('change', function() {
                updateLocationDropdowns('#location_from', '#location_to');

                // Reset products when location changes
                $('#productTableBody').html(`
            <tr id="noProductsRow">
                <td colspan="5" class="py-4 text-muted small">No products added yet</td>
            </tr>
        `);
                calculateGrandTotal();
            });

            $('#location_to').on('change', function() {
                updateLocationDropdowns('#location_to', '#location_from');
            });


            // 2️⃣ Product search with location filter
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
                if (!locFrom) {
                    $list.html('<li class="list-group-item text-danger small">Select a location first</li>')
                        .show();
                    return;
                }

                searchTimeout = setTimeout(() => {
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

            // 🔁 Add product to Table
            window.addProductToTable = function(product) {
                $('#searchResults').hide();
                $('#productSearch').val('');
                $('#noProductsRow').remove();

                // Prevent duplicates
                let exists = false;
                $('#productTableBody input[name="product_id[]"]').each(function() {
                    if ($(this).val() == product.id) {
                        exists = true;
                        return false;
                    }
                });

                if (exists) {
                    iziToast.warning({
                        title: 'Duplicate',
                        message: 'Product already added.',
                        position: 'topRight'
                    });
                    return;
                }

                let rowId = 'row_' + Date.now();
                let imgSrc = product.image ? product.image : 'https://placehold.co/50x50?text=No+Img';

                let newRow = `
            <tr id="${rowId}" class="align-middle border-bottom">
                <td class="ps-3" style="width: 25%;">
                <div class="d-flex align-items-center gap-2">
                    <img src="${imgSrc}" class="rounded border" style="width: 35px; height: 35px; object-fit: cover;">
                    <div="d-flex flex-column">
                        <span class="fw-semibold text-dark d-block" style="font-size: 0.85rem;">${product.name}</span>
                        <input type="hidden" name="product_id[]" value="${product.id}">
                    </div>
                </div>
                </td>
                <td style="width: 20%;">
            <div class="input-group input-group-sm">
    <textarea name="description[]"
        class="form-control "
        id="desc_input_${rowId}"
        rows="2"
        ></textarea>

</div>

                </td>
                <td style="width: 12%;"><input type="text" name="hsn_code[]" class="form-control form-control-sm text-center" value="${product.hsn_code || ''}"></td>
                <td style="width: 8%;"><input type="number" name="qty[]" class="form-control form-control-sm text-center qty-input" value="1" min="1" oninput="calculateGrandTotal()" readonly></td>
                <td style="width: 17%;"><input type="number" name="unit_price[]" class="form-control form-control-sm text-center price-input" value="${parseFloat(product.price).toFixed(2)}" step="0.01" oninput="calculateGrandTotal()"></td>
                <td class="row-total fw-bold text-dark text-end pe-3" style="width: 13%;">0.00</td>
                <td class="text-center" style="width: 5%;">
                    <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeProductRow('${rowId}')">
                        <i class="bx bx-trash fs-5"></i>
                    </button>
                </td>
            </tr>`;

                $('#productTableBody').append(newRow);
                calculateGrandTotal();
            };

            window.removeProductRow = function(rowId) {
                $('#' + rowId).remove();
                if ($('#productTableBody tr').length === 0) {
                    $('#productTableBody').append(
                        '<tr id="noProductsRow"><td colspan="7" class="py-4 text-muted small">No products added yet</td></tr>'
                    );
                }
                calculateGrandTotal();
            };




            window.calculateGrandTotal = function() {

                let subtotal = 0;
                let maxSingleProductPrice = 0;

                /* ================= PRODUCT LOOP ================= */
                $('#productTableBody tr').not('#noProductsRow').each(function() {

                    let qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    let price = parseFloat($(this).find('.price-input').val()) || 0;

                    if (price > maxSingleProductPrice) {
                        maxSingleProductPrice = price;
                    }

                    let rowTotal = qty * price;
                    $(this).find('.row-total').text(rowTotal.toFixed(2));

                    subtotal += rowTotal;
                });

                $('#grandTotal').text(subtotal.toFixed(2));

                /* ================= DISCOUNT ================= */
                let discount = parseFloat($('#discount').val()) || 0;
                if (discount > subtotal) discount = subtotal;

                let taxableAmount = subtotal; // ✅ GST always on subtotal
                let tcsamount = subtotal;


                /* ================= GST ================= */
                let $gstSelect = $('#gst_display');
                let $gstAmount = $('#gst_amount');
                let gstPercent = parseFloat($gstSelect.val()) || 0;
                let gstAmount = 0;

                if ($('#gst_yes').is(':checked')) {

                    $gstSelect.prop('disabled', false).removeClass('bg-light');
                    $gstAmount.prop('disabled', false)
                        .prop('readonly', true)
                        .removeClass('bg-light');

                    if (gstPercent > 0) {
                        gstAmount = taxableAmount * (gstPercent / 100);
                    }

                } else {

                    $gstSelect.val('').prop('disabled', true)
                        .addClass('bg-light')
                        .trigger('change.select2');

                    $gstAmount.val('0.00')
                        .prop('disabled', true)
                        .addClass('bg-light');

                    gstAmount = 0;
                }

                $gstAmount.val(gstAmount.toFixed(2));


                /* ================= TCS ================= */
                let $tcsSelect = $('#tcs_percentage');
                let $tcsValue = $('#tcs_display');
                let tcsPercent = parseFloat($tcsSelect.val()) || 0;
                let tcsAmount = 0;

                // Apply only if any single product price >= 10L
                if (maxSingleProductPrice >= 1000000) {

                    $tcsSelect.prop('disabled', false).removeClass('bg-light');
                    $tcsValue.prop('disabled', false)
                        .prop('readonly', true)
                        .removeClass('bg-light');

                    if (tcsPercent > 0) {
                        tcsAmount = tcsamount * (tcsPercent / 100);
                    }

                } else {

                    $tcsSelect.val('1')
                        .prop('disabled', true)
                        .addClass('bg-light')
                        .trigger('change.select2');

                    $tcsValue.val('0.00')
                        .prop('disabled', true)
                        .addClass('bg-light');

                    tcsAmount = 0;
                }

                $tcsValue.val(tcsAmount.toFixed(2));


                /* ================= FINAL TOTAL ================= */
                let finalTotal = subtotal + gstAmount + tcsAmount - discount;

                $('#finalTotal').text(finalTotal.toFixed(2));
                $('#finalTotal_input').val(finalTotal.toFixed(2));


                /* ================= PAYMENT SPLIT AUTO INIT ================= */
                if ($('.payment-row').length === 0 && finalTotal > 0) {
                    addPaymentRow();
                }

                updateRemainingAmount();
            };


            // ✅ Add Event Listener for TCS Select Change
            $('#gst_display, #tcs_percentage, #discount').on('change input', function() {
                calculateGrandTotal();
            });

            $('#discount, input[name="gst_applicable"], #payment_split_amount').on('input change', function() {
                calculateGrandTotal();
            });

            // Event Listeners for inputs
            // $('#discount, input[name="gst_applicable"], #payment_split_amount').on('input change', function () {
            //     calculateGrandTotal();
            // });

            // Remaining Amount Logic
            function updateRemainingAmount() {

                let total = parseFloat($('#finalTotal').text()) || 0;

                // 🔥 If Split Toggle OFF → force remaining = 0
                if (!$('#toggle_split_payment').is(':checked')) {

                    $('#remaining_amount').text('0.00');
                    $('#remaining_amount_input').val('0.00');

                    return; // Stop further calculation
                }

                let paid = 0;

                $('.pay-amount').each(function() {
                    paid += parseFloat($(this).val()) || 0;
                });

                if (paid > total) {

                    iziToast.warning({
                        title: 'Warning',
                        message: 'Payment cannot exceed Total Amount',
                        position: 'topRight',
                        timeout: 3000
                    });

                    let excess = paid - total;
                    let currentInput = $('.pay-amount').last();
                    let correctedValue = parseFloat(currentInput.val()) - excess;

                    currentInput.val(correctedValue > 0 ? correctedValue.toFixed(2) : 0);

                    paid = total;
                }

                let remaining = total - paid;

                $('#remaining_amount').text(remaining.toFixed(2));
                $('#remaining_amount_input').val(remaining.toFixed(2));
            }


            // Event Listeners for inputs
            $('#discount, input[name="gst_applicable"], #payment_split_amount').on('input change', function() {
                calculateGrandTotal();
            });

            // Close search results on click outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.position-relative').length) {
                    $('#searchResults').hide();
                }
            });

            const gstYes = document.getElementById('gst_yes');
            const gstNo = document.getElementById('gst_no');
            const gstContainer = document.getElementById('gst_number_container');

            function toggleGST() {
                if (gstYes.checked) {
                    gstContainer.style.display = 'block';
                } else {
                    gstContainer.style.display = 'none';
                    document.getElementById('gst_number').value = '';
                }
            }
            gstYes.addEventListener('change', toggleGST);
            gstNo.addEventListener('change', toggleGST);
            toggleGST();


            $('#customer_id').on('select2:select', function(e) {
                let customerId = e.params.data.id;

                if (customerId === 'walkin') {
                    // Call the reset function
                    resetSalesForm();

                    // Reset the customer dropdown itself so "Walk-in" isn't left selected
                    $(this).val(null).trigger('change');

                    // Open Modal
                    let modal = new bootstrap.Modal(document.getElementById('walkInCustomerModal'));
                    modal.show();
                    return;
                }
                $('#id_file_preview').html('');
                $('#existing_file_id').val('');

                if (customerId) {
                    $.ajax({
                        url: "{{ route('sales.get_customer') }}", // Create this route
                        type: "GET",
                        data: {
                            id: customerId
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                var data = response.data;

                                // 1. Full Name Logic
                                if (data.is_business == 1) {
                                    $('#full_name').val(data.business_name || '');
                                } else {
                                    var fullName = [data.first_name, data.middle_name, data
                                            .last_name
                                        ]
                                        .filter(Boolean)
                                        .join(' ');
                                    $('#full_name').val(fullName);
                                }

                                // 2. Contact Info
                                $('#mobile_no').val(data.mobile);
                                $('#email').val(data.email);

                                // 3. ID Proof Logic
                                if (data.id_proof_type) {
                                    $('#id_proof').val(data.id_proof_type).trigger('change');
                                } else {
                                    $('#id_proof').val('').trigger('change');
                                }
                                $('#id_no').val(data.id_number);

                                if (data.file_url) {
                                    $('#existing_file_id').val(data.id_file_path);

                                    $('#id_file_preview').html(`
                                        <div class="d-flex align-items-center text-success small mt-1">
                                            <i class="bx bx-check-circle me-1"></i> File fetched from customer record
                                        </div>
                                        <a href="${data.file_url}" target="_blank" class="d-flex align-items-center text-primary small text-decoration-none mt-1">
                                            <i class="bx bx-link-external me-1"></i> View File
                                        </a>
                                    `);
                                } else {
                                    $('#existing_file_id').val('');
                                }

                                // GST Logic (Only if Business)
                                var taxNumber = data.tax_number || data.gst_number || data
                                    .gst_no;

                                if (data.is_business == 1) {
                                    $('#gst_yes').prop('checked', true).trigger('change');
                                    // Only fill if value exists
                                    if (taxNumber) {
                                        $('#gst_number').val(taxNumber);
                                    }
                                } else {
                                    // Optional: Reset to 'No' for individuals if preferred
                                    // $('#gst_no').prop('checked', true).trigger('change');
                                }

                            }
                        }
                    });
                } else {
                    // Clear fields if no customer selected
                    $('#full_name').val('');
                    $('#mobile_no').val('');
                    $('#email').val('');
                    $('#id_proof').val('').trigger('change');
                    $('#id_no').val('');
                    $('#gst_number').val('');
                    $('#id_file_preview').html('');
                    $('#existing_file_id').val('');
                }
            });


            $('#openWalkInModal').on('click', function() {

                // Reset form
                $('#saleForm')[0].reset();
                $('#saleForm select').val(null).trigger('change');

                // Reset dynamic UI
                $('#productTableBody').html(`
        <tr id="noProductsRow">
            <td colspan="7" class="py-4 text-muted small">No products added yet</td>
        </tr>
    `);

                $('#id_file_preview').html('');
                $('#existing_file_id').val('');
                $('#grandTotal').text('0.00');
                $('#finalTotal').text('0.00');
                $('#remaining_amount').text('0.00');

                // Reset date
                if (document.querySelector("#sale_date")?._flatpickr) {
                    document.querySelector("#sale_date")._flatpickr.setDate(new Date());
                }

                // Open modal
                let modal = new bootstrap.Modal(
                    document.getElementById('walkInCustomerModal')
                );
                modal.show();
            });

            $(document).on('hidden.bs.modal', '.modal', function() {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('overflow', '');

                // Optional: Reset form if it's the Walk-In modal
                if ($(this).attr('id') === 'walkInCustomerModal') {
                    $('#walkInForm')[0].reset();
                    $('.w-type-toggle[value="0"]').prop('checked', true).trigger('change');
                    $('#w_id_proof_type').val(null).trigger('change');
                    $('.form-control, .form-select').removeClass('is-invalid');
                }
            });

            $('.w-type-toggle').on('change', function() {
                if ($(this).val() == '1') {
                    // Business
                    $('.w-individual-row').addClass('d-none');
                    $('.w-business-row').removeClass('d-none');

                    $('#w_business_name').addClass('w-req-field');
                    $('#w_first_name').removeClass('w-req-field');
                } else {
                    // Individual
                    $('.w-individual-row').removeClass('d-none');
                    $('.w-business-row').addClass('d-none');

                    $('#w_first_name').addClass('w-req-field');
                    $('#w_business_name').removeClass('w-req-field');
                }
            });

            // 2. Open Modal Logic (Updated)
            $('#customer_id').on('select2:select', function(e) {
                let customerId = e.params.data.id;

                if (customerId === 'walkin') {
                    // Reset Main Form
                    $('#saleForm')[0].reset();
                    $('#saleForm select').val(null).trigger('change');
                    $('#productTableBody').html(
                        '<tr id="noProductsRow"><td colspan="7" class="py-4 text-muted small">No products added yet</td></tr>'
                    );
                    $('#id_file_preview').html('');
                    $('#existing_file_id').val('');
                    $('#grandTotal').text('0.00');
                    $('#finalTotal').text('0.00');
                    $('#remaining_amount').text('0.00');
                    if (document.querySelector("#sale_date")?._flatpickr) {
                        document.querySelector("#sale_date")._flatpickr.setDate(new Date());
                    }

                    // Reset Select2 selection
                    $(this).val(null).trigger('change');

                    // Reset Walk-In Modal Form
                    $('#walkInForm')[0].reset();
                    $('.w-type-toggle[value="0"]').prop('checked', true).trigger(
                        'change'); // Default to Individual
                    $('.form-control, .form-select').removeClass('is-invalid');

                    // Show Modal
                    let modal = new bootstrap.Modal(document.getElementById('walkInCustomerModal'));
                    modal.show();
                    return;
                }
                // ... (Existing logic for normal customer selection continues here) ...
            });

            // 3. Save Walk-In Customer
            $('#saveWalkInBtn').on('click', function() {
                let valid = true;

                // 1. Validate Required Fields
                $('.w-req-field:visible').each(function() {
                    if (!$(this).val().trim()) {
                        valid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!valid) return;

                // 2. Submit Data
                // Use DOM element to get FormData (handles all fields including files)
                let formEl = document.getElementById('walkInForm');
                let formData = new FormData(formEl);
                let btn = $(this);
                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    // ✅ USE NEW SALES ROUTE
                    url: "{{ route('sales.store_walk_in') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        btn.prop('disabled', false).text('Save Customer');

                        if (res.success) {
                            iziToast.success({
                                title: 'Success',
                                message: res.message,
                                position: 'topRight'
                            });

                            // A. Close Modal & Fix Backdrop
                            let modalEl = document.getElementById('walkInCustomerModal');
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open').css('overflow', '');

                            // B. ✅ GET ID FROM RESPONSE
                            let newId = res.customer_id;

                            if (newId) {
                                // Construct Name for Dropdown
                                let isBusiness = formData.get('is_business') == '1';
                                let newName = '';

                                if (isBusiness) {
                                    newName = formData.get('business_name');
                                } else {
                                    let first = formData.get('first_name') || '';
                                    let last = formData.get('last_name') || '';
                                    newName = (first + ' ' + last).trim();
                                }
                                if (!newName) newName = "New Customer";

                                // C. ✅ APPEND TO DROPDOWN & SELECT IT
                                let newOption = new Option(newName, newId, true, true);
                                $('#customer_id').append(newOption).trigger('change');

                                // D. ✅ TRIGGER PREFILL (Fetch details like mobile/email)
                                $('#customer_id').trigger({
                                    type: 'select2:select',
                                    params: {
                                        data: {
                                            id: newId,
                                            text: newName
                                        }
                                    }
                                });
                            }

                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: res.message || 'Failed.',
                                position: 'topRight'
                            });
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Save Customer');
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong.',
                            position: 'topRight'
                        });
                    }
                });
            });

            let activeTab = localStorage.getItem('active_sales_tab');
            if (activeTab) {
                // Activate the tab
                let tabTrigger = document.querySelector(`a[href="${activeTab}"]`);
                if (tabTrigger) {
                    let tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
                localStorage.removeItem('active_sales_tab');
            }

        });

        // function openDescModal(rowId) {
        //     const currentVal = document.getElementById(`desc_input_${rowId}`).value;

        //     document.getElementById('modal_desc_textarea').value = currentVal;
        //     document.getElementById('current_row_id').value = rowId;

        //     const myModal = new bootstrap.Modal(
        //         document.getElementById('descriptionModal')
        //     );
        //     myModal.show();
        // }

        // function saveModalDesc() {
        //     const rowId = document.getElementById('current_row_id').value;
        //     const newDesc = document.getElementById('modal_desc_textarea').value;

        //     document.getElementById(`desc_input_${rowId}`).value = newDesc;

        //     const modal = bootstrap.Modal.getInstance(
        //         document.getElementById('descriptionModal')
        //     );
        //     modal.hide();
        // }

        // $('#location').on('change', function () {
        //     let locationId = $(this).val();

        //     if (!locationId) {
        //         $('#invoice_no').val('');
        //         return;
        //     }

        //     $.ajax({
        //         url: "{{ route('sales.generate.invoice') }}",
        //         type: "GET",
        //         data: { location_id: locationId },
        //         success: function (res) {
        //             if (res.status === 200) {
        //                 $('#invoice_no').val(res.invoice_no);
        //             }
        //         }
        //     });
        // });


        // mohiii

        $('#location').on('change', function() {

            let locationId = $(this).val();

            if (!locationId) {
                $('#invoice_no').val('');
                return;
            }


            let salesId = $('#edit_sales_id').val();

            if (salesId) {
                // Edit mode: keep existing invoice number
                return;
            }

            /* --------------------------------
               ADD MODE → GENERATE INVOICE
            ---------------------------------*/
            $.ajax({
                url: "{{ route('sales.generate.invoice') }}",
                type: "GET",
                data: {
                    location_id: locationId
                },
                success: function(res) {
                    if (res.status === 200) {
                        $('#invoice_no').val(res.invoice_no);
                    }
                }
            });
        });

        // $(document).on('click', '.viewDescription', function() {
        //     let desc = decodeURIComponent($(this).data('desc'));
        //     $('#descriptionModalBody').text(desc);
        //     $('#editdescriptionModal').modal('show');
        // });


        $(document).on('click', '.editSales', function() {

            let saleId = $(this).data('id');
            let url = "{{ route('sales.edit', ':id') }}".replace(':id', saleId);

            // =========================
            // OPEN EDIT TAB
            // =========================
            let tabTrigger = document.querySelector('a[href="#addStock"]');
            if (tabTrigger) {
                let tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }

            $('#addSalesTab').text('Edit Sale');

            // =========================
            // RESET FORM
            // =========================
            $('#saleForm')[0].reset();
            $('#saleForm').removeClass('was-validated');
            $('#saleForm').find('.form-control, .form-select').removeClass('is-valid is-invalid');
            $('#productTableBody').empty();

            $('.select2').val(null).trigger('change');

            $('#edit_sales_id').remove();

            $('<input>').attr({
                type: 'hidden',
                id: 'edit_sales_id',
                name: 'sales_id',
                value: saleId
            }).appendTo('#saleForm');

            $('#saveBtn').text('Update');

            // =========================
            // AJAX GET DATA
            // =========================
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

                    // =========================
                    // SPLIT PAYMENT LOAD
                    // =========================
                    if (payments.length > 0) {

                        $('#toggle_split_payment')
                            .prop('checked', true)
                            .trigger('change');

                        $('#is_split_payment').val(1);

                        $('#split_count')
                            .val(payments.length)
                            .trigger('input');

                        setTimeout(function() {

                            payments.forEach(function(pay, i) {

                                let row = $('.payment-row').eq(i);

                                if (!row.length) return;

                                row.append(`
                            <input type="hidden"
                                class="payment-id"
                                name="payment_split[${i}][payment_id]"
                                value="${pay.sp_id || ''}">

                            <input type="hidden"
                                name="payment_split[${i}][sales_id]"
                                value="${pay.sales_id || ''}">
                        `);

                                row.find('.payment-method')
                                    .val(pay.payment_id || pay.method)
                                    .trigger('change');

                                row.find('.pay-amount')
                                    .val(parseFloat(pay.recieved_amount || 0).toFixed(
                                        2))
                                    .trigger('input');

                                if (pay.cheque_no) {
                                    row.find('input[name*="[cheque_no]"]').val(pay
                                        .cheque_no);
                                }

                                if (pay.transaction_no) {
                                    row.find('input[name*="[transaction_no]"]').val(pay
                                        .transaction_no);
                                }

                                if (pay.bank_acc) {
                                    row.find('input[name*="[bank_account_no]"]').val(pay
                                        .bank_acc);
                                }

                                if (pay.card_no) {
                                    row.find('input[name*="[card_no]"]').val(pay
                                        .card_no);
                                }

                            });

                            normalizePaymentIndexes();
                            updateRemainingAmount();

                        }, 150);

                    } else {

                        $('#toggle_split_payment')
                            .prop('checked', false)
                            .trigger('change');

                        $('#is_split_payment').val(0);
                    }

                    // =========================
                    // FILL MAIN FORM (ALL EDITABLE)
                    // =========================
                    $('#location').val(s.location).trigger('change');

                    if ($('#customer_id').find("option[value='" + s.customer_id + "']").length === 0) {
                        $('#customer_id').append(
                            new Option(s.full_name, s.customer_id, true, true)
                        );
                    }

                    $('#customer_id').val(s.customer_id).trigger('change');

                    if (document.querySelector("#sale_date")._flatpickr) {
                        document.querySelector("#sale_date")._flatpickr.setDate(s.sale_date);
                    }

                    $('#invoice_no').val(s.invoice_no).prop('readonly', false).removeClass('bg-light');
                    $('#full_name').val(s.full_name).prop('readonly', false).removeClass('bg-light');
                    $('#mobile_no').val(s.mobile_no).prop('readonly', false).removeClass('bg-light');
                    $('#email').val(s.email).prop('readonly', false).removeClass('bg-light');
                    $('#id_no').val(s.id_no).prop('readonly', false).removeClass('bg-light');

                    $('#id_proof').val(s.id_proof).trigger('change');

                    $('#discount').val(s.discount).prop('readonly', false).removeClass('bg-light');

                    if (s.gst_applicable === 'yes') {
                        $('#gst_yes').prop('checked', true);
                    } else {
                        $('#gst_no').prop('checked', true);
                    }

                    $('input[name="gst_applicable"]').prop('disabled', false);

                    $('#gst_number').val(s.gst_number).prop('readonly', false).removeClass('bg-light');

                    $('#gst_display').val(s.gst_display).trigger('change');

                    $('#gst_amount').val(s.gst_amount).prop('readonly', false).removeClass('bg-light');

                    $('#tcs_percentage').val(s.tcs_percentage).trigger('change');

                    $('#tcs_display').val(s.tcs_display).prop('readonly', false).removeClass(
                    'bg-light');

                    $('#payment_split_amount')
                        .val(s.payment_split_amount)
                        .prop('readonly', false)
                        .removeClass('bg-light');

                    $('#bill_status').val(s.bill_status).trigger('change');

                    $('#file_id').prop('disabled', false);

                    // =========================
                    // PRODUCTS LOAD
                    // =========================
                    $('#productTableBody').empty();

                    if (products.length === 0) {

                        $('#productTableBody').html(`
                    <tr id="noProductsRow">
                        <td colspan="7" class="py-4 text-muted small">
                            No products added yet
                        </td>
                    </tr>
                `);

                    } else {

                        let assetBaseUrl = "{{ $actual_url . '/admin_assets/brand' }}";

                        products.forEach(function(p) {

                            let rowId = 'row_' + p.product_id + '_' + Date.now() + Math.random()
                                .toString(36).substr(2, 5);

                            let qty = parseFloat(p.qty) || 1;
                            let salesPrice = parseFloat(p.sales_price) || 0;
                            let unitPrice = qty > 0 ? (salesPrice / qty) : 0;

                            let imgSrc = 'https://placehold.co/50x50?text=No+Img';

                            if (p.pro_image && p.brand_folder && p.product_folder) {
                                imgSrc =
                                    `${assetBaseUrl}/${p.brand_folder}/${p.product_folder}/image/${p.pro_image}`;
                            }

                            let rowHtml = `
                        <tr id="${rowId}" class="align-middle border-bottom">

                            <td class="ps-3" style="width:25%;">
                                <div class="d-flex align-items-center gap-2">

                                    <img src="${imgSrc}"
                                        class="rounded border"
                                        style="width:35px;height:35px;object-fit:cover;">

                                    <div>
                                        <span class="fw-semibold d-block" style="font-size:.85rem;">
                                            ${p.pro_name || 'Unknown'}
                                        </span>

                                        <input type="hidden"
                                            name="product_id[]"
                                            value="${p.product_id}">
                                    </div>

                                </div>
                            </td>

                            <td style="width:20%;">
                                <input type="text"
                                    name="description[]"
                                    class="form-control"
                                    value="${p.description || ''}">
                            </td>

                            <td style="width:12%;">
                                <input type="text"
                                    name="hsn_code[]"
                                    class="form-control form-control-sm text-center"
                                    value="${p.hsn_code || ''}">
                            </td>

                            <td style="width:8%;">
                                <input type="number"
                                    name="qty[]"
                                    class="form-control form-control-sm text-center qty-input"
                                    value="${qty}"
                                    min="1"
                                    oninput="calculateGrandTotal()">
                            </td>

                            <td style="width:17%;">
                                <input type="number"
                                    name="unit_price[]"
                                    class="form-control form-control-sm text-center price-input"
                                    value="${unitPrice.toFixed(2)}"
                                    step="0.01"
                                    oninput="calculateGrandTotal()">
                            </td>

                            <td class="row-total fw-bold text-dark text-end pe-3"
                                style="width:13%;">
                                ${salesPrice.toFixed(2)}
                            </td>

                            <td class="text-center" style="width:5%;">
                                <button type="button"
                                    class="btn btn-link btn-sm text-danger p-0"
                                    onclick="removeProductRow('${rowId}')">

                                    <i class="bx bx-trash fs-5"></i>

                                </button>
                            </td>

                        </tr>
                    `;

                            $('#productTableBody').append(rowHtml);

                        });
                    }

                    calculateGrandTotal();

                    // =========================
                    // FILE PREVIEW
                    // =========================
                    if (s.file_id) {

                        $('#existing_file_id').val(s.file_id);

                        let fileUrl =
                            "{{ $actual_url . '/admin_assets/sales_document' }}/" + s.file_id;

                        $('#id_file_preview').html(`
                    <a href="${fileUrl}" target="_blank" class="text-primary small">
                        View File
                    </a>
                `);
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

        $('a[href="#listStock"]').on('shown.bs.tab', function() {
            isEditing = false;
            $('#filterCollapse').collapse('show');
            $('#filterToggleBtn').removeClass('d-none');
            $('#addSalesTab').text('Add Sale');
            setTimeout(function() {
                if ($.fn.DataTable.isDataTable('#salesTable')) {
                    salesTable.columns.adjust();
                    salesTable.draw(false);
                }
            }, 400);

        });




        $(document).on('click', '.delete-sale', function() {
            let id = $(this).data('id');
            let url = "{{ route('sales.delete') }}"; // Ensure this route exists in web.php

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status === 200) {
                                // 1. Show Success Alert
                                Swal.fire(
                                    'Deleted!',
                                    res.message,
                                    'success'
                                );

                                // 2. Reload DataTable immediately (Fixes "page load only" issue)
                                if ($.fn.DataTable.isDataTable('#salesTable')) {
                                    $('#salesTable').DataTable().ajax.reload(null,
                                        false); // false keeps current paging
                                }
                            } else {
                                Swal.fire(
                                    'Error!',
                                    res.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).on('click', '.printSale', function() {
            let salesId = $(this).data('id');
            let url = "{{ route('sales.print', ':id') }}".replace(':id', salesId);


            window.open(url, '_blank');

        });
    </script>
</body>

</html>
