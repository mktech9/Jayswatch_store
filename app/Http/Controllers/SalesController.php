<?php

namespace App\Http\Controllers;

use App\Models\BusinesslocationModel;
use App\Models\ContactMaster;
use App\Models\Order;
use App\Models\ProductModel;
use App\Models\SalesModel;
use App\Models\SalesPaymentModel;
use App\Models\SalesProductModel;
use App\Models\TaxModel;
use App\Models\TCSModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SalesController extends Controller
{
    public function index()
    {
        $page_title = 'Sale Management';
        $customers = ContactMaster::where('status', '!=', 1)
            ->when(!all_admin(), function ($query) {
                $query->where('created_by', current_user_id());
            })
            ->orderBy('first_name', 'asc')
            ->get();

        $tcs_data = TCSModel::where('status', '!=', 1)
            ->orderBy('percentage', 'asc')
            ->get();

        $gst_data = TaxModel::where('status', '!=', 1)
            ->where('tax', 'gst')
            ->orderBy('t_id', 'asc')
            ->get();

        $payment_method = DB::table('tbl_payment_option')->where('status', 0)->get();
        $store_location = access_locations();

        return view('sales.index', compact('page_title', 'customers', 'tcs_data', 'gst_data', 'payment_method', 'store_location'));
    }

    public function getCustomerDetails(Request $request)
    {
        $contact = ContactMaster::where('contact_master_id', $request->id)->first();

        if ($contact) {
            $contact->file_url = null;

            if (! empty($contact->id_file_path)) {
                $contact->file_url = config('app.actual_url') . '/admin_assets/contact_documents/' . $contact->id_file_path;
            }

            return response()->json([
                'status' => 200,
                'data' => $contact,
            ]);
        }

        return response()->json(['status' => 404, 'message' => 'Customer not found']);
    }

    public function list(Request $request)
    {
        /* ================= ACCESS LOCATIONS ================= */

        $allowedLocations = access_locations()->pluck('bl_id')->toArray();
        $selectedLocation = $request->business_location;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        /* ================= TOTAL RECORDS ================= */
        $totalQuery = SalesModel::where('status', '!=', 1)
            ->where('sale_status', 0)
            ->where(function ($q) {
                $q->whereNull('bill_status')
                    ->orWhere('bill_status', '!=', 'Return');
            })
            ->whereIn('location', $allowedLocations);

        if (! empty($selectedLocation)) {
            $totalQuery->where('location', $selectedLocation);
        }

        if (! empty($startDate) && ! empty($endDate)) {
            $totalQuery->whereBetween('sale_date', [$startDate, $endDate]);
        }

        $totalData = $totalQuery->count();

        $limit = $request->input('length');
        $start = $request->input('start');

        /* ================= MAIN QUERY ================= */

        $query = SalesModel::select(
            'mst_sales.*',
            'mst_contact_master.first_name',
            'mst_contact_master.last_name',
            'mst_contact_master.business_name',
            'mst_contact_master.is_business',
            'tbl_bussiness_location.name as location_name'
        )
            ->leftJoin('mst_contact_master', 'mst_sales.customer_id', '=', 'mst_contact_master.contact_master_id')
            ->leftJoin('tbl_bussiness_location', 'mst_sales.location', '=', 'tbl_bussiness_location.bl_id')
            ->where('mst_sales.status', '!=', 1)
            ->where('mst_sales.sale_status', 0)
            ->where(function ($q) {
                $q->whereNull('mst_sales.bill_status')
                    ->orWhere('mst_sales.bill_status', '!=', 'Return');
            })

            // ✅ LOCATION FILTER
            ->whereIn('mst_sales.location', $allowedLocations);
        if (! empty($selectedLocation)) {
            $query->where('mst_sales.location', $selectedLocation);
        }

        if (! empty($startDate) && ! empty($endDate)) {
            $query->whereBetween('mst_sales.sale_date', [$startDate, $endDate]);
        }

        /* ================= SEARCH ================= */

        if (! empty($request->input('search.value'))) {

            $search = $request->input('search.value');

            $query->where(function ($q) use ($search) {
                $q->where('mst_sales.invoice_no', 'LIKE', "%{$search}%")
                    ->orWhere('mst_sales.full_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.business_name', 'LIKE', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();

        $sales = $query->offset($start)
            ->limit($limit)
            ->orderBy('mst_sales.sales_id', 'desc')
            ->get();

        /* ================= FORMAT DATA ================= */

        $data = [];
        $i = $start + 1;

        foreach ($sales as $row) {

            // ✅ Customer Name
            if ($row->is_business == 1) {

                $custName = $row->business_name;

                if (! empty($row->full_name)) {
                    $custName .= ' <br><small class="text-muted">(' . $row->full_name . ')</small>';
                }
            } else {
                $custName = $row->full_name ?: ($row->first_name . ' ' . $row->last_name);
            }

            // ✅ Actions
            $action = '
<div class="d-flex gap-2">
    <button class="btn btn-icon btn-sm btn-warning-light rounded-pill printSale"
        data-id="' . $row->sales_id . '" title="Print">
        <i class="bx bx-printer"></i>
    </button>

    <button class="btn btn-icon btn-sm btn-info-light rounded-pill view-sale"
        data-id="' . $row->sales_id . '" title="View">
        <i class="bx bx-show"></i>
    </button>';

            if (all_admin()) {
                $action .= '
    <button class="btn btn-icon btn-sm btn-primary-light rounded-pill editSales"
        data-id="' . $row->sales_id . '" title="Edit">
        <i class="bx bx-edit"></i>
    </button>

    <button class="btn btn-icon btn-sm btn-danger-light rounded-pill delete-sale"
        data-id="' . $row->sales_id . '" title="Delete">
        <i class="bx bx-trash"></i>
    </button>';
            }

            $action .= '</div>';

            $displayBillStatus = $row->bill_status ?? 'N/A';

            if ($row->bill_status === 'Paid' && $row->remaining_amount > 0) {
                $displayBillStatus = 'Partially Paid';
            }

            $data[] = [
                'sr_no' => $i++,
                'sale_date' => date('d-m-Y', strtotime($row->sale_date)),
                'invoice_no' => $row->invoice_no,
                'customer' => $custName,
                'location' => $row->location_name,
                'total' => indian_number_format($row->finalTotal, 2),
                'remain_amount' => indian_number_format($row->remaining_amount, 2),
                'bill_status' => '<span class="badge bg-light text-dark border">' . $displayBillStatus . '</span>',
                'action' => $action,
            ];
        }

        /* ================= RESPONSE ================= */

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $sale = SalesModel::select(
            'mst_sales.*',
            'tbl_bussiness_location.name as location_name',
            'tbl_bussiness_location.state as location_state',
            'mst_contact_master.first_name',
            'mst_contact_master.last_name',
            'mst_contact_master.business_name',
            'mst_contact_master.is_business',
            'mst_contact_master.state as customer_state'
        )
            ->leftJoin('tbl_bussiness_location', 'mst_sales.location', '=', 'tbl_bussiness_location.bl_id')
            ->leftJoin('mst_contact_master', 'mst_sales.customer_id', '=', 'mst_contact_master.contact_master_id')
            ->where('sales_id', $id)
            ->first();

        if ($sale) {

            // Customer name
            $sale->customer_name = $sale->is_business
                ? $sale->business_name
                : $sale->first_name . ' ' . $sale->last_name;

            $sale->sale_date = date('d-m-Y', strtotime($sale->sale_date));

            $sale->isSameState = ((int)$sale->customer_state === (int)$sale->location_state) ? 1 : 0;
            /* ================= PRODUCTS ================= */
            $products = SalesProductModel::select(
                'mst_sales_product.*',
                'mst_product.pro_name'
            )
                ->leftJoin('mst_product', 'mst_sales_product.product_id', '=', 'mst_product.pro_id')
                ->where('sales_id', $id)
                ->get();

            /* ================= PAYMENTS ================= */
            $payments = SalesPaymentModel::where('sales_id', $id)->get();

            return response()->json([
                'status' => 200,
                'data' => $sale,
                'products' => $products,
                'payments' => $payments,

            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Sale not found',
        ]);
    }

    public function edit($id)
    {
        $sale = SalesModel::where('sales_id', $id)->first();

        if (! $sale) {
            return response()->json([
                'status' => 404,
                'message' => 'Sale not found',
            ]);
        }

        // ✅ PRODUCTS
        $products = SalesProductModel::select(
            'mst_sales_product.*',
            'mst_product.pro_name',
            'mst_product.pro_image',
            'mst_brand.brand_name'
        )
            ->leftJoin('mst_product', 'mst_sales_product.product_id', '=', 'mst_product.pro_id')
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->where('sales_id', $id)
            ->get()
            ->map(function ($item) {
                $item->brand_folder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? '');
                $item->product_folder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->pro_name ?? '');
                return $item;
            });

        // ✅ NEW — FETCH SPLIT PAYMENTS
        $payments = SalesPaymentModel::where('sales_id', $id)->get();

        return response()->json([
            'status' => 200,
            'sale' => $sale,
            'products' => $products,
            'payments' => $payments, // ⭐ IMPORTANT
        ]);
    }

    public function store(Request $request)
    {

        // dd($request->final_total);
        $request->validate([
            'sales_id' => 'nullable|exists:mst_sales,sales_id',
            'location' => 'required',
            'customer_id' => 'required',
            'sale_date' => 'required',
            // 'invoice_no' => 'required|unique:mst_sales,invoice_no,' . $request->sales_id . ',sales_id',
            'product_id' => 'required|array|min:1',
            'final_total' => 'required',
        ], [
            'product_id.required' => 'Please add at least one product.',
            // 'invoice_no.unique' => 'This Invoice Number already exists.',
        ]);

        try {
            DB::beginTransaction();

            /* ----------------------------------
               FILE HANDLING (UNCHANGED)
            ----------------------------------*/
            $fileName = null;
            $salesPath = public_path('assets/admin_assets/sales_document');

            if (! File::exists($salesPath)) {
                File::makeDirectory($salesPath, 0777, true, true);
            }

            if ($request->hasFile('file_id')) {
                $file = $request->file('file_id');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($salesPath, $fileName);
            } elseif ($request->filled('existing_file_id')) {
                $existingName = $request->existing_file_id;
                $sourcePath = public_path('assets/admin_assets/contact_documents/' . $existingName);
                $destPath = $salesPath . '/' . $existingName;

                if (File::exists($sourcePath)) {
                    if (! File::exists($destPath)) {
                        File::copy($sourcePath, $destPath);
                    }
                    $fileName = $existingName;
                }
            }

            /* ----------------------------------
               ADD OR UPDATE SALE
            ----------------------------------*/
            if ($request->filled('sales_id')) {

                // 🔁 UPDATE
                $sale = SalesModel::findOrFail($request->sales_id);

                $sale->update([
                    'location' => $request->location,
                    'customer_id' => $request->customer_id,
                    'sale_date' => $request->sale_date,
                    'invoice_no' => $request->invoice_no,
                    'full_name' => $request->full_name ?? '',
                    'mobile_no' => $request->mobile_no ?? 0,
                    'email' => $request->email ?? '',
                    'id_no' => $request->id_no,
                    'file_id' => $fileName ?? $sale->file_id,
                    'id_proof' => $request->id_proof,
                    'bill_status' => $request->bill_status,
                    'discount' => $request->discount ?? 0,
                    'gst_applicable' => $request->gst_applicable,
                    'gst_number' => $request->gst_number,
                    'gst_amount' => $request->gst_amount ?? 0,
                    'gst_display' => $request->gst_display ?? 0,
                    'tcs_display' => $request->tcs_display ?? 0,
                    'tcs_percentage' => $request->tcs_percentage ?? 0,
                    'payment_split_amount' => $request->payment_split_amount ?? 0,
                    'remaining_amount' => $request->remaining_amount ?? 0,
                    'finalTotal' => $request->final_total,
                    'updated_by' => current_user_id(),
                ]);

                $oldProductIds = SalesProductModel::where('sales_id', $sale->sales_id)
                    ->pluck('product_id')
                    ->toArray();

                // ✅ Restore removed old products stock
                ProductModel::whereIn('pro_id', $oldProductIds)
                    ->update([
                        'out_stock' => 0,
                        'quantity' => 1,
                    ]);

                // 🔥 Remove old products
                SalesProductModel::where('sales_id', $sale->sales_id)->delete();
                if ($request->is_split_payment == 0) {

                    SalesPaymentModel::where('sales_id', $sale->sales_id)->delete();
                }
            } else {

                // ➕ ADD
                $sale = SalesModel::create([
                    'location' => $request->location,
                    'customer_id' => $request->customer_id,
                    'sale_date' => $request->sale_date,
                    'invoice_no' => $request->invoice_no,
                    'full_name' => $request->full_name ?? '',
                    'mobile_no' => $request->mobile_no ?? 0,
                    'email' => $request->email ?? '',
                    'id_no' => $request->id_no,
                    'file_id' => $fileName,
                    'id_proof' => $request->id_proof,
                    'bill_status' => $request->bill_status,
                    'discount' => $request->discount ?? 0,
                    'gst_applicable' => $request->gst_applicable,
                    'gst_number' => $request->gst_number,
                    'gst_display' => $request->gst_display ?? 0,
                    'gst_amount' => $request->gst_amount ?? 0,
                    'tcs_display' => $request->tcs_display ?? 0,
                    'tcs_percentage' => $request->tcs_percentage ?? 0,
                    'payment_split_amount' => $request->payment_split_amount ?? 0,
                    'remaining_amount' => $request->remaining_amount ?? 0,
                    'finalTotal' => $request->final_total,
                    'sale_status' => current_user_id() === -1 ? 0 : 1,
                    'status' => 0,
                    'created_by' => current_user_id(),
                ]);

                if (current_user_id() === -1) {

                    $hoLocation = DB::table('tbl_bussiness_location')
                        ->where('location_id', 'HO')
                        ->value('bl_id');

                    if ($hoLocation && !empty($request->product_id)) {

                        DB::table('mst_product')
                            ->whereIn('pro_id', $request->product_id)
                            ->update([
                                'display_location'  => $hoLocation,
                                'physical_location' => $hoLocation,
                            ]);
                    }
                }

                if (set_smtp_config()) {

                    $customer = ContactMaster::find($request->customer_id);
                    $location = BusinesslocationModel::find($request->location);

                    $body = view('emails.sales_created', [
                        'sale' => (object) [
                            'customer_name' => $customer->first_name ?? $request->full_name,
                            'mobile_no' => $request->mobile_no ?? $customer->mobile_no ?? '-',
                            'email' => $request->email ?? $customer->email ?? '-',
                            'location_name' => $location->name ?? '-',
                            'sale_date' => $request->sale_date,
                            'invoice_no' => $request->invoice_no,
                            'final_total' => $request->final_total,
                            'bill_status' => $request->bill_status,
                        ]
                    ])->render();

                    send_multi_recipient_mail(
                        'New Sale Created - ' . $request->invoice_no,
                        $body
                    );
                }
            }

            if ($request->is_split_payment == 1 && ! empty($request->payment_split)) {

                $totalPaid = 0;

                // ✅ collect incoming payment ids
                $incomingIds = [];

                foreach ($request->payment_split as $split) {

                    $amount = floatval($split['amount'] ?? 0);
                    $totalPaid += $amount;

                    $data = [
                        'sales_id' => $sale->sales_id,
                        'payment_id' => $split['method'],
                        'transaction_no' => $split['transaction_no'] ?? null,
                        'bank_acc' => $split['bank_account_no'] ?? null,
                        'card_no' => $split['card_no'] ?? null,
                        'cheque_no' => $split['cheque_no'] ?? null,
                        'recieved_amount' => $amount,
                        'remain_amount' => 0,
                        'total_amount' => $request->final_total ?? 0,
                        'payment_date' => $request->sale_date,
                        'status' => 0,
                    ];

                    /* ===============================
                       ✅ UPDATE OR INSERT
                    =============================== */

                    if (! empty($split['payment_id'])) {

                        // UPDATE existing row
                        SalesPaymentModel::where('sp_id', $split['payment_id'])
                            ->update($data);

                        $incomingIds[] = $split['payment_id'];
                    } else {

                        // INSERT new row
                        $payment = SalesPaymentModel::create(
                            $data + [
                                'created_by' => current_user_id(),
                                'created_at' => now(),
                            ]
                        );

                        $incomingIds[] = $payment->sp_id;
                    }
                }

                /* ===============================
                   ✅ DELETE REMOVED PAYMENTS
                =============================== */

                SalesPaymentModel::where('sales_id', $sale->sales_id)
                    ->whereNotIn('sp_id', $incomingIds)
                    ->delete();

                /* ===============================
                   ✅ UPDATE SALE TOTALS
                =============================== */

                $remaining = ($request->final_total ?? 0) - $totalPaid;

                $sale->update([
                    'payment_split_amount' => $totalPaid,
                    'remaining_amount' => $remaining,
                ]);
            }

            /* ----------------------------------
               INSERT PRODUCTS (COMMON)
            ----------------------------------*/
            $productIds = $request->product_id;
            $quantities = $request->qty;
            $unitPrices = $request->unit_price;
            $descriptions = $request->description;
            $hsnCodes = $request->hsn_code;

            $productData = ProductModel::whereIn('pro_id', $productIds)
                ->pluck('selling_price_exclusive', 'pro_id');

            foreach ($productIds as $key => $prodId) {

                $qty = $quantities[$key];
                $unitPrice = $unitPrices[$key];
                $rowTotal = $qty * $unitPrice;

                SalesProductModel::create([
                    'sales_id' => $sale->sales_id,
                    'product_id' => $prodId,
                    'description' => $descriptions[$key] ?? null,
                    'hsn_code' => $hsnCodes[$key] ?? null,
                    'qty' => $qty,
                    'mrp' => $productData[$prodId] ?? 0,
                    'sales_price' => $rowTotal,
                    'status' => 0,
                ]);
            }

            if ($request->bill_status === 'Return') {

                // 🔁 Return stock back
                ProductModel::whereIn('pro_id', $productIds)
                    ->update([
                        'out_stock' => 0,
                        'quantity' => 1,
                    ]);
            } else {

                // 🛒 Normal sale → stock out
                ProductModel::whereIn('pro_id', $productIds)
                    ->update([
                        'out_stock' => 1,
                        'quantity' => 0,
                    ]);
            }

            if ($request->bill_status === 'Return') {

                $sale->update([
                    'return_no' => generate_credit_no(),
                    'return_date' => now(),
                ]);
            }



            /* ----------------------------------
   ACTIVITY LOG
----------------------------------*/
            if ($request->filled('sales_id')) {

                activity_log(
                    'Sales',
                    'Update',
                    'Sale updated. Invoice No: ' . $sale->invoice_no,
                    current_user_id(),
                    0
                );
            } else {

                activity_log(
                    'Sales',
                    'Create',
                    'Sale created. Invoice No: ' . $sale->invoice_no,
                    current_user_id(),
                    0
                );

                // Admin auto approve log
                if (current_user_id() === -1) {
                    activity_log(
                        'Sales',
                        'Approve',
                        'Sale auto approved by admin. Invoice No: ' . $sale->invoice_no,
                        current_user_id(),
                        0
                    );
                } else {
                    activity_log(
                        'Sales',
                        'Pending',
                        'Sale created and sent for approval. Invoice No: ' . $sale->invoice_no,
                        current_user_id(),
                        0
                    );
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'redirect' => $request->bill_status === 'Return'
                    ? route('sales.return.index')
                    : route('sales.index'),
                'message' => $request->filled('sales_id')
                    ? 'Sale updated successfully!'
                    : 'Sale added successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        $sale = SalesModel::find($request->id);
        if ($sale) {
            $sale->status = 1;
            $sale->save();

            return response()->json(['status' => 200, 'message' => 'Sale deleted successfully']);
        }

        return response()->json(['status' => 404, 'message' => 'Sale not found']);
    }







    // public function generateInvoice(Request $request)
    // {
    //     /* -------------------------------
    //   EDIT MODE
    // --------------------------------*/
    //     if ($request->filled('sales_id')) {
    //         $sale = SalesModel::find($request->sales_id);

    //         if ($sale) {
    //             return response()->json([
    //                 'status' => 200,
    //                 'invoice_no' => $sale->invoice_no,
    //                 'mode' => 'edit',
    //             ]);
    //         }
    //     }

    //     /* -------------------------------
    //   ADD MODE
    // --------------------------------*/
    //     $locationId = $request->location_id;

    //     $location = BusinesslocationModel::where('bl_id', $locationId)->first();

    //     if (!$location) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => 'Invalid location',
    //         ]);
    //     }

    //     $prefix = strtoupper($location->location_id);
    //     $state  = (int) $location->state;

    //     // ✅ Selected sale date
    //     $saleDate = Carbon::parse($request->sale_date);

    //     /* -------------------------------
    //   FINANCIAL YEAR
    // --------------------------------*/
    //     if ($saleDate->month >= 4) {
    //         $fyStartDate = Carbon::create($saleDate->year, 4, 1);
    //         $fyEndDate   = Carbon::create($saleDate->year + 1, 3, 31);
    //         $fyStart     = $saleDate->year;
    //         $fyEnd       = $saleDate->year + 1;
    //     } else {
    //         $fyStartDate = Carbon::create($saleDate->year - 1, 4, 1);
    //         $fyEndDate   = Carbon::create($saleDate->year, 3, 31);
    //         $fyStart     = $saleDate->year - 1;
    //         $fyEnd       = $saleDate->year;
    //     }

    //     $financialYear = substr($fyStart, -2) . '-' . substr($fyEnd, -2);

    //     $nextNumber = 1;

    //     /* -------------------------------
    //   STATE 22 → GLOBAL SEQUENCE
    //   Example: HO/26-27/001
    // --------------------------------*/
    //     if ($state === 22) {

    //         $lastInvoice = SalesModel::join(
    //             'tbl_bussiness_location',
    //             'mst_sales.location',
    //             '=',
    //             'tbl_bussiness_location.bl_id'
    //         )
    //             ->where('tbl_bussiness_location.state', 22)
    //             ->whereBetween('mst_sales.sale_date', [
    //                 $fyStartDate->toDateString(),
    //                 $fyEndDate->toDateString()
    //             ])
    //             ->where('mst_sales.invoice_no', 'like', '%/' . $financialYear . '/%')
    //             ->orderBy('mst_sales.sales_id', 'desc')
    //             ->value('mst_sales.invoice_no');

    //         if ($lastInvoice) {
    //             preg_match('/\/(\d+)$/', $lastInvoice, $matches);
    //             $nextNumber = isset($matches[1]) ? ((int)$matches[1] + 1) : 1;
    //         }

    //         $seq = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    //         $invoiceNo = $prefix . '/' . $financialYear . '/' . $seq;
    //     }

    //     /* -------------------------------
    //   OTHER STATES → LOCATION WISE
    //   Example: PAHM/26-27/001
    // --------------------------------*/ else {

    //         $lastInvoice = SalesModel::where('location', $locationId)
    //             ->whereBetween('sale_date', [
    //                 $fyStartDate->toDateString(),
    //                 $fyEndDate->toDateString()
    //             ])
    //             ->where('invoice_no', 'like', $prefix . '/' . $financialYear . '/%')
    //             ->orderBy('sales_id', 'desc')
    //             ->value('invoice_no');

    //         if ($lastInvoice) {
    //             preg_match('/\/(\d+)$/', $lastInvoice, $matches);
    //             $nextNumber = isset($matches[1]) ? ((int)$matches[1] + 1) : 1;
    //         }

    //         $seq = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    //         $invoiceNo = $prefix . '/' . $financialYear . '/' . $seq;
    //     }

    //     return response()->json([
    //         'status' => 200,
    //         'invoice_no' => $invoiceNo,
    //         'mode' => 'add',
    //     ]);
    // }
    // ecom - sales


    public function generateInvoice(Request $request)
    {
        /* -------------------------------
       EDIT MODE
    --------------------------------*/
        if ($request->filled('sales_id')) {
            $sale = SalesModel::find($request->sales_id);

            if ($sale) {
                return response()->json([
                    'status' => 200,
                    'invoice_no' => $sale->invoice_no,
                    'mode' => 'edit',
                ]);
            }
        }

        /* -------------------------------
       LOCATION CHECK
    --------------------------------*/
        $locationId = $request->location_id;

        $location = BusinesslocationModel::where('bl_id', $locationId)->first();

        if (!$location) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid location',
            ]);
        }

        $prefix = strtoupper($location->location_id);

        $saleDate = Carbon::parse($request->sale_date);

        /* -------------------------------
       FINANCIAL YEAR
    --------------------------------*/
        if ($saleDate->month >= 4) {
            $fyStartDate = Carbon::create($saleDate->year, 4, 1);
            $fyEndDate   = Carbon::create($saleDate->year + 1, 3, 31);
            $fyStart     = $saleDate->year;
            $fyEnd       = $saleDate->year + 1;
        } else {
            $fyStartDate = Carbon::create($saleDate->year - 1, 4, 1);
            $fyEndDate   = Carbon::create($saleDate->year, 3, 31);
            $fyStart     = $saleDate->year - 1;
            $fyEnd       = $saleDate->year;
        }

        $financialYear = substr($fyStart, -2) . '-' . substr($fyEnd, -2);

        /* -------------------------------
       UNIQUE LOCATION-WISE SEQUENCE
    --------------------------------*/
        $lastInvoice = SalesModel::where('location', $locationId)
            ->whereBetween('sale_date', [
                $fyStartDate->toDateString(),
                $fyEndDate->toDateString()
            ])
            ->where('invoice_no', 'like', $prefix . '/' . $financialYear . '/%')
            ->orderBy('sales_id', 'desc')
            // ->where('sale_status', '!=', 2)
            ->where('status', '=', 0)
            ->value('invoice_no');

        $nextNumber = 1;

        if ($lastInvoice) {
            preg_match('/\/(\d+)$/', $lastInvoice, $matches);
            $nextNumber = isset($matches[1]) ? ((int)$matches[1] + 1) : 1;
        }

        $seq = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $invoiceNo = $prefix . '/' . $financialYear . '/' . $seq;

        return response()->json([
            'status' => 200,
            'invoice_no' => $invoiceNo,
            'mode' => 'add',
        ]);
    }

    public function ecom_index()
    {
        $page_title = 'E-Com Sales';

        $rangedata = DB::table('tbl_ship_range')->where('status', 0)->get();

        return view('sales.ecom_sales', compact('page_title', 'rangedata'));
    }

    public function ecom_list(Request $request)
    {
        $query = DB::table('order')

            // ❌ Hide Cancelled
            ->where(function ($q) {

                $q->where('order_status', '!=', 'aborted')
                    ->orWhereNull('order_status')
                    ->orWhere('order_status', '');
            })

            // ❌ Hide Pending
            ->where(function ($q) {

                $q->whereNotNull('status')
                    ->where('status', '!=', '')
                    ->where('status', '!=', 0);
            });


        $loginType = Session::get('login_type');

        if ($loginType === 'staff') {

            $allowedStoreIds = access_locations()->pluck('bl_id')->toArray();

            if (!empty($allowedStoreIds)) {
                $query->where(function ($q) use ($allowedStoreIds) {
                    $q->whereNull('delivery_type')
                        ->orWhere('delivery_type', '!=', 'store_pickup')
                        ->orWhere(function ($sub) use ($allowedStoreIds) {
                            $sub->where('delivery_type', 'store_pickup')
                                ->whereIn('store_id', $allowedStoreIds);
                        });
                });
            } else {
                $query->where(function ($q) {
                    $q->whereNull('delivery_type')
                        ->orWhere('delivery_type', '!=', 'store_pickup');
                });
            }
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */
        if (!empty($request->status_filter) && $request->status_filter != 'all') {

            $status = $request->status_filter;

            if ($status == 'cancelled') {

                $query->where('order_status', 'aborted');
            } elseif ($status == 'prebook') {

                $query->whereRaw('LOWER(payment_method)=?', ['prebook'])
                    ->where(function ($q) {
                        $q->where('order_status', '!=', 'aborted')
                            ->orWhereNull('order_status')
                            ->orWhere('order_status', '');
                    });
            } elseif ($status == 'placed') {

                $query->where('status', 1)
                    ->whereRaw('LOWER(payment_method) != "prebook"')
                    ->where(function ($q) {
                        $q->where('order_status', '!=', 'aborted')
                            ->orWhereNull('order_status')
                            ->orWhere('order_status', '');
                    });
            } elseif ($status == 'transit') {

                $query->where('status', 2);
            } elseif ($status == 'pending') {

                $query->where(function ($q) {
                    $q->where('status', 0)
                        ->orWhereNull('status')
                        ->orWhere('status', '');
                })
                    ->where(function ($q) {
                        $q->where('order_status', '!=', 'aborted')
                            ->orWhereNull('order_status')
                            ->orWhere('order_status', '');
                    });
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if (! empty($request->input('search.value'))) {

            $search = $request->input('search.value');

            $query->where(function ($q) use ($search) {
                $q->where('invoice_num', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_first_name', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_last_name', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_email', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_phone', 'LIKE', "%{$search}%")
                    ->orWhere('order_id', 'LIKE', "%{$search}%");
            });
        }

        $totalData = $query->count();

        $limit = $request->input('length');
        $start = $request->input('start');

        $data = $query->orderBy('o_id', 'desc')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];

        foreach ($data as $row) {
            $isBombexDelivered = false; // 👈 ADD THIS
            $isBombexTransit = false;

            $isCancelled = strtolower($row->order_status) == 'aborted';
            $isPending = in_array($row->status, [0, '', null]);
            $isPrebook = strtolower($row->payment_method) == 'prebook';

            // 🔴 Cancelled
            if ($isCancelled) {

                $statusBadge = '<span class="badge bg-danger text-white">
                                Order Cancelled
                            </span>';

                // 🔵 Valid Prebook
            } elseif ($isPrebook) {

                $statusBadge = '<span class="badge bg-info text-dark prebook-status-btn"
                    data-oid="' . $row->o_id . '"
                    data-id="' . $row->order_id . '"
                    data-status="' . $row->status . '"
                    data-payment="' . $row->payment_method . '"
                    style="cursor:pointer;">
                    Pre-Booked
                </span>';

                // ✅ Show Store Pickup below
                if ($row->delivery_type == 'store_pickup') {

                    $statusBadge .= '
        <br>
        <span class="badge bg-dark mt-1" viewStorePickup"
        data-store="' . $row->store_id . '" style="cursor:pointer;">
            <i class="bi bi-shop me-1"></i> Store Pickup
        </span>
    ';
                }
            } elseif ($row->status == 1) {

                if ($row->delivery_type == 'store_pickup') {

                    $statusBadge = '
    <div class="d-flex flex-column align-items-start gap-1">

     <span class="badge bg-info text-dark delivered-btn"
     data-oid="' . $row->o_id . '"
            data-id="' . $row->order_id . '"
            data-status="' . $row->status . '"
            style="cursor:pointer;">
            Ready for Pickup
        </span>
        <span class="badge bg-dark" viewStorePickup"
        data-store="' . $row->store_id . '" style="cursor:pointer;">

            <i class="bi bi-shop me-1"></i> Store Pick Up
        </span>



    </div>
';
                } else {

                    $statusBadge = '<span class="badge bg-warning text-dark order-status-btn"
                            data-oid="' . $row->o_id . '"
                            data-id="' . $row->order_id . '"
                            data-status="' . $row->status . '"
                            style="cursor:pointer;">
                            Order Placed
                        </span>';
                }
            } elseif ($row->status == 2) {

                // Bombex Delivery
                if ($row->delivery_type == 'bombex') {

                    $tracking = $row->tracking_num;

                    // 🔥 Call Bombex API
                    $apiUrl = "https://eztrackwebapi159.softpal.in/V1/TrackingApiCommon_Softpal?ShipmentNo={$tracking}&HostId=24";

                    try {

                        $response = file_get_contents($apiUrl);
                        $apiData = json_decode($response, true);

                        $liveStatus = '<span class="badge rounded-pill bg-info-subtle text-info px-3 py-1">
        <i class="bx bx-loader-circle me-1"></i> In-Transit
    </span>'; // default

                        if (!empty($apiData['ConsignmentDetails_Traking']['current_status_name'])) {

                            $status = strtolower($apiData['ConsignmentDetails_Traking']['current_status_name']);

                            // ✅ Mapping logic
                            if (str_contains($status, 'transit')) {
                                $isBombexTransit = true;
                                $liveStatus = '<span class="badge rounded-pill bg-info-subtle text-info px-3 py-1">
        <i class="bx bx-loader-circle me-1"></i> In-Transit
    </span>';
                            } elseif (str_contains($status, 'out for delivery')) {
                                $isBombexTransit = true;
                                $liveStatus = '<span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-1">
        <i class="bx bx-cycling me-1"></i> Out For Delivery
    </span>';
                            } elseif (str_contains($status, 'pod')) {
                                $isBombexDelivered = true; // ✅ IMPORTANT
                                $liveStatus = '<span class="badge rounded-pill bg-success-subtle text-success px-3 py-1">
        <i class="bx bx-check-circle me-1"></i> Delivered
    </span>';
                            } else {
                                $liveStatus = '<span class="badge rounded-pill bg-secondary-subtle text-dark px-3 py-1">
        ' . ucfirst($status) . '
    </span>';
                            }
                        }
                    } catch (\Exception $e) {
                        $liveStatus = '<span class="text-danger">API Error</span>';
                    }

                    // 🔥 Final UI
                    $statusBadge = '
<div class="d-flex flex-column align-items-start gap-1">

  <span class="badge bg-primary bombex-track-btn"
    data-tracking="' . $row->tracking_num . '"
    data-order="' . $row->order_id . '"
    style="cursor:pointer;">
    Bombax
</span>

    <div>
        ' . $liveStatus . '
    </div>

</div>';
                } else {

                    // Internal Delivery
                    $statusBadge = '
                    <div class="d-flex flex-column align-items-start gap-1"><span class="badge bg-info text-dark assign-deliver"
                data-oid="' . $row->o_id . '"
                data-id="' . $row->order_id . '"
                data-status="' . $row->status . '"
                style="cursor:pointer;">
                In-Transit
            </span>
                <span class="badge rounded-pill bg-secondary-subtle text-success px-3 py-1">
        <i class="bx bx-user me-1"></i> Internal Delivery
    </span>
</div>';
                }
            } elseif ($row->status == 3) {

                $statusBadge = '
<div class="d-flex flex-column align-items-start gap-1">

    <span class="badge px-3 py-2 rounded-pill delivered-btn"
        data-oid="' . $row->o_id . '"
                data-id="' . $row->order_id . '"
                data-status="' . $row->status . '"
        style="background-color:#ffc107;color:#000;cursor:pointer;">
        Out For Delivery
    </span>

    <span class="badge rounded-pill bg-secondary-subtle text-success px-3 py-1">
        <i class="bx bx-user me-1"></i> Internal Delivery
    </span>

</div>';

                // ⚪ Pending
            } elseif ($row->status == 4) {

                $statusBadge = '
<div class="d-flex flex-column align-items-start gap-1">

    <span class="badge px-3 py-2 rounded-pill"
        data-oid="' . $row->o_id . '"
        data-id="' . $row->order_id . '"
        data-status="' . $row->status . '"
        style="background-color:#28a745;color:#fff;">
        Order Delivered
    </span>';

                // ✅ Store Pickup
                if ($row->delivery_type == 'store_pickup') {

                    $statusBadge .= '
    <span class="badge bg-dark viewStorePickup"
        data-store="' . $row->store_id . '" style="cursor:pointer;">
        <i class="bi bi-shop me-1"></i> Store Pick Up
    </span>
';
                } else {

                    // ✅ Internal Delivery
                    $statusBadge .= '
            <span class="badge rounded-pill bg-secondary-subtle text-success px-3 py-1">
                <i class="bx bx-user me-1"></i> Internal Delivery
            </span>
        ';
                }

                $statusBadge .= '</div>';
            } else {

                $statusBadge = '<span class="badge bg-secondary">
                                Pending
                            </span>';
            }

            /*
            |--------------------------------------------------------------------------
            | ACTION BUTTONS
            |--------------------------------------------------------------------------
            */

            $viewBtn = '<button class="btn btn-icon btn-sm btn-info-light rounded-pill viewEcomSale"
                            data-id="' . $row->o_id . '" title="View">
                            <i class="bx bx-show"></i>
                        </button>';

            $printBtn = '';

            // ❌ Hide Print for Pending & Cancelled
            if (! $isCancelled && (! $isPending || $isPrebook)) {

                $printBtn = '<button
                class="btn btn-icon btn-sm btn-primary-light rounded-pill invoice-btn"
                data-oid="' . e($row->o_id) . '"
                data-id="' . e($row->order_id) . '"
                title="Print">
                <i class="bx bx-printer"></i>
            </button>';
            }
            // 🔥 TRANSIT FILTER FINAL CONTROL
            if ($request->status_filter == 'transit') {

                $isNormalTransit = ($row->status == 2);
                $isNotCancelled = (
                    is_null($row->order_status) ||
                    $row->order_status == '' ||
                    strtolower($row->order_status) != 'aborted'
                );

                if (!($isNormalTransit || $isBombexTransit) || !$isNotCancelled || $isBombexDelivered) {
                    continue; // ❌ skip
                }
            }

            $action = '<div class="d-flex gap-2 justify-content-center">
                        ' . $viewBtn . '
                        ' . $printBtn . '
                   </div>';

            // ✅ FINAL FILTER LOGIC FOR COMPLETED
            if ($request->status_filter == 'completed') {

                $isNormalDelivered = ($row->status == 4);
                $isNotCancelled = (strtolower($row->order_status) != 'aborted');

                if (!($isNormalDelivered || $isBombexDelivered) || !$isNotCancelled) {
                    continue; // ❌ skip row
                }
            }

            $formattedData[] = [
                'order_id' => $row->order_id,
                'invoice_no' => $row->invoice_num ?? '-',
                'name' => $row->shipping_first_name . ' ' . $row->shipping_last_name,
                'mobile' => $row->shipping_phone ?? '-',
                'email' => $row->shipping_email ?? '-',
                'amount' => number_format((float) $row->grand_total, 2),
                'date' => date('d-m-Y H:i', strtotime($row->created_at)),
                'status' => $statusBadge,
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalData),
            'data' => $formattedData,
        ]);
    }


    public function getStorePickup($id)
    {
        $store = DB::table('tbl_bussiness_location')
            ->where('bl_id', $id)
            ->first();

        if ($store) {
            return response()->json([
                'status'  => 200,
                'name'    => $store->name,
                'address' => $store->address,
            ]);
        }

        return response()->json([
            'status'  => 404,
            'message' => 'Store not found'
        ]);
    }

    public function ecom_cancelled_pending_list(Request $request)
    {
        $query = DB::table('order')

            ->where(function ($q) {

                // 🔴 Cancelled Orders
                $q->where('order_status', 'aborted')

                    // ⚪ Pending Orders
                    ->orWhere(function ($x) {

                        $x->where(function ($y) {
                            $y->where('status', 0)
                                ->orWhereNull('status')
                                ->orWhere('status', '');
                        })

                            ->where(function ($y) {
                                $y->where('order_status', '!=', 'aborted')
                                    ->orWhereNull('order_status')
                                    ->orWhere('order_status', '');
                            });
                    });
            });

        /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

        if (!empty($request->input('search.value'))) {

            $search = $request->input('search.value');

            $query->where(function ($q) use ($search) {

                $q->where('invoice_num', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_first_name', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_last_name', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_email', 'LIKE', "%{$search}%")
                    ->orWhere('shipping_phone', 'LIKE', "%{$search}%")
                    ->orWhere('order_id', 'LIKE', "%{$search}%");
            });
        }

        $totalData = $query->count();

        $limit = $request->input('length');
        $start = $request->input('start');

        $data = $query->orderBy('o_id', 'desc')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];

        foreach ($data as $row) {

            $isCancelled = strtolower($row->order_status) == 'aborted';

            // 🔴 Cancelled Badge
            if ($isCancelled) {

                $statusBadge = '
                <span class="badge bg-danger text-white">
                    Order Cancelled
                </span>';
            }

            // ⚪ Pending Badge
            else {

                $statusBadge = '
                <span class="badge bg-secondary">
                    Pending
                </span>';
            }

            /*
        |--------------------------------------------------------------------------
        | ACTION BUTTONS
        |--------------------------------------------------------------------------
        */

            $viewBtn = '
            <button class="btn btn-icon btn-sm btn-info-light rounded-pill viewEcomSale"
                data-id="' . $row->o_id . '"
                title="View">
                <i class="bx bx-show"></i>
            </button>';

            $action = '
            <div class="d-flex gap-2 justify-content-center">
                ' . $viewBtn . '
            </div>';

            $formattedData[] = [

                'order_id' => $row->order_id,

                'invoice_no' => $row->invoice_num ?? '-',

                'name' => $row->shipping_first_name . ' ' . $row->shipping_last_name,

                'mobile' => $row->shipping_phone ?? '-',

                'email' => $row->shipping_email ?? '-',

                'amount' => number_format((float) $row->grand_total, 2),

                'date' => date('d-m-Y H:i', strtotime($row->created_at)),

                'status' => $statusBadge,

                'action' => $action,
            ];
        }

        return response()->json([

            'draw' => intval($request->input('draw')),

            'recordsTotal' => intval($totalData),

            'recordsFiltered' => intval($totalData),

            'data' => $formattedData,
        ]);
    }

    public function ecom_show($id)
    {
        $order = DB::table('order')->where('o_id', $id)->first();

        if ($order) {

            // ---------------- PAN ----------------
            $panDetails = null;

            if (!empty($order->pan_json)) {
                $panJson = json_decode($order->pan_json, true);

                if (!empty($panJson['data'])) {
                    $panDetails = [
                        'verified'   => true,
                        'full_name'  => $panJson['data']['full_name'] ?? '',
                        'pan_number' => $panJson['data']['pan_number'] ?? '',
                    ];
                }
            }

            // ---------------- DELIVERY ----------------
            // $deliveryDetails = null;

            // if (!empty($order->delivery_type)) {

            //     if ($order->delivery_type === 'internal') {
            //         $deliveryDetails = json_decode($order->delivery_details, true);
            //     }

            //     if ($order->delivery_type === 'bombex') {
            //         $deliveryDetails = [
            //             'tracking_num' => $order->tracking_num
            //         ];
            //     }
            // }

            // ---------------- DELIVERY ----------------
            $deliveryDetails = null;

            if (!empty($order->delivery_type)) {

                if ($order->delivery_type === 'internal') {
                    $deliveryDetails = json_decode($order->delivery_details, true);
                } elseif ($order->delivery_type === 'bombex') {
                    $deliveryDetails = [
                        'delivery_type' => 'bombex',
                        'tracking_num'  => $order->tracking_num
                    ];
                } else {
                    // store_pickup case: delivery_type contains bl_id
                    $store = DB::table('tbl_bussiness_location')
                        ->where('bl_id', $order->store_id)
                        ->first();

                    $deliveryDetails = [
                        'delivery_type' => 'store_pickup',
                        'store_id'      => $order->delivery_type,
                        'store_name'    => $store->name ?? '',
                        'store_address' => $store->address ?? '',
                    ];
                }
            }


            // ---------------- ITEMS ----------------
            $items = DB::table('order_items')
                ->where('order_id', $order->order_id)
                ->get();

            return response()->json([
                'status' => 200,
                'order' => $order,
                'items' => $items,
                'pan_details' => $panDetails,
                'delivery_details' => $deliveryDetails // ✅ correct now
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Order not found'
        ]);
    }

    public function invoiceprint($order_id)
    {
        // Fetch order with all related items
        $order = Order::with('items')->where('order_id', $order_id)->firstOrFail();

        // Fetch HSN Code from mst_product table for each item
        foreach ($order->items as $item) {
            $product = DB::table('mst_product')
                ->where('pro_id', $item->product_id)
                ->first();

            $item->hsn_code = $product->hsn_code ?? '-';
        }


        // Default TCS variables
        $tcsRate = 0;
        $tcsAmount = 0;

        // Apply TCS only if `tcs` field is not null or zero
        if (! empty($order->tcs) && $order->tcs > 0) {
            $tcsRate = (strtolower($order->shipping_citizen_type) === 'indian') ? 1 : 5;
            $tcsAmount = ($order->tcs * $tcsRate) / 100;
        }

        // Pass data to Blade
        $data = [
            'order' => $order,
            'items' => $order->items, // ✅ include items separately if needed
            'tcsRate' => $tcsRate,
            'tcsAmount' => $tcsAmount,
        ];

        $customerName = trim($order->shipping_first_name . ' ' . $order->shipping_last_name);
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $customerName); // make filename safe
        $pdfname = $order->order_id . '_' . $safeName . '.pdf';

        // Generate PDF
        $pdf = PDF::loadView('sales.ecom_print', $data);

        return $pdf->stream($pdfname);
    }

    // print invoice
    public function printInvoice($id)
    {
        /* ================= SALES ================= */
        $sales = SalesModel::where('sales_id', $id)->firstOrFail();

        /* ================= CUSTOMER ================= */
        $customer = ContactMaster::where(
            'contact_master_id',
            $sales->customer_id
        )->first();

        $sales->fullname = trim(
            ($customer->first_name ?? '') . ' ' .
                ($customer->middle_name ?? '') . ' ' .
                ($customer->last_name ?? '')
        );

        $sales->mobile_num = $customer->mobile
            ?? $customer->alternate_contact_number;

        $sales->email = $customer->email;

        if ($sales->is_business == 1) {
            $sales->gstnum = $customer->gst_number;
        }

        $sales->id_numbers = $customer->id_number;
        $sales->id_proof_type = $customer->id_proof_type;

        /* ================= SALE PRODUCTS ================= */
        $saleProducts = SalesProductModel::where('sales_id', $sales->sales_id)
            ->get()
            ->map(function ($item) {
                $product = ProductModel::where('pro_id', $item->product_id)->first();

                return (object) [
                    'product_name' => $product->pro_name ?? '-',
                    'description' => $item->description,
                    'hsn_code' => $item->hsn_code,
                    'per_total_price' => $item->sales_price,
                ];
            });

        /* ================= BUSINESS LOCATION ================= */
        $location = BusinesslocationModel::where(
            'bl_id',
            $sales->location
        )->first();


        $isSameState = ((int)($customer->state ?? 0) === (int)($location->state ?? 0));

        /* ================= CITY & STATE ================= */
        $city = DB::table('mst_city')
            ->where('id', $location->city)
            ->value('name');

        $state = DB::table('mst_state')
            ->where('id', $location->state)
            ->value('name');

        $place = $city . ', ' . $state;

        $gstNumber = $location->gst_number;
        $address = $location->address;

        /* ================= AMOUNTS ================= */
        $tcsAmount = $sales->tcs_display ?? 0;

        $netAmount = ($sales->is_business == 1)
            ? ($sales->finalTotal - $sales->gst_amount)
            : $sales->finalTotal;

        $netAmount -= $tcsAmount;
        $totalAmount = $sales->finalTotal;

        $salesPayments = DB::table('sales_payment')
            ->where('sales_id', $sales->sales_id)
            ->get();

        /* ================= PDF ================= */
        $pdf = Pdf::loadView('sales.sale_print', compact(
            'sales',
            'saleProducts',
            'place',
            'gstNumber',
            'address',
            'netAmount',
            'tcsAmount',
            'salesPayments',
            'location',
            'totalAmount',
            'isSameState' // ✅ added
        ));

        return $pdf->stream('Invoice-' . $sales->invoice_num . '.pdf');
    }

    public function storeWalkInCustomer(Request $request)
    {
        $currentUserId = current_user_id();
        $contactId = $request->contact_master_id;
        $contact = $contactId ? ContactMaster::findOrFail($contactId) : null;

        $basePath = public_path('/assets/admin_assets/contact_documents');
        if (! File::exists($basePath)) {
            File::makeDirectory($basePath, 0777, true, true);
        }

        // Standard inputs
        $data = $request->except(['id_file_path', '_token']);

        if ($request->date_of_birth) {
            $data['date_of_birth'] = date('Y-m-d', strtotime($request->date_of_birth));
        }

        // Handle FilePond Upload (if exists in form)
        if ($request->hasFile('id_file_path')) {
            $file = $request->file('id_file_path');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move($basePath, $filename);
            $data['id_file_path'] = $filename;
        }

        $data['updated_by'] = $currentUserId;

        if (! $contact) {
            $data['created_by'] = $currentUserId;
            // Default status or other fields if needed
            $contact = ContactMaster::create($data);
            $msg = 'Customer created successfully';
        } else {
            $contact->update($data);
            $msg = 'Customer updated successfully';
        }

        // ✅ RETURN RESPONSE WITH CUSTOMER ID
        return response()->json([
            'success' => true,
            'message' => $msg,
            'customer_id' => $contact->contact_master_id,
        ]);
    }

    // Sales Return

    public function sales_return_index()
    {
        $page_title = 'Sales Return List';

        return view('sales.sales_return', compact('page_title'));
    }

    public function sales_return_list(Request $request)
    {
        $totalData = SalesModel::where('status', '!=', 1)
            ->where('bill_status', 'Return')
            ->count();

        $limit = $request->input('length');
        $start = $request->input('start');

        $query = SalesModel::select(
            'mst_sales.*',
            'mst_contact_master.first_name',
            'mst_contact_master.last_name',
            'mst_contact_master.business_name',
            'mst_contact_master.is_business',
            'tbl_bussiness_location.name as location_name'
        )
            ->leftJoin('mst_contact_master', 'mst_sales.customer_id', '=', 'mst_contact_master.contact_master_id')
            ->leftJoin('tbl_bussiness_location', 'mst_sales.location', '=', 'tbl_bussiness_location.bl_id')
            ->where('mst_sales.status', '!=', 1)
            ->where('mst_sales.bill_status', 'Return');

        // Search Logic
        if (! empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('mst_sales.invoice_no', 'LIKE', "%{$search}%")
                    ->orWhere('mst_sales.full_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.business_name', 'LIKE', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();
        $sales = $query->offset($start)->limit($limit)->orderBy('mst_sales.return_date', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($sales as $row) {
            if ($row->is_business == 1) {
                $custName = $row->business_name;
                if (! empty($row->full_name)) {
                    $custName .= ' <br><small class="text-muted">(' . $row->full_name . ')</small>';
                }
            } else {
                $custName = $row->full_name ?: ($row->first_name . ' ' . $row->last_name);
            }

            // ✅ Action: Only Print & View
            $action = '
            <div class="d-flex gap-2 justify-content-center">
               <button class="btn btn-icon btn-sm btn-warning-light rounded-pill printSale"
                data-id="' . $row->sales_id . '" title="Print">
                <i class="bx bx-printer"></i>
            </button>
                <button class="btn btn-icon btn-sm btn-info-light rounded-pill view-sale" data-id="' . $row->sales_id . '" title="View"><i class="bx bx-show"></i></button>
            </div>';

            $data[] = [
                'sr_no' => $i++,
                'credit_no' => $row->return_no,
                'sale_date' => date('d-m-Y', strtotime($row->sale_date)),
                'return_date' => $row->return_date
                    ? date('d-m-Y', strtotime($row->return_date))
                    : '-',

                'invoice_no' => $row->invoice_no,
                'customer' => $custName,
                'location' => $row->location_name,
                'total' => indian_number_format($row->finalTotal, 2),
                // 'bill_status' removed as requested
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);
    }

    // Pending sales function
    public function pending_sales_index()
    {
        $page_title = 'Pending Sales';

        // Fetch required data for the Edit Form
        $customers = ContactMaster::where('status', '!=', 1)->orderBy('first_name', 'asc')->get();
        $tcs_data = TCSModel::where('status', '!=', 1)->orderBy('percentage', 'asc')->get();
        $gst_data = TaxModel::where('status', '!=', 1)
            ->where('tax', 'gst')
            ->orderBy('t_id', 'asc')
            ->get();
        $payment_method = DB::table('tbl_payment_option')->where('status', 0)->get();

        return view('sales.pending_sales', compact('page_title', 'customers', 'tcs_data', 'gst_data', 'payment_method'));
    }

    public function pending_sales_list(Request $request)
    {
        $totalData = SalesModel::where('status', '!=', 1)
            ->where('sale_status', 1)
            ->count();

        $limit = $request->input('length');
        $start = $request->input('start');

        $query = SalesModel::select(
            'mst_sales.*',
            'mst_contact_master.first_name',
            'mst_contact_master.last_name',
            'mst_contact_master.business_name',
            'mst_contact_master.is_business',
            'tbl_bussiness_location.name as location_name'
        )
            ->leftJoin('mst_contact_master', 'mst_sales.customer_id', '=', 'mst_contact_master.contact_master_id')
            ->leftJoin('tbl_bussiness_location', 'mst_sales.location', '=', 'tbl_bussiness_location.bl_id')
            ->where('mst_sales.status', '!=', 1)
            ->where('mst_sales.sale_status', 1);

        if (! empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('mst_sales.invoice_no', 'LIKE', "%{$search}%")
                    ->orWhere('mst_sales.full_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.business_name', 'LIKE', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();
        $sales = $query->offset($start)->limit($limit)->orderBy('sales_id', 'desc')->get();

        $data = [];
        $i = $start + 1;

        $isSuperAdmin = Session::get('login_type') === 'super_admin';

        foreach ($sales as $row) {
            if ($row->is_business == 1) {
                $custName = $row->business_name;
                if (! empty($row->full_name)) {
                    $custName .= ' <br><small class="text-muted">(' . $row->full_name . ')</small>';
                }
            } else {
                $custName = $row->full_name ?: ($row->first_name . ' ' . $row->last_name);
            }

            // ✅ Approve button only for Super Admin
            // ✅ Approve button only for Super Admin
            $approveBtn = '';
            $cancelBtn = '';
            $editBtn = '';
            $removeBtn = '';

            if (all_admin()) {
                $approveBtn = '
        <button class="btn btn-icon btn-sm btn-success-light rounded-pill approve-sale"
            data-id="' . $row->sales_id . '" title="Approve">
            <i class="bx bx-check"></i>
        </button>';

                $cancelBtn = '<button class="btn btn-icon btn-sm btn-secondary-light rounded-pill cancel-sale" data-id="' . $row->sales_id . '" title="Cancel">
                    <i class="bx bx-x-circle"></i>
                </button>';
                $editBtn = '  <button class="btn btn-icon btn-sm btn-primary-light rounded-pill editSales" data-id="' . $row->sales_id . '" title="Edit">
                    <i class="bx bx-edit"></i>
                </button>';

                $removeBtn = '<button class="btn btn-icon btn-sm btn-danger-light rounded-pill delete-sale" data-id="' . $row->sales_id . '" title="Delete">
                    <i class="bx bx-trash"></i>
                </button>';
            }

            // ✅ ACTIONS: Edit (In-Page), Approve, View, Print, Cancel, Delete
            $action = '
            <div class="d-flex gap-2 justify-content-center">
                ' . $approveBtn . '

            ' . $editBtn . '

                <button class="btn btn-icon btn-sm btn-info-light rounded-pill view-sale" data-id="' . $row->sales_id . '" title="View">
                    <i class="bx bx-show"></i>
                </button>

                <button class="btn btn-icon btn-sm btn-warning-light rounded-pill printSale" data-id="' . $row->sales_id . '" title="Print">
                    <i class="bx bx-printer"></i>
                </button>

                ' . $removeBtn . '

' . $cancelBtn . '


            </div>';

            $data[] = [
                'sr_no' => $i++,
                'sale_date' => date('d-m-Y', strtotime($row->sale_date)),
                'invoice_no' => $row->invoice_no,
                'customer' => $custName,
                'location' => $row->location_name,
                'total' => number_format($row->finalTotal, 2),
                'bill_status' => '<span class="badge bg-warning text-white">Pending</span>',
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);
    }

    // ✅ APPROVE SALE
    // public function approve_sale(Request $request)
    // {
    //     $sale = SalesModel::find($request->id);
    //     if ($sale) {
    //         $sale->sale_status = 0;
    //         $sale->save();

    //         return response()->json(['status' => 200, 'message' => 'Sale approved successfully']);
    //     }

    //     return response()->json(['status' => 404, 'message' => 'Sale not found']);
    // }

    public function approve_sale(Request $request)
    {
        $sale = SalesModel::find($request->id);

        if ($sale) {

            // Approve Sale
            $sale->sale_status = 0;
            $sale->save();

            // Get HO Location bl_id
            $hoLocation = DB::table('tbl_bussiness_location')
                ->where('location_id', 'HO')
                ->value('bl_id');

            if ($hoLocation) {

                // Get Product IDs from mst_sales_product
                $productIds = SalesProductModel::where('sales_id', $request->id)
                    ->pluck('product_id')
                    ->toArray();

                // Update mst_product table
                DB::table('mst_product')
                    ->whereIn('pro_id', $productIds)
                    ->update([
                        'display_location'  => $hoLocation,
                        'physical_location' => $hoLocation,
                    ]);
            }

            activity_log(
                'Sales',
                'Approve',
                'Sale approved successfully. Invoice No: ' . $sale->invoice_no,
                current_user_id(),
                0
            );

            return response()->json([
                'status' => 200,
                'message' => 'Sale approved successfully'
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Sale not found'
        ]);
    }

    public function editPending($id)
    {
        // Fetch the sale (Pending Only)
        $sale = SalesModel::where('sales_id', $id)->where('sale_status', 1)->first();

        if (! $sale) {
            return response()->json([
                'status' => 404,
                'message' => 'Pending Sale not found',
            ]);
        }

        // Fetch Products with details
        $products = SalesProductModel::select(
            'mst_sales_product.*',
            'mst_product.pro_name',
            'mst_product.pro_image',
            'mst_brand.brand_name'
        )
            ->leftJoin('mst_product', 'mst_sales_product.product_id', '=', 'mst_product.pro_id')
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->where('sales_id', $id)
            ->get();

        return response()->json([
            'status' => 200,
            'sale' => $sale,
            'products' => $products,
        ]);
    }

    public function updatePending(Request $request)
    {


        // dd($request->final_total);
        $request->validate([
            'sales_id' => 'nullable|exists:mst_sales,sales_id',
            'location' => 'required',
            'customer_id' => 'required',
            'sale_date' => 'required',
            // 'invoice_no' => 'required|unique:mst_sales,invoice_no,' . $request->sales_id . ',sales_id',
            'product_id' => 'required|array|min:1',
            'final_total' => 'required',
        ], [
            'product_id.required' => 'Please add at least one product.',
            // 'invoice_no.unique' => 'This Invoice Number already exists.',
        ]);

        try {
            DB::beginTransaction();

            /* ----------------------------------
               FILE HANDLING (UNCHANGED)
            ----------------------------------*/
            $fileName = null;
            $salesPath = public_path('assets/admin_assets/sales_document');

            if (! File::exists($salesPath)) {
                File::makeDirectory($salesPath, 0777, true, true);
            }

            if ($request->hasFile('file_id')) {
                $file = $request->file('file_id');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($salesPath, $fileName);
            } elseif ($request->filled('existing_file_id')) {
                $existingName = $request->existing_file_id;
                $sourcePath = public_path('assets/admin_assets/contact_documents/' . $existingName);
                $destPath = $salesPath . '/' . $existingName;

                if (File::exists($sourcePath)) {
                    if (! File::exists($destPath)) {
                        File::copy($sourcePath, $destPath);
                    }
                    $fileName = $existingName;
                }
            }

            /* ----------------------------------
               ADD OR UPDATE SALE
            ----------------------------------*/
            if ($request->filled('sales_id')) {

                // 🔁 UPDATE
                $sale = SalesModel::findOrFail($request->sales_id);

                $sale->update([
                    'location' => $request->location,
                    'customer_id' => $request->customer_id,
                    'sale_date' => $request->sale_date,
                    'invoice_no' => $request->invoice_no,
                    'full_name' => $request->full_name ?? '',
                    'mobile_no' => $request->mobile_no ?? 0,
                    'email' => $request->email ?? '',
                    'id_no' => $request->id_no,
                    'file_id' => $fileName ?? $sale->file_id,
                    'id_proof' => $request->id_proof,
                    'bill_status' => $request->bill_status,
                    'discount' => $request->discount ?? 0,
                    'gst_applicable' => $request->gst_applicable,
                    'gst_number' => $request->gst_number,
                    'gst_amount' => $request->gst_amount ?? 0,
                    'gst_display' => $request->gst_display ?? 0,
                    'tcs_display' => $request->tcs_display ?? 0,
                    'tcs_percentage' => $request->tcs_percentage ?? 0,
                    'payment_split_amount' => $request->payment_split_amount ?? 0,
                    'remaining_amount' => $request->remaining_amount ?? 0,
                    'finalTotal' => $request->final_total,
                    'updated_by' => current_user_id(),
                ]);

                $oldProductIds = SalesProductModel::where('sales_id', $sale->sales_id)
                    ->pluck('product_id')
                    ->toArray();

                // ✅ Restore removed old products stock
                ProductModel::whereIn('pro_id', $oldProductIds)
                    ->update([
                        'out_stock' => 0,
                        'quantity' => 1,
                    ]);

                // 🔥 Remove old products
                SalesProductModel::where('sales_id', $sale->sales_id)->delete();
                if ($request->is_split_payment == 0) {

                    SalesPaymentModel::where('sales_id', $sale->sales_id)->delete();
                }
            } else {

                // ➕ ADD
                $sale = SalesModel::create([
                    'location' => $request->location,
                    'customer_id' => $request->customer_id,
                    'sale_date' => $request->sale_date,
                    'invoice_no' => $request->invoice_no,
                    'full_name' => $request->full_name ?? '',
                    'mobile_no' => $request->mobile_no ?? 0,
                    'email' => $request->email ?? '',
                    'id_no' => $request->id_no,
                    'file_id' => $fileName,
                    'id_proof' => $request->id_proof,
                    'bill_status' => $request->bill_status,
                    'discount' => $request->discount ?? 0,
                    'gst_applicable' => $request->gst_applicable,
                    'gst_number' => $request->gst_number,
                    'gst_display' => $request->gst_display ?? 0,
                    'gst_amount' => $request->gst_amount ?? 0,
                    'tcs_display' => $request->tcs_display ?? 0,
                    'tcs_percentage' => $request->tcs_percentage ?? 0,
                    'payment_split_amount' => $request->payment_split_amount ?? 0,
                    'remaining_amount' => $request->remaining_amount ?? 0,
                    'finalTotal' => $request->final_total,
                    'sale_status' => current_user_id() === -1 ? 0 : 1,
                    'status' => 0,
                    'created_by' => current_user_id(),
                ]);

                // if (set_smtp_config()) {

                //     $customer = ContactMaster::find($request->customer_id);
                //     $location = BusinesslocationModel::find($request->location);

                //     $body = view('emails.sales_created', [
                //         'sale' => (object) [
                //             'customer_name' => $customer->first_name ?? $request->full_name,
                //             'mobile_no' => $request->mobile_no ?? $customer->mobile_no ?? '-',
                //             'email' => $request->email ?? $customer->email ?? '-',
                //             'location_name' => $location->name ?? '-',
                //             'sale_date' => $request->sale_date,
                //             'invoice_no' => $request->invoice_no,
                //             'final_total' => $request->final_total,
                //             'bill_status' => $request->bill_status,
                //         ]
                //     ])->render();

                //     send_multi_recipient_mail(
                //         'New Sale Created - ' . $request->invoice_no,
                //         $body
                //     );
                // }
            }

            if ($request->is_split_payment == 1 && ! empty($request->payment_split)) {

                $totalPaid = 0;

                // ✅ collect incoming payment ids
                $incomingIds = [];

                foreach ($request->payment_split as $split) {

                    $amount = floatval($split['amount'] ?? 0);
                    $totalPaid += $amount;

                    $data = [
                        'sales_id' => $sale->sales_id,
                        'payment_id' => $split['method'],
                        'transaction_no' => $split['transaction_no'] ?? null,
                        'bank_acc' => $split['bank_account_no'] ?? null,
                        'card_no' => $split['card_no'] ?? null,
                        'cheque_no' => $split['cheque_no'] ?? null,
                        'recieved_amount' => $amount,
                        'remain_amount' => 0,
                        'total_amount' => $request->final_total ?? 0,
                        'payment_date' => $request->sale_date,
                        'status' => 0,
                    ];

                    /* ===============================
                       ✅ UPDATE OR INSERT
                    =============================== */

                    if (! empty($split['payment_id'])) {

                        // UPDATE existing row
                        SalesPaymentModel::where('sp_id', $split['payment_id'])
                            ->update($data);

                        $incomingIds[] = $split['payment_id'];
                    } else {

                        // INSERT new row
                        $payment = SalesPaymentModel::create(
                            $data + [
                                'created_by' => current_user_id(),
                                'created_at' => now(),
                            ]
                        );

                        $incomingIds[] = $payment->sp_id;
                    }
                }

                /* ===============================
                   ✅ DELETE REMOVED PAYMENTS
                =============================== */

                SalesPaymentModel::where('sales_id', $sale->sales_id)
                    ->whereNotIn('sp_id', $incomingIds)
                    ->delete();

                /* ===============================
                   ✅ UPDATE SALE TOTALS
                =============================== */

                $remaining = ($request->final_total ?? 0) - $totalPaid;

                $sale->update([
                    'payment_split_amount' => $totalPaid,
                    'remaining_amount' => $remaining,
                ]);
            }

            /* ----------------------------------
               INSERT PRODUCTS (COMMON)
            ----------------------------------*/
            $productIds = $request->product_id;
            $quantities = $request->qty;
            $unitPrices = $request->unit_price;
            $descriptions = $request->description;
            $hsnCodes = $request->hsn_code;

            $productData = ProductModel::whereIn('pro_id', $productIds)
                ->pluck('selling_price_exclusive', 'pro_id');

            foreach ($productIds as $key => $prodId) {

                $qty = $quantities[$key];
                $unitPrice = $unitPrices[$key];
                $rowTotal = $qty * $unitPrice;

                SalesProductModel::create([
                    'sales_id' => $sale->sales_id,
                    'product_id' => $prodId,
                    'description' => $descriptions[$key] ?? null,
                    'hsn_code' => $hsnCodes[$key] ?? null,
                    'qty' => $qty,
                    'mrp' => $productData[$prodId] ?? 0,
                    'sales_price' => $rowTotal,
                    'status' => 0,
                ]);
            }

            if ($request->bill_status === 'Return') {

                // 🔁 Return stock back
                ProductModel::whereIn('pro_id', $productIds)
                    ->update([
                        'out_stock' => 0,
                        'quantity' => 1,
                    ]);
            } else {

                // 🛒 Normal sale → stock out
                ProductModel::whereIn('pro_id', $productIds)
                    ->update([
                        'out_stock' => 1,
                        'quantity' => 0,
                    ]);
            }

            if ($request->bill_status === 'Return') {

                $sale->update([
                    'return_no' => generate_credit_no(),
                    'return_date' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'redirect' => $request->bill_status === 'Return'
                    ? route('sales.return.index')
                    : route('sales.pending.index'),
                'message' => $request->filled('sales_id')
                    ? 'Sale updated successfully!'
                    : 'Sale added successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function cancel_sale(Request $request)
    {
        try {

            DB::beginTransaction();

            $sale = SalesModel::find($request->id);

            if (! $sale) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Sale not found',
                ]);
            }

            $productIds = SalesProductModel::where('sales_id', $sale->sales_id)
                ->pluck('product_id')
                ->toArray();

            if (! empty($productIds)) {

                ProductModel::whereIn('pro_id', $productIds)
                    ->update([
                        'out_stock' => 0,
                        'quantity' => 1,
                    ]);
            }

            $sale->update([
                'sale_status' => 2,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Sale cancelled and stock restored successfully',
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete_sale(Request $request)
    {
        $sale = SalesModel::find($request->id);
        if ($sale) {
            $sale->status = 1;
            $sale->save();

            return response()->json(['status' => 200, 'message' => 'Sale deleted successfully']);
        }

        return response()->json(['status' => 404, 'message' => 'Sale not found']);
    }

    // Cancel sales

    public function cancel_sales_index()
    {
        $page_title = 'Cancelled Sales List';

        return view('sales.cancel_sales', compact('page_title'));
    }

    public function cancel_sales_list(Request $request)
    {
        // Filter: status != 1 (Active) AND sale_status = 2 (Cancelled)
        $totalData = SalesModel::where('status', '!=', 1)
            ->where('sale_status', 2)
            ->count();

        $limit = $request->input('length');
        $start = $request->input('start');

        $query = SalesModel::select(
            'mst_sales.*',
            'mst_contact_master.first_name',
            'mst_contact_master.last_name',
            'mst_contact_master.business_name',
            'mst_contact_master.is_business',
            'tbl_bussiness_location.name as location_name'
        )
            ->leftJoin('mst_contact_master', 'mst_sales.customer_id', '=', 'mst_contact_master.contact_master_id')
            ->leftJoin('tbl_bussiness_location', 'mst_sales.location', '=', 'tbl_bussiness_location.bl_id')
            ->where('mst_sales.status', '!=', 1)
            ->where('mst_sales.sale_status', 2); // ✅ ONLY CANCELLED

        // Search Logic
        if (! empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('mst_sales.invoice_no', 'LIKE', "%{$search}%")
                    ->orWhere('mst_sales.full_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_contact_master.business_name', 'LIKE', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();
        $sales = $query->offset($start)->limit($limit)->orderBy('sales_id', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($sales as $row) {
            // Name Logic
            if ($row->is_business == 1) {
                $custName = $row->business_name;
                if (! empty($row->full_name)) {
                    $custName .= ' <br><small class="text-muted">(' . $row->full_name . ')</small>';
                }
            } else {
                $custName = $row->full_name ?: ($row->first_name . ' ' . $row->last_name);
            }

            // ✅ Action: Print & View (Matches Sales Return)
            $action = '
            <div class="d-flex gap-2 justify-content-center">
               <button class="btn btn-icon btn-sm btn-warning-light rounded-pill printSale"
                data-id="' . $row->sales_id . '" title="Print">
                <i class="bx bx-printer"></i>
            </button>
                <button class="btn btn-icon btn-sm btn-info-light rounded-pill view-sale" data-id="' . $row->sales_id . '" title="View"><i class="bx bx-show"></i></button>
            </div>';

            $data[] = [
                'sr_no' => $i++,
                'sale_date' => date('d-m-Y', strtotime($row->sale_date)),
                'invoice_no' => $row->invoice_no,
                'customer' => $custName,
                'location' => $row->location_name,
                'total' => number_format($row->finalTotal, 2),
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);
    }

    // Order COnfirmation
    public function confirmFullPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'o_id' => 'required',
        ]);

        $order = Order::where('order_id', $request->order_id)
            ->where('o_id', $request->o_id)
            ->first();



        if (! $order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found']);
        }

        // Update payment details
        $order->payment_method = 'fullpayment';
        $order->total = $order->grand_total;
        $order->save();

        // Fetch user
        $user = UserModel::where('user_id', $order->user_id)->first();

        // Fetch ordered items
        $orderItems = DB::table('order_items as oi')
            ->join('mst_product as p', 'oi.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            // ->leftJoin('variations as v', 'p.id', '=', 'v.product_id')
            ->select(
                'oi.quantity',
                'p.pro_name as product_name',
                'p.pro_image as product_image',
                'b.brand_name as brand_name',
                'p.selling_price_exclusive as price'
            )
            ->where('oi.order_id', $order->order_id)
            ->get();

        // Email data
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
            'message' => 'Your Full Payment is completed.',
        ];

        // Generate PDF
        $pdf = PDF::loadView('order_sales.invoiceprint', [
            'order' => $order,
            'items' => $orderItems,
        ]);

        // Safe file name
        $customerName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $customerName);
        $pdfFileName = $order->order_id . '_' . $safeName . '.pdf';
        $pdfPath = storage_path('app/public/invoices/' . $pdfFileName);

        // Ensure directory exists
        if (! file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0755, true);
        }

        // Save PDF
        $pdf->save($pdfPath);

        set_smtp_config();

        // Send email
        try {
            if (! empty($user->email)) {
                Mail::send('frontend.emails.order_email', ['data' => $emailData], function ($message) use ($user, $pdfPath, $pdfFileName) {
                    $message->to($user->email)
                        ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                        ->subject('Full Payment Completed - Jay\'s Watch Store')
                        ->attach($pdfPath, [
                            'as' => $pdfFileName,
                            'mime' => 'application/pdf',
                        ]);
                });
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mail sending failed',
                'error' => $e->getMessage(),  // << shows exact reason
            ]);
        }

        // Delete temporary PDF
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }



        try {

            send_whatsapp_template([

                'sender_whatsapp_number' => $order->shipping_phone ?? '',

                'template_name' => 'invoice',

                'broadcast_name' => 'test_broadcast',

                'url' => '',

                'parameter_value1' => $customerName,

            ]);
        } catch (\Exception $e) {

            // Silent ignore

        }
        return response()->json([
            'status' => 'success',
            'message' => 'Full payment confirmed and invoice emailed successfully.',
        ]);
    }

    // tracking number
    // public function updateTracking(Request $request)
    // {
    //     dd($request->all());
    //     $request->validate([
    //         'order_id' => 'required',
    //         'o_id' => 'required',
    //         'tracking_number' => 'required|string|max:255',
    //     ]);

    //     // Find the order by order_id and o_id
    //     $order = Order::where('order_id', $request->order_id)
    //         ->where('o_id', $request->o_id)
    //         ->first();

    //     if ($order) {
    //         $order->tracking_num = $request->tracking_number;
    //         $order->status = 2; // Order Shipped
    //         $order->save();

    //         // Check if shipping email exists
    //         if (! empty($order->shipping_email)) {
    //             $data = [
    //                 'order_id' => $order->order_id,
    //                 'tracking_number' => $order->tracking_num,
    //                 'first_name' => $order->shipping_first_name,
    //                 'last_name' => $order->shipping_last_name,
    //                 'order_date' => date('d-m-Y', strtotime($order->order_date)),
    //                 'shipping_address' => $order->shipping_address,
    //                 'shipping_landmark' => $order->shipping_landmark,
    //                 'shipping_city' => $order->shipping_city,
    //                 'shipping_state' => $order->shipping_state,
    //                 'shipping_country' => $order->shipping_country,
    //                 'shipping_zip' => $order->shipping_zip,

    //             ];

    //             // Send email
    //             set_smtp_config();
    //             Mail::send('frontend.emails.order_shipped', $data, function ($message) use ($order) {
    //                 $message->to($order->shipping_email)
    //                     ->from('tech@jayswatchstore.com', "Jay's Watch Store")
    //                     ->subject('Your Order Has Been Shipped');
    //             });
    //         }

    //         return response()->json(['success' => true, 'message' => 'Tracking number updated and email sent successfully.']);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    // }

    public function updateTracking(Request $request)
    {
        $request->validate([
            'order_id'      => 'required',
            'o_id'          => 'required',
            'delivery_type' => 'required'
        ]);

        $order = Order::where('order_id', $request->order_id)
            ->where('o_id', $request->o_id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        $orderItems = DB::table('order_items as oi')
            ->join('mst_product as p', 'oi.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            ->select(
                'oi.quantity',
                'p.pro_name as product_name',
                'p.pro_image as product_image',
                'b.brand_name as brand_name',
                'p.selling_price_exclusive as price'
            )
            ->where('oi.order_id', $order->order_id)
            ->get();

        // Bombex Delivery
        if ($request->delivery_type == 'bombex') {

            $tracking = generate_bombex_tracking();

            if ($tracking == 'Range End') {
                return response()->json([
                    'success' => false,
                    'message' => 'Shipment Range End'
                ]);
            }

            $order->delivery_type = 'bombex';
            $order->tracking_num = $tracking;
            $order->delivery_details = null;
        }

        // Internal Delivery
        if ($request->delivery_type == 'internal') {

            // $details = [
            //     'store_name'     => $request->store_name,
            //     'delivery_guy'   => $request->delivery_guy,
            //     'contact_number' => $request->contact_number,
            //     'notes' => $request->notes
            // ];

            $order->delivery_type = 'internal';
            $order->tracking_num = null;
            // $order->delivery_details = json_encode($details);
        }

        $order->status = 2;
        $order->save();

        // Email
        if (!empty($order->shipping_email) && $order->delivery_type == 'bombex') {

            $data = [
                'order_id'          => $order->order_id,
                'tracking_number'   => $order->tracking_num,
                'first_name'        => $order->shipping_first_name,
                'last_name'         => $order->shipping_last_name,
                'order_date'        => date('d-m-Y', strtotime($order->order_date)),
                'shipping_address'  => $order->shipping_address,
                'shipping_landmark' => $order->shipping_landmark,
                'shipping_city'     => $order->shipping_city,
                'shipping_state'    => $order->shipping_state,
                'shipping_country'  => $order->shipping_country,
                'shipping_zip'      => $order->shipping_zip,
                'delivery_type'     => $order->delivery_type,
                // 'delivery_details'  => $order->delivery_details, // FIXED,
                'items' => $orderItems
            ];



            set_smtp_config();

            Mail::send('frontend.emails.order_shipped', $data, function ($message) use ($order) {
                $message->to($order->shipping_email)
                    ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                    ->subject('Your Order Has Been Shipped');
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Order shipped successfully.'
        ]);
    }

    //Assing Internal Delivery
    public function assignInternalDelivery(Request $request)
    {
        $request->validate([
            'order_id'       => 'required',
            'o_id'           => 'required',
            'store_name'     => 'required',
            'delivery_guy'   => 'required',
            'contact_number' => 'required|digits:10'
        ]);

        $order = Order::where('order_id', $request->order_id)
            ->where('o_id', $request->o_id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        // 🔥 Delivery Details
        $details = [
            'store_name'     => $request->store_name,
            'delivery_guy'   => $request->delivery_guy,
            'contact_number' => $request->contact_number,
            'notes'          => $request->notes
        ];

        // $order->delivery_type = 'internal';
        // $order->tracking_num = null;
        $order->delivery_details = json_encode($details);
        $order->status = 3; // ✅ fixed

        $order->save();

        // 🔥 Get items (FIXED)
        $orderItems = DB::table('order_items as oi')
            ->join('mst_product as p', 'oi.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            ->select(
                'oi.quantity',
                'p.pro_name as product_name',
                'p.pro_image as product_image',
                'b.brand_name as brand_name',
                'p.selling_price_exclusive as price'
            )
            ->where('oi.order_id', $order->order_id)
            ->get();

        // 📧 Email
        if (!empty($order->shipping_email)) {

            $data = [
                'order_id'          => $order->order_id,
                'tracking_number'   => null,
                'first_name'        => $order->shipping_first_name,
                'last_name'         => $order->shipping_last_name,
                'order_date'        => date('d-m-Y', strtotime($order->order_date)),
                'shipping_address'  => $order->shipping_address,
                'shipping_landmark' => $order->shipping_landmark,
                'shipping_city'     => $order->shipping_city,
                'shipping_state'    => $order->shipping_state,
                'shipping_country'  => $order->shipping_country,
                'shipping_zip'      => $order->shipping_zip,
                'delivery_type'     => $order->delivery_type,
                'delivery_details'  => $order->delivery_details,
                'items'             => $orderItems
            ];

            set_smtp_config();

            Mail::send('frontend.emails.order_shipped', $data, function ($message) use ($order) {
                $message->to($order->shipping_email)
                    ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                    ->subject('Your Order is Out for Delivery');
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Delivery assigned successfully.'
        ]);
    }
    // intrasit
    public function markDelivered(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'o_id' => 'required',
        ]);

        $order = Order::where('order_id', $request->order_id)
            ->where('o_id', $request->o_id)
            ->first();

        $orderItems = DB::table('order_items as oi')
            ->join('mst_product as p', 'oi.product_id', '=', 'p.pro_id')
            ->leftJoin('mst_brand as b', 'p.brand', '=', 'b.brand_id')
            ->select(
                'oi.quantity',
                'p.pro_name as product_name',
                'p.pro_image as product_image',
                'b.brand_name as brand_name',
                'p.selling_price_exclusive as price'
            )
            ->where('oi.order_id', $order->order_id)
            ->get();

        if ($order) {
            $order->status = 4; // Completed / Delivered
            $order->save();

            // Send delivery confirmation email
            if (! empty($order->shipping_email)) {
                $data = [
                    'order_id' => $order->order_id,
                    'first_name' => $order->shipping_first_name,
                    'last_name' => $order->shipping_last_name,
                    'delivered_date' => date('d-m-Y'),
                    'shipping_address' => $order->shipping_address,
                    'shipping_landmark' => $order->shipping_landmark,
                    'shipping_city' => $order->shipping_city,
                    'shipping_state' => $order->shipping_state,
                    'shipping_country' => $order->shipping_country,
                    'shipping_zip' => $order->shipping_zip,
                    'items' => $orderItems
                ];

                set_smtp_config();

                Mail::send('frontend.emails.order_delivered', $data, function ($message) use ($order) {
                    $message->to($order->shipping_email)
                        ->from('tech@jayswatchstore.com', "Jay's Watch Store")
                        ->subject('Your Order Has Been Delivered');
                });
            }

            return response()->json(['success' => true, 'message' => 'Order marked as delivered and email sent successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }

    //ecommerce tracking range update
    public function shipmentRangeStore(Request $request)
    {
        if (!empty($request->sr_id)) {

            DB::table('tbl_ship_range')
                ->where('sr_id', $request->sr_id)
                ->update([
                    'from_range' => $request->from_range,
                    'to_range'   => $request->to_range,
                    'updated_by' => current_user_id(),
                    'updated_at' => now()
                ]);

            $sr_id = $request->sr_id;
            $message = 'Shipment Range Updated Successfully';
        } else {

            $sr_id = DB::table('tbl_ship_range')->insertGetId([
                'from_range' => $request->from_range,
                'to_range'   => $request->to_range,
                'created_at' => now(),
                'created_by' => current_user_id(),
                'updated_by' => current_user_id(),
                'updated_at' => now()
            ]);

            $message = 'Shipment Range Added Successfully';
        }

        // fetch latest saved row
        $range = DB::table('tbl_ship_range')
            ->where('sr_id', $sr_id)
            ->first();

        return response()->json([
            'status'     => true,
            'message'    => $message,
            'sr_id'      => $range->sr_id,
            'from_range' => $range->from_range,
            'to_range'   => $range->to_range
        ]);
    }

    public function bombexStatus(Request $request)
    {
        $tracking_num = $request->tracking_num;

        $apiUrl = "https://eztrackwebapi159.softpal.in/V1/TrackingApiCommon_Softpal?ShipmentNo={$tracking_num}&HostId=24";

        $response = Http::get($apiUrl);

        if (!$response->successful()) {
            return '<div class="track-error">Unable to fetch tracking details</div>';
        }

        $trackingData = $response->json();

        $history = $trackingData['Sheet_History'] ?? [];

        $currentStatus = $trackingData['ConsignmentDetails_Traking']['current_status_name']
            ?? 'Shipment Details Provided Soon';

        $html = '';

        /* ===============================
       ORDER STATUS TOP
    =============================== */

        $html .= '
    <div class="track-status-box d-none">
        <h2>Order Status:</h2>
        <h4>' . $currentStatus . '</h4>
    </div>

    <div class="track-order-no d-none">
        Order No: ' . $tracking_num . '
    </div>';

        /* ===============================
       TIMELINE
    =============================== */

        if (count($history) > 0) {

            $html .= '<div class="timeline-wrap"><div class="timeline">';

            foreach ($history as $row) {

                $status = $row['status'] ?? '-';
                $date   = !empty($row['status_date'])
                    ? date('d-m-Y H:i:s', strtotime($row['status_date']))
                    : '';

                $city   = strtoupper($row['destination'] ?? '');

                $html .= '
            <div class="step active">
                <h6>' . $status . '</h6>
                <p>' . $date . '</p>
                <p>' . $city . '</p>
            </div>';
            }

            $html .= '</div></div>';
        } else {

            $html .= '<div class="track-empty">Tracking Updates Will Be Available Soon</div>';
        }

        /* ===============================
       SENDER / RECEIVER
    =============================== */

        if (!empty($trackingData['ConsignmentDetails_Traking']['sender_name'])) {

            $c = $trackingData['ConsignmentDetails_Traking'];

            $html .= '
        <div class="info-box">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <h5>Sender Details</h5>

                    <p>
                        ' . ($c['sender_name'] ?? '') . '<br>
                        ' . ($c['sender_company'] ?? '') . '<br>
                        ' . ($c['sender_city'] ?? '') . ',
                        ' . ($c['sender_state'] ?? '') . '
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>Receiver Details</h5>

                    <p>
                        ' . ($c['receiver_name'] ?? '') . '<br>
                        ' . ($c['receiver_city'] ?? '') . '
                    </p>
                </div>

            </div>
        </div>';
        }

        /* ===============================
       POD IMAGE
    =============================== */

        if (!empty($trackingData['_PodImage']['PodPath'][0])) {

            $img = $trackingData['_PodImage']['PodPath'][0];

            $html .= '
        <div class="info-box">
            <h5>Proof of Delivery</h5>

            <a href="' . $img . '" target="_blank">
                <img src="' . $img . '" class="pod-img">
            </a>
        </div>';
        }

        return $html;
    }
}
