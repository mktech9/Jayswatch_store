<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\BlogModel;
use App\Models\MultiBlogModel;
use App\Models\BrandModel;
use App\Models\FaqModel;
use App\Models\UserModel;
use App\Models\ColorModel;
use App\Models\ContactModel;
use App\Models\MstCountryModel;
use App\Models\ProductEnquiryModel;
use App\Models\ProductModel;
use App\Models\TradeVerification;
use App\Models\AboutContentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use GuzzleHttp\Client;


class FrontEndController extends Controller
{
    public function home()
    {
        $slider = DB::table('mst_sliders')
            ->where('status', 0)
            ->orderBy('slider_id', 'desc')
            ->get();

        $homecontent = DB::table('tbl_home_content')->first();
        $clientreview = DB::table('mst_clients')
            ->where('status', 0)
            ->orderBy('client_id', 'desc')
            ->get();

        $title = 'Jays Watch Store :: Home';

        $products = ProductModel::with('brandInfo')
            ->where('new_arrival', 1)
            ->where('approval_status', 1)
            ->where('pro_type', 'product')
            ->where('out_stock', 0)
            ->where('not_for_selling', 0)
            ->where('status', 0)
            ->limit(4)
            ->get();

        return view('frontend.home', compact('slider', 'homecontent', 'title', 'products', 'clientreview'));
    }

    public function about()
    {

        $title = 'Jays Watch Store :: About Us';

        $aboutContent = AboutContentModel::first();

        return view('frontend.about', compact('title', 'aboutContent'));
    }

    // Locations
    public function lower_parel_mumbai()
    {

        return view('frontend.storelocation.lower_parel');
    }

    public function bandra_west_mumbai()
    {

        return view('frontend.storelocation.bandra_west');
    }

    public function bangalore_karnataka()
    {

        return view('frontend.storelocation.bangalore_karnataka');
    }

    public function ahmedabad_gujarat()
    {

        return view('frontend.storelocation.ahmedabad_gujarat');
    }

    // contact
    public function contact()
    {

        $slider = DB::table('mst_sliders')
            ->where('status', 0)
            ->orderBy('slider_id', 'desc')
            ->get();
        $brands = BrandModel::get();
        $clientreview = DB::table('mst_clients')
            ->where('status', 0)
            ->orderBy('client_id', 'desc')
            ->get();
        $homecontent = DB::table('tbl_home_content')->first();
        $title = 'Jays Watch Store :: Contact Us';

        return view('frontend.contact')->with(compact('brands', 'slider', 'homecontent', 'clientreview', 'title'));
    }

    public function addContact_us(Request $request)
    {
        /* =============================
           PREPARE DATA
        ==============================*/

        $email = $request->userEmail;
        $message = $request->userMessage;

        // Full Name Handle Empty Values
        $fullName = trim(implode(' ', array_filter([
            $request->title,
            $request->firstName,
            $request->lastName,
        ])));

        /* =============================
           SAVE CONTACT DATA
        ==============================*/

        $contactUs = new ContactModel;

        $contactUs->name = $fullName ?: null;
        $contactUs->email = $email;
        $contactUs->mobile = trim(($request->phone_code ?? '') . ' ' . ($request->userPhone ?? ''));
        $contactUs->country = $request->country;
        $contactUs->city = $request->city;
        $contactUs->store = $request->store_name;
        $contactUs->message = $message;
        $contactUs->status = 0;

        $contactUs->save();

        try {

            $logMessage = "Contact enquiry submitted by {$fullName} "
                . "(Email: {$email}, Mobile: {$contactUs->mobile}). "
                . "Location: {$request->city}, {$request->country}. "
                . "Store: {$request->store_name}";

            activity_log(
                'Ecommerce',
                'Contact Enquiry',
                $logMessage,
                null, // guest user
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        /* =============================
           EMAIL CONTENT
        ==============================*/

        // $to = 'ravikant@gocodex.com';
        // $to = 'info@jayswatchstore.com';
        // $to = 'akshay@gocodex.com';
        //  $to = 'admin@jayswatchstore.com';

        $to = 'mahir88khan@gmail.com';
        $subject = 'Contact from JaysWatch Website..';

        $body = "Name: {$fullName}\n";
        $body .= "Mobile Number: {$request->phone_code}{$request->userPhone}\n";
        $body .= "Email: {$email}\n";
        $body .= "Country: {$request->country}\n";
        $body .= "City: {$request->city}\n";
        $body .= "Store Name: {$request->store_name}\n";
        $body .= "Message: {$message}\n";

        /* =============================
           LOAD SMTP FROM HELPER
        ==============================*/

        $smtp = set_smtp_config();

        if (! $smtp) {
            return response()->json([
                'status' => 0,
                'message' => 'SMTP configuration not found',
            ]);
        }

        /* =============================
           SEND MAIL USING LARAVEL MAIL
        ==============================*/

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            Mail::raw($body, function ($mail) use ($to, $subject, $email) {
                $mail->to($to)
                    ->subject($subject)
                    ->cc('admin@jayswatchstore.com')
                    ->replyTo($email);
            });

            echo '<h4 style="color:white;">Thank You for Your Message.</h4>';
        } else {
            echo 0;
        }
    }

    // Store Location
    public function storeLocator()
    {
        $page_title = 'Our Store - Jay’s Watch Store';

        $store_faq = DB::table('faq')
            ->where('status', 0)
            ->whereIn('type', ['store', 'other'])
            ->orderBy('faq_id', 'desc')
            ->get();

        return view('frontend.store', compact('page_title', 'store_faq'));
    }

    // Brand Page
    public function manufacturerProducts(Request $request, $brand)
    {
        $brandSlug = strtolower(str_replace(' ', '-', $brand));
        $brandName = ucwords(str_replace('-', ' ', $brandSlug));

        // ===== FILTER SESSION =====
        $sessionKey = 'brand_filter_' . $brandSlug;
        $filterData = session($sessionKey, []);

        $size = $filterData['size'] ?? [];
        $gender = $filterData['gender'] ?? [];
        $stock = $filterData['stock'] ?? [];
        $movement = $filterData['movement'] ?? [];
        $sort = $filterData['sort'] ?? '';
        $min_price = $filterData['min_price'] ?? '';
        $max_price = $filterData['max_price'] ?? '';

        // ===== FILTER DATA =====
        $size_data = DB::table('mst_product')
            ->select('dial_diameter as case_size')
            ->whereNotNull('dial_diameter')
            ->where('dial_diameter', '!=', '')
            ->groupBy('dial_diameter')
            ->get();

        $movement_Data = DB::table('mst_product')
            ->join('mst_movement', 'mst_product.movement', '=', 'mst_movement.m_id')
            ->select(
                'mst_product.movement as movement_id',
                'mst_movement.title as movement'
            )
            ->whereNotNull('mst_product.movement')
            ->groupBy('mst_product.movement', 'mst_movement.title')
            ->get();

        // ===== MAIN QUERY =====
        $query = DB::table('mst_product')
            ->leftJoin('mst_brand as b1', 'mst_product.brand', '=', 'b1.brand_id')
            ->leftJoin('mst_brand as b2', 'mst_product.manufacturer', '=', 'b2.brand_id')
            ->select(
                'mst_product.pro_id',
                'mst_product.pro_name',
                'mst_product.pro_image',
                'mst_product.pro_sku',
                'mst_product.dial_diameter',
                'mst_product.pro_gender',
                'mst_product.out_stock',
                'mst_product.selling_price_exclusive',
                'mst_product.movement',
                'b1.brand_name as brandinfo',
                'b2.brand_name as manufacturerinfo'
            )
            ->where(function ($q) use ($brandName, $brandSlug) {
                $q->whereRaw('LOWER(b1.brand_name)=LOWER(?)', [$brandName])
                    ->orWhereRaw('LOWER(b1.brand_name)=LOWER(?)', [$brandSlug]);
            })
            ->where('mst_product.not_for_selling', 0)
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where('mst_product.status', 0)
            ->where('mst_product.approval_status', 1);
        $query->orderBy('mst_product.out_stock', 'ASC');



        // ===== APPLY FILTERS =====
        if (!empty($size)) {
            $query->whereIn('mst_product.dial_diameter', $size);
        }

        if (!empty($gender)) {
            $query->whereIn('mst_product.pro_gender', $gender);
        }

        if (!empty($stock)) {
            $query->whereIn('mst_product.out_stock', $stock);
        }

        if (!empty($movement)) {
            $query->whereIn('mst_product.movement', $movement);
        }

        if ($min_price !== '' && $max_price !== '') {
            $query->whereBetween('mst_product.selling_price_exclusive', [$min_price, $max_price]);
        }

        // ===== SORT =====
        // ===== SORT =====
        if (!empty($sort)) {

            if ($sort == 'A2Z') {
                $query->orderBy('b1.brand_name', 'ASC');
            } elseif ($sort == 'Z2A') {
                $query->orderBy('b1.brand_name', 'DESC');
            } elseif ($sort == 'ASC1') {
                $query->orderBy('mst_product.selling_price_exclusive', 'ASC');
            } elseif ($sort == 'DESC1') {
                $query->orderBy('mst_product.selling_price_exclusive', 'DESC');
            } elseif ($sort == 'BESTSELLING') {
                // ✅ Removed join + groupBy
                // ✅ Show random products instead
                $query->inRandomOrder();
            } elseif ($sort == 'NEWARRIVAL') {
                $query->where('mst_product.new_arrival', 1)
                    ->orderBy('mst_product.pro_id', 'DESC');
            }
        } else {
            $query->orderBy('mst_product.out_stock', 'ASC');
        }
        $query = $query->paginate(12);

        $brandData = DB::table('mst_brand')
            ->where(function ($q) use ($brandName, $brandSlug) {
                $q->whereRaw('LOWER(brand_name)=LOWER(?)', [$brandName])
                    ->orWhereRaw('LOWER(brand_name)=LOWER(?)', [$brandSlug]);
            })
            ->select('brand_name', 'meta_title', 'brand_desc')
            ->first();

        // ===== BRAND DETAILS =====
        $brandDetails = null;
        if ($brandData) {

            $metaTitle = !empty($brandData->meta_title)
                ? $brandData->meta_title
                : 'Pre-Owned ' . $brandData->brand_name . ' Watches | Jay’s Watch Store';

            $metaDescription = !empty($brandData->brand_desc)
                ? $brandData->brand_desc
                : 'Explore certified pre-owned ' . $brandData->brand_name . ' watches at Jay’s Watch Store.';
        } else {

            $metaTitle = 'Pre-Owned ' . $brandName . ' Watches | Jay’s Watch Store';
            $metaDescription = 'Explore certified pre-owned ' . $brandName . ' watches at Jay’s Watch Store.';
        }

        $brandPath = resource_path("brand-descriptions/{$brandSlug}.html");

        if (file_exists($brandPath)) {
            $brandDetails = file_get_contents($brandPath);
        }

        return view('frontend.manufacturer', compact(
            'query',
            'brandName',
            'brandSlug',
            'brandDetails',
            'metaTitle',
            'metaDescription',
            'size',
            'size_data',
            'gender',
            'stock',
            'movement',
            'movement_Data',
            'sort',
            'min_price',
            'max_price'
        ));
    }

    public function filterBrandProduct(Request $request)
    {
        $brandSlug = $request->brand_slug;

        $sessionKey = 'brand_filter_' . $brandSlug;

        $sessionArray = [
            'size' => $request->size ?? [],
            'gender' => $request->gender ?? [],
            'stock' => $request->stock ?? [],
            'movement' => $request->movement ?? [],
            'sort' => $request->sort ?? '',
            'min_price' => $request->min_price ?? '',
            'max_price' => $request->max_price ?? ''
        ];

        session([$sessionKey => $sessionArray]);

        return response()->json(['status' => true]);
    }

    // Product Page
    public function productDetails($manufacturerSlug, $productSlug, $skuSuffix)
    {
        // dd($manufacturerSlug, $productSlug, $skuSuffix);
        $homecontent = DB::table('tbl_home_content')->first();
        // $storycontent = Storycontent::find(1);

        // Find product by name slug + last 7 chars of SKU
        $product = ProductModel::get()->first(function ($item) use ($productSlug, $skuSuffix) {
            $nameMatches = Str::slug($item->pro_name) === $productSlug;
            $skuMatches = substr($item->pro_sku, -7) === $skuSuffix; // last 7 characters

            return $nameMatches && $skuMatches;
        });

        if (! $product) {
            abort(404);
        }

        $product->today_views += 1;
        $product->save();

        $productDetails = DB::table('mst_product')
            ->leftJoin('mst_brand as b1', 'mst_product.brand', '=', 'b1.brand_id')
            ->leftJoin('mst_brand as b2', 'mst_product.manufacturer', '=', 'b2.brand_id')

            ->leftJoin('mst_color', 'mst_product.color', '=', 'mst_color.color_id')
            ->leftJoin('mst_color as dial_color', 'mst_product.dial_colour', '=', 'dial_color.color_id')
            ->leftJoin('mst_color as strap_color', 'mst_product.strap_colour', '=', 'strap_color.color_id')
            ->leftJoin('mst_movement', 'mst_product.movement', '=', 'mst_movement.m_id')
            // ->join('units', 'products.unit_id', '=', 'units.id')
            // ->leftJoin('categories as c1', 'products.category_id', '=', 'c1.id')
            // ->leftJoin('categories as c2', 'products.sub_category_id', '=', 'c2.id')
            // ->leftJoin('tax_rates', 'products.tax', '=', 'tax_rates.id')
            // ->join('variations as v', 'v.product_id', '=', 'products.id')
            ->select(
                'mst_product.pro_id',
                'b1.brand_name as brandinfo',
                'b2.brand_name as manufacturerinfo',
                'mst_product.pro_name as product',
                'dial_color.title as dialcolor',
                'strap_color.title as strapcolor',
                'mst_product.product_desc',
                'mst_product.pro_sku',
                'mst_product.pro_image',
                'mst_product.today_views',
                'mst_movement.title as movementinfo',
                // 'products.case_size',
                // 'products.alert_quantity',
                'mst_product.out_stock',
                'mst_product.condition',
                'mst_product.selling_price_exclusive',

                'mst_color.title as color',
                'mst_product.*'
            )
            ->where('mst_product.pro_id', $product->pro_id)
            ->first();

        if (! $productDetails) {
            abort(404);
        }

        $relatedProducts = DB::table('mst_product')
            ->leftJoin('mst_brand as b1', 'mst_product.brand', '=', 'b1.brand_id')
            ->leftJoin('mst_brand as b2', 'mst_product.manufacturer', '=', 'b2.brand_id')
            // ->join('units', 'products.unit_id', '=', 'units.id')
            // ->join('variations as v', 'v.product_id', '=', 'products.id')
            ->select(
                'mst_product.pro_id',
                'mst_product.pro_name as product',
                'b1.brand_name as brandinfo',
                'b2.brand_name as manufacturerinfo',
                'mst_product.pro_image',
                // 'products.alert_quantity',
                'mst_product.out_stock',
                'mst_product.pro_sku',
                'mst_product.selling_price_exclusive'
            )
            ->where('mst_product.not_for_selling', 0)
            ->where('mst_product.status', 0)
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            // ->whereNull('v.deleted_at')
            // ->where('mst_product.type', '!=', 'modifier')

            // ✅ SAME BRAND / MANUFACTURER
            ->where(function ($q) use ($productDetails) {
                $q->where('mst_product.brand', $productDetails->brand)
                    ->orWhere('mst_product.manufacturer', $productDetails->manufacturer);
            })

            // ❌ EXCLUDE CURRENT PRODUCT
            ->where('mst_product.pro_id', '!=', $productDetails->pro_id)

            // ✅ ONLY IN-STOCK PRODUCTS (if 0 = available)
            ->where('mst_product.out_stock', 0)
            ->limit(4)
            ->get();

        $query = $relatedProducts;

        $title = 'Product Details';

        // ✅ Activity Log (Product Viewed)
        try {

            $userId = session('user_id') ?? null;

            activity_log(
                'Ecommerce',
                'Product Viewed',
                "Product viewed: {$productDetails->product} (SKU: {$productDetails->pro_sku})",
                $userId,
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        $countries = MstCountryModel::orderBy('name')->get();

        $faq_data = DB::table('faq')->where('status', 0)->get();

        $user = null;

        if (session()->has('user_id')) {
            $user = DB::table('tbl_users')
                ->where('user_id', session('user_id'))
                ->first();
        }

        return view('frontend.product-details')->with(compact(
            'homecontent',
            // 'storycontent',
            'productDetails',
            'relatedProducts',
            'query',
            'user',
            'faq_data',
            'countries',
            'title'
        ));
    }

    // All Watches Page
    public function product(Request $request)
    {
        $homecontent = DB::table('tbl_home_content')->first();
        // dd($request->session()->get('filterarray'));

        if ($request->session()->get('filterarray')) {
            $filterData = $request->session()->get('filterarray');
            $brand = $filterData['brand'];
            $color_id = $filterData['color_id'];
            $material = $filterData['material'];
            $collection = $filterData['collection'];
            $size = $filterData['size'];
            $gender = $filterData['gender'] ?? [];
            $sort = $filterData['sort'];
            $stock = $filterData['stock'] ?? [];
            $movement = $filterData['movement'] ?? [];
            $min_price = $filterData['min_price'] ?? '';
            $max_price = $filterData['max_price'] ?? '';
        } else {
            $brand = [];
            $color_id = [];
            $material = [];
            $collection = [];
            $size = [];
            $gender = [];
            $stock = [];
            $movement = [];
            $sort = '';
            $min_price = '';
            $max_price = '';
        }

        //         dd([
        //     'brand' => $brand,
        //     'color_id' => $color_id,
        //     'material' => $material,
        //     'collection' => $collection,
        //     'size' => $size,
        //     'gender' => $gender,
        //     'stock' => $stock,
        //     'movement' => $movement,
        //     'sort' => $sort,
        //     'full_session' => $request->session()->get('filterarray')
        // ]);

        // dd($request->session()->get('filterarray'));

        $brands = BrandModel::get();
        $color = ColorModel::where('status', '0')->select('*')->get();
        $homecontent = DB::table('tbl_home_content')->first();
        $material_data = DB::table('mst_product')->select('mst_product.strap_material as material')->groupBy('strap_material')->get();
        $collection_Data = DB::table('mst_product')->select('mst_product.collection as collection')->groupBy('collection')->get();
        $movement_Data = DB::table('mst_product')
            ->join('mst_movement', 'mst_product.movement', '=', 'mst_movement.m_id')
            ->select(
                'mst_product.movement as movement_id',
                'mst_movement.title as movement'
            )
            ->whereNotNull('mst_product.movement')
            ->groupBy('mst_product.movement', 'mst_movement.title')
            ->get();
        $size_data = DB::table('mst_product')
            ->select('mst_product.dial_diameter as case_size')
            ->whereNotNull('mst_product.dial_diameter')
            ->whereRaw("TRIM(mst_product.dial_diameter) != ''")
            ->groupBy('mst_product.dial_diameter')
            ->get();

        $categoryData = ProductModel::where('pro_type', 'product')
            ->select('mst_product.category as category')->groupBy('category')->get();
        $query = DB::table('mst_product')
            ->leftJoin('mst_brand as b1', 'mst_product.brand', '=', 'b1.brand_id')
            ->leftJoin('mst_brand as b2', 'mst_product.manufacturer', '=', 'b2.brand_id')

            ->select(
                'mst_product.pro_id',
                'mst_product.pro_name as product',
                'mst_product.pro_type',
                'mst_product.year_of_card',
                'mst_product.product_desc',
                'mst_product.category as category',
                'mst_product.category as sub_category',
                'mst_product.unit as unit',
                'b1.brand_name as brand',
                'b2.brand_name as manufacturer',
                'mst_product.pro_tax as tax',
                'mst_product.pro_sku',
                'mst_product.strap_material',
                'mst_product.collection',
                'mst_product.condition',
                'mst_product.pro_image',
                'mst_product.approval_status',
                'mst_product.status',
                'mst_product.purchase_date',
                'mst_product.dial_diameter as case_size',
                'mst_product.not_for_selling',
                // 'products.product_custom_field1',
                // 'products.product_custom_field2',
                // 'products.product_custom_field3',
                // 'products.product_custom_field4',
                'mst_product.quantity',
                'mst_product.out_stock',  // Add this line
                'mst_product.pro_gender',
                'mst_product.selling_price_exclusive'
                // 'v.dpp_inc_tax'
            );
        $query->where('mst_product.status', 0);
        $query->whereRaw("FIND_IN_SET('product', mst_product.pro_type)");
        $query->where('mst_product.approval_status', 1);
        $query->where('mst_product.product_type', '!=', 'modifier');
        $query->where('mst_product.not_for_selling', 0);
        $query->orderBy('mst_product.out_stock', 'ASC');

        if (! empty($brand)) {
            $brand = array_values(array_filter($brand));
        }
        if (! empty($color_id)) {
            $color_id = array_values(array_filter($color_id));
        }
        if (! empty($material)) {
            $material = array_values(array_filter($material));
        }
        if (! empty($collection)) {
            $collection = array_values(array_filter($collection));
        }
        if (! empty($size)) {
            $size = array_values(array_filter($size));
        }
        if (! empty($gender)) {
            $gender = array_values(array_filter($gender));
        }

        if (! empty($brand)) {
            $query->whereIn('mst_product.brand', $brand);
        }


        if (! empty($size)) {
            $query->whereIn('mst_product.dial_diameter', $size);
        }

        if (! empty($gender)) {
            $query->whereIn('mst_product.pro_gender', $gender);
        }

        if (!empty($stock)) {
            $query->whereIn('mst_product.out_stock', $stock);
        }

        if (!empty($movement)) {
            $query->whereIn('mst_product.movement', $movement);
        }

        if ($min_price !== '' && $max_price !== '') {
            $query->whereBetween('mst_product.selling_price_exclusive', [$min_price, $max_price]);
        }

        // ðŸ”½ APPLY SORTING
        if (! empty($sort)) {

            // Aâ€“Z product name
            if ($sort == 'A2Z') {
                $query->orderBy('b1.brand_name', 'ASC');
            }

            // Zâ€“A product name
            elseif ($sort == 'Z2A') {
                $query->orderBy('b1.brand_name', 'DESC');
            }

            // Price low â†’ high
            elseif ($sort == 'ASC1') {
                $query->orderBy('mst_product.selling_price_exclusive', 'ASC');
            }

            // Price high â†’ low
            elseif ($sort == 'DESC1') {
                $query->orderBy('mst_product.selling_price_exclusive', 'DESC');
            }

            // Legacy sorting (ASC / DESC)
            elseif ($sort == 'ASC' || $sort == 'DESC') {
                $query->orderBy('mst_product.pro_name', $sort);
            } elseif ($sort == 'BESTSELLING') {
                // ✅ Removed join + groupBy
                // ✅ Show random products instead
                $query->inRandomOrder();
            } elseif ($sort == 'NEWARRIVAL') {
                $query->where('mst_product.new_arrival', 1)
                    ->orderBy('mst_product.pro_id', 'DESC');
            }
        }

        $query = $query->paginate(12);

        $total_data = $query->total();
        $currentPage = $query->currentPage();
        $perPage = $query->perPage();

        $from_data = ($currentPage - 1) * $perPage + 1;
        $to_data = min($currentPage * $perPage, $total_data);

        $sessionArray = [
            'brand' => $brand,
            'color_id' => $color_id,
            'material' => $material,
            'collection' => $collection,
            'size' => $size,
            'gender' => $gender,
            'sort' => $sort,
            'stock' => $stock,
            'movement' => $movement,
            'min_price' => $min_price,
            'max_price' => $max_price
        ];
        $request->session()->put('filterarray', $sessionArray);

        $title = 'Jays Watch Store :: Product';

        try {

            $userId = session('user_id') ?? null;

            $filterSummary = [];

            // Brand names
            if (! empty($brand)) {
                $brandNames = DB::table('mst_brand')
                    ->whereIn('brand_id', $brand)
                    ->pluck('brand_name')
                    ->toArray();

                $filterSummary[] = 'Brand: ' . implode(', ', $brandNames);
            }





            // Size
            if (! empty($size)) {
                $filterSummary[] = 'Size: ' . implode(', ', $size);
            }

            // Gender
            if (! empty($gender)) {
                $filterSummary[] = 'Gender: ' . implode(', ', $gender);
            }

            // Sorting
            if (! empty($sort)) {

                $sortText = match ($sort) {
                    'A2Z' => 'Brand A–Z',
                    'Z2A' => 'Brand Z–A',
                    'ASC1' => 'Price Low → High',
                    'DESC1' => 'Price High → Low',
                    'BESTSELLING' => 'Best Selling',
                    'NEWARRIVAL' => 'New Arrivals',
                    default => $sort,
                };

                $filterSummary[] = "Sort: {$sortText}";
            }

            $filtersText = ! empty($filterSummary)
                ? ' | Filters: ' . implode(' | ', $filterSummary)
                : '';

            activity_log(
                'Ecommerce',
                'All Watches Viewed',
                "User viewed All Watches page{$filtersText}",
                $userId,
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        // dd($request->session()->get('filterarray'));
        return view('frontend.product')->with(compact(
            'brands',
            'categoryData',
            'homecontent',
            'query',
            'brand',
            'material_data',
            'collection_Data',
            'movement_Data',
            'size',
            'size_data',
            'material',
            'collection',
            'sort',
            'color',
            'color_id',
            'total_data',
            'to_data',
            'from_data',
            'stock',
            'movement',
            'min_price',
            'max_price',
            'title',
            'gender'
        ));
    }

    public function filterProduct(Request $request)
    {
        $category = $request->category;
        $gender = $request->gender;
        $color_id = $request->colorList;
        $material = $request->material;
        $collection = $request->collection;
        $size = $request->size;
        $sort = $request->sort;
        $stock = $request->stock;
        $movement = $request->movement;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $sessionArray = [
            'brand' => $category,
            'gender' => $gender,
            'color_id' => $color_id,
            'material' => $material,
            'collection' => $collection,
            'size' => $size,
            'sort' => $sort,
            'stock' => $stock,
            'movement' => $movement,
            'min_price' => $min_price,
            'max_price' => $max_price
        ];
        $request->session()->put('filterarray', $sessionArray);

        // dd($sessionArray);
        return response()->json(['filterData' => $sessionArray]);
    }

    // New Arrivals
    public function arrivals(Request $request)
    {
        $homecontent = DB::table('tbl_home_content')->first();

        if ($request->session()->get('filterarray1')) {
            $filterData = $request->session()->get('filterarray1');
            $brand = $filterData['brand'];
            $discover = $filterData['discover'];
            $color_id = $filterData['color_id'];
            $category = $filterData['category'];
            $sub_category = $filterData['sub_category'];
            $sort = $filterData['sort'];
            $min_price = $filterData['min_price'];
            $high_price = $filterData['high_price'];
        } else {
            $brand = '';
            $color_id = '';
            $category = '';
            $discover = '';
            $sub_category = '';
            $sort = '';
            $min_price = 0;
            $high_price = 1200000;
        }
        // dd($request->session()->get('filterarray'));

        $brands = BrandModel::get();
        $color = ColorModel::where('status', '0')->select('*')->get();
        $homecontent = DB::table('tbl_home_content')->first();
        $categoryData = ProductModel::where('pro_type', 'product')
            ->select('mst_product.category as category')->groupBy('category')->get();
        $query = DB::table('mst_product')
            ->leftJoin('mst_brand as b1', 'mst_product.brand', '=', 'b1.brand_id')
            ->leftJoin('mst_brand as b2', 'mst_product.manufacturer', '=', 'b2.brand_id')
            ->select(
                'mst_product.pro_id',
                'mst_product.pro_name as product',
                'mst_product.pro_type',
                'mst_product.year_of_card',
                'mst_product.product_desc',
                'mst_product.category as category',
                'mst_product.category as sub_category',
                'mst_product.unit as unit',
                'b1.brand_name as brand',
                'b2.brand_name as manufacturer',
                'mst_product.pro_tax as tax',
                'mst_product.pro_sku',
                'mst_product.strap_material',
                'mst_product.collection',
                'mst_product.condition',
                'mst_product.pro_image',
                'mst_product.approval_status',
                'mst_product.status',
                'mst_product.purchase_date',
                'mst_product.dial_diameter as case_size',
                'mst_product.not_for_selling',
                // 'products.product_custom_field1',
                // 'products.product_custom_field2',
                // 'products.product_custom_field3',
                // 'products.product_custom_field4',
                'mst_product.quantity',
                'mst_product.out_stock',  // Add this line
                'mst_product.pro_gender',
                'mst_product.selling_price_exclusive'
                // 'v.dpp_inc_tax'
            );
        $query->where('mst_product.not_for_selling', 0);
        $query->where('mst_product.status', 0);
        $query->whereRaw("FIND_IN_SET('product', mst_product.pro_type)");
        // $query->where('mst_product.product_type', '!=', 'modifier');
        $query->where('mst_product.new_arrival', 1);
        $query->where('mst_product.approval_status', 1);
        $query->where('mst_product.out_stock', 0);

        if (! empty($brand)) {
            $query->whereIn('mst_product.brand', $brand);
        }
        if (! empty($category)) {
            $query->whereIn('mst_product.category', $category);
        }
        if (! empty($color_id)) {
            $query->whereIn('mst_product.color', $color_id);
        }
        if (! empty($sub_category)) {
            $query->whereIn('mst_product.sub_category', $sub_category);
        }

        if (! empty($discover)) {
            if ($discover == 'today') {
                $start_date = date('Y-m-d') . ' 00:00:01';
                $end_date = date('Y-m-d') . ' 11:59:55';

                $query->where('mst_product.created_at', '>=', $start_date);
                $query->where('mst_product.created_at', '<=', $end_date);
            }

            if ($discover == 'this_week') {
                $monday = date('Y-m-d', strtotime('monday this week')) . ' 00:00:01';
                $saturday = date('Y-m-d', strtotime('saturday this week')) . ' 11:59:55';

                $query->where('mst_product.created_at', '>=', $monday);
                $query->where('mst_product.created_at', '<=', $saturday);
            }

            if ($discover == 'this_month') {
                $first_date = date('Y-m-d', strtotime('first day of this month')) . ' 00:00:01';
                $last_date = date('Y-m-d', strtotime('last day of this month')) . ' 11:59:55';
                // dd($last_date);
                $query->where('mst_product.created_at', '>=', $first_date);
                $query->where('mst_product.created_at', '<=', $last_date);
            }
        }

        if ($min_price != 0 && $high_price != 0) {

            $query->where('mst_product.selling_price_exclusive', '>=', $min_price);
            $query->where('mst_product.selling_price_exclusive', '<=', $high_price);
        } else {
        }

        if (! empty($sort)) {
            if ($sort == 'ASC' || $sort == 'DESC') {
                $query->orderBy('mst_product.name', $sort);
            }
            if ($sort == 'ASC1' || $sort == 'DESC1') {
                if ($sort == 'ASC1') {
                    $sort == 'ASC';
                    $query->orderBy('mst_product.selling_price_exclusive', 'ASC');
                } else {
                    $sort == 'DESC';
                    $query->orderBy('mst_product.selling_price_exclusive', 'DESC');
                }
            }
        }

        $query = $query->paginate(12);
        // dd($query);
        $total_data = $query->total();
        $currentPage = $query->currentPage();
        $perPage = $query->perPage();

        $from_data = ($currentPage - 1) * $perPage + 1;
        $to_data = min($currentPage * $perPage, $total_data);

        $products = DB::table('mst_product')
            ->leftJoin('mst_brand as b1', 'mst_product.brand', '=', 'b1.brand_id')
            ->leftJoin('mst_brand as b2', 'mst_product.manufacturer', '=', 'b2.brand_id')
            ->select(
                'mst_product.pro_id',
                'mst_product.pro_name as product',
                'mst_product.pro_type',
                'mst_product.year_of_card',
                'mst_product.product_desc',
                'mst_product.category as category',
                'mst_product.category as sub_category',
                'mst_product.unit as unit',
                'b1.brand_name as brand',
                'b2.brand_name as manufacturer',
                'mst_product.pro_tax as tax',
                'mst_product.pro_sku',
                'mst_product.strap_material',
                'mst_product.collection',
                'mst_product.condition',
                'mst_product.pro_image',
                'mst_product.approval_status',
                'mst_product.status',
                'mst_product.purchase_date',
                'mst_product.dial_diameter as case_size',
                'mst_product.not_for_selling',
                // 'products.product_custom_field1',
                // 'products.product_custom_field2',
                // 'products.product_custom_field3',
                // 'products.product_custom_field4',
                'mst_product.quantity',
                'mst_product.out_stock',  // Add this line
                'mst_product.pro_gender',
                'mst_product.selling_price_exclusive'
                // 'v.dpp_inc_tax'
            );
        $products->where('mst_product.not_for_selling', 0);
        $products->where('mst_product.status', 0);
        $products->whereRaw("FIND_IN_SET('product', mst_product.pro_type)");
        $products->where('mst_product.new_arrival', 1);
        $products->where('mst_product.approval_status', 1);
        $products->where('mst_product.out_stock', 0);
        // $products->where('mst_product.product_type', '!=', 'modifier'); // if needed

        $products = $products->paginate(6);

        $title = 'Jays Watch Store :: New Arrivals';

        try {

            $userId = session('user_id') ?? null;

            activity_log(
                'Ecommerce',
                'Arrival Page Viewed',
                'User viewed New Arrivals page',
                $userId,
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        return view('frontend.arrivals')->with(compact(
            'products',
            'brands',
            'categoryData',
            'homecontent',
            'query',
            'brand',
            'category',
            'sub_category',
            'sort',
            'min_price',
            'high_price',
            'color',
            'color_id',
            'discover',
            'homecontent',
            'total_data',
            'to_data',
            'from_data',
            'title'
        ));
    }

    // Enquiry Now

    private function verifyRecaptcha(Request $request)
    {
        $captcha = $request->input('g-recaptcha-response');

        if (!$captcha) {
            return [
                'status' => false,
                'message' => 'Please complete captcha verification.'
            ];
        }


        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
                'response' => $captcha,
                'remoteip' => $request->ip(),
            ]
        );

        $result = json_decode($response->body(), true);

        if (empty($result['success'])) {
            return [
                'status' => false,
                'message' => 'Captcha verification failed. Please try again.'
            ];
        }

        return [
            'status' => true
        ];
    }
    public function addProduct_enquiry(Request $request)
    {

        // dd($request->all());
        // ✅ Load SMTP settings from DB

        $captchaCheck = $this->verifyRecaptcha($request);

        if (!$captchaCheck['status']) {
            return response()->json($captchaCheck);
        }


        $countryName = DB::table('mst_country')
            ->where('id', $request->country_id)
            ->value('name');

        $stateName = DB::table('mst_state')
            ->where('id', $request->state_id)
            ->value('name');

        $cityName = DB::table('mst_city')
            ->where('id', $request->city_id)
            ->value('name');

        set_smtp_config();

        $userPhone = $request->userPhone;
        $email = $request->userEmail;
        $message = $request->userMessage;

        $product_Details = ProductModel::find($request->product_id);

        if (! $product_Details) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ]);
        }

        $product_enquiry = new ProductEnquiryModel;
        $product_enquiry->pro_id = $request->product_id;
        $product_enquiry->product_name = $request->Product_name;
        $product_enquiry->model_number = $request->model_number;
        $product_enquiry->sku = $product_Details->pro_sku;
        $product_enquiry->name = $request->userName;
        $product_enquiry->email = $email;
        $product_enquiry->mobile = $userPhone;
        $product_enquiry->country =  $countryName;
        $product_enquiry->state =  $stateName;
        $product_enquiry->city =  $cityName;
        $product_enquiry->message = $message;
        $product_enquiry->status = '0';
        $product_enquiry->date = now();
        $product_enquiry->save();

        try {

            $userId = session('user_id') ?? null;

            $logMessage = "Product enquiry submitted for {$product_Details->pro_name} "
                . "(SKU: {$product_Details->pro_sku}) "
                . "by {$request->userName} ({$email})";

            activity_log(
                'Ecommerce',
                'Product Enquiry',
                $logMessage,
                $userId,
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        $subject = 'Product Enquiry from JaysWatch Website';

        $body = 'Product Name: ' . $request->Product_name . "\n";
        $body .= 'Model Number: ' . $request->model_number . "\n";
        $body .= 'SKU Number: ' . $product_Details->pro_sku . "\n\n";

        $body .= "Customer Details\n";
        $body .= "-------------------------\n";
        $body .= 'Name: ' . $request->userName . "\n";
        $body .= 'Mobile: ' . $request->phone_code . $userPhone . "\n";
        $body .= 'Email: ' . $email . "\n";
        $body .= 'Country: ' . $countryName . "\n";
        $body .= 'State: ' . $stateName . "\n";
        $body .= 'City: ' . $cityName . "\n\n";
        $body .= "Message:\n" . $message . "\n";

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            send_multi_recipient_mail(
                $subject,
                $body,
                $email
            );

            return response()->json([
                'status' => true,
                'message' => 'Thank you for your interest in this product. Our team will contact you soon with complete details.',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid email address.',
        ]);
    }

    // term and condition
    public function terms_and_condtion()
    {
        $title = 'Terms and Conditions';

        return view('frontend.terms_and_condtion')->with(compact('title'));
    }

    public function privacy_policy()
    {
        $title = 'Privacy Policy';

        return view('frontend.privacy_policy')->with(compact('title'));
    }

    public function terms_of_use()
    {
        $title = 'Terms of Use';

        return view('frontend.terms_of_use')->with(compact('title'));
    }

    // Search Modal
    public function frontsearch(Request $request)
    {
        $query = trim($request->input('query'));

        if (! $query) {
            return response()->json([]);
        }

        try {

            $userId = session('user_id') ?? null;

            // Split query into words
            $words = preg_split('/\s+/', trim($query));
            $wordCount = count($words);

            // ✅ Accept only when 5 or more words
            if ($wordCount >= 3) {

                // Limit to maximum 10 words
                $acceptedQuery = implode(' ', array_slice($words, 0, 2));

                activity_log(
                    'Ecommerce',
                    'Product Search',
                    "User searched for: {$acceptedQuery}",
                    $userId,
                    0
                );
            }
        } catch (\Exception $e) {
            // silent fail
        }

        $results = ProductModel::leftJoin('mst_brand as b', 'mst_product.brand', '=', 'b.brand_id')
            ->leftJoin('mst_brand as b2', 'mst_product.manufacturer', '=', 'b2.brand_id')
            ->where('mst_product.not_for_selling', 0)
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where(function ($q) use ($query) {
                // Match product name OR brand name with word sequence
                $q->where('mst_product.pro_name', 'LIKE', "%{$query}%")
                    ->orWhere('b.brand_name', 'LIKE', "%{$query}%");
            })
            ->select(
                'mst_product.pro_id',
                'mst_product.pro_name',
                'mst_product.pro_image',
                'b.brand_name as brand_name',
                'b.brand_id as brand_id',
                'b.brand_img as brand_image',
                'b2.brand_name as manufacturer',
                'mst_product.pro_sku'
            )

            ->get()
            ->map(function ($item) {
                // $item->url = url('product/' . Str::slug($item->brand_name) . '/' . Str::slug($item->name));

                // $item->brandfolder = str_replace(' ', '_', trim($item->brand_name));
                // $item->productfolder = str_replace(' ', '_', trim($item->pro_name));

                $item->brandfolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name);
                $item->productfolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->pro_name);

                $item->url = url(
                    'product/' .
                        Str::slug($item->manufacturer ?: $item->brand_name) . '/' .
                        Str::slug($item->pro_name) . '/' .
                        ($item->pro_sku ? substr($item->pro_sku, -7) : '0000000')
                );

                return $item;
            });

        return response()->json($results);
    }

    public function sell()
    {
        $title = 'Sell Your Watch';
        $userId = session('user_id');

        $brand_data = BrandModel::where('status', '0')->select('*')->get();
        $countries = MstCountryModel::orderBy('name')->get();
        $cust_data = UserModel::where('user_id', $userId)->first();

        $new_arrivals = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name'
        )
            ->join('mst_brand', 'mst_brand.brand_id', '=', 'mst_product.brand')
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where('mst_product.new_arrival', 1)
            ->where('mst_product.not_for_selling', 0)
            ->where('mst_product.approval_status', 1)
            ->where('mst_product.status', 0)
            ->latest()
            ->get();

        $sell_faq = FaqModel::whereIn('type', ['sell', 'other'])
            ->where('status', 0)
            ->orderBy('faq_id', 'desc')
            ->get();

        return view('frontend.sell')->with(compact('title', 'cust_data', 'brand_data', 'countries', 'new_arrivals', 'sell_faq'));
    }

    public function sell_store(Request $request)
    {
        $request->validate([
            'selling_brand_id' => 'required',
            'selling_model' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'photos' => 'required',
        ]);

        /* ===== Get Country, State, City Names ===== */
        $countryName = DB::table('mst_country')
            ->where('id', $request->country_id)
            ->value('name');

        $stateName = DB::table('mst_state')
            ->where('id', $request->state_id)
            ->value('name');

        $cityName = DB::table('mst_city')
            ->where('id', $request->city_id)
            ->value('name');

        /* ===== Upload Images ===== */
        $images = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/front/uploads/selling'), $name);
                $images[] = $name;
            }
        }

        DB::table('tbl_selling')->insert([
            'brand_id' => $request->selling_brand_id,
            'model_no' => $request->selling_model,
            'price' => $request->selling_price,
            'image' => implode(',', $images),
            'name' => $request->name,
            'email_id' => $request->email,
            'contact_no' => $request->phone,

            // ✅ Insert names instead of IDs
            'country' => $countryName,
            'state' => $stateName,
            'city' => $cityName,

            'created_at' => now(),
            'created_by' => 0,
            'status' => 0,
        ]);

        try {
            $userId = session('user_id') ?? null;

            $brandName = DB::table('mst_brand')
                ->where('brand_id', $request->selling_brand_id)
                ->value('brand_name');

            $logMessage = "Sell watch request submitted for Brand: {$brandName}, "
                . "Model: {$request->selling_model} "
                . "by {$request->name} ({$request->email})";

            activity_log(
                'Ecommerce',
                'Sell Watch Enquiry',
                $logMessage,
                $userId,
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        return response()->json([
            'status' => true,
        ]);
    }
    // Trade Watch Enquiry
    public function trade()
    {
        $title = 'Trade Enquiry';
        $userId = session('user_id');

        $brand_data = BrandModel::where('status', '0')->select('*')->get();
        $countries = MstCountryModel::orderBy('name')->get();
        $cust_data = UserModel::where('user_id', $userId)->first();

        $new_arrivals = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name'
        )
            ->join('mst_brand', 'mst_brand.brand_id', '=', 'mst_product.brand')
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where('mst_product.new_arrival', 1)
            ->where('mst_product.not_for_selling', 0)
            ->where('mst_product.approval_status', 1)
            ->where('mst_product.status', 0)
            ->latest()
            ->get();

        $trade_faq = FaqModel::whereIn('type', ['trade', 'other'])
            ->where('status', 0)
            ->orderBy('faq_id', 'desc')
            ->get();

        return view('frontend.trade')->with(compact('title', 'brand_data', 'new_arrivals', 'trade_faq', 'countries', 'cust_data'));
    }

    public function sendOtp(Request $request)
    {
        $phone = $request->phone;

        // Remove spaces and +
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Validate international format length
        if (strlen($phone) < 10 || strlen($phone) > 15) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid phone number'
            ], 422);
        }

        $otp = rand(100000, 999999);

        TradeVerification::where('phone', $phone)->delete();

        TradeVerification::create([
            'phone' => $phone,
            'otp' => $otp,
            'is_verified' => 0,
        ]);

        $message = urlencode('Your verification OTP is: ' . $otp);

        $url = 'https://vferp.com/eizap/v1/send?access_token=wapi_2fbb02f64d658963bce9d66f5674d49739d54b521f13f114eaef414c3e73a55b&instance_id=gfpp9T&number=' . $phone . '&type=text&message=' . $message;

        file_get_contents($url);

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',
        ]);
    }

    // public function verifyOtp(Request $request)
    // {
    //     $phone = $request->phone;
    //     $otp = $request->otp;

    //     // remove +
    //     $phone = str_replace('+', '', $phone);

    //     // if 10 digit number add 91
    //     if (strlen($phone) == 10) {
    //         $phone = '91' . $phone;
    //     }

    //     $verify = TradeVerification::where('phone', $phone)
    //         ->where('otp', $otp)
    //         ->latest()
    //         ->first();

    //     if ($verify) {

    //         $verify->is_verified = 1;
    //         $verify->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'OTP verified',
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Invalid OTP',
    //     ]);
    // }

    public function verifyOtp(Request $request)
    {
        $phone = $request->phone;
        $otp = $request->otp;



        // Keep only digits
        $phone = preg_replace('/\D+/', '', $phone);


        // Must be between 10 and 15 digits for international numbers
        if (strlen($phone) < 10 || strlen($phone) > 15) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid phone number',
            ], 422);
        }

        $verify = TradeVerification::where('phone', $phone)
            ->where('otp', $otp)
            ->latest()
            ->first();

        if ($verify) {
            $verify->is_verified = 1;
            $verify->save();

            return response()->json([
                'status' => true,
                'message' => 'OTP verified',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP',
        ]);
    }

    public function trade_store(Request $request)
    {
        // dd($request->all());
        $images = [];

        if ($request->hasFile('photos')) {

            foreach ($request->file('photos') as $file) {

                $name = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('assets/front/uploads/trading'), $name);

                $images[] = $name;
            }
        }
        $countryName = DB::table('mst_country')
            ->where('id', $request->country_id)
            ->value('name');

        $stateName = DB::table('mst_state')
            ->where('id', $request->state_id)
            ->value('name');

        $cityName = DB::table('mst_city')
            ->where('id', $request->city_id)
            ->value('name');

        DB::table('tbl_trading')->insert([
            'trading_brand_id' => $request->trading_brand_id,
            'treading_model_no' => $request->trading_model,
            'price' => $request->trading_price,
            'images' => implode(',', $images),

            'looking_brand_id' => $request->looking_brand_id,
            'looking_model_no' => $request->looking_model,
            'comments' => $request->comments,

            'name' => $request->name,
            'email_id' => $request->email,
            'contact_no' => $request->phone,
            // 'purchase_from' => $request->purchase_from,
            'country' => $countryName,
            'state' => $stateName,
            'city' => $cityName,

            'is_subscribed' => 1,

            'created_at' => now(),
            'created_by' => 0,
            'status' => 0,
        ]);

        // ✅ Activity Log (Trade Watch Enquiry)
        try {




            $userId = session('user_id') ?? null;

            // Fetch brand names
            $tradingBrand = DB::table('mst_brand')
                ->where('brand_id', $request->trading_brand_id)
                ->value('brand_name');

            $lookingBrand = DB::table('mst_brand')
                ->where('brand_id', $request->looking_brand_id)
                ->value('brand_name');

            $logMessage = 'Trade request submitted. '
                . "Trading: {$tradingBrand} ({$request->trading_model}) "
                . "→ Looking for: {$lookingBrand} ({$request->looking_model}) "
                . "by {$request->name} ({$request->email})";

            activity_log(
                'Website',
                'Trade Watch Enquiry',
                $logMessage,
                $userId,
                0
            );
        } catch (\Exception $e) {
            // silent fail
        }

        return response()->json(['status' => 200]);
    }

    // Blog Page
    public function blog()
    {
        $title = 'Jayswatch - Blog';
        $blogs = BlogModel::where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $blogs_recent = BlogModel::where('status', 0)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $brand_data = BrandModel::where('status', '0')->get();
        $trending_blogs = BlogModel::where('status', 0)
            ->orderBy('view_count', 'desc')
            ->limit(4)
            ->get();

        $editors_picks = BlogModel::where('status', 0)
            ->where('editors_pick', 1)
            ->orderBy('created_at', 'desc')

            ->get();

        $blogs_features = BlogModel::where('status', 0)
            ->where('features_blog', 1)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();


        $new_arrivals = ProductModel::select(
            'mst_product.*',
            'mst_brand.brand_name'
        )
            ->join('mst_brand', 'mst_brand.brand_id', '=', 'mst_product.brand')
            ->whereRaw("FIND_IN_SET('product', mst_product.pro_type)")
            ->where('mst_product.new_arrival', 1)
            ->where('mst_product.not_for_selling', 0)
            ->where('mst_product.approval_status', 1)
            ->where('mst_product.status', 0)
            ->latest()
            ->get();

        return view('frontend.blog.blog_index')->with(compact('title', 'blogs', 'editors_picks', 'blogs_recent', 'brand_data', 'trending_blogs', 'new_arrivals', 'blogs_features'));
    }



    public function blogDetail($slug)
    {
        $title = 'Jayswatch - Blog Details';

        $blog = BlogModel::where('status', 0)
            ->get()
            ->first(function ($blog) use ($slug) {
                return Str::slug($blog->title) == $slug;
            });

        if (!$blog) {
            abort(404);
        }

        $multiBlogs = MultiBlogModel::where('blog_id', $blog->blog_id)
            ->where('status', 0)
            ->get();

        $trending_blogs = BlogModel::where('status', 0)
            ->orderBy('view_count', 'desc')
            ->limit(4)
            ->get();

        return view('frontend.blog.blog_details', compact('title', 'blog', 'trending_blogs', 'multiBlogs'));
    }

    public function blogAllView(Request $request)
    {
        $title = 'Jayswatch - Blog View';

        $sort = $request->get('sorting', 'DESC'); // default DESC

        $allblogs = BlogModel::where('status', 0)
            ->orderBy('created_at', $sort)
            ->paginate(10)
            ->withQueryString(); // keep sorting in pagination

        return view('frontend.blog.blog_all_view', compact('title', 'allblogs'));
    }


    public function blogBrandView(Request $request, $brand)
    {
        $title = 'Jayswatch - Blog View';

        $sort = $request->get('sorting', 'DESC');

        // convert slug back to brand name (if needed)
        $brandName = str_replace('-', ' ', $brand);

        $allblogs = BlogModel::where('status', 0)
            ->where('brand', $brandName)
            ->orderBy('created_at', $sort)
            ->paginate(10)
            ->withQueryString();

        return view('frontend.blog.blog_all_view', compact('title', 'allblogs'));
    }

    public function blogAllBrandView(Request $request)
    {
        $title = 'Jayswatch - Blog Brand View';

        $sort = $request->get('sorting', 'DESC');

        // convert slug back to brand name (if needed)


        $allblogs = BlogModel::where('status', 0)
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->orderBy('created_at', $sort)
            ->paginate(10)
            ->withQueryString();

        return view('frontend.blog.blog_all_view', compact('title', 'allblogs'));
    }


    public function blogAllFeaturesView(Request $request)
    {
        $title = 'Jayswatch - Blog Features View';

        $sort = $request->get('sorting', 'DESC');

        // convert slug back to brand name (if needed)


        $allblogs = BlogModel::where('status', 0)
            ->where('features_blog', 1)
            ->orderBy('created_at', $sort)
            ->paginate(10)
            ->withQueryString();

        return view('frontend.blog.blog_all_view', compact('title', 'allblogs'));
    }


    public function blogAllTrendingView(Request $request)
    {
        $title = 'Jayswatch - Blog Trending View';

        $sort = $request->get('sorting', 'DESC');

        $allblogs = BlogModel::where('status', 0)
            ->orderByRaw('COALESCE(view_count, 0) DESC')
            ->orderBy('created_at', $sort)
            ->paginate(10)
            ->withQueryString();

        return view('frontend.blog.blog_all_view', compact('title', 'allblogs'));
    }


    //FAQ

    public function allfaq(Request $request)
    {
        $title = 'Jayswatch - FAQ View';



        $allfaq = FaqModel::where('status', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('frontend.front_faq', compact('title', 'allfaq'));
    }

    //Pan Verification
    public function verifyPan(Request $request)
    {
        $client = new Client();

        $response = $client->post('https://kyc-api.surepass.app/api/v1/pan/pan-comprehensive', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('SUREPASS_TOKEN'),
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'id_number' => $request->pan
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return response()->json($data);
    }
}
