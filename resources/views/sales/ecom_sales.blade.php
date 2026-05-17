<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">
@include('partials.header_link')
<style>
    /* Scrollbar */
    #bombexTrackingContent::-webkit-scrollbar {
        height: 6px;
    }

    #bombexTrackingContent::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    /* ================= DESKTOP TIMELINE ================= */

    .timeline {
        display: flex;
        gap: 40px;
        position: relative;
        min-width: max-content;
        /* IMPORTANT for scroll */
    }

    /* LINE BACK */
    .timeline::before {
        content: '';
        position: absolute;
        top: 17px;
        left: 0;
        width: 100%;
        height: 4px;
        background: #ddd;
        z-index: 0;
    }

    /* LINE PROGRESS */
    .timeline::after {
        content: '';
        position: absolute;
        top: 17px;
        left: 0;
        width: 100%;
        height: 4px;
        background: #212529;
        z-index: 0;
    }

    /* STEP */
    .step {
        min-width: 180px;
        /* FIX SCROLL */
        text-align: center;
        position: relative;
        padding-top: 45px;
    }

    /* ✅ SQUARE CHECK */
    .step::before {
        content: '✔';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);

        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #212529;
        color: #fff;
        font-size: 16px;
        font-weight: bold;


        z-index: 2;
    }

    /* TEXT */
    .step h6 {
        font-size: 16px;
        font-weight: 600;
        color: #263241;
        margin-bottom: 6px;
    }

    .step p {
        margin: 0;
        font-size: 13px;
        color: #666;
        line-height: 1.5;
    }

    /* ================= MOBILE (VERTICAL TIMELINE) ================= */

    @media (max-width: 768px) {

        #bombexTrackingContent {
            overflow-x: hidden;
            padding: 15px 20px 30px;
        }

        .timeline {
            display: block;
            min-width: 100%;

        }

        /* Vertical Line */
        .timeline::before {
            top: 0;
            left: 10px;
            width: 4px;
            height: 100%;
            background: #212529;
        }

        .timeline::after {
            display: none;
        }

        /* Step */
        .step {
            text-align: left;
            padding-left: 40px;
            margin-bottom: 30px;
            min-width: auto;
        }

        /* Square position */
        .step::before {
            left: 10px;
            transform: translateX(-50%);
        }

        .step h6 {
            font-size: 14px;
        }

        .step p {
            font-size: 12px;
        }
    }

    /* ================= SMALL MOBILE ================= */

    @media (max-width: 480px) {

        .step::before {
            width: 28px;
            height: 28px;
            font-size: 13px;
        }

        .step h6 {
            font-size: 13px;
        }

        .step p {
            font-size: 11px;
        }
    }

    .pod-img {
        max-width: 220px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }

    .timeline-wrap {
        overflow-x: auto;
        padding: 20px 30px 40px;
    }
</style>

<body>
    @include('partials.switcher')
    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">E-Commerce Sales</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Sales</a></li>
                <li class="breadcrumb-item active" aria-current="page">E-Com Sales List</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="card custom-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#ecommercelist" role="tab">
                                    Ecommerce List
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="addSalesTab" data-bs-toggle="tab" href="#addStock"
                                    role="tab">
                                    Cancelled Orders
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="ecommercelist" role="tabpanel">
                                <div class="table-responsive">
                                    <div class="row mb-3 align-items-end">

                                        <div class="col-md-3">
                                            <label class="form-label">Select Status</label>
                                            <select id="statusFilter" class="form-select">
                                                <option value="all">All Orders</option>
                                                {{-- <option value="cancelled">Order Cancelled</option> --}}
                                                <option value="prebook">Pre-Booked</option>
                                                <option value="placed">Order Placed</option>
                                                <option value="transit">In-Transit</option>
                                                <option value="completed">Completed</option>
                                                {{-- <option value="pending">Pending</option> --}}
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <button class="btn btn-primary w-100" id="viewFilter">
                                                <i class="bx bx-show"></i> View
                                            </button>
                                        </div>

                                        <div class="col-md-3">
                                            <button class="btn btn-success w-100" data-bs-toggle="modal"
                                                data-bs-target="#rangeModal">

                                                <i class="bx bx-plus"></i>
                                                Shipment Number Range
                                            </button>
                                        </div>

                                        <!-- Right Side Refresh -->
                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                            <button class="btn btn-sm btn-primary" id="refreshTable">

                                                <i class="bx bx-refresh"></i>
                                                Refresh
                                            </button>
                                        </div>

                                    </div>

                                    <table class="table table-bordered text-nowrap w-100" id="ecomSalesTable">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Invoice No</th>
                                                <th>Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                                <th>Order Date</th>
                                                <th>Order Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="addStock" role="tabpanel">
                                <div class="row align-items-center mb-3">

                                    <div class="col-md-8">
                                        <h5 class="mb-0 fw-semibold">
                                            Cancelled & Pending Orders
                                        </h5>
                                    </div>

                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                        <button class="btn btn-sm btn-primary" id="refreshCancelledTable">
                                            <i class="bx bx-refresh"></i>
                                            Refresh
                                        </button>
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap w-100" id="ecomCancelledTable">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Invoice No</th>
                                                <th>Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                                <th>Order Date</th>
                                                <th>Order Status</th>
                                                <th class="text-center">Action</th>
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

        <div class="modal fade" id="viewEcomModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title d-flex align-items-center">
                            <i class="bx bx-cart me-2"></i> Order Details
                        </h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4" id="ecomDetailsContent">
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary modal-invoice-print" data-id="">
                            <i class="bx bx-printer me-1"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div id="fullpayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullpaymentLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="fullpaymentLabel">Full Payment Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            {{-- <label for="full_payment_amount">Enter Full Payment Amount</label> --}}


                            <!-- Hidden Order IDs -->
                            <input type="hidden" id="payment_order_id">
                            <input type="hidden" id="payment_order_oid">
                        </div>

                        <p class="text-muted mt-2">
                            Confirm that the customer has completed the remaining full payment.
                        </p>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="submitFullPayment">
                            <span class="btn-text">Confirm Payment</span>
                            <span class="spinner-border spinner-border-sm ms-2 d-none" id="fullPaymentLoader"
                                role="status"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        {{-- order placed --}}

        <div id="trackingModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="trackingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="trackingModalLabel">Delivery Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input delivery_type" type="checkbox" id="internal_delivery"
                                    value="internal">

                                <label class="form-check-label" for="internal_delivery">
                                    By Internally Store Delivery
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input delivery_type" type="checkbox" id="bombex_delivery"
                                    value="bombex">

                                <label class="form-check-label" for="bombex_delivery">
                                    By Bombax Delivery
                                </label>
                            </div>
                        </div>

                        <!-- Internal Delivery Fields -->
                        {{-- <div id="internalFields" style="display:none;">

                            <div class="mb-3">
                                <label class="form-label">Store Name</label>
                                <input type="text" id="store_name" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Delivery Agent</label>
                                <input type="text" id="delivery_guy" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" id="contact_number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea id="notes" class="form-control" rows="3" placeholder="Enter delivery notes..."></textarea>
                            </div>

                        </div> --}}

                        <input type="hidden" id="tracking_order_id">
                        <input type="hidden" id="tracking_order_oid">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-success" id="submitTracking">

                            <span class="btn-text">Submit</span>

                            <span class="spinner-border spinner-border-sm ms-2 d-none" id="trackingLoader"></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="assignDeliverModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form id="assignDeliveryForm" method="POST" novalidate>
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Assign Delivery Agent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order ID</label>
                                    <input type="text" id="modal_order_id" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Invoice No</label>
                                    <input type="text" id="modal_invoice_no" class="form-control" readonly>
                                </div>
                            </div>

                            <input type="hidden" id="modal_oid">

                            <!-- Row 1 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Store Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="store_name" class="form-control"
                                        placeholder="Enter store name" required>
                                    <div class="invalid-feedback">Store name is required</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Delivery Agent <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="delivery_guy" class="form-control"
                                        placeholder="Enter delivery agent name" required>
                                    <div class="invalid-feedback">Delivery agent is required</div>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        Contact Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="contact_number" class="form-control"
                                        placeholder="Enter 10-digit number" required pattern="[0-9]{10}">
                                    <div class="invalid-feedback">Enter valid 10-digit number</div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea id="notes" class="form-control" rows="2" placeholder="Optional notes"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="saveDeliveryBtn">
                                <span class="btn-text">Out For Delivery</span>
                                <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        {{-- Intrasit --}}


        <div id="deliveredModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="deliveredModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="deliveredModalLabel">Confirm Delivery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-center">
                        <p>Are you sure this product has been delivered?</p>
                        <input type="hidden" id="delivered_order_id">
                        <input type="hidden" id="delivered_order_oid">
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="confirmDelivered">
                            <span class="btn-text">Yes, Delivered</span>
                            <span class="spinner-border spinner-border-sm ms-2 d-none" id="deliveredLoader"
                                role="status"></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="rangeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form id="shipmentRangeForm" novalidate>
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Add Shipment Range</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            @php
                                $firstRange = $rangedata->first();
                            @endphp

                            <!-- Hidden Field -->
                            <input type="hidden" name="sr_id" id="sr_id"
                                value="{{ $firstRange->sr_id ?? '' }}">

                            <!-- From Range -->
                            <div class="mb-3">
                                <label class="form-label">From Range</label>
                                <input type="number" name="from_range" id="from_range" class="form-control"
                                    value="{{ $firstRange->from_range ?? '' }}" required>

                                <div class="invalid-feedback">
                                    Please enter From Range.
                                </div>
                            </div>

                            <!-- To Range -->
                            <div class="mb-3">
                                <label class="form-label">To Range</label>
                                <input type="number" name="to_range" id="to_range" class="form-control"
                                    value="{{ $firstRange->to_range ?? '' }}" required>

                                <div class="invalid-feedback">
                                    Please enter To Range.
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <div class="modal fade" id="bombexModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">

                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title">Shipment Tracking</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">

                        <h4 class="fw-bold mb-4">
                            Order No:
                            <span id="bombexOrderNo"></span>
                        </h4>

                        <div id="bombexTrackingContent"></div>

                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="storePickupModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Store Pickup</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p><strong>Store Name :</strong> <span id="store_name_text"></span></p>
                        <p><strong>Address :</strong> <span id="store_address_text"></span></p>
                    </div>

                </div>
            </div>
        </div>
        @include('partials.footer')
    </div>
    @include('partials.footer_link')

    <script>
        $(document).ready(function() {

            $('#statusFilter').select2({
                placeholder: "Select Status",
                allowClear: true,
                width: '100%'
            });
            // 1. Initialize DataTable

            let selectedStatus = '';

            var ecomSalesTable = $('#ecomSalesTable').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('ecom.sales.list') }}",
                    data: function(d) {
                        d.status_filter = selectedStatus;
                    }
                },
                columns: [{
                        data: 'order_id'
                    },
                    {
                        data: 'invoice_no'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rtip',
                language: {
                    searchPlaceholder: "Search...",
                    sSearch: ""
                }
            });

            var ecomCancelledTable = $('#ecomCancelledTable').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('ecom.cancelled.pending.list') }}"
                },

                columns: [{
                        data: 'order_id'
                    },
                    {
                        data: 'invoice_no'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],

                dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rtip',

                language: {
                    searchPlaceholder: "Search...",
                    sSearch: ""
                }
            });

            $('#refreshCancelledTable').on('click', function() {

                let btn = $(this);

                btn.html('<i class="bx bx-loader-alt bx-spin"></i> Refreshing...');

                $('#ecomCancelledTable').DataTable().ajax.reload(function() {

                    btn.html('<i class="bx bx-refresh"></i> Refresh');

                }, false);

            });

            $(document).on('click', '#refreshTable', function() {

                $('#ecomSalesTable').DataTable().ajax.reload(null, false);

                // iziToast.success({
                //     title: 'Success',
                //     message: 'Table Refreshed Successfully',
                //     position: 'topRight',
                //     timeout: 2000
                // });

            });


            $('#viewFilter').on('click', function() {

                selectedStatus = $('#statusFilter').val();

                ecomSalesTable.ajax.reload();
            });

            // 2. View Modal Handler
            $(document).on('click', '.viewEcomSale', function() {

                var id = $(this).data('id');
                var url = "{{ route('ecom.sales.show', ':id') }}".replace(':id', id);

                $('#ecomDetailsContent').html(
                    '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>'
                );

                $('#viewEcomModal').modal('show');

                $.get(url, function(res) {

                    if (res.status == 200) {

                        var order = res.order;
                        var items = res.items;

                        $('.modal-invoice-print').attr('data-id', order.order_id);
                        // ---------------- DELIVERY INFO ----------------
                        var deliveryHtml = '';

                        if (order.delivery_type && order.delivery_type.trim() !== '') {

                            deliveryHtml += `
        <div class="col-md-12 mt-4">
            <div class="border rounded p-3 bg-light">
                <h6 class="fw-bold text-dark mb-3">
                    Delivery Information 🚚
                </h6>
    `;

                            // -------- BOM BEX --------
                            if (order.delivery_type === 'bombex') {

                                deliveryHtml += `
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td width="150" class="text-muted">Delivery Type</td>
                    <td class="fw-bold text-uppercase">Bombax</td>
                </tr>

                <tr>
                    <td class="text-muted">Tracking Number</td>
                    <td class="fw-bold">${order.tracking_num || '-'}</td>
                </tr>
            </table>
        `;
                            }

                            // -------- INTERNAL --------
                            if (order.delivery_type === 'internal') {

                                // 👉 Handle null / string JSON / undefined
                                let d = {};

                                if (res.delivery_details) {
                                    try {
                                        d = typeof res.delivery_details === 'string' ?
                                            JSON.parse(res.delivery_details) :
                                            res.delivery_details;
                                    } catch (e) {
                                        d = {};
                                    }
                                }



                                deliveryHtml += `
    <table class="table table-sm table-borderless mb-0">
        <tr>
            <td width="150" class="text-muted">Delivery Type</td>
            <td class="fw-bold text-uppercase">
                <span class="badge bg-info">${order.delivery_type || '-'}</span>
            </td>
        </tr>

        <tr>
            <td class="text-muted">Store</td>
            <td class="fw-bold">${d?.store_name ?? '-'}</td>
        </tr>

        <tr>
            <td class="text-muted">Delivery Agent</td>
            <td class="fw-bold">${d?.delivery_guy ?? '-'}</td>
        </tr>

        <tr>
            <td class="text-muted">Contact</td>
            <td class="fw-bold">${d?.contact_number ?? '-'}</td>
        </tr>

        <tr>
            <td class="text-muted">Notes</td>
            <td class="fw-bold">${d?.notes ?? '-'}</td>
        </tr>
    </table>
    `;
                            }
                            if (order.delivery_type === 'store_pickup' || (res.delivery_details &&
                                    res.delivery_details.delivery_type === 'store_pickup')) {
                                let d = res.delivery_details || {};

                                deliveryHtml += `
        <table class="table table-sm table-borderless mb-0">
            <tr>
                <td width="150" class="text-muted">Delivery Type</td>
                <td class="fw-bold text-uppercase">Store Pick Up</td>
            </tr>
            <tr>
                <td class="text-muted">Store Name</td>
                <td class="fw-bold">${d.store_name || '-'}</td>
            </tr>
            <tr>
                <td class="text-muted">Store Address</td>
                <td class="fw-bold">${d.store_address || '-'}</td>
            </tr>
        </table>
    `;
                            }

                            deliveryHtml += `
            </div>
        </div>
    `;
                        }

                        // ---------------- PAN INFO ----------------
                        var panHtml = '';

                        if (res.pan_details && res.pan_details.verified) {

                            panHtml = `
                    <div class="col-md-12 mt-4">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-bold text-success mb-3">
                                PAN Verified ✅
                            </h6>

                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="150" class="text-muted">Full Name</td>
                                    <td class="fw-bold">${res.pan_details.full_name}</td>
                                </tr>

                                <tr>
                                    <td class="text-muted">PAN Number</td>
                                    <td class="fw-bold">${res.pan_details.pan_number}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;
                        }

                        // ---------------- ITEMS ----------------
                        var itemRows = '';

                        if (items.length > 0) {

                            $.each(items, function(index, item) {

                                itemRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.product_name}</td>
                            <td class="text-center">${item.quantity}</td>
                            <td class="text-end">${parseFloat(item.price).toFixed(2)}</td>
                            <td class="text-end">${(item.quantity * item.price).toFixed(2)}</td>
                        </tr>
                    `;
                            });

                        } else {

                            itemRows = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No Items Found
                        </td>
                    </tr>
                `;
                        }

                        // ---------------- HTML ----------------
                        var html = `
                <div class="row">

                    <div class="col-md-6 border-end">
                        <h6 class="fw-bold text-primary mb-3">Order Information</h6>

                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted">Invoice No</td>
                                <td>${order.invoice_num || '-'}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Order ID</td>
                                <td>${order.order_id}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Date</td>
                                <td>${new Date(order.created_at).toLocaleString()}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Payment</td>
                                <td>${order.payment_method || '-'}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-primary mb-3">Shipping Details</h6>

                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted">Name</td>
                                <td>${order.shipping_first_name} ${order.shipping_last_name}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Phone</td>
                                <td>${order.shipping_phone || '-'}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Email</td>
                                <td>${order.shipping_email || '-'}</td>
                            </tr>
                        </table>
                    </div>

                    ${panHtml}
                     ${deliveryHtml}

                </div>

                <hr>

                <h6 class="fw-bold mb-3">Order Items</h6>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            ${itemRows}
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Grand Total</th>
                                <th class="text-end">
                                    ${parseFloat(order.grand_total).toFixed(2)}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;

                        $('#ecomDetailsContent').html(html);
                    }
                });
            });

            $(document).on('click', '.invoice-btn', function() {
                const orderId = $(this).data('id'); // fetch order_id


                const url = "{{ route('invoice.print', ':order_id') }}".replace(':order_id', orderId);

                // Option 1: open in new tab (for viewing/printing PDF)
                window.open(url, '_blank');

                // Option 2 (alternative): redirect same page
                // window.location.href = url;
            });


            $(document).on('click', '.modal-invoice-print', function() {

                const orderId = $(this).data('id');

                if (!orderId) {

                    iziToast.error({
                        title: 'Error',
                        message: 'Order ID not found',
                        position: 'topRight',
                        timeout: 3000,
                        progressBar: true
                    });

                    return;
                }

                const url = "{{ route('invoice.print', ':order_id') }}"
                    .replace(':order_id', orderId);

                window.open(url, '_blank');
            });

            $(document).on('click', '.prebook-status-btn', function() {
                var o_id = $(this).data('oid');
                var orderId = $(this).data('id');
                var status = $(this).data('status');
                var payment = $(this).data('payment');

                if (payment == "prebook") {
                    $('#payment_order_id').val(orderId);
                    $('#payment_order_oid').val(o_id);
                    $('#fullpayment').modal('show');
                }
            });


            $('#submitFullPayment').click(function() {

                let order_id = $('#payment_order_id').val();
                let o_id = $('#payment_order_oid').val();

                // ✅ Start Loader
                $('#submitFullPayment').prop('disabled', true);
                $('#fullPaymentLoader').removeClass('d-none');
                $('#submitFullPayment .btn-text').text('Processing...');

                $.ajax({
                    url: "{{ route('order.fullpayment') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_id: order_id,
                        o_id: o_id
                    },

                    success: function(response) {

                        if (response.status === 'success') {

                            $('#fullpayment').modal('hide');

                            iziToast.success({
                                title: 'Success',
                                message: 'Full payment confirmed successfully!',
                                position: 'topRight'
                            });

                            $('#ecomSalesTable').DataTable().ajax.reload(null, false);

                        } else {

                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },

                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });
                    },

                    complete: function() {
                        // ✅ Stop Loader (always runs)
                        $('#submitFullPayment').prop('disabled', false);
                        $('#fullPaymentLoader').addClass('d-none');
                        $('#submitFullPayment .btn-text').text('Confirm Payment');
                    }
                });

            });



            //order placed
            $(document).on('click', '.order-status-btn', function() {
                var o_id = $(this).data('oid');
                var orderId = $(this).data('id');
                var status = $(this).data('status');

                if (status == 1) {
                    $('#tracking_order_id').val(orderId);
                    $('#tracking_order_oid').val(o_id);
                    $('#trackingModal').modal('show');
                }
            });


            // Submit tracking number
            // $('#submitTracking').click(function() {

            //     var trackingNumber = $('#tracking_number').val();
            //     var orderId = $('#tracking_order_id').val();
            //     var o_id = $('#tracking_order_oid').val();

            //     if (trackingNumber.trim() === '') {
            //         iziToast.warning({
            //             title: 'Warning',
            //             message: 'Please enter tracking number',
            //             position: 'topRight'
            //         });
            //         return;
            //     }

            //     // ✅ Show loader + disable button
            //     $('#submitTracking').prop('disabled', true);
            //     $('#trackingLoader').removeClass('d-none');
            //     $('#submitTracking .btn-text').text('Processing...');

            //     $.ajax({
            //         url: "{{ route('orders.updateTracking') }}",
            //         type: "POST",
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             order_id: orderId,
            //             o_id: o_id,
            //             tracking_number: trackingNumber
            //         },

            //         success: function(response) {

            //             if (response.success) {
            //                 iziToast.success({
            //                     title: 'Success',
            //                     message: response.message,
            //                     position: 'topRight'
            //                 });
            //             } else {
            //                 iziToast.error({
            //                     title: 'Error',
            //                     message: response.message,
            //                     position: 'topRight'
            //                 });
            //             }

            //             $('#trackingModal').modal('hide');
            //             $('#ecomSalesTable').DataTable().ajax.reload(null, false);
            //         },

            //         error: function(xhr) {
            //             let msg = 'Something went wrong.';
            //             if (xhr.responseJSON && xhr.responseJSON.message) {
            //                 msg = xhr.responseJSON.message;
            //             }

            //             iziToast.error({
            //                 title: 'Error',
            //                 message: msg,
            //                 position: 'topRight'
            //             });
            //         },

            //         complete: function() {
            //             // ✅ Restore button state (runs on success + error)
            //             $('#submitTracking').prop('disabled', false);
            //             $('#trackingLoader').addClass('d-none');
            //             $('#submitTracking .btn-text').text('Submit');
            //         }
            //     });
            // });


            //Intransit
            $(document).on('click', '.delivered-btn', function() {
                var o_id = $(this).data('oid');
                var orderId = $(this).data('id');

                // Pass values to modal hidden inputs
                $('#delivered_order_oid').val(o_id);
                $('#delivered_order_id').val(orderId);

                // Show modal
                $('#deliveredModal').modal('show');
            });


            $('#confirmDelivered').click(function() {

                var o_id = $('#delivered_order_oid').val();
                var orderId = $('#delivered_order_id').val();

                // ✅ Start loader
                $('#confirmDelivered').prop('disabled', true);
                $('#deliveredLoader').removeClass('d-none');
                $('#confirmDelivered .btn-text').text('Processing...');

                $.ajax({
                    url: "{{ route('orders.markDelivered') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_id: orderId,
                        o_id: o_id
                    },

                    success: function(response) {

                        if (response.success) {

                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });

                            $('#deliveredModal').modal('hide');


                            $('#ecomSalesTable').DataTable().ajax.reload(null, false);

                        } else {

                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },

                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong.',
                            position: 'topRight'
                        });
                    },

                    complete: function() {
                        // ✅ Stop loader always
                        $('#confirmDelivered').prop('disabled', false);
                        $('#deliveredLoader').addClass('d-none');
                        $('#confirmDelivered .btn-text').text('Yes, Delivered');
                    }
                });

            });


            $('#rangeModal').on('hidden.bs.modal', function() {

                // do NOT reset form
                // values stay in fields

            });

            $('#shipmentRangeForm').submit(function(e) {
                e.preventDefault();

                let form = this;

                if (!form.checkValidity()) {
                    $(form).addClass('was-validated');
                    return;
                }

                $.ajax({
                    url: "{{ route('shipment.range.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        sr_id: $('#sr_id').val(),
                        from_range: $('#from_range').val(),
                        to_range: $('#to_range').val()
                    },

                    success: function(response) {

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });

                        $('#sr_id').val(response.sr_id);
                        $('#from_range').val(response.from_range);
                        $('#to_range').val(response.to_range);

                        $('#shipmentRangeForm').removeClass('was-validated');
                        $('#rangeModal').modal('hide');
                    }
                });

            });

            $(document).on('change', '.delivery_type', function() {

                $('.delivery_type').not(this).prop('checked', false);

                if ($('#internal_delivery').is(':checked')) {
                    $('#internalFields').slideDown();
                } else {
                    $('#internalFields').slideUp();
                }

            });


            function resetTrackingForm() {

                // Uncheck checkboxes
                $('.delivery_type').prop('checked', false);

                // Clear inputs
                $('#store_name').val('');
                $('#delivery_guy').val('');
                $('#contact_number').val('');
                $('#notes').val('');

                // Hide internal fields
                $('#internalFields').hide();

                // Clear hidden fields
                $('#tracking_order_id').val('');
                $('#tracking_order_oid').val('');
            }

            $('#submitTracking').click(function() {

                var orderId = $('#tracking_order_id').val();
                var o_id = $('#tracking_order_oid').val();

                var delivery_type = '';

                if ($('#internal_delivery').is(':checked')) {
                    delivery_type = 'internal';
                }

                if ($('#bombex_delivery').is(':checked')) {
                    delivery_type = 'bombex';
                }

                if (delivery_type == '') {
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Please select delivery type',
                        position: 'topRight'
                    });
                    return;
                }

                // var store_name = $('#store_name').val();
                // var delivery_guy = $('#delivery_guy').val();
                // var contact_number = $('#contact_number').val();
                // var notes = $('#notes').val();

                // if (delivery_type == 'internal') {

                //     if (store_name == '' || delivery_guy == '' || contact_number == '') {
                //         iziToast.warning({
                //             title: 'Warning',
                //             message: 'Please fill all internal delivery fields',
                //             position: 'topRight'
                //         });
                //         return;
                //     }
                // }

                $('#submitTracking').prop('disabled', true);
                $('#trackingLoader').removeClass('d-none');
                $('#submitTracking .btn-text').text('Processing...');

                $.ajax({
                    url: "{{ route('orders.updateTracking') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_id: orderId,
                        o_id: o_id,
                        delivery_type: delivery_type,
                        // store_name: store_name,
                        // delivery_guy: delivery_guy,
                        // contact_number: contact_number,
                        // notes: notes,
                    },

                    success: function(response) {

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });

                        $('#trackingModal').modal('hide');

                        // ✅ RESET FORM
                        resetTrackingForm();

                        $('#ecomSalesTable').DataTable().ajax.reload(null, false);
                    },

                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong',
                            position: 'topRight'
                        });
                    },

                    complete: function() {
                        $('#submitTracking').prop('disabled', false);
                        $('#trackingLoader').addClass('d-none');
                        $('#submitTracking .btn-text').text('Submit');
                    }
                });

            });


            $(document).on('click', '.bombex-track-btn', function() {

                let tracking = $(this).data('tracking');
                let order = $(this).data('order');

                $('#bombexOrderNo').text(tracking);
                $('#bombexModal').modal('show');

                $('#bombexTrackingContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary"></div>
        </div>
    `);

                $.get("{{ route('bombex.status') }}", {
                    tracking_num: tracking,
                    order_id: order
                }, function(res) {
                    $('#bombexTrackingContent').html(res);
                });

            });


            $(document).on('click', '.assign-deliver', function() {

                let orderId = $(this).data('id');
                let oId = $(this).data('oid');

                // 👉 get invoice from table row (important)
                let invoice = $(this).closest('tr').find('td:eq(1)').text();

                $('#modal_order_id').val(orderId);
                $('#modal_invoice_no').val(invoice);
                $('#modal_oid').val(oId);

                // reset form
                $('#store_name').val('');
                $('#delivery_guy').val('');
                $('#contact_number').val('');
                $('#notes').val('');

                $('#assignDeliverModal').modal('show');
            });


            $('#assignDeliveryForm').on('submit', function(e) {

                e.preventDefault();

                let form = this;
                let btn = $('#saveDeliveryBtn');
                let spinner = btn.find('.spinner-border');
                let btnText = btn.find('.btn-text');

                // 🔥 Validation
                if (!form.checkValidity()) {
                    e.stopPropagation();
                    $(form).addClass('was-validated');
                    return;
                }

                // 🔥 Show spinner
                btn.prop('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('Saving...');

                $.ajax({
                    url: "{{ route('assign.internal.delivery') }}",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),

                        order_id: $('#modal_order_id').val(),
                        o_id: $('#modal_oid').val(),
                        delivery_type: 'internal',

                        store_name: $('#store_name').val(),
                        delivery_guy: $('#delivery_guy').val(),
                        contact_number: $('#contact_number').val(),
                        notes: $('#notes').val()
                    },
                    success: function(res) {

                        if (res.success) {

                            // ✅ Toast success
                            iziToast.success({
                                title: 'Success',
                                message: res.message,
                                position: 'topRight'
                            });

                            // ✅ Reset form
                            $('#assignDeliveryForm')[0].reset();
                            $('#assignDeliveryForm').removeClass('was-validated');

                            // ✅ Hide modal
                            $('#assignDeliverModal').modal('hide');

                            // ✅ Reload DataTable WITHOUT reset pagination
                            $('#ecomSalesTable').DataTable().ajax.reload(null, false);

                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: res.message,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });
                    },
                    complete: function() {
                        // 🔥 Reset button
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('Save');
                    }
                });

            });


            $(document).on('click', '.viewStorePickup', function() {

                let storeId = $(this).data('store');

                $.ajax({
                    url: "{{ route('store.pickup', ':id') }}".replace(':id', storeId),
                    type: "GET",

                    success: function(res) {

                        if (res.status === 200) {

                            $('#store_name_text').text(res.name);
                            $('#store_address_text').text(res.address);

                            $('#storePickupModal').modal('show');

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Store not found',
                                text: res.message
                            });
                        }
                    },

                    error: function() {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to fetch store details.'
                        });
                    }
                });
            });


        });
    </script>
</body>

</html>
