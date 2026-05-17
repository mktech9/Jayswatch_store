<!DOCTYPE html>
<html lang="en">



<title>Luxury Pre-Owned Watch Store in Bangalore | Jay's Watch Store</title>
<meta name="description"
    content="Shop luxury watches in Bangalore from iconic brands. Find exclusive deals on new and certified pre-owned watches at our trusted luxury watch showroom.">
<meta property="og:title" content="Luxury Pre-Owned Watch Store in Bangalore | Jay's Watch Store">
<meta property="og:description"
    content="Visit Jay’s Watch Store in Bangalore for a wide range of luxury watches from Rolex, Omega, Cartier & more. Explore certified pre-owned watches with authenticity.">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">


@include('frontend.partials.header_link')



<body>
    @include('frontend.partials.header')

    <style>
        .store_section .content {
            padding: 30px 0;
        }

        .store_section .content h1,
        .store_section .content h2 {
            color: #000;
            font-weight: 500;
            font-family: 'aguila-thin';
            font-size: 2rem;
            text-align: left;
        }

        .store_section .content img {
            margin: 30px 0;
            max-width: 100%;
            height: auto;
        }

        .map_address {
            background: #f5f5f5;
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            padding: 0;
        }

        .map_address .address {
            width: 35%;
            padding: 30px;
        }

        .map_address .map_image {
            width: 65%;
        }

        .map_address .address h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: left;
        }

        .map_address ul {
            padding: 0 !important;
            list-style: none;
        }

        .map_address ul li {
            margin-bottom: 10px;
        }

        .map_address ul li a {
            color: #000;
            text-decoration: none;
        }

        .map_address ul li a:hover {
            text-decoration: underline;
        }

        .map_address img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .store_section .address hr {
            margin: 2rem 0;
            border-top: 2px solid #000;
            opacity: 1;
        }

        @media (max-width: 768px) {
            .map_address {
                flex-direction: column;
            }

            .map_address .address,
            .map_address .map_image {
                width: 100%;
            }

            .map_address .address h2 {
                font-size: 1.8rem;
                text-align: left;
            }

            .store_section .address hr {
                display: block;
            }
        }
    </style>

    <section class="store_section">
        <div class="container">
            <div class="content">
                <h1>Find the Best Luxury Watches in Bangalore at Jay’s Watch Store</h1>
                <p>Looking for luxury watches in Bangalore? Visit Jay’s Watch Store, where you’ll find a wide range of
                    beautiful, high-quality watches from the world’s best brands. Whether you’re a collector, a
                    first-time buyer, or someone who loves timeless style, we have something special for you.</p>
                <p>If you’ve been searching for a luxury watch store in Bangalore or hoping to buy a rare piece, our
                    store is the perfect place. Along with brand-new models, we also have certified pre-owned watches in
                    Bangalore that offer great value and look as good as new.</p>
            </div>
        </div>

        <div class="container map_address">
            <div class="address">
                <h2>Phoenix Mall of Asia, Bangalore</h2>
                <p>F-34 Phoenix Mall of Asia,<br>Yelahanka Taluk, Bellary Road,<br>Bengaluru, Karnataka 560092</p>
                <hr>
                <ul>
                    <li>
                        <a href="tel:+918618186597">
                            <i class="fa fa-phone me-2"></i> +91 8618186597
                        </a>
                    </li>
                    <li>
                        <a href="mailto:infobengaluru@jayswatchstore.com">
                            <i class="fas fa-envelope me-2"></i> infobengaluru@jayswatchstore.com
                        </a>
                    </li>
                    <li>
                        <a href="tel:+918618186597">
                            <i class="fa-brands fa-whatsapp me-2"></i> +91 8618186597
                        </a>
                    </li>
                    <li>
                        <a href="https://maps.app.goo.gl/3mR3nxKV666WJu6i8" target="_blank">
                            <i class="fa fa-location-dot me-2"></i> Get Direction
                        </a>
                    </li>
                </ul>
            </div>
            <div class="map_image">
                <img src="{{ $actual_url . '/front/assets/images/store_images/Bangalore_map.jpg' }}"
                    alt="Map Image of Jay's Watch Store Location">
            </div>
        </div>

        <div class="container">
            <div class="content">
                <h2>Why Shop at Jay’s Watch Store in Bangalore?</h2>
                <p>At Jay’s Watch Store Bangalore, we have famous watch brands like Rolex, Omega, Cartier, and Patek
                    Philippe. Every watch we sell is 100% real, carefully checked, and comes with a certificate to prove
                    it.</p>
                <img src="{{ $actual_url . '/front/assets/images/store_images/Banglore_office.jpg' }}"
                    alt="Inside View of Jay's Watch Store">
                <p>We offer fair prices and clear deals, so you always know what you’re paying for. Our friendly and
                    knowledgeable team will help you find the perfect watch whether it’s for a gift, a personal
                    achievement, or a new addition to your collection.</p>
                <p>You can also buy, sell, or trade luxury watches in Bangalore with us. We provide honest prices, quick
                    service, and a safe way to trade or upgrade your watch.</p>
                <p>Follow Jay’s Watch Store Bangalore online for updates on new arrivals, special offers, and
                    limited-edition watches made for true watch lovers.</p>
            </div>
        </div>
    </section>

    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')

    @verbatim
        <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "JewelryStore",
  "@id": "https://jayswatchstore.com/store/bengaluru#store",
  "name": "Jay’s Watch Store – Bengaluru",
  "image": "https://jayswatchstore.com/wp-content/uploads/store-bengaluru.jpg",
  "url": "https://jayswatchstore.com/store/bengaluru",
  "telephone": "+918618186597",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "F-34, Phoenix Mall of Asia, Yelahanka Taluk, Bellary Road",
    "addressLocality": "Bengaluru",
    "addressRegion": "Karnataka",
    "postalCode": "560092",
    "addressCountry": "IN"
  },
  "openingHours": "Mo-Su 10:30-21:30",
  "description": "Discover pre-owned luxury watches at Jay’s Watch Store in Phoenix Mall of Asia, Bengaluru.",
  "priceRange": "₹₹₹₹",
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "13.0707",
    "longitude": "77.5950"
  }
}
</script>
    @endverbatim


</body>

</html>
