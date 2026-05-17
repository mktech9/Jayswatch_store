<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckMenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
      public function handle(Request $request, Closure $next, $action = 'view')
    {
        // SUPER ADMIN → allow
        if (session('login_type') === 'super_admin') {
            return $next($request);
        }

        $currentRoute = $request->route()->getName(); // 🔥 IMPORTANT

        session(['current_page_route' => $currentRoute]);

        if (!$currentRoute) {
            return response()->view('frontend.404', [], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | 1. CHECK IN MAIN MENU (mst_menu)
        |--------------------------------------------------------------------------
        */
        $menu = DB::table('mst_menu')
            ->where('menu_route', $currentRoute)
            ->where('status', 0)
            ->first();

        $menuId = null;
        $subMenuId = null;

        if ($menu) {
            $menuId = $menu->menu_id;
        } else {

            /*
            |--------------------------------------------------------------------------
            | 2. CHECK IN SUB MENU (tbl_sub_menu)
            |--------------------------------------------------------------------------
            */
            $submenu = DB::table('tbl_sub_menu')
                ->where('submenu_route', $currentRoute)
                ->where('status', 0)
                ->first();

            if ($submenu) {
                $menuId = $submenu->menu_id;
                $subMenuId = $submenu->sub_menu_id;
            }
        }

        // 🚫 If not found in menu/submenu → block
        if (!$menuId) {
            return response()->view('frontend.404', [], 404);
        }


        if (!menuPermission((int)$menuId, $action, $subMenuId ? (int)$subMenuId : null)) {
            return response()->view('frontend.404', [], 404);
        }

        return $next($request);
    }

}
