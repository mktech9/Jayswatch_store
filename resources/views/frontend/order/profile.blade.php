<!DOCTYPE html>
<html lang="en">


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css" />
@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')
    <style>
        :root {
            --bg: #ffffff;
            --text: #262626;
            --muted: #6b6b6b;
            --border: #e6e6e6;
            --accent: #000;
            /* plum/wine */
            --accent-50: #4a3a4f10;
            --danger: #B00020;
            --success: #27AE60;
            --card: #fafafa;
            --focus: #8a7990;
            --shadow: 0 10px 30px rgba(0, 0, 0, .06);
            --radius: 14px;
        }

        * {
            box-sizing: border-box
        }

        .jws-account {
            background: var(--bg);
            color: var(--text)
        }

        .jws-account .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 64px
        }

        .jws-account .title {
            font-size: 34px;
            letter-spacing: .06em;
            text-align: center;
            margin: 8px 0 28px;
            color: var(--accent);
            font-weight: 500
        }

        .jws-account .layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 24px;
            align-items: start;
            padding: 20px;
            background: #f5f5f5;
            /*border-radius: 20px;*/
        }

        .primary {
            background: #212529 !important;
        }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 16px;
            background: var(--bg);
            border: 1px solid var(--border);
            /*border-radius: var(--radius);*/
            box-shadow: var(--shadow);
            overflow: hidden
        }

        .profile-card {
            padding: 10px;
            border-bottom: 1px solid var(--border);
            display: grid;
            grid-template-columns: 72px 1fr;
            gap: 16px;
            align-items: center
        }

        .avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 2px solid var(--border);
            object-fit: cover;
            display: block
        }

        .edit-photo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px dashed var(--accent);
            color: var(--accent);
            background: transparent;
            padding: 8px 10px;
            /*border-radius: 999px;*/
            font-size: 12px;
            cursor: pointer
        }

        .hidden-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none
        }

        .nav {
            display: grid;
            padding: 6px
        }

        .nav button {
            text-align: left;
            background: transparent;
            border: 0;
            padding: 12px 16px;
            /*border-radius: 10px;*/
            font-size: 15px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer
        }

        .nav button[aria-current="page"] {
            background: var(--accent-50);
            color: var(--accent);
            font-weight: 600
        }

        .nav button:hover {
            background: #00000008
        }

        /* Main panels */
        .panel {
            background: var(--bg);
            border: 1px solid var(--border);
            /*border-radius: var(--radius);*/
            box-shadow: var(--shadow);
            padding: 22px;
            display: none
        }

        .panel.active {
            display: block
        }

        .section-title {
            font-size: 20px;
            margin: 0 0 16px;
            color: var(--accent)
        }

        .grid-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        label {
            font-size: 13px;
            color: var(--muted);
            display: block;
            margin-bottom: 6px
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            /*border-radius: 10px;*/
            background: #fff;
            color: var(--text)
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid var(--focus);
            border-color: var(--focus)
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 14px
        }

        .btn {
            border: 0;
            /*padding:12px 16px;*/
            /*border-radius: 10px;*/
            font-weight: 600;
            cursor: pointer
        }

        .btn.primary {
            background: var(--accent);
            color: #fff
        }

        .btn.ghost {
            background: transparent;
            border: 1px solid var(--border)
        }

        .btn.danger {
            background: var(--danger);
            color: #fff
        }

        /* Orders */
        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table th,
        .table td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid var(--border)
        }

        .table th {
            font-size: 13px;
            color: var(--muted);
            font-weight: 600
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            /*border-radius: 999px;*/
            font-size: 12px;
            border: 1px solid var(--border)
        }

        .status.delivered {
            background: #f2fbf5;
            color: var(--success);
            border-color: #dff3e4
        }

        .status.processing {
            background: var(--accent-50);
            color: var(--accent);
            border-color: #e8e2eb
        }

        .status.cancelled {
            background: #fff3f5;
            color: var(--danger);
            border-color: #ffdce2
        }

        /* Wishlist */
        .wishlist {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px
        }

        .product {
            border: 1px solid var(--border);
            /*border-radius: var(--radius);*/
            padding: 14px;
            background: #fff;
            display: grid;
            grid-template-rows: auto 1fr auto
        }

        .product img {
            width: 100%;
            height: 160px;
            object-fit: contain
        }

        .product h4 {
            font-size: 15px;
            margin: 8px 0 4px
        }

        .price {
            font-weight: 600
        }

        .product .row {
            display: flex;
            gap: 8px;
            margin-top: 10px
        }

        /* Address */
        .address-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px
        }

        .address-card {
            border: 1px solid var(--border);
            /*border-radius: var(--radius);*/
            padding: 16px;
            background: #fff
        }

        .address-card h4 {
            margin: 0 0 6px;
            color: var(--accent)
        }

        .muted {
            color: var(--muted);
            font-size: 14px
        }

        .add-card {
            border: 1px dashed var(--accent);
            background: #fff;
            color: var(--accent);
            display: grid;
            place-items: center;
            padding: 26px;
            /*border-radius: var(--radius);*/
            cursor: pointer
        }

        /* Modal */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            display: none;
            align-items: center;
            justify-content: center
        }

        .modal.open {
            display: flex
        }

        .modal .box {
            background: #fff;
            /*border-radius: 16px;*/
            width: min(520px, 100%);
            border: 1px solid var(--border);
            box-shadow: var(--shadow)
        }

        .modal header {
            padding: 16px 18px;
            border-bottom: 1px solid var(--border);
            font-weight: 700;
            color: var(--accent)
        }

        .modal .content {
            padding: 18px
        }

        .modal footer {
            padding: 12px 18px 18px;
            display: flex;
            justify-content: flex-end;
            gap: 10px
        }

        /* Responsive */
        @media (max-width:980px) {
            .jws-account .layout {
                grid-template-columns: 1fr
            }

            .sidebar {
                position: static
            }

            .wishlist {
                grid-template-columns: repeat(2, 1fr)
            }

            .address-list {
                grid-template-columns: 1fr
            }
        }

        @media (max-width:600px) {
            .grid-two {
                grid-template-columns: 1fr
            }

            .wishlist {
                grid-template-columns: 1fr
            }
        }


        .email-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .email-wrapper input {
            padding-right: 90px;
            /* space for badge */
        }

        .verify-badge {
            position: absolute;
            right: 10px;
            background: #28a745;
            color: #fff;
            font-size: 12px;
            padding: 3px 8px;
            /*border-radius: 12px;*/
            cursor: default;
            white-space: nowrap;
        }

        /* Tooltip */
        .verify-badge::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 130%;
            right: 0;
            background: #000;
            color: #fff;
            font-size: 11px;
            padding: 6px 8px;
            border-radius: 4px;
            opacity: 0;
            visibility: hidden;
            transition: 0.2s;
            white-space: nowrap;
        }

        .verify-badge::before {
            content: '';
            position: absolute;
            bottom: 115%;
            right: 10px;
            border: 6px solid transparent;
            border-top-color: #000;
            opacity: 0;
            visibility: hidden;
        }

        .verify-badge:hover::after,
        .verify-badge:hover::before {
            opacity: 1;
            visibility: visible;
        }

        .primary_address {
            color: #ffffff;
            font-size: 14px;
            background: #28a745;
            padding: 5px 10px;
            /*border-radius: 20px;*/
        }


        /* ===== RESPONSIVE TABLE ===== */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        /* Mobile layout */
        @media (max-width: 768px) {

            .orders-table thead {
                display: none;
            }

            .orders-table,
            .orders-table tbody,
            .orders-table tr,
            .orders-table td {
                display: block;
                width: 100%;
            }

            .orders-table tr {
                background: #fff;
                border: 1px solid var(--border);
                border-radius: 12px;
                padding: 12px;
                margin-bottom: 14px;
            }

            .orders-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
                font-size: 14px;
            }


            .orders-table td[data-label="Action"] {
                flex-direction: column;
                align-items: stretch;
                gap: 6px;
            }

            .orders-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--muted);
            }

            .orders-table td:last-child {
                margin-top: 8px;
                justify-content: flex-end;
            }

            .orders-table .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
    <style>
        /* ===== SELL FORM UI FIXES ===== */
        #panel-sells .step {
            padding: 10px 0;
        }

        #panel-sells h4 {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #212529;
        }

        #panel-sells label {
            font-size: 13px;
            font-weight: 500;
            color: #555;
            margin-bottom: 6px;
            display: block;
        }

        #panel-sells input:not([type="checkbox"]),
        #panel-sells select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 0px;
            font-size: 14px;
            background: #fff;
            margin-bottom: 4px;
        }

        #panel-sells .form-check-input {

            padding: 0 !important;
            margin-top: 0.25em;
        }

        .form-check-input:checked {
            background-color: #151211;
            /* Bootstrap primary */
            border-color: #151211;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* intl-tel-input full width fix */
        #panel-sells .iti {
            width: 100%;
        }

        #panel-sells .iti input {
            width: 100% !important;
        }

        /* OTP + button row */
        #panel-sells .input-btn-otp-wrap {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        #panel-sells .input-btn-otp-wrap .iti {
            flex: 1;
        }

        /* OTP boxes */
        #panel-sells .otp-digit {
            display: flex;
            gap: 8px;
            flex: 1;
        }

        #panel-sells .otp-digit input {
            width: 42px !important;
            height: 42px;
            text-align: center;
            padding: 0;
            font-size: 16px;
            font-weight: 600;

            border: 1px solid #ccc;
            flex: 1;
        }

        #panel-sells .otp-digit-btn-wrap {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Get OTP / Verify button */
        #panel-sells .getotp {
            white-space: nowrap;
            padding: 10px 14px;
            background: #212529;
            color: #fff;

            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 44px;
        }

        #panel-sells .getotp:hover {
            background: #000;
        }

        /* Step navigation buttons */
        #panel-sells .next-step,
        #panel-sells .back-step {
            padding: 10px 24px;
            /*border-radius: 8px;*/
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #212529;
            cursor: pointer;
            margin-top: 14px;
        }

        #panel-sells .next-step {
            background: #212529;
            color: #fff;
        }

        #panel-sells .back-step {
            background: transparent;
            color: #212529;
        }

        #panel-sells .d-flex {
            display: flex;
            gap: 10px;
        }

        #panel-sells .actn-btn {
            background: #212529;
            color: #fff;

            padding: 10px 24px;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;
            margin-top: 14px;
        }

        /* Resend timer */
        #panel-sells .wait-otp {
            font-size: 12px;
            color: #555;
            margin-top: 6px;
            display: block;
        }

        /* Upload area */
        #panel-sells .upld-img {
            border: 2px dashed #ddd;

            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            position: relative;
            margin-bottom: 18px;
            transition: 0.3s;
            background: #fafafa;
        }

        #panel-sells .upld-img input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        #panel-sells .file-msg {
            display: block;
            font-size: 12px;
            color: #888;
            margin-top: 4px;
        }

        @media (max-width: 600px) {
            #panel-sells .input-btn-otp-wrap {
                flex-wrap: wrap;
            }

            #panel-sells .getotp {
                width: 100%;
                justify-content: center;
            }
        }
    </style>


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

        /* .action-buttons .buy-btn {
    min-height: 48px;
    border-radius: 12px;
    font-weight: 600;
}

.action-buttons .icon-btn {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-size: 18px;
} */

        @media (max-width: 768px) {

            /* Phone + Get OTP */
            .send-enter-otp-wrap .input-btn-otp-wrap {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .send-enter-otp-wrap .input-btn-otp-wrap input,
            .send-enter-otp-wrap .input-btn-otp-wrap .iti {
                width: 100% !important;
            }

            .send-enter-otp-wrap .input-btn-otp-wrap .getotp {
                width: 100%;
                justify-content: center;
                max-width: 100%;
            }

            /* OTP boxes + verify */
            .send-enter-otp-wrap .otp-digit-btn-wrap {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .send-enter-otp-wrap .otp-digit {
                width: 100% !important;
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                gap: 6px;
            }

            .send-enter-otp-wrap .otp-digit input {
                width: 100% !important;
                height: 42px;
            }

            .send-enter-otp-wrap .submitotp {
                width: 100%;
                max-width: 100%;
                justify-content: center;
            }

            .wait-otp {
                display: block;
                margin-top: 8px;
                text-align: center;
            }
        }

        .form-select {
            border-radius: 0 !important;
        }
    </style>


    <div class="jws-account">
        <div class="wrap">
            <h1 class="title">My Account</h1>

            <div class="layout" role="application">
                <!-- SIDEBAR -->
                <aside class="sidebar" aria-label="Account navigation">
                    <div class="profile-card">
                        <img id="avatar" class="avatar"
                            src="{{ $cust_data && $cust_data->profile_pic
                                ? $actual_url . '/front/uploads/customer_profile/' . $cust_data->profile_pic
                                : $actual_url . '/front/user-icon.jpg' }}"
                            alt="Profile photo" />

                        <div>
                            <div style="font-weight:700">{{ $cust_data->full_name }}</div>
                            <div class="muted" style="margin-bottom:10px">{{ $cust_data->email }}</div>
                            <button class="edit-photo" id="editPhotoBtn" type="button"
                                aria-label="Change profile photo">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    aria-hidden="true">
                                    <path
                                        d="M9 3l-1.5 2H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-2.5L15 3H9z"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="12" cy="12" r="4" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                                Edit photo
                            </button>
                            <input id="photoInput" type="file" accept="image/*" class="hidden-input" />
                        </div>
                    </div>
                    <nav class="nav" id="nav">
                        <button data-target="panel-profile" aria-current="page"> Profile</button>
                        <button data-target="panel-cart"> Cart</button>
                        <button data-target="panel-sells"> Sells</button>
                        <button data-target="panel-orders"> Ordered</button>
                        <button data-target="panel-wishlist"> Wishlist</button>

                        <button type="button" data-target="panel-password" id="openPwd">
                            Change Password
                        </button>
                        <button data-target="panel-address"> Address</button>
                        <button data-target="panel-logout"> Logout</button>
                    </nav>
                </aside>

                <!-- MAIN -->
                <main>
                    <!-- PROFILE -->
                    <section id="panel-profile" class="panel active" aria-labelledby="tab-profile" role="tabpanel">
                        <h2 class="section-title">Profile</h2>
                        <div class="grid-two">
                            <div>
                                <label for="name">Full name</label>
                                <input id="name" type="text" placeholder="Your name"
                                    value="{{ $cust_data->full_name }}" />
                            </div>
                            <div>
                                <label for="email">Email address</label>

                                <div class="email-wrapper">
                                    <input id="email" class="email-validator verified" type="email"
                                        value="{{ $cust_data->email }}" readonly
                                        title="Your email account is verified" />

                                    <span class="verify-badge" data-tooltip="Your email account is verified">
                                        ✓ Verified
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label for="phone">Phone</label>
                                <input id="phone" type="tel" placeholder="Enter phone number">
                            </div>

                        </div>

                        <!-- Left side -->


                        <!-- Right side -->
                        <div class="actions mt-4">
                            <button class="btn ghost" type="button" id="discardProfile">Discard</button>
                            <button class="btn primary" type="button" id="saveProfile">Save</button>
                        </div>




                    </section>

                    <!-- ORDERS -->
                    <section id="panel-orders" class="panel" role="tabpanel">
                        <h2 class="section-title">Your Ordered</h2>

                        <div class="table-responsive">
                            <table class="table orders-table" aria-describedby="ordersHelp">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td data-label="Order #">{{ $order->order_id }}</td>
                                            <td data-label="Date">
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                                            </td>
                                            {{-- <td data-label="Status">
                                                @if ($order->status == 2)
                                                    <span class="status processing">Processing</span>
                                                @elseif($order->status == 3)
                                                    <span class="status delivered">Shipped</span>
                                                @elseif($order->status == 4)
                                                    <span class="status delivered">Delivered</span>
                                                @endif
                                            </td> --}}
                                            <td data-label="Status">

                                                <span
                                                    style="
        background:#d1fae5;
        color:#065f46;
        padding:6px 14px;

        display:inline-block;
    ">
                                                    {{ $order->track_status ?? '-' }}
                                                </span>

                                            </td>
                                            <td data-label="Total">
                                                ₹ {{ indian_number_format($order->total, 2) }}
                                            </td>
                                            <td data-label="Action">

                                                <button class="btn ghost" type="button"
                                                    onclick="window.open('{{ route('profileinvoice-page', ['o_id' => $order->o_id, 'order_id' => $order->order_id]) }}', '_blank')">

                                                    View

                                                </button>

                                                {{-- ✅ TRACK BUTTON FOR BOMBEX --}}
                                                @if ($order->delivery_type == 'bombex' && !empty($order->tracking_num))
                                                    <button class="btn ghost" type="button"
                                                        onclick="window.open('{{ route('ordertracking', ['tracking_num' => $order->tracking_num, 'order_id' => $order->order_id]) }}', '_blank')">

                                                        Track

                                                    </button>
                                                @endif


                                                {{-- ✅ INTERNAL DELIVERY BUTTON --}}
                                                @if ($order->delivery_type == 'internal')
                                                    <button class="btn ghost" type="button"
                                                        onclick="window.open('{{ route('internal.order.tracking', ['order_id' => $order->order_id]) }}', '_blank')">

                                                        Track

                                                    </button>
                                                @endif



                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                No Processing or Delivered orders found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <p id="ordersHelp" class="muted mt-2">
                            Click <b>View</b> to see shipment details and invoices.
                        </p>
                    </section>


                    <!-- WISHLIST -->
                    <section id="panel-wishlist" class="panel" role="tabpanel">
                        <h2 class="section-title">Wishlist</h2>

                        <div class="wishlist">

                            @if ($wishlist->count() > 0)

                                @foreach ($wishlist as $item)
                                    @php
                                        $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? '');
                                        $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->pro_name ?? '');

                                        $manufacturerSlug = \Illuminate\Support\Str::slug($brand_name);
                                        $productSlug = \Illuminate\Support\Str::slug($item->pro_name);
                                        $skuSuffix = $item->pro_sku ? substr($item->pro_sku, -7) : '0000000';
                                    @endphp

                                    <article class="product">

                                        <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $item->pro_image }}"
                                            alt="{{ $item->pro_name }}" />

                                        <h4 class="text-center">{{ $item->pro_name }}</h4>

                                        <div class="muted text-center">
                                            {{ $item->dial_color ?? 'N/A' }} • {{ $item->case_material }}
                                        </div>

                                        <p class="mt-1 text-center">
                                            ₹ {{ indian_number_format($item->selling_price_exclusive, 2) }}
                                        </p>
                                        <div
                                            class="d-flex align-items-center justify-content-between gap-2 mt-2 action-buttons">
                                            @if ($item->out_stock == 1)
                                                <!-- ❌ OUT OF STOCK -->
                                                <button class="btn btn-danger custom-btn flex-grow-1 text-center"
                                                    type="button" style="font-size: 12px !important;" disabled>
                                                    Out of Stock
                                                </button>
                                            @else
                                                <!-- ✅ ADD TO CART -->
                                                <button
                                                    class="btn btn-dark cart-btn custom-btn flex-grow-1 text-center"
                                                    type="button" style="font-size: 12px !important;"
                                                    data-productname="{{ $item->pro_name }}"
                                                    data-id="{{ $item->pro_id }}">
                                                    Add to Cart
                                                </button>
                                            @endif

                                            <!-- 👁 VIEW -->
                                            <a href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}"
                                                class="btn btn-light icon-btn">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <!-- 🗑 REMOVE -->
                                            <button class="btn btn-light icon-btn text-danger remove-wishlist"
                                                data-id="{{ $item->pro_id }}" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                    </article>
                                @endforeach
                            @else
                                <p>No wishlist items found.</p>

                            @endif

                        </div>
                    </section>

                    <!-- CART -->
                    <section id="panel-cart" class="panel">
                        <h2 class="section-title">Cart</h2>

                        <div class="wishlist" id="cart-panel-body">
                            <!-- dynamic content here -->
                        </div>
                    </section>


                    <!-- SELLS -->
                    <section id="panel-sells" class="panel" role="tabpanel">
                        <h2 class="section-title">Sell Your Watch</h2>

                        <form class="quote-frm stz-frm needs-validation" id="sellEnquiryForm" novalidate>
                            @csrf

                            <!-- STEP 1 -->
                            <div class="step step-1 active">

                                <div class="wtch-info">

                                    <h4 class="text-center">

                                        What are you selling?
                                    </h4>

                                    <!-- BRAND -->
                                    <div class="mb-3">
                                        <label class="lbl-slt" for="selling-brand">Brand <span
                                                class="text-danger">*</span></label>

                                        <select name="selling_brand_id" id="selling_brand_id" class="form-select"
                                            required>
                                            <option value="">Select Brand</option>
                                            @foreach ($brand_data as $brand)
                                                <option value="{{ $brand->brand_id }}">
                                                    {{ $brand->brand_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback text-right" style="font-size:10px;">
                                            This Field is required.
                                        </div>
                                    </div>

                                    <!-- MODEL -->
                                    <div class="mb-3">
                                        <label for="modalNo">Model No <span class="text-danger">*</span></label>
                                        <input name="selling_model" type="text" id="selling-modalNo"
                                            class="form-control" required />
                                        <div class="invalid-feedback text-right" style="font-size:10px;">
                                            This Field is required.
                                        </div>
                                    </div>

                                    <!-- PRICE -->
                                    <label for="price">Price</label>
                                    <select id="price" name="selling_price">
                                        <option value="">Select Price Range</option>
                                        <option value="Upto 2 Lakhs">Upto 2 Lakhs</option>
                                        <option value="2 to 4 Lakhs">2 to 4 Lakhs</option>
                                        <option value="4 to 6 Lakhs">4 to 6 Lakhs</option>
                                        <option value="6 to 8 Lakhs">6 to 8 Lakhs</option>
                                        <option value="8 to 10 Lakhs">8 to 10 Lakhs</option>
                                        <option value="Above 10 Lakhs">Above 10 Lakhs</option>
                                    </select>

                                    <!-- IMAGE -->
                                    <label for="addPhoto" class="mt-2">Add Photos <span
                                            class="text-danger">*</span></label>
                                    <div class="upld-img">
                                        <img src="{{ $actual_url . '/front/trade/i-upld.svg' }}" width="2"
                                            style="width: 15px !important" />

                                        <span id="filename">upload image</span>

                                        <input type="file"
                                            class="required-entry vldtstz-filesize vldtstz-fileextensions vldtstz-imglength"
                                            name="photos[]" id="trade-addPhoto" multiple
                                            onchange="fileNameShow();" />

                                        <span id="fileNameShow" class="file-msg"></span>
                                        <span id="maxFile" class="file-msg">Upload max 3 images</span>
                                    </div>

                                </div>

                                <button type="button" class="btn actn-btn btn-blk next-step">
                                    Next
                                </button>
                            </div>

                            <!-- STEP 2 -->
                            <div class="step step-2">

                                <div class="psnl-info other-info">

                                    <h4 class="text-center">

                                        Personal Information
                                    </h4>

                                    <!-- NAME -->
                                    <div class="mb-3">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                            value="{{ $cust_data->full_name ?? '' }}" id="trade-name"
                                            class="form-control" required />
                                        <div class="invalid-feedback text-right" style="font-size:10px;">
                                            This Field is required.
                                        </div>
                                    </div>

                                    <!-- EMAIL -->
                                    <div class="mb-3">
                                        <label for="email">Email id <span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{ $cust_data->email ?? '' }}"
                                            id="trade-email" class="form-controlvalidate-email" required />
                                        <div class="invalid-feedback text-right" style="font-size:10px;">
                                            This Field is required.
                                        </div>
                                    </div>

                                    <!-- OTP SECTION (UNCHANGED) -->
                                    <div class="field send-enter-otp-wrap">

                                        <div class="send-otp-wrap field send-otp-wrap">
                                            <!-- PHONE with intl-tel-input -->
                                            <div class="mb-3">
                                                <label for="trade-phoneNo">Phone number <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-btn-otp-wrap">
                                                    <input class="form-control" type="tel" id="trade-phoneNo"
                                                        name="phone" required>

                                                    <a href="javascript:void(0)" id="tradeGetOtpBtn"
                                                        class="sendotp getotp tooltip-container">
                                                        <span class="whts-otp-icon">
                                                            <!-- your WhatsApp SVG stays same -->
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

                                        <!-- ENTER OTP -->
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

                                    <!-- CITY -->

                                    <div class="d-flex flex-wrap gap-3 mb-3">

                                        <div class="flex-fill">
                                            <label class="form-label">Country <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="country_id" id="country_id" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Country is required</div>
                                        </div>

                                        <div class="flex-fill">
                                            <label class="form-label">State <span class="text-danger">*</span></label>
                                            <select class="form-select" name="state_id" id="state_id" required
                                                disabled>
                                                <option value="">Select State</option>
                                            </select>
                                            <div class="invalid-feedback">State is required</div>
                                        </div>

                                        <div class="flex-fill">
                                            <label class="form-label">City <span class="text-danger">*</span></label>
                                            <select class="form-select" name="city_id" id="city_id" required
                                                disabled>
                                                <option value="">Select City</option>
                                            </select>
                                            <div class="invalid-feedback">City is required</div>
                                        </div>

                                    </div>


                                    <!-- NEWSLETTER (YOU MISSED BEFORE ❌ NOW FIXED) -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="trade-newsletter_subs" name="newsletter" value="1" checked
                                                required>

                                            <label class="form-check-label" for="trade-newsletter_subs">
                                                Subscribe to news and updates from jayswatch store
                                            </label>

                                            <div class="invalid-feedback text-right" style="font-size:10px;">
                                                This field is required.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BUTTONS -->
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn back-step">Back</button>
                                        <button type="submit" class="btn actn-btn btn-blk">Get A Quote</button>


                                    </div>

                                </div>
                            </div>

                        </form>
                    </section>

                    <!-- ADDRESS -->

                    <section id="panel-address" class="panel" role="tabpanel">
                        <h2 class="section-title">Saved Addresses</h2>
                        <div class="address-list">

                            @if ($address_data->isNotEmpty())
                                @foreach ($address_data as $addr)
                                    <div class="address-card">
                                        <h4
                                            style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>{{ ucfirst($addr->address_type) }}</span>
                                            @if ($addr->is_primary == 1)
                                                <span class="primary_address">Primary</span>
                                            @endif
                                        </h4>

                                        <div class="muted">
                                            {{ $addr->u_address1 }}<br />
                                            @if ($addr->u_address2)
                                                {{ $addr->u_address2 }}<br />
                                            @endif
                                            {{ $addr->u_city }} – {{ $addr->u_pincode }}<br />
                                            {{ $addr->u_state }}, {{ $addr->u_country }}
                                        </div>
                                        <div class="actions" style="justify-content:flex-start;margin-top:10px">
                                            <button class="btn ghost" type="button" data-edit-address
                                                data-id="{{ $addr->ua_id }}">Edit</button>
                                            <button class="btn ghost delete-address" type="button"
                                                data-id="{{ $addr->ua_id }}">
                                                Delete
                                            </button>

                                            @if (!$addr->is_primary == 1)
                                                <button class="btn ghost" type="button" data-primary-address
                                                    data-id="{{ $addr->ua_id }}">Primary</button>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="muted">No saved addresses found.</p>
                            @endif

                            <button class="add-card" id="addAddressBtn" type="button">+ Add New Address</button>
                        </div>
                    </section>


                    <!-- LOGOUT -->
                    <section id="panel-logout" class="panel" role="tabpanel">
                        <h2 class="section-title">Logout</h2>
                        <p>Sign out of your account on this device.</p>
                        <button class="btn primary" type="button" id="openLogout">Logout</button>

                    </section>


                    <!-- Update Password Panel -->
                    <section class="panel" id="panel-password">
                        <h2 class="section-title">Update Password</h2>

                        <div class="grid-two">
                            <div>
                                <label for="oldPwd">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input id="oldPwd" type="password" placeholder="Current password"
                                        class="pe-5" />
                                    <span
                                        class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                        data-target="oldPwd" style="cursor:pointer;">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label for="newPwd">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input id="newPwd" type="password" placeholder="Enter new password"
                                        class="pe-5" />
                                    <span
                                        class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                        data-target="newPwd" style="cursor:pointer;">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="confirmPwd">
                                Confirm New Password <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <input id="confirmPwd" type="password" placeholder="Repeat new password"
                                    class="pe-5" />
                                <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                    data-target="confirmPwd" style="cursor:pointer;">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="actions mt-4">
                            <button class="btn ghost" type="button" data-target="panel-profile">
                                Cancel
                            </button>

                            <button class="btn primary" id="savePwdBtn" type="button" disabled>
                                Update
                            </button>
                        </div>
                    </section>

                </main>
            </div>
        </div>





        <!-- Address Modal -->
        <div class="modal" id="addressModal" role="dialog" aria-modal="true" aria-labelledby="addrTitle">
            <div class="box">
                <header id="addrTitle">Address</header>
                <div class="content">
                    <div class="grid-two">
                        <div>
                            <label for="addrLabel">Address Type <span class="text-danger">*</span></label>
                            <select id="addrLabel">
                                <option>Home</option>
                                <option>Work</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="pincode">Pincode <span class="text-danger">*</span></label>
                            <input id="pincode" type="number" placeholder="Pin Code" />
                        </div>
                        <div>
                            <label for="line1">Address line 1 <span class="text-danger">*</span></label>
                            <input id="line1" type="text" placeholder="Flat / House / Building" />
                        </div>
                        <div>
                            <label for="line2">Address line 2</label>
                            <input id="line2" type="text" placeholder="Area / Street / Sector" />
                        </div>
                        <div>
                            <label for="country">Country <span class="text-danger">*</span></label>


                            <select class="form-select" name="address_country_id" id="address_country_id" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="state">State <span class="text-danger">*</span></label>


                            <select class="form-select" name="address_state_id" id="address_state_id" required
                                disabled>
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div>
                            <label for="city">City <span class="text-danger">*</span></label>


                            <select class="form-select" name="address_city_id" id="address_city_id" required
                                disabled>
                                <option value="">Select City</option>
                            </select>
                        </div>

                    </div>
                </div>
                <footer>
                    <button class="btn ghost" type="button" data-close="#addressModal">Cancel</button>
                    <button class="btn primary" type="button" id="saveAddressBtn" disabled>
                        Save Address
                    </button>

                </footer>
            </div>
        </div>

        <!-- Logout Modal -->
        <div class="modal" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutTitle">
            <div class="box">
                <header id="logoutTitle">Sign out</header>
                <div class="content">Are you sure you want to logout?</div>
                <footer>
                    <button class="btn ghost" type="button" data-close="#logoutModal">Cancel</button>
                    <a href="{{ route('customerlogout') }}" class="btn btn-danger text-white">
                        Logout
                    </a>

                </footer>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')

    <script>
        document.querySelectorAll(".toggle-password").forEach(function(toggle) {
            toggle.addEventListener("click", function() {
                const input = document.getElementById(this.getAttribute("data-target"));
                const icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace("bx-hide", "bx-show");
                } else {
                    input.type = "password";
                    icon.classList.replace("bx-show", "bx-hide");
                }
            });
        });
    </script>

    <script>
        $('#cancelPwdBtn').on('click', function() {
            $('#pwdModal').removeClass('open');

            // Optional: clear fields when cancelling
            $('#oldPwd, #newPwd, #confirmPwd').val('');
            $('#savePwdBtn').prop('disabled', true);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const phoneInput = document.querySelector("#phone");

            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "off",
                preferredCountries: ["in", "us", "gb"],
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
            });

            let maxLength = 10; // default India

            /* ===== SET MAX LENGTH BASED ON COUNTRY ===== */
            function updateMaxLength() {
                const country = iti.getSelectedCountryData();

                // India → 10 digits, others → 15 digits
                maxLength = (country.iso2 === "in") ? 10 : 15;
            }

            /* ===== LIMIT INPUT ===== */
            phoneInput.addEventListener("input", function() {
                let value = phoneInput.value.replace(/\D/g, '');

                if (value.length > maxLength) {
                    value = value.slice(0, maxLength);
                }

                phoneInput.value = value;
            });

            /* ===== BLOCK NON-DIGITS ===== */
            phoneInput.addEventListener("keypress", function(e) {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
            });

            /* ===== COUNTRY CHANGE ===== */
            phoneInput.addEventListener("countrychange", function() {
                updateMaxLength();

                let value = phoneInput.value.replace(/\D/g, '');
                if (value.length > maxLength) {
                    phoneInput.value = value.slice(0, maxLength);
                }
            });

            /* ===== PREFILL ===== */
            @if (!empty($cust_data->phone))
                iti.setNumber("{{ preg_replace('/[^0-9+]/', '', $cust_data->phone) }}");
            @endif

            // initialize
            updateMaxLength();

        });
    </script>




    <script>
        // Sidebar navigation switching
        const nav = document.getElementById('nav');
        const panels = document.querySelectorAll('.panel');
        nav.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-target]');
            if (!btn) return;
            const id = btn.dataset.target;
            panels.forEach(p => p.classList.toggle('active', p.id === id));
            nav.querySelectorAll('button').forEach(b => b.setAttribute('aria-current', b === btn ? 'page' :
                'false'));

            // ✅ ADD THIS
            if (id === 'panel-cart') {
                refreshCartPanel();
            }

            const first = document.querySelector('#' + id + ' input, #' + id + ' button');
            if (first) first.focus({
                preventScroll: true
            });
        });

        // Photo upload preview
        const editPhotoBtn = document.getElementById('editPhotoBtn');
        const photoInput = document.getElementById('photoInput');
        const avatar = document.getElementById('avatar');
        editPhotoBtn.addEventListener('click', () => photoInput.click());
        photoInput.addEventListener('change', (e) => {
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (evt) => {
                avatar.src = evt.target.result;
            };
            reader.readAsDataURL(file);
        });


        function refreshCartPanel() {
            fetch("{{ route('cart.panel') }}")
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cart-panel-body').innerHTML = data.html;
                });
        }


        const addAddressBtn = document.getElementById('addAddressBtn');
        const addressModal = document.getElementById('addressModal');
        addAddressBtn.addEventListener('click', () => {
            resetAddressForm();
            addressModal.classList.add('open');
        });
        document.querySelectorAll('[data-edit-address]').forEach(btn => btn.addEventListener('click', () => addressModal
            .classList.add('open')));

        function resetAddressForm() {
            $('#addrLabel').val('Home');
            $('#pincode, #line1, #line2, #city, #state, #country').val('');

            // Remove edit mode
            $('#addressModal').removeData('ua_id');

            // Disable Save button again
            $('#saveAddressBtn').prop('disabled', true).html('Save Address');
        }

        const logoutModal = document.getElementById('logoutModal');
        document.getElementById('openLogout').addEventListener('click', () => logoutModal.classList.add('open'));

        document.addEventListener('click', (e) => {
            const closeBtn = e.target.closest('[data-close]');
            if (closeBtn) {
                const sel = closeBtn.getAttribute('data-close');
                const el = document.querySelector(sel);
                if (el) el.classList.remove('open');
            }
        });

        // Tiny demo toasts
        const save = (id, msg) => {
            document.getElementById(id).insertAdjacentHTML('beforeend',
                `<div class="muted" style="margin-top:10px">${msg}</div>`);
            setTimeout(() => {
                const nodes = document.querySelectorAll('#' + id + ' .muted');
                if (nodes.length) nodes[nodes.length - 1].remove();
            }, 2000);
        };
        //   document.getElementById('saveProfile').addEventListener('click',()=>save('panel-profile','Profile saved.'));
        //   document.getElementById('discardProfile').addEventListener('click',()=>save('panel-profile','Changes discarded.'));

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get("tab");

            if (activeTab) {
                const panels = document.querySelectorAll(".panel");
                const navButtons = document.querySelectorAll("#nav button");

                // remove old active panel
                panels.forEach(panel => panel.classList.remove("active"));

                // activate selected panel
                const selectedPanel = document.getElementById(activeTab);
                if (selectedPanel) {
                    selectedPanel.classList.add("active");
                }

                // update sidebar active button
                navButtons.forEach(btn => {
                    btn.setAttribute(
                        "aria-current",
                        btn.dataset.target === activeTab ? "page" : "false"
                    );
                });

                // if cart tab open
                if (activeTab === "panel-cart") {
                    refreshCartPanel();
                }
            }
        });
    </script>
    <!-- ===== /My Account (Static UI) ===== -->



    <!-- ===== By Mahirkhan ===== -->



    <script>
        $('#photoInput').on('change', function() {
            let file = this.files[0];
            if (!file) return;

            let formData = new FormData();
            formData.append('photo', file);

            $.ajax({
                url: "{{ route('update-profile-photo') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            icon: 'fa fa-check-circle',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });

                        // Update the photo preview instantly
                        $('#profileImage').attr('src', response.file);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                    }
                },
                error: function() {
                    iziToast.error({
                        title: 'Error',
                        message: 'Something went wrong!',
                        position: 'topRight',
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });
                }
            });
        });
    </script>

    <script>
        const saveBtn = $('#savePwdBtn');

        // Disable initially
        saveBtn.prop('disabled', true);

        // Watch inputs
        $('#oldPwd, #newPwd, #confirmPwd').on('input', function() {

            let oldPwd = $('#oldPwd').val().trim();
            let newPwd = $('#newPwd').val().trim();
            let confirmPwd = $('#confirmPwd').val().trim();

            // Enable only if all fields have value
            if (oldPwd !== '' && newPwd !== '' && confirmPwd !== '') {
                saveBtn.prop('disabled', false);
            } else {
                saveBtn.prop('disabled', true);
            }
        });
        $('#savePwdBtn').click(function() {

            let oldPwd = $('#oldPwd').val().trim();
            let newPwd = $('#newPwd').val().trim();
            let confirmPwd = $('#confirmPwd').val().trim();

            // Get email for password comparison rule
            let email = "{{ $cust_data->email }}".toLowerCase();

            // 1️⃣ Required check
            if (newPwd === '' || confirmPwd === '') {
                iziToast.info({
                    message: 'Please enter both new and confirm password.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 2️⃣ Confirm match
            if (newPwd !== confirmPwd) {
                iziToast.info({
                    message: 'Passwords do not match!',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 3️⃣ Length validation
            if (newPwd.length < 8 || newPwd.length > 20) {
                iziToast.info({
                    message: 'Password must be 8–20 characters long.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 4️⃣ Uppercase letter
            if (!/[A-Z]/.test(newPwd)) {
                iziToast.info({
                    message: 'Password must contain at least one uppercase letter.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 5️⃣ Lowercase letter
            if (!/[a-z]/.test(newPwd)) {
                iziToast.info({
                    message: 'Password must contain at least one lowercase letter.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 6️⃣ Number check
            if (!/[0-9]/.test(newPwd)) {
                iziToast.info({
                    message: 'Password must contain at least one digit.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 7️⃣ Special character
            if (!/[@#$%^&*()_+\-=\!?]/.test(newPwd)) {
                iziToast.info({
                    message: 'Password must contain at least one special character.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 8️⃣ No spaces allowed
            if (/\s/.test(newPwd)) {
                iziToast.info({
                    message: 'Password cannot contain spaces.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 9️⃣ Cannot contain word "password"
            if (newPwd.toLowerCase().includes("password")) {
                iziToast.info({
                    message: 'Password cannot contain the word "password".',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 🔟 Cannot match email
            if (newPwd.toLowerCase() === email) {
                iziToast.info({
                    message: 'Password cannot be same as your email.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // 1️⃣1️⃣ No sequential characters (123456 / abcdef / ABCDEF)
            const sequences = [
                "123456", "234567", "345678", "456789",
                "abcdef", "bcdefg", "cdefgh", "defghi",
                "ABCDEF", "BCDEFG", "CDEFGH", "DEFGHI"
            ];
            for (let seq of sequences) {
                if (newPwd.includes(seq)) {
                    iziToast.info({
                        message: 'Password cannot contain sequential characters.',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });
                    return;
                }
            }

            // 1️⃣2️⃣ No repeated characters (aaaaaa, 111111)
            if (/([a-zA-Z0-9])\1{3,}/.test(newPwd)) {
                iziToast.info({
                    message: 'Password cannot contain repeated characters.',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                return;
            }

            // ⭐ If all conditions passed → AJAX submit
            $.ajax({
                url: "{{ route('update-customer-password') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    new_password: newPwd,
                    old_password: oldPwd
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            iconColor: '#ffffff',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            icon: 'fa fa-check-circle',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                        $('#newPwd, #confirmPwd, #oldPwd').val('');
                        $('#savePwdBtn').prop('disabled', true).html('Save Password');

                    } else {
                        iziToast.info({
                            message: response.message,
                            position: 'topRight',
                            iconColor: '#ffffff',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                    }
                },
                error: function() {
                    iziToast.error({
                        title: 'Error',
                        message: 'Something went wrong!',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });
                }
            });

        });
    </script>



    <script>
        $(document).ready(function() {

            let isLocked = false; // 🔒 prevents multiple clicks
            const saveBtn = $('#saveProfile');
            const phoneInput = document.querySelector('#phone');

            // 👉 Get intl-tel-input instance
            const iti = window.intlTelInputGlobals.getInstance(phoneInput);

            // 🔁 Enable Save button ONLY when input changes
            $('#name, #email, #phone').on('input change', function() {
                if (isLocked) {
                    isLocked = false;
                    saveBtn.prop('disabled', false).text('Save changes');
                }
            });

            $('#saveProfile').click(function() {

                // 🚫 Prevent multiple clicks
                if (isLocked) return;

                let name = $('#name').val().trim();
                let email = $('#email').val().trim();

                // ✅ Get phone WITH country code
                let phone = iti ? iti.getNumber() : $('#phone').val().trim();

                const emailPattern =
                    /^(?!.*\.\.)(?!.*\.$)(?!^\.)[A-Za-z0-9._+\-]+@[A-Za-z0-9\-]+\.[A-Za-z]{2,10}$/;
                const countryData = iti.getSelectedCountryData();
                const nationalNumber = phone.replace(/\D/g, '').replace(/^91/, ''); // remove +91

                if (countryData.iso2 === 'in') {

                    // must be exactly 10 digits & start with 6–9
                    if (!/^[6-9][0-9]{9}$/.test(nationalNumber)) {
                        iziToast.info({
                            title: 'Invalid Phone',
                            message: 'Invalid Mobile Number',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                        return; // ❌ STOP SAVE
                    }
                }

                // ❌ Invalid email
                if (!emailPattern.test(email)) {
                    iziToast.info({
                        title: 'Invalid Email',
                        message: 'Please enter a valid email address.',
                        backgroundColor: '#212529',
                        iconColor: '#ffffff',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });
                    $("#email").addClass("is-invalid").removeClass("is-valid");
                    return;
                }

                // ❌ Empty name
                if (name === '') {
                    iziToast.info({
                        title: 'Required',
                        message: 'Full Name cannot be empty.',
                        position: 'topRight',
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });
                    return;
                }



                // 🔒 Lock button after click
                isLocked = true;
                saveBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ route('update-customer-profile') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        full_name: name,
                        email: email,
                        phone: phone // ✅ +91XXXXXXXXXX
                    },
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight',
                                backgroundColor: '#212529',
                                titleColor: '#ffffff',
                                messageColor: '#ffffff',
                                position: 'topRight',
                                icon: 'fa fa-check-circle',
                                iconColor: '#ffffff',
                                progressBarColor: '#ffffff'
                            });

                            saveBtn.prop('disabled', true).text('Saved');

                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight',
                                backgroundColor: '#212529',
                                titleColor: '#ffffff',
                                messageColor: '#ffffff',
                                position: 'topRight',
                                iconColor: '#ffffff',
                                progressBarColor: '#ffffff'
                            });

                            // ❗ Unlock only on failure
                            isLocked = false;
                            saveBtn.prop('disabled', false).text('Save changes');
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });

                        isLocked = false;
                        saveBtn.prop('disabled', false).text('Save changes');
                    }
                });
            });

            $('#discardProfile').click(function() {
                location.reload();
            });

        });
    </script>




    <script>
        $(document).ready(function() {
            // --- SAVE ADDRESS ---

            $(document).on('change', '#address_country_id', function() {

                let countryId = $(this).val();

                $('#address_state_id').empty()
                    .append('<option value="">Select State</option>')
                    .prop('disabled', true);

                $('#address_city_id').empty()
                    .append('<option value="">Select City</option>')
                    .prop('disabled', true);

                if (!countryId) return;

                let url = "{{ route('get.states', ':id') }}".replace(':id', countryId);

                $.get(url, function(data) {

                    $('#address_state_id').prop('disabled', false);

                    $.each(data, function(key, state) {
                        $('#address_state_id').append(
                            '<option value="' + state.id + '">' + state.name +
                            '</option>'
                        );
                    });

                });
            });

            // State → Cities
            $(document).on('change', '#address_state_id', function() {

                let stateId = $(this).val();

                $('#address_city_id').empty()
                    .append('<option value="">Select City</option>')
                    .prop('disabled', true);

                if (!stateId) return;

                let url = "{{ route('get.cities', ':id') }}".replace(':id', stateId);

                $.get(url, function(data) {

                    $('#address_city_id').prop('disabled', false);

                    $.each(data, function(key, city) {
                        $('#address_city_id').append(
                            '<option value="' + city.id + '">' + city.name + '</option>'
                        );
                    });

                });
            });


            const saveBtn = $('#saveAddressBtn');

            // Disable initially
            saveBtn.prop('disabled', true);

            // Watch all inputs & selects inside address modal
            $('#addressModal input, #addressModal select').on('input change', function() {

                let hasValue = false;

                $('#addressModal input, #addressModal select').each(function() {
                    if ($(this).val().trim() !== '') {
                        hasValue = true;
                        return false; // break loop
                    }
                });

                saveBtn.prop('disabled', !hasValue);
            });


            $('#addressModal .btn.primary').click(function() {
                let address_type = $('#addrLabel').val();
                let pincode = $('#pincode').val().trim();
                let address1 = $('#line1').val().trim();
                let address2 = $('#line2').val().trim();
                let city = $('#address_city_id').val();
                let state = $('#address_state_id').val();
                let country = $('#address_country_id').val();
                let ua_id = $('#addressModal').data('ua_id') || ''; // Detect edit mode

                if (!pincode || !address1 || !city || !state) {
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Please fill all required address fields.',
                        position: 'topRight',
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });
                    return;
                }

                // Disable button and show spinner
                let btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

                $.ajax({
                    url: "{{ route('save-customer-address') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ua_id: ua_id,
                        address_type: address_type,
                        u_pincode: pincode,
                        u_address1: address1,
                        u_address2: address2,
                        u_city: city,
                        u_state: state,
                        u_country: country
                    },
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight',
                                backgroundColor: '#212529',
                                titleColor: '#ffffff',
                                icon: 'fa fa-check-circle',
                                messageColor: '#ffffff',
                                position: 'topRight',
                                iconColor: '#ffffff',
                                progressBarColor: '#ffffff'
                            });

                            // Close modal
                            $('#addressModal').removeClass('open');

                            // Set flag to reopen Address tab
                            localStorage.setItem('openAddressTab', 'true');

                            // Reload page
                            setTimeout(() => location.reload(), 800);
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight',
                                backgroundColor: '#212529',
                                titleColor: '#ffffff',
                                messageColor: '#ffffff',
                                position: 'topRight',
                                iconColor: '#ffffff',
                                progressBarColor: '#ffffff'
                            });
                            btn.prop('disabled', false).html('Save Address');
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                        btn.prop('disabled', false).html('Save Address');
                    }
                });
            });


            // --- SET PRIMARY ADDRESS ---
            $(document).on('click', '[data-primary-address]', function() {
                let ua_id = $(this).data('id');
                let btn = $(this);

                // Add spinner and disable button
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

                $.ajax({
                    url: "{{ route('update.primary.address') }}",
                    type: "POST",
                    data: {
                        ua_id: ua_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight',
                                backgroundColor: '#212529',
                                titleColor: '#ffffff',
                                messageColor: '#ffffff',
                                position: 'topRight',
                                icon: 'fa fa-check-circle',
                                iconColor: '#ffffff',
                                progressBarColor: '#ffffff'
                            });

                            // Set a flag in localStorage to reopen Address tab after reload
                            localStorage.setItem('openAddressTab', 'true');

                            // Reload page
                            setTimeout(() => location.reload(), 800);
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight',
                                backgroundColor: '#212529',
                                titleColor: '#ffffff',
                                messageColor: '#ffffff',
                                position: 'topRight',
                                iconColor: '#ffffff',
                                progressBarColor: '#ffffff'
                            });
                            btn.prop('disabled', false).html('Primary');
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                        btn.prop('disabled', false).html('Primary');
                    }
                });
            });



            // --- OPEN EDIT ADDRESS MODAL ---
            $(document).on('click', '[data-edit-address]', function() {
                let ua_id = $(this).data('id');

                // Clear form before filling
                $('#addrLabel').val('Home');
                $('#pincode, #line1, #line2, #address_city_id, #address_state_id, #address_country_id').val(
                    '');

                $.ajax({
                    url: "{{ route('get.single.address') }}",
                    type: "GET",
                    data: {
                        ua_id: ua_id
                    },
                    success: function(response) {
                        if (response.success) {

                            let addr = response.data;

                            $('#addrLabel').val(addr.address_type);
                            $('#pincode').val(addr.u_pincode);
                            $('#line1').val(addr.u_address1);
                            $('#line2').val(addr.u_address2);

                            // 🔥 STEP 1: Set COUNTRY (ID)
                            $('#address_country_id')
                                .val(addr.country_id)
                                .trigger('change');

                            // 🔥 STEP 2: After state loads
                            setTimeout(function() {

                                $('#address_state_id')
                                    .val(addr.state_id)
                                    .trigger('change');

                                // 🔥 STEP 3: After city loads
                                setTimeout(function() {

                                    $('#address_city_id')
                                        .val(addr.city_id);

                                }, 600);

                            }, 600);

                            // Store ID for update
                            $('#addressModal').data('ua_id', ua_id);

                            // Open modal
                            $('#addressModal').fadeIn();

                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight',
                                backgroundColor: '#212529',
                                titleColor: '#ffffff',
                                messageColor: '#ffffff',
                                iconColor: '#ffffff',
                                progressBarColor: '#ffffff'
                            });
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Unable to fetch address details.',
                            position: 'topRight',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                    }
                });
            });


            $(document).on('click', '.delete-address', function() {
                let ua_id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This address will be permanently deleted.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#212529",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete.address') }}", // Your delete route name
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                ua_id: ua_id
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Deleted!",
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    localStorage.setItem('openAddressTab', 'true');

                                    // Reload page
                                    setTimeout(() => location.reload(), 800);
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error!",
                                        text: response.message,
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Something went wrong. Please try again.",
                                });
                            }
                        });
                    }
                });
            });




            // --- AFTER PAGE RELOAD — REOPEN ADDRESS TAB ---
            if (localStorage.getItem('openAddressTab') === 'true') {
                $('[data-target="panel-address"]').trigger('click');
                localStorage.removeItem('openAddressTab');
            }
        });
    </script>


    <script>
        document.addEventListener('click', function(e) {

            if (e.target.closest('.remove-wishlist')) {

                let btn = e.target.closest('.remove-wishlist');
                let id = btn.getAttribute('data-id');
                let card = btn.closest('.product');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Remove this item from wishlist?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        fetch("{{ route('remove.wishlist') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    product_id: id
                                })
                            })
                            .then(res => res.json())
                            .then(data => {

                                if (data.status === 'success') {

                                    // ✅ Remove item from UI
                                    card.remove();

                                    // ✅ Remove from localStorage
                                    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
                                    wishlist = wishlist.filter(item => item != id);
                                    localStorage.setItem("wishlist", JSON.stringify(wishlist));

                                    // 🔥 Check empty wishlist
                                    let container = document.querySelector('#panel-wishlist .wishlist');
                                    let remainingItems = container.querySelectorAll('.product');

                                    if (remainingItems.length === 0) {
                                        container.innerHTML = '<p>No wishlist items found.</p>';
                                    }

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Removed!',
                                        text: 'Item removed from wishlist.',
                                        timer: 1200,
                                        showConfirmButton: false
                                    });

                                    // ✅ Update wishlist icon instantly on other pages
                                    document.querySelectorAll('.wishlist-icon[data-id="' + id + '"]')
                                        .forEach(icon => {
                                            icon.classList.remove('active');
                                        });

                                } else {
                                    Swal.fire('Error!', 'Something went wrong.', 'error');
                                }
                            });

                    }

                });
            }

        });
    </script>

    <script>
        // =====================================================
        // GLOBAL
        // =====================================================
        function fileNameShow() {
            var input = document.getElementById('trade-addPhoto');
            var output = document.getElementById('fileNameShow');
            var maxMsg = document.getElementById('maxFile');
            if (!input || !output) return;
            if (input.files.length > 3) {
                output.innerHTML =
                    '<span style="display:block;color:red;font-size:12px;">&#10007; You can upload max 3 images</span>';
                if (maxMsg) maxMsg.style.display = 'none';
            } else if (input.files.length === 0) {
                output.innerHTML = '';
                if (maxMsg) maxMsg.style.display = 'block';
            } else {
                output.innerHTML = '';
                for (var i = 0; i < input.files.length; i++) {
                    output.innerHTML += '<span style="display:block;color:green;font-size:12px;">&#10003; ' + input.files
                        .item(i).name + '</span>';
                }
                if (maxMsg) maxMsg.style.display = 'none';
            }
        }

        // =====================================================
        // Register validators after jQuery Validate loads
        // =====================================================
        function registerValidators() {
            if (typeof $ === 'undefined' || typeof $.validator === 'undefined') {
                setTimeout(registerValidators, 100);
                return;
            }
            $.validator.addMethod('vldtstz-filesize', function(v, elm) {
                var max = 5 * 1024000,
                    s0 = 0,
                    s1 = 0,
                    s2 = 0;
                if (elm.files[0]) s0 = elm.files[0].size;
                if (elm.files[1]) s1 = elm.files[1].size;
                if (elm.files[2]) s2 = elm.files[2].size;
                return !(s0 > max || s1 > max || s2 > max);
            }, 'File size should not exceed 5MB.');

            $.validator.addMethod('vldtstz-fileextensions', function(v, elm) {
                if (!v) return true;
                var ok = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
                var inp = document.getElementById('trade-addPhoto');
                if (!inp || !inp.files.length) return true;
                var matched = 0;
                for (var x = 0; x < inp.files.length; x++) {
                    if (ok.indexOf(inp.files[x].name.split('.').pop()) !== -1) matched++;
                }
                return inp.files.length === matched;
            }, 'Please upload image files only (jpg, jpeg, png).');

            $.validator.addMethod('vldtstz-imglength', function(v, elm) {
                if (!v) return true;
                var inp = document.getElementById('trade-addPhoto');
                return !inp || inp.files.length < 4;
            }, 'You can upload max 3 files.');
        }
        registerValidators();

        // =====================================================
        // Main
        // =====================================================
        $(document).ready(function() {


            var sellIti = null; // lazily initialized
            var originalOtpBtn = null;

            // ── helper: show inline error under a field ──────
            function showFieldError(selector, msg) {
                $(selector).addClass('is-invalid')
                    .closest('.mb-3, .field, div')
                    .find('.invalid-feedback')
                    .first()
                    .text(msg)
                    .show();
            }

            function clearFieldError(selector) {
                $(selector).removeClass('is-invalid')
                    .closest('.mb-3, .field, div')
                    .find('.invalid-feedback')
                    .first()
                    .hide();
            }

            // ── Init intlTelInput lazily when step-2 shows ───
            function initSellIti() {
                var el = document.getElementById('trade-phoneNo');
                if (!el || sellIti) return; // already done or not found
                sellIti = window.intlTelInput(el, {
                    initialCountry: 'in',
                    separateDialCode: true,
                    nationalMode: false,
                    autoPlaceholder: "off",
                    preferredCountries: ['in', 'us', 'gb'],
                    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js'
                });
                originalOtpBtn = $('.sendotp').html();
            }

            // ── Step 1: initial state ────────────────────────
            $('.step-1').show();
            $('.step-2').hide();

            // ── NEXT button ──────────────────────────────────
            $(document).on('click', '.next-step', function() {
                var valid = true;

                // Required selects & inputs
                $('.step-1').find('select[required], input[required]').each(function() {
                    if (!$(this).val() || $(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // File input
                var fileInput = document.getElementById('trade-addPhoto');
                var fileError = $('#fileNameShow');

                if (!fileInput || fileInput.files.length === 0) {
                    fileError.html(
                        '<span style="color:red;font-size:12px;">&#10007; Please upload at least 1 image.</span>'
                    );
                    valid = false;
                } else if (fileInput.files.length > 3) {
                    fileError.html(
                        '<span style="color:red;font-size:12px;">&#10007; Max 3 images allowed.</span>');
                    valid = false;
                } else {
                    var allowed = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
                    var extOk = true;
                    var sizeOk = true;
                    var maxSize = 5 * 1024 * 1000;
                    for (var i = 0; i < fileInput.files.length; i++) {
                        if (allowed.indexOf(fileInput.files[i].name.split('.').pop()) === -1) extOk = false;
                        if (fileInput.files[i].size > maxSize) sizeOk = false;
                    }
                    if (!extOk) {
                        fileError.html(
                            '<span style="color:red;font-size:12px;">&#10007; Only jpg, jpeg, png allowed.</span>'
                        );
                        valid = false;
                    } else if (!sizeOk) {
                        fileError.html(
                            '<span style="color:red;font-size:12px;">&#10007; Each file must be under 5MB.</span>'
                        );
                        valid = false;
                    }
                }

                if (!valid) {
                    $('.step-1').closest('form').addClass('was-validated');
                    return;
                }

                // ✅ Go to step 2 — init ITI NOW (element is visible)
                $('.step-1').hide();
                $('.step-2').show();
                initSellIti(); // <-- lazy init here

                $('html, body').animate({
                    scrollTop: $('#sellEnquiryForm').offset().top - 100
                }, 300);
            });

            // ── BACK button ──────────────────────────────────
            $(document).on('click', '.back-step', function() {
                $('.step-2').hide();
                $('.step-1').show();
                $('html, body').animate({
                    scrollTop: $('#sellEnquiryForm').offset().top - 100
                }, 300);
            });

            // ── OTP input auto-focus ─────────────────────────
            $(document).on('keyup', '.verify-otp-input', function(e) {
                if (this.value.length === 1) $(this).next('.verify-otp-input').focus();
                if (e.key === 'Backspace' && this.value === '') $(this).prev('.verify-otp-input').focus();
            });

            // ── OTP timer ────────────────────────────────────
            function startOtpTimer() {
                var time = 60;
                $('.otp-counter').text(time);
                $('.resendotp').hide();

                // ✅ Keep button locked during timer
                $('.sendotp').data('sending', true)
                    .css({
                        opacity: '0.6',
                        'pointer-events': 'none'
                    });

                var timer = setInterval(function() {
                    time--;
                    $('.otp-counter').text(time < 10 ? '0' + time : time);
                    if (time <= 0) {
                        clearInterval(timer);
                        $('.otp-counter').text('00');
                        $('.resendotp').show();

                        // ✅ Unlock button when timer ends (Resend available)
                        $('.sendotp').data('sending', false)
                            .css({
                                opacity: '1',
                                'pointer-events': 'auto'
                            });
                    }
                }, 1000);
            }

            // ── Send OTP ─────────────────────────────────────
            // ── Send OTP ─────────────────────────────────────
            $(document).on('click', '.sendotp', function() {
                // ✅ Prevent multiple clicks
                if ($(this).data('sending')) return;

                if (!sellIti) {
                    iziToast.warning({
                        message: 'Please wait...',
                        position: 'topRight',
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });
                    return;
                }

                clearFieldError('#trade-phoneNo');

                if (!sellIti.isValidNumber()) {
                    $('#trade-phoneNo').addClass('is-invalid');
                    $('#trade-phoneNo').closest('.mb-3')
                        .find('.invalid-feedback')
                        .text('Please enter a valid phone number.')
                        .show();
                    $('#trade-phoneNo').focus();
                    return;
                }

                var phone = sellIti.getNumber();
                var btn = $(this);

                // ✅ Lock button immediately
                btn.data('sending', true)
                    .css({
                        opacity: '0.6',
                        'pointer-events': 'none'
                    })
                    .find('span.tooltip-text').hide(); // hide tooltip during lock

                $.ajax({
                    url: "{{ route('send.otp') }}",
                    type: 'POST',
                    data: {
                        phone: phone,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        clearFieldError('#trade-phoneNo');
                        $('.enter-otp-wrap').show();
                        startOtpTimer();
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP sent to WhatsApp'
                        });
                    },
                    error: function(xhr) {
                        // ✅ Unlock on error so user can retry
                        btn.data('sending', false)
                            .css({
                                opacity: '1',
                                'pointer-events': 'auto'
                            });

                        iziToast.error({
                            title: 'Error',
                            message: (xhr.responseJSON && xhr.responseJSON.message) ?
                                xhr.responseJSON.message : 'Failed to send OTP.',
                            position: 'topRight',
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                    }
                });
            });

            // ── Resend OTP ───────────────────────────────────
            $(document).on('click', '.resendotp', function() {
                $('.sendotp').trigger('click');
                $(this).hide();
            });

            // ── Verify OTP ───────────────────────────────────
            $(document).on('click', '.submitotp', function() {
                var otp = '';
                $('.verify-otp-input').each(function() {
                    otp += $(this).val();
                });
                if (otp.length < 6) {
                    iziToast.warning({
                        message: 'Please enter all 6 OTP digits.',
                        position: 'topRight'
                    });
                    return;
                }
                $.ajax({
                    url: "{{ route('verify.otp') }}",
                    type: 'POST',
                    data: {
                        phone: sellIti.getNumber(),
                        otp: otp,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status) {
                            window.otpVerified = true;
                            $('.enter-otp-wrap').hide();
                            $('#trade-phoneNo').prop('readonly', true);
                            $('.sendotp').text('Verified ✓').css({
                                background: '#28a745',
                                'pointer-events': 'none'
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Phone Verified'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid OTP',
                                text: 'Please check and try again.'
                            });
                        }
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'OTP verification failed.',
                            position: 'topRight'
                        });
                    }
                });
            });

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


            // ── Form submit ──────────────────────────────────
            $(document).on('submit', '#sellEnquiryForm', function(e) {
                e.preventDefault();

                var form = this;

                // ✅ Bootstrap validation
                if (!form.checkValidity()) {
                    $(form).addClass('was-validated');
                    return;
                }

                // ✅ Phone validation
                if (!sellIti || !sellIti.isValidNumber()) {
                    $('#trade-phoneNo').addClass('is-invalid');

                    $('#trade-phoneNo').closest('.mb-3')
                        .find('.invalid-feedback')
                        .text('Please enter a valid phone number.')
                        .css('display', 'block');

                    return;
                }

                // ❌ OTP NOT VERIFIED
                if (!window.otpVerified) {

                    $('#trade-phoneNo').addClass('is-invalid');

                    $('#trade-phoneNo').closest('.mb-3')
                        .find('.invalid-feedback')
                        .text('Please verify OTP before submitting the form')
                        .css('display', 'block');

                    // 🔥 scroll to error
                    $('html, body').animate({
                        scrollTop: $('#trade-phoneNo').offset().top - 100
                    }, 300);

                    return;
                }

                // ✅ OTP VERIFIED → remove error
                $('#trade-phoneNo').removeClass('is-invalid');

                $('#trade-phoneNo').closest('.mb-3')
                    .find('.invalid-feedback')
                    .hide();

                // ✅ Prepare form data
                var formData = new FormData(form);
                formData.set('phone', sellIti.getNumber());

                $.ajax({
                    url: "{{ route('selling.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Selling Request Sent!',
                            text: 'Our expert will contact you shortly.',
                            confirmButtonColor: '#000'
                        });

                        // 🔄 Reset form
                        $('#sellEnquiryForm')[0].reset();
                        fileNameShow();

                        window.otpVerified = false;

                        $('#country_id').val('');

                        $('#state_id')
                            .html('<option value="">Select State</option>')
                            .prop('disabled', true)
                            .val('');

                        $('#city_id')
                            .html('<option value="">Select City</option>')
                            .prop('disabled', true)
                            .val('');


                        // reset UI
                        sellIti = null;
                        $('#trade-phoneNo').prop('readonly', false);

                        $('.sendotp').html(originalOtpBtn).css({
                            background: '#3fa236',
                            'pointer-events': 'auto'
                        });

                        $('.enter-otp-wrap').hide();
                        $('.verify-otp-input').val('');

                        // back to step 1
                        $('.step-2').hide();
                        $('.step-1').show();
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
</body>

</html>
