<!DOCTYPE html>
<html lang="en">


    <title>404 Page Not Found | Jay\'s Watch Store</title>
    <meta name="description" content="404 Page Not Found | Jay\'s Watch Store">
    <meta property="og:title" content="404 Page Not Found | Jay\'s Watch Store">
    <meta property="og:description" content="404 Page Not Found | Jay\'s Watch Store">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="page">

@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')



<style>
    .error-page {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 100px 20px;
        font-family: 'Montserrat', sans-serif;
        color: #333;
        background:#eeeeee;
    }
    .error-page img {
        max-width: 200px;
        margin-bottom: 30px;
    }
    .error-page h1 {
        font-size: 120px;
        margin: 0;
        color: #000;
    }
    .error-page h2 {
        font-size: 28px;
        margin-top: 10px;
        color: #666;
    }
    .error-page p {
        font-size: 18px;
        color: #777;
        margin: 20px 0;
    }
    .error-page a {
        display: inline-block;
        padding: 12px 24px;
        background-color: #000;
        color: #fff!important;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
    }
    .error-page a:hover {
        background-color: #444;
    }
</style>

<div class="error-page">
    <img src="{{ $actual_url . '/front/img/logo.png' }}" alt="Jay's Watch Store Logo">
    <h1>404</h1>
    <h2>Oops! Page Not Found</h2>
    <p>It looks like the page you're looking for doesn't exist anymore or might have been moved.</p>
    <a href="{{ url('/') }}">Go to Homepage</a>
</div>
    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')


</body>

</html>

