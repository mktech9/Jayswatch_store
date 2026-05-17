<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css" />

<!-- intl-tel-input JS -->

<style>
    .form-control {
        border-radius: 0px !important;
    }

    .form-select {
        border-radius: 0px !important;
    }

    .iti {
        width: 100%;
    }

    #checkout-section {
        display: block;
        border: 1px solid var(--line);
        /*border-radius: 10px;*/
    }

    .Back-to-cart {
        border: 1px solid #e2e2e2;
    }

    /* ===== Jay's Watch Store Checkout (scoped) ===== */
    .jw-checkout {
        --ink: #111;
        --muted: #6b7280;
        --line: #e5e7eb;
        --gold: #b58549;
        --bg: #f8f9fb;
    }

    .jw-checkout .wrap {
        max-width: 1280px;
        margin: 60px auto;
        padding: 0 16px;
    }

    .jw-checkout .grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 28px;
    }

    @media (max-width: 992px) {
        .jw-checkout .grid {
            grid-template-columns: 1fr;
        }
    }

    .jw-checkout .card {
        border: 1px solid var(--line);
        border-radius: 10px;
        background: #fff;
    }

    .jw-checkout .card-body {
        padding: 20px !important;
    }

    .jw-checkout h2 {
        font-size: 28px;
        font-weight: 400;
        margin: 0 0 18px;
    }

    /* Left form */
    .jw-checkout .form-label {
        font-weight: 400;
        font-size: 14px;
        color: var(--ink);
    }

    .jw-checkout .form-control {
        background: #f6f7f9;
        border: 1px solid #e6e8ee;
        box-shadow: none;
    }

    .jw-checkout .form-select {
        background-color: #f6f7f9 !important;
        border: 1px solid #e6e8ee;
        box-shadow: none;
    }

    .jw-checkout .hr {
        height: 1px;
        background: var(--line);
        margin: 16px 0;
    }

    .jw-checkout .btn-darky {
        background: #0f1420;
        border: 0;
        height: 48px;
        font-weight: 400;
        color: #fff;
    }

    .jw-checkout .btn-darky:hover {
        filter: brightness(1.05);
    }

    /* Right summary */
    .jw-checkout .summary h4 {
        font-size: 20px;
        margin: 2px 0 14px;
        font-weight: 400;
    }

    .jw-checkout .row-s {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0;
    }

    .jw-checkout .muted {
        color: var(--muted);
    }

    .jw-checkout .divider {
        height: 1px;
        background: var(--line);
        margin: 14px 0;
    }

    .jw-checkout .total {
        font-size: 18px;
        font-weight: 700;
    }

    .jw-checkout .thumb {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border: 1px solid var(--line);
        border-radius: 6px;
    }

    .jw-checkout .brand {
        font-size: 12px;
        color: var(--muted);
    }

    .jw-checkout .name {
        font-size: 14px;
    }

    .jw-checkout .qty {
        font-size: 12px;
        color: var(--muted);
    }

    .jw-checkout .price-total {
        color: var(--gold);
    }

    /* TCS Note */
    .jw-checkout .note {
        font-size: 13px;
        color: #555;
        background: #f9f9f9;
        border-left: 3px solid #ccc;
        padding: 10px 12px;
        border-radius: 4px;
        line-height: 1.5;
        margin-top: 6px;
    }

    .jw-checkout .note a {
        color: #000;
        text-decoration: underline;
    }

    .jw-cart .payment {
        display: block;
        width: 100%;
        height: 46px;
        border: 0;
        /*border-radius: 8px;*/
        background: #212529;
        color: #fff;
        font-weight: 400;
        cursor: pointer;
    }


    /* Grey Container */
    .checkout-box {
        background: #f0f0f0;
        border: 1px solid #dcdcdc;
        /*border-radius: 10px;*/
    }

    /* Custom Radio Buttons (Checkbox Look) */
    .custom-radio {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 12px 15px;
        /*border-radius: 10px;*/
        border: 1px solid #ccc;
        cursor: pointer;
        margin-bottom: 12px;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .custom-radio:hover {
        background: #e8e8e8;
    }

    .custom-radio input {
        display: none;
        /* Hide default radio */
    }

    .radio-box {
        width: 22px;
        height: 22px;
        border: 2px solid #555;
        /* border-radius: 5px; */
        /* Checkbox look */
        margin-right: 12px;
        position: relative;
        transition: 0.3s ease;
    }

    /* Tick on checked */
    .custom-radio input:checked+.radio-box {
        background: #212529;
        border-color: #212529;
    }

    .custom-radio input:checked+.radio-box::after {
        content: "✔";
        color: #fff;
        font-size: 14px;
        position: absolute;
        top: -1px;
        left: 4px;
    }
</style>
<div id="checkout-section" style="display: none">
    <div class="jw-checkout">
        <div class="checkout-box p-4">

            <h4 class="fw-bold mb-3">Select Payment Option</h4>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <!-- Pre-Book -->
                    <label class="custom-radio w-100">
                        <input type="radio" name="payment_method" value="prebook">
                        <span class="radio-box"></span>
                        Advanced Payment
                    </label>
                </div>

                <div class="col-md-6 mb-3">
                    <!-- Full Payment -->
                    <label class="custom-radio w-100">
                        <input type="radio" name="payment_method" value="fullpayment">
                        <span class="radio-box"></span>
                        Full Payment
                    </label>
                </div>

                <!-- Collapsible Terms for Prebook -->
                <div id="prebook-terms" class="mt-2" style="display:none;">
                    <div style="
        border:2px solid #212529;

        padding:20px;

    ">
                        <h5 style="color:#212529; font-weight:700; margin-bottom:15px;">
                            Terms & Conditions for Advance Booking
                        </h5>

                        <div style="font-size:14px; line-height:1.6; color:#212529;">

                            <p style="margin-bottom:8px;">
                                <span style="color:#212529; font-weight:bold;">•</span>
                                The selected watch will be kept on hold for <strong>48 hours</strong> from the time of
                                advance payment.
                            </p>

                            <p style="margin-bottom:8px;">
                                <span style="color:#212529; font-weight:bold;">•</span>
                                To complete the remaining payment or for any queries, please contact us at
                                <strong>tech@jayswatchstore.com</strong> or call us at <strong>+91 8591187684</strong>.
                            </p>

                            <p style="margin-bottom:0;">
                                <span style="color:#212529; font-weight:bold;">•</span>
                                If there is no response from the customer or the remaining payment is not completed
                                within
                                <strong>48 hours</strong>, the advance amount will be refunded and the watch will be
                                released back for sale.
                            </p>

                        </div>
                    </div>
                </div>




            </div>

        </div>

        <div class="wrap">

            <div class="grid">
                <!-- LEFT: Shipping form -->
                <div class="card">
                    <div class="card-body">
                        <h2>Shipping Information</h2>

                        <!-- Shipping Fields -->
                        <form id="checkoutForm" class="needs-validation" novalidate>
                            <!-- Shipping Fields -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="shipping_email">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" id="shipping_email" name="shipping_email"
                                        placeholder="Enter your email address" readonly required />
                                    <div class="invalid-feedback">
                                        Please enter a valid email.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="shipping_phone">
                                        Phone Number <span class="text-danger">*</span>
                                    </label>

                                    <input type="tel" class="form-control" id="shipping_phone" name="shipping_phone"
                                        placeholder="Enter your mobile number" required />

                                    <div class="invalid-feedback">Phone number is required.</div>
                                </div>

                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="shipping_first_name">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_first_name"
                                        name="shipping_first_name" placeholder="Enter your first name" required />
                                    <div class="invalid-feedback">First name is required.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="shipping_last_name">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_last_name"
                                        name="shipping_last_name" placeholder="Enter your last name" required />
                                    <div class="invalid-feedback">Last name is required.</div>
                                </div>
                            </div>


                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label class="form-label" for="shipping_citizen_type">
                                        Citizen Type <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="shipping_citizen_type" name="shipping_citizen_type"
                                        required>
                                        <option value="" disabled selected>Select your Citizen Type</option>
                                        <option value="indian">Indian Citizen</option>
                                        <option value="non-indian">Non-Indian Citizen</option>
                                    </select>
                                    <div class="invalid-feedback">Please select citizen type.</div>
                                </div>


                                <div class="col-md-4" id="pan_radio_group" style="display: none;">
                                    <label class="form-label d-block">Do you have a PAN? <span
                                            class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="have_pan"
                                            id="have_pan_yes" value="yes" />
                                        <label class="form-check-label" for="have_pan_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="have_pan"
                                            id="have_pan_no" value="no" />
                                        <label class="form-check-label" for="have_pan_no">No</label>
                                    </div>
                                </div>

                                <div class="col-md-4" id="pan_field" style="display: none;">
                                    <label class="form-label" for="pan_no">
                                        Enter PAN No. <span class="text-danger">*</span>
                                    </label>

                                    <div class="d-flex gap-2">
                                        <input type="text" class="form-control" id="pan_no" name="pan_no" />

                                        <button type="button" class="btn btn-dark" id="verifyPanBtn"
                                            style="white-space: nowrap;">
                                            Verify
                                        </button>
                                    </div>

                                    <div class="invalid-feedback">Enter Valid PAN Card Number.</div>
                                </div>

                                <div class="col-md-4" id="pan-upload-div">
                                    <label class="form-label" for="pan_upload">
                                        Upload any valid documents <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="form-control" id="pan_upload" name="pan_upload"
                                        accept=".pdf,.jpg,.png" required />
                                    <div class="invalid-feedback">This field is required.</div>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">



                                <label class="form-label" for="delivery_option">
                                    Select Delivery Option <span class="text-danger">*</span>
                                </label>

                                <div class="col-md-6">
                                    <label class="custom-radio w-100">
                                        <input type="radio" name="delivery_option" id="home_delivery"
                                            value="home_delivery" checked>

                                        <span class="radio-box"></span>

                                        Home Delivery
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <label class="custom-radio w-100">
                                        <input type="radio" name="delivery_option" id="store_pickup"
                                            value="store_pickup">

                                        <span class="radio-box"></span>

                                        Store Pick Up
                                    </label>
                                </div>

                            </div>

                            <div class="row g-3 mt-3" id="storePickupBox" style="display: none;">

                                <div class="col-md-12">

                                    <div class="border p-4">


                                        <label class="form-label" for="select_store">
                                            Select Store For Pickup <span class="text-danger">*</span>
                                        </label>

                                        <div class="row">

                                            @foreach ($stores as $store)
                                                <div class="col-md-6 mb-3">

                                                    <label class="custom-radio w-100 h-100 align-items-start">

                                                        <input type="radio" name="store_id"
                                                            id="store_{{ $store->location_id }}"
                                                            value="{{ $store->bl_id }}">

                                                        <span class="radio-box mt-1"></span>

                                                        <div>
                                                            <div class="fw-bold">
                                                                {{ $store->name }}
                                                            </div>

                                                            <div class="text-muted small mt-1">
                                                                {{ $store->address }}
                                                            </div>
                                                        </div>

                                                    </label>

                                                </div>
                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <hr />

                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label class="form-label" for="shipping_street">Street Address <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_street"
                                        name="shipping_street" placeholder="House No., Building, Street name"
                                        required />
                                    <div class="invalid-feedback">
                                        Street address is required.
                                    </div>
                                </div>


                                <div class="col-12">
                                    <label class="form-label" for="shipping_landmark">Landmark <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_landmark"
                                        name="shipping_landmark" placeholder="Nearby landmark" required />
                                    <div class="invalid-feedback">
                                        Landmark is required.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <select class="form-select" id="shipping_country" name="shipping_country"
                                        required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select class="form-select" id="shipping_state" name="shipping_state" required
                                        disabled>
                                        <option value="">Select State</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select class="form-select" id="shipping_city" name="shipping_city" required
                                        disabled>
                                        <option value="">Select City</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="shipping_zip">Pin Code <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="shipping_zip" name="shipping_zip"
                                        placeholder="Enter your PIN code" required />
                                    <div class="invalid-feedback">Pin code is required.</div>
                                </div>

                            </div>

                            <hr />

                            <!-- Billing Checkbox -->
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sameAsBilling"
                                            name="same_as_billing" />
                                        <label class="form-check-label" for="sameAsBilling">
                                            Shipping Address is same as billing address
                                        </label>
                                    </div>
                                </div>
                            </div>





                            <!-- Billing Fields -->
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="billing_first_name">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="billing_first_name"
                                        name="billing_first_name" placeholder="Enter your first name" required />
                                    <div class="invalid-feedback">First name is required.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="billing_last_name">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="billing_last_name"
                                        name="billing_last_name" placeholder="Enter your last name" required />
                                    <div class="invalid-feedback">Last name is required.</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="billing_phone">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="billing_phone"
                                        name="billing_phone" placeholder="Enter your mobile number" required />
                                    <div class="invalid-feedback">Phone number is required.</div>
                                </div>




                                <div class="col-12">
                                    <label class="form-label" for="billing_street">Street Address <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="billing_street"
                                        name="billing_street" placeholder="House No., Building, Street name"
                                        required />
                                    <div class="invalid-feedback">
                                        Street address is required.
                                    </div>
                                </div>


                                <div class="col-12">
                                    <label class="form-label" for="billing_landmark">Landmark <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="billing_landmark"
                                        name="billing_landmark" placeholder="Nearby landmark" required />
                                    <div class="invalid-feedback">
                                        Landmark is required.
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <select class="form-select" id="billing_country" name="billing_country" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select class="form-select" id="billing_state" name="billing_state" required
                                        disabled>
                                        <option value="">Select State</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select class="form-select" id="billing_city" name="billing_city" required
                                        disabled>
                                        <option value="">Select City</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="billing_zip">Pin Code <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="billing_zip" name="billing_zip"
                                        placeholder="Enter your Pin" required />
                                    <div class="invalid-feedback">Pin code is required.</div>
                                </div>

                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-100 d-none" id="checkout-submit">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>


<script>
    let itiShipping;
    let itiBilling;
    let selectedCountry = null;
    let selectedState = null;
    let selectedCity = null;

    function syncShippingToBilling() {
        // ✅ Define it inside the function so it's always available
        const billingFieldIds = [
            'billing_first_name', 'billing_last_name', 'billing_phone',
            'billing_street', 'billing_landmark', 'billing_zip'
        ];

        billingFieldIds.forEach(id => {
            const shippingId = id.replace('billing_', 'shipping_');
            const shippingEl = document.getElementById(shippingId);
            const billingEl = document.getElementById(id);
            if (shippingEl && billingEl) billingEl.value = shippingEl.value;
        });

        const shippingCountry = $('#shipping_country').val();
        const shippingState = $('#shipping_state').val();
        const shippingCity = $('#shipping_city').val();

        if (shippingCountry) {
            $('#billing_country').val(shippingCountry);

            $.get("{{ route('get.states', ':id') }}".replace(':id', shippingCountry), function(data) {
                let options = '<option value="">Select State</option>';
                $.each(data, function(key, state) {
                    options += `<option value="${state.id}">${state.name}</option>`;
                });
                $('#billing_state').html(options).prop('disabled', false);

                if (shippingState) {
                    $('#billing_state').val(shippingState);

                    $.get("{{ route('get.cities', ':id') }}".replace(':id', shippingState), function(data) {
                        let options = '<option value="">Select City</option>';
                        $.each(data, function(key, city) {
                            options += `<option value="${city.id}">${city.name}</option>`;
                        });
                        $('#billing_city').html(options).prop('disabled', false);

                        if (shippingCity) {
                            $('#billing_city').val(shippingCity);
                        }
                    });
                }
            });
        }
    }

    $(document).on('change', '#shipping_country', function() {

        let countryId = $(this).val();

        $('#shipping_state').html('<option>Select State</option>').prop('disabled', true);
        $('#shipping_city').html('<option>Select City</option>').prop('disabled', true);

        if (!countryId) return;

        $.get("{{ route('get.states', ':id') }}".replace(':id', countryId), function(data) {

            $('#shipping_state').prop('disabled', false);

            $.each(data, function(key, state) {
                $('#shipping_state').append('<option value="' + state.id + '">' + state.name +
                    '</option>');
            });

            // ✅ AUTO SET STATE AFTER LOAD
            if (selectedState) {
                $('#shipping_state').val(selectedState).trigger('change');
            }
        });
    });

    $(document).on('change', '#shipping_state', function() {

        let stateId = $(this).val();

        $('#shipping_city').html('<option>Select City</option>').prop('disabled', true);

        if (!stateId) return;

        $.get("{{ route('get.cities', ':id') }}".replace(':id', stateId), function(data) {

            $('#shipping_city').prop('disabled', false);

            $.each(data, function(key, city) {
                $('#shipping_city').append('<option value="' + city.id + '">' + city.name +
                    '</option>');
            });

            // ✅ AUTO SET CITY AFTER LOAD
            if (selectedCity) {
                $('#shipping_city').val(selectedCity);
            }
        });
    });
    $(document).on('change', '#billing_country', function() {

        let countryId = $(this).val();

        $('#billing_state').html('<option>Select State</option>').prop('disabled', true);
        $('#billing_city').html('<option>Select City</option>').prop('disabled', true);

        if (!countryId) return;

        $.get("{{ route('get.states', ':id') }}".replace(':id', countryId), function(data) {

            $('#billing_state').prop('disabled', false);

            $.each(data, function(key, state) {
                $('#billing_state').append('<option value="' + state.id + '">' + state.name +
                    '</option>');
            });

            // 🔥 ADD THIS (MISSING)
            if (selectedState) {
                $('#billing_state').val(selectedState).trigger('change');
            }
        });
    });
    $(document).on('change', '#billing_state', function() {

        let stateId = $(this).val();

        $('#billing_city').html('<option>Select City</option>').prop('disabled', true);

        if (!stateId) return;

        $.get("{{ route('get.cities', ':id') }}".replace(':id', stateId), function(data) {

            $('#billing_city').prop('disabled', false);

            $.each(data, function(key, city) {
                $('#billing_city').append('<option value="' + city.id + '">' + city.name +
                    '</option>');
            });

            // 🔥 ADD THIS (MISSING)
            if (selectedCity) {
                $('#billing_city').val(selectedCity);
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {

        const shippingInput = document.querySelector("#shipping_phone");
        const billingInput = document.querySelector("#billing_phone");

        // =============================
        // INIT intl-tel-input
        // =============================
        itiShipping = window.intlTelInput(shippingInput, {
            initialCountry: "in",
            separateDialCode: true,
            preferredCountries: ["in", "us", "gb", "ae"],
            autoPlaceholder: "polite",
            nationalMode: false,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
        });

        itiBilling = window.intlTelInput(billingInput, {
            initialCountry: "in",
            separateDialCode: true,
            preferredCountries: ["in", "us", "gb", "ae"],
            autoPlaceholder: "polite",
            nationalMode: false,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
        });

        // =============================
        // APPLY INPUT RULES
        // =============================
        function applyPhoneRules(inputEl, itiInstance) {

            inputEl.addEventListener("input", function() {
                let value = inputEl.value.replace(/\D/g, "");

                const countryData = itiInstance.getSelectedCountryData();
                const maxLength = countryData.iso2 === "in" ? 10 : 15;

                if (value.length > maxLength) {
                    value = value.slice(0, maxLength);
                }

                inputEl.value = value;
            });

            // Allow digits only
            inputEl.addEventListener("keypress", function(e) {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
            });

            // Re-validate when country changes
            inputEl.addEventListener("countrychange", function() {
                inputEl.value = inputEl.value.replace(/\D/g, "");
            });
        }

        applyPhoneRules(shippingInput, itiShipping);
        applyPhoneRules(billingInput, itiBilling);

    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // If coming from prebook button
        if (sessionStorage.getItem('isPrebook') === '1') {

            let prebookRadio = document.querySelector('input[name="payment_method"][value="prebook"]');
            if (prebookRadio) {
                prebookRadio.checked = true; // auto select
                prebookRadio.dispatchEvent(new Event('change')); // trigger UI updates
            }

            // Clear flag after selecting
            sessionStorage.removeItem('isPrebook');
        }
    });
</script>


<script>
    // Replace your sameAsBilling section with this:

    window.addEventListener('DOMContentLoaded', function() {
        const sameAsBilling = document.getElementById("sameAsBilling");

        // ✅ Only needed here now for clearBillingFields
        const billingFieldIds = [
            'billing_first_name', 'billing_last_name', 'billing_phone',
            'billing_street', 'billing_landmark', 'billing_zip'
        ];

        sameAsBilling.checked = true;
        toggleBillingSection();

        sameAsBilling.addEventListener("change", function() {
            if (this.checked) {
                syncShippingToBilling();
            } else {
                clearBillingFields();
            }
            toggleBillingSection();
        });

        function toggleBillingSection() {
            const allBillingFields = document.querySelectorAll(
                '#billing_first_name, #billing_last_name, #billing_phone, #billing_street, #billing_landmark, #billing_city, #billing_state, #billing_zip, #billing_country'
            );
            allBillingFields.forEach(field => {
                field.closest('.col-md-6, .col-12').style.display = sameAsBilling.checked ? 'none' :
                    'block';
            });
        }



        function clearBillingFields() {
            billingFieldIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            $('#billing_country').val('');
            $('#billing_state').html('<option value="">Select State</option>').prop('disabled', true);
            $('#billing_city').html('<option value="">Select City</option>').prop('disabled', true);
        }

        // ✅ Live sync: listen to both input AND change events on shipping fields
        const shippingTextFields = document.querySelectorAll(
            '#shipping_first_name, #shipping_last_name, #shipping_phone, #shipping_street, #shipping_landmark, #shipping_zip'
        );
        shippingTextFields.forEach(field => {
            field.addEventListener('input', function() {
                if (sameAsBilling.checked) {
                    const billingId = field.id.replace('shipping_', 'billing_');
                    const billingEl = document.getElementById(billingId);
                    if (billingEl) billingEl.value = field.value;
                }
            });
        });

        // ✅ Live sync dropdowns separately using 'change'
        ['#shipping_country', '#shipping_state', '#shipping_city'].forEach(selector => {
            $(document).on('change', selector, function() {
                if (sameAsBilling.checked) {
                    syncShippingToBilling();
                }
            });
        });
    });
    // Bootstrap validation
    (function() {
        "use strict";
        const forms = document.querySelectorAll(".needs-validation");
        Array.from(forms).forEach(function(form) {
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add("was-validated");
                },
                false
            );
        });
    })();
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const citizenSelect = document.getElementById("shipping_citizen_type");
        const panRadioGroup = document.getElementById("pan_radio_group");
        const panField = document.getElementById("pan_field");
        const panInput = document.getElementById("pan_no");

        // Citizen type change
        citizenSelect.addEventListener("change", function() {
            if (this.value === "indian") {
                panRadioGroup.style.display = "block";
            } else {
                panRadioGroup.style.display = "none";
                panField.style.display = "none";
                panInput.removeAttribute("required");
                panInput.value = "";
                $("input[name='have_pan']").prop("checked", false);
            }
        });

        // PAN radio change
        document.querySelectorAll("input[name='have_pan']").forEach((radio) => {
            radio.addEventListener("change", function() {
                if (this.value === "yes") {
                    panField.style.display = "block";
                    panInput.setAttribute("required", "required");
                } else {
                    panField.style.display = "none";
                    panInput.removeAttribute("required");
                    panInput.value = "";
                }
            });
        });

        // Convert PAN to uppercase
        panInput.addEventListener("input", function() {
            this.value = this.value.toUpperCase();
        });

        // Validate PAN format
        panInput.addEventListener("blur", function() {
            const panValue = this.value.trim();
            const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            if (panValue && !panRegex.test(panValue)) {
                this.classList.add("is-invalid");
            } else {
                this.classList.remove("is-invalid");
            }
        });
    });
</script>


<script>
    $(document).ready(function() {

        // ðŸ”¥ AUTO-PREFILL EMAIL + TRIGGER BLUR TO FETCH DATA (Delay fix)
        @if (!empty($user_email))
            $('#shipping_email').val('{{ $user_email }}');

            setTimeout(function() {
                $('#shipping_email').trigger('blur');
            }, 300);
        @endif


        // ðŸ”¥ CHECK EMAIL ON BLUR
        $('#shipping_email').on('blur', function() {

            let email = $(this).val().trim();
            if (email === '') return;

            $.ajax({
                url: '{{ route('check.email') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function(response) {
                    console.log("Response:", response);

                    // --------------------------------------------------------
                    // ðŸ”¥ SHOW POPUP IF EMAIL BELONGS TO A REGISTERED USER
                    // --------------------------------------------------------
                    if (response.exists === true) {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Account Already Registered',
                            html: `This email is already registered. Please sign in.`,
                            showCancelButton: true,
                            confirmButtonText: 'Login',
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    "{{ url('custlogin-page') }}?tab=login&email=" +
                                    encodeURIComponent(email);
                            }
                        });

                        return; // stop further prefill
                    }


                    // --------------------------------------------------------
                    // ðŸŸ¢ AUTO PREFILL USER DETAILS
                    // --------------------------------------------------------
                    if (response.user) {

                        // Personal info
                        $('#shipping_first_name').val(response.user.first_name);
                        $('#shipping_last_name').val(response.user.last_name);
                        const shippingIti = window.intlTelInputGlobals.getInstance(
                            document.querySelector("#shipping_phone")
                        );

                        $('#billing_first_name').val(response.user.first_name);
                        $('#billing_last_name').val(response.user.last_name);
                        const billingIti = window.intlTelInputGlobals.getInstance(
                            document.querySelector("#billing_phone")
                        );
                        shippingIti.setNumber(response.user.phone);
                        billingIti.setNumber(response.user.phone);
                        // Address info
                        if (response.address) {
                            selectedCountry = response.address.country_id;
                            selectedState = response.address.state_id;
                            selectedCity = response.address.city_id;

                            $('#shipping_street').val(response.address.u_address1);
                            $('#billing_street').val(response.address.u_address1);

                            $('#shipping_landmark').val(response.address.u_address2);
                            $('#billing_landmark').val(response.address.u_address2);

                            $('#shipping_zip').val(response.address.u_pincode);
                            $('#billing_zip').val(response.address.u_pincode);

                            // ✅ Load shipping country → state → city chain, then sync billing at the END
                            $('#shipping_country').val(selectedCountry);

                            $.get("{{ route('get.states', ':id') }}".replace(':id',
                                selectedCountry), function(stateData) {

                                let stateOptions =
                                    '<option value="">Select State</option>';
                                $.each(stateData, function(key, state) {
                                    stateOptions +=
                                        `<option value="${state.id}">${state.name}</option>`;
                                });
                                $('#shipping_state').html(stateOptions).prop(
                                    'disabled', false);
                                $('#shipping_state').val(selectedState);

                                $.get("{{ route('get.cities', ':id') }}".replace(
                                    ':id', selectedState), function(
                                    cityData) {

                                    let cityOptions =
                                        '<option value="">Select City</option>';
                                    $.each(cityData, function(key, city) {
                                        cityOptions +=
                                            `<option value="${city.id}">${city.name}</option>`;
                                    });
                                    $('#shipping_city').html(cityOptions)
                                        .prop('disabled', false);
                                    $('#shipping_city').val(selectedCity);

                                    // ✅ NOW sync to billing — shipping dropdowns are fully populated
                                    if ($('#sameAsBilling').is(
                                            ':checked')) {
                                        syncShippingToBilling();
                                    }
                                });
                            });
                        }
                    }
                }
            });
        });

    });



    window.addEventListener('pageshow', function(event) {
        // Detect if user navigated back from CCAvenue
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            console.log("User navigated back from CCAvenue");

            // Restore TCS and PAN
            let tcsValue = localStorage.getItem('tcs_value');
            let panValue = localStorage.getItem('pan_value');

            if (tcsValue) $('#tcs').val(tcsValue);
            if (panValue) $('#pan_number').val(panValue);
            $('#pan-section').show(); // If it's hidden

            // Optional: prevent auto logout redirect
            history.replaceState(null, '', window.location.href);
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('input[name="payment_method"]').on('change', function() {
            if ($(this).val() === 'prebook') {
                $("#prebook-terms").slideDown();
            } else {
                $("#prebook-terms").slideUp();
            }
        });
    });


    $('#verifyPanBtn').on('click', function() {

        let pan = $('#pan_no').val().trim();

        if (pan === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing PAN',
                text: 'Please enter PAN number first',
            });
            return;
        }

        // PAN format validation
        let panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
        if (!panRegex.test(pan)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid PAN',
                text: 'Enter valid PAN format (ABCDE1234F)',
            });
            return;
        }

        // Loading
        Swal.fire({
            title: 'Verifying...',
            text: 'Please wait while we verify PAN',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('verify.pan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                pan: pan
            },
            success: function(res) {

                console.log(res);

                if (res.success === true || res.data) {

                    $('#pan_json').remove();

                    $('<input>').attr({
                        type: 'hidden',
                        id: 'pan_json',
                        name: 'pan_json',
                        value: JSON.stringify(res)
                    }).appendTo('#checkoutForm');

                    // ✅ Update button UI
                    $('#verifyPanBtn')
                        .text('Verified')
                        .removeClass('btn-dark')
                        .addClass('btn-success')
                        .prop('disabled', true);

                    // ✅ Disable PAN input
                    $('#pan_no').prop('disabled', true);

                    // Optional: mark as verified (hidden flag)
                    $('#pan_no').attr('data-verified', 'true');

                    Swal.fire({
                        icon: 'success',
                        title: 'PAN Verified ✅',
                        html: `
                <b>Name:</b> ${res.data?.full_name || 'N/A'}<br>
                <b>PAN:</b> ${pan}
            `,
                        confirmButtonColor: '#212529'
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Failed',
                        text: res.message || 'Invalid PAN details',
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid PAN',
                    text: 'Unable to verify PAN. Try again.',
                });
            }
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const homeDelivery = document.getElementById('home_delivery');
        const storePickup = document.getElementById('store_pickup');
        const storePickupBox = document.getElementById('storePickupBox');
        const storeRadios = document.querySelectorAll('input[name="store_id"]');

        function toggleStoreBox() {
            if (storePickup.checked) {
                storePickupBox.style.display = 'block';
            } else {
                storePickupBox.style.display = 'none';
                storeRadios.forEach(radio => radio.checked = false);
            }
        }

        homeDelivery.addEventListener('change', toggleStoreBox);
        storePickup.addEventListener('change', toggleStoreBox);

        toggleStoreBox();
    });
</script>
