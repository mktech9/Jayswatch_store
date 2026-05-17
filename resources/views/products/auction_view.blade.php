<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    .step-content {
        padding: 30px;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        background-color: #fff;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 576px) {
        .step-content {
            padding: 0px;
            border: none;
            box-shadow: none;
        }
    }

    /* Enhanced Progress Bar Styles */
    .step-progress {
        position: relative;
        margin: 40px 0 50px;
    }

    .progress-line {
        position: absolute;
        top: 35px;
        left: 20px;
        right: 20px;
        height: 4px;
        background: linear-gradient(90deg, #2a2e72 0%, #e9ecef 100%);
        z-index: 1;
        border-radius: 2px;
        overflow: hidden;
    }

    .progress-line .progress-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: linear-gradient(90deg, #2a2e72, #2a2e72);
        width: 20%;
        transition: width 0.5s ease;
        border-radius: 2px;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 2;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
    }

    .step-item:not(:last-child) {
        margin-right: 10px;
    }

    .step-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 12px;
        background: white;
        border: 4px solid #e9ecef;
        color: #6c757d;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 2;
    }

    .step-icon i {
        font-size: 24px;
    }

    .step-label {
        font-size: 14px;
        font-weight: 600;
        color: #6c757d;
        text-align: center;
        transition: all 0.3s ease;
        max-width: 100px;
    }

    .step-description {
        font-size: 12px;
        color: #adb5bd;
        text-align: center;
        margin-top: 4px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    /* Active Step Styles */
    .step-item.active .step-icon {
        border-color: #2a2e72;
        background: linear-gradient(135deg, #2a2e72, #2a2e72);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
    }

    .step-item.active .step-label {
        color: #2a2e72;
        font-weight: 700;
    }

    .step-item.active .step-description {
        opacity: 1;
        transform: translateY(0);
    }

    /* Completed Step Styles */
    .step-item.completed .step-icon {
        border-color: #198754;
        background: linear-gradient(135deg, #198754, #20c997);
        color: white;
    }

    .step-item.completed .step-label {
        color: #198754;
    }

    .step-item.completed .step-icon::after {
        content: '✓';
        position: absolute;
        top: -5px;
        right: -5px;
        width: 24px;
        height: 24px;
        background: #198754;
        color: white;
        border-radius: 50%;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
    }

    /* Navigation Buttons */
    .step-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .nav-btn {
        padding: 10px 24px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-btn i {
        font-size: 16px;
    }

    .nav-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Step Icons Background */
    .step-icon.step-1 {
        background: linear-gradient(135deg, #fff, #f8f9fa);
    }

    .step-icon.step-2 {
        background: linear-gradient(135deg, #fff, #f8f9fa);
    }

    .step-icon.step-3 {
        background: linear-gradient(135deg, #fff, #f8f9fa);
    }

    .step-icon.step-4 {
        background: linear-gradient(135deg, #fff, #f8f9fa);
    }

    .step-icon.step-5 {
        background: linear-gradient(135deg, #fff, #f8f9fa);
    }

    .step-item.active .step-icon.step-1 {
        /*background: linear-gradient(135deg, #2a2e72, #2a2e72);*/
        background: linear-gradient(135deg, #2a2e72, #2a2e72);
    }

    .step-item.active .step-icon.step-2 {
        background: linear-gradient(135deg, #2a2e72, #2a2e72);
    }

    .step-item.active .step-icon.step-3 {
        background: linear-gradient(135deg, #2a2e72, #2a2e72);
    }

    .step-item.active .step-icon.step-4 {
        background: linear-gradient(135deg, #2a2e72, #2a2e72);
    }

    .step-item.active .step-icon.step-5 {
        background: linear-gradient(135deg, #2a2e72, #2a2e72);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .step-progress {
            margin: 20px 0 30px;
            /* padding: 0 10px; */
        }

        .step-icon {
            width: 50px;
            height: 50px;
            font-size: 16px;
        }

        .step-icon i {
            font-size: 20px;
        }

        .step-label {
            font-size: 12px;
            max-width: 80px;
        }

        .step-description {
            display: none;
        }

        .progress-line {
            top: 25px;
        }
    }

    /* Form Validation */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }

    .filepond--root {
        margin-bottom: 0;
    }

    .filepond--panel-root {
        border-radius: 0.25rem;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }

    /* Smooth collapse transition */
    .collapsing {
        transition: height 0.45s ease, opacity 0.35s ease;
    }

    .collapse:not(.show) {
        display: block;
        height: 0;
        overflow: hidden;
        opacity: 0;
    }

    .collapse.show {
        opacity: 1;
        transition: height 0.45s ease, opacity 0.35s ease;
    }

    #filterCollapse {
        will-change: height, opacity;
    }

    /* Custom Styles for Product View Modal */
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

    /* Card hover effects */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {

        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
    }

    @media (max-width: 768px) {
        .nav-tabs-custom {
            display: flex;
            justify-content: space-between;
        }

        .nav-tabs-custom .nav-item {
            flex: 1;
            /* Equal width */
            text-align: center;
        }

        .nav-tabs-custom .nav-link {
            padding: 8px 2px;
            font-size: 11px;
            white-space: nowrap;
        }

        .nav-tabs-custom .nav-link i {
            display: none;
            /* Hide icons on mobile */
        }
    }
</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Auction List</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Product Management</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Auction List</li>
            </ol>
        </div>
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item d-none">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listUsers"
                                            role="tab">
                                            Products List
                                        </a>
                                    </li>
                                    <li class="nav-item d-none" id="addProductTabWrapper">
                                        <a class="nav-link" id="addProductTab" data-bs-toggle="tab" href="#addUsers"
                                            role="tab">
                                            Add Products
                                        </a>
                                    </li>


                                </ul>

                                <!-- Right aligned filter button -->
                                <button id="filterToggleBtn" class="btn btn-outline-primary btn-sm ms-auto d-none"
                                    data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
                                    <i class="bx bx-filter-alt"></i>
                                </button>

                            </div>



                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="listUsers" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap w-100" id="auctionView">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Action</th>
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


                                <div class="tab-pane fade" id="addUsers" role="tabpanel">
                                    <form id="productForm" class="needs-validation" novalidate>
                                        @csrf

                                        <input type="hidden" name="remove_main_image" id="remove_main_image"
                                            value="0">

                                        <input type="hidden" name="remove_brochure" id="remove_brochure"
                                            value="0">
                                        <input type="hidden" name="remove_video" id="remove_video" value="0">
                                        <input type="hidden" name="removed_gallery_images" id="removed_gallery_images">



                                        <!-- Enhanced Progress Bar -->
                                        <div class="step-progress">
                                            <div class="progress-line">
                                                <div class="progress-fill" id="progressFill"></div>
                                            </div>

                                            <div class="progress-steps">
                                                <!-- Step 1 -->
                                                <div class="step-item active" data-step="1">
                                                    <div class="step-icon step-1">
                                                        <i class="bi bi-info-circle"></i>
                                                    </div>
                                                    <div class="step-label">Basic Info</div>
                                                    <div class="step-description">Product Details</div>
                                                </div>

                                                <!-- Step 2 -->
                                                <div class="step-item" data-step="2">
                                                    <div class="step-icon step-2">
                                                        <i class="bi bi-tags"></i>
                                                    </div>
                                                    <div class="step-label">Branding</div>
                                                    <div class="step-description">Categories & Brand</div>
                                                </div>

                                                <!-- Step 3 -->
                                                <div class="step-item" data-step="3">
                                                    <div class="step-icon step-3">
                                                        <i class="bi bi-palette"></i>
                                                    </div>
                                                    <div class="step-label">Design</div>
                                                    <div class="step-description">Appearance & Style</div>
                                                </div>

                                                <!-- Step 4 -->
                                                <div class="step-item" data-step="4">
                                                    <div class="step-icon step-4">
                                                        <i class="bi bi-shield-check"></i>
                                                    </div>
                                                    <div class="step-label">Features</div>
                                                    <div class="step-description">Specifications</div>
                                                </div>

                                                <!-- Step 5 -->
                                                <div class="step-item" data-step="5">
                                                    <div class="step-icon step-5">
                                                        <i class="bi bi-cart-plus"></i>
                                                    </div>
                                                    <div class="step-label">Business</div>
                                                    <div class="step-description">Inventory & Pricing</div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Step 1 -->
                                        <div class="step-content" id="step1">
                                            <div class="row">

                                                <!-- Product Type -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="productType" class="form-label">Product Type <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="productType"
                                                        name="product_type[]" multiple required>
                                                        <option value="">Select Product Type</option>
                                                        <option value="product">Product</option>
                                                        <option value="auction">Auction</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select product type.</div>
                                                </div>

                                                <!-- Gender -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="gender" class="form-label">Gender</label>
                                                    <select class="form-select" id="gender" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="unisex">Unisex</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Product Name -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="productName" class="form-label">Product Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="productName"
                                                        name="product_name" placeholder="Enter product name" required>
                                                    <div class="invalid-feedback">Please enter product name.</div>
                                                </div>

                                                <!-- Model Name -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="modelName" class="form-label">Model Name</label>
                                                    <input type="text" class="form-control" id="modelName"
                                                        name="model_name" placeholder="Enter model name">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Model Number -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="modelNumber" class="form-label">Model Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="modelNumber"
                                                        name="model_number" placeholder="Enter model number" required>
                                                    <div class="invalid-feedback">Please enter model number.</div>
                                                </div>

                                                <!-- Watch Ref Number -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="watchRefNumber" class="form-label">Watch Ref.
                                                        Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="watchRefNumber"
                                                        name="watch_ref_number" placeholder="Enter reference number"
                                                        required>
                                                    <div class="invalid-feedback">Please enter reference number.</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="brand" class="form-label">Brand <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="brand" name="brand_id"
                                                        required>
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brand_data as $brand)
                                                            <option value="{{ $brand->brand_id }}">
                                                                {{ $brand->brand_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select brand.</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="collection" class="form-label">Collection <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="collection"
                                                        name="collection" placeholder="Enter collection" required>
                                                    <div class="invalid-feedback">Please enter collection.</div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <!-- SKU -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="sku" class="form-label">SKU</label>

                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="sku"
                                                            name="sku"
                                                            placeholder="Enter SKU (Leave Empty For Auto-Generate)">

                                                        {{-- <button class="btn btn-primary" type="button"
                                                            id="generateSkuBtn">
                                                            <i class='bx bx-refresh'></i>
                                                        </button> --}}
                                                    </div>
                                                </div>


                                                <!-- Barcode Type -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="barcodeType" class="form-label">Barcode Type</label>
                                                    <select class="form-select" id="barcodeType" name="barcode_type">
                                                        <option value="">Select Barcode Type</option>
                                                        <option value="Code 128 (C128)">Code 128 (C128)</option>
                                                        {{-- <option value="Code 39 (C39)">Code 39 (C39)</option>
                                                        <option value="EAN-13">EAN-13</option>
                                                        <option value="EAN-8">EAN-8</option>
                                                        <option value="UPC-A">UPC-A</option>
                                                        <option value="UPC-E">UPC-E</option> --}}
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between mt-4">
                                                <div></div>
                                                <button type="button" class="btn btn-primary next-step"
                                                    data-next="2">
                                                    Next: Branding & Categories
                                                </button>
                                            </div>
                                        </div>


                                        <!-- Step 2 - Branding & Categories -->
                                        <div class="step-content" id="step2" style="display: none;">

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="watchCategory" class="form-label">Watch
                                                        Category</label>
                                                    <input type="text" class="form-control" id="watchCategory"
                                                        name="watch_category" placeholder="Enter watch category">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="category" class="form-label">Category <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="category" name="category"
                                                        required>
                                                        <option value="">Select Category</option>
                                                        <option value="Men-M">Men-M</option>
                                                        <option value="Unisex-Unisex">Unisex-Unisex</option>
                                                        <option value="Women-W">Women-W</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select category.</div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="calendarType" class="form-label">Calendar Type</label>
                                                    <input type="text" class="form-control" id="calendarType"
                                                        name="calendar_type" placeholder="Enter calendar type">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="watchType" class="form-label">Watch Type</label>
                                                    <select class="form-select" id="watchType" name="watch_type_id">
                                                        <option value="">Select Watch Type</option>
                                                        @foreach ($watchtype_data as $type)
                                                            <option value="{{ $type->wt_id }}">{{ $type->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="col-md-6 mb-3">
                                                    <label for="sportType" class="form-label">Sport Type</label>
                                                    <input type="text" class="form-control" id="sportType"
                                                        name="sport_type" placeholder="Enter sport type">
                                                </div> --}}
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="occasion" class="form-label">Occasion</label>
                                                    <input type="text" class="form-control" id="occasion"
                                                        name="occasion" placeholder="Enter occasion">
                                                </div>


                                            </div> --}}

                                            <div class="d-flex justify-content-between mt-4 gap-2">
                                                <button type="button" class="btn btn-primary prev-step"
                                                    data-prev="1">Previous</button>
                                                <button type="button" class="btn btn-primary next-step"
                                                    data-next="3">Next: Design & Appearance</button>
                                            </div>
                                        </div>


                                        <!-- Step 3 - Design & Appearance -->
                                        <div class="step-content" id="step3" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="dialType" class="form-label">Dial Type</label>
                                                    <input type="text" class="form-control" id="dialType"
                                                        name="dial_type" placeholder="Enter dial type">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="dial_color" class="form-label">Dial Colour</label>

                                                    <select class="form-select" name="dial_color" id="dial_color">
                                                        <option value="">Select Dial Color</option>

                                                        @foreach ($color_data as $color)
                                                            <option value="{{ $color->color_id }}">
                                                                {{ $color->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="col-md-4 mb-3">
                                                    <label for="dialDiameter" class="form-label">Dial Diameter
                                                        (mm)</label>
                                                    <input type="number" class="form-control" id="dialDiameter"
                                                        name="dial_diameter" step="0.1"
                                                        placeholder="Enter diameter in mm">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="caseShape" class="form-label">Case Shape</label>
                                                    <input type="text" class="form-control" id="caseShape"
                                                        name="case_shape" placeholder="Enter case shape">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="caseMaterial" class="form-label">Case Material</label>
                                                    <input type="text" class="form-control" id="caseMaterial"
                                                        name="case_material" placeholder="Enter case material">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="caseBack" class="form-label">Case Back</label>
                                                    <input type="text" class="form-control" id="caseBack"
                                                        name="case_back" placeholder="Enter case back type">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="strapMaterial" class="form-label">Strap
                                                        Material</label>
                                                    <input type="text" class="form-control" id="strapMaterial"
                                                        name="strap_material" placeholder="Enter strap material">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="strap_color" class="form-label">Strap Colour</label>

                                                    <select class="form-select" name="strap_color" id="strap_color">
                                                        <option value="">Select Color</option>

                                                        @foreach ($color_data as $color)
                                                            <option value="{{ $color->color_id }}">
                                                                {{ $color->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="glassMaterial" class="form-label">Glass
                                                        Material</label>
                                                    <select class="form-select" id="glassMaterial"
                                                        name="glass_material_id">
                                                        <option value="">Select Glass Material</option>
                                                        @foreach ($glassmaterial_data as $gm)
                                                            <option value="{{ $gm->gm_id }}">{{ $gm->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">


                                                <div class="col-md-4 mb-3">
                                                    <label for="bezel" class="form-label">Bezel</label>
                                                    <input type="text" class="form-control" id="bezel"
                                                        name="bezel" placeholder="Enter bezel type">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="bezelFunction" class="form-label">Bezel
                                                        Function</label>
                                                    <input type="text" class="form-control" id="bezelFunction"
                                                        name="bezel_function" placeholder="Enter bezel function">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="embellishment"
                                                        class="form-label">Embellishment</label>
                                                    <input type="text" class="form-control" id="embellishment"
                                                        name="embellishment" placeholder="Enter embellishment">
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-4 mb-3">
                                                    <label for="claspType" class="form-label">Clasp Type</label>
                                                    <input type="text" class="form-control" id="claspType"
                                                        name="clasp_type" placeholder="Enter clasp type">
                                                </div>

                                                {{-- <div class="col-md-4 mb-3 d-none">
                                                    <label for="color" class="form-label">Color</label>
                                                    <select class="form-select" name="color_id" id="color">
                                                        <option value="">Select Color</option>
                                                        @foreach ($color_data as $color)
                                                        <option value="{{ $color->color_id }}">
                                                            {{ $color->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}
                                            </div>



                                            <div class="d-flex justify-content-between mt-4 gap-2">
                                                <button type="button" class="btn btn-primary prev-step"
                                                    data-prev="2">Previous</button>
                                                <button type="button" class="btn btn-primary next-step"
                                                    data-next="4">Next: Features & Compliance</button>
                                            </div>
                                        </div>


                                        <!-- Step 4 - Features & Compliance -->
                                        <div class="step-content" id="step4" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="movement" class="form-label">Movement <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="movement" name="movement_id"
                                                        required>

                                                        @foreach ($movement_data as $mv)
                                                            <option value="{{ $mv->m_id }}">{{ $mv->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select movement type.</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="waterResistance" class="form-label">Water
                                                        Resistance</label>
                                                    <input type="text" class="form-control" id="waterResistance"
                                                        name="water_resistance" placeholder="e.g., 50m, 100m, 200m">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="functionality"
                                                        class="form-label">Functionality</label>
                                                    <textarea class="form-control" id="functionality" name="functionality" rows="3"
                                                        placeholder="Enter functionality such as Chronograph, Calendar, GMT, etc."></textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="brandwarranty" class="form-label">Brand
                                                        Warranty</label>
                                                    <select class="form-select" id="brandwarranty"
                                                        name="brand_warranty">
                                                        <option value="">Select option</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="serviceCard" class="form-label">Service Card</label>
                                                    <select class="form-select" id="serviceCard" name="service_card">
                                                        <option value="">Select option</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="warrantyCardYear" class="form-label">Year of
                                                        Card</label>
                                                    <input type="text" class="form-control" id="warrantyCardYear"
                                                        name="warranty_card_year" placeholder="Select year">
                                                </div>


                                                <div class="col-md-4 mb-3">
                                                    <label for="hasBox" class="form-label">Box</label>

                                                    <select id="hasBox" name="has_box" class="form-control">
                                                        <option value="">Select option</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>


                                                <div class="col-md-4 mb-3">
                                                    <label for="hasPapers" class="form-label">Papers</label>

                                                    <select id="hasPapers" name="has_papers" class="form-control">
                                                        <option value="">Select option</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>


                                                <div class="col-md-4 mb-3">
                                                    <label for="hsnCode" class="form-label">HSN Code</label>
                                                    <input type="text" class="form-control" id="hsnCode"
                                                        name="hsn_code" placeholder="Enter HSN code">
                                                </div>

                                            </div>

                                            <div class="row">


                                                <div class="col-md-4 mb-3">
                                                    <label for="unit" class="form-label">Unit <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="unit" name="unit"
                                                        required>
                                                        <option value="">Select Unit</option>
                                                        <option value="piece">Piece</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select unit.</div>
                                                </div>


                                                <div class="col-md-4 mb-3">
                                                    <label for="countryOrigin" class="form-label">Country of Origin
                                                        <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="countryOrigin"
                                                        name="country_of_origin_id" required>
                                                        <option value="">Select Country</option>
                                                        @foreach ($country_data as $country)
                                                            <option value="{{ $country->id }}">
                                                                {{ $country->name ?? $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select country of origin.
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="manufacturer" class="form-label">Manufacturer</label>
                                                    <select class="form-select" id="manufacturer"
                                                        name="manufacturer_id">

                                                        @foreach ($brand_data as $brand)
                                                            <option value="{{ $brand->brand_id }}">
                                                                {{ $brand->brand_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="row">

                                                <div class="col-md-4 mb-3">
                                                    <label for="packer" class="form-label">Packers</label>
                                                    <select class="form-control" id="packer" name="packer">
                                                        <option value="">Select packer</option>
                                                        <option value="Jay’s Watch Store Private Limited">
                                                            Jay’s Watch Store Private Limited
                                                        </option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="d-flex justify-content-between mt-4 gap-2">
                                                <button type="button" class="btn btn-primary prev-step"
                                                    data-prev="3">Previous</button>
                                                <button type="button" class="btn btn-primary next-step"
                                                    data-next="5">Next: Business & Inventory</button>
                                            </div>
                                        </div>


                                        <!-- Step 5 - Business & Inventory -->
                                        <div class="step-content" id="step5" style="display: none;">

                                            <!-- Condition & Purchase Date -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="condition" class="form-label">Condition <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="condition"
                                                        name="condition"
                                                        placeholder="Enter condition (e.g., New, Used, Refurbished)"
                                                        required>
                                                    <div class="invalid-feedback">Please enter product condition.</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="purchaseDate" class="form-label">Purchase Date</label>
                                                    <input type="text" class="form-control" id="purchaseDate"
                                                        name="purchase_date" placeholder="Select purchase date">
                                                </div>
                                            </div>

                                            <!-- Business Location & Warranty -->
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="displayLocation" class="form-label">Display
                                                        Location <span class="text-danger">*</span></label>
                                                    <select class="form-select select2" id="displayLocation"
                                                        name="display_location_id[]" multiple="multiple" required>

                                                        @foreach ($store_location as $location)
                                                            <option value="{{ $location->bl_id }}">
                                                                {{ $location->name }} - {{ $location->location_id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select display location.</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="physicalLocation" class="form-label">Physical
                                                        Location <span class="text-danger">*</span></label>
                                                    <select class="form-select select2" id="physicalLocation"
                                                        name="physical_location_id" required>
                                                        <option value="">Select Physical Location</option>
                                                        @foreach ($store_location as $location)
                                                            <option value="{{ $location->bl_id }}">
                                                                {{ $location->name }} - {{ $location->location_id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select physical location.
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="shopwarranty" class="form-label">Warranty</label>
                                                    <select id="shopwarranty" name="shop_warranty"
                                                        class="form-select">

                                                        <option value="6_months">6 Months</option>
                                                        <option value="1_year">1 Year</option>
                                                        <option value="2_year">2 Years</option>
                                                        <option value="Not Applicable">Not Applicable</option>
                                                    </select>
                                                </div>


                                                <div class="col-md-4 mb-3">
                                                    <label for="quantity" class="form-label">Quantity <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="quantity"
                                                        name="quantity" required min="0" value="1">
                                                    <div class="invalid-feedback">Please enter quantity.</div>
                                                </div>


                                            </div>

                                            <!-- Check Options -->
                                            <div class="row">
                                                @if (all_admin())
                                                    <div class="col-md-2 mb-3">
                                                        <div class="form-check mt-4">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="adminExclusive" name="admin_exclusive"
                                                                value="1">
                                                            <label class="form-check-label"
                                                                for="admin_exclusive">Admin
                                                                Exclusive Product</label>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-2 mb-3">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="newArrivals" name="new_arrival" value="1">
                                                        <label class="form-check-label" for="newArrivals">New
                                                            Arrivals</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="manageStock" name="manage_stock" value="1">
                                                        <label class="form-check-label" for="manageStock">Manage
                                                            Stock?</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" id="outOfStock" name="out_of_stock"
                                                            class="form-check-input" value="1">
                                                        <label for="outOfStock" class="form-check-label">Out of
                                                            Stock</label>
                                                    </div>
                                                </div>


                                                <div class="col-md-2 mb-3">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" id="notforselling"
                                                            name="not_for_selling" class="form-check-input"
                                                            value="1">
                                                        <label for="notforselling" class="form-check-label">Not For
                                                            Selling</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" id="tatacliqproduct"
                                                            name="tatacliqproduct" class="form-check-input"
                                                            value="1">
                                                        <label for="tatacliqproduct" class="form-check-label">Tata
                                                            Cliq Exlusive Product</label>
                                                    </div>


                                                </div>
                                            </div>



                                            <!-- Product Description -->
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="productDescription" class="form-label">Product
                                                        Description</label>
                                                    <textarea class="form-control text-justify" id="productDescription" name="description" rows="4"></textarea>
                                                </div>
                                            </div>

                                            <!-- Images, Gallery, Brochure -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Image</label>
                                                    <input type="file" id="productMainImage" name="main_image"
                                                        class="filepond" accept="image/*">
                                                    <small class="text-muted">(284px × 294px recommended)</small>
                                                    <div id="editMainImagePreview" class="mt-2"></div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Gallery Images</label>
                                                    <input type="file" id="productImages" name="gallery_images[]"
                                                        class="filepond" accept="image/*" multiple>
                                                    <div id="editGalleryPreview" class="mt-2 d-flex flex-wrap gap-2">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Brochure</label>
                                                    <input type="file" id="productBrochure" name="brochure"
                                                        class="filepond">
                                                    <div id="editBrochurePreview" class="mt-2"></div>
                                                </div>


                                                <!-- Video / IMEI -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Video Type</label>
                                                    <select id="videoType" name="video_type" class="form-select">

                                                        <option value="file">File</option>
                                                        <option value="youtube">YouTube Link</option>
                                                        <option value="vimeo">Vimeo Link</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" id="videoLabel">Video Source</label>

                                                    <div id="videoUrlWrapper">
                                                        <input type="url" id="videoLink" name="video_link_url"
                                                            class="form-control"
                                                            placeholder="Select video type first">
                                                    </div>

                                                    <div id="videoFileWrapper" class="d-none">
                                                        <input type="file" id="videoFile" name="video_link_file"
                                                            class="filepond" accept="video/*">
                                                    </div>

                                                    <div id="editVideoPreview" class="mt-2"></div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" id="enableIMEI" name="enable_imei"
                                                            class="form-check-input" value="1">
                                                        <label for="enableIMEI" class="form-check-label">
                                                            Enable Product Description / IMEI / Serial Number
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- Tax Configuration -->
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Applicable Tax</label>
                                                    <select id="applicableTax" name="tax_rate" class="form-select">
                                                        <option value="none">None</option>
                                                        <option value="5">GST 5%</option>
                                                        <option value="12">GST 12%</option>
                                                        <option value="18">GST 18%</option>
                                                        <option value="28">GST 28%</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Product Type</label>
                                                    <select id="productVariantType" name="variant_type"
                                                        class="form-select">
                                                        <option value="single">Single</option>
                                                        {{-- <option value="variable">Variable</option>
                                                        <option value="combo">Combo</option> --}}
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Selling Price Tax Type <span
                                                            class="text-danger">*</span></label>
                                                    <select id="sellingTaxType" name="selling_price_tax_type"
                                                        class="form-select">
                                                        <option value="exclusive">Exclusive</option>
                                                        <option value="inclusive">Inclusive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Purchase Type </label>
                                                    <select id="purchaseType" name="purchase_type"
                                                        class="form-select">
                                                        <option value="Approval">Approval</option>
                                                        <option value="Consignment">Consignment</option>
                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                        <option value="Exchange">Exchange</option>
                                                        <option value="N/A" selected>
                                                            None of the Above
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Pricing -->
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Default Purchase Price (Exc. Tax)</label>
                                                    <input type="number" id="purchaseExc"
                                                        name="purchase_price_exc_tax" class="form-control"
                                                        step="0.01">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Default Purchase Price (Inc. Tax)</label>
                                                    <input type="number" id="purchaseInc"
                                                        name="purchase_price_inc_tax" class="form-control"
                                                        step="0.01">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">% Margin</label>
                                                    <input type="number" id="margin" name="profit_margin"
                                                        value="25" class="form-control" step="0.01">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="price" class="form-label">Default Selling Price
                                                        (Exc. Tax)</label>
                                                    <input type="number" class="form-control" id="price"
                                                        name="selling_price_exc_tax" required min="0"
                                                        step="0.01">
                                                </div>
                                            </div>

                                            <hr>

                                            <h5 class="mb-3 text-primary">
                                                SEO Details
                                            </h5>
                                            <!-- Meta -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Meta Title</label>
                                                    <input type="text" id="metaTitle" name="meta_title"
                                                        class="form-control">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Meta Description</label>
                                                    <textarea id="metaDescription" name="meta_description" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="d-flex justify-content-between mt-4 gap-2">
                                                <button type="button" class="btn btn-primary prev-step"
                                                    data-prev="4">Previous</button>
                                                <button type="submit" id="saveProductBtn"
                                                    class="btn btn-success">Submit
                                                    Product</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="auctionViewModal" tabindex="-1" aria-labelledby="auctionViewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="auctionViewModalLabel">Product Details</h5>
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

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            function calculateSellingPrice() {

                let purchasePrice = parseFloat($("#purchaseExc").val()) || 0;
                let marginPercent = parseFloat($("#margin").val()) || 0;

                // ✅ Profit Margin Calculation
                let profitAmount = (purchasePrice * marginPercent) / 100;

                // ✅ Final Selling Price
                let sellingPrice = purchasePrice + profitAmount;

                // ✅ Set Selling Price Field
                $("#price").val(sellingPrice.toFixed(2));
            }

            // ✅ Sync Purchase Exc → Purchase Inc
            $("#purchaseExc").on("input", function() {
                $("#purchaseInc").val($(this).val());
                calculateSellingPrice();
            });

            // ✅ Sync Purchase Inc → Purchase Exc
            $("#purchaseInc").on("input", function() {
                $("#purchaseExc").val($(this).val());
                calculateSellingPrice();
            });

            // ✅ Update Selling Price when Margin Changes
            $("#margin").on("input", function() {
                calculateSellingPrice();
            });

        });
    </script>
    <script>
        let isEditing = false;

        let stockHistoryTable;

        let auctionView;
        $(document).ready(function() {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);

            function validateFileSize(fileItem, maxSizeMB, label) {
                const maxSizeBytes = maxSizeMB * 1024 * 1024;
                if (fileItem.fileSize > maxSizeBytes) {
                    iziToast.error({
                        title: 'File Too Large',
                        message: `${label} must be less than ${maxSizeMB}MB.`,
                        position: 'topRight'
                    });
                    return false;
                }
                return true;
            }

            const pondConfig = {
                storeAsFile: true,
                credits: false,
                labelIdle: 'Drag & Drop or <span class="filepond--label-action">Browse</span>'
            };

            window.mainPond = FilePond.create($('#productMainImage')[0], {
                ...pondConfig,
                acceptedFileTypes: ['image/*'],
                onaddfile: (err, fileItem) => {
                    if (!err && !validateFileSize(fileItem, 1, 'Product Image')) {
                        window.mainPond.removeFile(fileItem.id);
                    }
                }
            });
            window.galleryPond = FilePond.create($('#productImages')[0], {
                ...pondConfig,
                allowMultiple: true,
                acceptedFileTypes: ['image/*'],
                onaddfile: (err, fileItem) => {
                    if (!err && !validateFileSize(fileItem, 1, 'Gallery Image')) {
                        window.galleryPond.removeFile(fileItem.id);
                    }
                }
            });
            window.brochurePond = FilePond.create($('#productBrochure')[0], {
                ...pondConfig
            });
            window.videoPond = FilePond.create($('#videoFile')[0], {
                ...pondConfig,
                acceptedFileTypes: ['video/*'],
                onaddfile: (err, fileItem) => {
                    if (!err && !validateFileSize(fileItem, 3, 'Video File')) {
                        window.videoPond.removeFile(fileItem.id);
                    }
                }
            });

            // ─── Video Type Switch ─────────────────────────────────────────────────────
            const $vidType = $('#videoType');
            const $vidLabel = $('#videoLabel');
            const $urlWrap = $('#videoUrlWrapper');
            const $fileWrap = $('#videoFileWrapper');
            const $vidLink = $('#videoLink');

            function updateVideoInput() {
                const type = $vidType.val();
                $urlWrap.add($fileWrap).addClass('d-none');

                if (type === 'file') {
                    $vidLabel.text('Upload Video File');
                    $fileWrap.removeClass('d-none');
                } else if (type === 'youtube') {
                    $vidLabel.text('YouTube Link');
                    $urlWrap.removeClass('d-none');
                    $vidLink.attr('placeholder', 'https://youtube.com/...');
                } else if (type === 'vimeo') {
                    $vidLabel.text('Vimeo Link');
                    $urlWrap.removeClass('d-none');
                    $vidLink.attr('placeholder', 'https://vimeo.com/...');
                } else {
                    $vidLabel.text('Video Source');
                    $urlWrap.removeClass('d-none');
                }
            }

            $vidType.on('change', updateVideoInput);

            // ─── Stepper Logic ─────────────────────────────────────────────────────────
            let currentStep = 1;
            const $stepItems = $('.step-item');
            const $stepPanels = $('.step-content');
            const $progress = $('#progressFill');

            function goToStep(target, scroll = true) {
                if (target < 1 || target > 5) return;

                $('.step-content').hide();
                $(`#step${target}`).show();

                $('.step-item').removeClass('active completed');
                $('.step-item').each(function() {
                    const s = +$(this).data('step');
                    if (s < target) $(this).addClass('completed');
                    if (s === target) $(this).addClass('active');
                });

                $('#progressFill').css('width', ((target - 1) / 4 * 100) + '%');
                currentStep = target;

                if (scroll) {
                    document.querySelector(`#step${target}`)
                        .scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                }
            }

            $('#businessLocation').select2({
                placeholder: "Select Multiple Locations",
                allowClear: true,
                width: "100%"
            });

            $('#displayLocation').select2({
                placeholder: "Select Display Locations",
                allowClear: true,
                width: "100%"
            });

            $('#physicalLocation').select2({
                placeholder: "Select Physical Location",
                allowClear: true,
                width: "100%"
            });

            $('.next-step').on('click', function() {
                const next = +$(this).data('next');
                if (validateStep(currentStep)) goToStep(next);
            });

            $('.prev-step').on('click', function() {
                goToStep(+$(this).data('prev'));
            });

            $stepItems.on('click', function() {
                const step = +$(this).data('step');
                if (step <= currentStep) goToStep(step);
            });

            function validateStep(stepNum) {
                const $panel = $(`#step${stepNum}`);
                let valid = true;

                $panel.find('[required]').each(function() {
                    if (!this.value.trim()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                return valid;
            }

            // ─── Form Reset Helper ─────────────────────────────────────────────────────
            function resetFormFully() {
                const $form = $('#productForm');

                $form[0].reset();
                $form.removeClass('was-validated');
                $form.find('.is-invalid').removeClass('is-invalid');

                $form.find('select').val(null).trigger('change');

                mainPond?.removeFiles();
                galleryPond?.removeFiles();
                brochurePond?.removeFiles();
                videoPond?.removeFiles();

                $('.dynamic-preview').remove();

                goToStep(1, false);

                $('#quantity').val(1).prop('readonly', false);
                $('#outOfStock').prop('checked', false);

                $vidType.val('').trigger('change');
                $('#purchaseType').val('N/A').trigger('change');
            }

            // ─── Quantity ↔ Out of Stock Logic ─────────────────────────────────────────
            $('#outOfStock').on('change', function() {
                const $qty = $('#quantity');
                if (this.checked) {
                    $qty.val(0).prop('readonly', true);
                } else {
                    $qty.val(1).prop('readonly', false);
                }
            });

            // ─── Select2 & flatpickr Initialization ────────────────────────────────────
            // Product Type
            $('#productType').select2({
                placeholder: "Select Product Type",
                allowClear: true,
                width: "100%"
            });

            // Gender
            $('#gender').select2({
                placeholder: "Select Gender",
                allowClear: true,
                width: "100%"
            });

            // Barcode Type
            $('#barcodeType').select2({
                placeholder: "Select Barcode Type",
                allowClear: true,
                width: "100%"
            });

            // Brand
            $('#brand').select2({
                placeholder: "Select or Enter Brand",
                allowClear: true,
                width: "100%",
                tags: true
            });

            // WatchType
            $('#watchType').select2({
                placeholder: "Select or Enter Watch Type",
                allowClear: true,
                width: "100%",
                tags: true
            });


            // Strap Color
            $('#strap_color').select2({
                placeholder: "Select or Enter Strap Colour",
                allowClear: true,
                width: "100%",
                tags: true
            });

            // Dial Color
            $('#dial_color').select2({
                placeholder: "Select or Enter Dial Colour",
                allowClear: true,
                width: "100%",
                tags: true
            });

            // Category
            $('#category').select2({
                placeholder: "Select Category",
                allowClear: true,
                width: "100%"
            });


            // Glass Material
            $('#glassMaterial').select2({
                placeholder: "Select or Enter Glass Material",
                allowClear: true,
                width: "100%",
                tags: true
            });

            //Movement
            $('#movement').select2({
                placeholder: "Select or Enter Movement",
                allowClear: true,
                width: "100%",
                tags: true
            });

            //Movement
            $('#manufacturer').select2({
                placeholder: "Select or Enter Manufacturer",
                allowClear: true,
                width: "100%",
                tags: true
            });


            $('#brandwarranty').select2({
                placeholder: "Select Brand Warranty",
                allowClear: true,
                width: "100%"
            });

            $('#serviceCard').select2({
                placeholder: "Select Service Card",
                allowClear: true,
                width: "100%"
            });


            $('#hasBox').select2({
                placeholder: "Select Option",
                allowClear: true,
                width: "100%"
            });

            $('#hasPapers').select2({
                placeholder: "Select Option",
                allowClear: true,
                width: "100%"
            });

            $('#unit').select2({
                placeholder: "Select Unit",
                allowClear: true,
                width: "100%"
            });

            $('#countryOrigin').select2({
                placeholder: "Select Country",
                allowClear: true,
                width: "100%"
            });


            $('#packer').select2({
                placeholder: "Select Packer",
                allowClear: true,
                width: "100%"
            });

            $('#shopwarranty').select2({
                placeholder: "Select Shop Warranty",
                allowClear: true,
                width: "100%"
            });

            $('#applicableTax').select2({
                placeholder: "Select Tax",
                allowClear: true,
                width: "100%"
            });


            $('#productVariantType').select2({
                placeholder: "Select Porduct Variant",
                allowClear: true,
                width: "100%"
            });

            $('#sellingTaxType').select2({
                placeholder: "Select Selling Price Tax",
                allowClear: true,
                width: "100%"
            });

            $('#purchaseType').select2({
                placeholder: "Select Purchase Type",
                allowClear: true,
                width: "100%"
            });



            $('#videoType').select2({
                placeholder: "Select Video Type",
                allowClear: true,
                width: "100%"
            });

            $('#filter_business_location').select2({
                placeholder: "Select Location Filter",
                allowClear: true,
                width: "100%"
            });


            $('#filter_brand').select2({
                placeholder: "Select Filter Brand",
                allowClear: true,
                width: "100%"
            });

            $('#filter_stock').select2({
                placeholder: "Select Filter Stock",
                allowClear: true,
                width: "100%"
            });








            flatpickr("#purchaseDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                maxDate: "today",
                allowInput: true
            });


            const warrantyPicker = flatpickr("#warrantyCardYear", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                allowInput: true
            });


            $(document).on('click', '.remove-main-image', function() {
                $('#remove_main_image').val('1');
                $(this).closest('.dynamic-preview').remove();
            });
            let removedGalleryImages = [];

            $(document).on('click', '.remove-gallery-image', function() {
                const img = $(this).data('image');

                removedGalleryImages.push(img);
                $('#removed_gallery_images').val(JSON.stringify(removedGalleryImages));

                $(this).closest('.dynamic-gallery-item').remove();
            });

            $(document).on('click', '.remove-brochure', function() {
                $('#remove_brochure').val('1');
                $(this).closest('.dynamic-preview').remove();
            });

            $(document).on('click', '.remove-video', function() {
                $('#remove_video').val('1');
                videoPond?.removeFiles();
                $('#videoLink').val('');
                $(this).closest('.dynamic-preview').remove();
            });


            // ─── Form Submit (Add + Update) ────────────────────────────────────────────
            $('#productForm').on('submit', function(e) {
                e.preventDefault();


                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    for (let i = 1; i <= 5; i++) {
                        if (!validateStep(i)) {
                            goToStep(i);
                            return;
                        }
                    }
                }

                const $btn = $('#saveProductBtn');
                const originalHTML = $btn.html();

                const proId = $('#edit_pro_id').val();

                $btn.prop('disabled', true).html('Saving...');

                const fd = new FormData(this);

                // FilePond files
                if (mainPond.getFiles().length) fd.set('pro_image', mainPond.getFiles()[0].file);
                galleryPond.getFiles().forEach(f => fd.append('pro_gallery[]', f.file));
                if (brochurePond.getFiles().length) fd.set('brochure', brochurePond.getFiles()[0].file);

                // Video
                const vType = $vidType.val();
                if (vType === 'file' && videoPond.getFiles().length) {
                    fd.set('video_link', videoPond.getFiles()[0].file);
                } else if (vType && $vidLink.val().trim()) {
                    fd.set('video_link', $vidLink.val().trim());
                }

                // Checkboxes
                fd.append('admin_exclusive', $('#adminExclusive').is(':checked') ? '1' : '0');
                fd.append('new_arrival', $('#newArrivals').is(':checked') ? '1' : '0');
                fd.append('manage_stock', $('#manageStock').is(':checked') ? '1' : '0');
                fd.append('out_of_stock', $('#outOfStock').is(':checked') ? '1' : '0');
                fd.append('not_for_selling', $('#notforselling').is(':checked') ? '1' : '0');
                fd.append('tatacliqproduct', $('#tatacliqproduct').is(':checked') ? '1' : '0');
                fd.append('enable_imei', $('#enableIMEI').is(':checked') ? '1' : '0');


                $.ajax({
                    url: "{{ route('product.store') }}",
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {

                            iziToast.success({
                                title: 'Success',
                                message: res.message,
                                position: 'topRight'
                            });

                            // 🔥 AUCTION REDIRECT
                            if (res.redirect) {
                                setTimeout(() => {
                                    window.location.href = res.redirect;
                                }, 800);
                                return;
                            }

                            // NORMAL PRODUCT FLOW
                            resetFormFully();

                            new bootstrap.Tab(document.querySelector('a[href="#listUsers"]'))
                                .show();

                            setTimeout(() => {
                                pendingProductTable.ajax.reload(null, false);
                            }, 400);

                            $('#pendingProductTable').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalHTML);
                    }
                });
            });



            var auctionView = $('#auctionView').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('auction.details') }}",
                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },

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

                            // UI display
                            if (type === 'display') {
                                return data;
                            }

                            // CSV & Excel → image URL
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
                    }
                ],

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

                buttons: [

                    // COPY → remove image column (index 1)
                    {
                        extend: 'copyHtml5',
                        text: '<i class="bx bx-copy"></i> Copy',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },

                    // CSV → include image column (URL)
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bx bx-file"></i> Export to CSV',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            orthogonal: 'export'
                        }
                    },

                    // EXCEL → include image column (URL)
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bx bx-spreadsheet"></i> Export to Excel',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            orthogonal: 'export'
                        }
                    },

                    // PRINT → remove image column
                    {
                        extend: 'print',
                        text: '<i class="bx bx-printer"></i> Print',
                        className: 'dt-btn-light',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },

                    // COLUMN VISIBILITY (keep image controllable in UI)
                    {
                        extend: 'colvis',
                        text: '<i class="bx bx-columns"></i> Column visibility',
                        className: 'dt-btn-light'
                    },

                    // PDF → remove image column
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bx bx-file-blank"></i> Export to PDF',
                        className: 'dt-btn-light',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        customize: function(doc) {
                            doc.pageMargins = [10, 10, 10, 10];
                            var table = doc.content[1].table;
                            table.widths = Array(table.body[0].length).fill('*');
                        }
                    }
                ]
            });


            function formatIndianDate(dateStr) {
                if (!dateStr) return '-';

                const [year, month, day] = dateStr.split('-');
                return `${day}-${month}-${year}`;
            }



            // View product modal
            // View product modal
            $(document).on('click', '.viewProduct', function() {
                var id = $(this).data('id');
                var modalContent = $('#viewModalContent');

                // Show Modal & Spinner
                $('#auctionViewModal').modal('show');
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
    <label class="form-label text-muted small mb-1">
        Product Type
    </label>

 <div class="fw-medium">
    <ul class="mb-0 ps-3" style="list-style-type: disc;">
        ${
            checkNull(d.pro_type)
            .split(',')
            .map(item => `<li>${item.trim().toUpperCase()}</li>`)
            .join('')
        }
    </ul>
</div>
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
                                            <div>${yesNoBadge(d.box)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Papers</label>
                                            <div>${yesNoBadge(d.paper)}</div>
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
    <label class="form-label text-muted small mb-1">
        Locations ${
            d.location_name
            ? `(${d.location_name.split(",").length})`
            : "(0)"
        }
    </label>

    <ol class="mb-0 ps-3">
        ${
            d.location_name
                ? d.location_name
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
                                                    <label class="form-label text-muted small mb-1">Purchase Type</label>
                                                    <div class="fw-medium">${checkNull(d.purchase_type)}</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Purchase Price</label>
                                                    <div class="fw-medium">${formatPrice(d.purchase_price_exclusive)}</div>
                                                </div>

 <div class="col-md-3">
    <label class="form-label text-muted small mb-1">Purchase Date</label>
    <div class="fw-medium">
        ${d.purchase_date
            ? new Date(d.purchase_date).toLocaleDateString('en-GB')
            : '-'}
    </div>
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




            // Edit product
            $(document).on('click', '.editAuction', function() {
                isEditing = true;
                var id = $(this).data('id');
                var url = "{{ route('product.edit', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response.status === 200) {
                            var d = response.data;

                            $('#addProductTabWrapper').removeClass('d-none');
                            var tabTrigger = document.querySelector('a[href="#addUsers"]');
                            var tab = new bootstrap.Tab(tabTrigger);
                            tab.show();
                            goToStep(1, false);

                            $('#addProductTab').text('Edit Product');


                            $('#productForm')[0].reset();
                            $('#productForm select').val(null).trigger('change');

                            $('#edit_pro_id').remove();
                            $('.dynamic-preview').remove();


                            $('#productForm').append(
                                '<input type="hidden" id="edit_pro_id" name="pro_id" value="' +
                                d.pro_id + '">');

                            $('#saveProductBtn').text('Update Product');


                            var baseUrl = "{{ $actual_url . '/admin_assets/brand/' }}" + d
                                .brand_folder + "/" + d.product_folder + "/";


                            if (d.pro_image) {
                                var imgUrl = baseUrl + "image/" + d.pro_image;
                                var imgHtml = `
                                    <div class="dynamic-preview mt-2">
                                        <label class="small text-muted d-block mb-1">Current Image:</label>
                                        <div class="position-relative d-inline-block">
                                            <a href="${imgUrl}" target="_blank" title="View Full Image">
                                                <img src="${imgUrl}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                            </a>
      <button type="button"
    class="btn btn-danger btn-sm remove-main-image">
    <i class="bi bi-x"></i>
</button>
                                        </div>
                                    </div>`;
                                $('#productMainImage').after(imgHtml);
                            }


                            if (d.pro_gallery) {
                                var galleryImages = d.pro_gallery.split(',');
                                var galHtml =
                                    '<div class="dynamic-preview mt-2"><label class="small text-muted d-block mb-1">Current Gallery:</label><div class="d-flex flex-wrap gap-3">';

                                galleryImages.forEach(function(img) {
                                    var gUrl = baseUrl + "gallery/" + img;
                                    galHtml += `
        <div class="position-relative dynamic-gallery-item">
            <a href="${gUrl}" target="_blank">
                <img src="${gUrl}" style="width:60px;height:60px;object-fit:cover;">
            </a>
            <button type="button"
                class="btn btn-danger btn-sm remove-gallery-image"
                data-image="${img}">
                <i class="bi bi-x"></i>
            </button>
        </div>`;
                                });


                                galHtml += '</div></div>';
                                $('#productImages').after(galHtml);
                            }

                            // C. BROCHURE
                            if (d.pro_brochure) {
                                var brochureHtml = `
        <div class="dynamic-preview mt-2 position-relative">
            <a href="${baseUrl}brochure/${d.pro_brochure}"
               target="_blank"
               class="text-info text-decoration-none d-inline-block">
                <i class="bi bi-file-earmark-arrow-down"></i> View Current Brochure
            </a>

            <button type="button"
                class="btn btn-danger btn-sm remove-brochure position-absolute"
                style="top:-6px; right:-6px;">
                <i class="bi bi-x"></i>
            </button>
        </div>`;
                                $('#productBrochure').after(brochureHtml);
                            }

                            // D. VIDEO
                            // Trigger change first to ensure input type matches (file vs url)
                            // D. VIDEO (FIXED)
                            $('#videoType').val(d.video_type).trigger('change');

                            if (d.video_source) {
                                let videoHtml = `
        <div class="dynamic-preview mt-2 position-relative">
            <button type="button"
                class="btn btn-danger btn-sm remove-video position-absolute"
                style="top:-6px; right:-6px;">
                <i class="bi bi-x"></i>
            </button>
    `;

                                if (d.video_type === 'file') {
                                    videoHtml += `
            <label class="small text-muted d-block mb-1">Current Video:</label>
            <video controls class="rounded border" style="width: 220px; max-height: 140px;">
                <source src="${baseUrl}video/${d.video_source}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
                                } else {
                                    $('#videoLink').val(d.video_source);
                                    videoHtml += `
            <a href="${d.video_source}" target="_blank" class="text-primary small">
                <i class="bi bi-play-circle"></i> Open Video Link
            </a>
        `;
                                }

                                videoHtml += `</div>`;

                                // 🔥 append to correct visible wrapper
                                if (d.video_type === 'file') {
                                    $('#videoFileWrapper').after(videoHtml);
                                } else {
                                    $('#videoUrlWrapper').after(videoHtml);
                                }
                            }

                            // -----------------------------------------------------------

                            // 4. Populate Standard Fields
                            var proType = d.pro_type;

                            $('#productType')
                                .val(d.pro_type.split(','))
                                .trigger('change');
                            $('#gender').val(d.pro_gender).trigger('change');
                            $('#productName').val(d.pro_name);
                            $('#modelName').val(d.pro_model_name);
                            $('#modelNumber').val(d.pro_model);
                            $('#watchRefNumber').val(d.pro_ref_num);
                            $('#sku').val(d.pro_sku);
                            $('#barcodeType').val(d.barcode_type).trigger('change');
                            $('#purchaseType').val(d.purchase_type).trigger('change');

                            $('#brand').val(d.brand).trigger('change');
                            $('#collection').val(d.collection);
                            $('#watchCategory').val(d.watch_category);
                            $('#category').val(d.category).trigger('change');
                            $('#calendarType').val(d.calendar_type);
                            // $('#sportType').val(d.sport_type);
                            // $('#occasion').val(d.occasion);
                            $('#watchType').val(d.watch_type).trigger('change');

                            $('#dialType').val(d.dial_type);
                            $('#dial_color').val(d.dial_colour).trigger('change');
                            $('#dialDiameter').val(d.dial_diameter);
                            $('#caseShape').val(d.case_shape);
                            $('#caseMaterial').val(d.case_material);
                            $('#caseBack').val(d.case_back);
                            $('#strapMaterial').val(d.strap_material);
                            $('#strap_color').val(d.strap_colour).trigger('change');
                            $('#glassMaterial').val(d.glass_material).trigger('change');
                            $('#bezel').val(d.bezel);
                            $('#bezelFunction').val(d.bezel_function);
                            $('#embellishment').val(d.embellishment);
                            $('#claspType').val(d.clasp_type);
                            $('#color').val(d.color).trigger('change');

                            $('#movement').val(d.movement).trigger('change');
                            $('#waterResistance').val(d.water_resistance);
                            $('#functionality').val(d.functionality);

                            $('#brandwarranty').val(d.brand_warranty == 0 ? 'yes' : 'no')
                                .trigger('change');
                            $('#serviceCard').val(d.service_card == 1 ? 'yes' : 'no').trigger(
                                'change');
                            warrantyPicker.setDate(d.year_of_card, true);

                            $('#hasBox').val(d.box).trigger('change');
                            $('#hasPapers').val(d.paper).trigger('change');
                            $('#hsnCode').val(d.hsn_code);
                            $('#unit').val(d.unit).trigger('change');
                            $('#countryOrigin').val(d.origin_country).trigger('change');
                            $('#manufacturer').val(d.manufacturer).trigger('change');
                            $('#packer').val(d.packers).trigger('change');

                            $('#condition').val(d.condition);
                            if (d.purchase_date) {
                                var purchaseDateInput = document.querySelector("#purchaseDate");
                                if (purchaseDateInput && purchaseDateInput._flatpickr) {
                                    purchaseDateInput._flatpickr.setDate(d.purchase_date);
                                } else {
                                    $('#purchaseDate').val(d.purchase_date);
                                }
                            }
                            // if (d.business_location) {
                            //     let locArray = d.business_location.split(',').filter(function(
                            //         val) {
                            //         return val !== null && val !== "" && val !==
                            //             undefined;
                            //     });
                            //     $('#businessLocation').val(locArray).trigger('change');
                            // } else {
                            //     $('#businessLocation').val(null).trigger('change');
                            // }
                            if (d.display_location) {
                                let displayLocArray = d.display_location.split(',').filter(
                                    function(val) {
                                        return val !== null && val !== "" && val !==
                                            undefined;
                                    });
                                $('#displayLocation').val(displayLocArray).trigger('change');
                            } else {
                                $('#displayLocation').val(null).trigger('change');
                            }

                            // ✅ NEW: Populate Physical Location
                            $('#physicalLocation').val(d.physical_location).trigger('change');
                            $('#shopwarranty').val(d.shop_warranty).trigger('change');
                            $('#quantity').val(d.quantity);

                            $('#adminExclusive').prop('checked', d.admin_exclusive == 1);
                            $('#newArrivals').prop('checked', d.new_arrival == 1);
                            $('#manageStock').prop('checked', d.manage_stock == 1);
                            $('#outOfStock').prop('checked', d.out_stock == 1);
                            $('#notforselling').prop('checked', d.not_for_selling == 1);
                            $('#tatacliqproduct').prop('checked', d.tata_cliq_product == 1);
                            $('#enableIMEI').prop('checked', d.enable_imei == 1);

                            $('#productDescription').val(d.product_desc);

                            $('#applicableTax').val(d.pro_tax).trigger('change');
                            $('#productVariantType').val(d.product_type).trigger('change');
                            $('#sellingTaxType').val(d.selling_tax_type).trigger('change');
                            $('#purchaseExc').val(d.purchase_price_exclusive);
                            $('#purchaseInc').val(d.purchase_price_inclusive);
                            $('#margin').val(d.pro_margin);
                            $('#price').val(d.selling_price_exclusive);

                            $('#metaTitle').val(d.meta_title);
                            $('#metaDescription').val(d.meta_description);

                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });
                    }
                });
            });




            $('a[href="#addUsers"]').on('shown.bs.tab', function() {
                $('#filterCollapse').collapse('hide');
                $('#filterToggleBtn').addClass('d-none');
                if (!isEditing) {
                    resetFormFully();
                    goToStep(1, false);
                }

                // Hide filter panel

            });

            $('a[href="#listUsers"]').on('shown.bs.tab', function() {
                isEditing = false;
                $('#filterCollapse').collapse('show');
                $('#filterToggleBtn').removeClass('d-none');
                $('#addProductTab').text('Add Products');
                setTimeout(function() {
                    if ($.fn.DataTable.isDataTable('#pendingProductTable')) {
                        pendingProductTable.columns.adjust();
                        pendingProductTable.draw(false);
                    }
                }, 400);

            });


            $(document).on('click', '.deleteAuction', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: 'Are you sure?',
                    html: `You are about to delete <strong>${name}</strong>.<br>This action cannot be undone.`,
                    icon: 'warning',
                    iconColor: '#d33',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('product.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(res) {
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });

                                    pendingProductTable.ajax.reload(null, false);
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete product'
                                });
                            }
                        });
                    }
                });
            });


        });
    </script>
</body>

</html>
