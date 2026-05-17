<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Password Changed Successfully</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:30px; margin:0;">

  <table align="center" width="650" cellpadding="0" cellspacing="0"
         style="background:#ffffff; border-radius:8px; overflow:hidden;">

    <!-- HEADER -->
    <tr>
      <td align="center" style="padding:28px 20px 10px;">
        <img src="https://jayswatchstore.com/front/img/logo.png" width="120" alt="Jay's Watch Store" style="display:block;">
        <h2 style="margin:14px 0 0; font-size:20px; color:#222;">
          Password Changed Successfully
        </h2>
      </td>
    </tr>

    <!-- CONTENT -->
    <tr>
      <td style="padding: 20px 40px 10px;">
        <p style="margin:0 0 12px; color:#444; font-size:15px;">
          Hi <strong>{{ $name }}</strong>,
        </p>

        <p style="margin:0 0 14px; color:#444; font-size:15px; line-height:1.6;">
          This is a confirmation that the password for your Jay's Watch Store account
          (<strong>{{ $email }}</strong>) has been updated successfully.
        </p>

        <p style="margin:0 0 14px; color:#444; font-size:15px; line-height:1.6;">
          If you didn’t make this change, please reset your password immediately or contact our support team.
        </p>
      </td>
    </tr>

    <!-- ACCOUNT BOX -->
    <tr>
      <td style="padding: 0 40px 20px;">
        <table width="100%" cellpadding="0" cellspacing="0"
               style="background:#fafafa; border:1px solid #eee; border-radius:6px; padding:12px;">
          <tr>
            <td style="font-size:13px; color:#555;">
              <strong>Account Email:</strong> {{ $email }}<br>
              <strong>Changed At:</strong> {{ $changed_at }}
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- BUTTON -->
    <tr>
      <td align="center" style="padding:15px 20px 10px;">
        <a href="https://jayswatchstore.com"
           style="background:#000; color:#fff; text-decoration:none;
                  padding:12px 28px; border-radius:6px; display:inline-block;
                  font-size:15px;">
          Login to Our Store
        </a>
      </td>
    </tr>

    <!-- FOOTER -->
    <tr>
      <td align="center" style="padding: 20px 20px 30px;">
        <p style="margin:0; font-size:13px; color:#999;">
          For help, contact
          <a href="mailto:support@jayswatchstore.com" style="color:#0b73f0; text-decoration:none;">
            support@jayswatchstore.com
          </a>
        </p>
      </td>
    </tr>

  </table>

</body>
</html>
