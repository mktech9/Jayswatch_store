<?php

namespace App\Http\Controllers;

use App\Models\TCSModel;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;

class TCSController extends Controller
{
    public function index()
    {
        $page_title = "TCS";
        return view('settings.tcs', compact('page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'percentage.*' => 'required|numeric',
        ], [
            'percentage.*.required' => 'Percentage is required',
            'percentage.*.numeric' => 'Percentage must be a number',
        ]);

        // 1. Check for duplicates in the input array (Server-side backup)
        $percentages = $request->percentage;
        if (count($percentages) !== count(array_unique($percentages))) {
            return response()->json([
                'status' => 400,
                'message' => 'Duplicate values entered in the list. Please remove duplicates.'
            ]);
        }

        // 2. Check if any value already exists in Database (Active records)
        $existing = TCSModel::whereIn('percentage', $percentages)
            ->where('status', '!=', 1)
            ->exists();

        if ($existing) {
            return response()->json([
                'status' => 400,
                'message' => 'One or more TCS percentages already exist in the system.'
            ]);
        }

        try {
            DB::beginTransaction();

            $count = count($request->percentage);

            for ($i = 0; $i < $count; $i++) {
                if (isset($request->percentage[$i])) {
                    TCSModel::create([
                        'percentage' => $request->percentage[$i],
                        'created_by' => current_user_id(),
                        'created_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'TCS Added Successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function list(Request $request)
    {
        $totalData = TCSModel::where('status', '!=', 1)->count();
        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $tcs_data = TCSModel::where('status', '!=', 1)
                ->offset($start)
                ->limit($limit)
                ->orderBy('tcs_id', 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $tcs_data = TCSModel::where('status', '!=', 1)
                ->where('percentage', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('tcs_id', 'desc')
                ->get();

            $totalData = TCSModel::where('status', '!=', 1)
                ->where('percentage', 'LIKE', "%{$search}%")
                ->count();
        }

        $formattedData = [];
        $i = $start + 1;

        foreach ($tcs_data as $row) {
            $actionButtons = '<div class="d-flex gap-2">
                <button type="button" class="btn btn-icon btn-primary-light rounded-pill btn-wave edit-tcs" data-id="' . $row->tcs_id . '" title="Edit"><i class="bx bx-edit"></i></button>
                <button type="button" class="btn btn-icon btn-danger-light rounded-pill btn-wave delete-tcs" data-id="' . $row->tcs_id . '" title="Delete"><i class="bx bx-trash"></i></button>
            </div>';

            $formattedData[] = [
                'sr_no' => $i++,
                'percentage' => $row->percentage . '%',
                'action' => $actionButtons,
            ];
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $formattedData
        ]);
    }

    public function edit(Request $request)
    {
        $tcs = TCSModel::find($request->id);
        if ($tcs) {
            return response()->json(['status' => 200, 'data' => $tcs]);
        }
        return response()->json(['status' => 404, 'message' => 'TCS not found']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'percentage.*' => 'required|numeric',
        ]);

        try {
            $tcs = TCSModel::find($request->id);

            if (!$tcs) {
                return response()->json(['status' => 404, 'message' => 'TCS not found']);
            }

            // Handle array input from form
            $percentageVal = is_array($request->percentage) ? $request->percentage[0] : $request->percentage;

            // 3. Check for duplicates in Database (excluding current ID)
            $exists = TCSModel::where('percentage', $percentageVal)
                ->where('tcs_id', '!=', $request->id)
                ->where('status', '!=', 1)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => 400,
                    'message' => 'This TCS percentage already exists.'
                ]);
            }

            $tcs->update([
                'percentage' => $percentageVal,
                'updated_by' => current_user_id(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'TCS Updated Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $tcs = TCSModel::find($request->tcs_id);
        if ($tcs) {
            $tcs->status = 1;
            $tcs->save();
            return response()->json([
                'status' => true,
                'message' => 'TCS deleted successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'TCS not found'
        ]);
    }
}
