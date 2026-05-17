<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>New Product Submission</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f5f5; font-family: Arial, sans-serif;">

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f5f5f5">
  <tr>
    <td align="center" style="padding: 30px 10px;">
      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" bgcolor="#ffffff" style="border-radius:8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
          <td align="center" style="padding:30px 20px; border-bottom:1px solid #eee;">
            <img src="{{ $actual_url . '/admin_assets/logo.png' }}" alt="Jay's Watch Store Logo" width="150" height="auto" style="display:block; border:0; margin-bottom:10px;" />
            <div style="font-size:20px; font-weight:bold; color:#333;">New Product Submitted for Approval</div>
          </td>
        </tr>
        <tr>
          <td style="padding: 20px 30px; color:#444; font-size:16px; line-height:24px;">
            <p>Hello Admin,</p>
            <p>A new product has been submitted by a Store Manager and is pending your approval.</p>
            <table role="presentation" border="0" cellpadding="10" cellspacing="0" width="100%" bgcolor="#f9f9f9" style="border-radius:5px; margin: 20px 0;">
              <tr>
                <td style="font-weight:bold;">Product Name:</td>
                <td>{{ $product->name }}</td>
              </tr>
              <tr>
                <td style="font-weight:bold;">SKU:</td>
                <td>{{ $product->sku }}</td>
              </tr>
              <tr>
                <td style="font-weight:bold;">Submitted By:</td>
                <td>
{{ $product->submitted_by }}
                </td>
              </tr>
            </table>
            <div style="text-align:center; margin-top:30px;">
              <a href="https://www.jayswatchstore.com/login" style="background:#000; color:#fff; text-decoration:none; padding:12px 20px; border-radius:5px; font-weight:bold; display:inline-block;">Review Now</a>
            </div>
            <p>If this submission was made in error, please reach out to the submitting store or support.</p>
          </td>
        </tr>
        <tr>
          <td style="text-align:center; font-size:13px; color:#888; padding: 20px;">
            Jay's Watch Store 路 <a href="https://www.jayswatchstore.com" style="color:#888; text-decoration:none;">www.jayswatchstore.com</a><br />
            Contact: support@jayswatchstore.com
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

</body>
</html>
