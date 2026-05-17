<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | Jay's Watch</title>
    @include('frontend.partials.header_link')
  <style>
  body {
  background: #f6f8fa;
  font-family: Arial, sans-serif;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0;
}

.reset-container {
  background: #ffffff;
  padding: 40px 35px;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  border-radius: 12px;
}

.reset-container h2 {
  margin-bottom: 25px;
  color: #212529;
  font-weight: 600;
  text-align: center;
}

.form-group {
  margin-bottom: 20px;
  position: relative;
}

label {
  margin-bottom: 6px;
  font-weight: 600;
  font-size: 14px;
  color: #495057;
}

input[type="password"],
input[type="text"] {
  width: 100%;
  padding: 12px 45px 12px 12px;
  border: 1px solid #ced4da;
  border-radius: 8px;
  font-size: 15px;
  transition: all 0.2s ease;
}

input:focus {
  border-color: #212529;
  outline: none;
  box-shadow: 0 0 0 3px rgba(33,37,41,0.1);
}

.toggle-password {
  position: absolute;
  right: 12px;
  top: 38px;
  cursor: pointer;
  font-size: 18px;
  color: #6c757d;
}

.toggle-password:hover {
  color: #212529;
}

.btn {
  width: 100%;
  background: #212529;
  color: #fff;
  border: none;
  padding: 12px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.2s ease;
  cursor: pointer;
}

.btn:hover {
  background-color: #000;
}
  </style>
</head>
<body>
<div class="reset-container">
  <h2>Reset Your Password</h2>

  <form id="resetForm">
    @csrf

    <div class="form-group position-relative">
      <label for="password">New Password</label>
      <input type="password" name="password" id="password" required>

      <span class="toggle-password position-absolute top-50 end-0 me-3"
            data-target="password"
            style="cursor:pointer;">
        <i class="bx bx-hide"></i>
      </span>
    </div>

    <div class="form-group position-relative">
      <label for="password_confirmation">Confirm Password</label>
      <input type="password" name="password_confirmation" id="password_confirmation" required>

      <span class="toggle-password position-absolute top-50 end-0  me-3"
            data-target="password_confirmation"
            style="cursor:pointer;">
        <i class="bx bx-hide"></i>
      </span>
    </div>

    <button type="submit" class="btn" id="submitBtn">Update Password</button>
  </form>
</div>

  <!-- Scripts -->
   @include('frontend.partials.footer_link')
<script>
document.querySelectorAll(".toggle-password").forEach(function(toggle) {
    toggle.addEventListener("click", function () {
        const input = document.getElementById(this.getAttribute("data-target"));
        const icon = this.querySelector("i");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("bx-hide", "bx-show");
        } else {
            input.type = "password";
            icon.classList.replace("bx-show", "bx-hide");
        }
    });
});
</script>
 <script>
$(document).ready(function () {

  $('#resetForm').on('submit', function (e) {
    e.preventDefault();

    let newPwd     = $('#password').val().trim();
    let confirmPwd = $('#password_confirmation').val().trim();
    let $btn       = $('#submitBtn');

    // Get email if available (optional safety)
    let email = "{{ $cust_data->email ?? '' }}".toLowerCase();

    // 1️⃣ Required check
    if (newPwd === '' || confirmPwd === '') {
      iziToast.info({
        message: 'Please enter both password fields.',
        position: 'topRight'
      });
      return;
    }

    // 2️⃣ Password match
    if (newPwd !== confirmPwd) {
      iziToast.info({
        message: 'Passwords do not match!',
        position: 'topRight'
      });
      return;
    }

    // 3️⃣ Length validation
    if (newPwd.length < 8 || newPwd.length > 20) {
      iziToast.info({
        message: 'Password must be 8–20 characters long.',
        position: 'topRight'
      });
      return;
    }

    // 4️⃣ Uppercase letter
    if (!/[A-Z]/.test(newPwd)) {
      iziToast.info({
        message: 'Password must contain at least one uppercase letter.',
        position: 'topRight'
      });
      return;
    }

    // 5️⃣ Lowercase letter
    if (!/[a-z]/.test(newPwd)) {
      iziToast.info({
        message: 'Password must contain at least one lowercase letter.',
        position: 'topRight'
      });
      return;
    }

    // 6️⃣ Number
    if (!/[0-9]/.test(newPwd)) {
      iziToast.info({
        message: 'Password must contain at least one digit.',
        position: 'topRight'
      });
      return;
    }

    // 7️⃣ Special character
    if (!/[@#$%^&*()_+\-=\!?]/.test(newPwd)) {
      iziToast.info({
        message: 'Password must contain at least one special character.',
        position: 'topRight'
      });
      return;
    }

    // 8️⃣ No spaces
    if (/\s/.test(newPwd)) {
      iziToast.info({
        message: 'Password cannot contain spaces.',
        position: 'topRight'
      });
      return;
    }

    // 9️⃣ Cannot contain "password"
    if (newPwd.toLowerCase().includes('password')) {
      iziToast.info({
        message: 'Password cannot contain the word "password".',
        position: 'topRight'
      });
      return;
    }

    // 🔟 Cannot be same as email
    if (email && newPwd.toLowerCase() === email) {
      iziToast.info({
        message: 'Password cannot be same as your email.',
        position: 'topRight'
      });
      return;
    }

    // 1️⃣1️⃣ No sequential characters
    const sequences = [
      "123456", "234567", "345678", "456789",
      "abcdef", "bcdefg", "cdefgh", "defghi",
      "ABCDEF", "BCDEFG", "CDEFGH", "DEFGHI"
    ];

    for (let seq of sequences) {
      if (newPwd.includes(seq)) {
        iziToast.info({
          message: 'Password cannot contain sequential characters.',
          position: 'topRight'
        });
        return;
      }
    }

    // 1️⃣2️⃣ No repeated characters
    if (/([a-zA-Z0-9])\1{3,}/.test(newPwd)) {
      iziToast.info({
        message: 'Password cannot contain repeated characters.',
        position: 'topRight'
      });
      return;
    }

    // ✅ Passed all validations
    $btn.prop('disabled', true).text('Updating...');

    $.ajax({
      url: "{{ route('cust-update-password') }}",
      type: 'POST',
      data: {
        _token: "{{ csrf_token() }}",
        password: newPwd,
        password_confirmation: confirmPwd
      },
      success: function () {
        iziToast.success({
          title: 'Success',
          message: 'Password updated successfully!',
          position: 'topRight'
        });

        $('#resetForm')[0].reset();

        setTimeout(() => {
          window.location.href = "{{ route('custlogin-page') }}";
        }, 2000);
      },
      error: function () {
        iziToast.error({
          title: 'Error',
          message: 'Failed to update password. Please try again.',
          position: 'topRight'
        });
      },
      complete: function () {
        $btn.prop('disabled', false).text('Update Password');
      }
    });

  });

});
</script>

</body>
</html>
