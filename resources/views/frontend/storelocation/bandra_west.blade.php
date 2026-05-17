<!DOCTYPE html>
<html lang="en">
<title>Luxury Pre-Owned Watch Store in Bandra, Mumbai | Jay's Watch Store</title>
<meta name="description"
    content="Discover Jay's Watch Store in Bandra, Mumbai — your trusted destination for authentic pre-owned luxury watches. Shop Rolex, Omega, Cartier, and more at the best prices.">
<meta property="og:title" content="Luxury Pre-Owned Watch Store in Bandra, Mumbai | Jay's Watch Store">
<meta property="og:description"
    content="Visit Jay's Watch Store in Bandra for a curated collection of certified pre-owned luxury watches from top brands like Rolex, Omega, and Tag Heuer. Explore timeless craftsmanship today.">
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

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .map_address {
                flex-direction: column;
            }

            .map_address .address {
                width: 100%;
            }

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
                <h1>Discover the Finest Luxury Watch Store in Mumbai</h1>
                <p>When it comes to timeless craftsmanship and refined style, luxury watches remain a statement of
                    elegance.
                    If you’re searching for a luxury watch shop in Mumbai, Jay's Watch Store is a trusted name in the
                    city’s
                    premium timepiece market. From brand-new Swiss models to rare vintage finds, our exclusive
                    collection
                    caters to every style and occasion.</p>
                <p>As a renowned luxury watch store in Mumbai, we offer an impressive selection of international brands.
                    Whether you desire a classic Rolex, a bold Tag Heuer, or an iconic Omega, our boutique promises a
                    remarkable lineup paired with expert customer care.</p>
            </div>
        </div>

        <div class="container map_address">
            <div class="address">
                <h2>Bandra West, Mumbai</h2>
                <p>Muzaffar Manor,<br>Plot No. 116/117, near Waterfield Road,<br>Bandra West, Mumbai, Maharashtra 400050
                </p>
                <hr>
                <ul>
                    <li>
                        <a href="tel:+919321387684">
                            <i class="fa fa-phone me-2"></i> +91 9321387684
                        </a>
                    </li>
                    <li>
                        <a href="mailto:infobandra@jayswatchstore.com">
                            <i class="fas fa-envelope me-2"></i> infobandra@jayswatchstore.com
                        </a>
                    </li>
                    <li>
                        <a href="tel:+919321387684">
                            <i class="fa-brands fa-whatsapp me-2"></i></i> +91 9321387684
                        </a>
                    </li>
                    <li>
                        <a href="https://maps.app.goo.gl/nSiTGm1jEEEwgDG18" target="_blank">
                            <i class="fa fa-location-dot me-2"></i> Get Direction
                        </a>
                    </li>
                </ul>

            </div>
            <div class="map_image">
                <img src="{{ $actual_url . '/front/assets/images/store_images/map_image.webp' }}"
                    alt="Map Image of Jay's Watch Store Location">
            </div>
        </div>

        <div class="container">
            <div class="content">
                <h2>Trusted Destination for Pre-Owned Watches in Mumbai</h2>
                <p>For collectors and enthusiasts, pre-owned watches in Mumbai offer a chance to own rare, discontinued,
                    and
                    investment-grade pieces. Jay's Watch Store proudly showcases certified pre-owned watches from names
                    like
                    Jaeger-LeCoultre, Rolex, and Omega. From vintage Rolex Submariners to Omega Speedmasters, every
                    watch
                    comes with authenticity certificates and post-sale services.</p>
                <img src="{{ $actual_url . '/front/assets/images/store_images/store_image.webp' }}"
                    alt="Inside View of Jay's Watch Store">
                <p>Located in the heart of Bandra, Jay's Watch Store offers an elegant setting where luxury meets
                    heritage.
                    Explore luxury brands including Cartier, Hublot, Franck Muller, and IWC. Our expert team,
                    personalized
                    services, and exceptional collection make us a preferred destination for watch enthusiasts.</p>
                <p>Whether seeking used watches in Mumbai, certified pre-owned pieces, or the perfect luxury watch,
                    discover
                    timeless elegance at Jay's Watch Store — where the world’s finest timepieces await.</p>
            </div>
        </div>


        @include('frontend.partials.footer')

        @include('frontend.partials.footer_link')


        @verbatim

            <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "JewelryStore",
  "@id": "https://jayswatchstore.com/store/bandra-west-mumbai#store",
  "name": "Jay’s Watch Store – Bandra West",
  "image": "https://jayswatchstore.com/wp-content/uploads/store-bandra-west-mumbai.jpg",
  "url": "https://jayswatchstore.com/store/bandra-west-mumbai",
  "telephone": "+919321387684",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Muzaffar Manor, Plot No. 116/117, near Waterfield Road",
    "addressLocality": "Bandra West",
    "addressRegion": "Maharashtra",
    "postalCode": "400050",
    "addressCountry": "IN"
  },
  "openingHours": "Mo-Su 11:00-19:00",
  "description": "Premium pre-owned luxury watches available at Jay’s Watch Store Bandra West, Mumbai.",
  "priceRange": "₹₹₹₹",
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "19.0550",
    "longitude": "72.8290"
  }
}
</script>
        @endverbatim


</body>

</html>
