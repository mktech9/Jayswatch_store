<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: "Montserrat";
            margin: 0;
            padding: 0;
            color: #222;
        }

        .page {
            width: 100%;
            height: 100vh;
            position: relative;
            page-break-after: always;
            page-break-inside: avoid;
            overflow: hidden;
            background: #fff;
        }

        /* stop extra blank last page */
        .page:last-of-type {
            page-break-after: auto;
        }

        .cover-page {
            width: 100%;
            height: 100vh;
            position: relative;
            page-break-after: always;
            overflow: hidden;
        }

        .cover-page:last-of-type {
            page-break-after: auto;
        }

        .cover-top {
            height: 66%;
            width: 100%;
            position: relative;
        }

        .cover-bottom {
            height: 34%;
            width: 100%;
            background: #ececec;
            position: relative;
        }

        .cover-logo {
            width: 420px;
            height: auto;
            position: absolute;
            top: 48%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .cover-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 34px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #000;
        }


        /* PRODUCT PAGE */
        .card-wrap {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
            background: #fff;
        }

        .logo {
            position: absolute;
            top: 18px;
            left: 18px;
            width: 170px;
            height: auto;
            z-index: 10;
            opacity: 0.95;
        }

        .left {
            position: absolute;
            top: 0;
            left: 0;
            width: 58%;
            height: 100%;
            display: table;
            padding: 0;
            box-sizing: border-box;
        }

        .image-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .right {
            position: absolute;
            top: 40%;
            right: 0;
            width: 50%;
            height: 66%;
            z-index: 2;
            background: #efefef;
            box-sizing: border-box;
            padding: 2px 28px 2px 18px;
        }

        .watch-img {
            max-width: 92%;
            max-height: 92%;
            width: auto;
            height: auto;
            display: inline-block;
            margin-top: 20px;
        }

        .title {


            line-height: 1.35;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .meta-item {
            line-height: 1.5;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .meta-subitem {
            line-height: 1.5;
            text-transform: uppercase;
        }

        .price {
            margin-top: 25px;

            font-weight: 400;
        }
    </style>
</head>

<body>
    @php
        $logoPath = public_path('assets/admin_assets/inventory/pagelogo.png');
        $logoSrc = file_exists($logoPath) ? 'file://' . $logoPath : null;

        $multilogoPath = public_path('assets/admin_assets/inventory/logo.png');
        $multilogoSrc = file_exists($multilogoPath) ? 'file://' . $multilogoPath : null;
    @endphp

    {{-- FIRST PAGE / COVER PAGE --}}
    <div class="cover-page">

        <div class="cover-top">
            @if ($logoSrc)
                <img src="{{ $logoSrc }}" class="cover-logo" alt="Logo">
            @endif
        </div>

        <div class="cover-bottom">
            <div class="cover-title">
                CATALOGUE
            </div>
        </div>

    </div>
    {{-- PRODUCT PAGES --}}
    @foreach ($products as $product)
        @php
            $imgSrc = null;

            if (!empty($product->image_path) && file_exists($product->image_path)) {
                $type = pathinfo($product->image_path, PATHINFO_EXTENSION);
                $data = file_get_contents($product->image_path);
                $imgSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            $fontSize = $product->service_card == 1 ? '22.5px' : '22.5px';
        @endphp

        <div class="page">
            <div class="card-wrap">

                @if ($multilogoSrc)
                    <img src="{{ $multilogoSrc }}" class="logo" alt="Logo">
                @endif

                <div class="left">
                    <div class="image-cell">
                        @if ($imgSrc)
                            <img src="{{ $imgSrc }}" class="watch-img" alt="{{ $product->pro_name }}">
                        @endif
                    </div>
                </div>

                <div class="right" style="font-size: {{ $fontSize }};">
                    <div class="title">
                        {{ $product->brand_name }} {{ $product->pro_name }}
                    </div>

                    <div class="meta-item">
                        {{ $product->dial_diameter }}
                    </div>

                    <div class="meta-item">
                        {{ $product->pro_ref_num }}
                    </div>

                    <div class="meta-item">
                        {{ \Carbon\Carbon::parse($product->year_of_card)->format('Y') }}
                    </div>

                    <div class="meta-subitem">
                        BOX: {{ $product->box_text }}
                    </div>

                    <div class="meta-subitem">
                        PAPER: {{ $product->paper_text }}
                    </div>

                    @if ($product->service_card == 1)
                        <div class="meta-subitem">
                            (SERVICE CARD AVAILABLE)
                        </div>
                    @endif

                    <div class="price">
                        {{ $product->selling_price_text }}/-
                    </div>
                </div>

            </div>
        </div>
    @endforeach
</body>

</html>
