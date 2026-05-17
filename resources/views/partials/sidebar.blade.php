@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Session;

    $currentRoute = Route::currentRouteName();

    /*
|--------------------------------------------------------------------------
| MENUS
|--------------------------------------------------------------------------
*/
    $menus = DB::table('mst_menu')->where('status', 0)->orderBy('menu_order')->get()->groupBy('slide_category');

    /*
|--------------------------------------------------------------------------
| SUB MENUS
|--------------------------------------------------------------------------
*/
    $subMenus = DB::table('tbl_sub_menu')->where('status', 0)->orderBy('sub_menu_order')->get()->groupBy('menu_id');
@endphp

<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <div class="logo_box" style="margin-right: auto;">
      <a href="{{ route('dashboard') }}" class="header-logo">
                <img src="{{ $actual_url . '/admin_assets/logo.png' }}" alt="logo" class="desktop-logo"
                    style="height: auto;
    width: 120px;;
    filter: invert(1);">

                <img src="{{ $actual_url . '/admin_assets/logo.png' }}" alt="logo" class="toggle-logo"
                    style="height: auto;
    width: 70px;
    filter: invert(1);">

                <img src="{{ $actual_url . '/admin_assets/logo.png' }}" alt="logo" class="desktop-dark"
                    style="height: auto;
    width: 120px;;
    filter: invert(1);">

                <img src="{{ $actual_url . '/admin_assets/logo.png' }}" alt="logo" class="toggle-dark"
                    style="height: auto;
    width: 70px;
    filter: invert(1);">
            </a>
        </div>


    </div>

    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <ul class="main-menu">

                {{-- LEFT SCROLL --}}
                <div class="slide-left" id="slide-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                    </svg>
                </div>

                @foreach ($menus as $category => $categoryMenus)
                    @php
                        // CHECK IF CATEGORY HAS AT LEAST ONE VISIBLE MENU
                        $showCategory = false;

                        foreach ($categoryMenus as $menu) {
                            // Menu without submenu
                            if ($menu->is_submenu == 0 && menuPermission($menu->menu_id, 'view')) {
                                $showCategory = true;
                                break;
                            }

                            // Menu with submenu
                            if ($menu->is_submenu == 1) {
                                foreach ($subMenus[$menu->menu_id] ?? [] as $sub) {
                                    if (menuPermission($menu->menu_id, 'view', $sub->sub_menu_id)) {
                                        $showCategory = true;
                                        break 2;
                                    }
                                }
                            }
                        }
                    @endphp

                    {{-- CATEGORY --}}
                    @if ($showCategory && trim($category) !== '')
                        <li class="slide__category">
                            <span class="category-name">{{ $category }}</span>
                        </li>
                    @endif

                    @foreach ($categoryMenus as $menu)
                        @php
                            // CHECK ACTIVE MENU
                            $isMenuActive = false;

                            if ($menu->menu_route === $currentRoute) {
                                $isMenuActive = true;
                            }

                            if ($menu->is_submenu == 1 && isset($subMenus[$menu->menu_id])) {
                                foreach ($subMenus[$menu->menu_id] as $sub) {
                                    if ($sub->submenu_route === $currentRoute) {
                                        $isMenuActive = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        {{-- MENU WITHOUT SUBMENU --}}
                        @if ($menu->is_submenu == 0 && menuPermission($menu->menu_id, 'view'))
                            <li class="slide {{ $isMenuActive ? 'active' : '' }}">
                                <a href="{{ $menu->menu_route && Route::has($menu->menu_route) ? route($menu->menu_route) : '#' }}"
                                    class="side-menu__item {{ $isMenuActive ? 'active' : '' }}">
                                    <span class="side-menu__icon">{!! $menu->menu_icon !!}</span>
                                    <span class="side-menu__label">{{ $menu->menu_name }}</span>
                                </a>
                            </li>
                        @endif

                        {{-- MENU WITH SUBMENU --}}
                        @if ($menu->is_submenu == 1)
                            @php
                                $allowedSubMenus = collect($subMenus[$menu->menu_id] ?? [])->filter(
                                    fn($sub) => menuPermission($menu->menu_id, 'view', $sub->sub_menu_id),
                                );
                            @endphp

                            @if ($allowedSubMenus->count())
                                <li class="slide has-sub {{ $isMenuActive ? 'open active' : '' }}">
                                    <a href="javascript:void(0);"
                                        class="side-menu__item {{ $isMenuActive ? 'active' : '' }}">
                                        <span class="side-menu__icon">{!! $menu->menu_icon !!}</span>
                                        <span class="side-menu__label">{{ $menu->menu_name }}</span>
                                        <i class="fe fe-chevron-right side-menu__angle"></i>
                                    </a>

                                    <ul class="slide-menu child1 {{ $isMenuActive ? 'show' : '' }}">
                                        @foreach ($allowedSubMenus as $sub)
                                            @php
                                                $isSubActive = $sub->submenu_route === $currentRoute;
                                            @endphp

                                            <li class="slide {{ $isSubActive ? 'active' : '' }}">
                                                <a href="{{ $sub->submenu_route && Route::has($sub->submenu_route) ? route($sub->submenu_route) : '#' }}"
                                                    class="side-menu__item {{ $isSubActive ? 'active' : '' }}">
                                                    {!! $sub->sub_menu_icon !!}
                                                    {{ $sub->sub_menu_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endforeach

                {{-- RIGHT SCROLL --}}
                <div class="slide-right" id="slide-right">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                    </svg>
                </div>

            </ul>
        </nav>
    </div>
</aside>
