<!DOCTYPE html>
<html lang="en">


@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        /* =========================
   GENERAL
========================= */
        /* a.page-link.pagination125 {
            display: none;
        }

        a.page-link.one-link {
            color: #000 !important;
            font-weight: 400;
        }

        .page-link {
            background: transparent !important;
        } */

        .pagination-bar {
            margin-top: 30px;
        }

        .pagination-modern {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .pagination-info {
            font-size: 14px;
            color: #555;
        }

        .custom-pagination-modern {
            display: flex;
            list-style: none;
            gap: 8px;
            padding: 0;
            margin: 0;
        }

        .custom-pagination-modern li a,
        .custom-pagination-modern li span {
            min-width: 42px;
            height: 42px;
            padding: 0 16px;

            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background: #f5f5f5;
            color: #222;
            font-size: 14px;

            transition: 0.3s;
        }

        .custom-pagination-modern li.active a {
            background: #212529 !important;
            color: #fff !important;
        }

        .custom-pagination-modern li a:hover {
            background: #e9e9e9;
        }

        .custom-pagination-modern li.disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .pagination-modern {
                justify-content: center;
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .pagination-info {
                width: 100%;
                font-size: 13px;
                text-align: center;
            }

            .custom-pagination-modern {
                justify-content: center;
                flex-wrap: wrap;
                gap: 6px;
                width: 100%;
            }

            .custom-pagination-modern li a,
            .custom-pagination-modern li span {
                min-width: 38px;
                height: 38px;
                padding: 0 10px;
                font-size: 13px;
            }
        }

        .feature-image {
            border: 12px solid #fff;
            border-top: 0;
            border-bottom: 0;
        }

        /* =========================
   PRODUCT CARD
========================= */
        .product-card img {
            width: 100%;
            max-width: 294px;
            height: 294px;
            margin: 0 auto;
            object-fit: contain;
        }

        /* =========================
   WISHLIST HEART
========================= */
    .wishlist-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 6px 8px;
    cursor: pointer;
    z-index: 10;
    -webkit-tap-highlight-color: transparent;
}

.heart-icon {
    fill: transparent;
    stroke: #999;
    stroke-width: 2;
    transition: fill 0.3s ease, stroke 0.3s ease, transform 0.25s ease;
    pointer-events: none;
}

/* Active state */
.wishlist-icon.active .heart-icon {
    fill: red;
    stroke: red;
    animation: heartPop 0.3s ease;
}

/* Hover only on real pointer devices (not mobile touch) */
@media (hover: hover) {
    .wishlist-icon:hover .heart-icon {
        fill: red;
        stroke: red;
    }
}

/* Force empty heart when NOT active — overrides stuck touch hover on mobile */
.wishlist-icon:not(.active) .heart-icon {
    fill: transparent !important;
    stroke: #999 !important;
}

@keyframes heartPop {
    0%   { transform: scale(1); }
    50%  { transform: scale(1.3); }
    100% { transform: scale(1.1); }
}



        /* =========================
   PAGINATION
========================= */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .custom-pagination {
            display: flex;
            list-style: none;
            gap: 8px;
            padding: 0;
        }

        .custom-pagination li a,
        .custom-pagination li span {
            min-width: 42px;
            height: 42px;
            padding: 0 12px;

            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            text-decoration: none;
            background: #f2f2f2;
            color: #333;
            transition: 0.3s;
        }

        .custom-pagination li.active a,
        .custom-pagination li a:hover {
            background: #212529;
            color: #fff !important;
        }

        .custom-pagination li.disabled span {
            background: #ddd;
            color: #777;
            cursor: not-allowed;
        }



        .luxury-price-filter {
            padding: 20px;
            border: 1px solid #ececec;
            background: #fff;
            min-height: 170px;
        }

        .price-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #111;
        }

        .slider-wrapper {
            position: relative;
            width: 100%;
            height: 45px;
        }

        .slider-track,
        .slider-range {
            position: absolute;
            top: 15px;
            height: 6px;

        }

        .slider-track {
            width: 100%;
            background: #e8dfd7;
            z-index: 1;
        }

        .slider-range {
            background: #000;
            z-index: 2;
        }

        .slider-wrapper input[type="range"] {
            position: absolute;
            width: 100%;
            top: 5px;
            left: 0;
            background: none;
            pointer-events: none;
            appearance: none;
            -webkit-appearance: none;
            z-index: 3;
        }

        .slider-wrapper input[type="range"]::-webkit-slider-thumb {
            pointer-events: auto;
            appearance: none;
            -webkit-appearance: none;
            width: 24px;
            height: 24px;
            background: #000;
            cursor: pointer;
            border: none;
        }

        .slider-wrapper input[type="range"]::-moz-range-thumb {
            pointer-events: auto;
            width: 24px;
            height: 24px;
            background: #000;
            border: none;
            cursor: pointer;
        }

        .price-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .price-boxes span {
            background: #e8dfd7;
            padding: 10px 18px;

            font-size: 15px;

            color: #222;
        }



        /* =========================
   TOP FILTER BAR
========================= */
        .mobile-filter-wrapper {
            max-width: 320px;
            background: #fff;
        }

        .filter-toggle-head {
            display: flex;
            align-items: self-start;
            justify-content: center;
        }

        .filter-left {
            cursor: pointer;
        }

        /* =========================
   FILTER SWITCH
========================= */
        .filter-switch {
            position: relative;
            width: 45px;
            height: 22px;
        }

        .filter-switch input {
            display: none;
        }

        .slider-switch {
            position: absolute;
            inset: 0;
            background: #222;
            /* border-radius: 30px; */
            cursor: pointer;
        }

        .slider-switch::before {
            content: "";
            position: absolute;
            width: 18px;
            height: 18px;
            background: #fff;
            top: 2px;
            left: 2px;
            /* border-radius: 50%; */
            transition: 0.3s;
        }

        .filter-switch input:checked+.slider-switch::before {
            transform: translateX(23px);
        }

        /* =========================
   SORT DROPDOWN
========================= */
        .filter-item {
            position: relative;
            cursor: pointer;
            user-select: none;

        }

        .filter-item .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto !important;
            min-width: 220px;
            max-width: calc(100vw - 20px);
            width: max-content;
            max-height: 260px;
            overflow-y: auto;
            z-index: 9999;
            white-space: nowrap;
            box-sizing: border-box;
            display: none;
            padding: 10px 0;
            border: 1px solid #eee;
            background: #fff;

            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }

        .filter-item .dropdown-menu li {
            padding: 10px 14px;
            gap: 15px;
        }

        /* =========================
   SIDEBAR FILTER
========================= */
        .vertical-filter-panel {
            display: block;
        }

        .filter-box {
            border: 1px solid #eee;
            margin-bottom: 12px;

            overflow: hidden;
        }

        .filter-box-title {
            padding: 14px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;

            background: #fff;
        }

        .filter-box-body {
            display: none;
            padding: 15px;
            border-top: 1px solid #eee;
            max-height: 220px;
            overflow-y: auto;
            background: #fff;
        }

        .filter-check-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        /* =========================
   PRICE RANGE
========================= */
        .slider-wrapper {
            position: relative;
            width: 100%;
            height: 45px;
        }

        .slider-track,
        .slider-range {
            position: absolute;
            top: 15px;
            height: 6px;

        }

        .slider-track {
            width: 100%;
            background: #e8dfd7;
            z-index: 1;
        }

        .slider-range {
            background: #000;
            z-index: 2;
        }

        .slider-wrapper input[type="range"] {
            position: absolute;
            width: 100%;
            top: 5px;
            left: 0;
            background: none;
            pointer-events: none;
            appearance: none;
            -webkit-appearance: none;
            z-index: 3;
        }

        .slider-wrapper input[type="range"]::-webkit-slider-thumb,
        .slider-wrapper input[type="range"]::-moz-range-thumb {
            pointer-events: auto;
            width: 24px;
            height: 24px;
            background: #000;
            border: none;
            cursor: pointer;
        }

        .price-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .price-boxes span {
            background: #e8dfd7;
            padding: 10px 18px;

            font-size: 14px;

            color: #222;
        }

        /* =========================
   RESPONSIVE
========================= */
        @media (max-width: 768px) {
            .filter-item .dropdown-menu {
                min-width: 180px;
                max-width: 90vw;
                font-size: 14px;
            }

            .product-card img {
                height: 220px;
            }

            .price-boxes span {
                font-size: 13px;
                padding: 8px 12px;
            }
        }

        .custom-filter-bars {
            display: inline-block;
            width: 20px;
            height: 14px;
            position: relative;
        }

        .custom-filter-bars::before,
        .custom-filter-bars::after,
        .custom-filter-bars {
            background: transparent;
        }

        .custom-filter-bars::before,
        .custom-filter-bars::after {
            content: "";
            position: absolute;
            right: 0;
            height: 2px;
            background: #000;

        }

        .custom-filter-bars::before {
            top: 0;
            width: 18px;
        }

        .custom-filter-bars::after {
            top: 6px;
            width: 12px;
        }

        .custom-filter-bars span {
            position: absolute;
            top: 12px;
            right: 0;
            width: 16px;
            height: 2px;
            background: #000;

        }

        input[type="radio"] {
            accent-color: #212529;
        }
    </style>

    <div class="desktop all-bg">
        <img src="{{ $actual_url . '/front/img/allwatches/allwatchmobile.webp' }}" />
    </div>
    <div class="mobile all-bg">
        <img src="{{ $actual_url . '/front/img/allwatches/allwatch.webp' }}" />
    </div>

    <section>
        <div class="category-main">
            <div class="container">
                <div class="features-title text-center mb-4">
                    {{-- change here --}}
                    <h3 class="all-title">ALL WATCHES</h3>
                </div>

                <div class="row mb-4 align-items-center">

                    <!-- LEFT : FILTER TOGGLE -->
                    <div class="col-lg-6 col-6">
                        <div class="mobile-filter-wrapper">
                            <div class="filter-toggle-head mb-0">
                                <div class="filter-left" id="filterToggleBtn">
                                    <i class="fa fa-filter custom-filter-icon"></i>
                                    <span>FILTERS</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT : SORT -->
                    <div class="col-lg-6 col-6 text-end">
                        @php
                            $sortLabels = [
                                'BESTSELLING' => 'BEST SELLING',
                                'NEWARRIVAL' => 'NEW ARRIVALS',
                                'ASC1' => 'PRICE LOW TO HIGH',
                                'DESC1' => 'PRICE HIGH TO LOW',
                                'A2Z' => 'NAME A-Z',
                                'Z2A' => 'NAME Z-A',
                            ];

                            $selectedSortLabel = !empty($sort) ? $sortLabels[$sort] ?? 'ALL' : 'ALL';
                        @endphp

                        <div class="filter-item d-inline-block text-start">
                            SORT BY : <span id="selectedSortText">{{ $selectedSortLabel }}</span>
                            <i class="fa fa-angle-down ms-1"></i>
                            <ul class="dropdown-menu end-sort" style="height:auto;">
                                <li class="d-flex justify-content-between align-items-center">
                                    <span>Best Selling</span>
                                    <input type="radio" name="floatingSelect" value="BESTSELLING"
                                        onclick="filterProduct()" {{ $sort == 'BESTSELLING' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center">
                                    <span>New Arrivals</span>
                                    <input type="radio" name="floatingSelect" value="NEWARRIVAL"
                                        onclick="filterProduct()" {{ $sort == 'NEWARRIVAL' ? 'checked' : '' }}>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <span>Price Low to High</span>
                                    <input type="radio" name="floatingSelect" value="ASC1" onclick="filterProduct()"
                                        {{ $sort == 'ASC1' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center">
                                    <span>Price High to Low</span>
                                    <input type="radio" name="floatingSelect" value="DESC1" onclick="filterProduct()"
                                        {{ $sort == 'DESC1' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center d-none">
                                    <span>Name: A–Z</span>
                                    <input type="radio" name="floatingSelect" value="A2Z" onclick="filterProduct()"
                                        {{ $sort == 'A2Z' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center d-none">
                                    <span>Name: Z–A</span>
                                    <input type="radio" name="floatingSelect" value="Z2A" onclick="filterProduct()"
                                        {{ $sort == 'Z2A' ? 'checked' : '' }}>
                                </li>


                            </ul>
                        </div>
                    </div>

                </div>

                <div class="container">
                    <div class="row">

                        <!-- LEFT FILTER SIDEBAR -->
                        <div class="col-lg-3 mb-4" id="filterSidebar">
                            <div id="verticalFilterPanel" class="vertical-filter-panel">

                                <!-- BRAND -->
                                <div class="filter-box">
                                    <div class="filter-box-title" data-target="brandFilter">
                                        Brands <i class="fa fa-angle-down"></i>
                                    </div>
                                    <div class="filter-box-body" id="brandFilter">
                                        <label class="filter-check-item">
                                            <span>All</span>
                                            <input type="checkbox" value="" class="categorytick"
                                                {{ empty($brand) ? 'checked' : '' }}>
                                        </label>

                                        @foreach ($brands as $key)
                                            <label class="filter-check-item">
                                                <span>{{ $key->brand_name }}</span>
                                                <input type="checkbox" value="{{ $key->brand_id }}"
                                                    class="categorytick"
                                                    {{ !empty($brand) && in_array($key->brand_id, $brand) ? 'checked' : '' }}>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- PRICE -->
                                <div class="filter-box">
                                    <div class="filter-box-title" data-target="priceFilter">
                                        Price <i class="fa fa-angle-down"></i>
                                    </div>
                                    <div class="filter-box-body" id="priceFilter">
                                        <div class="slider-wrapper">
                                            <div class="slider-track"></div>
                                            <div class="slider-range" id="sliderRange"></div>

                                            <input type="range" id="minPrice" min="0" max="10000000"
                                                step="50000" value="{{ $min_price !== '' ? $min_price : 0 }}">

                                            <input type="range" id="maxPrice" min="0" max="10000000"
                                                step="50000"
                                                value="{{ $max_price !== '' ? $max_price : 10000000 }}">
                                        </div>

                                        <div class="price-boxes">
                                            <span id="minPriceText">₹0</span>
                                            <span id="maxPriceText">₹1 Cr</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- GENDER -->
                                <div class="filter-box">
                                    <div class="filter-box-title" data-target="genderFilter">
                                        Gender <i class="fa fa-angle-down"></i>
                                    </div>
                                    <div class="filter-box-body" id="genderFilter">
                                        <label class="filter-check-item">
                                            <span>All</span>
                                            <input type="checkbox" value="" class="gender"
                                                {{ empty($gender) ? 'checked' : '' }}>
                                        </label>

                                        <label class="filter-check-item">
                                            <span>Male</span>
                                            <input type="checkbox" value="male" class="gender"
                                                {{ !empty($gender) && in_array('male', $gender) ? 'checked' : '' }}>
                                        </label>

                                        <label class="filter-check-item">
                                            <span>Female</span>
                                            <input type="checkbox" value="female" class="gender"
                                                {{ !empty($gender) && in_array('female', $gender) ? 'checked' : '' }}>
                                        </label>

                                        <label class="filter-check-item">
                                            <span>Unisex</span>
                                            <input type="checkbox" value="unisex" class="gender"
                                                {{ !empty($gender) && in_array('unisex', $gender) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                </div>

                                <!-- SIZE -->
                                <div class="filter-box">
                                    <div class="filter-box-title" data-target="sizeFilter">
                                        Size <i class="fa fa-angle-down"></i>
                                    </div>
                                    <div class="filter-box-body" id="sizeFilter">
                                        <label class="filter-check-item">
                                            <span>All</span>
                                            <input type="checkbox" value="" class="size_check"
                                                {{ empty($size) ? 'checked' : '' }}>
                                        </label>

                                        @foreach ($size_data as $key)
                                            <label class="filter-check-item">
                                                <span>{{ $key->case_size }}</span>
                                                <input type="checkbox" value="{{ $key->case_size }}"
                                                    class="size_check"
                                                    {{ !empty($size) && in_array($key->case_size, $size) ? 'checked' : '' }}>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="filter-box">
                                    <div class="filter-box-title" data-target="stockFilter">
                                        Stock Status <i class="fa fa-angle-down"></i>
                                    </div>
                                    <div class="filter-box-body" id="stockFilter">
                                        <label class="filter-check-item">
                                            <span>All</span>
                                            <input type="checkbox" value="" class="stock_check"
                                                {{ empty($stock) ? 'checked' : '' }}>
                                        </label>

                                        <label class="filter-check-item">
                                            <span>In Stock</span>
                                            <input type="checkbox" value="0" class="stock_check"
                                                {{ !empty($stock) && in_array('0', $stock) ? 'checked' : '' }}>
                                        </label>

                                        <label class="filter-check-item">
                                            <span>Out of Stock</span>
                                            <input type="checkbox" value="1" class="stock_check"
                                                {{ !empty($stock) && in_array('1', $stock) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                </div>

                                <div class="filter-box">
                                    <div class="filter-box-title" data-target="movementFilter">
                                        Movement <i class="fa fa-angle-down"></i>
                                    </div>
                                    <div class="filter-box-body" id="movementFilter">
                                        <label class="filter-check-item">
                                            <span>All</span>
                                            <input type="checkbox" value="" class="movement_check"
                                                {{ empty($movement) ? 'checked' : '' }}>
                                        </label>

                                        @foreach ($movement_Data as $key)
                                            <label class="filter-check-item">
                                                <span>{{ $key->movement }}</span>
                                                <input type="checkbox" value="{{ $key->movement_id }}"
                                                    class="movement_check"
                                                    {{ !empty($movement) && in_array($key->movement_id, $movement) ? 'checked' : '' }}>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>



                                <!-- BUTTONS -->
                                <div class="d-flex gap-2 mt-3">
                                    <button type="button" id="applyAllFilters" class="btn btn-dark flex-fill">
                                        Apply
                                    </button>
                                    <button type="button" id="resetAllFilters"
                                        class="btn btn-outline-dark flex-fill">
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT PRODUCT GRID -->
                        <div class="col-lg-9" id="productGridWrapper">
                            <div class="row">
                                @forelse ($query as $key)
                                    @php
                                        // Build SEO-friendly slugs
                                        $manufacturerSlug = Str::slug($key->manufacturer ?? $key->brand);
                                        $productSlug = Str::slug($key->product);
                                        $skuSuffix = substr($key->pro_sku, -7);

                                        $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->brand ?? '');
                                        $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->product ?? '');

                                    @endphp

                                    <div class="mb-4 col-12 col-sm-6 product-card product-item">
                                        <a
                                            href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}">
                                            <div class="card position-relative">

                                                <!-- ❤️ Wishlist Icon -->
                                                <span class="wishlist-icon" data-id="{{ $key->pro_id }}">
                                                    <svg class="heart-icon" viewBox="0 0 24 24" width="20"
                                                        height="20">
                                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
        2 5.42 4.42 3 7.5 3
        c1.74 0 3.41.81 4.5 2.09
        C13.09 3.81 14.76 3 16.5 3
        19.58 3 22 5.42 22 8.5
        c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                    </svg>
                                                </span>
                                                <img src="{{ !empty($key->pro_image)
                                                    ? $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $key->pro_image
                                                    : $actual_url . '/front/noimage.jpg' }}"
                                                    class="card-img-top px-3 py-3" alt="{{ $key->brand }}">

                                                <div class="product-info text-center px-3 py-2">
                                                    <h5>{{ $key->brand }}</h5>
                                                    <p>{{ $key->product }}</p>

                                                    @if (isset($key->out_stock) && $key->out_stock == 0)
                                                        ₹
                                                        {{ indian_number_format(round($key->selling_price_exclusive, 2)) }}
                                                    @else
                                                        <p class="text-danger"><strong>Sold Out</strong></p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                @empty
                                    <div class="col-12">
                                        <p class="text-muted text-center">
                                            No Product Available.
                                        </p>
                                    </div>
                                @endforelse

                            </div>
                        </div>

                    </div>
                </div>
                {{--
                <div class="container">
                    <div class="row">

                        @forelse ($query as $key)
                            @php
                                // Build SEO-friendly slugs
                                $manufacturerSlug = Str::slug($key->manufacturer ?? $key->brand);
                                $productSlug = Str::slug($key->product);
                                $skuSuffix = substr($key->pro_sku, -7);

                                $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->brand ?? '');
                                $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->product ?? '');

                            @endphp

                            <div class="mb-4 col-12 col-sm-6 col-md-3 product-card">
                                <a
                                    href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}">
                                    <div class="card position-relative">

                                        <!-- ❤️ Wishlist Icon -->
                                        <span class="wishlist-icon" data-id="{{ $key->pro_id }}">
                                            <svg class="heart-icon" viewBox="0 0 24 24" width="20"
                                                height="20">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
        2 5.42 4.42 3 7.5 3
        c1.74 0 3.41.81 4.5 2.09
        C13.09 3.81 14.76 3 16.5 3
        19.58 3 22 5.42 22 8.5
        c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                            </svg>
                                        </span>
                                        <img src="{{ !empty($key->pro_image)
                                            ? $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $key->pro_image
                                            : $actual_url . '/front/noimage.jpg' }}"
                                            class="card-img-top px-3 py-3" alt="{{ $key->brand }}">

                                        <div class="product-info text-center px-3 py-2">
                                            <h5>{{ $key->brand }}</h5>
                                            <p>{{ $key->product }}</p>

                                            @if (isset($key->out_stock) && $key->out_stock == 0)
                                                ₹ {{ indian_number_format(round($key->selling_price_exclusive, 2)) }}
                                            @else
                                                <p class="text-danger"><strong>Sold Out</strong></p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>

                        @empty
                            <div class="col-12">
                                <p class="text-muted text-center">
                                    No Product Available.
                                </p>
                            </div>
                        @endforelse

                    </div>
                </div> --}}




            </div>
        </div>
    </section>


    <section class="pagination-bar mt-4 mb-4">
        @if ($query->hasPages())
            @php
                $current = $query->currentPage();
                $last = $query->lastPage();

                $start = max(1, $current - 1);
                $end = min($last, $start + 2);

                if ($end - $start < 2) {
                    $start = max(1, $end - 2);
                }
            @endphp

            <div class="pagination-modern">

                <!-- LEFT : SHOWING -->
                <div class="pagination-info">
                    Showing {{ $to_data }} from {{ $total_data }} data
                </div>

                <!-- RIGHT : PAGINATION -->
                <ul class="custom-pagination-modern">

                    {{-- Previous --}}
                    @if ($query->onFirstPage())
                        <li class="disabled"><span><i class="fa fa-angle-left me-3"></i> Previous</span></li>
                    @else
                        <li>
                            <a href="{{ $query->previousPageUrl() }}"><i class="fa fa-angle-left me-3"></i>
                                Previous</a>
                        </li>
                    @endif

                    {{-- 3 centered pages --}}
                    @for ($i = $start; $i <= $end; $i++)
                        <li class="{{ $current == $i ? 'active' : '' }}">
                            <a href="{{ $query->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Next --}}
                    @if ($query->hasMorePages())
                        <li>
                            <a href="{{ $query->nextPageUrl() }}">Next <i class="fa fa-angle-right ms-3"></i></a>
                        </li>
                    @else
                        <li class="disabled"><span>Next <i class="fa fa-angle-right ms-3"></i></span></li>
                    @endif

                </ul>
            </div>
        @endif
    </section>




    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')




    <script>
        function updateProductGrid() {
            if ($('#filterSidebar').is(':visible')) {
                $('.product-item')
                    .removeClass('col-md-3 col-lg-3')
                    .addClass('col-md-4 col-lg-4'); // 3 items
            } else {
                $('.product-item')
                    .removeClass('col-md-4 col-lg-4')
                    .addClass('col-md-3 col-lg-3'); // 4 items
            }
        }
        $(document).ready(function() {



            /* ===============================
               1) FILTER SIDEBAR TOGGLE
            =============================== */

            // Restore toggle state on page load
            const savedToggle = sessionStorage.getItem('filterToggleState');
            if (savedToggle === 'hidden') {
                $('#filterToggle').prop('checked', false);
                $('#filterSidebar').hide();
                $('#verticalFilterPanel').hide();
                $('#productGridWrapper')
                    .removeClass('col-lg-9')
                    .addClass('col-lg-12');
            } else {
                $('#filterToggle').prop('checked', true);
                $('#filterSidebar').show();
                $('#verticalFilterPanel').show();
                $('#productGridWrapper')
                    .removeClass('col-lg-12')
                    .addClass('col-lg-9');
            }

            // Save toggle state on change
            $('#filterToggleBtn').click(function() {
                let isVisible = $('#filterSidebar').is(':visible');

                if (isVisible) {
                    sessionStorage.setItem('filterToggleState', 'hidden');

                    $('#verticalFilterPanel').stop(true, true).slideUp();
                    $('#filterSidebar').hide();

                    $('#productGridWrapper')
                        .removeClass('col-lg-9')
                        .addClass('col-lg-12');
                } else {
                    sessionStorage.setItem('filterToggleState', 'visible');

                    $('#filterSidebar').show();
                    $('#verticalFilterPanel').stop(true, true).slideDown();

                    $('#productGridWrapper')
                        .removeClass('col-lg-12')
                        .addClass('col-lg-9');
                }

                updateProductGrid();
            });

            updateProductGrid();

            /* ===============================
               2) INNER FILTER COLLAPSE
            =============================== */
            $('.filter-box-title').click(function() {
                let target = $(this).data('target');
                $('#' + target).stop(true, true).slideToggle();
            });

            /* ===============================
               3) SORT DROPDOWN TOGGLE
            =============================== */
            $('.filter-item').click(function(e) {
                e.stopPropagation();

                let dropdown = $(this).find('.dropdown-menu');

                $('.dropdown-menu').not(dropdown).hide();

                dropdown.toggle();
            });

            $('.dropdown-menu').click(function(e) {
                e.stopPropagation();
            });

            $(document).click(function() {
                $('.dropdown-menu').hide();
            });


            $("input[name='floatingSelect']").change(function() {
                let selectedText = $(this).closest("li").find("span").text();
                $("#selectedSortText").text(selectedText.toUpperCase());

                $('.dropdown-menu').hide();
            });

            /* ===============================
               4) APPLY FILTER BUTTON
            =============================== */
            $('#applyAllFilters').click(function() {
                filterProduct();
            });

            /* ===============================
               5) RESET FILTER BUTTON
            =============================== */
            $('#resetAllFilters').click(function() {

                // 1) uncheck all selected values
                $('#verticalFilterPanel input[type=checkbox]').prop('checked', false);

                sessionStorage.setItem('filterToggleState', 'visible');
                // 2) check All by default
                $('.categorytick[value=""]').prop('checked', true);
                $('.gender[value=""]').prop('checked', true);
                $('.size_check[value=""]').prop('checked', true);

                // 3) reset sort also
                $("input[name='floatingSelect']").prop('checked', false);

                $("#selectedSortText").text("ALL");

                // 4) close all dropdowns
                $('.filter-box-body').stop(true, true).slideUp();

                // 5) keep sidebar visible
                sessionStorage.setItem('filterToggleState', 'visible');
                $('#filterSidebar').show();
                $('#verticalFilterPanel').show();

                $('#productGridWrapper')
                    .removeClass('col-lg-12')
                    .addClass('col-lg-9');

                $('#minPrice').val(0);
                $('#maxPrice').val(10000000);
                updatePriceSlider();

                // 6) auto apply reset filters
                filterProduct();
            });

            function autoOpenPriceFilter() {
                let min = parseInt($('#minPrice').val());
                let max = parseInt($('#maxPrice').val());

                // open only if custom price selected
                if (min > 0 || max < 10000000) {
                    $("#priceFilter").show();
                } else {
                    $("#priceFilter").hide();
                }
            }

            autoOpenPriceFilter();

            /* ===============================
               6) ALL OPTION CHECKBOX LOGIC
            =============================== */
            function setupFilterGroup(selector) {
                const checkboxes = document.querySelectorAll(selector);

                checkboxes.forEach(box => {
                    box.addEventListener("change", function() {
                        const allOption = [...checkboxes].find(cb => cb.value === "");
                        const normalOptions = [...checkboxes].filter(cb => cb.value !== "");

                        if (this.value === "" && this.checked) {
                            normalOptions.forEach(cb => cb.checked = false);
                        }

                        if (this.value !== "" && this.checked) {
                            if (allOption) allOption.checked = false;
                        }

                        const anyChecked = normalOptions.some(cb => cb.checked);

                        if (!anyChecked && allOption) {
                            allOption.checked = true;
                        }
                    });
                });
            }


            function autoOpenPrefilledFilter(targetId, selector) {
                const checkedValues = $(selector + ":checked")
                    .map(function() {
                        return $(this).val();
                    }).get();

                // open only if selected values exist except All
                if (checkedValues.length > 0 && !checkedValues.includes("")) {
                    $("#" + targetId).show();
                }
            }
            setupFilterGroup(".categorytick");
            setupFilterGroup(".gender");
            setupFilterGroup(".size_check");
            setupFilterGroup(".stock_check");
            setupFilterGroup(".movement_check");



            autoOpenPrefilledFilter("brandFilter", ".categorytick");
            autoOpenPrefilledFilter("genderFilter", ".gender");
            autoOpenPrefilledFilter("sizeFilter", ".size_check");
            autoOpenPrefilledFilter("stockFilter", ".stock_check");
            autoOpenPrefilledFilter("movementFilter", ".movement_check");
        });


        /* ===============================
           7) MAIN FILTER AJAX
        =============================== */
        function filterProduct() {
            let categorytick = [];
            let size = [];
            let gender = [];
            let stock = [];
            let movement = [];
            let min_price = $("#minPrice").val();
            let max_price = $("#maxPrice").val();

            $(".categorytick:checked").each(function() {
                if ($(this).val() !== "") {
                    categorytick.push($(this).val());
                }
            });

            $(".size_check:checked").each(function() {
                if ($(this).val() !== "") {
                    size.push($(this).val());
                }
            });

            $(".gender:checked").each(function() {
                if ($(this).val() !== "") {
                    gender.push($(this).val());
                }
            });

            $(".stock_check:checked").each(function() {
                if ($(this).val() !== "") {
                    stock.push($(this).val());
                }
            });

            $(".movement_check:checked").each(function() {
                if ($(this).val() !== "") {
                    movement.push($(this).val());
                }
            });

            let sort = $("input[name='floatingSelect']:checked").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('filterProduct') }}",
                type: "POST",
                dataType: "json",
                data: {
                    size: size,
                    category: categorytick,
                    gender: gender,
                    stock: stock,
                    movement: movement,
                    min_price: min_price,
                    max_price: max_price,
                    sort: sort,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = "{{ route('product') }}";
                }
            });
        }
    </script>
    <script>
        function formatPrice(value) {
            value = parseInt(value);

            if (value >= 10000000) {
                return '₹1 Cr';
            } else if (value >= 100000) {
                return '₹' + (value / 100000).toFixed(1).replace('.0', '') + ' Lakh';
            } else {
                return '₹' + new Intl.NumberFormat('en-IN').format(value);
            }
        }

        function updatePriceSlider() {
            let min = parseInt($('#minPrice').val());
            let max = parseInt($('#maxPrice').val());
            const sliderMax = 10000000;

            if (min > max) {
                [min, max] = [max, min];
                $('#minPrice').val(min);
                $('#maxPrice').val(max);
            }

            $('#minPriceText').text(formatPrice(min));
            $('#maxPriceText').text(formatPrice(max));

            let percent1 = (min / sliderMax) * 100;
            let percent2 = (max / sliderMax) * 100;

            $('#sliderRange').css({
                left: percent1 + '%',
                width: (percent2 - percent1) + '%'
            });
        }

        $('#minPrice, #maxPrice').on('input', updatePriceSlider);

        updatePriceSlider();
    </script>









</body>

</html>
