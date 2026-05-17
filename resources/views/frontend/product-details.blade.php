<!DOCTYPE html>
<html lang="en">


<title>{{ !empty($productDetails->meta_title) ? $productDetails->meta_title : $productDetails->product }}</title>
<meta name="description"
    content="{{ !empty($productDetails->meta_description) ? $productDetails->meta_description : $productDetails->product }}">
<meta property="og:title"
    content="{{ !empty($productDetails->meta_title) ? $productDetails->meta_title : $productDetails->product }}">
<meta property="og:description"
    content="{{ !empty($productDetails->meta_description) ? $productDetails->meta_description : $productDetails->product }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="product">
@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')


    <!-- Lightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <style>

        /* ================================
   PRODUCT PAGE — CLEANED + FIXED
   ================================ */

        /* ---- Buttons (Buy / Cart / Enquire) ---- */
        .otp-box {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .custom-btn,
        .btn.custom-btn,
        .ecom-enquire.custom-btn,
        button.custom-btn {
            display: inline-block;
            padding: 10px !important;
            font-size: 18px !important;
            min-width: 210px;
            width: 100%;
            max-width: 210px;
            line-height: 1.2;
        }

        /* ---- Product cards ---- */
        .product-card img {
            width: 294px;
            height: 294px;
            margin: 0 auto;
            object-fit: contain;
        }

        /* ---- Typography helpers ---- */
        .capitalizesubtext {
            text-transform: capitalize;
        }

        /* ---- Modal / form ---- */
        .modal-header {
            border-bottom: 0;
        }

        .contact-form .submit-btn {
            margin: 0;
            background-color: #000;
            color: #fff !important;
        }

        .contact-form .form-field {
            margin: 14px 0;
            padding: 4px;
        }

        .contact-form .label {
            bottom: 60px;
        }

        .contact-form .input-text {
            font-size: 17px;
        }

        /* ---- Carousel ---- */
        .carousel-indicators {
            /* default; overridden per breakpoint below */
        }

        .zoom-hover img {
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .zoom-hover img:hover {
            transform: scale(1.05);
        }

        /* ---- Optional: price block small note ---- */
        .Inclusive {
            font-size: 12px;
        }



        .ecom-tab strong {
            font-size: 14px;
        }


     .product_video{
    width:100%;
    aspect-ratio:1/1;
    background:#fff;
    position:relative;
    overflow:hidden;
}

.product_video iframe{
    position:absolute;
    top:50%;
    left:50%;
    width:182%;
    height:102%;
    transform:translate(-50%,-50%);
    border:0;
    pointer-events:none;   /* hides pause click */
}


        /* ================================
   DESKTOP (≥1300px)
   ================================ */
        @media only screen and (min-width: 1300px) {
            .carousel-indicators {
                margin-bottom: -5rem !important;
                margin-left: auto !important;
            }
        }

        /* ================================
   MOBILE (≤767px)
   ================================ */
        @media only screen and (max-width: 767px) {

            /* Buttons a bit smaller on mobile */
            .custom-btn,
            .btn.custom-btn,
            .ecom-enquire.custom-btn,
            button.custom-btn {
                font-size: 14px !important;
                min-width: 150px;
                max-width: 200px;
            }

            .carousel-indicators {
                margin-bottom: -5rem !important;
                position: unset !important;
                /* move indicators below images nicely */
            }

            .ecom-slide1 {
                text-transform: uppercase;
                padding-top: 5rem;
            }

            .product-card img {
                width: 294px;
                height: 294px;
                margin: 0 auto;
                object-fit: contain;
            }

            .carousel-item img {
                max-width: 500px;
            }


            /* .product_video {
                width: 100%;
                height: 360px;
            } */

        }

   /* Replace existing wishlist-icon styles */
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



    </style>

    <!-- Add this inside your <style> block -->



    <!-- Breadcrumb -->
    @php
        $manufacturerSlug = \Illuminate\Support\Str::slug(
            $productDetails->manufacturerinfo ?? $productDetails->brandinfo,
        );
        $productSlug = \Illuminate\Support\Str::slug($productDetails->product);
        $skuSuffix = substr($productDetails->pro_sku, -7);
    @endphp

    <div class="container ecom-bread">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-black">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ url('/product') }}">All Watches</a>
                </li>

                <li class="breadcrumb-item active">
                    <a href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}">
                        {{ $productDetails->product }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>



    <section class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div id="demo" class="carousel slide" data-bs-ride="carousel">
                        <div class="wishlist-icon" id="wishlistDetail" data-id="{{ $productDetails->pro_id }}">
        <svg class="heart-icon" viewBox="0 0 24 24" width="24" height="24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
            2 5.42 4.42 3 7.5 3
            c1.74 0 3.41.81 4.5 2.09
            C13.09 3.81 14.76 3 16.5 3
            19.58 3 22 5.42 22 8.5
            c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
    </div>
                    <!-- Carousel slides -->
                    <div class="carousel-inner">
                        @if ($productDetails->pro_gallery != null)
                            @php
                                $imageList = explode(',', $productDetails->pro_gallery);
                                $brand_name = $productDetails->brandinfo ?? '';

                                $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $productDetails->brandinfo ?? '');
                                $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $productDetails->product ?? '');
                            @endphp
                            @foreach ($imageList as $i => $img)
                                <div class="carousel-item @if ($i == 0) active @endif zoom-hover">
                                    <a href="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/gallery/' . $img }}"
                                        class="glightbox" data-gallery="product-gallery">
                                        <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/gallery/' . $img }}"
                                            class="d-block w-100" alt="{{ $productDetails->product }}">
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Move indicators BELOW images -->
                    <div class="carousel-indicators ecom-carousel mt-3">
                        @php
                            $imageList = explode(',', $productDetails->pro_gallery);

                            $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $productDetails->brandinfo ?? '');
                            $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $productDetails->product ?? '');
                        @endphp
                        @foreach ($imageList as $i => $img)
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $i }}"
                                class="@if ($i == 0) active @endif"
                                @if ($i == 0) aria-current="true" @endif></button>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <h3 class="ecom-slide ecom-slide1">{{ $productDetails->brandinfo }}</h3>
                <h4 class="ecom-h4">{{ $productDetails->product }}</h4>
                <p class="ecom-p">MODEL NO. - {{ $productDetails->pro_model }}</p>

                <h4 class="ecom-h4">DESCRIPTION</h4>
                <p class="ecom-p">{!! $productDetails->product_desc !!}</p>

                <h4 class="ecom-h4 mb-4">WATCH SPECIFICATION</h4>


                <div class="row ecom-tab">
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>CONDITION</strong></div>
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>WARRANTY CARD</strong></div>
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>WATCH BOX</strong></div>
                </div>
                <div class="row ecom-like ecom-tab">
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                        {{ $productDetails->condition }}</div>
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                        {{ !empty(trim($productDetails->shop_warranty)) ? $productDetails->shop_warranty : 'No' }}</div>
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">{{ $productDetails->box }}
                    </div>
                </div>

                <div class="row ecom-tab">
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>YEAR</strong></div>
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>SIZE</strong></div>
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>SERVICE RECORD</strong></div>
                </div>
                <div class="row ecom-like ecom-tab">
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                        @if ($productDetails->show_yearcard == 1)
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', trim($productDetails->year_of_card))->format('Y') }}
                        @else
                            <span>N/A</span> {{-- Show "N/A" if the date is missing or invalid --}}
                        @endif
                    </div>
                    <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                        {{ $productDetails->dial_diameter }}</div>
                   <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
    {{ $productDetails->service_card == 1 ? 'Yes' : 'No' }}
</div>
                </div>

                <!--            <p class="ecom-h4-price mt-3">-->
                <!--                <strong>Price:</strong>-->
                <!--                <h3 class="price-ecom d-inline">₹ {{ indian_number_format(round($productDetails->selling_price_exclusive, 2)) }}</h3>-->
                <!--                <span class="text-muted Inclusive">*Inclusive of all taxes</span>-->
                <!--            </p>-->

                <!--            @if ($productDetails->selling_price_exclusive > 1000000)
-->
                <!--    <p style="max-width: 500px; color: #000; font-size: 14px;" class="mt-2">-->
                <!--        <strong>Note:</strong> Effective 22 April 2025, 1% TCS on listing price will be applicable and collected separately by our team.-->
                <!--        Please refer to -->
                <!--        <a href="{{ url('/terms_and_condtion') }}" target="_blank" style="color: gray; text-decoration: underline;">-->
                <!--            <b>Terms & Conditions</b>-->
                <!--        </a> for details.-->
                <!--    </p>-->
                <!--
@endif-->






                @if (isset($productDetails->out_stock) && $productDetails->out_stock == 0)
                    <p class="ecom-h4-price mt-3">
                        <strong>Price:</strong>
                    <h3 class="price-ecom d-inline">₹
                        {{ indian_number_format(round($productDetails->selling_price_exclusive, 2)) }}</h3>
                    <span class="text-muted Inclusive">*Inclusive of all taxes</span>
                    </p>

                    @if ($productDetails->selling_price_exclusive > 1000000)
                        <p style="max-width: 500px; color: #000; font-size: 14px;" class="mt-2">
                            <strong>Note:</strong> Effective 22 April 2025, 1% TCS on listing price will be applicable
                            and collected separately by our team.
                            Please refer to
                            <a href="{{ url('/terms_and_condtion') }}" target="_blank"
                                style="color: gray; text-decoration: underline;">
                                <b>Terms & Conditions</b>
                            </a> for details.
                        </p>
                    @endif
                @else
                    <p class="text-danger ecom-h4-price mt-3">
                        <strong> Sold Out </strong>
                    </p>
                @endif


                <div class="d-flex  gap-2">



                    @if (isset($productDetails->out_stock) && $productDetails->out_stock == 0)
                        <p class="ecom-p d-none">Product id. - {{ $productDetails->pro_id }}</p>


                        <button
                            class="btn btn-body border border-dark text-uppercase fw-bold rounded-0 mt-3 buy-btn custom-btn"
                            data-productname="{{ $productDetails->product }}" data-id="{{ $productDetails->pro_id }}">
                            <i class="fa fa-shopping-bag me-2"></i> Buy Now
                        </button>

                        <button
                            class="btn btn-body border border-dark text-uppercase fw-bold rounded-0 mt-3 cart-btn custom-btn"
                            data-productname="{{ $productDetails->product }}" data-id="{{ $productDetails->pro_id }}">
                            <i class="fa fa-shopping-cart me-2"></i> Add to Cart
                        </button>

                        <button
                            class="btn btn-body border border-dark text-uppercase fw-bold rounded-0 mt-3 prebook-btn custom-btn d-none"
                            data-productname="{{ $productDetails->product }}" data-id="{{ $productDetails->pro_id }}">
                            <i class="fa fa-ticket me-2"></i> Pre-Book
                        </button>
                    @else
                        <button class="ecom-enquire rounded-0 btn btn-body mt-3 custom-btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Enquire Now
                        </button>
                    @endif

                </div>





            </div>
        </div>
    </section>



    <!-- Enquiry Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="dialog-close-btn"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="contact-form row row-margin" id="contact-form-data">
                        @csrf
                        <input type="hidden" value="{{ $productDetails->pro_id }}" name="product_id"
                            id="product_id">
                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto">
                            <input id="Product_name" name="Product_name" class="input-text js-input"
                                value="{{ $productDetails->product }}" type="text" readonly
                                style="background-color: #f3f3f3;">
                            <label class="label" for="name">Product Name</label>
                        </div>
                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto">
                            <input id="model_number" name="model_number" class="input-text js-input" type="text"
                                value="{{ $productDetails->pro_model }}" readonly style="background-color: #f3f3f3;">
                            <label class="label" for="name">Model Number</label>
                            <!--<br>-->
                            <!--<span class="error" id="userName_error" style="color:red;"></span>-->
                        </div>
                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto">
                            <input id="userName" name="userName" class="input-text js-input" type="text"
                                value="{{ $user ? $user->full_name ?? $user->first_name . ' ' . $user->last_name : '' }}">
                            <label class="label" for="name">Name</label>
                            <br>
                            <span class="error" id="userName_error" style="color:red;"></span>
                        </div>


                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto">



                            <input id="userEmail" name="userEmail" class="input-text js-input" type="email"
                                value="{{ $user->email ?? '' }}">
                            <label class="label" for="email">Email</label>
                            <br>
                            <span class="error" id="userEmail_error" style="color:red;"></span>
                        </div>

                        <div class="row">

                            <!-- Phone -->
                            <!-- Phone -->
                            <div class="form-field col-lg-6 col-md-6 col-sm-12" id="phone-field-wrapper">
                                <input id="userPhone" name="userPhone" class="input-text js-input" type="tel">
                                <label class="label" id="phone-label" for="userPhone">Phone Number</label>
                                <br>
                                <span class="error" id="userPhone_error" style="color:red;"></span>
                            </div>

                            <!-- Country -->
                            <div class="form-field col-lg-6 col-md-6 col-sm-12">
                                <select name="country_id" id="country_id" class="input-text js-input">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <label class="label">Country</label>
                                <span class="error" id="country_error" style="color:red;"></span>
                            </div>

                            <!-- State -->
                            <div class="form-field col-lg-6 col-md-6 col-sm-12">
                                <select class="input-text js-input" name="state_id" id="state_id" disabled>
                                    <option value="">Select State</option>
                                </select>
                                <label class="label">State</label>
                                <span class="error" id="state_error" style="color:red;"></span>
                            </div>

                            <!-- City -->
                            <div class="form-field col-lg-6 col-md-6 col-sm-12">
                                <select class="input-text js-input" name="city_id" id="city_id" disabled>
                                    <option value="">Select City</option>
                                </select>
                                <label class="label">City</label>
                                <span class="error" id="city_error" style="color:red;"></span>
                            </div>

                        </div>
                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto">
                            <select id="question" name="question" class="input-text js-input">
                                <option value="">Select Your Query</option>

                                @foreach ($faq_data as $faq)
                                    <option value="{{ $faq->question }}">{{ $faq->question }}</option>
                                @endforeach

                                <option value="other">Other</option>
                            </select>
                            <label class="label">Your Question</label>
                            <span class="error" id="question_error" style="color:red;"></span>
                        </div>
                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto" id="otherMessageBox"
                            style="display:none;">
                            <input id="otherMessage" name="otherMessage" class="input-text js-input" type="text">
                            <label class="label">Please specify your question</label>
                            <span class="error" id="other_error" style="color:red;"></span>
                        </div>
                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto text-left mt-3">
                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                            <span class="error" id="captcha_error" style="color:red;"></span>
                        </div>
                        <div class="form-field col-lg-12 col-md-12 col-sm-12 mx-auto text-center">
                            <button class="submit-btn px-4 py-2 border-0 text-dark" type="button"
                                id="contactbutton" onclick="contactform()">
                                Enquire Now
                            </button>
                        </div>
                    </form>

                    <div id="contactformMessgaeDiv" style="color: green;font-size: 18px;">
                        <div id="form-status"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- FULL SPECIFICATION -->
    <section>
        <div class="container speci-margin">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="specify">FULL SPECIFICATION</h3>
                    <div class="row ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>BRAND</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>GENDER</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>MOVEMENT</strong></div>
                    </div>
                    <div class="row rolex-margin ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->brandinfo }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->pro_gender }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->movementinfo }}</div>
                    </div>
                    <div class="row ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>WARRANTY CARD</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>WATCH BOX</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>YEAR OF CARD</strong></div>
                    </div>
                    <div class="row rolex-margin ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ !empty(trim($productDetails->shop_warranty)) ? $productDetails->shop_warranty : 'No' }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->box }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            @if ($productDetails->show_yearcard == 1)
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', trim($productDetails->year_of_card))->format('Y') }}
                            @else
                                <span>N/A</span>
                            @endif
                        </div>
                    </div>
                    <div class="row ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>CASE SIZE</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>CASE SHAPE</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>DIAL COLOUR</strong></div>
                    </div>
                    <div class="row rolex-margin  ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->dial_diameter }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->case_shape }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->dialcolor }}</div>
                    </div>
                    <div class="row  ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>CASE MATERIAL</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>STRAP MATERIAL</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>STRAP COLOUR</strong></div>
                    </div>
                    <div class="row rolex-margin  ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->case_material }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->strap_material }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->strapcolor }}</div>
                    </div>
                    <div class="row  ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>CLASP TYPE</strong></div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4"><strong>WATER RESISTANCE</strong></div>
                    </div>
                    <div class="row rolex-margin  ecom-tab">
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->clasp_type }}</div>
                        <div class="ecom-table col-lg-4 col-md-4 col-sm-4 capitalizesubtext">
                            {{ $productDetails->water_resistance }}</div>
                    </div>
                </div>




                <div class="col-md-6">

                    @php

                        $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $productDetails->brandinfo ?? '');
                        $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $productDetails->product ?? '');

                        $videoType = $productDetails->video_type ?? '';
                        $videoSource = $productDetails->video_source ?? '';
                    @endphp

                    @if (!empty($videoSource))

                        @php
                            $embedUrl = null;

                            /* ================= YOUTUBE ================= */
                            if ($videoType == 'youtube') {
                                $url = $videoSource;
                                $videoId = null;

                                if (strpos($url, 'youtu.be') !== false) {
                                    $videoId = substr(parse_url($url, PHP_URL_PATH), 1);
                                } elseif (strpos($url, 'youtube.com/watch') !== false) {
                                    parse_str(parse_url($url, PHP_URL_QUERY), $queryVars);
                                    $videoId = $queryVars['v'] ?? null;
                                }

                                $embedUrl = $videoId ? 'https://www.youtube.com/embed/' . $videoId : $url;
                            } /* ================= VIMEO ================= */ elseif ($videoType == 'vimeo') {
                                $videoId = (int) substr(parse_url($videoSource, PHP_URL_PATH), 1);
                                $embedUrl = 'https://player.vimeo.com/video/' . $videoId;
                            } /* ================= FILE VIDEO ================= */ elseif ($videoType == 'file') {
                                $embedUrl =
                                    $actual_url .
                                    '/admin_assets/brand/' .
                                    $brand_name .
                                    '/' .
                                    $pro_name .
                                    '/video/' .
                                    $videoSource;
                            }
                        @endphp


                        <div class="product_video" style="position:relative;padding-top:56.25%;">

                            {{-- YOUTUBE / VIMEO --}}
                            @if ($videoType == 'youtube' || $videoType == 'vimeo')
                                @php
                                    if ($videoType == 'youtube') {
                                        $embedUrl = $videoId
                                            ? 'https://www.youtube.com/embed/' .
                                                $videoId .
                                                '?autoplay=1&mute=1&loop=1&playlist=' .
                                                $videoId .
                                                '&controls=0&modestbranding=1&rel=0&playsinline=1&disablekb=1'
                                            : $embedUrl;
                                    }

                                    if ($videoType == 'vimeo') {
                                        $embedUrl = $embedUrl . '?autoplay=1&muted=1&loop=1&background=1';
                                    }
                                @endphp

                               <iframe src="{{ $embedUrl }}"
allow="autoplay"
allowfullscreen>
</iframe>
                                {{-- FILE VIDEO --}}
                            @elseif($videoType == 'file')
                                <video controls style="width:100%;height:auto;">
                                    <source src="{{ $embedUrl }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif

                        </div>
                    @else
                        {{-- FALLBACK IMAGE --}}
                        <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $productDetails->pro_image }}"
                            alt="{{ $productDetails->product }}" class="w-100">

                    @endif

                </div>


            </div>
        </div>
    </section>

    <!-- SIMILAR WATCHES -->
    <section class="container mt-5">
        <h3 class="mb-4">SIMILAR WATCHES</h3>
        <div class="row">
            @php
                $availableQuery = collect($query ?? [])
                    ->filter(function ($item) {
                        return isset($item->out_stock) && (int) $item->out_stock === 0;
                    })
                    ->take(4); // optional: max 4
            @endphp

            @if ($availableQuery->count())
                @foreach ($availableQuery as $key)
                    @php
                        $manufacturerSlug = \Illuminate\Support\Str::slug($key->manufacturerinfo ?? $key->brandinfo);
                        $productSlug = \Illuminate\Support\Str::slug($key->product);
                        $skuSuffix = substr($key->pro_sku, -7); // last 7 digits

                        $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->brandinfo ?? '');
                        $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->product ?? '');
                    @endphp

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 product-card mb-3">
                        <a href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}">
                            <div class="ecom-card card rounded-0">
                                <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $key->pro_image }}"
                                    class="card-img-top px-3 py-3"
                                    alt="{{ $key->brandinfo ?? $key->manufacturerinfo }}">

                                <div class="product-info text-center px-3 py-2">
                                    <h5>{{ $key->brandinfo ?? $key->manufacturerinfo }}</h5>
                                    <p>{{ $key->product }}</p>

                                    <p class="fw-semibold">
                                        ₹ {{ indian_number_format(round($key->selling_price_exclusive, 2)) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p class="text-muted text-center">No similar watches currently available.</p>
            @endif
        </div>
    </section>

    @include('frontend.partials.footer')
    @include('frontend.partials.footer_link')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css" />
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        // ================= GLIGHTBOX =================
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            closeButton: true,
        });




        // ================= ENQUIRY FORM SUBMIT =================
        function contactform() {
            if ($('#contactbutton').prop('disabled')) {
                return;
            }
            let error = false;

            const userName = $('#userName').val().trim();
            const email = $('#userEmail').val().trim();
            const rawPhone = $('#userPhone').val().replace(/\D/g, '');
            const fullPhone = getFullPhone();

            const country = $('#country_id').val();
            const state = $('#state_id').val();
            const city = $('#city_id').val();
            const question = $('#question').val();
            const otherMsg = $('#otherMessage').val().trim();
            const captchaResponse = grecaptcha.getResponse();

            if (!captchaResponse) {
                error = true;
                $('#captcha_error').html('Please verify captcha');
            } else {
                $('#captcha_error').html('');
            }

            let finalMessage = question === 'other' ? otherMsg : question;

            if (!userName) {
                error = true;
                $('#userName_error').html('Name is required');
            } else $('#userName_error').html('');

            if (!email || !email.includes('@')) {
                error = true;
                $('#userEmail_error').html('Valid email is required');
            } else $('#userEmail_error').html('');

            if (!rawPhone || rawPhone.length < 6) {
                error = true;
                $('#userPhone_error').html('Enter valid mobile number');
            } else $('#userPhone_error').html('');

            if (!country) {
                error = true;
                $('#country_error').html('Country is required');
            } else $('#country_error').html('');

            if (!state) {
                error = true;
                $('#state_error').html('State is required');
            } else $('#state_error').html('');

            if (!city) {
                error = true;
                $('#city_error').html('City is required');
            } else $('#city_error').html('');

            if (!question) {
                error = true;
                $('#question_error').html('Please select your query');
            } else $('#question_error').html('');

            if (question === 'other' && !otherMsg) {
                error = true;
                $('#other_error').html('Please enter your question');
            } else $('#other_error').html('');

            if (error) return;

            let formData = new FormData($('#contact-form-data')[0]);
            formData.set('userPhone', fullPhone);
            formData.set('userMessage', finalMessage);
            formData.append('g-recaptcha-response', grecaptcha.getResponse());

            $.ajax({
                url: "{{ route('addProduct_enquiry') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#contactbutton')
                        .prop('disabled', true)
                        .html('<span class="spinner-border spinner-border-sm me-2"></span>Submitting...');
                },
                success: function(res) {
                    $('#contactbutton')
                        .prop('disabled', false)
                        .html('Enquire Now');

                    if (res.status) {
                        $('#contact-form-data')[0].reset();
                        $('#exampleModal').modal('hide');
                        grecaptcha.reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Thank You!',
                            text: res.message,
                            confirmButtonColor: '#000',
                            timer: 3500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: res.message,
                            confirmButtonColor: '#000'
                        });
                    }
                },
                error: function(xhr) {
                    $('#contactbutton')
                        .prop('disabled', false)
                        .html('Enquire Now');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Form submit failed',
                        confirmButtonColor: '#000'
                    });

                    console.log(xhr.responseText);
                }
            });
        }

        // ================= QUESTION TOGGLE =================
        $('#question').on('change', function() {
            if ($(this).val() === 'other') {
                $('#otherMessageBox').css({
                    display: 'block',
                    opacity: 0
                }).animate({
                    opacity: 1
                }, 200);
            } else {
                $('#otherMessageBox').animate({
                    opacity: 0
                }, 150, function() {
                    $(this).css('display', 'none');
                });
                $('#otherMessage').val('');
            }
        });








        // ================= COUNTRY → STATE → CITY =================
        $(document).ready(function() {

            $('#country_id').on('change', function() {
                const countryId = $(this).val();
                $('#state_id').fadeTo(200, 0.3);
                $('#city_id').html('<option value="">Select City</option>').prop('disabled', true);

                if (!countryId) return;

                $.get("{{ route('get.states', ':id') }}".replace(':id', countryId), function(data) {
                    $('#state_id')
                        .html('<option value="">Select State</option>')
                        .prop('disabled', false);
                    $.each(data, function(_, s) {
                        $('#state_id').append(`<option value="${s.id}">${s.name}</option>`);
                    });
                    $('#state_id').fadeTo(200, 1);
                });
            });

            $('#state_id').on('change', function() {
                const stateId = $(this).val();
                $('#city_id').fadeTo(200, 0.3);

                if (!stateId) return;

                $.get("{{ route('get.cities', ':id') }}".replace(':id', stateId), function(data) {
                    $('#city_id')
                        .html('<option value="">Select City</option>')
                        .prop('disabled', false);
                    $.each(data, function(_, c) {
                        $('#city_id').append(`<option value="${c.id}">${c.name}</option>`);
                    });
                    $('#city_id').fadeTo(200, 1);
                });
            });

        });


        // ================= PHONE — INTL TEL INPUT + FLOATING LABEL =================
        document.addEventListener("DOMContentLoaded", function() {
            const phoneInput = document.querySelector("#userPhone");

            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                separateDialCode: true,
                nationalMode: false,
                formatOnDisplay: false,
                autoPlaceholder: "off",
                preferredCountries: ["in", "us"],
            });

            let maxLength = 10;

            function updateMaxLength() {
                maxLength = iti.getSelectedCountryData().iso2 === "in" ? 10 : 15;
            }

            phoneInput.addEventListener("input", function() {
                let val = phoneInput.value.replace(/\D/g, '');
                if (val.length > maxLength) val = val.slice(0, maxLength);
                phoneInput.value = val;
            });

            phoneInput.addEventListener("keypress", function(e) {
                if (e.which < 48 || e.which > 57) e.preventDefault();
            });

            phoneInput.addEventListener("countrychange", function() {
                updateMaxLength();
                let val = phoneInput.value.replace(/\D/g, '');
                if (val.length > maxLength) {
                    phoneInput.value = val.slice(0, maxLength);
                }
            });

            updateMaxLength();

            window.getFullPhone = function() {
                return iti ? iti.getNumber() : phoneInput.value;
            };
        });
    </script>

</body>

</html>
