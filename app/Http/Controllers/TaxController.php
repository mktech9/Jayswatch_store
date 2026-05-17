<?php

namespace App\Http\Controllers;

use App\Models\TaxModel;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;


class TaxController extends Controller
{
    public function index()
    {
        $page_title = "Tax";


        return view('settings.tax', compact('page_title'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'tax.*' => 'required|string|max:255',
            'tax_rate.*' => 'required|numeric',
        ], [
            'tax.*.required' => 'Tax Name is required',
            'tax_rate.*.required' => 'Tax Rate is required',
            'tax_rate.*.numeric' => 'Rate must be a number',
        ]);

        try {
            DB::beginTransaction();

            $count = count($request->tax);

            for ($i = 0; $i < $count; $i++) {

                if (isset($request->tax[$i]) && isset($request->tax_rate[$i])) {

                    TaxModel::create([
                        'tax' => $request->tax[$i],
                        'tax_rate' => $request->tax_rate[$i],
                        'created_by' => current_user_id(),
                        'created_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Taxes Added Successfully'
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
        $columns = [
            0 => 't_id',
            1 => 'tax',
            2 => 'tax_rate',
        ];

        $query = TaxModel::where('status', 0);

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('tax', 'LIKE', "%{$searchValue}%")
                    ->orWhere('tax_rate', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        $orderColumn = $columns[$orderColumnIndex] ?? 't_id';
        $data = $query
            ->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $actionButtons = '
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="javascript:void(0)" 
                        class="btn btn-icon btn-primary-light rounded-pill editTax" 
                        data-id="' . $row->t_id . '" title="Edit">
                            <i class="bx bx-edit"></i>
                        </a>

                        <a href="javascript:void(0)" 
                        class="btn btn-icon btn-danger-light rounded-pill deleteTax" 
                        data-id="' . $row->t_id . '" 
                        data-name="' . e($row->tax) . '" title="Delete">
                            <i class="bx bx-trash"></i>
                        </a>
                    </div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'tax' => e($row->tax),
                'tax_rate' => e($row->tax_rate),
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
        $tax = TaxModel::find($id);

        if ($tax) {
            return response()->json([
                'status' => 200,
                'data' => $tax
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Tax not found'
        ]);
    }
    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'tax' => 'required|string|max:255',
            'tax_rate' => 'required|numeric',
        ], [
            'tax.required' => 'Tax Name is required',
            'tax_rate.required' => 'Tax Rate is required',
            'tax_rate.numeric' => 'Rate must be a number',
        ]);

        try {
            $tax = TaxModel::find($request->id);

            if (!$tax) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Tax not found'
                ]);
            }

            $tax->update([
                'tax' => $request->tax,
                'tax_rate' => $request->tax_rate,
                'updated_by' => current_user_id(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Tax Updated Successfully'
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
        $tax = TaxModel::find($request->t_id);
        if ($tax) {
            $tax->status = 1;
            $tax->save();
            return response()->json([
                'status' => true,
                'message' => 'Tax deleted successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Tax not found'
        ]);
    }
}
