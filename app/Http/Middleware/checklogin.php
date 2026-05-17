<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class checklogin
{
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |----------------------------------------------------------
        | RESTORE SESSION FROM REMEMBER-ME COOKIE (IF NOT LOGGED IN)
        |----------------------------------------------------------
        */
        if (!session()->has('login_type') && Cookie::has('remember_login')) {

            $cookie = json_decode(Cookie::get('remember_login'), true);

            if (!empty($cookie['type']) && !empty($cookie['id'])) {

                /* ================= SUPER ADMIN ================= */
                if ($cookie['type'] === 'super_admin') {

                    $admin = DB::table('super_admin')
                        ->where('sp_id', $cookie['id'])
                        ->first();

                    if ($admin) {
                        Session::put('login_type', 'super_admin');
                        Session::put('super_admin_id', $admin->sp_id);
                        Session::put('super_admin_username', $admin->sp_username);
                    }
                }

                /* ================= STAFF ================= */
                if ($cookie['type'] === 'staff') {

                    $staff = DB::table('tbl_staff')
                        ->where('staff_id', $cookie['id'])
                        ->where('active_status', 0)
                        ->first();

                    if ($staff) {
                        Session::put('login_type', 'staff');
                        Session::put('staff_id', $staff->staff_id);
                        Session::put('staff_username', $staff->user_name);
                        Session::put('staff_first_name', $staff->first_name);
                        Session::put('staff_last_name', $staff->last_name);
                    }
                }
            }
        }

        /*
        |----------------------------------------------------------
        | IF USER IS LOGGED IN → ALLOW ACCESS
        |----------------------------------------------------------
        */
        if (
            session()->has('login_type') &&
            (
                (session('login_type') === 'super_admin' && session()->has('super_admin_id')) ||
                (session('login_type') === 'staff' && session()->has('staff_id'))
            )
        ) {
            $response = $next($request);

            return $response
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        /*
        |----------------------------------------------------------
        | NOT LOGGED IN → REDIRECT TO LOGIN
        |----------------------------------------------------------
        */
        return redirect()->route('login');
    }
}
