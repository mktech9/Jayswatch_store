@php
use Carbon\Carbon;

$defaultImg = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';

$profileImg = $defaultImg;

if (!empty($user->profile_pic)) {

    // Build physical path for file_exists()
    $profilePath = public_path('assets/admin_assets/profile/' . $user->profile_pic);

    if (file_exists($profilePath)) {

        // Build actual URL using $actual_url (NOT asset())
        $profileImg = $actual_url . '/admin_assets/profile/' . $user->profile_pic;
    }
}
@endphp





<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient" data-menu-styles="dark">

@include('partials.header_link')



<style>
    /* Profile Card Styles */
    .profile-card {
        text-align: center;
        padding: 30px 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .profile-img-wrapper {
        position: relative;
        width: 130px;
        height: 130px;
        margin: 0 auto 20px;
        display: inline-block;
    }

    .profile-user-img {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #f3f6f8;
        background-color: #e9ecef;
    }


    .img-upload-trigger {
        position: absolute;
        bottom: 5px;
        right: 0px;
        background: #3c4858;
        color: #fff !important;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        border: 3px solid #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        z-index: 20;
        text-decoration: none;
    }

    .img-upload-trigger:hover {
        background: #000;
        transform: scale(1.1);
        color: #fff;
    }

    .img-upload-trigger i {
        font-size: 18px;
    }

    #profileImageInput {
        display: none;
    }

    /* Section Headers */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #000000;
        font-size: 1.2rem;
    }

    /* Form Styles */
    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.4rem;
    }

    .form-control,
    .form-select {
        padding: 0.6rem 1rem;
        border-radius: 8px;
        border-color: #e5e7eb;
    }

    /* --- FIXED: Seamless Input Groups (No internal borders) --- */

    /* 1. The Container for the group */
    .input-group-merged {
        display: flex;
        align-items: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .input-group-merged:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .input-group-merged .input-group-text {
        background-color: #fff;
        border: none;
        color: #6b7280;
        padding-right: 0;
    }

    .input-group-merged .form-control {
        border: none;
        box-shadow: none;
        background: transparent;
    }

    .input-group-merged .btn {
        border: none;
        background: transparent;
        color: #6b7280;
        z-index: 5;
    }

    .input-group-merged .btn:hover {
        color: #374151;
    }

    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

</style>

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">My Profile</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">

             

                    <div class="row">
                        <div class="col-xl-4 col-lg-5 mb-4">
                            <div class="card custom-card profile-card">
                                <div class="card-body">
                                    <div class="profile-img-wrapper">
                                        <img src="{{ $profileImg }}" alt="user" class="profile-user-img" id="imgPreview">

                                        <label for="profileImageInput" class="img-upload-trigger">
                                            <i class='bx bx-camera'></i>
                                        </label>

                                        <input type="file" name="image" id="profileImageInput" accept="image/*">
                                    </div>

                                    <h5 class="fw-bold text-dark mb-1"> @if($type == 'super_admin')
                                        {{ $user->sp_name }}
                                        @else
                                        {{ $user->first_name }} {{ $user->last_name }}
                                        @endif</h5>
                                    <p class="text-muted mb-4"> @if($type == 'super_admin')
                                        {{ $user->sp_email }}
                                        @else
                                        {{ $user->email_id }}
                                        @endif</p>
                                    @if($type == 'staff')
                                    <div class="text-start mt-4">
                                        <h6 class="fw-bold mb-3 text-uppercase fs-12 text-muted">Social Profiles</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Facebook</label>
                                            <div class="input-group-merged">
                                                <span class="input-group-text">
                                                    <i class='bx bxl-facebook text-primary fs-5 ms-1'></i>
                                                </span>
                                                <input type="text" class="form-control" name="facebook" placeholder="Link" value="{{ $user->facebook_link }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Twitter</label>
                                            <div class="input-group-merged">
                                                <span class="input-group-text">
                                                    <i class='bx bxl-twitter text-info fs-5 ms-1'></i>
                                                </span>
                                                <input type="text" class="form-control" name="twitter" placeholder="Link" value="{{ $user->twitter_link }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>

                            <div class="card custom-card mt-4">
                                <div class="card-body">
                                    <div class="section-title mb-4">
                                        <i class='bx bx-lock-alt'></i> Change Password
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <div class="input-group-merged">
                                            <input type="password" class="form-control" name="current_password" id="current_pass">
                                            <button type="button" class="btn" onclick="togglePassword('current_pass', this)">
                                                <i class='bx bx-show fs-5'></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <div class="input-group-merged">
                                            <input type="password" class="form-control" name="new_password" id="new_pass">
                                            <button type="button" class="btn" onclick="togglePassword('new_pass', this)">
                                                <i class='bx bx-show fs-5'></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group-merged">
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_pass">
                                            <button type="button" class="btn" onclick="togglePassword('confirm_pass', this)">
                                                <i class='bx bx-show fs-5'></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 pb-3 text-center">
                                        <button type="submit" class="btn btn-primary px-4" id="savePasswordBtn">
                                            Save Password
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-7">
                            <div class="card custom-card">
                                <div class="card-body p-4">

                                    <div class="section-title">
                                        Personal Information
                                    </div>
                                    <div class="row gx-4 gy-3 mb-5">
                                        @if($type == 'staff')
                                        <div class="col-md-2">
                                            <label class="form-label">Prefix</label>
                                            <select class="form-select select2" name="prefix">
                                                <option value="Mr" {{ ($user->prefix ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                                <option value="Mrs" {{ ($user->prefix ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                                <option value="Miss" {{ ($user->prefix ?? '') == 'Miss' ? 'selected' : '' }}>Mrs</option>
                                            </select>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="email" value="{{ $type == 'super_admin' ? ($user->sp_email ?? '') : ($user->email_id ?? '') }}">
                                        </div>
                                        @if($type == 'staff')
                                        <div class="col-md-6">
                                            <label class="form-label">Language</label>
                                            <select class="form-select select2" name="language">
                                                <option value="English" {{ ($user->language ?? '') == 'English' ? 'selected' : '' }}>English</option>
                                                <option value="Hindi" {{ ($user->language ?? '') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                                <option value="Gujarati" {{ ($user->language ?? '') == 'Gujarati' ? 'selected' : '' }}>Gujarati</option>
                                            </select>
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label">Date of Birth</label>
                                            <div class="input-group-merged">
                                                <span class="input-group-text ps-3"><i class='bx bx-calendar'></i></span>
                                                <input type="text" class="form-control" name="dob" id="dob" placeholder="Select Date" value="{{ $user->dob ? Carbon::parse($user->dob)->format('d-m-Y') : '' }}"> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Gender</label>

                                            <div class="d-flex gap-4 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="gMale" value="Male" {{ ($user->gender ?? '') == 'Male' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gMale">Male</label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="gFemale" value="Female" {{ ($user->gender ?? '') == 'Female' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gFemale">Female</label>
                                                </div>
                                            </div>
                                        </div>

                                        @endif
                                    </div>
                                    @if($type == 'staff')
                                    <div class="section-title">
                                        Contact & Address
                                    </div>
                                    <div class="row gx-4 gy-3 mb-5">
                                        <div class="col-md-6">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" value="{{ $user->contact_number }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Alternate Number</label>
                                            <input type="text" class="form-control" name="alt_mobile" value="{{ $user->alt_contact_number }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Current Address</label>
                                            <textarea class="form-control" rows="3" name="current_address">{{ $user->current_address ?? '' }}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Permanent Address</label>
                                            <textarea class="form-control" rows="3" name="permanent_address">{{ $user->permanent_address ?? '' }}</textarea>
                                        </div>

                                    </div>

                                    <div class="section-title">
                                        Bank Information
                                    </div>
                                    <div class="row gx-4 gy-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Bank Name</label>
                                            <input type="text" class="form-control" name="bank_name" value="{{ $user->bank_name }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Branch Name</label>
                                            <input type="text" class="form-control" name="branch" value="{{ $user->bank_branch }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Account Holder Name</label>
                                            <input type="text" class="form-control" name="account_holder" value="{{ $user->acc_holder_name }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Account Number</label>
                                            <input type="text" class="form-control" name="account_number" value="{{ $user->acc_number }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">IFSC Code</label>
                                            <input type="text" class="form-control" name="bank_code" value="{{ $user->bank_code }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tax ID / PAN</label>
                                            <input type="text" class="form-control" name="tax_id" value="{{ $user->tax_payer_id }}">
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="card-footer bg-white border-top-0 pb-4 text-end">
                                    {{-- <button type="button" class="btn btn-light me-2">Cancel</button> --}}
                                 <button type="submit" class="btn btn-primary px-4" id="saveChangesBtn">
    Save Changes
</button>
                                </div>
                            </div>
                        </div>
                    </div>
              

            </div>
        </div>

        @include('partials.footer')
    </div>

    @include('partials.footer_link')

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });
        });

        flatpickr("#dob", {
            dateFormat: "d-m-Y"
            , allowInput: true
            , defaultDate: "{{ $user->dob ? Carbon::parse($user->dob)->format('d-m-Y') : '' }}"
        });

    // Image Preview + AJAX Upload + iziToast
document.getElementById('profileImageInput').addEventListener('change', function(event) {

    if (event.target.files && event.target.files[0]) {

        // Preview image
        var reader = new FileReader();
        reader.onload = function() {
            document.getElementById('imgPreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);

        // Upload
        let formData = new FormData();
        formData.append('image', event.target.files[0]);

        fetch("{{ route('profile.image.update') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            if (data.status) {

                iziToast.success({
                    title: 'Success',
                    message: 'Profile image updated successfully',
                    position: 'topRight',
                    timeout: 2500
                });

            } else {

                iziToast.error({
                    title: 'Error',
                    message: data.message ?? 'Failed to update profile image',
                    position: 'topRight',
                    timeout: 3000
                });
            }
        })
        .catch(err => {
            console.error(err);
            iziToast.error({
                title: 'Server Error',
                message: 'Something went wrong while uploading.',
                position: 'topRight',
                timeout: 3000
            });
        });
    }
});


        // Password Visibility Toggle Logic
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            } else {
                input.type = "password";
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            }
        }


   document.getElementById("savePasswordBtn").addEventListener("click", function () {

    let current = document.getElementById("current_pass").value;
    let newp = document.getElementById("new_pass").value;
    let confirm = document.getElementById("confirm_pass").value;

    // // console log (debug)
    // console.log("Current Password:", current);
    // console.log("New Password:", newp);
    // console.log("Confirm Password:", confirm);

    // frontend validations
    if (!current || !newp || !confirm) {
        iziToast.error({
            title: 'Required',
            message: 'All password fields are required',
            position: 'topRight'
        });
        return;
    }

    if (newp !== confirm) {
        iziToast.info({
            title: 'Mismatch',
            message: 'New password and confirm password do not match',
            position: 'topRight'
        });
        return;
    }

    let formData = new FormData();
    formData.append("current_password", current);
    formData.append("new_password", newp);

    fetch("{{ route('change.password') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
        .then(res => res.json())
        .then(data => {

            if (data.status) {
                iziToast.success({
                    title: 'Success',
                    message: data.message,
                    position: 'topRight'
                });

                document.getElementById("current_pass").value = "";
                document.getElementById("new_pass").value = "";
                document.getElementById("confirm_pass").value = "";

            } else {
                iziToast.info({
                   
                    message: data.message,
                    position: 'topRight'
                });
            }
        })
        .catch(e => {
            console.error(e);
            iziToast.error({
                title: 'Server Error',
                message: 'Something went wrong',
                position: 'topRight'
            });
        });
});


document.getElementById("saveChangesBtn").addEventListener("click", function (e) {

    e.preventDefault(); // stop submit

    let data = {};

    // ---------- Social ----------
    data.facebook = document.querySelector('[name="facebook"]')?.value || "";
    data.twitter  = document.querySelector('[name="twitter"]')?.value || "";

    // ---------- Staff only ----------
    data.prefix      = document.querySelector('[name="prefix"]')?.value || "";
    data.first_name  = document.querySelector('[name="first_name"]')?.value || "";
    data.last_name   = document.querySelector('[name="last_name"]')?.value || "";
    data.language    = document.querySelector('[name="language"]')?.value || "";
    data.dob         = document.querySelector('[name="dob"]')?.value || "";

    // gender radio
    let genderEl = document.querySelector('input[name="gender"]:checked');
    data.gender = genderEl ? genderEl.value : "";

    // ---------- Common ----------
    data.email             = document.querySelector('[name="email"]')?.value || "";
    data.mobile            = document.querySelector('[name="mobile"]')?.value || "";
    data.alt_mobile        = document.querySelector('[name="alt_mobile"]')?.value || "";
    data.current_address   = document.querySelector('[name="current_address"]')?.value || "";
    data.permanent_address = document.querySelector('[name="permanent_address"]')?.value || "";

    // ---------- Bank ----------
    data.bank_name       = document.querySelector('[name="bank_name"]')?.value || "";
    data.branch          = document.querySelector('[name="branch"]')?.value || "";
    data.account_holder  = document.querySelector('[name="account_holder"]')?.value || "";
    data.account_number  = document.querySelector('[name="account_number"]')?.value || "";
    data.bank_code       = document.querySelector('[name="bank_code"]')?.value || "";
    data.tax_id          = document.querySelector('[name="tax_id"]')?.value || "";

    // ---------- SEND TO LARAVEL ----------
    fetch("{{ route('profile.update') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {

        if (response.success) {

            iziToast.success({
                title: 'Success',
                message: 'Profile updated successfully',
                position: 'topRight',
                timeout: 2500
            });

            // close modal
            let modal = document.querySelector('#editProfileModal');
            if (modal) {
                let bootstrapModal = bootstrap.Modal.getInstance(modal);
                bootstrapModal?.hide();
            }

            setTimeout(() => {
                location.reload();
            }, 1200);

        } else {

            iziToast.error({
                title: 'Failed',
                message: 'Profile update failed',
                position: 'topRight'
            });
        }
    })
    .catch(err => {
        console.error(err);

        iziToast.error({
            title: 'Error',
            message: 'Something went wrong',
            position: 'topRight'
        });
    });

});



    </script>
</body>

</html>
