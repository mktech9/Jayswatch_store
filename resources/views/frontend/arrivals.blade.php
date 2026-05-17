<!DOCTYPE html>
<html lang="en">


<title>Luxury pre-owned watches | Jay's Watch Store. </title>
<meta name="description"
    content="Check out the latest arrivals of luxury pre-owned watches at Jay's Watch Store. Curated selection of authentic timepieces from top brands for collectors and enthusiasts.">
<meta property="og:title" content="Luxury pre-owned watches | Jay's Watch Store. ">
<meta property="og:description"
    content="Check out the latest arrivals of luxury pre-owned watches at Jay's Watch Store. Curated selection of authentic timepieces from top brands for collectors and enthusiasts.">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="page">




<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick-theme.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.css">
@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')
    <style>
        .slick-slide {
            padding: 10px;
        }

        .slick-prev {
            left: -30px;
            transform: rotate(180deg);
        }

        .slick-next {
            right: -30px;
        }

        .slick-next::before,
        .slick-prev::before {
            display: none;
        }

        .slick-prev:hover,
        .slick-prev:focus,
        .slick-next:hover,
        .slick-next:focus {
            color: transparent;
            outline: 0;
            background-image: url(front/img/arrow-slider.png);
        }

        .slick-arrow {
            top: 50%;
            height: 26px;
            width: 14px;
            margin-top: -13px;
            position: absolute;
            font-size: 0;
            cursor: pointer;
            background-color: transparent;
            border: 0;
            background-image: url(front/img/arrow-slider.png);
            background-repeat: no-repeat;
        }
    </style>

    <div class="desktop arrival-bg">
        <img src="{{ $actual_url . '/front/img/arrivals/arrivals.webp' }}" />
    </div>
    <div class="mobile arrival-bg">
        <img src="{{ $actual_url . '/front/img/arrivals/arrivals-mobile.webp' }}" />
    </div>
    <h3 class="text-center all-title">NEW ARRIVALS</h3>

    <div id="demo" class="carousel carousel-dark slide arr-slide" data-bs-ride="carousel" style="display:none;">
        <div class="carousel-inner">
            @if ($products != null)
                @php $i=1; @endphp
                @foreach ($products as $key)
                    @php
                        $manufacturerSlug = \Illuminate\Support\Str::slug($key->manufacturer ?? $key->brand);
                        $productSlug = \Illuminate\Support\Str::slug($key->product);
                        $skuSuffix = substr($key->pro_sku, -7); // last 7 digits

                        $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->brand ?? '');
                        $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->product ?? '');
                    @endphp
                    <div class="carousel-item @if ($i == 1) active @endif">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 product-card">
                                    <a href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}"
                                        class="card">
                                        <img src="{{ !empty($key->pro_image)
                                            ? $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $key->pro_image
                                            : $actual_url . '/front/noimage.jpg' }}"
                                            class="card-img-top px-3 py-3" alt="{{ $key->brand }}"
                                            class="card-img-top py-3" alt="{{ $key->brand }}">
                                        <div class="product-info text-start px-3 py-2">
                                            <h5 class="">{{ $key->brand }}</h5>
                                            <p>{{ $key->product }}</p>
                                            <p class="rupees">₹
                                                {{ indian_number_format(round($key->selling_price_exclusive, 2)) }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                @endforeach
            @endif
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="container">
        <div class="slick-carousel">
            @if ($products != null)
                @foreach ($products as $key)
                    @php
                        $manufacturerSlug = \Illuminate\Support\Str::slug($key->manufacturer ?? $key->brand);
                        $productSlug = \Illuminate\Support\Str::slug($key->product);
                        $skuSuffix = substr($key->pro_sku, -7); // last 7 digits
                        $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->brand ?? '');
                        $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $key->product ?? '');
                    @endphp
                    <div class="product-card">
                        <a href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}"
                            class="card">
                            <img src="{{ !empty($key->pro_image)
                                ? $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $key->pro_image
                                : $actual_url . '/front/noimage.jpg' }}"
                                class="card-img-top px-3 py-3" alt="{{ $key->brand }}">
                            <div class="product-info text-center px-3 py-2">
                                <h5 class="">{{ $key->brand }}</h5>
                                <p>{{ $key->product }}</p>
                                <p class="rupees">₹ {{ indian_number_format(round($key->selling_price_exclusive, 2)) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>

    <script>
        $('.slick-carousel').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            autoplay: true, // ✅ auto slide
            autoplaySpeed: 2000, // speed (2 sec)
            speed: 800, // animation speed
            dots: false,
            responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    </script>

    <div class="container-fluid trending-section ">
        <div class="row row-pad bg-pad2">
            <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 watch-card row-pad">
                <img src="{{ $actual_url . '/front/img/arrivals/newarrival.webp' }}" alt="Rolex Watch on Wrist"
                    class="watch-img">
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 watch-card row-pad align-self-center">
                <div class="top-content">
                    <h3 class=" all-title">TRENDING</h3>
                </div>
                <img src="{{ $actual_url . '/front/img/arrivals/arrivals-watch.png' }}" alt="Rolex Watch"
                    class="watch1-img my-5">
                <div class="bottom-content my-5 mx-2">
                    <p class="ROLEX">CARL F. BUCHERER<br><span>Manero Flyback</span></p>
                    <p class="price">₹ 8,00,000</p>
                </div>
            </div>
        </div>
        <div class="row row-pad bottom-pad bg-pad1 ">
            <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 watch-card bg-watch-card row-pad align-self-center">
                <div class="top-content">
                    <h3 class=" all-title">TRENDING</h3>
                </div>
                <img src="{{ $actual_url . '/front/img/arrivals/arrivals-watch1.png' }}" alt="Santos de Cartier"
                    class="watch1-img ">
                <div class="bottom-content my-5 mx-2">
                    <p class="ROLEX">ROLEX<br><span>Datejust 31MM</span></p>
                    <p class="price">₹ 11,44,000</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 watch-card row-pad">
                <img src="{{ $actual_url . '/front/img/arrivals/newarrival2.webp' }}" alt="Cartier Watch"
                    class="watch-img">
            </div>
        </div>
    </div>
    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')


</body>

</html>
