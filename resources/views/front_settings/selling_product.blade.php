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
            <h4 class="fw-medium mb-0">What are you selling?</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Front Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Selling List</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap w-100" id="sellingProTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">Action</th>
                                                <th>Brand</th>
                                                <th>Model No</th>
                                                <th>Price</th>
                                                <th>Photos </th>
                                                <th>Name </th>
                                                <th>Email id </th>
                                                <th>Phone number</th>
                                                <th>Last remark</th>
                                                <th>City </th>

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


        <div class="modal fade" id="viewSellingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title">Selling Product Details</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row mb-4" id="sellingDetailsArea"></div>

                        <hr>

                        <h6 class="fw-bold mb-3"><i class="bx bx-list-plus me-1"></i> Add Follow-up Note</h6>
                        <form id="followupForm">
                            @csrf
                            <input type="hidden" name="selling_id" id="followup_selling_id">
                            <div class="row g-2 align-items-end">
                              <div class="col-md-7">
    <label class="small text-muted">
        Follow-up Note <span class="text-danger">*</span>
    </label>
    <textarea
        name="remark"
        id="followup_note"
        class="form-control"
        rows="2"
        placeholder="Enter note here..."
        required></textarea>
</div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100"
                                        id="updateFollowupBtn">Update</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table table-sm table-bordered w-100" id="followupTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Remark</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('partials.footer')
    </div>
    @include('partials.footer_link')

    <script>
        $(document).ready(function () {
            const sellTable = $('#sellingProTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('product.selling.list') }}",
                columns: [
                    { data: 'sr_no', orderable: false },
                    { data: 'action', orderable: false, searchable: false },
                    { data: 'brand' },
                    { data: 'model' },
                    { data: 'price' },
                    { data: 'photos', orderable: false, searchable: false },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'last_remark' },
                    { data: 'city' }
                ]
            });

            $(document).on('click', '.viewSelling', function () {
                const id = $(this).data('id');
                 const SELLING_IMG_PATH = "{{ $actual_url . '/front/uploads/selling' }}/";
                $('#followupForm')[0].reset();
                $('#followup_selling_id').val(id);
                let url = "{{ route('product.selling.show', ':id') }}";
                url = url.replace(':id', id);

                $.get(url, function (res) {
                    if (res.status === 200) {
                        const d = res.data;
                        const formattedDate = d.date;
                        let imagesHtml = '<span class="text-muted">-</span>';

                        if (d.image) {
                            let imgs = d.image.split(',').map(img => img.trim());

                       imagesHtml = imgs.map(img => `
    <img src="${SELLING_IMG_PATH + img}"
        class="img-thumbnail me-2 mb-2"
        style="max-height:75px; cursor:pointer;"
        onclick="window.open('${SELLING_IMG_PATH + img}', '_blank')">
`).join('');
                        }

                        let html = `

                        <div class="row g-4">

                            <!-- LEFT : WHAT ARE YOU SELLING -->
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bx bx-store-alt me-1"></i> What are you selling?
                                </h6>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-purchase-tag fs-4 text-primary me-2"></i>
                                    <div>
                                        <p class="text-muted small mb-0">Brand</p>
                                        <p class="fw-semibold mb-0">${d.brand_name ?? '-'}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-chip fs-4 text-primary me-2"></i>
                                    <div>
                                        <p class="text-muted small mb-0">Model No</p>
                                        <p class="fw-semibold mb-0">${d.model_no}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-rupee fs-4 text-primary me-2"></i>
                                    <div>
                                        <p class="text-muted small mb-0">Expected Price</p>
                                        <p class="fw-semibold mb-0">${d.price}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start">
                                    <i class="bx bx-image fs-4 text-primary me-2 mt-1"></i>
                                    <div>
                                        <p class="text-muted small mb-1">Photos</p>
                                        ${imagesHtml}
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT : PERSONAL INFORMATION -->
                            <div class="col-md-6 ps-md-4">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bx bx-user me-1"></i> Personal Information
                                </h6>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-user fs-4 text-primary me-2"></i>
                                    <div>
                                        <p class="text-muted small mb-0">Full Name</p>
                                        <p class="fw-semibold mb-0">${d.name}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-envelope fs-4 text-primary me-2"></i>
                                    <div>
                                        <p class="text-muted small mb-0">Email Address</p>
                                        <p class="fw-semibold mb-0">${d.email_id}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bx bx-phone fs-4 text-primary me-2"></i>
                                    <div>
                                        <p class="text-muted small mb-0">Phone Number</p>
                                        <p class="fw-semibold mb-0">${d.contact_no}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <i class="bx bx-map fs-4 text-primary me-2"></i>
                                    <div>
                                        <p class="text-muted small mb-0">City</p>
                                        <p class="fw-semibold mb-0">${d.city}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        `;

                        $('#sellingDetailsArea').html(html);
                        loadFollowupList(id);
                        $('#viewSellingModal').modal('show');
                    }
                });
            });

            function loadFollowupList(sellId) {
                let url = "{{ route('selling_product.followup.list', ':id') }}";
                url = url.replace(':id', sellId);

                $.get(url, function (res) {
                    let html = '';
                    res.data.forEach(row => {
                        html += `<tr>
                    <td>${row.remark}</td>
                    <td>${row.datetime}</td>
                    <td class="text-center">${row.action}</td>
                </tr>`;
                    });
                    $('#followupTable tbody').html(html || '<tr><td colspan="4" class="text-center">No follow-ups found</td></tr>');
                });
            }

            $('#followupForm').on('submit', function (e) {
                e.preventDefault();

                $.post("{{ route('selling_product.followup.store') }}", $(this).serialize())
                    .done(function (res) {

                        if (res.success) {
                            iziToast.success({
                                title: 'Success',
                                message: res.message,
                                position: 'topRight'
                            });
 sellTable.ajax.reload(null, false);
                            $('#followup_note').val('');
                            loadFollowupList($('#followup_selling_id').val());

                        } else {
                            iziToast.warning({
                                title: 'Warning',
                                message: res.message,
                                position: 'topRight'
                            });
                        }

                    })
                    .fail(function () {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong. Please try again.',
                            position: 'topRight'
                        });
                    });
            });

            $(document).on('click', '.deleteFollowup', function () {
                const id = $(this).data('id');
                const sellId = $('#followup_selling_id').val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to remove this follow-up note.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('selling_product.followup.delete') }}", {
                            _token: "{{ csrf_token() }}",
                            id: id
                        }, function (res) {
                            if (res.success) {
                                iziToast.success({
                                    title: 'Deleted',
                                    message: res.message,
                                    position: 'topRight'
                                });
                                loadFollowupList(sellId);
                            }
                        }).fail(function () {
                            iziToast.error({
                                title: 'Error',
                                message: 'Failed to delete follow-up note.',
                                position: 'topRight'
                            });
                        });
                    }
                });
            });

            // Delete Handler
            $(document).on('click', '.deleteSelling', function () {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to remove this Sell entry.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('product.selling.delete') }}", { _token: "{{ csrf_token() }}", id: id }, function (res) {
                            Swal.fire('Deleted!', res.message, 'success');
                            sellTable.ajax.reload();
                        });
                    }
                });
            });

        });
    </script>

</body>

</html>
