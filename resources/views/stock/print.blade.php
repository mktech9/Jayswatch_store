<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Transfer</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 25px;
        }

        h2, h3, h4 {
            margin: 0;
            padding: 0;
        }

        /* ✅ Header */
        .invoice-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        .invoice-header h2 {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .invoice-header p {
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }

        /* ✅ Info Section */
        .info-grid {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-box {
             width: 27%;
    height: 65px;
    display: inline-block;
    vertical-align: top;
    border: 1px solid #ddd;
    padding: 12px;
    border-radius: 6px;
        }

        .info-box h4 {
            font-size: 14px;
            margin-bottom: 6px;
            color: #222;
        }

        .info-box p {
            margin: 3px 0;
            font-size: 12px;
        }

        /* ✅ Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table th {
            background: #2c3e50;
            color: #fff;
            padding: 10px;
            font-size: 13px;
            text-align: center;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* ✅ Total Box */
        .total-summary {
            margin-top: 20px;
            float: right;
            width: 40%;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .total-summary td {
            padding: 10px;
            font-size: 13px;
        }

        .total-summary th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: left;
            padding: 10px;
        }

        /* ✅ Notes */
        .notes-box {
            margin-top: 30px;
            border: 1px dashed #999;
            padding: 12px;
            border-radius: 6px;
        }

        .notes-box h4 {
            margin-bottom: 6px;
            font-size: 14px;
        }

        /* ✅ Amount in Words */
        .amount-words {
            margin-top: 20px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #fdfdfd;
            font-size: 13px;
        }

        /* ✅ Signature Section */
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }

        .signature-box {
            width: 32%;
            display: inline-block;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-label {
            margin-top: 8px;
            font-weight: bold;
            font-size: 12px;
        }

        /* ✅ Barcode Section */
        .barcode-section {
            margin-top: 50px;
            text-align: center;
            border-top: 1px dashed #aaa;
            padding-top: 20px;
        }

        .barcode-box {
            display: inline-block;
            padding: 15px 25px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
        }

        .barcode-text {
            margin-top: 8px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* ✅ Print Fix */
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

@php
/* ✅ Pure PHP Indian Amount to Words Function */
function numberToWordsIndian($num)
{
    $ones = [
        "", "One", "Two", "Three", "Four", "Five", "Six", "Seven",
        "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"
    ];

    $tens = [
        "", "", "Twenty", "Thirty", "Forty", "Fifty",
        "Sixty", "Seventy", "Eighty", "Ninety"
    ];

    if ($num == 0) return "Zero";

    $result = "";

    if ($num >= 10000000) {
        $result .= numberToWordsIndian(intval($num / 10000000)) . " Crore ";
        $num %= 10000000;
    }

    if ($num >= 100000) {
        $result .= numberToWordsIndian(intval($num / 100000)) . " Lakh ";
        $num %= 100000;
    }

    if ($num >= 1000) {
        $result .= numberToWordsIndian(intval($num / 1000)) . " Thousand ";
        $num %= 1000;
    }

    if ($num >= 100) {
        $result .= numberToWordsIndian(intval($num / 100)) . " Hundred ";
        $num %= 100;
    }

    if ($num > 0) {
        if ($num < 20) {
            $result .= $ones[$num] . " ";
        } else {
            $result .= $tens[intval($num / 10)] . " ";
            $result .= $ones[$num % 10] . " ";
        }
    }

    return trim($result);
}
@endphp

<!-- ✅ Header -->
<div class="invoice-header">
    <h2>STOCK TRANSFER</h2>
    <p>
        Reference No: <b>{{ $transfer->reference_no }}</b>
        | Date: {{ $transfer_date }}
    </p>
</div>

<!-- ✅ Info Section -->
<div class="info-grid">

    <div class="info-box">
        <h4>From Location</h4>
        <p><b>Name:</b> {{ $fromLocation->name ?? '-' }}</p>
        <p><b>Address:</b> {{ $fromLocation->address ?? '-' }}</p>
        <p><b>Email:</b> {{ $fromLocation->email ?? '-' }}</p>
    </div>

    <div class="info-box" style="margin: 0 1%;">
        <h4>To Location</h4>
        <p><b>Name:</b> {{ $toLocation->name ?? '-' }}</p>
        <p><b>Address:</b> {{ $toLocation->address ?? '-' }}</p>
        <p><b>Email:</b> {{ $toLocation->email ?? '-' }}</p>
    </div>

    <div class="info-box">
        <h4>Transfer Info</h4>
        <p><b>Status:</b>
            @if($transfer->stock_status == 0)
                Pending
            @elseif($transfer->stock_status == 1)
                In-Transit
            @else
                Completed
            @endif
        </p>

        <p><b>Shipping Charges:</b> ₹ {{ number_format($transfer->shipping_charges, 2) }}</p>
    </div>

</div>

<!-- ✅ Products Table -->
<h3>Transferred Products</h3>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @php $netTotal = 0; @endphp

        @foreach($products as $key => $item)
            @php
                $lineTotal = $item->qyt * $item->unit_price;
                $netTotal += $lineTotal;
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>
                <td style="text-align:left; padding-left:10px;">
                    {{ $item->product->pro_name ?? '-' }}
                </td>
                <td>{{ $item->qyt }}</td>
                <td>₹ {{ number_format($item->unit_price, 2) }}</td>
                <td>₹ {{ number_format($lineTotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- ✅ Total Summary -->
<table class="total-summary">
    <tr>
        <th>Net Total</th>
        <td>₹ {{ number_format($netTotal, 2) }}</td>
    </tr>
    <tr>
        <th>Shipping Charges</th>
        <td>₹ {{ number_format($transfer->shipping_charges, 2) }}</td>
    </tr>
    <tr>
        <th>Grand Total</th>
        <td><b>₹ {{ number_format($netTotal + $transfer->shipping_charges, 2) }}</b></td>
    </tr>
</table>

<div style="clear: both;"></div>

<!-- ✅ Amount in Words -->
@php
    $grandTotal = round($netTotal + $transfer->shipping_charges);
    $amountWords = numberToWordsIndian($grandTotal);
@endphp

<div class="amount-words">
    <b>Total Amount in Words:</b> {{ $amountWords }} Only.
</div>

<!-- ✅ Notes -->
<div class="notes-box">
    <h4>Additional Notes</h4>
    <p>{{ $transfer->notes ?? '--' }}</p>
</div>

{{-- <!-- ✅ Signature Area -->
<div class="signature-section">

    <div class="signature-box">
        <div class="signature-line"></div>
        <div class="signature-label">Prepared By</div>
    </div>

    <div class="signature-box" style="margin: 0 1%;">
        <div class="signature-line"></div>
        <div class="signature-label">Received By</div>
    </div>

    <div class="signature-box">
        <div class="signature-line"></div>
        <div class="signature-label">Authorized Signature</div>
    </div>

</div> --}}

<!-- ✅ Barcode -->
<div class="barcode-section">
    <h4>Reference Barcode</h4>

    <div class="barcode-box">
       <img src="data:image/png;base64,
{{ Milon\Barcode\Facades\DNS1DFacade::getBarcodePNG($transfer->reference_no ?? 'NA', 'C128', 2, 60) }}">


        <p class="barcode-text">{{ $transfer->reference_no }}</p>
    </div>
</div>

<!-- ✅ Auto Print -->
<script>
    window.onload = function () {
        window.print();
    }
</script>

</body>
</html>
