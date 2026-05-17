<?php

namespace App\Http\Controllers;

use App\Models\BusinesslocationModel;
use App\Models\ProductModel;
use App\Models\StockMultiProductModel;
use App\Models\StockTransferModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class StockController extends Controller
{
    public function index()
    {
        $page_title = 'Stock Management';
        $reference_no = generate_stock_reference_no();

        return view('stock.index', compact('page_title', 'reference_no'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            /* ============================
             |  UPDATE MODE
             ============================ */
            if (! empty($request->stock_id)) {

                $stock = StockTransferModel::where('stock_id', $request->stock_id)->first();

                if (! $stock) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Stock Transfer not found!',
                    ], 404);
                }

                // ✅ Update main stock transfer
                $stock->update([
                    'transfer_date' => $request->transfer_date,
                    'reference_no' => $request->reference_no,
                    'stock_status' => $request->stock_status,
                    'shipping_charges' => $request->shipping_charges,
                    'notes' => $request->notes,
                    'total' => $request->total,
                    'updated_by' => current_user_id(),
                    'updated_at' => now(),
                ]);

                // ✅ Existing product rows
                $existingIds = StockMultiProductModel::where('stock_id', $stock->stock_id)
                    ->pluck('stock_multi_id')
                    ->toArray();

                $submittedIds = [];

                foreach ($request->product_id as $index => $pid) {

                    $multiId = $request->multi_id[$index] ?? null;

                    // 🔄 Update existing
                    if (! empty($multiId)) {

                        StockMultiProductModel::where('stock_multi_id', $multiId)
                            ->where('stock_id', $stock->stock_id)
                            ->update([
                                'qyt' => $request->qty[$index],
                                'unit_price' => $request->unit_price[$index],
                                'unit_type' => $request->unit_type[$index],
                                'updated_at' => now(),
                            ]);

                        $submittedIds[] = $multiId;
                    }
                    // ➕ Insert new
                    else {
                        $new = StockMultiProductModel::create([
                            'stock_id' => $stock->stock_id,
                            'product_id' => $pid,
                            'qyt' => $request->qty[$index],
                            'unit_price' => $request->unit_price[$index],
                            'unit_type' => $request->unit_type[$index],
                            'status' => 0,
                            'created_by' => current_user_id(),
                            'created_at' => now(),
                        ]);

                        $submittedIds[] = $new->stock_multi_id;
                    }
                }

                // ❌ Delete removed products
                $toDelete = array_diff($existingIds, $submittedIds);
                if (! empty($toDelete)) {
                    StockMultiProductModel::whereIn('stock_multi_id', $toDelete)->delete();
                }

                // ✅ MOVE PRODUCT LOCATION IF COMPLETED
                if ($request->stock_status == 2 && $stock->getOriginal('stock_status') != 2) {

                    $fromLocation = $stock->location_from;
                    $toLocation = $stock->location_to;

                    $stockProducts = StockMultiProductModel::where('stock_id', $stock->stock_id)->get();

                    foreach ($stockProducts as $item) {
                        ProductModel::where('pro_id', $item->product_id)
                            ->where('physical_location', $fromLocation)
                            ->update([
                                'physical_location' => $toLocation,
                            ]);
                    }
                }

                activity_log(
                    'stock',
                    'stock_transfer',
                    json_encode([
                        'stock_id' => $stock->stock_id,
                        'status' => 'Stock Transfer Updated',
                    ]),
                    current_user_id()
                );



                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Stock Transfer Updated Successfully ✅',
                ]);
            }

            /* ============================
             |  CREATE MODE
             ============================ */
            $stock = StockTransferModel::create([
                'transfer_date' => $request->transfer_date,
                'reference_no' => $request->reference_no,
                'stock_status' => $request->stock_status,
                'location_from' => $request->location_from,
                'location_to' => $request->location_to,
                'shipping_charges' => $request->shipping_charges,
                'notes' => $request->notes,
                'total' => $request->total,
                'created_by' => current_user_id(),
                'created_at' => now(),
            ]);

            foreach ($request->product_id as $index => $pid) {
                StockMultiProductModel::create([
                    'stock_id' => $stock->stock_id,
                    'product_id' => $pid,
                    'qyt' => $request->qty[$index],
                    'unit_price' => $request->unit_price[$index],
                    'unit_type' => $request->unit_type[$index],
                    'status' => 0,
                    'created_by' => current_user_id(),
                    'created_at' => now(),
                ]);
            }

            // ✅ MOVE PRODUCT LOCATION IF CREATED AS COMPLETED
            if ($request->stock_status == 2) {

                $fromLocation = $stock->location_from;
                $toLocation = $stock->location_to;

                $stockProducts = StockMultiProductModel::where('stock_id', $stock->stock_id)->get();

                foreach ($stockProducts as $item) {
                    ProductModel::where('pro_id', $item->product_id)
                        ->where('physical_location', $fromLocation)
                        ->update([
                            'physical_location' => $toLocation,
                        ]);
                }
            }

            activity_log(
                'stock',
                'stock_transfer',
                json_encode([
                    'stock_id' => $stock->stock_id,
                    'status' => 'New Stock Transfer Created',
                ]),
                current_user_id()
            );


            create_notification(
                'Stock Transfer',
                "New Stock Transfer Created :- {$stock->reference_no}",
                current_user_id()
            );

            if (set_smtp_config()) {

                $fromLocation = DB::table('tbl_bussiness_location')
                    ->where('bl_id', $stock->location_from)
                    ->first();

                $toLocation = DB::table('tbl_bussiness_location')
                    ->where('bl_id', $stock->location_to)
                    ->first();

                $body = view('emails.stock_transfer', [
                    'stock'        => $stock,
                    'fromLocation' => $fromLocation,
                    'toLocation'   => $toLocation
                ])->render();

                $subject = 'New Stock Transfer Created - Ref #' . $stock->reference_no;

                $extraEmails = [];

                // ✅ Always send TO location email
                if (!empty($toLocation->email)) {
                    $extraEmails[] = $toLocation->email;
                }

                // ✅ If Completed then also send FROM location
                if ($request->stock_status == 2) {

                    $subject = 'Stock Transfer Completed - Ref #' . $stock->reference_no;

                    if (!empty($fromLocation->email)) {
                        $extraEmails[] = $fromLocation->email;
                    }
                }

                send_multi_recipient_mail(
                    $subject,
                    $body,
                    null,
                    [],
                    $extraEmails
                );
            }


            DB::commit();



            return response()->json([
                'status' => true,
                'message' => 'Stock Transfer Saved Successfully ✅',
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function list(Request $request)
    {
        $columns = [
            0 => 'stock_id',
            1 => 'reference_no',
            2 => 'transfer_date',
            3 => 'location_from',
            4 => 'location_to',
            5 => 'shipping_charges',
            6 => 'total',
            7 => 'stock_status',
            8 => 'action',
        ];

        $query = StockTransferModel::with(['fromLocation', 'toLocation']);

        $accessLocations = access_locations()->pluck('bl_id')->toArray();

        if (Session::get('login_type') === 'staff') {

            $query->where(function ($q) use ($accessLocations) {
                $q->whereIn('location_from', $accessLocations)
                    ->orWhereIn('location_to', $accessLocations);
            });
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'desc');
        $searchValue = $request->input('search.value');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reference_no', 'LIKE', "%{$searchValue}%")
                    ->orWhere('transfer_date', 'LIKE', "%{$searchValue}%")
                    ->orWhere('stock_status', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        $orderColumn = $columns[$orderColumnIndex] ?? 'stock_id';

        $data = $query
            ->orderByDesc('stock_id')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // ✅ Default Buttons (View + Print always)
            $action = '
<div class="d-flex gap-1 justify-content-center mb-1">

    <button class="btn btn-sm btn-info viewStock" data-id="' . $row->stock_id . '">
        <i class="bx bx-show"></i>
    </button>

    <button class="btn btn-sm btn-secondary printStock" data-id="' . $row->stock_id . '">
        <i class="bx bx-printer"></i>
    </button>';

            // ✅ Edit button only for all admin
            if (all_admin()) {
                $action .= '
    <button class="btn btn-sm btn-warning editStock"
        data-id="' . $row->stock_id . '"
        title="Edit">
        <i class="bx bx-edit"></i>
    </button>';
            }

            $action .= '</div>';

            // ✅ Only location_to staff can update status
            if (
                $row->stock_status != 2 &&
                in_array($row->location_to, $accessLocations)
            ) {

                $action .= '
    <div class="d-flex gap-1 justify-content-center">

        <button class="btn btn-sm btn-success receivedStock"
            data-id="' . $row->stock_id . '">
            <i class="bx bx-check-circle"></i>
        </button>

        <button class="btn btn-sm btn-danger rejectStock"
            data-id="' . $row->stock_id . '">
            <i class="bx bx-trash"></i>
        </button>



    </div>';
            }
            $canUpdateStatus = in_array($row->location_to, $accessLocations) && $row->stock_status != 2;
            $stockStatus = match ($row->stock_status) {

                // ✅ Pending
                0 => $canUpdateStatus
                    ? '<span class="badge bg-warning stockStatusBtn"
                data-id="' . $row->stock_id . '"
                data-status="0"
                style="cursor:pointer;">Pending</span>'
                    : '<span class="badge bg-warning">Pending</span>',

                // ✅ In-Transit
                1 => $canUpdateStatus
                    ? '<span class="badge bg-info stockStatusBtn"
                data-id="' . $row->stock_id . '"
                data-status="1"
                style="cursor:pointer;">In-Transit</span>'
                    : '<span class="badge bg-info">In-Transit</span>',

                // ✅ Completed (Never Clickable)
                2 => '<span class="badge bg-success">Completed</span>',

                default => '<span class="badge bg-secondary">-</span>',
            };

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'reference_no' => '#' . e($row->reference_no),
                'transfer_date' => $row->transfer_date
                    ? \Carbon\Carbon::parse($row->transfer_date)->format('d-m-Y')
                    : '-',
                'location_from' => $row->fromLocation->name ?? '-',
                'location_to' => $row->toLocation->name ?? '-',
                'shipping_charges' => e($row->shipping_charges),
                'total' => e($row->total),
                'stock_status' => $stockStatus,
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $formattedData,
        ]);
    }

    public function viewProducts($id)
    {
        $transfer = StockTransferModel::where('stock_id', $id)->first();

        if (! $transfer) {
            return response()->json([
                'status' => false,
                'message' => 'Stock Transfer not found!',
            ]);
        }

        $transfer_date = $transfer->transfer_date
            ? Carbon::parse($transfer->transfer_date)->format('d M Y')
            : '-';

        $products = StockMultiProductModel::with('product')
            ->where('stock_id', $id)
            ->where('status', 0)
            ->get();

        $fromLocation = BusinesslocationModel::where('bl_id', $transfer->location_from)->first();
        $toLocation = BusinesslocationModel::where('bl_id', $transfer->location_to)->first();

        $activityLogs = DB::table('activity_log')
            ->where('menu_type', 'stock')
            ->where('log_type', 'stock_transfer')
            ->whereNotNull('log_description') // ✅ ignore NULL
            ->whereRaw("JSON_VALID(log_description)") // ✅ only valid JSON
            ->whereRaw(
                "JSON_UNQUOTE(JSON_EXTRACT(log_description, '$.stock_id')) = ?",
                [$id]
            )
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($log) {

                $json = json_decode($log->log_description, true) ?? [];

                return [
                    'status' => $json['status'] ?? '-',
                    'reference' => $json['reference_no'] ?? '-',
                    'user_name' => full_name($log->user_id),
                    'date' => Carbon::parse($log->created_at)->format('d-M-Y'),
                ];
            });

        return response()->json([
            'status' => true,
            'transfer' => $transfer,
            'from' => $fromLocation,
            'to' => $toLocation,
            'transfer_date' => $transfer_date,
            'products' => $products,
            'logs' => $activityLogs,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $stock = StockTransferModel::where('stock_id', $request->stock_id)->first();

        if (! $stock) {
            return response()->json([
                'status' => false,
                'message' => 'Stock Transfer not found!',
            ], 404);
        }

        // ✅ Update stock status
        $stock->update([
            'stock_status' => $request->stock_status,
            'updated_by'   => current_user_id(),
            'updated_at'   => now(),
        ]);

        $statusText = 'Unknown';

        if ($request->stock_status == 0) {
            $statusText = 'Pending';
        } elseif ($request->stock_status == 1) {
            $statusText = 'In-Transit';
        } elseif ($request->stock_status == 2) {

            $statusText = 'Completed';

            // ✅ Move product physical location
            $fromLocation = $stock->location_from;
            $toLocation   = $stock->location_to;

            $stockProducts = StockMultiProductModel::where('stock_id', $stock->stock_id)->get();

            foreach ($stockProducts as $stockItem) {

                ProductModel::where('pro_id', $stockItem->product_id)
                    ->where('physical_location', $fromLocation)
                    ->update([
                        'physical_location' => $toLocation,
                    ]);
            }
        }

        // ✅ Activity Log
        activity_log(
            'stock',
            'stock_transfer',
            json_encode([
                'stock_id'      => $stock->stock_id,
                'reference_no'  => $stock->reference_no,
                'status'        => $statusText,
            ]),
            current_user_id()
        );

        /* ==========================
       EMAIL NOTIFICATION
    ========================== */
        if (set_smtp_config()) {

            $fromLocationData = DB::table('tbl_bussiness_location')
                ->where('bl_id', $stock->location_from)
                ->first();

            $toLocationData = DB::table('tbl_bussiness_location')
                ->where('bl_id', $stock->location_to)
                ->first();

            $body = view('emails.stock_transfer', [
                'stock'        => $stock,
                'fromLocation' => $fromLocationData,
                'toLocation'   => $toLocationData
            ])->render();

            $subject = 'Stock Status Updated - Ref #' . $stock->reference_no;

            $extraEmails = [];

            // Always send TO location
            if (!empty($toLocationData->email)) {
                $extraEmails[] = $toLocationData->email;
            }

            // If completed also send FROM location
            if ($request->stock_status == 2) {

                $subject = 'Stock Transfer Completed - Ref #' . $stock->reference_no;

                if (!empty($fromLocationData->email)) {
                    $extraEmails[] = $fromLocationData->email;
                }
            }

            send_multi_recipient_mail(
                $subject,
                $body,
                null,
                [],
                $extraEmails
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Stock Status Updated Successfully!',
        ]);
    }
    public function printInvoice($id)
    {
        // ✅ Fetch Stock Transfer
        $transfer = StockTransferModel::where('stock_id', $id)->firstOrFail();

        // ✅ Format Transfer Date
        $transfer_date = $transfer->transfer_date
            ? Carbon::parse($transfer->transfer_date)->format('d M Y')
            : '-';

        // ✅ Fetch Products
        $products = StockMultiProductModel::with('product')
            ->where('stock_id', $id)
            ->where('status', 0)
            ->get();

        // ✅ Fetch Locations
        $fromLocation = BusinesslocationModel::where('bl_id', $transfer->location_from)->first();
        $toLocation = BusinesslocationModel::where('bl_id', $transfer->location_to)->first();

        // ✅ Return Print View (Auto Print)
        return view('stock.print', compact(
            'transfer',
            'transfer_date',
            'products',
            'fromLocation',
            'toLocation'
        ));
    }

    public function edit($id)
    {
        $transfer = StockTransferModel::where('stock_id', $id)->first();

        if (! $transfer) {
            return response()->json([
                'status' => false,
                'message' => 'Stock Transfer not found!',
            ]);
        }

        $products = StockMultiProductModel::with('product.brandInfo')
            ->where('stock_id', $id)
            ->get();

        // ✅ Add brand_folder, product_folder, image_url for each product
        foreach ($products as $item) {

            if ($item->product) {

                $brandFolder = preg_replace(
                    '/[^A-Za-z0-9\-]/',
                    '_',
                    $item->product->brandInfo->brand_name ?? 'NoBrand'
                );

                $productFolder = preg_replace(
                    '/[^A-Za-z0-9\-]/',
                    '_',
                    $item->product->pro_name ?? 'NoProduct'
                );

                // ✅ Image Path
                $imagePath = public_path(
                    "assets/admin_assets/brand/{$brandFolder}/{$productFolder}/image/" .
                        $item->product->pro_image
                );

                // ✅ If Image Exists → Use Real Image
                if (! empty($item->product->pro_image) && file_exists($imagePath)) {

                    $item->product->image_url =
                        config('app.actual_url') .
                        "/admin_assets/brand/{$brandFolder}/{$productFolder}/image/" .
                        $item->product->pro_image;
                }
                // ✅ Else Show Placeholder
                else {
                    $item->product->image_url =
                        'https://placehold.co/50x50?text=No+Img';
                }
            }
        }

        return response()->json([
            'status' => true,
            'transfer' => $transfer,
            'products' => $products,
        ]);
    }

    public function markReceived(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:mst_stock_trasfer,stock_id',
        ]);

        $transfer = StockTransferModel::where('stock_id', $request->stock_id)->first();

        if (! $transfer) {
            return response()->json([
                'status' => false,
                'message' => 'Stock Transfer not found!',
            ]);
        }

        $fromLocation = $transfer->location_from;
        $toLocation = $transfer->location_to;

        // ✅ Update transfer status
        $transfer->stock_status = 2;
        $transfer->save();

        // ✅ Products under this stock transfer
        $stockProducts = StockMultiProductModel::where('stock_id', $transfer->stock_id)->get();

        foreach ($stockProducts as $stockItem) {

            // ✅ Update ONLY if physical_location matches FROM location
            ProductModel::where('pro_id', $stockItem->product_id)
                ->where('physical_location', $fromLocation)
                ->update([
                    'physical_location' => $toLocation,
                ]);
        }

        // ✅ Activity Log
        activity_log(
            'stock',
            'stock_transfer',
            json_encode([
                'stock_id' => $transfer->stock_id,
                'status' => 'Stock Marked as Received',
                'location_from' => $fromLocation,
                'location_to' => $toLocation,
            ]),
            current_user_id()
        );

        /* ==========================
       EMAIL NOTIFICATION
    ========================== */
        if (set_smtp_config()) {

            $fromLocationData = DB::table('tbl_bussiness_location')
                ->where('bl_id', $fromLocation)
                ->first();

            $toLocationData = DB::table('tbl_bussiness_location')
                ->where('bl_id', $toLocation)
                ->first();

            $body = view('emails.stock_transfer', [
                'stock'        => $transfer,
                'fromLocation' => $fromLocationData,
                'toLocation'   => $toLocationData
            ])->render();

            $extraEmails = [];

            // Always notify TO location
            if (!empty($toLocationData->email)) {
                $extraEmails[] = $toLocationData->email;
            }

            // Also notify FROM location
            if (!empty($fromLocationData->email)) {
                $extraEmails[] = $fromLocationData->email;
            }

            send_multi_recipient_mail(
                'Stock Transfer Completed - Ref #' . $transfer->reference_no,
                $body,
                null,
                [],
                $extraEmails
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Stock marked as Received and Physical Location updated successfully!',
        ]);
    }

    // Stock IN
    public function stockIn()
    {
        $page_title = 'Stock IN';

        return view('stock.stock_in', compact('page_title'));
    }

    public function stockInlist(Request $request)
    {
        $columns = [
            0 => 'stock_id',
            1 => 'reference_no',
            2 => 'transfer_date',
            3 => 'location_from',
            4 => 'location_to',
            5 => 'shipping_charges',
            6 => 'total',
            7 => 'stock_status',
            8 => 'action',
        ];

        $query = StockTransferModel::with(['fromLocation', 'toLocation']);

        $accessLocations = access_locations()->pluck('bl_id')->toArray();

        if (Session::get('login_type') === 'staff') {
            $query->whereIn('location_to', $accessLocations);
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'desc');
        $searchValue = $request->input('search.value');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reference_no', 'LIKE', "%{$searchValue}%")
                    ->orWhere('transfer_date', 'LIKE', "%{$searchValue}%")
                    ->orWhere('stock_status', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        $orderColumn = $columns[$orderColumnIndex] ?? 'stock_id';

        $data = $query
            ->orderByDesc('stock_id')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // ✅ Default Buttons (View + Print always)
            $action = '
<div class="d-flex gap-1 justify-content-center mb-1">
    <button class="btn btn-sm btn-info viewStock" data-id="' . $row->stock_id . '">
        <i class="bx bx-show"></i>
    </button>

    <button class="btn btn-sm btn-secondary printStock" data-id="' . $row->stock_id . '">
        <i class="bx bx-printer"></i>
    </button>

    <button class="btn btn-sm btn-warning editStock d-none" data-id="' . $row->stock_id . '" title="Edit"> <i class="bx bx-edit"></i> </button>
</div>';

            // ✅ Only location_to staff can update status
            if (
                $row->stock_status != 2 &&
                in_array($row->location_to, $accessLocations)
            ) {

                $action .= '
    <div class="d-flex gap-1 justify-content-center">

        <button class="btn btn-sm btn-success receivedStock"
            data-id="' . $row->stock_id . '">
            <i class="bx bx-check-circle"></i>
        </button>

        <button class="btn btn-sm btn-danger rejectStock"
            data-id="' . $row->stock_id . '">
            <i class="bx bx-trash"></i>
        </button>



    </div>';
            }
            $canUpdateStatus = in_array($row->location_to, $accessLocations) && $row->stock_status != 2;
            $stockStatus = match ($row->stock_status) {

                // ✅ Pending
                0 => $canUpdateStatus
                    ? '<span class="badge bg-warning stockStatusBtn"
                data-id="' . $row->stock_id . '"
                data-status="0"
                style="cursor:pointer;">Pending</span>'
                    : '<span class="badge bg-warning">Pending</span>',

                // ✅ In-Transit
                1 => $canUpdateStatus
                    ? '<span class="badge bg-info stockStatusBtn"
                data-id="' . $row->stock_id . '"
                data-status="1"
                style="cursor:pointer;">In-Transit</span>'
                    : '<span class="badge bg-info">In-Transit</span>',

                // ✅ Completed (Never Clickable)
                2 => '<span class="badge bg-success">Completed</span>',

                default => '<span class="badge bg-secondary">-</span>',
            };

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'reference_no' => '#' . e($row->reference_no),
                'transfer_date' => $row->transfer_date
                    ? \Carbon\Carbon::parse($row->transfer_date)->format('d-m-Y')
                    : '-',
                'location_from' => $row->fromLocation->name ?? '-',
                'location_to' => $row->toLocation->name ?? '-',
                'shipping_charges' => e($row->shipping_charges),
                'total' => e($row->total),
                'stock_status' => $stockStatus,
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $formattedData,
        ]);
    }

    // Stock Out

    public function stockOut()
    {
        $page_title = 'Stock Out';

        return view('stock.stock_out', compact('page_title'));
    }

    public function stockOutlist(Request $request)
    {
        $columns = [
            0 => 'stock_id',
            1 => 'reference_no',
            2 => 'transfer_date',
            3 => 'location_from',
            4 => 'location_to',
            5 => 'shipping_charges',
            6 => 'total',
            7 => 'stock_status',
            8 => 'action',
        ];

        $query = StockTransferModel::with(['fromLocation', 'toLocation']);

        $accessLocations = access_locations()->pluck('bl_id')->toArray();

        if (Session::get('login_type') === 'staff') {
            $query->whereIn('location_from', $accessLocations);
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'desc');
        $searchValue = $request->input('search.value');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reference_no', 'LIKE', "%{$searchValue}%")
                    ->orWhere('transfer_date', 'LIKE', "%{$searchValue}%")
                    ->orWhere('stock_status', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        $orderColumn = $columns[$orderColumnIndex] ?? 'stock_id';

        $data = $query
            ->orderByDesc('stock_id')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // ✅ Default Buttons (View + Print always)
            $action = '
<div class="d-flex gap-1 justify-content-center mb-1">
    <button class="btn btn-sm btn-info viewStock" data-id="' . $row->stock_id . '">
        <i class="bx bx-show"></i>
    </button>

    <button class="btn btn-sm btn-secondary printStock" data-id="' . $row->stock_id . '">
        <i class="bx bx-printer"></i>
    </button>

    <button class="btn btn-sm btn-warning editStock d-none" data-id="' . $row->stock_id . '" title="Edit"> <i class="bx bx-edit"></i> </button>
</div>';

            // ✅ Only location_to staff can update status
            if (
                $row->stock_status != 2 &&
                in_array($row->location_to, $accessLocations)
            ) {

                $action .= '
    <div class="d-flex gap-1 justify-content-center">

        <button class="btn btn-sm btn-success receivedStock"
            data-id="' . $row->stock_id . '">
            <i class="bx bx-check-circle"></i>
        </button>

        <button class="btn btn-sm btn-danger rejectStock"
            data-id="' . $row->stock_id . '">
            <i class="bx bx-trash"></i>
        </button>



    </div>';
            }
            $canUpdateStatus = in_array($row->location_to, $accessLocations) && $row->stock_status != 2;
            $stockStatus = match ($row->stock_status) {

                // ✅ Pending
                0 => $canUpdateStatus
                    ? '<span class="badge bg-warning stockStatusBtn"
                data-id="' . $row->stock_id . '"
                data-status="0"
                style="cursor:pointer;">Pending</span>'
                    : '<span class="badge bg-warning">Pending</span>',

                // ✅ In-Transit
                1 => $canUpdateStatus
                    ? '<span class="badge bg-info stockStatusBtn"
                data-id="' . $row->stock_id . '"
                data-status="1"
                style="cursor:pointer;">In-Transit</span>'
                    : '<span class="badge bg-info">In-Transit</span>',

                // ✅ Completed (Never Clickable)
                2 => '<span class="badge bg-success">Completed</span>',

                default => '<span class="badge bg-secondary">-</span>',
            };

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'reference_no' => '#' . e($row->reference_no),
                'transfer_date' => $row->transfer_date
                    ? \Carbon\Carbon::parse($row->transfer_date)->format('d-m-Y')
                    : '-',
                'location_from' => $row->fromLocation->name ?? '-',
                'location_to' => $row->toLocation->name ?? '-',
                'shipping_charges' => e($row->shipping_charges),
                'total' => e($row->total),
                'stock_status' => $stockStatus,
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $formattedData,
        ]);
    }

    // Reject Transfer
    public function reject(Request $request)
    {
        DB::beginTransaction();

        try {

            $stockId = $request->stock_id;

            $stock = StockTransferModel::where('stock_id', $stockId)->first();

            if (!$stock) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stock Transfer not found!',
                ]);
            }

            $fromLocation = DB::table('tbl_bussiness_location')
                ->where('bl_id', $stock->location_from)
                ->first();

            $toLocation = DB::table('tbl_bussiness_location')
                ->where('bl_id', $stock->location_to)
                ->first();

            // delete child rows first
            StockMultiProductModel::where('stock_id', $stockId)->delete();

            // delete main row
            StockTransferModel::where('stock_id', $stockId)->delete();

            // ✅ Activity Log
            activity_log(
                'stock',
                'stock_transfer',
                json_encode([
                    'stock_id' => $stockId,
                    'status'   => 'Stock Rejected',
                ]),
                current_user_id()
            );

            /* ==========================
           EMAIL NOTIFICATION
        ========================== */
            if (set_smtp_config()) {

                $body = view('emails.stock_transfer', [
                    'stock'        => $stock,
                    'fromLocation' => $fromLocation,
                    'toLocation'   => $toLocation
                ])->render();

                $extraEmails = [];

                // notify TO location
                if (!empty($toLocation->email)) {
                    $extraEmails[] = $toLocation->email;
                }

                // notify FROM location
                if (!empty($fromLocation->email)) {
                    $extraEmails[] = $fromLocation->email;
                }

                send_multi_recipient_mail(
                    'Stock Transfer Rejected - Ref #' . $stock->reference_no,
                    $body,
                    null,
                    [],
                    $extraEmails
                );
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Stock rejected successfully',
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }
}
