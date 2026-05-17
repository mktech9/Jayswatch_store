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
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Sales Return</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Sales Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Return List</li>
            </ol>
        </div>
        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="salesReturnTable" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Credit No</th>
                                                <th>Selling Date</th>
                                                <th>Return Date</th>
                                                <th>Invoice No</th>
                                                <th>Customer</th>
                                                <th>Location</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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

        @include('partials.footer')
    </div>
    @include('partials.footer_link')

    <script>
        $(document).ready(function() {

            // Initialize DataTable
            var salesReturnTable = $('#salesReturnTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('sales.return.list') }}",
                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'credit_no'
                    },
                    {
                        data: 'sale_date'
                    },
                    {
                        data: 'return_date'
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
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                // ✅ Changed to 'text-start' to align left
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
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
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

            // View Sale Modal Logic

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
                        <span class="fw-semibold me-2 w-25">Credit No:</span>
                        <span>${d.return_no}</span>
                    </div>

                      <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Credit Date:</span>
                        <span>${new Date(d.return_date).toLocaleDateString('en-GB')}</span>
                    </div>

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

            $(document).on('click', '.printSale', function() {
                let salesId = $(this).data('id');
                let url = "{{ route('sales.print', ':id') }}".replace(':id', salesId);
                window.open(url, '_blank');
            });
        });
    </script>
</body>

</html>
