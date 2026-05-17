<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title }}</title>



    <!-- Favicon -->
    <link rel="icon" href="{{ $actual_url . '/admin_assets/favicon.ico' }}" type="image/x-icon">

    <!-- Choices JS -->
    <script src="{{ $actual_url . '/admin_assets/libs/choices.js/public/assets/scripts/choices.min.js' }}"></script>

    <!-- Main Theme JS -->
    <script src="{{ $actual_url . '/admin_assets/js/main.js' }}"></script>

    <!-- Bootstrap CSS -->
    <link id="style" href="{{ $actual_url . '/admin_assets/libs/bootstrap/css/bootstrap.min.css' }}"
        rel="stylesheet">

    <!-- Style CSS -->
    <link href="{{ $actual_url . '/admin_assets/css/styles.css' }}" rel="stylesheet">

    <!-- Icons CSS -->
    <link href="{{ $actual_url . '/admin_assets/css/icons.css' }}" rel="stylesheet">

    <!-- Node Waves CSS -->
    <link href="{{ $actual_url . '/admin_assets/libs/node-waves/waves.min.css' }}" rel="stylesheet">

    <!-- Simplebar CSS -->
    <link href="{{ $actual_url . '/admin_assets/libs/simplebar/simplebar.min.css' }}" rel="stylesheet">

    <!-- Flatpickr / Color Picker CSS -->
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/flatpickr/flatpickr.min.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/@simonwep/pickr/themes/nano.min.css' }}">

    <!-- Choices CSS -->
    <link rel="stylesheet"
        href="{{ $actual_url . '/admin_assets/libs/choices.js/public/assets/styles/choices.min.css' }}">

    <!-- Toast / Datatables -->
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/css/iziToast.min.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/datatables/dataTables.bootstrap5.min.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/datatables/responsive.bootstrap.min.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/datatables/buttons.bootstrap5.min.css' }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.css"
        rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ $actual_url . '/admin_assets/css/select2.min.css' }}" rel="stylesheet">

    <!-- Quill Editor -->
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/quill/quill.snow.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/quill/quill.bubble.css' }}">

    <!-- Filepond -->
    <link rel="stylesheet" href="{{ $actual_url . '/admin_assets/libs/filepond/filepond.min.css' }}">
    <link rel="stylesheet"
        href="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css' }}">
    <link rel="stylesheet"
        href="{{ $actual_url . '/admin_assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css' }}">

</head>


<style>
    .dt-buttons .dt-btn-light {
        background: #ffffff !important;
        color: #111827 !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 6px;

        font-size: 13px;
        font-weight: 500;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    /* Hover */
    .dt-buttons .dt-btn-light:hover {
        background: #f3f4f6 !important;
        border-color: #d1d5db !important;
        color: #111827 !important;
    }


    /* ===== Column Visibility Dropdown ===== */
    .dt-button-collection {
        background: #767578 !important;
        /* refined purple */
        border-radius: 10px !important;
        padding: 8px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
        z-index: 1055 !important;
    }

    /* Dropdown buttons */
    .dt-button-collection .dt-button {
        background: transparent !important;
        color: #ffffff !important;
        border: none !important;
        text-align: left !important;
        padding: 10px 14px !important;
        border-radius: 6px !important;
        font-weight: 500;
    }

    /* Hover effect */
    .dt-button-collection .dt-button:hover {
        background: rgba(255, 255, 255, 0.18) !important;
        color: #ffffff !important;
    }

    /* Remove default focus outline */
    .dt-button:focus {
        box-shadow: none !important;
        outline: none !important;
    }

    /* ===== Backdrop Overlay ===== */
    .dt-button-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1050;
    }

    /* Button group spacing */
</style>
