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



            $('#statusUpdateModal').on('shown.bs.modal', function() {

                $('#updateStockStatus').select2({
                    dropdownParent: $('#statusUpdateModal'), // ✅ MOST IMPORTANT
                    width: "100%",
                    minimumResultsForSearch: Infinity,
                    placeholder: "Please Select Status"
                });

            });

















            $('#stockTrasferTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('stock.in.list') }}",

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
                                            // ✅ Reload DataTable
                                            $("#stockTrasferTable").DataTable().ajax
                                                .reload(null,
                                                    false);
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
