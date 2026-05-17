<!DOCTYPE html>
<html lang="en">



<title>Luxury Pre owned Watch Store in Ahmedabad | Jay's Watch Store</title>
<meta name="description"
    content="Discover premium timepieces at the best luxury watch shop in Ahmedabad. Explore new & pre-owned watches from top brands near you at unbeatable prices.">
<meta property="og:title" content="Luxury Pre owned Watch Store in Ahmedabad | Jay's Watch Store">
<meta property="og:description"
    content="Explore iconic new and certified pre-owned luxury watches from Rolex, Omega, Cartier, and more at Jay’s Watch Store in Ahmedabad.">
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

        <!--<img src="{{ asset('front/assets/images/store_images/JayswatchAhemdabadbanner.webp') }}" alt="Map Image of Jay's Watch Store Location">-->

        <div class="container">
            <div class="content">
                <h1>Ahmedabad’s Premier Luxury Watch Destination</h1>
                <p>Looking for a luxury watch store in Ahmedabad with an exclusive collection of the world’s most
                    prestigious timepieces? Your search ends at Jay's Watch Store. We offer a handpicked selection of
                    iconic luxury watches, perfect for discerning collectors, enthusiasts, and style connoisseurs who
                    value craftsmanship, prestige, and timeless design.</p>
                <p>Our boutique blends tradition with modern sophistication. Whether you're typing ‘luxury watch shop
                    near me’ or exploring Ahmedabad for a statement piece, Jay's Watch Store promises a refined,
                    welcoming experience every time.</p>
            </div>
        </div>

        <div class="container map_address">
            <div class="address">
                <h2>Palladium Ahmedabad</h2>
                <p>F-29, First Floor, Palladium Ahmedabad,<br>Near Sarkhej - Gandhinagar Hwy,<br>Thaltej, Ahmedabad,
                    Gujarat 380054</p>
                <hr>
                <ul>
                    <li>
                        <a href="tel:+917990590199">
                            <i class="fa fa-phone me-2"></i> +91 7990590199
                        </a>
                    </li>
                    <li>
                        <a href="mailto:infoahmedabad@jayswatchstore.com">
                            <i class="fas fa-envelope me-2"></i> infoahmedabad@jayswatchstore.com
                        </a>
                    </li>
                    <li>
                        <a href="tel:+917990590199">
                            <i class="fa-brands fa-whatsapp me-2"></i> +91 7990590199
                        </a>
                    </li>
                    <li>
                        <a href="https://maps.app.goo.gl/bb1GEE2jAt8NQmU39" target="_blank">
                            <i class="fa fa-location-dot me-2"></i> Get Direction
                        </a>
                    </li>
                </ul>
            </div>
            <div class="map_image">
                <img src="{{ $actual_url . '/front/assets/images/store_images/Ahemdabad_map.jpg' }}"
                    alt="Map Image of Jay's Watch Store Location">
            </div>
        </div>

        <div class="container">
            <div class="content">
                <h2>Why Choose Jay’s Watch Store for Your Next Luxury Watch</h2>
                <p>Discover premium timepieces from the world’s finest brands, including Rolex, Omega, Cartier, and
                    more. Every watch in our collection is 100% authentic, meticulously inspected, and comes with a
                    certificate of authenticity giving you complete peace of mind.</p>
                <img src="{{ $actual_url . '/front/assets/images/store_images/Ahmedabad_office.jpg' }}"
                    alt="Inside View of Jay's Watch Store">
                <p>We’re known for our transparent pricing, competitive deals, and exclusive seasonal offers, making
                    luxury watches more accessible than ever. Our passionate, knowledgeable team is always ready to
                    offer personalized guidance, whether you’re making an investment, marking a milestone, or adding to
                    your collection.</p>
                <p>At Jay’s Watch Store, you can also buy, sell, and trade luxury watches in Ahmedabad. From securing
                    rare, limited-edition timepieces to trading in your current watch for something new, we ensure a
                    smooth, reliable, and hassle-free experience.</p>
                <p>Stay connected with us online for updates on our latest arrivals, exclusive collections, and special
                    promotions tailored for true watch enthusiasts.</p>
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
  "@id": "https://jayswatchstore.com/store/ahmedabad#store",
  "name": "Jay’s Watch Store – Ahmedabad",
  "image": "https://jayswatchstore.com/wp-content/uploads/store-ahmedabad.jpg",
  "url": "https://jayswatchstore.com/store/ahmedabad",
  "telephone": "+917990590199",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "F-29, First Floor, Palladium Ahmedabad, near Sarkhej-Gandhinagar Hwy, Thaltej",
    "addressLocality": "Ahmedabad",
    "addressRegion": "Gujarat",
    "postalCode": "380054",
    "addressCountry": "IN"
  },
  "openingHours": "Mo-Su 10:30-21:30",
  "description": "Jay’s Watch Store Ahmedabad offers certified pre-owned luxury watches with authenticity guarantee.",
  "priceRange": "₹₹₹₹",
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "23.0365",
    "longitude": "72.5253"
  }
}
</script>
    @endverbatim

</body>

</html>
