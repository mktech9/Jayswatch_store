@php
    $subtotal = 0;
@endphp

<!DOCTYPE html>
<html lang="en">

@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')



    <style>
        .Inclusive {
            font-size: 10px;
        }

        /* ===== Jay's Watch Store Cart (scoped) ===== */
        .jw-cart {
            --ink: #111;
            --muted: #6b7280;
            --line: #e5e7eb;
            --black: #000;
        }

        .jw-cart .container-jw {
            max-width: 1280px;
            margin: 70px auto;
            padding: 0 16px;
        }

        .jw-cart .title {
            font-size: 40px;
            font-weight: 400;
            margin: 0 0 24px;
            font-family: 'aguila-thin';
        }

        .jw-cart .grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 28px;
        }

        @media (max-width: 992px) {
            .jw-cart .grid {
                grid-template-columns: 1fr;
            }
        }

        /* Left card */
        .jw-cart .card-jw {
            border: 1px solid var(--line);
            /*border-radius: 10px;*/
            padding: 18px;
        }

        .jw-cart .item {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .jw-cart .thumb {
            min-width: 60px;
            width: 90px;
            height: auto;
            object-fit: cover;
            /*border-radius: 6px;*/
            border: 1px solid var(--line);
            background: #fff;
        }

        .jw-cart .brand {
            font-size: 12px;
            color: var(--muted);
        }

        .jw-cart .name {
            font-size: 18px;
            margin: 2px 0 8px;
        }

        .jw-cart .price {
            color: var(--black);
            font-weight: 600;
            font-size: 18px;
        }

        .jw-cart .delete {
            color: #000;
            font-size: 18px;
            margin-left: 15px;
            cursor: pointer;
            transition: color .3s;
        }

        .jw-cart .delete:hover {
            color: #7f1d1d;
        }

        .jw-cart .continue {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--line);
            /*border-radius: 6px;*/
            padding: 10px 14px;
            margin-top: 16px;
            text-decoration: none;
            color: #111;
        }

        .jw-cart .continue i {
            font-size: 12px;
        }

        /* Right summary */
        .jw-cart .summary {
            border: 1px solid var(--line);
            /*border-radius: 10px;*/
            padding: 18px;
            position: sticky;
            top: 20px;
        }

        .jw-cart .summary h4 {
            font-size: 18px;
            margin: 4px 0 14px;
            font-weight: 400;
        }

        .jw-cart .row-s {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }

        .jw-cart .muted {
            color: var(--muted);
        }

        .jw-cart .divider {
            height: 1px;
            background: var(--line);
            margin: 14px 0;
        }

        .jw-cart .green {
            color: #1a7f37;
            font-size: 13px;
        }

        .jw-cart .total {
            font-size: 18px;
            font-weight: 400;
        }

        .jw-cart .input-group-jw {
            display: flex;
            gap: 10px;
            margin: 12px 0;
        }

        .jw-cart .input-group-jw input {
            flex: 1;
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0 12px;
        }

        .jw-cart .input-group-jw button {
            height: 42px;
            border: 1px solid #111;
            background: #fff;
            border-radius: 6px;
            padding: 0 14px;
            cursor: pointer;
        }

        .jw-cart .checkout {
            display: block;
            width: 100%;
            height: 46px;
            border: 0;
            /*border-radius: 8px;*/
            background: #0f1420;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }

        .jw-cart .bullets {
            list-style: none;
            margin: 12px 0 0;
            padding: 0;
        }

        .jw-cart .bullets li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 14px;
            margin: 6px 0;
        }

        /* Note styling */
        .jw-cart .note {
            font-size: 13px;
            color: var(--muted);
            background: #f9f9f9;
            border-left: 3px solid #ccc;
            padding: 10px 12px;
            /*border-radius: 4px;*/
            margin-top: 6px;
            line-height: 1.5;
        }
    </style>

    <div class="jw-cart">
        <div class="container-jw">

            <button class="Back-to-cart d-none" id="backtocart-btn">Back to Cart</button>

            <h1 class="title">Shopping Cart</h1>

            <div class="grid">
                <!-- LEFT SIDE: Shopping Cart Section -->
                <div id="cart-section">
                    @foreach ($cartItems as $item)
                        @php
                            $subtotal += $item->price;
                            $manufacturerSlug = Str::slug($item->manufacturer ?? $item->brand_name);
                            $productSlug = Str::slug($item->product_name);
                            $skuSuffix = substr($item->pro_sku, -7); // last 7 digits
                            $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? '');
                            $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->product_name ?? '');
                        @endphp
                        <div class="card-jw mt-2">
                            <div class="item">
                                <a
                                    href="{{ route('productDetails.seo', [$manufacturerSlug, $productSlug, $skuSuffix]) }}">
                                    <img class="thumb"
                                        src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $item->pro_image }}"
                                        alt="{{ $item->brand_name }} {{ $item->product_name }}" loading="eager"
                                        decoding="async"
                                        onerror="this.onerror=null;this.src='{{ $actual_url . '/front/noimage.jpg' }}';" />
                                </a>

                                <div style="flex:1">
                                    <div style="display:flex; justify-content:space-between; align-items:start;">
                                        <div>
                                            <div class="productid d-none">{{ $item->pro_id }}</div>
                                            <div class="brand">{{ $item->brand_name }}</div>
                                            <div class="name">{{ $item->product_name }}</div>
                                            <div class="price">
                                                ₹ {{ indian_number_format($item->price, 2) }}
                                                <span class="text-muted Inclusive">*Inclusive of all taxes</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-trash delete" title="Remove" data-id="{{ $item->pro_id }}"
                                                onclick="removeFromCart(this)"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($cartItems->isEmpty())
                        <p class="text-center mt-3">Your cart is empty.</p>
                    @endif

                    <a class="continue" href="{{ route('product') }}">
                        <i class="fa fa-chevron-left"></i> Continue Shopping
                    </a>
                </div>

                <!-- LEFT SIDE: Checkout Section (hidden initially) -->
                @include('frontend.order.checkout')

                <!-- RIGHT SIDE: Summary -->
                @if (!$cartItems->isEmpty())
                    <aside class="summary">
                        <h4>Order Summary</h4>
                        <div class="d-flex flex-column gap-3 order-items d-none">
                            @foreach ($cartItems as $item)
                                @php

                                    $brand_name = $item->brand_name ?? '';
                                    $pro_name = urldecode($item->product_name ?? '');
                                    $pro_name = preg_replace('/\s+/', '_', $pro_name);
                                    $pro_name = preg_replace('/[^\w\-\.\(\)&]/', '', $pro_name);
                                @endphp
                                <div class="d-flex align-items-start gap-2">
                                    <a
                                        href="{{ url('product/' . \Illuminate\Support\Str::slug($item->brand_name) . '/' . \Illuminate\Support\Str::slug($item->product_name)) }}">
                                        <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $item->pro_image }}"
                                            alt="{{ $item->brand_name }} {{ $item->product_name }}" loading="eager"
                                            decoding="async"
                                            onerror="this.onerror=null;this.src='{{ $actual_url . '/front/noimage.jpg' }}';"
                                            class="img-thumbnail"
                                            style="width: 60px; min-width: 60px; height: auto; object-fit: cover;" />
                                    </a>
                                    <div>
                                        <div class="productid d-none">{{ $item->pro_id }}</div>
                                        <div class="fw-bold">{{ $item->brand_name }}</div>
                                        <div class="text-muted">{{ $item->product_name }}</div>


                                        <!--<div class="text-muted small">Qty: 1</div>-->
                                    </div>
                                </div>
                            @endforeach
                        </div>



                        <div class="row-s">
                            <div class="muted">Subtotal</div>
                            <div id="subtotal-value">₹ {{ indian_number_format($subtotal, 2) }}</div>
                        </div>



                        <div class="row-s d-none tcspart" id="tcs-row">
                            <div class="muted">TCS (1%)</div>
                            <div id="tcs-value">₹ 0.00</div>
                        </div>
                        <div class="row-s d-none taxpart" id="tax-row">
                            <div class="muted" id="tax-label">Estimated Tax</div>
                            <div id="tax-value">₹ 0.00</div>
                        </div>
                        <div class="row-s">
                            <div class="muted">Shipping</div>
                            <div>Free</div>
                        </div>

                        <div class="note d-none notepart">
                            <strong>Note:</strong> Effective 22 April 2025, 1% TCS on listing price will be applicable
                            and collected separately by our team.
                            Please refer to <a href="https://jayswatchstore.com/terms_and_condtion"
                                style="color:#000; text-decoration:underline;">Terms & Conditions</a> for details.
                        </div>

                        <div class="divider"></div>

                        <div class="row-s total">
                            <div>Total</div>
                            <div id="total-value">₹ {{ indian_number_format($subtotal, 2) }}</div>
                        </div>

                        <!--<div class="muted" style="margin-top:16px">Promo Code</div>-->
                        <!--<div class="input-group-jw">-->
                        <!--  <input type="text" placeholder="Enter code">-->
                        <!--  <button type="button">Apply</button>-->
                        <!--</div>-->
                        @if (session('user_id'))
                            <button class="checkout" id="checkout-btn">Proceed to Checkout</button>
                        @else
                            <button class="checkout" id="custlogin">Proceed to Checkout</button>
                        @endif
                        <button class="payment d-none" id="payment-btn">Continue to Payment</button>

                        <ul class="bullets">
                            <li><i class="fa-regular fa-star"></i> Authenticity Guaranteed</li>
                            <li><i class="fa fa-ban"></i> No Returns on Purchases</li>
                            <li><i class="fa fa-lock"></i> Secure SSL Checkout</li>
                        </ul>
                    </aside>
                @endif
            </div>
        </div>
    </div>


    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        const tcsRow = document.getElementById('tcs-row');
        const tcsValue = document.getElementById('tcs-value');
        const totalValue = document.getElementById('total-value');
        const taxRow = document.getElementById('tax-row');
        const taxValue = document.getElementById('tax-value');
        const taxLabel = document.getElementById('tax-label');

        // const products = @json($cartItems); // All products

        // Function to recalculate TCS based on citizen & PAN
        function updateTCS() {
            const citizenType = document.getElementById('shipping_citizen_type')?.value;
            const hasPanYes = document.getElementById('have_pan_yes');
            const hasPanNo = document.getElementById('have_pan_no');

            let tcsAmount = 0;
            let taxPercentText = '';

            const expensiveProduct = products.find(p => parseFloat(p.price) >= 1000000);

            if (expensiveProduct) {
                let price = parseFloat(expensiveProduct.price);

                if (citizenType === 'indian') {
                    if (hasPanNo && hasPanNo.checked) {
                        tcsAmount = price * 0.05;
                        taxPercentText = '(5%)';
                    } else if (hasPanYes && hasPanYes.checked) {
                        tcsAmount = price * 0.01;
                        taxPercentText = '(1%)';
                    }
                } else if (citizenType === 'non-indian') {
                    tcsAmount = price * 0.05;
                    taxPercentText = '(5%)';
                }
            }

            // Display TCS
            if (tcsAmount > 0) {
                tcsRow.classList.remove('d-none');
                tcsValue.innerText = `₹${tcsAmount.toLocaleString("en-IN", { minimumFractionDigits:2 })}`;
                tcsRow.querySelector('.muted').innerText = `TCS ${taxPercentText}`;
            } else {
                tcsRow.classList.add('d-none');
                tcsValue.innerText = "₹0.00";
            }

            // 🔥 After updating TCS, recalc final total
            updatePaymentTotal();
        }


        // 🟢 Event Listeners
        document.getElementById('shipping_citizen_type')?.addEventListener('change', updateTCS);
        document.getElementById('have_pan_yes')?.addEventListener('change', updateTCS);
        document.getElementById('have_pan_no')?.addEventListener('change', updateTCS);
    </script>


    <script>
        function rebuildProductsArray() {
            window.products = [];

            document.querySelectorAll("#cart-section .card-jw").forEach(card => {
                let id = parseInt(card.querySelector(".productid").innerText.trim());
                let priceText = card.querySelector(".price").childNodes[0].nodeValue.trim();
                let price = parseFloat(priceText.replace(/[₹,]/g, ""));

                window.products.push({
                    id: id,
                    price: price
                });
            });
        }

        // Toggle checkout section
        document.getElementById("checkout-btn").addEventListener("click", function() {

            refreshOrderSummary();
            refreshTotalsSimple();
            rebuildProductsArray(); // 🔥 THE MISSING PART
            updateTCS();

            document.getElementById("cart-section").style.display = "none";
            document.getElementById("checkout-section").style.display = "block";
            document.querySelector(".title").textContent = "Checkout";

            // Show tax & note sections
            document.querySelector('.taxpart').classList.remove('d-none');
            document.querySelector('.notepart').classList.remove('d-none');
            document.querySelector('.order-items').classList.remove('d-none');

            // Toggle buttons
            document.getElementById("checkout-btn").classList.add("d-none");
            document.getElementById("payment-btn").classList.remove("d-none");
            document.getElementById("backtocart-btn").classList.remove("d-none");

            // ✅ Force re-run TCS & PAN logic when returning to checkout
            if (typeof updateTCS === 'function') {
                updateTCS();
            }

            // ✅ Also re-trigger PAN radio visibility (if selected)
            const panYes = document.getElementById('have_pan_yes');
            const panNo = document.getElementById('have_pan_no');
            if (panYes && panYes.checked) panYes.dispatchEvent(new Event('change'));
            if (panNo && panNo.checked) panNo.dispatchEvent(new Event('change'));
        });



        document.getElementById("backtocart-btn").addEventListener("click", function() {
            document.getElementById("cart-section").style.display = "block";
            document.getElementById("checkout-section").style.display = "none";
            document.querySelector(".title").textContent = "Shopping Cart";

            //tax section
            document.querySelector('.taxpart').classList.add('d-none');
            document.querySelector('.tcspart').classList.add('d-none');
            document.querySelector('.notepart').classList.add('d-none');

            document.getElementById("checkout-btn").classList.remove("d-none");
            document.getElementById("payment-btn").classList.add("d-none");
            document.getElementById("backtocart-btn").classList.add("d-none");
            document.querySelector('.order-items').classList.add('d-none');
        });
    </script>



    <script>
        function removeFromCart(element) {
            let productId = parseInt(element.dataset.id);

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to remove this product from the cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove from browser sessionStorage
                    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
                    cart = cart.filter(id => id !== productId);
                    sessionStorage.setItem('cart', JSON.stringify(cart));

                    // Remove card from DOM
                    let card = element.closest('.card-jw');
                    if (card) card.remove();

                    // Update all cart badges
                    document.querySelectorAll('.cart-badge').forEach(badge => {
                        badge.textContent = cart.length;
                    });

                    // --- Remove from DB if user logged in ---
                    fetch("{{ route('cart.remove') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    }).catch(() => {
                        /* ignore any guest or DB issues */
                    });
                    // ----------------------------------------

                    Swal.fire({
                        title: 'Removed!',
                        text: 'Product removed from cart!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });


                    // Optionally trigger cart refresh
                    document.querySelectorAll('.cart-count').forEach(btn => btn.click());
                }
            });
        }
    </script>


    <script>
        document.getElementById('payment-btn').addEventListener('click', function(e) {
            e.preventDefault();

            const paymentBtn = this;
            paymentBtn.disabled = true; // 🚫 Disable button immediately
            paymentBtn.innerHTML = 'Processing...'; // Optional: show loading text

            const form = document.getElementById('checkoutForm');
            const panUpload = document.getElementById('pan_upload');
            const panNo = document.getElementById('pan_no');
            const citizenType = document.getElementById('shipping_citizen_type').value;
            const hasPanYes = document.getElementById('have_pan_yes');
            const hasPanNo = document.getElementById('have_pan_no');
            const panRadioGroup = document.getElementById('pan_radio_group');

            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');


            // ✅ Get full international phone number
            const shippingPhoneFull = itiShipping.getNumber(); // +919876543210

            // ✅ BILLING PHONE (WITH COUNTRY CODE)
            const billingPhoneFull = itiBilling.getNumber();


            /* 🇮🇳 INDIA-ONLY PHONE VALIDATION */

            // Shipping
            const shippingCountry = itiShipping.getSelectedCountryData();
            const shippingNational = shippingPhoneFull.replace(/\D/g, '').replace(/^91/, '');

            if (shippingCountry.iso2 === 'in') {
                if (!/^[6-9][0-9]{9}$/.test(shippingNational)) {
                    iziToast.info({
                        message: 'Invalid Shipping Mobile Numer.',
                        position: 'topRight',
                        timeout: 4000,
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });

                    paymentBtn.disabled = false;
                    paymentBtn.innerHTML = 'Continue to Payment';
                    return;
                }
            }

            // Billing
            const billingCountry = itiBilling.getSelectedCountryData();
            const billingNational = billingPhoneFull.replace(/\D/g, '').replace(/^91/, '');

            if (billingCountry.iso2 === 'in') {
                if (!/^[6-9][0-9]{9}$/.test(billingNational)) {
                    iziToast.info({
                        message: 'Invalid Billing Mobile Numer.',
                        position: 'topRight',
                        timeout: 4000,
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });

                    paymentBtn.disabled = false;
                    paymentBtn.innerHTML = 'Continue to Payment';
                    return;
                }
            }


            // // ❌ invalid number check (recommended)
            // if (!window.iti.isValidNumber()) {
            //     iziToast.info({
            //         message: 'Please enter a valid phone number.',
            //         position: 'topRight',
            //         timeout: 4000,
            //     });

            //     paymentBtn.disabled = false;
            //     paymentBtn.innerHTML = 'Continue to Payment';
            //     return;
            // }

            // ✅ Append to FormData (BEST way since you're using fetch)



            if (!selectedPayment) {
                iziToast.info({
                    message: 'Please select a payment option.',
                    position: 'topRight',
                    timeout: 4000,
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });

                paymentBtn.disabled = false;
                paymentBtn.innerHTML = 'Continue to Payment';
                return;
            }

            // 🔥 Get radio value (prebook or fullpayment)
            const paymentMethod = selectedPayment.value;

            // Optional: alert or log the value
            console.log("Selected Payment Method:", paymentMethod);




            if (citizenType === 'indian') {
                if (!hasPanYes.checked && !hasPanNo.checked) {
                    iziToast.info({
                        message: 'Please select whether you have a PAN.',
                        position: 'topRight',
                        timeout: 4000,
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff',
                        position: 'topRight',
                        iconColor: '#ffffff',
                        progressBarColor: '#ffffff'
                    });

                    // Highlight the radio group area
                    panRadioGroup.classList.add('border', 'border-danger', 'rounded', 'p-2');
                    paymentBtn.disabled = false;
                    paymentBtn.innerHTML = 'Continue to Payment';
                    return;
                } else {
                    // Remove red border if valid
                    panRadioGroup.classList.remove('border', 'border-danger', 'rounded', 'p-2');
                }
            }

            if (citizenType === 'indian') {
                if (hasPanYes.checked) {

                    const panValue = panNo.value.trim();
                    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
                    const isVerified = $('#pan_no').attr('data-verified');

                    if (!panValue) {
                        iziToast.info({
                            message: 'PAN number is required.',
                            position: 'topRight',
                            timeout: 4000,
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                        panNo.classList.add('is-invalid');
                        panNo.focus();
                        paymentBtn.disabled = false;
                        paymentBtn.innerHTML = 'Continue to Payment';
                        return;
                    }

                    if (!panRegex.test(panValue)) {
                        iziToast.info({
                            message: 'Invalid PAN format (ABCDE1234F).',
                            position: 'topRight',
                            timeout: 4000,
                            backgroundColor: '#212529',
                            titleColor: '#ffffff',
                            messageColor: '#ffffff',
                            position: 'topRight',
                            iconColor: '#ffffff',
                            progressBarColor: '#ffffff'
                        });
                        panNo.classList.add('is-invalid');
                        panNo.focus();
                        paymentBtn.disabled = false;
                        paymentBtn.innerHTML = 'Continue to Payment';
                        return;
                    }

                    // ✅ 🔥 MAIN CONDITION (YOUR REQUIREMENT)
                    if (isVerified !== 'true') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'PAN Not Verified',
                            text: 'Please verify your PAN before proceeding.',
                            confirmButtonColor: '#212529'
                        });

                        paymentBtn.disabled = false;
                        paymentBtn.innerHTML = 'Continue to Payment';
                        return;
                    }
                }
            }

            // ✅ Check if PAN file is uploaded
            if (!panUpload.value) {
                iziToast.info({
                    message: 'Please upload a valid document.',
                    position: 'topRight',
                    timeout: 4000,
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff',
                    position: 'topRight',
                    iconColor: '#ffffff',
                    progressBarColor: '#ffffff'
                });
                panUpload.classList.add('is-invalid');
                form.classList.add('was-validated');
                paymentBtn.disabled = false;
                paymentBtn.innerHTML = 'Continue to Payment';
                return;
            }

            //Delivery option validation

            const selectedDelivery = document.querySelector('input[name="delivery_option"]:checked');

            if (!selectedDelivery) {
                iziToast.info({
                    message: 'Please select a delivery option.',
                    position: 'topRight',
                    timeout: 4000,
                    backgroundColor: '#212529',
                    titleColor: '#ffffff',
                    messageColor: '#ffffff'
                });

                paymentBtn.disabled = false;
                paymentBtn.innerHTML = 'Continue to Payment';
                return;
            }

            const deliveryOption = selectedDelivery.value;
            let selectedStoreId = '';

            if (deliveryOption === 'store_pickup') {
                const selectedStore = document.querySelector('input[name="store_id"]:checked');

                if (!selectedStore) {
                    iziToast.info({
                        message: 'Please select a store for pickup.',
                        position: 'topRight',
                        timeout: 4000,
                        backgroundColor: '#212529',
                        titleColor: '#ffffff',
                        messageColor: '#ffffff'
                    });

                    paymentBtn.disabled = false;
                    paymentBtn.innerHTML = 'Continue to Payment';
                    return;
                }

                selectedStoreId = selectedStore.value;
            }

            // ✅ Validate form
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                paymentBtn.disabled = false;
                paymentBtn.innerHTML = 'Continue to Payment';
                return;
            }

            let formData = new FormData(form);
            formData.append('shipping_phone', shippingPhoneFull);
            formData.append('billing_phone', billingPhoneFull);
            // formData.append('payment_method', paymentMethod);
            formData.append('delivery_option', deliveryOption);
            formData.append('store_id', selectedStoreId);

            // Totals
            const subtotal = parseFloat({{ $subtotal }});
            const taxValue = parseFloat(document.getElementById('tax-value').innerText.replace(/[₹,]/g, '') || 0);
            const tcsValue = parseFloat(document.getElementById('tcs-value') ? document.getElementById('tcs-value')
                .innerText.replace(/[₹,]/g, '') : 0);
            const totalValue = parseFloat(document.getElementById('total-value').innerText.replace(/[₹,]/g, '') ||
                0);


            formData.append('payment_method', paymentMethod);
            formData.append('subtotal', subtotal);
            formData.append('tcs', tcsValue);
            formData.append('tax', taxValue);
            formData.append('total', totalValue);

            const formattedTotalValue = indian_number_format(totalValue);

            // Product IDs
            const productIds = [];
            document.querySelectorAll('#cart-section .productid').forEach(el => {
                productIds.push(el.textContent.trim());
            });
            formData.append('productid', JSON.stringify(productIds));

            Swal.fire({
                title: 'Confirm Payment',
                html: `<h5>Total Amount: <b>${formattedTotalValue}</b></h5>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Continue to Payment',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#212529',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (!result.isConfirmed) {
                    paymentBtn.disabled = false; // 🔄 Re-enable if cancelled
                    paymentBtn.innerHTML = 'Continue to Payment';
                    return;
                }

                Swal.fire({
                    title: 'Processing Payment...',
                    text: 'Please wait while we redirect you to CCAvenue...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch("{{ route('payment.process') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();

                        if (data.success) {
                            console.log("🔐 Preparing to redirect to CCAvenue:", data);

                            let ccForm = document.createElement('form');
                            ccForm.method = 'POST';
                            ccForm.action = data.ccavenue_url;

                            let encInput = document.createElement('input');
                            encInput.type = 'hidden';
                            encInput.name = 'encRequest';
                            encInput.value = data.encrypted_data;

                            let accessInput = document.createElement('input');
                            accessInput.type = 'hidden';
                            accessInput.name = 'access_code';
                            accessInput.value = data.access_code;

                            let orderIdInput = document.createElement('input');
                            orderIdInput.type = 'hidden';
                            orderIdInput.name = 'order_id';
                            orderIdInput.value = data.order_id || 'N/A';

                            ccForm.append(encInput, accessInput, orderIdInput);
                            document.body.appendChild(ccForm);

                            console.log("🚀 Redirecting to CCAvenue...");
                            ccForm.submit();
                        } else {
                            paymentBtn.disabled = false;
                            paymentBtn.innerHTML = 'Continue to Payment';
                            Swal.fire({
                                title: 'Error',
                                text: data.message || 'Failed to start payment process.',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Payment error:', error);
                        paymentBtn.disabled = false;
                        paymentBtn.innerHTML = 'Continue to Payment';
                        Swal.fire({
                            title: 'Error',
                            text: 'Unable to process payment. Please try again.',
                            icon: 'error'
                        });
                    });
            });
        });


        function indian_number_format(number) {
            number = number.toString().replace(/[^0-9.]/g, '');
            let x = number.split('.');
            let intPart = x[0];
            let decimalPart = x.length > 1 ? '.' + x[1] : '.00';

            let lastThree = intPart.substring(intPart.length - 3);
            let otherNumbers = intPart.substring(0, intPart.length - 3);
            if (otherNumbers !== '') lastThree = ',' + lastThree;

            let formatted = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
            return '₹' + formatted + decimalPart;
        }
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check query parameter
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('auto_checkout') === '1') {
                const checkoutBtn = document.getElementById('checkout-btn');
                if (checkoutBtn) {
                    checkoutBtn.click(); // automatically trigger checkout logic
                }
            }
        });
    </script>

    <script>
        document.getElementById('custlogin').addEventListener('click', function() {
            window.location.href = "{{ route('custlogin-page') }}";
        });
    </script>

    <script>
        window.addEventListener('pageshow', function(event) {
            // Detect if user came back from CCAvenue or used browser back
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                console.log("🔙 Page restored — rechecking TCS, PAN visibility, and radio states");

                // ✅ Re-trigger citizen type logic
                const citizenType = document.getElementById('shipping_citizen_type');
                if (citizenType && citizenType.value) {
                    citizenType.dispatchEvent(new Event('change'));
                }

                // ✅ Re-trigger PAN Yes/No radio change events if one is selected
                const panYes = document.getElementById('have_pan_yes');
                const panNo = document.getElementById('have_pan_no');
                if (panYes && panYes.checked) {
                    panYes.dispatchEvent(new Event('change'));
                } else if (panNo && panNo.checked) {
                    panNo.dispatchEvent(new Event('change'));
                }

                // ✅ Recheck PAN upload section visibility
                const tcsValue = parseFloat(document.getElementById('tcs-value').innerText.replace(/[₹,]/g, '') ||
                    0);
                const panSection = document.getElementById('pan-section');
                if (tcsValue > 0 && panSection) {
                    panSection.style.display = 'block';
                }
            }
        });
    </script>

    <script>
        function cleanNumber(val) {
            return parseFloat(val.replace(/[₹,]/g, "")) || 0;
        }

        function indian_number_format(num) {
            return "₹" + num.toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // ✅ GLOBAL: FINAL TOTAL CALCULATION
        function updatePaymentTotal() {
            const subtotal = cleanNumber(document.getElementById("subtotal-value").innerText);
            const tcs = cleanNumber(document.getElementById("tcs-value").innerText);
            const totalEl = document.getElementById("total-value");

            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');

            let finalTotal = subtotal + tcs; // default full payment

            if (selectedMethod) {
                if (selectedMethod.value === "prebook") {
                    finalTotal = (subtotal * 0.10) + tcs; // 10% + TCS
                }
            }

            totalEl.innerText = indian_number_format(finalTotal);
        }


        document.addEventListener("DOMContentLoaded", function() {

            // PAYMENT METHOD SELECTED
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener("change", updatePaymentTotal);
            });

            // CITIZEN TYPE CHANGED
            document.getElementById("shipping_citizen_type")?.addEventListener("change", updateTCS);

            // PAN YES/NO CHANGED
            document.getElementById("have_pan_yes")?.addEventListener("change", updateTCS);
            document.getElementById("have_pan_no")?.addEventListener("change", updateTCS);

            // FIRST LOAD
            setTimeout(() => {
                updateTCS();
                updatePaymentTotal();
            }, 400);
        });
    </script>





</body>

</html>
