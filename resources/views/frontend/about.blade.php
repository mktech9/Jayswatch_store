<!DOCTYPE html>
<html lang="en">
<style>
    .input-group .btn {
        border: 1px solid #9e9e9e85 !important;
        border-radius: 100px;
    }
</style>

<title>{!! $aboutContent->meta_title ?? 'JWS' !!}</title>
<meta name="description" content="{!! $aboutContent->meta_description ?? 'JWS' !!}">
<meta property="og:title" content="About Jay's Watch Store | Passion for Timeless Craftsmanship">
<meta property="og:description"
    content="Learn about Jay's Watch Store and our collection of authentic pre-owned luxury watches. Featuring brands like Rolex, Audemars Piguet, and more.">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="page">

@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')

    @section('title', config('app.name', 'ultimatePOS'))






    <div class="desktop about-backg">
        <img src="{{ $actual_url . '/front/img/aboutus/JWS-AboutUs-07.webp' }}" />
    </div>
    <div class="mobile about-backg">
        <img src="{{ $actual_url . '/front/img/aboutus/bgmobile.webp' }}" />
    </div>
    <section class="aboutusbg">
        <div class="about">
            <div class="container ">
                <div class="about-title text-center text-danger">{!! $aboutContent->about_heading ?? '' !!}</div>
                <div class="text-center about-content">
                    {!! $aboutContent->about_content ?? '' !!}

                </div>

                <div class="row card-top-pad">
                    <div class="col-lg-4 col-md-4 col-sm-4 mb-lg-0 mb-3">
                        <div class="card">
                            <div class="img-content">
                                <img src="{{ $actual_url . '/admin_assets/about_content/' . $aboutContent->section1_image }}"
                                    alt="" class="w-100">
                            </div>
                            <div class="content">
                                <div class="heading mb-3">{!! $aboutContent->section1_heading ?? '' !!} </div>
                                <div class="card__description mb-3">{!! $aboutContent->section1_content ?? '' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mb-lg-0 mb-3">
                        <div class="card">
                            <div class="img-content">
                                <img src="{{ $actual_url . '/admin_assets/about_content/' . $aboutContent->section2_image }}"
                                    alt="" class="w-100">
                            </div>
                            <div class="content">
                                <div class="heading mb-4">{!! $aboutContent->section2_heading ?? '' !!} </div>
                                <div class="card__description mb-3">{!! $aboutContent->section2_content ?? '' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mb-lg-0 mb-3">
                        <div class="card">
                            <div class="img-content">
                                <img src="{{ $actual_url . '/admin_assets/about_content/' . $aboutContent->section3_image }}"
                                    alt="" class="w-100">
                            </div>
                            <div class="content">
                                <div class="heading mb-4">{!! $aboutContent->section3_heading ?? '' !!} </div>
                                <div class="card__description mb-3">{!! $aboutContent->section3_content ?? '' !!}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>


    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')

</body>

</html>
