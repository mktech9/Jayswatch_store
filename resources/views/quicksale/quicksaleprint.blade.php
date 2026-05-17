<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="background-color: #ffffff;border:1px solid #000;font-size:13px;font-family: 'Montserrat', sans-serif;">
   <span class="graphic" style="width: 95%; height: 5px; display: block; z-index: -10; left: 3.27rem; top: 1px;background-color: #c02026;margin: 0px auto;"></span>
    <table style="width: 100%;padding:20px 20px 5px 20px;text-align:left;">
        <tr>
            <td>
                <img src="{{ public_path('assets/admin_assets/invoice.png') }}" class="image" style="width: 9rem;text-align: left;padding-top:1rem;padding-bottom:1rem;"/>
                <br><br>
                <span class="position style" style="width: 2.51rem; height: 0.84rem; left: 0.00rem; top: 0.50rem; transform: ScaleX(1.05);">Date:&nbsp;&nbsp;</span>
                <span class="style" style="transform: ScaleX(1.05);"><?php echo date('d/m/Y H:i', strtotime($quicksale->bill_date)); ?></span><br>
                <span class="position style" style="">Invoice No:&nbsp;&nbsp;</span>
                <span class="style" style="transform: ScaleX(1.05);">{{ $quicksale->invoice_num }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td style="text-align:center;"><p style="font-size:25px;font-family: 'Montserrat', sans-serif;">Jay's Watch Store <br>
                Pvt. Ltd.</p></td>
            <td style="padding-top:1rem;padding-bottom:1rem;text-align:right;"><img src="{{ public_path('assets/admin_assets/invoice_logo.png') }}" class="" style="width: 8rem;"/></td>
        </tr>
        <tr>
            <td colspan="3"><hr style="color:#c02026;"></td>
        </tr>
    </table>

    <table style="width: 100%;padding:0px 20px;text-align:left;">
        <tr style="text-align: left;">
            <td style="width:50%;">
                <div class="receipt-right" style="line-height:2;">
                    <h5 style="color:#c02026;">Invoice To </h5>
                        <p><b>Customer Name :</b>&nbsp;&nbsp;{{$quicksale->fullname }}</p>
                        <p><b>Mobile Number :</b>&nbsp;&nbsp;{{$quicksale->mobile_num }}</p>
                        <p><b>Email Id:</b>&nbsp;&nbsp;{{$quicksale->email }}</p>
                        @if($quicksale->gsttype=="yes")
                            <p><b>GST IN :</b>&nbsp;&nbsp;{{$quicksale->gstnum }}</p>
                        @endif
                        <p><b>Identification:</b>&nbsp;&nbsp;{{$quicksale->id_numbers }}, ({{$quicksale->id_proof_type }})</p>
                </div>
            </td>
            <td style="padding-left:20px;width:50%;">
                <div class="receipt-right" style="line-height:2;">
                    <h5 style="color:#c02026;">Payment Details </h5>
                    @if($quicksale->id<=22)
                        @if($quicksale->type=="Card")

                            <p><b>Payment Method :</b>&nbsp;&nbsp;{{$quicksale->type }}</p>
                            <p><b>Card No :</b>&nbsp;&nbsp;<?php echo "XXXX- XXXX- XXXX- ".preg_replace( "#(.*?)(\d{4})$#", "$2", $quicksale->chq_card); ?></p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            @if($quicksale->gsttype=="yes")
                                <p><b>&nbsp;&nbsp;</b></p>
                            @endif
                        @endif

                        @if($quicksale->type=="Cash")
                            <p><b>Payment Method :</b>&nbsp;&nbsp;{{$quicksale->type }}</p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            @if($quicksale->gsttype=="yes")
                                <p><b>&nbsp;&nbsp;</b></p>
                            @endif
                        @endif

                        @if($quicksale->type=="Cheque")
                            <p><b>Payment Method :</b>&nbsp;&nbsp;{{$quicksale->type }}</p>
                            <p><b>Cheque No :</b>&nbsp;&nbsp;{{$quicksale->chq_card }}</p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            @if($quicksale->gsttype=="yes")
                                <p><b>&nbsp;&nbsp;</b></p>
                            @endif
                        @endif
                        @if($quicksale->type=="RTGS" || $quicksale->type=="NEFT")
                            <p><b>Payment Method :</b>&nbsp;&nbsp;{{$quicksale->type }}</p>
                            <p><b>Transaction No :</b>&nbsp;&nbsp;{{$quicksale->chq_card }}</p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            <p><b>&nbsp;&nbsp;</b></p>
                            @if($quicksale->gsttype=="yes")
                                <p><b>&nbsp;&nbsp;</b></p>
                            @endif
                        @endif
                        @if($quicksale->type=="Online Bank Transfer")
                            <p><b>Payment Method :</b>&nbsp;&nbsp;{{$quicksale->type }}</p>
                            <p><b>Transaction No :</b>&nbsp;&nbsp;{{$quicksale->chq_card }}</p>
                            @if($quicksale->bank!="")
                                <p><b>Bank :</b>&nbsp;&nbsp;{{ $quicksale->bank }}</p>
                                <p><b>&nbsp;&nbsp;</b></p>
                                @if($quicksale->gsttype=="yes")
                                    <p><b>&nbsp;&nbsp;</b></p>
                                @endif
                            @else
                                <p><b>&nbsp;&nbsp;</b></p>
                                <p><b>&nbsp;&nbsp;</b></p>
                                @if($quicksale->gsttype=="yes")
                                    <p><b>&nbsp;&nbsp;</b></p>
                                @endif
                            @endif
                        @endif
                    @else
                        @php
                            $r=1;
                        @endphp
                        @foreach($quicksale->quicksale_payment as $keys)
                            <p><b>{{ $r++ }})Payment Method :</b>&nbsp;&nbsp;{{ $keys->split_type }},@if($keys->split_type=="Card") <b>Card No :</b>&nbsp;&nbsp;<?php echo "XXXX- XXXX- XXXX- ".preg_replace( "#(.*?)(\d{4})$#", "$2", $keys->split_chq_card); ?>, @endif
                                @if($keys->split_type=="Cheque") <b>Cheque No :</b>&nbsp;&nbsp;{{$keys->split_chq_card }} , @endif @if($keys->split_type=="RTGS" || $keys->split_type=="NEFT") <b>Transaction No :</b>&nbsp;&nbsp;{{$keys->split_chq_card }} , @endif
                                @if($keys->split_type=="Online Bank Transfer") <b>Transaction No :</b>&nbsp;&nbsp;{{$keys->split_chq_card }} ,<b>Bank :</b>&nbsp;&nbsp;{{ $keys->split_bank }} @endif </p>
                            </p>
                        @endforeach
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <table class="table1"  style="width: 100%;padding:20px;">
        <thead>
            <tr>
                <th style="border-bottom: 1px solid #c02026;border-top: 1px solid #c02026; vertical-align: top;border-right: 1px solid #3a3a3a;padding:10px;">Sr No.</th>
                <th style="border-bottom: 1px solid #c02026; border-top: 1px solid #c02026; vertical-align: top;border-right: 1px solid #3a3a3a;padding:10px;">Product & Description</th>
                <th style="border-bottom: 1px solid #c02026;  border-top: 1px solid #c02026; vertical-align: top;border-right: 1px solid #3a3a3a;padding:10px;">HSN Code</th>
                <th style="border-bottom: 1px solid #c02026; border-top: 1px solid #c02026; vertical-align: top;padding:10px;">Total Price</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 1px solid #3a3a3a;">
            @php
                $i=1;
            @endphp
            @foreach($quicksale->quicksaleproduct as $key)
                <tr class="bordersasa">
                    <td style="text-align:center;">{{ $i++ }}</td>
                    <td style="text-align:center;">{{ $key->product_name }} - {{ $key->description }}</td>
                    <td style="text-align:center;">{{ $key->hsn_code }}</td>
                    <td style="border: 0px;text-align:center;">{{ $key->per_total_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        // Calculate net amount (with or without GST)
        $netAmount = ($quicksale->gsttype == "yes") ? ($quicksale->finaltotal - $quicksale->gst) : $quicksale->finaltotal;

        // Use TCS value from database column
        $tcsAmount = $quicksale->tcs ?? 0;

        $netAmount = $netAmount - $tcsAmount ;

        // Calculate final total including TCS
        $totalAmount = $quicksale->finaltotal;
    @endphp

    <table class="table" style="width: 100%;padding:10px">
        <thead>
            <tr>
                <th style="text-align: left;font-weight:normal;">Goods once sold will not be taken back</th>
                <th style="text-align: left;font-weight:normal;"></th>
                @if($quicksale->gsttype=="yes")
                    <th style="text-align: left;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">Net Amount : {{ number_format($netAmount, 2) }}</th>
                @else
                    <th style="text-align: left;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">Net Amount : {{ number_format($netAmount, 2) }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if($tcsAmount > 0)
                <tr style="text-align: right;">
                    <th style="text-align: left;font-weight:normal;"></th>
                    <td></td>
                    <th style="text-align: left;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">TCS (1%) : {{ number_format($tcsAmount, 2) }}</th>
                </tr>
            @endif

            @if($quicksale->gsttype=="yes")
                <tr style="text-align: right;">
                    <th style="text-align: left;font-weight:normal;">Goods sold are used/second hand goods</th>
                    <td></td>
                    <th style="text-align: left;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">Sales: CGST 9%:- {{ number_format(($quicksale->gst/2), 2) }}</th>
                </tr>
                <tr style="text-align: right;">
                    <th style="text-align: left;font-weight:normal;">CIN-U52590MH2022PTC392589</th>
                    <td></td>
                    <th style="text-align: left;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">Sales: SGST 9%:- {{ number_format(($quicksale->gst/2), 2) }}</th>
                </tr>
                <tr style="text-align: right;">
                    @if($quicksale->location_id==1)
                        <th style="text-align: left;font-weight:normal;">GST-24AAFCJ7965H1Z8 </th>
                   @elseif($quicksale->location_id==7)
                        <th style="text-align: left;font-weight:normal;">GST-29AAFCJ7965H1ZY </th>
                    @else
                        <th style="text-align: left;font-weight:normal;">GST-27AAFCJ7965H1Z2 </th>
                    @endif
                    <td></td>
                    <th style="text-align: left;color:#c02026;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">Total INR:- {{ number_format($totalAmount, 2) }}</th>
                </tr>

                @if($quicksale->location_id==1)
                     <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Supply - Ahmedabad, Gujarat  </th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Delivery - Ahmedabad, Gujarat</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
               @elseif($quicksale->location_id==7)
                     <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Supply - Bangalore, Karnataka</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Delivery - Bangalore, Karnataka</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                @else
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Supply - Mumbai, Maharashtra  </th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Delivery - Mumbai, Maharashtra</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                @endif
                <tr style="text-align: right;">
                    <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Goods are subject to taxable under margin scheme of GST.</th>
                    <td></td>
                    <th style="text-align: left;font-weight:normal;"></th>
                </tr>
            @else
                 <tr style="text-align: right;">
                    <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Goods sold are used/second hand goods</th>
                    <td></td>
                    <th style="text-align: left;color:#c02026;border-top: 1px solid #d2d2d2;padding-top:7px;padding-bottom:7px;font-weight:normal;">Total INR:- {{ number_format($totalAmount, 2) }}</th>
                </tr>
                <tr style="text-align: right;">
                    <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">CIN-U52590MH2022PTC392589</th>
                    <td></td>
                    <th style="text-align: left;font-weight:normal;"></th>
                </tr>
                <tr style="text-align: right;">
                    @if($quicksale->location_id==1)
                        <th style="text-align: left;font-weight:normal;">GST-24AAFCJ7965H1Z8 </th>
                   @elseif($quicksale->location_id==7)
                        <th style="text-align: left;font-weight:normal;">GST-29AAFCJ7965H1ZY </th>
                    @else
                        <th style="text-align: left;font-weight:normal;">GST-27AAFCJ7965H1Z2 </th>
                    @endif
                    <td></td>
                    <th style="text-align: left;font-weight:normal;"></th>
                </tr>

                @if($quicksale->location_id==1)
                     <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Supply - Ahmedabad, Gujarat</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Delivery - Ahmedabad, Gujarat</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                @elseif($quicksale->location_id==7)
                     <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Supply - Bangalore, Karnataka</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Delivery - Bangalore, Karnataka</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                @else
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Supply - Mumbai, Maharashtra</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                    <tr style="text-align: right;">
                        <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Place of Delivery - Mumbai, Maharashtra</th>
                        <td></td>
                        <th style="text-align: left;font-weight:normal;"></th>
                    </tr>
                @endif
                <tr style="text-align: right;">
                    <th style="text-align: left;font-weight:normal;padding-top:7px;padding-bottom:7px;">Goods are subject to taxable under margin scheme of GST.</th>
                    <td></td>
                    <th style="text-align: left;font-weight:normal;"></th>
                </tr>
            @endif
        </tbody>
    </table>

    <table class="table"    style="width: 94%;padding:29px 20px 29px 20px;margin-left:20px; margin-right:20px; background-color: #eaeaea;border-bottom:4px solid #c02026;">
         <!--@if($quicksale->location_id!=1)-->
         <!--   <thead>-->
         <!--       <tr >-->
         <!--           <th style="text-align:left;">Registered Office</th>-->
         <!--           <th></th>-->
         <!--           <th></th>-->
         <!--       </tr>-->
         <!--   </thead>-->
         <!--@endif-->

          @if($quicksale->location_id=1)
            <thead>
                <tr >
                    <th style="text-align:left;">Registered Office</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
         @endif
        <tbody>
            <!--@if($quicksale->location_id!=1)-->
            <!--    <tr>-->
            <!--        <td>B2,Floor-1,Corinthian,Strand Road,Strand Cinema Mumbai-400005</td>-->
            <!--        <td></td>-->
            <!--    </tr>-->
            <!--@endif-->
             @if($quicksale->location_id=1)
                <tr>
                    <td>B2,Floor-1,Corinthian,Strand Road,Strand Cinema Mumbai-400005</td>
                    <td></td>
                </tr>
            @endif
            <tr>
                <td></td>
                <td></td>
            </tr>

            @if($quicksale->location_id==1)
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
            @else
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
            @endif
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

        .receipt-main td, .receipt-main th {
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

        .bordersasa td{
            border-right: 1px solid #3a3a3a;vertical-align: top;border-right: 1px solid #3a3a3a;padding:10px;
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
