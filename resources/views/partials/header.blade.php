@php
    use App\Models\NotificationModel;

    $notifications = NotificationModel::where('read_status', 0)
        ->where('status', 0)
        ->orderBy('created_at', 'desc')
        ->get();

    $unreadCount = $notifications->count();
@endphp

<style>
    /* Search dropdown scroll */
    .modal-backdrop.fix-notification {
        opacity: var(--bs-backdrop-opacity) !important;
    }

    Applied dynamically only when notification modal is open .modal-backdrop.force-zindex-zero {
        --bs-backdrop-zindex: 0 !important;
    }

    #headersearch {
        max-height: 400px;
        /* adjust height as needed */
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Smooth scrollbar (optional) */
    #headersearch::-webkit-scrollbar {
        width: 6px;
    }

    #headersearch::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #headersearch::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    #headersearch::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
<style>
    .calc-btn {
        padding: 5px 0;
        /* Reduced padding */
        font-weight: 600;
        transition: all 0.2s;
        font-size: 13px;
        /* Smaller font */
    }

    .calc-btn:hover {
        background-color: #f0f1f7;
        transform: translateY(-1px);
    }

    .calc-btn:active {
        transform: translateY(1px);
    }

    #calc-display {
        height: 35px;
        /* Reduced height */
        letter-spacing: 1px;
        font-size: 16px !important;
        margin-bottom: 8px !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
<header class="app-header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo">
                        {{-- <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                        <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                        <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                        <img src="../assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark"> --}}
                    </a>
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                @php
                    use Illuminate\Support\Facades\DB;
                    use Illuminate\Support\Facades\Route;

                    // Fetch Menus
                    $searchMenus = DB::table('mst_menu')->where('status', 0)->orderBy('menu_order')->get();

                    // Fetch Submenus
                    $searchSubMenus = DB::table('tbl_sub_menu')
                        ->where('status', 0)
                        ->orderBy('sub_menu_order')
                        ->get()
                        ->groupBy('menu_id');
                @endphp

                <a aria-label="anchor" href="javascript:void(0);" class="sidemenu-toggle header-link"
                    data-bs-toggle="sidebar">
                    <span class="open-toggle me-2">
                        <i class="bx bx-menu header-link-icon"></i>
                    </span>
                </a>

                <div class="main-header-center d-none d-lg-block header-link">
                    <input type="text" class="form-control form-control-lg" id="typehead"
                        placeholder="Search for results..." autocomplete="off">
                    <button type="button" aria-label="button" class="btn pe-1"><i class="fe fe-search"
                            aria-hidden="true"></i></button>

                    <div id="headersearch" class="header-search">
                        <div class="p-3">
                            <div class="mt-3">

                                <ul class="ps-0 list-unstyled">
                                    @foreach ($searchMenus as $sMenu)

                                        {{-- 2. Menu with Submenus --}}
                                        @if ($sMenu->is_submenu == 1 && isset($searchSubMenus[$sMenu->menu_id]))
                                            {{-- Filter Visible Submenus based on Permission --}}
                                            @php
                                                $visibleSubs = $searchSubMenus[$sMenu->menu_id]->filter(function (
                                                    $sub,
                                                ) use ($sMenu) {
                                                    return menuPermission($sMenu->menu_id, 'view', $sub->sub_menu_id);
                                                });
                                            @endphp

                                            @if ($visibleSubs->count() > 0)
                                                {{-- Menu Name Header (Isolator) --}}
                                                <li class="mt-4 mb-2 px-2 d-flex align-items-center search-header"
                                                    data-menu-id="{{ $sMenu->menu_id }}">
                                                    <span class="text-primary fs-15 me-2">
                                                        {!! $sMenu->menu_icon !!}
                                                    </span>
                                                    <span
                                                        class="fw-bold text-uppercase fs-12 text-muted ls-1">{{ $sMenu->menu_name }}</span>
                                                </li>

                                                {{-- Loop Submenus --}}
                                                @foreach ($visibleSubs as $sSub)
                                                    <li class="mb-1 ms-2 ps-3 border-start border-2 border-light search-sub-item"
                                                        data-parent-id="{{ $sMenu->menu_id }}">
                                                        <a href="{{ $sSub->submenu_route && Route::has($sSub->submenu_route) ? route($sSub->submenu_route) : '#' }}"
                                                            class="d-flex align-items-center p-2 rounded-2 text-decoration-none search-app hover-bg-light">

                                                            {{-- Directed Icon --}}
                                                            <i class="bx bx-chevron-right text-muted me-2 fs-16"></i>

                                                            {{-- DB Icon --}}
                                                            <span class="me-2 text-primary opacity-75 fs-14">
                                                                {!! $sSub->sub_menu_icon !!}
                                                            </span>

                                                            {{-- Submenu Name --}}
                                                            <span
                                                                class="text-dark fs-13 fw-normal">{{ $sSub->sub_menu_name }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endif

                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element header-search d-lg-none d-block ">
                <!-- Start::header-link -->
                <a aria-label="anchor" href="javascript:void(0);" class="header-link" data-bs-toggle="modal"
                    data-bs-target="#searchModal">
                    <i class="bx bx-search-alt-2 header-link-icon"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <div class="header-content-right">

            <!-- Start::header-element -->
            {{-- <div class="header-element country-selector">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a aria-label="anchor" href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bx bx-globe header-link-icon"></i>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <ul class="main-header-dropdown dropdown-menu border-0" data-popper-placement="none">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="../assets/images/flags/us_flag.jpg" alt="img">
                                    </span>
                                    English
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="../assets/images/flags/spain_flag.jpg" alt="img">
                                    </span>
                                    Spanish
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="../assets/images/flags/french_flag.jpg" alt="img">
                                    </span>
                                    French
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="../assets/images/flags/germany_flag.jpg" alt="img">
                                    </span>
                                    German
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="../assets/images/flags/italy_flag.jpg" alt="img">
                                    </span>
                                    Italian
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="../assets/images/flags/russia_flag.jpg" alt="img">
                                    </span>
                                    Russian
                                </a>
                            </li>
                        </ul>
                    </div> --}}
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a aria-label="anchor" href="javascript:void(0);" class="header-link layout-setting">
                    <!-- Start::header-link-icon -->
                    <i class="bx bx-sun bx-flip-horizontal header-link-icon ionicon  dark-layout"></i>
                    <!-- End::header-link-icon -->
                    <!--  Start::header-link-icon -->
                    <i class="bx bx-moon bx-flip-horizontal header-link-icon ionicon light-layout"></i>
                    <!-- End::header-link-icon -->
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->
            <div class="header-element header-calculator">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside">
                    <i class="bx bx-calculator header-link-icon"></i>
                </a>

                <div class="main-header-dropdown dropdown-menu border-0 dropdown-menu-end p-0 overflow-hidden"
                    data-popper-placement="none" style="min-width: 220px;">

                    <div class="calc-header bg-primary text-white p-2 d-flex justify-content-between align-items-center"
                        style="cursor: move;">
                        <span class="fs-12 fw-bold"><i class="bx bx-move me-1"></i> Calculator</span>
                        <i class="bx bx-x fs-14 cursor-pointer"
                            onclick="this.closest('.dropdown-menu').classList.remove('show')"></i>
                    </div>

                    <div class="calculator-body p-2">
                        <div class="mb-2">
                            <input type="text" class="form-control text-end fw-bold bg-light border-0"
                                id="calc-display" readonly value="0">
                        </div>
                        <div class="row g-1">
                            <div class="col-3"><button class="btn btn-light w-100 calc-btn text-danger"
                                    onclick="calcClear()">C</button></div>
                            <div class="col-3"><button class="btn btn-light w-100 calc-btn"
                                    onclick="calcAppend('/')">/</button></div>
                            <div class="col-3"><button class="btn btn-light w-100 calc-btn"
                                    onclick="calcAppend('*')">×</button></div>
                            <div class="col-3"><button class="btn btn-light w-100 calc-btn"
                                    onclick="calcBackspace()"><i class="bx bx-left-arrow-alt"></i></button></div>

                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('7')">7</button></div>
                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('8')">8</button></div>
                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('9')">9</button></div>
                            <div class="col-3"><button class="btn btn-light w-100 calc-btn"
                                    onclick="calcAppend('-')">-</button></div>

                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('4')">4</button></div>
                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('5')">5</button></div>
                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('6')">6</button></div>
                            <div class="col-3"><button class="btn btn-light w-100 calc-btn"
                                    onclick="calcAppend('+')">+</button></div>

                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('1')">1</button></div>
                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('2')">2</button></div>
                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('3')">3</button></div>
                            <div class="col-3" rowspan="2"><button class="btn btn-primary w-100 h-100 calc-btn"
                                    onclick="calcResult()">=</button></div>

                            <div class="col-6"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('0')">0</button></div>
                            <div class="col-3"><button class="btn btn-light border w-100 calc-btn"
                                    onclick="calcAppend('.')">.</button></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <!-- Start::header-element -->
                    <div class="header-element cart-dropdown">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bx bx-cart header-link-icon ionicon"></i>
                            <span class="badge bg-danger rounded-pill header-icon-badge" id="cart-icon-badge">5</span>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <!-- Start::main-header-dropdown -->
                        <div class="main-header-dropdown dropdown-menu  border-0 dropdown-menu-end" data-popper-placement="none">
                            <div class="p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0 fs-17 fw-semibold">Cart Items</p>
                                    <span class="badge bg-success-transparent" id="cart-data">5 Items</span>
                                </div>
                            </div>
                            <div>
                                <hr class="dropdown-divider">
                            </div>
                            <ul class="list-unstyled mb-0" id="header-cart-items-scroll">
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start cart-dropdown-item">
                                        <span class="avatar avatar-xl bd-gray-200 p-1">
                                            <img src="../assets/images/ecommerce/png/1.png" alt="">
                                        </span>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex align-items-start justify-content-between mb-0">
                                                <div class=" fs-13 fw-semibold">
                                                    <a href="cart.html">Cactus mini plant</a>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                            <div class="min-w-fit-content align-items-start">
                                                <div class=" fw-normal fs-12 text-muted">Quantity:02</div>
                                                <div class="d-flex  align-items-center">
                                                    <span class=" fw-semibold fs-16">$1,229</span>
                                                    <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$1,799</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start cart-dropdown-item">
                                        <span class="avatar avatar-xl bd-gray-200 p-1">
                                            <img src="../assets/images/ecommerce/png/15.png" alt="">
                                        </span>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex align-items-start justify-content-between mb-0">
                                                <div class=" fs-13 fw-semibold">
                                                    <a href="cart.html">Sports shoes for men</a>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                            <div class="min-w-fit-content align-items-start">
                                                <div class=" fw-normal fs-12 text-muted">Quantity:01</div>
                                                <div class="d-flex  align-items-center">
                                                    <span class=" fw-semibold fs-16">$10,229</span>
                                                    <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$799</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start cart-dropdown-item">
                                        <span class="avatar avatar-xl bd-gray-200 p-1">
                                            <img src="../assets/images/ecommerce/png/40.png" alt="">
                                        </span>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex align-items-start justify-content-between mb-0">
                                                <div class=" fs-13 fw-semibold">
                                                    <a href="cart.html">Pink color smart watch </a>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                            <div class="min-w-fit-content align-items-start">
                                                <div class=" fw-normal fs-12 text-muted">Quantity:03</div>
                                                <div class="d-flex  align-items-center">
                                                    <span class=" fw-semibold fs-16">$5,500</span>
                                                    <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$599</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start cart-dropdown-item">
                                        <span class="avatar avatar-xl bd-gray-200 p-1">
                                            <img src="../assets/images/ecommerce/png/8.png" alt="">
                                        </span>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex align-items-start justify-content-between mb-0">
                                                <div class=" fs-13 fw-semibold">
                                                    <a href="cart.html">Red Leafs plant </a>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                            <div class="min-w-fit-content align-items-start">
                                                <div class=" fw-normal fs-12 text-muted">Quantity:01</div>
                                                <div class="d-flex  align-items-center">
                                                    <span class=" fw-semibold fs-16">$15,300</span>
                                                    <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$799</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start cart-dropdown-item">
                                        <span class="avatar avatar-xl bd-gray-200 p-1">
                                            <img src="../assets/images/ecommerce/png/11.png" alt="">
                                        </span>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex align-items-start justify-content-between mb-0">
                                                <div class=" fs-13 fw-semibold">
                                                    <a href="cart.html">Good luck mini plant</a>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                            <div class="min-w-fit-content align-items-start">
                                                <div class=" fw-normal fs-12 text-muted">Quantity:02</div>
                                                <div class="d-flex  align-items-center">
                                                    <span class=" fw-semibold fs-16">$600</span>
                                                    <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$99</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="p-3 empty-header-item border-top">
                                <div class="d-grid">
                                    <a href="checkout.html" class="btn btn-primary">Checkout</a>
                                </div>
                            </div>
                            <div class="p-5 empty-item d-none">
                                <div class="text-center">
                                    <span class="avatar avatar-xxl avatar-rounded bg-warning-transparent">
                                        <i class="bx bx-cart bx-tada fs-2"></i>
                                    </span>
                                    <h6 class="fw-bold mb-2 mt-3">Your Cart is Empty</h6>
                                    <a href="products.html" class="btn btn-primary btn-wave btn-sm m-1" data-abc="true">continue shopping <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- End::main-header-dropdown -->
                    </div>
                    <!-- End::header-element --> --}}

            <!-- Start::header-element -->

            @php
                $isSuperAdmin = Session::get('login_type') === 'super_admin';

                $visibleNotifications = collect();

                // Current user's allowed location IDs
$allowedLocationIds = access_locations()->pluck('bl_id')->toArray();

foreach ($notifications as $notification) {
    // Super admin sees both
    if ($isSuperAdmin) {
        if (in_array($notification->type, ['Product', 'Stock Transfer'])) {
            $visibleNotifications->push($notification);
        }
        continue;
    }

    // Staff: only stock transfer notifications for their destination location
    if ($notification->type === 'Stock Transfer') {
        preg_match('/:-\s*(.+)$/', $notification->description ?? '', $match);
        $referenceNo = $match[1] ?? null;

        if (!$referenceNo) {
            continue;
        }

        $stock = \App\Models\StockTransferModel::where('reference_no', $referenceNo)->first();

        if ($stock && in_array($stock->location_to, $allowedLocationIds)) {
            $visibleNotifications->push($notification);
        }
    }
}

$visibleNotifications = $visibleNotifications->sortByDesc('created_at')->values();
            @endphp

            <div class="header-element notifications-dropdown ">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                    <i class="bx bx-bell bx-flip-horizontal header-link-icon ionicon"></i>
                    <span class="badge bg-info rounded-pill header-icon-badge pulse pulse-secondary"
                        id="notification-icon-badge">
                        {{ $visibleNotifications->count() }}
                    </span>

                </a>
                <!-- End::header-link|dropdown-toggle -->
                <!-- Start::main-header-dropdown -->
                <div class="main-header-dropdown dropdown-menu border-0 dropdown-menu-end">

                    <div class="p-3 d-flex align-items-center justify-content-between">
                        <p class="mb-0 fs-17 fw-semibold">Notifications</p>
                        <span class="badge bg-secondary-transparent" id="notification-unread-text">
                            {{ $visibleNotifications->count() }} Unread
                        </span>

                    </div>

                    <div class="dropdown-divider"></div>

                    <ul class="list-unstyled mb-0" id="header-notification-scroll">
                        @forelse($visibleNotifications as $notify)
                            <li class="dropdown-item">
                                <div class="d-flex align-items-start">

                                    <div class="pe-2">
                                        <span class="avatar avatar-md bg-primary-transparent rounded-2">
                                            <i class="bx bx-package fs-18"></i>
                                        </span>
                                    </div>

                                    <div class="flex-grow-1 d-flex justify-content-between">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0 fw-semibold">
                                                    {{ $notify->type }}
                                                </p>
                                                <p class="mb-0 text-muted fs-11">
                                                    {{ $notify->created_at->diffForHumans() }}
                                                </p>
                                            </div>

                                            <span class="fs-12 text-muted">
                                                {{ $notify->description }}
                                            </span>

                                            <div class="fs-11 text-muted">
                                                Submitted by :- {{ full_name($notify->submit_by) }}
                                            </div>
                                        </div>

                                        <div class="min-w-fit-content ms-2 text-end">
                                            <a href="javascript:void(0);" class="text-muted me-1 close-notification"
                                                data-id="{{ $notify->n_id }}">
                                                <i class="ti ti-x fs-14"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        @empty
                            <li class="dropdown-item text-center text-muted">
                                No New Notifications
                            </li>
                        @endforelse
                    </ul>


                    @if ($isSuperAdmin && $visibleNotifications->count() > 0)
                        <div class="p-3 border-top">
                            <div class="d-grid">
                                <button class="btn btn-primary" id="openNotificationModal">
                                    View All
                                </button>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- End::main-header-dropdown -->
            </div>
            <!-- End::header-element -->
            {{-- <div class="header-element d-flex header-settings header-shortcuts-dropdown">
                <a aria-label="anchor" href="javascript:void(0);" class=" header-link nav-link icon"
                    data-bs-toggle="offcanvas" data-bs-target="#apps" aria-controls="apps">
                    <i class="bx bx-category  header-link-icon"></i>
                </a>
            </div> --}}


            <div class="offcanvas offcanvas-end wd-330" tabindex="-1" id="apps" aria-labelledby="appsLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 id="appsLabel" class="mb-0 fs-18">Related Apps</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"> <i class="bx bx-x   apps-btn-close"></i></button>
                </div>
                <div class="p-3">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="full-calendar.html">
                                <div class="text-center p-3 related-app border">
                                    <span class="avatar fs-23 bg-success-transparent p-2 mb-2">
                                        <i class="bx bx-calendar text-success"></i>
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-semibold">Calendar</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="mail.html">
                                <div class="text-center p-3 related-app border">
                                    <span class="avatar  fs-23 bg-info-transparent p-2 mb-2">
                                        <i class="bx bx-envelope  text-info"></i>
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-semibold">Mail</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="profile.html">
                                <div class="text-center p-3 related-app border">
                                    <span class="avatar bg-warning-transparent fs-23 bg p-2 mb-2">
                                        <i class="bx bx-user  text-warning"></i>
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-semibold">Profile</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="chat.html">
                                <div class="text-center p-3 related-app border">
                                    <span class="avatar    bg-pink-transparent fs-23 bg p-2 mb-2">
                                        <i class="bx bx-chat text-pink"></i>
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-semibold">Chat</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="contacts.html">
                                <div class="text-center p-3 related-app border">
                                    <span class="avatar    bg-secondary-transparent fs-23 bg p-2 mb-2">
                                        <i class="bx bx-phone text-secondary"></i>
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-semibold">Contacts</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="mail-settings.html">
                                <div class="text-center p-3 related-app border">
                                    <span class="avatar    bg-teal-transparent fs-23 bg p-2 mb-2">
                                        <i class="bx bx-cog text-teal"></i>
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-semibold">Settings</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start::header-element -->

            <!-- Start::header-element -->
            <div class="header-element header-fullscreen">
                <!-- Start::header-link -->
                <a aria-label="anchor" onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                    <i class="bx bx-fullscreen header-link-icon  full-screen-open"></i>
                    <i class="bx bx-exit-fullscreen header-link-icon  full-screen-close  d-none"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            {{-- <div class="header-element d-flex header-settings">
                <a aria-label="anchor" href="javascript:void(0);" class=" header-link nav-link icon me-1" data-bs-toggle="offcanvas" data-bs-target="#sidebar-right" aria-controls="sidebar-right">
                    <i class="bx bx-slider header-link-icon"></i>
                </a>
            </div> --}}
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element mainuserProfile">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="d-sm-flex wd-100p">
                            <div class="avatar avatar-sm"><img alt="avatar" class="rounded-circle"
                                    src="{{ profile_pic()
                                        ? $actual_url . '/admin_assets/profile/' . profile_pic()
                                        : $actual_url . '/admin_assets/images/faces/1.jpg' }}">
                            </div>
                            <div class="ms-2 my-auto d-none d-xl-flex">
                                <h6 class=" font-weight-semibold mb-0 fs-13 user-name d-sm-block d-none"><span
                                        class="fw-semibold">{{ ucwords(loggedUserName()) }}
                                    </span></h6>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="dropdown-menu  border-0 main-header-dropdown  overflow-hidden header-profile-dropdown"
                    aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item" href="{{ route('profile.users') }}"><i
                                class="fs-13 me-2 bx bx-user"></i>Profile</a></li>
                    <li><a class="dropdown-item d-none" href="mail.html"><i
                                class="fs-13 me-2 bx bx-comment"></i>Message</a>
                    </li>
                    {{-- <li><a class="dropdown-item" href="mail-settings.html"><i
                                class="fs-13 me-2 bx bx-cog"></i>Settings</a></li>
                    <li><a class="dropdown-item" href="faq's.html"><i
                                class="fs-13 me-2 bx bx-help-circle"></i>Help</a></li> --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="fs-13 me-2 bx bx-arrow-to-right"></i> Log Out
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|switcher-icon -->
                <a aria-label="anchor" href="javascript:void(0);" class="header-link switcher-icon ms-1"
                    data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                    <i class="bx bx-cog bx-spin header-link-icon"></i>
                </a>
                <!-- End::header-link|switcher-icon -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-right -->

    </div>


    <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">

                <!-- Modal Header -->
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-semibold">
                        Unread Notifications
                    </h5>

                    <div class="d-flex align-items-center gap-2">
                        <form method="POST" action="#">
                            @csrf
                            {{-- <button type="submit" class="btn btn-sm btn-success">
                                Read All
                            </button> --}}
                        </form>

                        <!-- Close button -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-3" id="notification-modal-body">
                    @forelse($notifications as $notify)
                        <div class="pb-3 mb-3 border-bottom modal-notification-item" data-id="{{ $notify->n_id }}">

                            <div class="d-flex justify-content-between align-items-start">
                                <strong class="fs-14">
                                    {{ $notify->type }}
                                </strong>
                                <small class="text-muted fs-11">
                                    {{ $notify->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <p class="mb-1 text-muted fs-13">
                                {{ $notify->description }}
                            </p>

                            <small class="text-muted fs-12">
                                Submitted by {{ full_name($notify->submit_by) }}
                            </small>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5" id="modal-empty-text">
                            No unread notifications
                        </div>
                    @endforelse
                </div>


                <!-- Modal Footer -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!-- End::main-header-container -->

</header>
<div id="loader">
    <img src="{{ $actual_url . '/admin_assets/images/media/loader.svg' }}" alt="">
</div>

{{-- script for search functionality --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("typehead");

        searchInput.addEventListener("keyup", function() {
            const keyword = this.value.toLowerCase().trim();

            // Get all search items (both headers and submenus)
            const searchItems = document.querySelectorAll(".search-header, .search-sub-item");

            if (keyword === "") {
                // If search is empty, show all items
                searchItems.forEach(item => {
                    item.style.display = "";
                    item.classList.remove("d-none");
                });
                return;
            }

            // First, hide all items
            searchItems.forEach(item => {
                item.style.display = "none";
                item.classList.add("d-none");
            });

            // Find matching submenus
            const matchingSubItems = Array.from(document.querySelectorAll(".search-sub-item")).filter(
                sub => {
                    return sub.innerText.toLowerCase().includes(keyword);
                });

            // For each matching submenu, show its parent header and itself
            matchingSubItems.forEach(matchingSub => {
                const parentId = matchingSub.getAttribute("data-parent-id");

                // Show the matching submenu
                matchingSub.style.display = "";
                matchingSub.classList.remove("d-none");

                // Show its specific parent header
                const parentHeader = document.querySelector(
                    `.search-header[data-menu-id="${parentId}"]`);
                if (parentHeader) {
                    parentHeader.style.display = "";
                    parentHeader.classList.remove("d-none");
                }
            });
        });
    });

    // Calculator Logic

    document.addEventListener("DOMContentLoaded", function() {
        // --- Calculator Drag Logic ---
        const calcMenu = document.querySelector('.header-calculator .dropdown-menu');
        const calcHeader = document.querySelector('.header-calculator .calc-header');

        let isDown = false;
        let startX, startY, initialTransformX = 0,
            initialTransformY = 0;

        if (calcHeader && calcMenu) {

            // Unified Start Handler
            function handleDragStart(e) {
                // Check if it's touch or mouse
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;

                isDown = true;
                calcHeader.style.cursor = 'grabbing';

                startX = clientX;
                startY = clientY;

                const style = window.getComputedStyle(calcMenu);
                const matrix = new WebKitCSSMatrix(style.transform);
                initialTransformX = matrix.m41;
                initialTransformY = matrix.m42;

                // Prevent scroll on touch, prevent text select on mouse
                if (e.cancelable && e.type === 'touchstart') {
                    // e.preventDefault(); // Optional: Uncomment if dragging feels sticky on mobile
                } else {
                    e.preventDefault();
                }
            }

            // Unified Move Handler
            function handleDragMove(e) {
                if (!isDown) return;

                // Prevent scrolling while dragging on mobile
                if (e.cancelable) e.preventDefault();

                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;

                const dx = clientX - startX;
                const dy = clientY - startY;

                calcMenu.style.transform =
                    `translate3d(${initialTransformX + dx}px, ${initialTransformY + dy}px, 0px)`;
            }

            // Unified End Handler
            function handleDragEnd() {
                if (isDown) {
                    isDown = false;
                    calcHeader.style.cursor = 'move';
                }
            }

            // --- Event Listeners (Mouse) ---
            calcHeader.addEventListener('mousedown', handleDragStart);
            document.addEventListener('mousemove', handleDragMove);
            document.addEventListener('mouseup', handleDragEnd);

            // --- Event Listeners (Touch) ---
            calcHeader.addEventListener('touchstart', handleDragStart, {
                passive: false
            });
            document.addEventListener('touchmove', handleDragMove, {
                passive: false
            });
            document.addEventListener('touchend', handleDragEnd);

            // Prevent closing when clicking inside
            calcMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Allow touch on buttons inside calc to work (prevent drag from stealing click)
            calcMenu.addEventListener('touchstart', function(e) {
                e.stopPropagation();
            }, {
                passive: true
            });
        }
    });
    let calcDisplay = document.getElementById('calc-display');
    let currentExpression = '';

    function updateDisplay(value) {
        if (!calcDisplay) calcDisplay = document.getElementById('calc-display');
        calcDisplay.value = value;
    }

    function calcAppend(val) {
        if (currentExpression === '' && ['+', '*', '/'].includes(val)) return;
        currentExpression += val;
        updateDisplay(currentExpression);
    }

    function calcClear() {
        currentExpression = '';
        updateDisplay('0');
    }

    function calcBackspace() {
        currentExpression = currentExpression.slice(0, -1);
        updateDisplay(currentExpression || '0');
    }

    function calcResult() {
        try {
            // Safely evaluate the math expression
            if (currentExpression) {
                let result = Function('"use strict";return (' + currentExpression + ')')();
                // Format decimal places if necessary
                if (!Number.isInteger(result)) {
                    result = result.toFixed(2);
                }
                currentExpression = result.toString();
                updateDisplay(currentExpression);
            }
        } catch (e) {
            updateDisplay('Error');
            setTimeout(calcClear, 1000);
        }
    }
</script>
<script>
    document.getElementById('openNotificationModal').addEventListener('click', function() {

        // Close notification dropdown
        const dropdownToggle = document.getElementById('messageDropdown');
        const dropdownInstance = bootstrap.Dropdown.getInstance(dropdownToggle);
        if (dropdownInstance) {
            dropdownInstance.hide();
        }

        // Open modal manually
        const modalEl = document.getElementById('notificationModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Observe DOM for backdrop creation
        const observer = new MutationObserver(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                // 🔥 FORCE override (this beats CSS)
                backdrop.style.setProperty('--bs-backdrop-zindex', '0');
                backdrop.style.opacity = 'var(--bs-backdrop-opacity)';
                observer.disconnect();
            }
        });

        observer.observe(document.body, {
            childList: true
        });

        // Restore when modal closes
        modalEl.addEventListener('hidden.bs.modal', () => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.style.setProperty('--bs-backdrop-zindex', '1050');
                backdrop.style.removeProperty('opacity');
            }
        }, {
            once: true
        });

    });
</script>
<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.close-notification');
        if (!btn) return;

        const notificationId = btn.dataset.id;

        fetch("{{ route('notification.markRead') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: notificationId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;

                /* ----------------------------
                   1. Remove from dropdown
                ----------------------------- */
                btn.closest('li.dropdown-item')?.remove();

                /* ----------------------------
                   2. Remove from modal
                ----------------------------- */
                const modalItem = document.querySelector(
                    `.modal-notification-item[data-id="${notificationId}"]`
                );
                if (modalItem) {
                    modalItem.remove();
                }

                /* ----------------------------
                   3. Update unread count
                ----------------------------- */
                const bellBadge = document.getElementById('notification-icon-badge');
                const unreadText = document.getElementById('notification-unread-text');

                let count = parseInt(bellBadge?.innerText || 0);
                count = Math.max(count - 1, 0);

                if (bellBadge) bellBadge.innerText = count;
                if (unreadText) unreadText.innerText = `${count} Unread`;

                /* ----------------------------
                   4. Handle empty state
                ----------------------------- */
                const dropdownList = document.getElementById('header-notification-scroll');
                const modalBody = document.getElementById('notification-modal-body');

                if (count === 0) {

                    // Dropdown empty state
                    if (dropdownList) {
                        dropdownList.innerHTML = `
                    <li class="dropdown-item text-center text-muted">
                        No New Notifications
                    </li>
                `;
                    }

                    // Modal empty state
                    if (modalBody) {
                        modalBody.innerHTML = `
                    <div class="text-center text-muted py-5">
                        No unread notifications
                    </div>
                `;
                    }

                    // Hide View All button
                    document.getElementById('openNotificationModal')
                        ?.closest('.p-3')?.remove();

                    // Hide badges
                    bellBadge && (bellBadge.style.display = 'none');
                    unreadText && (unreadText.style.display = 'none');
                }
            })
            .catch(err => console.error(err));
    });
</script>
