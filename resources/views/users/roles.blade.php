<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    /* ===== Permission UI ===== */
    .permission-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 18px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    .permission-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px dashed #e5e7eb;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .permission-title {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .permission-sub {
        margin-left: 20px;
        margin-top: 15px;
        padding-left: 15px;
        border-left: 3px solid #e5e7eb;
    }

    .permission-chip {
        background: #f8fafc;
        border-radius: 8px;
        padding: 10px 12px;
        transition: all .2s ease;
        cursor: pointer;
    }

    .permission-chip:hover {
        background: #eef2ff;
    }

    .permission-chip .form-check-input {
        margin-top: 0.2rem;
    }

    .permission-chip label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    /* Toggle style */
    .form-check-input {
        cursor: pointer;
    }

    .menu-select-all,
    .submenu-select-all {
        transform: scale(1.1);
    }

    /* Global buttons */
    .permission-actions button {
        border-radius: 20px;
        padding: 4px 14px;
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Roles Management</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">User-Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Roles</li>
            </ol>
        </div>
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-12">

                        <div class="card custom-card">

                            <!-- CARD HEADER / TABS -->
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">

                                    <!-- ROLE LIST TAB (DEFAULT) -->
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listRole" role="tab">
                                            Role List
                                        </a>
                                    </li>

                                    <!-- ADD ROLE TAB -->
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#addRole" role="tab">
                                            Add Role
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            <!-- CARD BODY -->
                            <div class="tab-content">

                                <!-- ================= ROLE LIST TAB ================= -->
                                <div class="tab-pane fade show active" id="listRole" role="tabpanel">
                                    <div class="table-responsive">
                                        <table id="roleTable"
                                            class="table table-bordered table-striped text-center w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Role Name</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <!-- ================= ADD ROLE TAB ================= -->
                                <div class="tab-pane fade" id="addRole" role="tabpanel">
                                    <form id="roleForm" class="row g-3 needs-validation" novalidate>
                                        @csrf
                                        <input type="hidden" name="role_id" id="roleId">

                                        <div class="col-md-4">
                                            <label for="roleName" class="form-label">Role Name <span
                                                    class="text-danger">*</span></label>

                                            <input type="text" id="roleName" name="role_name" class="form-control"
                                                placeholder="Enter role name" required>



                                            <div class="invalid-feedback">
                                                Please enter a role name.
                                            </div>
                                        </div>


                                        <hr>

                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0">Permissions</h5>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        id="selectAllGlobal">Select All</button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        id="unselectAllGlobal">Unselect All</button>
                                                </div>
                                            </div>

                                            @foreach ($menus as $menu)
                                                <div class="permission-card">

                                                    <!-- MENU HEADER -->
                                                    <div class="permission-header">
                                                        <div class="permission-title">
                                                            <i
                                                                class="{{ $menu->menu_icon ?? 'ri-menu-line' }} me-2 text-primary"></i>
                                                            {{ $menu->menu_name }}
                                                        </div>

                                                        {{-- Select All only if NO submenu --}}
                                                        @if ($menu->is_submenu == 0)
                                                            <div class="form-check">
                                                                <input class="form-check-input menu-select-all"
                                                                    type="checkbox" data-menu="{{ $menu->menu_id }}">
                                                                <label class="form-check-label fw-semibold">Select
                                                                    All</label>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- MENU PERMISSIONS -->
                                                    <div class="row g-2">

                                                        {{-- MENU WITH SUBMENU → ONLY VIEW --}}
                                                        @if ($menu->is_submenu == 1)
                                                            <div class="col-md-3">
                                                                <div class="permission-chip">
                                                                    <div class="form-check">
                                                                        <input
                                                                            class="form-check-input permission-checkbox menu-{{ $menu->menu_id }}"
                                                                            type="checkbox"
                                                                            data-menu-view="{{ $menu->menu_id }}"
                                                                            name="permissions[menu][{{ $menu->menu_id }}][]"
                                                                            value="can_view">
                                                                        <label class="form-check-label">
                                                                            👁 View {{ strtolower($menu->menu_name) }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{-- MENU WITHOUT SUBMENU → FULL CRUD --}}
                                                            @foreach (['view', 'create', 'update', 'delete', 'export'] as $perm)
                                                                <div class="col-md-3">
                                                                    <div class="permission-chip">
                                                                        <div class="form-check">
                                                                            <input
                                                                                class="form-check-input permission-checkbox menu-{{ $menu->menu_id }}"
                                                                                type="checkbox"
                                                                                name="permissions[menu][{{ $menu->menu_id }}][]"
                                                                                value="can_{{ $perm }}">
                                                                            <label
                                                                                class="form-check-label text-capitalize">
                                                                                {{ ucfirst($perm) }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                    <!-- SUB MENUS -->
                                                    @if ($menu->is_submenu == 1 && isset($subMenus[$menu->menu_id]))
                                                        @foreach ($subMenus[$menu->menu_id] as $sub)
                                                            <!-- Inside the submenu loop -->
                                                            <div class="permission-sub">
                                                                <div class="permission-header">
                                                                    <div class="permission-title fs-14">
                                                                        {{ $sub->sub_menu_name }}
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input
                                                                            class="form-check-input submenu-select-all"
                                                                            type="checkbox"
                                                                            data-parent-menu="{{ $menu->menu_id }}"
                                                                            data-submenu-id="{{ $sub->sub_menu_id }}">
                                                                        <!-- ← Add this -->
                                                                        <label
                                                                            class="form-check-label fw-semibold">Select
                                                                            All</label>
                                                                    </div>
                                                                </div>

                                                                <div class="row g-2">
                                                                    @foreach (['view', 'create', 'update', 'delete', 'export'] as $perm)
                                                                        <div class="col-md-3">
                                                                            <div class="permission-chip">
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input permission-checkbox
                                  submenu-{{ $menu->menu_id }}
                                  submenu-item-{{ $sub->sub_menu_id }}"
                                                                                        type="checkbox"
                                                                                        name="permissions[sub_menu][{{ $sub->sub_menu_id }}][]"
                                                                                        value="can_{{ $perm }}">
                                                                                    <label
                                                                                        class="form-check-label text-capitalize">
                                                                                        {{ ucfirst($perm) }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-12 d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-primary px-4">
                                                Save Role
                                            </button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <!-- End::row-1 -->

            </div>
        </div>


        @include('partials.footer')




    </div>


    @include('partials.footer_link')
    <script>
        $(document).ready(function() {
            let isEditMode = false;


            $('#selectAllGlobal').on('click', function() {

                // enable submenu items
                $('.submenu-select-all, .permission-checkbox[class*="submenu-"]')
                    .prop('disabled', false);

                // check all checkboxes
                $('.permission-checkbox').prop('checked', true);
            });


            $('#unselectAllGlobal').on('click', function() {

                // uncheck all
                $('.permission-checkbox').prop('checked', false);

                // disable all submenu permissions again
                $('.submenu-select-all, .permission-checkbox[class*="submenu-"]')
                    .prop('disabled', true);
            });




            $('.menu-select-all').on('change', function() {
                const menuId = $(this).data('menu');

                // check menu permissions
                $('.menu-' + menuId).prop('checked', this.checked);

                // enable + check submenu under that menu
                $('.submenu-' + menuId)
                    .prop('disabled', !this.checked)
                    .prop('checked', this.checked);

                $('.submenu-select-all[data-parent-menu="' + menuId + '"]')
                    .prop('disabled', !this.checked)
                    .prop('checked', this.checked);
            });


            $(document).on('change', '.submenu-select-all', function() {
                const submenuId = $(this).data('submenu-id');
                const isChecked = this.checked;

                // Only affect checkboxes of THIS exact submenu
                $(`.submenu-item-${submenuId}`).prop('checked', isChecked);
            });


            $('.submenu-select-all, .permission-checkbox[class*="submenu-"]')
                .prop('disabled', true);


            $('[data-menu-view]').on('change', function() {

                const menuId = $(this).data('menu-view');

                const submenuCheckboxes = $('.submenu-' + menuId);
                const submenuSelectAll = $('.submenu-select-all[data-parent-menu="' + menuId + '"]');

                if (this.checked) {
                    submenuCheckboxes.prop('disabled', false);
                    submenuSelectAll.prop('disabled', false);
                } else {
                    submenuCheckboxes.prop('checked', false).prop('disabled', true);
                    submenuSelectAll.prop('checked', false).prop('disabled', true);
                }
            });


            $('#roleForm').on('submit', function(e) {
                e.preventDefault();

                const roleName = $('#roleName').val()?.trim();

                if (!roleName) {
                    iziToast.warning({
                        title: 'Required',
                        message: 'Role name is required',
                        position: 'topRight'
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('roles.store') }}",
                    type: "POST",
                    data: $(this).serialize(),



                    success: function(res) {

                        if (res.status) {

                            iziToast.success({
                                title: 'Success',
                                message: res.message,
                                position: 'topRight',
                                timeout: 3000
                            });

                            $('#roleForm')[0].reset();


                            $('a[href="#listRole"]').tab('show');


                            roleTable.ajax.reload(null, false);

                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: 'Something went wrong',
                                position: 'topRight'
                            });
                        }
                    },

                    error: function(xhr) {
                        iziToast.error({
                            title: 'Failed',
                            message: xhr.responseJSON?.message || 'Server error',
                            position: 'topRight'
                        });
                    }
                });
            });



            var roleTable = $('#roleTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('roles.list') }}",

                columns: [{
                    data: 'sr_no',
                    orderable: false
                }, {
                    data: 'role_name'
                }, {
                    data: 'created_at'
                }, {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }],

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
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'csvHtml5',
                    text: '<i class="bx bx-file"></i> Export to CSV',
                    className: 'dt-btn-light',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'excelHtml5',
                    text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                    className: 'dt-btn-light',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'print',
                    text: '<i class="bx bx-printer"></i> Print',
                    className: 'dt-btn-light',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }, {
                    extend: 'colvis',
                    text: '<i class="bx bx-columns"></i> Column visibility',
                    className: 'dt-btn-light'
                }, {
                    extend: 'pdfHtml5',
                    text: '<i class="bx bx-file-blank"></i> Export to PDF',
                    className: 'dt-btn-light',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    customize: function(doc) {
                        doc.pageMargins = [10, 10, 10, 10];
                        var table = doc.content[1].table;
                        table.widths = Array(table.body[0].length).fill('*');
                    }
                }]

            });

            $(document).on('click', '.editRole', function() {

                const roleId = $(this).data('id');

                let url = "{{ route('roles.edit', ':id') }}";
                url = url.replace(':id', roleId);
                $.ajax({
                    url: url,
                    type: "GET",

                    success: function(res) {

                        if (!res.status) return;

                        isEditMode = true;
                        new bootstrap.Tab(document.querySelector('a[href="#addRole"]')).show();

                        $('#roleId').val(res.role.role_id);

                        $('#roleName').val(res.role.role_name);
                        $('button[type="submit"]').text('Update Role');

                        $('.permission-checkbox').prop('checked', false);


                        $('.permission-checkbox:not([class*="submenu-"])')
                            .prop('disabled', false);


                        $('.permission-checkbox[class*="submenu-"]')
                            .prop('disabled', true);

                        $('.submenu-select-all').prop('checked', false).prop('disabled', true);

                        $('.submenu-select-all').prop('checked', false).prop('disabled', true);

                        // 🔹 Loop permissions
                        res.permissions.forEach(p => {

                            /* ================= MENU PERMISSIONS ================= */
                            if (p.menu_id && !p.sub_menu_id) {

                                if (p.can_view)
                                    $(
                                        `input[name="permissions[menu][${p.menu_id}][]"][value="can_view"]`
                                        )
                                    .prop('checked', true)
                                    .trigger('change');

                                if (p.can_create)
                                    $(
                                        `input[name="permissions[menu][${p.menu_id}][]"][value="can_create"]`
                                        )
                                    .prop('checked', true);

                                if (p.can_update)
                                    $(
                                        `input[name="permissions[menu][${p.menu_id}][]"][value="can_update"]`
                                        )
                                    .prop('checked', true);

                                if (p.can_delete)
                                    $(
                                        `input[name="permissions[menu][${p.menu_id}][]"][value="can_delete"]`
                                        )
                                    .prop('checked', true);

                                if (p.view_export)
                                    $(
                                        `input[name="permissions[menu][${p.menu_id}][]"][value="can_export"]`
                                        )
                                    .prop('checked', true);
                            }


                            if (p.sub_menu_id) {


                                $(`.submenu-${p.menu_id}`).prop('disabled', false);
                                $(`.submenu-select-all[data-parent-menu="${p.menu_id}"]`)
                                    .prop('disabled', false);

                                if (p.can_view)
                                    $(
                                        `input[name="permissions[sub_menu][${p.sub_menu_id}][]"][value="can_view"]`
                                        )
                                    .prop('checked', true);

                                if (p.can_create)
                                    $(
                                        `input[name="permissions[sub_menu][${p.sub_menu_id}][]"][value="can_create"]`
                                        )
                                    .prop('checked', true);

                                if (p.can_update)
                                    $(
                                        `input[name="permissions[sub_menu][${p.sub_menu_id}][]"][value="can_update"]`
                                        )
                                    .prop('checked', true);

                                if (p.can_delete)
                                    $(
                                        `input[name="permissions[sub_menu][${p.sub_menu_id}][]"][value="can_delete"]`
                                        )
                                    .prop('checked', true);

                                if (p.view_export)
                                    $(
                                        `input[name="permissions[sub_menu][${p.sub_menu_id}][]"][value="can_export"]`
                                        )
                                    .prop('checked', true);
                            }
                        });
                    }
                });
            });


            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {

                const target = $(e.target).attr('href');

                // When switching to ADD ROLE manually (not edit)
                if (target === '#listRole') {

                    isEditMode = false;

                    $('button[type="submit"]').text('Save Role');

                    // 🔥 Restore tab text
                    $('#addRoleTab').text('Add Role');

                    resetRoleForm();
                }
            });


            function resetRoleForm() {

                $('#roleForm')[0].reset();

                // Clear role name
                $('#roleName').val('');
                $('#roleId').val('');

                // Reset all permissions
                $('.permission-checkbox').prop('checked', false);

                // Enable MENU permissions
                $('.permission-checkbox:not([class*="submenu-"])')
                    .prop('disabled', false);

                // Disable SUBMENU permissions
                $('.permission-checkbox[class*="submenu-"], .submenu-select-all')
                    .prop('disabled', true)
                    .prop('checked', false);
            }

            $(document).on('click', '.deleteRole', function() {

                const roleId = $(this).data('id');
                const roleName = $(this).data('name');

                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    title: 'Confirm Delete',
                    message: `Are you sure you want to delete <b>${roleName}</b>?`,
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function(instance, toast) {

                            $.ajax({
                                url: "{{ route('roles.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    role_id: roleId
                                },
                                success: function(res) {

                                    if (res.status) {

                                        // ✅ CLOSE CONFIRMATION TOAST FIRST
                                        instance.hide({
                                            transitionOut: 'fadeOut'
                                        }, toast, 'button');

                                        iziToast.success({
                                            title: 'Deleted',
                                            message: res.message,
                                            position: 'topRight'
                                        });

                                        // Reload DataTable
                                        roleTable.ajax.reload(null, false);
                                    }
                                },
                                error: function() {
                                    instance.hide({
                                        transitionOut: 'fadeOut'
                                    }, toast, 'button');
                                }
                            });

                        }, true],

                        ['<button>NO</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }]
                    ]
                });
            });




        });
    </script>




</body>

</html>
