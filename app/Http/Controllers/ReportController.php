<?php

namespace App\Http\Controllers;

use App\Models\BusinesslocationModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function invoice_index()
    {
        $page_title = 'Invoice Report';

        return view('report.invoice_report', compact('page_title'));
    }

    public function list(Request $request)
    {

        $storeSales = DB::table('mst_sales as s')
            ->leftJoin('tbl_bussiness_location as l', 's.location', '=', 'l.bl_id')
            ->select([
                's.sales_id as id',
                DB::raw("'store' as sale_type"),
                's.invoice_no as invoice_num',
                's.full_name as fullname',
                's.mobile_no as mobile_num',
                's.email',
                's.finalTotal as final_total',
                's.sale_date as bill_date',
                's.location as location_id', // ✅ ADD THIS
                's.created_at',
            ])->whereNotNull('s.invoice_no');
        /* ================= ONLINE SALES ================= */
        $onlineSales = DB::table('order as o')
            ->select([
                'o.o_id as id',
                DB::raw("'online' as sale_type"),
                'o.invoice_num',
                DB::raw("CONCAT(o.shipping_first_name, ' ', o.shipping_last_name) as fullname"),
                'o.shipping_phone as mobile_num',
                'o.shipping_email as email',
                'o.grand_total as final_total',
                'o.order_date as bill_date',
                DB::raw('NULL as location_id'), // ✅ REQUIRED
                'o.created_at',
            ])->whereNotNull('o.invoice_num');

        /* ===== UNION BOTH ===== */
        $query = $storeSales->unionAll($onlineSales);
        $mainQuery = DB::query()->fromSub($query, 'sales');

        if ($request->filled('location_id')) {
            $mainQuery->where(function ($q) use ($request) {
                $q->where('sale_type', 'store')
                    ->where('location_id', $request->location_id);
            });
        }

        /* ===== SEARCH ===== */
        if ($search = $request->input('search.value')) {
            $mainQuery->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%$search%")
                    ->orWhere('invoice_num', 'like', "%$search%")
                    ->orWhere('mobile_num', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        /* ===== FILTER BY TYPE ===== */
        if ($request->filled('sale_type')) {
            $mainQuery->where('sale_type', $request->sale_type);
        }

        /* ===== FILTER BY DATE RANGE ===== */
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date . ' 00:00:00';
            $endDate = $request->end_date . ' 23:59:59';
            $mainQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        /* ===== GET SUMMARY DATA ===== */
        $summaryQuery = clone $mainQuery;
        $summary = [
            'total' => $summaryQuery->count(),
            'store' => (clone $summaryQuery)->where('sale_type', 'store')->count(),
            'online' => (clone $summaryQuery)->where('sale_type', 'online')->count(),
            'amount' => $summaryQuery->sum('final_total') ?? 0,
        ];

        /* ===== PAGINATION ===== */
        $totalData = $mainQuery->count();
        $limit = $request->length ?? 10;
        $start = $request->start ?? 0;

        $data = $mainQuery
            ->orderBy('created_at', 'desc')
            ->offset($start)
            ->limit($limit)
            ->get();

        /* ===== FORMAT DATA ===== */
        $formatted = [];
        $i = $start + 1;

        foreach ($data as $row) {
            $action = '
        <div class="d-flex gap-2 justify-content-center">
            <button class="btn btn-sm btn-info-light btn-action viewInvoice"
                data-id="' . $row->id . '"
                data-type="' . $row->sale_type . '"
                data-bs-toggle="tooltip"
                title="View Details">
                <i class="bx bx-show"></i>
            </button>
            <button class="btn btn-sm btn-primary-light btn-action d-none printInvoice"
                data-id="' . $row->id . '"
                data-type="' . $row->sale_type . '"
                data-bs-toggle="tooltip"
                title="Print Invoice">
                <i class="bx bx-printer"></i>
            </button>
        </div>';

            $formatted[] = [
                'sr_no' => $i++,
                'invoice_num' => $row->invoice_num,
                'fullname' => $row->fullname ?? 'N/A',
                'mobile_num' => $row->mobile_num ?? 'N/A',
                'email' => $row->email ?? 'N/A',
                'final_total' => indian_number_format($row->final_total, 2),
                'bill_date' => date('d-m-Y', strtotime($row->bill_date)),
                'sale_type' => $row->sale_type,
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $formatted,
            'summary' => $summary,
        ]);
    }

    public function show($type, $id)
    {
        /* ================= STORE SALE ================= */
        if ($type == 'store') {

            $sale = DB::table('mst_sales as s')
                ->leftJoin('tbl_bussiness_location as l', 's.location', '=', 'l.bl_id')
                ->select('s.*', 'l.name as location_name', 's.finalTotal as final_total', 's.gst_amount as tax_amount')
                ->where('s.sales_id', $id)
                ->first();

            $sale->sale_type = 'store';

            $products = DB::table('mst_sales_product')
                ->leftJoin('mst_product as p', 'mst_sales_product.product_id', '=', 'p.pro_id')
                ->where('sales_id', $id)
                ->select([
                    'p.pro_name as product_name',
                    'p.hsn_code',
                    'qty',
                    'p.selling_price_exclusive as price',
                    'sales_price as total_price',
                ])
                ->get();

            return response()->json([
                'status' => 200,
                'sale_type' => 'store',
                'sale' => $sale,
                'products' => $products,
            ]);
        }

        /* ================= ONLINE SALE ================= */
        if ($type == 'online') {

            $sale = DB::table('order')
                ->select('*', 'tcs as tax_amount')
                ->where('o_id', $id)
                ->first();
            $sale->sale_type = 'online';
            $products = DB::table('order_items as ot')
                ->leftJoin('mst_product as op', 'ot.product_id', '=', 'op.pro_id')
                ->where('order_id', $sale->order_id)
                ->select([
                    'op.pro_name as product_name',
                    'op.hsn_code',
                    'ot.quantity as qty',
                    'ot.total as total_price',
                    'ot.price as price',
                ])
                ->get();

            return response()->json([
                'status' => 200,
                'sale_type' => 'online',
                'sale' => $sale,
                'products' => $products,
            ]);
        }
    }

    public function storeLocations()
    {
        return DB::table('tbl_bussiness_location')
            ->select('bl_id', 'name')
            ->orderBy('name')
            ->get();
    }

    // Inventory Report
    public function inventory_report()
    {
        $page_title = 'Inventory Report';

        $store_data = BusinesslocationModel::get();

        return view('report.inventory_report', compact('page_title', 'store_data'));
    }

    public function inventoryReportList(Request $request)
    {



        try {

            $query = ProductModel::from('mst_product as p')
                ->leftJoin('tbl_bussiness_location as bl', 'bl.bl_id', '=', 'p.brand')
                ->where('p.pro_type', 'product')
                ->select(
                    'p.*',
                    'bl.name as brand_name'
                );

            if ($request->filled('store_id')) {
                $query->where('p.brand', $request->store_id);
            }
            $totalRecords = $query->count();

            // Pagination
            $start = $request->start ?? 0;
            $length = $request->length ?? 25;

            $products = $query
                ->skip($start)
                ->take($length)
                ->get();

            $data = [];
            $summary = [
                'total_products' => $totalRecords,
                'total_units_sold' => 0,
                'total_sales_value' => 0,
                'total_brands' => 0,
            ];

            foreach ($products as $index => $product) {

                $salesQuery = DB::table('mst_sales_product as sp')
                    ->leftJoin('mst_sales as s', 's.sales_id', '=', 'sp.sales_id')
                    ->where('sp.product_id', $product->pro_id);

                if ($request->filled('start_date') && $request->filled('end_date')) {

                    // Range filter
                    $salesQuery->whereBetween('s.created_at', [
                        $request->start_date,
                        $request->end_date,
                    ]);
                } elseif ($request->filled('start_date')) {

                    // Single date filter
                    $salesQuery->whereDate('s.created_at', $request->start_date);
                } elseif ($request->filled('end_date')) {

                    // Optional: only end date
                    $salesQuery->whereDate('s.created_at', $request->end_date);
                }

                $salesData = $salesQuery->selectRaw('
                COALESCE(SUM(sp.qty),0) as sold_qty,
                COALESCE(SUM(sp.sales_price),0) as total_sales
            ')->first();

                $soldQty = $salesData->sold_qty ?? 0;
                $totalSales = $salesData->total_sales ?? 0;

                $summary['total_units_sold'] += $soldQty;
                $summary['total_sales_value'] += $totalSales;

                $data[] = [
                    'sr_no' => $start + $index + 1,
                    'pro_name' => $product->pro_name,
                    'pro_model' => $product->pro_model,
                    'pro_sku' => $product->pro_sku,
                    'brand_name' => $product->brand_name ?? 'N/A',
                    'sold_qty' => $soldQty,
                    'unit_price' => $product->selling_price_exclusive ?? 0,
                    'total_sales' => $totalSales,
                    'status' => $product->status == 0 ? 'active' : 'inactive',
                ];
            }

            $summary['total_brands'] = ProductModel::distinct('brand')->count('brand');

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data,
                'summary' => $summary,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'summary' => [
                    'total_products' => 0,
                    'total_units_sold' => 0,
                    'total_sales_value' => 0,
                    'total_brands' => 0,
                ],
            ]);
        }
    }

    // Activity Logs
    public function activityReport()
    {
        $page_title = 'Activity Logs';

        return view('report.activity_logs', compact('page_title'));
    }

    public function activityLogsFilters(Request $request)
    {
        try {
            // Get unique menu types
            $menu_types = DB::table('activity_log')
                ->whereNotNull('menu_type')
                ->distinct()
                ->orderBy('menu_type')
                ->pluck('menu_type');

            // Get unique log types
            $log_types = DB::table('activity_log')
                ->whereNotNull('log_type')
                ->distinct()
                ->orderBy('log_type')
                ->pluck('log_type');

            // Get users who have activities
            $users = DB::table('activity_log as al')
                ->leftJoin('tbl_staff as s', 's.staff_id', '=', 'al.user_id')
                ->leftJoin('tbl_users as u', 'u.user_id', '=', 'al.user_id')
                ->select(
                    'al.user_id',
                    DB::raw("
                    CASE
                        WHEN al.menu_type = 'Ecommerce' THEN
                            CONCAT(u.full_name, ' <span class=\"badge bg-info\">- (Ecommerce)</span>')

                        WHEN al.user_id = -1 THEN
                            'Super Admin'

                        ELSE CONCAT(
                            COALESCE(s.prefix, ''),
                            IF(s.prefix IS NOT NULL AND s.prefix != '', ' ', ''),
                            s.first_name,
                            IF(s.last_name IS NOT NULL AND s.last_name != '', CONCAT(' ', s.last_name), '')
                        )
                    END as user_name
                ")
                )
                ->whereNotNull('al.user_id')
                ->distinct()
                ->orderBy('al.user_id')
                ->get();

            return response()->json([
                'menu_types' => $menu_types,
                'log_types'  => $log_types,
                'users'      => $users,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'menu_types' => [],
                'log_types'  => [],
                'users'      => [],
            ]);
        }
    }

    public function activityLogsList(Request $request)
    {
        try {
            $query = DB::table('activity_log as al')
                ->leftJoin('tbl_staff as s', 's.staff_id', '=', 'al.user_id')
                ->leftJoin('tbl_users as u', 'u.user_id', '=', 'al.user_id')
                ->select(
                    'al.log_id',
                    'al.menu_type',
                    'al.log_type',
                    'al.user_id',
                    DB::raw("
    CASE
        WHEN al.menu_type = 'Ecommerce' THEN u.full_name
        WHEN al.user_id = -1 THEN 'Admin'
        ELSE CONCAT(
            COALESCE(s.prefix, ''),
            IF(s.prefix IS NOT NULL AND s.prefix != '', ' ', ''),
            s.first_name,
            IF(s.last_name IS NOT NULL AND s.last_name != '', CONCAT(' ', s.last_name), '')
        )
    END as user_name
"),
                    'al.log_date',
                    'al.log_description',
                    'al.log_status',
                    'al.ip_address',
                    'al.created_at',
                    'al.created_by',
                    'al.updated_at',
                    'al.updated_by'
                );
            // Apply filters
            if ($request->filled('menu_type')) {
                $query->where('al.menu_type', $request->menu_type);
            }

            if ($request->filled('log_type')) {
                $query->where('al.log_type', $request->log_type);
            }

            if ($request->filled('user_id')) {
                $query->where('al.user_id', $request->user_id);
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('al.created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59',
                ]);
            }

            // Get total count before pagination
            $totalRecords = $query->count();

            // Apply pagination
            $logs = $query->orderBy('al.log_id', 'desc')
                ->skip($request->start ?? 0)
                ->take($request->length ?? 25)
                ->get();

            // Calculate summary
            $summary = [
                'total_activities' => $totalRecords,
                'unique_users' => DB::table('activity_log')
                    ->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
                        return $q->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                    })
                    ->distinct('user_id')
                    ->count('user_id'),
                'menu_types' => DB::table('activity_log')
                    ->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
                        return $q->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                    })
                    ->distinct('menu_type')
                    ->count('menu_type'),
                'log_types' => DB::table('activity_log')
                    ->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
                        return $q->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                    })
                    ->distinct('log_type')
                    ->count('log_type'),
            ];

            // Add serial numbers
            $data = [];
            $sr_no = $request->start ?? 0;

            foreach ($logs as $log) {

                $sr_no++;

                $description = $log->log_description;

                // ✅ Only for stock_transfer
                if ($log->log_type === 'stock_transfer' && ! empty($log->log_description)) {

                    $json = json_decode($log->log_description, true);

                    if (is_array($json)) {

                        $bullets = [];

                        // Status
                        if (! empty($json['status'])) {
                            $bullets[] = '• Status: ' . $json['status'];
                        }

                        // Reference No
                        if (! empty($json['reference_no'])) {
                            $bullets[] = '• Reference No: ' . $json['reference_no'];
                        }

                        // Location From
                        if (! empty($json['location_from'])) {
                            $locationFrom = DB::table('tbl_bussiness_location')
                                ->where('bl_id', $json['location_from'])
                                ->value('name');

                            if ($locationFrom) {
                                $bullets[] = '• From Location: ' . $locationFrom;
                            }
                        }

                        // Location To
                        if (! empty($json['location_to'])) {
                            $locationTo = DB::table('tbl_bussiness_location')
                                ->where('bl_id', $json['location_to'])
                                ->value('name');

                            if ($locationTo) {
                                $bullets[] = '• To Location: ' . $locationTo;
                            }
                        }

                        $description = implode('<br>', $bullets);
                    }
                }

                $data[] = [
                    'sr_no' => $sr_no,
                    'log_id' => $log->log_id,
                    'menu_type' => $log->menu_type,
                    'log_type' => $log->log_type,
                    'user_id' => $log->user_id,
                    'user_name' => $log->user_name,
                    'log_date' => $log->log_date,
                    'log_description' => $description, // ✅ Modified
                    'log_status' => $log->log_status,
                    'ip_address' => $log->ip_address,
                    'created_at' => $log->created_at,
                    'created_by' => $log->created_by,
                    'updated_at' => $log->updated_at,
                    'updated_by' => $log->updated_by,
                ];
            }

            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data,
                'summary' => $summary,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'summary' => [
                    'total_activities' => 0,
                    'unique_users' => 0,
                    'menu_types' => 0,
                    'log_types' => 0,
                ],
            ]);
        }
    }
}
