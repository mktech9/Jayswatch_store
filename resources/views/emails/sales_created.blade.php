<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Sales Notification</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f5f5; font-family: Arial, sans-serif;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f5f5f5">
        <tr>
            <td align="center" style="padding: 30px 10px;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600"
                    bgcolor="#ffffff"
                    style="border-radius:8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding:30px 20px; border-bottom:1px solid #eee;">
                            <img src="{{ $actual_url . '/admin_assets/logo.png' }}"
                                alt="Jay's Watch Store Logo"
                                width="150"
                                height="auto"
                                style="display:block; border:0; margin-bottom:10px;" />
                            <div style="font-size:20px; font-weight:bold; color:#333;">
                                New Sale Created Notification
                            </div>
                        </td>
                    </tr>

                    <!-- Customer + Sale Details -->
                    <tr>
                        <td style="padding: 20px 30px; color:#444; font-size:16px; line-height:24px;">
                            <table width="100%" style="background:#f9f9f9; border-radius:6px; margin:20px 0;"
                                cellpadding="8">

                                <tr>
                                    <td colspan="2"
                                        style="font-size:17px; font-weight:bold; color:#222;">
                                        Customer Details:
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <b>Name:</b> {{ $sale->customer_name ?? '-' }}<br />
                                        <b>Mobile:</b> {{ $sale->mobile_no ?? '-' }}<br />
                                        <b>Email:</b> {{ $sale->email ?? '-' }}<br />
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"
                                        style="font-size:17px; padding-top:20px; font-weight:bold; color:#222;">
                                        Sale Details:
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Location:</b></td>
                                    <td>{{ $sale->location_name ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><b>Bill Date:</b></td>
                                    <td>
                                        {{ !empty($sale->sale_date) ? \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') : '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Invoice No:</b></td>
                                    <td>#{{ $sale->invoice_no ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><b>Final Total:</b></td>
                                    <td>₹ {{ indian_number_format($sale->final_total ?? 0, 2) }}</td>
                                </tr>

                                <tr>
                                    <td><b>Status:</b></td>
                                    <td>{{ ucfirst($sale->bill_status ?? '-') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Login Button -->
                    <tr>
                        <td style="padding: 20px 30px; color:#444; font-size:16px; line-height:24px;">
                            <div style="text-align:center; margin-top:30px;">
                                <a href="https://jayswatchstore.com/login"
                                    style="background:#000; color:#fff; text-decoration:none; padding:12px 20px; border-radius:5px; font-weight:bold; display:inline-block;">
                                    Login to Dashboard
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="text-align:center; font-size:13px; color:#888; padding: 20px;">
                            Jay's Watch Store
                            <a href="https://www.jayswatchstore.com"
                                style="color:#888; text-decoration:none;">
                                www.jayswatchstore.com
                            </a><br />
                            Contact:
                            <a href="mailto:support@jayswatchstore.com"
                                style="color:#888; text-decoration:none;">
                                support@jayswatchstore.com
                            </a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
