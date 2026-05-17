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

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Stock Management</h4>
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
                                            Stock List
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#addStock" role="tab">
                                            <span id="stockTabText">Add Stock</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>


                            <div class="tab-content">


                                <div class="tab-pane fade show active" id="listStock" role="tabpanel">
                                    <div class="table-responsive">
                                        <table id="stockTrasferTable"
                                            class="table table-bordered table-striped text-center w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Reference No</th>
                                                    <th>Location From</th>
                                                    <th>Location To</th>
                                                    <th>Shipping Charges</th>
                                                    <th>Total</th>
                                                    <th>Stock Status</th>
                                                    <th>Trasfer Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="addStock" role="tabpanel">
                                    <div class="p-3">
                                        <h5 class="card-title mb-4" style="color:#2A2E72">Add Stock Transfer</h5>

                                        <form id="stockForm" class="needs-validation" novalidate>
                                            @csrf
                                            <input type="hidden" id="stock_id" name="stock_id">


                                            <div class="row g-3 mb-4">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Date:<span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0 text-muted">
                                                            <i class="bx bx-calendar"></i>
                                                        </span>
                                                        <input type="text"
                                                            class="form-control border-start-0 bg-light ps-0"
                                                            id="transfer_date" name="transfer_date" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Reference
                                                        No:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0 text-muted">
                                                            <i class="bx bx-hash"></i>
                                                        </span>
                                                        <input type="text"
                                                            class="form-control border-start-0 bg-light ps-0"
                                                            name="reference_no" id="reference_no"
                                                            value="{{ $reference_no }}" placeholder="Reference No">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Stock Status:<span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">

                                                        <div class="flex-grow-1">
                                                            <select class="form-select border-start-0 bg-light ps-0"
                                                                id="stock_status" name="stock_status">


                                                                <option value="0">Pending</option>
                                                                <option value="1">In Transit</option>
                                                                <option value="2">Completed</option>

                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            @php
                                                $loginType = Session::get('login_type');

                                                // ✅ Staff allowed From locations
                                                $fromLocations = access_locations();

                                                // ✅ Super Admin → To locations = All
                                                if ($loginType === 'super_admin') {
                                                    $toLocations = \App\Models\BusinesslocationModel::where(
                                                        'status',
                                                        0,
                                                    )->get();
                                                }

                                                // ✅ Staff → To locations = All EXCEPT assigned ones
                                                else {
                                                    // $assignedIds = $fromLocations->pluck('bl_id'); // staff assigned location IDs

                                                    // $toLocations = \App\Models\BusinesslocationModel::where('status', 0)
                                                    //     ->whereNotIn('bl_id', $assignedIds)
                                                    //     ->get();
                                                    $toLocations = \App\Models\BusinesslocationModel::where(
                                                        'status',
                                                        0,
                                                    )->get();
                                                }
                                            @endphp


                                            <div class="row g-3 mb-4">

                                                <!-- ✅ From Location -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Location (From): <span class="text-danger">*</span>
                                                    </label>

                                                    <select class="form-select bg-light" name="location_from"
                                                        id="location_from">
                                                        <option value="">Please Select</option>
                                                        @foreach ($fromLocations as $loc)
                                                            <option value="{{ $loc->bl_id }}">{{ $loc->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- ✅ To Location -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Location (To): <span class="text-danger">*</span>
                                                    </label>

                                                    <select class="form-select bg-light" name="location_to"
                                                        id="location_to">
                                                        <option value="">Please Select</option>
                                                        @foreach ($toLocations as $loc)
                                                            <option value="{{ $loc->bl_id }}">{{ $loc->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>


                                            <div class="mb-4">
                                                <h6 class="fw-semibold text-dark mb-3">Search Products</h6>

                                                <!-- 🔍 Search Box -->
                                                <div class="d-flex justify-content-center">
                                                    <div class="product-search-wrapper position-relative mb-3">
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
                                                            class="list-group position-absolute shadow bg-white rounded-bottom">
                                                        </ul>
                                                    </div>
                                                </div>


                                                <!-- 📦 Product Table -->
                                                <div class="table-responsive border rounded-2"
                                                    style="max-height: 400px; overflow-y: auto;">
                                                    <table
                                                        class="table table-borderless text-center align-middle mb-0">
                                                        <thead class="bg-light text-muted sticky-top">
                                                            <tr>
                                                                <th class="fw-semibold text-start ps-4"
                                                                    width="30%">Product</th>
                                                                <th class="fw-semibold" width="15%">Quantity</th>
                                                                <th class="fw-semibold" width="20%">Unit Price</th>
                                                                <th class="fw-semibold" width="15%">Unit Type</th>
                                                                <th class="fw-semibold" width="5%">
                                                                    <i class="bx bx-trash"></i>
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="productTableBody">
                                                            <tr id="noProductsRow">
                                                                <td colspan="5" class="py-4 text-muted small">
                                                                    No products added yet
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                        <tfoot class="border-top sticky-bottom bg-white">
                                                            <tr>
                                                                <td colspan="3"></td>
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
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold text-dark">Shipping
                                                        Charges:</label>
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text bg-light border-end-0 text-muted">

                                                        </span>
                                                        <input type="number"
                                                            class="form-control border-start-0 bg-light ps-0 no-leading-zero"
                                                            name="shipping_charges" id="shippingCharges"
                                                            min="0" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label fw-semibold text-dark">Additional
                                                        Notes</label>
                                                    <textarea class="form-control bg-light" name="notes" id="notes" rows="3"
                                                        placeholder="Enter any notes here..."></textarea>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column align-items-end mt-4 pt-3 border-top">
                                                <h5 class="fw-bold mb-3 text-dark"> Total Amount: <span
                                                        id="finalTotal">0.00</span></h5>
                                                <div>
                                                    <button type="submit" class="btn btn-primary px-5"
                                                        id="saveBtn">
                                                        <i class="bx bx-save me-1"></i><span
                                                            id="btnText">Save</span>
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


        <div class="modal fade" id="stockProductModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title">
                            Stock Transfer Details - Reference No: <span class="fw-bold text-primary refNo"></span>
                        </h5>

                        {{-- <h5 class="fw-bold">Stock Transfer Details</h5> --}}

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <!-- ✅ Location Details -->
                        <div class="row mb-3">

                            <!-- From Location -->
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h6 class="fw-bold text-success">From Location</h6>
                                    <p class="mb-1"><b>Name:</b> <span id="fromName"></span></p>
                                    <p class="mb-1"><b>Address:</b> <span id="fromAddress"></span></p>
                                    <p class="mb-0"><b>Email:</b> <span id="fromEmail"></span></p>
                                </div>
                            </div>

                            <!-- To Location -->
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h6 class="fw-bold text-danger">To Location</h6>
                                    <p class="mb-1"><b>Name:</b> <span id="toName"></span></p>
                                    <p class="mb-1"><b>Address:</b> <span id="toAddress"></span></p>
                                    <p class="mb-0"><b>Email:</b> <span id="toEmail"></span></p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border rounded p-3">

                                    <p class="mb-1"><b>Reference No:</b> <span class="refNo"></span></p>
                                    <p class="mb-1"><b>Date:</b> <span class="transferDate"></span></p>
                                    <p class="mb-0"><b>Status:</b> <span id="stockStatus"></span></p>
                                </div>
                            </div>


                        </div>

                        <!-- ✅ Products Table -->
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Unit Type</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="stockProductTable"></tbody>
                        </table>

                        <div class="border rounded p-2 mb-3">
                            <h6 class="fw-bold">Additional Notes</h6>
                            <p class="mb-0 text-muted" id="additionalNotes">-</p>
                        </div>

                        <div class="border rounded p-2 mb-3">
                            <h6 class="fw-bold">Activity Logs</h6>

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Status</th>
                                            <th>Done By</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="activityLogTable">
                                        <tr>
                                            <td colspan="4" class="text-muted">No activity found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="statusUpdateModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content rounded-4 shadow">

                    <!-- ✅ Header -->
                    <div class="modal-header bg-light border-0">
                        <h5 class="modal-title fw-bold text-dark">
                            Update Stock Status
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- ✅ Body -->
                    <div class="modal-body px-4 pt-3 pb-4">

                        <input type="hidden" id="updateStockId">

                        <label class="fw-semibold mb-2 text-dark">
                            Select Status <span class="text-danger">*</span>
                        </label>

                        <select class="form-select" id="updateStockStatus">
                            <option value="0">Pending</option>
                            <option value="1">In-Transit</option>
                            <option value="2">Completed</option>
                        </select>

                    </div>

                    <!-- ✅ Footer -->
                    <div class="modal-footer border-0 px-4 pb-4 d-flex justify-content-end">

                        <button class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button class="btn btn-primary px-4" id="updateStatusBtn">
                            Update
                        </button>

                    </div>

                </div>
            </div>
        </div>



        @include('partials.footer')
    </div>
    @include('partials.footer_link')
    <script>
        $(document).ready(function() {

            $(document).on('focus', '#shippingCharges', function() {
                if (this.value == 0) this.value = '';
            });

            $(document).on('blur', '#shippingCharges', function() {
                if (this.value === '') this.value = 0;
            });

            // 1️⃣ Initialize datepicker & select2
            let transferPicker = $("#transfer_date").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: new Date(),
                allowInput: false
            });
            // $('#stock_status').select2({
            //     placeholder: "Please Select",
            //     allowClear: true,
            //     width: '100%',
            //     minimumResultsForSearch: Infinity,
            //     selectionCssClass: 'bg-light border-start-0'
            // });

            $('#location_from, #location_to').select2({
                placeholder: "Please Select",
                allowClear: true,
                width: '100%'
            });

            $("#stock_status").select2({
                placeholder: "Please Select",
                allowClear: true,
                width: "100%"
            });

            $('#statusUpdateModal').on('shown.bs.modal', function() {

                $('#updateStockStatus').select2({
                    dropdownParent: $('#statusUpdateModal'), // ✅ MOST IMPORTANT
                    width: "100%",
                    minimumResultsForSearch: Infinity,
                    placeholder: "Please Select Status"
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

            $('#location_from').on('change', function() {
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

            // 3️⃣ Product search with location filter
            let searchTimeout;
            $('#productSearch').on('keyup', function() {
                let query = $(this).val();
                let $list = $('#searchResults');
                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    $list.hide().html('');
                    return;
                }

                let locFrom = $('#location_from').val();
                if (!locFrom) {
                    $list.html('<li class="list-group-item text-muted small">Select a location first</li>')
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
                                // Inside success: function(data)

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
                if (!$(e.target).closest('.position-relative').length) {
                    $('#searchResults').hide();
                }
            });

            // 🔁 Add product (no duplicates)
            window.addProductToTable = function(product) {
                $('#searchResults').hide();
                $('#productSearch').val('');
                $('#noProductsRow').remove();

                let exists = false;
                $('#productTableBody input[name="product_id[]"]').each(function() {
                    if ($(this).val() == product.id) {
                        exists = true;
                        return false;
                    }
                });

                if (exists) {
                    iziToast.warning({
                        title: 'Already Added',
                        message: 'Product has already been added.',
                        position: 'topRight'
                    });
                    return;
                }

                let rowId = 'row_' + Date.now();
                let imgSrc = product.image ? product.image : 'https://placehold.co/50x50?text=No+Img';

                let newRow = `
            <tr id="${rowId}" class="border-bottom">
                <td class="text-start ps-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="${imgSrc}" class="rounded border" style="width: 40px; height: 40px; object-fit: cover;">
                        <span class="fw-medium text-dark">${product.name}</span>
                       <input type="hidden" name="multi_id[]" value="">
<input type="hidden" name="product_id[]" value="${product.id}">
                    </div>
                </td>
                <td>
                    <input type="number" name="qty[]" class="form-control form-control-sm text-center mx-auto qty-input"
                        style="width: 80px;" value="1" min="1" onchange="validateQuantity(this)" oninput="calculateGrandTotal()">
                </td>
                <td>
                    <input type="number" name="unit_price[]" class="form-control form-control-sm text-center mx-auto price-input"
                        style="width: 120px;" value="${parseFloat(product.price).toFixed(2)}" step="0.01" min="0" oninput="calculateGrandTotal()">
                </td>
                <td>
                    <input type="text" class="form-control-plaintext text-center text-muted small" name="unit_type[]" value="${product.unit}" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-icon btn-light text-danger" onclick="removeProductRow('${rowId}')">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            </tr>`;
                $('#productTableBody').append(newRow);
                calculateGrandTotal();
            };

            // Quantity validation
            window.validateQuantity = function(input) {
                if (input.value === "" || parseInt(input.value) <= 0) {
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Quantity must be greater than 0.',
                        position: 'topRight'
                    });
                    input.value = 1;
                }
                calculateGrandTotal();
            };

            // Remove product
            window.removeProductRow = function(rowId) {
                $('#' + rowId).remove();
                if ($('#productTableBody tr').length === 0) {
                    $('#productTableBody').html(`
                <tr id="noProductsRow">
                    <td colspan="5" class="py-4 text-muted small">No products added yet</td>
                </tr>`);
                }
                calculateGrandTotal();
            };

            // Total & final total
            window.calculateGrandTotal = function() {
                let total = 0;
                $('#productTableBody tr').not('#noProductsRow').each(function() {
                    let qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    let price = parseFloat($(this).find('.price-input').val()) || 0;
                    total += (qty * price);
                });

                $('#grandTotal').text(total.toFixed(2));

                let shipping = parseFloat($('#shippingCharges').val()) || 0;
                let finalTotal = total + shipping;
                $('#finalTotal').text(finalTotal.toFixed(2));
            };

            $('#shippingCharges').on('input', function() {
                calculateGrandTotal();
            });

            // 📤 AJAX Submit (like colourForm)
            $(document).on('submit', '#stockForm', function(e) {
                e.preventDefault();
                let form = this;

                if (!form.checkValidity()) {
                    e.stopPropagation();
                    $(form).addClass('was-validated');
                    return false;
                }

                let $btn = $('#saveBtn'),
                    originalHTML = $btn.html();
                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Saving...');

                let fd = new FormData(form);

                let productRow = $('#productTableBody tr').not('#noProductsRow').first();
                if (!productRow.length) {
                    iziToast.error({
                        message: 'Please add a product before saving.',
                        position: 'topRight'
                    });
                    $btn.prop('disabled', false).html(originalHTML);
                    return;
                }

                // fd.append('product_id', productRow.find('input[name="product_id[]"]').val());
                // fd.append('qty', productRow.find('input[name="qty[]"]').val());
                // fd.append('unit_price', productRow.find('input[name="unit_price[]"]').val());
                // fd.append('unit_type', productRow.find('input[name="unit_type[]"]').val());


                // ✅ Only Total Manually Add
                fd.append("total", $("#finalTotal").text());


                $.ajax({
                    url: "{{ route('stock.transfer.store') }}",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        iziToast.success({
                            message: res.message,
                            position: 'topRight'
                        });
                        resetStockForm();

                        $("#stockTrasferTable").DataTable().ajax.reload(null, false);

                        // ✅ Back to List
                        $('a[href="#listStock"]').tab("show");
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                iziToast.error({
                                    title: 'Validation Error',
                                    message: messages.join(', '),
                                    position: 'topRight'
                                });
                            });
                        } else {
                            iziToast.error({
                                message: xhr.responseJSON?.message ||
                                    "Something went wrong!",
                                position: 'topRight'
                            });
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalHTML);
                    }
                });
            });






            $('#stockTrasferTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('stock.transfer.list') }}",

                columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    },
                    {
                        data: 'reference_no',
                        name: 'reference_no'
                    },
                    {
                        data: 'location_from',
                        name: 'location_from'
                    },
                    {
                        data: 'location_to',
                        name: 'location_to'
                    },
                    {
                        data: 'shipping_charges',
                        name: 'shipping_charges'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'stock_status',
                        name: 'stock_status'
                    },
                    {
                        data: 'transfer_date',
                        name: 'transfer_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });




            $(document).on('click', '.viewStock', function() {

                let stockId = $(this).data('id');

                $.ajax({
                    url: "{{ route('stock.transfer.products', ':id') }}".replace(':id', stockId),
                    type: "GET",
                    success: function(response) {

                        let rows = '';
                        let i = 1;

                        let netTotal = 0; // ✅ Total Net Amount

                        // ✅ Additional Charges
                        let shippingCharges = parseFloat(response.transfer.shipping_charges) ||
                            0;

                        if (response.products.length > 0) {

                            $.each(response.products, function(key, item) {

                                let productName = item.product ? item.product.pro_name :
                                    '-';
                                let qty = parseFloat(item.qyt) || 0;
                                let unitPrice = parseFloat(item.unit_price) || 0;
                                let total = qty * unitPrice;
                                $('.refNo').text(response.transfer.reference_no ?? '-');
                                $('.transferDate').text(response.transfer_date ?? '-');

                                // ✅ From Location
                                $('#fromName').text(response.from?.name ?? '-');
                                $('#fromAddress').text(response.from?.address ?? '-');
                                $('#fromEmail').text(response.from?.email ?? '-');

                                // ✅ To Location
                                $('#toName').text(response.to?.name ?? '-');
                                $('#toAddress').text(response.to?.address ?? '-');
                                $('#toEmail').text(response.to?.email ?? '-');


                                $('#additionalNotes').text(response.transfer?.notes ??
                                    '-');

                                let status = response.transfer?.stock_status ?? 0;
                                let badge = '';

                                if (status == 0) {
                                    badge =
                                        `<span class="badge bg-warning text-dark">Pending</span>`;
                                } else if (status == 1) {
                                    badge =
                                        `<span class="badge bg-info text-dark">IN - Transit</span>`;
                                } else if (status == 2) {
                                    badge =
                                        `<span class="badge bg-success">Completed</span>`;
                                } else {
                                    badge =
                                        `<span class="badge bg-secondary">Unknown</span>`;
                                }

                                $('#stockStatus').html(badge);

                                let logRows = '';
                                let logIndex = 1;

                                if (response.logs.length > 0) {

                                    $.each(response.logs, function(key, log) {

                                        logRows += `
            <tr>
                <td>${logIndex++}</td>
                <td>${log.status}</td>
                <td>${log.user_name}</td>
                <td>${log.date}</td>
            </tr>`;
                                    });

                                } else {

                                    logRows = `
        <tr>
            <td colspan="4" class="text-muted text-center">No activity found</td>
        </tr>`;
                                }

                                $('#activityLogTable').html(logRows);


                                netTotal += total;

                                rows += `
            <tr>
                <td>${i++}</td>
                <td>${productName}</td>
                <td>₹ ${indianFormat(unitPrice)}</td>
                <td>${qty}</td>
                <td>${item.unit_type}</td>
                <td>${indianFormat(total)}</td>
            </tr>`;
                            });

                            // ✅ Total Net Amount Row
                            rows += `
        <tr class="fw-bold">
            <td colspan="5" class="text-end">Total Net Amount</td>
            <td>${indianFormat(netTotal)}</td>
        </tr>`;

                            // ✅ Additional Charges Row
                            rows += `
        <tr class="fw-bold text-warning">
            <td colspan="5" class="text-end">Additional Charges</td>
            <td>${indianFormat(shippingCharges)}</td>
        </tr>`;

                            // ✅ Overall Grand Total
                            // ✅ Overall Grand Total
                            let overallGrandTotal = netTotal + shippingCharges;

                            // ✅ Convert Total to Words
                            let totalWords = numberToWords(Math.round(overallGrandTotal));

                            // ✅ Show Grand Total Row
                            rows += `
<tr class="fw-bold text-success">
    <td colspan="5" class="text-end">Overall Grand Total</td>
    <td>₹ ${indianFormat(overallGrandTotal)}</td>
</tr>`;

                            // ✅ Show Total in Words Row
                            rows += `
<tr class="fw-bold text-primary">
    <td colspan="6" class="text-start">
        Total Amount In Words:
        <span class="fst-italic">${totalWords}</span>
    </td>
</tr>`;


                        } else {

                            rows = `
        <tr>
            <td colspan="6" class="text-center">No products found</td>
        </tr>`;
                        }

                        $('#stockProductTable').html(rows);
                        $('#stockProductModal').modal('show');
                    }

                });

            });

            $(document).on('click', '.stockStatusBtn', function() {

                let stockId = $(this).data('id');
                let status = $(this).data('status');

                $('#updateStockId').val(stockId);
                $('#updateStockStatus').val(status);

                $('#statusUpdateModal').modal('show');
            });
            $(document).on('click', '#updateStatusBtn', function() {

                let stockId = $('#updateStockId').val();
                let status = $('#updateStockStatus').val();

                let $btn = $(this);
                let originalHtml = $btn.html();

                // ✅ Prevent double click + show spinner
                $btn.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm me-1"></span>
        Updating...
    `);

                $.ajax({
                    url: "{{ route('stock.transfer.updateStatus') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        stock_id: stockId,
                        stock_status: status
                    },

                    success: function(res) {

                        iziToast.success({
                            message: res.message,
                            position: "topRight"
                        });

                        $('#statusUpdateModal').modal('hide');
                        $('#stockTrasferTable').DataTable().ajax.reload(null, false);
                    },

                    error: function(xhr) {

                        iziToast.error({
                            message: xhr.responseJSON?.message ||
                                "Something went wrong!",
                            position: "topRight"
                        });
                    },

                    complete: function() {

                        // ✅ Restore button
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });
            //Print
            $(document).on("click", ".printStock", function() {

                let id = $(this).data("id");

                window.open(
                    "{{ route('stock.transfer.print', ':id') }}".replace(':id', id),
                    "_blank"
                );
            });


            //edit stock
            $(document).on("click", ".editStock", function() {

                let id = $(this).data("id");

                $.ajax({
                    url: "{{ route('stock.transfer.edit', ':id') }}".replace(":id", id),
                    type: "GET",

                    success: function(res) {

                        if (res.status) {

                            // ✅ Switch Tab
                            $('a[href="#addStock"]').tab("show");

                            // ✅ Prefill Form
                            $("#stock_id").val(res.transfer.stock_id);

                            $("#transfer_date").val(res.transfer.transfer_date);
                            $("#reference_no").val(res.transfer.reference_no);

                            $("#stock_status").val(res.transfer.stock_status).trigger("change");
                            $("#location_from").val(res.transfer.location_from).trigger(
                                "change").prop("disabled", true);
                            $("#location_to").val(res.transfer.location_to).trigger("change")
                                .prop("disabled", true);

                            $("#shippingCharges").val(res.transfer.shipping_charges);
                            $("#notes").val(res.transfer.notes);

                            // ✅ Products Table
                            $("#productTableBody").html("");

                            res.products.forEach(item => {

                                let rowId = "row_" + Date.now() + "_" + Math.floor(Math
                                    .random() * 1000);

                                let name = item.product?.pro_name ?? "-";
                                let imgSrc = item.product?.image_url ?
                                    item.product.image_url :
                                    "https://placehold.co/50x50?text=No+Img";


                                $("#productTableBody").append(`
<tr id="${rowId}" class="border-bottom">
    <td class="text-start ps-4">
        <div class="d-flex align-items-center gap-3">
          <img src="${imgSrc}" class="rounded border" style="width: 40px; height: 40px; object-fit: cover;">
         <span class="fw-medium text-dark">${name}</span>

        <!-- ✅ Existing Row ID -->
        <input type="hidden" name="multi_id[]" value="${item.stock_multi_id}">

        <!-- ✅ Product ID -->
        <input type="hidden" name="product_id[]" value="${item.product_id}">
        </div>
    </td>

    <td>
        <input type="number" name="qty[]" class="form-control form-control-sm text-center mx-auto qty-input"
            value="${item.qyt}" min="1" style="width: 80px;"
            oninput="calculateGrandTotal()">
    </td>

    <td>
        <input type="number" name="unit_price[]" class="form-control form-control-sm text-center mx-auto price-input"
            value="${item.unit_price}" style="width: 120px;"
            oninput="calculateGrandTotal()">
    </td>

    <td>
        <input type="text" class="form-control-plaintext text-center text-muted small"
            value="${item.unit_type}" readonly>
        <input type="hidden" name="unit_type[]" value="${item.unit_type}">
    </td>

    <td>
      <button type="button" class="btn btn-sm btn-icon btn-light text-danger" onclick="removeProductRow('${rowId}')">
                        <i class="bx bx-trash"></i>
                    </button>
    </td>
</tr>
`);


                            });

                            calculateGrandTotal();

                            // ✅ Change Button + Tab Text
                            $("#btnText").text("Update");
                            $("#saveBtn").removeClass("btn-primary").addClass("btn-warning");
                            $("#stockTabText").text("Edit Stock");

                        }
                    }
                });

            });


            // ✅ Reset when List Tab Clicked
            $('a[href="#listStock"]').on("shown.bs.tab", function() {
                resetStockForm();
            });


            // ✅ Reset Stock Form Function
            function resetStockForm() {

                // ✅ Reset Form Fields
                $("#stockForm")[0].reset();
                transferPicker.setDate(new Date(), true);

                // ✅ Clear Hidden Stock ID (Exit Edit Mode)
                $("#stock_id").val("");

                // ✅ Reset Products Table
                $("#productTableBody").html(`
        <tr id="noProductsRow">
            <td colspan="5" class="py-4 text-muted small">
                No products added yet
            </td>
        </tr>
    `);

                // ✅ Reset Totals
                $("#grandTotal").text("0.00");
                $("#finalTotal").text("0.00");

                // ✅ Reset Select2 Dropdowns
                $("#stock_status").val("0").trigger("change");
                $("#location_from").val("").trigger("change");
                $("#location_to").val("").trigger("change");

                // ✅ Reset Button Back to Save Mode
                $("#btnText").text("Save");
                $("#saveBtn").removeClass("btn-warning").addClass("btn-primary");

                // ✅ Reset Tab Title Back
                $("#stockTabText").text("Add Stock");
                $("#reference_no").prop("disabled", false);
                $("#location_from").prop("disabled", false);
                $("#location_to").prop("disabled", false);

            }



            // ✅ Clicking Add Stock Tab → Reset if not in Edit Mode
            $('a[href="#addStock"]').on("shown.bs.tab", function() {

                // ✅ Only reset if no Edit ID
                if ($("#stock_id").val() === "") {
                    resetStockForm();
                }

            });


            //Stock Receive
            $(document).on("click", ".receivedStock", function() {

                let stockId = $(this).data("id");

                Swal.fire({
                    title: "Mark as Received?",
                    // text: "Stock Transfer ID: " + stockId,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Received",
                    cancelButtonText: "Cancel"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('stock.transfer.received') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                stock_id: stockId
                            },
                            success: function(res) {

                                Swal.fire("Success!", res.message, "success");

                                // ✅ Reload DataTable
                                $("#stockTrasferTable").DataTable().ajax.reload(null,
                                    false);
                            },
                            error: function(xhr) {

                                Swal.fire(
                                    "Error!",
                                    xhr.responseJSON?.message ||
                                    "Something went wrong!",
                                    "error"
                                );
                            }
                        });
                    }
                });

            });


            $(document).on('click', '.rejectStock', function() {

                let stockId = $(this).data('id');

                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    title: 'Reject Stock?',
                    message: 'This will permanently remove this stock transfer.',
                    position: 'center',
                    buttons: [
                        [
                            '<button><b>YES, REJECT</b></button>',
                            function(instance, toast) {

                                $.ajax({
                                    url: "{{ route('stock.reject') }}",
                                    type: "POST",
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr(
                                            'content'),
                                        stock_id: stockId
                                    },
                                    success: function(res) {

                                        if (res.status) {
                                            iziToast.success({
                                                message: res.message,
                                                position: 'topRight'
                                            });

                                            // reload datatable
                                            $('#stockInTable').DataTable().ajax
                                                .reload(null, false);
                                        } else {
                                            iziToast.error({
                                                message: res.message,
                                                position: 'topRight'
                                            });
                                        }
                                    }
                                });

                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast);
                            },
                            true
                        ],
                        [
                            '<button>NO</button>',
                            function(instance, toast) {
                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast);
                            }
                        ]
                    ]
                });
            });
        });
    </script>

</body>

</html>
