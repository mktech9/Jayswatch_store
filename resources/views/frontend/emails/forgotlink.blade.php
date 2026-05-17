<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password – Jay's Watch Store</title>
</head>
<body style="margin:0; padding:0; background-color:#f7f7f7; font-family: Arial, sans-serif;">
<table width="100%" bgcolor="#f7f7f7" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding:30px 10px;">
            <table width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0"
                   style="border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1); overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td align="center" style="padding:25px; border-bottom:1px solid #eee;">
                        <img src="https://jayswatchstore.com/front/img/logo.png"
                             width="150" alt="Jay's Watch Store" style="display:block;margin-bottom:10px;">
                        <div style="font-size:22px;font-weight:bold;color:#333;">
                            Reset Your Password
                        </div>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:30px; color:#444; font-size:16px; line-height:24px;">
                        <p>Hi <strong>{{ $user->full_name ?? 'Customer' }}</strong>,</p>

                        <p>
                            We received a request to reset your password for your
                            <strong>Jay’s Watch Store</strong> account.
                        </p>

                        <p>
                            Click the button below to set a new password.
                            This link is valid for <strong>30 minutes</strong>.
                        </p>

                        <!-- Button -->
                        <div style="text-align:center; margin:30px 0;">
                            <a href="{{ $resetUrl }}"
                               style="background:#000;color:#fff;text-decoration:none;
                                      padding:14px 30px;border-radius:6px;
                                      font-weight:bold;display:inline-block;">
                                Reset Password
                            </a>
                        </div>

                        <p style="font-size:14px;color:#666;">
                            If you did not request a password reset, please ignore this email.
                            Your password will remain unchanged.
                        </p>
                    </td>
                </tr>

                <!-- Divider -->
                <tr>
                    <td style="padding:0 30px;">
                        <hr style="border:0;border-top:1px solid #eee;margin:20px 0;">
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="text-align:center;font-size:13px;color:#888;
                               padding:20px;background:#fafafa;">
                        Jay's Watch Store<br>
                        <a href="https://www.jayswatchstore.com"
                           style="color:#888;text-decoration:none;">
                            www.jayswatchstore.com
                        </a><br>
                        Need help?
                        <a href="mailto:tech@jayswatchstore.com"
                           style="color:#888;text-decoration:none;">
                            tech@jayswatchstore.com
                        </a>
                        <div style="margin-top:10px;">
                            © {{ date('Y') }} Jay's Watch Store. All Rights Reserved.
                        </div>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
