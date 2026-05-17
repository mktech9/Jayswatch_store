<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    @include('frontend.partials.header_link')
    <style>


  

        /* 🔥 Layout Fix */
        .faq-wrapper {
            display: flex;
            gap: 40px;
        }

        /* LEFT MENU */
        .faq-left {
            width: 25%;
        }

        .faq-left a {
            display: block;
            padding: 10px 0;
            color: #000;
            text-decoration: none;
        }

        .faq-left a.active {
            font-weight: bold;
        }

        /* RIGHT CONTENT */
        .faq-right {
            width: 75%;
        }

        .faq-right h3 {
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .faq-right p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* Divider line */
        .faq-item {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        /* Mobile */
        @media(max-width:768px) {
            .faq-wrapper {
                flex-direction: column;
            }

            .faq-left,
            .faq-right {
                width: 100%;
            }
        }
    </style>

</head>

<body>

    @include('frontend.partials.header')

    <div class="container">

        <div class="faq-wrapper">

            <!-- LEFT MENU -->
            <div class="faq-left">
                <a class="active" href="{{ route('all.faq') }}">FAQs</a>

            </div>

            <!-- RIGHT FAQ CONTENT -->
            <div class="faq-right">

                @php
                    function toRoman($num)
                    {
                        $map = [
                            'M' => 1000,
                            'CM' => 900,
                            'D' => 500,
                            'CD' => 400,
                            'C' => 100,
                            'XC' => 90,
                            'L' => 50,
                            'XL' => 40,
                            'X' => 10,
                            'IX' => 9,
                            'V' => 5,
                            'IV' => 4,
                            'I' => 1,
                        ];
                        $return = '';
                        foreach ($map as $roman => $int) {
                            while ($num >= $int) {
                                $return .= $roman;
                                $num -= $int;
                            }
                        }
                        return $return;
                    }
                @endphp

                @forelse($allfaq as $faq)
                    <div class="faq-item">

                        <h3>
                            {{ toRoman($loop->iteration) }}. {{ $faq->question }}
                        </h3>

                        <p>{!! $faq->answer !!}</p>

                    </div>

                @empty

                    <p>No FAQs available.</p>
                @endforelse
            </div>

        </div>

    </div>
    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')
</body>

</html>
