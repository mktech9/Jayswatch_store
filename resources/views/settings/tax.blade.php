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
            <h4 class="fw-medium mb-0">Tax Settings</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tax</li>
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
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listTax" role="tab"
                                            id="listTaxTab">
                                            Tax List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#addTax" role="tab"
                                            id="addTaxTabLink">
                                            Add Tax
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="listTax" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="taxTable"
                                                class="table table-bordered table-striped text-center w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tax Name</th>
                                                        <th>Tax Rate (%)</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="addTax" role="tabpanel">
                                        <form method="POST" id="addTaxForm" class="needs-validation" novalidate>
                                            @csrf
                                            <input type="hidden" name="id" id="tax_id">

                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dynamic_field">
                                                    <thead>
                                                        <tr>
                                                            <th>Tax Name <span class="text-danger">*</span></th>
                                                            <th>Tax Rate (%) <span class="text-danger">*</span></th>
                                                            <th width="10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamic_body">
                                                        <tr id="row0">
                                                            <td>
                                                                <input type="text" name="tax[]"
                                                                    placeholder="Enter Tax Name" class="form-control"
                                                                    required />
                                                                <div class="invalid-feedback"> Tax Name is required</div>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01" name="tax_rate[]"
                                                                    placeholder="Enter Rate" class="form-control"
                                                                    required />
                                                                <div class="invalid-feedback">Tax Value is required</div>
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
                                                    Tax</button>
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
            var table = $('#taxTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('tax.list') }}",
                columns: [
                    { data: 'sr_no', orderable: false },
                    { data: 'tax' },
                    { data: 'tax_rate' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { targets: '_all', className: 'text-start' }
                ],
                order: [[0, 'desc']],
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
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',
                        exportOptions: { columns: ':not(:last-child)' }
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
                        exportOptions: { columns: ':not(:last-child)' },
                        customize: function (doc) {
                            doc.pageMargins = [10, 10, 10, 10];
                            if (doc.content[1] && doc.content[1].table) {
                                var table = doc.content[1].table;
                                table.widths = Array(table.body[0].length).fill('*');
                            }
                        }
                    }
                ]
            });
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");

                if (target === '#listTax') {
                    table.ajax.reload(null, false);
                }
                else if (target === '#addTax') {
                    if (!isEditMode) {
                        resetForm();
                    }
                }
            });
            var i = 0;

            $('#add').click(function () {
                i++;
                var html = '';
                html += '<tr id="row' + i + '">';
                html += '<td>';
                html += '<input type="text" name="tax[]" placeholder="Enter Tax Name" class="form-control" required/>';
                html += '<div class="invalid-feedback">Tax Name is required</div>';
                html += '</td>';
                html += '<td>';
                html += '<input type="number" step="0.01" name="tax_rate[]" placeholder="Enter Rate" class="form-control" required/>';
                html += '<div class="invalid-feedback">Tax Value is required</div>';
                html += '</td>';
                html += '<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove"><i class="bx bx-minus"></i></button></td>';

                html += '</tr>';
                $('#dynamic_body').append(html);
            });

            $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $('#row' + button_id).remove();
            });

            $('#addTaxForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();

                let updateId = $('#tax_id').val();
                let url = updateId ? "{{ route('tax.update') }}" : "{{ route('tax.store') }}";

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

                            resetForm();
                            $('a[href="#listTax"]').tab('show');

                        } else if (response.status === 400) {
                            let errorMessages = "";
                            $.each(response.errors, function (key, err_values) {
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
                                    inputField.removeClass('is-valid').addClass('is-invalid');
                                    inputField.siblings('.invalid-feedback').text(err_values[0]).show();
                                    errorMessages += err_values[0] + "<br>";
                                }
                            });
                            iziToast.error({
                                title: '',
                                message: errorMessages,
                                position: 'topRight'
                            });

                        } else {
                            iziToast.error({
                                title: 'Error',
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

        return; // stop further generic error toast
    }

    iziToast.error({
        title: 'Error',
        message: 'Something went wrong.',
        position: 'topRight'
    });
}

                });
            });

            $(document).on('click', '.editTax', function () {
                let id = $(this).data('id');

                resetForm();
                isEditMode = true;

                    let url = "{{ route('tax.edit', ':id') }}";
    url = url.replace(':id', id);

                $.ajax({
            url: url,
                    type: "GET",
                    success: function (response) {
                        if (response.status === 200) {
                            let data = response.data;
                            new bootstrap.Tab(document.querySelector('a[href="#addTax"]')).show();
                            $('#tax_id').val(data.t_id);
                            $('input[name="tax[]"]').eq(0).val(data.tax);
                            $('input[name="tax_rate[]"]').eq(0).val(data.tax_rate);
                            $('#add').hide();
                            $('#addTaxTabLink').text('Edit Tax');
                            $('#submitBtn').text('Update Tax');
                            setTimeout(() => { isEditMode = false; }, 200);
                        }
                    }
                });
            });

            $(document).on('click', '.deleteTax', function () {
                let id = $(this).data('id');
                let name = $(this).data('name');

                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Delete Confirmation',
                    message: 'Are you sure you want to delete <b>' + name + '</b>?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                            $.ajax({
                                url: "{{ route('tax.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    t_id: id
                                },
                                success: function (response) {
                                    if (response.status) {
                                        iziToast.success({
                                            title: 'Deleted',
                                            message: response.message,
                                            position: 'topRight'
                                        });
                                        table.ajax.reload(null, false);
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
            $('#cancelBtn').on('click', function () {
                $('a[href="#listTax"]').tab('show');
            });

            function resetForm() {
                $('#addTaxForm')[0].reset();
                $('#tax_id').val('')
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();
                var rowCount = $('#dynamic_body tr').length;
                if (rowCount > 1) {
                    $('#dynamic_body tr').not(':first').remove();
                }
                $('#add').show();
                $('#addTaxTabLink').text('Add Tax');
                $('#submitBtn').text('Save Tax');
            }

        });
    </script>
</body>

</html>