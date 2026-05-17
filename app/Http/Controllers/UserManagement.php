<?php

namespace App\Http\Controllers;

use App\Models\BusinesslocationModel;
use App\Models\RoleModel;
use App\Models\StaffDocModel;
use App\Models\StaffModel;
use App\Models\SuperAdminModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class UserManagement extends Controller
{
    public function rolesindex()
    {
        $page_title = 'Roles';

        $menus = DB::table('mst_menu')
            ->where('status', 0)
            ->orderBy('menu_order')
            ->get();

        $subMenus = DB::table('tbl_sub_menu')
            ->where('status', 0)
            ->orderBy('sub_menu_order')
            ->get()
            ->groupBy('menu_id');

        return view('users.roles', compact('page_title', 'menus', 'subMenus'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $roleId = $request->role_id;

            if ($roleId) {

                // 🔄 UPDATE ROLE
                DB::table('tbl_role')
                    ->where('role_id', $roleId)
                    ->update([
                        'role_name' => $request->role_name,
                        'updated_by' => current_user_id(),
                        'updated_at' => now(),
                    ]);
            } else {

                // ➕ CREATE ROLE
                $roleId = DB::table('tbl_role')->insertGetId([
                    'role_name' => $request->role_name,
                    'role_status' => 0,
                    'created_by' => current_user_id(),
                    'updated_by' => current_user_id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('role_menu_permissions')
                ->where('role_id', $roleId)
                ->delete();

            if (! empty($request->permissions['menu'])) {

                foreach ($request->permissions['menu'] as $menuId => $perms) {

                    DB::table('role_menu_permissions')->insert([
                        'role_id' => $roleId,
                        'menu_id' => $menuId,
                        'sub_menu_id' => null,

                        'can_view' => in_array('can_view', $perms) ? 1 : 0,
                        'can_create' => in_array('can_create', $perms) ? 1 : 0,
                        'can_update' => in_array('can_update', $perms) ? 1 : 0,
                        'can_delete' => in_array('can_delete', $perms) ? 1 : 0,
                        'view_export' => in_array('can_export', $perms) ? 1 : 0,

                        'status' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if (! empty($request->permissions['sub_menu'])) {

                foreach ($request->permissions['sub_menu'] as $subMenuId => $perms) {

                    $menuId = DB::table('tbl_sub_menu')
                        ->where('sub_menu_id', $subMenuId)
                        ->value('menu_id');

                    DB::table('role_menu_permissions')->insert([
                        'role_id' => $roleId,
                        'menu_id' => $menuId,
                        'sub_menu_id' => $subMenuId,

                        'can_view' => in_array('can_view', $perms) ? 1 : 0,
                        'can_create' => in_array('can_create', $perms) ? 1 : 0,
                        'can_update' => in_array('can_update', $perms) ? 1 : 0,
                        'can_delete' => in_array('can_delete', $perms) ? 1 : 0,
                        'view_export' => in_array('can_export', $perms) ? 1 : 0,

                        'status' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $request->role_id
                    ? 'Role updated successfully'
                    : 'Role created successfully',
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function list(Request $request)
    {
        /* ===============================
       COLUMN MAP (DATATABLES)
    =============================== */
        $columns = [
            0 => 'role_id',
            1 => 'role_name',
            2 => 'created_at',
        ];

        /* ===============================
       BASE QUERY
    =============================== */
        $query = RoleModel::where('role_status', 0)->orderBy('role_id', 'DESC');

        $totalData = $query->count();
        $totalFiltered = $totalData;

        /* ===============================
       PAGINATION
    =============================== */
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = $request->input('search.value');

        /* ===============================
       SEARCH
    =============================== */
        if (! empty($searchValue)) {
            $query->where('role_name', 'LIKE', "%{$searchValue}%");
            $totalFiltered = $query->count();
        }

        /* ===============================
       ORDERING
    =============================== */
        $orderColumn = $columns[$orderColumnIndex] ?? 'role_id';
        $orderDirection = in_array($orderDirection, ['asc', 'desc']) ? $orderDirection : 'desc';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();

        /* ===============================
       FORMAT DATA
    =============================== */
        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $actionButtons = '
            <div class="d-flex gap-2 justify-content-center">
                <a href="javascript:void(0)"
                   class="btn btn-icon btn-primary-light rounded-pill btn-wave editRole"
                   data-id="'.$row->role_id.'"
                   title="Edit">
                    <i class="bx bx-edit"></i>
                </a>

                <a href="javascript:void(0)"
                   class="btn btn-icon btn-danger-light rounded-pill btn-wave deleteRole"
                   data-id="'.$row->role_id.'"
                   data-name="'.e($row->role_name).'"
                   title="Delete">
                    <i class="bx bx-trash"></i>
                </a>
            </div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'role_name' => e($row->role_name),
                'created_at' => $row->created_at->format('d-m-Y'),
                'action' => $actionButtons,
            ];
        }

        /* ===============================
       RESPONSE
    =============================== */
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData,
        ]);
    }

    public function edit($id)
    {
        $role = RoleModel::findOrFail($id);

        $permissions = DB::table('role_menu_permissions')
            ->where('role_id', $id)
            ->get();

        return response()->json([
            'status' => true,
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function softDelete(Request $request)
    {
        DB::table('tbl_role')
            ->where('role_id', $request->role_id)
            ->update([
                'role_status' => 1,
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Role deleted successfully',
        ]);
    }

    // ////////////////////////////////////////////CRUD USERS////////////////////////////

    public function usersindex()
    {
        $page_title = 'Add Staff';

        $role_data = RoleModel::where('role_status', 0)->get();
        $locations = BusinesslocationModel::where('status', 0)
            ->orderBy('name')
            ->get();

        return view('users.create', compact(
            'page_title',
            'role_data',
            'locations'
        ));
    }

    public function storeuser(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'email',
            Rule::unique('tbl_staff', 'email_id')
                ->where(function ($query) {
                    return $query->where('status', 0);
                })
                ->ignore($request->staff_id, 'staff_id'),
            'role_id' => 'required|integer',
            'password' => $request->staff_id ? 'nullable|min:4' : 'required|min:4',
        ]);

        $data = [
            'role_id' => $request->role_id,
            'prefix' => $request->prefix,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email_id' => $request->email_id,
            'user_name' => $request->user_name,
            'access_location' => $request->access_location ?? null,
            'sales_commission' => $request->sales_commission,
            'sales_discount' => $request->sales_discount,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
            'alt_contact_number' => $request->alt_contact_number,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'permanent_address' => $request->permanent_address,
            'current_address' => $request->current_address,
            'acc_holder_name' => $request->acc_holder_name,
            'acc_number' => $request->acc_number,
            'bank_name' => $request->bank_name,
            'bank_code' => $request->bank_code,
            'bank_branch' => $request->bank_branch,
            'tax_payer_id' => $request->tax_payer_id,
        ];

        $data['active_status'] = $request->active_status ?? 1;
        $data['login_status'] = $request->login_status ?? 1;
        $data['allow_contact'] = $request->allow_contact ?? 1;

        if (! empty($request->dob)) {
            $data['dob'] = Carbon::parse($request->dob)->format('Y-m-d');
        } else {
            $data['dob'] = null;
        }

        if (is_array($request->access_location)) {
            $data['access_location'] = implode(',', $request->access_location);
        }

        if (! empty($request->password)) {
            $data['password'] = md5($request->password);
        }

        if (! empty($request->staff_id)) {

            StaffModel::where('staff_id', $request->staff_id)->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Staff updated successfully',
            ]);
        }

        $data['status'] = 0;
        $data['created_by'] = current_user_id();

        StaffModel::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Staff added successfully',
        ]);
    }

    public function userlist(Request $request)
    {

        $columns = [
            0 => 'staff_id',
            1 => 'user_name',
            2 => 'first_name',
            3 => 'role_id',
            4 => 'email_id',
            5 => 'created_at',
        ];

        $query = StaffModel::with('role')
            ->where('status', 0);

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = strtolower($request->input('order.0.dir', 'desc'));
        $searchValue = trim($request->input('search.value'));

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('user_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('first_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('email_id', 'LIKE', "%{$searchValue}%");
            });

            $totalFiltered = $query->count();
        }

        $orderColumn = $columns[$orderColumnIndex] ?? 'staff_id';
        $orderDirection = in_array($orderDirection, ['asc', 'desc']) ? $orderDirection : 'desc';

        $query->orderBy($orderColumn, $orderDirection)
            ->offset($start)
            ->limit($limit);

        $data = $query->get();

        $formattedData = [];
        $sr_no = $start + 1;

        foreach ($data as $row) {

            $fullName = trim($row->first_name.' '.$row->last_name);

            $actionButtons = '
<div class="d-flex gap-2 justify-content-center">

    <button type="button"
        class="btn btn-icon btn-info-light rounded-pill btn-wave viewUser"
        data-id="'.encrypt($row->staff_id).'"
        title="View">
        <i class="bx bx-show"></i>
    </button>

    <button type="button"
        class="btn btn-icon btn-primary-light rounded-pill btn-wave editUser"
        data-id="'.$row->staff_id.'"
        title="Edit">
        <i class="bx bx-edit"></i>
    </button>

    <button type="button"
        class="btn btn-icon btn-danger-light rounded-pill btn-wave deleteUser"
        data-id="'.$row->staff_id.'"
        data-name="'.e($fullName).'"
        title="Delete">
        <i class="bx bx-trash"></i>
    </button>

</div>';

            $formattedData[] = [
                'sr_no' => $sr_no++,
                'user_name' => e($row->user_name),
                'name' => e($fullName),
                'role' => e($row->role->role_name ?? '-'),
                'email' => e($row->email_id),
                'created_at' => optional($row->created_at)->format('d-m-Y'),
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

    public function userview($id)
    {
        $page_title = 'User Information';
        $staffId = decrypt($id);

        $user = StaffModel::with('role')->findOrFail($staffId);

        // Convert stored locations to array
        $accessLocationNames = $user->access_location
            ? array_map('trim', explode(',', $user->access_location))
            : [];

        $locations = BusinesslocationModel::where('status', 0)
            ->whereIn('bl_id', $accessLocationNames)
            ->get();

        return view('users.view', compact(
            'user',
            'page_title',
            'locations'
        ));
    }

    public function editUsers($id)
    {
        $staff = StaffModel::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $staff,
        ]);
    }

    public function deleteUser(Request $request)
    {
        StaffModel::where('staff_id', $request->staff_id)
            ->update(['status' => 1]);

        return response()->json([
            'status' => true,
            'message' => 'Staff deleted successfully',
        ]);
    }

    public function editUsersInfo($id)
    {
        $page_title = 'Add Users';
        $role_data = RoleModel::where('role_status', 0)->get();

        $editStaffId = decrypt($id);

        $locations = BusinesslocationModel::where('status', 0)
            ->orderBy('name')
            ->get();

        return view('users.create', compact(
            'page_title',
            'role_data',
            'editStaffId',
            'locations'
        ));
    }

    public function updateImage(Request $request)
    {
        if (! $request->hasFile('image')) {
            return response()->json(['status' => false, 'message' => 'No image uploaded']);
        }

        $file = $request->file('image');

        $folder = public_path('assets/admin_assets/profile/');

        if (! file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($folder, $filename);

        $loginType = Session::get('login_type');

        if ($loginType === 'super_admin') {

            $username = Session::get('super_admin_username');

            $user = DB::table('super_admin')->where('sp_username', $username)->first();

            if ($user && ! empty($user->profile_pic)) {
                $old = $folder.$user->profile_pic;
                if (file_exists($old)) {
                    unlink($old);
                }
            }

            DB::table('super_admin')
                ->where('sp_username', $username)
                ->update(['profile_pic' => $filename]);
        }

        if ($loginType === 'staff') {

            $staffId = Session::get('staff_id');

            $user = DB::table('tbl_staff')->where('staff_id', $staffId)->first();

            if ($user && ! empty($user->profile_pic)) {
                $old = $folder.$user->profile_pic;
                if (file_exists($old)) {
                    unlink($old);
                }
            }

            DB::table('tbl_staff')
                ->where('staff_id', $staffId)
                ->update(['profile_pic' => $filename]);
        }

        return response()->json(['status' => true, 'image' => $filename]);
    }

    public function changePassword(Request $request)
    {
        $loginType = Session::get('login_type');

        $currentPassword = md5($request->current_password);
        $newPassword = md5($request->new_password);

        if (! $loginType) {
            return response()->json(['status' => false, 'message' => 'User not logged in']);
        }

        // prevent same password
        if ($currentPassword === $newPassword) {
            return response()->json([
                'status' => false,
                'message' => 'New password cannot be same as current password',
            ]);
        }

        // ================= SUPER ADMIN =================
        if ($loginType === 'super_admin') {

            $username = Session::get('super_admin_username');

            $user = DB::table('super_admin')
                ->where('sp_username', $username)
                ->first();

            if (! $user) {
                return response()->json(['status' => false, 'message' => 'User not found']);
            }

            // check current password match
            if ($user->sp_password != $currentPassword) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect',
                ]);
            }

            DB::table('super_admin')
                ->where('sp_username', $username)
                ->update(['sp_password' => $newPassword]);

            return response()->json(['status' => true, 'message' => 'Password updated successfully']);
        }

        // ================= STAFF =================
        if ($loginType === 'staff') {

            $staffId = Session::get('staff_id');

            $user = DB::table('tbl_staff')
                ->where('staff_id', $staffId)
                ->first();

            if (! $user) {
                return response()->json(['status' => false, 'message' => 'User not found']);
            }

            // check current password match
            if ($user->password != $currentPassword) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect',
                ]);
            }

            DB::table('tbl_staff')
                ->where('staff_id', $staffId)
                ->update(['password' => $newPassword]);

            return response()->json(['status' => true, 'message' => 'Password updated successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Invalid login type']);
    }

    // /////Staff Documentation/////////
    public function staffdocstore(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'title' => 'required|string|max:255',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $newFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('assets/admin_assets/staff_doc'), $name);
                $newFiles[] = $name;
            }
        }

        if (! empty($request->doc_id)) {
            $keptFiles = $request->existing_files ?? [];
            $finalFiles = array_merge($keptFiles, $newFiles);

            StaffDocModel::where('sd_id', $request->doc_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'files' => implode(',', $finalFiles),
                'is_private' => $request->is_private ?? 0,
                'updated_by' => current_user_id(),
            ]);

            $message = 'Document updated successfully';
        } else {
            StaffDocModel::create([
                'staff_id' => $request->staff_id,
                'title' => $request->title,
                'description' => $request->description,
                'files' => implode(',', $newFiles),
                'is_private' => $request->is_private ?? 0,
                'status' => 0,
                'created_by' => current_user_id(),
            ]);

            $message = 'Document added successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function staffdoclist($staff_id)
    {
        $docs = StaffDocModel::with('staff')
            ->where('staff_id', $staff_id)
            ->orderBy('sd_id', 'desc')
            ->get();

        $data = [];
        $i = 1;

        foreach ($docs as $doc) {
            $data[] = [
                'sr_no' => $i++,
                'action' => '
    <div class="d-flex align-items-center gap-1">

        <button class="btn btn-sm btn-info viewDoc" data-id="'.$doc->sd_id.'">
            <i class="bx bx-show"></i>
        </button>

        <button class="btn btn-sm btn-warning editDoc" data-id="'.$doc->sd_id.'">
            <i class="bx bx-edit-alt"></i>
        </button>

        <button class="btn btn-sm btn-danger deleteDoc" data-id="'.$doc->sd_id.'">
            <i class="bx bx-trash"></i>
        </button>

    </div>
',

                'title' => $doc->title,
                'added_by' => $doc->created_by
                    ? full_name($doc->created_by)
                    : '-',
                'created_at' => Carbon::parse($doc->created_at)->format('d-m-Y'),
                'updated_at' => $doc->updated_at
                    ? Carbon::parse($doc->updated_at)->format('d-m-Y')
                    : '-',
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function staffDocShow($id)
    {
        $doc = StaffDocModel::with('staff')->findOrFail($id);

        // explode files csv into array
        $files = $doc->files ? explode(',', $doc->files) : [];

        return response()->json([
            'status' => true,
            'data' => $doc,
            'files' => $files,
        ]);
    }

    // Edit
    public function staffDocEdit($id)
    {
        $doc = StaffDocModel::findOrFail($id);

        $files = $doc->files ? explode(',', $doc->files) : [];

        return response()->json([
            'status' => true,
            'data' => $doc,
            'files' => $files,
        ]);
    }

    public function profile_index()
    {
        $page_title = 'Profile';

        $currentId = current_user_id();   // your helper

        if ($currentId === -1) {

            // super admin
            $user = SuperAdminModel::first();   // since only 1 super admin normally
            $type = 'super_admin';
        } else {

            // staff
            $user = StaffModel::where('staff_id', $currentId)->first();
            $type = 'staff';
        }

        return view('users.profile', compact('page_title', 'user', 'type'));
    }

    // update profile

    public function update(Request $request)
    {
        $loginType = Session::get('login_type');

        try {

            // =========================
            // SUPER ADMIN — ONLY EMAIL
            // =========================
            if ($loginType === 'super_admin') {

                $email = $request->input('email');

                if (! $email) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email is required',
                    ], 422);
                }

                $admin = DB::table('super_admin')
                    ->where('sp_username', Session::get('super_admin_username'))
                    ->first();

                if (! $admin) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Admin not found',
                    ], 404);
                }

                // no change
                if ($admin->sp_email == $email) {
                    return response()->json([
                        'success' => true,
                        'message' => 'No changes detected',
                    ]);
                }

                // ---------- FIRST TRY including updated_at ----------
                try {
                    DB::table('super_admin')
                        ->where('sp_username', Session::get('super_admin_username'))
                        ->update([
                            'sp_email' => $email,
                            'updated_at' => now(),
                        ]);
                } catch (\Throwable $e) {
                    // ---------- RETRY without updated_at ----------
                    DB::table('super_admin')
                        ->where('sp_username', Session::get('super_admin_username'))
                        ->update([
                            'sp_email' => $email,
                        ]);
                }

                // update session email (if displayed anywhere)
                Session::put('super_admin_email', $email);

                return response()->json([
                    'success' => true,
                    'message' => 'Email updated',
                ]);
            }

            // =========================
            // STAFF — unchanged
            // =========================
            if ($loginType === 'staff') {

                $staffId = Session::get('staff_id');
                $staff = StaffModel::find($staffId);

                if (! $staff) {
                    return response()->json(['success' => false]);
                }

                $staff->prefix = $request->prefix;
                $staff->first_name = $request->first_name;
                $staff->last_name = $request->last_name;
                $staff->email_id = $request->email;
                $staff->contact_number = $request->mobile;
                $staff->alt_contact_number = $request->alt_mobile;
                $staff->current_address = $request->current_address;
                $staff->permanent_address = $request->permanent_address;
                $staff->dob = $request->dob;
                $staff->gender = $request->gender;
                $staff->facebook_link = $request->facebook;
                $staff->twitter_link = $request->twitter;
                $staff->language = $request->language;

                $staff->bank_name = $request->bank_name;
                $staff->bank_branch = $request->branch;
                $staff->acc_holder_name = $request->account_holder;
                $staff->acc_number = $request->account_number;
                $staff->bank_code = $request->bank_code;
                $staff->tax_payer_id = $request->tax_id;

                $staff->updated_by = current_user_id();

                if ($staff->isDirty()) {
                    $staff->updated_at = now();
                    $staff->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Updated only changed fields',
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'No changes detected',
                ]);
            }

            return response()->json(['success' => false]);

        } catch (\Throwable $e) {

            // Always JSON to avoid unexpected '<'
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

public function activityLogs(Request $request)
{
    $staffId = $request->staff_id;

    $logs = DB::table('activity_log')
        ->where('menu_type', 'user')
        ->whereIn('log_type', ['login_activity', 'logout_activity'])
        ->where('user_id', $staffId)
        ->orderByDesc('log_date') // latest first
        ->get();

    $data = [];
    $sr = 1;

    foreach ($logs as $log) {

        $action = match ($log->log_type) {
            'login_activity' => 'Login',
            'logout_activity' => 'Logout',
            default => '-',
        };

        $data[] = [
            'sr_no' => $sr++,
       'log_date' => $log->log_date, // for sorting
                'date' => Carbon::parse($log->log_date)
                ->timezone('Asia/Kolkata')
                ->format('d-m-Y h:i A'), // display format
            'action' => $action,
            'by' => full_name($log->user_id),
        ];
    }

    return response()->json($data);
}
}
