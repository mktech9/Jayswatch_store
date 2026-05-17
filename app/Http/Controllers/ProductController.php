<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\BrandModel;
use App\Models\BusinesslocationModel;
use App\Models\ColorModel;
use App\Models\EmailModel;
use App\Models\GlassMaterialModel;
use App\Models\MovementModel;
use App\Models\MstCountryModel;
use App\Models\ProductModel;
use App\Models\WatchTypeModel;
use App\Models\CatalogueModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $page_title = 'Products Management';
        $store_location = access_locations();

        $brand_data = BrandModel::where('status', 0)->get();
        $movement_data = MovementModel::where('status', 0)->get();
        $watchtype_data = WatchTypeModel::where('status', 0)->get();
        $glassmaterial_data = GlassMaterialModel::where('status', 0)->get();
        $color_data = ColorModel::where('status', 0)->get();

        $country_data = MstCountryModel::get();

        return view('products.index', compact('page_title', 'store_location', 'brand_data', 'movement_data', 'watchtype_data', 'glassmaterial_data', 'color_data', 'country_data'));
    }

    public function store(Request $request)
    {


        $productType = implode(',', $request->product_type);



        $gender = implode('/', (array) $request->gender);
        $category = implode('/', (array) $request->category);


        $currentUserId = current_user_id();
        $storeOwner = ($currentUserId === -1) ? null : $currentUserId;
        $proId = $request->pro_id;
        $product = $proId ? ProductModel::findOrFail($proId) : null;

        $brandInput = $request->brand_id;
        $manufacturerInput = $request->manufacturer_id;
        $watchTypeInput = $request->watch_type_id;
        $glassInput = $request->glass_material_id;
        $strapInput = $request->strap_color;
        $dialInput = $request->dial_color;
        $movementInput = $request->movement_id;

        /* ===================== DEFAULT VALUES ===================== */

        $brandId = null;
        $manufacturerId = null;
        $watchtypeId = null;
        $glassId = null;
        $strapcolorId = null;
        $dialcolorId = null;
        $movementId = null;

        /* ===================== BRAND ===================== */
        if (! empty($brandInput)) {

            $brand = is_numeric($brandInput)
                ? BrandModel::findOrFail($brandInput)
                : BrandModel::firstOrCreate([
                    'brand_name' => trim($brandInput),
                ]);

            $brandId = $brand->brand_id;
        }

        /* ===================== MANUFACTURER ===================== */
        if (! empty($manufacturerInput)) {

            $manufacturer = is_numeric($manufacturerInput)
                ? BrandModel::findOrFail($manufacturerInput)
                : BrandModel::firstOrCreate([
                    'brand_name' => trim($manufacturerInput),
                ]);

            $manufacturerId = $manufacturer->brand_id;
        }

        /* ===================== WATCH TYPE ===================== */
        if (! empty($watchTypeInput)) {

            $watchtype = is_numeric($watchTypeInput)
                ? WatchTypeModel::findOrFail($watchTypeInput)
                : WatchTypeModel::firstOrCreate([
                    'title' => trim($watchTypeInput),
                ]);

            $watchtypeId = $watchtype->wt_id;
        }

        /* ===================== GLASS MATERIAL ===================== */
        if (! empty($glassInput)) {

            $glassmaterial = is_numeric($glassInput)
                ? GlassMaterialModel::findOrFail($glassInput)
                : GlassMaterialModel::firstOrCreate([
                    'title' => trim($glassInput),
                ]);

            $glassId = $glassmaterial->gm_id;
        }

        /* ===================== STRAP COLOR ===================== */
        if (! empty($strapInput)) {

            $strapcolor = is_numeric($strapInput)
                ? ColorModel::findOrFail($strapInput)
                : ColorModel::firstOrCreate([
                    'title' => trim($strapInput),
                ]);

            $strapcolorId = $strapcolor->color_id;
        }

        /* ===================== DIAL COLOR ===================== */
        if (! empty($dialInput)) {

            $dialcolor = is_numeric($dialInput)
                ? ColorModel::findOrFail($dialInput)
                : ColorModel::firstOrCreate([
                    'title' => trim($dialInput),
                ]);

            $dialcolorId = $dialcolor->color_id;
        }

        /* ===================== MOVEMENT ===================== */
        if (! empty($movementInput)) {

            $movement = is_numeric($movementInput)
                ? MovementModel::findOrFail($movementInput)
                : MovementModel::firstOrCreate([
                    'title' => trim($movementInput),
                ]);

            $movementId = $movement->m_id;
        }

        /* ===================== SKU ===================== */
        $sku = $request->sku ?: ProductModel::generateSKU(
            $brandId,
            $request->collection,
            $request->watch_ref_number,
            $request->model_number
        );

        /* ===================== SLUG ===================== */
        $slug = ProductModel::generateSlug(
            $request->product_name,
            $request->watch_ref_number,
            $request->model_number
        );

        /* ===================== PATH ===================== */
        /* ===================== PATH (WITH DIRECTORY RENAME FIX) ===================== */

        $brand = BrandModel::where('brand_id', $brandId)->first();

        /* ---------- OLD PATH (ONLY DURING UPDATE) ---------- */
        $oldBasePath = null;

        if ($product && $product->brand) {

            $oldBrand = BrandModel::find($product->brand);

            if ($oldBrand) {

                $oldBrandName = preg_replace('/[^A-Za-z0-9\-]/', '_', $oldBrand->brand_name);
                $oldProductName = preg_replace('/[^A-Za-z0-9\-]/', '_', $product->pro_name);

                $oldBasePath = public_path("/assets/admin_assets/brand/$oldBrandName/$oldProductName");
            }
        }

        /* ---------- NEW PATH ---------- */
        $brandName = preg_replace('/[^A-Za-z0-9\-]/', '_', $brand->brand_name);
        $productName = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->product_name);

        $newBasePath = public_path("/assets/admin_assets/brand/$brandName/$productName");

        /* ---------- MOVE DIRECTORY IF NAME CHANGED ---------- */
        if ($product && $oldBasePath && $oldBasePath !== $newBasePath) {

            // move ONLY if old exists AND new does NOT exist
            if (File::exists($oldBasePath) && !File::exists($newBasePath)) {

                File::makeDirectory(dirname($newBasePath), 0777, true, true);

                File::move($oldBasePath, $newBasePath);
            }
        }

        $basePath = $newBasePath;

        /* ---------- ENSURE DIRECTORY EXISTS ---------- */
        File::makeDirectory($basePath, 0777, true, true);

        /* ===================== MAIN IMAGE ===================== */
        $main_image = $product->pro_image ?? null;

        if ($request->remove_main_image == 1) {
            $main_image = null;
        }

        if ($request->hasFile('pro_image')) {
            File::makeDirectory("$basePath/image", 0777, true, true);
            $main_image = ImageHelper::convertToWebp(
                $request->file('pro_image'),
                "$basePath/image"
            );
        }

        /* ===================== GALLERY (PER IMAGE REMOVE) ===================== */
        $gallery_images = [];

        if ($product && $product->pro_gallery) {
            $gallery_images = explode(',', $product->pro_gallery);
        }

        // Remove selected gallery images (DB only)
        if ($request->filled('removed_gallery_images')) {
            $removeImages = json_decode($request->removed_gallery_images, true);
            if (is_array($removeImages)) {
                $gallery_images = array_diff($gallery_images, $removeImages);
            }
        }

        // Add new gallery uploads
        if ($request->hasFile('pro_gallery')) {
            File::makeDirectory("$basePath/gallery", 0777, true, true);
            foreach ($request->file('pro_gallery') as $img) {
                $gallery_images[] = ImageHelper::convertToWebp(
                    $img,
                    "$basePath/gallery"
                );
            }
        }

        $gallery_images = array_values(array_unique(array_filter($gallery_images)));
        $gallery_string = count($gallery_images) ? implode(',', $gallery_images) : null;

        /* ===================== BROCHURE ===================== */
        $brochure_name = $product->pro_brochure ?? null;

        if ($request->remove_brochure == 1) {
            $brochure_name = null;
        }

        if ($request->hasFile('brochure')) {
            File::makeDirectory("$basePath/brochure", 0777, true, true);
            $brochure = $request->file('brochure');
            $brochure_name = time() . '_' . $brochure->getClientOriginalName();
            $brochure->move("$basePath/brochure", $brochure_name);
        }

        /* ===================== VIDEO ===================== */
        $video_source = $product->video_source ?? null;

        if ($request->remove_video == 1) {
            $video_source = null;
        }

        if ($request->video_type === 'file' && $request->hasFile('video_link')) {
            File::makeDirectory("$basePath/video", 0777, true, true);
            $video = $request->file('video_link');
            $video_source = time() . '_' . $video->getClientOriginalName();
            $video->move("$basePath/video", $video_source);
        }

        if (in_array($request->video_type, ['youtube', 'vimeo']) && $request->video_link) {
            $video_source = $request->video_link;
        }

        // $locations = $request->business_location_id;
        // $location_string = (! empty($locations) && is_array($locations)) ? implode(',', $locations) : null;

        $displayLocations = $request->display_location_id;
        $display_location_string = (! empty($displayLocations) && is_array($displayLocations)) ? implode(',', $displayLocations) : null;

        // ✅ NEW: Physical Location (Single Value)
        $physicalLocation = $request->physical_location_id;

        $data = [
            'pro_type' =>  $productType,
            'pro_name' => $request->product_name,
            'pro_model' => $request->model_number,
            'pro_model_name' => $request->model_name,
            'pro_ref_num' => $request->watch_ref_number,
            'pro_gender' =>  $gender,
            'pro_sku' => $sku,
            'barcode_type' => $request->barcode_type,
            'slug' => $slug,

            'brand' => $brandId,
            'collection' => $request->collection,
            'watch_category' => $request->watch_category,
            'category' => $category,
            // 'sport_type' => $request->sport_type,
            'calendar_type' => $request->calendar_type,
            // 'occasion' => $request->occasion,
            'watch_type' => $watchtypeId,

            'dial_type' => $request->dial_type,
            'dial_colour' => $dialcolorId,
            'dial_diameter' => $request->dial_diameter,
            'case_shape' => $request->case_shape,
            'case_material' => $request->case_material,
            'case_back' => $request->case_back,
            'strap_material' => $request->strap_material,
            'strap_colour' => $strapcolorId,
            'glass_material' => $glassId,
            'bezel' => $request->bezel,
            'bezel_function' => $request->bezel_function,
            'embellishment' => $request->embellishment,
            'clasp_type' => $request->clasp_type,
            'color' => $request->color_id,

            'movement' => $movementId,
            'water_resistance' => $request->water_resistance,
            'functionality' => $request->functionality,
            'brand_warranty' => strtolower($request->brand_warranty) == 'yes' ? 1 : 0,
            'service_card' => strtolower($request->service_card) == 'yes' ? 1 : 0,
            'year_of_card' => $request->warranty_card_year,
            'show_yearcard' => $request->show_yearcard ? 1 : 0,

            'box' => $request->has_box,
            'paper' => $request->has_papers,
            'hsn_code' => $request->hsn_code,
            'origin_country' => $request->country_of_origin_id,
            'manufacturer' => $manufacturerId,
            'packers' => $request->packer,
            'unit' => $request->unit,

            'condition' => $request->condition,
            'purchase_date' => $request->purchase_date,
            // 'business_location' => $request->business_location_id,
            'business_location' => null,
            'display_location' => $display_location_string,
            'physical_location' => $physicalLocation,
            'shop_warranty' => $request->shop_warranty,

            'admin_exclusive' => $request->admin_exclusive ? 1 : 0,
            'new_arrival' => $request->new_arrival ? 1 : 0,
            'manage_stock' => $request->manage_stock ? 1 : 0,
            'out_stock' => $request->out_of_stock ? 1 : 0,
            'not_for_selling' => $request->not_for_selling ? 1 : 0,
            'tata_cliq_product' => $request->tatacliqproduct ? 1 : 0,

            'quantity' => $request->quantity,
            'product_desc' => $request->description,

            // IMPORTANT: DB references only
            'pro_image' => $main_image,
            'pro_gallery' => $gallery_string,
            'pro_brochure' => $brochure_name,

            'video_type' => $request->video_type,
            'video_source' => $video_source,
            'enable_imei' => $request->enable_imei ? 1 : 0,

            'pro_tax' => $request->tax_rate,
            'product_type' => $request->variant_type,
            'selling_tax_type' => $request->selling_price_tax_type,
            'purchase_type' => $request->purchase_type,
            'purchase_price_inclusive' => $request->purchase_price_inc_tax,
            'purchase_price_exclusive' => $request->purchase_price_exc_tax,
            'pro_margin' => $request->profit_margin,
            'selling_price_exclusive' => $request->selling_price_exc_tax,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            // 'approval_status' => (Session::get('login_type') === 'super_admin') ? 1 : 0,
            'status' => 0,
            'store_owner' => $storeOwner,
            'created_by' => $currentUserId,
            'updated_by' => $currentUserId,

        ];

        /* ===================== INSERT / UPDATE ===================== */
        /* ===================== INSERT / UPDATE ===================== */

        if ($product) {

            // ✅ UPDATE (approval_status unchanged)
            $product->update($data);


            activity_log(
                'product',
                'product_update',
                json_encode([
                    'pro_sku' => $product->pro_sku,
                    'product_name' => $product->pro_name,
                    'status' => 'Product Updated',
                ]),
                current_user_id()
            );
            $redirectUrl = ($request->product_type === 'auction')
                ? route('auction.view')
                : null;

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'redirect' => $redirectUrl,
            ]);
        }

        /* ===================== CREATE ===================== */

        $data['approval_status'] =
            (Session::get('login_type') === 'super_admin') ? 1 : 0;

        $product = ProductModel::create($data);

        activity_log(
            'product',
            'product_create',
            json_encode([
                'product_sku' => $product->pro_sku,
                'product_name' => $request->product_name,
                'status' => 'New Product Created',
            ]),
            current_user_id()
        );
        /* ===== SEND EMAIL + NOTIFICATION ===== */
        if (! empty($storeOwner)) {

            $smtp = set_smtp_config();

            if ($smtp) {

                $subject = 'New Product Submitted for Approval: ' . $request->product_name;

                $body = view('emails.product_created', [
                    'product' => (object) [
                        'name' => $request->product_name,
                        'sku' => $sku,
                        'submitted_by' => full_name($storeOwner),
                    ],
                    'submitted_by' => full_name($storeOwner),
                    'actual_url' => url(''),
                ])->render();

                send_multi_recipient_mail($subject, $body);
            }

            create_notification(
                'Product',
                "New Product For Approval :- {$request->product_name}",
                $storeOwner
            );
        }

        /* ===== REDIRECT DECISION ===== */

        $redirectUrl = null;

        if ($data['approval_status'] == 0) {
            // Pending product
            $redirectUrl = route('pendingproduct.view');
        } elseif ($request->product_type === 'auction') {
            $redirectUrl = route('auction.view');
        }

        /* ===== FINAL RESPONSE ===== */

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully',
            'redirect' => $redirectUrl,
        ]);
    }

    public function list(Request $request)
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

        // ✅ Base Query
        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name'
        )
            ->addSelect([
                DB::raw("(
        SELECT GROUP_CONCAT(bl.name ORDER BY
            CASE
                WHEN FIND_IN_SET(bl.bl_id, mst_product.physical_location) THEN 1
                WHEN FIND_IN_SET(bl.bl_id, mst_product.display_location) THEN 2
                ELSE 3
            END
        SEPARATOR ', ')
        FROM tbl_bussiness_location bl
        WHERE
            FIND_IN_SET(bl.bl_id, mst_product.physical_location)
            OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
    ) as location_name"),
            ])

            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->when(!all_admin(), function ($q) {
                $q->where('mst_product.admin_exclusive', 0);
            })
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where('mst_product.approval_status', 1)
            ->where('mst_product.status', 0)
            ->orderBy('mst_product.pro_id', 'DESC');

        // ✅ Apply Staff Location Access Filter Here
        if (Session::get('login_type') === 'staff') {



            $allowedLocationIds = access_locations()->pluck('bl_id')->toArray();

            if (!empty($allowedLocationIds)) {

                $query->where('mst_product.out_stock', 0); // ✅ only in stock products

                $query->where(function ($q) use ($allowedLocationIds) {
                    foreach ($allowedLocationIds as $locId) {
                        $q->orWhere(function ($sub) use ($locId) {
                            $sub->whereRaw(
                                'FIND_IN_SET(?, mst_product.physical_location)',
                                [$locId]
                            )->orWhereRaw(
                                'FIND_IN_SET(?, mst_product.display_location)',
                                [$locId]
                            );
                        });
                    }
                });
            } else {
                $query->whereRaw('1=0');
            }
        }

        // ✅ Total Records Before Filtering
        $totalData = $query->count();
        $totalFiltered = $totalData;

        // ✅ Pagination Variables
        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        // ✅ Global Search
        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('mst_product.pro_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_product.pro_sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_brand.brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_product.category', 'LIKE', "%{$searchValue}%");
            });
        }

        // ✅ Custom Filters (From Apply Filter Button)

        // Filter: Model Name
        if ($request->filled('model_name')) {
            $query->where('mst_product.pro_model_name', 'LIKE', '%' . $request->model_name . '%');
        }

        // Filter: Model Number
        if ($request->filled('model_number')) {
            $query->where('mst_product.pro_model', 'LIKE', '%' . $request->model_number . '%');
        }

        // Filter: SKU
        if ($request->filled('sku')) {
            $query->where('mst_product.pro_sku', 'LIKE', '%' . $request->sku . '%');
        }

        // Filter: Brand
        if ($request->filled('brand')) {
            $query->where('mst_product.brand', $request->brand);
        }

        // Filter: Business Location (Comma separated IDs)
        if ($request->filled('business_location')) {
            $query->whereRaw('FIND_IN_SET(?, mst_product.physical_location)', [
                $request->business_location,
            ]);
        }

        // Filter: Stock
        // if ($request->filled('stock')) {

        //     if ($request->stock == 'in') {
        //         $query->where('mst_product.quantity', '>', 0);
        //     }

        //     if ($request->stock == 'out') {
        //         $query->where('mst_product.quantity', '=', 0);
        //     }
        // }

        if ($request->filled('stock')) {

            if ($request->stock === 'in') {
                $query->where('mst_product.out_stock', 0);
            }

            if ($request->stock === 'out') {
                $query->where('mst_product.out_stock', 1);
            }
        }
        // ✅ Update Filter Count After All Filters
        $totalFiltered = $query->count();

        // ✅ Ordering
        $orderColumn = $columns[$orderColumnIndex] ?? 'pro_id';
        $query->orderBy($orderColumn, $orderDirection);

        // ✅ Pagination Apply
        if ($limit != -1) {
            $query->offset($start)->limit($limit);
        }

        // ✅ Fetch Data
        $data = $query->get();

        // ✅ Format Data for DataTable
        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // ✅ Default Image Placeholder
            $imageHtml = '
        <div class="d-flex align-items-center justify-content-center bg-light border rounded"
             style="width:50px;height:50px;">
            <i class="bx bx-image text-muted fs-4"></i>
        </div>';

            // ✅ If Product Image Exists
            if ($row->pro_image && $row->brand_name) {

                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name);
                $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name);

                $actual_url = config('app.actual_url');

                $relativePath = $actual_url . '/admin_assets/brand/' .
                    $brandFolder . '/' .
                    $productFolder . '/image/' .
                    $row->pro_image;

                $imageHtml = '
            <a href="' . $relativePath . '" target="_blank">
                <img src="' . $relativePath . '"
                     style="width:50px;height:50px;object-fit:cover;border-radius:5px;border:1px solid #eee;">
            </a>';
            }

            // ✅ Badges
            $boxBadge = (strtolower($row->box) === 'yes')
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            $paperBadge = (strtolower($row->paper) === 'yes')
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            // ✅ Action Buttons
            // ✅ Check User Role
            $isSuperAdmin = (current_user_id() === -1);

            // ✅ Always Show View Button
            $actionButtons = '
            <div class="d-flex gap-2 justify-content-center">
                <button type="button"
                    class="btn btn-icon btn-info-light rounded-pill btn-wave viewProduct"
                    data-id="' . $row->pro_id . '" title="View">
                    <i class="bx bx-show"></i>
                </button>';

            // ✅ Only Super Admin Can Edit/Delete
            if ($isSuperAdmin) {

                $actionButtons .= '
                <button type="button"
                    class="btn btn-icon btn-primary-light rounded-pill btn-wave editProduct"
                    data-id="' . $row->pro_id . '" title="Edit">
                    <i class="bx bx-edit"></i>
                </button>

                <button type="button"
                    class="btn btn-icon btn-danger-light rounded-pill btn-wave deleteProduct"
                    data-id="' . $row->pro_id . '"
                    data-name="' . htmlspecialchars($row->pro_name, ENT_QUOTES) . '"
                    title="Delete">
                    <i class="bx bx-trash"></i>
                </button>

                    <button type="button"
        class="btn btn-icon btn-success-light rounded-pill btn-wave addStock"
        data-id="' . $row->pro_id . '"
        data-name="' . htmlspecialchars($row->pro_name, ENT_QUOTES) . '"
        title="Add or Edit Stock">
        <i class="bx bx-plus"></i>
    </button>
       <button type="button"
    class="btn btn-icon btn-warning-light rounded-pill btn-wave duplicateProduct"
   data-id="' . $row->pro_id . '" title="Duplicate">
    <i class="bx bx-duplicate"></i>
</button>
    ';
            }

            // ✅ Close Div
            $actionButtons .= '</div>';

            // ✅ Location Bullet List Output
            $locationHtml = $row->location_name
                ? collect(explode(',', $row->location_name))
                ->map(fn($loc) => '• ' . e(trim($loc)))
                ->implode('<br>')
                : '-';

            // $locations = [];

            // if (!empty($row->display_location)) {
            //     $locations[] = '• ' . e($row->display_location);
            // }

            // if (!empty($row->physical_location)) {
            //     $locations[] = '• ' . e($row->physical_location);
            // }

            // $businessLocation = !empty($locations)
            //     ? implode('<br>', $locations)
            //     : '-';

            // ✅ Final Row Data
            $formattedData[] = [
                'sr_no' => $sr_no++,
                'pro_image' => $imageHtml,
                'pro_name' => e($row->pro_name),
                'brand' => e($row->brand_name),
                'category' => e($row->category),
                'pro_sku' => e($row->pro_sku),
                'out_stock' => e($row->out_stock),
                'not_for_selling' => e($row->not_for_selling),
                'business_location' => $locationHtml,
                'purchase_price' => indian_number_format($row->purchase_price_exclusive, 2),
                'selling_price' => indian_number_format($row->selling_price_exclusive, 2),
                'box' => $boxBadge,
                'paper' => $paperBadge,
                'action' => $actionButtons,
            ];
        }

        // ✅ Return JSON Response
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData,
        ]);
    }

    public function edit($id)
    {
        $product = ProductModel::select('mst_product.*', 'mst_brand.brand_name')
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->where('mst_product.pro_id', $id)
            ->first();

        if ($product) {
            $product->brand_folder = preg_replace('/[^A-Za-z0-9\-]/', '_', $product->brand_name);
            $product->product_folder = preg_replace('/[^A-Za-z0-9\-]/', '_', $product->pro_name);

            return response()->json([
                'status' => 200,
                'data' => $product,
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Product not found',
        ]);
    }

    public function show($id)
    {
        // Fetch all details with joined names for display
        $product = ProductModel::select(
            'mst_product.*',
            'b.brand_name',
            'manu.brand_name as manufacturer_name',
            // 'bl.name as location_name',
            'm.title as movement_name',
            'wt.title as watch_type_name',
            'gm.title as glass_name',
            'c.title as color_name',
            'c2.title as dial_color_name',
            'co.name as origin_country_name'
        )
            ->leftJoin('mst_brand as b', 'mst_product.brand', '=', 'b.brand_id')
            ->leftJoin('mst_brand as manu', 'mst_product.manufacturer', '=', 'manu.brand_id')
            // ->leftJoin('tbl_bussiness_location as bl', 'mst_product.business_location', '=', 'bl.bl_id')
            ->leftJoin('mst_movement as m', 'mst_product.movement', '=', 'm.m_id')
            ->leftJoin('mst_watch_type as wt', 'mst_product.watch_type', '=', 'wt.wt_id')
            ->leftJoin('mst_glass_material as gm', 'mst_product.glass_material', '=', 'gm.gm_id')
            ->leftJoin('mst_color as c', 'mst_product.color', '=', 'c.color_id')
            ->leftJoin('mst_color as c2', 'mst_product.dial_colour', '=', 'c2.color_id')
            ->leftJoin('mst_country as co', 'mst_product.origin_country', '=', 'co.id')
            ->where('mst_product.pro_id', $id)
            ->first();

        if ($product) {
            // Generate folder name for images matching the store logic
            $product->brand_folder = preg_replace('/[^A-Za-z0-9\-]/', '_', $product->brand_name);
            $product->product_folder = preg_replace('/[^A-Za-z0-9\-]/', '_', $product->pro_name);

            // $locationNames = '-';
            // if ($product->business_location) {
            //     $ids = explode(',', $product->business_location);
            //     $locationNames = DB::table('tbl_bussiness_location')
            //         ->whereIn('bl_id', $ids)
            //         ->pluck('name')
            //         ->implode(', ');
            // }
            // $product->location_name = $locationNames;

            // Fetch Display Location Names (Multiple)
            $displayLocNames = '-';
            if ($product->display_location) {
                $ids = explode(',', $product->display_location);
                $displayLocNames = DB::table('tbl_bussiness_location')
                    ->whereIn('bl_id', $ids)
                    ->pluck('name')
                    ->implode(', ');
            }
            $product->display_location_name = $displayLocNames;

            // Fetch Physical Location Name (Single)
            $physicalLocName = '-';
            if ($product->physical_location) {
                $physicalLocName = DB::table('tbl_bussiness_location')
                    ->where('bl_id', $product->physical_location)
                    ->value('name') ?? '-';
            }
            $product->physical_location_name = $physicalLocName;

            return response()->json(['status' => 200, 'data' => $product]);
        }

        return response()->json(['status' => 404, 'message' => 'Product not found']);
    }

    public function delete(Request $request)
    {
        $product = ProductModel::where('pro_id', $request->id)->first();

        if ($product) {

            $product->update([
                'status' => 1,
            ]);

            activity_log(
                'product',
                'product_delete',
                json_encode([
                    'product_sku' => $product->pro_sku,
                    'product_name' => $product->pro_name,
                    'status' => 'Product Deleted',
                ]),
                current_user_id()
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed successfully',
        ]);
    }

    // Product List
    public function view()
    {
        $page_title = 'Products';

        return view('products.view', compact('page_title'));
    }

    public function viewProduct(Request $request)
    {
        $columns = [
            0 => 'pro_id',
            1 => 'pro_image',
            2 => 'pro_name',
            3 => 'brand_name', // alias from join
            4 => 'category',
            5 => 'pro_sku',
            6 => 'location_name', // alias from join
            7 => 'purchase_price_exclusive',
            8 => 'selling_price_exclusive',
            9 => 'box',
            10 => 'paper',
            11 => 'action',
        ];

        // Base Query with Joins
        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name',

        )
            ->addSelect([
                DB::raw("(
        SELECT GROUP_CONCAT(bl.name ORDER BY
            CASE
                WHEN FIND_IN_SET(bl.bl_id, mst_product.physical_location) THEN 1
                WHEN FIND_IN_SET(bl.bl_id, mst_product.display_location) THEN 2
                ELSE 3
            END
        SEPARATOR ', ')
        FROM tbl_bussiness_location bl
        WHERE
            FIND_IN_SET(bl.bl_id, mst_product.physical_location)
            OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
    ) as location_name"),
            ])
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->leftJoin('tbl_bussiness_location', 'mst_product.business_location', '=', 'tbl_bussiness_location.bl_id')
            // ->where('pro_type', 'product')
            // ->where('tata_cliq_product', '!=', 1)
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where('approval_status', '=', 1)
            ->where('mst_product.status', 0); // Assuming 0 is active

        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Search
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('pro_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('pro_sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_brand.brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('category', 'LIKE', "%{$searchValue}%");
            });
            $totalFiltered = $query->count();
        }

        // Ordering
        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $orderColumn = $columns[$orderColumnIndex] ?? 'pro_id';
        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();
        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // Image Logic
            $imageHtml = '<div class="d-flex align-items-center justify-content-center bg-light border rounded" style="width:50px;height:50px;">
                            <i class="bx bx-image text-muted fs-4"></i>
                          </div>';

            // Check for real image
            if ($row->pro_image && $row->brand_name) {
                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name);
                $ProductFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name);

                // Define the relative path
                $actual_url = config('app.actual_url');

                $relativePath = $actual_url
                    . '/admin_assets/brand/'
                    . $brandFolder . '/'
                    . $ProductFolder . '/image/'
                    . $row->pro_image;

                $imageHtml = '
<a href="' . $relativePath . '" target="_blank">
    <img src="' . $relativePath . '"
         alt="Img"
         style="width:50px;height:50px;object-fit:cover;border-radius:5px;border:1px solid #eee;">
</a>';
            }

            // Badges
            $boxBadge = ($row->box == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';
            $paperBadge = ($row->paper == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';

            // Action Button
            $actionButtons = '
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-icon btn-info-light rounded-pill btn-wave viewProduct"
                    data-id="' . $row->pro_id . '" title="View Details">
                    <i class="bx bx-show"></i>
                </button>

            </div>';

            $locationHtml = $row->location_name
                ? collect(explode(',', $row->location_name))
                ->map(fn($loc) => '• ' . e(trim($loc)))
                ->implode('<br>')
                : '-';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'pro_image' => $imageHtml,
                'pro_name' => e($row->pro_name),
                'brand' => e($row->brand_name),
                'category' => e($row->category),
                'pro_sku' => e($row->pro_sku),
                'business_location' => $locationHtml,
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

    // Auction Product List
    public function auction_view()
    {
        $page_title = 'Auctions';

        $store_location = access_locations();

        $brand_data = BrandModel::where('status', 0)->get();
        $movement_data = MovementModel::where('status', 0)->get();
        $watchtype_data = WatchTypeModel::where('status', 0)->get();
        $glassmaterial_data = GlassMaterialModel::where('status', 0)->get();
        $color_data = ColorModel::where('status', 0)->get();

        $country_data = MstCountryModel::get();

        return view('products.auction_view', compact('page_title', 'store_location', 'brand_data', 'movement_data', 'watchtype_data', 'glassmaterial_data', 'color_data', 'country_data'));
    }

    public function viewAuction(Request $request)
    {
        $columns = [
            0 => 'pro_id',
            1 => 'pro_image',
            2 => 'pro_name',
            3 => 'brand_name', // alias from join
            4 => 'category',
            5 => 'pro_sku',
            6 => 'location_name', // alias from join
            7 => 'purchase_price_exclusive',
            8 => 'selling_price_exclusive',
            9 => 'box',
            10 => 'paper',
            11 => 'action',
        ];

        // Base Query with Joins
        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name',

        )
            ->addSelect([
                DB::raw("(
        SELECT GROUP_CONCAT(bl.name ORDER BY
            CASE
                WHEN FIND_IN_SET(bl.bl_id, mst_product.physical_location) THEN 1
                WHEN FIND_IN_SET(bl.bl_id, mst_product.display_location) THEN 2
                ELSE 3
            END
        SEPARATOR ', ')
        FROM tbl_bussiness_location bl
        WHERE
            FIND_IN_SET(bl.bl_id, mst_product.physical_location)
            OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
    ) as location_name"),
            ])
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->leftJoin('tbl_bussiness_location', 'mst_product.business_location', '=', 'tbl_bussiness_location.bl_id')
            ->when(!all_admin(), function ($q) {
                $q->where('mst_product.admin_exclusive', 0);
            })
            // ->where('pro_type', 'auction')
            ->whereRaw("FIND_IN_SET('auction', mst_product.pro_type)")
            // ->where('tata_cliq_product', '!=', 1)
            ->where('approval_status', '=', 1)
            ->where('mst_product.status', 0); // Assuming 0 is active

        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Search
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('pro_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('pro_sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_brand.brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('category', 'LIKE', "%{$searchValue}%");
            });
            $totalFiltered = $query->count();
        }

        // Ordering
        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $orderColumn = $columns[$orderColumnIndex] ?? 'pro_id';
        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();
        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // Image Logic
            $imageHtml = '<div class="d-flex align-items-center justify-content-center bg-light border rounded" style="width:50px;height:50px;">
                            <i class="bx bx-image text-muted fs-4"></i>
                          </div>';

            // Check for real image
            if ($row->pro_image && $row->brand_name) {
                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name);
                $ProductFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name);

                // Define the relative path
                $actual_url = config('app.actual_url');

                $relativePath = $actual_url
                    . '/admin_assets/brand/'
                    . $brandFolder . '/'
                    . $ProductFolder . '/image/'
                    . $row->pro_image;

                $imageHtml = '
            <a href="' . $relativePath . '" target="_blank">
                <img src="' . $relativePath . '"
                    alt="Img"
                    style="width:50px;height:50px;object-fit:cover;border-radius:5px;border:1px solid #eee;">
            </a>';
            }

            // Badges
            $boxBadge = ($row->box == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';
            $paperBadge = ($row->paper == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';

            // Action Button
            $actionButtons = '
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-icon btn-info-light rounded-pill btn-wave viewProduct"
                    data-id="' . $row->pro_id . '" title="View Details">
                    <i class="bx bx-show"></i>
                </button>

                 <button type="button"
                    class="btn btn-icon btn-primary-light rounded-pill btn-wave editAuction"
                    data-id="' . $row->pro_id . '" title="Edit">
                    <i class="bx bx-edit"></i>
                </button>

                <button type="button"
                    class="btn btn-icon btn-danger-light rounded-pill btn-wave deleteAuction"
                    data-id="' . $row->pro_id . '"
                    data-name="' . htmlspecialchars($row->pro_name, ENT_QUOTES) . '"
                    title="Delete">
                    <i class="bx bx-trash"></i>
                </button>

            </div>';

            $locationHtml = $row->location_name
                ? collect(explode(',', $row->location_name))
                ->map(fn($loc) => '• ' . e(trim($loc)))
                ->implode('<br>')
                : '-';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'pro_image' => $imageHtml,
                'pro_name' => e($row->pro_name),
                'brand' => e($row->brand_name),
                'category' => e($row->category),
                'pro_sku' => e($row->pro_sku),
                'business_location' => $locationHtml,
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

    // tata cliq Product

    public function tatacliq_view()
    {
        $page_title = 'Tata Cliq Products';

        return view('products.tatacliq_view', compact('page_title'));
    }

    public function viewtatacliq(Request $request)
    {
        $columns = [
            0 => 'pro_id',
            1 => 'pro_image',
            2 => 'pro_name',
            3 => 'brand_name', // alias from join
            4 => 'category',
            5 => 'pro_sku',
            6 => 'location_name', // alias from join
            7 => 'purchase_price_exclusive',
            8 => 'selling_price_exclusive',
            9 => 'box',
            10 => 'paper',
            11 => 'action',
        ];

        // Base Query with Joins
        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name',
            'mst_brand.brand_name as manufacturer',
            'mst_watch_type.title as watch_type',
            'mst_color.title as dial_colour',
            'mst_color.title as strap_colour',
            'mst_glass_material.title as glass_material',
            'mst_movement.title as movement',
            'mst_country.name as origin_country'
        )

            // 🔹 Show location name ONLY if Tata Cliq ID is present
            ->addSelect([DB::raw("( SELECT GROUP_CONCAT( bl.name ORDER BY CASE WHEN FIND_IN_SET(bl.bl_id, mst_product.physical_location) THEN 1 WHEN FIND_IN_SET(bl.bl_id, mst_product.display_location) THEN 2 ELSE 3 END SEPARATOR ', ' ) FROM tbl_bussiness_location bl WHERE FIND_IN_SET(bl.bl_id, mst_product.physical_location) OR FIND_IN_SET(bl.bl_id, mst_product.display_location) ) as location_name")])
            // 🔗 Joins
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->leftJoin('mst_country', 'mst_product.origin_country', '=', 'mst_country.id')
            ->leftJoin('mst_movement', 'mst_product.movement', '=', 'mst_movement.m_id')
            ->leftJoin('mst_glass_material', 'mst_product.glass_material', '=', 'mst_glass_material.gm_id')
            ->leftJoin('mst_color', 'mst_product.dial_colour', '=', 'mst_color.color_id')
            ->leftJoin('mst_watch_type', 'mst_product.watch_type', '=', 'mst_watch_type.wt_id')

            // 🔥 HARD FILTER – PRODUCT MUST BELONG TO TATA CLIQ
            ->whereRaw("
    EXISTS (
        SELECT 1
        FROM tbl_bussiness_location bl
        WHERE bl.name = 'Tata Cliq'
          AND (
              FIND_IN_SET(bl.bl_id, mst_product.physical_location)
              OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
          )
    )
")
            ->where('mst_product.status', 0)
            ->where('mst_product.approval_status', 1);


        // Assuming 0 is active

        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Search
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('pro_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('pro_sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_brand.brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('category', 'LIKE', "%{$searchValue}%");
            });
            $totalFiltered = $query->count();
        }

        // Ordering
        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $orderColumn = $columns[$orderColumnIndex] ?? 'pro_id';
        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();
        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // Image Logic
            $imageHtml = '<div class="d-flex align-items-center justify-content-center bg-light border rounded" style="width:50px;height:50px;">
                            <i class="bx bx-image text-muted fs-4"></i>
                          </div>';

            // Check for real image
            if ($row->pro_image && $row->brand_name) {
                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name);
                $ProductFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name);

                // Define the relative path
                $actual_url = config('app.actual_url');

                $relativePath = $actual_url
                    . '/admin_assets/brand/'
                    . $brandFolder . '/'
                    . $ProductFolder . '/image/'
                    . $row->pro_image;

                $imageHtml = '
<a href="' . $relativePath . '" target="_blank">
    <img src="' . $relativePath . '"
         alt="Img"
         style="width:50px;height:50px;object-fit:cover;border-radius:5px;border:1px solid #eee;">
</a>';
            }

            $locationHtml = $row->location_name
                ? collect(explode(',', $row->location_name))
                ->map(fn($loc) => '• ' . e(trim($loc)))
                ->implode('<br>')
                : '-';

            // Badges
            $boxBadge = (strtolower($row->box) === 'yes')
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            $paperBadge = (strtolower($row->paper) === 'yes')
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            $BrandwBadge = ($row->brand_warranty == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';
            $servicecardBadge = ($row->service_card == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';

            $currentUserId = current_user_id();
            $storeOwner = ($currentUserId === -1) ? null : $currentUserId;
            // Action Button
            $actionButtons = '
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-icon btn-info-light rounded-pill btn-wave viewProduct"
                    data-id="' . $row->pro_id . '" title="View Details">
                    <i class="bx bx-show"></i>
                </button>

            </div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'pro_image' => $imageHtml,
                'pro_name' => e($row->pro_name),
                'brand' => e($row->brand_name),
                'category' => e($row->category),
                'pro_sku' => e($row->pro_sku),
                'business_location' => $locationHtml,
                'purchase_price' => indian_number_format($row->purchase_price_exclusive, 2),
                'selling_price' => indian_number_format($row->selling_price_exclusive, 2),
                'box' => $boxBadge,
                'paper' => $paperBadge,
                // Hidden Columns (11-59) - Add all fields from your JS columns list here
                // Fillable Sequence Fields
                'pro_type' => $row->pro_type,
                'pro_model' => $row->pro_model,
                'pro_gender' => $row->pro_gender,
                'pro_model_name' => $row->pro_model_name,
                'pro_ref_num' => $row->pro_ref_num,
                'barcode_type' => $row->barcode_type,
                'slug' => $row->slug,
                'watch_category' => $row->watch_category,
                'calendar_type' => $row->calendar_type,
                'occasion' => $row->occasion,
                'collection' => $row->collection,
                'sport_type' => $row->sport_type,
                'watch_type' => $row->watch_type,
                'dial_type' => $row->dial_type,
                'dial_colour' => $row->dial_colour,
                'dial_diameter' => $row->dial_diameter,
                'case_shape' => $row->case_shape,
                'case_material' => $row->case_material,
                'case_back' => $row->case_back,
                'strap_material' => $row->strap_material,
                'strap_colour' => $row->strap_colour,
                'glass_material' => $row->glass_material,
                'bezel' => $row->bezel,
                'bezel_function' => $row->bezel_function,
                'embellishment' => $row->embellishment,
                'clasp_type' => $row->clasp_type,
                // 'color' => $row->color,
                'movement' => $row->movement,
                'water_resistance' => $row->water_resistance,
                'functionality' => $row->functionality,
                'brand_warranty' => $BrandwBadge,
                'service_card' => $servicecardBadge,
                'year_of_card' => $row->year_of_card,
                'hsn_code' => $row->hsn_code,
                'origin_country' => $row->origin_country,
                'manufacturer' => $row->manufacturer,
                'packers' => $row->packers,
                'unit' => $row->unit,
                'condition' => $row->condition,
                'purchase_date' => $row->purchase_date,
                'shop_warranty' => $row->shop_warranty,
                'new_arrival' => $row->new_arrival,
                'manage_stock' => $row->manage_stock,
                'out_stock' => $row->out_stock,
                'not_for_selling' => $row->not_for_selling,
                'tata_cliq_product' => $row->tata_cliq_product,
                'quantity' => $row->quantity,
                'product_desc' => strip_tags($row->product_desc),
                'pro_image_hidden' => $row->pro_image,
                'pro_gallery' => $row->pro_gallery,
                'pro_brochure' => $row->pro_brochure,
                'video_type' => $row->video_type,
                'video_source' => $row->video_source,
                'enable_imei' => $row->enable_imei,
                'pro_tax' => $row->pro_tax,
                'product_type' => $row->product_type,
                'selling_tax_type' => $row->selling_tax_type,
                'purchase_price_inclusive' => $row->purchase_price_inclusive,
                'purchase_price_exclusive' => $row->purchase_price_exclusive,
                'pro_margin' => $row->pro_margin,
                'selling_price_exclusive' => $row->selling_price_exclusive,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'approval_status' => $row->approval_status,
                'status' => $row->status,
                'store_owner' => $storeOwner,
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

    // By faazil (product search - stock)
    public function search(Request $request)
    {
        $search = $request->get('q');
        $locationId = $request->get('location_id');

        // dd($locationId);

        // ✅ Staff Allowed Location IDs
        $allowedLocationIds = access_locations()->pluck('bl_id')->toArray();

        $products = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name'
        )
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')

            // 🔍 Search group (IMPORTANT)
            ->where(function ($q) use ($search) {
                $q->where('mst_product.pro_name', 'LIKE', "%{$search}%")
                    ->orWhere('mst_product.pro_sku', 'LIKE', "%{$search}%");
            })
            ->when(!all_admin(), function ($q) {
                $q->where('mst_product.admin_exclusive', 0);
            })
            ->where('mst_product.approval_status', 1)
            ->where('out_stock', 0)
            ->where('mst_product.status', 0);

        // ✅ Filter by selected location (SINGLE value, comma-separated column)
        if (! empty($locationId)) {
            $products->whereRaw(
                'FIND_IN_SET(?, mst_product.physical_location)',
                [$locationId]
            );
        }

        // ✅ Staff Restriction (comma-separated fix)
        if (Session::get('login_type') === 'staff') {

            if (! empty($allowedLocationIds)) {

                $products->where(function ($q) use ($allowedLocationIds) {
                    foreach ($allowedLocationIds as $locId) {
                        $q->orWhereRaw(
                            'FIND_IN_SET(?, mst_product.physical_location)',
                            [$locId]
                        );
                    }
                });
            } else {
                // ❌ No access → return empty
                $products->whereRaw('1 = 0');
            }
        }

        // ✅ Limit Results
        $products = $products->limit(10)->get();

        // ✅ Format Response
        $results = [];

        foreach ($products as $pro) {

            $imageUrl = null;

            if ($pro->pro_image && $pro->brand_name) {

                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $pro->brand_name);
                $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $pro->pro_name);

                $imageUrl = config('app.actual_url')
                    . '/admin_assets/brand/'
                    . $brandFolder . '/'
                    . $productFolder . '/image/'
                    . $pro->pro_image;
            }

            $results[] = [
                'id' => $pro->pro_id,
                'name' => $pro->pro_name,
                'hsn_code' => $pro->hsn_code,
                'pro_sku' => $pro->pro_sku,
                'product_desc' => $pro->product_desc,
                'image' => $imageUrl,
                'price' => $pro->selling_price_exclusive,
                'unit' => $pro->unit,
                'out_stock' => $pro->out_stock,
            ];
        }

        return response()->json($results);
    }

    // Pending Product
    public function pendingproduct()
    {

        $page_title = 'Pending Product';

        $store_location = access_locations();

        $brand_data = BrandModel::where('status', 0)->get();
        $movement_data = MovementModel::where('status', 0)->get();
        $watchtype_data = WatchTypeModel::where('status', 0)->get();
        $glassmaterial_data = GlassMaterialModel::where('status', 0)->get();
        $color_data = ColorModel::where('status', 0)->get();

        $country_data = MstCountryModel::get();

        return view('products.pending_products', compact('page_title', 'brand_data', 'store_location', 'movement_data', 'watchtype_data', 'glassmaterial_data', 'color_data', 'country_data'));
    }

    public function viewPendingProducts(Request $request)
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

        // ✅ Base Query
        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name'
        )
            ->addSelect([
                DB::raw("(
        SELECT GROUP_CONCAT(bl.name ORDER BY
            CASE
                WHEN FIND_IN_SET(bl.bl_id, mst_product.physical_location) THEN 1
                WHEN FIND_IN_SET(bl.bl_id, mst_product.display_location) THEN 2
                ELSE 3
            END
        SEPARATOR ', ')
        FROM tbl_bussiness_location bl
        WHERE
            FIND_IN_SET(bl.bl_id, mst_product.physical_location)
            OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
    ) as location_name"),
            ])
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->where('mst_product.approval_status', 0)
            ->where('mst_product.status', 0)
            ->orderBy('mst_product.pro_id', 'DESC');

        // ✅ Staff Location Access Filter
        if (Session::get('login_type') === 'staff') {

            $allowedLocationIds = access_locations()->pluck('bl_id')->toArray();

            if (! empty($allowedLocationIds)) {

                $query->where(function ($q) use ($allowedLocationIds) {

                    foreach ($allowedLocationIds as $locId) {

                        $q->orWhere(function ($sub) use ($locId) {
                            $sub->whereRaw(
                                'FIND_IN_SET(?, mst_product.physical_location)',
                                [$locId]
                            )->orWhereRaw(
                                'FIND_IN_SET(?, mst_product.display_location)',
                                [$locId]
                            );
                        });
                    }
                });
            } else {
                // ❌ Staff has no location access → return no products
                $query->whereRaw('1=0');
            }
        }

        // ✅ Counts
        $totalData = $query->count();
        $totalFiltered = $totalData;

        // ✅ Pagination
        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        // ✅ Search
        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('mst_product.pro_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_product.pro_sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_brand.brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_product.category', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // ✅ Ordering
        $orderColumn = $columns[$orderColumnIndex] ?? 'pro_id';
        $query->orderBy($orderColumn, $orderDirection);

        // ✅ Pagination Apply
        if ($limit != -1) {
            $query->offset($start)->limit($limit);
        }

        // ✅ Fetch Data
        $data = $query->get();

        // ✅ Format Output
        $formattedData = [];
        $sr_no = $start + 1;



        foreach ($data as $row) {

            // ✅ Image Placeholder
            $imageHtml = '
        <div class="d-flex align-items-center justify-content-center bg-light border rounded"
             style="width:50px;height:50px;">
            <i class="bx bx-image text-muted fs-4"></i>
        </div>';

            if ($row->pro_image && $row->brand_name) {

                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name);
                $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name);

                $actual_url = config('app.actual_url');

                $relativePath = $actual_url . '/admin_assets/brand/' .
                    $brandFolder . '/' .
                    $productFolder . '/image/' .
                    $row->pro_image;

                $imageHtml = '
            <a href="' . $relativePath . '" target="_blank">
                <img src="' . $relativePath . '"
                     style="width:50px;height:50px;object-fit:cover;border-radius:5px;border:1px solid #eee;">
            </a>';
            }

            // ✅ Badge Logic
            $boxBadge = ($row->box == 0)
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            $paperBadge = ($row->paper == 0)
                ? '<span class="badge bg-success-transparent">Yes</span>'
                : '<span class="badge bg-danger-transparent">No</span>';

            // ✅ Location Output (Bullet Style)
            $locationHtml = $row->location_name
                ? collect(explode(',', $row->location_name))
                ->map(fn($loc) => '• ' . e(trim($loc)))
                ->implode('<br>')
                : '-';

            // ✅ View + Approve Button Only
            $actionButtons = '
<div class="d-flex gap-2 justify-content-center">

    <!-- ✅ View Button -->
    <button type="button"
        class="btn btn-icon btn-info-light rounded-pill btn-wave viewProduct"
        data-id="' . $row->pro_id . '" title="View">
        <i class="bx bx-show"></i>
    </button>
          <button type="button"
                    class="btn btn-icon btn-primary-light rounded-pill btn-wave editPendingProduct"
                    data-id="' . $row->pro_id . '" title="Edit">
                    <i class="bx bx-edit"></i>
                </button>';

            if (current_user_id() == -1) {

                if ($request->has('from_dashboard') && $request->from_dashboard == 'true') {

                    // ❌ Reject Button (For Dashboard)
                    $actionButtons .= '
                         </button>

                <button type="button"
                    class="btn btn-icon btn-danger-light rounded-pill btn-wave rejectProduct d-none"
                    data-id="' . $row->pro_id . '"
                    data-name="' . e($row->pro_name) . '"
                    title="Reject">
                    <i class="bx bx-x-circle"></i>
                       <button type="button d-none"
                    class="btn btn-icon btn-success-light rounded-pill btn-wave approveProduct d-none"
                    data-id="' . $row->pro_id . '"
                    data-name="' . e($row->pro_name) . '"
                    title="Approve">
                    <i class="bx bx-check-circle"></i>
                </button>


                ';
                } else {

                    // ✅ Approve Button (For Product Pending Page)
                    $actionButtons .= '
                <button type="button"
                    class="btn btn-icon btn-success-light rounded-pill btn-wave approveProduct"
                    data-id="' . $row->pro_id . '"
                    data-name="' . e($row->pro_name) . '"
                    title="Approve">
                    <i class="bx bx-check-circle"></i>

                       <button type="button"
                    class="btn btn-icon btn-danger-light rounded-pill btn-wave rejectProduct"
                    data-id="' . $row->pro_id . '"
                    data-name="' . e($row->pro_name) . '"
                    title="Reject">
                    <i class="bx bx-x-circle"></i>
                </button>';
                }
            }

            $actionButtons .= '
</div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'pro_image' => $imageHtml,
                'pro_name' => e($row->pro_name),
                'brand' => e($row->brand_name),
                'category' => e($row->category),
                'pro_sku' => e($row->pro_sku),
                'business_location' => $locationHtml,
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
    public function rejectProduct(Request $request)
    {
        $product = ProductModel::where('pro_id', $request->pro_id)->first();

        if ($product) {

            $product->update([
                'approval_status' => 2,
            ]);

            activity_log(
                'product',
                'product_reject',
                json_encode([
                    'product_sku' => $product->pro_sku,
                    'product_name' => $product->pro_name,
                    'status' => 'Product Rejected',
                ]),
                current_user_id()
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Rejected Successfully!',
        ]);
    }

    public function approveProduct(Request $request)
    {
        $product = ProductModel::where('pro_id', $request->pro_id)->first();

        if ($product) {

            $product->update([
                'approval_status' => 1,
            ]);

            activity_log(
                'product',
                'product_approve',
                json_encode([
                    'product_sku' => $product->pro_sku,
                    'product_name' => $product->pro_name,
                    'status' => 'Product Approved',
                ]),
                current_user_id()
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Approved Successfully!',
        ]);
    }

    public function inventory()
    {
        $page_title = 'Inventory';
        $store_location = access_locations();
        $brand_data = BrandModel::where('status', 0)->get();

        return view('products.inventory', compact('page_title', 'store_location', 'brand_data'));
    }

    // Inventory DataTable Source
    public function inventoryList(Request $request)
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

        // ✅ Base Query
        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name'
        )
            ->addSelect([
                DB::raw("(
        SELECT GROUP_CONCAT(bl.name ORDER BY
            CASE
                WHEN FIND_IN_SET(bl.bl_id, mst_product.physical_location) THEN 1
                WHEN FIND_IN_SET(bl.bl_id, mst_product.display_location) THEN 2
                ELSE 3
            END
        SEPARATOR ', ')
        FROM tbl_bussiness_location bl
        WHERE
            FIND_IN_SET(bl.bl_id, mst_product.physical_location)
            OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
    ) as location_name"),
            ])
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            // ->where('mst_product.pro_type', 'product')
            ->where('mst_product.approval_status', 1)
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where('mst_product.out_stock', 0)
            ->where('mst_product.status', 0)
            ->orderBy('mst_product.pro_id', 'DESC');

        // ✅ Apply Staff Location Access Filter
        // if (Session::get('login_type') === 'staff') {
        //     $allowedLocationIds = access_locations()->pluck('bl_id')->toArray();
        //     if (! empty($allowedLocationIds)) {
        //         $query->where(function ($q) use ($allowedLocationIds) {
        //             foreach ($allowedLocationIds as $locId) {
        //                 $q->orWhereRaw('FIND_IN_SET(?, mst_product.business_location)', [$locId]);
        //             }
        //         });
        //     } else {
        //         $query->whereRaw('1=0');
        //     }
        // }

        // ✅ Global Search
        $searchValue = $request->input('search.value');
        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('mst_product.pro_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_product.pro_sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_brand.brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('mst_product.category', 'LIKE', "%{$searchValue}%");
            });
        }

        // ✅ Custom Filters
        if ($request->filled('model_name')) {
            $query->where('mst_product.pro_model_name', 'LIKE', '%' . $request->model_name . '%');
        }
        if ($request->filled('model_number')) {
            $query->where('mst_product.pro_model', 'LIKE', '%' . $request->model_number . '%');
        }
        if ($request->filled('sku')) {
            $query->where('mst_product.pro_sku', 'LIKE', '%' . $request->sku . '%');
        }
        if ($request->filled('brand')) {
            $query->where('mst_product.brand', $request->brand);
        }
        if ($request->filled('business_location')) {
            $query->whereRaw('FIND_IN_SET(?, mst_product.physical_location)', [$request->business_location]);
        }
        if ($request->filled('stock')) {
            if ($request->stock == 'in') {
                $query->where('mst_product.out_stock', '=', 0);
            }
            if ($request->stock == 'out') {
                $query->where('mst_product.out_stock', '=', 1);
            }
        }

        // ✅ Pagination & Ordering
        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $orderColumn = $columns[$orderColumnIndex] ?? 'pro_id';

        $query->orderBy($orderColumn, $orderDirection);

        if ($limit != -1) {
            $query->offset($start)->limit($limit);
        }

        $data = $query->get();
        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {
            // Image Logic
            $imageHtml = '<div class="d-flex align-items-center justify-content-center bg-light border rounded" style="width:50px;height:50px;"><i class="bx bx-image text-muted fs-4"></i></div>';
            if ($row->pro_image && $row->brand_name) {
                $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name);
                $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name);
                $relativePath = config('app.actual_url') . '/admin_assets/brand/' . $brandFolder . '/' . $productFolder . '/image/' . $row->pro_image;
                $imageHtml = '<a href="' . $relativePath . '" target="_blank"><img src="' . $relativePath . '" style="width:50px;height:50px;object-fit:cover;border-radius:5px;border:1px solid #eee;"></a>';
            }

            // Badges
            $boxBadge = ($row->box == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';
            $paperBadge = ($row->paper == 0) ? '<span class="badge bg-success-transparent">Yes</span>' : '<span class="badge bg-danger-transparent">No</span>';

            // Location
            $locationHtml = $row->location_name
                ? collect(explode(',', $row->location_name))
                ->map(fn($loc) => '• ' . e(trim($loc)))
                ->implode('<br>')
                : '-';

            // ✅ Action Buttons (VIEW ONLY)
            $actionButtons = '
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-icon btn-info-light rounded-pill btn-wave viewProduct" data-id="' . $row->pro_id . '" title="View"><i class="bx bx-show"></i></button>
            </div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'select' => '<input type="checkbox" class="form-check-input product-check" value="' . $row->pro_id . '">',
                'pro_image' => $imageHtml, // This will be used for UI
                'pro_name' => e($row->pro_name),
                'brand' => e($row->brand_name),
                'category' => e($row->category),
                'pro_sku' => e($row->pro_sku),
                'business_location' => $locationHtml,
                'purchase_price' => indian_number_format($row->purchase_price_exclusive, 2),
                'selling_price' => indian_number_format($row->selling_price_exclusive, 2),
                'box' => $boxBadge,
                'paper' => $paperBadge,
                'action' => $actionButtons,

                // 🟢 NEW: Hidden Fields for Excel (Matching tatacliq_view)
                'pro_type' => $row->pro_type,
                'pro_model' => $row->pro_model,
                'pro_gender' => $row->pro_gender,
                'pro_model_name' => $row->pro_model_name,
                'pro_ref_num' => $row->pro_ref_num,
                'barcode_type' => $row->barcode_type,
                'slug' => $row->slug,
                'watch_category' => $row->watch_category,
                'calendar_type' => $row->calendar_type,
                'occasion' => $row->occasion,
                'collection' => $row->collection,
                'sport_type' => $row->sport_type,
                'watch_type' => $row->watch_type, // Ensure these are joined in query if needed, or raw ID
                'dial_type' => $row->dial_type,
                'dial_colour' => $row->dial_colour,
                'dial_diameter' => $row->dial_diameter,
                'case_shape' => $row->case_shape,
                'case_material' => $row->case_material,
                'case_back' => $row->case_back,
                'strap_material' => $row->strap_material,
                'strap_colour' => $row->strap_colour,
                'glass_material' => $row->glass_material,
                'bezel' => $row->bezel,
                'bezel_function' => $row->bezel_function,
                'embellishment' => $row->embellishment,
                'clasp_type' => $row->clasp_type,
                'movement' => $row->movement,
                'water_resistance' => $row->water_resistance,
                'functionality' => $row->functionality,
                'brand_warranty' => $row->brand_warranty == 0 ? 'Yes' : 'No',
                'service_card' => $row->service_card == 0 ? 'Yes' : 'No',
                'year_of_card' => $row->year_of_card,
                'hsn_code' => $row->hsn_code,
                'origin_country' => $row->origin_country,
                'manufacturer' => $row->manufacturer,
                'packers' => $row->packers,
                'unit' => $row->unit,
                'condition' => $row->condition,
                'purchase_date' => $row->purchase_date,
                'shop_warranty' => $row->shop_warranty,
                'new_arrival' => $row->new_arrival,
                'manage_stock' => $row->manage_stock,
                'out_stock' => $row->out_stock,
                'not_for_selling' => $row->not_for_selling,
                'tata_cliq_product' => $row->tata_cliq_product,
                'quantity' => $row->quantity,
                'product_desc' => strip_tags($row->product_desc),

                // 🟢 EXPORT IMAGE URL (Raw link for Excel)
                'pro_image_hidden' => ($row->pro_image && $row->brand_name) ? config('app.actual_url') . '/admin_assets/brand/' . preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name) . '/' . preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name) . '/image/' . $row->pro_image : '',

                'pro_gallery' => $row->pro_gallery,
                'pro_brochure' => $row->pro_brochure,
                'video_type' => $row->video_type,
                'video_source' => $row->video_source,
                'enable_imei' => $row->enable_imei,
                'pro_tax' => $row->pro_tax,
                'product_type' => $row->product_type,
                'selling_tax_type' => $row->selling_tax_type,
                'purchase_price_inclusive' => $row->purchase_price_inclusive,
                'purchase_price_exclusive' => $row->purchase_price_exclusive,
                'pro_margin' => $row->pro_margin,
                'selling_price_exclusive' => $row->selling_price_exclusive,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'approval_status' => $row->approval_status,
                'status' => $row->status,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData,
        ]);
    }

    // add or edit stokc
    public function fetchStockLocations(Request $request)
    {
        $proId = $request->pro_id;

        // ✅ Fetch product
        $product = ProductModel::where('pro_id', $proId)->first();

        if (! $product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        // ✅ Physical location ID
        $physicalLocationId = $product->physical_location;

        // ✅ Display location IDs (convert to array)
        $displayLocationIds = [];

        if (! empty($product->display_location)) {
            $displayLocationIds = explode(',', $product->display_location);
        }

        // ✅ Fetch all required locations
        $locations = BusinesslocationModel::whereIn(
            'bl_id',
            array_merge([$physicalLocationId], $displayLocationIds)
        )
            ->get()
            ->map(function ($loc) use ($physicalLocationId) {
                return [
                    'bl_id' => $loc->bl_id,
                    'name' => $loc->name,
                    'location_id' => $loc->location_id,
                    'type' => ($loc->bl_id == $physicalLocationId)
                        ? 'physical'
                        : 'display',
                ];
            });

        return response()->json([
            'status' => true,
            'physical_quantity' => $product->quantity,
            'locations' => $locations,
        ]);
    }

    public function addStock(Request $request)
    {
        $note = $request->note; // ✅ notes from JS

        $product = ProductModel::where('pro_id', $request->pro_id)->first();

        if (! $product) {
            return response()->json(['status' => 'error']);
        }

        $newLocationId = (string) $request->location_id;
        $oldPhysicalLocation = (string) $product->physical_location;

        // ✅ Already in same physical location → no update
        if ($oldPhysicalLocation === $newLocationId && (int) $product->out_stock === 0) {
            return response()->json([
                'status' => 'already_added',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Handle display_location swap logic
        |--------------------------------------------------------------------------
        */
        $displayLocations = [];

        if (! empty($product->display_location)) {
            $displayLocations = array_map('trim', explode(',', $product->display_location));
        }

        // ➕ Move OLD physical location into display
        if (! empty($oldPhysicalLocation) && ! in_array($oldPhysicalLocation, $displayLocations, true)) {
            $displayLocations[] = $oldPhysicalLocation;
        }

        // ❌ Remove new physical location from display
        $displayLocations = array_diff($displayLocations, [$newLocationId]);

        $product->display_location = ! empty($displayLocations)
            ? implode(',', $displayLocations)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Update product stock
        |--------------------------------------------------------------------------
        */
        $product->physical_location = $newLocationId;
        $product->quantity = 1;
        $product->out_stock = 0;
        $product->save();

        /*
        |--------------------------------------------------------------------------
        | ✅ INSERT HISTORY (product_stock_report)
        |--------------------------------------------------------------------------
        */
        DB::table('product_stock_report')->insert([
            'pro_id' => $product->pro_id,
            'location_id' => $newLocationId,
            'notes' => $note,
            'status' => 0, // or 'moved'
            'created_by' => current_user_id(), // fallback if no auth
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => 'updated',
        ]);
    }

    public function fetchStockHistory(Request $request)
    {
        $proId = $request->pro_id;

        $history = DB::table('product_stock_report as psr')
            ->leftJoin('tbl_bussiness_location as bl', 'bl.bl_id', '=', 'psr.location_id')
            ->where('psr.pro_id', $proId)
            ->orderBy('psr.created_at', 'desc')
            ->select(
                'psr.psr_id',
                'bl.name as location_name',
                'psr.notes',
                'psr.status',
                'psr.created_by',
                'psr.created_at'
            )
            ->get()
            ->map(function ($row) {

                return [
                    'psr_id' => $row->psr_id,
                    'location_name' => $row->location_name ?? '-',
                    'notes' => $row->notes ?? '-',
                    'status' => $row->status,
                    'created_by' => full_name($row->created_by) ?? 'System',
                    'created_at' => Carbon::parse($row->created_at)
                        ->timezone('Asia/Kolkata')
                        ->format('d-M-Y h:i A'),

                ];
            });

        return response()->json([
            'data' => $history,
        ]);
    }

    //duplicate product
    public function getProductData(Request $request)
    {
        $product = ProductModel::where('pro_id', $request->id)->first();

        return response()->json($product);
    }



    public function duplicateProduct(Request $request)
    {
        $request->validate([
            'pro_model' => 'required',
            'pro_ref_num' => 'required',
            'collection' => 'required',
            'brand' => 'required',
            'sku' => 'required',
            'product_id' => 'required',
            'year_of_card' => 'nullable|date'
        ]);

        $currentUserId = current_user_id();
        $storeOwner = ($currentUserId === -1) ? null : $currentUserId;

        // ✅ GLOBAL SKU CHECK
        $exists = ProductModel::where('pro_sku', $request->sku)->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'sku' => ['This SKU already exists']
                ]
            ], 422);
        }

        // ✅ GET ORIGINAL PRODUCT
        $product = ProductModel::where('pro_id', $request->product_id)->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // ================= IMAGE FOLDER LOGIC =================
        $oldBrand = BrandModel::find($product->brand);
        $newBrand = BrandModel::find($request->brand);

        $oldBrandName = $oldBrand ? preg_replace('/[^A-Za-z0-9\-]/', '_', $oldBrand->brand_name) : null;
        $newBrandName = preg_replace('/[^A-Za-z0-9\-]/', '_', $newBrand->brand_name);

        $productName = preg_replace('/[^A-Za-z0-9\-]/', '_', $product->pro_name);

        $oldPath = public_path("assets/admin_assets/brand/$oldBrandName/$productName");
        $newPath = public_path("assets/admin_assets/brand/$newBrandName/$productName");


        if ($oldBrandName !== $newBrandName) {
            if (File::exists($oldPath)) {
                File::makeDirectory($newPath, 0777, true, true);
                File::copyDirectory($oldPath, $newPath);
            }
        } else {
            File::makeDirectory($newPath, 0777, true, true);
        }

        // ================= DUPLICATE =================
        $newProduct = $product->replicate();

        $newProduct->pro_model = $request->pro_model;
        $newProduct->pro_ref_num = $request->pro_ref_num;
        $newProduct->collection = $request->collection;
        $newProduct->brand = $request->brand;
        $newProduct->pro_sku = $request->sku;

        $newProduct->year_of_card = $request->year_of_card;

        // 🔥 IMPORTANT (LINK ORIGINAL)
        $newProduct->duplicate_ref = $request->product_id;


        $newProduct->store_owner = $storeOwner;
        $newProduct->created_by = $currentUserId;
        $newProduct->updated_by = $currentUserId;

        // status always pending initially
        $newProduct->status = 0;

        // approval logic
        $newProduct->approval_status =
            (Session::get('login_type') === 'super_admin') ? 1 : 0;

        $newProduct->save();

        activity_log(
            'product',
            'product_duplicate',
            json_encode([
                'original_product_sku' => $product->pro_sku,
                'new_product_sku' => $newProduct->pro_sku,
                'product_name' => $product->pro_name,
                'status' => 'Product Duplicated',
            ]),
            current_user_id()
        );

        // ================= EMAIL + NOTIFICATION =================
        if (!empty($storeOwner)) {

            $smtp = set_smtp_config();

            if ($smtp) {

                $emails = EmailModel::where('status', 0)->pluck('email');

                if ($emails->count() > 0) {

                    Mail::send('emails.product_created', [
                        'product' => (object) [
                            'name' => $product->pro_name,
                            'sku' => $request->sku,
                            'submitted_by' => full_name($storeOwner),
                        ],
                        'submitted_by' => full_name($storeOwner),
                        'actual_url' => url(''),
                    ], function ($message) use ($emails, $product) {

                        $message->to($emails->toArray())
                            ->subject('Duplicated Product Pending Approval: ' . $product->pro_name);
                    });
                }
            }

            create_product_notification(
                $product->pro_name,
                $storeOwner
            );
        }

        // ================= REDIRECT =================
        $redirectUrl = null;

        if ($newProduct->approval_status == 0) {
            $redirectUrl = route('pendingproduct.view');
        }

        return response()->json([
            'status' => true,
            'message' => 'Product duplicated successfully & sent for approval',
            'redirect' => $redirectUrl
        ]);
    }


    //export product data
    // public function export(Request $request)
    // {

    //     ini_set('memory_limit', '1024M');
    //     set_time_limit(300);
    //     $query = ProductModel::select(
    //         'mst_product.*',
    //         'mst_brand.brand_name',
    //         'mst_watch_type.title as watch_type_title',
    //         'dial.title as dial_color',
    //         'strap.title as strap_color',
    //         'mst_glass_material.title as glass_type',
    //         'mst_movement.title as movement_type',
    //         'mst_country.name as country_name',
    //         'manufacturer.brand_name as manufacturer_type',
    //         DB::raw("
    //         (
    //             SELECT GROUP_CONCAT(bl.name SEPARATOR ', ')
    //             FROM tbl_bussiness_location bl
    //             WHERE FIND_IN_SET(bl.bl_id, mst_product.physical_location)
    //             OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
    //         ) as location_name
    //     ")
    //     )
    //         ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
    //         ->leftJoin('mst_brand as manufacturer', 'mst_product.manufacturer', '=', 'mst_brand.brand_id')
    //         ->leftjoin('mst_watch_type', 'mst_product.watch_type', '=', 'mst_watch_type.wt_id')
    //         ->leftjoin('mst_color as dial', 'mst_product.dial_colour', '=', 'dial.color_id')
    //         ->leftjoin('mst_color as strap', 'mst_product.strap_colour', '=', 'strap.color_id')
    //         ->leftjoin('mst_glass_material', 'mst_product.glass_material', '=', 'mst_glass_material.gm_id')
    //         ->leftjoin('mst_movement', 'mst_product.movement', '=', 'mst_movement.m_id')
    //         ->leftjoin('mst_country', 'mst_product.origin_country', '=', 'mst_country.id')
    //         ->where('mst_product.pro_type', 'product')
    //         ->where('mst_product.approval_status', 1)
    //         ->where('mst_product.status', 0);

    //     // Filters
    //     if ($request->filled('model_name')) {
    //         $query->where('mst_product.pro_model_name', 'LIKE', '%' . $request->model_name . '%');
    //     }

    //     if ($request->filled('model_number')) {
    //         $query->where('mst_product.pro_model', 'LIKE', '%' . $request->model_number . '%');
    //     }

    //     if ($request->filled('sku')) {
    //         $query->where('mst_product.pro_sku', 'LIKE', '%' . $request->sku . '%');
    //     }

    //     if ($request->filled('brand')) {
    //         $query->where('mst_product.brand', $request->brand);
    //     }

    //     if ($request->filled('business_location')) {
    //         $query->whereRaw(
    //             'FIND_IN_SET(?, mst_product.physical_location)',
    //             [$request->business_location]
    //         );
    //     }

    //     if ($request->filled('stock')) {
    //         if ($request->stock == 'in') {
    //             $query->where('mst_product.out_stock', 0);
    //         }

    //         if ($request->stock == 'out') {
    //             $query->where('mst_product.out_stock', 1);
    //         }
    //     }

    //     $products = $query->orderBy('mst_product.pro_id', 'DESC')->get();

    //     $rows = [];

    //     foreach ($products as $item) {
    //         $baseUrl = config('app.url') . '/assets/admin_assets/brand/';
    //         $brandFolder   = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name);
    //         $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->pro_name);


    //         $map = [
    //             'Product Type' => $item->pro_type,
    //             'Gender'        => $item->pro_gender,
    //             'Product Name'   => $item->pro_name,
    //             'Model Name'    => $item->pro_model_name,
    //             'Model Number'  => $item->pro_model,
    //             'Reference Number' => $item->pro_ref_num,
    //             'Brand'         => $item->brand_name,
    //             'Collection'    => $item->collection,
    //             'SKU'           => $item->pro_sku,
    //             'Barcode Type' => $item->barcode_type,
    //             'Watch Category' => $item->watch_category,
    //             'Category'      => $item->category,
    //             'Calendar Type' => $item->calendar_type,
    //             'Watch Type'    => $item->watch_type_title,
    //             'Dial Type'   => $item->dial_type,
    //             'Dial Colour' => $item->dial_color,
    //             'Dial Diameter (mm)' => $item->dial_diameter,
    //             'Case Shape'  => $item->case_shape,
    //             'Case Material' => $item->case_material,
    //             'Case Back' => $item->case_back,
    //             'Strap Material' => $item->strap_material,
    //             'Strap Colour' => $item->strap_color,
    //             'Glass Material' => $item->glass_type,
    //             'Bezel' => $item->bezel,
    //             'Bezel Function' => $item->bezel_function,
    //             'Embellishment' => $item->embellishment,
    //             'Clasp Type' => $item->clasp_type,
    //             'Movement' => $item->movement_type,
    //             'Water Resistance' => $item->water_resistance,
    //             'Functionality' => $item->functionality,
    //             'Year of Card' => $item->year_of_card
    //                 ? date('d-m-Y', strtotime($item->year_of_card))
    //                 : '',
    //             'Show Year Card' => $item->show_yearcard == 1 ? 'Yes' : 'No',
    //             'Brand Warranty' => $item->brand_warranty == 1 ? 'Yes' : 'No',
    //             'Service Card' => $item->service_card == 1 ? 'Yes' : 'No',
    //             'Box' => $item->box == 1 ? 'Yes' : 'No',
    //             'Papers' => $item->paper == 1 ? 'Yes' : 'No',
    //             'HSN Code' => $item->hsn_code,
    //             'Unit' => $item->unit,
    //             'Country of Origin' => $item->country_name,
    //             'Manufacturer' => $item->manufacturer_type,
    //             'Packers' => $item->packers,
    //             'Condition' => $item->condition,
    //             'Purchase Date' => $item->purchase_date
    //                 ? date('d-m-Y', strtotime($item->purchase_date))
    //                 : '',
    //             'Business Location'      => $item->location_name,
    //             'Warranty' => $item->shop_warranty,
    //             'Quantity' => $item->quantity,
    //             'New Arrivals' => $item->new_arrival == 1 ? 'Yes' : 'No',
    //             'Manage Stock?' => $item->manage_stock == 1 ? 'Yes' : 'No',
    //             'Stock Status' => $item->out_stock == 1 ? 'Out of Stock' : 'In Stock',
    //             'Not For Selling' => $item->not_for_selling == 1 ? 'Yes' : 'No',
    //             'Tata Cliq Exlusive Product' =>  $item->tata_cliq_product == 1 ? 'Yes' : 'No',
    //             'Product Description' => $item->product_desc,

    //             'Product Image' => $item->pro_image
    //                 ? $baseUrl . $brandFolder . '/' . $productFolder . '/image/' . $item->pro_image
    //                 : '',

    //             'Product Gallery Images' => $item->pro_gallery
    //                 ? collect(explode(',', $item->pro_gallery))
    //                 ->map(function ($img) use ($baseUrl, $brandFolder, $productFolder) {
    //                     return $baseUrl . $brandFolder . '/' . $productFolder . '/gallery/' . trim($img);
    //                 })
    //                 ->implode(', ')
    //                 : '',

    //             'Product Brochure' => $item->pro_brochure
    //                 ? $baseUrl . $brandFolder . '/' . $productFolder . '/brochure/' . $item->pro_brochure
    //                 : '',

    //             'Video Type' => ucfirst($item->video_type),

    //             'Video Source' => $item->video_type == 'file'
    //                 ? (
    //                     $item->video_source
    //                     ? $baseUrl . $brandFolder . '/' . $productFolder . '/video/' . $item->video_source
    //                     : ''
    //                 )
    //                 : $item->video_source,

    //             'Applicable Tax' => $item->pro_tax,
    //             'Type' =>  $item->product_type,
    //             'Selling Price Tax Type' => $item->selling_tax_type,
    //             'Default Purchase Price (Exc. Tax)' => $item->purchase_price_exclusive,
    //             'Default Purchase Price (Inc. Tax)' => $item->purchase_price_inclusive,
    //             '% Margin' => $item->pro_margin,
    //             'Default Selling Price (Exc. Tax)' => $item->selling_price_exclusive,
    //             'Meta Title' => $item->meta_title,
    //             'Meta Description' => $item->meta_description,





    //         ];

    //         $rows[] = array_values($map);
    //     }

    //     $headers = array_keys($map);

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->fromArray($headers, null, 'A1');
    //     $sheet->fromArray($rows, null, 'A2');

    //     $lastColumn = $sheet->getHighestColumn();
    //     $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);

    //     foreach (range('A', $sheet->getHighestColumn()) as $column) {
    //         $sheet->getColumnDimension($column)->setAutoSize(true);
    //     }

    //     $fileName = 'products_' . date('d_m_Y_h_i_A') . '.xlsx';

    //     $writer = new Xlsx($spreadsheet);

    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="' . $fileName . '"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    //     exit;
    // }

    public function export(Request $request)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);

        $query = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name',
            'mst_watch_type.title as watch_type_title',
            'dial.title as dial_color',
            'strap.title as strap_color',
            'mst_glass_material.title as glass_type',
            'mst_movement.title as movement_type',
            'mst_country.name as country_name',
            'manufacturer.brand_name as manufacturer_type',
            DB::raw("
            (
                SELECT GROUP_CONCAT(DISTINCT bl.name ORDER BY bl.name SEPARATOR ', ')
                FROM tbl_bussiness_location bl
                WHERE FIND_IN_SET(bl.bl_id, mst_product.physical_location)
                   OR FIND_IN_SET(bl.bl_id, mst_product.display_location)
            ) as location_name
        ")
        )
            ->leftJoin('mst_brand', 'mst_product.brand', '=', 'mst_brand.brand_id')
            ->leftJoin('mst_brand as manufacturer', 'mst_product.manufacturer', '=', 'manufacturer.brand_id')
            ->leftJoin('mst_watch_type', 'mst_product.watch_type', '=', 'mst_watch_type.wt_id')
            ->leftJoin('mst_color as dial', 'mst_product.dial_colour', '=', 'dial.color_id')
            ->leftJoin('mst_color as strap', 'mst_product.strap_colour', '=', 'strap.color_id')
            ->leftJoin('mst_glass_material', 'mst_product.glass_material', '=', 'mst_glass_material.gm_id')
            ->leftJoin('mst_movement', 'mst_product.movement', '=', 'mst_movement.m_id')
            ->leftJoin('mst_country', 'mst_product.origin_country', '=', 'mst_country.id')
            ->where('mst_product.pro_type', 'product')
            ->where('mst_product.approval_status', 1)
            ->where('mst_product.status', 0)
            ->groupBy('mst_product.pro_id');

        /* ---------------- FILTERS ---------------- */

        if ($request->filled('model_name')) {
            $query->where('mst_product.pro_model_name', 'LIKE', '%' . $request->model_name . '%');
        }

        if ($request->filled('model_number')) {
            $query->where('mst_product.pro_model', 'LIKE', '%' . $request->model_number . '%');
        }

        if ($request->filled('sku')) {
            $query->where('mst_product.pro_sku', 'LIKE', '%' . $request->sku . '%');
        }

        if ($request->filled('brand')) {
            $query->where('mst_product.brand', $request->brand);
        }

        if ($request->filled('business_location')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('FIND_IN_SET(?, mst_product.physical_location)', [$request->business_location])
                    ->orWhereRaw('FIND_IN_SET(?, mst_product.display_location)', [$request->business_location]);
            });
        }

        if ($request->filled('stock')) {
            if ($request->stock == 'in') {
                $query->where('mst_product.out_stock', 0);
            } elseif ($request->stock == 'out') {
                $query->where('mst_product.out_stock', 1);
            }
        }

        $products = $query->orderByDesc('mst_product.pro_id')->get();

        $rows = [];
        $headers = [];

        $maxGalleryImages = 0;

        foreach ($products as $product) {
            if (!empty($product->pro_gallery)) {
                $count = count(array_filter(explode(',', $product->pro_gallery)));
                $maxGalleryImages = max($maxGalleryImages, $count);
            }
        }

        foreach ($products as $item) {

            $baseUrl = config('app.url') . '/assets/admin_assets/brand/';
            $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? 'No_Brand');
            $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->pro_name ?? 'No_Product');

            /* Gallery Array */
            $gallery = [];

            if (!empty($item->pro_gallery)) {
                $gallery = array_values(
                    array_filter(
                        array_map('trim', explode(',', $item->pro_gallery))
                    )
                );
            }

            /* Video Source */
            $videoSource = '';

            if ($item->video_type == 'file') {
                $videoSource = $item->video_source
                    ? $baseUrl . $brandFolder . '/' . $productFolder . '/video/' . $item->video_source
                    : '';
            } else {
                $videoSource = $item->video_source;
            }

            $map = [

                'Product Type' => $item->pro_type,
                'Gender' => $item->pro_gender,
                'Product Name' => $item->pro_name,
                'Model Name' => $item->pro_model_name,
                'Model Number' => $item->pro_model,
                'Reference Number' => $item->pro_ref_num,
                'Brand' => $item->brand_name,
                'Collection' => $item->collection,
                'SKU' => $item->pro_sku,
                'Barcode Type' => $item->barcode_type,
                'Watch Category' => $item->watch_category,
                'Category' => $item->category,
                'Calendar Type' => $item->calendar_type,
                'Watch Type' => $item->watch_type_title,
                'Dial Type' => $item->dial_type,
                'Dial Colour' => $item->dial_color,
                'Dial Diameter (mm)' => $item->dial_diameter,
                'Case Shape' => $item->case_shape,
                'Case Material' => $item->case_material,
                'Case Back' => $item->case_back,
                'Strap Material' => $item->strap_material,
                'Strap Colour' => $item->strap_color,
                'Glass Material' => $item->glass_type,
                'Bezel' => $item->bezel,
                'Bezel Function' => $item->bezel_function,
                'Embellishment' => $item->embellishment,
                'Clasp Type' => $item->clasp_type,
                'Movement' => $item->movement_type,
                'Water Resistance' => $item->water_resistance,
                'Functionality' => $item->functionality,

                'Year of Card' => $item->year_of_card
                    ? date('d-m-Y', strtotime($item->year_of_card))
                    : '',

                'Show Year Card' => $item->show_yearcard ? 'Yes' : 'No',
                'Brand Warranty' => $item->brand_warranty ? 'Yes' : 'No',
                'Service Card' => $item->service_card ? 'Yes' : 'No',
                'Box' => strtolower($item->box) == 'yes' || $item->box == 1 ? 'Yes' : 'No',
                'Papers' => strtolower($item->paper) == 'yes' || $item->paper == 1 ? 'Yes' : 'No',

                'HSN Code' => $item->hsn_code,
                'Unit' => $item->unit,
                'Country of Origin' => $item->country_name,
                'Manufacturer' => $item->manufacturer_type,
                'Packers' => $item->packers,
                'Condition' => $item->condition,

                'Purchase Date' => $item->purchase_date
                    ? date('d-m-Y', strtotime($item->purchase_date))
                    : '',

                // 'Business Location' => $item->location_name,
                'Physical Location' => $item->physical_location
                    ? DB::table('tbl_bussiness_location')
                    ->where('bl_id', $item->physical_location)
                    ->value('name')
                    : '',

                'Display Location' => $item->display_location
                    ? DB::table('tbl_bussiness_location')
                    ->whereIn('bl_id', explode(',', $item->display_location))
                    ->pluck('name')
                    ->implode(', ')
                    : '',
                'Warranty' => $item->shop_warranty,
                'Quantity' => $item->quantity,

                'New Arrivals' => $item->new_arrival ? 'Yes' : 'No',
                'Manage Stock?' => $item->manage_stock ? 'Yes' : 'No',
                'Stock Status' => $item->out_stock ? 'Out of Stock' : 'In Stock',
                'Not For Selling' => $item->not_for_selling ? 'Yes' : 'No',
                'Tata Cliq Exclusive Product' => $item->tata_cliq_product ? 'Yes' : 'No',

                'Product Description' => $item->product_desc,

                'Product Image' => $item->pro_image
                    ? $baseUrl . $brandFolder . '/' . $productFolder . '/image/' . $item->pro_image
                    : '',
            ];

            /* Gallery Columns After Product Image */
            for ($i = 1; $i <= $maxGalleryImages; $i++) {

                $galleryImage = '';

                if (!empty($gallery[$i - 1])) {
                    $galleryImage = $baseUrl . $brandFolder . '/' . $productFolder . '/gallery/' . $gallery[$i - 1];
                }

                $columnName = ($i == 1)
                    ? 'Front Gallery Image'
                    : 'Gallery Image ' . $i;

                $map[$columnName] = $galleryImage;
            }

            /* Remaining Fields */
            $map['Product Brochure'] = $item->pro_brochure
                ? $baseUrl . $brandFolder . '/' . $productFolder . '/brochure/' . $item->pro_brochure
                : '';

            $map['Video Type'] = ucfirst($item->video_type);
            $map['Video Source'] = $videoSource;

            $map['Applicable Tax'] = $item->pro_tax;
            $map['Type'] = $item->product_type;
            $map['Selling Price Tax Type'] = $item->selling_tax_type;
            $map['Default Purchase Price (Exc. Tax)'] = $item->purchase_price_exclusive;
            $map['Default Purchase Price (Inc. Tax)'] = $item->purchase_price_inclusive;
            $map['% Margin'] = $item->pro_margin;
            $map['Default Selling Price (Exc. Tax)'] = $item->selling_price_exclusive;

            $map['Meta Title'] = $item->meta_title;
            $map['Meta Description'] = $item->meta_description;

            if (empty($headers)) {
                $headers = array_keys($map);
            }

            $rows[] = array_values($map);
        }



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($headers, null, 'A1');
        $sheet->fromArray($rows, null, 'A2');

        $lastColumn = $sheet->getHighestColumn();

        $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);

        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);

        for ($col = 1; $col <= $highestColumnIndex; $col++) {

            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);

            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        }

        $fileName = 'Product_Export_' . date('d_m_Y_h_i_A') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    // public function bulkUpdateExcel(Request $request)
    // {
    //     if (!$request->hasFile('file')) {
    //         return response()->json([
    //             'message' => 'File not found'
    //         ], 422);
    //     }

    //     $spreadsheet = IOFactory::load($request->file('file')->getPathname());
    //     $rows = $spreadsheet->getActiveSheet()->toArray();

    //     if (count($rows) <= 1) {
    //         return response()->json([
    //             'message' => 'Excel empty'
    //         ], 422);
    //     }

    //     $headers = array_map('trim', $rows[0]);

    //     $updated = 0;
    //     $summary = '';

    //     foreach (array_slice($rows, 1) as $row) {

    //         $data = array_combine($headers, $row);

    //         if (empty($data['SKU'])) {
    //             continue;
    //         }

    //         $product = ProductModel::where('pro_sku', trim($data['SKU']))->first();

    //         if (!$product) {
    //             $summary .= "SKU {$data['SKU']} not found<br>";
    //             continue;
    //         }

    //         $changes = [];

    //         /* Normal Fields */
    //         $fieldMap = [

    //             'Product Type' => 'pro_type',
    //             'Gender' => 'pro_gender',
    //             'Product Name' => 'pro_name',
    //             'Model Name' => 'pro_model_name',
    //             'Model Number' => 'pro_model',
    //             'Reference Number' => 'pro_ref_num',
    //             'Collection' => 'collection',
    //             'Barcode Type' => 'barcode_type',
    //             'Watch Category' => 'watch_category',
    //             'Category' => 'category',
    //             'Calendar Type' => 'calendar_type',
    //             'Dial Type' => 'dial_type',
    //             'Dial Diameter (mm)' => 'dial_diameter',
    //             'Case Shape' => 'case_shape',
    //             'Case Material' => 'case_material',
    //             'Case Back' => 'case_back',
    //             'Strap Material' => 'strap_material',
    //             'Bezel' => 'bezel',
    //             'Bezel Function' => 'bezel_function',
    //             'Embellishment' => 'embellishment',
    //             'Clasp Type' => 'clasp_type',
    //             'Water Resistance' => 'water_resistance',
    //             'Functionality' => 'functionality',
    //             'HSN Code' => 'hsn_code',
    //             'Unit' => 'unit',
    //             'Packers' => 'packers',
    //             'Condition' => 'condition',
    //             'Warranty' => 'shop_warranty',
    //             'Quantity' => 'quantity',
    //             'Product Description' => 'product_desc',
    //             'Video Type' => 'video_type',
    //             'Video Source' => 'video_source',

    //             'Applicable Tax' => 'pro_tax',
    //             'Type' => 'product_type',
    //             'Selling Price Tax Type' => 'selling_tax_type',
    //             'Default Purchase Price (Exc. Tax)' => 'purchase_price_exclusive',
    //             'Default Purchase Price (Inc. Tax)' => 'purchase_price_inclusive',
    //             '% Margin' => 'pro_margin',
    //             'Default Selling Price (Exc. Tax)' => 'selling_price_exclusive',
    //             'Meta Title' => 'meta_title',
    //             'Meta Description' => 'meta_description',
    //         ];

    //         foreach ($fieldMap as $excelCol => $dbCol) {

    //             if (isset($data[$excelCol])) {

    //                 $newVal = trim($data[$excelCol]);

    //                 if ((string)$product->$dbCol != (string)$newVal) {
    //                     $changes[$dbCol] = $newVal;
    //                 }
    //             }
    //         }

    //         /* Yes / No Fields */
    //         $yesNoMap = [

    //             'Show Year Card' => 'show_yearcard',
    //             'Brand Warranty' => 'brand_warranty',
    //             'Service Card' => 'service_card',
    //             'Box' => 'box',
    //             'Papers' => 'paper',
    //             'New Arrivals' => 'new_arrival',
    //             'Manage Stock?' => 'manage_stock',
    //             'Not For Selling' => 'not_for_selling',
    //             'Tata Cliq Exclusive Product' => 'tata_cliq_product',
    //         ];

    //         foreach ($yesNoMap as $excelCol => $dbCol) {

    //             if (isset($data[$excelCol])) {

    //                 $val = strtolower(trim($data[$excelCol])) == 'yes' ? 1 : 0;

    //                 if ((int)$product->$dbCol != $val) {
    //                     $changes[$dbCol] = $val;
    //                 }
    //             }
    //         }

    //         /* Stock Status */
    //         if (isset($data['Stock Status'])) {

    //             $stock = strtolower(trim($data['Stock Status'])) == 'out of stock' ? 1 : 0;

    //             if ((int)$product->out_stock != $stock) {
    //                 $changes['out_stock'] = $stock;
    //             }
    //         }

    //         /* Date Fields */
    //         if (!empty($data['Year of Card'])) {

    //             $date = date('Y-m-d', strtotime($data['Year of Card']));

    //             if ($product->year_of_card != $date) {
    //                 $changes['year_of_card'] = $date;
    //             }
    //         }

    //         if (!empty($data['Purchase Date'])) {

    //             $date = date('Y-m-d', strtotime($data['Purchase Date']));

    //             if ($product->purchase_date != $date) {
    //                 $changes['purchase_date'] = $date;
    //             }
    //         }

    //         // ADD this block before /* Final Update */

    //         /* Physical Location */
    //         if (isset($data['Physical Location']) && trim($data['Physical Location']) != '') {

    //             $physical = DB::table('tbl_bussiness_location')
    //                 ->where('name', trim($data['Physical Location']))
    //                 ->first();

    //             if ($physical) {

    //                 if ((string)$product->physical_location != (string)$physical->bl_id) {
    //                     $changes['physical_location'] = $physical->bl_id;
    //                 }
    //             } else {

    //                 $summary .= "SKU {$data['SKU']} : Physical Location not found (" . $data['Physical Location'] . ")<br>";
    //             }
    //         }

    //         /* Display Location (comma separated names) */
    //         if (isset($data['Display Location']) && trim($data['Display Location']) != '') {

    //             $names = array_filter(array_map('trim', explode(',', $data['Display Location'])));

    //             $ids = [];
    //             $invalid = [];

    //             foreach ($names as $name) {

    //                 $location = DB::table('tbl_bussiness_location')
    //                     ->where('name', $name)
    //                     ->first();

    //                 if ($location) {
    //                     $ids[] = $location->bl_id;
    //                 } else {
    //                     $invalid[] = $name;
    //                 }
    //             }

    //             if (!empty($invalid)) {

    //                 $summary .= "SKU {$data['SKU']} : Display Location not found (" . implode(', ', $invalid) . ")<br>";
    //             } else {

    //                 $displayIds = implode(',', $ids);

    //                 if ((string)$product->display_location != (string)$displayIds) {
    //                     $changes['display_location'] = $displayIds;
    //                 }
    //             }
    //         }

    //         // ADD this block after Display Location block and before Final Update

    //         /* Brand */
    //         if (isset($data['Brand']) && trim($data['Brand']) != '') {

    //             $brand = DB::table('mst_brand')
    //                 ->where('brand_name', trim($data['Brand']))
    //                 ->first();

    //             if ($brand) {

    //                 if ((string)$product->brand != (string)$brand->brand_id) {
    //                     $changes['brand'] = $brand->brand_id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Brand not found (" . $data['Brand'] . ")<br>";
    //             }
    //         }

    //         /* Manufacturer */
    //         if (isset($data['Manufacturer']) && trim($data['Manufacturer']) != '') {

    //             $manufacturer = DB::table('mst_brand')
    //                 ->where('brand_name', trim($data['Manufacturer']))
    //                 ->first();

    //             if ($manufacturer) {

    //                 if ((string)$product->manufacturer != (string)$manufacturer->brand_id) {
    //                     $changes['manufacturer'] = $manufacturer->brand_id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Manufacturer not found (" . $data['Manufacturer'] . ")<br>";
    //             }
    //         }

    //         /* Watch Type */
    //         if (isset($data['Watch Type']) && trim($data['Watch Type']) != '') {

    //             $watchType = DB::table('mst_watch_type')
    //                 ->where('title', trim($data['Watch Type']))
    //                 ->first();

    //             if ($watchType) {

    //                 if ((string)$product->watch_type != (string)$watchType->wt_id) {
    //                     $changes['watch_type'] = $watchType->wt_id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Watch Type not found (" . $data['Watch Type'] . ")<br>";
    //             }
    //         }

    //         /* Dial Colour */
    //         if (isset($data['Dial Colour']) && trim($data['Dial Colour']) != '') {

    //             $dial = DB::table('mst_color')
    //                 ->where('title', trim($data['Dial Colour']))
    //                 ->first();

    //             if ($dial) {

    //                 if ((string)$product->dial_colour != (string)$dial->color_id) {
    //                     $changes['dial_colour'] = $dial->color_id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Dial Colour not found (" . $data['Dial Colour'] . ")<br>";
    //             }
    //         }

    //         /* Strap Colour */
    //         if (isset($data['Strap Colour']) && trim($data['Strap Colour']) != '') {

    //             $strap = DB::table('mst_color')
    //                 ->where('title', trim($data['Strap Colour']))
    //                 ->first();

    //             if ($strap) {

    //                 if ((string)$product->strap_colour != (string)$strap->color_id) {
    //                     $changes['strap_colour'] = $strap->color_id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Strap Colour not found (" . $data['Strap Colour'] . ")<br>";
    //             }
    //         }

    //         /* Glass Material */
    //         if (isset($data['Glass Material']) && trim($data['Glass Material']) != '') {

    //             $glass = DB::table('mst_glass_material')
    //                 ->where('title', trim($data['Glass Material']))
    //                 ->first();

    //             if ($glass) {

    //                 if ((string)$product->glass_material != (string)$glass->gm_id) {
    //                     $changes['glass_material'] = $glass->gm_id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Glass Material not found (" . $data['Glass Material'] . ")<br>";
    //             }
    //         }

    //         /* Movement */
    //         if (isset($data['Movement']) && trim($data['Movement']) != '') {

    //             $movement = DB::table('mst_movement')
    //                 ->where('title', trim($data['Movement']))
    //                 ->first();

    //             if ($movement) {

    //                 if ((string)$product->movement != (string)$movement->m_id) {
    //                     $changes['movement'] = $movement->m_id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Movement not found (" . $data['Movement'] . ")<br>";
    //             }
    //         }

    //         /* Country of Origin */
    //         if (isset($data['Country of Origin']) && trim($data['Country of Origin']) != '') {

    //             $country = DB::table('mst_country')
    //                 ->where('name', trim($data['Country of Origin']))
    //                 ->first();

    //             if ($country) {

    //                 if ((string)$product->origin_country != (string)$country->id) {
    //                     $changes['origin_country'] = $country->id;
    //                 }
    //             } else {
    //                 $summary .= "SKU {$data['SKU']} : Country not found (" . $data['Country of Origin'] . ")<br>";
    //             }
    //         }
    //         /* Final Update */
    //         if (!empty($changes)) {

    //             $product->update($changes);

    //             $updated++;

    //             $summary .= "SKU {$data['SKU']} updated : "
    //                 . implode(', ', array_keys($changes))
    //                 . "<br>";
    //         }
    //     }

    //     return response()->json([
    //         'message' => $updated . ' Products Updated Successfully',
    //         'summary' => $summary
    //     ]);
    // }

    public function bulkUpdateExcel(Request $request)
    {
        try {

            if (!$request->hasFile('file')) {
                return response()->json([
                    'message' => 'Please upload excel file'
                ], 422);
            }

            ini_set('memory_limit', '1024M');
            set_time_limit(300);

            $spreadsheet = IOFactory::load($request->file('file')->getPathname());
            $rows = $spreadsheet->getActiveSheet()->toArray();

            if (count($rows) <= 1) {
                return response()->json([
                    'message' => 'Excel file empty'
                ], 422);
            }

            $headers = array_map('trim', $rows[0]);

            $updated = 0;
            $summary = [];

            foreach (array_slice($rows, 1) as $row) {

                if (count(array_filter($row)) == 0) {
                    continue;
                }

                $data = array_combine($headers, $row);

                $sku = trim($data['SKU'] ?? '');

                if ($sku == '') {
                    continue;
                }

                $product = ProductModel::where('pro_sku', $sku)->first();

                if (!$product) {
                    $summary[] = "SKU {$sku} not found";
                    continue;
                }

                $changes = [];

                /* ---------------- NORMAL FIELDS ---------------- */

                $fieldMap = [

                    'Product Type' => 'pro_type',
                    'Gender' => 'pro_gender',
                    'Product Name' => 'pro_name',
                    'Model Name' => 'pro_model_name',
                    'Model Number' => 'pro_model',
                    'Reference Number' => 'pro_ref_num',
                    'Collection' => 'collection',
                    'Barcode Type' => 'barcode_type',
                    'Watch Category' => 'watch_category',
                    'Category' => 'category',
                    'Calendar Type' => 'calendar_type',
                    'Dial Type' => 'dial_type',
                    'Dial Diameter (mm)' => 'dial_diameter',
                    'Case Shape' => 'case_shape',
                    'Case Material' => 'case_material',
                    'Case Back' => 'case_back',
                    'Strap Material' => 'strap_material',
                    'Bezel' => 'bezel',
                    'Bezel Function' => 'bezel_function',
                    'Embellishment' => 'embellishment',
                    'Clasp Type' => 'clasp_type',
                    'Water Resistance' => 'water_resistance',
                    'Functionality' => 'functionality',
                    'HSN Code' => 'hsn_code',
                    'Unit' => 'unit',
                    'Packers' => 'packers',
                    'Condition' => 'condition',
                    'Warranty' => 'shop_warranty',
                    'Quantity' => 'quantity',
                    'Product Description' => 'product_desc',
                    'Video Type' => 'video_type',
                    'Video Source' => 'video_source',
                    'Applicable Tax' => 'pro_tax',
                    'Type' => 'product_type',
                    'Selling Price Tax Type' => 'selling_tax_type',
                    'Default Purchase Price (Exc. Tax)' => 'purchase_price_exclusive',
                    'Default Purchase Price (Inc. Tax)' => 'purchase_price_inclusive',
                    '% Margin' => 'pro_margin',
                    'Default Selling Price (Exc. Tax)' => 'selling_price_exclusive',
                    'Meta Title' => 'meta_title',
                    'Meta Description' => 'meta_description',
                ];

                foreach ($fieldMap as $excelCol => $dbCol) {

                    if (!isset($data[$excelCol])) continue;

                    $newVal = trim((string)$data[$excelCol]);
                    $oldVal = trim((string)$product->$dbCol);

                    if ($newVal === '') continue;

                    if ($dbCol == 'video_type') {
                        $newVal = strtolower($newVal);
                        $oldVal = strtolower($oldVal);
                    }

                    if (is_numeric($newVal) && is_numeric($oldVal)) {
                        $newVal = (float)$newVal;
                        $oldVal = (float)$oldVal;
                    }

                    if ($newVal != $oldVal) {
                        $changes[$dbCol] = trim((string)$data[$excelCol]);
                    }
                }

                /* ---------------- YES / NO ---------------- */

                $yesNoMap = [

                    'Show Year Card' => 'show_yearcard',
                    'Brand Warranty' => 'brand_warranty',
                    'Service Card' => 'service_card',
                    'Box' => 'box',
                    'Papers' => 'paper',
                    'New Arrivals' => 'new_arrival',
                    'Manage Stock?' => 'manage_stock',
                    'Not For Selling' => 'not_for_selling',
                    'Tata Cliq Exclusive Product' => 'tata_cliq_product',
                ];

                foreach ($yesNoMap as $excelCol => $dbCol) {

                    // column not present
                    if (!isset($data[$excelCol])) {
                        continue;
                    }

                    // raw excel value
                    $rawVal = trim((string)$data[$excelCol]);

                    // if empty / null / blank then skip update
                    if ($rawVal === '' || is_null($data[$excelCol])) {
                        continue;
                    }

                    $val = strtolower($rawVal);

                    $newVal = ($val == 'yes') ? 1 : 0;

                    $oldVal = strtolower(trim((string)$product->$dbCol));
                    $oldVal = ($oldVal == 'yes' || $oldVal == '1') ? 1 : 0;

                    if ($newVal != $oldVal) {
                        $changes[$dbCol] = $newVal;
                    }
                }
                /* ---------------- STOCK ---------------- */

                if (!empty($data['Stock Status'])) {

                    $newVal = strtolower(trim($data['Stock Status'])) == 'out of stock' ? 1 : 0;
                    $oldVal = (int)$product->out_stock;

                    if ($newVal != $oldVal) {
                        $changes['out_stock'] = $newVal;
                    }
                }

                /* ---------------- DATES ---------------- */

                if (!empty($data['Year of Card'])) {

                    $newDate = date('Y-m-d', strtotime($data['Year of Card']));
                    $oldDate = $product->year_of_card;

                    if ($newDate != $oldDate) {
                        $changes['year_of_card'] = $newDate;
                    }
                }

                if (!empty($data['Purchase Date'])) {

                    $newDate = date('Y-m-d', strtotime($data['Purchase Date']));
                    $oldDate = $product->purchase_date;

                    if ($newDate != $oldDate) {
                        $changes['purchase_date'] = $newDate;
                    }
                }

                /* ---------------- RELATION FIELDS ---------------- */

                $relations = [

                    ['Brand', 'mst_brand', 'brand_name', 'brand_id', 'brand'],
                    ['Manufacturer', 'mst_brand', 'brand_name', 'brand_id', 'manufacturer'],
                    ['Watch Type', 'mst_watch_type', 'title', 'wt_id', 'watch_type'],
                    ['Dial Colour', 'mst_color', 'title', 'color_id', 'dial_colour'],
                    ['Strap Colour', 'mst_color', 'title', 'color_id', 'strap_colour'],
                    ['Glass Material', 'mst_glass_material', 'title', 'gm_id', 'glass_material'],
                    ['Movement', 'mst_movement', 'title', 'm_id', 'movement'],
                    ['Country of Origin', 'mst_country', 'name', 'id', 'origin_country'],
                    ['Physical Location', 'tbl_bussiness_location', 'name', 'bl_id', 'physical_location'],
                ];

                foreach ($relations as $rel) {

                    [$excelCol, $table, $matchCol, $idCol, $dbCol] = $rel;

                    $val = trim($data[$excelCol] ?? '');

                    if ($val == '') continue;

                    $record = DB::table($table)
                        ->whereRaw("LOWER($matchCol)=?", [strtolower($val)])
                        ->first();

                    if ($record) {

                        if ((string)$product->$dbCol != (string)$record->$idCol) {
                            $changes[$dbCol] = $record->$idCol;
                        }
                    } else {
                        $summary[] = "SKU {$sku} : {$excelCol} not found ({$val})";
                    }
                }

                /* ---------------- DISPLAY LOCATION ---------------- */

                if (!empty($data['Display Location'])) {

                    $names = array_filter(array_map('trim', explode(',', $data['Display Location'])));

                    $ids = [];
                    $invalid = [];

                    foreach ($names as $name) {

                        $record = DB::table('tbl_bussiness_location')
                            ->whereRaw("LOWER(name)=?", [strtolower($name)])
                            ->first();

                        if ($record) {
                            $ids[] = $record->bl_id;
                        } else {
                            $invalid[] = $name;
                        }
                    }

                    if (empty($invalid)) {

                        // NEW VALUES
                        $newIds = array_unique($ids);
                        sort($newIds);

                        // OLD VALUES
                        $oldIds = array_filter(explode(',', $product->display_location));
                        $oldIds = array_map('intval', $oldIds);
                        sort($oldIds);

                        if ($newIds != $oldIds) {
                            $changes['display_location'] = implode(',', $newIds);
                        }
                    } else {

                        $summary[] = "SKU {$sku} : Display Location not found (" . implode(', ', $invalid) . ")";
                    }
                }

                /* ---------------- FINAL UPDATE ---------------- */

                // REPLACE ONLY FINAL UPDATE BLOCK with this

                /* ---------------- FINAL UPDATE ---------------- */

                /* ---------------- FINAL UPDATE ---------------- */

                /* ---------------- FINAL UPDATE ---------------- */

                if (!empty($changes)) {

                    $activity = [];

                    /* -------- MEDIA FOLDER COPY (SAFE) -------- */
                    $oldBrandId = $product->brand;
                    $oldName    = $product->pro_name;

                    $newBrandId = $changes['brand'] ?? $product->brand;
                    $newName    = $changes['pro_name'] ?? $product->pro_name;

                    if ($oldBrandId != $newBrandId || $oldName != $newName) {

                        $oldBrand = DB::table('mst_brand')->where('brand_id', $oldBrandId)->first();
                        $newBrand = DB::table('mst_brand')->where('brand_id', $newBrandId)->first();

                        if ($oldBrand && $newBrand) {

                            $oldBrandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $oldBrand->brand_name);
                            $newBrandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $newBrand->brand_name);

                            $oldProductFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $oldName);
                            $newProductFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $newName);

                            $oldPath = public_path("assets/admin_assets/brand/$oldBrandFolder/$oldProductFolder");
                            $newPath = public_path("assets/admin_assets/brand/$newBrandFolder/$newProductFolder");

                            if (File::exists($oldPath) && !File::exists($newPath)) {

                                File::makeDirectory(dirname($newPath), 0777, true, true);
                                File::copyDirectory($oldPath, $newPath);

                                $activity[] = "media folder : copied to new path";
                            }
                        }
                    }

                    /* Protect Media Columns */
                    unset($changes['pro_image'], $changes['pro_gallery'], $changes['pro_brochure']);

                    foreach ($changes as $column => $newValue) {

                        $oldValue = $product->$column;

                        if (is_null($oldValue)) $oldValue = '';
                        if (is_null($newValue)) $newValue = '';

                        $activity[] = $column . ' : ' . $oldValue . ' → ' . $newValue;
                    }

                    DB::transaction(function () use ($product, $changes) {
                        $product->update($changes);
                    });

                    /* -------- ACTIVITY LOG -------- */
                    activity_log(
                        'product',
                        'bulk_excel_update',
                        json_encode([
                            'sku'          => $sku,
                            'product_name' => $newName,
                            'changes'      => $changes,
                            'message'      => 'Product updated through bulk excel import'
                        ]),
                        current_user_id()
                    );

                    $updated++;

                    $summary[] = "
    <div class='mb-2 p-2 border rounded bg-light'>
        <strong>SKU {$sku}</strong><br>
        " . implode('<br>', $activity) . "
    </div>";
                }
            }

            return response()->json([
                'message' => $updated . ' Products Updated Successfully',
                'summary' => implode('<br>', $summary)
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    //Catalogue Creation
    // public function catalogue_create(Request $request)
    // {
    //     ini_set('memory_limit', '1024M');
    //     $proIds = $request->input('pro_ids', []);

    //     if (empty($proIds)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No products selected'
    //         ], 422);
    //     }

    //     $products = DB::table('mst_product as p')
    //         ->leftJoin('mst_brand as b', 'b.brand_id', '=', 'p.brand')
    //         ->whereIn('p.pro_id', $proIds)
    //         ->select(
    //             'p.pro_id',
    //             'p.pro_name',
    //             'p.pro_ref_num',
    //             'p.dial_diameter',
    //             'p.year_of_card',
    //             'p.box',
    //             'p.paper',
    //             'p.selling_price_exclusive',
    //             'p.pro_image',
    //             'p.service_card',
    //             'b.brand_name'
    //         )
    //         ->orderByRaw("FIELD(p.pro_id, " . implode(',', array_map('intval', $proIds)) . ")")
    //         ->orderBy('p.pro_id', 'desc')
    //         ->get();

    //     $actualUrl = config('app.actual_url');

    //     $products = $products->map(function ($row) use ($actualUrl) {
    //         $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name ?? '');
    //         $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name ?? '');

    //         $imagePath = public_path(
    //             'assets/admin_assets/brand/' .
    //                 $brandFolder . '/' .
    //                 $productFolder . '/image/' .
    //                 $row->pro_image
    //         );

    //         $manager = new ImageManager(new Driver());

    //         if (file_exists($imagePath)) {

    //             $compressedDir = storage_path('app/public/catalogue_temp');

    //             if (!file_exists($compressedDir)) {
    //                 mkdir($compressedDir, 0777, true);
    //             }

    //             $compressedPath = $compressedDir . '/' . $row->pro_id . '.jpg';

    //             if (!file_exists($compressedPath)) {

    //                 $image = $manager->read($imagePath);

    //                 // $image->resize(900, null);

    //                 $image->toJpeg(45)->save($compressedPath);
    //             }

    //             $row->image_path = $compressedPath;
    //         } else {

    //             $row->image_path = null;
    //         }
    //         $row->box_text = ((int) $row->box === 0) ? 'YES' : 'NO';
    //         $row->paper_text = ((int) $row->paper === 0) ? 'YES' : 'NO';
    //         $row->selling_price_text = indian_number_format((float) $row->selling_price_exclusive, 0, '.', ',');

    //         return $row;
    //     });

    //     // $pdf = Pdf::loadView('products.catalogue_pdf', compact('products'))
    //     //     ->setPaper([0, 0, 520, 960], 'landscape')
    //     //     ->setOption('isRemoteEnabled', true);
    //     // ->setOption('dpi', 150)
    //     // ->setOption('defaultFont', 'sans-serif');
    //     $pdf = Pdf::loadView('products.catalogue_pdf', compact('products'))
    //         ->setPaper([0, 0, 520, 960], 'landscape');





    //     return $pdf->download('IN-STORE-CATALOGUE.pdf');
    // }

    public function catalogue_create(Request $request)
    {
        ini_set('memory_limit', '1024M');

        $proIds = $request->input('pro_ids', []);

        if (empty($proIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No products selected'
            ], 422);
        }

        $products = DB::table('mst_product as p')
            ->leftJoin('mst_brand as b', 'b.brand_id', '=', 'p.brand')
            ->whereIn('p.pro_id', $proIds)
            ->select(
                'p.pro_id',
                'p.pro_name',
                'p.pro_ref_num',
                'p.dial_diameter',
                'p.year_of_card',
                'p.box',
                'p.paper',
                'p.selling_price_exclusive',
                'p.pro_image',
                'p.service_card',
                'b.brand_name'
            )
            ->orderByRaw("FIELD(p.pro_id, " . implode(',', array_map('intval', $proIds)) . ")")
            ->orderBy('p.pro_id', 'desc')
            ->get();

        $products = $products->map(function ($row) {
            $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->brand_name ?? '');
            $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $row->pro_name ?? '');

            $imagePath = public_path(
                'assets/admin_assets/brand/' .
                    $brandFolder . '/' .
                    $productFolder . '/image/' .
                    $row->pro_image
            );

            $manager = new ImageManager(new Driver());

            if (file_exists($imagePath)) {
                $compressedDir = storage_path('app/public/catalogue_temp');

                if (!file_exists($compressedDir)) {
                    mkdir($compressedDir, 0777, true);
                }

                $compressedPath = $compressedDir . '/' . $row->pro_id . '.jpg';

                if (!file_exists($compressedPath)) {
                    $image = $manager->read($imagePath);
                    $image->toJpeg(45)->save($compressedPath);
                }

                $row->image_path = $compressedPath;
            } else {
                $row->image_path = null;
            }

            $row->box_text = ((int) $row->box === 0) ? 'YES' : 'NO';
            $row->paper_text = ((int) $row->paper === 0) ? 'YES' : 'NO';
            $row->selling_price_text = indian_number_format((float) $row->selling_price_exclusive, 0, '.', ',');

            return $row;
        });

        $pdf = Pdf::loadView('products.catalogue_pdf', compact('products'))
            ->setPaper([0, 0, 520, 960], 'landscape');

        $fileName = 'IN-STORE-CATALOGUE.pdf';
        $uploadPath = public_path('assets/admin_assets/catalogue/');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fullPath = $uploadPath . $fileName;

        $catalogue = CatalogueModel::first();

        if (!$catalogue) {
            $catalogue = new CatalogueModel();
            $catalogue->created_by = current_user_id();
            $catalogue->created_at = now();
        }

        // delete old file only if it's different and exists
        if (!empty($catalogue->file)) {
            $oldFilePath = $uploadPath . $catalogue->file;

            if (file_exists($oldFilePath) && $oldFilePath !== $fullPath) {
                unlink($oldFilePath);
            }
        }

        // save new pdf
        file_put_contents($fullPath, $pdf->output());

        $catalogue->file = $fileName;
        $catalogue->updated_by = current_user_id();
        $catalogue->updated_at = now();
        $catalogue->save();

        return response()->download($fullPath, $fileName);
    }
}
