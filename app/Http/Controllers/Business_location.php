<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use App\Models\PaymentoptionModel;
use App\Models\BusinesslocationModel;
use App\Models\MstCountryModel;
use App\Models\MstStateModel;
use App\Models\ProductModel;
use App\Models\MstCityModel;


class Business_location extends Controller
{
public function index()
{
    $page_title = "Business Location";

    $payment_options = PaymentoptionModel::where('status', 0)->get();

    $countries = MstCountryModel::orderBy('name')->get();
$pos_screen_data = ProductModel::where('out_stock', 0)
    ->where('not_for_selling', 0)
    ->where('status', 0)
    ->orderBy('pro_name')
    ->get();

    return view('settings.business_location', compact('page_title', 'payment_options', 'countries','pos_screen_data'));
}
   public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'location_id' => 'required|string|max:255',
        'zip_code'    => 'required',
        'mobile'      => 'required',
    ]);

    // Map dropdown IDs
    $request->merge([
        'country' => $request->country_id,
        'state'   => $request->state_id,
        'city'    => $request->city_id,
    ]);

    try {

        // ✅ FIRST get all input
        $input = $request->all();

        // ✅ FIX product array
        if (!empty($request->product) && is_array($request->product)) {
            $input['product'] = implode(',', $request->product);
        } else {
            $input['product'] = null;
        }

        // ✅ FIX payment options array
        if (!empty($request->payment_options) && is_array($request->payment_options)) {
            $input['payment_options'] = implode(',', $request->payment_options);
        } else {
            $input['payment_options'] = null;
        }

        $input['created_by'] = current_user_id();
        $input['created_at'] = now();

        BusinesslocationModel::create($input);

        return response()->json([
            'status'  => 200,
            'message' => 'Business Location Added Successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => 500,
            'message' => 'Something went wrong: ' . $e->getMessage()
        ]);
    }
}



    public function list(Request $request)
    {
        $columns = [
            0 => 'bl_id',
            1 => 'name',
            2 => 'location_id',
            3 => 'city',
            4 => 'zip_code',
            5 => 'state',
            6 => 'country',
            7 => 'product',
            8 => 'action',
        ];

     $query = BusinesslocationModel::select(
            'tbl_bussiness_location.*',
            'mst_city.name as city_name',
            'mst_state.name as state_name',
            'mst_country.name as country_name'
        )
        ->leftJoin('mst_city', 'mst_city.id', '=', 'tbl_bussiness_location.city')
        ->leftJoin('mst_state', 'mst_state.id', '=', 'tbl_bussiness_location.state')
        ->leftJoin('mst_country', 'mst_country.id', '=', 'tbl_bussiness_location.country')
        ->where('tbl_bussiness_location.status', 0);


        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('location_id', 'LIKE', "%{$searchValue}%")
                    ->orWhere('city', 'LIKE', "%{$searchValue}%")
                    ->orWhere('state', 'LIKE', "%{$searchValue}%");
            });
            $query->where('status', 0);
            $totalFiltered = $query->count();
        }

        $orderColumn = $columns[$orderColumnIndex] ?? 'bl_id';
        $query->orderBy($orderColumn, $orderDirection)->offset($start)->limit($limit);

        $data = $query->get();
        $formattedData = [];
        $sr_no = $start + 1;
        foreach ($data as $row) {
            $actionButtons = '
            <div class="d-flex gap-2 justify-content-center">
                <a href="javascript:void(0)" class="btn btn-icon btn-primary-light rounded-pill btn-wave editLocation" data-id="' . $row->bl_id . '" title="Edit">
                    <i class="bx bx-edit"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-icon btn-danger-light rounded-pill btn-wave deleteLocation" data-id="' . $row->bl_id . '" data-name="' . e($row->name) . '" title="Delete">
                    <i class="bx bx-trash"></i>
                </a>
            </div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'name' => e($row->name),
                'location_id' => e($row->location_id),
              'city'    => e($row->city_name),
'state'   => e($row->state_name),
'country' => e($row->country_name),


                'zip_code' => e($row->zip_code),


                'price_group' => e($row->product ?? '-'),
                'action' => $actionButtons,
            ];
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $formattedData,
        ]);
    }

    //edit
    public function edit($id)
    {
        $data = BusinesslocationModel::find($id);
        if ($data) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 404, 'message' => 'Location not found']);
        }
    }
public function update(Request $request)
{
    // ---------- VALIDATION ----------
    $request->validate([
        'bl_id'       => 'required|integer',
        'name'        => 'required|string|max:255',
        'location_id' => 'required|string|max:255',
        'zip_code'    => 'required',
        'mobile'      => 'required',
    ]);

    // ---------- MAP select2 IDs to DB columns ----------
    $request->merge([
        'country' => $request->country_id,
        'state'   => $request->state_id,
        'city'    => $request->city_id,
    ]);

    try {

        $location = BusinesslocationModel::find($request->bl_id);

        if (!$location) {
            return response()->json([
                'status'  => 404,
                'message' => 'Business Location not found'
            ]);
        }

        // Get all fields except token and id
        $input = $request->except(['_token', 'bl_id', 'country_id', 'state_id', 'city_id']);

        // ---------- PAYMENT OPTIONS ----------
        if ($request->has('payment_options') && is_array($request->payment_options)) {
            $input['payment_options'] = implode(',', $request->payment_options);
        } else {
            $input['payment_options'] = null;
        }

        // ---------- UPDATE META ----------
        $input['updated_by'] = current_user_id();
        $input['updated_at'] = now();

        // ---------- PERFORM UPDATE ----------
        $location->update($input);

        return response()->json([
            'status'  => 200,
            'message' => 'Business Location Updated Successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => 500,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ]);
    }
}



    public function destroy(Request $request)
    {
        $location = BusinesslocationModel::find($request->bl_id);
        if ($location) {
            $location->status = 1; // 1 = Deleted
            $location->save();
            return response()->json(['status' => true, 'message' => 'Location deleted successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Location not found']);
    }

    public function getStates($country_id)
{
    return MstStateModel::where('country_id', $country_id)
                    ->orderBy('name')
                    ->get();
}

public function getCities($state_id)
{
    return MstCityModel::where('state_id', $state_id)
                    ->orderBy('name')
                    ->get();
}




}
