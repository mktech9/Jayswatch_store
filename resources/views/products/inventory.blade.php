<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')

<style>
    /* Custom Styles for Product View Modal (Reused from Index) */
    .nav-tabs-custom .nav-link {
        border: none;
        padding: 12px 20px;
        font-weight: 500;
        color: #6c757d;
        border-bottom: 3px solid transparent;
    }

    .nav-tabs-custom .nav-link:hover {
        color: #0d6efd;
        background-color: #f8f9fa;
    }

    .nav-tabs-custom .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border-bottom: 3px solid #0d6efd;
    }

    .gallery-item {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .gallery-item:hover {
        transform: scale(1.05);
    }

    .gallery-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .gallery-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .gallery-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .gallery-scroll::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    @media (max-width: 768px) {
        .nav-tabs-custom {
            display: flex;
            justify-content: space-between;
        }

        .nav-tabs-custom .nav-item {
            flex: 1;
            text-align: center;
        }

        .nav-tabs-custom .nav-link {
            padding: 8px 2px;
            font-size: 11px;
            white-space: nowrap;
        }

        .nav-tabs-custom .nav-link i {
            display: none;
        }
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Inventory</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Product Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Inventory</li>
            </ol>
        </div>
        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title">Inventory List</div>

                                <button id="filterToggleBtn" class="btn btn-outline-primary btn-sm ms-auto"
                                    data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
                                    <i class="bx bx-filter-alt"></i> Filter
                                </button>
                            </div>

                            <div class="collapse show mb-3" id="filterCollapse">
                                <div class="p-3">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Model Name</label>
                                            <input type="text" id="filter_model_name" class="form-control"
                                                placeholder="Enter model name">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Model Number</label>
                                            <input type="text" id="filter_model_number" class="form-control"
                                                placeholder="Enter model number">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">SKU</label>
                                            <input type="text" id="filter_sku" class="form-control"
                                                placeholder="Enter SKU">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Business Location</label>
                                            <select id="filter_business_location" class="form-select select2">
                                                <option value="">All Locations</option>
                                                @foreach ($store_location as $location)
                                                    <option value="{{ $location->bl_id }}">{{ $location->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Brand</label>
                                            <select id="filter_brand" class="form-select select2">
                                                <option value="">All Brands</option>
                                                @foreach ($brand_data as $brand)
                                                    <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-none">
                                            <label class="form-label">Stock</label>
                                            <select id="filter_stock" class="form-select select2">
                                                <option value="">All</option>
                                                <option value="in">In Stock</option>
                                                <option value="out">Out of Stock</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9 d-flex align-items-end">
                                            <div class="d-flex align-items-end w-100">

                                                <div class="d-flex gap-2">
                                                    <button type="button" id="applyFilterBtn" class="btn btn-primary">
                                                        <i class="bx bx-search"></i> Apply Filter
                                                    </button>

                                                    <button type="button" id="resetFilterBtn"
                                                        class="btn btn-outline-secondary">
                                                        <i class="bx bx-reset"></i> Reset
                                                    </button>
                                                </div>
                                                @if (all_admin())
                                                    <div class="ms-auto">
                                                        <button class="btn btn-success d-flex align-items-center gap-2"
                                                            id="createCatalogueBtn">

                                                            <i class="bx bx-book-open fs-5"></i>

                                                            <span class="btn-text">
                                                                Create Catalogue
                                                            </span>

                                                            <span class="spinner-border spinner-border-sm d-none"
                                                                role="status"></span>
                                                        </button>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="d-flex justify-content-end mb-2 gap-2">


                                        <button class="btn btn-sm btn-outline-primary" id="scrollLeft">◀</button>
                                        <button class="btn btn-sm btn-outline-primary" id="scrollRight">▶</button>
                                    </div>

                                    <table class="table table-bordered text-nowrap w-100" id="inventoryTable">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                @if (all_admin())
                                                    <th>
                                                        <div class="d-flex align-items-center gap-1">
                                                            <input type="checkbox" id="selectAllProducts">
                                                            <span>Select</span>
                                                        </div>
                                                    </th>
                                                @endif
                                                <th>Action</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>SKU</th>
                                                <th>Location</th>
                                                @if (all_admin())
                                                    <th>Purchase Price</th>
                                                @endif
                                                <th>Selling Price</th>
                                                <th>Box</th>
                                                <th>Paper</th>
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

        <div class="modal fade" id="productViewModal" tabindex="-1" aria-labelledby="productViewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productViewModalLabel">Product Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="viewModalContent">
                            <div class="text-center w-100 py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>

    @include('partials.footer_link')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script>
        $(document).ready(function() {
            let selectedProductIds = [];
            // Initialize Select2 for Filters
            $('#filter_business_location, #filter_brand, #filter_stock').select2({
                placeholder: "Select Filter",
                allowClear: true,
                width: "100%"
            });



            function syncSelectedIds() {
                $('.product-check').each(function() {
                    const id = $(this).val();

                    if ($(this).is(':checked')) {
                        if (!selectedProductIds.includes(id)) {
                            selectedProductIds.push(id);
                        }
                    } else {
                        selectedProductIds = selectedProductIds.filter(item => item !== id);
                    }
                });

                // console.log('Selected pro_id:', selectedProductIds);
            }

            $(document).on('change', '#selectAllProducts', function() {

                let isChecked = $(this).is(':checked');

                $('.product-check').prop('checked', isChecked);

                $('.product-check').each(function() {

                    const id = $(this).val();

                    if (isChecked) {

                        if (!selectedProductIds.includes(id)) {
                            selectedProductIds.push(id);
                        }

                    } else {

                        selectedProductIds = [];

                    }

                });

            });

            // Initialize DataTable
            var table = $('#inventoryTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('product.inventory_list') }}", // Ensure this route is defined in web.php
                    data: function(d) {
                        d.model_name = $('#filter_model_name').val();
                        d.model_number = $('#filter_model_number').val();
                        d.sku = $('#filter_sku').val();
                        d.business_location = $('#filter_business_location').val();
                        d.brand = $('#filter_brand').val();
                        d.stock = $('#filter_stock').val();
                    }
                },
                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },

                    @if (all_admin())
                        {
                            data: 'select',
                            orderable: false,
                            searchable: false
                        },
                    @endif

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pro_image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) return '';
                            if (type === 'display') return data;
                            var match = data.match(/src=["']([^"']+)["']/);
                            return match ? match[1] : '';
                        }
                    },
                    {
                        data: 'pro_name',
                        render: function(data, type, row) {
                            if (type !== 'display') return data;

                            let labels = '';

                            if (row.out_stock == 1) {
                                labels +=
                                    '<span style="color:red;font-size:12px;font-weight:600;"><br>(Out of Stock)</span>';
                            } else if (row.out_stock == 0) {
                                labels +=
                                    '<span style="color:green;font-size:12px;font-weight:600;"><br>(In Stock)</span>';
                            }

                            if (row.not_for_selling == 1) {
                                labels +=
                                    ' <span style="color:grey;font-size:12px;font-weight:600;"><br>(Not for Selling)</span>';
                            }

                            return `
                <div>
                    <div>${data} ${labels}</div>
                </div>
            `;
                        }
                    },
                    {
                        data: 'brand'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'pro_sku'
                    },
                    {
                        data: 'business_location'
                    },

                    @if (all_admin())
                        {
                            data: 'purchase_price'
                        },
                    @endif

                    {
                        data: 'selling_price'
                    },
                    {
                        data: 'box'
                    },
                    {
                        data: 'paper'
                    }
                ],
                drawCallback: function() {

                    $('.product-check').each(function() {

                        if (selectedProductIds.includes($(this).val())) {
                            $(this).prop('checked', true);
                        }

                    });

                    // Header checkbox sync
                    let total = $('.product-check').length;
                    let checked = $('.product-check:checked').length;

                    $('#selectAllProducts').prop('checked', total > 0 && total === checked);
                },
                columnDefs: [{
                    targets: '_all',
                    className: 'text-start'
                }],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: -1,
                dom: "<'row mb-2 align-items-center'<'col-lg-2 col-md-3'l><'col-lg-7 col-md-6 text-center'B><'col-lg-3 col-md-3 text-end'f>>rtip",
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: {
                            // Export visible columns: No(0), Image(2), Name(3)... Paper(11)
                            // We Exclude Action(1)
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        },
                        customizeData: function(data) {
                            // Get full data from DataTable (including fields not in columns)
                            var dt = $('#inventoryTable').DataTable();
                            var rowData = dt.rows({
                                search: 'applied',
                                order: 'applied'
                            }).data().toArray();

                            // 1. Add Headers for Extra Columns
                            var extraHeaders = [
                                'Product Type', 'Model', 'Gender', 'Model Name', 'Ref Num',
                                'Barcode Type', 'Slug',
                                'Watch Category', 'Calendar Type', 'Occasion', 'Collection',
                                'Sport Type', 'Watch Type',
                                'Dial Type', 'Dial Colour', 'Dial Diameter', 'Case Shape',
                                'Case Material', 'Case Back',
                                'Strap Material', 'Strap Colour', 'Glass Material', 'Bezel',
                                'Bezel Function', 'Embellishment',
                                'Clasp Type', 'Movement', 'Water Resistance', 'Functionality',
                                'Brand Warranty', 'Service Card',
                                'Year of Card', 'HSN Code', 'Origin Country', 'Manufacturer',
                                'Packers', 'Unit', 'Condition',
                                'Purchase Date', 'Shop Warranty', 'New Arrival', 'Manage Stock',
                                'Out Stock', 'Not For Selling',
                                'Tata Cliq Product', 'Quantity', 'Description', 'Gallery',
                                'Brochure', 'Video Type', 'Video Source',
                                'Enable IMEI', 'Tax', 'Type', 'Selling Tax Type',
                                'Purchase Price Inc', 'Purchase Price Exc',
                                'Margin', 'Selling Price Exc', 'Meta Title', 'Meta Description',
                                'Approval Status', 'Status'
                            ];
                            data.header.push(...extraHeaders);

                            // 2. Loop through rows to Add Data & Fix Image URL
                            for (var i = 0; i < data.body.length; i++) {
                                var fullRow = rowData[i];

                                // Fix Image Column (Index 1 in exported file because Col 0 is "No" and Col 1 is "Image")
                                // Note: Because we excluded Action column, Image is the 2nd column (index 1)
                                if (fullRow.pro_image_hidden) {
                                    data.body[i][1] = fullRow
                                        .pro_image_hidden; // Replace HTML with URL
                                } else {
                                    data.body[i][1] = '';
                                }

                                // Prepare Extra Values
                                var extraValues = [
                                    fullRow.pro_type, fullRow.pro_model, fullRow.pro_gender,
                                    fullRow.pro_model_name, fullRow.pro_ref_num, fullRow
                                    .barcode_type, fullRow.slug,
                                    fullRow.watch_category, fullRow.calendar_type, fullRow
                                    .occasion, fullRow.collection, fullRow.sport_type, fullRow
                                    .watch_type,
                                    fullRow.dial_type, fullRow.dial_colour, fullRow
                                    .dial_diameter, fullRow.case_shape, fullRow.case_material,
                                    fullRow.case_back,
                                    fullRow.strap_material, fullRow.strap_colour, fullRow
                                    .glass_material, fullRow.bezel, fullRow.bezel_function,
                                    fullRow.embellishment,
                                    fullRow.clasp_type, fullRow.movement, fullRow
                                    .water_resistance, fullRow.functionality, fullRow
                                    .brand_warranty, fullRow.service_card,
                                    fullRow.year_of_card, fullRow.hsn_code, fullRow
                                    .origin_country, fullRow.manufacturer, fullRow.packers,
                                    fullRow.unit, fullRow.condition,
                                    fullRow.purchase_date, fullRow.shop_warranty, fullRow
                                    .new_arrival, fullRow.manage_stock, fullRow.out_stock,
                                    fullRow.not_for_selling,
                                    fullRow.tata_cliq_product, fullRow.quantity, fullRow
                                    .product_desc, fullRow.pro_gallery, fullRow.pro_brochure,
                                    fullRow.video_type, fullRow.video_source,
                                    fullRow.enable_imei, fullRow.pro_tax, fullRow.product_type,
                                    fullRow.selling_tax_type, fullRow.purchase_price_inclusive,
                                    fullRow.purchase_price_exclusive,
                                    fullRow.pro_margin, fullRow.selling_price_exclusive, fullRow
                                    .meta_title, fullRow.meta_description, fullRow
                                    .approval_status, fullRow.status
                                ];

                                // Handle nulls/undefined
                                extraValues = extraValues.map(v => (v === null || v === undefined) ?
                                    '' : v);

                                // Append to the row
                                data.body[i].push(...extraValues);
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        },
                        customize: function(doc) {
                            doc.pageMargins = [10, 10, 10, 10];
                            var table = doc.content[1].table;
                            table.widths = Array(table.body[0].length).fill('*');
                        }
                    }
                ]
            });

            // Filter Apply
            $('#applyFilterBtn').on('click', function() {
                table.ajax.reload();
            });

            // Filter Reset
            $('#resetFilterBtn').on('click', function() {
                $('#filter_model_name').val('');
                $('#filter_model_number').val('');
                $('#filter_sku').val('');
                $('#filter_stock').val('');
                $('#filter_business_location').val('').trigger('change');
                $('#filter_brand').val('').trigger('change');
                $('#filter_stock').val('').trigger('change');
                table.ajax.reload();
            });

            // Scroll Buttons
            $("#scrollRight").on("click", function() {
                $(".dataTables_scrollBody").animate({
                    scrollLeft: "+=200"
                }, 300);
            });
            $("#scrollLeft").on("click", function() {
                $(".dataTables_scrollBody").animate({
                    scrollLeft: "-=200"
                }, 300);
            });

            // View Product Logic (Reused exact logic)
            // View product modal
            $(document).on('click', '.viewProduct', function() {
                var id = $(this).data('id');
                var modalContent = $('#viewModalContent');

                // Show Modal & Spinner
                $('#productViewModal').modal('show');
                modalContent.html(
                    '<div class="text-center w-100 py-5"><div class="spinner-border text-primary" role="status"></div></div>'
                );

                var url = "{{ route('product.show', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response.status === 200) {
                            var d = response.data;

                            // --- Helpers ---
                            var checkNull = (val) => (val === null || val === '') ? 'N/A' : val;
                            var yesNoBadge = (val) => val == 1 ?
                                '<span class="badge bg-success">Yes</span>' :
                                '<span class="badge bg-light text-dark border">No</span>';
                            var boolBadge = (val, text) => val == 1 ?
                                `<span class="badge bg-primary me-1 mb-1">${text}</span>` : '';

                            var formatLabel = (val) => (val === null || val === '') ? 'N/A' :
                                val
                                .replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                            // --- Image Logic ---
                            var brandFolder = d.brand_folder;
                            var productFolder = d.product_folder;

                            var baseUrl = "{{ $actual_url . '/admin_assets/brand/' }}" +
                                brandFolder + "/" +
                                productFolder + "/";

                            // Main Image
                            var mainImgHtml = d.pro_image ?
                                `<div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3 d-flex align-items-center justify-content-center">
                            <img src="${baseUrl}image/${d.pro_image}" class="img-fluid rounded" style="max-height: 280px; object-fit: contain;">
                        </div>
                    </div>` :
                                `<div class="card border h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                            <i class="bi bi-image display-4 mb-3"></i>
                            <span>No Main Image</span>
                        </div>
                    </div>`;

                            // Gallery Images - Scrollable
                            var galleryHtml = '';
                            if (d.pro_gallery && d.pro_gallery.trim() !== '') {
                                var images = d.pro_gallery.split(',');
                                galleryHtml = `
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-0 py-3">
                                <h6 class="mb-0 fw-semibold text-dark">Gallery</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="gallery-scroll" style="max-height: 200px; overflow-y: auto; overflow-x:hidden;">
                                    <div class="row g-2">
                    `;
                                images.forEach(img => {
                                    galleryHtml += `
                            <div class="col-4 col-md-6">
                                <div class="gallery-item position-relative">
                                    <img src="${baseUrl}gallery/${img}" class="img-fluid rounded border" style="height: 80px; width: 100%; object-fit: cover;">
                                </div>
                            </div>
                        `;
                                });
                                galleryHtml += `
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                            } else {
                                galleryHtml = `
                        <div class="card border h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                                <i class="bi bi-images display-4 mb-3"></i>
                                <span>No Gallery Images</span>
                            </div>
                        </div>
                    `;
                            }

                            // --- Brochure & Video Links ---
                            var brochureBase = "{{ $actual_url . '/admin_assets/brand/' }}";

                            var brochureLink = d.pro_brochure ?
                                `<a href="${brochureBase}${brandFolder}/${productFolder}/brochure/${d.pro_brochure}"
       target="_blank"
       class="btn btn-sm btn-outline-primary mb-0 ">
        <i class="bi bi-file-earmark-pdf me-1"></i> Download Brochure
    </a>` : '';

                            var videoHtml = '';
                            if (d.video_source) {
                                if (d.video_type === 'file') {
                                    // Local File
                                    var videoBase =
                                        "{{ $actual_url . '/admin_assets/brand/' }}";
                                    var videoUrl = videoBase + brandFolder + "/" +
                                        productFolder + "/video/" + d.video_source;

                                    videoHtml = `
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-transparent border-0 py-3">
                                    <h6 class="mb-0 fw-semibold text-dark">Video Preview</h6>
                                </div>
                                <div class="card-body p-3">
                                    <video controls class="w-100 rounded" style="height: 150px; object-fit: cover;">
                                        <source src="${videoUrl}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        `;
                                } else if (d.video_type === 'youtube' || d.video_type ===
                                    'vimeo') {
                                    // External Link
                                    videoHtml = `
                            <div class="card border h-100">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                                    <i class="bi bi-play-circle display-4 text-danger mb-3"></i>
                                    <h6 class="fw-semibold">Watch Video</h6>
                                    <p class="text-muted small text-center mb-3">Available on ${d.video_type.charAt(0).toUpperCase() + d.video_type.slice(1)}</p>
                                    <a href="${d.video_source}" target="_blank" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-play-circle me-1"></i> Watch Now
                                    </a>
                                </div>
                            </div>
                        `;
                                }
                            } else {
                                videoHtml = `
                        <div class="card border h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                                <i class="bi bi-camera-video display-4 mb-3"></i>
                                <span>No Video Available</span>
                            </div>
                        </div>
                    `;
                            }

                            // --- Price Formatting ---
                            var formatPrice = (price) => {
                                if (!price) return 'N/A';
                                return '₹' + parseFloat(price).toLocaleString('en-IN');
                            };

                            // --- Construct HTML ---
                            var html = `
                    <!-- Product Header -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4 class="fw-bold text-dark mb-1">${checkNull(d.pro_name)}</h4>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="badge bg-primary">${checkNull(d.pro_model)}</span>
                                <span class="badge bg-info text-dark">${checkNull(d.pro_ref_num)}</span>
                                <span class="badge bg-light text-dark border">${checkNull(d.brand_name)}</span>
                            </div>
                            <p class="text-muted mb-0">${checkNull(d.pro_model_name)}</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex flex-column">
                                <span class="text-muted small">Current Price</span>
                                <h3 class="fw-bold text-success mb-0">${formatPrice(d.selling_price_exclusive)}</h3>
                                <span class="text-muted small">Exclusive of Tax</span>
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="row mb-2">
                        <div class="col-md-4 mb-3">
                            ${mainImgHtml}
                        </div>
                        <div class="col-md-4 mb-3">
                            ${galleryHtml}
                        </div>
                        <div class="col-md-4 mb-3">
                            ${videoHtml}

                        </div>
                    </div>



                    <!-- Product Information Tabs -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-tabs-custom" id="productTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                        <i class="bi bi-info-circle me-2"></i>Basic Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" type="button" role="tab">
                                        <i class="bi bi-palette me-2"></i>Design
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">
                                        <i class="bi bi-gear me-2"></i>Features
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="business-tab" data-bs-toggle="tab" data-bs-target="#business" type="button" role="tab">
                                        <i class="bi bi-graph-up me-2"></i>Business
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content p-4" id="productTabContent">
                                <!-- Basic Info Tab -->
                                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Product Type</label>
                                            <div class="fw-medium">${checkNull(d.pro_type)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Gender</label>
                                            <div class="fw-medium">${checkNull(d.pro_gender)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">SKU</label>
                                            <div class="fw-bold text-primary">${checkNull(d.pro_sku)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Collection</label>
                                            <div>${checkNull(d.collection)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Watch Category</label>
                                            <div>${checkNull(d.watch_category)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Watch Type</label>
                                            <div>${checkNull(d.watch_type_name)}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Design Tab -->
                                <div class="tab-pane fade" id="design" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Dial Color</label>
                                            <div>${checkNull(d.dial_color_name)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Case Material</label>
                                            <div>${checkNull(d.case_material)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Strap Material</label>
                                            <div>${checkNull(d.strap_material)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Glass</label>
                                            <div>${checkNull(d.glass_name)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Case Shape</label>
                                            <div>${checkNull(d.case_shape)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Dial Diameter</label>
                                            <div>${checkNull(d.dial_diameter)} mm</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Water Resistance</label>
                                            <div>${checkNull(d.water_resistance)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Movement</label>
                                            <div class="fw-medium">${checkNull(d.movement_name)}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features Tab -->
                                <div class="tab-pane fade" id="features" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Brand Warranty</label>
                                            <div>${yesNoBadge(d.brand_warranty)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Service Card</label>
                                            <div>${yesNoBadge(d.service_card)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Box Included</label>
                                            <div>${checkNull(d.box)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Papers</label>
                                            <div>${checkNull(d.paper)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Origin Country</label>
                                            <div>${checkNull(d.origin_country_name)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Manufacturer</label>
                                            <div>${checkNull(d.manufacturer_name)}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label text-muted small mb-1">Functionality</label>
                                            <div class="bg-light p-3 rounded">${checkNull(d.functionality)}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Tab -->
                                <div class="tab-pane fade" id="business" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Condition</label>
                                            <div class="fw-bold ${d.condition === 'New' ? 'text-success' : 'text-warning'}">${checkNull(d.condition)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Quantity</label>
                                            <div class="fw-bold ${d.quantity > 0 ? 'text-success' : 'text-danger'}">${checkNull(d.quantity)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Physical Location</label>
                                            <div class="fw-medium">${checkNull(d.physical_location_name)}</div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label text-muted small mb-1">
                                                Display Locations ${(d.display_location_name && d.display_location_name !== '-')
                                    ? `(${d.display_location_name.split(",").length})`
                                    : "(0)"
                                }
                                            </label>

                                            <ol class="mb-0 ps-3">
                                                ${(d.display_location_name && d.display_location_name !== '-')
                                    ? d.display_location_name
                                        .split(",")
                                        .map(loc => `<li>${loc.trim()}</li>`)
                                        .join("")
                                    : "<li>Not Available</li>"
                                }
                                            </ol>
                                        </div>


                                        <!-- Pricing Section -->
                                        <div class="col-12 mt-4">
                                            <h6 class="border-bottom pb-2 mb-3">Pricing Details</h6>
                                            <div class="row g-3">
                                                @if (all_admin())
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Purchase Price</label>
                                                    <div class="fw-medium">${formatPrice(d.purchase_price_exclusive)}</div>
                                                </div>
                                                @endif
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Margin</label>
                                                    <div class="fw-medium">${checkNull(d.pro_margin)}%</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Selling Price</label>
                                                    <div class="fw-bold text-success">${formatPrice(d.selling_price_exclusive)}</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Tax Rate</label>
                                                    <div>${checkNull(d.pro_tax)}%</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status Flags -->
                                        <div class="col-12 mt-4">
                                            <h6 class="border-bottom pb-2 mb-3">Status</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                ${boolBadge(d.new_arrival, 'New Arrival')}
                                                ${boolBadge(d.manage_stock, 'Stock Managed')}
                                                ${boolBadge(d.out_stock, 'Out of Stock')}
                                                ${boolBadge(d.not_for_selling, 'Not for Sale')}
                                                ${boolBadge(d.tata_cliq_product, 'Tata Cliq Exclusive')}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card -->
                    <div class="card border-0 shadow-sm mt-4">
                   <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">

    <h6 class="mb-0 fw-semibold text-dark">
        <i class="bi bi-card-text me-2"></i>Product Description
    </h6>

    ${d.pro_brochure ? brochureLink : ''}

</div>
                        <div class="card-body">
                            <p class="mb-0 text-muted">${checkNull(d.product_desc)}</p>
                        </div>
                    </div>
                `;
                            modalContent.html(html);
                        } else {
                            modalContent.html(
                                '<div class="alert alert-danger text-center">Failed to load product data. Please try again.</div>'
                            );
                        }
                    },
                    error: function() {
                        modalContent.html(
                            '<div class="alert alert-danger text-center">Something went wrong. Please check your connection and try again.</div>'
                        );
                    }
                });
            });

            $(document).on('change', '.product-check', function() {
                syncSelectedIds();
            });
            $(document).on('click', '#createCatalogueBtn', function() {

                let btn = $(this);

                // Show Spinner
                btn.prop('disabled', true);
                btn.find('.btn-text').text('Generating...');
                btn.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: "{{ route('catalogue.create') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        pro_ids: selectedProductIds
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },

                    success: function(blob) {

                        const url = window.URL.createObjectURL(blob);
                        window.open(url, '_blank');

                        // Success Toast
                        iziToast.success({
                            title: 'Success',
                            message: 'Catalogue generated successfully',
                            position: 'topRight'
                        });

                        // Reset Button
                        btn.prop('disabled', false);
                        btn.find('.btn-text').text('Create Catalogue');
                        btn.find('.spinner-border').addClass('d-none');
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        // Error Toast
                        iziToast.error({
                            title: 'Error',
                            message: 'Select Products to generate catalogue',
                            position: 'topRight'
                        });

                        // Reset Button
                        btn.prop('disabled', false);
                        btn.find('.btn-text').text('Create Catalogue');
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });
        });
    </script>
</body>

</html>
