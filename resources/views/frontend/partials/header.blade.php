<?php
use Illuminate\Support\Str;
use App\Models\BrandModel;
use App\Models\UserModel;
use App\Models\CatalogueModel;

// Fetch distinct brands not deleted
$userId = session('user_id');
$brands = BrandModel::where('status', 0)->select('brand_id', 'brand_name')->distinct()->get();

$cust_data = UserModel::where('user_id', $userId)->first();

$catalogue = CatalogueModel::where('status', 0)->latest()->first();
?>

<style>
    /* Add in your style section */

    .floating-whatsapp {
        position: fixed;
        right: 22px;
        bottom: 22px;
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #39b54a;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .18);
        transition: all .25s ease;
    }


    .floating-whatsapp:hover {
        transform: translateY(-3px) scale(1.05);
    }

    @media(max-width:768px) {
        .floating-whatsapp {
            width: 52px;
            height: 52px;
            right: 15px;
            bottom: 15px;
        }

        .floating-whatsapp img {
            width: 26px;
            height: 26px;
        }
    }
</style>

<style>
    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 380px;
        height: 100%;
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /* Left Side */
    .modal.left.fade .modal-dialog {
        left: -380px;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.show .modal-dialog {
        left: 0;
    }

    /* Right Side */
    .modal.right.fade .modal-dialog {
        right: -380px;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.show .modal-dialog {
        right: 0;
    }

    /* Modal Style */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    .modal-header {
        border-bottom-color: #eee;
        background-color: #f9f9f9;
    }

    #cart-count {
        font-size: 1rem;
        padding: 0.5rem 1rem;

    }

    .cart-count-icon {
        background: transparent !important;
        border: none;
    }


    .cart-count {
        background: #000 !important;
        border: none;
    }



    .cart-count:hover {
        background: #5b5b5b !important;
    }

    .checkout-btn {
        border: none;
        background: #5b5b5b !important;
    }

    .checkout-btn:hover {
        background: #000 !important;
    }

    #cart-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }


    .sidecartButton,
    .sidecartButton:hover,
    .sidecartButton:focus,
    .sidecartButton:active {
        background: transparent !important;
        border: none !important;
        color: inherit !important;
        box-shadow: none !important;
        transition: none !important;
        margin-top: 5px;
    }

    @media (max-width: 991px) {
        .header-logo.mobile {
            position: static !important;
            transform: none !important;
            left: auto !important;
            margin-right: auto;
            line-height: 0;
            display: flex !important;
            align-items: center;
        }

        .header-logo.mobile img {
            height: 34px;
            width: auto;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    }
</style>

<style>
    /* ─── RESET & BASE ─────────────────────────────────────────── */
    #site-header * {
        box-sizing: border-box;
    }

    #site-header {
        width: 100%;
        border-bottom: 1px solid #e0e0e0;
        background: #fff;
        /* position: sticky; */
        top: 0;
        z-index: 1000;
    }

    /* ─── ROW 1: TOP BAR ────────────────────────────────────────── */
    .header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 40px;
        border-bottom: 1px solid #e8e8e8;
    }

    /* Left: WhatsApp contact */
    .header-top-left {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #111;
        font-family: 'Montserrat', sans-serif;


        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .header-top-left:hover {
        color: #555;
    }

    .header-top-left svg {
        flex-shrink: 0;
    }

    /* Center: Logo */
    .header-logo {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        line-height: 0;
    }

    .header-logo img {
        height: 52px;
        width: auto;
        object-fit: contain;
    }

    /* Right: Icon group */
    .header-top-right {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-left: auto;
    }

    .icon-btn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 40px !important;
        height: 40px !important;
        background: none !important;
        border: none !important;
        cursor: pointer !important;
        ;
        color: #111 !important;
        text-decoration: none !important;
        position: relative !important;
        transition: color 0.2s !important;
    }

    .icon-btn:hover {
        color: #555;
    }

    .icon-btn svg {
        display: block;
    }



    /* User avatar */
    .avatar-img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        border: 1.5px solid #ddd;
    }

    /* ─── ROW 2: NAV BAR ─────────────────────────────────────────── */
    .header-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 60px;
        padding: 0 40px;
        height: 46px;
        color: #000000;
    }

    .nav-link-item {
        font-family: 'Montserrat', sans-serif;
        font-size: 17px;
        /*font-weight: 500; */
        /*letter-spacing: 0.1em;*/
        /*color: #111;*/
        text-decoration: none;
        white-space: nowrap;
        position: relative;
        padding-bottom: 2px;
        transition: color 0.2s;
    }

    /*.nav-link-item::after {*/
    /*    content: '';*/
    /*    position: absolute;*/
    /*    bottom: -2px;*/
    /*    left: 0;*/
    /*    right: 0;*/
    /*    height: 1px;*/
    /*    background: #111;*/
    /*    transform: scaleX(0);*/
    /*    transition: transform 0.2s ease;*/
    /*}*/

    .nav-link-item:hover {
        color: #333;
    }

    .nav-link-item:hover::after {
        transform: scaleX(1);
    }

    /* BRANDS mega menu trigger */
    .nav-brands {
        position: relative;
    }

    .nav-brands .nav-link-item {
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
    }

    /* ─── MEGA MENU ──────────────────────────────────────────────── */
    .dropdown-mega-menu {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translateX(-50%);
        min-width: 280px;
        /* minimum width on desktop */
        max-width: 90vw;
        background: #ffffffdb;
        border: 1px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        display: none;
        padding: 20px;
        z-index: 9999;
        white-space: normal;
        box-sizing: border-box;
    }


    .nav-brands:hover .dropdown-mega-menu {
        display: block;
    }

    .mega-menu-columns {
        display: flex;
        gap: 30px;
        justify-content: space-between;
        flex-wrap: nowrap;
    }

    .mega-menu-column {
        list-style: none;
        padding: 0;
        margin: 0;
        flex: 1;
    }

    .mega-menu-column li {
        margin-bottom: 4px;
    }

    .mega-menu-column li a {
        color: #111;
        text-decoration: none;
        text-transform: uppercase;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        font-weight: 400;
        letter-spacing: 0.06em;
        display: block;
        padding: 4px 0;
        transition: color 0.15s;
    }

    .mega-menu-column li a:hover {
        color: #555;
    }

    @media (min-width: 992px) {
        .filter-brand:hover .dropdown-mega-menu {
            display: block;
        }

        .dropdown-mega-menu {

            min-width: 900px;
            /* minimum width on desktop */

        }
    }

    /* ─── MOBILE HAMBURGER ───────────────────────────────────────── */
    .hamburger-btn {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        flex-direction: column;
        gap: 5px;
        align-items: center;
        justify-content: center;
    }

    .hamburger-btn span {
        display: block;
        width: 22px;
        height: 1.5px;
        background: #111;
        transition: all 0.3s;
    }

    /* Mobile drawer */
    .mobile-drawer {
        display: none;
        flex-direction: column;
        padding: 16px 20px 24px;
        border-top: 1px solid #eee;
        gap: 0;
    }

    .mobile-drawer.open {
        display: flex;
    }

    .mobile-nav-link {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #111;
        text-decoration: none;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Mobile brands accordion */
    .mobile-brands-toggle {
        cursor: pointer;
        user-select: none;
    }

    .mobile-brands-list {
        display: none;
        flex-direction: column;
        gap: 0;
        overflow-y: auto;
        max-height: 220px;
        padding: 8px 0 6px 12px;
        border-left: 1px solid #eee;
        /* margin-left: 6px; */
    }

    .mobile-brands-list.open {
        display: flex;
    }

    .mobile-brands-list a {
        display: block;
        width: 100%;
        padding: 8px 0;
        font-family: 'Montserrat', sans-serif;
        font-size: 11px;
        font-weight: 500;
        color: #444;
        text-decoration: none;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f3f3f3;
        text-transform: uppercase;
    }

    .mobile-brands-list a:last-child {
        border-bottom: none;
    }

    .mobile-brands-list a:hover {
        color: #111;
    }

    /* ─── RESPONSIVE ─────────────────────────────────────────────── */
    @media (max-width: 991px) {
        .header-top {
            padding: 12px 20px;
        }

        .header-logo img {
            height: 44px;
        }

        .header-nav {
            display: none;
        }

        .hamburger-btn {
            display: flex;
        }

        .header-top-right .icon-desktop-only {
            display: none;
        }

        .dropdown-mega-menu {
            display: none !important;
        }
    }

    @media (max-width: 480px) {
        .header-top {
            padding: 10px 16px;
        }

        .header-logo img {
            height: 38px;
        }
    }

    .cart-btn-custom {
        padding: 6px 8px !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    .cart-btn-custom .cart-badge {
        top: -4px !important;
        left: 22px !important;
        transform: none !important;
        min-width: 16px;
        height: 16px;
        font-size: 9px;

        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .nav-brands .nav-link-item::after {
        display: inline-block;
        margin-left: 6px;
        vertical-align: middle;
        content: "";
        border-top: 5px solid #000;
        border-right: 5px solid transparent;
        border-left: 5px solid transparent;
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     HEADER
════════════════════════════════════════════════════════════ -->
<header id="site-header">

    <!-- ── ROW 1: TOP BAR ── -->
    <div class="header-top" style="position: relative;">

        <!-- Left: WhatsApp -->
        <a href="{{ route('contact') }}" class="desktop header-top-left" rel="noopener">
            <!-- WhatsApp icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                <path id="np_contact_3106476_000000"
                    d="M7.767,18.253l0,0,.013.014h0A9.51,9.51,0,0,0,14.3,21a6.9,6.9,0,0,0,2.512-.449.887.887,0,0,0,.558-.825V18.559a1.178,1.178,0,0,0-.574-1.008l-2.1-1.244a.737.737,0,0,0-1.006.244l-.87,1.393c-.067.106-.226.069-.257.06a6.2,6.2,0,0,1-2.833-1.744,6.2,6.2,0,0,1-1.744-2.832c-.008-.031-.046-.19.06-.257l.772-.483.62-.387h0a.737.737,0,0,0,.244-1.007L8.446,9.2A1.178,1.178,0,0,0,7.44,8.626H6.273a.887.887,0,0,0-.824.558c-1.094,2.8-.136,6.592,2.278,9.029ZM6.045,9.415a.244.244,0,0,1,.228-.15H7.44a.536.536,0,0,1,.458.26L9.14,11.62a.1.1,0,0,1-.032.139l-.619.387-.774.483a.844.844,0,0,0-.338.968,6.9,6.9,0,0,0,1.91,3.116,6.9,6.9,0,0,0,3.116,1.91h0a.845.845,0,0,0,.968-.338l.871-1.394a.1.1,0,0,1,.137-.032l2.1,1.243a.535.535,0,0,1,.261.458v1.167h0a.243.243,0,0,1-.151.228c-2.578,1.008-6.09.106-8.355-2.145l-.022-.023-.027-.026c-2.242-2.265-3.14-5.77-2.134-8.345ZM20.679,5H12.113a.319.319,0,0,0-.319.32v6.4h0a.319.319,0,0,0,.319.32h.43l-.724,1.724a.32.32,0,0,0,.447.406l3.956-2.13h4.458a.32.32,0,0,0,.32-.32V5.32a.32.32,0,0,0-.32-.32Zm-.319,6.4H16.14a.32.32,0,0,0-.151.038l-3.23,1.739.56-1.333h0a.32.32,0,0,0-.3-.444h-.592V5.639H20.36ZM18.866,7.861h-4.94v-.64h4.94Zm0,1.955h-4.94v-.64h4.94Z"
                    transform="translate(-4.999 -5)"></path>
            </svg>
            CONTACT US
        </a>

        <!-- Center: Logo (absolute) -->
        <div class="header-logo desktop">
            <a href="{{ route('home') }}">
                <img src="{{ $actual_url . '/front/img/logo.png' }}" alt="Jay's Watch Store">
            </a>
        </div>

        <div class="header-logo mobile">
            <a href="{{ route('home') }}">
                <img src="{{ $actual_url . '/front/img/logo.png' }}" alt="Jay's Watch Store">
            </a>
        </div>


        <!-- Right: Icons -->
        <div class="header-top-right">
            <!-- Search -->
            <button class="icon-btn" data-bs-toggle="modal" data-bs-target="#productSearch" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </button>

            <!-- Wishlist -->
            <a href="{{ route('customerprofile', ['tab' => 'panel-wishlist']) }}" class="icon-btn"
                aria-label="Wishlist">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                </svg>
            </a>

            <!-- Cart -->
            <button class="btn btn-outline-secondary position-relative cart-count-icon sidecartButton cart-btn-custom">
                <i class="fa fa-shopping-cart fa-lg"></i>
                <span
                    class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                </span>
            </button>

            <!-- User / Avatar -->
            <a href="{{ route(session('user_fullname') ? 'customerprofile' : 'custlogin-page') }}" class="icon-btn"
                aria-label="{{ session('user_fullname') ? 'Profile' : 'Login' }}">

                <img src="{{ session('user_fullname')
                    ? ($cust_data?->profile_pic
                        ? $actual_url . '/front/uploads/customer_profile/' . $cust_data->profile_pic
                        : $actual_url . '/front/user-icon.jpg')
                    : $actual_url . '/front/user-icon.jpg' }}"
                    alt="{{ session('user_fullname') ? 'Profile' : 'Login' }}" class="avatar-img">
            </a>

            @if (!empty($catalogue) && !empty($catalogue->file))
                <a href="{{ $actual_url . '/admin_assets/catalogue/' . $catalogue->file }}" target="_blank"
                    class="nav-link-item desktop d-none">
                      CATALOGUE
                </a>
            @endif




            <!-- Hamburger (mobile only) -->
            <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <!-- ── ROW 2: DESKTOP NAV ── -->
    <nav class="header-nav" aria-label="Main navigation">
        <a href="{{ route('product') }}" class="nav-link-item">ALL WATCHES</a>
        <a href="{{ route('arrivals') }}" class="nav-link-item">NEW ARRIVALS</a>

        <!-- Brands mega menu -->
        <div class="nav-brands">
            <span class="nav-link-item">
                BRANDS
                <!--<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"-->
                <!--    stroke-width="2.5" stroke-linecap="round">-->
                <!--    <polyline points="6 9 12 15 18 9" />-->
                <!--</svg>-->
            </span>
            <div class="dropdown-mega-menu">
                <div class="mega-menu-columns">
                    @php
                        $columns = 4;
                        $uniqueBrands = $brands->unique('brand_name')->values();
                        $chunkedBrands = $uniqueBrands->chunk(ceil($uniqueBrands->count() / $columns));
                    @endphp
                    @foreach ($chunkedBrands as $chunk)
                        <ul class="mega-menu-column">
                            @foreach ($chunk as $brand)
                                <li>
                                    <a
                                        href="{{ url('preowned-' . preg_replace('/[^A-Za-z0-9\.\-]/', '-', strtolower($brand->brand_name))) }}">
                                        {{ $brand->brand_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>

        <a href="{{ route('sell') }}" class="nav-link-item">SELL</a>
        <a href="{{ route('trade') }}" class="nav-link-item">TRADE</a>
        <a href="{{ route('store') }}" class="nav-link-item">OUR STORE</a>

    </nav>

    <!-- ── MOBILE DRAWER ── -->
    <div class="mobile-drawer" id="mobileDrawer">
        <a href="{{ route('product') }}" class="mobile-nav-link">ALL WATCHES</a>
        <a href="{{ route('arrivals') }}" class="mobile-nav-link">NEW ARRIVALS</a>

        <div class="mobile-nav-link mobile-brands-toggle" id="mobileBrandsToggle">
            BRANDS
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" id="brandsChevron">
                <polyline points="6 9 12 15 18 9" />
            </svg>
        </div>
        <div class="mobile-brands-list" id="mobileBrandsList">
            @php $allBrands = $brands->unique('brand_name')->values(); @endphp
            @foreach ($allBrands as $brand)
                <a
                    href="{{ url('preowned-' . preg_replace('/[^A-Za-z0-9\.\-]/', '-', strtolower($brand->brand_name))) }}">
                    {{ $brand->brand_name }}
                </a>
            @endforeach
        </div>

        <a href="{{ route('sell') }}" class="mobile-nav-link">SELL</a>
        <a href="{{ route('trade') }}" class="mobile-nav-link">TRADE</a>
        <a href="{{ route('contact') }}" class="mobile-nav-link">CONTACT US</a>
        <a href="{{ route('store') }}" class="mobile-nav-link">OUR STORE</a>
        @if (!empty($catalogue) && !empty($catalogue->file))
            <a href="{{ $actual_url . '/admin_assets/catalogue/' . $catalogue->file }}" target="_blank"
                class="mobile-nav-link d-none">
                CATALOGUE
            </a>
        @endif
    </div>

</header>


<!-- ══════════════════════════════════════════
     CART MODAL (slide-in from right)
══════════════════════════════════════════ -->


<div class="modal right fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="cartModalLabel">Your Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Example Product -->

                <hr>
                <div class="fw-bold text-end me-2"></div>
            </div>

            <div class="modal-footer d-flex flex-column gap-2">
                <button class="btn btn-primary w-100 cart-count View_Cart">View Cart</button>
                @if (session('user_id'))
                    <button class="btn btn-success w-100 checkout-btn" id="modal-checkout-btn">Checkout</button>
                @else
                    <button class="btn btn-success w-100 checkout-btn" id="login-btn">Checkout</button>
                @endif
            </div>

        </div>
    </div>
</div>



<!-- ══════════════════════════════════════════
     SEARCH MODAL
══════════════════════════════════════════ -->
<div class="search-dialog">
    <div class="modal fade" id="productSearch" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Search Input -->
                    <div class="input-group">
                        <input type="text" class="form-control border-black" id="searchInputMain"
                            placeholder="Search by brand or model name..." aria-label="Search"
                            style="border: 1px solid #9e9e9e85 !important;">
                        <button class="btn btn-black" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <!-- Results Container -->
                    <div id="searchResults" style="max-height: 400px; overflow-y: auto;"></div>

                </div>
            </div>
        </div>
    </div>
</div>



<!-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ── Hamburger toggle ──
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileDrawer = document.getElementById('mobileDrawer');

        hamburgerBtn.addEventListener('click', function() {
            mobileDrawer.classList.toggle('open');
        });

        // ── Mobile brands accordion ──
        const mobileBrandsToggle = document.getElementById('mobileBrandsToggle');
        const mobileBrandsList = document.getElementById('mobileBrandsList');
        const brandsChevron = document.getElementById('brandsChevron');

        mobileBrandsToggle.addEventListener('click', function() {
            mobileBrandsList.classList.toggle('open');
            brandsChevron.style.transform = mobileBrandsList.classList.contains('open') ?
                'rotate(180deg)' : 'rotate(0deg)';
        });

        // ── Checkout / login redirect ──
        const loginBtn = document.getElementById('login-btn');
        if (loginBtn) {
            loginBtn.addEventListener('click', function() {
                window.location.href = "{{ route('custlogin-page') }}";
            });
        }

    });
</script>
