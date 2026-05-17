<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Delivered</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding: 30px;">

    <table align="center" width="650" cellpadding="0" cellspacing="0"
        style="background: #ffffff; border-radius: 6px; padding: 0; overflow:hidden;">

        <!-- HEADER -->
        <tr>
            <td align="center" style="padding: 30px 20px 20px;">
                <img src="{{ $actual_url . '/admin_assets/logo.png' }}" width="120" alt="Jay's Watch Store">
                <h2 style="margin: 15px 0 5px; font-size: 22px; color:#222;">Your Order Has Been Delivered!</h2>
            </td>
        </tr>

        <!-- MESSAGE SECTION -->
        <tr>
            <td style="padding: 0 40px 20px;">
                <p style="font-size: 15px; color:#444;">
                    Dear <strong>{{ $first_name }} {{ $last_name }}</strong>,
                </p>

                <p style="font-size: 15px; color:#444; line-height: 1.6;">
                    We are happy to inform you that your order
                    <strong>#{{ $order_id }}</strong> has been successfully delivered.
                </p>

                <p style="font-size: 15px; color:#444; line-height: 1.6;">
                    We hope you enjoy your purchase! Thank you for choosing Jay’s Watch Store.
                </p>
            </td>
        </tr>

        <tr>
            <td style="padding:20px 40px;">


                <table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #eee; border-radius:6px;">

                    <tr style="background:#fafafa; font-weight:bold;">
                        <th align="left">Product</th>
                        <th align="center">Qty</th>
                        <th align="right">Price</th>
                    </tr>

                    @foreach ($items as $item)
                        @php
                            $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? '');
                            $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->product_name ?? '');
                        @endphp

                        <tr>
                            <td style="display:flex; align-items:center;">
                                <img src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $item->product_image }}"
                                    width="50" style="margin-right:10px; border-radius:4px;">

                                {{ $item->product_name }}
                            </td>

                            <td align="center">
                                {{ $item->quantity }}
                            </td>

                            <td align="right">
                                ₹{{ number_format($item->price, 2) }}
                            </td>
                        </tr>
                    @endforeach

                </table>

            </td>
        </tr>

        <!-- ORDER DETAILS BOX -->
        <tr>
            <td style="padding: 10px 40px;">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background:#fafafa; border:1px solid #eee; border-radius: 6px; padding: 15px;">

                    <tr>
                        <td style="padding: 8px 0; color:#555; font-size:14px;">
                            <strong>Order ID:</strong> {{ $order_id }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 8px 0; color:#555; font-size:14px;">
                            <strong>Delivered Date:</strong> {{ $delivered_date }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 8px 0; color:#555; font-size:14px;">
                            <strong>Delivery Address:</strong><br>
                            {{ $first_name }} {{ $last_name }}<br>
                            {{ $shipping_address }}, {{ $shipping_landmark }}<br>
                            {{ $shipping_city }}, {{ $shipping_state }} - {{ $shipping_zip }},
                            {{ $shipping_country }}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <!-- LOGIN BUTTON -->
        <tr>
            <td align="center" style="padding: 25px 20px 10px;">
                <a href="https://jayswatchstore.com"
                    style="background:#000; color:#fff; text-decoration:none;
                          padding:12px 28px; border-radius:6px; display:inline-block;
                          font-size:15px;">
                    Visit Our Store
                </a>
            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td align="center" style="padding: 20px 20px 30px;">
                <p style="font-size: 13px; color:#999;">
                    Thank you for shopping with Jay's Watch Store!<br>
                    For support contact:
                    <a href="mailto:support@jayswatchstore.com" style="color:#0b73f0;">
                        support@jayswatchstore.com
                    </a>
                </p>
            </td>
        </tr>

    </table>

</body>

</html>
