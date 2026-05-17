<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use App\Models\MovementModel;
use App\Models\WatchTypeModel;
use App\Models\GlassMaterialModel;
use App\Models\ColorModel;
use App\Models\SmtpModel;
use App\Models\EmailModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class ProSettingController extends Controller
{
    public function index()
    {

        $brand_count = BrandModel::where('status', 0)->count();
        $movement_count = MovementModel::where('status', 0)->count();
        $watchtype_count = WatchTypeModel::where('status', 0)->count();
        $glassmaterial_count = GlassMaterialModel::where('status', 0)->count();
        $color_count = ColorModel::where('status', 0)->count();
        $email_count = EmailModel::where('status', 0)->count();

        $page_title = "Product Settings";
        return view('product_setting.index', compact('page_title', 'color_count', 'watchtype_count', 'glassmaterial_count', 'movement_count', 'brand_count', 'email_count'));
    }



    public function brandstore(Request $request)
    {
        $request->validate([
            'brand_name' => [
                'required',
                Rule::unique('mst_brand', 'brand_name')
                    ->where(function ($query) {
                        return $query->where('status', 0);
                    })
                    ->ignore($request->brand_id, 'brand_id'),
            ],
        ]);

        // ---------- CREATE OR UPDATE ----------
        if ($request->filled('brand_id')) {

            $brand = BrandModel::find($request->brand_id);

            if (!$brand) {
                return response()->json([
                    'status' => false,
                    'message' => 'Brand not found'
                ], 404);
            }

            $message = "Brand updated successfully";
        } else {
            $brand = new BrandModel();
            $message = "Brand created successfully";
        }

        $brand->brand_name = $request->brand_name;
        $brand->brand_desc = $request->brand_desc;
        $brand->meta_title = $request->meta_title;

        // image remove
        if ($request->remove_image == 1 && $brand->brand_img) {
            $old = public_path('assets/brand_images/' . $brand->brand_img);
            if (file_exists($old)) unlink($old);
            $brand->brand_img = null;
        }

        // image upload
        if ($request->hasFile('brand_img')) {

            if ($brand->brand_img) {
                $old = public_path('assets/brand_images/' . $brand->brand_img);
                if (file_exists($old)) unlink($old);
            }

            $file = $request->file('brand_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/brand_images'), $filename);
            $brand->brand_img = $filename;
        }

        $brand->save();

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }



    public function brandlist(Request $request)
    {
        $columns = [
            0 => 'brand_id',
            1 => 'brand_name',
            2 => 'brand_desc',
            3 => 'status',
            4 => 'created_at',
            5 => 'action'
        ];

        $query = BrandModel::query()->where('status', '0')->orderBy('brand_id', 'DESC');

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));

        $searchValue = $request->input('search.value');


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('brand_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('brand_desc', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }


        $orderColumn = $columns[$orderColumnIndex] ?? 'brand_id';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();


        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $statusBadge = $row->status == 0
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            $actionButtons = '
        <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-icon btn-primary-light rounded-pill editBrand" data-id="' . $row->brand_id . '">
                <i class="bx bx-edit"></i>
            </button>

            <button type="button" class="btn btn-icon btn-danger-light rounded-pill deleteBrand" data-id="' . $row->brand_id . '" data-name="' . e($row->brand_name) . '">
                <i class="bx bx-trash"></i>
            </button>
        </div>';

            $formattedData[] = [
                'sr_no'        => $sr_no++,
                'brand_name'   => e($row->brand_name),
                'brand_desc'   => e(value: $row->brand_desc ?? '-'),
                'status'       => $statusBadge,
                'created_at'   => $row->created_at ? $row->created_at->format('d-m-Y') : '-',
                'action'       => $actionButtons
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData,
        ]);
    }



    public function brandedit($id)
    {
        $brand = BrandModel::findOrFail($id);

        return response()->json($brand);
    }


    public function brandSoftDelete($id)
    {
        $brand = BrandModel::find($id);

        if (!$brand) {
            return response()->json([
                'status' => false,
                'message' => 'Brand not found'
            ], 404);
        }

        // mark as soft deleted
        $brand->status = 1;
        $brand->save();

        return response()->json([
            'status' => true,
            'message' => 'Brand removed successfully'
        ]);
    }


    public function watchstore(Request $request)
    {
        $request->validate([
            'watch_type' => [
                'required',
                Rule::unique('mst_watch_type', 'title')
                    ->where(function ($query) {
                        return $query->where('status', 0);
                    })
                    ->ignore($request->wt_id, 'wt_id'),
            ],
        ]);

        // ---------- CREATE OR UPDATE ----------
        if ($request->filled('wt_id')) {

            $watch = WatchTypeModel::find($request->wt_id);

            if (!$watch) {
                return response()->json([
                    'status' => false,
                    'message' => 'Watch not found'
                ], 404);
            }

            $message = "Watch updated successfully";
        } else {

            $watch = new WatchTypeModel();
            $message = "Watch created successfully";
        }

        $watch->title = $request->watch_type;
        $watch->desc  = $request->desc;

        $watch->save();

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function watchlist(Request $request)
    {
        $columns = [
            0 => 'wt_id',
            1 => 'title',
            2 => 'desc',
            3 => 'status',
            4 => 'created_at',
            5 => 'action'
        ];

        $query = WatchTypeModel::query()->where('status', '0')->orderBy('wt_id', 'DESC');

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));

        $searchValue = $request->input('search.value');


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'LIKE', "%{$searchValue}%")
                    ->orWhere('desc', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }


        $orderColumn = $columns[$orderColumnIndex] ?? 'wt_id';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();


        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $statusBadge = $row->status == 0
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            $actionButtons = '
        <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-icon btn-primary-light rounded-pill editWatch" data-id="' . $row->wt_id . '">
                <i class="bx bx-edit"></i>
            </button>

            <button type="button" class="btn btn-icon btn-danger-light rounded-pill deleteWatch" data-id="' . $row->wt_id . '" data-name="' . e($row->title) . '">
                <i class="bx bx-trash"></i>
            </button>
        </div>';

            $formattedData[] = [
                'sr_no'        => $sr_no++,
                'title'   => e($row->title),
                'desc'   => e(value: $row->desc ?? '-'),
                'status'       => $statusBadge,
                'created_at'   => $row->created_at ? $row->created_at->format('d-m-Y') : '-',
                'action'       => $actionButtons
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData,
        ]);
    }

    public function watchedit($id)
    {
        $watch = WatchTypeModel::findOrFail($id);

        return response()->json($watch);
    }

    public function watchSoftDelete($id)
    {
        $watch = WatchTypeModel::find($id);

        if (!$watch) {
            return response()->json([
                'status' => false,
                'message' => 'Watch not found'
            ], 404);
        }

        // mark as soft deleted
        $watch->status = 1;
        $watch->save();

        return response()->json([
            'status' => true,
            'message' => 'Watch removed successfully'
        ]);
    }

    public function colourstore(Request $request)
    {
        // ---------- BASIC VALIDATION ----------
        $request->validate([
            'colour'   => 'required|array',
            'colour.*' => 'required|string',
        ]);


        if ($request->filled('color_id')) {

            $color = ColorModel::find($request->color_id);

            if (!$color) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Colour not found'
                ], 404);
            }

            $newColour = strtolower(trim($request->colour[0]));

            // Check duplicate except current record
            $exists = ColorModel::where('status', 0)
                ->whereRaw('LOWER(title) = ?', [$newColour])
                ->where('color_id', '!=', $request->color_id)
                ->first();

            if ($exists) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Colour already exists',
                    'exists'  => [$exists->title]
                ], 422);
            }

            // Update
            $color->update([
                'title' => ucfirst($newColour)
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Colour updated successfully'
            ]);
        }


        $inputColours = array_map(
            fn($c) => strtolower(trim($c)),
            $request->colour
        );

        // Find existing colours
        $existingColours = ColorModel::where('status', 0)
            ->whereIn(DB::raw('LOWER(title)'), $inputColours)
            ->pluck('title')
            ->toArray();

        if (!empty($existingColours)) {
            return response()->json([
                'status'  => false,
                'message' => 'Some colours already exist',
                'exists'  => $existingColours
            ], 422);
        }

        // Prepare insert
        $insertData = [];

        foreach ($request->colour as $value) {

            if (!$value) continue;

            $insertData[] = [
                'title'       => ucfirst(trim($value)),
                'status'      => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        ColorModel::insert($insertData);

        return response()->json([
            'status'  => true,
            'message' => 'Colour(s) saved successfully'
        ]);
    }


    public function colourlist(Request $request)
    {
        $columns = [
            0 => 'color_id',
            1 => 'title',
            2 => 'status',
            3 => 'created_at',
            4 => 'action'
        ];

        $query = ColorModel::query()->where('status', '0');

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));

        $searchValue = $request->input('search.value');


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }


        $orderColumn = $columns[$orderColumnIndex] ?? 'color_id';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();


        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $statusBadge = $row->status == 0
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            $actionButtons = '
        <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-icon btn-primary-light rounded-pill editColour" data-id="' . $row->color_id . '">
                <i class="bx bx-edit"></i>
            </button>

            <button type="button" class="btn btn-icon btn-danger-light rounded-pill deleteColour" data-id="' . $row->color_id . '" data-name="' . e($row->title) . '">
                <i class="bx bx-trash"></i>
            </button>
        </div>';

            $formattedData[] = [
                'sr_no'        => $sr_no++,
                'title'   => e($row->title),
                'status'       => $statusBadge,
                'created_at'   => $row->created_at ? $row->created_at->format('d-m-Y') : '-',
                'action'       => $actionButtons
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData,
        ]);
    }

    public function colouredit($id)
    {
        $color = ColorModel::findOrFail($id);

        return response()->json($color);
    }

    public function colourSoftDelete($id)
    {
        $color = ColorModel::find($id);

        if (!$color) {
            return response()->json([
                'status' => false,
                'message' => 'Colour not found'
            ], 404);
        }

        // mark as soft deleted
        $color->status = 1;
        $color->save();

        return response()->json([
            'status' => true,
            'message' => 'Colour removed successfully'
        ]);
    }

    public function glassstore(Request $request)
    {
        $request->validate([
            'glass_material' => [
                'required',
                Rule::unique('mst_glass_material', 'title')
                    ->where(function ($query) {
                        return $query->where('status', 0);
                    })
                    ->ignore($request->gm_id, 'gm_id'),
            ],
        ]);

        // ---------- CREATE OR UPDATE ----------
        if ($request->filled('gm_id')) {

            $glass = GlassMaterialModel::find($request->gm_id);

            if (!$glass) {
                return response()->json([
                    'status' => false,
                    'message' => 'Glass not found'
                ], 404);
            }

            $message = "Glass updated successfully";
        } else {

            $glass = new GlassMaterialModel();
            $message = "Glass created successfully";
        }

        $glass->title = $request->glass_material;
        $glass->desc  = $request->desc;

        $glass->save();

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }


    public function glasslist(Request $request)
    {
        $columns = [
            0 => 'gm_id',
            1 => 'title',
            2 => 'desc',
            3 => 'status',
            4 => 'created_at',
            5 => 'action'
        ];

        $query = GlassMaterialModel::query()->where('status', '0')->orderBy('gm_id', 'DESC');;

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));

        $searchValue = $request->input('search.value');


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'LIKE', "%{$searchValue}%")
                    ->orWhere('desc', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }


        $orderColumn = $columns[$orderColumnIndex] ?? 'gm_id';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();


        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $statusBadge = $row->status == 0
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            $actionButtons = '
        <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-icon btn-primary-light rounded-pill editGlass" data-id="' . $row->gm_id . '">
                <i class="bx bx-edit"></i>
            </button>

            <button type="button" class="btn btn-icon btn-danger-light rounded-pill deleteGlass" data-id="' . $row->gm_id . '" data-name="' . e($row->title) . '">
                <i class="bx bx-trash"></i>
            </button>
        </div>';

            $formattedData[] = [
                'sr_no'        => $sr_no++,
                'title'   => e($row->title),
                'desc'   => e(value: $row->desc ?? '-'),
                'status'       => $statusBadge,
                'created_at'   => $row->created_at ? $row->created_at->format('d-m-Y') : '-',
                'action'       => $actionButtons
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData,
        ]);
    }

    public function glassedit($id)
    {
        $glass = GlassMaterialModel::findOrFail($id);

        return response()->json($glass);
    }

    public function glassSoftDelete($id)
    {
        $glass = GlassMaterialModel::find($id);

        if (!$glass) {
            return response()->json([
                'status' => false,
                'message' => 'Glass not found'
            ], 404);
        }

        // mark as soft deleted
        $glass->status = 1;
        $glass->save();

        return response()->json([
            'status' => true,
            'message' => 'Glass removed successfully'
        ]);
    }


    public function movementstore(Request $request)
    {
        // ---------- VALIDATION ----------
        $request->validate([
            'movement_title'   => 'required|array',
            'movement_title.*' => 'required|string',
        ]);

        /* ======================================================
       ================= UPDATE (SINGLE) ===================
       ====================================================== */
        if ($request->filled('m_id')) {

            $movement = MovementModel::find($request->m_id);

            if (!$movement) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Movement not found'
                ], 404);
            }

            $newTitle = strtolower(trim($request->movement_title[0]));

            $exists = MovementModel::where('status', 0)
                ->whereRaw('LOWER(title) = ?', [$newTitle])
                ->where('m_id', '!=', $request->m_id)
                ->first();

            if ($exists) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Movement already exists',
                    'exists'  => [$exists->title]
                ], 422);
            }

            $movement->update([
                'title' => ucfirst($newTitle)
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Movement updated successfully'
            ]);
        }

        /* ======================================================
       ================= INSERT (MULTIPLE) ==================
       ====================================================== */

        // Normalize input
        $inputTitles = array_map(
            fn($t) => strtolower(trim($t)),
            $request->movement_title
        );

        // Check duplicates
        $existing = MovementModel::where('status', 0)
            ->whereIn(DB::raw('LOWER(title)'), $inputTitles)
            ->pluck('title')
            ->toArray();

        if (!empty($existing)) {
            return response()->json([
                'status'  => false,
                'message' => 'Some movements already exist',
                'exists'  => $existing
            ], 422);
        }

        // Prepare bulk insert
        $insertData = [];

        foreach ($request->movement_title as $title) {

            if (!$title) continue;

            $insertData[] = [
                'title'      => ucfirst(trim($title)),
                'status'     => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        MovementModel::insert($insertData);

        return response()->json([
            'status'  => true,
            'message' => 'Movement(s) saved successfully'
        ]);
    }


    public function movementlist(Request $request)
    {
        $columns = [
            0 => 'm_id',
            1 => 'title',
            2 => 'status',
            3 => 'created_at',
            4 => 'action'
        ];

        $query = MovementModel::query()->where('status', '0');

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));

        $searchValue = $request->input('search.value');


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }


        $orderColumn = $columns[$orderColumnIndex] ?? 'm_id';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();


        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $statusBadge = $row->status == 0
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            $actionButtons = '
        <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-icon btn-primary-light rounded-pill editMovement" data-id="' . $row->m_id . '">
                <i class="bx bx-edit"></i>
            </button>

            <button type="button" class="btn btn-icon btn-danger-light rounded-pill deleteMovement" data-id="' . $row->m_id . '" data-name="' . e($row->title) . '">
                <i class="bx bx-trash"></i>
            </button>
        </div>';

            $formattedData[] = [
                'sr_no'        => $sr_no++,
                'title'   => e($row->title),
                'status'       => $statusBadge,
                'created_at'   => $row->created_at ? $row->created_at->format('d-m-Y') : '-',
                'action'       => $actionButtons
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData,
        ]);
    }

    public function movementedit($id)
    {
        $movement = MovementModel::findOrFail($id);

        return response()->json($movement);
    }

    public function movementSoftDelete($id)
    {
        $movement = MovementModel::find($id);

        if (!$movement) {
            return response()->json([
                'status' => false,
                'message' => 'Movement not found'
            ], 404);
        }

        // mark as soft deleted
        $movement->status = 1;
        $movement->save();

        return response()->json([
            'status' => true,
            'message' => 'Movement removed successfully'
        ]);
    }


    public function Emailstore(Request $request)
    {
        // ✅ UPDATE MODE
        if ($request->email_id) {

            $exists = EmailModel::where("email", $request->email[0])
                ->where("email_id", "!=", $request->email_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    "message" => $request->email[0] . " already exists!"
                ], 422);
            }

            EmailModel::where("email_id", $request->email_id)->update([
                "email"      => $request->email[0],
                "updated_by" => current_user_id()
            ]);

            return response()->json([
                "message" => "Email Updated Successfully!"
            ]);
        }

        // ✅ INSERT MODE (Multiple Emails)
        $duplicates = [];

        foreach ($request->email as $mail) {

            if (EmailModel::where("email", $mail)->exists()) {
                $duplicates[] = $mail;
                continue;
            }

            EmailModel::create([
                "email"      => $mail,
                "status"     => 0,
                "created_by" => current_user_id()
            ]);
        }

        if (count($duplicates) > 0) {
            return response()->json([
                "message" => implode(", ", $duplicates) . " already exists!"
            ], 422);
        }

        return response()->json([
            "message" => "Emails Added Successfully!"
        ]);
    }


    public function emaillist(Request $request)
    {
        $columns = [
            0 => 'email_id',
            1 => 'email',
            2 => 'status',
            3 => 'created_at',
            4 => 'action'
        ];

        // ✅ Only Active Emails (status = 0 like movement)
        $query = EmailModel::query()->where('status', '0')->orderBy('email_id', 'DESC');

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));

        $searchValue = $request->input('search.value');

        // ✅ Search Filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('email', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        // ✅ Ordering
        $orderColumn = $columns[$orderColumnIndex] ?? 'email_id';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            // ✅ Status Badge
            $statusBadge = $row->status == 0
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            // ✅ Action Buttons (Same UI as Movement)
            $actionButtons = '
        <div class="d-flex gap-2 justify-content-center">

            <button type="button"
                class="btn btn-icon btn-primary-light rounded-pill editEmail"
                data-id="' . $row->email_id . '">
                <i class="bx bx-edit"></i>
            </button>

            <button type="button"
                class="btn btn-icon btn-danger-light rounded-pill deleteEmail"
                data-id="' . $row->email_id . '"
                data-email="' . e($row->email) . '">
                <i class="bx bx-trash"></i>
            </button>

        </div>';

            $formattedData[] = [
                'sr_no'      => $sr_no++,
                'email'      => e($row->email),
                'status'     => $statusBadge,
                'created_at' => $row->created_at ? $row->created_at->format('d-m-Y') : '-',
                'action'     => $actionButtons
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData,
        ]);
    }
    public function emailedit($id)
    {
        $email = EmailModel::where("email_id", $id)->first();

        return response()->json($email);
    }


    public function emaildelete($id)
    {

        EmailModel::where("email_id", $id)->delete();

        return response()->json([
            "message" => "Email Deleted Successfully!"
        ]);
    }
}
