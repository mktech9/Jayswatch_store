<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="background-color: #ffffff;border:1px solid #000;font-size:13px;font-family: 'Montserrat', sans-serif;">
    <span class="graphic"
        style="width: 95%; height: 5px; display: block; z-index: -10; left: 3.27rem; top: 1px;background-color: #c02026;margin: 0px auto;"></span>
    <table style="width: 100%;padding:20px 20px 5px 20px;text-align:left;">
        <tr>
            <td>
                @if ($order->payment_method == 'prebook')
                    <img src="{{ public_path('assets/admin_assets/proforma.png') }}" class="image"
                        style="width: 17rem;text-align: left;padding-top:1rem;padding-bottom:1rem;" />
                @else
                    <img src="{{ public_path('assets/admin_assets/invoice.png') }}" class="image"
                        style="width: 9rem;text-align: left;padding-top:1rem;padding-bottom:1rem;" />
                @endif
                <br><br>
                <span class="position style" style="">INVOICE No. :&nbsp;&nbsp;</span>
                <span class="style" style="transform: ScaleX(1.05);">{{ $order->invoice_num }}</span><br>



                <span class="position style" style="">ORDER ID:&nbsp;&nbsp;</span>
                <span class="style" style="transform: ScaleX(1.05);">{{ $order->order_id }}</span> <br>
                <span class="position style"
                    style="width: 2.51rem; height: 0.84rem; left: 0.00rem; top: 0.50rem; transform: ScaleX(1.05);">Date:&nbsp;&nbsp;</span>
                <span class="style" style="transform: scaleX(1.05);">
                    <?php echo date('d/m/Y', strtotime($order->order_date)); ?>

            </td>
            <td style="text-align:center;">
                <p style="font-size:25px;font-family: 'Montserrat', sans-serif;">Jay's Watch Store <br>Pvt. Ltd.</p>
            </td>
            <td style="padding-top:1rem;padding-bottom:1rem;text-align:right;"><img
                    src="{{ public_path('assets/admin_assets/invoice_logo.png') }}" class=""
                    style="width: 8rem;" /></td>
        </tr>
        <tr>
            <td colspan="3">
                <hr style="color:#c02026;">
            </td>
        </tr>
    </table>

    <table style="width: 100%;padding:0px 20px;text-align:left;">
        <tr style="text-align: left;">
            <td style="width:50%;">
                <div class="receipt-right" style="line-height:2;">
                    <h5 style="color:#c02026;">Invoice To </h5>
                    <p><b>Customer Name :</b>&nbsp;&nbsp;{{ $order->shipping_first_name }}
                        {{ $order->shipping_last_name }}</p>
                    <p><b>Mobile Number :</b>&nbsp;&nbsp;{{ $order->shipping_phone }}</p>
                    <p><b>Email Id:</b>&nbsp;&nbsp;{{ $order->shipping_email }}</p>

                </div>
            </td>
            <td style="padding-left:20px;width:50%;">
                <div class="receipt-right" style="line-height:2;">
                    <h5 style="color:#c02026;">Payment Details </h5>


                    <p><b>Payment Method :</b>&nbsp;&nbsp;{{ $order->payment_mode }}</p>
                    <p><b>Transaction No :</b>&nbsp;&nbsp;{{ $order->transaction_id }}</p>

                </div>
            </td>
        </tr>
    </table>

    <table class="table1" style="width: 100%;padding:20px;">
        <thead>
            <tr>
                <th
                    style="border-bottom: 1px solid #c02026;border-top: 1px solid #c02026; vertical-align: top;border-right: 1px solid #3a3a3a;padding:10px;">
                    Sr No.</th>
                <th
                    style="border-bottom: 1px solid #c02026; border-top: 1px solid #c02026; vertical-align: top;border-right: 1px solid #3a3a3a;padding:10px;">
                    Product & Description</th>
                <th
                    style="border-bottom: 1px solid #c02026;  border-top: 1px solid #c02026; vertical-align: top;border-right: 1px solid #3a3a3a;padding:10px;">
                    HSN Code</th>
                <th
                    style="border-bottom: 1px solid #c02026; border-top: 1px solid #c02026; vertical-align: top;padding:10px;">
                    Total Price</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 1px solid #3a3a3a;">
            @php $i = 1; @endphp
            @foreach ($order->items as $item)
                <tr class="bordersasa">
                    <td style="text-align:center;">{{ $i++ }}</td>
                    <td style="text-align:center;">
                        {{ strtoupper('USED WATCH - ' . ($item->product_name ?? '-')) }}
                    </td>
                    <td style="text-align:center;">{{ $item->hsn_code ?? '-' }}</td>
                    <td style="border:0px; text-align:center;">{{ indian_number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>



    <table class="table" style="width: 100%;padding:0 20px 0px 20px;">
        <thead>
            <tr>
                <th style="text-align: left;font-weight:normal;">Goods once sold will not be taken back<br><br>
                    Goods sold are used/second hand goods</th>
                <th style="text-align: left;font-weight:normal;"></th>

                <th
                    style="text-align: left;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">
                    Net Amount : {{ indian_number_format($order->subtotal, 2) }}</th>

            </tr>
        </thead>
        <tbody>
            {{-- ✅ TCS Section --}}
            @if ($order->tcs > 0 && strtolower($order->shipping_citizen_type) === 'indian')
                <tr style="text-align: right;">
                    <th style="text-align: left; font-weight:normal;"></th>
                    <td></td>
                    <th
                        style="text-align: left; border-top:1px solid #d2d2d2; padding-top:7px; padding-bottom:7px; font-weight:normal;">
                        TCS (1%) : {{ indian_number_format($order->tcs, 2) }}
                    </th>
                </tr>
            @elseif($order->tcs > 0 && strtolower($order->shipping_citizen_type) === 'non-indian')
                <tr style="text-align: right;">
                    <th style="text-align: left; font-weight:normal;"></th>
                    <td></td>
                    <th
                        style="text-align: left; border-top:1px solid #d2d2d2; padding-top:7px; padding-bottom:7px; font-weight:normal;">
                        TCS (5%) : {{ indian_number_format($order->tcs, 2) }}
                    </th>
                </tr>
            @else
                <tr style="text-align: right;">
                    <th style="text-align: left; font-weight:normal;"></th>
                    <td></td>
                    <th
                        style="text-align: left; border-top:1px solid #d2d2d2; padding-top:7px; padding-bottom:7px; font-weight:normal;">

                    </th>
                </tr>
            @endif




            {{-- ✅ Total Section --}}
            <tr style="text-align: right;">

                <th style="text-align: left; font-weight: normal;">
                    CIN-U52590MH2022PTC392589 <br>
                    GST - 27AAFCJ7965H1Z2
                </th>

                <td></td>

                @if ($order->payment_method == 'prebook')
                    <th
                        style="text-align: left; color:#c02026; border-top:1px solid #d2d2d2; padding-top:7px; padding-bottom:7px; font-weight:normal;">

                        Total Amount : {{ indian_number_format($order->grand_total, 2) }} <br>
                        Total Paid : {{ indian_number_format($order->total, 2) }} <br>
                        Total Remaining : {{ indian_number_format($order->grand_total - $order->total, 2) }}

                    </th>
                @else
                    <th
                        style="text-align: left; color:#c02026; border-top:1px solid #d2d2d2; padding-top:7px; padding-bottom:7px; font-weight:normal;">
                        Total INR : {{ indian_number_format($order->total, 2) }}
                    </th>
                @endif

            </tr>


            {{-- ✅ Additional Info --}}
            <tr style="text-align: right;">
                @if ($order->tcs > 0 && strtolower($order->shipping_citizen_type) === 'indian')
                    <th style="text-align: left; font-weight:normal; padding-top:7px; padding-bottom:7px;">
                        Note: Effective 22 April 2025, 1% TCS on listing price will be applicable and collected
                        separately by our team. Please refer to Terms & Conditions for details.
                    </th>
                @elseif($order->tcs > 0 && strtolower($order->shipping_citizen_type) === 'non-indian')
                    <th style="text-align: left; font-weight:normal; padding-top:7px; padding-bottom:7px;">
                        Note: Effective 22 April 2025, 5% TCS on listing price will be applicable and collected
                        separately by our team. Please refer to Terms & Conditions for details.
                    </th>
                @else
                    <th style="text-align: left; font-weight:normal; padding-top:7px; padding-bottom:7px;">
                        <!--Note: Effective 22 April 2025, TCS on listing price will be applicable and collected separately by our team. Please refer to Terms & Conditions for details.-->
                    </th>
                @endif
                <td></td>
                <th style="text-align: left; font-weight:normal;"></th>
            </tr>

        </tbody>

    </table>
    <table style="width:100%; padding:0 20px 0px 20px;">
        <tr style="text-align: right;">
            <th style="text-align: left; font-weight:normal; padding-top:7px; padding-bottom:7px;">
                Place of Supply - Mumbai, Maharashtra
            </th>
            <td></td>
            <th style="text-align: left; font-weight:normal;"></th>
        </tr>
        <tr>

            <td style="width:50%; vertical-align:top;">
                <h4 style="color:#c02026; margin-bottom:5px;">Shipping Address</h4>
                <p>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}<br>

                </p>
            </td>
            <td style="width:50%; vertical-align:top;">
                <h4 style="color:#c02026; margin-bottom:5px;">Billing Address</h4>
                <p>{{ $order->billing_first_name }} {{ $order->billing_last_name }}<br>
                    {{ $order->billing_address }}<br>
                    {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zip }}<br>

                </p>
            </td>
        </tr>
    </table>

    <table class="table"
        style="width: 94%;padding:29px 20px 29px 20px;margin-left:20px; margin-right:20px; background-color: #eaeaea;border-bottom:4px solid #c02026;">



        <thead>
            <tr>
                <th style="text-align:left;">Registered Office</th>
                <th></th>
                <th></th>
            </tr>
        </thead>

        <tbody>


            <tr>
                <td>B2,Floor-1,Corinthian,Strand Road,Strand Cinema Mumbai-400005</td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
            </tr>


            <tr>
                <td><b>Corporate Office</b></td>
                <td></td>
            </tr>
            <tr>
                <td>Akansha Heights, B Wing, 201, 2nd Floor, Opposite The St. Regis Exit Gate,</td>
                <td></td>
            </tr>
            <tr>
                <td>Gandhi Nagar, Upper Worli, Mumbai 400018</td>
                <td>Signatory</td>
            </tr>

            <tr>
                <td></td>
                <td style="border-bottom: 1.5px solid #d2d2d2!important;padding-top:3px;"></td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <style type="text/css">
        body {
            background: #eee;
            margin-top: 10px;
        }

        .wills {
            line-height: normal !important;
            text-align: left !important;
        }

        .wills p {
            padding: 0 !important;
            margin: 0 !important;
        }

        .text-danger strong {
            color: #9f181c;
        }

        .receipt-main {
            background: #ffffff none repeat scroll 0 0;
            margin-top: 0px;
            margin-bottom: 50px;
            padding: 0px 0px !important;
            position: relative;
            box-shadow: 0 1px 21px #acacac;
            color: #333333;
        }

        .receipt-main p {
            color: #333333;
            line-height: 1.42857;
        }

        .receipt-footer h1 {
            font-size: 15px;
            font-weight: 400 !important;
            margin: 0 !important;
        }

        .receipt-main::after {
            background: #414143 none repeat scroll 0 0;
            content: "";
            height: 5px;
            left: 0;
            position: absolute;
            right: 0;
            top: -13px;
        }

        .receipt-main thead th {
            font-size: 12px;
        }

        .receipt-right h5 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 7px 0;
        }

        .receipt-right p {
            font-size: 12px;
            margin: 0px;
        }

        .receipt-right p i {
            text-align: center;
            width: 18px;
        }

        .receipt-main td,
        .receipt-main th {
            padding: 7px !important;
        }

        .receipt-main td {
            font-size: 13px;
            font-weight: initial !important;
        }

        .receipt-main td p:last-child {
            margin: 0;
            padding: 0;
        }

        .receipt-main td h2 {
            font-size: 20px;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
        }

        .receipt-header-mid .receipt-left h1 {
            font-weight: 100;
            margin: 34px 0 0;
            text-align: right;
            text-transform: uppercase;
        }

        .receipt-header-mid {
            margin: 24px 0;
            overflow: hidden;
        }

        #container {
            background-color: #dcdcdc;
        }

        .bordersasa td {
            border-right: 1px solid #3a3a3a;
            vertical-align: top;
            border-right: 1px solid #3a3a3a;
            padding: 10px;
        }

        .bordersasa {
            border-bottom: 1px solid #3a3a3a;
        }

        .table1 {
            border-spacing: 0;
            border-collapse: collapse;
        }
    </style>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>

</body>

</html>
