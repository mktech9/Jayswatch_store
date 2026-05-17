<?php

use App\Models\BusinesslocationModel;
use App\Models\NotificationModel;
use App\Models\StaffModel;
use App\Models\SalesModel;
use App\Models\StockTransferModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

if (! function_exists('loggedUserName')) {

    function loggedUserName(): string
    {
        if (Session::get('login_type') === 'super_admin') {
            return Session::get('super_admin_username', '');
        }

        if (Session::get('login_type') === 'staff') {
            return trim(
                Session::get('staff_first_name', '') . ' ' .
                    Session::get('staff_last_name', '')
            );
        }

        return '';
    }
}

if (! function_exists('current_user_id')) {

    function current_user_id()
    {
        $loginType = Session::get('login_type');

        if ($loginType === 'super_admin') {
            return -1;
        }

        if ($loginType === 'staff') {
            return Session::get('staff_id');
        }

        return null;
    }
}

if (! function_exists('activity_log')) {

    function activity_log(
        string $menuType,
        string $logType,
        string $description,
        ?int $userId = null,
        int $status = 0
    ) {

        $ipAddress = request()->getClientIp();

        // âœ… Prevent duplicate log within last 10 seconds
        $exists = DB::table('activity_log')
            ->where('menu_type', $menuType)
            ->where('log_type', $logType)
            ->where('log_description', $description)
            ->where('ip_address', $ipAddress)
            ->where(function ($q) use ($userId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->whereNull('user_id');
                }
            })
            ->where('created_at', '>=', now()->subSeconds(60)) // ðŸ”¥ time window
            ->exists();

        // Stop if duplicate
        if ($exists) {
            return;
        }

        DB::table('activity_log')->insert([
            'menu_type'       => $menuType,
            'log_type'        => $logType,
            'user_id'         => $userId,
            'log_date'        => now(),
            'log_description' => $description,
            'log_status'      => $status,
            'ip_address'      => $ipAddress,
            'created_at'      => now(),
            'created_by'      => current_user_id(),
            'updated_at'      => null,
            'updated_by'      => null,
        ]);
    }
}
if (! function_exists('full_name')) {

    function full_name(?int $userId): ?string
    {
        // -1 means Super Admin
        if ($userId === -1) {
            return 'Admin';
        }

        if (! $userId) {
            return null;
        }

        $staff = StaffModel::select('first_name', 'last_name')
            ->where('staff_id', $userId)
            ->first();

        if (! $staff) {
            return 'Unknown User';
        }

        return trim($staff->first_name . ' ' . $staff->last_name);
    }
}

if (! function_exists('profile_pic')) {

    function profile_pic(): ?string
    {
        $loginType = Session::get('login_type');

        // For SUPER ADMIN
        if ($loginType === 'super_admin') {

            $username = Session::get('super_admin_username');

            if (! $username) {
                return null;
            }

            return DB::table('super_admin')
                ->where('sp_username', $username)
                ->value('profile_pic');
        }

        // For STAFF
        if ($loginType === 'staff') {

            $staffId = Session::get('staff_id');

            if (! $staffId) {
                return null;
            }

            return DB::table('tbl_staff')
                ->where('staff_id', $staffId)
                ->value('profile_pic');
        }

        // default for other login types / not logged in
        return null;
    }
}

if (! function_exists('menuPermission')) {

    function menuPermission(int $menuId, string $action = 'view', ?int $subMenuId = null): bool
    {

        if (Session::get('login_type') === 'super_admin') {
            return true;
        }

        $roleId = Session::get('role_id');

        if (! $roleId) {
            return false;
        }

        $query = DB::table('role_menu_permissions')
            ->where('role_id', $roleId)
            ->where('menu_id', $menuId)
            ->where('status', 0);

        if (! is_null($subMenuId)) {
            $query->where('sub_menu_id', $subMenuId);
        }

        $permission = $query->first();

        if (! $permission) {
            return false;
        }

        return match ($action) {
            'view' => (int) $permission->can_view === 1,
            'create' => (int) $permission->can_create === 1,
            'update' => (int) $permission->can_update === 1,
            'delete' => (int) $permission->can_delete === 1,
            'export' => (int) $permission->view_export === 1,
            default => false,
        };
    }
}

// Notification
// if (! function_exists('create_product_notification')) {
//     function create_product_notification(string $proName, int $staffId): bool
//     {

//         if (! $staffId) {
//             return false;
//         }

//         NotificationModel::create([
//             'type' => 'Product',
//             'description' => "New Product For Approval :- {$proName}",
//             'read_status' => 0,
//             'submit_by' => $staffId,
//             'created_by' => $staffId,
//             'status' => 0,
//         ]);

//         return true;
//     }

//     // mohii

//     if (! function_exists('staff_locations')) {

//         function staff_locations()
//         {
//             $loginType = Session::get('login_type');

//             if ($loginType === 'super_admin') {
//                 return BusinesslocationModel::where('status', 0)->get();
//             }

//             if ($loginType === 'staff') {

//                 $staffId = Session::get('staff_id');

//                 if (! $staffId) {
//                     return collect();
//                 }

//                 $accessLocation = DB::table('tbl_staff')
//                     ->where('staff_id', $staffId)
//                     ->value('access_location');

//                 if (! $accessLocation) {
//                     return collect();
//                 }

//                 // convert "1,2,5" â†’ [1,2,5]
//                 $locationIds = array_map('intval', explode(',', $accessLocation));

//                 return BusinesslocationModel::whereIn('bl_id', $locationIds)
//                     ->where('status', 0)
//                     ->get();
//             }

//             return collect();
//         }
//     }
// }
// if (! function_exists('create_product_notification')) {

//     function create_product_notification(string $proName, int $staffId, string $type): bool
//     {

//         if (! $staffId) {
//             return false;
//         }

//         NotificationModel::create([
//             'type' => $type,
//             'description' => "New {$type} For Approval :- {$proName}",
//             'read_status' => 0,
//             'submit_by' => $staffId,
//             'created_by' => $staffId,
//             'status' => 0,
//         ]);

//         return true;
//     }
// }


if (! function_exists('create_notification')) {

    function create_notification(
        string $type,
        string $description,
        int $staffId
    ): bool {

        if (! $staffId) {
            return false;
        }

        NotificationModel::create([
            'type' => $type,
            'description' => $description,
            'read_status' => 0,
            'submit_by' => $staffId,
            'created_by' => $staffId,
            'status' => 0,
        ]);

        return true;
    }
}

// mohii
if (! function_exists('staff_locations')) {

    function staff_locations()
    {
        $loginType = Session::get('login_type');

        if ($loginType === 'super_admin') {
            return BusinesslocationModel::where('status', 0)->get();
        }

        if ($loginType === 'staff') {

            $staffId = Session::get('staff_id');

            if (! $staffId) {
                return collect();
            }

            $accessLocation = DB::table('tbl_staff')
                ->where('staff_id', $staffId)
                ->value('access_location');

            if (! $accessLocation) {
                return collect();
            }

            // convert "1,2,5" â†’ [1,2,5]
            $locationIds = array_map('intval', explode(',', $accessLocation));

            return BusinesslocationModel::whereIn('bl_id', $locationIds)
                ->where('status', 0)
                ->get();
        }

        return collect();
    }
}

if (! function_exists('access_locations')) {

    function access_locations()
    {
        // ✅ All admin roles get all locations
        if (all_admin()) {
            return BusinesslocationModel::where('status', 0)
                ->orderBy('name')
                ->get();
        }

        // ✅ Normal staff → only assigned locations
        if (Session::get('login_type') === 'staff') {

            $staffId = Session::get('staff_id');

            if (! $staffId) {
                return collect();
            }

            $accessLocation = DB::table('tbl_staff')
                ->where('staff_id', $staffId)
                ->value('access_location');

            if (! $accessLocation) {
                return collect();
            }

            return BusinesslocationModel::where('status', 0)
                ->whereRaw('FIND_IN_SET(bl_id, ?)', [$accessLocation])
                ->orderBy('name')
                ->get();
        }

        return collect();
    }
}

if (! function_exists('indian_number_format')) {

    function indian_number_format($number)
    {
        // force 2 decimal digits
        $number = number_format((float) $number, 2, '.', '');

        $parts = explode('.', $number);

        $integerPart = $parts[0];
        $decimalPart = $parts[1];

        $lastThree = substr($integerPart, -3);
        $remaining = substr($integerPart, 0, -3);

        if ($remaining != '') {
            $lastThree = ',' . $lastThree;
        }

        $formatted = preg_replace("/\B(?=(\d{2})+(?!\d))/", ',', $remaining) . $lastThree;

        return $formatted . '.' . $decimalPart;
    }
}

if (! function_exists('current_customer')) {

    function current_customer()
    {
        return session('user_id'); // fetch from session
    }
}

// ccavenue

if (! function_exists('ccavenueEncrypt')) {
    function ccavenueEncrypt($plainText, $key)
    {
        $secretKey = hextobin(md5($key));
        $initVector = pack(
            'C*',
            0x00,
            0x01,
            0x02,
            0x03,
            0x04,
            0x05,
            0x06,
            0x07,
            0x08,
            0x09,
            0x0A,
            0x0B,
            0x0C,
            0x0D,
            0x0E,
            0x0F
        );
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);

        return bin2hex($openMode);
    }
}

if (! function_exists('ccavenueDecrypt')) {
    function ccavenueDecrypt($encryptedText, $key)
    {
        $secretKey = hextobin(md5($key));
        $initVector = pack(
            'C*',
            0x00,
            0x01,
            0x02,
            0x03,
            0x04,
            0x05,
            0x06,
            0x07,
            0x08,
            0x09,
            0x0A,
            0x0B,
            0x0C,
            0x0D,
            0x0E,
            0x0F
        );
        $encryptedText = hextobin($encryptedText);

        return openssl_decrypt($encryptedText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
    }
}

if (! function_exists('hextobin')) {
    function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = '';
        for ($i = 0; $i < $length; $i += 2) {
            $binString .= pack('H*', substr($hexString, $i, 2));
        }

        return $binString;
    }
}

if (!function_exists('ccavenuePrepareData')) {
    function ccavenuePrepareData($order, $mode = 'live')
    {
        if ($mode === 'live') {
            $merchant_id  = "3928615";
            $access_code  = "AVBV33LK86BL18VBLB";
            $working_key  = "A0D933D61B85CF2BDDD070F8238717D1";
            $ccavenue_url = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        } else {
            $merchant_id  = "3928615";
            $access_code  = "ATBV33LK86BL18VBLB";
            $working_key  = "4C96CEFE74F23664E5F0300101ACEE03";
            $ccavenue_url = "https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        }



        $merchant_data = [
            'merchant_id'     => $merchant_id,
            'order_id'        => $order['order_id'],
            'currency'        => 'INR',
            'amount'          => $order['total'],

            'language'        => 'EN',
            'billing_name'    => $order['shipping_first_name'] ?? '',
            'billing_email'   => $order['shipping_email'] ?? '',
            'billing_tel'     => $order['shipping_phone'] ?? '',
            'billing_address' => $order['shipping_address'] ?? '',
            'billing_zip'     => $order['shipping_zip'] ?? '',
            'redirect_url' => route('ccavenue.response'),



        ];

        $merchant_data_str = http_build_query($merchant_data);
        $encrypted_data = ccavenueEncrypt($merchant_data_str, $working_key);

        return [
            'encrypted_data' => $encrypted_data,
            'access_code'    => $access_code,
            'ccavenue_url'   => $ccavenue_url,
            'mode'           => $mode,
        ];
    }
}

if (! function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber()
    {
        // âœ… Determine current fiscal year (Aprilâ€“March)
        $month = date('n'); // 1â€“12
        $year = date('y');  // e.g., 25

        if ($month >= 4) {
            // Aprilâ€“March â†’ fiscal year
            $currentYear = $year;
            $nextYear = $year + 1;
        } else {
            // Janâ€“Mar â†’ previous fiscal year
            $currentYear = $year - 1;
            $nextYear = $year;
        }

        $yearFormat = sprintf('%02d-%02d', $currentYear, $nextYear);

        // âœ… Fetch last non-empty invoice number from "orders"
        $lastInvoice = DB::table('order')
            ->whereNotNull('invoice_num')
            ->where('invoice_num', '!=', '')
            ->orderByDesc('o_id')
            ->value('invoice_num');

        $nextNumber = 1;

        if ($lastInvoice) {
            // Extract numeric and year parts from invoice
            // Example: JWSEC-001/25-26
            preg_match('/JWSEC-(\d+)\/(\d{2}-\d{2})/', $lastInvoice, $matches);

            if (isset($matches[1])) {
                $lastNum = (int) $matches[1];
                $lastYear = $matches[2] ?? '';

                // âœ… Increment if same fiscal year
                if ($lastYear === $yearFormat) {
                    $nextNumber = $lastNum + 1;
                }
            }
        }

        // âœ… Format next invoice number
        return 'JWSEC-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . '/' . $yearFormat;
    }
}



//credit-no
if (!function_exists('generate_credit_no')) {
    function generate_credit_no()
    {
        $lastRow = SalesModel::whereNotNull('return_no')
            ->orderByDesc('sales_id')
            ->first();

        // ✅ First entry
        if (!$lastRow || empty($lastRow->return_no)) {
            return 'CN-00001';
        }

        // ✅ Extract number from CN-00001
        $lastNumber = (int) str_replace('CN-', '', $lastRow->return_no);

        // ✅ Increment
        $newNumber = $lastNumber + 1;

        // ✅ Format with leading zeros
        return 'CN-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}



//All Admin

if (!function_exists('all_admin')) {

    function all_admin()
    {
        $loginType = Session::get('login_type');

        // Super admin access
        if ($loginType === 'super_admin') {
            return true;
        }

        // Staff role access
        if ($loginType === 'staff') {
            $staffId = Session::get('staff_id');

            $roleName = DB::table('tbl_staff as s')
                ->join('tbl_role as r', 'r.role_id', '=', 's.role_id')
                ->where('s.staff_id', $staffId)
                ->value('r.role_name');

            return in_array($roleName, ['Admin', 'Co-Admin']);
        }

        return false;
    }
}

// Bombex tracking number generator
if (!function_exists('generate_bombex_tracking')) {

    function generate_bombex_tracking()
    {
        // Get active range
        $range = DB::table('tbl_ship_range')
            ->where('status', 0)
            ->first();

        if (!$range) {
            return 'Range not found';
        }

        $from = (int) $range->from_range;
        $to   = (int) $range->to_range;

        // Get last used numeric tracking number from orders table
        $lastOrder = DB::table('order')
            ->where('delivery_type', 'bombex')
            ->whereNotNull('tracking_num')
            ->whereRaw('tracking_num REGEXP "^[0-9]+$"')
            ->orderByRaw('CAST(tracking_num AS UNSIGNED) DESC')
            ->first();

        // If no tracking used yet
        if (!$lastOrder) {
            return $from;
        }

        $next = ((int) $lastOrder->tracking_num) + 1;

        // If next number below range start
        if ($next < $from) {
            return $from;
        }

        // If range finished
        if ($next > $to) {
            return 'Range End';
        }

        return $next;
    }
}

// Permission Helper
if (! function_exists('routePermission')) {

    function routePermission(?string $routeName, string $action = 'view'): bool
    {
        if (Session::get('login_type') === 'super_admin') {
            return true;
        }

        if (! $routeName) {
            return false;
        }

        $menu = DB::table('mst_menu')
            ->where('menu_route', $routeName)
            ->where('status', 0)
            ->first();

        if ($menu) {
            return menuPermission((int) $menu->menu_id, $action);
        }

        $submenu = DB::table('tbl_sub_menu')
            ->where('submenu_route', $routeName)
            ->where('status', 0)
            ->first();

        if ($submenu) {
            return menuPermission(
                (int) $submenu->menu_id,
                $action,
                (int) $submenu->sub_menu_id
            );
        }

        return false;
    }
}


//whatsapp template
if (!function_exists('send_whatsapp_template')) {

    function send_whatsapp_template($data = [])
    {
        try {

            // Remove spaces, +91, special chars
            $phone = preg_replace('/\D+/', '', $data['sender_whatsapp_number'] ?? '');

            // Check empty phone
            if (empty($phone)) {

                // Log::warning('WhatsApp number missing');

                return [
                    'status' => false,
                    'message' => 'WhatsApp number missing'
                ];
            }

            // Payload
            $payload = [

                "sender_whatsapp_number" => $phone,

                "template_name" => $data['template_name'] ?? '',

                "broadcast_name" => $data['broadcast_name'] ?? 'test_broadcast',

                "url" => $data['url'] ?? '',

                "parameter_value1" => $data['parameter_value1'] ?? '',

            ];

            // Optional parameters
            if (!empty($data['parameter_value2'])) {
                $payload['parameter_value2'] = $data['parameter_value2'];
            }

            if (!empty($data['parameter_value3'])) {
                $payload['parameter_value3'] = $data['parameter_value3'];
            }

            // API Request
            $response = Http::withHeaders([

                'Content-Type' => 'application/json',

                'token' =>  env('SMARTCHAT_TOKEN'),

            ])->post('https://smartchatapi.live/portal/Api/send_template_message', $payload);

            // Response
            return [

                'status' => $response->successful(),

                'response' => $response->json(),

            ];
        } catch (\Exception $e) {

            // Log::error('WhatsApp API Error : ' . $e->getMessage());

            return [

                'status' => false,

                'message' => $e->getMessage(),

            ];
        }
    }
}


//auto genetrate stock transfer reference number
if (! function_exists('generate_stock_reference_no')) {

    function generate_stock_reference_no(): string
    {
        $prefix = 'JWS-';
        $padding = 3;

        $lastRef = StockTransferModel::where('reference_no', 'like', $prefix . '%')
            ->orderByDesc('stock_id')
            ->value('reference_no');

        $lastNumber = 0;

        if ($lastRef && preg_match('/^JWS-(\d+)$/', $lastRef, $match)) {
            $lastNumber = (int) $match[1];
        }

        return $prefix . str_pad($lastNumber + 1, $padding, '0', STR_PAD_LEFT);
    }
}
