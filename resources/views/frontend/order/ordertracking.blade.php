<!DOCTYPE html>
<html lang="en">
@include('frontend.partials.header_link')

<body>

@include('frontend.partials.header')

<style>
.track-page { background:#f8f8f8; padding:40px 0; }
.track-card { background:#fff; box-shadow:0 5px 20px rgba(0,0,0,.08); overflow:hidden; }

.track-top { background:#212529; color:#fff; padding:30px; }
.track-top h2 { font-size:34px; margin-bottom:10px; font-weight:700; }
.track-top h4 { font-size:20px; margin:0; }

.order-no { font-size:22px; font-weight:600; padding:25px 30px 10px; }

/* ===================== DESKTOP TIMELINE ===================== */
.timeline-wrap {
    padding:20px 30px 40px;
    overflow-x:auto;
    overflow-y:hidden;
}

.timeline {
    display:flex;
    gap:40px;
    position:relative;
    min-width:max-content; /* IMPORTANT */
}

/* LINE */
.timeline::before {
    content:'';
    position:absolute;
    top:17px;
    left:0;
    width:100%;
    height:4px;
    background:#212529;
}

.timeline::after {
    content:'';
    position:absolute;
    top:17px;
    left:0;
    width:100%;
    height:4px;
    background:#212529;
}

/* STEP */
.step {
    flex:1;
    text-align:center;
    position:relative;
    padding-top:40px;
}

/* SQUARE */
.step::before {
    content:'✔';
    position:absolute;
    top:0;
    left:50%;
    transform:translateX(-50%);
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#212529;
    color:#fff;
    font-size:16px;
    font-weight:bold;

    z-index:2;
}

.step h6 { font-size:15px; font-weight:600; margin-bottom:5px; font-family: "Montserrat", sans-serif; }
.step p { font-size:12px; margin:0; color:#666; }

/* ===================== MOBILE VERTICAL TIMELINE ===================== */
@media(max-width:768px){

.timeline {
    display:block;

}

/* VERTICAL LINE */
.timeline::before {
    top:0;
    left:15px;
    width:4px;
    height:100%;
}

.timeline::after {
    display:none;
}

/* STEP */
.step {
    text-align:left;
    padding-left:40px;
    margin-bottom:30px;
}

/* SQUARE */
.step::before {
    left:15px;
    top:0;
    transform:translateX(-50%);
}

}

/* ===================== INFO ===================== */
.info-box { padding:25px 30px; border-top:1px solid #eee; }
.pod-img { max-width:220px; border:1px solid #ddd; margin-top:10px; }
</style>

<section class="track-page">
<div class="container">
<div class="track-card">

@php
$history = $trackingData['Sheet_History'] ?? [];

usort($history, function ($a, $b) {
    return strtotime($a['status_date']) - strtotime($b['status_date']);
});

$steps = [];

$steps[] = [
    'title' => 'Order Placed',
    'date' => date('d-m-Y h:i A', strtotime($order->created_at)),
    'city' => $order->shipping_city ?? ''
];

foreach ($history as $h) {
    $steps[] = [
        'title' => $h['status'],
        'date' => date('d-m-Y h:i A', strtotime($h['status_date'])),
        'city' => $h['destination']
    ];
}

$currentStatus = end($steps)['title'] ?? 'Order Placed';
@endphp

<!-- TOP -->
<div class="track-top">
    <h2>Order Status:</h2>
    <h4>{{ $currentStatus }}</h4>
</div>

<div class="order-no">
    Order No: {{ $tracking_num }}
</div>

<!-- TIMELINE -->
<div class="timeline-wrap">
    <div class="timeline">

        @foreach ($steps as $step)
        <div class="step">
            <h6>{{ $step['title'] }}</h6>
            <p>{{ $step['date'] }}</p>
            <p>{{ strtoupper($step['city']) }}</p>
        </div>
        @endforeach

    </div>
</div>

<!-- SENDER / RECEIVER -->
@if (!empty($trackingData['ConsignmentDetails_Traking']['sender_name']))
<div class="info-box">
    <div class="row">

        <div class="col-md-6">
            <h5>Sender Details</h5>
            <p>
                {{ $trackingData['ConsignmentDetails_Traking']['sender_name'] }}<br>
                {{ $trackingData['ConsignmentDetails_Traking']['sender_company'] ?? '' }}<br>
                {{ $trackingData['ConsignmentDetails_Traking']['sender_city'] ?? '' }},
                {{ $trackingData['ConsignmentDetails_Traking']['sender_state'] ?? '' }}
            </p>
        </div>

        <div class="col-md-6">
            <h5>Receiver Details</h5>
            <p>
                {{ $trackingData['ConsignmentDetails_Traking']['receiver_name'] ?? '' }}<br>
                {{ $trackingData['ConsignmentDetails_Traking']['receiver_city'] ?? '' }}
            </p>
        </div>

    </div>
</div>
@endif

<!-- POD -->
@if (!empty($trackingData['_PodImage']['PodPath'][0]))
<div class="info-box text-center">
    <h5>Proof of Delivery</h5>
    <a href="{{ $trackingData['_PodImage']['PodPath'][0] }}" target="_blank">
        <img src="{{ $trackingData['_PodImage']['PodPath'][0] }}" class="pod-img">
    </a>
</div>
@endif

</div>
</div>
</section>

@include('frontend.partials.footer')
@include('frontend.partials.footer_link')

</body>
</html>
