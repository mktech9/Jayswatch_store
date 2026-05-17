<?php

namespace App\Http\Controllers;

use App\Models\BusinesslocationModel;
use App\Models\ProductModel;
use App\Models\SalesModel;
use App\Models\StaffModel;
use App\Models\StockTransferModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Dashboard extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'JaysWatch Dashboard';

        $loginType = Session::get('login_type');

        // Accessible locations
        $locationIds = access_locations()->pluck('bl_id')->toArray();

        $filter = session('dashboard_filter', 1);
        $filter = $filter === 'all' ? 'all' : (int)$filter;

        $startDate = match ($filter) {
            1 => now()->subDays(30),
            3 => now()->subMonths(3),
            6 => now()->subMonths(6),
            12 => now()->subYear(),
            'all' => null,
            default => now()->subDays(30),
        };

        /* =========================
       TOTAL SELL
    ==========================*/
        $sellQuery = SalesModel::where('bill_status', 'Paid')
            ->where('status', 0);

        if ($loginType === 'staff') {
            $sellQuery->whereIn('location', $locationIds);
        }

        if ($startDate) {
            $sellQuery->whereBetween('sale_date', [$startDate, now()]);
        }

        $totalSell = (clone $sellQuery)->sum('finalTotal');

        /* =========================
       PRODUCTS
    ==========================*/
        $productsQuery = ProductModel::where('status', 0);

        if ($loginType === 'staff') {
            $productsQuery->whereIn('display_location', $locationIds);
        }

        $products = $productsQuery->count();

        $pending_products = ProductModel::where('status', 0)
            ->where('approval_status', 0)
            ->when($loginType === 'staff', function ($q) use ($locationIds) {
                $q->whereIn('display_location', $locationIds);
            })
            ->count();

        /* =========================
       STAFF COUNT
    ==========================*/
        $staff = StaffModel::where('status', 0)->count();

        /* =========================
       STORE COUNT
    ==========================*/
        $storeQuery = BusinesslocationModel::where('status', 0);

        if ($loginType === 'staff') {
            $storeQuery->whereIn('bl_id', $locationIds);
        }

        $store = $storeQuery->count();


        $outStock = ProductModel::where('status', 0)
            ->where('out_stock', 1)
            ->when($loginType === 'staff', function ($q) use ($locationIds) {
                $q->whereIn('display_location', $locationIds);
            })
            ->count();

        /* =========================
       BUSINESS LOCATIONS
    ==========================*/
        $business = BusinesslocationModel::where('status', 0)
            ->when($loginType === 'staff', function ($q) use ($locationIds) {
                $q->whereIn('bl_id', $locationIds);
            })
            ->get();

        /* =========================
       SALES LOCATION LIST
    ==========================*/
        $sales_location = SalesModel::join(
            'tbl_bussiness_location',
            'tbl_bussiness_location.bl_id',
            '=',
            'mst_sales.location'
        )
            ->select(
                'mst_sales.*',
                'tbl_bussiness_location.name as location_name'
            )
            ->where('mst_sales.status', 0)
            ->when($loginType === 'staff', function ($q) use ($locationIds) {
                $q->whereIn('mst_sales.location', $locationIds);
            })
            ->get();

        return view('dashboard', compact(
            'page_title',
            'products',
            'totalSell',
            'outStock',
            'staff',
            'store',
            'pending_products',
            'business',
            'sales_location'
        ));
    }

    public function getTotalSell(Request $request)
    {
        $loginType = Session::get('login_type');
        $locationIds = access_locations()->pluck('bl_id')->toArray();

        $filter = $request->filter ?? 1;
        $filter = $filter === 'all' ? 'all' : (int)$filter;

        $startDate = match ($filter) {
            1 => now()->subDays(30),
            3 => now()->subMonths(3),
            6 => now()->subMonths(6),
            12 => now()->subYear(),
            'all' => null,
            default => now()->subDays(30),
        };

        $query = SalesModel::where('bill_status', 'Paid')
            ->where('status', 0);

        if ($loginType === 'staff') {
            $query->whereIn('location', $locationIds);
        }

        if ($startDate) {
            $query->whereBetween('sale_date', [$startDate, now()]);
        }

        return response()->json([
            'totalSell' => indian_number_format($query->sum('finalTotal'), 2),
        ]);
    }

    public function locationSalesChart(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        // ✅ Get accessible locations (Super admin = all, Staff = assigned)
        $locations = access_locations();

        $locationIds = $locations->pluck('bl_id')->toArray();

        // Base sales query
        $salesQuery = SalesModel::where('status', 0)->where('bill_status', 'Paid');

        // ✅ Filter sales by accessible locations
        if (! empty($locationIds)) {
            $salesQuery->whereIn('location', $locationIds);
        }

        // Date filter
        if ($from && $to) {
            $salesQuery->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to . ' 23:59:59',
            ]);
        }

        // Group sales
        $salesData = (clone $salesQuery)
            ->select(
                'location',
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(finalTotal) as total_amount')
            )
            ->groupBy('location')
            ->get()
            ->keyBy('location');

        $colors = [
            '#008FFB',
            '#00E396',
            '#FEB019',
            '#FF4560',
            '#775DD0',
            '#3F51B5',
            '#03A9F4',
            '#4CAF50',
        ];

        $result = [];

        // ✅ All accessible locations summary
        $result[] = [
            'name' => 'All Locations',
            'sales' => (int) $salesData->sum('total_count'),
            'revenue' => (float) $salesData->sum('total_amount'),
            'color' => '#333333',
        ];

        // Individual locations
        foreach ($locations as $index => $loc) {

            $stats = $salesData->get($loc->bl_id);

            $result[] = [
                'name' => $loc->name,
                'sales' => $stats ? (int) $stats->total_count : 0,
                'revenue' => $stats ? (float) $stats->total_amount : 0,
                'color' => $colors[$index % count($colors)],
            ];
        }

        return response()->json($result);
    }

    // Stock IN List
    public function stockinpending(Request $request)
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

        $loginType = Session::get('login_type');

        $query = StockTransferModel::with(['fromLocation', 'toLocation'])
            ->where('stock_status', 0);

        // ✅ Staff can see only assigned locations
        if ($loginType === 'staff') {
            $accessLocations = access_locations()->pluck('bl_id')->toArray();
            $query->whereIn('location_to', $accessLocations);
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $searchValue = $request->input('search.value');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reference_no', 'LIKE', "%{$searchValue}%")
                    ->orWhere('transfer_date', 'LIKE', "%{$searchValue}%")
                    ->orWhere('stock_status', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        $data = $query
            ->orderByDesc('stock_id')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            /* --------------------------------
               DEFAULT BUTTONS (ALL USERS)
            --------------------------------*/
            $action = '
        <div class="d-flex gap-1 justify-content-center mb-1">

            <button class="btn btn-sm btn-info viewStock"
                data-id="' . $row->stock_id . '">
                <i class="bx bx-show"></i>
            </button>

            <button class="btn btn-sm btn-secondary printStock"
                data-id="' . $row->stock_id . '">
                <i class="bx bx-printer"></i>
            </button>

        </div>';

            /* --------------------------------
               SUPER ADMIN EXTRA ACTIONS
            --------------------------------*/
            if ($loginType === 'super_admin' && $row->stock_status != 2) {

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

            /* --------------------------------
               STATUS CLICK PERMISSION
            --------------------------------*/
            $canUpdateStatus =
                ($loginType === 'super_admin' && $row->stock_status != 2);

            $stockStatus = match ($row->stock_status) {

                0 => $canUpdateStatus
                    ? '<span class="badge bg-warning stockStatusBtn"
                    data-id="' . $row->stock_id . '"
                    data-status="0"
                    style="cursor:pointer;">Pending</span>'
                    : '<span class="badge bg-warning">Pending</span>',

                1 => $canUpdateStatus
                    ? '<span class="badge bg-info stockStatusBtn"
                    data-id="' . $row->stock_id . '"
                    data-status="1"
                    style="cursor:pointer;">In-Transit</span>'
                    : '<span class="badge bg-info">In-Transit</span>',

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

    // Draft Invoice
    public function draftinvoicelist(Request $request)
    {
        /* ================= TOTAL RECORDS ================= */

        $totalQuery = SalesModel::where('status', '!=', 1)
            ->where('sale_status', 0)
            ->where('bill_status', 'Draft');

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
            ->leftJoin(
                'mst_contact_master',
                'mst_sales.customer_id',
                '=',
                'mst_contact_master.contact_master_id'
            )
            ->leftJoin(
                'tbl_bussiness_location',
                'mst_sales.location',
                '=',
                'tbl_bussiness_location.bl_id'
            )
            ->where('mst_sales.status', '!=', 1)
            ->where('mst_sales.sale_status', 0)
            ->where('mst_sales.bill_status', 'Draft');

        /* ================= SEARCH (OPTIONAL DATATABLE SEARCH) ================= */

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
            ->orderByDesc('mst_sales.sales_id')
            ->get();

        /* ================= FORMAT DATA ================= */

        $data = [];
        $i = $start + 1;

        foreach ($sales as $row) {

            // Customer Name
            if ($row->is_business == 1) {

                $custName = $row->business_name;

                if (! empty($row->full_name)) {
                    $custName .= '<br><small class="text-muted">(' . $row->full_name . ')</small>';
                }
            } else {
                $custName = $row->full_name ?: ($row->first_name . ' ' . $row->last_name);
            }

            // Actions
            $action = '
        <div class="d-flex gap-2">
            <button class="btn btn-icon btn-sm btn-warning-light rounded-pill printSale"
                data-id="' . $row->sales_id . '">
                <i class="bx bx-printer"></i>
            </button>

            <button class="btn btn-icon btn-sm btn-info-light rounded-pill view-sale"
                data-id="' . $row->sales_id . '">
                <i class="bx bx-show"></i>
            </button>

            <button class="btn btn-icon btn-sm btn-primary-light rounded-pill editSales"
                data-id="' . $row->sales_id . '">
                <i class="bx bx-edit"></i>
            </button>

            <button class="btn btn-icon btn-sm btn-danger-light rounded-pill delete-sale"
                data-id="' . $row->sales_id . '">
                <i class="bx bx-trash"></i>
            </button>
        </div>';

            $data[] = [
                'sr_no' => $i++,
                'sale_date' => date('d-m-Y', strtotime($row->sale_date)),
                'invoice_no' => $row->invoice_no,
                'customer' => $custName,
                'location' => $row->location_name,
                'total' => indian_number_format($row->finalTotal, 2),
                'bill_status' => '<span class="badge bg-warning text-dark">Draft</span>',
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

    // Out Of Stock
    public function out_stock_product(Request $request)
    {
        $columns = [
            0 => 'pro_id',
            1 => 'pro_image',
            2 => 'pro_name',
            3 => 'brand_name',
            4 => 'category',
            5 => 'pro_sku',
            6 => 'location_name',
            7 => 'purchase_price_exclusive',
            8 => 'selling_price_exclusive',
            9 => 'box',
            10 => 'paper',
            11 => 'action',
        ];

        $loginType = Session::get('login_type');
        $locationIds = access_locations()->pluck('bl_id')->toArray();

        /* ===========================
       BASE QUERY
    ============================ */
        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name',
            'tbl_bussiness_location.name as location_name'
        )
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->leftJoin('tbl_bussiness_location', 'mst_product.business_location', '=', 'tbl_bussiness_location.bl_id')
            ->where('pro_type', 'product')
            // ->where('tata_cliq_product', '!=', 1)
            ->where('approval_status', 1)
            ->where('mst_product.status', 0)
            ->where('mst_product.out_stock', 1)
            ->when($loginType === 'staff', function ($q) use ($locationIds) {
                $q->whereIn('mst_product.display_location', $locationIds);
            });

        $totalData = $query->count();
        $totalFiltered = $totalData;

        /* ===========================
       DATATABLE PARAMETERS
    ============================ */
        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        /* ===========================
       SEARCH
    ============================ */
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('pro_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('pro_sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_brand.brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('category', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        /* ===========================
       ORDER + LIMIT
    ============================ */
        $orderColumn = $columns[$orderColumnIndex] ?? 'pro_id';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            /* ===========================
           IMAGE LOGIC
        ============================ */
            $imageHtml = '
        <div class="d-flex align-items-center justify-content-center bg-light border rounded"
             style="width:50px;height:50px;">
            <i class="bx bx-image text-muted fs-4"></i>
        </div>';

            if ($row->pro_image && $row->brand_name) {

                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name);
                $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name);

                $actual_url = config('app.actual_url');

                $relativePath = $actual_url
                    . '/admin_assets/brand/'
                    . $brandFolder . '/'
                    . $productFolder . '/image/'
                    . $row->pro_image;

                $imageHtml = '
            <a href="' . $relativePath . '" target="_blank">
                <img src="' . $relativePath . '"
                     style="width:50px;height:50px;object-fit:cover;border-radius:5px;border:1px solid #eee;">
            </a>';
            }

            /* ===========================
           OUT OF STOCK LABEL
        ============================ */
            $productName = '
        <div class="text-start">
            <div class="fw-semibold">' . e($row->pro_name) . '</div>
            <span class="badge bg-danger mt-1">
                <i class="bx bx-error-circle me-1"></i> Out of Stock
            </span>
        </div>';

            /* ===========================
           BADGES
        ============================ */
            $boxBadge = ($row->box == 0)
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            $paperBadge = ($row->paper == 0)
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            /* ===========================
           ACTION BUTTON
        ============================ */
            $actionButtons = '
        <div class="d-flex gap-2 justify-content-center">
            <button type="button"
                class="btn btn-icon btn-info-light rounded-pill btn-wave viewStockOut"
                data-id="' . $row->pro_id . '"
                title="View Details">
                <i class="bx bx-show"></i>
            </button>
        </div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'pro_image' => $imageHtml,
                'pro_name' => $productName,
                'brand' => e($row->brand_name),
                'category' => e($row->category),
                'pro_sku' => e($row->pro_sku),
                'business_location' => e($row->location_name ?? '-'),
                'purchase_price' => indian_number_format($row->purchase_price_exclusive, 2),
                'selling_price' => indian_number_format($row->selling_price_exclusive, 2),
                'box' => $boxBadge,
                'paper' => $paperBadge,
                'action' => $actionButtons,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData,
        ]);
    }
}
