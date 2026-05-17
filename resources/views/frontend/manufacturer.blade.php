<?php
use Illuminate\Support\Str;
use App\Models\BrandModel;

$brands = BrandModel::where('status', 0)->select('brand_id', 'brand_name')->distinct()->get();
?>
<!DOCTYPE html>
<html lang="en">

<title>{!! $metaTitle !!}</title>
<meta name="description" content="{!! $metaDescription !!}">
<meta property="og:title" content="{!! $metaTitle !!}">
<meta property="og:description" content="{!! $metaDescription !!}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="article">

@include('frontend.partials.header_link')

<body>
    @include('frontend.partials.header')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .product-card img {
            width: 100%;
            max-width: 294px;
            height: 294px;
            margin: 0 auto;
            object-fit: contain;
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

        }

        .filter-box-body {
            display: none;
            padding: 15px;
            border-top: 1px solid #eee;
            max-height: 220px;
            overflow-y: auto;
        }

        .filter-check-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
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
        }

        .slider-range {
            background: #000;
        }

        .slider-wrapper input[type=range] {
            position: absolute;
            width: 100%;
            top: 5px;
            left: 0;
            background: none;
            pointer-events: none;
            appearance: none;
        }

        .slider-wrapper input[type=range]::-webkit-slider-thumb {
            pointer-events: auto;
            width: 24px;
            height: 24px;
            background: #000;
            appearance: none;
        }

        .price-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .price-boxes span {
            background: #e8dfd7;
            padding: 10px 18px;

        }


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

        /* =========================
   TOP FILTER BAR
========================= */
        .mobile-filter-wrapper {
            max-width: 320px;
            background: #fff;
        }

        .filter-toggle-head {
            display: flex;
            /* justify-content: space-between; */
            justify-content: space-around;
            align-items: center;
            margin-bottom: 0;
        }

        .filter-left {
            display: flex;
            align-items: center;
            gap: 10px;

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

input[type="radio"] {
    accent-color: #212529;
}



        .filter-left {
            cursor: pointer;
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
                    <h3 class="all-title">Pre Owned {{ $brandName }} Watches</h3>
                </div>

                {{-- TOP FILTER BAR --}}
                <div class="row mb-4 align-items-center">
                    {{-- <div class="col-lg-6 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa fa-filter"></i>
                            <span>Filters</span>
                            <label class="form-check form-switch ms-3">
                                <input class="form-check-input" type="checkbox" id="filterToggle" checked>
                                  <span class="slider-switch"></span>
                            </label>
                        </div>
                    </div> --}}

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

                    <div class="col-lg-6 col-6 text-end">
                        @php
                            $sortLabels = [
                                'BESTSELLING' => 'BEST SELLING',
                                'NEWARRIVAL' => 'NEW ARRIVALS',
                                'ASC1' => 'PRICE LOW TO HIGH',
                                'DESC1' => 'PRICE HIGH TO LOW',
                            ];

                            $selectedSortLabel = $sortLabels[$sort] ?? 'ALL';
                        @endphp

                        <div class="filter-item d-inline-block text-start">
                            SORT BY : <span id="selectedSortText">{{ $selectedSortLabel }}</span>
                            <i class="fa fa-angle-down ms-1"></i>

                            <ul class="dropdown-menu end-sort" style="height:auto;">

                                <li class="d-flex justify-content-between align-items-center">
                                    <span>Best Selling</span>
                                    <input type="radio" name="floatingSelect" value="BESTSELLING"
                                        onclick="filterBrandProduct()" {{ $sort == 'BESTSELLING' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center">
                                    <span>New Arrivals</span>
                                    <input type="radio" name="floatingSelect" value="NEWARRIVAL"
                                        onclick="filterBrandProduct()" {{ $sort == 'NEWARRIVAL' ? 'checked' : '' }}>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <span>Price Low to High</span>
                                    <input type="radio" name="floatingSelect" value="ASC1"
                                        onclick="filterBrandProduct()" {{ $sort == 'ASC1' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center">
                                    <span>Price High to Low</span>
                                    <input type="radio" name="floatingSelect" value="DESC1"
                                        onclick="filterBrandProduct()" {{ $sort == 'DESC1' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center d-none">
                                    <span>Name: A–Z</span>
                                    <input type="radio" name="floatingSelect" value="A2Z"
                                        onclick="filterBrandProduct()" {{ $sort == 'A2Z' ? 'checked' : '' }}>
                                </li>

                                <li class="d-flex justify-content-between align-items-center d-none">
                                    <span>Name: Z–A</span>
                                    <input type="radio" name="floatingSelect" value="Z2A"
                                        onclick="filterBrandProduct()" {{ $sort == 'Z2A' ? 'checked' : '' }}>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">

                    {{-- FILTER SIDEBAR --}}
                    <div class="col-lg-3 mb-4" id="filterSidebar">
                        <div id="verticalFilterPanel" class="vertical-filter-panel">

                            {{-- PRICE --}}
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
                                            step="50000" value="{{ $max_price !== '' ? $max_price : 10000000 }}">
                                    </div>

                                    <div class="price-boxes">
                                        <span id="minPriceText">₹0</span>
                                        <span id="maxPriceText">₹1 Cr</span>
                                    </div>
                                </div>
                            </div>

                            {{-- GENDER --}}
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
                                            {{ in_array('male', $gender ?? []) ? 'checked' : '' }}>
                                    </label>

                                    <label class="filter-check-item">
                                        <span>Female</span>
                                        <input type="checkbox" value="female" class="gender"
                                            {{ in_array('female', $gender ?? []) ? 'checked' : '' }}>
                                    </label>

                                    <label class="filter-check-item">
                                        <span>Unisex</span>
                                        <input type="checkbox" value="unisex" class="gender"
                                            {{ in_array('unisex', $gender ?? []) ? 'checked' : '' }}>
                                    </label>
                                </div>
                            </div>

                            {{-- SIZE --}}
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

                                    @foreach ($size_data as $s)
                                        <label class="filter-check-item">
                                            <span>{{ $s->case_size }}</span>
                                            <input type="checkbox" value="{{ $s->case_size }}" class="size_check"
                                                {{ in_array($s->case_size, $size ?? []) ? 'checked' : '' }}>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- STOCK --}}
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
                                            {{ in_array('0', $stock ?? []) ? 'checked' : '' }}>
                                    </label>

                                    <label class="filter-check-item">
                                        <span>Out of Stock</span>
                                        <input type="checkbox" value="1" class="stock_check"
                                            {{ in_array('1', $stock ?? []) ? 'checked' : '' }}>
                                    </label>
                                </div>
                            </div>

                            {{-- MOVEMENT --}}
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

                                    @foreach ($movement_Data as $m)
                                        <label class="filter-check-item">
                                            <span>{{ $m->movement }}</span>
                                            <input type="checkbox" value="{{ $m->movement_id }}"
                                                class="movement_check"
                                                {{ in_array($m->movement_id, $movement ?? []) ? 'checked' : '' }}>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="button" id="applyBrandFilters" class="btn btn-dark flex-fill">
                                    Apply
                                </button>
                                <button type="button" id="resetBrandFilters" class="btn btn-outline-dark flex-fill">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- PRODUCT GRID --}}



                    <div class="col-lg-9" id="productGridWrapper">
                        <div class="row">
                            @forelse ($query as $key)
                                @php
                                    $manufacturerSlug = Str::slug($key->brandinfo);
                                    $productSlug = Str::slug($key->pro_name);
                                    $skuSuffix = substr($key->pro_sku, -7);
                                    $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->brandinfo ?? '');
                                    $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->pro_name ?? '');
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
                                            <img
                                                src="{{ $actual_url . '/admin_assets/brand/' . $brandFolder . '/' . $pro_name . '/image/' . $key->pro_image }}">

                                            <div class="product-info text-center px-3 py-2">
                                                <h5>{{ $key->manufacturerinfo }}</h5>
                                                <p>{{ $key->pro_name }}</p>

                                                @if ($key->out_stock == 0)
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
                            <div class="pagination-info">
                                Showing {{ $query->count() }} from {{ $query->total() }} data
                            </div>

                            <ul class="custom-pagination-modern">
                                @if ($query->onFirstPage())
                                    <li class="disabled"><span>Previous</span></li>
                                @else
                                    <li><a href="{{ $query->previousPageUrl() }}">Previous</a></li>
                                @endif

                                @for ($i = $start; $i <= $end; $i++)
                                    <li class="{{ $current == $i ? 'active' : '' }}">
                                        <a href="{{ $query->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($query->hasMorePages())
                                    <li><a href="{{ $query->nextPageUrl() }}">Next</a></li>
                                @else
                                    <li class="disabled"><span>Next</span></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </section>

                @if ($brandDetails)
                    <section class="brand-info py-5">
                        {!! $brandDetails !!}
                    </section>
                @endif

            </div>
        </div>
    </section>



    @include('frontend.partials.footer')
    @include('frontend.partials.footer_link')

    <script>
        function updateProductGrid() {
            if ($('#filterSidebar').is(':visible')) {
                $('.product-card')
                    .removeClass('col-md-3 col-lg-3')
                    .addClass('col-md-4 col-lg-4');
            } else {
                $('.product-card')
                    .removeClass('col-md-4 col-lg-4')
                    .addClass('col-md-3 col-lg-3');
            }
        }

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

        $(document).ready(function() {

            // ===============================
            // FILTER SIDEBAR TOGGLE
            // ===============================
            const savedToggle = sessionStorage.getItem('brandFilterToggle');

            if (savedToggle === 'hidden') {

                $('#filterSidebar').hide();
                $('#verticalFilterPanel').hide();
                $('#productGridWrapper')
                    .removeClass('col-lg-9')
                    .addClass('col-lg-12');
            } else {

                $('#filterSidebar').show();
                $('#verticalFilterPanel').show();
                $('#productGridWrapper')
                    .removeClass('col-lg-12')
                    .addClass('col-lg-9');
            }

            $('#filterToggleBtn').click(function() {
                let isVisible = $('#filterSidebar').is(':visible');

                if (isVisible) {
                    sessionStorage.setItem('brandFilterToggle', 'hidden');

                    $('#verticalFilterPanel').stop(true, true).slideUp();
                    $('#filterSidebar').hide();

                    $('#productGridWrapper')
                        .removeClass('col-lg-9')
                        .addClass('col-lg-12');
                } else {
                    sessionStorage.setItem('brandFilterToggle', 'visible');

                    $('#filterSidebar').show();
                    $('#verticalFilterPanel').stop(true, true).slideDown();

                    $('#productGridWrapper')
                        .removeClass('col-lg-12')
                        .addClass('col-lg-9');
                }

                updateProductGrid();
            });
            updateProductGrid();

            // ===============================
            // FILTER ACCORDION
            // ===============================
            $('.filter-box-title').click(function() {
                let target = $(this).data('target');
                $('#' + target).stop(true, true).slideToggle();
            });

            // ===============================
            // SORT DROPDOWN
            // ===============================
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

                $('.dropdown-menu').hide(); // close dropdown
            });

            // ===============================
            // FILTER GROUP LOGIC
            // ===============================
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

                if (checkedValues.length > 0 && !checkedValues.includes("")) {
                    $("#" + targetId).show();
                }
            }

            setupFilterGroup(".gender");
            setupFilterGroup(".size_check");
            setupFilterGroup(".stock_check");
            setupFilterGroup(".movement_check");

            autoOpenPrefilledFilter("genderFilter", ".gender");
            autoOpenPrefilledFilter("sizeFilter", ".size_check");
            autoOpenPrefilledFilter("stockFilter", ".stock_check");
            autoOpenPrefilledFilter("movementFilter", ".movement_check");

            // ===============================
            // PRICE FILTER AUTO OPEN
            // ===============================
            let min = parseInt($('#minPrice').val());
            let max = parseInt($('#maxPrice').val());

            if (min > 0 || max < 10000000) {
                $("#priceFilter").show();
            }

            $('#minPrice, #maxPrice').on('input', updatePriceSlider);
            updatePriceSlider();

            // ===============================
            // APPLY
            // ===============================
            $('#applyBrandFilters').click(function() {
                filterBrandProduct();
            });

            // ===============================
            // RESET
            // ===============================
            $('#resetBrandFilters').click(function() {
                $('#verticalFilterPanel input[type=checkbox]').prop('checked', false);

                $('.gender[value=""]').prop('checked', true);
                $('.size_check[value=""]').prop('checked', true);
                $('.stock_check[value=""]').prop('checked', true);
                $('.movement_check[value=""]').prop('checked', true);

                $("input[name='floatingSelect']").prop('checked', false);

                $('#minPrice').val(0);
                $('#maxPrice').val(10000000);

                updatePriceSlider();

                sessionStorage.setItem('brandFilterToggle', 'visible');
                $('#filterSidebar').show();
                $('#verticalFilterPanel').show();

                $('#productGridWrapper')
                    .removeClass('col-lg-12')
                    .addClass('col-lg-9');

                sessionStorage.setItem('brandFilterToggle', 'visible');

                filterBrandProduct();
            });

        });

        function filterBrandProduct() {
            let size = [];
            let gender = [];
            let stock = [];
            let movement = [];

            $(".size_check:checked").each(function() {
                if ($(this).val() !== "") size.push($(this).val());
            });

            $(".gender:checked").each(function() {
                if ($(this).val() !== "") gender.push($(this).val());
            });

            $(".stock_check:checked").each(function() {
                if ($(this).val() !== "") stock.push($(this).val());
            });

            $(".movement_check:checked").each(function() {
                if ($(this).val() !== "") movement.push($(this).val());
            });

            $.ajax({
                url: "{{ route('filterBrandProduct') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    brand_slug: "{{ $brandSlug }}",
                    size: size,
                    gender: gender,
                    stock: stock,
                    movement: movement,
                    sort: $("input[name='floatingSelect']:checked").val(),
                    min_price: $('#minPrice').val(),
                    max_price: $('#maxPrice').val()
                },
                success: function() {
                    location.reload();
                }
            });
        }
    </script>



</body>

</html>
