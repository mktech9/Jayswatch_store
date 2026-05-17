<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Dynamically loaded from product view --}}

    @yield('meta')
    <link rel="stylesheet" href="{{ $actual_url . '/front/css/style.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/front/css/responsive.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/front/css/bootstrap.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/front/css/bootstrap-grid.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/front/css/bootstrap-reboot.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/front/css/bootstrap-utilities.css' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!---- Canonical URL ---->
    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
<link rel="shortcut icon" href="{{ $actual_url . '/front/img/favicon.ico' }}" />
 <link href="{{ $actual_url . '/admin_assets/css/select2.min.css' }}" rel="stylesheet">

    <!--Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Q9S45920QM"></script>


           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-Q9S45920QM');
    </script>

    <!--Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '604963402404601');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=604963402404601&ev=PageView&noscript=1" /></noscript>
    <!--End Meta Pixel Code -->



    <meta name="google-site-verification" content="RajgtQyv3Vb60Yy2DIkdkIkiV1hgJJjBmOHAsgD8fcs" />

    <meta name="google-site-verification" content="LRPGAr40jEatWNsYAcDF43_T6-vFbESwRveeJZsnFaQ" />

</head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-SS38EHVVHF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-SS38EHVVHF');
</script>
