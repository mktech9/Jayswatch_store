<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    .dt-buttons {
        white-space: nowrap;
        overflow-x: auto;
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
        font-weight: 500;
    }

    .is-invalid~.invalid-feedback {
        display: block;
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">TCS Settings</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">TCS</li>
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
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listTcs" role="tab"
                                            id="listTcsTabLink">
                                            TCS List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#addTcs" role="tab"
                                            id="addTcsTabLink">
                                            Add TCS
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="listTcs" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="tcsTable"
                                                class="table table-bordered table-striped text-center w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Percentage (%)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="addTcs" role="tabpanel">
                                        <form method="POST" id="addTcsForm" class="needs-validation" novalidate>
                                            @csrf
                                            <input type="hidden" name="id" id="tcs_id">

                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dynamic_field">
                                                    <thead>
                                                        <tr>
                                                            <th>Percentage (%) <span class="text-danger">*</span></th>
                                                            <th width="10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamic_body">
                                                        <tr id="row0">
                                                            <td>
                                                                <input type="number" step="0.01" name="percentage[]"
                                                                    placeholder="Enter Percentage" class="form-control"
                                                                    required />
                                                                <div class="invalid-feedback">Percentage is required</div>
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="add"
                                                                    class="btn btn-success btn-sm">
                                                                    <i class="bx bx-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end mt-4">
                                                <button type="button" class="btn btn-light me-2"
                                                    id="cancelBtn">Cancel</button>
                                                <button type="submit" class="btn btn-primary px-4" id="submitBtn">Save
                                                    TCS</button>
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

        @include('partials.footer')
    </div>

    @include('partials.footer_link')

    <script>
        $(document).ready(function () {
            var isEditMode = false;

            // 1. Initialize DataTable
            var table = $('#tcsTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('tcs.list') }}",
                columns: [
                    { data: 'sr_no', orderable: false },
                    { data: 'percentage' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { targets: '_all', className: 'text-start' }
                ],
                order: [[0, 'desc']],
                // ... (Keep existing DOM/Buttons config) ...
            });

            // 2. Tab Switching Logic
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");
                if (target === '#listTcs') {
                    table.ajax.reload(null, false);
                } else if (target === '#addTcs') {
                    if (!isEditMode) resetForm();
                }
            });

            // 3. Dynamic Rows
            var i = 0;
            $('#add').click(function () {
                i++;
                var html = '<tr id="row' + i + '"><td><input type="number" step="0.01" name="percentage[]" placeholder="Enter Percentage" class="form-control" required/><div class="invalid-feedback">Percentage is required</div></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove"><i class="bx bx-minus"></i></button></td></tr>';
                $('#dynamic_body').append(html);
            });

            $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $('#row' + button_id).remove();
            });

            // 4. Submit Form (Add & Update)
            $('#addTcsForm').on('submit', function (e) {
                e.preventDefault();
                
                // ✅ Client-Side Duplicate Check (For Multiple Insertion)
                if(!isEditMode) {
                    let values = [];
                    let hasDuplicate = false;
                    $('input[name="percentage[]"]').each(function() {
                        let val = $(this).val();
                        if(val) {
                            if(values.includes(val)) {
                                hasDuplicate = true;
                                return false; // break loop
                            }
                            values.push(val);
                        }
                    });

                    if(hasDuplicate) {
                        iziToast.warning({
                            title: 'Warning',
                            message: 'Duplicate percentage values entered. Please remove duplicates before saving.',
                            position: 'topRight'
                        });
                        return; // Stop submission
                    }
                }

                let formData = new FormData(this);
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();

                let updateId = $('#tcs_id').val();
                let url = updateId ? "{{ route('tcs.update') }}" : "{{ route('tcs.store') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status === 200) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });
                            // ✅ Reload Page on Success
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // ✅ Handle Warning/Duplicate Message
                            iziToast.warning({
                                title: 'Warning',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            $('.form-control').removeClass('is-invalid');
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, err_values) {
                                let parts = key.split('.');
                                let fieldName = parts[0]; 
                                let index = parts[1]; 

                                let inputField;
                                if (index === undefined) {
                                    inputField = $('input[name="' + fieldName + '"]');
                                } else {
                                    inputField = $('input[name="' + fieldName + '[]"]').eq(index);
                                }

                                if (inputField.length > 0) {
                                    inputField.addClass('is-invalid');
                                    inputField.siblings('.invalid-feedback').text(err_values[0]).show();
                                }
                            });
                            return;
                        }
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong.',
                            position: 'topRight'
                        });
                    }
                });
            });

            // 5. Edit Button Logic
            $(document).on('click', '.edit-tcs', function () {
                let id = $(this).data('id');
                resetForm();
                isEditMode = true;

                $.ajax({
                    url: "{{ route('tcs.edit') }}",
                    method: "GET",
                    data: { id: id },
                    success: function (response) {
                        if (response.status === 200) {
                            let data = response.data;
                            new bootstrap.Tab(document.querySelector('a[href="#addTcs"]')).show();
                            $('#tcs_id').val(data.tcs_id);
                            $('input[name="percentage[]"]').eq(0).val(data.percentage);
                            $('#add').hide(); 
                            $('#addTcsTabLink').text('Edit TCS');
                            $('#submitBtn').text('Update TCS');
                            setTimeout(() => { isEditMode = false; }, 200);
                        }
                    }
                });
            });

            // 6. Delete Logic
            $(document).on('click', '.delete-tcs', function () {
                let id = $(this).data('id');
                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Delete Confirmation',
                    message: 'Are you sure you want to delete this TCS?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            $.ajax({
                                url: "{{ route('tcs.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    tcs_id: id
                                },
                                success: function (response) {
                                    if (response.status) {
                                        iziToast.success({
                                            title: 'Deleted',
                                            message: response.message,
                                            position: 'topRight'
                                        });
                                        // ✅ Reload Page on Success
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    } else {
                                        iziToast.error({ title: 'Error', message: 'Failed to delete' });
                                    }
                                }
                            });
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]
                    ]
                });
            });

            // Cancel Button
            $('#cancelBtn').on('click', function () {
                $('a[href="#listTcs"]').tab('show');
            });

            // Reset Form Logic
            function resetForm() {
                $('#addTcsForm')[0].reset();
                $('#tcs_id').val('');
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();
                var rowCount = $('#dynamic_body tr').length;
                if (rowCount > 1) {
                    $('#dynamic_body tr').not(':first').remove();
                }
                $('#add').show(); 
                $('#addTcsTabLink').text('Add TCS');
                $('#submitBtn').text('Save TCS');
            }
        });
    </script>
</body>
</html>