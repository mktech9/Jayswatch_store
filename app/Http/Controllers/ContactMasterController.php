<?php

namespace App\Http\Controllers;

use App\Models\ContactMaster;
use App\Models\MstCountryModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ContactMasterController extends Controller
{
    public function index()
    {
        $page_title = 'Store Customer';
        $countries = MstCountryModel::orderBy('name')->get();

        return view('contact.index', compact('page_title', 'countries'));
    }

    public function store(Request $request)
    {
        $currentUserId = current_user_id();
        $contactId = $request->contact_master_id;
        $contact = $contactId ? ContactMaster::findOrFail($contactId) : null;

        $basePath = public_path('/assets/admin_assets/contact_documents');
        File::makeDirectory($basePath, 0777, true, true);

        // Standard inputs
        $data = $request->except(['id_file_path', '_token']);

        if ($request->date_of_birth) {
            $data['date_of_birth'] = date('Y-m-d', strtotime($request->date_of_birth));
        }

        // Handle FilePond Upload
        if ($request->hasFile('id_file_path')) {
            $file = $request->file('id_file_path');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move($basePath, $filename);
            $data['id_file_path'] = $filename;
        }

        $data['updated_by'] = $currentUserId;
        if (! $contact) {
            $data['created_by'] = $currentUserId;
            ContactMaster::create($data);
            $msg = 'Contact created successfully';
        } else {
            $contact->update($data);
            $msg = 'Contact updated successfully';
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function list(Request $request)
    {
        $query = ContactMaster::where('status', '!=', 1);

        // ✅ Show all data for Super Admin / Admin / Co-Admin
        // otherwise show only created_by own records
        if (!all_admin()) {
            $staffId = session('staff_id');

            $query->where('created_by', $staffId);
        }

        $totalData = $query->count();

        $start = (int) $request->input('start', 0);
        $limit = (int) $request->input('length', 10);

        $queryData = $query->orderBy('contact_master_id', 'desc');

        // Handle "All" option safely
        if ($limit != -1) {
            $queryData->offset($start)->limit($limit);
        }

        $data = $queryData->get();

        $formattedData = [];

        foreach ($data as $key => $row) {

            $displayName = $row->is_business
                ? $row->business_name
                : $row->prefix . ' ' . $row->first_name . ' ' . $row->last_name;

            $statusBtn = $row->status == 0
                ? '<button class="btn btn-sm btn-warning-light statusToggle"
                    data-id="' . $row->contact_master_id . '"
                    data-status="2">
                    Deactivate
               </button>'
                : '<button class="btn btn-sm btn-success-light statusToggle"
                    data-id="' . $row->contact_master_id . '"
                    data-status="0">
                    Activate
               </button>';

            $viewUrl = route('contact.master.view', encrypt($row->contact_master_id));

            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                'contact_id' => $row->contact_id ?? 'N/A',
                'name' => $displayName,
                'mobile' => $row->mobile,
                'email' => $row->email,

                'action' => '
                <div class="d-flex gap-2">
                    <a href="' . $viewUrl . '"
                       class="btn btn-icon btn-info-light">
                       <i class="bx bx-show"></i>
                    </a>

                    <button class="btn btn-icon btn-primary-light editContact"
                        data-id="' . $row->contact_master_id . '">
                        <i class="bx bx-edit"></i>
                    </button>

                    ' . $statusBtn . '

                    <button class="btn btn-icon btn-danger-light deleteContact"
                        data-id="' . $row->contact_master_id . '">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>',
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $formattedData
        ]);
    }

    public function show($id)
    {
        $contact = ContactMaster::select(
            'mst_contact_master.*',
            'mst_country.name as country_name',
            'mst_state.name as state_name',
            'mst_city.name as city_name'
        )
            ->leftJoin('mst_country', 'mst_country.id', '=', 'mst_contact_master.country')
            ->leftJoin('mst_state', 'mst_state.id', '=', 'mst_contact_master.state')
            ->leftJoin('mst_city', 'mst_city.id', '=', 'mst_contact_master.city')
            ->selectRaw("DATE_FORMAT(date_of_birth, '%d-%m-%Y') as formatted_dob")
            ->where('contact_master_id', $id)
            ->first();

        if ($contact && $contact->id_file_path) {

            $path = public_path('assets/admin_assets/contact_documents/' . $contact->id_file_path);

            $contact->file_url = asset(
                'assets/admin_assets/contact_documents/' . $contact->id_file_path
            );

            $contact->file_size = file_exists($path) ? filesize($path) : 0;
        }

        return response()->json(['status' => 200, 'data' => $contact]);
    }

    public function toggle_status(Request $request)
    {
        ContactMaster::where('contact_master_id', $request->id)->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status updated']);
    }

    public function delete(Request $request)
    {
        ContactMaster::where('contact_master_id', $request->id)->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Contact removed']);
    }

    public function view_contact($id)
    {
        $page_title = 'Contact Information';

        try {
            $contactId = decrypt($id); // Decrypt the ID from the URL
        } catch (\Exception $e) {
            abort(404);
        }

        // Fetch contact with joined location names (Country, State, City)
        $contact = ContactMaster::select(
            'mst_contact_master.*',
            'mst_country.name as country_name',
            'mst_state.name as state_name',
            'mst_city.name as city_name'
        )
            ->leftJoin('mst_country', 'mst_country.id', '=', 'mst_contact_master.country')
            ->leftJoin('mst_state', 'mst_state.id', '=', 'mst_contact_master.state')
            ->leftJoin('mst_city', 'mst_city.id', '=', 'mst_contact_master.city')
            ->where('contact_master_id', $contactId)
            ->firstOrFail();

        $sales = DB::table('mst_sales')
            ->where('customer_id', $contactId)
            ->where('status', 0)
            ->orderBy('sale_date', 'desc')
            ->get();

        $countries = MstCountryModel::orderBy('name')->get();

        return view('contact.view', compact('page_title', 'contact', 'sales', 'countries'));
    }

    public function getNextContactId()
    {
        $last = DB::table('mst_contact_master')
            ->where('contact_id', 'LIKE', 'CO-%')
            ->orderByDesc('contact_master_id')
            ->value('contact_id');

        if ($last) {
            $number = (int) str_replace('CO-', '', $last);
            $next = $number + 1;
        } else {
            $next = 1;
        }

        $contactId = 'CO-' . str_pad($next, 4, '0', STR_PAD_LEFT);

        return response()->json([
            'contact_id' => $contactId,
        ]);
    }

    // Ecommerce Customer
    public function ecom_cust()
    {
        $page_title = 'Ecommerce Customer';
        $countries = MstCountryModel::orderBy('name')->get();

        return view('contact.ecom_cust_index', compact('page_title', 'countries'));
    }

    public function ecomlist(Request $request)
    {
        $query = UserModel::where('status', 1);
        $totalData = $query->count();
        $start = $request->input('start');
        $limit = $request->input('length');

        $data = $query->offset($start)->limit($limit)->orderBy('user_id', 'desc')->get();

        $formattedData = [];
        foreach ($data as $key => $row) {
            $displayName = $row->full_name ?? $row->first_name . ' ' . $row->last_name;
            $statusBtn = $row->status == 1
                ? '<button class="btn btn-sm btn-warning-light statusToggle" data-id="' . $row->contact_master_id . '" data-status="2">Deactivate</button>'
                : '<button class="btn btn-sm btn-success-light statusToggle" data-id="' . $row->contact_master_id . '" data-status="0">Activate</button>';

            $viewUrl = route('contact.ecom_cust.view', encrypt($row->user_id));

            $formattedData[] = [
                'sr_no' => $start + $key + 1,
                'name' => $displayName ?? '-',
                'mobile' => $row->phone ?? '-',
                'email' => $row->email ?? '-',
                'citizen' => $row->citizen_type ?? '-',
                'pan_no' => $row->pan_no ?? '-',
                'action' => '
                    <div class="d-flex gap-2">
                        <a href="' . $viewUrl . '" class="btn btn-icon btn-info-light"><i class="bx bx-show"></i></a>

                    </div>',
            ];
        }

        return response()->json(['draw' => intval($request->input('draw')), 'recordsTotal' => $totalData, 'recordsFiltered' => $totalData, 'data' => $formattedData]);
    }

    public function view_ecomcust($id)
    {
        $page_title = 'Ecommerce Customer Information';

        try {
            $contactId = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $contact = UserModel::where('user_id', $contactId)->firstOrFail();

        $sales = DB::table('order')
            ->where('user_id', $contactId)
            ->orderBy('order_date', 'desc')
            ->get();


        $user_address = DB::table('user_address')
            ->where('user_id', $contactId)
            ->orderByDesc('is_primary')
            ->get();


        $primary_address = $user_address->first();

        return view('contact.ecom_view', compact(
            'page_title',
            'contact',
            'sales',
            'user_address',
            'primary_address'
        ));
    }
}
