<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')


<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Tata Cliq Products</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Product Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tata Cliq Product</li>
            </ol>
        </div>
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">


                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="listUsers" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap w-100" id="tatacliqView">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Image</th>
                                                    <th>Product Name</th>
                                                    <th>Brand</th>
                                                    <th>Category</th>
                                                    <th>SKU</th>
                                                    <th>Location</th>
                                                    <th>Purchase Price</th>
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
        </div>

        <div class="modal fade" id="tatacliqViewModal" tabindex="-1" aria-labelledby="tatacliqViewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tatacliqViewModalLabel">Tata Cliq Product Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            // 1. Define Hidden Headers exactly as they appear in your columns mapping
            var hiddenHeaders = [
                "Type", "Model", "Gender", "Model Name", "slug", "Ref. Number", "Barcode Type",
                "Calendar Type", "Watch Category", "Occasion", "Collection", "Sport", "Watch Type",
                "Dial Type", "Dial Colour", "Dial Diameter", "Case Shape", "Product Gallery",
                "Product Brochure",
                "Video Type", "Video Source", "Material", "Case Back", "Strap Material", "Strap Color",
                "Glass Material", "Bezel", "Bezel Fn.", "Embellishment", "Clasp Type", "Movement",
                "Water Resistance", "Function", "Warranty", "Service Card", "Year", "HSN",
                "Origin Of Country", "Manufacturer", "Packer", "Unit", "Condition", "Purchase Date",
                "Warranty", "New Arrivals", "Manage Stock", "Out Stock", "Not for selling",
                "Tata cliq product", "Qty", "Desc", "Tax(GST %)", "Prod Type", "Selling Price Tax Type",
                "Purchase Inc.", "Purchase Exc.", "Margin", "Default Selling Price", "Meta title",
                "Meta Description", "Approval Status", "Store Owner", "Status"
            ];

            // 2. Clear and Rebuild the Header Row properly
            var headerRow = $('#tatacliqView thead tr');
            headerRow.empty();

            // ✅ Corrected Visible Headers (Matches 'columns' definition order)
            // Sequence: No -> Action -> Image -> Name -> ... -> Paper
            var visibleTitles = [
                "No.",
                "Action", // ✅ Moved Action to correct position (Index 1)
                "Image",
                "Product Name",
                "Brand",
                "Category",
                "SKU",
                "Location",
                "Purchase Price",
                "Selling Price",
                "Box",
                "Paper"
            ];

            // Append Visible Headers
            visibleTitles.forEach(function(title) {
                headerRow.append('<th>' + title + '</th>');
            });

            // Append Hidden Headers
            hiddenHeaders.forEach(function(title) {
                headerRow.append('<th>' + title + '</th>');
            });

            // ❌ Removed: headerRow.append('<th>Action</th>'); (This was causing the mismatch)

            // 3. Initialize DataTable
            var tatacliqView = $('#tatacliqView').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('tatacliq.details') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    // --- Visible Columns (12 Columns) ---
                    {
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }, // Action is here (Index 1)
                    {
                        data: 'pro_image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) return '';
                            if (type === 'export') {
                                var match = data.match(/src=["']([^"']+)["']/);
                                return match ? match[1] : '';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'pro_name'
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
                    {
                        data: 'purchase_price'
                    },
                    {
                        data: 'selling_price'
                    },
                    {
                        data: 'box'
                    },
                    {
                        data: 'paper'
                    },

                    // --- Hidden Columns ---
                    {
                        data: 'pro_type',
                        visible: false
                    },
                    {
                        data: 'pro_model',
                        visible: false
                    },
                    {
                        data: 'pro_gender',
                        visible: false
                    },
                    {
                        data: 'pro_model_name',
                        visible: false
                    },
                    {
                        data: 'slug',
                        visible: false
                    },
                    {
                        data: 'pro_ref_num',
                        visible: false
                    },
                    {
                        data: 'barcode_type',
                        visible: false
                    },
                    {
                        data: 'calendar_type',
                        visible: false
                    },
                    {
                        data: 'watch_category',
                        visible: false
                    },
                    {
                        data: 'occasion',
                        visible: false
                    },
                    {
                        data: 'collection',
                        visible: false
                    },
                    {
                        data: 'sport_type',
                        visible: false
                    },
                    {
                        data: 'watch_type',
                        visible: false
                    },
                    {
                        data: 'dial_type',
                        visible: false
                    },
                    {
                        data: 'dial_colour',
                        visible: false
                    },
                    {
                        data: 'dial_diameter',
                        visible: false
                    },
                    {
                        data: 'case_shape',
                        visible: false
                    },
                    {
                        data: 'pro_gallery',
                        visible: false
                    },
                    {
                        data: 'pro_brochure',
                        visible: false
                    },
                    {
                        data: 'video_type',
                        visible: false
                    },
                    {
                        data: 'video_source',
                        visible: false
                    },
                    {
                        data: 'case_material',
                        visible: false
                    },
                    {
                        data: 'case_back',
                        visible: false
                    },
                    {
                        data: 'strap_material',
                        visible: false
                    },
                    {
                        data: 'strap_colour',
                        visible: false
                    },
                    {
                        data: 'glass_material',
                        visible: false
                    },
                    {
                        data: 'bezel',
                        visible: false
                    },
                    {
                        data: 'bezel_function',
                        visible: false
                    },
                    {
                        data: 'embellishment',
                        visible: false
                    },
                    {
                        data: 'clasp_type',
                        visible: false
                    },
                    {
                        data: 'movement',
                        visible: false
                    },
                    {
                        data: 'water_resistance',
                        visible: false
                    },
                    {
                        data: 'functionality',
                        visible: false
                    },
                    {
                        data: 'brand_warranty',
                        visible: false
                    },
                    {
                        data: 'service_card',
                        visible: false
                    },
                    {
                        data: 'year_of_card',
                        visible: false
                    },
                    {
                        data: 'hsn_code',
                        visible: false
                    },
                    {
                        data: 'origin_country',
                        visible: false
                    },
                    {
                        data: 'manufacturer',
                        visible: false
                    },
                    {
                        data: 'packers',
                        visible: false
                    },
                    {
                        data: 'unit',
                        visible: false
                    },
                    {
                        data: 'condition',
                        visible: false
                    },
                    {
                        data: 'purchase_date',
                        visible: false
                    },
                    {
                        data: 'shop_warranty',
                        visible: false
                    },
                    {
                        data: 'new_arrival',
                        visible: false
                    },
                    {
                        data: 'manage_stock',
                        visible: false
                    },
                    {
                        data: 'out_stock',
                        visible: false
                    },
                    {
                        data: 'not_for_selling',
                        visible: false
                    },
                    {
                        data: 'tata_cliq_product',
                        visible: false
                    },
                    {
                        data: 'quantity',
                        visible: false
                    },
                    {
                        data: 'product_desc',
                        visible: false
                    },
                    {
                        data: 'pro_tax',
                        visible: false
                    },
                    {
                        data: 'product_type',
                        visible: false
                    },
                    {
                        data: 'selling_tax_type',
                        visible: false
                    },
                    {
                        data: 'purchase_price_inclusive',
                        visible: false
                    },
                    {
                        data: 'purchase_price_exclusive',
                        visible: false
                    },
                    {
                        data: 'pro_margin',
                        visible: false
                    },
                    {
                        data: 'selling_price_exclusive',
                        visible: false
                    },
                    {
                        data: 'meta_title',
                        visible: false
                    },
                    {
                        data: 'meta_description',
                        visible: false
                    },
                    {
                        data: 'approval_status',
                        visible: false
                    },
                    {
                        data: 'store_owner',
                        visible: false
                    },
                    {
                        data: 'status',
                        visible: false
                    }
                ],

                columnDefs: [{
                    targets: '_all',
                    className: 'text-start'
                }],
                dom: "<'row mb-2 align-items-center'<'col-lg-2 col-md-3'l><'col-lg-7 col-md-6 text-center'B><'col-lg-3 col-md-3 text-end'f>>rtip",
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            orthogonal: 'export'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            orthogonal: 'export'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)'
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

            // View product modal

            // View product modal
            $(document).on('click', '.viewProduct', function() {
                var id = $(this).data('id');
                var modalContent = $('#viewModalContent');

                // Show Modal & Spinner
                $('#tatacliqViewModal').modal('show');
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
                                            <div>${checkNull(d.dial_colour)}</div>
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
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Purchase Price</label>
                                                    <div class="fw-medium">${formatPrice(d.purchase_price_exclusive)}</div>
                                                </div>
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
        });
    </script>
</body>

</html>
