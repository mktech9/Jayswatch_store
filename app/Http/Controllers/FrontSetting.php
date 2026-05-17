<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\AboutContentModel;
use App\Models\ClientModel;
use App\Models\ContactFollowupModel;
use App\Models\ContactModel;
use App\Models\HomeContentModel;
use App\Models\ProductEnquiryFollowupModel;
use App\Models\ProductEnquiryModel;
use App\Models\ProductSellFollowupModel;
use App\Models\ProductSellModel;
use App\Models\SliderModel;
use App\Models\TradingFollowupModel;
use App\Models\TradingModel;
use App\Models\MstCountryModel;
use App\Models\CatalogueModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\table;

class FrontSetting extends Controller
{
    public function slider_index()
    {
        $page_title = 'Slider Management';

        return view('front_settings.slider', compact('page_title'));
    }

    public function slider_store(Request $request)
    {
        $currentUserId = current_user_id();
        $sliderId = $request->slider_id;
        $slider = $sliderId ? SliderModel::findOrFail($sliderId) : null;

        $basePath = public_path('/assets/admin_assets/sliders');
        File::makeDirectory($basePath, 0777, true, true);

        // --- Desktop Image Logic ---
        $desktop_image = $slider->desktop_image ?? null;
        if ($request->hasFile('desktop_image')) {
            // $desktop_image = ImageHelper::convertToWebp($request->file('desktop_image'), $basePath, 1920, 800);
            $desktop_image = ImageHelper::convertToWebp(
                $request->file('desktop_image'),
                $basePath
            );
        }

        // --- Mobile Image Logic ---
        $mobile_image = $slider->mobile_image ?? null;
        if ($request->hasFile('mobile_image')) {
            // $mobile_image = ImageHelper::convertToWebp($request->file('mobile_image'), $basePath, 600, 800);
            $mobile_image = ImageHelper::convertToWebp(
                $request->file('mobile_image'),
                $basePath
            );
        }

        $data = [
            'desktop_image' => $desktop_image,
            'mobile_image' => $mobile_image,
            'updated_by' => $currentUserId,
        ];

        if ($slider) {
            $slider->update($data);
            $message = 'Slider updated successfully';
        } else {
            $data['created_by'] = $currentUserId;
            SliderModel::create($data);
            $message = 'Slider added successfully';
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function slider_list(Request $request)
    {
        $query = SliderModel::where('status', 0);
        $totalData = $query->count();

        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $data = $query->offset($start)->limit($limit)->orderBy('slider_id', 'desc')->get();

        $formattedData = [];

        // Use config helper to get actual_url defined in your environment/config
        $actual_url = config('app.actual_url');
        $path = $actual_url . '/admin_assets/sliders/';

        foreach ($data as $key => $row) {
            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                // Updated to use $path variable
                'desktop' => '<img src="' . $path . $row->desktop_image . '" width="120" class="rounded border shadow-sm">',
                'mobile' => '<img src="' . $path . $row->mobile_image . '" width="60" class="rounded border shadow-sm">',
                'action' => '
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-icon btn-primary-light rounded-pill editSlider" data-id="' . $row->slider_id . '">
                            <i class="bx bx-edit"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-danger-light rounded-pill deleteSlider" data-id="' . $row->slider_id . '">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>',
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $formattedData,
        ]);
    }

    public function slider_edit($id)
    {
        $slider = SliderModel::find($id);
        if ($slider) {
            return response()->json(['status' => 200, 'data' => $slider]);
        }

        return response()->json(['status' => 404, 'message' => 'Not found']);
    }

    public function slider_delete(Request $request)
    {
        SliderModel::where('slider_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Slider removed successfully']);
    }

    public function client_index()
    {
        $page_title = 'Client Reviews';

        return view('front_settings.client', compact('page_title'));
    }

    public function client_store(Request $request)
    {
        $currentUserId = current_user_id();
        $clientId = $request->client_id;
        $client = $clientId ? ClientModel::findOrFail($clientId) : null;

        $data = [
            'client_name' => $request->client_name,
            'review' => $request->review,
            'updated_by' => $currentUserId,
        ];

        if ($client) {
            $client->update($data);
            $message = 'Review updated successfully';
        } else {
            $data['created_by'] = $currentUserId;
            ClientModel::create($data);
            $message = 'Review added successfully';
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function client_list(Request $request)
    {
        $query = ClientModel::where('status', 0);
        $totalData = $query->count();
        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $data = $query->offset($start)->limit($limit)->orderBy('client_id', 'desc')->get();

        $formattedData = [];
        foreach ($data as $key => $row) {
            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                'client_name' => e($row->client_name),
                'review' => \Illuminate\Support\Str::limit(e($row->review), 50),
                'action' => '
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-icon btn-primary-light rounded-pill editClient" data-id="' . $row->client_id . '">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger-light rounded-pill deleteClient" data-id="' . $row->client_id . '">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>',
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $formattedData,
        ]);
    }

    public function client_edit($id)
    {
        $client = ClientModel::find($id);

        return $client ? response()->json(['status' => 200, 'data' => $client]) : response()->json(['status' => 404]);
    }

    public function client_delete(Request $request)
    {
        ClientModel::where('client_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Review deleted successfully']);
    }

    public function home_content_index()
    {
        $page_title = 'Edit Homepage Content';
        $content = HomeContentModel::first();

        return view('front_settings.home_content', compact('page_title', 'content'));
    }

    public function home_content_update(Request $request)
    {
        $currentUserId = current_user_id();
        $content = HomeContentModel::first() ?: new HomeContentModel;

        $basePath = public_path('/assets/admin_assets/home_content');
        File::makeDirectory($basePath, 0777, true, true);

        $data = $request->only([
            'slider_heading',
            'slider_content',
            'watch_list_heading',
            'list_top_paragraph',
            'list_bottom_paragraph',
            'second_banner_heading',
            'second_banner_content',
            'meta_title',
            'meta_description',
        ]);

        $imageFields = [
            'second_top_signature_image',
            'content_image',
            'icon_image',
            'mobile_content_image',
            'mobile_icon_image',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($basePath, $filename);
                $data[$field] = $filename;
            } else {
                $data[$field] = $content->$field;
            }
        }

        if ($request->hasFile('second_banner_image')) {
            $data['second_banner_image'] = ImageHelper::convertToWebp(
                $request->file('second_banner_image'),
                $basePath,
                1920,
                1080
            );
        } else {
            $data['second_banner_image'] = $content->second_banner_image;
        }

        $data['updated_by'] = $currentUserId;
        if (! $content->exists) {
            $data['created_by'] = $currentUserId;
        }

        HomeContentModel::updateOrCreate(['hc_id' => $content->hc_id ?? null], $data);

        return response()->json(['success' => true, 'message' => 'Homepage content updated successfully']);
    }

    public function contact_index()
    {
        $page_title = 'Contact-Us List';

        return view('front_settings.contact_list', compact('page_title'));
    }

    public function contact_list_data(Request $request)
    {
        $query = ContactModel::selectRaw("
        tbl_contacts.*,
        DATE_FORMAT(tbl_contacts.date, '%d-%m-%Y') as formatted_date,
        cf.note as followup_note,
        cf.curr_status as followup_status
    ")
            ->leftJoin(DB::raw('
        (
            SELECT f1.*
            FROM tbl_contact_followups f1
            INNER JOIN (
                SELECT contact_id, MAX(created_at) as latest_date
                FROM tbl_contact_followups
                GROUP BY contact_id
            ) f2
            ON f1.contact_id = f2.contact_id
            AND f1.created_at = f2.latest_date
        ) as cf
    '), 'cf.contact_id', '=', 'tbl_contacts.contact_id')
            ->where('tbl_contacts.status', 0);

        // Total records
        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Default select = 10
        $limit = (int) $request->input('length', 10);
        $start = (int) $request->input('start', 0);

        $queryData = $query->orderBy('tbl_contacts.contact_id', 'desc');

        // ✅ Handle "All" option safely (length = -1)
        if ($limit != -1) {
            $queryData->offset($start)->limit($limit);
        }

        $data = $queryData->get();

        $formattedData = [];

        foreach ($data as $key => $row) {

            // Status Badge
            if ($row->followup_status == 'pending') {
                $badge = '<span class="badge bg-warning">Pending</span>';
            } elseif ($row->followup_status == 'completed') {
                $badge = '<span class="badge bg-success">Completed</span>';
            } else {
                $badge = '<span class="badge bg-secondary">No Follow-up</span>';
            }

            // Note + Status
            $followupHtml = $row->followup_note
                ? '<small>' . e(Str::limit($row->followup_note, 40)) . '</small><br>
               <div class="text-center mt-1">' . $badge . '</div>'
                : '<div class="text-center">' . $badge . '</div>';

            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                'date' => $row->formatted_date,
                'name' => e($row->name),
                'email' => e($row->email),
                'mobile' => e($row->mobile),
                'country' => e($row->country),
                'city' => e($row->city),
                'store' => e($row->store),

                'message' => Str::limit(e($row->message), 30),
                'last_followup' => $followupHtml,

                'action' => '
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button"
                        class="btn btn-icon btn-info-light rounded-pill viewContact"
                        data-id="' . $row->contact_id . '">
                        <i class="bx bx-show"></i>
                    </button>
                    <button type="button"
                        class="btn btn-icon btn-danger-light rounded-pill deleteContact"
                        data-id="' . $row->contact_id . '">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>',
            ];
        }

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $formattedData,
        ]);
    }

    public function contact_show($id)
    {
        $contact = ContactModel::selectRaw("*, DATE_FORMAT(date, '%d-%m-%Y') as date")
            ->where('contact_id', $id)
            ->first();

        if ($contact) {
            return response()->json(['status' => 200, 'data' => $contact]);
        }

        return response()->json(['status' => 404, 'message' => 'Contact not found']);
    }

    public function contact_delete(Request $request)
    {
        ContactModel::where('contact_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Contact removed successfully']);
    }

    public function followup_store(Request $request)
    {
        if (! $request->note || ! $request->curr_status) {
            return response()->json(['success' => false, 'message' => 'All fields are required']);
        }

        ContactFollowupModel::create([
            'contact_id' => $request->contact_id,
            'note' => $request->note,
            'curr_status' => $request->curr_status,
            'created_by' => current_user_id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Follow-up added successfully']);
    }

    public function followup_list($id)
    {
        $data = ContactFollowupModel::where('contact_id', $id)
            ->where('status', 0)
            ->orderBy('followup_id', 'desc')
            ->get();

        $formattedData = [];
        foreach ($data as $row) {
            $statusBadge = ($row->curr_status == 'completed')
                ? '<span class="badge bg-success">Completed</span>'
                : '<span class="badge bg-warning text-dark">Pending</span>';

            $formattedData[] = [
                'note' => e($row->note),
                'status' => $statusBadge,
                'datetime' => date('d-m-Y H:i', strtotime($row->created_at)),
                'action' => '<button type="button" class="btn btn-sm btn-danger-light deleteFollowup" data-id="' . $row->followup_id . '"><i class="bx bx-trash"></i></button>',
            ];
        }

        return response()->json(['data' => $formattedData]);
    }

    public function followup_delete(Request $request)
    {
        ContactFollowupModel::where('followup_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Follow-up deleted']);
    }

    public function product_enquiry_index()
    {
        $page_title = 'Product Enquiry List';

        $product_data = DB::table('mst_product')->get();
        $countries = MstCountryModel::orderBy('name')->get();

        return view('front_settings.product_enquiry_list', compact('page_title', 'product_data', 'countries'));
    }

    public function product_enquiry_data(Request $request)
    {
        $currentUserId = current_user_id();
        $query = ProductEnquiryModel::selectRaw("
        tbl_product_enquiries.*,
        DATE_FORMAT(tbl_product_enquiries.date, '%d-%m-%Y') as formatted_date,
        pf.note as followup_note,
        pf.curr_status as followup_status
    ")
            ->leftJoin(DB::raw('
            (
                SELECT f1.*
                FROM tbl_product_enquiry_followups f1
                INNER JOIN (
                    SELECT enquiry_id, MAX(created_at) as latest_date
                    FROM tbl_product_enquiry_followups
                    WHERE status = 0
                    GROUP BY enquiry_id
                ) f2
                ON f1.enquiry_id = f2.enquiry_id
                AND f1.created_at = f2.latest_date
            ) as pf
        '), 'pf.enquiry_id', '=', 'tbl_product_enquiries.enquiry_id')
            ->where('tbl_product_enquiries.status', 0);

        if (! all_admin()) {
            $query->where(function ($q) use ($currentUserId) {
                $q->where('tbl_product_enquiries.from_panel', 0)
                    ->orWhere(function ($q2) use ($currentUserId) {
                        $q2->where('tbl_product_enquiries.from_panel', 1)
                            ->where('tbl_product_enquiries.created_by', $currentUserId);
                    });
            });
        }

        $totalData = $query->count();

        $limit = (int) $request->input('length', 10);
        $start = (int) $request->input('start', 0);

        // ✅ Fix for "All" option (-1)
        if ($limit == -1) {
            $data = $query
                ->orderBy('tbl_product_enquiries.enquiry_id', 'desc')
                ->get();
        } else {
            $data = $query
                ->orderBy('tbl_product_enquiries.enquiry_id', 'desc')
                ->offset($start)
                ->limit($limit)
                ->get();
        }

        $formattedData = [];

        foreach ($data as $key => $row) {

            if ($row->followup_status == 'pending') {
                $badge = '<span class="badge bg-warning">Pending</span>';
            } elseif ($row->followup_status == 'completed') {
                $badge = '<span class="badge bg-success">Completed</span>';
            } else {
                $badge = '<span class="badge bg-secondary">No Follow-up</span>';
            }

            $followupHtml = $row->followup_note
                ? '<small>' . e(Str::limit($row->followup_note, 40)) . '</small><br>
               <div class="text-center mt-1">' . $badge . '</div>'
                : '<div class="text-center">' . $badge . '</div>';

            $deleteBtn = '';


            $pageRoute = session('current_page_route');

            if (routePermission($pageRoute, 'delete')) {

                $deleteBtn = '
        <button class="btn btn-icon btn-danger-light rounded-pill deleteEnquiry"
            data-id="' . $row->enquiry_id . '">
            <i class="bx bx-trash"></i>
        </button>
    ';
            }

            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                'date' => $row->formatted_date,
                'name' => e($row->name),
                'email' => e($row->email),
                'mobile' => e($row->mobile),
                'product' => '<b>' . e($row->product_name) . '</b><br><small>' . e($row->sku) . '</small>',
                'city' => e($row->city),
                'last_followup' => $followupHtml,

                'from_panel' => $row->from_panel == 1
                    ? '<span class="badge rounded-pill bg-primary px-3 py-1">
                    <i class="bi bi-shop me-1"></i> Store
                  </span>'
                    : '<span class="badge rounded-pill bg-info text-dark px-3 py-1">
                    <i class="bi bi-globe me-1"></i> Ecommerce
                  </span>',

                'action' => '
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-icon btn-info-light rounded-pill viewEnquiry"
                        data-id="' . $row->enquiry_id . '">
                        <i class="bx bx-show"></i>
                    </button>
                   ' . $deleteBtn . '
                </div>',
            ];
        }

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $formattedData,
        ]);
    }

    public function product_enquiry_show($id)
    {
        $data = ProductEnquiryModel::selectRaw("*, DATE_FORMAT(date, '%d-%m-%Y') as date")
            ->where('enquiry_id', $id)->first();

        return $data ? response()->json(['status' => 200, 'data' => $data]) : response()->json(['status' => 404]);
    }

    public function product_enquiry_delete(Request $request)
    {
        ProductEnquiryModel::where('enquiry_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Enquiry removed']);
    }

    // --- Followup Logic ---
    public function product_followup_store(Request $request)
    {
        ProductEnquiryFollowupModel::create([
            'enquiry_id' => $request->enquiry_id,
            'note' => $request->note,
            'curr_status' => $request->curr_status,
            'created_by' => current_user_id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Follow-up updated']);
    }

    public function product_followup_list($id)
    {
        $data = ProductEnquiryFollowupModel::where('enquiry_id', $id)->where('status', 0)->orderBy('followup_id', 'desc')->get();
        $list = [];
        foreach ($data as $row) {
            $badge = ($row->curr_status == 'completed') ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-warning text-dark">Pending</span>';
            $list[] = [
                'note' => e($row->note),
                'status' => $badge,
                'datetime' => $row->created_at->format('d-m-Y H:i'),
                'action' => '<button class="btn btn-sm btn-danger-light deleteProdFollowup" data-id="' . $row->followup_id . '"><i class="bx bx-trash"></i></button>',
            ];
        }

        return response()->json(['data' => $list]);
    }

    public function product_followup_delete(Request $request)
    {
        ProductEnquiryFollowupModel::where('followup_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true]);
    }

    public function product_selling_index()
    {
        $page_title = 'Selling Product';

        return view('front_settings.selling_product', compact('page_title'));
    }

    public function product_selling_list(Request $request)
    {
        $query = ProductSellModel::with('brandInfo')
            ->selectRaw("
            tbl_selling.*,
            DATE_FORMAT(tbl_selling.created_at, '%d-%m-%Y') as formatted_date,
            sf.remark as last_remark,
            DATE_FORMAT(sf.created_at, '%d-%m-%Y') as remark_date
        ")
            ->leftJoin(DB::raw('
            (
                SELECT f1.*
                FROM tbl_sell_followup f1
                INNER JOIN (
                    SELECT selling_id, MAX(created_at) as latest_date
                    FROM tbl_sell_followup
                    WHERE status = 0
                    GROUP BY selling_id
                ) f2
                ON f1.selling_id = f2.selling_id
                AND f1.created_at = f2.latest_date
            ) as sf
        '), 'sf.selling_id', '=', 'tbl_selling.selling_id');

        $totalData = $query->count();

        $limit = (int) $request->input('length', 10);
        $start = (int) $request->input('start', 0);

        $data = $query
            ->orderBy('tbl_selling.selling_id', 'desc')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        $actual_url = config('app.actual_url');
        $imgPath = $actual_url . '/front/uploads/selling/';
        foreach ($data as $key => $row) {

            $images = array_map('trim', explode(',', $row->image));

            // 🔹 Last remark + date
            $remarkHtml = $row->last_remark
                ? '<small>' . e(Str::limit($row->last_remark, 40)) . '</small><br>
               <div class="text-center text-muted" style="font-size:11px;">'
                . e($row->remark_date) .
                '</div>'
                : '<div class="text-center text-muted">No Remark</div>';

            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                'brand' => e($row->brandInfo->brand_name ?? '-'),
                'model' => e($row->model_no),
                'price' => e($row->price),

                'photos' => ! empty($images[0])
                    ? '<img src="' . $imgPath . e($images[0]) . '"
        width="50"
        height="50"
        class="rounded object-fit-cover">'
                    : '-',

                'name' => e($row->name),
                'email' => e($row->email_id),
                'phone' => e($row->contact_no),
                'city' => e($row->city),

                // ✅ NEW COLUMN
                'last_remark' => $remarkHtml,

                'action' => '
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-icon btn-info-light rounded-pill viewSelling"
                        data-id="' . $row->selling_id . '">
                        <i class="bx bx-show"></i>
                    </button>
                    <button class="btn btn-icon btn-danger-light rounded-pill deleteSelling"
                        data-id="' . $row->selling_id . '">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>',
            ];
        }

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $formattedData,
        ]);
    }

    public function product_selling_show($id)
    {
        $selling = ProductSellModel::leftJoin('mst_brand', 'mst_brand.brand_id', '=', 'tbl_selling.brand_id')
            ->selectRaw("
                    tbl_selling.*,
                    mst_brand.brand_name,
                    DATE_FORMAT(tbl_selling.created_at, '%d-%m-%Y') as formatted_date
                ")
            ->where('selling_id', $id)
            ->first();

        if ($selling) {
            return response()->json(['status' => 200, 'data' => $selling]);
        }

        return response()->json(['status' => 404, 'message' => 'Contact not found']);
    }

    public function product_selling_delete(Request $request)
    {
        ProductSellModel::where('selling_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Selling Product removed successfully']);
    }

    public function product_sell_followup_store(Request $request)
    {
        if (! $request->remark) {
            return response()->json(['success' => false, 'message' => 'remark fields are required']);
        }

        ProductSellFollowupModel::create([
            'selling_id' => $request->selling_id,
            'remark' => $request->remark,
            'created_by' => current_user_id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Follow-up added successfully']);
    }

    public function product_sell_followup_list($id)
    {
        $data = ProductSellFollowupModel::where('selling_id', $id)
            ->where('status', 0)
            ->orderBy('sell_r_id', 'desc')
            ->get();
        // dd($data);
        $formattedData = [];
        foreach ($data as $row) {
            // dd( $row->created_at);
            $formattedData[] = [
                'remark' => e($row->remark),
                'datetime' => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d-m-Y H:i')
                    : '-',
                'action' => '<button type="button" class="btn btn-sm btn-danger-light deleteFollowup" data-id="' . $row->sell_r_id . '"><i class="bx bx-trash"></i></button>',
            ];
        }

        return response()->json(['data' => $formattedData]);
    }

    public function product_sell_followup_delete(Request $request)
    {
        ProductSellFollowupModel::where('sell_r_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Follow-up deleted']);
    }

    public function product_trading_index()
    {
        $page_title = 'Trading Product';

        return view('front_settings.trading_product', compact('page_title'));
    }

    public function product_trading_list(Request $request)
    {
        $query = TradingModel::with('brandInfo', 'brand')
            ->selectRaw("
            tbl_trading.*,
            DATE_FORMAT(tbl_trading.created_at, '%d-%m-%Y') as formatted_date,
            tf.remark as last_remark,
            DATE_FORMAT(tf.created_at, '%d-%m-%Y') as remark_date
        ")
            ->leftJoin(DB::raw('
            (
                SELECT f1.*
                FROM tbl_trading_followup f1
                INNER JOIN (
                    SELECT trading_id, MAX(created_at) as latest_date
                    FROM tbl_trading_followup
                    WHERE status = 0
                    GROUP BY trading_id
                ) f2
                ON f1.trading_id = f2.trading_id
                AND f1.created_at = f2.latest_date
            ) as tf
        '), 'tf.trading_id', '=', 'tbl_trading.trading_id');

        $totalData = $query->count();

        $limit = (int) $request->input('length', 10);
        $start = (int) $request->input('start', 0);

        $data = $query
            ->orderBy('tbl_trading.trading_id', 'desc')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];

        $actual_url = config('app.actual_url');
        $imgPath = $actual_url . '/front/uploads/trading/';

        foreach ($data as $key => $row) {

            $images = array_map('trim', explode(',', $row->images));

            // 🔹 Last remark + date (inline, no helper)
            $remarkHtml = $row->last_remark
                ? '<small>' . e(Str::limit($row->last_remark, 40)) . '</small><br>
               <div class="text-center text-muted" style="font-size:11px;">'
                . e($row->remark_date) .
                '</div>'
                : '<div class="text-center text-muted">No Remark</div>';

            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                'brand' => e($row->brandInfo->brand_name ?? '-'),
                'model' => e($row->treading_model_no),
                'price' => e($row->price),

                'photos' => ! empty($images[0])
                    ? '<img src="' . $imgPath . e($images[0]) . '"
        width="50"
        height="50"
        class="rounded object-fit-cover">'
                    : '-',

                'model_number_2' => e($row->looking_model_no),
                'brand_looking' => e($row->brand->brand_name ?? '-'),
                'comments' => e($row->comments ?? '-'),
                'name' => e($row->name),
                'email' => e($row->email_id),
                'phone' => e($row->contact_no),
                'city' => e($row->city),

                // ✅ NEW COLUMN
                'last_remark' => $remarkHtml,

                'action' => '
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-icon btn-info-light rounded-pill viewTrading"
                        data-id="' . $row->trading_id . '">
                        <i class="bx bx-show"></i>
                    </button>
                    <button class="btn btn-icon btn-danger-light rounded-pill deleteTrading"
                        data-id="' . $row->trading_id . '">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>',
            ];
        }

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $formattedData,
        ]);
    }

    public function product_trading_show($id)
    {
        $trading = TradingModel::select(
            'tbl_trading.*',
            'tradingBrand.brand_name as trading_brand_name',
            'lookingBrand.brand_name as looking_brand_name'
        )
            ->where('trading_id', $id)
            ->leftJoin('mst_brand as tradingBrand', 'tradingBrand.brand_id', '=', 'tbl_trading.trading_brand_id')
            ->leftJoin('mst_brand as lookingBrand', 'lookingBrand.brand_id', '=', 'tbl_trading.looking_brand_id')
            ->first();

        // dd($trading);

        if ($trading) {
            return response()->json(['status' => 200, 'data' => $trading]);
        }

        return response()->json(['status' => 404, 'message' => 'Contact not found']);
    }

    public function product_trading_delete(Request $request)
    {
        TradingModel::where('trading_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Trading Product removed successfully']);
    }

    public function product_trade_followup_store(Request $request)
    {
        if (! $request->remark) {
            return response()->json([
                'success' => false,
                'message' => 'Remark field is required',
            ]);
        }

        TradingFollowupModel::create([
            'trading_id' => $request->trading_id,
            'remark' => $request->remark,
            'created_by' => current_user_id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Follow-up added successfully']);
    }

    public function product_trade_followup_list($id)
    {
        $data = TradingFollowupModel::where('trading_id', $id)
            ->where('status', 0)
            ->orderBy('trading_r_id', 'desc')
            ->get();
        // dd($data);
        $formattedData = [];
        foreach ($data as $row) {
            // dd( $row->created_at);
            $formattedData[] = [
                'remark' => e($row->remark),
                'datetime' => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d-m-Y H:i')
                    : '-',
                'action' => '<button type="button" class="btn btn-sm btn-danger-light deleteFollowup" data-id="' . $row->trading_r_id . '"><i class="bx bx-trash"></i></button>',
            ];
        }

        return response()->json(['data' => $formattedData]);
    }

    public function product_trade_followup_delete(Request $request)
    {
        TradingFollowupModel::where('trading_r_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Follow-up deleted']);
    }


    //About Page Content
    public function about_content_index()
    {
        $page_title = 'Edit About Page Content';
        $content = AboutContentModel::first();

        return view('front_settings.about_content', compact('page_title', 'content'));
    }

    public function about_content_update(Request $request)
    {
        try {

            $currentUserId = current_user_id();

            // Get existing or new record
            $content = AboutContentModel::first() ?: new AboutContentModel;

            $basePath = public_path('/assets/admin_assets/about_content');

            if (!file_exists($basePath)) {
                mkdir($basePath, 0777, true);
            }

            // =========================
            // TEXT DATA
            // =========================
            $data = $request->only([
                'about_heading',
                'about_content',

                'section1_heading',
                'section1_content',

                'section2_heading',
                'section2_content',

                'section3_heading',
                'section3_content',

                'meta_title',
                'meta_description',
            ]);

            // =========================
            // IMAGE FIELDS
            // =========================
            $imageFields = ['section1_image', 'section2_image', 'section3_image'];

            foreach ($imageFields as $field) {

                if ($request->hasFile($field)) {


                    if (!empty($content->$field) && file_exists($basePath . '/' . $content->$field)) {
                        unlink($basePath . '/' . $content->$field);
                    }

                    $file = $request->file($field);
                    $filename = time() . '_' . $file->getClientOriginalName();

                    $file->move($basePath, $filename);

                    $data[$field] = $filename;
                } else {
                    // keep old image
                    $data[$field] = $content->$field;
                }
            }


            $data['status'] = 0;
            $data['updated_by'] = $currentUserId;

            if (!$content->exists) {
                $data['created_by'] = $currentUserId;
            }

            AboutContentModel::updateOrCreate(
                ['ac_id' => $content->ac_id ?? null],
                $data
            );

            return response()->json([
                'status' => true,
                'message' => 'About Content Updated Successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Product Enquiry Store
    public function store(Request $request)
    {

        $countryName = DB::table('mst_country')
            ->where('id', $request->country)
            ->value('name');

        $stateName = DB::table('mst_state')
            ->where('id', $request->state)
            ->value('name');

        $cityName = DB::table('mst_city')
            ->where('id', $request->city)
            ->value('name');

        // $productName = DB::table('mst_product')
        //     ->where('pro_id', $request->pro_id)
        //     ->value('pro_name');

        $productSku = DB::table('mst_product')
            ->where('pro_id', $request->pro_id)
            ->value('pro_sku');

        ProductEnquiryModel::create([
            'date' => now(),
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'mobile' => $request->mobile ?? '',
            // 'pro_id' => $request->pro_id ?? null,
            'product_name' =>  $request->pro_name ?? null,
            'model_number' => $request->model_number ?? '',
            'price_range' => $request->price_from . ' - ' . $request->price_to,
            'year_range' => $request->year_from . ' - ' . $request->year_to,
            'sku' => $productSku ?? '',
            'country' => $countryName ?? '',
            'state' => $stateName ?? '',
            'city' => $cityName ?? '',
            'message' => $request->message ?? '',
            'from_panel' => 1,
            'created_by' => current_user_id(),
            'status' => 0
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Enquiry saved successfully'
        ]);
    }

    //Export Product Enquiry
    public function export()
    {
        $currentUserId = current_user_id();
        $query = ProductEnquiryModel::selectRaw("
            tbl_product_enquiries.*,
            DATE_FORMAT(tbl_product_enquiries.date, '%d-%m-%Y') as formatted_date
        ")
            ->where('tbl_product_enquiries.status', 0);

        // Admin / Co-Admin / Super Admin see all
        if (! all_admin()) {
            $query->where(function ($q) use ($currentUserId) {
                $q->where('tbl_product_enquiries.from_panel', 0)
                    ->orWhere(function ($q2) use ($currentUserId) {
                        $q2->where('tbl_product_enquiries.from_panel', 1)
                            ->where('tbl_product_enquiries.created_by', $currentUserId);
                    });
            });
        }

        $data = $query->orderBy('tbl_product_enquiries.enquiry_id', 'desc')->get();

        $rows = [];
        $headers = [];

        foreach ($data as $key => $row) {

            $map = [

                'Date' => $row->formatted_date,
                'Name' => $row->name,
                'Email' => $row->email,
                'Mobile' => $row->mobile,
                'Product' => $row->product_name,
                'Model Number' => $row->model_number,
                'SKU' => $row->sku,
                'City' => $row->city,
                'State' => $row->state,
                'Country' => $row->country,
                'Message' => $row->message,
                'Submitted From' => $row->from_panel == 1 ? 'Store' : 'Ecommerce',
            ];

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



        $writer = new Xlsx($spreadsheet);
        $fileName = 'Product_Enquiry_' . date('d_m_Y_h_i_A') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }


    //Export Contact Us list
    public function contact_export()
    {

        $data = ContactModel::selectRaw("
        tbl_contacts.*,
        DATE_FORMAT(tbl_contacts.date, '%d-%m-%Y') as formatted_date,
        cf.note as followup_note,
        cf.curr_status as followup_status
    ")
            ->leftJoin(DB::raw('
        (
            SELECT f1.*
            FROM tbl_contact_followups f1
            INNER JOIN (
                SELECT contact_id, MAX(created_at) as latest_date
                FROM tbl_contact_followups
                GROUP BY contact_id
            ) f2
            ON f1.contact_id = f2.contact_id
            AND f1.created_at = f2.latest_date
        ) as cf
    '), 'cf.contact_id', '=', 'tbl_contacts.contact_id')
            ->where('tbl_contacts.status', 0)
            ->orderBy('tbl_contacts.contact_id', 'desc')
            ->get();

        $rows = [];
        $headers = [];

        foreach ($data as $key => $row) {

            $followup = $row->followup_note
                ? $row->followup_note . ' (' . ucfirst($row->followup_status ?? 'No Follow-up') . ')'
                : ($row->followup_status ? ucfirst($row->followup_status) : 'No Follow-up');

            $map = [

                'Date' => $row->formatted_date,
                'Name' => $row->name,
                'Email' => $row->email,
                'Mobile' => $row->mobile,
                // 'Last Follow Up' => $followup,
                'Country' => $row->country,
                'City' => $row->city,
                'Store' => $row->store,
                'Message' => $row->message,
            ];

            if (empty($headers)) {
                $headers = array_keys($map);
            }

            $rows[] = array_values($map);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $sheet->fromArray($headers, null, 'A1');

        // Data rows
        $sheet->fromArray($rows, null, 'A2');

        // Bold header
        $lastColumn = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$lastColumn}1")
            ->getFont()
            ->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Contact_List_' . date('d_m_Y_h_i_A') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    //Catalogue
    public function catalogue_index()
    {
        $page_title = 'Catalogue';

        $catalogue = CatalogueModel::first();

        if (!$catalogue) {
            $catalogue = new CatalogueModel();
        }

        return view('front_settings.catalogue', compact('page_title', 'catalogue'));
    }

    public function updatecatalogue(Request $request)
    {
        // 🔍 FIND OR CREATE
        $catalogue = CatalogueModel::find($request->cg_id);

        if (!$catalogue) {
            $catalogue = new CatalogueModel();
            $catalogue->created_by = current_user_id();
            $catalogue->created_at = now();
        }

        // 📁 FILE UPLOAD
        if ($request->hasFile('file')) {

            $uploadPath = public_path('assets/admin_assets/catalogue/');

            // 🔴 DELETE OLD FILE (ONLY IF UPDATE)
            if (!empty($catalogue->file)) {
                $oldFilePath = $uploadPath . $catalogue->file;

                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // 🟢 NEW FILE NAME (MD5)
            $file = $request->file('file');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();

            $file->move($uploadPath, $filename);

            $catalogue->file = $filename;
        }

        // 📅 DATE
        $catalogue->date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        // 🔘 STATUS
        $catalogue->status = $request->has('status') ? 0 : 1;

        // 👤 UPDATED INFO
        $catalogue->updated_by = current_user_id();
        $catalogue->updated_at = now();

        $catalogue->save();

        return response()->json([
            'status' => true,
            'message' => $request->cg_id ? 'Catalogue updated successfully!' : 'Catalogue created successfully!'
        ]);
    }
}
