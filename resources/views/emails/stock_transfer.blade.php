<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Stock Transfer Notification</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f5f5; font-family: Arial, sans-serif;">

    <table width="100%" bgcolor="#f5f5f5" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 30px 10px;">

                <table width="600" bgcolor="#ffffff" style="border-radius:8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

                    <!-- ✅ Header -->
                    <tr>
                        <td align="center" style="padding:30px 20px; border-bottom:1px solid #eee;">
                            <img src="{{ $actual_url . '/admin_assets/logo.png' }}" width="150"
                                style="display:block; margin-bottom:10px;" />

                            <div style="font-size:20px; font-weight:bold; color:#333;">
                                Stock Transfer Notification
                            </div>
                        </td>
                    </tr>

                    <!-- ✅ Body -->
                    <tr>
                        <td style="padding: 20px 30px; color:#444; font-size:16px; line-height:24px;">

                            <table width="100%" style="background:#f9f9f9; border-radius:6px; margin:20px 0;"
                                cellpadding="8">

                                <!-- ✅ Location From -->
                                <tr>
                                    <td colspan="2" style="font-size:17px; font-weight:bold; color:#222;">
                                        Location (From):
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        {{ $fromLocation->name ?? 'Origin location not available' }}
                                    </td>
                                </tr>

                                <!-- ✅ Location To -->
                                <tr>
                                    <td colspan="2"
                                        style="padding-top: 20px; font-size:17px; font-weight:bold; color:#222;">
                                        Location (To):
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        {{ $toLocation->name ?? 'Destination location not available' }}
                                    </td>
                                </tr>

                                <!-- ✅ Reference -->
                                <tr>
                                    <td style="font-weight:bold;">Reference No:</td>
                                    <td>#{{ $stock->reference_no }}</td>
                                </tr>

                                <!-- ✅ Date -->
                                <tr>
                                    <td style="font-weight:bold;">Date:</td>
                                    <td>{{ \Carbon\Carbon::parse($stock->transfer_date)->format('d/m/Y') }}</td>
                                </tr>

                                <!-- ✅ Status -->
                                <tr>
                                    <td style="font-weight:bold;">Status:</td>
                                    <td>
                                        @if ($stock->stock_status == 0)
                                            Pending
                                        @elseif($stock->stock_status == 1)
                                            In Transit
                                        @else
                                            Completed
                                        @endif
                                    </td>
                                </tr>

                            </table>

                            <!-- ✅ Button -->
                            <div style="text-align:center; margin-top:30px;">
                                <a href="{{ url('/stock-transfer') }}"
                                    style="background:#000; color:#fff; text-decoration:none;
                                      padding:12px 20px; border-radius:5px;
                                      font-weight:bold; display:inline-block;">
                                    View Stock Transfer
                                </a>
                            </div>

                        </td>
                    </tr>

                    <!-- ✅ Footer -->
                    <tr>
                        <td style="text-align:center; font-size:13px; color:#888; padding: 20px;">
                            Jay's Watch Store
                            <a href="https://www.jayswatchstore.com" style="color:#888; text-decoration:none;">
                                www.jayswatchstore.com
                            </a>
                            <br />
                            Contact:
                            <a href="mailto:support@jayswatchstore.com" style="color:#888; text-decoration:none;">
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
