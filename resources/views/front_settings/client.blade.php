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
            <h4 class="fw-medium mb-0">Client Reviews</h4>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                            href="#listTab">Reviews List</a></li>
                                    <li class="nav-item"><a class="nav-link" id="formTabBtn" data-bs-toggle="tab"
                                            href="#formTab">Add Review</a></li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade show active p-3" id="listTab" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered w-100" id="clientTable">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Client Name</th>
                                                    <th>Review</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-4" id="formTab" role="tabpanel">
                                    <form id="clientForm">
                                        @csrf
                                        <input type="hidden" name="client_id" id="client_id">
                                        <div class="mb-3">
                                            <label class="form-label">Client Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="client_name" id="client_name" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Review <span class="text-danger">*</span></label>
                                            <textarea name="review" id="review" class="form-control" rows="4"
                                                required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="saveBtn">Save Review</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.footer')
    </div>
    @include('partials.footer_link')

    <script>
        let clientTable;
        $(document).ready(function () {
            clientTable = $('#clientTable').DataTable({
                processing: true, serverSide: true,
                ajax: "{{ route('client.list') }}",
                columns: [{ data: 'sr_no' }, { data: 'client_name' }, { data: 'review' }, { data: 'action' }]
            });

            $('a[href="#listTab"]').on('shown.bs.tab', function () { resetClientForm(); $('#formTabBtn').text('Add Review'); });

            $('#clientForm').on('submit', function (e) {
                e.preventDefault();
                if (!$('#client_name').val() || !$('#review').val()) {
                    iziToast.error({ title: 'Error', message: 'All fields are required', position: 'topRight' });
                    return;
                }
                $.post("{{ route('client.store') }}", $(this).serialize(), function (res) {
                    iziToast.success({ title: 'Success', message: res.message, position: 'topRight' });
                    resetClientForm(); clientTable.ajax.reload();
                    bootstrap.Tab.getOrCreateInstance(document.querySelector('a[href="#listTab"]')).show();
                });
            });

            $(document).on('click', '.editClient', function () {
                const id = $(this).data('id');

                let url = "{{ route('client.edit', ':id') }}";
                url = url.replace(':id', id);

                $.get(url, function (res) {
                    if (res.status === 200) {
                        $('#client_id').val(res.data.client_id);
                        $('#client_name').val(res.data.client_name);
                        $('#review').val(res.data.review);
                        $('#formTabBtn').text('Edit Review');
                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#formTabBtn')).show();
                    }
                });
            });

            $(document).on('click', '.deleteClient', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('client.delete') }}", { _token: "{{ csrf_token() }}", id: id }, function (res) {
                            Swal.fire('Deleted!', res.message, 'success');
                            clientTable.ajax.reload();
                        });
                    }
                });
            });
        });

        function resetClientForm() { $('#client_id').val(''); $('#clientForm')[0].reset(); }
    </script>
</body>

</html>