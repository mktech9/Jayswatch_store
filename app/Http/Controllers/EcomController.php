<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductModel;
use App\Models\UserAddressModel;
use App\Models\UserModel;
use App\Models\BrandModel;
use App\Models\MstCountryModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class EcomController extends Controller
{
    public function custlogin(Request $request)
    {
        // If user is already logged in, redirect directly to tracking
        if (session('user_id')) {
            if ($request->filled('tracking_num') && $request->filled('order_id')) {
                return redirect()->route('ordertracking', [
                    'tracking_num' => $request->tracking_num,
                    'order_id'     => $request->order_id,
                ]);
            }
            return redirect()->route('product');
        }

        return view('frontend.order.loginpage', [
            'tracking_num' => $request->query('tracking_num'),
            'order_id'     => $request->query('order_id'),
            'redirect'     => $request->query('redirect'), // 'tracking'
        ]);
    }
    // public function custregister(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'password' => 'required|min:6',
    //     ]);

    //     if (UserModel::where('email', $request->email)->exists()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Email already registered',
    //         ]);
    //     }

    //     $token = Str::random(64);

    //     DB::table('email_verifications')->updateOrInsert(
    //         ['email' => $request->email],
    //         [
    //             'name' => $request->name,
    //             'password' => encrypt($request->password),
    //             'token' => $token,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]
    //     );
    //     set_smtp_config();
    //     $verifyUrl = route('verify.email', $token);

    //     Mail::send('frontend.emails.verify', [
    //         'name' => $request->name,
    //         'verifyUrl' => $verifyUrl,
    //     ], function ($message) use ($request) {
    //         $message->to($request->email)
    //             ->from('tech@jayswatchstore.com', "Jay's Watch Store")
    //             ->subject('Verify Your Email Address');
    //     });

    //     try {
    //         activity_log(
    //             'Ecommerce',
    //             'Registration',
    //             'verification email sent to: ' . $request->email,
    //             null,
    //             0
    //         );
    //     } catch (\Exception $e) {
    //         // Do nothing - keep flow running
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Please verify your email account via Gmail.',
    //     ]);
    // }




    public function custregister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'g_recaptcha_response' => 'required',
        ]);

        if (UserModel::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already registered',
            ]);
        }

        // reCAPTCHA verification
        $captchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('GOOGLE_RECAPTCHA_SECRET'),
            'response' => $request->g_recaptcha_response,
            'remoteip' => $request->ip(),
        ]);

        $captchaResult = $captchaResponse->json();

        if (empty($captchaResult['success']) || $captchaResult['success'] !== true) {
            return response()->json([
                'success' => false,
                'message' => 'Captcha verification failed',
            ]);
        }

        $token = Str::random(64);

        DB::table('email_verifications')->updateOrInsert(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => encrypt($request->password),
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        set_smtp_config();

        $verifyUrl = route('verify.email', $token);

        Mail::send('frontend.emails.verify', [
            'name' => $request->name,
            'verifyUrl' => $verifyUrl,
        ], function ($message) use ($request) {
            $message->to($request->email)
                ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                ->subject('Verify Your Email Address');
        });

        try {
            activity_log(
                'Ecommerce',
                'Registration',
                'verification email sent to: ' . $request->email,
                null,
                0
            );
        } catch (\Exception $e) {
            // ignore
        }

        return response()->json([
            'success' => true,
            'message' => 'Please verify your email account via Gmail.',
        ]);
    }




    public function verifyEmail($token)
    {
        $record = DB::table('email_verifications')->where('token', $token)->first();

        if (! $record) {
            return redirect('/')->with('error', 'Invalid or expired verification link.');
        }

        $user = UserModel::create([
            'full_name' => $record->name,
            'email' => $record->email,
            'password' => $record->password,
            'status' => 1,
        ]);

        DB::table('email_verifications')->where('email', $record->email)->delete();

        session([
            'user_id' => $user->user_id,
            'user_fullname' => $user->full_name,
            'user_email' => $user->email,
        ]);

        try {
            activity_log(
                'Ecommerce',
                'Email Verification',
                'User email verified successfully: ' . $user->email,
                $user->user_id,
                0
            );
        } catch (\Exception $e) {
            // Silent fail - do not break verification
        }

        return redirect()->route('customerprofile')
            ->with('success', 'Email verified successfully!');
    }

    public function customerlogin(Request $request)
    {
        $credentials = $request->only('loginemail', 'loginpassword');

        // Find user by email
        $user = UserModel::where('email', $credentials['loginemail'])->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ]);
        }

        // Decrypt stored password
        try {
            $decryptedPassword = decrypt($user->password);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Password decryption failed.',
            ]);
        }

        // Compare passwords
        if ($decryptedPassword !== $credentials['loginpassword']) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ]);
        }

        // Store user data in session
        session([
            'user_id' => $user->user_id,
            'user_fullname' => $user->full_name,
            'user_email' => $user->email,
            'user_profile' => $user->profile_pic,
        ]);

        try {
            activity_log(
                'Ecommerce',
                'Login',
                'User logged in successfully: ' . $user->email,
                $user->user_id,
                0
            );
        } catch (\Exception $e) {
            // Silent fail
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
        ]);
    }

    public function customerprofile()
    {
        $userId = session('user_id');

        // ✅ Redirect to login if session not found
        if (! $userId) {
            return redirect()->route('custlogin-page');
        }

        $cust_data = UserModel::where('user_id', $userId)->first();
        $countries = MstCountryModel::orderBy('name')->get();

        $address_data = UserAddressModel::where('user_id', $userId)
            ->orderByDesc('is_primary')  // show primary first
            ->orderByDesc('ua_id')       // then sort others by latest added
            ->get();

        $orders = Order::select('order_id', 'order_date', 'status', 'total', 'o_id', 'tracking_num', 'delivery_type')
            ->where('user_id', $userId)
            ->whereIn('status', [1, 2, 3, 4]) // ✅ Only Processing & Delivered
            ->orderByDesc('o_id')
            ->get();

        foreach ($orders as $order) {

            $order->track_type = null;
            $order->track_status = null;
            $order->track_url = null;

            if ($order->delivery_type == 'bombex') {

                $order->track_type = 'bombex';
                $order->track_url = route('ordertracking', [
                    'tracking_num' => $order->tracking_num,
                    'order_id' => $order->order_id
                ]);

                if (!empty($order->tracking_num)) {
                    $apiUrl = "https://eztrackwebapi159.softpal.in/V1/TrackingApiCommon_Softpal?ShipmentNo={$order->tracking_num}&HostId=24";
                    $response = Http::get($apiUrl);

                    if ($response->successful()) {
                        $trackingData = $response->json();
                        $liveStatus = strtolower($trackingData['ConsignmentDetails_Traking']['current_status_name'] ?? '');

                        if (str_contains($liveStatus, 'transit')) {
                            $order->track_status = 'In Transit';
                        } elseif (str_contains($liveStatus, 'out for delivery')) {
                            $order->track_status = 'Out For Delivery';
                        } elseif (str_contains($liveStatus, 'pod') || str_contains($liveStatus, 'delivered')) {
                            $order->track_status = 'Delivered';
                        } else {
                            $order->track_status = $trackingData['ConsignmentDetails_Traking']['current_status_name'] ?? 'Tracking Pending';
                        }
                    } else {
                        $order->track_status = 'Tracking Pending';
                    }
                }
            } elseif ($order->delivery_type == 'internal') {

                $order->track_type = 'internal';
                $order->track_url = route('internal.order.tracking', [
                    'order_id' => $order->order_id
                ]);

                if ($order->status == 2) {
                    $order->track_status = 'Processing';
                } elseif ($order->status == 3) {
                    $order->track_status = 'In Transit';
                } elseif ($order->status == 4) {
                    $order->track_status = 'Delivered';
                }
            } elseif ($order->delivery_type == 'store_pickup') {

                $order->track_type = 'store_pickup';
                $order->track_url = route('store.pickup.tracking', [
                    'order_id' => $order->order_id
                ]);

                if ($order->status == 2) {
                    $order->track_status = 'Ready for Pickup';
                } elseif ($order->status == 3) {
                    $order->track_status = 'Visit Store';
                } elseif ($order->status == 4) {
                    $order->track_status = 'Picked Up';
                }
            } else {

                $order->track_type = 'normal';
                $order->track_status = match ((int) $order->status) {
                    1 => 'Processing',
                    2 => 'Shipped',
                    3 => 'Delivered',
                    4 => 'Delivered',
                    default => null,
                };
            }
        }

        $wishlist = DB::table('tbl_wishlist as w')
            ->join('mst_product as p', 'w.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_color as c', 'p.dial_colour', '=', 'c.color_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            ->where('w.user_id', $userId)
            ->select(
                'p.pro_id',
                'p.pro_name',
                'b.brand_name',
                'p.pro_sku',
                'p.pro_image',
                'p.case_material',
                'p.selling_price_exclusive',
                'p.out_stock',
                'c.title as dial_color'
            )
            ->get();




        $brand_data = BrandModel::where('status', '0')->select('*')->get();

        return view('frontend.order.profile', compact('cust_data', 'address_data', 'countries', 'orders', 'wishlist', 'brand_data'));
    }

    public function customerLogout(Request $request)
    {

        $userId = session('user_id');
        $userEmail = session('user_email');

        // ✅ Logout Activity Log (before flush)
        if ($userId) {
            try {
                activity_log(
                    'Ecommerce',
                    'Logout',
                    'User logged out successfully: ' . $userEmail,
                    $userId,
                    0
                );
            } catch (\Exception $e) {
                // Silent fail
            }
        }
        // Clear all Laravel session data
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to product page (or any page)
        return redirect()->route('product')->with('success', 'You have been logged out successfully.');
    }

    public function profileinvoicepage(Request $request)
    {
        $o_id = $request->query('o_id');
        $order_id = $request->query('order_id');

        // ✅ Fetch order
        $order = Order::where('order_id', $order_id)->first();

        foreach ($order->items as $item) {
            $product = DB::table('mst_product')
                ->where('pro_id', $item->product_id)
                ->first();

            $item->hsn_code = $product->hsn_code ?? '-';
        }

        if (! $order) {
            abort(404, 'Order not found');
        }

        // ✅ Fetch ordered items with product, brand, and variation info
        $orderItems = DB::table('order_items as oi')
            ->join('mst_product as p', 'oi.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')

            ->select(
                'oi.quantity',
                'p.pro_sku',
                'p.pro_name as product_name',
                'p.pro_image as product_image',
                'b.brand_name as brand_name',
                'p.hsn_code as hsn_code',
                'p.selling_price_exclusive as price'
            )
            ->where('oi.order_id', $order->order_id)
            ->get();

        // ✅ Fetch user details
        $user = UserModel::where('user_id', $order->user_id)->first();

        // ✅ Return invoice page view
        return view('frontend.order.invoiceprofile', compact('order', 'o_id', 'order_id', 'orderItems'));
    }

    public function updateProfilePhoto(Request $request)
    {
        $userId = session('user_id'); // Get logged-in user ID

        if (! $userId) {
            return response()->json(['success' => false, 'message' => 'User not logged in']);
        }

        if (! $request->hasFile('photo')) {
            return response()->json(['success' => false, 'message' => 'No file uploaded']);
        }

        $file = $request->file('photo');
        $ext = $file->getClientOriginalExtension();

        // Validate allowed extensions
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (! in_array(strtolower($ext), $allowed)) {
            return response()->json(['success' => false, 'message' => 'Invalid file type']);
        }

        // Generate new filename
        $filename = 'profile_' . $userId . '_' . time() . '.' . $ext;
        $uploadPath = public_path('assets/front/uploads/customer_profile');

        // Create folder if it doesn't exist
        if (! File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        // Move uploaded file
        $file->move($uploadPath, $filename);

        // Update database
        UserModel::where('user_id', $userId)->update(['profile_pic' => $filename]);

        // Update session if needed
        session(['profile_pic' => $filename]);

        try {
            activity_log(
                'Ecommerce',
                'Profile Update',
                'Customer updated profile photo.',
                $userId,
                0
            );
        } catch (\Exception $e) {
            // Silent fail (do not break flow)
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully!',
            'file' => asset('uploads/customer_profile/' . $filename),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please log in again.',
            ]);
        }

        $user = UserModel::find($userId);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ]);
        }

        try {
            // Decrypt the existing password from DB
            $decryptedPassword = decrypt($user->password);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error decrypting password. Please contact support.',
            ]);
        }

        if ($request->old_password !== $decryptedPassword) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ]);
        }

        $user->password = encrypt($request->new_password);
        $user->save();

        try {
            activity_log(
                'Ecommerce',
                'Password Update',
                'Customer updated account password.',
                $userId,
                0
            );
        } catch (\Exception $e) {
            // Silent fail (do not interrupt flow)
        }

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!',
        ]);
    }

    public function updateProfile(Request $request)
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please log in again.',
            ]);
        }

        $user = UserModel::find($userId);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ]);
        }

        $oldFullName = $user->full_name;
        $oldEmail = $user->email;
        $oldPhone = $user->phone;

        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        $changes = [];

        if ($oldFullName !== $request->full_name) {
            $changes[] = "Full Name: '{$oldFullName}' → '{$request->full_name}'";
        }

        if ($oldEmail !== $request->email) {
            $changes[] = "Email: '{$oldEmail}' → '{$request->email}'";
        }

        if ($oldPhone !== $request->phone) {
            $changes[] = "Phone: '{$oldPhone}' → '{$request->phone}'";
        }

        if (! empty($changes)) {
            try {
                activity_log(
                    'Ecommerce',
                    'Profile Update',
                    'Customer updated profile details: ' . implode(', ', $changes),
                    $userId,
                    0
                );
            } catch (\Exception $e) {
                // Silent fail
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
        ]);
    }

    public function saveAddress(Request $request)
    {
        $userId = session('user_id');

        if (! $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please log in again.',
            ]);
        }

        $ua_id = $request->ua_id;

        $countryName = DB::table('mst_country')
            ->where('id', $request->u_country)
            ->value('name');

        $stateName = DB::table('mst_state')
            ->where('id', $request->u_state)
            ->value('name');

        $cityName = DB::table('mst_city')
            ->where('id', $request->u_city)
            ->value('name');

        // Common data (excluding is_primary for update)
        $data = [
            'user_id' => $userId,
            'address_type' => $request->address_type,
            'u_pincode' => $request->u_pincode,
            'u_address1' => $request->u_address1,
            'u_address2' => $request->u_address2,
            'u_city' => $cityName,
            'u_state' =>  $stateName,
            'u_country' => $countryName,
            'status' => 1,
        ];

        if ($ua_id) {
            // Update existing address (keep is_primary as it is)
            $data['updated_at'] = Carbon::now();
            $data['updated_by'] = $userId;

            UserAddressModel::where('ua_id', $ua_id)->update($data);

            $message = 'Address updated successfully!';
        } else {
            // Create new address (set default is_primary to 0)
            $data['is_primary'] = 0;
            $data['created_at'] = Carbon::now();
            $data['created_by'] = $userId;

            UserAddressModel::create($data);

            $message = 'Address saved successfully!';

            try {
                activity_log(
                    'Ecommerce',
                    'Address Create',
                    'Customer added new address (' . $request->address_type . ', ' . $request->u_state . ', ' . $request->u_city . ').',
                    $userId,
                    0
                );
            } catch (\Exception $e) {
                // Silent fail
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function updatePrimaryAddress(Request $request)
    {
        $userId = session('user_id');
        $ua_id = $request->ua_id;

        if (! $userId || ! $ua_id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }

        $selectedAddress = UserAddressModel::where('ua_id', $ua_id)
            ->where('user_id', $userId)
            ->first();

        // First set all addresses to non-primary
        UserAddressModel::where('user_id', $userId)->update(['is_primary' => 0]);

        // Then set the selected address as primary
        UserAddressModel::where('ua_id', $ua_id)
            ->where('user_id', $userId)
            ->update(['is_primary' => 1]);

        try {
            activity_log(
                'Ecommerce',
                'Primary Address Update',
                'Customer set primary address: ' .
                    $selectedAddress->u_address1 . ', ' .
                    $selectedAddress->u_city . ', ' .
                    $selectedAddress->u_state,
                $userId,
                0 // use 1 not 0
            );
        } catch (\Exception $e) {
            // If needed for debugging:
            // \Log::error($e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Primary address updated successfully!',
        ]);
    }

    public function getSingleAddress(Request $request)
    {
        $address = UserAddressModel::find($request->ua_id);

        if ($address) {

            // 🔹 Convert NAME → ID
            $countryId = DB::table('mst_country')
                ->where('name', $address->u_country)
                ->value('id');

            $stateId = DB::table('mst_state')
                ->where('name', $address->u_state)
                ->value('id');

            $cityId = DB::table('mst_city')
                ->where('name', $address->u_city)
                ->value('id');

            return response()->json([
                'success' => true,
                'data' => [
                    'address_type' => $address->address_type,
                    'u_pincode' => $address->u_pincode,
                    'u_address1' => $address->u_address1,
                    'u_address2' => $address->u_address2,

                    // ✅ SEND IDs
                    'country_id' => $countryId,
                    'state_id'   => $stateId,
                    'city_id'    => $cityId,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Address not found.'
        ]);
    }

    public function deleteAddress(Request $request)
    {
        $userId = session('user_id');
        $ua_id = $request->ua_id;

        if (! $userId || ! $ua_id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request.',
            ]);
        }

        $address = UserAddressModel::where('ua_id', $ua_id)
            ->where('user_id', $userId)
            ->first();

        if (! $address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.',
            ]);
        }

        // Store details before delete (for log)
        $descriptionText = $address->u_address1 . ', ' .
            $address->u_city . ', ' .
            $address->u_state;

        $address->delete();

        // ✅ Activity Log (only after successful delete)
        try {
            activity_log(
                'Ecommerce',
                'Address Delete',
                'Customer deleted address: ' . $descriptionText,
                $userId,
                0
            );
        } catch (\Exception $e) {
            // Silent fail
        }

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully!',
        ]);
    }

    public function forgotcustPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = UserModel::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email address.',
            ]);
        }

        set_smtp_config();

        $resetUrl = URL::temporarySignedRoute(
            'cust-reset-password',
            now()->addMinutes(30),
            [
                'user_id' => $user->user_id,
                'email' => $user->email,
            ]
        );

        Mail::send('frontend.emails.forgotlink', [
            'user' => $user,
            'resetUrl' => $resetUrl,
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                ->subject('Reset Your Password');
        });

        try {
            activity_log(
                'Ecommerce',
                'Forgot Password',
                'Customer requested password reset link. ' . $user->email,
                $user->user_id,
                0
            );
        } catch (\Exception $e) {
            // Silent fail
        }

        return response()->json([
            'success' => true,
            'message' => 'A password reset link has been sent to your email.',
        ]);
    }

    public function showResetPasswordPage(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'This password reset link has expired or is invalid.');
        }

        session([
            'user_id' => $request->query('user_id'),
            'user_email' => $request->query('email'),
        ]);

        return view('frontend.order.forgotpass');
    }

    public function custupdatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $userId = session('user_id');
        $email = session('user_email');

        $user = UserModel::where('user_id', $userId)
            ->where('email', $email)
            ->first();

        if (! $user) {
            return back()->with('error', 'Invalid session. Please request a new reset link.');
        }

        $user->password = encrypt($request->password);
        $user->save();

        $fullName = $user->full_name
            ? $user->full_name
            : trim($user->first_name . ' ' . $user->last_name);

        $changedAt = date('d/m/Y, h:i A');

        set_smtp_config();

        Mail::send('frontend.emails.forgot_pass', [
            'name' => $fullName,
            'email' => $email,
            'changed_at' => $changedAt,
        ], function ($message) use ($email) {
            $message->to($email)
                ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                ->subject('Password Changed Successfully');
        });

        try {
            activity_log(
                'Ecommerce',
                'Password Reset',
                "Customer password changed successfully for: {$email}",
                $user->user_id,
                0
            );
        } catch (\Exception $e) {
            // Do nothing, flow continues
        }

        // Clear session
        session()->forget(['user_id', 'user_email']);

        return redirect()->route('custlogin-page')->with('success', 'Your password has been changed successfully.');
    }

    public function showsideCart(Request $request)
    {
        $productIds = $request->input('products', []);
        session(['cart' => $productIds]); // Save cart to session

        return response()->json(['success' => true]);
    }

    // Order Concept
    public function addToDb(Request $request)
    {
        $userId = $request->user_id;
        $productId = $request->product_id;

        if (! $userId || ! $productId) {
            return response()->json(['status' => 'error']);
        }

        DB::table('tbl_cart')->insert([
            'user_id' => $userId,
            'product_id' => $productId,

        ]);

        // ✅ Get Product Details
        $product = DB::table('mst_product')
            ->where('pro_id', $productId)
            ->select('pro_name', 'pro_sku')
            ->first();

        // ✅ Activity Log (silent fail)
        try {

            $productName = $product->pro_name ?? 'Unknown Product';
            $sku = $product->pro_sku ?? 'N/A';

            activity_log(
                'Ecommerce',
                'Add To Cart',
                "Product added to cart: {$productName} (SKU: {$sku})",
                $userId,
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        return response()->json(['status' => 'success']);
    }

    public function getCartItems(Request $request)
    {
        $productIds = $request->input('cart', []);

        if (empty($productIds)) {
            return response()->json([]);
        }

        $sidecartItems = DB::table('mst_product as p')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')

            ->select(
                'p.pro_id',
                'p.pro_name as product_name',
                'p.pro_image',
                'b.brand_name as brand_name',
                'p.selling_price_exclusive as price'
            )
            ->whereIn('p.pro_id', $productIds)
            ->get()
            ->map(function ($item) {

                // ✅ EXACT SAME LOGIC AS UPLOAD (NO strtolower)
                $item->brandfolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name);
                $item->productfolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->product_name);

                return $item;
            });

        return response()->json($sidecartItems);
    }

    public function removeFromCart(Request $request)
    {
        $userId = session('user_id');
        $productId = $request->input('product_id');

        if ($userId) {

            // Get product details before delete
            $product = DB::table('mst_product')
                ->where('pro_id', $productId)
                ->select('pro_name', 'pro_sku')
                ->first();

            $productName = $product->pro_name ?? 'Unknown Product';
            $sku = $product->pro_sku ?? 'N/A';

            // Delete only once
            $deleted = DB::table('tbl_cart')
                ->where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();

            if ($deleted) {
                try {
                    activity_log(
                        'Ecommerce',
                        'Remove From Cart',
                        "Product '{$productName}' (SKU: {$sku}) removed from cart",
                        $userId,
                        0
                    );
                } catch (\Exception $e) {
                    // silent fail
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Removed from DB cart',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in DB cart',
            ]);
        }

        return response()->json([
            'status' => 'guest',
            'message' => 'Guest user — only removed from session',
        ]);
    }

    public function showCart(Request $request)
    {
        $productIds = $request->input('products', []);
        session(['cart' => $productIds]); // Save cart to session

        return response()->json(['success' => true]);
    }

    public function getDBCart(Request $request)
    {
        $userId = session('user_id'); // ✅ Correct

        if (! $userId) {
            return response()->json(['status' => 'error', 'message' => 'User not logged in']);
        }

        $cartFromDb = DB::table('tbl_cart')
            ->where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        // Merge with session cart if exists
        $cartFromSession = session('cart', []);
        $mergedCart = array_unique(array_merge($cartFromDb, $cartFromSession));

        session(['cart' => $mergedCart]);

        return response()->json(['status' => 'success', 'cart' => $mergedCart]);
    }

    // Cart Page
    public function cartPage()
    {
        $productIds = session('cart', []);

        $cartItems = DB::table('mst_product as p')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            ->leftJoin('mst_brand as b2', 'p.manufacturer', '=', 'b2.brand_id')
            ->whereIn('p.pro_id', $productIds)
            ->select(
                'p.pro_id',
                'p.pro_name as product_name',
                'b2.brand_name as manufacturer',
                'p.pro_image',
                'p.pro_sku',
                'b.brand_name as brand_name',
                'p.selling_price_exclusive as price'
            )
            ->get();

        $countries = MstCountryModel::orderBy('name')->get();
        $stores = DB::table('tbl_bussiness_location')
            ->whereIn('location_id', ['PAHM', 'PHPA', 'PM', 'BW'])
            ->where('status', 0)
            ->get();

        $userEmail = session('user_email');

        return view('frontend.order.cart', [
            'cartItems' => $cartItems,
            'user_email' => $userEmail,  // pass to blade
            'countries' =>  $countries,
            'stores' => $stores,
        ]);
    }

    public function checkEmail(Request $request)
    {


        $email = $request->email;

        // Find user by email
        $user = UserModel::where('email', $email)->first();

        if ($user) {

            $userId = $user->user_id;

            // ---------------------------
            // Name handling
            // ---------------------------
            $firstName = $user->first_name ?: '';
            $lastName = $user->last_name ?: '';
            $fullName = $user->full_name;

            if (empty($firstName) && empty($lastName)) {
                $nameParts = explode(' ', trim($fullName), 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
            }

            // ---------------------------
            // Get primary address
            // ---------------------------
            $address = UserAddressModel::where('user_id', $userId)
                ->where('is_primary', 1)
                ->first();

            $addressData = null;

            if ($address) {

                // 🔥 Convert NAME → ID
                $countryId = DB::table('mst_country')
                    ->where('name', $address->u_country)
                    ->value('id');

                $stateId = DB::table('mst_state')
                    ->where('name', $address->u_state)
                    ->value('id');

                $cityId = DB::table('mst_city')
                    ->where('name', $address->u_city)
                    ->value('id');

                // ---------------------------
                // Final address response
                // ---------------------------
                $addressData = [
                    'u_address1' => $address->u_address1,
                    'u_address2' => $address->u_address2,
                    'u_pincode'  => $address->u_pincode,

                    // 🔥 IDs for dropdown
                    'country_id' => $countryId,
                    'state_id'   => $stateId,
                    'city_id'    => $cityId,
                ];
            }

            // ---------------------------
            // Final response
            // ---------------------------
            return response()->json([
                'exists' => false,
                'user' => [
                    'first_name'   => $firstName,
                    'last_name'    => $lastName,
                    'full_name'    => $fullName,
                    'citizen_type' => $user->citizen_type,
                    'pan_no'       => $user->pan_no,
                    'phone'        => $user->phone,
                ],
                'address' => $addressData
            ]);
        }

        // ---------------------------
        // New user
        // ---------------------------
        return response()->json([
            'exists' => false
        ]);
    }

    // Payment Process

    public function process(Request $request)
    {

        // dd(

        //     $request->delivery_option,
        //     $request->store_id
        // );

        $shippingCountryName = DB::table('mst_country')
            ->where('id', $request->shipping_country)
            ->value('name');

        $shippingStateName = DB::table('mst_state')
            ->where('id', $request->shipping_state)
            ->value('name');

        $shippingCityName = DB::table('mst_city')
            ->where('id', $request->shipping_city)
            ->value('name');


        $billingCountryName = DB::table('mst_country')
            ->where('id', $request->billing_country)
            ->value('name');

        $billingStateName = DB::table('mst_state')
            ->where('id', $request->billing_state)
            ->value('name');

        $billingCityName = DB::table('mst_city')
            ->where('id', $request->billing_city)
            ->value('name');



        $panJson = json_decode($request->pan_json, true);

        unset($panJson['data']['client_id']);

        $data['pan_json'] = json_encode($panJson);

        $panValue = $panJson ? json_encode($panJson) : null;

        try {
            // Handle optional file upload
            $docFileName = null;
            if ($request->hasFile('pan_upload')) {
                $file = $request->file('pan_upload');
                $docFileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/front/uploads/order_doc'), $docFileName);
            }

            // ✅ Create or update user
            $email = $request->shipping_email;
            $users = UserModel::where('email', $email)->first();

            if ($users) {
                // Update only empty fields
                $fieldsToUpdate = [
                    'phone' => $request->shipping_phone,
                    'pan_no' => $request->pan_no,
                    'pan_json' => $panValue,
                    'first_name' => $request->shipping_first_name,
                    'last_name' => $request->shipping_last_name,
                    'citizen_type' => $request->shipping_citizen_type,
                    'address' => $request->shipping_street,
                    'city' => $shippingCityName,
                    'state' => $shippingStateName,
                    'zip' => $request->shipping_zip,
                    'country' => $shippingCountryName,
                ];

                foreach ($fieldsToUpdate as $field => $value) {
                    if (empty($users->$field) && ! empty($value)) {
                        $users->$field = $value;
                    }
                }

                // Optional: set password if empty
                if (empty($users->password)) {
                    $users->password = encrypt('123456');
                }

                $users->updated_at = now();
                $users->updated_by = current_customer() ?? null;
                $users->save();
            } else {
                // Create new user
                $users = UserModel::create([
                    'email' => $email,
                    'password' => encrypt('123456'),
                    'phone' => $request->shipping_phone,
                    'pan_no' => $request->pan_no,
                    'pan_json' => $panValue,
                    'first_name' => $request->shipping_first_name,
                    'last_name' => $request->shipping_last_name,
                    'citizen_type' => $request->shipping_citizen_type,
                    'address' => $request->shipping_street,
                    'city' => $shippingCityName,
                    'state' => $shippingStateName,
                    'zip' => $request->shipping_zip,
                    'country' => $shippingCountryName,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => current_customer() ?? null,
                    'updated_by' => null,
                ]);
            }

            // ✅ Generate unique order ID
            do {
                $order_id = 'JW-ORD' . mt_rand(100000, 999999) . '-EC';
                $exists = DB::table('order')->where('order_id', $order_id)->exists();
            } while ($exists);

            $sessionUserId = session('user_id'); // returns null if not logged in

            // Use session user_id if exists, otherwise use the created/found user
            $userIdForOrder = $sessionUserId ?? $users->user_id;

            // ✅ Create order
            $order = Order::create([
                'order_id' => $order_id,
                'user_id' => $userIdForOrder,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_first_name' => $request->shipping_first_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_citizen_type' => $request->shipping_citizen_type,
                'doc_file' => $docFileName,
                'pan_no' => $request->pan_no,
                'pan_json' => $panValue,
                'shipping_address' => $request->shipping_street,
                'shipping_landmark' => $request->shipping_landmark,
                'shipping_city' => $shippingCityName,
                'shipping_state' => $shippingStateName,
                'shipping_zip' => $request->shipping_zip,
                'shipping_country' => $shippingCountryName,
                'same_as_billing' => $request->same_as_billing === 'on' ? 1 : 0,
                'billing_first_name' => $request->billing_first_name,
                'billing_last_name' => $request->billing_last_name,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_street,
                'billing_landmark' => $request->billing_landmark,
                'billing_city' => $billingCityName,
                'billing_state' => $billingStateName,
                'billing_zip' => $request->billing_zip,
                'billing_country' => $billingCountryName,
                'subtotal' => $request->subtotal,
                'payment_method' => $request->payment_method,
                'delivery_type' => $request->delivery_option == 'store_pickup'
                    ? $request->delivery_option
                    : null,
                'store_id' => $request->store_id ?? null,
                'tcs' => $request->tcs,
                'tax' => $request->tax,
                'total' => $request->total,
                'grand_total' => $request->subtotal + $request->tcs,
                'order_date' => now()->format('Y-m-d'),
                'created_by' => current_customer() ?? null,
                'created_at' => now(),
                'updated_by' => null,
                'updated_at' => null,
            ]);

            // ✅ Prepare encrypted payment request for CCAvenue
            $paymentPayload = ccavenuePrepareData($order->toArray());

            // ✅ Insert order items
            $productIds = json_decode($request->productid, true);
            $products = ProductModel::select('mst_product.pro_id', 'mst_product.pro_name', 'mst_product.selling_price_exclusive')
                // ->leftJoin('variations as v', 'products.id', '=', 'v.product_id')
                ->whereIn('mst_product.pro_id', $productIds)
                ->get();

            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product->pro_id,
                    'user_id' => $users->user_id,
                    'tid' => null,
                    'merchant_id' => null,
                    'currency' => 'INR',
                    'product_name' => $product->pro_name,
                    'quantity' => 1,
                    'price' => $product->selling_price_exclusive ?? 0,
                    'total' => $product->selling_price_exclusive ?? 0,
                    'created_at' => now(),
                    'created_by' => current_customer() ?? null,
                ]);
            }

            // ✅ Activity Log (silent fail)
            try {

                // Fetch ordered product details with SKU
                $orderedProducts = DB::table('mst_product')
                    ->whereIn('pro_id', $productIds)
                    ->select('pro_name', 'pro_sku')
                    ->get();

                $productList = $orderedProducts->map(function ($p) {
                    return "{$p->pro_name} (SKU: {$p->pro_sku})";
                })->implode(', ');

                activity_log(
                    'Ecommerce',
                    'Order Placed',
                    "Order {$order->order_id} placed by {$request->shipping_email}. Products: {$productList}. Grand Total: ₹{$order->grand_total}",
                    $userIdForOrder,
                    0
                );
            } catch (\Exception $e) {
                // silent fail — never break checkout
            }

            // ✅ Return JSON response
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'o_id' => $order->o_id,
                'order_id' => $order->order_id,
                'order' => $order->toArray(),
                'user' => $users->toArray(),
                'order_items' => $products->toArray(),
                'encrypted_data' => $paymentPayload['encrypted_data'],
                'access_code' => $paymentPayload['access_code'],
                'ccavenue_url' => $paymentPayload['ccavenue_url'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function ccavenueResponse(Request $request)
    {
        $encResp = $request->input('encResp');
        $working_key = '4C96CEFE74F23664E5F0300101ACEE03';

        // for live
        // $working_key = "A0D933D61B85CF2BDDD070F8238717D1";

        // ✅ Decrypt response
        $decrypted_response = ccavenueDecrypt($encResp, $working_key);

        parse_str($decrypted_response, $responseArray);

        // ✅ Extract response values
        $userId = session('user_id');
        $order_id = $responseArray['order_id'] ?? null;
        $status = strtolower($responseArray['order_status'] ?? '');
        $tracking_id = $responseArray['tracking_id'] ?? null;
        $failure_message = $responseArray['failure_message'] ?? null;
        $failure_status_message = $responseArray['status_message'] ?? null;
        $ref_no = $responseArray['bank_ref_no'] ?? null;
        $payment_mode = $responseArray['payment_mode'] ?? null;
        $card_name = $responseArray['card_name'] ?? null;
        $currency = $responseArray['currency'] ?? null;
        $billing_notes = $responseArray['billing_notes'] ?? null;
        $trans_date = null;
        $hoLocation = DB::table('tbl_bussiness_location')
            ->where('location_id', 'HO')
            ->first();

        if (!empty($responseArray['trans_date'])) {
            $trans_date = Carbon::createFromFormat(
                'd/m/Y H:i:s',
                $responseArray['trans_date']
            )->format('Y-m-d H:i:s');
        }

        if ($order_id) {
            $updateData = [
                'order_status' => $status,
                'transaction_id' => $tracking_id,
                'failure_message' => $failure_message,
                'failure_status_message' => $failure_status_message,
                'ref_no' => $ref_no,
                'payment_mode' => $payment_mode,
                'card_name' => $card_name,
                'currency' => $currency,
                'billing_notes' => $billing_notes,
                'trans_date' => $trans_date,

                'status' => ($status === 'success') ? 1 : 0,
            ];

            if ($status === 'success') {
                $invoiceNum = generateInvoiceNumber();
                $updateData['invoice_num'] = $invoiceNum;
            }

            // dd($invoiceNum);
            // ✅ Update main order
            Order::where('order_id', $order_id)->update($updateData);

            // Fetch all product IDs from OrderItem for this order
            $productIds = OrderItem::where('order_id', $order_id)->pluck('product_id');

            // Update stock_status in Product table
            // ProductModel::whereIn('pro_id', $productIds)->update(['out_stock' => 1]);
            ProductModel::whereIn('pro_id', $productIds)
                ->update([

                    'out_stock' => 1,

                    // ✅ UPDATE LOCATION
                    'display_location' => $hoLocation->bl_id,
                    'physical_location' => $hoLocation->bl_id,

                ]);

            // ✅ Update all related order items
            OrderItem::where('order_id', $order_id)->update([
                'status' => ($status === 'success') ? 1 : 0,
            ]);
            $productIds = OrderItem::where('order_id', $order_id)
                ->pluck('product_id')
                ->toArray();

            // DB::table('tbl_cart')
            //     ->where('user_id', $userId)
            //     ->whereIn('product_id', $productIds)
            //     ->delete();
            DB::table('tbl_cart')
                ->where('product_id', $productIds)
                ->delete();
        }

        // ✅ Activity Log (Payment Result)
        try {

            // Fetch ordered products
            $orderedProducts = DB::table('mst_product')
                ->whereIn('pro_id', $productIds)
                ->select('pro_name', 'pro_sku')
                ->get();

            $productList = $orderedProducts->map(function ($p) {
                return "{$p->pro_name} (SKU: {$p->pro_sku})";
            })->implode(', ');

            $logAction = ($status === 'success')
                ? 'Payment Success'
                : 'Payment Failed';

            $logMessage = "Order {$order_id} payment {$status}. "
                . "Txn ID: {$tracking_id}, Mode: {$payment_mode}, "
                . "Bank Ref: {$ref_no}. Products: {$productList}";

            activity_log(
                'Ecommerce',
                $logAction,
                $logMessage,
                $userId,
                ($status === 'success') ? 0 : 1
            );
        } catch (\Exception $e) {
            // silent fail — never interrupt payment flow
        }

        if ($status === 'success') {
            return redirect()->route('invoice-page', [
                'order_id' => $order_id,
                'status' => $status,
            ]);
        } elseif ($status === 'aborted') {
            return redirect()->route('order-cancel-page', [
                'order_id' => $order_id,
                'status' => $status,
                'message' => $failure_message,
            ]);
        } else {
            return redirect()->route('order-cancel-page', [
                'order_id' => $order_id,
                'status' => $status,
                'message' => $failure_message ?? 'Payment failed',
            ]);
        }
    }

    public function invoicepage(Request $request)
    {
        $o_id = $request->query('o_id');
        $order_id = $request->query('order_id');

        // ✅ Fetch order
        $order = Order::where('order_id', $order_id)->first();

        foreach ($order->items as $item) {
            $product = DB::table('mst_product')
                ->where('pro_id', $item->product_id)
                ->first();

            $item->hsn_code = $product->hsn_code ?? '-';
        }

        if (! $order) {
            abort(404, 'Order not found');
        }

        // ✅ Fetch ordered items with product, brand, and variation info
        $orderItems = DB::table('order_items as oi')
            ->join('mst_product as p', 'oi.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            // ->leftJoin('variations as v', 'p.id', '=', 'v.product_id')
            ->select(
                'oi.quantity',
                'p.pro_name as product_name',
                'p.pro_image as product_image',
                'b.brand_name as brand_name',
                'p.hsn_code as hsn_code',
                'p.selling_price_exclusive as price'
            )
            ->where('oi.order_id', $order->order_id)
            ->get();

        // ✅ Fetch user details
        $user = UserModel::where('user_id', $order->user_id)->first();

        // ✅ Prepare email data (handle null values safely)
        $emailData = [
            'user_name' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
            'user_email' => $user->email ?? '-',
            'order_id' => $order->order_id ?? '-',
            'invoice_num' => $order->invoice_num ?? '-',
            'order_date' => ! empty($order->order_date)
                ? Carbon::parse($order->order_date)->format('d F Y')
                : '-',
            'payment_mode' => $order->payment_mode ?? '-',
            'payment_method' => $order->payment_method ?? '-',
            'ref_no' => $order->ref_no ?? '-',
            'card_name' => $order->card_name ?? '-',
            'subtotal' => $order->subtotal ?? 0,
            'tcs' => $order->tcs ?? 0,
            'order_status' => $order->order_status ?? 0,
            'shipping_phone' => $order->shipping_phone ?? '-',
            'shipping_address' => $order->shipping_address ?? '-',
            'shipping_city' => $order->shipping_city ?? '-',
            'shipping_state' => $order->shipping_state ?? '-',
            'shipping_zip' => $order->shipping_zip ?? '-',
            'shipping_country' => $order->shipping_country ?? '-',
            'items' => $orderItems,
        ];

        // ✅ Generate the invoice PDF
        $pdf = PDF::loadView('order_sales.invoiceprint', [
            'order' => $order,
            'items' => $orderItems,
            'tcsRate' => (! empty($order->tcs) && $order->tcs > 0)
                ? ((strtolower($order->shipping_citizen_type) === 'indian') ? 1 : 5)
                : 0,
            'tcsAmount' => (! empty($order->tcs) && $order->tcs > 0)
                ? (($order->tcs * ((strtolower($order->shipping_citizen_type) === 'indian') ? 1 : 5)) / 100)
                : 0,
        ]);

        // ✅ Create a safe PDF file name
        $customerName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $customerName);
        $pdfFileName = $order->order_id . '_' . $safeName . '.pdf';
        $pdfPath = storage_path('app/public/invoices/' . $pdfFileName);

        // ✅ Ensure directory exists
        if (! file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0755, true);
        }

        // ✅ Save PDF temporarily
        $pdf->save($pdfPath);

        set_smtp_config();

        // ✅ Send email with attached PDF
        try {
            if (! empty($user->email)) {
                Mail::send('frontend.emails.order_email', ['data' => $emailData], function ($message) use ($user, $pdfPath, $pdfFileName) {
                    $message->to($user->email)
                        ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                        ->subject('Order Successfully Placed - Jay\'s Watch Store')
                        ->attach($pdfPath, [
                            'as' => $pdfFileName,
                            'mime' => 'application/pdf',

                        ]);
                });
            }
        } catch (\Exception $e) {
            // \Log::error('Mail send failed: ' . $e->getMessage());
        }

        // ✅ Delete the temp PDF after sending
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        // ✅ Return invoice page view
        return view('frontend.order.invoice', compact('order', 'o_id', 'order_id', 'orderItems'));
    }

    public function ordercancel()
    {
        return view('frontend.order.ordercancel');
    }


    //Wishlist
    public function saveWishlist(Request $request)
    {
        $user_id = session('user_id');

        if (!$user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }

        $wishlist = $request->wishlist;

        foreach ($wishlist as $product_id) {

            $exists = DB::table('tbl_wishlist')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->first();

            if (!$exists) {
                DB::table('tbl_wishlist')->insert([
                    'user_id'    => $user_id,
                    'product_id' => $product_id,
                    'status'     => 0,
                    'created_at' => now(),
                    'created_by' => $user_id
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Wishlist saved successfully'
        ]);
    }


    public function getWishlist()
    {
        $user_id = session('user_id');

        if (!$user_id) {
            return response()->json(['status' => 'error']);
        }

        $wishlist = DB::table('tbl_wishlist')
            ->where('user_id', $user_id)
            ->pluck('product_id');

        return response()->json([
            'status' => 'success',
            'wishlist' => $wishlist
        ]);
    }

    public function addWishlist(Request $request)
    {
        $user_id = session('user_id');

        if (!$user_id) {
            return response()->json(['status' => 'error']);
        }

        $exists = DB::table('tbl_wishlist')
            ->where('user_id', $user_id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$exists) {
            DB::table('tbl_wishlist')->insert([
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'status' => 1,
                'created_at' => now(),
                'created_by' => $user_id
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function removeWishlist(Request $request)
    {
        $user_id = session('user_id');

        if (!$user_id) {
            return response()->json(['status' => 'error']);
        }

        DB::table('tbl_wishlist')
            ->where('user_id', $user_id)
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json(['status' => 'success']);
    }



    public function getCartPanel()
    {
        $userId = session('user_id');

        if (!$userId) {
            return response()->json([
                'html' => '<p>Please login to see cart.</p>'
            ]);
        }

        $cartitems = DB::table('tbl_cart as tc')
            ->join('mst_product as p', 'tc.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_color as c', 'p.dial_colour', '=', 'c.color_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            ->where('tc.user_id', $userId)
            ->select(
                'p.pro_id',
                'p.pro_name',
                'b.brand_name',
                'p.pro_sku',
                'p.pro_image',
                'p.selling_price_exclusive',
                'p.case_material',
                'c.title as dial_color'
            )
            ->get();

        // 🔥 Build HTML manually
        $html = '';

        if ($cartitems->count() > 0) {
            foreach ($cartitems as $item) {

                $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? '');
                $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->pro_name ?? '');

                $actual_url = config('app.actual_url');

                $img = $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $item->pro_image;

                // SEO Route Slugs
                $manufacturerSlug = \Illuminate\Support\Str::slug($item->brand_name);
                $productSlug = \Illuminate\Support\Str::slug($item->pro_name);
                $skuSuffix = $item->pro_sku ? substr($item->pro_sku, -7) : '0000000';

                $viewUrl = route('productDetails.seo', [
                    $manufacturerSlug,
                    $productSlug,
                    $skuSuffix
                ]);

                $html .= '
    <article class="product">
        <img src="' . $img . '" alt="' . $item->pro_name . '" />

        <h4 class="text-center">' . $item->pro_name . '</h4>

        <div class="muted text-center">
            ' . ($item->dial_color ?? 'N/A') . ' • ' . $item->case_material . '
        </div>

     <p class="mt-1 text-center">
    ₹ ' . indian_number_format($item->selling_price_exclusive) . '
</p>

      <div class="d-flex align-items-center justify-content-between gap-2 mt-2 action-buttons">
    <button class="btn btn-dark buy-btn custom-btn flex-grow-1" Style="font-size: 12px !important;"
        data-productname="' . $item->pro_name . '"
        data-id="' . $item->pro_id . '">
        Buy Now
    </button>

    <a href="' . $viewUrl . '" class="btn btn-light icon-btn">
        <i class="fa fa-eye"></i>
    </a>

    <button class="btn btn-light icon-btn text-danger"
        data-id="' . $item->pro_id . '"
        onclick="removeFromProfileCart(this)">
        <i class="fa fa-trash"></i>
    </button>
</div>
    </article>';
            }
        } else {
            $html = '<p>No cart items found.</p>';
        }

        return response()->json([
            'html' => $html
        ]);
    }


    //Email OTP
    public function sendEmailOtp(Request $request)
    {

        set_smtp_config();

        $otp = rand(100000, 999999);

        DB::table('email_otp')->insert([
            'user_id' => session('user_id'),
            'token_id' => Str::random(40),
            'email' => $request->email,
            'otp' => $otp,
            'status' => 0,
            'created_at' => now()
        ]);


        Mail::send([], [], function ($message) use ($request, $otp) {
            $message->to($request->email)
                ->subject('Email Verification OTP')
                ->html("
                <h3>Your OTP is: <b>$otp</b></h3>
                <p>This OTP is valid for 5 minutes.</p>
            ");
        });

        return response()->json(['success' => true]);
    }

    public function verifyEmailOtp(Request $request)
    {
        $otp = DB::table('email_otp')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('status', 0)
            ->latest()
            ->first();

        if ($otp) {

            DB::table('email_otp')
                ->where('eo_id', $otp->eo_id)
                ->update(['status' => 1]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }


    //order tracking
    public function ordertracking($tracking_num, $order_id)
    {

        $userId = session('user_id');

        if (!$userId) {
            return redirect('/custlogin-page');
        }

        $order = Order::where('order_id', $order_id)
            ->where('tracking_num', $tracking_num)
            ->first();

        if (!$order) {
            abort(404, 'Tracking not found');
        }

        $apiUrl = "https://eztrackwebapi159.softpal.in/V1/TrackingApiCommon_Softpal?ShipmentNo={$tracking_num}&HostId=24";

        $response = Http::get($apiUrl);

        if (!$response->successful()) {
            return back()->with('error', 'Unable to fetch tracking details.');
        }

        $trackingData = $response->json();

        return view('frontend.order.ordertracking', compact(
            'order',
            'tracking_num',
            'trackingData'
        ));
    }

    public function internal_order_tracking($order_id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/custlogin-page');
        }

        $order = Order::where('order_id', $order_id)
            ->where('delivery_type', 'internal')
            ->first();

        if (!$order) {
            abort(404, 'Tracking not found');
        }

        $steps = [];

        // ✅ ORDER PLACED
        $steps[] = [
            'title' => 'Order Placed',
            'date' => date('d-m-Y h:i A', strtotime($order->created_at)),
            'city' => $order->shipping_city ?? '',
        ];

        // ✅ SHIPPED
        if ($order->status >= 2) {

            $steps[] = [
                'title' => 'Shipped',
                'date' => date('d-m-Y h:i A', strtotime($order->updated_at)),
                'city' => $order->shipping_city ?? '',
            ];
        }

        // ✅ OUT FOR DELIVERY
        if ($order->status >= 3 && !empty($order->delivery_details)) {

            $delivery = json_decode($order->delivery_details, true);

            $steps[] = [
                'title' => 'Out For Delivery',
                'date' => date('d-m-Y h:i A', strtotime($order->updated_at)),
                'city' => $order->shipping_city ?? '',
                'delivery_guy' => $delivery['delivery_guy'] ?? '',
                'contact_number' => $delivery['contact_number'] ?? '',
            ];
        }

        // ✅ DELIVERED
        if ($order->status >= 4) {

            $steps[] = [
                'title' => 'Delivered',
                'date' => date('d-m-Y h:i A', strtotime($order->updated_at)),
                'city' => $order->shipping_city ?? '',
            ];
        }

        $currentStatus = end($steps)['title'] ?? 'Order Placed';

        return view('frontend.order.internaltracking', compact(
            'order',
            'steps',
            'currentStatus'
        ));
    }

    //store pickup tracking
    public function store_pickup_tracking($order_id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/custlogin-page');
        }

        $order = Order::where('order_id', $order_id)
            ->where('delivery_type', 'store_pickup')
            ->first();

        if (!$order) {
            abort(404, 'Tracking not found');
        }

        // ✅ STORE DETAILS
        $store = DB::table('tbl_bussiness_location')
            ->where('bl_id', $order->store_id)
            ->first();

        $steps = [];

        // ✅ ORDER PLACED
        $steps[] = [
            'title' => 'Order Placed',
            'date' => date('d-m-Y h:i A', strtotime($order->created_at)),
            'city' => $order->shipping_city ?? '',
        ];

        // ✅ VISIT STORE
        if ($order->status >= 2) {

            $steps[] = [
                'title' => 'Visit Store',
                'date' => date('d-m-Y h:i A', strtotime($order->updated_at)),
                'city' => $store->name ?? '',
                'store_address' => $store->address ?? '',
            ];
        }

        // ✅ DELIVERED / PICKED UP
        if ($order->status >= 4) {

            $steps[] = [
                'title' => 'Delivered',
                'date' => date('d-m-Y h:i A', strtotime($order->updated_at)),
                'city' => $store->name ?? '',
            ];
        }

        $currentStatus = end($steps)['title'] ?? 'Order Placed';

        return view(
            'frontend.order.storepickuptracking',
            compact(
                'order',
                'steps',
                'currentStatus',
                'store'
            )
        );
    }
}
