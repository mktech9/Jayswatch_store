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
            <h4 class="fw-medium mb-0">Quick Sale</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Sales</a></li>
                <li class="breadcrumb-item active" aria-current="page">Quick Sale List</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100" id="quickSaleTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Full Name</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
                                        <th>Final Total</th>
                                        <th>Bill Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewQuickSaleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title d-flex align-items-center">
                            <i class="bx bx-receipt me-2"></i> Quick Sale Details
                        </h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4" id="printArea">
                        <div id="quickSaleDetailsContent"></div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="window.print()">
                            <i class="bx bx-printer me-1"></i> Print
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
            // 1. Initialize DataTable
            var table = $('#quickSaleTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('quicksale.list') }}",
                columns: [
                    { data: 'sr_no', orderable: false, searchable: false },
                    { data: 'invoice_num' },
                    { data: 'fullname' },
                    { data: 'mobile_num' },
                    { data: 'email' },
                    { data: 'final_total' },
                    { data: 'bill_date' },
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rtip',
                language: {
                    searchPlaceholder: "Search...",
                    sSearch: ""
                }
            });

            // 2. View Modal Handler
            $(document).on('click', '.viewQuickSale', function() {
                var id = $(this).data('id');
                var url = "{{ route('quicksale.show', ':id') }}".replace(':id', id);

                // Show spinner
                $('#quickSaleDetailsContent').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>');
                $('#viewQuickSaleModal').modal('show');

                $.get(url, function(res) {
                    if (res.status === 200) {
                        var sale = res.sale;
                        var products = res.products;
                        var payments = res.payments;

                        var idFileLink = '-';
                        if(sale.id_proof_file) {
                            var filePath = "{{ asset('assets/admin_assets/quicksale_documents') }}/" + sale.id_proof_file;
                            idFileLink = `<a href="${filePath}" target="_blank" class="text-primary fw-semibold text-decoration-none">
                                            <i class="bx bx-link-external me-1"></i> View ID File
                                          </a>`;
                        }

                        // --- Generate Product Rows ---
                        var productRows = '';
                        if (products.length > 0) {
                            products.forEach(function(p, index) {
                                productRows += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${p.product_name || '-'} <br><small class="text-muted">${p.description || ''}</small></td>
                                        <td>${p.hsn_code || '-'}</td>
                                        <td class="text-center">${p.qty}</td>
                                        <td class="text-end fw-bold">${parseFloat(p.per_total_price).toFixed(2)}</td>
                                    </tr>`;
                            });
                        } else {
                            productRows = '<tr><td colspan="5" class="text-center text-muted">No products found</td></tr>';
                        }

                        // --- Generate Payment Rows ---
                        var paymentRows = '';
                        if (payments.length > 0) {
                            payments.forEach(function(pay) {
                                paymentRows += `
                                    <tr>
                                        <td>${pay.split_type || '-'}</td>
                                        <td>${pay.split_bank || '-'}</td>
                                        <td>${pay.split_chq_card || '-'}</td>
                                        <td>${pay.split_Date || '-'}</td>
                                        <td class="text-end fw-bold text-success">${parseFloat(pay.split_amt).toFixed(2)}</td>
                                    </tr>`;
                            });
                        } else {
                            paymentRows = '<tr><td colspan="5" class="text-center text-muted">No payment details found</td></tr>';
                        }

                        // --- Construct HTML ---
                        var html = `
                            <div class="row mb-4">
                                <div class="col-md-6 border-end">
                                    <h6 class="fw-bold text-primary mb-3">Invoice Information</h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td class="text-muted w-40">Invoice No:</td> <td class="fw-bold text-dark">${sale.invoice_num}</td></tr>
                                        <tr><td class="text-muted">Bill Date:</td> <td>${sale.bill_date}</td></tr>
                                        <tr><td class="text-muted">Payment Status:</td> <td><span class="badge bg-${sale.payment_status === 'Paid' ? 'success' : 'warning'}">${sale.payment_status}</span></td></tr>
                                        <tr><td class="text-muted">GST Applicable:</td> <td>${sale.gst_applicable || 'No'}</td></tr>
                                        <tr><td class="text-muted">GST Amount:</td> <td>${parseFloat(sale.gst_amount || 0).toFixed(2)}</td></tr>
                                    </table>
                                </div>

                                <div class="col-md-6 ps-4">
                                    <h6 class="fw-bold text-primary mb-3">Customer Details</h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td class="text-muted w-40">Full Name:</td> <td class="fw-bold">${sale.fullname}</td></tr>
                                        <tr><td class="text-muted">Mobile:</td> <td>${sale.mobile_num || '-'}</td></tr>
                                        <tr><td class="text-muted">Email:</td> <td>${sale.email || '-'}</td></tr>
                                        <tr><td class="text-muted">State / Pincode:</td> <td>${sale.state || ''} ${sale.pincode ? '- ' + sale.pincode : ''}</td></tr>
                                        <tr><td class="text-muted">ID Proof Type:</td> <td>${sale.id_proof_type || '-'}</td></tr>
                                        <tr><td class="text-muted">ID Proof Number:</td> <td>${sale.id_numbers || '-'}</td></tr>
                                        <tr><td class="text-muted">ID Proof File:</td> <td>${idFileLink}</td></tr>
                                    </table>
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mt-4 mb-2">Items Purchased</h6>
                            <div class="table-responsive border rounded-2 mb-4">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th> <th>Product</th> <th>HSN</th> <th class="text-center">Qty</th> <th class="text-end">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>${productRows}</tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                                            <td class="text-end fw-bold text-primary">${parseFloat(sale.finaltotal).toFixed(2)}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <h6 class="fw-bold text-dark mt-4 mb-2">Payment History</h6>
                            <div class="table-responsive border rounded-2">
                                <table class="table table-bordered mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Payment Type</th> <th>Bank</th> <th>Ref/Card No</th> <th>Date</th> <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>${paymentRows}</tbody>
                                </table>
                            </div>
                        `;

                        $('#quickSaleDetailsContent').html(html);
                    }
                });
            });
        });
    </script>
</body>
</html>