<!DOCTYPE html>
<html lang="en">
@include('frontend.partials.header_link')

<body>

@include('frontend.partials.header')

<style>
.track-page {
    background:#f8f8f8;
    padding:40px 0;
}

.track-card {
    background:#fff;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    overflow:hidden;
}

.track-top {
    background:#212529;
    color:#fff;
    padding:30px;
}

.track-top h2 {
    font-size:34px;
    margin-bottom:10px;
    font-weight:700;
}

.track-top h4 {
    font-size:20px;
    margin:0;
}

.order-no {
    font-size:22px;
    font-weight:600;
    padding:25px 30px 10px;
}

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
    min-width:max-content;
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

/* ICON */

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

.step h6 {
    font-size:15px;
    font-weight:600;
    margin-bottom:5px;
    font-family:"Montserrat", sans-serif;
}

.step p {
    font-size:12px;
    margin:0;
    color:#666;
}

/* ===================== MOBILE ===================== */

@media(max-width:768px){

.timeline {
    display:block;
}

.timeline::before {
    top:0;
    left:15px;
    width:4px;
    height:100%;
}

.timeline::after {
    display:none;
}

.step {
    text-align:left;
    padding-left:40px;
    margin-bottom:30px;
}

.step::before {
    left:15px;
    top:0;
    transform:translateX(-50%);
}

}

/* ===================== INFO ===================== */

.info-box {
    padding:25px 30px;
    border-top:1px solid #eee;
}

.agent-box {
    background:#f8f9fa;
    border:1px solid #ddd;
    padding:20px;
    border-radius:10px;
}
</style>

<section class="track-page">

<div class="container">

<div class="track-card">

<!-- TOP -->

<div class="track-top">

    <h2>Order Status:</h2>

    <h4>{{ $currentStatus }}</h4>

</div>

<div class="order-no">
    Order No: {{ $order->order_id }}
</div>

<!-- TIMELINE -->

<div class="timeline-wrap">

    <div class="timeline">

        @foreach ($steps as $step)

        <div class="step">

            <h6>{{ $step['title'] }}</h6>

            <p>{{ $step['date'] }}</p>

            <p>{{ strtoupper($step['city']) }}</p>

            @if (!empty($step['delivery_guy']))

                <div class="agent-box mt-2">

                    <p class="mb-1">
                        <strong>Delivery Agent:</strong>
                        {{ $step['delivery_guy'] }}
                    </p>

                    <p class="mb-0">
                        <strong>Contact:</strong>
                        {{ $step['contact_number'] }}
                    </p>

                </div>

            @endif

        </div>

        @endforeach

    </div>

</div>

<!-- CUSTOMER DETAILS -->

<div class="info-box">

    <div class="row">

        <div class="col-md-6">

            <h5>Customer Details</h5>

            <p>
                {{ $order->shipping_first_name }}
                {{ $order->shipping_last_name }}
                <br>

                {{ $order->shipping_phone }}
                <br>

                {{ $order->shipping_email }}
            </p>

        </div>

        <div class="col-md-6">

            <h5>Shipping Address</h5>

            <p>
                {{ $order->shipping_address }}
                <br>

                {{ $order->shipping_city }},
                {{ $order->shipping_state }}
                <br>

                {{ $order->shipping_pincode }}
            </p>

        </div>

    </div>

</div>

</div>

</div>

</section>

@include('frontend.partials.footer')
@include('frontend.partials.footer_link')

</body>
</html>
