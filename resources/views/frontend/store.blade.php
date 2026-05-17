<?php
use Illuminate\Support\Str;
use App\Models\BrandModel;

// Fetch distinct brands not deleted

$brands = BrandModel::where('status', 0)->select('brand_id', 'brand_name', 'brand_img')->distinct()->get();

?>
<!doctype html>
<html lang="en">

<head>


    <!-- End Google Tag Manager -->
    <script>
        var LOCALE = 'en\u002DGB';
        var BASE_URL = 'https\u003A\u002F\u002Fwww.secondmovement.com\u002F';
        var require = {
            'baseUrl': 'https\u003A\u002F\u002Fcdn.secondmovement.com\u002Fstatic\u002Fversion1754375309\u002Ffrontend\u002FEthos\u002Fsmnew\u002Fen_GB'
        };
    </script>
    <title>Jay's Watch Store | We're Here to Help You</title>
    <meta name="description"
        content="Get in touch with Jay's Watch Store for inquiries or support. Visit our stores or contact us.">
    <meta property="og:title" content="Contact Jay's Watch Store | We're Here to Help You">
    <meta property="og:description"
        content="Get in touch with Jay's Watch Store for inquiries or support. Visit our stores or contact us.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="page">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="{{ $actual_url . '/front/store/store.min.css' }}" />

    <script type="text/javascript" src="{{ $actual_url . '/front/store/require.js' }}"></script>

    <link href="{{ $actual_url . '/front/store/delhi-square-one-v-2.min.css' }}" rel="stylesheet" />
    <link href="{{ $actual_url . '/front/store/swiper-bundle.min.css' }}" rel="stylesheet" />
    <link
        href="https://cdn.secondmovement.com/static/version1754375309/frontend/Ethos/smnew/en_GB/css/logo-slider.min.css"
        rel="stylesheet" />



    @include('frontend.partials.header_link')



    <style>
        .store-locator-row {
            min-height: 80vh;
            /*margin-top: 2rem;*/
            /*margin-bottom: 2rem;*/
        }

        .left-panel {
            background: #fafafa;
            /*border-right: 1px solid #e5e5e5;*/
            padding: 2rem 1.5rem 2rem 2rem;
            height: 100%;
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .results-title {
            font-size: 1.1rem;
            color: #222;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .legend {
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 1rem;
            color: #222;
            cursor: pointer;
            padding: 0.3rem 0.5rem;

            transition: background 0.2s, color 0.2s;
            user-select: none;
        }

        .legend-item.active,
        .legend-item:hover {
            /*background: #e6f4ea;*/
            color: #d52c2c;
            font-weight: 600;
        }

        .legend-dot {
            width: 12px;
            height: 12px;

            display: inline-block;
            margin-right: 0.5rem;
            margin-left: 0.2rem;
        }

        .legend-retailer {
            background: #d52c2c;
        }

        .legend-preowned {
            background: #888;
        }

        .legend-service {
            background: #bdbdbd;
        }

        .store-list {
            flex: 1 1 auto;
            background-color: #f8f8f8;

            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .store-item {
            padding: 1.5rem 1.2rem 1.2rem 1.2rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            transition: box-shadow 0.2s;
            position: relative;
        }

        .store-item:hover {
            background-color: #f3f3f3;
        }

        .store-item:last-child {
            margin-bottom: 0;
        }

        .store-info {
            flex: 1 1 auto;
        }

        .store-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #222;
        }

        .store-address {
            color: #444;
            font-size: 1rem;
            margin-bottom: 0.2rem;
            line-height: 1.4;
        }

        .plus-btn {

            border: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #222;
            transition: background 0.2s, border 0.2s;
            padding: 13px 8px;
            line-height: 5px;
            width: 36px;
            background-color: #f3f3f3;
        }

        /*.plus-btn:hover {*/
        /*  background: #e6f4ea;*/
        /*  border: 1px solid #d52c2c;*/
        /*  color: #d52c2c;*/
        /*}*/
        .details-panel {
            background: #fff;
            /*box-shadow: 0 2px 12px rgba(0,0,0,0.06);*/
            padding: 0 0 2rem 0;
            position: absolute;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            min-height: 100vh;
            z-index: 10;
            animation: fadeIn 0.2s;
            overflow-y: auto;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .details-img {
            width: 100%;
            object-fit: cover;
        }

        .details-close {
            position: absolute;
            top: 12px;
            right: 18px;
            background: #f3f3f3;
            border: none;

            width: 32px;
            height: 32px;
            font-size: 1.3rem;
            color: #222;
            cursor: pointer;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .details-close:hover {
            background: #e6f4ea;
            color: #d52c2c;
        }

        .details-content {
            padding: 1.5rem 2rem 0 2rem;
        }

        .details-type {
            color: #d52c2c;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .details-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #222;
            line-height: 1.2;
        }

        .details-address {
            color: #444;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .details-hours {
            margin-bottom: 1.2rem;
        }

        .details-hours strong {
            font-weight: 600;
            margin-right: 0.5rem;
            display: none;
        }

        .details-hours .open {
            color: #d52c2c;
            font-weight: 600;
        }

        .details-directions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.2rem;
            color: #222;
            font-weight: 500;
            cursor: pointer;
            font-size: 1.05rem;
        }

        .details-directions i {
            font-size: 1.2rem;
            color: #d52c2c;
        }

        .details-btn {
            display: block;
            width: 180px;
            margin: 1.5rem auto 0 auto;
            background: #18804b;
            color: #fff;
            border: none;

            padding: 0.8rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .details-btn:hover {
            background: #d52c2c;
        }

        .map-panel {
            padding: 0;
            height: 100%;
            min-height: 70vh;
            display: flex;
            align-items: stretch;
            justify-content: stretch;

            position: sticky;
            top: 0;
            /* Distance from top before it 'sticks' */
            height: 100vh;
            /* Fill full viewport height */
        }

        .map-embed {
            width: 100%;
            height: 100%;
            min-height: 70vh;
            border: none;

            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.04);
        }

        @media (max-width: 991.98px) {
            .store-locator-row {
                flex-direction: column;
            }

            .left-panel {
                border-right: none;
                border-bottom: 1px solid #e5e5e5;
                padding: 1.5rem 1rem 1.5rem 1rem;
                min-height: unset;
            }

            .map-panel {
                min-height: 40vh;
            }

            .map-embed {
                min-height: 40vh;

            }

            .details-content {
                padding: 1.2rem 1rem 0 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .store-locator-row {
                margin-top: 1rem;
                margin-bottom: 1rem;
            }

            .left-panel {
                padding: 1rem 0.5rem 1rem 0.5rem;
            }

            .store-item {
                padding: 1rem 0.7rem 0.7rem 0.7rem;
            }

            .details-content {
                padding: 1rem 0.5rem 0 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .store-locator-row {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }

            .left-panel {
                padding: 0.7rem 0.2rem 0.7rem 0.2rem;
            }

            .store-item {
                padding: 0.7rem 0.3rem 0.5rem 0.3rem;
            }

            .details-content {
                padding: 0.7rem 0.2rem 0 0.2rem;
            }
        }

        /* Existing map and autocomplete styles */
        #map {
            height: 100%;
            min-height: 90vh;
            width: 100%;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #pac-card {
            background-color: #fff;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            box-sizing: border-box;

            margin: 10px 10px 0 0;
            -moz-box-sizing: border-box;
            outline: none;
        }

        #pac-container {
            padding-top: 12px;
            padding-bottom: 12px;
            margin-right: 12px;
        }

        #pac-input {
            background-color: #fff;

            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #acbcc9;
            font-size: 18px;
            font-weight: 400;
            padding: 6px 12px;
        }

        .hidden {
            display: none;
        }

        #panel {
            height: 100%;
            width: null;
            background-color: white;
            position: fixed;
            z-index: 1;
            overflow-x: hidden;
            transition: all .2s ease-out;
        }

        /* .open {
            width: 250px;
        } */

        .place {

            font-size: 1.2em;
            font-weight: 500;
            margin-block-end: 0px;
            padding-left: 18px;
            padding-right: 18px;
        }

        .distanceText {
            color: silver;

            font-size: 1em;
            font-weight: 400;
            margin-block-start: 0.25em;
            padding-left: 18px;
            padding-right: 18px;
        }
    </style>
</head>

<body>

    @include('frontend.partials.header')

    <style>
        /*--- media-query--- */

        @media (max-width: 576px) {
            .form-container {
                padding: 20px;
                margin: 20px;
            }

            .form-container h1 {
                font-size: 1.25rem;
            }
        }

        /* -----contact-us-form----- */
        .contact-section {
            background-color: white;
        }

        .form-container {
            max-width: 703px;
            color: #452c1e;
            margin: 50px auto;
            padding: 30px;
        }

        .contact-textarea {
            border: none !important;

            background-color: #f5f5f5 !important;

        }

        .form-container .form-contact {
            font-size: 24px;
            text-align: center;
        }

        .form-container h1 {
            text-align: center;
            font-size: 45px;
            font-weight: bold;
        }

        .form-container p {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;

        }

        .contact-in {
            background-color: transparent !important;

            border: none !important;
            border-bottom: 1px solid black !important;
            padding-left: 3px !important;
        }

        .check-main {
            font-size: 12px;

        }



        .check-box[type=checkbox]:checked {
            background-color: black;
            border: none !important;
        }

        .check-txt {
            color: black !important;
            font-weight: bold;
        }

        .contact-button {
            background-color: black !important;
            color: white !important;
        }

        .form-select:focus {
            box-shadow: none !important;
        }

        input,
        select {
            padding: .375rem 0 !important;
        }

        input,
        textarea:focus {
            box-shadow: none !important;
        }

        .ttttsss {

            text-transform: uppercase;
            text-align: center;
            font-size: 32px;
        }

        .ttttsss11 {

            font-weight: normal;
            font-size: 25px;
            text-align: center;
            padding-bottom: 1rem;
        }

        .contact-section {
            margin: 70px auto;
        }

        .goback {
            margin-right: 1rem;
            background-color: transparent !important;
            color: #000 !important;
            border: 0;
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        .goback:hover {
            margin-right: 1rem;
            background-color: transparent !important;
            color: #000 !important;
            border: 0;
        }

        .goback:active {
            margin-right: 1rem;
            background-color: transparent !important;
            color: #000 !important;
            border: 0;
        }

        .form-select option {
            padding-left: 1rem;
        }

        option:hover {
            background-color: red;
        }

        .left-panel {
            background-color: #fff;
        }

        .icon {
            width: 100px;
        }

        .logotab {
            width: 20px;
            margin-right: 10px;
            vertical-align: sub;
        }


        .opening-times {

            color: #333;
        }

        .opening-times .status {
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 1rem;
        }

        .opening-times .status .open {
            color: #127749;
            /* green */
        }

        .times-list {
            list-style: none;
            padding: 0 !important;
            margin: 0;
        }

        .day {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            align-items: center;
        }

        .day.active {
            color: #127749;
            /* green text for active day */

        }

        .day.active .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #127749;

            margin-left: 8px;
        }

        .day-name {
            flex: 0 0 50px;
        }

        .hours {
            flex: 1;
            font-weight: normal;
            text-align: left;
            padding-left: 2rem;
        }

        .css-e4xo1y {
            border: none;
            font-style: inherit;
            font-variant: inherit;
            font-stretch: inherit;

            font-optical-sizing: inherit;
            font-size-adjust: inherit;
            font-kerning: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            line-height: normal;
            padding: 0px;
            text-decoration: none;
            user-select: none;
            font-weight: 700;
            --gap: 0.5rem;
            --height: var(--btn-height);
            --padding: 1.875rem;
            -webkit-box-align: center;
            align-items: center;
            box-sizing: border-box;
            color: var(--text, inherit);
            column-gap: var(--gap);
            display: inline-flex;
            font-size: 1rem;
            -webkit-box-pack: center;
            justify-content: center;
            white-space: nowrap;
            background-color: #f3f3f3;
            transition: none;
            cursor: pointer;
            width: 36px;
            height: 36px;

            margin-right: 1rem;
            vertical-align: middle;
        }

        .details-email {
            margin-top: 1rem;
        }

        .details-more {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.2rem;
            color: #222;
            font-weight: 500;
            cursor: pointer;
            font-size: 1.05rem;
            justify-content: left;
        }

        .details-more a {
            background-color: #df0505;
            padding: 10px 30px;

            color: #fff !important;
        }

        .gm-style .gm-style-iw-t {
            display: none !important;
        }





        @media only screen and (min-width: 320px) and (max-width: 767px) {

            #legendTabs {
                display: flex;
                flex-direction: row;
                gap: 10px;
                margin-top: 10px;
                width: 100%;
                overflow: scroll;
            }

            #legendTabs::-webkit-scrollbar {
                height: 5px;
                cursor: pointer;
            }

            .details-panel {
                position: relative;
            }
        }

        .footer_store {
            display: none;
        }

        .store-item {
            cursor: pointer;
        }
    </style>

    <style>
        /* ---- About Boutique ---- */
        .about-boutique {
            padding: 4rem 0 2rem;
        }

        .jws-about-inner {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Hero text */
        .jws-eyebrow {
            display: block;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #b08d57;
            font-weight: 500;
            margin-bottom: 1rem;
            text-align: center;
        }

        .jws-about-title {

            color: #1a1a1a;
            text-align: center;
            line-height: 1.25;
            margin: 0 0 1.25rem;
        }

        .jws-about-lead {
            font-size: 16px;
            color: #555;
            line-height: 1.85;
            text-align: center;
            max-width: 660px;
            margin: 0 auto 1.5rem;
        }

        /* City pills */
        .jws-cities {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .jws-city-pill {
            font-size: 12px;
            border: 1px solid #212529;
            color: #212529;

            padding: 4px 16px;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        /* Divider */
        .jws-gold-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0 0 2.5rem;
        }

        .jws-gold-divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #212529, transparent);
        }

        .jws-gold-divider-diamond {
            width: 8px;
            height: 8px;
            background: #212529;
            transform: rotate(45deg);
            flex-shrink: 0;
        }

        /* Feature cards */
        .jws-feature-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 768px) {
            .jws-feature-cards {
                grid-template-columns: 1fr;
            }
        }

        .jws-feat-card {
            background: #fff;
            border: 1px solid #e7ebee;
            border-top: 3px solid #212529;

            padding: 1.5rem 1.25rem;
            text-align: center;
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }

        .jws-feat-card:hover {
            box-shadow: 0 8px 28px rgba(176, 141, 87, 0.15);
            transform: translateY(-3px);
        }

        .jws-feat-icon {
            width: 44px;
            height: 44px;
            background: #212529;

            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .jws-feat-icon svg {
            width: 20px;
            height: 20px;
        }

        .jws-feat-title {
            font-size: 15px;
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.4rem;
        }

        .jws-feat-desc {
            font-size: 15px;

            line-height: 1.6;
            margin: 0;
        }

        /* Numbered sections */
        .jws-sections {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .jws-num-section {
            display: grid;
            grid-template-columns: 64px 1fr;
            gap: 1.25rem;
            padding: 1.75rem 0;
            border-bottom: 1px solid #f0ebe1;
            align-items: center;
        }

        @media (max-width: 768px) {
            .jws-num-section {
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 1.5rem 0;
                text-align: center;
                justify-items: center;
            }
        }

        .jws-num-section:last-child {
            border-bottom: none;
        }

        .jws-num {
            font-size: 38px;

            color: #212529;
            line-height: 1;
            padding-top: 2px;

        }

        .jws-num-title {
            font-size: 15px;
            font-weight: 500;
            color: #212529;
            margin: 0 0 0.45rem;
        }

        .jws-num-body {
            font-size: 15px;

            line-height: 1.75;
            margin: 0;
        }

        /* Closing quote */
        .jws-closing {
            text-align: center;
            padding: 2.5rem 1rem 0.5rem;
            border-top: 1px solid #f0ebe1;
            margin-top: 2rem;
        }

        .jws-closing-quote {
            font-size: 15px;
            color: #888;
            font-style: italic;
            line-height: 1.7;
            margin: 0 0 1rem;
        }

        .jws-dot-row {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .jws-dot-row span {
            width: 7px;
            height: 7px;

            background: #b08d57;
        }

        .jws-dot-row span:nth-child(1),
        .jws-dot-row span:nth-child(5) {
            opacity: 0.2;
        }

        .jws-dot-row span:nth-child(2),
        .jws-dot-row span:nth-child(4) {
            opacity: 0.5;
        }

        .jws-dot-row span:nth-child(3) {
            opacity: 1;
        }
    </style>


    <style>
        .store-card {
            overflow: hidden;
            background: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
            display: flex;
        }

        .store-card .row {
            flex: 1;
        }

        .store-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 220px;
        }

        .store-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .arrow-link {
            font-size: 14px;
            font-weight: 500;
            color: #000;
            text-decoration: none;
            margin-top: auto;
            /* 🔥 pushes button to bottom */
        }

        .arrow-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 767px) {

            .store-card {
                display: block;
                /* stack layout */
            }

            .store-card .row {
                display: block;
            }

            .store-card .col-5,
            .store-card .col-7 {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
            }

            .store-img {
                height: 220px;
                /* fixed nice height for mobile */
            }
        }
    </style>

    <style>
        .jws-why-visit {
            padding: 50px 0;

        }

        .why-visit-header {
            text-align: center;
            max-width: 850px;
            margin: 0 auto 60px;
        }

        .why-tag {
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #b08d57;
            margin-bottom: 10px;
        }

        .why-visit-header h2 {
            font-size: 42px;
            margin-bottom: 15px;

        }

        .why-visit-header p {
            font-size: 15px;
            line-height: 1.8;

        }

        .why-visit-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        .why-card {
            background: #fff;
            padding: 25px 18px;

            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
            transition: 0.3s ease;
            text-align: center;
            min-height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .why-number {
            display: block;
            font-size: 34px;
            color: #212529;

            margin-bottom: 12px;
        }


        @media (max-width: 992px) {
            .why-visit-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .why-visit-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .why-visit-grid {
                grid-template-columns: 1fr;
            }

            .why-visit-header h2 {
                font-size: 28px;
            }

            .why-card h3 {
                font-size: 18px;
            }

            .why-number {
                font-size: 30px;
            }
        }
    </style>

    <style>
        /* Ecosystem */
        .jws-ecosystem {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 100px;
            align-items: center;
        }

        .eco-tag {
            color: #212529;
            text-transform: uppercase;
            font-size: 15px;
            letter-spacing: 2px;
        }

        .eco-left h2 {

            margin: 15px 0;
        }

        .eco-right {
            display: grid;
            gap: 20px;
        }


        .eco-card {
            background: #fff;
            padding: 28px;

            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
        }

        .eco-card h3 {
            margin-bottom: 8px;

        }

        /* FAQ */

        /* CTA */
        .jws-final-cta {
            position: relative;
            overflow: hidden;
            color: #fff;
            padding: 70px 40px;

            z-index: 1;
        }

        .jws-final-cta::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: -1;
        }

        .jws-final-cta span {

            text-transform: uppercase;
            font-size: 15px;
            letter-spacing: 2px;
        }

        .jws-final-cta h2 {

            margin: 18px 0;
        }


        .jws-cta-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 28px;
            background: #fff;
            color: #212529;
            text-decoration: none;

            font-weight: 600;
        }

        @media (max-width: 576px) {
            .jws-cta-btn {
                display: block;
                width: 100%;
                max-width: 280px;
                margin: 20px auto 0;
                padding: 14px 18px;
                font-size: 14px;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .jws-ecosystem {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .eco-left h2,
            .faq-heading h2,
            .jws-final-cta h2 {
                font-size: 28px;
            }

            .jws-final-cta {
                padding: 50px 25px;
            }
        }
    </style>
    <!-- Add this script at the bottom of your page or in your JS file -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const storeItems = document.querySelectorAll(".store-item");

            storeItems.forEach(item => {
                item.addEventListener("click", function(e) {
                    // Prevent double trigger if user clicks the button
                    if (e.target.classList.contains('plus-btn')) return;

                    // Trigger the plus button click manually
                    this.querySelector(".plus-btn").click();
                });
            });
        });
    </script>

    <div class="page-wrapper">
        <link
            href="https://cdn.secondmovement.com/static/version1754375309/frontend/Ethos/smnew/en_GB/css/sm-v10.min.css"
            rel="stylesheet" />


        <style>
            #mdl-ovrlay {
                background-color: rgba(0, 0, 0, 0.7);
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

                body::before {
                    content: "Please Rotate Your Device";
                    text-align: center;
                    background: #ffffff;
                    width: 100%;
                    position: fixed;
                    height: 100vh;
                    padding-top: 10%;
                    font-size: 20px;
                    z-index: 1500;
                    left: 0;
                    top: 0;
                }

                body::after {
                    content: "";
                    width: 100%;
                    position: fixed;
                    height: 100vh;
                    background: url('https://cdn.secondmovement.com/static/version1754375309/frontend/Ethos/smnew/en_GB/images/landscape.svg') no-repeat center 60%;
                    z-index: 1500;
                    left: 0;
                    top: 0;
                }
            }

            @media (max-width: 1024px) {
                .filter-opened .eoy-sale-head-title-container {
                    z-index: 9;
                }
            }

            @media (max-width: 767px) {
                .customer-account-create .stz-frm.form-create-account .field.field-name-prefix {
                    width: 20%;
                }

                #shipping-new-address-form .field[name*="firstname"],
                .stz-frm.form-create-account .field.field-name-firstname {
                    width: 28%;
                }

                #shipping-new-address-form .field[name*="lastname"],
                .form-create-account .field-name-lastname {
                    margin-left: 3%;
                    width: 46%;
                }

                .wtch-lst a[itemprop="url"] img,
                .scrl-lst .wtch-lst a img {
                    filter: none !important;
                }
            }

            @media (max-width: 400px) {
                .filter-options .am-ranges {
                    height: calc(100dvh - 20px);
                }
            }

            .boutique-hero {
                position: relative !important;
                width: 100%;
                height: 75vh;
                overflow: hidden;
            }

            .boutique-hero-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }


            @media (max-width: 767px) {
                .boutique-hero {
                    height: 55vh;
                    min-height: 420px;
                }
            }

            .boutique-hero {
                position: relative;
            }

            .explore-btn {
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                text-decoration: none !important;
                color: #fff !important;
                background: rgb(247 242 242 / 60%);
                padding: 10px 25px;

                font-size: 15px;
                letter-spacing: 1px;
                transition: 0.3s ease;
                white-space: nowrap;
                z-index: 2;
            }

            .explore-btn:hover {
                background: #fff !important;
                color: #151211 !important;
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .explore-btn {
                    bottom: 15px;
                    padding: 8px 18px;
                    font-size: 12px;

                }
            }

            /* Small Mobile Devices */
            @media (max-width: 480px) {
                .explore-btn {
                    bottom: 12px;
                    padding: 7px 16px;
                    font-size: 11px;
                    letter-spacing: 0.5px;
                }
            }

            .luxury-points {
                list-style: none;
                padding: 0;
                margin: 20px 0 0;
            }

            .luxury-points li {
                position: relative;
                padding-left: 28px;
                margin-bottom: 14px;
                font-size: 15px;
                line-height: 1.7;


            }

            .luxury-points li::before {
                content: "•";
                position: absolute;
                left: 0;
                top: 0;

                /* luxury gold tone */
                font-size: 22px;
                line-height: 1;
            }

            .jws-faq-section {
                padding: 50px 0;
            }

            .faq-heading h2 {

                margin-bottom: 15px;
            }

            .jws-faq-accordion {
                border-top: 1px solid #ddd;
            }

            .faq-row {
                border-bottom: 1px solid #ddd;
                padding: 5px 0;
            }

            .faq-question {
                width: 100%;
                border: none;
                background: none;
                display: flex;
                justify-content: space-between;
                align-items: center;

                font-weight: 400;
                cursor: pointer;
                padding: 0;
                text-align: left;
            }

            .faq-icon {
                font-size: 32px;
                font-weight: 300;
                transition: 0.3s ease;
            }

            .faq-answer {
                max-height: 0;
                overflow: hidden;
                opacity: 0;
                transition: max-height 0.5s ease, opacity 0.3s ease;
            }

            .faq-row.active .faq-answer {
                max-height: 300px;
                /* enough height */
                opacity: 1;
            }

            .faq-answer p {

                line-height: 1.8;
                text-align: left;

                margin: 0;
            }
        </style>

        <main id="maincontent" class="page-main"><a id="contentarea" tabindex="-1"></a>
            <div class="columns">
                <div class="column main"><input name="form_key" type="hidden" value="OFTHy3rhpjnvgmd0" />
                    <div id="authenticationPopup" data-bind="scope:'authenticationPopup'" style="display: none;">

                        <!-- ko template: getTemplate() --><!-- /ko -->

                    </div>




                    <div class="boutique-page">
                        <div class="boutique-hero">
                            <img src="{{ $actual_url . '/front/store/img/bandra.webp' }}" alt="Jay’s Watch Store"
                                class="boutique-hero-img">

                            <div class="boutique-hero-text">
                                <h1>
                                    <span>Jay’s Watch Store</span>
                                </h1>
                                <p>
                                    Step Into Timeless Luxury at Jay’s Watch Store. A refined space to explore certified
                                    pre-owned luxury watches
                                </p>
                            </div>
                            <a href="#next-section" class="explore-btn"> SCROLL TO EXPLORE</a>

                        </div>

                        <div class="about-boutique" id="next-section">
                            <div class="jws-about-inner">

                                {{-- Eyebrow + Heading + Lead --}}

                                <h1 class="jws-about-title">Experience Pre-Owned Luxury Watches<br>Across India</h1>
                                <p class="jws-about-lead mb-3">
                                    A refined space where heritage, craftsmanship, and authenticity come together —
                                    offering an unparalleled horological experience for collectors and first-time buyers
                                    alike.
                                </p>

                                {{-- City pills --}}
                                <div class="jws-cities">
                                    <span class="jws-city-pill">Mumbai</span>
                                    <span class="jws-city-pill">Ahmedabad</span>
                                    <span class="jws-city-pill">Bangalore</span>
                                </div>

                                {{-- Gold divider --}}
                                <div class="jws-gold-divider">
                                    <div class="jws-gold-divider-line"></div>
                                    <div class="jws-gold-divider-diamond"></div>
                                    <div class="jws-gold-divider-line"></div>
                                </div>

                                {{-- Feature cards --}}
                                <div class="jws-feature-cards d-none">
                                    <div class="jws-feat-card">
                                        <div class="jws-feat-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="9" />
                                                <polyline points="12 7 12 12 15 14" />
                                            </svg>
                                        </div>
                                        <div class="jws-feat-title">Meticulously Curated</div>
                                        <p class="jws-feat-desc">Every piece hand-selected for quality, provenance, and
                                            lasting value.</p>
                                    </div>
                                    <div class="jws-feat-card">
                                        <div class="jws-feat-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                            </svg>
                                        </div>
                                        <div class="jws-feat-title">Expertly Authenticated</div>
                                        <p class="jws-feat-desc">Certified pre-owned with full condition reports and
                                            transparent history.</p>
                                    </div>
                                    <div class="jws-feat-card">
                                        <div class="jws-feat-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                            </svg>
                                        </div>
                                        <div class="jws-feat-title">Personal Guidance</div>
                                        <p class="jws-feat-desc">One-on-one consultation with horology experts at every
                                            boutique.</p>
                                    </div>
                                </div>

                                {{-- Numbered paragraphs --}}
                                <div class="jws-sections d-none">
                                    <div class="jws-num-section">
                                        <div class="jws-num">01</div>
                                        <div>
                                            <div class="jws-num-title" style="text-transform: uppercase;">A legacy of
                                                craftsmanship</div>
                                            <p class="jws-num-body">
                                                Step into the world of certified pre-owned luxury watches at Jay’s Watch
                                                Store — where heritage, craftsmanship, and authenticity come together to
                                                create an unparalleled horological experience. Each timepiece in our
                                                collection is meticulously curated, expertly authenticated, and
                                                thoughtfully presented to reflect the legacy of the world’s most
                                                prestigious watchmakers.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="jws-num-section">
                                        <div class="jws-num">02</div>
                                        <div>
                                            <div class="jws-num-title" style="text-transform: uppercase;">Boutiques
                                                designed as luxury lounges</div>
                                            <p class="jws-num-body">
                                                With a growing presence across Mumbai, Ahmedabad, and Bangalore, our
                                                boutiques are designed as sophisticated luxury lounges, offering a
                                                refined and personalized experience for both seasoned collectors and
                                                first-time buyers. Whether you are seeking a timeless investment piece
                                                or a statement of style, our experts guide you through every detail with
                                                precision and care.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="jws-num-section">
                                        <div class="jws-num">03</div>
                                        <div>
                                            <div class="jws-num-title" style="text-transform: uppercase;">Beyond
                                                retail — lasting relationships</div>
                                            <p class="jws-num-body">
                                                At Jay’s Watch Store, we go beyond retail — we create lasting
                                                relationships built on trust, transparency, and a deep passion for fine
                                                watchmaking. From iconic classics to rare finds, every watch tells a
                                                story, and we are here to help you find the one that defines yours.

                                            </p>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>

                        <div class="boutique-gallery">
                            <div class="container">

                                <div class="slider-nav d-lg-block">
                                    <!-- Add Arrows -->
                                    <a class="swiper-button-next next"> <img
                                            src="https://images.secondmovement.com/media/special-pages/boutique/dso/sm-slider-arrow-right.svg"
                                            alt="" width="16" /></a>
                                    <a class="swiper-button-prev prev"> <img
                                            src="https://images.secondmovement.com/media/special-pages/boutique/dso/sm-slider-arrow-left.svg"
                                            alt="" width="16" /></a>
                                </div>

                                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                                    class="swiper-container mySwiper2">

                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <picture>
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe1.webp' }}"
                                                    media="(max-width: 767px)" />
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe1.webp' }}"
                                                    media="(min-width: 768px)" />
                                                <img src="{{ $actual_url . '/front/store/img/swipe1.webp' }}"
                                                    alt="" width="100%" />
                                            </picture>
                                        </div>

                                        <div class="swiper-slide">
                                            <picture>
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe2.webp' }}"
                                                    media="(max-width: 767px)" />
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe2.webp' }}"
                                                    media="(min-width: 768px)" />
                                                <img src="{{ $actual_url . '/front/store/img/swipe2.webp' }}"
                                                    alt="" width="100%" />
                                            </picture>
                                        </div>

                                        <div class="swiper-slide">
                                            <picture>
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe3.webp' }}"
                                                    media="(max-width: 767px)" />
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe3.webp' }}"
                                                    media="(min-width: 768px)" />
                                                <img src="{{ $actual_url . '/front/store/img/swipe3.webp' }}"
                                                    alt="" width="100%" />
                                            </picture>
                                        </div>

                                        <div class="swiper-slide">
                                            <picture>
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe4.webp' }}"
                                                    media="(max-width: 767px)" />
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe4.webp' }}"
                                                    media="(min-width: 768px)" />
                                                <img src="{{ $actual_url . '/front/store/img/swipe4.webp' }}"
                                                    alt="" width="100%" />
                                            </picture>
                                        </div>
                                        <div class="swiper-slide">
                                            <picture>
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe5.webp' }}"
                                                    media="(max-width: 767px)" />
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe5.webp' }}"
                                                    media="(min-width: 768px)" />
                                                <img src="{{ $actual_url . '/front/store/img/swipe5.webp' }}"
                                                    alt="" width="100%" />
                                            </picture>
                                        </div>
                                        <div class="swiper-slide">
                                            <picture>
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe6.webp' }}"
                                                    media="(max-width: 767px)" />
                                                <source srcset="{{ $actual_url . '/front/store/img/swipe6.webp' }}"
                                                    media="(min-width: 768px)" />
                                                <img src="{{ $actual_url . '/front/store/img/swipe6.webp' }}"
                                                    alt="" width="100%" />
                                            </picture>
                                        </div>
                                    </div>
                                    <div class="swiper-thumb"></div>
                                </div>


                            </div>
                        </div>

                        <hr />
                        <div class="what-we-offer mb-4">
                            <div class="container">
                                <div class="provide-offer">
                                    <figure class="order-1">
                                        <picture>
                                            <source
                                                srcset="https://images.secondmovement.com/media/special-pages/boutique/dso/secondtime-studio-mobile@2x.jpg"
                                                media="(max-width:767px)" />
                                            <source
                                                srcset="https://images.secondmovement.com/media/special-pages/boutique/dso/secondtime-studio@2x.jpg"
                                                media="(min-width:768px)" />
                                            <img src="https://images.secondmovement.com/media/special-pages/boutique/dso/secondtime-studio@2x.jpg"
                                                alt="" width="100%" />
                                        </picture>
                                    </figure>
                                    <div class="offer-text">

                                        <h1 class="mb-2"> A Premium Luxury <br /> Watch Experience</h1>
                                        <p>
                                            Jay’s Watch Store is more than a retail space, it is a destination for
                                            horology enthusiasts
                                        </p>

                                        <ul class="luxury-points">
                                            <li>Sophisticated, lounge-style interiors</li>
                                            <li>Curated display of iconic luxury timepieces</li>
                                            <li>Personalized, one-on-one consultation</li>
                                            <li>A seamless offline luxury buying experience</li>
                                        </ul>
                                        <div class="linkWrap">
                                            <a class="arrow-link ctClickNew d-inline-flex align-items-center gap-2"
                                                href="{{ route('product') }}" target="_blank" title="Visit Us">
                                                <span>Explore Our Collection</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="provide-offer">
                                    <figure>
                                        <picture>
                                            <source
                                                srcset="https://images.secondmovement.com/media/special-pages/boutique/dso/peerless-quality-standard-mobile@2x.jpg"
                                                media="(max-width:767px)" />
                                            <source
                                                srcset="https://images.secondmovement.com/media/special-pages/boutique/dso/peerless-quality-standard@2x.jpg"
                                                media="(min-width:768px)" />
                                            <img src="https://images.secondmovement.com/media/special-pages/boutique/dso/peerless-quality-standard@2x.jpg"
                                                alt="" width="100%" />
                                        </picture>
                                    </figure>
                                    <div class="offer-text">

                                        <h1 class="mb-2"> Certified Pre-Owned Watches <br /> You Can Trust</h1>
                                        <p>
                                            Every timepiece at Jay’s Watch Store undergoes strict quality checks and
                                            authentication.
                                        </p>

                                        <ul class="luxury-points">
                                            <li>100% Authentic Luxury Watches</li>
                                            <li>Fully Serviced & Inspected Timepieces</li>
                                            <li>Certified Pre-Owned Guarantee</li>
                                            <li>Transparent Condition Reports</li>
                                        </ul>
                                        <p>
                                            We bring international standards of luxury resale to India, ensuring every
                                            watch meets collector-level expectations.
                                        </p>
                                        <div class="linkWrap">
                                            <a class="arrow-link ctClickNew d-inline-flex align-items-center gap-2"
                                                href="{{ route('contact') }}" target="_blank" title="Visit Us">
                                                <span>Contact Us For More Information</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr />



                        <section class="jws-store-locations py-5">
                            <div class="container">

                                <h2 class="store-main-title text-center mb-5">Explore Our Store Locations</h2>

                                <div class="row g-4">

                                    <!-- Lower Parel -->
                                    <div class="col-md-6">
                                        <div class="store-card">
                                            <div class="row g-0">
                                                <div class="col-5">
                                                    <img src="{{ $actual_url . '/front/store/img/lowerparel.webp' }}"
                                                        class="store-img">
                                                </div>
                                                <div class="col-7">
                                                    <div class="store-body">

                                                        <h4>Mumbai – Lower Parel (Flagship Boutique)</h4>
                                                        <h5>Jay’s Watch Store – Lower Parel</h5>

                                                        <p class="small">
                                                            G-7, Ground Floor, Phoenix Palladium<br>
                                                            462, Senapati Bapat Marg<br>
                                                            Lower Parel, Mumbai, Maharashtra 400013
                                                        </p>

                                                        <p class="small"><strong>Phone:</strong> +91 8269786786</p>
                                                        <p class="small"><strong>Email:</strong>
                                                            info@jayswatchstore.com</p>

                                                        <p class="small text-muted">
                                                            Experience our flagship boutique located in Mumbai’s most
                                                            premium luxury destination.
                                                        </p>

                                                        <a href="{{ route('lower_parel_mumbai') }}" target="_blank"
                                                            class="arrow-link">
                                                            Visit Our Boutique →
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bandra -->
                                    <div class="col-md-6">
                                        <div class="store-card">
                                            <div class="row g-0">
                                                <div class="col-5">
                                                    <img src="{{ $actual_url . '/front/store/img/bandra_loc.jpg' }}"
                                                        class="store-img">
                                                </div>
                                                <div class="col-7">
                                                    <div class="store-body">

                                                        <h4>Mumbai – Bandra West</h4>
                                                        <h5>Jay’s Watch Store – Bandra West</h5>

                                                        <p class="small">
                                                            Muzaffar Manor, Plot No. 116/117<br>
                                                            Near Waterfield Road<br>
                                                            Bandra West, Mumbai, Maharashtra 400050
                                                        </p>

                                                        <p class="small"><strong>Phone:</strong> +91 9321387684</p>
                                                        <p class="small"><strong>Email:</strong>
                                                            infobandra@jayswatchstore.com</p>

                                                        <p class="small text-muted">
                                                            A boutique designed for Mumbai’s luxury lifestyle audience
                                                            in the heart of Bandra.
                                                        </p>

                                                        <a href="{{ route('bandra_west_mumbai') }}" target="_blank"
                                                            class="arrow-link">
                                                            Visit Our Boutique →
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ahmedabad -->
                                    <div class="col-md-6">
                                        <div class="store-card">
                                            <div class="row g-0">
                                                <div class="col-5">
                                                    <img src="{{ $actual_url . '/front/store/img/ahmedabad_loc.jpg' }}"
                                                        class="store-img">
                                                </div>
                                                <div class="col-7">
                                                    <div class="store-body">

                                                        <h4>Ahmedabad – Palladium Mall</h4>
                                                        <h5>Jay’s Watch Store – Ahmedabad</h5>

                                                        <p class="small">
                                                            F-29, First Floor, Palladium Ahmedabad<br>
                                                            Near Sarkhej - Gandhinagar Hwy<br>
                                                            Thaltej, Ahmedabad, Gujarat 380054
                                                        </p>

                                                        <p class="small"><strong>Phone:</strong> +91 7990590199</p>
                                                        <p class="small"><strong>Email:</strong>
                                                            infoahmedabad@jayswatchstore.com</p>

                                                        <p class="small text-muted">
                                                            Serving Gujarat’s luxury watch collectors with a curated
                                                            premium selection.
                                                        </p>

                                                        <a href="{{ route('ahmedabad_gujarat') }}" target="_blank"
                                                            class="arrow-link">
                                                            Visit Our Boutique →
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bangalore -->
                                    <div class="col-md-6">
                                        <div class="store-card">
                                            <div class="row g-0">
                                                <div class="col-5">
                                                    <img src="{{ $actual_url . '/front/store/img/bangalore_loc.jpg' }}"
                                                        class="store-img">
                                                </div>
                                                <div class="col-7">
                                                    <div class="store-body">

                                                        <h4>Bangalore – Phoenix Mall of Asia</h4>
                                                        <h5>Jay’s Watch Store – Bangalore</h5>

                                                        <p class="small">
                                                            F-34, Phoenix Mall of Asia<br>
                                                            Yelahanka Taluk, Bellary Road<br>
                                                            Bengaluru, Karnataka 560092
                                                        </p>

                                                        <p class="small"><strong>Phone:</strong> +91 8618186597</p>
                                                        <p class="small"><strong>Email:</strong>
                                                            infobengaluru@jayswatchstore.com</p>

                                                        <p class="small text-muted">
                                                            A premium destination for luxury watch enthusiasts in
                                                            Bangalore.
                                                        </p>

                                                        <a href="{{ route('bangalore_karnataka') }}" target="_blank"
                                                            class="arrow-link">
                                                            Visit Our Boutique →
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>



                        <section class="jws-why-visit">
                            <div class="container">
                                <div class="why-visit-header">

                                    <h2>Why Visit Jay’s Watch Store?</h2>
                                    <p>
                                        Experience India’s trusted destination for certified pre-owned luxury watches,
                                        crafted for collectors, enthusiasts, and first-time buyers.
                                    </p>
                                </div>

                                <div class="why-visit-grid">
                                    <div class="why-card">
                                        <span class="why-number">01</span>
                                        <h5>Multi-city luxury boutique presence</h5>
                                    </div>

                                    <div class="why-card">
                                        <span class="why-number">02</span>
                                        <h5>Certified pre-owned luxury watches</h5>
                                    </div>

                                    <div class="why-card">
                                        <span class="why-number">03</span>
                                        <h5>Personalized consultation experience</h5>
                                    </div>

                                    <div class="why-card">
                                        <span class="why-number">04</span>
                                        <h5>Access to rare & collectible timepieces</h5>
                                    </div>

                                    <div class="why-card">
                                        <span class="why-number">05</span>
                                        <h5>Trusted by collectors across India</h5>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <section class="jws-ecosystem-faq">
                            <div class="container">

                                <!-- Buy Sell Trade -->


                                <!-- TOP CONTENT -->
                                <div class="text-center mb-5">
                                    <span class="text-uppercase text-muted small d-block" style="letter-spacing:2px;">
                                        Luxury Watch Services
                                    </span>

                                    <h2 class="fw-semibold mt-2">
                                        Buy, Sell & Trade Luxury Watches
                                    </h2>

                                    <p class="text-muted mt-2">
                                        Jay’s Watch Store offers a complete ecosystem:
                                    </p>
                                </div>

                                <!-- CARDS -->
                                <div class="row g-4">

                                    <!-- BUY -->
                                    <div class="col-md-4">
                                        <div
                                            class="bg-light p-4 text-center h-100 d-flex flex-column justify-content-between">

                                            <div>
                                                <h3 class="mb-2">Buy</h3>
                                                <p class="text-muted small">
                                                    Shop certified pre-owned luxury watches
                                                </p>
                                            </div>

                                            <div class="mt-auto">
                                                <a href="{{ route('product') }}"
                                                    class="btn btn-dark  px-4 py-2 text-white">
                                                    Explore Watches
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- SELL -->
                                    <div class="col-md-4">
                                        <div
                                            class="bg-light p-4 text-center h-100 d-flex flex-column justify-content-between">

                                            <div>
                                                <h3 class="mb-2">Sell</h3>
                                                <p class="text-muted small">
                                                    Get the best value for your watch
                                                </p>
                                            </div>

                                            <div class="mt-auto">
                                                <a href="{{ route('sell') }}"
                                                    class="btn btn-dark  px-4 py-2 text-white">
                                                    Sell Your Watch
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- TRADE -->
                                    <div class="col-md-4">
                                        <div
                                            class="bg-light p-4 text-center h-100 d-flex flex-column justify-content-between">

                                            <div>
                                                <h3 class="mb-2">Trade</h3>
                                                <p class="text-muted small">
                                                    Upgrade seamlessly with exchange options
                                                </p>
                                            </div>

                                            <div class="mt-auto">
                                                <a href="{{ route('trade') }}"
                                                    class="btn btn-dark  px-4 py-2 text-white">
                                                    Trade Your Watch
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>




                                <section class="lxry-brds d-none">
                                    <div class="flx-jusfy container">
                                        <h2 class="sec-ttl">
                                            Luxury brands <span>worthy of a collector</span>
                                            <a href="{{ route('product') }}" class="vAll ctClickNew"
                                                title="View All">
                                                Shop now
                                            </a>
                                        </h2>
                                    </div>

                                    <div class="lxry-brds-wrpr">
                                        <div class="lxry-brds-lists">

                                            {{-- Row 1 --}}
                                            <ul class="lxry-brds-list">
                                                @foreach ($brands as $brand)
                                                    <li class="hexagon">
                                                        <a href="{{ url('preowned-' . preg_replace('/[^A-Za-z0-9\.\-]/', '-', strtolower($brand->brand_name))) }}"
                                                            class="ctClickNew" title="{{ $brand->brand_name }}">
                                                            <span class="lxry-brds-incs">
                                                                @if (!empty($brand->brand_img))
                                                                    <img src="{{ $actual_url . '/brand_images/' . $brand->brand_img }}"
                                                                        alt="{{ $brand->brand_name }}"
                                                                        class="brand-logo-img">
                                                                @else
                                                                    <span class="brand-name-text">
                                                                        {{ $brand->brand_name }}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            {{-- Row 2 same full data --}}
                                            <ul class="lxry-brds-list reverse-row">
                                                @foreach ($brands as $brand)
                                                    <li class="hexagon">
                                                        <a href="{{ url('preowned-' . preg_replace('/[^A-Za-z0-9\.\-]/', '-', strtolower($brand->brand_name))) }}"
                                                            class="ctClickNew" title="{{ $brand->brand_name }}">
                                                            <span class="lxry-brds-incs">
                                                                @if (!empty($brand->brand_img))
                                                                    <img src="{{ $actual_url . '/brand_images/' . $brand->brand_img }}"
                                                                        alt="{{ $brand->brand_name }}"
                                                                        class="brand-logo-img">
                                                                @else
                                                                    <span class="brand-name-text">
                                                                        {{ $brand->brand_name }}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>

                                </section>

                                <div class="jws-faq-section">
                                    <div class="faq-heading">
                                        <h2>Frequently Asked Questions</h2>
                                    </div>

                                    <div class="jws-faq-accordion">

                                        @foreach ($store_faq as $key => $faq)
                                            <div class="faq-row {{ $key == 0 ? 'active' : '' }}">

                                                <button class="faq-question">
                                                    <span>{{ $faq->question }}</span>
                                                    <span class="faq-icon">{{ $key == 0 ? '−' : '+' }}</span>
                                                </button>

                                                <div class="faq-answer">
                                                    <p>{{ $faq->answer }}</p>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <!-- CTA -->
                                {{-- <div class="jws-final-cta"
                                    style="background: url('{{ $actual_url . '/front/store/img/swipe1.webp' }}') center center / cover no-repeat;">
                                    <span>Visit Jay’s Watch Store Today</span>
                                    <h2>Experience the finest collection of pre-owned luxury watches in India</h2>
                                    <p class="text-white">
                                        Across Mumbai, Ahmedabad, and Bangalore, step into a boutique near you
                                        and discover timeless luxury.
                                    </p>
                                    <a href="#store-locations" class="jws-cta-btn">Find a Boutique Near You</a>
                                </div> --}}

                            </div>



                            <section id="store-locations">
                                <div class="container-fluid p-0" style="background-color: #f8f8f8;">
                                    <div class="store-locator-row d-flex">
                                        <!-- Left Panel: Filters & Store List -->
                                        <div class="col-lg-4 left-panel position-relative p-0">
                                            <div class="p-3">
                                                <div class="results-title mb-2">Results in <span
                                                        style="color:#d52c2c;font-weight:600;">India</span></div>
                                                <hr>
                                                <div class="legend mb-4" id="legendTabs">
                                                    <div class="legend-item" data-city="mumbai"><span><img
                                                                src={{ $actual_url . '/front/map-box/img/pi1n.png' }}
                                                                class="logotab" /></span>Mumbai</div>
                                                    <div class="legend-item" data-city="ahmedabad"><span><img
                                                                src={{ $actual_url . '/front/map-box/img/pi1n.png' }}
                                                                class="logotab" /></span>Ahmedabad</div>
                                                    <div class="legend-item" data-city="bengaluru"><span><img
                                                                src={{ $actual_url . '/front/map-box/img/pi1n.png' }}
                                                                class="logotab" /></span>Bengaluru</div>
                                                </div>
                                            </div>
                                            <div class="store-list p-2" id="storeList">
                                                <div class="store-item" data-type="retailer" data-id="1"
                                                    data-city="mumbai">
                                                    <div class="store-info">
                                                        <div class="store-title">Phoenix Palladium, Mumbai</div>
                                                        <div class="store-address">G-7. Ground Floor, Phoenix
                                                            Palladium,
                                                            462, Senapati Bapat
                                                            Marg. Lower Parel. Mumbai, Maharashtra 400013.</div>
                                                    </div>
                                                    <button class="plus-btn" title="More info">+</button>
                                                </div>
                                                <div class="store-item" data-type="retailer" data-id="2"
                                                    data-city="mumbai">
                                                    <div class="store-info">
                                                        <div class="store-title">Bandra West, Mumbai</div>
                                                        <div class="store-address">Muzaffar Manor, Plot No. 116/117,
                                                            near
                                                            Waterfield Road,
                                                            Bandra West Mumbai, Maharashtra 400050</div>
                                                    </div>
                                                    <button class="plus-btn" title="More info">+</button>
                                                </div>
                                                <div class="store-item" data-type="retailer" data-id="3"
                                                    data-city="ahmedabad">
                                                    <div class="store-info">
                                                        <div class="store-title">Palladium, Ahmedabad</div>
                                                        <div class="store-address">F-29, First Floor, Palladium
                                                            Ahmedabad,
                                                            near, Sarkhej -
                                                            Gandhinagar Hwy, Thaltej, Ahmedabad,Gujarat 380054</div>
                                                    </div>
                                                    <button class="plus-btn" title="More info">+</button>
                                                </div>
                                                <div class="store-item" data-type="retailer" data-id="4"
                                                    data-city="bengaluru">
                                                    <div class="store-info">
                                                        <div class="store-title">Phoenix Mall Of Asia, Bengaluru</div>
                                                        <div class="store-address">F-34 Phoenix Mall of Asia, Yelahanka
                                                            Taluk, Bellary Road,
                                                            Bengaluru, Karnataka 560092</div>
                                                    </div>
                                                    <button class="plus-btn" title="More info">+</button>
                                                </div>
                                            </div>
                                            <!-- Details panel placeholder -->
                                            <div id="detailsPanel" style="display:none;"></div>
                                        </div>
                                        <!-- Right Panel: Map -->
                                        <div class="col-lg-8 map-panel p-0">
                                            <!-- Google Map -->
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!--Munesh Patel Start-->


                    </div>

                    <script>
                        require(["jquery", "js/swiper.min"], function($, Swiper) {
                            $(function() {



                                var swiper = new Swiper(".mySwiper2", {
                                    loop: true,
                                    navigation: {
                                        nextEl: ".swiper-button-next",
                                        prevEl: ".swiper-button-prev",
                                    },
                                    pagination: {
                                        el: ".swiper-thumb",
                                        clickable: true,
                                        renderBullet: function(index, className) {
                                            const thumbs = [
                                                "{{ $actual_url . '/front/store/img/swipe1.webp' }}",
                                                "{{ $actual_url . '/front/store/img/swipe2.webp' }}",
                                                "{{ $actual_url . '/front/store/img/swipe3.webp' }}",
                                                "{{ $actual_url . '/front/store/img/swipe4.webp' }}",
                                                "{{ $actual_url . '/front/store/img/swipe5.webp' }}",
                                                "{{ $actual_url . '/front/store/img/swipe6.webp' }}"
                                            ];

                                            return `
        <div class="${className}">
            <img src="${thumbs[index]}" alt="thumb-${index + 1}" width="100%" />
        </div>
    `;
                                        }
                                    },
                                });

                            })
                        })
                    </script>

                    <style>
                        .swiper-thumb .swiper-pagination-bullet {
                            max-width: 16%;
                        }
                    </style>
                </div>
            </div>
        </main>


    </div>
    @include('frontend.partials.footer')
    @include('frontend.partials.footer_link')



    <script src={{ $actual_url . '/front/map-box/app.js' }}></script>

    <script>
        function generateOpeningTimes(timingsArray) {
            const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const currentDay = new Date().getDay(); // 0 = Sunday, ..., 6 = Saturday

            let html = '<div class="opening-times">';
            html += '<p class="status">Opening times <span class="open">Currently open</span></p>';
            html += '<ul class="times-list">';

            for (let i = 0; i < dayNames.length; i++) {
                const activeClass = (i === currentDay) ? 'day active' : 'day';
                const dotSpan = (i === currentDay) ? '<span class="dot"></span>' : '';
                html +=
                    `<li class="${activeClass}"><span class="day-name">${dayNames[i]}</span> <span class="hours">${timingsArray[i]}</span> ${dotSpan}</li>`;
            }

            html += '</ul></div>';
            return html;
        }
        window.activeCity = null;

        // Tab filtering logic
        function showStoresByCity(city) {
            window.activeCity = city; // remember last active city

            const cityCenters = {
                mumbai: {
                    lat: 19.0760,
                    lng: 72.8777
                },
                ahmedabad: {
                    lat: 23.0634,
                    lng: 72.5070
                },
                bengaluru: {
                    lat: 13.1007,
                    lng: 77.5946
                }
            };

            if (window.map && cityCenters[city]) {
                if (city === 'mumbai') {
                    // Set default Mumbai center and zoom (no bounds)
                    window.map.setCenter(cityCenters[city]);
                    window.map.setZoom(12);
                } else {
                    // Other cities
                    window.map.setCenter(cityCenters[city]);
                    window.map.setZoom(12);
                }
            }

            // Show only relevant stores for the city
            document.querySelectorAll('.store-item').forEach(item => {
                item.style.display = item.getAttribute('data-city') === city ? '' : 'none';
            });
        }

        // On page load, show only 'retailer' stores
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.store-item').forEach(item => {
                item.style.display = '';
            });

            // Remove active tab highlighting
            document.querySelectorAll('.legend-item').forEach(tab => {
                tab.classList.remove('active');
            });

            // Handle tab clicks
            document.querySelectorAll('.legend-item').forEach(function(tab) {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.legend-item').forEach(function(t) {
                        t.classList.remove('active');
                    });
                    tab.classList.add('active');

                    var city = tab.getAttribute('data-city');
                    showStoresByCity(city);

                    // Hide store list panel (if any) and close details
                    document.getElementById('detailsPanel').style.display = 'none';
                    document.getElementById('storeList').style.display = '';
                });
            });

            // Store details data (for demo, static; in real use, fetch from backend or data attr)
            const storeDetails = {
                1: {
                    type: 'Official Jays Watch Store',
                    name: 'Phoenix Palladium, Mumbai',
                    address: 'G-7. Ground Floor, Phoenix Palladium,<br> 462, Senapati Bapat Marg., Lower Parel.<br> Mumbai, Maharashtra 400013.',
                    gmaps: 'https://goo.gl/maps/4Qw1Qw1Qw1Qw1Qw1A',
                    contact: '+918269786786',
                    email: 'info@jayswatchstore.com',
                    timings: generateOpeningTimes([
                        '10:30 am - 9:30 pm', // Sun
                        '10:30 am - 9:30 pm', // Mon
                        '10:30 am - 9:30 pm', // Tue
                        '10:30 am - 9:30 pm', // Wed
                        '10:30 am - 9:30 pm', // Thu
                        '10:30 am - 9:30 pm', // Fri
                        '10:30 am - 9:30 pm' // Sat
                    ]),
                    image: 'public/assets/front/map-box/img/Palladium-desktop-min.jpg',
                    detailsUrl: "{{ route('lower_parel_mumbai') }}",
                    lat: 19.017614,
                    lng: 72.856164
                },
                2: {
                    type: 'Official Jays Watch Store',
                    name: 'Bandra West, Mumbai',
                    address: 'Muzaffar Manor,<br> Plot No. 116/117, near Waterfield Road,<br> Bandra West Mumbai, Maharashtra 400050',
                    gmaps: 'https://goo.gl/maps/2Qw2Qw2Qw2Qw2Qw2A',
                    contact: '+919321387684',
                    email: 'infobandra@jayswatchstore.com',
                    timings: generateOpeningTimes([
                        '11:00 am - 07:00 pm', // Sun
                        '11:00 am - 07:00 pm', // Mon
                        '11:00 am - 07:00 pm', // Tue
                        '11:00 am - 07:00 pm', // Wed
                        '11:00 am - 07:00 pm', // Thu
                        '11:00 am - 07:00 pm', // Fri
                        '11:00 am - 07:00 pm' // Sat
                    ]),
                    image: 'public/assets/front/map-box/img/Mumbai-desktop-min.jpg',
                    detailsUrl: "{{ route('bandra_west_mumbai') }}",
                    lat: 19.060792,
                    lng: 72.834204
                },
                3: {
                    type: 'Official Jays Watch Store',
                    name: 'Palladium, Ahmedabad',
                    address: 'F-29, First Floor,<br> Palladium Ahmedabad, <br>near, Sarkhej - Gandhinagar Hwy, Thaltej,<br> Ahmedabad,Gujarat 380054',
                    gmaps: 'https://goo.gl/maps/3Qw3Qw3Qw3Qw3Qw3A',
                    contact: '+917990590199',
                    email: 'infoahmedabad@jayswatchstore.com',
                    timings: generateOpeningTimes([
                        '10:30 am - 9:30 pm', // Sun
                        '10:30 am - 9:30 pm', // Mon
                        '10:30 am - 9:30 pm', // Tue
                        '10:30 am - 9:30 pm', // Wed
                        '10:30 am - 9:30 pm', // Thu
                        '10:30 am - 9:30 pm', // Fri
                        '10:30 am - 9:30 pm' // Sat
                    ]),
                    image: 'public/assets/front/map-box/img/Ahmedabad-desktop-min.jpg',
                    detailsUrl: "{{ route('ahmedabad_gujarat') }}",
                    lat: 23.071014,
                    lng: 72.515091
                },
                4: {
                    type: 'Official Jays Watch Store',
                    name: 'Phoenix Mall Of Asia, Bengaluru',
                    address: 'F-34 Phoenix Mall of Asia,<br> Yelahanka Taluk, Bellary Road, <br>Bengaluru, Karnataka 560092',
                    gmaps: 'https://goo.gl/maps/5Qw5Qw5Qw5Qw5Qw5A',
                    contact: '+918618186597',
                    email: 'infobengaluru@jayswatchstore.com',
                    timings: generateOpeningTimes([
                        '10:30 am - 9:30 pm', // Sun
                        '10:30 am - 9:30 pm', // Mon
                        '10:30 am - 9:30 pm', // Tue
                        '10:30 am - 9:30 pm', // Wed
                        '10:30 am - 9:30 pm', // Thu
                        '10:30 am - 9:30 pm', // Fri
                        '10:30 am - 9:30 pm' // Sat
                    ]),
                    image: 'public/assets/front/map-box/img/Ahmedabad-desktop-min.jpg',
                    detailsUrl: "{{ route('bangalore_karnataka') }}",
                    lat: 13.120556,
                    lng: 77.5946
                }
            };

            document.querySelectorAll('.plus-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    var storeItem = btn.closest('.store-item');
                    var id = storeItem.getAttribute('data-id');
                    var details = storeDetails[id];
                    if (!details) return;

                    // Build details HTML
                    var html = `
      <div class="details-panel">
        <button class="details-close" id="closeDetails" title="Close">&times;</button>
        <img class="details-img" src="${details.image}" alt="Store">
        <div class="details-content">
          ${details.type ? '<div class="details-type">' + details.type + '</div>' : ''}
          <div class="details-title">${details.name}</div>
          <div class="details-address">${details.address}</div><hr>
          <div class="details-contact"><strong>Contact:</strong> ${details.contact}</div>
          <div class="details-email"><strong>Email:</strong> ${details.email}</div>
          <div class="details-hours"><strong>Store Timings:</strong> ${details.timings}</div>
          <div class="details-more"><a href="${details.detailsUrl}">Visit Store</a></div>
        </div>
      </div>
    `;

                    var panel = document.getElementById('detailsPanel');
                    panel.innerHTML = html;
                    panel.style.display = '';
                    document.getElementById('storeList').style.display = 'none';

                    // Close button logic
                    document.getElementById('closeDetails').onclick = function() {
                        panel.style.display = 'none';
                        document.getElementById('storeList').style.display = '';
                        if (window.activeCity) {
                            showStoresByCity(window.activeCity);
                        }
                    };

                    // Pan and zoom the map directly using store coordinates
                    if (window.map && details.lat && details.lng) {
                        var pos = {
                            lat: details.lat,
                            lng: details.lng
                        };
                        window.map.setCenter(pos);
                        window.map.setZoom(13);

                        // Open an info window
                        if (!window._storeInfoWindow) {
                            window._storeInfoWindow = new google.maps.InfoWindow();
                        }
                        window._storeInfoWindow.setContent('<b>' + details.name + '</b><br>' +
                            details.address);
                        window._storeInfoWindow.setPosition(pos);
                        window._storeInfoWindow.open(window.map);
                    }
                });
            });

        });

        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.parentElement;
                const answer = row.querySelector('.faq-answer');
                const isActive = row.classList.contains('active');

                // Close all
                document.querySelectorAll('.faq-row').forEach(item => {
                    item.classList.remove('active');
                    item.querySelector('.faq-icon').textContent = '+';

                    const ans = item.querySelector('.faq-answer');
                    ans.style.maxHeight = null;
                });

                // Open current
                if (!isActive) {
                    row.classList.add('active');
                    row.querySelector('.faq-icon').textContent = '−';

                    answer.style.maxHeight = answer.scrollHeight + "px";
                }
            });
        });
    </script>





    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdyuN2cq54Oh9EHMpOy-Y1qzV0hJ2WjYc&libraries=places&callback=initMap&solution_channel=GMP_codelabs_simplestorelocator_v1_a">
    </script>


</body>

</html>
