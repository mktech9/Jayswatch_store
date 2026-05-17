<!DOCTYPE html>
<html lang="en">
<style>
    .input-group .btn {
        border: 1px solid #9e9e9e85 !important;
        border-radius: 100px;
    }
</style>


<title>{!! $homecontent->meta_title ?? 'JWS' !!}</title>
<meta name="description" content="{!! $homecontent->meta_description ?? 'JWS' !!}">
<meta property="og:title" content="Buy Pre-Owned Luxury Watches - Authentic & Certified - JWS">
<meta property="og:description" content="{!! $homecontent->meta_description ?? 'JWS' !!}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="page">

@include('frontend.partials.header_link')
<style>
    .seo-card {
        background: #fff;
        padding: 35px;
        font-size: 15px !important;
        /* box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        transition: 0.3s ease; */
        height: 100%;
    }

    /* .seo-card:hover {
        transform: translateY(-5px);
    } */

    .seo-list {
        list-style-type: disc !important;
        padding-left: 22px !important;
        margin: 0;


    }

    .seo-list li {
        list-style: disc !important;
        display: list-item !important;
        margin-bottom: 8px;
    }

    .luxury-overlay-section {
        margin-top: 60px;
    }

    .overlay-image-box {
        position: relative;

        overflow: hidden;
    }

    .overlay-image-box img {
        width: 100%;
        height: 520px;
        object-fit: cover;

    }

    .floating-card {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        width: 460px;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .left-card {
        left: 40px;
    }

    .right-card {
        right: 40px;
    }

    @media (max-width: 991px) {
        .overlay-image-box img {
            height: 400px;
        }

        .floating-card {
            position: static;
            transform: none;
            width: 100%;
            margin-top: -40px;
            border-radius: 20px;
        }
    }

    @media (max-width: 768px) {
        .jws-seo-section h2 {
            font-size: 28px;
        }

        .seo-card,
        .floating-card {
            padding: 24px;
        }

        .overlay-image-box img {
            height: 300px;
        }
    }
</style>
<style>
    .luxury-banner-overlay {
        position: relative;
        overflow: hidden;
        min-height: 650px;
        margin-top: 60px;
    }

    .luxury-banner-overlay img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .luxury-banner-overlay::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .luxury-banner-content {
        position: relative;
        z-index: 2;
        min-height: 710px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 50px 40px;
        text-align: center;
        color: #fff;
        max-width: 650px;
        margin: auto;
    }

    .luxury-banner-content h2 {

        margin-bottom: 20px;

    }

    .luxury-banner-content p,
    .luxury-banner-content li {

        line-height: 1.8;
    }

    .luxury-banner-content .seo-list {
        text-align: left;
        margin: 20px 0;
        width: 100%;
    }

    .luxury-btn {
        display: inline-block;
        padding: 12px 28px;
        border: 1px solid #fff;
        color: #fff !important;
        text-decoration: none;

        background: #212529;
        margin-top: 20px;
        transition: 0.3s ease;
    }

    .luxury-btn:hover {
        background: #fff;
        color: #000 !important;
    }

    @media (max-width: 768px) {

        .luxury-banner-overlay,
        .luxury-banner-content {
            min-height: auto;
        }

        .luxury-banner-content {
            padding: 40px 20px;
            max-width: 100%;
        }

        .luxury-banner-content h2 {
            font-size: 24px;
        }

        .luxury-banner-content p,
        .luxury-banner-content li {
            font-size: 15px;
        }
    }

    .product-grid {
        display: grid;
        gap: 30px;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }

    .product-card {
        text-align: center;
    }

    .product-image {
        width: 100% !important;
        height: 280px !important;
        object-fit: contain;
    }
</style>

<body>



    @include('frontend.partials.header')








    <div id="desktopCarousel" class="desktop carousel slide" data-bs-ride="carousel">

        <div class="carousel-indicators test-btn container">
            @foreach ($slider as $i => $key)
                <button type="button" data-bs-target="#desktopCarousel" data-bs-slide-to="{{ $i }}"
                    class="{{ $i == 0 ? 'active' : '' }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach ($slider as $i => $key)
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                    <img src="{{ $actual_url . '/admin_assets/sliders/' . $key->desktop_image }}" class="d-block w-100"
                        alt="Jay's Watch Store Images">
                </div>
            @endforeach
        </div>

    </div>

    <div id="mobileCarousel" class="mobile carousel slide" data-bs-ride="carousel">

        <div class="carousel-indicators test-btn container">
            @foreach ($slider as $i => $key)
                <button type="button" data-bs-target="#mobileCarousel" data-bs-slide-to="{{ $i }}"
                    class="{{ $i == 0 ? 'active' : '' }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach ($slider as $i => $key)
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                    <img src="{{ $actual_url . '/admin_assets/sliders/' . $key->mobile_image }}" class="d-block w-100"
                        alt="Jay's Watch Store Images">
                </div>
            @endforeach
        </div>

    </div>



    <section>
        <div class="container-fluid hero-section">
            <div class="container">

                <div class="hero-title">
                    {!! $homecontent->slider_heading !!}
                </div>

                <div class="hero-description about-content">
                    {!! $homecontent->slider_content !!}
                </div>

                <h6 class="read-more about-content">
                    <a href="{{ route('about') }}" class="text-dark bot-border">
                        READ MORE
                    </a>
                </h6>

            </div>
        </div>



        <div class="container-fluid">
            <div class="text-center">
                <h2 class="mb-3" style="font-family: aguila-thin;">

                    {!! $homecontent->watch_list_heading ?? '' !!}

                </h2>
                <p class="mb-0" style="max-width: 850px; margin: 0 auto; line-height: 1.8;">
                   {!! $homecontent->list_top_paragraph ?? '' !!}
                </p>
            </div>
            <div class="product-grid">
                @if (!empty($products) && $products->count())
                    @foreach ($products as $key)
                        @php
                            $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->brandInfo->brand_name ?? '');
                            $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->pro_name ?? '');

                            $manufacturerSlug = \Illuminate\Support\Str::slug($brand_name);
                            $productSlug = \Illuminate\Support\Str::slug($key->pro_name);
                            $skuSuffix = $key->pro_sku ? substr($key->pro_sku, -7) : '0000000';
                        @endphp

                        <div class="product-card">
                            <a href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}"
                                class="card text-decoration-none border-0">

                                <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $key->pro_image }}"
                                    class="product-image" alt="{{ $brand_name }} {{ $pro_name }}">

                                <div class="product-info text-center px-3 pb-3">
                                    <h5>{{ $brand_name }}</h5>
                                    <p>{{ $key->pro_name }}</p>
                                    <p>₹ {{ indian_number_format(round($key->selling_price_exclusive, 2)) }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="text-center">

                <div style="max-width: 850px; margin: 15px auto;">
                    {!! $homecontent->list_bottom_paragraph ?? '' !!}

                </div>
            </div>

        </div>


        </div>


    </section>


    <section class="mb-5">
        <div class="container-fluid home-sell">
            <div class="row row-margin">
                <div class="col-md-8">
                    <img src="{{ $actual_url . '/admin_assets/home_content/' . $homecontent->second_banner_image }}"
                        alt="" class="">
                </div>

            </div>
            <div class="container">
                <div class="sell-trade sell-trade1 sell-trade2">
                    <div class="sell-content text-start">
                        <img src="{{ $actual_url . '/admin_assets/home_content/' . $homecontent->second_top_signature_image }}"
                            alt="" class="sell-img mb-2 img-fluid"><br>
                        <h4><?php echo $homecontent->second_banner_heading; ?></h4>
                        <p class="desc-1">
                            <?php echo $homecontent->second_banner_content; ?>
                        </p>
                        <h6 class="mb-3 mt-4"><a href="" class="text-dark bot-border ">CONTACT US</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="desktop">
        <img src="{{ $actual_url . '/admin_assets/home_content/' . $homecontent->content_image }}" />
    </section>



    <section class="mobile">
        <img src="{{ $actual_url . '/admin_assets/home_content/' . $homecontent->mobile_content_image }}" />
    </section>

    <section class="desktop">
        <img src="{{ $actual_url . '/admin_assets/home_content/' . $homecontent->icon_image }}" />
    </section>
    <section class="mobile">
        <img src="{{ $actual_url . '/admin_assets/home_content/' . $homecontent->mobile_icon_image }}" />
    </section>


    <section class="testimonialSlider12248">
        <div class="container testimonialSlider122">
            <div id="testimonialSlider1" class="carousel slide " data-bs-ride="carousel">
                <div class="carousel-inner car-inner">
                    @if ($clientreview != null)
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($clientreview as $key)
                            <div class="carousel-item @if ($i == 1) active @endif">
                                <div class="testimonial ">
                                    <p>{{ $key->review }}
                                    </p>
                                    <p class="rayomand"><strong>{{ $key->client_name }}</strong>
                                    </p>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    @endif


                </div>

                <div class="carousel-indicators cs-btn">
                    @if ($clientreview != null)
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($clientreview as $key)
                            <button type="button" data-bs-target="#testimonialSlider1"
                                data-bs-slide-to="{{ $i }}"
                                @if ($i == 0) class="active" @endif aria-current="true"
                                aria-label="Slide 1"></button>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    @endif

                </div>
            </div>
    </section>



    <section class="jws-seo-section py-5 d-none">
        <div class="container">

            <!-- Row 1 -->
            <div class="row align-items-center g-4 mb-5">
                <h3 class=" mb-3 text-center">Why Choose Pre Owned Watches from Jay’s Watch Store?</h3>
                <div class="col-lg-6">

                    <div class="seo-card">

                        <p>The demand for pre-owned luxury watches in India is growing rapidly. Today’s buyers prefer
                            pre owned watches because they offer:</p>
                        <ul class="seo-list">
                            <li>Better value compared to retail pricing</li>
                            <li>Access to discontinued or rare models</li>
                            <li>Immediate availability without waiting lists</li>
                            <li>Investment-worthy options</li>
                            <li>Sustainable luxury consumption</li>
                        </ul>
                        <p>
                            Luxury watches are not just fashion statements; they are assets that hold heritage and
                            long-term value. Popular models from Rolex and Omega continue to show strong global demand
                            in the resale market.
                        </p>
                        <p>
                            When you choose used luxury watches from Jay’s Watch Store , you gain
                            access to iconic craftsmanship at competitive prices, backed by expert assurance
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ $actual_url . '/front/image/rolex.webp' }}" class="img-fluid shadow-sm w-100"
                        alt="Jay's Watch Store">
                </div>
            </div>
            <hr>
            <!-- Row 2 -->
            <div class="row align-items-center g-4 mb-5">
                <h3 class=" mb-3 text-center">100% Authentic Pre Owned Watches at Jay’s Watch Store</h3>
                <div class="col-lg-6 order-lg-1 order-2">
                    <img src="{{ $actual_url . '/front/image/omega.webp' }}" class="img-fluid  shadow-sm w-100"
                        alt="Authentic Luxury Watches">
                </div>
                <div class="col-lg-6 order-lg-2 order-1">
                    <div class="seo-card">

                        <p>Authenticity is the most important factor when purchasing second hand watches in India. At
                            Jay’s Watch Store :
                        </p>
                        <ul class="seo-list">
                            <li>Serial numbers are verified</li>
                            <li>Movements are inspected for performance</li>
                            <li>Case, dial, and bracelet conditions are evaluated</li>
                            <li>Watches are tested for accuracy and functionality</li>
                        </ul>

                        <p>We ensure that every pre owned watch sold through Jay’s Watch Store meets strict quality
                            standards. When customers search for buy used watches safely, Jay’s Watch Store
                            provides the trust and transparency they expect</p>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Row 3 -->
            <div class="row align-items-center g-4">
                <h3 class=" mb-3 text-center">Buy Pre Owned Watches with Expert Guidance</h3>
                <div class="col-lg-6">
                    <div class="seo-card">

                        <p>Choosing the right watch can feel overwhelming, especially with so many premium options
                            available. At Jay’s Watch Store , our experts help you select timepieces based on:</p>
                        <ul class="seo-list">
                            <li>Lifestyle and daily wear needs</li>
                            <li>Investment potential</li>
                            <li>Brand heritage and market demand</li>
                            <li>Budget preferences</li>

                        </ul>

                        <p>Whether you want a Rolex Submariner for a bold statement or a Cartier Santos for timeless
                            elegance, Jay’s Watch Store ensures your buying journey is smooth and informed.
                        </p>
                        <p>
                            Buying used luxury watches should feel just as premium as buying new and at
                            Jay’s Watch Store , that is exactly the experience we deliver.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ $actual_url . '/front/image/cartier.webp' }}" class="img-fluid  shadow-sm w-100"
                        alt="Luxury Watch Trade In">
                </div>
            </div>


        </div>
    </section>
    <section class="container-fluid py-5 d-none">
        <div class="row g-4">

            <!-- Left Banner -->
            <div class="col-lg-6">
                <section class="luxury-banner-overlay">
                    <img src="{{ $actual_url . '/front/image/sell.webp' }}" alt="Sell Watch">
                    <div class="luxury-banner-content">
                        <h2>Sell or Trade Your Used Watches at Jay’s Watch Store</h2>
                        <p>
                            In addition to helping clients buy pre owned watches, Jay’s Watch Store also
                            offers:
                        </p>
                        <ul class="seo-list" style="color:#fff!important">
                            <li>Luxury watch buyback service</li>
                            <li>Trade-in options for upgrades</li>
                            <li>Fair and transparent market valuation</li>
                            <li>Instant and secure offers</li>

                        </ul>
                        <p>
                            If you own a pre owned watch and want to upgrade to a new model, Jay’s Watch Store makes the
                            process
                            simple, professional, and secure across all four locations.
                        </p>
                        <p>
                            We continuously update our inventory so you can discover the latest arrivals in
                            pre-owned luxury watches across India.
                        </p>
                        <div class="d-flex justify-content-center gap-3 mt-auto flex-wrap">
                            <a href="{{ route('sell') }}" class="luxury-btn">SELL WATCH</a>
                            <a href="{{ route('trade') }}" class="luxury-btn luxury-btn-outline">TRADE WATCH</a>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Banner -->
            <div class="col-lg-6">
                <section class="luxury-banner-overlay">
                    <img src="{{ $actual_url . '/front/image/buy.webp' }}" alt="Trusted Luxury Watches">
                    <div class="luxury-banner-content">
                        <h2>Why Buyers Across India Trust Jay’s Watch Store</h2>
                        <p>
                            Customers across India choose Jay’s Watch Store because we offer:
                        </p>
                        <ul class="seo-list" style="color:#fff!important">
                            <li>Authentic pre owned watches</li>
                            <li>Transparent and competitive pricing</li>
                            <li>Strong physical store presence in four cities</li>
                            <li>Personalized expert consultation</li>
                            <li>Established reputation in the luxury watch market</li>

                        </ul>
                        <p>Jay’s Watch Store stands out as a reliable, premium, and authoritative choice.</p>
                        <div class="d-flex justify-content-center gap-3 mt-auto flex-wrap">
                            <a href="{{ route('product') }}" class="luxury-btn">EXPLORE NOW</a>

                        </div>

                    </div>

                </section>

            </div>

        </div>
    </section>


    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')


</body>

</html>
