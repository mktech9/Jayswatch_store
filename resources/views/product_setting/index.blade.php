<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    .settings-card {
        transition: all 0.3s ease;
        border: 1px solid #e8e8e8;
    }

    .settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .category-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .count-badge {
        font-size: 1.2rem;
        font-weight: 600;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .settings-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
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

    .action-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        margin: 0 3px;
    }

    .tab-content {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animation for showing/hiding sections */
    .section-transition {
        transition: all 0.3s ease;
    }

    /* CSS by Faazil */
    .hub-row {
        margin-bottom: 20px;
        perspective: 1000px;
    }

    .hub-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #edf2f9;
        box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        padding: 0;
        height: 100px;
        /* Fixed height for consistency */
    }

    .hub-card:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 1rem 3rem rgba(18, 38, 63, 0.1);
        border-color: transparent;
    }

    /* Colored Accent Bar on Left */
    .hub-border {
        width: 6px;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
    }

    /* Icon Section */
    .hub-icon-box {
        width: 80px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        background: #fcfcfc;
        border-right: 1px dashed #e2e5e8;
        z-index: 2;
    }

    /* Main Content */
    .hub-content {
        flex: 1;
        padding: 0 25px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Metric Section (Count) */
    .hub-metric {
        padding: 0 30px;
        text-align: right;
        z-index: 2;
        min-width: 120px;
        border-left: 1px solid #f0f2f5;
        height: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .metric-value {
        font-size: 1.2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 5px;
    }

    .metric-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #8795a1;
        font-weight: 600;
    }

    /* Action Buttons Area */
    .hub-actions {
        padding: 0 25px;
        z-index: 2;
        background: #fff;
        /* Ensure buttons sit on white */
    }

    /* Background Watermark Icon */
    .hub-watermark {
        position: absolute;
        right: 10%;
        top: 50%;
        transform: translateY(-50%) rotate(-15deg);
        font-size: 8rem;
        opacity: 0.04;
        pointer-events: none;
        z-index: 1;
        transition: all 0.5s ease;
    }

    .hub-card:hover .hub-watermark {
        transform: translateY(-50%) rotate(0deg) scale(1.1);
        opacity: 0.08;
    }

    /* Color Variances */
    :root {
        --hub-theme: #2A2E72;
    }

    /* 2. Override Borders, Icons, and Text for all card types */
    .hub-card .hub-border {
        background: var(--hub-theme) !important;
    }

    .hub-card .hub-icon-box {
        color: var(--hub-theme) !important;
    }

    .hub-card .metric-value {
        color: var(--hub-theme) !important;
    }

    /* 3. Override Solid Buttons (Add New) */
    .hub-actions .btn:not([class*="btn-outline"]) {
        background-color: var(--hub-theme) !important;
        border-color: var(--hub-theme) !important;
        color: #ffffff !important;
    }

    /* 4. Override Outline Buttons (View) */
    .hub-actions .btn[class*="btn-outline"] {
        color: var(--hub-theme) !important;
        border-color: var(--hub-theme) !important;
        background-color: transparent !important;
    }

    .hub-actions .btn[class*="btn-outline"]:hover {
        background-color: var(--hub-theme) !important;
        color: #ffffff !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {

        /* Turn the main container into a flex grid */
        #cardsSection {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -8px;
            /* Negative margin to pull cards to the screen edges */
        }

        /* Force existing rows to act as 50% width columns */
        #cardsSection .hub-row {
            width: 50%;
            padding: 0 8px;
            /* Gap between the two cards */
            margin: 0 0 16px 0;
            /* Bottom spacing */
            display: block;
            /* overrides Bootstrap .row flex behavior */
        }

        /* Remove inner column padding */
        #cardsSection .hub-row .col-12 {
            padding: 0;
        }

        /* Adjust the Card to be a vertical tile */
        .hub-card {
            height: 100%;
            flex-direction: column;
            padding: 0;
            justify-content: space-between;
            text-align: center;
        }

        /* 1. Top Border Bar */
        .hub-border {
            width: 100%;
            height: 4px;
            left: 0;
            top: 0;
        }

        /* 2. Icon - Smaller & Centered */
        .hub-icon-box {
            width: 100%;
            height: 50px;
            border-right: none;
            border-bottom: 1px dashed #eee;
            font-size: 1.6rem;
            margin-top: 4px;
            background: transparent;
        }

        /* 3. Content - Compact */
        .hub-content {
            padding: 10px 5px;
            flex: 0 0 auto;
            width: 100%;
        }

        .hub-content h4 {
            font-size: 0.95rem;
            margin-bottom: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .hub-content p {
            display: none;
        }

        /* Hide description to save space */

        /* 4. Metric - Compact Box */
        .hub-metric {
            border-left: none;
            border-top: 1px solid #f0f2f5;
            width: 100%;
            padding: 8px;
            text-align: center;
            min-width: auto;
            background: transparent !important;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .metric-value {
            font-size: 1.5rem;
            margin-bottom: 0;
        }

        .metric-label {
            font-size: 0.65rem;
            margin-top: 2px;
        }

        /* 5. Actions - Fix Button Sizing */
        .hub-actions {
            width: 100%;
            padding: 10px;
            display: flex;
            gap: 8px !important;
            justify-content: center;
            flex-wrap: wrap;
            /* Allows stacking when needed */
        }

        .hub-actions .btn {
            padding: 8px 0 !important;
            font-size: 0.75rem;
            flex: 1;
            border-radius: 50px !important;
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 0;
            /* Prevents overflow */
        }

        .hub-watermark {
            display: block !important;
            /* Force visible */
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-10deg);
            /* Centered and tilted */
            font-size: 6rem;
            /* Large size relative to card */
            opacity: 0.06;
            /* Low opacity */
            color: var(--hub-theme);
            pointer-events: none;
            /* Click through to buttons */
            z-index: 0;
        }
    }

    @media (max-width: 450px) {
        .hub-actions .btn {
            flex: 0 0 100%;
            /* Force 100% width (Up and Down) */
            width: 100%;
        }
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Product Settings</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product Settings</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Category Cards Section -->
                <div id="cardsSection">

                    <div class="row hub-row">
                        <div class="col-12">
                            <div class="hub-card hub-primary">
                                <div class="hub-border"></div>

                                <div class="hub-icon-box">
                                    <i class="bx bx-tag"></i>
                                </div>

                                <div class="hub-content">
                                    <h5 class="mb-1 text-dark">Brands</h5>
                                    <p class="mb-0 text-muted fs-13">Manage and organize watch brands</p>
                                </div>

                                <div class="hub-metric">
                                    <span class="metric-value" id="brandCount">{{ $brand_count }}</span>
                                    <span class="metric-label">Active Brands</span>
                                </div>

                                <div class="hub-actions d-flex gap-2">
                                    <button class="btn btn-outline-primary rounded-pill px-4" id="viewBrand">
                                        <i class="bx bx-show me-1"></i> View
                                    </button>
                                    <button class="btn btn-primary rounded-pill px-4 add-category" data-category="brand"
                                        data-title="Add Brand">
                                        <i class="bx bx-plus me-1"></i> Add New
                                    </button>
                                </div>

                                <i class="bx bx-tag hub-watermark"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row hub-row">
                        <div class="col-12">
                            <div class="hub-card hub-success">
                                <div class="hub-border"></div>

                                <div class="hub-icon-box">
                                    <i class="bx bx-time"></i>
                                </div>

                                <div class="hub-content">
                                    <h5 class="mb-1 text-dark">Watch Types</h5>
                                    <p class="mb-0 text-muted fs-13">Categorize watches by type or style</p>
                                </div>

                                <div class="hub-metric">
                                    <span class="metric-value" id="watchTypeCount">{{ $watchtype_count }}</span>
                                    <span class="metric-label">Watch Types</span>
                                </div>

                                <div class="hub-actions d-flex gap-2">
                                    <button class="btn btn-outline-success rounded-pill px-4" id="viewWatch"
                                        data-category="watch_type" data-title="Watch Type Management">
                                        <i class="bx bx-show me-1"></i> View
                                    </button>
                                    <button class="btn btn-success rounded-pill px-4 add-category"
                                        data-category="watch_type" data-title="Add Watch Type">
                                        <i class="bx bx-plus me-1"></i> Add New
                                    </button>
                                </div>

                                <i class="bx bx-time hub-watermark"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row hub-row">
                        <div class="col-12">
                            <div class="hub-card hub-info">
                                <div class="hub-border"></div>

                                <div class="hub-icon-box">
                                    <i class="bx bx-diamond"></i>
                                </div>

                                <div class="hub-content">
                                    <h5 class="mb-1 text-dark">Glass Material</h5>
                                    <p class="mb-0 text-muted fs-13">Define glass materials (Sapphire, Mineral)</p>
                                </div>

                                <div class="hub-metric">
                                    <span class="metric-value" id="glassMaterialCount">{{ $glassmaterial_count }}</span>
                                    <span class="metric-label">Materials</span>
                                </div>

                                <div class="hub-actions d-flex gap-2">
                                    <button class="btn btn-outline-info rounded-pill px-4" id="viewGlass"
                                        data-category="glass_material" data-title="Glass Material Management">
                                        <i class="bx bx-show me-1"></i> View
                                    </button>
                                    <button class="btn btn-info text-white rounded-pill px-4 add-category"
                                        data-category="glass_material" data-title="Add Glass Material">
                                        <i class="bx bx-plus me-1"></i> Add New
                                    </button>
                                </div>

                                <i class="bx bx-diamond hub-watermark"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row hub-row">
                        <div class="col-12">
                            <div class="hub-card hub-warning">
                                <div class="hub-border"></div>

                                <div class="hub-icon-box">
                                    <i class="bx bx-palette"></i>
                                </div>

                                <div class="hub-content">
                                    <h5 class="mb-1 text-dark">Colours</h5>
                                    <p class="mb-0 text-muted fs-13">Manage available color variants</p>
                                </div>

                                <div class="hub-metric">
                                    <span class="metric-value" id="colourCount">{{ $color_count }}</span>
                                    <span class="metric-label">Colors</span>
                                </div>

                                <div class="hub-actions d-flex gap-2">
                                    <button class="btn btn-outline-warning rounded-pill px-4" id="viewColour"
                                        data-category="colour" data-title="Colour Management">
                                        <i class="bx bx-show me-1"></i> View
                                    </button>
                                    <button class="btn btn-warning rounded-pill px-4 add-category"
                                        data-category="colour" data-title="Add Colour">
                                        <i class="bx bx-plus me-1"></i> Add New
                                    </button>
                                </div>

                                <i class="bx bx-palette hub-watermark"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row hub-row">
                        <div class="col-12">
                            <div class="hub-card hub-danger">
                                <div class="hub-border"></div>

                                <div class="hub-icon-box">
                                    <i class="bx bx-cog"></i>
                                </div>

                                <div class="hub-content">
                                    <h5 class="mb-1 text-dark">Movement</h5>
                                    <p class="mb-0 text-muted fs-13">Configure watch movement types (Automatic, Quartz)
                                    </p>
                                </div>

                                <div class="hub-metric">
                                    <span class="metric-value" id="movementCount">{{ $movement_count }}</span>
                                    <span class="metric-label">Movements</span>
                                </div>

                                <div class="hub-actions d-flex gap-2">
                                    <button class="btn btn-outline-danger rounded-pill px-4" id="viewMovement"
                                        data-category="movement" data-title="Movement Management">
                                        <i class="bx bx-show me-1"></i> View
                                    </button>
                                    <button class="btn btn-danger rounded-pill px-4 add-category"
                                        data-category="movement" data-title="Add Movement">
                                        <i class="bx bx-plus me-1"></i> Add New
                                    </button>
                                </div>

                                <i class="bx bx-cog hub-watermark"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row hub-row">
                        <div class="col-12">
                            <div class="hub-card hub-danger">
                                <div class="hub-border"></div>

                                <div class="hub-icon-box">
                                    <i class="bx bx-mail-send"></i>
                                </div>


                                <div class="hub-content">
                                    <h5 class="mb-1 text-dark">Admin Emails</h5>
                                    <p class="mb-0 text-muted fs-13">Add Primary Emails
                                    </p>
                                </div>

                                <div class="hub-metric">
                                    <span class="metric-value" id="emailCount">{{ $email_count }}</span>
                                    <span class="metric-label">Email</span>
                                </div>

                                <div class="hub-actions d-flex gap-2">
                                    <button class="btn btn-outline-danger rounded-pill px-4" id="viewEmail"
                                        data-category="email" data-title="Email Management">
                                        <i class="bx bx-show me-1"></i> View
                                    </button>
                                    <button class="btn btn-danger rounded-pill px-4 add-category"
                                        data-category="email" data-title="Add Email">
                                        <i class="bx bx-plus me-1"></i> Add New
                                    </button>
                                </div>

                                <i class="bx bx-mail-send hub-watermark"></i>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="row section-transition" id="brandTableSection" style="display:none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0" id="tableTitle">Category Management</h4>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="brandTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Brand</th>
                                                <th>Meta Description</th>
                                                <th>Status</th>
                                                <th>Created At</th> <!-- added -->
                                                <th>Action</th> <!-- added -->
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Form Section --}}
                <div class="row" id="addBrandSection" style="display:none;">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                            <div
                                class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1   text-dark">Add Brand</h4>
                                    <p class="mb-0 text-muted small">Enter the details to create a new watch brand</p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>

                            <div class="card-body p-4">
                                <form id="brandForm" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <input type="hidden" name="brand_id" id="brand_id">
                                    <input type="hidden" name="remove_image" id="remove_image" value="0">

                                    <div class="row g-4">

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Brand Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted">
                                                    <i class="bx bx-tag"></i>
                                                </span>
                                                <input type="text" name="brand_name"
                                                    class="form-control border-start-0 bg-light ps-0"
                                                    placeholder="e.g. Rolex" oninput="capitalizeFirst(this)" required>
                                                <div class="invalid-feedback">
                                                    Please enter brand name.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Brand Image</label>

                                            <div
                                                class="input-group has-validation shadow-sm rounded-3 overflow-hidden border">
                                                <span class="input-group-text bg-white border-0 text-primary ps-3">
                                                    <i class="bx bx-image-add fs-5"></i>
                                                </span>
                                                <input type="file" name="brand_img" id="brand_img"
                                                    class="form-control border-0 bg-white ps-2 py-2"
                                                    style="font-size: 0.9rem;" accept="image/*">
                                                <div class="invalid-feedback px-3 pb-2 m-0 bg-white">
                                                    Please select a valid image file.
                                                </div>
                                            </div>

                                            <div id="previewWrapper" class="mt-3 position-relative"
                                                style="display:none; width: fit-content; line-height: 0;">
                                                <img id="brand_img_preview" src=""
                                                    style="height: 100px; width: auto; min-width: 60px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 2px solid #fff;">

                                                <button type="button" id="removeImageBtn"
                                                    class="btn btn-danger btn-sm p-0 rounded-circle shadow"
                                                    style="position:absolute; top:-8px; right:-8px; width:22px; height:22px; display:flex; align-items:center; justify-content:center; z-index: 10;">
                                                    <i class="bx bx-x" style="font-size: 1.1rem;"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Meta Title</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light border-end-0 text-muted align-items-start pt-2">
                                                    <i class="bx bx-text"></i>
                                                </span>
                                                <input type="text" name="meta_title"
                                                    class="form-control border-start-0 bg-light ps-0" rows="3"
                                                    placeholder="Enter a meta title...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Meta Description</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light border-end-0 text-muted align-items-start pt-2">
                                                    <i class="bx bx-text"></i>
                                                </span>
                                                <textarea name="brand_desc" class="form-control border-start-0 bg-light ps-0" rows="3"
                                                    placeholder="Enter a meta description..."></textarea>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-end border-top pt-4">
                                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                                <i class="bx bx-save me-1"></i> Save
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row section-transition" id="watchTableSection" style="display:none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0" id="tableTitle">Watch Types</h4>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="watchTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Watch</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Created At</th> <!-- added -->
                                                <th>Action</th> <!-- added -->
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="addWatchTypeSection" style="display:none;">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                            <div
                                class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1   text-dark">Add Watch Type</h4>
                                    <p class="mb-0 text-muted small">Create a new category for watch types</p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>

                            <div class="card-body p-4">
                                <form id="watchForm" novalidate>
                                    @csrf
                                    <input type="hidden" name="wt_id" id="wt_id">

                                    <div class="row g-4">

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Watch Type <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted">
                                                    <i class="bx bx-time"></i>
                                                </span>
                                                <input type="text"
                                                    class="form-control border-start-0 bg-light ps-0"
                                                    name="watch_type" placeholder="e.g. Automatic"
                                                    oninput="capitalizeFirst(this)" required>
                                                <div class="invalid-feedback">
                                                    Please enter watch type.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Description</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light border-end-0 text-muted align-items-start pt-2">
                                                    <i class="bx bx-text"></i>
                                                </span>
                                                <input type="text"
                                                    class="form-control border-start-0 bg-light ps-0" name="desc"
                                                    rows="3"
                                                    placeholder="Enter a brief description..."></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-end border-top pt-4">
                                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                                <i class="bx bx-save me-1"></i> Save
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row section-transition" id="glassTableSection" style="display:none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0" id="tableTitle">Glass Materials</h4>
                                <button type="button" class="btn btn-light btn-primary" id="backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="glassTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Glass Material</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Created At</th> <!-- added -->
                                                <th>Action</th> <!-- added -->
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" id="addGlassSection" style="display:none;">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                            <div
                                class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1   text-dark">Add Glass Material</h4>
                                    <p class="mb-0 text-muted small">Define glass materials (Sapphire, Mineral, etc.)
                                    </p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>

                            <div class="card-body p-4">
                                <form id="glassForm" novalidate>
                                    @csrf
                                    <input type="hidden" name="gm_id" id="gm_id">

                                    <div class="row g-4">

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Glass Material <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted">
                                                    <i class="bx bx-diamond"></i>
                                                </span>
                                                <input type="text" name="glass_material"
                                                    class="form-control border-start-0 bg-light ps-0"
                                                    placeholder="e.g. Sapphire Crystal"
                                                    oninput="capitalizeFirst(this)" required>

                                                <div class="invalid-feedback">
                                                    Please enter glass material.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark">Description</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light border-end-0 text-muted align-items-start pt-2">
                                                    <i class="bx bx-text"></i>
                                                </span>
                                                <input type="text"
                                                    class="form-control border-start-0 bg-light ps-0" name="desc"
                                                    rows="3"
                                                    placeholder="Enter a brief description..."></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-end border-top pt-4">
                                            <button type="submit" class="btn btn-primary  px-5 shadow-sm">
                                                <i class="bx bx-save me-1"></i> Save Glass Material
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row section-transition" id="colourTableSection" style="display:none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0" id="tableTitle">Colour Management</h4>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="colourTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Material Colour</th>
                                                <th>Status</th>
                                                <th>Created At</th> <!-- added -->
                                                <th>Action</th> <!-- added -->
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="addColourSection" style="display:none;">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                            <div
                                class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1   text-dark">Add Colour</h4>
                                    <p class="mb-0 text-muted small">Manage available color variants</p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>

                            <div class="card-body p-4">
                                <form id="colourForm" novalidate>
                                    @csrf
                                    <input type="hidden" name="color_id" id="color_id">

                                    <div class="row g-4" id="colourWrapper">

                                        <!-- First Row -->
                                        <div class="col-md-6 colour-row">
                                            <label class="form-label fw-semibold text-dark">
                                                Colour Name <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted">
                                                    <i class="bx bx-palette"></i>
                                                </span>

                                                <input type="text" name="colour[]"
                                                    class="form-control border-start-0 bg-light ps-0"
                                                    oninput="capitalizeFirst(this)" placeholder="e.g. Rose Gold"
                                                    required>

                                                <!-- Plus Button -->
                                                <button type="button" class="btn btn-success addColour">
                                                    <i class="bx bx-plus"></i>
                                                </button>

                                                <div class="invalid-feedback">
                                                    Please enter colour.
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-end border-top pt-4">
                                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                                <i class="bx bx-save me-1"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row section-transition" id="movementTableSection" style="display:none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0" id="tableTitle">Movement Management</h4>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="movementTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Movement Title</th>
                                                <th>Status</th>
                                                <th>Created At</th> <!-- added -->
                                                <th>Action</th> <!-- added -->
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" id="addMovementSection" style="display:none;">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                            <div
                                class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1   text-dark">Add Movement</h4>
                                    <p class="mb-0 text-muted small">Configure watch movement types (Swiss Made
                                        Automatic)
                                    </p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>

                            <div class="card-body p-4">
                                <form id="movementForm" novalidate>
                                    @csrf
                                    <input type="hidden" name="m_id" id="m_id">

                                    <div class="row g-4" id="movementWrapper">

                                        <div class="col-md-6 movement-row">
                                            <label class="form-label fw-semibold text-dark">
                                                Movement Title <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted">
                                                    <i class="bx bx-cog"></i>
                                                </span>

                                                <input type="text" name="movement_title[]"
                                                    class="form-control border-start-0 bg-light ps-0"
                                                    placeholder="e.g. Swiss Made Automatic"
                                                    oninput="capitalizeFirst(this)" required>

                                                <!-- PLUS -->
                                                <button type="button" class="btn btn-success addMovement">
                                                    <i class="bx bx-plus"></i>
                                                </button>

                                                <div class="invalid-feedback">
                                                    Please enter movement title.
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-end border-top pt-4">
                                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                                <i class="bx bx-save me-1"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>



                <!-- ✅ ADD EMAIL SECTION -->
                <div class="row" id="addEmailSection" style="display:none;">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                            <!-- Header -->
                            <div
                                class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1 text-dark">Add Admin Emails</h4>
                                    <p class="mb-0 text-muted small">Add multiple admin emails for notifications</p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="card-body p-4">

                                <form id="emailForm" novalidate>
                                    @csrf

                                    <div class="row g-4" id="emailWrapper">

                                        <!-- First Email Row -->
                                        <div class="col-md-6 email-row">
                                            <label class="form-label fw-semibold text-dark">
                                                Admin Email <span class="text-danger">*</span>
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted">
                                                    <i class="bx bx-envelope"></i>
                                                </span>

                                                <input type="email" name="email[]"
                                                    class="form-control border-start-0 bg-light ps-0"
                                                    placeholder="e.g. admin@gmail.com" required>

                                                <!-- ✅ PLUS BUTTON -->
                                                <button type="button" class="btn btn-success addEmail">
                                                    <i class="bx bx-plus"></i>
                                                </button>

                                                <div class="invalid-feedback">
                                                    Please enter a valid email.
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Submit -->
                                    <div class="row mt-4">
                                        <div class="col-12 text-end border-top pt-4">
                                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                                <i class="bx bx-save me-1"></i> Save
                                            </button>
                                        </div>
                                    </div>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="row section-transition" id="emailTableSection" style="display:none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Admin Email Management</h4>

                                <button type="button" class="btn btn-primary btn-sm px-3 backToCards">
                                    <i class="bx bx-arrow-back me-1"></i> Back
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="emailTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th>
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

        @include('partials.footer')
    </div>

    <!-- ADD BRAND SECTION -->



    @include('partials.footer_link')

    <script>
        // ───────────────────────────────────────────────
        // ADD NEW COLOUR FIELD (only first added gets padding)
        // ───────────────────────────────────────────────
        $(document).on('click', '.addColour', function() {

            // Count existing colour rows BEFORE appending
            const existingCount = $('#colourWrapper .colour-row').length;
            const applyPadding = (existingCount ===
                1); // 1 = only the static first row exists → next one is "first added"

            let row = `
    <div class="col-md-6 colour-row"${applyPadding ? ' style="padding-top: 25px;"' : ''}>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bx bx-palette"></i>
            </span>
            <input type="text"
                   name="colour[]"
                   class="form-control border-start-0 bg-light ps-0"
                   oninput="capitalizeFirst(this)"
                   placeholder="e.g. Rose Gold"
                   required>
            <button type="button" class="btn btn-danger removeColour">
                <i class="bx bx-minus"></i>
            </button>
            <div class="invalid-feedback">
                Please enter colour.
            </div>
        </div>
    </div>`;

            $('#colourWrapper').append(row);
        });

        // ───────────────────────────────────────────────
        // ADD NEW MOVEMENT FIELD (same logic)
        // ───────────────────────────────────────────────
        $(document).on('click', '.addMovement', function() {

            const existingCount = $('#movementWrapper .movement-row').length;
            const applyPadding = (existingCount === 1);

            let row = `
    <div class="col-md-6 movement-row"${applyPadding ? ' style="padding-top: 25px;"' : ''}>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bx bx-cog"></i>
            </span>
            <input type="text"
                   name="movement_title[]"
                   class="form-control border-start-0 bg-light ps-0"
                   oninput="capitalizeFirst(this)"
                   placeholder="Swiss Made Automatic"
                   required>
            <button type="button" class="btn btn-danger removeMovement">
                <i class="bx bx-minus"></i>
            </button>
            <div class="invalid-feedback">
                Please enter movement title.
            </div>
        </div>
    </div>`;

            $('#movementWrapper').append(row);
        });

        // Remove handlers (unchanged)
        $(document).on('click', '.removeColour', function() {
            $(this).closest('.colour-row').remove();
        });

        $(document).on('click', '.removeMovement', function() {
            $(this).closest('.movement-row').remove();
        });
    </script>

    <script>
        $(document).on("change", "#brand_img", function() {
            let reader = new FileReader();

            reader.onload = function(e) {
                $("#brand_img_preview").attr("src", e.target.result);
                $("#previewWrapper").show();
            };

            reader.readAsDataURL(this.files[0]);
            $("#remove_image").val(0);
        });


        $(document).on("click", "#removeImageBtn", function() {

            $("#previewWrapper").hide();
            $("#brand_img_preview").attr("src", "");
            $("#brand_img").val("");

            // mark image for deletion
            $("#remove_image").val(1);
        });



        // SHOW ADD FORMS (RESET ALWAYS LIKE BRAND)
        $(document).on("click", ".add-category", function() {

            const category = $(this).data("category");

            // hide everything else
            $("#cardsSection").hide();
            $("#brandTableSection, #watchTableSection, #glassTableSection, #colourTableSection, #movementTableSection,#emailTableSection")
                .hide();
            $("#addBrandSection, #addWatchTypeSection, #addGlassSection, #addColourSection, #addMovementSection, #addCountrySection,#addEmailSection")
                .hide();

            /* ---------------- BRAND ---------------- */
            if (category === "brand") {

                $('#brandForm')[0].reset();
                $('#brandForm').removeClass('was-validated');

                $('#brand_id').val('');
                $('#remove_image').val(0);

                $("#previewWrapper").hide();
                $("#brand_img_preview").attr("src", "");
                $("input[name='brand_img']").val("");

                $("#addBrandSection .card-title").text("Add Brand");
                $("#addBrandSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Save');

                $("#addBrandSection").show();
            }

            /* ---------------- WATCH TYPE ---------------- */
            if (category === "watch_type") {

                $('#watchForm')[0].reset();
                $('#watchForm').removeClass('was-validated');
                $('#wt_id').val('');

                $("#addWatchTypeSection .card-title").text("Add Watch Type");
                $("#addWatchTypeSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Save');

                $("#addWatchTypeSection").show();
            }

            /* ---------------- GLASS MATERIAL ---------------- */
            if (category === "glass_material") {

                $('#glassForm')[0].reset();
                $('#glassForm').removeClass('was-validated');
                $('#gm_id').val('');

                $("#addGlassSection .card-title").text("Add Glass Material");
                $("#addGlassSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Save');

                $("#addGlassSection").show();
            }

            /* ---------------- COLOUR ---------------- */
            if (category === "colour") {

                $('#colourForm')[0].reset();
                $('#colourForm').removeClass('was-validated');
                $('#color_id').val('');

                $("#addColourSection .card-title").text("Add Colour");
                $("#addColourSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Save');

                $("#addColourSection").show();
            }

            /* ---------------- MOVEMENT ---------------- */
            if (category === "movement") {

                $('#movementForm')[0].reset();
                $('#movementForm').removeClass('was-validated');
                $('#m_id').val('');

                $("#addMovementSection .card-title").text("Add Movement");
                $("#addMovementSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Save');

                $("#addMovementSection").show();
            }

            /* ---------------- EMAIL ---------------- */
            if (category === "email") {

                $('#emailForm')[0].reset();
                $('#emailForm').removeClass('was-validated');
                $('#email_id').val('');

                $("#addEmailSection .card-title").text("Add Admin Email");
                $("#addEmailSection button[type='submit']")
                    .html('<i class="bx bx-save me-1"></i> Save');

                $("#addEmailSection").show();
            }




        });



        // BACK BUTTON
        $(document).on("click", ".backToCards", function() {
            window.location.href = "{{ route('prosetting.index') }}";
        });




        // ADD BRAND – AJAX SAVE
        $(document).on('submit', '#brandForm', function(e) {

            e.preventDefault();

            let form = this;

            // check validity
            if (!form.checkValidity()) {
                e.stopPropagation();
                $(form).addClass('was-validated');
                return false;
            }

            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('brand.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                    iziToast.success({
                        message: res.message,
                        position: "topRight"
                    });

                    form.reset();
                    $("#previewWrapper").hide();
                    $("#brand_img_preview").attr("src", "");
                    $('#brand_id').val(""); // clear id after update
                    $('#viewBrand').trigger('click');
                },

                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        if (errors?.brand_name) {
                            iziToast.info({
                                message: "Brand name already exists",
                                position: "topRight"
                            });
                            return;
                        }
                    }
                    iziToast.error({
                        message: xhr.responseJSON?.message || "Failed to save brand",
                        position: "topRight"
                    });
                }
            });
        });


        $(document).on('click', '#backToCards', function() {

            $("#brandTableSection").hide();
            $("#addBrandSection").hide();

            $("#cardsSection").show();
        });



        // VIEW BRAND TABLE
        $('#viewBrand').on('click', function() {

            $("#cardsSection").hide();
            $("#addBrandSection").hide();

            $("#tableTitle").text("Brands Management");


            $("#brandTableSection").show();

            if ($.fn.DataTable.isDataTable('#brandTable')) {
                $('#brandTable').DataTable().ajax.reload();
                return;
            }

            setTimeout(function() {

                $('#brandTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('brand.list') }}",
                    destroy: true,

                    columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    }, {
                        data: 'brand_name',
                        name: 'brand_name'
                    }, {
                        data: 'brand_desc',
                        name: 'brand_desc'
                    }, {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'created_at',
                        name: 'created_at'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }]
                });

            }, 200); // important (wait until visible)
        });


        $(document).on('click', '.editBrand', function() {

            let id = $(this).data('id');

            // show form
            $("#cardsSection").hide();
            $("#brandTableSection").hide();
            $("#addBrandSection").show();


            $("#addBrandSection .card-title").text("Edit Brand");
            $("#addBrandSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Update');


            // build route from route name
            let url = "{{ route('brand.edit', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",

                success: function(res) {

                    $('#brand_id').val(res.brand_id);
                    $('input[name="brand_name"]').val(res.brand_name);
                    $('input[name="meta_title"]').val(res.meta_title);
                    $('textarea[name="brand_desc"]').val(res.brand_desc);

                    if (res.brand_img) {

                        let path = "/assets/brand_images/" + res.brand_img;

                        $("#brand_img_preview").attr("src", path);
                        $("#previewWrapper").show();

                    } else {
                        $("#previewWrapper").hide();
                        $("#brand_img_preview").attr("src", "");
                    }
                }

            });

        });


        $(document).on("click", ".deleteBrand", function() {

            let id = $(this).data("id");
            let name = $(this).data("name");

            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'delete-question',
                zindex: 99999,
                title: 'Confirm Delete',
                message: 'Do you really want to delete brand: <b>' + name + '</b> ?',
                position: 'center',

                buttons: [
                    // YES BUTTON
                    ['<button><b>Yes</b></button>', function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);

                        let url = "{{ route('brand.soft.delete', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {

                                iziToast.success({
                                    message: res.message,
                                    position: "topRight"
                                });

                                $('#brandTable').DataTable().ajax.reload();
                            }
                        });

                    }, true],

                    // NO BUTTON
                    ['<button>No</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);
                    }],
                ]
            });
        });

        $(document).on('submit', '#watchForm', function(e) {
            //alert();
            e.preventDefault();

            let form = this;

            // check validity
            if (!form.checkValidity()) {
                e.stopPropagation();
                $(form).addClass('was-validated');
                return false;
            }

            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('watch.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                    iziToast.success({
                        message: res.message,
                        position: "topRight"
                    });

                    form.reset();
                    $('#wt_id').val(""); // clear id after update
                    $('#viewWatch').trigger('click');
                },

                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        if (errors?.watch_type) {
                            iziToast.info({
                                message: "Watch type already exists",
                                position: "topRight"
                            });
                            return;
                        }
                    }

                    iziToast.error({
                        message: xhr.responseJSON?.message || "Failed to save watch",
                        position: "topRight"
                    });
                }
            });
        });


        $(document).on('click', '#backToCards', function() {
            $("#watchTableSection").hide();
            $("#addWatchTypeSection").hide();

            $("#cardsSection").show();
        });


        $('#viewWatch').on('click', function() {

            $("#cardsSection").hide();
            $("#addWatchTypeSection").hide();

            $("#watchTableSection").show();

            if ($.fn.DataTable.isDataTable('#watchTable')) {
                $('#watchTable').DataTable().ajax.reload();
                return;
            }

            setTimeout(function() {

                $('#watchTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('watch.list') }}",
                    destroy: true,

                    columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    }, {
                        data: 'title',
                        name: 'title'
                    }, {
                        data: 'desc',
                        name: 'desc'
                    }, {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'created_at',
                        name: 'created_at'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }]
                });

            }, 200);
        });

        $(document).on('click', '.editWatch', function() {

            let id = $(this).data('id');

            // show form
            $("#cardsSection").hide();
            $("#watchTableSection").hide();
            $("#addWatchTypeSection").show();


            $("#addWatchTypeSection .card-title").text("Edit Watch");
            $("#addWatchTypeSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Update');


            // build route from route name
            let url = "{{ route('watch.edit', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",

                success: function(res) {

                    $('#wt_id').val(res.wt_id);
                    $('input[name="watch_type"]').val(res.title);
                    $('textarea[name="desc"]').val(res.desc);
                }

            });

        });

        $(document).on("click", ".deleteWatch", function() {

            let id = $(this).data("id");
            let name = $(this).data("name");

            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'delete-question',
                zindex: 99999,
                title: 'Confirm Delete',
                message: 'Do you really want to delete watch: <b>' + name + '</b> ?',
                position: 'center',

                buttons: [
                    // YES BUTTON
                    ['<button><b>Yes</b></button>', function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);

                        let url = "{{ route('watch.soft.delete', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {

                                iziToast.success({
                                    message: res.message,
                                    position: "topRight"
                                });

                                $('#watchTable').DataTable().ajax.reload();
                            }
                        });

                    }, true],

                    // NO BUTTON
                    ['<button>No</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);
                    }],
                ]
            });
        });

        $(document).on('submit', '#glassForm', function(e) {
            //alert();
            e.preventDefault();

            let form = this;

            // check validity
            if (!form.checkValidity()) {
                e.stopPropagation();
                $(form).addClass('was-validated');
                return false;
            }

            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('glass.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                    iziToast.success({
                        message: res.message,
                        position: "topRight"
                    });

                    form.reset();
                    $('#gm_id').val(""); // clear id after update
                    $('#viewGlass').trigger('click');
                },

                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        if (errors?.glass_material) {
                            iziToast.info({
                                message: "Glass material already exists",
                                position: "topRight"
                            });
                            return;
                        }
                    }
                    iziToast.error({
                        message: xhr.responseJSON?.message || "Failed to save glass",
                        position: "topRight"
                    });
                }
            });
        });


        $(document).on('click', '#backToCards', function() {
            $("#glassTableSection").hide();
            $("#addGlassSection").hide();

            $("#cardsSection").show();
        });

        $('#viewGlass').on('click', function() {

            $("#cardsSection").hide();
            $("#addGlassSection").hide();

            $("#glassTableSection").show();

            if ($.fn.DataTable.isDataTable('#glassTable')) {
                $('#glassTable').DataTable().ajax.reload();
                return;
            }

            setTimeout(function() {

                $('#glassTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('glass.list') }}",
                    destroy: true,

                    columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    }, {
                        data: 'title',
                        name: 'title'
                    }, {
                        data: 'desc',
                        name: 'desc'
                    }, {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'created_at',
                        name: 'created_at'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }]
                });

            }, 200);
        });

        $(document).on('click', '.editGlass', function() {

            let id = $(this).data('id');

            // show form
            $("#cardsSection").hide();
            $("#glassTableSection").hide();
            $("#addGlassSection").show();


            $("#addGlassSection .card-title").text("Edit Glass");
            $("#addGlassSection button[type='submit']").html('<i class="bx bx-save me-1"></i> Update');


            // build route from route name
            let url = "{{ route('glass.edit', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",

                success: function(res) {

                    $('#gm_id').val(res.gm_id);
                    $('input[name="glass_material"]').val(res.title);
                    $('textarea[name="desc"]').val(res.desc);
                }

            });

        });

        $(document).on("click", ".deleteGlass", function() {

            let id = $(this).data("id");
            let name = $(this).data("name");

            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'delete-question',
                zindex: 99999,
                title: 'Confirm Delete',
                message: 'Do you really want to delete glass: <b>' + name + '</b> ?',
                position: 'center',

                buttons: [
                    // YES BUTTON
                    ['<button><b>Yes</b></button>', function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);

                        let url = "{{ route('glass.soft.delete', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {

                                iziToast.success({
                                    message: res.message,
                                    position: "topRight"
                                });

                                $('#glassTable').DataTable().ajax.reload();
                            }
                        });

                    }, true],

                    // NO BUTTON
                    ['<button>No</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);
                    }],
                ]
            });
        });

        $(document).on('submit', '#colourForm', function(e) {
            //alert();
            e.preventDefault();

            let form = this;

            // check validity
            if (!form.checkValidity()) {
                e.stopPropagation();
                $(form).addClass('was-validated');
                return false;
            }

            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('colour.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                    iziToast.success({
                        message: res.message,
                        position: "topRight"
                    });

                    form.reset();
                    $('#color_id').val(""); // clear id after update
                    $('#viewColour').trigger('click');
                },

                error: function(xhr) {

                    if (xhr.status === 422 && xhr.responseJSON?.exists) {

                        iziToast.error({
                            title: 'Duplicate Colour',
                            message: 'Already exists: <b>' + xhr.responseJSON.exists.join(
                                ', ') + '</b>',
                            position: "topRight",
                            timeout: 5000
                        });

                        return;
                    }
                    iziToast.error({
                        message: xhr.responseJSON?.message || "Failed to save color",
                        position: "topRight"
                    });
                }
            });
        });


        $(document).on('click', '#backToCards', function() {
            $("#colourTableSection").hide();
            $("#addColourSection").hide();

            $("#cardsSection").show();
        });

        $('#viewColour').on('click', function() {

            $("#cardsSection").hide();
            $("#addColourSection").hide();

            $("#colourTableSection").show();

            if ($.fn.DataTable.isDataTable('#colourTable')) {
                $('#colourTable').DataTable().ajax.reload();
                return;
            }

            setTimeout(function() {

                $('#colourTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('colour.list') }}",
                    destroy: true,

                    columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    }, {
                        data: 'title',
                        name: 'title'
                    }, {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'created_at',
                        name: 'created_at'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }]
                });

            }, 200);
        });
        $(document).on('click', '.editColour', function() {

            let id = $(this).data('id');

            // show form
            $("#cardsSection").hide();
            $("#colourTableSection").hide();
            $("#addColourSection").show();

            $("#addColourSection .card-title").text("Edit Colour");
            $("#addColourSection button[type='submit']")
                .html('<i class="bx bx-save me-1"></i> Update');

            // ---------- RESET MULTIPLE FIELDS ----------
            $('#colourWrapper').html(`
        <div class="col-md-6 colour-row">
            <label class="form-label fw-semibold text-dark">
                Colour Name <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted">
                    <i class="bx bx-palette"></i>
                </span>

                <input type="text"
                       name="colour[]"
                       class="form-control border-start-0 bg-light ps-0"
                       oninput="capitalizeFirst(this)"
                       required>

                <!-- NO PLUS BUTTON IN EDIT -->
                <div class="invalid-feedback">
                    Please enter colour.
                </div>
            </div>
        </div>
    `);

            // set hidden id
            $('#color_id').val(id);

            // build route
            let url = "{{ route('colour.edit', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",

                success: function(res) {
                    $('input[name="colour[]"]').val(res.title);
                }
            });

        });


        $(document).on("click", ".deleteColour", function() {

            let id = $(this).data("id");
            let name = $(this).data("name");

            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'delete-question',
                zindex: 99999,
                title: 'Confirm Delete',
                message: 'Do you really want to delete colour: <b>' + name + '</b> ?',
                position: 'center',

                buttons: [
                    // YES BUTTON
                    ['<button><b>Yes</b></button>', function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);

                        let url = "{{ route('colour.soft.delete', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {

                                iziToast.success({
                                    message: res.message,
                                    position: "topRight"
                                });

                                $('#colourTable').DataTable().ajax.reload();
                            }
                        });

                    }, true],

                    // NO BUTTON
                    ['<button>No</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);
                    }],
                ]
            });
        });

        $(document).on('submit', '#movementForm', function(e) {
            //alert();
            e.preventDefault();

            let form = this;

            // check validity
            if (!form.checkValidity()) {
                e.stopPropagation();
                $(form).addClass('was-validated');
                return false;
            }

            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('movement.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                    iziToast.success({
                        message: res.message,
                        position: "topRight"
                    });

                    form.reset();
                    $('#m_id').val(""); // clear id after update
                    $('#viewMovement').trigger('click');
                },

                error: function(xhr) {

                    if (xhr.status === 422 && xhr.responseJSON?.exists) {
                        iziToast.error({
                            title: 'Duplicate Movement',
                            message: 'Already exists: <b>' + xhr.responseJSON.exists.join(
                                ', ') + '</b>',
                            position: "topRight",
                            timeout: 5000
                        });
                        return;
                    }
                    iziToast.error({
                        message: xhr.responseJSON?.message || "Failed to save movement",
                        position: "topRight"
                    });
                }
            });
        });


        $(document).on('click', '#backToCards', function() {
            $("#movementTableSection").hide();
            $("#addMovementSection").hide();

            $("#cardsSection").show();
        });

        $('#viewMovement').on('click', function() {

            $("#cardsSection").hide();
            $("#addMovementSection").hide();

            $("#movementTableSection").show();

            if ($.fn.DataTable.isDataTable('#movementTable')) {
                $('#movementTable').DataTable().ajax.reload();
                return;
            }

            setTimeout(function() {

                $('#movementTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('movement.list') }}",
                    destroy: true,

                    columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    }, {
                        data: 'title',
                        name: 'title'
                    }, {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'created_at',
                        name: 'created_at'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }]
                });

            }, 200);
        });

        $(document).on('click', '.editMovement', function() {

            let id = $(this).data('id');

            // show form
            $("#cardsSection").hide();
            $("#movementTableSection").hide();
            $("#addMovementSection").show();

            $("#addMovementSection .card-title").text("Edit Movement");
            $("#addMovementSection button[type='submit']")
                .html('<i class="bx bx-save me-1"></i> Update');

            // ---------- RESET MULTIPLE FIELDS ----------
            $('#movementWrapper').html(`
        <div class="col-md-6 movement-row">
            <label class="form-label fw-semibold text-dark">
                Movement Title <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted">
                    <i class="bx bx-cog"></i>
                </span>

                <input type="text"
                       name="movement_title[]"
                       class="form-control border-start-0 bg-light ps-0"
                       oninput="capitalizeFirst(this)"
                       required>

                <!-- NO PLUS BUTTON IN EDIT -->
                <div class="invalid-feedback">
                    Please enter movement title.
                </div>
            </div>
        </div>
    `);

            // set hidden id
            $('#m_id').val(id);

            // build route
            let url = "{{ route('movement.edit', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",

                success: function(res) {
                    $('input[name="movement_title[]"]').val(res.title);
                }
            });

        });

        $(document).on("click", ".deleteMovement", function() {

            let id = $(this).data("id");
            let name = $(this).data("name");

            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'delete-question',
                zindex: 99999,
                title: 'Confirm Delete',
                message: 'Do you really want to delete movement: <b>' + name + '</b> ?',
                position: 'center',

                buttons: [
                    // YES BUTTON
                    ['<button><b>Yes</b></button>', function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);

                        let url = "{{ route('movement.soft.delete', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {

                                iziToast.success({
                                    message: res.message,
                                    position: "topRight"
                                });

                                $('#movementTable').DataTable().ajax.reload();
                            }
                        });

                    }, true],

                    // NO BUTTON
                    ['<button>No</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);
                    }],
                ]
            });
        });



        // ✅ ADD NEW EMAIL FIELD
        $(document).on("click", ".addEmail", function() {

            // ✅ Count existing email rows before adding
            const existingCount = $("#emailWrapper .email-row").length;

            // ✅ Apply padding only for the first added row
            const applyPadding = (existingCount === 1);

            let row = `
        <div class="col-md-6 email-row"${applyPadding ? ' style="padding-top:25px;"' : ''}>
            <div class="input-group">

                <span class="input-group-text bg-light border-end-0 text-muted">
                    <i class="bx bx-envelope"></i>
                </span>

                <input type="email"
                       name="email[]"
                       class="form-control border-start-0 bg-light ps-0"
                       placeholder="e.g. admin@gmail.com"
                       required>

                <!-- ✅ REMOVE BUTTON -->
                <button type="button" class="btn btn-danger removeEmail">
                    <i class="bx bx-minus"></i>
                </button>

                <div class="invalid-feedback">
                    Please enter a valid email.
                </div>

            </div>
        </div>
    `;

            $("#emailWrapper").append(row);
        });



        // ✅ REMOVE EMAIL FIELD
        $(document).on("click", ".removeEmail", function() {
            $(this).closest(".email-row").remove();
        });


        // ✅ SUBMIT EMAIL FORM AJAX
        $(document).on("submit", "#emailForm", function(e) {

            e.preventDefault();

            let form = this;

            if (!form.checkValidity()) {
                e.stopPropagation();
                $(form).addClass("was-validated");
                return;
            }

            let formData = new FormData(form);

            // ✅ Check if Update Mode
            let emailId = $("#email_id").val();

            // ✅ Prevent Duplicate Emails in Form
            let emails = [];
            let duplicate = false;

            $("input[name='email[]']").each(function() {

                let val = $(this).val().trim().toLowerCase();

                if (val !== "") {

                    if (emails.includes(val)) {
                        duplicate = true;
                        return false; // stop loop
                    }

                    emails.push(val);
                }
            });

            if (duplicate) {
                iziToast.info({
                    title: "Duplicate Email",
                    message: "Same email cannot be entered twice!",
                    position: "topRight"
                });
                return;
            }


            $.ajax({
                url: "{{ route('email.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                    // ✅ SUCCESS MESSAGE (ADD or UPDATE)
                    iziToast.success({
                        message: res.message,
                        position: "topRight"
                    });

                    // ✅ Reload Email Table After Save
                    if ($.fn.DataTable.isDataTable('#emailTable')) {
                        $('#emailTable').DataTable().ajax.reload(null, false);
                    }

                    // ✅ Reset ID
                    $("#email_id").val("");

                    // ✅ RESET FORM
                    form.reset();
                    $("#emailWrapper").html("");

                    // ✅ Add first row again
                    $("#emailWrapper").append(`
                <div class="col-md-6 email-row">
                    <label class="form-label fw-semibold text-dark">
                        Admin Email <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bx bx-envelope"></i>
                        </span>

                        <input type="email" name="email[]"
                            class="form-control border-start-0 bg-light ps-0"
                            placeholder="e.g. admin@gmail.com"
                            required>

                        <button type="button" class="btn btn-success addEmail">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
            `);

                    // ✅ If Update → Go Back to Table View
                    if (emailId) {
                        $("#addEmailSection").hide();
                        $("#emailTableSection").show();
                    }

                    $('#viewEmail').trigger('click');
                },

                error: function(xhr) {

                    if (xhr.status === 422) {
                        iziToast.info({
                            message: xhr.responseJSON.message,
                            position: "topRight"
                        });
                        return;
                    }

                    iziToast.error({
                        message: "Failed to save emails",
                        position: "topRight"
                    });
                }
            });
        });



        // ✅ VIEW EMAIL TABLE
        $('#viewEmail').on('click', function() {

            $("#cardsSection").hide();
            $("#addEmailSection").hide();

            $("#emailTableSection").show();

            if ($.fn.DataTable.isDataTable('#emailTable')) {
                $('#emailTable').DataTable().ajax.reload();
                return;
            }

            setTimeout(function() {

                $('#emailTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('email.list') }}",
                    destroy: true,

                    columns: [{
                            data: 'sr_no',
                            name: 'sr_no'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });


            }, 200);
        });

        $(document).on("click", ".editEmail", function() {

            let id = $(this).data("id");

            // Hide table + Show form
            $("#emailTableSection").hide();
            $("#addEmailSection").show();

            // Change title + button
            $("#addEmailSection .card-title").text("Edit Email");
            $("#emailForm button[type='submit']")
                .html('<i class="bx bx-save me-1"></i> Update');

            // Reset wrapper to single row (No plus button)
            $("#emailWrapper").html(`
      <input type="hidden" class="form-control bg-light" name="email_id" value="${id}">
        <div class="col-md-6 email-row">
            <label class="form-label fw-semibold text-dark">
                Admin Email <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted">
                    <i class="bx bx-envelope"></i>
                </span>

                <input type="email" name="email[]"
                    class="form-control border-start-0 bg-light ps-0"
                    required>

                <div class="invalid-feedback">
                    Please enter valid email.
                </div>
            </div>
        </div>
    `);

            // Set hidden id
            $("#email_id").val(id);

            // Fetch Email Data
            let url = "{{ route('email.edit', ':id') }}";
            url = url.replace(":id", id);

            $.ajax({
                url: url,
                type: "GET",

                success: function(res) {
                    $("input[name='email[]']").val(res.email);
                }
            });
        });


        // ✅ DELETE EMAIL
        $(document).on("click", ".deleteEmail", function() {

            let id = $(this).data("id");
            let email = $(this).data("email");

            iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                title: "Confirm Delete",
                message: "Delete <b>" + email + "</b> ?",
                position: "center",

                buttons: [
                    ['<button><b>Yes</b></button>', function(instance, toast) {

                        instance.hide({}, toast);

                        let url = "{{ route('email.delete', ':id') }}";
                        url = url.replace(":id", id);

                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },

                            success: function(res) {

                                iziToast.success({
                                    message: res.message,
                                    position: "topRight"
                                });

                                $('#emailTable').DataTable().ajax.reload();
                            }
                        });

                    }, true],

                    ['<button>No</button>', function(instance, toast) {
                        instance.hide({}, toast);
                    }]
                ]
            });
        });
    </script>



    <script>
        function capitalizeFirst(input) {
            if (input.value.length > 0) {
                input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
            }
        }
    </script>

    <script>
        function capitalizeFirst(input) {
            if (input.value.length > 0) {
                input.value =
                    input.value.charAt(0).toUpperCase() +
                    input.value.slice(1);
            }
        }
    </script>




</body>

</html>
