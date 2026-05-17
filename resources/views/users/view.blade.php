<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    .modal-dialog-scrollable .modal-body {
        overflow-y: auto !important;
        max-height: calc(100vh - 200px);
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">User Information</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('users.list') }}" class="text-white-50">Users</a>
                </li>
                <li class="breadcrumb-item active">{{ $user->first_name ?? '-' }} {{ $user->last_name ?? '-' }}</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">

                        <div class="card custom-card">
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-xl-3 col-lg-4 col-md-5 mb-4">
                                        <div class="card text-center h-100">
                                            <div class="card-body">

                                                <div class="mb-3">
                                                    <div
                                                        class="avatar avatar-xl rounded-circle bg-light overflow-hidden">
                                                        <img src="{{ !empty($user->profile_pic)
                                                            ? $actual_url . '/admin_assets/profile/' . $user->profile_pic
                                                            : $actual_url . '/admin_assets/images/faces/1.jpg' }}"
                                                            class="w-100 h-100" style="object-fit: cover;"
                                                            alt="avatar">
                                                    </div>
                                                </div>


                                                <h5 class="mb-1">
                                                    {{ $user->first_name ?? '-' }} {{ $user->last_name ?? '-' }}
                                                </h5>
                                                <p class="text-muted mb-2">
                                                    {{ $user->role->role_name ?? '-' }}
                                                </p>

                                                <hr>

                                                <div class="text-start">
                                                    <p><b>Username:</b> {{ $user->user_name ?? '-' }}</p>
                                                    <p><b>Email:</b> {{ $user->email_id ?? '-' }}</p>
                                                    <p>
                                                        <b>Status:</b>
                                                        @if ($user->active_status == 0)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between gap-2 mt-3">

                                                    <a href="{{ route('create.users') }}" class="btn btn-primary">
                                                        <i class="bx bx-arrow-back"></i> Back
                                                    </a>

                                                    <a href="{{ route('staffinfo.edit', encrypt($user->staff_id)) }}"
                                                        class="btn btn-warning">
                                                        <i class="bx bx-edit-alt"></i> Edit
                                                    </a>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-9 col-lg-8 col-md-7">
                                        <div class="card h-100">

                                            <div class="card-header border-bottom">
                                                <ul class="nav nav-tabs card-header-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-bs-toggle="tab"
                                                            href="#userInfo">
                                                            <i class="bx bx-user"></i> User Information
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-bs-toggle="tab" href="#documents">
                                                            <i class="bx bx-file"></i> Documents & Notes
                                                        </a>
                                                    </li>
                                                    @if (current_user_id() == $user->staff_id || current_user_id() == -1)
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#activities">
                                                                <i class="bx bx-time"></i> Activities
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>

                                            <div class="card-body tab-content">

                                                <div class="tab-pane fade show active" id="userInfo">

                                                    <h6 class="fw-semibold mb-3">Basic Information</h6>

                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <b>Role:</b><br>{{ $user->role->role_name ?? '-' }}
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Username:</b><br>{{ $user->user_name ?? '-' }}
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Email:</b><br>{{ $user->email_id ?? '-' }}
                                                        </div>

                                                        <div class="col-md-4">
                                                            <b>Prefix:</b><br>{{ $user->prefix ?? '-' }}
                                                        </div>
                                                        <div class="col-md-4"><b>First
                                                                Name:</b><br>{{ $user->first_name ?? '-' }}</div>
                                                        <div class="col-md-4"><b>Last
                                                                Name:</b><br>{{ $user->last_name ?? '-' }}</div>

                                                        <div class="col-md-4">
                                                            <b>Status:</b><br>
                                                            <span
                                                                class="badge {{ $user->active_status == 0 ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $user->active_status == 0 ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </div>

                                                        <div class="col-md-4"><b>Login
                                                                Allowed:</b><br>{{ $user->login_status == 0 ? 'Yes' : 'No' }}
                                                        </div>
                                                        <div class="col-md-4"><b>Allow
                                                                Contact:</b><br>{{ $user->allow_contact == 0 ? 'Yes' : 'No' }}
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h6 class="fw-semibold mb-3">Personal Information</h6>

                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <b>Date of Birth:</b><br>
                                                            {{ $user->dob ? $user->dob->format('d-m-Y') : '-' }}
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Gender:</b><br>{{ $user->gender ?? '-' }}
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Mobile:</b><br>{{ $user->contact_number ?? '-' }}
                                                        </div>

                                                        <div class="col-md-4"><b>Alternate
                                                                Contact:</b><br>{{ $user->alt_contact_number ?? '-' }}
                                                        </div>
                                                        <div class="col-md-8">
                                                            <b>Access Locations:</b>

                                                            @if ($locations->count())
                                                                <ul class="mb-0 ps-3"
                                                                    style="list-style-type: disc; color:#000;">
                                                                    @foreach ($locations as $location)
                                                                        <li>{{ $location->name }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                -
                                                            @endif
                                                        </div>

                                                    </div>

                                                    <hr>

                                                    <h6 class="fw-semibold mb-3">Address Information</h6>

                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <b>Permanent Address:</b><br>
                                                            {{ $user->permanent_address ?? '-' }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <b>Current Address:</b><br>
                                                            {{ $user->current_address ?? '-' }}
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h6 class="fw-semibold mb-3">Sales Information</h6>

                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <b>Sales Commission (%):</b><br>
                                                            {{ number_format($user->sales_commission ?? 0, 2) }}
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Max Sales Discount (%):</b><br>
                                                            {{ number_format($user->sales_discount ?? 0, 2) }}
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h6 class="fw-semibold mb-3">Social Links</h6>

                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <b>Facebook:</b><br>
                                                            @if ($user->facebook_link)
                                                                <a href="{{ $user->facebook_link }}"
                                                                    target="_blank">{{ $user->facebook_link }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <b>Twitter:</b><br>
                                                            @if ($user->twitter_link)
                                                                <a href="{{ $user->twitter_link }}"
                                                                    target="_blank">{{ $user->twitter_link }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    {{-- <h6 class="fw-semibold mb-3">Bank Details</h6>

                                                    <div class="row g-3">
                                                        <div class="col-md-4"><b>Account
                                                                Holder:</b><br>{{ $user->acc_holder_name ?? '-' }}</div>
                                                        <div class="col-md-4"><b>Account
                                                                Number:</b><br>{{ $user->acc_number ?? '-' }}</div>
                                                        <div class="col-md-4"><b>Bank
                                                                Name:</b><br>{{ $user->bank_name ?? '-' }}</div>

                                                        <div class="col-md-4"><b>IFSC
                                                                Code:</b><br>{{ $user->bank_code ?? '-' }}</div>
                                                        <div class="col-md-4"><b>Bank
                                                                Branch:</b><br>{{ $user->bank_branch ?? '-' }}</div>
                                                        <div class="col-md-4"><b>Tax Payer
                                                                ID:</b><br>{{ $user->tax_payer_id ?? '-' }}</div>
                                                    </div>

                                                    <hr> --}}

                                                </div>

                                                <div class="tab-pane fade" id="documents">

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold mb-0">Documents / Notes</h6>

                                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#addNoteModal"
                                                            data-staff-id="{{ $user->staff_id }}">
                                                            <i class="bi bi-plus-lg me-1"></i> Add Note
                                                        </button>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table id="documentsTable"
                                                            class="table table-bordered table-hover align-middle w-100">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width:60px">#</th>
                                                                    <th>Heading</th>
                                                                    <th>Added By</th>
                                                                    <th>Created At</th>
                                                                    <th>Updated At</th>
                                                                    <th style="width:120px">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade" id="activities">

                                                    <div class="table-responsive">
                                                        <table id="activityTable"
                                                            class="table table-bordered table-striped table-hover w-100 align-middle">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th width="5%">Sr No</th>
                                                                    <th width="30%">Date</th>
                                                                    <th width="20%">Action</th>
                                                                    <th width="45%">By</th>
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
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="addNoteModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <form id="addDocForm" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="doc_id" id="doc_id">
                        <input type="text" name="staff_id" id="noteStaffId" hidden>

                        <div class="modal-header">
                            <h5 class="modal-title fw-semibold">Add Note</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Heading <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <div id="noteEditor" style="height: 250px;"></div>
                                <textarea name="description" id="noteDescription" hidden></textarea>
                            </div>

                            <div id="existing_files_area" class="mb-3 d-none">
                                <label class="form-label fw-semibold text-dark">Existing Documents</label>
                                <div id="existing_files_list" class="d-flex flex-column gap-2">
                                </div>
                                <hr>
                            </div>

                            <div class="d-flex mb-3 align-items-center justify-content-between">
                                <p class="mb-0 fw-semibold fs-14">Upload New Files</p>
                            </div>

                            <div class="mb-3">
                                <input type="file" class="multiple-filepond bd-gray-100 text-primary"
                                    name="files[]" multiple data-allow-reorder="true" data-max-file-size="3MB"
                                    data-max-files="6">
                            </div>

                            <div class="form-check form-switch" style="cursor: pointer;">
                                <input class="form-check-input" type="checkbox" name="is_private" value="1"
                                    id="isPrivate" style="cursor: pointer;" checked>
                                <label class="form-check-label fw-semibold" for="isPrivate" style="cursor: pointer;">
                                    Is Private?
                                </label>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="viewDocModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">View Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p><strong>Title:</strong> <span id="v_title"></span></p>
                        <p><strong>Description:</strong></p>
                        <div id="v_description"></div>

                        <p class="mt-2"><strong>Files:</strong></p>
                        <div id="v_files" class="d-flex gap-2 flex-wrap"></div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>

    @include('partials.footer_link')

    <script>
        const quill = new Quill('#noteEditor', {
            theme: 'snow',
            placeholder: 'Enter description...',
            modules: {
                toolbar: [
                    [{
                        font: []
                    }],
                    [{
                        size: ['small', false, 'large', 'huge']
                    }],
                    [{
                        header: [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: 'sub'
                    }, {
                        script: 'super'
                    }],
                    ['blockquote', 'code-block'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    [{
                        indent: '-1'
                    }, {
                        indent: '+1'
                    }],
                    [{
                        align: []
                    }],
                    [{
                        direction: 'rtl'
                    }],
                    ['link', 'image', 'video'],
                    ['formula'],
                    ['clean']
                ]
            }
        });

        quill.on('text-change', function() {
            document.getElementById('noteDescription').value = quill.root.innerHTML;
        });
    </script>

    <script>
        const pond = FilePond.create(document.querySelector('.multiple-filepond'), {
            allowMultiple: true,
            allowReorder: true,
            storeAsFile: true,
            maxFiles: 6,
            maxFileSize: '3MB',
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'application/pdf'],
            imagePreviewHeight: 120,
            imageResizeTargetWidth: 1024,
            imageResizeMode: 'contain',
            instantUpload: false,
            labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>',
        });
    </script>

    <script>
        let originalFilesList = [];

        $(document).ready(function() {
            $(document).on('click', '[data-bs-target="#addNoteModal"]', function() {
                $('#noteStaffId').val($(this).data('staff-id'));
            });
            $('#addDocForm').on('submit', function(e) {
                e.preventDefault();
                console.clear();
                console.log("--- SUBMIT HANDLER STARTED ---");
                let currentExistingFiles = [];
                $('.existing-file-input').each(function() {
                    currentExistingFiles.push($(this).val());
                });

                let removedFiles = originalFilesList.filter(file => !currentExistingFiles.includes(file));


                let newFilesObjects = pond.getFiles();
                let newFileNames = newFilesObjects.map(f => f.file.name);

                console.group("Document Update Details");
                console.log("Original Files (When Edit Opened):", originalFilesList);
                console.log("Files Kept (Sending to DB):", currentExistingFiles);
                console.log("Files Removed (User deleted these):", removedFiles);
                console.log("New Files Added:", newFileNames);
                console.groupEnd();


                let title = $('input[name="title"]').val().trim();
                if (!title) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Heading is required'
                    });
                    return;
                }

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('staff.doc.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        iziToast.success({
                            title: 'Success',
                            message: res.message,
                            position: 'topRight'
                        });
                        $('#addNoteModal').modal('hide');
                        $('#addDocForm')[0].reset();
                        documentsTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON?.message ?? 'Something went wrong'
                        });
                    }
                });
            });

            document.getElementById('addNoteModal').addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (button) {
                    document.getElementById('addDocForm').reset();
                    quill.setContents([]);
                    document.getElementById('noteDescription').value = '';
                    pond.removeFiles();
                    document.getElementById('doc_id').value = '';

                    $('#existing_files_area').addClass('d-none');
                    $('#existing_files_list').empty();
                    originalFilesList = [];

                    $('#addNoteModal .modal-title').text('Add Note');
                    if (button.getAttribute('data-staff-id')) {
                        document.getElementById('noteStaffId').value = button.getAttribute('data-staff-id');
                    }
                }
            });

            let staffId = "{{ $user->staff_id }}";
            let documentsTable = $('#documentsTable').DataTable({
                processing: true,
                serverSide: false,
                destroy: true,
                responsive: true,
                ajax: {
                    url: "{{ route('staff.doc.list', ':staff_id') }}".replace(':staff_id', staffId),
                    type: "GET"
                },
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    searchable: false
                }],
                order: [],
                columns: [{
                        data: 'sr_no'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'added_by'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.editDoc', function() {
                let id = $(this).data('id');
                let editUrl = "{{ route('staff.doc.edit', ':id') }}".replace(':id', id);

                $.ajax({
                    url: editUrl,
                    type: "GET",
                    success: function(res) {
                        if (res.status) {
                            let data = res.data;
                            let files = res.files || [];


                            originalFilesList = [...files];
                            console.log("Edit Mode Started. Original Files:",
                                originalFilesList);

                            $('#doc_id').val(data.sd_id);
                            $('input[name="title"]').val(data.title);
                            $('#noteStaffId').val(data.staff_id);
                            $('#isPrivate').prop('checked', data.is_private == 1);

                            if (data.description) {
                                quill.root.innerHTML = data.description;
                                $('#noteDescription').val(data.description);
                            } else {
                                quill.root.innerHTML = '';
                                $('#noteDescription').val('');
                            }

                            let fileListHtml = '';
                            if (files.length > 0) {
                                $('#existing_files_area').removeClass('d-none');
                                files.forEach(function(fileName) {
                                    let fileUrl =
                                        `{{ $actual_url }}/admin_assets/staff_doc/${fileName}`;
                                    let isImage = /\.(jpg|jpeg|png|webp)$/i.test(
                                        fileName);

                                    fileListHtml += `
                                        <div class="existing-file-item border rounded p-2 d-flex align-items-center justify-content-between bg-white mb-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div>
                                                    ${isImage
                                            ? `<img src="${fileUrl}" width="40" height="40" class="rounded object-fit-cover border">`
                                            : `<i class="bx bxs-file-pdf fs-2 text-danger"></i>`
                                        }
                                                </div>
                                                <div>
                                                    <a href="${fileUrl}" target="_blank" class="text-dark fw-medium text-decoration-none text-truncate d-block" style="max-width: 200px;">
                                                        ${fileName}
                                                    </a>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-danger btn-icon remove-existing-file" data-filename="${fileName}">
                                                <i class="bx bx-x"></i>
                                            </button>

                                            <input type="hidden" name="existing_files[]" value="${fileName}" class="existing-file-input">
                                        </div>
                                    `;
                                });
                                $('#existing_files_list').html(fileListHtml);
                            } else {
                                $('#existing_files_area').addClass('d-none');
                                $('#existing_files_list').empty();
                            }
                            $('#addNoteModal .modal-title').text('Edit Note');
                            pond.removeFiles();
                            $('#addNoteModal').modal('show');
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to fetch document data'
                        });
                    }
                });
            });

            $(document).on('click', '.remove-existing-file', function() {
                $(this).closest('.existing-file-item').remove();

                if ($('#existing_files_list').children().length === 0) {
                    $('#existing_files_area').addClass('d-none');
                }
            });

            $(document).on('click', '.viewDoc', function() {
                let id = $(this).data('id');
                let showUrl = "{{ route('staff.doc.show', ':id') }}".replace(':id', id);

                $.ajax({
                    url: showUrl,
                    type: "GET",
                    success: function(res) {
                        let d = res.data;
                        $('#v_title').text(d.title ?? '-');
                        $('#v_description').html(d.description ?? '-');
                        $('#v_files').empty();

                        if (res.files.length > 0) {
                            res.files.forEach(f => {
                                let fileUrl =
                                    "{{ $actual_url }}/admin_assets/staff_doc/" + f;
                                let isImage = /\.(jpg|jpeg|png|webp)$/i.test(f);
                                $('#v_files').append(`
                                    <div class="border rounded p-2 d-flex align-items-center gap-3" style="min-width:260px">
                                        <div>
                                            ${isImage
                                        ? `<img src="${fileUrl}" width="60" height="60" class="rounded border" style="object-fit:cover;">`
                                        : `<i class="bx bxs-file-pdf fs-1 text-danger"></i>`
                                    }
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold small text-truncate" style="max-width:180px">${f}</div>
                                            <div class="mt-1 d-flex gap-2">
                                                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bx bx-show"></i> View</a>
                                                <a href="${fileUrl}" download class="btn btn-sm btn-primary"><i class="bx bx-download"></i> Download</a>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            $('#v_files').html('<span class="text-muted">No files</span>');
                        }
                        $('#viewDocModal').modal('show');
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Unable to load document'
                        });
                    }
                });
            });

            let table = $('#activityTable').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,

                ajax: {
                    url: "{{ route('user.logs') }}",
                    data: {
                        staff_id: staffId
                    },
                    dataSrc: ''
                },
                columns: [{
                        data: 'sr_no',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        className: 'text-center',
                        render: function(data, type, row) {

                            if (type === 'sort' || type === 'type') {
                                return row.log_date; // use DB format for sorting
                            }

                            return data; // show Indian format
                        }
                    },
                    {
                        data: 'action',
                        className: 'text-center fw-semibold'
                    },
                    {
                        data: 'by',
                        className: 'text-center'
                    }
                ],

                order: [
                    [1, 'desc']
                ],

                // ✅ SHOW 3 ENTRIES BY DEFAULT
                pageLength: 3,
                lengthMenu: [
                    [3, 10, 25, 50],
                    [3, 10, 25, 50]
                ],

                // ✅ CENTER EXPORT BUTTONS
                dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
                    "<'row mb-2'<'col-sm-12 d-flex justify-content-center'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",

                buttons: [{
                        extend: 'excel',
                        title: 'User Log'
                    },
                    {
                        extend: 'pdf',
                        title: 'User Log'
                    },
                    {
                        extend: 'print',
                        title: 'User Log'
                    }
                ]
            });

        });
    </script>
</body>

</html>
