<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Password Reset Request</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f5f5; font-family: Arial, sans-serif;">

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f5f5f5">
  <tr>
    <td align="center" style="padding:30px 10px;">

      <table role="presentation" border="0" cellpadding="0" cellspacing="0"
             width="600" bgcolor="#ffffff"
             style="border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);">

        <!-- Header -->
        <tr>
          <td align="center" style="padding:30px 20px; border-bottom:1px solid #eee;">
                       <img src="https://jayswatchstore.com/front/img/logo.png" alt="Jay's Watch Store Logo" width="150" height="auto" style="display:block; border:0; margin-bottom:10px;" />

            <div style="font-size:20px; font-weight:bold; color:#333;">
                Password Reset Request
            </div>
          </td>
        </tr>

        <!-- Body -->
        <tr>
          <td style="padding:20px 30px; color:#444; font-size:16px; line-height:24px;">

            <p>Hello,</p>

            <p>
                We received a request to reset your password for your
                <strong>
                    {{ $type === 'super_admin' ? 'Super Admin' : 'Staff' }}
                </strong>
                account.
            </p>

            <p>
                Click the button below to reset your password securely:
            </p>

            <!-- Button -->
            <div style="text-align:center; margin:30px 0;">
              <a href="{{ $link }}"
                 style="background:#000; color:#fff; text-decoration:none;
                        padding:12px 22px; border-radius:5px;
                        font-weight:bold; display:inline-block;">
                    Reset Password
              </a>
            </div>

            <p>
                This link is valid for a limited time. If you did not request
                this password reset, you can safely ignore this email.
            </p>

            <p>
                Thanks,<br>
                <strong>Jay's Watch Store</strong>
            </p>

          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="text-align:center; font-size:13px; color:#888; padding: 20px;">
            Jay's Watch Store <a href="https://www.jayswatchstore.com" style="color:#888; text-decoration:none;">www.jayswatchstore.com</a><br />
            Contact: support@jayswatchstore.com
          </td>
        </tr>

      </table>

    </td>
  </tr>
</table>

</body>
</html>
