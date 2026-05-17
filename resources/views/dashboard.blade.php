<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    .date-range-select {
        min-width: 230px;
    }

    tspan {
        font-size: 87% !important;
    }

    .custom-input {
        height: 38px;
        font-size: 13px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
    }

    .custom-input:focus {
        border-color: #3b82f6;
        box-shadow: none;
    }

    .pdf-mode {
        background: #fff !important;
        padding: 20px;
    }

    .pdf-mode .card {
        page-break-inside: avoid;
        break-inside: avoid;
    }

    .pdf-mode img {
        max-width: 100%;
        height: auto;
    }
</style>

<style>
    /* Custom styles to clean up Bootstrap defaults */
    .custom-input:focus,
    .form-select:focus,
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }

    /* Better dropdown items */
    .dropdown-item {
        border-radius: 8px;
        transition: all 0.15s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item:active {
        background-color: #e9ecef;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .card-header {
            padding: 1rem !important;
        }

        .dropdown-menu {
            min-width: 200px !important;
        }
    }

    /* Remove spin buttons from number inputs */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>


<style>
    /* ===== Dashboard Stat Cards ===== */
    .stat-card {
        border: none;
        border-radius: 14px;
        transition: all 0.35s ease;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    /* soft gradient border */
    .stat-card::before {
        content: "";
        position: absolute;
        inset: 0;
        padding: 1px;
        border-radius: 14px;
        /* background: linear-gradient(120deg, #f1f3f7, #e9ecf3); */
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
    }

    /* Hover */
    .stat-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    /* Icon */
    .stat-card .icon {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: 0.3s;
    }

    .stat-card:hover .icon {
        transform: scale(1.1) rotate(5deg);
    }

    /* Text */
    .stat-card h5 {
        font-size: 20px;
        color: #86b7fe;
        letter-spacing: .3px;
    }

    .stat-card p {
        font-size: 13px;
        font-weight: 500;
    }

    .stat-card span {
        font-size: 12px;
    }

    /* Badge */
    .stat-sub {
        background: rgba(255, 255, 255, 0.25);
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
        margin-top: 4px;
    }

    /* ===== GRADIENT BACKGROUNDS ===== */

    /* ===== THEME HARMONY GRADIENTS ===== */

    .card-bg-1 {
        background: linear-gradient(135deg, #2A2E72, #5A5FCF);
        color: #fff;
    }

    .card-bg-2 {
        background: linear-gradient(135deg, #1E2161, #3A3F9B);
        color: #fff;
    }

    .card-bg-3 {
        background: linear-gradient(135deg, #2A2E72, #3F8EFC);
        color: #fff;
    }

    .card-bg-4 {
        background: linear-gradient(135deg, #2A2E72, #E06C75);
        /* muted warning */
        color: #fff;
    }

    .card-bg-5 {
        background: linear-gradient(135deg, #24306F, #1FA2A6);
        color: #fff;
    }

    .card-bg-6 {
        background: linear-gradient(135deg, #2A2E72, #4C6FFF);
        color: #fff;
    }


    /* text harmony */
    [class^="card-bg-"] p,
    [class^="card-bg-"] span {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    [class^="card-bg-"] h5 {
        color: #fff;
    }

    /* soft glass icon */
    [class^="card-bg-"] .icon {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }
</style>
<style>
    /* Hide elements only during PDF creation */
    .pdf-mode .no-pdf {
        display: none !important;
    }
</style>

<body>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="border-bottom border-block-end-dashed">
                <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                    <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-home" type="button" role="tab" aria-controls="switcher-home"
                        aria-selected="true">Theme Styles</button>
                    <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-profile" type="button" role="tab"
                        aria-controls="switcher-profile" aria-selected="false">Theme Colors</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel"
                    aria-labelledby="switcher-home-tab" tabindex="0">
                    <div class="">
                        <p class="switcher-style-head">Theme Color Mode:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-light-theme">
                                        Light
                                    </label>
                                    <input class="form-check-input" type="radio" name="theme-style"
                                        id="switcher-light-theme" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-dark-theme">
                                        Dark
                                    </label>
                                    <input class="form-check-input" type="radio" name="theme-style"
                                        id="switcher-dark-theme">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="">
                        <p class="switcher-style-head">Directions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-ltr">
                                        LTR
                                    </label>
                                    <input class="form-check-input" type="radio" name="direction" id="switcher-ltr"
                                        checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-rtl">
                                        RTL
                                    </label>
                                    <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="">
                        <p class="switcher-style-head">Navigation Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-vertical">
                                        Vertical
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-style"
                                        id="switcher-vertical" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-horizontal">
                                        Horizontal
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-style"
                                        id="switcher-horizontal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="navigation-menu-styles">
                        <p class="switcher-style-head">Vertical &amp; Horizontal Menu Styles:</p>
                        <div class="row switcher-style gx-0  gy-2">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-click">
                                        Menu Click
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-menu-click">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-hover">
                                        Menu Hover
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-menu-hover">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-click">
                                        Icon Click
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-icon-click">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-hover">
                                        Icon Hover
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-icon-hover">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidemenu-layout-styles">
                        <p class="switcher-style-head">Sidemenu Layout Styles:</p>
                        <div class="row switcher-style gx-0  gy-2">
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-default-menu">
                                        Default Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-default-menu" checked>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-closed-menu">
                                        Closed Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-closed-menu">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icontext-menu">
                                        Icon Text
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-icontext-menu">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-overlay">
                                        Icon Overlay
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-icon-overlay">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-detached">
                                        Detached
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-detached">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-double-menu">
                                        Double Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-double-menu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Page Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-regular">
                                        Regular
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-styles"
                                        id="switcher-regular" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-classic">
                                        Classic
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-styles"
                                        id="switcher-classic">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Layout Width Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-full-width">
                                        Full Width
                                    </label>
                                    <input class="form-check-input" type="radio" name="layout-width"
                                        id="switcher-full-width" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-boxed">
                                        Boxed
                                    </label>
                                    <input class="form-check-input" type="radio" name="layout-width"
                                        id="switcher-boxed">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Menu Positions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-fixed">
                                        Fixed
                                    </label>
                                    <input class="form-check-input" type="radio" name="menu-positions"
                                        id="switcher-menu-fixed" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-scroll">
                                        Scrollable
                                    </label>
                                    <input class="form-check-input" type="radio" name="menu-positions"
                                        id="switcher-menu-scroll">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Header Positions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-fixed">
                                        Fixed
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions"
                                        id="switcher-header-fixed" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-scroll">
                                        Scrollable
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions"
                                        id="switcher-header-scroll">
                                </div>
                            </div>
                            <div class="col-4 rounded-header">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-rounded">
                                        Rounded
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions"
                                        id="switcher-header-rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Loader:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-loader-enable">
                                        Enable
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-loader"
                                        id="switcher-loader-enable">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-loader-disable">
                                        Disable
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-loader"
                                        id="switcher-loader-disable" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel"
                    aria-labelledby="switcher-profile-tab" tabindex="0">
                    <div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Menu Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Light Menu" type="radio" name="menu-colors"
                                        id="switcher-menu-light">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Dark Menu" type="radio" name="menu-colors"
                                        id="switcher-menu-dark" checked>
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically
                                change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Header &amp; Bredcrumb Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Dark Header" type="radio"
                                        name="header-colors" id="switcher-header-dark">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Color Header" type="radio"
                                        name="header-colors" id="switcher-header-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-gradient"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Gradient Header"
                                        type="radio" name="header-colors" id="switcher-header-gradient">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-transparent"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Transparent Header"
                                        type="radio" name="header-colors" id="switcher-header-transparent">
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically
                                change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Header Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Default Light Header" type="radio"
                                        name="header-colors" id="switcher-default-header-light">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Default Dark Header" type="radio"
                                        name="header-colors" id="switcher-default-header-dark">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Default Color Header" type="radio"
                                        name="header-colors" id="switcher-default-header-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-gradient"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Default Gradient Header" type="radio" name="header-colors"
                                        id="switcher-default-header-gradient">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-transparent"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Default Transparent Header" type="radio" name="header-colors"
                                        id="switcher-default-header-transparent">
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically
                                change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Primary:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-1" type="radio"
                                        name="theme-primary" id="switcher-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-2" type="radio"
                                        name="theme-primary" id="switcher-primary1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-3" type="radio"
                                        name="theme-primary" id="switcher-primary2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-4" type="radio"
                                        name="theme-primary" id="switcher-primary3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-5" type="radio"
                                        name="theme-primary" id="switcher-primary4">
                                </div>
                                <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                    <div class="theme-container-primary"></div>
                                    <div class="pickr-container-primary"></div>
                                </div>
                            </div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Background:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-1" type="radio"
                                        name="theme-background" id="switcher-background">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-2" type="radio"
                                        name="theme-background" id="switcher-background1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-3" type="radio"
                                        name="theme-background" id="switcher-background2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-4" type="radio"
                                        name="theme-background" id="switcher-background3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-5" type="radio"
                                        name="theme-background" id="switcher-background4">
                                </div>
                                <div
                                    class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                    <div class="theme-container-background"></div>
                                    <div class="pickr-container-background"></div>
                                </div>
                            </div>
                        </div>
                        <div class="menu-image mb-3">
                            <p class="switcher-style-head">Menu With Background Image:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img1" type="radio"
                                        name="theme-background" id="switcher-bg-img">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img2" type="radio"
                                        name="theme-background" id="switcher-bg-img1">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img3" type="radio"
                                        name="theme-background" id="switcher-bg-img2">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img4" type="radio"
                                        name="theme-background" id="switcher-bg-img3">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img5" type="radio"
                                        name="theme-background" id="switcher-bg-img4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid canvas-footer">
                    <a href="javascript:void(0);" id="reset-all" class="btn btn-danger m-1">Reset</a>
                </div>
            </div>
        </div>
    </div>



    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0"> Welcome, {{ ucwords(loggedUserName()) }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Dashboards</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Jay's Watch Store</li>
            </ol>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="flex-grow-1"> <select class="form-select bg-light" id="filter" name="filter">
                            <option value="1" {{ session('dashboard_filter', 1) == 1 ? 'selected' : '' }}>Last 1
                                Month
                            </option>
                            <option value="3" {{ session('dashboard_filter') == 3 ? '' : '' }}>Last 3 Months
                            </option>
                            <option value="6" {{ session('dashboard_filter') == 6 ? '' : '' }}>Last 6 Months
                            </option>
                            <option value="12" {{ session('dashboard_filter') == 12 ? '' : '' }}>Last 12 Months
                            </option>
                            <option value="all" {{ session('dashboard_filter') == 'all' ? '' : '' }}>All</option>
                        </select> </div>
                </div>
            </div>

        </div>

        <!-- <div class="row mb-4 align-items-center">
            <div class="col-md-3 ms-auto">
                <select class="form-select bg-light" id="filter" name="filter">
                    <option value="1" {{ request('filter') == 1 ? 'selected' : '' }}>Last 1 Month</option>
                    <option value="3" {{ request('filter') == 3 ? 'selected' : '' }}>Last 3 Months</option>
                    <option value="6" {{ request('filter') == 6 ? 'selected' : '' }}>Last 6 Months</option>
                    <option value="12" {{ request('filter') == 12 ? 'selected' : '' }}>Last 12 Months</option>
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                </select>
            </div>
        </div> -->

        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Start::row-1 -->
                <div class="row g-3">

                    <!-- Total Sell -->
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="card stat-card card-bg-1 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon">
                                    <i class='bx bx-rupee'></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-1">Total Sell</p>
                                    <h5 class="fw-bold mb-0" id="totalSellAmount">
                                        ₹ {{ indian_number_format($totalSell, 2) }}
                                    </h5>
                                    <span class="stat-sub">Based on Filter</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Products -->
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="card stat-card card-bg-2 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon">
                                    <i class='bx bx-package'></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-1">Total Products</p>
                                    <h5 class="fw-bold mb-0">{{ $products }}</h5>
                                    <span>All Items</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Products -->
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="card stat-card card-bg-3 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon">
                                    <i class='bx bx-time-five'></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-1">Pending Products</p>
                                    <h5 class="fw-bold mb-0">{{ $pending_products }}</h5>
                                    <span>Approval Required</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row g-3 mt-1">

                    <!-- Out of Stock -->
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="card stat-card card-bg-4 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon">
                                    <i class='bx bx-error-circle'></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-1">Out of Stock</p>
                                    <h5 class="fw-bold mb-0">{{ $outStock }}</h5>
                                    <span>Needs Restocking</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="card stat-card card-bg-5 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon">
                                    <i class='bx bx-group'></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-1">Total Users</p>
                                    <h5 class="fw-bold mb-0">{{ $staff }}</h5>
                                    <span>Active Users</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stores -->
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="card stat-card card-bg-6 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon">
                                    <i class='bx bx-store'></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-1">Total Stores</p>
                                    <h5 class="fw-bold mb-0">{{ $store }}</h5>
                                    <span>Active Locations</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--End::row-1 -->

            <div class="row mt-3">
                <div class="col-12">


                    <div class="card-header bg-white border-bottom py-3 px-4">

                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                            <!-- LEFT SIDE -->
                            <div class="d-flex flex-column">

                                <!-- Title -->
                                <h5 class="fw-semibold text-dark mb-3">Total Sales</h5>

                                <!-- Filters Row -->
                                <div
                                    class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-end gap-3">

                                    <!-- Select Period -->
                                    <div style="min-width:160px;">
                                        <label class="form-label small text-muted mb-1">Select Period</label>
                                        <select id="dateRangePreset" class="form-select form-select-sm">
                                            <option value="" selected>Select Period</option>
                                            <option value="today">Today</option>
                                            <option value="this_week">This Week</option>
                                            <option value="this_month">This Month</option>
                                            <option value="this_quarter">This Quarter</option>
                                            <option value="this_year">This Year</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="previous_week">Previous Week</option>
                                            <option value="previous_month">Previous Month</option>
                                            <option value="previous_quarter">Previous Quarter</option>
                                            <option value="previous_year">Previous Year</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </div>

                                    <!-- Date Range -->
                                    <div style="min-width:240px;">
                                        <label class="form-label small text-muted mb-1">Date Range</label>
                                        <div class="d-flex gap-2">
                                            <div class="position-relative flex-grow-1">
                                                <input type="text" id="CustomerDateRange"
                                                    class="form-control form-control-sm shadow-none pe-4"
                                                    placeholder="Select date range" readonly>
                                                <i class="bi bi-calendar3 position-absolute top-50 end-0 translate-middle-y me-2 text-muted"
                                                    style="pointer-events:none; font-size:0.9rem;"></i>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button
                                                    class="btn btn-sm btn-primary px-3 d-flex align-items-center gap-2"
                                                    id="applyDateFilter">
                                                    <i class="bi bi-funnel"></i>
                                                    View
                                                </button>

                                                <button
                                                    class="btn btn-sm btn-outline-secondary px-3 d-flex align-items-center gap-2"
                                                    id="resetDateFilter">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                    Reset
                                                </button>
                                            </div>



                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- RIGHT SIDE (Three Dot at Extreme Corner) -->
                            <div class="dropdown">

                                <button
                                    class="btn btn-light btn-sm border shadow-none d-flex align-items-center justify-content-center"
                                    type="button" data-bs-toggle="dropdown" style="width:36px; height:36px;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end shadow-sm py-2"
                                    style="min-width:180px; border-radius:12px;">

                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2"
                                            href="javascript:void(0);" onclick="downloadChart('svg')">
                                            <i class="bi bi-filetype-svg text-primary"></i>
                                            SVG
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2"
                                            href="javascript:void(0);" onclick="downloadChart('png')">
                                            <i class="bi bi-filetype-png text-success"></i>
                                            PNG
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider my-1">
                                    </li>

                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2"
                                            href="javascript:void(0);" onclick="downloadCSV()">
                                            <i class="bi bi-file-earmark-spreadsheet text-dark"></i>
                                            CSV
                                        </a>
                                    </li>

                                </ul>

                            </div>


                        </div>
                    </div>


                    <div class="card custom-card">

                        <!-- Custom Legend -->
                        <div id="custom-chart-legend"
                            style="display:flex; flex-wrap:wrap; justify-content:center; gap:5px; padding:16px 24px; background:#f8fafc; border-bottom:1px solid #e9ecef;">
                        </div>

                        <!-- Chart Container -->
                        <div class="card-body" style="padding:24px;">
                            <div style="overflow-x:auto;">
                                <div id="locationSalesChart" style="min-width:900px; height:420px;">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Stock In-->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between d-flex align-items-center">
                            <div class="card-title">STOCK IN</div>

                            <button class="btn btn-sm btn-primary" id="refreshStockTable">
                                <i class='bx bx-refresh'></i> Refresh
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" id="stockTrasferTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reference No</th>
                                            <th>Location From</th>
                                            <th>Location To</th>
                                            <th>Shipping Charges</th>
                                            <th>Total</th>
                                            <th>Stock Status</th>
                                            <th>Trasfer Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Draft Invoice -->

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between d-flex align-items-center">
                            <div class="card-title">DRAFT INVOICE</div>

                            <button class="btn btn-sm btn-primary" id="refreshDraftInvoice">
                                <i class='bx bx-refresh'></i> Refresh
                            </button>

                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" id="draftInvoiceTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Invoice No</th>
                                            <th>Customer</th>
                                            <th>Location</th>
                                            <th>Total</th>
                                            <th>Bill Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Start:: row-2 -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between d-flex align-items-center">
                            <div class="card-title">Pending Product List</div>

                            <!-- Refresh Button -->
                            <button class="btn btn-sm btn-primary" id="refreshPendingTable">
                                <i class='bx bx-refresh'></i> Refresh
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" id="dashboardPendingTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>SKU</th>
                                            <th>Location</th>
                                            <th>Purchase Price</th>
                                            <th>Selling Price</th>
                                            <th>Box</th>
                                            <th>Paper</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>









            <!-- Out Of Stock -->

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between d-flex align-items-center">
                            <div class="card-title">OUT OF STOCK</div>

                            <button class="btn btn-sm btn-primary" id="refreshOutStock">
                                <i class='bx bx-refresh'></i> Refresh
                            </button>

                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap w-100" id="outStockProduct">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>SKU</th>
                                            <th>Location</th>
                                            <th>Purchase Price</th>
                                            <th>Selling Price</th>
                                            <th>Box</th>
                                            <th>Paper</th>

                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- End:: row-2 -->

    </div>
    </div>


    <div class="modal fade" id="productViewModal" tabindex="-1" aria-labelledby="productViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productViewModalLabel">Pending Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="viewModalContent">
                        <div class="text-center w-100 py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (current_user_id() == -1)
                        <button type="button" class="btn btn-success approveModalBtn d-none" id="approveModalBtn">
                            <i class="bx bx-check-circle me-1"></i> Approve Product
                        </button>
                        <button type="button" class="btn btn-danger" id="rejectProduct">
                            <i class="bx bx-x-circle me-1"></i> Reject Product
                        </button>
                    @endif
                    <button type="button" class="btn btn-primary" id="printProductBtn">
                        <i class="bx bx-printer me-1"></i>
                        <span class="btn-text">Print</span>
                    </button>

                    <button type="button" class="btn btn-muted" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="stockProductModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title">
                        Stock Transfer Details - Reference No: <span class="fw-bold text-primary refNo"></span>
                    </h5>

                    {{-- <h5 class="fw-bold">Stock Transfer Details</h5> --}}

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- ✅ Location Details -->
                    <div class="row mb-3">

                        <!-- From Location -->
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h6 class="fw-bold text-success">From Location</h6>
                                <p class="mb-1"><b>Name:</b> <span id="fromName"></span></p>
                                <p class="mb-1"><b>Address:</b> <span id="fromAddress"></span></p>
                                <p class="mb-0"><b>Email:</b> <span id="fromEmail"></span></p>
                            </div>
                        </div>

                        <!-- To Location -->
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h6 class="fw-bold text-danger">To Location</h6>
                                <p class="mb-1"><b>Name:</b> <span id="toName"></span></p>
                                <p class="mb-1"><b>Address:</b> <span id="toAddress"></span></p>
                                <p class="mb-0"><b>Email:</b> <span id="toEmail"></span></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded p-3">

                                <p class="mb-1"><b>Reference No:</b> <span class="refNo"></span></p>
                                <p class="mb-1"><b>Date:</b> <span class="transferDate"></span></p>
                                <p class="mb-0"><b>Status:</b> <span id="stockStatus"></span></p>
                            </div>
                        </div>


                    </div>

                    <!-- ✅ Products Table -->
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Unit Type</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="stockProductTable"></tbody>
                    </table>

                    <div class="border rounded p-2 mb-3">
                        <h6 class="fw-bold">Additional Notes</h6>
                        <p class="mb-0 text-muted" id="additionalNotes">-</p>
                    </div>

                    <div class="border rounded p-2 mb-3 d-none">
                        <h6 class="fw-bold">Activity Logs</h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Done By</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody id="activityLogTable">
                                    <tr>
                                        <td colspan="4" class="text-muted">No activity found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="viewSaleModal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title d-flex align-items-center">
                        <i class="bx bx-receipt me-2"></i> Sale Details
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="printArea">
                    <div id="saleDetailsContent"></div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="stockOutModal" tabindex="-1" aria-labelledby="stockOutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockOutModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="viewModalStockOut">
                        <div class="text-center w-100 py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>




    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @include('partials.footer_link')

    <script>
        $(document).ready(function() {

            // 1. Initialize DataTable (No changes to list logic)
            var pendingTable = $('#dashboardPendingTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('pendingpro.details') }}?from_dashboard=true",
                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pro_image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) return '';
                            if (type === 'display') return data;
                            var match = data.match(/src=["']([^"']+)["']/);
                            return match ? match[1] : '';
                        }
                    },
                    {
                        data: 'pro_name'
                    },
                    {
                        data: 'brand'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'pro_sku'
                    },
                    {
                        data: 'business_location'
                    },
                    {
                        data: 'purchase_price'
                    },
                    {
                        data: 'selling_price'
                    },
                    {
                        data: 'box'
                    },
                    {
                        data: 'paper'
                    }
                ],
                columnDefs: [{
                    targets: '_all',
                    className: 'text-start'
                }],
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25],
                    [5, 10, 25]
                ],
                dom: "<'row mb-2 align-items-center'<'col-lg-2'l><'col-lg-7 text-center'><'col-lg-3 text-end'f>>rtip",
            });


            $('#refreshPendingTable').on('click', function() {

                let btn = $(this);
                btn.html("<i class='bx bx-loader-alt bx-spin'></i> Refreshing");

                pendingTable.ajax.reload(function() {
                    btn.html("<i class='bx bx-refresh'></i> Refresh");
                }, false);

            });



            // 2. ✅ View Product - EXACT COPY from pending_products.blade.php
            $(document).on('click', '.viewProduct', function() {
                var id = $(this).data('id');
                var modalContent = $('#viewModalContent');

                // Show Modal & Spinner
                $('#productViewModal').modal('show');
                modalContent.html(
                    '<div class="text-center w-100 py-5"><div class="spinner-border text-primary" role="status"></div></div>'
                );

                var url = "{{ route('product.show', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response.status === 200) {
                            var d = response.data;

                            // Enable Approve Button for Modal
                            $('#approveModalBtn')
                                .attr("data-id", id)
                                .attr("data-name", d.pro_name)
                                .removeClass("d-none");

                            $('#printProductBtn')
                                .attr("data-id", id)
                                .attr("data-name", d.pro_name)
                                .removeClass("d-none");

                            $('#rejectProduct')
                                .attr("data-id", id)
                                .attr("data-name", d.pro_name)
                                .removeClass("d-none");

                            // --- Helpers ---
                            var checkNull = (val) => (val === null || val === '') ? 'N/A' : val;
                            var yesNoBadge = (val) => val == 1 ?
                                '<span class="badge bg-success">Yes</span>' :
                                '<span class="badge bg-light text-dark border">No</span>';
                            var boolBadge = (val, text) => val == 1 ?
                                `<span class="badge bg-primary me-1 mb-1">${text}</span>` : '';
                            var formatPrice = (price) => !price ? 'N/A' : '₹' + parseFloat(
                                price).toLocaleString('en-IN');

                            // --- Image Logic ---
                            var brandFolder = d.brand_folder;
                            var productFolder = d.product_folder;
                            var baseUrl =
                                "{{ config('app.actual_url') . '/admin_assets/brand/' }}" +
                                brandFolder + "/" + productFolder + "/";

                            // Main Image
                            var mainImgHtml = d.pro_image ?
                                `<div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-3 d-flex align-items-center justify-content-center">
                                    <img src="${baseUrl}image/${d.pro_image}" class="img-fluid rounded" style="max-height: 280px; object-fit: contain;">
                                </div>
                            </div>` :
                                `<div class="card border h-100">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-image display-4 mb-3"></i>
                                    <span>No Main Image</span>
                                </div>
                            </div>`;

                            // Gallery Images
                            var galleryHtml = '';
                            if (d.pro_gallery && d.pro_gallery.trim() !== '') {
                                var images = d.pro_gallery.split(',');
                                galleryHtml = `
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-transparent border-0 py-3">
                                        <h6 class="mb-0 fw-semibold text-dark">Gallery</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="gallery-scroll" style="max-height: 200px; overflow-y: auto; overflow-x:hidden;">
                                            <div class="row g-2">`;
                                images.forEach(img => {
                                    galleryHtml += `
                                    <div class="col-4 col-md-6">
                                        <div class="gallery-item position-relative">
                                            <img src="${baseUrl}gallery/${img}" class="img-fluid rounded border" style="height: 80px; width: 100%; object-fit: cover;">
                                        </div>
                                    </div>`;
                                });
                                galleryHtml += `</div></div></div></div>`;
                            } else {
                                galleryHtml = `
                                <div class="card border h-100">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                                        <i class="bi bi-images display-4 mb-3"></i>
                                        <span>No Gallery Images</span>
                                    </div>
                                </div>`;
                            }

                            // Brochure & Video
                            var brochureBase =
                                "{{ config('app.actual_url') . '/admin_assets/brand/' }}";
                            var brochureLink = d.pro_brochure ?
                                `<a href="${brochureBase}${brandFolder}/${productFolder}/brochure/${d.pro_brochure}" target="_blank" class="btn btn-sm btn-outline-primary mb-0 "><i class="bi bi-file-earmark-pdf me-1"></i> Download Brochure</a>` :
                                '';

                            var videoHtml = '';
                            if (d.video_source) {
                                if (d.video_type === 'file') {
                                    var videoUrl = baseUrl + "video/" + d.video_source;
                                    videoHtml = `
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-header bg-transparent border-0 py-3">
                                            <h6 class="mb-0 fw-semibold text-dark">Video Preview</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <video controls class="w-100 rounded" style="height: 150px; object-fit: cover;">
                                                <source src="${videoUrl}" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>`;
                                } else {
                                    videoHtml = `
                                    <div class="card border h-100">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                                            <i class="bi bi-play-circle display-4 text-danger mb-3"></i>
                                            <h6 class="fw-semibold">Watch Video</h6>
                                            <a href="${d.video_source}" target="_blank" class="btn btn-danger btn-sm w-100">Watch Now</a>
                                        </div>
                                    </div>`;
                                }
                            } else {
                                videoHtml = `
                                <div class="card border h-100">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                                        <i class="bi bi-camera-video display-4 mb-3"></i>
                                        <span>No Video Available</span>
                                    </div>
                                </div>`;
                            }

                            // --- Construct HTML (Exact Schema) ---
                            var html = `
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <h4 class="fw-bold text-dark mb-1">${checkNull(d.pro_name)}</h4>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <span class="badge bg-primary">${checkNull(d.pro_model)}</span>
                                        <span class="badge bg-info text-dark">${checkNull(d.pro_ref_num)}</span>
                                        <span class="badge bg-light text-dark border">${checkNull(d.brand_name)}</span>
                                    </div>
                                    <p class="text-muted mb-0">${checkNull(d.pro_model_name)}</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="d-flex flex-column">
                                        <span class="text-muted small">Current Price</span>
                                        <h3 class="fw-bold text-success mb-0">${formatPrice(d.selling_price_exclusive)}</h3>
                                        <span class="text-muted small">Exclusive of Tax</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 mb-3">${mainImgHtml}</div>
                                <div class="col-md-4 mb-3">${galleryHtml}</div>
                                <div class="col-md-4 mb-3 no-pdf">${videoHtml}</div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-0">
                                    <ul class="nav nav-tabs nav-tabs-custom" id="productTab" role="tablist">
                                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic"><i class="bi bi-info-circle me-2"></i>Basic Info</button></li>
                                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#design"><i class="bi bi-palette me-2"></i>Design</button></li>
                                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#features"><i class="bi bi-gear me-2"></i>Features</button></li>
                                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#business"><i class="bi bi-graph-up me-2"></i>Business</button></li>
                                    </ul>

                                    <div class="tab-content p-4">
                                        <div class="tab-pane fade show active" id="basic">
                                            <div class="row g-3">
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Product Type</label><div class="fw-medium">${checkNull(d.pro_type)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Gender</label><div class="fw-medium">${checkNull(d.pro_gender)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">SKU</label><div class="fw-bold text-primary">${checkNull(d.pro_sku)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Collection</label><div>${checkNull(d.collection)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Watch Category</label><div>${checkNull(d.watch_category)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Watch Type</label><div>${checkNull(d.watch_type_name)}</div></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="design">
                                            <div class="row g-3">
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Dial Color</label><div>${checkNull(d.dial_colour)}</div></div>
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Case Material</label><div>${checkNull(d.case_material)}</div></div>
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Strap Material</label><div>${checkNull(d.strap_material)}</div></div>
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Glass</label><div>${checkNull(d.glass_name)}</div></div>
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Case Shape</label><div>${checkNull(d.case_shape)}</div></div>
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Dial Diameter</label><div>${checkNull(d.dial_diameter)} mm</div></div>
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Water Resistance</label><div>${checkNull(d.water_resistance)}</div></div>
                                                <div class="col-md-3"><label class="form-label text-muted small mb-1">Movement</label><div class="fw-medium">${checkNull(d.movement_name)}</div></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="features">
                                             <div class="row g-3">
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Brand Warranty</label><div>${yesNoBadge(d.brand_warranty)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Service Card</label><div>${yesNoBadge(d.service_card)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Box Included</label><div>${yesNoBadge(d.box)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Papers</label><div>${yesNoBadge(d.paper)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Origin Country</label><div>${checkNull(d.origin_country_name)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Manufacturer</label><div>${checkNull(d.manufacturer_name)}</div></div>
                                                <div class="col-12"><label class="form-label text-muted small mb-1">Functionality</label><div class="bg-light p-3 rounded">${checkNull(d.functionality)}</div></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="business">
                                            <div class="row g-3">
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Condition</label><div class="fw-bold ${d.condition === 'New' ? 'text-success' : 'text-warning'}">${checkNull(d.condition)}</div></div>
                                                <div class="col-md-4"><label class="form-label text-muted small mb-1">Quantity</label><div class="fw-bold ${d.quantity > 0 ? 'text-success' : 'text-danger'}">${checkNull(d.quantity)}</div></div>
      <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Physical Location</label>
                                            <div class="fw-medium">${checkNull(d.physical_location_name)}</div>
                                        </div>

                                      <div class="col-12">
                                            <label class="form-label text-muted small mb-1">
                                                Display Locations ${(d.display_location_name && d.display_location_name !== '-')
                                    ? `(${d.display_location_name.split(",").length})`
                                    : "(0)"
                                }
                                            </label>

                                            <ol class="mb-0 ps-3">
                                                ${(d.display_location_name && d.display_location_name !== '-')
                                    ? d.display_location_name
                                        .split(",")
                                        .map(loc => `<li>${loc.trim()}</li>`)
                                        .join("")
                                    : "<li>Not Available</li>"
                                }
                                            </ol>
                                        </div>
                                                <div class="col-12 mt-4"><h6 class="border-bottom pb-2 mb-3">Pricing Details</h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-3"><label class="form-label text-muted small mb-1">Purchase Price</label><div class="fw-medium">${formatPrice(d.purchase_price_exclusive)}</div></div>
                                                        <div class="col-md-3"><label class="form-label text-muted small mb-1">Margin</label><div class="fw-medium">${checkNull(d.pro_margin)}%</div></div>
                                                        <div class="col-md-3"><label class="form-label text-muted small mb-1">Selling Price</label><div class="fw-bold text-success">${formatPrice(d.selling_price_exclusive)}</div></div>
                                                        <div class="col-md-3"><label class="form-label text-muted small mb-1">Tax Rate</label><div>${checkNull(d.pro_tax)}%</div></div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-4"><h6 class="border-bottom pb-2 mb-3">Status</h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        ${boolBadge(d.new_arrival, 'New Arrival')}
                                                        ${boolBadge(d.manage_stock, 'Stock Managed')}
                                                        ${boolBadge(d.out_stock, 'Out of Stock')}
                                                        ${boolBadge(d.not_for_selling, 'Not for Sale')}
                                                        ${boolBadge(d.tata_cliq_product, 'Tata Cliq Exclusive')}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mt-4">
                                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-semibold text-dark"><i class="bi bi-card-text me-2"></i>Product Description</h6>
                                    ${d.pro_brochure ? brochureLink : ''}
                                </div>
                                <div class="card-body"><p class="mb-0 text-muted">${checkNull(d.product_desc)}</p></div>
                            </div>`;

                            modalContent.html(html);
                        } else {
                            modalContent.html(
                                '<div class="alert alert-danger">Failed to load data.</div>'
                            );
                        }
                    },
                    error: function() {
                        modalContent.html(
                            '<div class="alert alert-danger">Error loading data.</div>');
                    }
                });
            });

            $(document).on("click", "#printProductBtn", async function() {

                const btn = $(this);

                /* -------------------------------
                   BUTTON LOADING START
                --------------------------------*/
                btn.prop("disabled", true);
                btn.find(".btn-text").html(`
        <span class="spinner-border spinner-border-sm me-2"></span>
        Printing...
    `);

                const {
                    jsPDF
                } = window.jspdf;
                let content = document.getElementById("viewModalContent");

                /* -------------------------------
                   STEP 1 : SHOW ALL TABS
                --------------------------------*/
                let tabs = content.querySelectorAll('.tab-pane');

                tabs.forEach(tab => {
                    tab.classList.add('show', 'active');
                    tab.style.display = 'block';
                    tab.style.opacity = '1';
                });

                // hide tab headers
                content.querySelectorAll('.nav-tabs').forEach(nav => {
                    nav.style.display = "none";
                });

                // ✅ enable pdf mode (hide .no-pdf items)
                content.classList.add("pdf-mode");

                /* -------------------------------
                   STEP 2 : CREATE CANVAS
                --------------------------------*/
                html2canvas(content, {
                    scale: 1.2,
                    useCORS: true,
                    allowTaint: true,
                    scrollY: -window.scrollY
                }).then(canvas => {

                    const imgData = canvas.toDataURL("image/png");

                    const pdf = new jsPDF('p', 'mm', 'a4');

                    const pageWidth = pdf.internal.pageSize.getWidth();
                    const pageHeight = pdf.internal.pageSize.getHeight();

                    const imgHeight = (canvas.height * pageWidth) / canvas.width;

                    let heightLeft = imgHeight;
                    let position = 0;

                    pdf.addImage(imgData, 'PNG', 0, position, pageWidth, imgHeight);
                    heightLeft -= pageHeight;

                    while (heightLeft > 0) {
                        position = heightLeft - imgHeight;
                        pdf.addPage();
                        pdf.addImage(imgData, 'PNG', 0, position, pageWidth, imgHeight);
                        heightLeft -= pageHeight;
                    }

                    /* -------------------------------
                       STEP 3 : DIRECT PRINT
                    --------------------------------*/
                    const pdfBlob = pdf.output('blob');
                    const pdfUrl = URL.createObjectURL(pdfBlob);

                    let printWindow = window.open(pdfUrl, "_blank");

                    setTimeout(() => {
                        if (printWindow) {
                            printWindow.focus();
                            printWindow.print();
                        }
                    }, 500);

                    /* -------------------------------
                       STEP 4 : RESTORE UI
                    --------------------------------*/
                    content.classList.remove("pdf-mode");

                    tabs.forEach(tab => {
                        tab.classList.remove('active', 'show');
                        tab.removeAttribute("style");
                    });

                    content.querySelectorAll('.nav-tabs').forEach(nav => {
                        nav.style.display = "";
                    });

                    $('#productTab button:first').tab('show');

                    /* -------------------------------
                       BUTTON RESTORE
                    --------------------------------*/
                    btn.prop("disabled", false);
                    btn.find(".btn-text").html("Print");

                }).catch(() => {
                    btn.prop("disabled", false);
                    btn.find(".btn-text").html("Print");
                    content.classList.remove("pdf-mode");
                });

            });


            $(document).on('click', '.editPendingProduct', function() {

                var pro_id = $(this).data('id');

                // redirect to product page with edit id
                window.location.href = "{{ route('pendingproduct.view') }}?edit_id=" + pro_id;

            });


            // Hide Approve button on close
            $('#productViewModal').on('hidden.bs.modal', function() {
                $('#approveModalBtn').addClass("d-none");
            });

            // 3. ✅ Reject Logic (From Dashboard List Action)
            $(document).on("click", "#rejectProduct", function() {

                let id = $(this).data("id");
                let name = $(this).data("name");

                Swal.fire({
                    title: "Reject Product?",
                    html: `Are you sure you want to <b>REJECT</b> <b>${name}</b>?<br>This will change status to Rejected.`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, Reject",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('product.reject') }}",
                            type: "POST",
                            data: {
                                pro_id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: "Rejected!",
                                    text: res.message,
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#productViewModal').modal('hide');
                                $('#dashboardPendingTable').DataTable().ajax.reload();
                            },
                            error: function() {
                                Swal.fire("Error", "Something went wrong", "error");
                            }
                        });
                    }
                });
            });

            // 4. ✅ Approve Logic (From Modal Footer Action)
            $(document).on("click", "#approveModalBtn", function() {
                let id = $(this).data("id");
                let name = $(this).data("name");

                Swal.fire({
                    title: "Approve Product?",
                    html: `Are you sure you want to approve <b>${name}</b>?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Approve",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('product.approve') }}",
                            type: "POST",
                            data: {
                                pro_id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: "Approved!",
                                    text: res.message,
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#productViewModal').modal('hide');
                                $('#dashboardPendingTable').DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });

        });
    </script>

    <!-- filter logic -->
    <script>
        document.getElementById('filter').addEventListener('change', function() {

            fetch("{{ route('dashboard.totalSell') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        filter: this.value
                    })
                })
                .then(res => res.json())
                .then(data => {

                    document.getElementById('totalSellAmount').innerHTML = '₹ ' + data.totalSell;

                })
                .catch(error => console.log(error));
        });
    </script>

    <!-- new logic  -->
    <script>
        let chartInstance = null;
        let selectedStart = null;
        let selectedEnd = null;
        let fp = null; // 🔥 make flatpickr global

        let selectedStores = [];
        let allLocationsSelected = true;

        const salesDataUrl = "{{ route('dashboard.locationSalesChart') }}";

        $(document).ready(function() {
            // Initialize Flatpickr
            fp = flatpickr("#CustomerDateRange", {
                mode: "range",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                allowInput: true,
                placeholder: "DD-MM-YYYY to DD-MM-YYYY",
                defaultDate: null,
                onReady: function(selectedDates, dateStr, instance) {
                    instance.clear();
                },
                onChange: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        selectedStart = selectedDates[0];
                        selectedEnd = selectedDates[1];
                    } else {
                        selectedStart = null;
                        selectedEnd = null;
                    }
                }
            });

            $('#dateRangePreset').on('change', function() {

                const value = $(this).val();

                if (value === 'custom') {
                    fp.open();
                    return;
                }

                const today = new Date();
                let start, end;

                switch (value) {
                    case 'today':
                        start = end = new Date();
                        break;

                    case 'yesterday':
                        start = new Date();
                        start.setDate(start.getDate() - 1);
                        end = new Date(start);
                        break;

                    case 'this_week':
                        start = new Date();
                        start.setDate(start.getDate() - start.getDay());
                        end = new Date();
                        break;

                    case 'previous_week':
                        start = new Date();
                        start.setDate(start.getDate() - start.getDay() - 7);
                        end = new Date(start);
                        end.setDate(start.getDate() + 6);
                        break;

                    case 'this_month':
                        start = new Date(today.getFullYear(), today.getMonth(), 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        break;

                    case 'previous_month':
                        start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        end = new Date(today.getFullYear(), today.getMonth(), 0);
                        break;

                    case 'this_quarter':
                        const currentQuarter = Math.floor(today.getMonth() / 3);
                        start = new Date(today.getFullYear(), currentQuarter * 3, 1);
                        end = new Date(today.getFullYear(), (currentQuarter * 3) + 3, 0);
                        break;

                    case 'previous_quarter':
                        const prevQuarter = Math.floor(today.getMonth() / 3) - 1;
                        start = new Date(today.getFullYear(), prevQuarter * 3, 1);
                        end = new Date(today.getFullYear(), (prevQuarter * 3) + 3, 0);
                        break;

                    case 'this_year':
                        start = new Date(today.getFullYear(), 0, 1);
                        end = new Date(today.getFullYear(), 11, 31);
                        break;

                    case 'previous_year':
                        start = new Date(today.getFullYear() - 1, 0, 1);
                        end = new Date(today.getFullYear() - 1, 11, 31);
                        break;

                    default:
                        return;
                }

                selectedStart = start;
                selectedEnd = end;

                // Only set date visually
                fp.setDate([start, end], true);

            });

            // Apply Button
            $('#applyDateFilter').on('click', function() {
                const from = selectedStart ? formatDate(selectedStart) : '';
                const to = selectedEnd ? formatDate(selectedEnd) : '';
                fetchData(from, to);
            });

            // Initial Load
            fetchData('', '');



            // 🔥 Reset Button
            $('#resetDateFilter').on('click', function() {

                // Clear flatpickr visually
                fp.clear();

                // Clear preset dropdown
                $('#dateRangePreset').val('');

                // Reset selected dates
                selectedStart = null;
                selectedEnd = null;

                // Reset legend selections
                allLocationsSelected = true;
                selectedStores = [];

                // Reload full data
                fetchData('', '');
            });

        });

        function formatDate(date) {
            if (!date) return '';
            const d = new Date(date);
            return d.toISOString().split('T')[0];
        }

        function fetchData(from, to) {
            let url = salesDataUrl;
            const params = new URLSearchParams();

            if (from && to) {
                params.append('from', from);
                params.append('to', to);
                url += `?${params.toString()}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    window.latestChartData = data;
                    allLocationsSelected = true;
                    selectedStores = [];
                    renderChart(data);
                    renderCustomLegend(data);
                })
                .catch(err => console.error("Fetch error:", err));
        }

        function renderChart(storeData) {

            let filteredData;

            if (allLocationsSelected) {
                filteredData = storeData.filter(d => d.name !== 'All Locations');
            } else {
                filteredData = storeData.filter(d =>
                    selectedStores.includes(d.name)
                );
            }


            // 🔥 Check if there is REAL data (not just empty array)
            const totalSales = filteredData.reduce((sum, item) => sum + (item.sales || 0), 0);
            const hasData = filteredData.length > 0 && totalSales > 0;

            const maxValue = hasData ?
                Math.max(...filteredData.map(d => d.sales)) :
                10;

            const yAxisMax = Math.ceil(maxValue / 10) * 10;

            const options = {
                chart: {
                    type: 'bar',
                    height: 420,
                    fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                    toolbar: {
                        show: true,
                        tools: {
                            download: false,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true
                        }
                    },
                    dropShadow: {
                        enabled: true,
                        top: 4,
                        left: 0,
                        blur: 6,
                        opacity: 0.15
                    },

                    animations: {
                        enabled: true,
                        speed: 1200, // slower for dramatic bounce
                        easing: 'easeinout', // smoother easing
                        animateGradually: {
                            enabled: true,
                            delay: 200 // staggered bounce effect
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 800
                        }
                    }

                },

                // ✅ This will now work correctly
                noData: {
                    text: 'No Data Available',
                    align: 'center',
                    verticalAlign: 'middle',
                    style: {
                        color: '#64748b',
                        fontSize: '18px',
                        fontWeight: 600
                    }
                },

                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        borderRadius: 12,
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },


                colors: hasData ?
                    filteredData.map(d => d.color || '#3b82f6') : ['#e2e8f0'],

                dataLabels: {
                    enabled: hasData,
                    formatter: function(val) {
                        return val.toLocaleString();
                    },
                    style: {
                        fontSize: '13px',
                        fontWeight: 700,
                        colors: ['#ffffff']
                    },
                    background: {
                        enabled: false
                    }
                },

                // 🔥 IMPORTANT PART
                series: hasData ? [{
                    name: 'Sales Count',
                    data: filteredData.map(d => d.sales)
                }] : [],

                xaxis: {
                    categories: hasData ?
                        filteredData.map(d => d.name) : []
                },

                yaxis: {
                    min: 0,
                    max: yAxisMax,
                    title: {
                        text: 'Number of Sales',
                        style: {
                            fontSize: '13px',
                            fontWeight: 600,
                            color: '#334155'
                        }
                    }
                },

                tooltip: hasData ? {
                    theme: 'light',
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif'
                    },
                    y: {
                        formatter: function(val, opts) {
                            const rev = filteredData[opts.dataPointIndex]?.revenue || 0;
                            return `
                        <div style="padding:8px;">
                            <strong style="color:#1e293b;">Sales Count:</strong> ${val.toLocaleString()}<br>
                            <strong style="color:#1e293b;">Revenue:</strong> ₹${rev.toLocaleString('en-IN')}
                        </div>
                    `;
                        }
                    }
                } : {
                    enabled: false
                },

                legend: {
                    show: false
                }
            };

            if (chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new ApexCharts(
                document.querySelector("#locationSalesChart"),
                options
            );

            chartInstance.render();
        }

        function renderCustomLegend(storeData) {
            const legendDiv = document.getElementById('custom-chart-legend');
            if (!legendDiv) return;

            legendDiv.innerHTML = '';

            storeData.forEach(item => {

                const isAll = item.name === 'All Locations';
                const isActive =
                    (isAll && allLocationsSelected) ||
                    (!isAll && selectedStores.includes(item.name));

                const btn = document.createElement('button');

                btn.style.cssText = `
            display:flex;
            align-items:center;
            padding:6px 14px;
            border:1.5px solid ${isActive ? item.color : '#e2e8f0'};
            border-radius:30px;
            background:${isActive ? `${item.color}15` : 'white'};
            font-size:12px;
            font-weight:${isActive ? '600' : '500'};
            cursor:pointer;
            transition:all .2s ease;
            margin-bottom:6px;
        `;

                btn.innerHTML = `
            <span style="width:10px;height:10px;background:${item.color};
            border-radius:50%;margin-right:8px;"></span>
            ${item.name}
        `;

                btn.onclick = () => {

                    if (isAll) {
                        // Reset everything
                        allLocationsSelected = true;
                        selectedStores = [];
                    } else {

                        allLocationsSelected = false;

                        if (selectedStores.includes(item.name)) {
                            // 🔥 UNSELECT if already selected
                            selectedStores = selectedStores.filter(s => s !== item.name);
                        } else {
                            // 🔥 ADD if not selected
                            selectedStores.push(item.name);
                        }

                        // If nothing selected → fallback to all
                        if (selectedStores.length === 0) {
                            allLocationsSelected = true;
                        }
                    }

                    renderChart(storeData);
                    renderCustomLegend(storeData);
                };

                legendDiv.appendChild(btn);
            });
        }


        function downloadChart(type) {
            if (!chartInstance) return;

            if (type === 'png') {

                chartInstance.dataURI().then(({
                    imgURI
                }) => {
                    const link = document.createElement('a');
                    link.href = imgURI;
                    link.download = `location-sales-${new Date().getTime()}.png`;
                    link.click();
                });

            }

            if (type === 'svg') {

                const svgElement = document.querySelector("#locationSalesChart svg");
                if (!svgElement) return;

                const serializer = new XMLSerializer();
                const svgString = serializer.serializeToString(svgElement);

                const blob = new Blob([svgString], {
                    type: "image/svg+xml;charset=utf-8"
                });

                const url = URL.createObjectURL(blob);

                const link = document.createElement("a");
                link.href = url;
                link.download = `location-sales-${new Date().getTime()}.svg`;
                link.click();

                URL.revokeObjectURL(url);
            }
        }


        function downloadCSV() {
            const filteredData = allLocationsSelected ?
                window.latestChartData.filter(d => d.name !== 'All Locations') :
                window.latestChartData.filter(d => selectedStores.includes(d.name));

            // Add summary row
            const totalSales = filteredData.reduce((sum, row) => sum + row.sales, 0);
            const totalRevenue = filteredData.reduce((sum, row) => sum + row.revenue, 0);

            let csv = "Store Location,Sales Count,Revenue (₹)\n";

            filteredData.forEach(row => {
                csv += `"${row.name}",${row.sales},${row.revenue}\n`;
            });

            csv += `\n"TOTAL",${totalSales},${totalRevenue}\n`;

            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = `location-sales-report-${new Date().getTime()}.csv`;
            link.click();

            URL.revokeObjectURL(url);
        }
    </script>


    <script>
        $(document).ready(function() {
            var stockTable = $('#stockTrasferTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('stock.in.pending') }}",
                lengthMenu: [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],
                pageLength: 5,

                columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    },
                    {
                        data: 'reference_no',
                        name: 'reference_no'
                    },
                    {
                        data: 'location_from',
                        name: 'location_from'
                    },
                    {
                        data: 'location_to',
                        name: 'location_to'
                    },
                    {
                        data: 'shipping_charges',
                        name: 'shipping_charges'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'stock_status',
                        name: 'stock_status'
                    },
                    {
                        data: 'transfer_date',
                        name: 'transfer_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            $('#refreshStockTable').on('click', function() {

                let btn = $(this);

                btn.html("<i class='bx bx-loader-alt bx-spin'></i> Refreshing");

                stockTable.ajax.reload(function() {
                    btn.html("<i class='bx bx-refresh'></i> Refresh");
                }, false); // keep current page

            });


            $(document).on('click', '.viewStock', function() {

                let stockId = $(this).data('id');

                $.ajax({
                    url: "{{ route('stock.transfer.products', ':id') }}".replace(':id', stockId),
                    type: "GET",
                    success: function(response) {

                        let rows = '';
                        let i = 1;

                        let netTotal = 0; // ✅ Total Net Amount

                        // ✅ Additional Charges
                        let shippingCharges = parseFloat(response.transfer.shipping_charges) ||
                            0;

                        if (response.products.length > 0) {

                            $.each(response.products, function(key, item) {

                                let productName = item.product ? item.product.pro_name :
                                    '-';
                                let qty = parseFloat(item.qyt) || 0;
                                let unitPrice = parseFloat(item.unit_price) || 0;
                                let total = qty * unitPrice;
                                $('.refNo').text(response.transfer.reference_no ?? '-');
                                $('.transferDate').text(response.transfer_date ?? '-');

                                // ✅ From Location
                                $('#fromName').text(response.from?.name ?? '-');
                                $('#fromAddress').text(response.from?.address ?? '-');
                                $('#fromEmail').text(response.from?.email ?? '-');

                                // ✅ To Location
                                $('#toName').text(response.to?.name ?? '-');
                                $('#toAddress').text(response.to?.address ?? '-');
                                $('#toEmail').text(response.to?.email ?? '-');


                                $('#additionalNotes').text(response.transfer?.notes ??
                                    '-');

                                let status = response.transfer?.stock_status ?? 0;
                                let badge = '';

                                if (status == 0) {
                                    badge =
                                        `<span class="badge bg-warning text-dark">Pending</span>`;
                                } else if (status == 1) {
                                    badge =
                                        `<span class="badge bg-info text-dark">IN - Transit</span>`;
                                } else if (status == 2) {
                                    badge =
                                        `<span class="badge bg-success">Completed</span>`;
                                } else {
                                    badge =
                                        `<span class="badge bg-secondary">Unknown</span>`;
                                }

                                $('#stockStatus').html(badge);

                                let logRows = '';
                                let logIndex = 1;

                                if (response.logs.length > 0) {

                                    $.each(response.logs, function(key, log) {

                                        logRows += `
            <tr>
                <td>${logIndex++}</td>
                <td>${log.status}</td>
                <td>${log.user_name}</td>
                <td>${log.date}</td>
            </tr>`;
                                    });

                                } else {

                                    logRows = `
        <tr>
            <td colspan="4" class="text-muted text-center">No activity found</td>
        </tr>`;
                                }

                                $('#activityLogTable').html(logRows);


                                netTotal += total;

                                rows += `
            <tr>
                <td>${i++}</td>
                <td>${productName}</td>
                <td>₹ ${indianFormat(unitPrice)}</td>
                <td>${qty}</td>
                <td>${item.unit_type}</td>
                <td>${indianFormat(total)}</td>
            </tr>`;
                            });

                            // ✅ Total Net Amount Row
                            rows += `
        <tr class="fw-bold">
            <td colspan="5" class="text-end">Total Net Amount</td>
            <td>${indianFormat(netTotal)}</td>
        </tr>`;

                            // ✅ Additional Charges Row
                            rows += `
        <tr class="fw-bold text-warning">
            <td colspan="5" class="text-end">Additional Charges</td>
            <td>${indianFormat(shippingCharges)}</td>
        </tr>`;

                            // ✅ Overall Grand Total
                            // ✅ Overall Grand Total
                            let overallGrandTotal = netTotal + shippingCharges;

                            // ✅ Convert Total to Words
                            let totalWords = numberToWords(Math.round(overallGrandTotal));

                            // ✅ Show Grand Total Row
                            rows += `
<tr class="fw-bold text-success">
    <td colspan="5" class="text-end">Overall Grand Total</td>
    <td>₹ ${indianFormat(overallGrandTotal)}</td>
</tr>`;

                            // ✅ Show Total in Words Row
                            rows += `
<tr class="fw-bold text-primary">
    <td colspan="6" class="text-start">
        Total Amount In Words:
        <span class="fst-italic">${totalWords}</span>
    </td>
</tr>`;


                        } else {

                            rows = `
        <tr>
            <td colspan="6" class="text-center">No products found</td>
        </tr>`;
                        }

                        $('#stockProductTable').html(rows);
                        $('#stockProductModal').modal('show');
                    }

                });

            });


            $(document).on("click", ".printStock", function() {

                let id = $(this).data("id");

                window.open(
                    "{{ route('stock.transfer.print', ':id') }}".replace(':id', id),
                    "_blank"
                );
            });


            $(document).on("click", ".receivedStock", function() {

                let stockId = $(this).data("id");

                Swal.fire({
                    title: "Mark as Received?",
                    // text: "Stock Transfer ID: " + stockId,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Received",
                    cancelButtonText: "Cancel"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('stock.transfer.received') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                stock_id: stockId
                            },
                            success: function(res) {

                                Swal.fire("Success!", res.message, "success");

                                // ✅ Reload DataTable
                                $("#stockTrasferTable").DataTable().ajax.reload(null,
                                    false);
                            },
                            error: function(xhr) {

                                Swal.fire(
                                    "Error!",
                                    xhr.responseJSON?.message ||
                                    "Something went wrong!",
                                    "error"
                                );
                            }
                        });
                    }
                });

            });




            $(document).on('click', '.rejectStock', function() {

                let stockId = $(this).data('id');

                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    title: 'Reject Stock?',
                    message: 'This will permanently remove this stock transfer.',
                    position: 'center',
                    buttons: [
                        [
                            '<button><b>YES, REJECT</b></button>',
                            function(instance, toast) {

                                $.ajax({
                                    url: "{{ route('stock.reject') }}",
                                    type: "POST",
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr(
                                            'content'),
                                        stock_id: stockId
                                    },
                                    success: function(res) {

                                        if (res.status) {
                                            iziToast.success({
                                                message: res.message,
                                                position: 'topRight'
                                            });

                                            // reload datatable
                                            $('#stockInTable').DataTable().ajax
                                                .reload(null, false);
                                        } else {
                                            iziToast.error({
                                                message: res.message,
                                                position: 'topRight'
                                            });
                                        }
                                    }
                                });

                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast);
                            },
                            true
                        ],
                        [
                            '<button>NO</button>',
                            function(instance, toast) {
                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast);
                            }
                        ]
                    ]
                });
            });




        });
    </script>


    <script>
        $(document).ready(function() {

            var draftInvoiceTable = $('#draftInvoiceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('draft-invoice') }}",
                    data: function(d) {

                        d.business_location = $('#filter_business_location').val();

                        let range = $('#CustomerDateRange').val();

                        if (range) {
                            let dates = range.split(" to ");
                            d.start_date = dates[0];
                            d.end_date = dates[1] ?? dates[0];
                        }
                    }
                },



                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sale_date'
                    },
                    {
                        data: 'invoice_no'
                    },
                    {
                        data: 'customer'
                    },
                    {
                        data: 'location'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'bill_status'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                columnDefs: [{
                    targets: '_all',
                    className: 'text-start'
                }],

                lengthMenu: [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],
                pageLength: 5,

                // ✅ DOM without buttons
                dom: "<'row mb-2 align-items-center'" +
                    "<'col-lg-6 col-md-6'l>" +
                    "<'col-lg-6 col-md-6 text-end'f>" +
                    ">" +
                    "rtip",

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search sales...",
                }
            });


            $('#refreshDraftInvoice').on('click', function() {

                let btn = $(this);

                btn.html("<i class='bx bx-loader-alt bx-spin'></i> Refreshing");

                draftInvoiceTable.ajax.reload(function() {
                    btn.html("<i class='bx bx-refresh'></i> Refresh");
                }, false); // keep current page

            });


            $(document).on('click', '.view-sale', function() {

                var id = $(this).data('id');
                var url = "{{ route('sales.show', ':id') }}".replace(':id', id);

                $.get(url, function(response) {

                    if (response.status === 200) {

                        var d = response.data;
                        var products = response.products || [];
                        var payments = response.payments || [];

                        /* ================= PRODUCTS ================= */

                        var productRows = '';

                        if (products.length > 0) {

                            products.forEach(function(p, index) {

                                productRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>
                                ${p.pro_name || 'Product'}
                                <br>
                                <small class="text-muted">${p.description || ''}</small>
                            </td>
                            <td>${p.hsn_code || '-'}</td>
                            <td class="text-center">${p.qty}</td>
                            <td class="text-end">${parseFloat(p.mrp || 0).toFixed(2)}</td>
                            <td class="text-end fw-bold">${parseFloat(p.sales_price || 0).toFixed(2)}</td>
                        </tr>`;
                            });

                        } else {
                            productRows =
                                '<tr><td colspan="6" class="text-center text-muted">No products found</td></tr>';
                        }


                        /* ================= PAYMENTS ================= */

                        let paymentRows = '';

                        if (payments.length > 0) {

                            payments.forEach(function(pay, i) {

                                paymentRows += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${pay.payment_method || pay.payment_id || '-'}</td>
                            <td class="text-end">${parseFloat(pay.recieved_amount || 0).toFixed(2)}</td>
                            <td>${pay.transaction_no ?? '-'}</td>
                            <td>${pay.card_no ?? pay.cheque_no ?? pay.bank_acc ?? '-'}</td>
                        </tr>`;
                            });

                        } else {

                            paymentRows = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No payment records
                        </td>
                    </tr>`;
                        }


                        /* ================= MODAL HTML ================= */

                        var html = `
            <div class="row mb-4">
                <div class="col-md-6 border-end">

                    <h6 class="fw-bold text-primary mb-3">Invoice Info</h6>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Invoice No:</span>
                        <span>${d.invoice_no}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Date:</span>
                        <span>${d.sale_date}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Location:</span>
                        <span>${d.location_name}</span>
                    </div>

                    <h6 class="fw-bold text-primary mt-4 mb-3">Customer Details</h6>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Name:</span>
                        <span>${d.customer_name}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Mobile:</span>
                        <span>${d.mobile_no}</span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">Email:</span>
                        <span>${d.email}</span>
                    </div>

                </div>

                <div class="col-md-6 ps-4">

                    <h6 class="fw-bold text-primary mb-3">Payment Status</h6>

                    <div class="d-flex mb-2 align-items-center">
                        <span class="fw-semibold me-2 w-25">Bill Status:</span>
                        <span class="badge bg-${d.bill_status === 'Paid' ? 'success' : 'warning'}">
                            ${d.bill_status}
                        </span>
                    </div>

                    <div class="d-flex mb-2">
                        <span class="fw-semibold me-2 w-25">GST No:</span>
                        <span>${d.gst_number || 'N/A'}</span>
                    </div>

                    <div class="p-3 bg-light rounded border mt-3">

                        <div class="d-flex justify-content-between text-muted">
                            <span>GST Amount:</span>
                            <span>+ ${parseFloat(d.gst_amount || 0).toFixed(2)}</span>
                        </div>

                        <div class="d-flex justify-content-between text-muted">
                            <span>TCS Amount:</span>
                            <span>+ ${parseFloat(d.tcs_display || 0).toFixed(2)}</span>
                        </div>

                        <div class="d-flex justify-content-between text-danger">
                            <span>Discount:</span>
                            <span>- ${parseFloat(d.discount || 0).toFixed(2)}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fs-5 fw-bold text-primary">
                            <span>Grand Total:</span>
                            <span>${parseFloat(d.finalTotal || 0).toFixed(2)}</span>
                        </div>

                        <div class="d-flex justify-content-between small text-muted">
                            <span>Paid:</span>
                            <span>${parseFloat(d.payment_split_amount || 0).toFixed(2)}</span>
                        </div>

                        <div class="d-flex justify-content-between small text-danger fw-bold">
                            <span>Balance:</span>
                            <span>${parseFloat(d.remaining_amount || 0).toFixed(2)}</span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- PRODUCTS -->
            <div class="table-responsive border rounded-2 mt-2">
                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>HSN</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">MRP</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>${productRows}</tbody>
                </table>
            </div>

            <!-- PAYMENTS -->
            <div class="table-responsive border rounded-2 mt-4">
                <h6 class="fw-bold text-primary p-2">Payment Details</h6>

                <table class="table table-bordered mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Method</th>
                            <th class="text-end">Amount</th>
                            <th>Transaction No</th>
                            <th>Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${paymentRows}
                    </tbody>
                </table>
            </div>
            `;

                        $('#saleDetailsContent').html(html);
                        $('#viewSaleModal').modal('show');
                    }
                });
            });



            $(document).on('click', '.delete-sale', function() {
                let id = $(this).data('id');
                let url = "{{ route('sales.delete') }}"; // Ensure this route exists in web.php

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.status === 200) {
                                    // 1. Show Success Alert
                                    Swal.fire(
                                        'Deleted!',
                                        res.message,
                                        'success'
                                    );

                                    // 2. Reload DataTable immediately (Fixes "page load only" issue)
                                    if ($.fn.DataTable.isDataTable('#salesTable')) {
                                        $('#salesTable').DataTable().ajax.reload(null,
                                            false); // false keeps current paging
                                    }
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        res.message,
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.printSale', function() {
                let salesId = $(this).data('id');
                let url = "{{ route('sales.print', ':id') }}".replace(':id', salesId);


                window.open(url, '_blank');

            });

            $(document).on('click', '.editSales', function() {

                let saleId = $(this).data('id');

                // redirect with edit id
                window.location.href =
                    "{{ route('sales.index') }}?edit_id=" + saleId;
            });



        });
    </script>


    <script>
        $(document).ready(function() {
            outStockProduct = $('#outStockProduct').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('out-stock-product') }}",

                columns: [{
                        data: 'sr_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pro_image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type) {
                            if (!data) return '';
                            if (type === 'display') return data;
                            return data;
                        }
                    },
                    {
                        data: 'pro_name'
                    },
                    {
                        data: 'brand'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'pro_sku'
                    },
                    {
                        data: 'business_location'
                    },
                    {
                        data: 'purchase_price'
                    },
                    {
                        data: 'selling_price'
                    },
                    {
                        data: 'box'
                    },
                    {
                        data: 'paper'
                    }
                ],

                columnDefs: [{
                    targets: '_all',
                    className: 'text-start'
                }],

                lengthMenu: [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],
                pageLength: 5,

                dom: "<'row mb-2 align-items-center'" +
                    "<'col-lg-2 col-md-3'l>" +
                    "<'col-lg-7 col-md-6 text-center'>" +
                    "<'col-lg-3 col-md-3 text-end'f>" +
                    ">" +
                    "rtip"
            });


            $('#refreshOutStock').on('click', function() {

                let btn = $(this);
                btn.html("<i class='bx bx-loader-alt bx-spin'></i> Refreshing");

                outStockProduct.ajax.reload(function() {
                    btn.html("<i class='bx bx-refresh'></i> Refresh");
                }, false);

            });


            function formatIndianDate(dateStr) {
                if (!dateStr) return '-';

                const [year, month, day] = dateStr.split('-');
                return `${day}-${month}-${year}`;
            }



            // View product modal

            $(document).on('click', '.viewStockOut', function() {
                var id = $(this).data('id');

               

                var modalContent = $('#viewModalStockOut');

                // Show Modal & Spinner
                $('#stockOutModal').modal('show');
                modalContent.html(
                    '<div class="text-center w-100 py-5"><div class="spinner-border text-primary" role="status"></div></div>'
                );

                 var url = "{{ route('product.show', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response.status === 200) {
                            var d = response.data;

                            // --- Helpers ---
                            var checkNull = (val) => (val === null || val === '') ? 'N/A' : val;
                            var yesNoBadge = (val) => val == 1 ?
                                '<span class="badge bg-success">Yes</span>' :
                                '<span class="badge bg-light text-dark border">No</span>';
                            var boolBadge = (val, text) => val == 1 ?
                                `<span class="badge bg-primary me-1 mb-1">${text}</span>` : '';

                            var formatLabel = (val) => (val === null || val === '') ? 'N/A' :
                                val
                                .replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                            // --- Image Logic ---
                            var brandFolder = d.brand_folder;
                            var productFolder = d.product_folder;

                            var baseUrl = "{{ $actual_url . '/admin_assets/brand/' }}" +
                                brandFolder + "/" +
                                productFolder + "/";

                            // Main Image
                            var mainImgHtml = d.pro_image ?
                                `<div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3 d-flex align-items-center justify-content-center">
                            <img src="${baseUrl}image/${d.pro_image}" class="img-fluid rounded" style="max-height: 280px; object-fit: contain;">
                        </div>
                    </div>` :
                                `<div class="card border h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                            <i class="bi bi-image display-4 mb-3"></i>
                            <span>No Main Image</span>
                        </div>
                    </div>`;

                            // Gallery Images - Scrollable
                            var galleryHtml = '';
                            if (d.pro_gallery && d.pro_gallery.trim() !== '') {
                                var images = d.pro_gallery.split(',');
                                galleryHtml = `
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-0 py-3">
                                <h6 class="mb-0 fw-semibold text-dark">Gallery</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="gallery-scroll" style="max-height: 200px; overflow-y: auto; overflow-x:hidden;">
                                    <div class="row g-2">
                    `;
                                images.forEach(img => {
                                    galleryHtml += `
                            <div class="col-4 col-md-6">
                                <div class="gallery-item position-relative">
                                    <img src="${baseUrl}gallery/${img}" class="img-fluid rounded border" style="height: 80px; width: 100%; object-fit: cover;">
                                </div>
                            </div>
                        `;
                                });
                                galleryHtml += `
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                            } else {
                                galleryHtml = `
                        <div class="card border h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                                <i class="bi bi-images display-4 mb-3"></i>
                                <span>No Gallery Images</span>
                            </div>
                        </div>
                    `;
                            }

                            // --- Brochure & Video Links ---
                            var brochureBase = "{{ $actual_url . '/admin_assets/brand/' }}";

                            var brochureLink = d.pro_brochure ?
                                `<a href="${brochureBase}${brandFolder}/${productFolder}/brochure/${d.pro_brochure}"
       target="_blank"
       class="btn btn-sm btn-outline-primary mb-0 ">
        <i class="bi bi-file-earmark-pdf me-1"></i> Download Brochure
    </a>` : '';

                            var videoHtml = '';
                            if (d.video_source) {
                                if (d.video_type === 'file') {
                                    // Local File
                                    var videoBase =
                                        "{{ $actual_url . '/admin_assets/brand/' }}";
                                    var videoUrl = videoBase + brandFolder + "/" +
                                        productFolder + "/video/" + d.video_source;

                                    videoHtml = `
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-transparent border-0 py-3">
                                    <h6 class="mb-0 fw-semibold text-dark">Video Preview</h6>
                                </div>
                                <div class="card-body p-3">
                                    <video controls class="w-100 rounded" style="height: 150px; object-fit: cover;">
                                        <source src="${videoUrl}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        `;
                                } else if (d.video_type === 'youtube' || d.video_type ===
                                    'vimeo') {
                                    // External Link
                                    videoHtml = `
                            <div class="card border h-100">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                                    <i class="bi bi-play-circle display-4 text-danger mb-3"></i>
                                    <h6 class="fw-semibold">Watch Video</h6>
                                    <p class="text-muted small text-center mb-3">Available on ${d.video_type.charAt(0).toUpperCase() + d.video_type.slice(1)}</p>
                                    <a href="${d.video_source}" target="_blank" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-play-circle me-1"></i> Watch Now
                                    </a>
                                </div>
                            </div>
                        `;
                                }
                            } else {
                                videoHtml = `
                        <div class="card border h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted">
                                <i class="bi bi-camera-video display-4 mb-3"></i>
                                <span>No Video Available</span>
                            </div>
                        </div>
                    `;
                            }

                            // --- Price Formatting ---
                            var formatPrice = (price) => {
                                if (!price) return 'N/A';
                                return '₹' + parseFloat(price).toLocaleString('en-IN');
                            };

                            // --- Construct HTML ---
                            var html = `
                    <!-- Product Header -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4 class="fw-bold text-dark mb-1">${checkNull(d.pro_name)}</h4>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="badge bg-primary">${checkNull(d.pro_model)}</span>
                                <span class="badge bg-info text-dark">${checkNull(d.pro_ref_num)}</span>
                                <span class="badge bg-light text-dark border">${checkNull(d.brand_name)}</span>
                            </div>
                            <p class="text-muted mb-0">${checkNull(d.pro_model_name)}</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex flex-column">
                                <span class="text-muted small">Current Price</span>
                                <h3 class="fw-bold text-success mb-0">${formatPrice(d.selling_price_exclusive)}</h3>
                                <span class="text-muted small">Exclusive of Tax</span>
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="row mb-2">
                        <div class="col-md-4 mb-3">
                            ${mainImgHtml}
                        </div>
                        <div class="col-md-4 mb-3">
                            ${galleryHtml}
                        </div>
                        <div class="col-md-4 mb-3">
                            ${videoHtml}

                        </div>
                    </div>



                    <!-- Product Information Tabs -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-tabs-custom" id="productTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                        <i class="bi bi-info-circle me-2"></i>Basic Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" type="button" role="tab">
                                        <i class="bi bi-palette me-2"></i>Design
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">
                                        <i class="bi bi-gear me-2"></i>Features
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="business-tab" data-bs-toggle="tab" data-bs-target="#business" type="button" role="tab">
                                        <i class="bi bi-graph-up me-2"></i>Business
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content p-4" id="productTabContent">
                                <!-- Basic Info Tab -->
                                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Product Type</label>
                                            <div class="fw-medium">${checkNull(d.pro_type)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Gender</label>
                                            <div class="fw-medium">${checkNull(d.pro_gender)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">SKU</label>
                                            <div class="fw-bold text-primary">${checkNull(d.pro_sku)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Collection</label>
                                            <div>${checkNull(d.collection)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Watch Category</label>
                                            <div>${checkNull(d.watch_category)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Watch Type</label>
                                            <div>${checkNull(d.watch_type_name)}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Design Tab -->
                                <div class="tab-pane fade" id="design" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Dial Color</label>
                                            <div>${checkNull(d.dial_color_name)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Case Material</label>
                                            <div>${checkNull(d.case_material)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Strap Material</label>
                                            <div>${checkNull(d.strap_material)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Glass</label>
                                            <div>${checkNull(d.glass_name)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Case Shape</label>
                                            <div>${checkNull(d.case_shape)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Dial Diameter</label>
                                            <div>${checkNull(d.dial_diameter)} mm</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Water Resistance</label>
                                            <div>${checkNull(d.water_resistance)}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label text-muted small mb-1">Movement</label>
                                            <div class="fw-medium">${checkNull(d.movement_name)}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features Tab -->
                                <div class="tab-pane fade" id="features" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Brand Warranty</label>
                                            <div>${yesNoBadge(d.brand_warranty)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Service Card</label>
                                            <div>${yesNoBadge(d.service_card)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Box Included</label>
                                            <div>${checkNull(d.box)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Papers</label>
                                            <div>${checkNull(d.paper)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Origin Country</label>
                                            <div>${checkNull(d.origin_country_name)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Manufacturer</label>
                                            <div>${checkNull(d.manufacturer_name)}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label text-muted small mb-1">Functionality</label>
                                            <div class="bg-light p-3 rounded">${checkNull(d.functionality)}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Tab -->
                                <div class="tab-pane fade" id="business" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Condition</label>
                                            <div class="fw-bold ${d.condition === 'New' ? 'text-success' : 'text-warning'}">${checkNull(d.condition)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Quantity</label>
                                            <div class="fw-bold ${d.quantity > 0 ? 'text-success' : 'text-danger'}">${checkNull(d.quantity)}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label text-muted small mb-1">Physical Location</label>
                                            <div class="fw-medium">${checkNull(d.physical_location_name)}</div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label text-muted small mb-1">
                                                Display Locations ${(d.display_location_name && d.display_location_name !== '-')
                                    ? `(${d.display_location_name.split(",").length})`
                                    : "(0)"
                                }
                                            </label>

                                            <ol class="mb-0 ps-3">
                                                ${(d.display_location_name && d.display_location_name !== '-')
                                    ? d.display_location_name
                                        .split(",")
                                        .map(loc => `<li>${loc.trim()}</li>`)
                                        .join("")
                                    : "<li>Not Available</li>"
                                }
                                            </ol>
                                        </div>


                                        <!-- Pricing Section -->
                                        <div class="col-12 mt-4">
                                            <h6 class="border-bottom pb-2 mb-3">Pricing Details</h6>
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Purchase Price</label>
                                                    <div class="fw-medium">${formatPrice(d.purchase_price_exclusive)}</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Margin</label>
                                                    <div class="fw-medium">${checkNull(d.pro_margin)}%</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Selling Price</label>
                                                    <div class="fw-bold text-success">${formatPrice(d.selling_price_exclusive)}</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-muted small mb-1">Tax Rate</label>
                                                    <div>${checkNull(d.pro_tax)}%</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status Flags -->
                                        <div class="col-12 mt-4">
                                            <h6 class="border-bottom pb-2 mb-3">Status</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                ${boolBadge(d.new_arrival, 'New Arrival')}
                                                ${boolBadge(d.manage_stock, 'Stock Managed')}
                                                ${boolBadge(d.out_stock, 'Out of Stock')}
                                                ${boolBadge(d.not_for_selling, 'Not for Sale')}
                                                ${boolBadge(d.tata_cliq_product, 'Tata Cliq Exclusive')}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card -->
                    <div class="card border-0 shadow-sm mt-4">
                   <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">

    <h6 class="mb-0 fw-semibold text-dark">
        <i class="bi bi-card-text me-2"></i>Product Description
    </h6>

    ${d.pro_brochure ? brochureLink : ''}

</div>
                        <div class="card-body">
                            <p class="mb-0 text-muted">${checkNull(d.product_desc)}</p>
                        </div>
                    </div>
                `;
                            modalContent.html(html);
                        } else {
                            modalContent.html(
                                '<div class="alert alert-danger text-center">Failed to load product data. Please try again.</div>'
                            );
                        }
                    },
                    error: function() {
                        modalContent.html(
                            '<div class="alert alert-danger text-center">Something went wrong. Please check your connection and try again.</div>'
                        );
                    }
                });
            });
        });
    </script>

</body>

</html>
