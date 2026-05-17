<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Successfully Placed - Jay's Watch Store</title>
</head>

<body style="margin:0; padding:0; background-color:#f7f7f7; font-family: Arial, sans-serif;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f7f7f7">
        <tr>
            <td align="center" style="padding: 30px 10px;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600"
                    bgcolor="#ffffff"
                    style="border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1); overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding:25px; border-bottom:1px solid #eee;">
                            <img src="{{ $actual_url . '/admin_assets/logo.png' }}" alt="Jay's Watch Store"
                                width="150" style="display:block; margin-bottom:10px;">
                            <div style="font-size:22px; font-weight:bold; color:#333;">Order Successfully Placed!</div>
                        </td>
                    </tr>

                    <!-- Confirmation Text -->
                    <tr>
                        <td style="padding: 30px; color:#444; font-size:16px; line-height:24px;">
                            <p>Hi <strong>{{ $data['user_name'] ?? 'Valued Customer' }}</strong>,</p>
                            <p>
                                Thank you for shopping with <strong>Jay’s Watch Store</strong> 🎉
                                Your order has been placed successfully and is now being processed.
                            </p>
                            <p>We'll notify you once your items have been shipped.</p>
                        </td>
                    </tr>

                    <!-- Order Summary -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <table width="100%" cellpadding="8" style="background:#f9f9f9; border-radius:8px;">
                                <tr>
                                    <td colspan="2" style="font-size:17px; font-weight:bold; color:#222;">Order
                                        Summary</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>Order ID:</b></td>
                                    <td>#{{ $data['order_id'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Order Date:</b></td>
                                    <td>{{ $data['order_date'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Payment Method:</b></td>
                                    <td>{{ $data['payment_mode'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Total Amount:</b></td>
                                    <td><strong>₹{{ number_format($data['subtotal'] + $data['tcs'], 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td><b>Status:</b></td>
                                    <td>
                                        @if (($data['order_status'] ?? 0) == 1)
                                            <span
                                                style="background:#28a745; color:#fff; padding:3px 10px; border-radius:4px;">Confirmed</span>
                                        @else
                                            <span
                                                style="background:#ffc107; color:#fff; padding:3px 10px; border-radius:4px;">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Product Details -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <div style="font-size:17px; font-weight:bold; color:#222; margin-bottom:10px;">Items in Your
                                Order</div>
                            <table width="100%" cellpadding="8" style="border:1px solid #eee; border-radius:6px;">
                                <tr style="background:#fafafa; font-weight:bold; text-align:left;">
                                    <th style="padding:8px;">Product</th>
                                    <th style="padding:8px;">Qty</th>
                                    <th style="padding:8px;">Price</th>
                                </tr>

                                @foreach ($data['items'] as $item)
                                    @php

                                        $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? '');
                                        $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->product_name ?? '');

                                    @endphp
                                    <tr>
                                        <td style="padding:8px; display:flex; align-items:center;">
                                            <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $item->product_image }}"
                                                alt="Product" width="50"
                                                style="border-radius:4px; margin-right:8px;">
                                            {{ $item->product_name ?? 'N/A' }}
                                        </td>
                                        <td style="padding:8px;">{{ $item->quantity ?? '1' }}</td>
                                        <td style="padding:8px;">₹{{ number_format($item->price ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach

                            </table>
                        </td>
                    </tr>

                    @if ($data['payment_method'] == 'prebook')
                        <tr>
                            <td style="padding: 0 30px 30px 30px;">
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="border:2px solid #000; background:#f5f5f5;">
                                    <tr>
                                        <td style="padding:20px;">

                                            <h2 style="color:#000; font-weight:700; margin-top:0; margin-bottom:15px;">
                                                Terms & Conditions for Advance Booking
                                            </h2>

                                            <div style="font-size:14px; line-height:1.6; color:#000; text-align:left;">

                                                <p style="margin-bottom:8px;">
                                                    The selected watch will be kept on hold for
                                                    <strong>48 hours</strong> from the time of advance payment.
                                                </p>

                                                <p style="margin-bottom:8px;">
                                                    To complete the remaining payment or for any queries, please contact
                                                    us at
                                                    <strong>tech@jayswatchstore.com</strong> or call us at
                                                    <strong>+91 8591187684</strong>.
                                                </p>

                                                <p style="margin-bottom:0;">
                                                    If there is no response from the customer or the remaining payment
                                                    is not completed within
                                                    <strong>48 hours</strong>, the advance amount will be refunded and
                                                    the watch will be released back for sale.
                                                </p>

                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endif


                    <!-- Delivery Details -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <table width="100%" cellpadding="8" style="background:#f9f9f9; border-radius:8px;">
                                <tr>
                                    <td colspan="2" style="font-size:17px; font-weight:bold; color:#222;">Delivery
                                        Details</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>Shipping To:</b></td>
                                    <td>
                                        {{ $data['user_name'] ?? '-' }}<br>
                                        {{ $data['shipping_address'] ?? '-' }}<br>
                                        {{ $data['shipping_city'] ?? '' }}, {{ $data['shipping_state'] ?? '' }} -
                                        {{ $data['shipping_zip'] ?? '' }}<br>
                                        {{ $data['shipping_country'] ?? '' }}<br>
                                        Mobile: {{ $data['shipping_phone'] ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Expected Delivery:</b></td>
                                    <td>{{ \Carbon\Carbon::now()->addDays(5)->format('d F Y') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Call To Action -->
                    <!--<tr>-->
                    <!--  <td align="center" style="padding: 20px 30px;">-->
                    <!--    <a href="https://jayswatchstore.com/order-tracking"-->
                    <!--       style="background:#000; color:#fff; text-decoration:none; padding:14px 28px; border-radius:5px; font-weight:bold; display:inline-block;">-->
                    <!--       Track Your Order-->
                    <!--    </a>-->
                    <!--  </td>-->
                    <!--</tr>-->

                    <!-- Divider -->
                    <tr>
                        <td style="padding: 0 30px;">
                            <hr style="border:0; border-top:1px solid #eee; margin:20px 0;">
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="text-align:center; font-size:13px; color:#888; padding: 20px; background:#fafafa;">
                            Jay's Watch Store
                            <a href="https://www.jayswatchstore.com"
                                style="color:#888; text-decoration:none;">www.jayswatchstore.com</a><br />
                            Need Help? <a href="mailto:tech@jayswatchstore.com"
                                style="color:#888; text-decoration:none;">tech@jayswatchstore.com</a><br />
                            <div style="margin-top:10px;"> {{ date('Y') }} Jay's Watch Store. All Rights Reserved.
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
