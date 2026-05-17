<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')

<body>

    @include('partials.switcher')

    <div class="page">

        @include('partials.header')
        @include('partials.sidebar')


        <!-- PAGE HEADER -->
        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">FAQ</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);" class="text-white-50">FAQ</a>
                </li>
                <li class="breadcrumb-item active">FAQ</li>
            </ol>
        </div>


        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">

                        <div class="card custom-card">

                            <!-- CARD HEADER -->
                            <div class="card-header d-flex justify-content-between align-items-center">

                                <ul class="nav nav-tabs card-header-tabs">

                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listTab">
                                            FAQ List
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="formTabBtn" data-bs-toggle="tab" href="#formTab">
                                            <span id="formTabText">Add FAQ</span>
                                        </a>
                                    </li>

                                </ul>

                            </div>


                            <div class="tab-content">

                                <!-- LIST TAB -->
                                <div class="tab-pane fade show active p-3" id="listTab">

                                    <table class="table table-bordered w-100" id="faqTable">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                {{-- <th>Status</th> --}}
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                    </table>

                                </div>



                                <!-- FORM TAB -->
                                <div class="tab-pane fade p-4" id="formTab">
                                    <form id="faqForm" novalidate>
                                        @csrf

                                        <input type="hidden" name="faq_id" id="faq_id">
                                        <div class="row mb-3">

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">
                                                    Type <span class="text-danger">*</span>
                                                </label>

                                                <select name="type" id="type" class="form-control" required>
                                                    <option value="">Select Type</option>
                                                    <option value="sell">Sell Page</option>
                                                    <option value="trade">Trade Page</option>
                                                    <option value="store">Our Store Page</option>
                                                    <option value="other">Other</option>
                                                </select>

                                                <div class="invalid-feedback">Please select type.</div>

                                            </div>

                                        </div>
                                        <div id="faqContainer"></div>
                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary px-5">
                                                <i class="bx bx-save me-1"></i> <span id="submitBtnText">Save FAQ</span>
                                            </button>
                                        </div>

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
    <!-- FAQ VIEW MODAL -->
    <div class="modal fade" id="viewFaqModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content shadow-lg border-0">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title fw-semibold">
                        <i class="bx bx-help-circle me-2"></i> FAQ Details
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                </div>


                <!-- Modal Body -->
                <div class="modal-body p-4">

                    <div id="viewFaqBody"></div>

                </div>


                <!-- Footer -->
                <div class="modal-footer">

                    <button class="btn btn-light border" data-bs-dismiss="modal">
                        Close
                    </button>

                </div>

            </div>
        </div>
    </div>

    @include('partials.footer_link')

    <script>
        function loadDefaultFaqRow() {
            let html = `
        <div class="faqRow">
            <div class="row g-3">

                <div class="col-md-12">
                    <label class="form-label fw-bold">Question <span class="text-danger">*</span></label>
                    <input type="text" name="question[]" class="form-control" placeholder="Enter FAQ question" required>
                    <div class="invalid-feedback">Please enter a question.</div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Answer <span class="text-danger">*</span></label>
                    <textarea name="answer[]" class="form-control" rows="4" placeholder="Enter FAQ answer" required></textarea>
                    <div class="invalid-feedback">Please enter an answer.</div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-success" id="addFaqRow">
                        <i class="bx bx-plus"></i> Add More
                    </button>
                </div>

            </div>
        </div>
        `;
            $('#faqContainer').html(html);
        }

        $(document).ready(function() {

            loadDefaultFaqRow();

            $('#type').select2({
                placeholder: "Select Type",
                allowClear: true,
                width: '100%'
            });

            /* ---------------------------
            ADD MORE ROW
            --------------------------- */

            $(document).on('click', '#addFaqRow', function() {

                let html = `
            <div class="faqRow mt-3 border p-3 rounded">
                <div class="row g-3">

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Question <span class="text-danger">*</span></label>
                        <input type="text" name="question[]" class="form-control" placeholder="Enter FAQ question" required>
                        <div class="invalid-feedback">Please enter a question.</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Answer <span class="text-danger">*</span></label>
                        <textarea name="answer[]" class="form-control" rows="4" placeholder="Enter FAQ answer" required></textarea>
                        <div class="invalid-feedback">Please enter an answer.</div>
                    </div>

                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger removeRow">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>

                </div>
            </div>
            `;

                $('#faqContainer').append(html);

            });

            $(document).on('click', '.removeRow', function() {
                $(this).closest('.faqRow').remove();
            });


            /* ---------------------------
            DATATABLE
            --------------------------- */

            let faqTable = $('#faqTable').DataTable({
                processing: true,
                ajax: "{{ route('faq.list') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'question'
                    },
                    {
                        data: 'answer'
                    },
                    // { data: 'status' },
                    {
                        data: 'created'
                    },
                    {
                        data: 'action'
                    }
                ]
            });


            /* ---------------------------
            FORM SUBMIT
            --------------------------- */

            $('#faqForm').on('submit', function(e) {

                e.preventDefault();

                let isValid = true;
                let type = $('#type').val()
                $('input[name="question[]"]').removeClass('is-invalid');
                $('textarea[name="answer[]"]').removeClass('is-invalid');

                $('input[name="question[]"]').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }
                });

                $('textarea[name="answer[]"]').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    }
                });



                if (type === '') {
                    $('#type').addClass('is-invalid')
                    return
                } else {
                    $('#type').removeClass('is-invalid')
                }

                if (!isValid) return;

                let url = "{{ route('faq.store') }}";

                if ($('#faq_id').val()) {
                    url = "{{ route('faq.update') }}";
                }

                $.ajax({
                    url: url,
                    method: "POST",
                    data: $('#faqForm').serialize(),

                    success: function(res) {

                        iziToast.success({
                            title: 'Success',
                            message: res.message,
                            position: 'topRight'
                        });

                        $('#faqForm')[0].reset();

                        $('#faq_id').val('');
                        $('#type').val(null).trigger('change');
                        loadDefaultFaqRow();

                        $('#formTabText').text('Add FAQ');
                        $('#submitBtnText').text('Save FAQ');

                        faqTable.ajax.reload();

                        $('a[href="#listTab"]').tab('show');

                    },

                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong',
                            position: 'topRight'
                        });
                    }

                });

            });


            /* ---------------------------
            VIEW
            --------------------------- */

            $(document).on('click', '.viewFaq', function() {

                let id = $(this).data('id');

                $.get("{{ route('faq.view', ':id') }}".replace(':id', id), function(res) {

                    $('#viewFaqBody').html(`
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-2">
                                <i class="bx bx-question-mark me-1"></i> Question
                            </h6>
                            <p class="mb-0">${res.data.question}</p>
                        </div>

                        <hr>

                        <div>
                            <h6 class="fw-bold text-success mb-2">
                                <i class="bx bx-message-square-detail me-1"></i> Answer
                            </h6>
                            <p class="mb-0">${res.data.answer}</p>
                        </div>

                    </div>
                </div>
                `);

                    $('#viewFaqModal').modal('show');

                });

            });


            /* ---------------------------
            EDIT
            --------------------------- */

            $(document).on('click', '.editFaq', function() {

                let id = $(this).data('id');

                $.get("{{ route('faq.edit', ':id') }}".replace(':id', id), function(res) {

                    let faq = res.data;

                    $('#faq_id').val(faq.faq_id);
                    $('#type').val(faq.type).trigger('change');

                    let html = `
                <div class="faqRow mt-3 border p-3 rounded">
                    <div class="row g-3">

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Question <span class="text-danger">*</span></label>
                            <input type="text" name="question[]" class="form-control" value="${faq.question}" required>
                            <div class="invalid-feedback">Please enter a question.</div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer[]" class="form-control" rows="4" required>${faq.answer}</textarea>
                            <div class="invalid-feedback">Please enter an answer.</div>
                        </div>

                    </div>
                </div>
                `;

                    $('#faqContainer').html(html);

                    $('#formTabText').text('Update FAQ');
                    $('#submitBtnText').text('Update FAQ');

                    $('#formTabBtn').tab('show');

                });

            });


            /* ---------------------------
            LIST TAB RESET
            --------------------------- */

            $('a[href="#listTab"]').on('shown.bs.tab', function() {

                $('#faqForm')[0].reset();
                $('#faq_id').val('');

                $('#type').val(null).trigger('change');

                loadDefaultFaqRow();

                $('#formTabText').text('Add FAQ');
                $('#submitBtnText').text('Save FAQ');

            });

            /* ---------------------------
            DELETE
            --------------------------- */

            $(document).on('click', '.deleteFaq', function() {

                let id = $(this).data('id');

                iziToast.show({
                    theme: 'dark',
                    title: 'Delete FAQ?',
                    message: 'This action cannot be undone',
                    position: 'center',
                    timeout: false,
                    overlay: true,

                    buttons: [

                        ['<button>Yes Delete</button>', function(instance, toast) {

                            $.ajax({
                                url: "{{ route('faq.delete', ':id') }}".replace(
                                    ':id', id),
                                type: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },

                                success: function(res) {
                                    iziToast.success({
                                        title: 'Deleted',
                                        message: res.message,
                                        position: 'topRight'
                                    });
                                    faqTable.ajax.reload();
                                }

                            });

                            instance.hide({}, toast);

                        }, true],

                        ['<button>Cancel</button>', function(instance, toast) {
                            instance.hide({}, toast);
                        }]

                    ]

                });

            });

        });
    </script>
</body>

</html>
