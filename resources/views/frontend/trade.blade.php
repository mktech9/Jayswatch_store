<!doctype html>
<html lang="en">

<head>

    <!-- Google Tag Manager -->

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="Trade Your Watch | Jay's Watch Store Luxury Watch Trader" />
    <meta name="description"
        content="Trade in your watch and get the best price of your timepiece. Get Competitive Quotes Within 24 Hours That Will Help You Get The Best Value For Your Watch." />
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="format-detection" content="telephone=no" />
    <title>Trade Your Watch | Jay's Watch Store Luxury Watch Trader</title>


    <link rel="stylesheet" type="text/css" media="all" href="{{ $actual_url . '/front/trade/trade.min.css' }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css" />


    @include('frontend.partials.header_link')

    <style>
        .acdn-panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .wtch-lst a[itemprop="url"] img,
        .scrl-lst .wtch-lst a img {
            filter: none !important;
        }

        .page.messages .message {
            position: relative;
            z-index: 999;
        }




        /* Landscape rotate message */
        @media only screen and (min-width: 568px) and (max-width: 991px) and (orientation: landscape) and not (width: 708px) and not (height: 823px) {

            body {
                overflow: hidden;
                padding-top: 0;
            }

            body .page-wrapper,
            div#livechat-compact-container {
                display: none;
            }

            body:before {
                content: "Please Rotate Your Device";
                text-align: center;
                background: #ffffff;
                width: 100%;
                position: fixed;
                height: 100vh;
                padding-top: 10%;
                font-size: 20px;
                z-index: 1500;
            }

            body:after {
                content: "";
                width: 100%;
                position: fixed;
                height: 100vh;
                background: url("https://cdn.secondmovement.com/static/version1754375309/frontend/Ethos/smnew/en_GB/images/landscape.svg") no-repeat center 60%;
                z-index: 1500;
            }
        }


        /* Tablet fix */
        @media (max-width:1024px) {
            .filter-opened .eoy-sale-head-title-container {
                z-index: 9;
            }
        }


        /* Mobile layout fixes */
        @media (max-width:767px) {

            .customer-account-create .stz-frm.form-create-account .field.field-name-prefix {
                width: 20%;
            }

            #shipping-new-address-form .field[name*=firstname],
            .stz-frm.form-create-account .field.field-name-firstname {
                width: 28%;
            }

            #shipping-new-address-form .field[name*=lastname],
            .form-create-account .field-name-lastname {
                margin-left: 3%;
                width: 46%;
            }

            .wtch-lst a[itemprop="url"] img,
            .scrl-lst .wtch-lst a img {
                filter: none !important;
            }
        }


        /* Small mobile fix */
        @media (max-width:400px) {
            .filter-options .am-ranges {
                height: calc(100dvh - 20px);
            }
        }

        /* Hide errors until form was submitted at least once */
        #tradeEnquiryForm .invalid-feedback {
            display: none;
        }

        #tradeEnquiryForm.was-validated .invalid-feedback,
        #tradeEnquiryForm .is-invalid~.invalid-feedback {
            display: block;
        }

        .stz-frm .input-btn-otp-wrap {
            display: flex;
            width: 100%;
            gap: 12px;
        }

        .stz-frm .input-btn-otp-wrap .iti {
            flex: 1;
            width: 100% !important;
        }

        .stz-frm #trade-phoneNo {
            width: 100% !important;
        }

        .stz-frm .sendotp {
            flex-shrink: 0;
            min-width: 90px;
        }

        @media(max-width:767px) {
            .stz-frm .input-btn-otp-wrap {
                flex-direction: column;
            }

            .stz-frm .sendotp {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('frontend.partials.header')







    <div class="page-wrapper">





        <div class="breadcrumbs container">
            <ul itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="1" />
                    <a itemprop="item" href="/" title="Home"><span itemprop="name">Home</span></a>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="2" />
                    <span itemprop="name">Trade Your Watch</span>
                </li>
            </ul>
        </div>
        <main id="maincontent" class="page-main"><a id="contentarea" tabindex="-1"></a>
            <div class="columns">
                <div class="column main"><input name="form_key" type="hidden" value="i6mK3B87C46dukqj" />
                    <div id="authenticationPopup" data-bind="scope:'authenticationPopup'" style="display: none;">
                    </div>

                    <div class="trade-cms">

                        <section id="sll-wtch" class="nw-sll-wtch">
                            <div class="container">
                                <div class="sellWatchContent">

                                    <div class="sll-top">
                                        <h1 class="sec-ttl">Trade your watch</h1>
                                        <p>Get competitive quotes within 24 hours that will help you get the best value
                                            for your watch</p>
                                        <span class="hWorks">how it works</span>
                                    </div>


                                    <div class="trade-up-stp container">
                                        <div class="stp-lst">
                                            <span class="nw-spt-incs sell-wtch">1</span>
                                            <h4 class="stp-ttl">Choose your watch</h4>
                                            <p>Browse through the watches available with us and select the watch you
                                                would want to Trade</p>
                                        </div>

                                        <div class="stp-lst">
                                            <span class="nw-spt-incs sell-wtch">2</span>
                                            <h4 class="stp-ttl">Speak with an expert</h4>
                                            <p>Get in touch with the experts for an insight</p>
                                        </div>

                                        <div class="stp-lst">
                                            <span class="nw-spt-incs sell-wtch">3</span>
                                            <h4 class="stp-ttl">Send us your watch</h4>
                                            <p>Once you’ve accepted the offer please courier us the watch within 2 days
                                                for final inspection</p>
                                        </div>

                                        <div class="stp-lst">
                                            <span class="nw-spt-incs sell-wtch">4</span>
                                            <h4 class="stp-ttl">Ships within 48 hours</h4>
                                            <p>We would dispatch your new watch within 2 days</p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </section>


                        <section class="trade-quote-frm container" id="get-quote" style="padding: 50px 0;">
                            <div class="dflt-watch-wrp">
                                <a id="product_url" href="javascript:void(0)">
                                    <img src="{{ $actual_url . '/front/trade/default-trade-watch.svg' }}"
                                        alt="Trade Watch" id="product_image" style="margin-top: 20rem !important;" />
                                </a>
                                <p id="no_img">Image not representational of the actual product</p>
                            </div>
                            <form class="quote-frm stz-frm needs-validation" id="tradeEnquiryForm" novalidate>
                                @csrf
                                <div class="wtch-info">
                                    <h4><span class="rnd-sp"><img
                                                src="{{ $actual_url . '/front/trade/i-size-chart.svg' }}"
                                                alt="Size Chart" width="17" /></span>What are you trading?</h4>
                                    <div class="mb-3">
                                        <label class="lbl-slt" for="trade-brand">Brand <span
                                                class="text-danger">*</span></label>

                                        <select name="trading_brand_id" id="trading_brand_id" class="form-select"
                                            required>
                                            <option value="">Select Brand</option>

                                            @foreach ($brand_data as $brand)
                                                <option value="{{ $brand->brand_id }}">
                                                    {{ $brand->brand_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback text-right" style="font-size: 10px;">
                                            This Field is required.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="modalNo">Model No <span class="text-danger">*</span></label>
                                        <input name="trading_model" type="text" id="trade-modalNo"
                                            class="form-control" value="" required />
                                        <div class="invalid-feedback text-right" style="font-size: 10px;">
                                            This Field is required.
                                        </div>
                                    </div>

                                    <!--<div class="mb-3">-->
                                    <!--    <label class="lbl-slt" for="spec-purchasefrom">Where You From Purchase ? <span-->
                                    <!--            class="text-danger">*</span></label>-->
                                    <!--    <input name="purchase_from" type="text" class="form-control"-->
                                    <!--        id="trade-purchasefrom" value="" required />-->

                                    <!--    <div class="invalid-feedback text-right" style="font-size: 10px;">-->
                                    <!--        This Field is required.-->
                                    <!--    </div>-->
                                    <!--</div>-->



                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <select id="price" name="trading_price" class="form-select">
                                            <option value="">Select Price Range</option>
                                            <option value="Upto 2 Lakhs">Upto 2 Lakhs</option>
                                            <option value="2 to 4 Lakhs">2 to 4 Lakhs</option>
                                            <option value="4 to 6 Lakhs">4 to 6 Lakhs</option>
                                            <option value="6 to 8 Lakhs">6 to 8 Lakhs</option>
                                            <option value="8 to 10 Lakhs">8 to 10 Lakhs</option>
                                            <option value="Above 10 Lakhs">Above 10 Lakhs</option>
                                        </select>
                                    </div>



                                    <label for="addPhoto">Add Photos <span class="text-danger">*</span></label>
                                    <div class="upld-img">
                                        <img src="{{ $actual_url . '/front/trade/i-upld.svg' }}" alt="Upload"
                                            width="17" />

                                        <span id="filename">upload image</span>
                                        <input type="file"
                                            class="required-entry vldtstz-filesize vldtstz-fileextensions vldtstz-imglength"
                                            name="photos[]" id="trade-addPhoto" multiple placeholder="upload image"
                                            onchange="fileNameShow();" />
                                        <span id="fileNameShow" class="file-msg"></span>
                                        <span id="maxFile" class="file-msg">Upload max 3 images</span>
                                    </div>
                                </div>
                                <div class="spec-search-wrpr other-info">
                                    <h4><span class="rnd-sp"><img
                                                src="{{ $actual_url . '/front/trade/i-spec-search.svg' }}"
                                                alt="what are you looking for" width="24" /></span>What are you
                                        looking for?</h4>
                                    <div class="wtch-info" style="grid-template-columns : 1fr 1fr !important;">
                                        <div class="mb-3">
                                            <label class="lbl-slt" for="spec-modalNo">Model number <span
                                                    class="text-danger">*</span></label>
                                            <input name="looking_model" type="text" class="form-control"
                                                id="trade-specmodel" value="" required />

                                            <div class="invalid-feedback text-right" style="font-size: 10px;">
                                                This Field is required.
                                            </div>
                                        </div>



                                        <div class="mb-3">

                                            <label class="lbl-slt" for="spec-brand">Brand <span
                                                    class="text-danger">*</span></label>
                                            <select name="looking_brand_id" id="looking_brand_id" class="form-select"
                                                required>
                                                <option value="">Select Brand</option>

                                                @foreach ($brand_data as $brand)
                                                    <option value="{{ $brand->brand_id }}">
                                                        {{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback text-right" style="font-size: 10px;">
                                                This Field is required.
                                            </div>
                                        </div>
                                    </div>

                                    <label for="spec-Comments">Comments</label>
                                    <textarea name="comments" id="trade-speccomment" title="Comments" cols="5" rows="3"></textarea>
                                </div>
                                <div class="psnl-info other-info">
                                    <h4><span class="rnd-sp"><img src="{{ $actual_url . '/front/trade/i-user.svg' }}"
                                                alt="Size Chart" width="20" /></span>Personal Information</h4>
                                    <div class="mb-3">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="trade-name" class="form-control"
                                            value="{{ $cust_data->full_name ?? '' }}" required />
                                        <div class="invalid-feedback text-right" style="font-size: 10px;">
                                            This Field is required.
                                        </div>
                                    </div>

                                    <div class="field send-enter-otp-wrap">
                                        <div class="send-otp-wrap field send-otp-wrap">
                                            <div class="mb-3">
                                                <label for="phoneNo">Phone number <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-btn-otp-wrap">
                                                    <input class="form-control minimum-length-10 num-allowed"
                                                        type="tel" id="trade-phoneNo" name="phone"
                                                        value="" title="Mobile" maxlength="15"
                                                        autocomplete="mobile" aria-required="true" placeholder=""
                                                        required>

                                                    <a href="javascript:void(0)"
                                                        class="sendotp getotp tooltip-container">
                                                        <span class="whts-otp-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 32 32" width="32px" height="32px"
                                                                fill-rule="evenodd">
                                                                <path fill-rule="evenodd"
                                                                    d="M 24.503906 7.503906 C 22.246094 5.246094 19.246094 4 16.050781 4 C 9.464844 4 4.101563 9.359375 4.101563 15.945313 C 4.097656 18.050781 4.648438 20.105469 5.695313 21.917969 L 4 28.109375 L 10.335938 26.445313 C 12.078125 27.398438 14.046875 27.898438 16.046875 27.902344 L 16.050781 27.902344 C 22.636719 27.902344 27.996094 22.542969 28 15.953125 C 28 12.761719 26.757813 9.761719 24.503906 7.503906 Z M 16.050781 25.882813 L 16.046875 25.882813 C 14.265625 25.882813 12.515625 25.402344 10.992188 24.5 L 10.628906 24.285156 L 6.867188 25.269531 L 7.871094 21.605469 L 7.636719 21.230469 C 6.640625 19.648438 6.117188 17.820313 6.117188 15.945313 C 6.117188 10.472656 10.574219 6.019531 16.054688 6.019531 C 18.707031 6.019531 21.199219 7.054688 23.074219 8.929688 C 24.949219 10.808594 25.980469 13.300781 25.980469 15.953125 C 25.980469 21.429688 21.523438 25.882813 16.050781 25.882813 Z M 21.496094 18.445313 C 21.199219 18.296875 19.730469 17.574219 19.457031 17.476563 C 19.183594 17.375 18.984375 17.328125 18.785156 17.625 C 18.585938 17.925781 18.015625 18.597656 17.839844 18.796875 C 17.667969 18.992188 17.492188 19.019531 17.195313 18.871094 C 16.894531 18.722656 15.933594 18.40625 14.792969 17.386719 C 13.90625 16.597656 13.304688 15.617188 13.132813 15.320313 C 12.957031 15.019531 13.113281 14.859375 13.261719 14.710938 C 13.398438 14.578125 13.5625 14.363281 13.710938 14.1875 C 13.859375 14.015625 13.910156 13.890625 14.011719 13.691406 C 14.109375 13.492188 14.058594 13.316406 13.984375 13.167969 C 13.910156 13.019531 13.3125 11.546875 13.0625 10.949219 C 12.820313 10.367188 12.574219 10.449219 12.390625 10.4375 C 12.21875 10.429688 12.019531 10.429688 11.820313 10.429688 C 11.621094 10.429688 11.296875 10.503906 11.023438 10.804688 C 10.75 11.101563 9.980469 11.824219 9.980469 13.292969 C 9.980469 14.761719 11.050781 16.183594 11.199219 16.382813 C 11.347656 16.578125 13.304688 19.59375 16.300781 20.886719 C 17.011719 21.195313 17.566406 21.378906 18 21.515625 C 18.714844 21.742188 19.367188 21.710938 19.882813 21.636719 C 20.457031 21.550781 21.648438 20.914063 21.898438 20.214844 C 22.144531 19.519531 22.144531 18.921875 22.070313 18.796875 C 21.996094 18.671875 21.796875 18.597656 21.496094 18.445313 Z">
                                                                </path>
                                                            </svg>
                                                        </span> Get OTP
                                                        <span class="tooltip-text">Receive OTP on WhatsApp</span>
                                                    </a>
                                                </div>
                                                <div class="invalid-feedback text-right" style="font-size: 10px;">
                                                    Please verify OTP before submitting the form
                                                </div>
                                            </div>


                                        </div>

                                        <div class="form-group  mt-10 field enter-otp-wrap enter-otp-wrap-register">
                                            <label for="phone"> Enter OTP</label>
                                            <div class="otp-digit-btn-wrap">
                                                <div class="otp-digit">
                                                    <input type="text" name="verify-otp-input1"
                                                        class="form-control verify-otp-input num-allowed"
                                                        id="verify-otp-input1" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="verify-otp-input2"
                                                        class="form-control verify-otp-input num-allowed"
                                                        id="verify-otp-input-2" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="verify-otp-input3"
                                                        class="form-control verify-otp-input num-allowed"
                                                        id="verify-otp-input-3" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="verify-otp-input4"
                                                        class="form-control verify-otp-input num-allowed"
                                                        id="verify-otp-input-4" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="verify-otp-input5"
                                                        class="form-control verify-otp-input num-allowed"
                                                        id="verify-otp-input-5" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="verify-otp-input6"
                                                        class="form-control verify-otp-input num-allowed"
                                                        id="verify-otp-input-6" inputmode="numeric" maxlength="1">
                                                </div>
                                                <input type="hidden" name="type" value="trade-page"
                                                    id="form-type">
                                                <input type="hidden" name="verify-otp-input"
                                                    class="required-entry validate-length minimum-length-6 maximum-length-6"
                                                    id="verify-otp-input" value="">

                                                <a href="javascript:void(0)" class="getotp submitotp">VERIFY</a>
                                            </div>
                                            <span class="wait-otp">Resend OTP in : 00:<span
                                                    class="otp-counter">60</span>
                                                <a href="javascript:void(0)" class="resendotp"
                                                    style="display:none;">Resend OTP</a></span>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email id <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="trade-email"
                                            value="{{ $cust_data->email ?? '' }}" class="form-controlvalidate-email"
                                            required />
                                        <div class="invalid-feedback text-right" style="font-size: 10px;">
                                            This Field is required.
                                        </div>
                                    </div>





                                    <div class="mb-3">
                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                        <select class="form-select" name="country_id" id="country_id" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Country is required</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <select class="form-select" name="state_id" id="state_id" required disabled>
                                            <option value="">Select State</option>
                                        </select>
                                        <div class="invalid-feedback">State is required</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <select class="form-select" name="city_id" id="city_id" required disabled>
                                            <option value="">Select City</option>
                                        </select>
                                        <div class="invalid-feedback">City is required</div>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <span class="subs-bx">
                                        <input name="newsletter" id="trade-newsletter_subs" type="checkbox"
                                            value="1" checked>
                                        <label for="trade-newsletter_subs">
                                            Subscribe to news and updates from Jay’s Watch Store
                                        </label>
                                    </span>

                                    <div class="invalid-feedback text-right" style="font-size:10px;">
                                        This Field is required.
                                    </div>
                                </div>
                                <button type="submit" class="btn actn-btn btn-blk">Get A Quote</button>
                            </form>
                        </section>


                        <section id="feat_wtchs" class="scrl-lst nw-scrl-lst newArrivals">

                            <div class="container swiper-container" id="new-arrivals">

                                <div class="nw-ttlsctn flx-jusfy">

                                    <h2 class="sec-ttl">
                                        {{ $new_arrivals->count() }} New Arrivals
                                        <a class="vAll ctClick" href="{{ route('arrivals') }}" title="View All">
                                            View All
                                        </a>
                                    </h2>

                                    <div class="arrow">
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-pagination"></div>
                                    </div>

                                </div>

                                <div class="wtch-lst swiper-wrapper">

                                    @foreach ($new_arrivals as $product)
                                        @php
                                            $brand_name = preg_replace(
                                                '/[^A-Za-z0-9\-]/',
                                                '_',
                                                $product->brand_name ?? '',
                                            );
                                            $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $product->pro_name ?? '');

                                            $manufacturerSlug = \Illuminate\Support\Str::slug($brand_name ?? '');
                                            $productSlug = \Illuminate\Support\Str::slug($pro_name ?? '');

                                            $skuSuffix = !empty($product->pro_sku)
                                                ? substr($product->pro_sku, -7)
                                                : '0000000';
                                        @endphp

                                        <div class="swiper-slide slideItem">

                                            <a href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}"
                                                title="{{ $product->pro_name }}">

                                                <img loading="lazy" height="1172" width="776"
                                                    src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $product->pro_image }}"
                                                    alt="{{ $product->pro_name }}" />

                                            </a>



                                            <div class="product-info text-center px-3 py-2">
                                                <h5 class="">{{ $product->brand_name }}</h5>
                                                <p>{{ $product->pro_name }}</p>
                                                <p class="rupees">₹
                                                    {{ indian_number_format(round($product->selling_price_exclusive, 2)) }}
                                                </p>
                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                        </section>

                        <style>
                            .bndDetail {
                                border: 0px !important;
                            }

                            .swiper-slide.slideItem {
                                border: 0px !important;
                            }
                        </style>
                        <section id="faq">
                            <div class="container">

                                <div class="faq-top">
                                    <h2 class="sec-ttl">
                                        <span>Selling</span> Frequently asked questions
                                    </h2>
                                </div>

                                <div class="faq-wrap">

                                    <div class="stz-acdn cms-wrpr">

                                        @foreach ($trade_faq as $key => $faq)
                                            <div class="acdn-list">

                                                <h4 class="acdn-lnk {{ $key == 0 ? 'active' : '' }}">

                                                    <span>{{ $faq->question }}</span>

                                                    <svg id="i_plsMns" xmlns="http://www.w3.org/2000/svg"
                                                        width="18" height="18" viewBox="0 0 18 18">

                                                        <path id="plus"
                                                            d="M39.361,35.667H33.028a.528.528,0,1,0,0,1.056h6.333a.528.528,0,1,0,0-1.056Z"
                                                            transform="translate(-27.194 -27.194)" />

                                                        <path id="minus"
                                                            d="M39.361,35.667H33.028a.528.528,0,1,0,0,1.056h6.333a.528.528,0,1,0,0-1.056Z"
                                                            transform="translate(45.195 -27.194) rotate(90)" />

                                                    </svg>

                                                </h4>

                                                <div class="acdn-panel {{ $key == 0 ? 'acdn-open' : '' }}">

                                                    <p>{!! $faq->answer !!}</p>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                    <a href="{{ route('all.faq') }}" class="kMore ctClickNew"
                                        data-ct-event-name="FAQs"
                                        data-ct-attributes-value='{"Type":"Sell Page","View All": "Yes"}'
                                        title="View All FAQ's">

                                        View All

                                        <svg xmlns="http://www.w3.org/2000/svg" width="19.199" height="6.822"
                                            viewBox="0 0 19.199 6.822">

                                            <path d="M30.574,39.316v2.677h-14.6v1.13h14.6v3.016l4.6-3.506Z"
                                                transform="translate(-15.973 -39.316)" fill-rule="evenodd">
                                            </path>

                                        </svg>

                                    </a>

                                </div>

                            </div>
                        </section>
                    </div>


                    <style>
                        .verify-first {
                            font-size: 10px;
                            color: red;
                            letter-spacing: 0.5px;
                            font-weight: 400;
                            margin-top: 5px;
                            text-align: right;
                            width: 100%;
                        }
                    </style>
                </div>
            </div>
        </main>



        <style>
            .exclusive-notify .exclusive-wrapper .wtsp-right-col {
                background-color: #f4f4f4 !important;
            }

            .exclusive-notify .wtsp-mobile img {
                object-fit: cover;
            }

            .exclusive-notify .exclusive-form h1 {
                margin-bottom: 8px !important;
            }

            .exclusive-notify .exclusive-txt {
                font-size: 10px;
                line-height: 16px;
                margin-bottom: 24px;
            }

            .exclusive-notify .wtsp-input-wrap {
                margin-bottom: 12px !important;
            }

            .exclusive-notify .wtsp-input-wrap .wtsp-input {
                font-size: 11px !important;
            }

            .exclusive-form .what-field {
                position: relative;
            }

            .exclusive-form .what-field .wtsp-input {
                -webkit-appearance: none;
                appearance: none;
            }

            .exclusive-form .what-field:after {
                content: "";
                display: block;
                position: absolute;
                border-left: 4px solid transparent;
                border-right: 4px solid transparent;
                border-top: 5px solid #000;
                z-index: 1;
                top: 20px;
                right: 15px;
            }

            .exclusive-form .what-field select {
                margin-left: 0px;
            }

            .exclusive-form .cnt-field .phn-text {
                width: calc(100% - 51px) !important;
            }



            @media(min-width:769px) {
                .exclusive-notify .wtsp-input-wrap {
                    position: relative;
                }

                .exclusive-form div.mage-error {
                    position: absolute;
                    background: #fff;
                    width: auto;
                    display: block;
                    z-index: 1;
                    border: 1px solid #c2c2c2;
                    border-radius: 5px;
                    padding: 5px;
                    line-height: 14px;
                    top: 20px !important;
                    right: 40px;
                    width: auto !important;
                    max-width: 230px;
                }

                .exclusive-form div.mage-error:after,
                .exclusive-form div.mage-error:before {
                    content: "";
                    border-left: 5px solid transparent;
                    border-right: 5px solid transparent;
                    text-align: center;
                    border-bottom: 5px solid #ffffff;
                    top: -5px;
                    position: absolute;
                    left: 20px;
                }

                .exclusive-form div.mage-error:before {
                    content: "";
                    border-left: 6px solid transparent;
                    border-right: 6px solid transparent;
                    border-bottom: 6px solid #c2c2c2;
                    top: -6px;
                    left: 19px;
                }
            }

            .searchDeals .input-btn-otp-wrap input {
                background: #fff;
            }

            .searchDeals .send-enter-otp-wrap {
                margin-bottom: 12px;
            }

            .searchDeals .input-btn-otp-wrap input {
                border: none;
            }

            #whatsapp .wtsp-flex {
                max-height: 670px;
            }

            .searchDeals input::-webkit-input-placeholder {
                color: #000000 !important;
                opacity: 1;
            }

            @media(max-width:992px) {
                #whatsapp .wtsp-right-col {
                    overflow-y: auto;
                }

                .searchDeals .input-btn-otp-wrap input {
                    width: calc(100% - 115px);
                }

                .searchDeals .input-btn-otp-wrap {
                    flex-wrap: wrap;
                    gap: 0px 10px !important;
                }

                .searchDeals .input-btn-otp-wrap #whatsappmobile-error {
                    order: 3;
                }
            }
        </style>





        <!-- popup style -->
        <style>
            .send-otp-wrap>label,
            .enter-otp-wrap>label {
                display: flex !important;
                gap: 10px;
            }

            .send-otp-wrap>label input,
            .enter-otp-wrap>label input {
                margin-top: 0px !important;
            }

            .whts-otp-icon {
                max-width: 22px;
                display: inline-block;
            }

            .whts-otp-icon svg {
                max-width: 22px;
            }

            .whts-otp-icon svg path {
                fill: #fff;
            }

            .stz-frm .getotp {
                font-weight: 500;
                line-height: 1;
                display: flex;
                align-items: center;
                gap: 5px;
                max-width: 105px;
                padding: 10px;
                background: #151211;
                color: #fff !important;
                height: 42px;
                text-decoration: none;
                justify-content: center;
                text-transform: uppercase;
                font-size: 12px;
            }

            .otp-multi-input input {
                padding: 0px;
                text-align: center;
                width: 16.66% !important;
            }

            .otp-seconds {
                font-size: 10px;
                position: relative;
                top: -5px;
                color: #151211;
            }

            .stz-frm .otp-digit {
                display: flex;
                gap: 10px;
                width: calc(100% - 105px);
            }

            .stz-frm .otp-digit-btn-wrap.tick .otp-digit {
                width: calc(100% - 50px);
            }

            .stz-frm .otp-row-hide {
                display: none;
            }

            .stz-frm .otp-row-show {
                display: block;
            }

            .otp-verified-icon svg {
                fill: green;
            }

            .stz-frm .otp-verified-icon {
                width: auto;
                display: inline-block;
            }

            .stz-frm .enter-otp-wrap .otp-error {
                text-align: left;
            }

            .send-otp-wrap .getotp.tooltip-container {
                background: #3fa236;
            }

            .send-otp-wrap {
                position: relative;
            }

            .stz-frm .input-btn-otp-wrap {
                display: flex;
                gap: 10px;
            }

            .stz-frm .enter-otp-wrap {
                display: none;
            }

            .wait-otp,
            .wait-otp-get-offer,
            .wait-otp-cmn {
                color: green;
                font-size: 10px;
                margin-top: 5px;
            }

            .wait-otp .otp-counter,
            .wait-otp-get-offer .otp-counter-get-offer,
            .wait-otp-cmn .otp-counter-cmn {
                display: inline-block !important;
                width: auto;
            }

            .stz-frm .text-otp-show,
            .stz-frm .enter-otp-show {
                width: 49%;
            }

            .text-otp-show {
                margin-right: 2%;
            }

            .enter-otp-wrap-register .otp-digit input {
                padding: 0px;
                text-align: center;
            }

            .stz-frm .otp-digit-btn-wrap {
                display: flex;
                gap: 10px;
            }

            .stz-frm .enter-otp-wrap-register .otp-digit {
                width: calc(100% - 70px);
                gap: 5px;
            }

            .stz-frm .enter-otp-wrap-register .otp-digit-btn-wrap {
                gap: 5px;
            }

            .stz-frm .enter-otp-wrap-register .submitotp {
                max-width: 80px;
            }

            .stz-frm .enter-otp-wrap-register .submitotp-get-offer {
                max-width: 80px;
            }

            .stz-frm .enter-otp-wrap-register .submitotp-search-deals {
                max-width: 80px;
            }

            .send-enter-otp-wrap .field {
                width: 100%;
            }

            .req-mdl .stz-frm input {
                margin-top: 0px;
            }

            .stz-frm label+.send-enter-otp-wrap {
                margin-top: 24px;
            }

            .searchDeals select {
                background: none;
            }

            @media(max-width:767px) {
                .getotp {
                    font-size: 10px;
                    max-width: 95px;
                    padding: 10px 5px;
                }

                .submitotp {
                    max-width: 60px;
                }

                .stz-frm .otp-digit {
                    width: calc(100% - 60px);
                }

                .stz-frm .otp-digit,
                .send-otp-wrap>label,
                .enter-otp-wrap>label {
                    gap: 5px;
                }

                .stz-frm .text-otp-show,
                .stz-frm .enter-otp-show {
                    width: 100%;
                }

                .text-otp-show {
                    margin-right: 0%;
                }
            }


            .stz-frm input::-webkit-input-placeholder {
                color: #626262;
            }

            .tooltip-container {
                position: relative;
                display: inline-block;
                cursor: pointer;
                font-weight: 500;
                color: #151211;
            }

            .tooltip-text {
                visibility: hidden;
                background-color: #F4F4F4;
                color: #151211;
                text-align: center;
                border-radius: 6px;
                padding: 8px 10px;
                position: absolute;
                z-index: 1;
                bottom: 125%;
                right: 0;
                opacity: 0;
                transition: opacity 0.3s;
                pointer-events: none;
                font-size: 11px;
                line-height: 1.2;
                font-family: Sculpin, sans-serif;
                font-weight: normal;
                text-transform: none;
                text-wrap: nowrap;
                display: block;
                width: auto !important;
            }


            .tooltip-text::after {
                content: '';
                position: absolute;
                top: 100%;
                left: 50%;
                margin-left: -5px;
                border-width: 5px;
                border-style: solid;
                border-color: #F4F4F4 transparent transparent transparent;
            }

            .tooltip-container:hover .tooltip-text {
                visibility: visible;
                opacity: 1;
            }

            #reqAnOffer .req-frm .mage-error {
                line-height: normal;
                position: initial;
            }

            .reqAnOffer_popup .mdl-ctnt {
                max-width: 820px;
            }

            .mdl-bdy .sec-ttl .ct-popup-title {
                color: #151211;
                font-size: 24px;
                font-weight: normal;
                line-height: 34px;
                font-family: petersburg-web, serif;
            }

            .catalog-popup-flex {
                display: flex;
                align-items: center;
            }

            .reqAnOffer_popup .mdl-bdy {
                padding: 0px;
            }

            .catalog-popup-image {
                width: 320px;
                padding: 60px 0px 60px 60px;
            }

            .catalog-popup-form {
                width: 500px;
                padding: 60px;
            }

            .catalog-popup-image img {
                width: 100%;
                max-width: 260px;
                vertical-align: middle;
            }

            .ct-popup-sku {
                color: #626262;
            }

            .ct-popup-subtitle {
                border-top: 1px solid #f4f4f4;
                padding-top: 12px;
                margin-top: 12px !important;
            }

            .socialLinks a {
                background-size: cover;
            }

            @media(min-width:768px) {
                .ftr-brd-wrpr {
                    max-height: 240px;
                }

                .tp-lnk>.minicart-wrapper {
                    transition: 0s all;
                }

            }

            @media (max-width: 1024px) {
                .catalog-popup-image {
                    display: none;
                }

                .reqAnOffer_popup .mdl-ctnt {
                    max-width: 500px;
                }

                .catalog-popup-form {
                    width: 100%;
                    padding: 10%;
                }
            }

            @media (max-width: 767px) {
                .mdl-bdy .sec-ttl .ct-popup-title {
                    font-size: 18px;
                }

                .req-frm [type="checkbox"]+label:after {
                    top: 2px;
                }

                .req-frm [type="checkbox"]+label:before {
                    top: 6px;
                }
            }
        </style>





    </div>
    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script src="{{ $actual_url . '/front/trade/swiper.min.js' }}"></script>
    <script>
        document.querySelectorAll('.acdn-lnk').forEach(function(trigger) {
            trigger.addEventListener('click', function() {
                var item = this.closest('.acdn-list');
                var panel = item.querySelector('.acdn-panel');
                var isOpen = item.classList.contains('acdn-open');

                // Close all
                document.querySelectorAll('.acdn-list').forEach(function(el) {
                    el.classList.remove('acdn-open');
                    el.querySelector('.acdn-panel').style.maxHeight = null;
                    el.querySelector('.acdn-lnk').classList.remove('active');
                });

                // Open clicked if it was closed
                if (!isOpen) {
                    item.classList.add('acdn-open');
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                    this.classList.add('active');
                }
            });
        });

        // Open first item on load
        var first = document.querySelector('.acdn-list');
        if (first) {
            var firstPanel = first.querySelector('.acdn-panel');
            first.classList.add('acdn-open');
            firstPanel.style.maxHeight = firstPanel.scrollHeight + 'px';
        }
    </script>
    <script>
        $(document).ready(function() {

            var customCheck = true;

            var newArrivals = new Swiper('#new-arrivals', {

                pagination: {
                    el: '.swiper-pagination',
                    type: 'custom',

                    renderCustom: function(swiper, current, total) {

                        var customCurrent = current + 3;
                        var customTotal = total + 3;

                        if (customCurrent == customTotal && customCheck) {

                            customCheck = false;
                            $(".swiper-button-next").click();

                        }

                        if (customCurrent > customTotal) {
                            customCurrent = customTotal;
                        }

                        return '<span class="swiper-pagination-current">' + customCurrent +
                            '</span> / <span class="swiper-pagination-total">' +
                            customTotal + '</span>';
                    }
                },

                slidesPerView: 'auto',

                centeredSlides: false,

                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                autoplay: {
                    delay: 5000,
                }

            });

        });
    </script>

    <script>
        $("#tradeEnquiryForm").on("submit", function() {
            const fullNumber = window.tradePhoneInstance.getNumber();
            $("#trade-phoneNo").val(fullNumber);
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#country_id').on('change', function() {

                let countryId = $(this).val();

                $('#state_id').empty().append('<option value="">Select State</option>').prop('disabled',
                    true);
                $('#city_id').empty().append('<option value="">Select City</option>').prop('disabled',
                    true);

                if (!countryId) return;

                let url = "{{ route('get.states', ':country_id') }}";
                url = url.replace(':country_id', countryId);

                $.get(url, function(data) {

                    $('#state_id').prop('disabled', false);

                    $.each(data, function(key, state) {
                        $('#state_id').append('<option value="' + state.id + '">' + state
                            .name + '</option>');
                    });

                    $('#state_id').trigger('change.select2');
                });
            });


            // State → Cities
            $('#state_id').on('change', function() {

                let stateId = $(this).val();

                $('#city_id').empty().append('<option value="">Select City</option>').prop('disabled',
                    true);

                if (!stateId) return;

                let url = "{{ route('get.cities', ':state_id') }}";
                url = url.replace(':state_id', stateId);

                $.get(url, function(data) {

                    $('#city_id').prop('disabled', false);

                    $.each(data, function(key, city) {
                        $('#city_id').append('<option value="' + city.id + '">' + city
                            .name + '</option>');
                    });

                    $('#city_id').trigger('change.select2');
                });
            });



            $.validator.addMethod(
                'vldtstz-filesize',
                function(v, elm) {
                    var maxSize = 5 * 1024000;

                    if (navigator.appName == "Microsoft Internet Explorer") {
                        if (elm.value) {
                            var oas = new ActiveXObject("Scripting.FileSystemObject");
                            var e = oas.getFile(elm.value);
                            var size = e.size;
                        }
                    } else {
                        var size = size1 = size2 = 0;

                        if (elm.files[0] != undefined) {
                            size = elm.files[0].size;
                        }
                        if (elm.files[1] != undefined) {
                            size1 = elm.files[1].size;
                        }
                        if (elm.files[2] != undefined) {
                            size2 = elm.files[2].size;
                        }
                    }

                    if ((size != undefined && size > maxSize) ||
                        (size1 != undefined && size1 > maxSize) ||
                        (size2 != undefined && size2 > maxSize)) {
                        return false;
                    }

                    return true;
                },
                'The file size should not exceed 5MB'
            );


            // Validate Image Extensions
            $.validator.addMethod(
                'vldtstz-fileextensions',
                function(v, elm) {

                    if (!v) {
                        return true;
                    }

                    var all = 0;
                    var extensions = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
                    var inputImg = document.getElementById('trade-addPhoto');

                    for (var x = 0; x < inputImg.files.length; x++) {
                        var ext = inputImg.files[x].name.substring(inputImg.files[x].name.lastIndexOf('.') + 1);

                        for (var i = 0; i < extensions.length; i++) {
                            if (ext == extensions[i]) {
                                all++;
                            }
                        }
                    }

                    if (inputImg.files.length == all) {
                        return true;
                    }

                    return false;

                },
                'Please upload image file only.'
            );


            // Validate Max Image Count
            $.validator.addMethod(
                'vldtstz-imglength',
                function(v, elm) {

                    if (!v) {
                        return true;
                    }

                    var inputImg = document.getElementById('trade-addPhoto');

                    if (inputImg.files.length < 4) {
                        return true;
                    }

                    return false;

                },
                'You can upload max 3 files.'
            );


            // Show File Names
            window.fileNameShow = function() {

                var input = document.getElementById('trade-addPhoto');
                var output = document.getElementById('fileNameShow');

                if (input.files.length > 3) {
                    output.innerHTML = 'You can upload max 3 images';
                    output.style.color = 'red';
                } else {

                    output.innerHTML = '';

                    for (var i = 0; i < input.files.length; ++i) {
                        output.innerHTML += '<span>' + input.files.item(i).name + '</span><br>';
                    }

                    output.style.color = 'green';
                }
            };

            function startOtpTimer() {
                let time = 60;

                $('.otp-counter').text(time);
                $('.resendotp').hide();

                let timer = setInterval(function() {
                    time--;
                    $('.otp-counter').text(time);

                    if (time <= 0) {
                        clearInterval(timer);

                        $('.otp-counter').text('00');
                        $('.resendotp').show();

                        otpSending = false;
                        $('.sendotp')
                            .html(originalOtpBtn)
                            .css("pointer-events", "auto");
                    }
                }, 1000);
            }
            $('.verify-otp-input').on('keyup', function(e) {

                if (this.value.length == 1) {
                    $(this).next('.verify-otp-input').focus();
                }

                if (e.key === "Backspace" && this.value === "") {
                    $(this).prev('.verify-otp-input').focus();
                }

            });



            let otpSending = false;
            let originalOtpBtn = $('.sendotp').html();

            $('.sendotp').off('click').on('click', function(e) {
                e.preventDefault();

                if (otpSending) return;

                let btn = $(this);
                let phone = window.tradePhoneInstance.getNumber();

                if (!window.tradePhoneInstance.isValidNumber()) {
                    iziToast.warning({
                        title: 'Invalid Phone',
                        message: 'Please Enter Valid Phone Number',
                        position: 'topRight'
                    });
                    $('#trade-phoneNo').focus();
                    return;
                }

                otpSending = true;

                btn.html("Sending...");
                btn.css("pointer-events", "none");

                $.ajax({
                    url: "{{ route('send.otp') }}",
                    type: "POST",
                    data: {
                        phone: phone,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('.enter-otp-wrap').show();
                        startOtpTimer();

                        btn.html("OTP Sent");

                        Swal.fire({
                            icon: 'success',
                            title: 'OTP sent to WhatsApp'
                        });
                    },
                    error: function() {
                        btn.html(originalOtpBtn);
                        btn.css("pointer-events", "auto");
                        otpSending = false;
                    }
                });
            });

            $('.resendotp').click(function() {
                $(this).hide();
                $('.sendotp').trigger('click');
            });

            $('.submitotp').click(function() {

                let otp = '';

                $('.verify-otp-input').each(function() {
                    otp += $(this).val();
                });

                let phone = window.tradePhoneInstance.getNumber();

                $.ajax({
                    url: "{{ route('verify.otp') }}",
                    type: "POST",
                    data: {
                        phone: phone,
                        otp: otp,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {

                        if (res.status) {

                            window.otpVerified = true;

                            // Hide OTP input fields
                            $('.enter-otp-wrap').hide();

                            // Disable phone input
                            $('#trade-phoneNo').prop('readonly', true);

                            // Change button text to Verified
                            $('.sendotp')
                                .text('Verified ✓')
                                .css({
                                    'background': '#28a745',
                                    'pointer-events': 'none'
                                });

                            Swal.fire({
                                icon: 'success',
                                title: 'Phone Verified'
                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid OTP'
                            });

                        }

                    }

                });

            });


            // Form Submit
            $('#tradeEnquiryForm').on('submit', function(e) {


                var form = this;



                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(form).addClass('was-validated');
                    return;
                }


                if (!window.otpVerified) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please verify OTP first'
                    });

                    return false;
                }


                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('trading.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Trade Request Sent!',
                            text: 'Our expert will contact you shortly.',
                            confirmButtonColor: '#000'
                        });

                        $('#tradeEnquiryForm')[0].reset();
                        window.otpVerified = false;

                        // Enable phone input again
                        $('#trade-phoneNo').prop('readonly', false);

                        $('.sendotp')
                            .html(originalOtpBtn)
                            .css({
                                background: '#3fa236',
                                'pointer-events': 'auto'
                            });
                        // Hide OTP input area
                        $('.enter-otp-wrap').hide();

                        // Clear OTP inputs
                        $('.verify-otp-input').val('');

                    },

                    error: function() {

                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });

                    }

                });

            });

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const phoneInput = document.querySelector("#trade-phoneNo");

            if (phoneInput) {
                const iti = window.intlTelInput(phoneInput, {
                    initialCountry: "in",
                    separateDialCode: true,
                    autoPlaceholder: "off", // ✅ remove sample number placeholder
                    preferredCountries: ["in", "ae", "us", "gb"],
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
                });

                phoneInput.addEventListener("countrychange", function() {
                    const countryData = iti.getSelectedCountryData();
                    console.log("Selected Dial Code:", countryData.dialCode);
                });

                window.tradePhoneInstance = iti;
            }
        });
    </script>
</body>

</html>
