<?php

namespace App\Http\Controllers;

use App\Models\QuickSale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuickSaleData extends Controller
{
    public function index()
    {
        $page_title = 'Quick Sale List';

        return view('quicksale.index', compact('page_title'));
    }

    public function list(Request $request)
    {
        // Base Query using DB Facade
        $query = DB::table('quicksale');

        // Search Logic
        if (! empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_num', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('invoice_num', 'LIKE', "%{$search}%");
            });
        }

        // Pagination & Sorting
        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        $data = $query->orderBy('id', 'desc')
            ->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        $i = $start + 1;

        foreach ($data as $row) {
            $action = '
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-icon btn-sm btn-info-light rounded-pill viewQuickSale" data-id="'.$row->id.'" title="View"><i class="bx bx-show"></i></button>
               <a href="'.route('quicksale.print', $row->id).'"
   class="btn btn-icon btn-sm btn-success rounded-pill"
   target="_blank" title="Print">
   <i class="bx bx-printer"></i>
</a>

                </div>';

            $formattedData[] = [
                'sr_no' => $i++,
                'invoice_num' => $row->invoice_num,
                'fullname' => $row->fullname,
                'mobile_num' => $row->mobile_num ?? 'N/A',
                'email' => $row->email ?? 'N/A',
                'final_total' => number_format((float) $row->finaltotal, 2),
                'bill_date' => $row->bill_date,
                'action' => $action,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData,
        ]);
    }

    public function show($id)
    {
        // 1. Fetch Main Sale Data
        $sale = DB::table('quicksale')->where('id', $id)->first();

        if ($sale) {
            // 2. Fetch Products
            $products = DB::table('quicksaleproduct')->where('quicksale_id', $id)->get();

            // 3. Fetch Payments
            $payments = DB::table('quicksale_payment')->where('quicksale_id', $id)->get();

            return response()->json([
                'status' => 200,
                'sale' => $sale,
                'products' => $products,
                'payments' => $payments,
            ]);
        }

        return response()->json(['status' => 404, 'message' => 'Record not found']);
    }

    public function quicksaleprint($id)
    {

        $QuicksaleData = QuickSale::with('quicksaleproduct')->findOrFail($id);

        $data['quicksale'] = $QuicksaleData;

        $pdf = PDF::loadView('quicksale.quicksaleprint', $data);

        $pdfname = mt_rand(1000000000, 9999999999).'.pdf';

        return $pdf->stream($pdfname);

    }
}
