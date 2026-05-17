<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Business_location;
use App\Http\Controllers\ContactMasterController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\EcomController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\FrontSetting;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProSettingController;
use App\Http\Controllers\QuickSaleData;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SMTPController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TCSController;
use App\Http\Controllers\UserManagement;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', [FrontEndController::class, 'home'])->name('home');

Route::get('/login', function () {

    /*
    |----------------------------------------------------------
    | IF SESSION EXISTS → REDIRECT TO DASHBOARD
    |----------------------------------------------------------
    */
    if (Cookie::has('remember_login')) {
        return redirect()->route('dashboard');
    }
    /*
    |----------------------------------------------------------
    | AUTO LOGIN USING REMEMBER-ME COOKIE
    |----------------------------------------------------------
    */
    if (Cookie::has('remember_login')) {

        $cookie = json_decode(Cookie::get('remember_login'), true);

        if (! empty($cookie['type']) && ! empty($cookie['id'])) {

            /* ================= SUPER ADMIN ================= */
            if ($cookie['type'] === 'super_admin') {

                $admin = DB::table('super_admin')
                    ->where('sp_id', $cookie['id'])
                    ->first();

                if ($admin) {
                    Session::put('login_type', 'super_admin');
                    Session::put('super_admin_id', $admin->sp_id);
                    Session::put('super_admin_username', $admin->sp_username);

                    return redirect()->route('dashboard');
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

                    return redirect()->route('dashboard');
                }
            }
        }
    }

    /*
    |----------------------------------------------------------
    | NO SESSION & NO COOKIE → SHOW LOGIN
    |----------------------------------------------------------
    */
    return view('login');
})->name('login');

// web.php
Route::post('/login', [AuthController::class, 'login'])->name('login.check');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// ForgotpasswordReset
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('password.update');

Route::middleware(['checklogin'])->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard')->middleware('menu.permission');
    Route::post('/dashboard/total-sell', [Dashboard::class, 'getTotalSell'])->name('dashboard.totalSell');
    Route::get('/dashboard/location-sales-chart', [Dashboard::class, 'locationSalesChart'])->name('dashboard.locationSalesChart');
    Route::get('/stock/in/pending', [Dashboard::class, 'stockinpending'])->name('stock.in.pending');
    Route::get('/draft/invoice', [Dashboard::class, 'draftinvoicelist'])->name('draft-invoice');
    Route::get('outstock/product', [Dashboard::class, 'out_stock_product'])->name('out-stock-product');

    // USERMANAGEMENT
    Route::get('/users', [UserManagement::class, 'usersindex'])->name('create.users')->middleware('menu.permission');
    Route::get('/roles', [UserManagement::class, 'rolesindex'])->name('roles.index')->middleware('menu.permission');
    Route::get('/roles/list', [UserManagement::class, 'list'])->name('roles.list');
    Route::post('/roles/store', [UserManagement::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [UserManagement::class, 'edit'])->name('roles.edit');
    Route::post('/roles/delete', [UserManagement::class, 'softDelete'])->name('roles.delete');
    Route::post('/staff/store', [UserManagement::class, 'storeuser'])->name('staff.store');
    Route::get('/users/list', [UserManagement::class, 'userlist'])->name('users.list');
    Route::get('/users/view/{id}', [UserManagement::class, 'userview'])->name('users.view');
    Route::get('/users/edit/{id}', [UserManagement::class, 'edit'])->name('users.edit');
    Route::get('/user-logs', [UserManagement::class, 'activityLogs'])->name('user.logs');

    // Profile by chirag
    Route::get('/profile', [UserManagement::class, 'profile_index'])->name('profile.users');
    Route::post('/profile/update-image', [UserManagement::class, 'updateImage'])->name('profile.image.update');
    Route::post('/change-password', [UserManagement::class, 'changePassword'])->name('change.password');

    // update profile
    Route::post('/profile/update', [UserManagement::class, 'update'])->name('profile.update');

    Route::get('/staff/{id}/edit', [UserManagement::class, 'editUsers'])->name('staff.edit');
    Route::post('/staff/delete', [UserManagement::class, 'deleteUser'])->name('staff.delete');

    Route::get('/staffinfo/{id}/edit', [UserManagement::class, 'editUsersInfo'])->name('staffinfo.edit');
    Route::post('/staff-doc/store', [UserManagement::class, 'staffdocstore'])->name('staff.doc.store');
    Route::get('/staff-doc/list/{staff_id}', [UserManagement::class, 'staffdoclist'])->name('staff.doc.list');
    Route::get('/staff/doc/{id}', [UserManagement::class, 'staffDocShow'])->name('staff.doc.show');
    Route::get('/staff/doc/edit/{id}', [UserManagement::class, 'staffDocEdit'])->name('staff.doc.edit');

    // Business Location
    Route::get('/bussiness-location', [Business_location::class, 'index'])->name('location.index')->middleware('menu.permission');
    Route::post('/bussiness-location/store', [Business_location::class, 'store'])->name('business_location.store');
    Route::get('/business-location/list', [Business_location::class, 'list'])->name('business_location.list');
    Route::get('/business-location/edit/{id}', [Business_location::class, 'edit'])->name('business_location.edit');
    Route::post('/business-location/update', [Business_location::class, 'update'])->name('business_location.update');
    Route::post('/business-location/delete', [Business_location::class, 'destroy'])->name('business_location.delete');


    // Tax
    Route::get('/tax', [TaxController::class, 'index'])->name('tax.index')->middleware('menu.permission');
    Route::get('/tax/list', [TaxController::class, 'list'])->name('tax.list');
    Route::post('/tax/store', [TaxController::class, 'store'])->name('tax.store');
    Route::get('/tax/edit/{id}', [TaxController::class, 'edit'])->name('tax.edit');
    Route::post('/tax/update', [TaxController::class, 'update'])->name('tax.update');
    Route::post('/tax/delete', [TaxController::class, 'destroy'])->name('tax.delete');

    // Products Management
    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('menu.permission');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/list', [ProductController::class, 'list'])->name('product.list');
    Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/delete', [ProductController::class, 'delete'])->name('product.delete');

    Route::get('/products/view', [ProductController::class, 'view'])->name('products.view')->middleware('menu.permission');
    Route::get('/product/details', [ProductController::class, 'viewProduct'])->name('product.details');

    Route::get('/auction/view', [ProductController::class, 'auction_view'])->name('auction.view')->middleware('menu.permission');
    Route::get('/auction/details', [ProductController::class, 'viewAuction'])->name('auction.details');

    Route::get('/tatacliq/view', [ProductController::class, 'tatacliq_view'])->name('tatacliq.view')->middleware('menu.permission');
    Route::post('/tatacliq/details', [ProductController::class, 'viewtatacliq'])->name('tatacliq.details');

    Route::get('/pending/product', [ProductController::class, 'pendingproduct'])->name('pendingproduct.view')->middleware('menu.permission');
    Route::get('/pendingpro/details', [ProductController::class, 'viewPendingProducts'])->name('pendingpro.details');
    Route::post('/product/approve', [ProductController::class, 'approveProduct'])->name('product.approve');
    Route::post('/product/reject', [ProductController::class, 'rejectProduct'])->name('product.reject');

    // by faazil (product search - stock)
    Route::get('/product/search-autocomplete', [ProductController::class, 'search'])->name('product.search_autocomplete');
    // inventory routes
    Route::get('/inventory', [ProductController::class, 'inventory'])->name('product.inventory')->middleware('menu.permission');
    Route::get('/inventory/list', [ProductController::class, 'inventoryList'])->name('product.inventory_list');

    // fetchstock location wiese
    Route::get('/product/fetch-stock-locations', [ProductController::class, 'fetchStockLocations'])->name('product.fetchStockLocations');
    Route::post('/product/add-stock', [ProductController::class, 'addStock'])->name('product.addStock');
    Route::get('/product/stock-history', [ProductController::class, 'fetchStockHistory'])->name('product.fetchStockHistory');

    //product Duplication
    Route::get('/get-product-data', [ProductController::class, 'getProductData'])->name('product.getData');
    Route::post('/duplicate-product', [ProductController::class, 'duplicateProduct'])->name('duplicate.product');

    // Notification
    Route::post('/notification/mark-read', [NotificationController::class, 'markRead'])->name('notification.markRead');

    // Porduct Setting
    Route::get('/pro-setting', [ProSettingController::class, 'index'])->name('prosetting.index')->middleware('menu.permission');
    Route::post('/brand/store', [ProSettingController::class, 'brandstore'])->name('brand.store');
    Route::get('/brand/list', [ProSettingController::class, 'brandlist'])->name('brand.list');
    Route::get('/brand/{id}', [ProSettingController::class, 'brandedit'])->name('brand.edit');
    Route::post('/brand/soft-delete/{id}', [ProSettingController::class, 'brandSoftDelete'])->name('brand.soft.delete');
    Route::post('/watch/store', [ProSettingController::class, 'watchstore'])->name('watch.store');
    Route::get('/watch/list', [ProSettingController::class, 'watchlist'])->name('watch.list');
    Route::get('/watch/{id}', [ProSettingController::class, 'watchedit'])->name('watch.edit');
    Route::post('/watch/soft-delete/{id}', [ProSettingController::class, 'watchSoftDelete'])->name('watch.soft.delete');

    Route::post('/glass/store', [ProSettingController::class, 'glassstore'])->name('glass.store');
    Route::get('/glass/list', [ProSettingController::class, 'glasslist'])->name('glass.list');
    Route::get('/glass/{id}', [ProSettingController::class, 'glassedit'])->name('glass.edit');
    Route::post('/glass/soft-delete/{id}', [ProSettingController::class, 'glassSoftDelete'])->name('glass.soft.delete');

    Route::post('/colour/store', [ProSettingController::class, 'colourstore'])->name('colour.store');
    Route::get('/colour/list', [ProSettingController::class, 'colourlist'])->name('colour.list');
    Route::get('/colour/{id}', [ProSettingController::class, 'colouredit'])->name('colour.edit');
    Route::post('/colour/soft-delete/{id}', [ProSettingController::class, 'colourSoftDelete'])->name('colour.soft.delete');

    Route::post('/movement/store', [ProSettingController::class, 'movementstore'])->name('movement.store');
    Route::get('/movement/list', [ProSettingController::class, 'movementlist'])->name('movement.list');
    Route::get('/movement/{id}', [ProSettingController::class, 'movementedit'])->name('movement.edit');
    Route::post('/movement/soft-delete/{id}', [ProSettingController::class, 'movementSoftDelete'])->name('movement.soft.delete');

    Route::post('/email/store', [ProSettingController::class, 'Emailstore'])->name('email.store');
    Route::get('/email/list', [ProSettingController::class, 'Emaillist'])->name('email.list');
    Route::get('/email/edit/{id}', [ProSettingController::class, 'emailedit'])->name('email.edit');
    Route::post('/email/delete/{id}', [ProSettingController::class, 'Emaildelete'])->name('email.delete');

    Route::get('/smtp/index', [SMTPController::class, 'index'])->name('smtp.index')->middleware('menu.permission');
    Route::post('/smtp/update', [SMTPController::class, 'smtpupdate'])->name('smtp.update');
    Route::get('/settings/smtp/test-mail', [SMTPController::class, 'testSmtpMail'])->name('smtp.test.mail');

    // Stock Management
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index')->middleware('menu.permission');
    Route::post('/stock/transfer/store', [StockController::class, 'store'])->name('stock.transfer.store');
    Route::get('/stock/transfer/list', [StockController::class, 'list'])->name('stock.transfer.list');
    Route::get('/stock/transfer/products/{id}', [StockController::class, 'viewProducts'])->name('stock.transfer.products');
    Route::post('/stock-transfer/update-status', [StockController::class, 'updateStatus'])->name('stock.transfer.updateStatus');
    Route::get('stock-transfers/print/{id}', [StockController::class, 'printInvoice'])->name('stock.transfer.print');
    Route::get('/stock-transfer/edit/{id}', [StockController::class, 'edit'])->name('stock.transfer.edit');
    Route::post('/stock-transfer/received', [StockController::class, 'markReceived'])->name('stock.transfer.received');
    Route::get('/stock/in', [StockController::class, 'stockIn'])->name('stock-in.index')->middleware('menu.permission');
    Route::get('/stock/in/list', [StockController::class, 'stockInlist'])->name('stock.in.list');
    Route::get('/stock/out', [StockController::class, 'stockOut'])->name('stock-out.index')->middleware('menu.permission');
    Route::get('/stock/out/list', [StockController::class, 'stockOutlist'])->name('stock.out.list');
    Route::post('/stock/reject', [StockController::class, 'reject'])->name('stock.reject');

    // Front Setting - Slider Management
    Route::get('/sliders', [FrontSetting::class, 'slider_index'])->name('slider.index')->middleware('menu.permission');
    Route::get('/slider/list', [FrontSetting::class, 'slider_list'])->name('slider.list');
    Route::post('/slider/store', [FrontSetting::class, 'slider_store'])->name('slider.store');
    Route::get('/slider/edit/{id}', [FrontSetting::class, 'slider_edit'])->name('slider.edit');
    Route::post('/slider/delete', [FrontSetting::class, 'slider_delete'])->name('slider.delete');

    // Front Settings - Client Reviews
    Route::get('/clients', [FrontSetting::class, 'client_index'])->name('client.index')->middleware('menu.permission');
    Route::get('/client/list', [FrontSetting::class, 'client_list'])->name('client.list');
    Route::post('/client/store', [FrontSetting::class, 'client_store'])->name('client.store');
    Route::get('/client/edit/{id}', [FrontSetting::class, 'client_edit'])->name('client.edit');
    Route::post('/client/delete', [FrontSetting::class, 'client_delete'])->name('client.delete');

    // Front Settings - Home Page Content
    Route::get('/home-content', [FrontSetting::class, 'home_content_index'])->name('home_content.index')->middleware('menu.permission');
    Route::post('/home-content/update', [FrontSetting::class, 'home_content_update'])->name('home_content.update');

    // Front Settings - About Page Content
    Route::get('/about-content', [FrontSetting::class, 'about_content_index'])->name('about_content.index')->middleware('menu.permission');
    Route::post('/about-content/update', [FrontSetting::class, 'about_content_update'])->name('about_content.update');

    // Front Settings - Contact List
    Route::get('/contacts-list', [FrontSetting::class, 'contact_index'])->name('contact.index')->middleware('menu.permission');
    Route::get('/contact/list-data', [FrontSetting::class, 'contact_list_data'])->name('contact.list.data');
    Route::get('/contact/show/{id}', [FrontSetting::class, 'contact_show'])->name('contact.show');
    Route::post('/contact/delete', [FrontSetting::class, 'contact_delete'])->name('contact.delete');

    Route::post('/contact/followup/store', [FrontSetting::class, 'followup_store'])->name('contact.followup.store');
    Route::get('/contact/followup/list/{id}', [FrontSetting::class, 'followup_list'])->name('contact.followup.list');
    Route::post('/contact/followup/delete', [FrontSetting::class, 'followup_delete'])->name('contact.followup.delete');

    // Product Enquiry Routes
    Route::get('/product-enquiries', [FrontSetting::class, 'product_enquiry_index'])->name('product.enquiry.index')->middleware('menu.permission');
    Route::get('/product-enquiry/data', [FrontSetting::class, 'product_enquiry_data'])->name('product.enquiry.data');
    Route::get('/product-enquiry/show/{id}', [FrontSetting::class, 'product_enquiry_show'])->name('product.enquiry.show');
    Route::post('/product-enquiry/delete', [FrontSetting::class, 'product_enquiry_delete'])->name('product.enquiry.delete');

    // Product Followup Routes
    Route::post('/product-enquiry/followup/store', [FrontSetting::class, 'product_followup_store'])->name('product.followup.store');
    Route::get('/product-enquiry/followup/list/{id}', [FrontSetting::class, 'product_followup_list'])->name('product.followup.list');
    Route::post('/product-enquiry/followup/delete', [FrontSetting::class, 'product_followup_delete'])->name('product.followup.delete');

    //Product Enquiry Store
    Route::post('/enquiry-store', [FrontSetting::class, 'store'])->name('enquiry.store');


    Route::get('/product.selling.index', [FrontSetting::class, 'product_selling_index'])->name('product.selling.index')->middleware('menu.permission');
    Route::get('/product-selling/list', [FrontSetting::class, 'product_selling_list'])->name('product.selling.list');
    Route::get('/product-selling/show/{id}', [FrontSetting::class, 'product_selling_show'])->name('product.selling.show');
    Route::post('/product-selling/delete', [FrontSetting::class, 'product_selling_delete'])->name('product.selling.delete');
    Route::post('/selling/followup/store', [FrontSetting::class, 'product_sell_followup_store'])->name('selling_product.followup.store');
    Route::get('/selling/followup/list/{id}', [FrontSetting::class, 'product_sell_followup_list'])->name('selling_product.followup.list');
    Route::post('/selling/followup/delete', [FrontSetting::class, 'product_sell_followup_delete'])->name('selling_product.followup.delete');

    Route::get('/product.trading.index', [FrontSetting::class, 'product_trading_index'])->name('product.trading.index')->middleware('menu.permission');
    Route::get('/product-trading/list', [FrontSetting::class, 'product_trading_list'])->name('product.trading.list');
    Route::get('/product-trading/show/{id}', [FrontSetting::class, 'product_trading_show'])->name('product.trading.show');
    Route::post('/product-trading/delete', [FrontSetting::class, 'product_trading_delete'])->name('product.trading.delete');
    Route::post('/trading/followup/store', [FrontSetting::class, 'product_trade_followup_store'])->name('trading_product.followup.store');
    Route::get('/trading/followup/list/{id}', [FrontSetting::class, 'product_trade_followup_list'])->name('trading_product.followup.list');
    Route::post('/trading/followup/delete', [FrontSetting::class, 'product_trade_followup_delete'])->name('trading_product.followup.delete');

    // Store Customer Routes
    Route::get('/contact-master', [ContactMasterController::class, 'index'])->name('contact.master.index')->middleware('menu.permission');
    Route::get('/contact-master/list', [ContactMasterController::class, 'list'])->name('contact.master.list');
    Route::post('/contact-master/store', [ContactMasterController::class, 'store'])->name('contact.master.store');
    Route::get('/contact-master/show/{id}', [ContactMasterController::class, 'show'])->name('contact.master.show');
    Route::post('/contact-master/toggle', [ContactMasterController::class, 'toggle_status'])->name('contact.master.toggle');
    Route::post('/contact-master/delete', [ContactMasterController::class, 'delete'])->name('contact.master.delete');
    Route::get('/contact-master/view/{id}', [ContactMasterController::class, 'view_contact'])->name('contact.master.view');
    Route::get('/contact/next-id', [ContactMasterController::class, 'getNextContactId'])->name('contact.next.id');

    // Online Customer
    Route::get('ecom/customer', [ContactMasterController::class, 'ecom_cust'])->name('ecom.customer.index')->middleware('menu.permission');
    Route::get('/ecom-cust/list', [ContactMasterController::class, 'ecomlist'])->name('ecom.cust.list');
    Route::get('/ecom-cust/view/{id}', [ContactMasterController::class, 'view_ecomcust'])->name('contact.ecom_cust.view');

    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/get-customer', [SalesController::class, 'getCustomerDetails'])->name('sales.get_customer');
    Route::get('/sales/list', [SalesController::class, 'list'])->name('sales.list');
    Route::post('/sales/store', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/sales/show/{id}', [SalesController::class, 'show'])->name('sales.show');
    Route::get('/sales/edit/{id}', [SalesController::class, 'edit'])->name('sales.edit');
    Route::post('/sales/delete', [SalesController::class, 'delete'])->name('sales.delete');
    Route::get('/sales/generate-invoice', [SalesController::class, 'generateInvoice'])->name('sales.generate.invoice');
    Route::get('/sales/print/{id}', [SalesController::class, 'printInvoice'])->name('sales.print');

    Route::post('/sales/store-walk-in', [SalesController::class, 'storeWalkInCustomer'])->name('sales.store_walk_in');

    // Sales Return Routes
    Route::get('/sales/return', [SalesController::class, 'sales_return_index'])->name('sales.return.index')->middleware('menu.permission');
    Route::get('/sales/return/list', [SalesController::class, 'sales_return_list'])->name('sales.return.list');

    // Pending Sales Routes
    Route::get('/sales/pending', [SalesController::class, 'pending_sales_index'])->name('sales.pending.index')->middleware('menu.permission');
    Route::get('/sales/pending/list', [SalesController::class, 'pending_sales_list'])->name('sales.pending.list');
    Route::post('/sales/cancel', [SalesController::class, 'cancel_sale'])->name('sales.cancel');
    Route::get('/sales/pending/edit/{id}', [SalesController::class, 'editPending'])->name('sales.pending.edit');
    Route::post('/sales/pending/update', [SalesController::class, 'updatePending'])->name('sales.pending.update');
    Route::post('/sales/pending/delete', [SalesController::class, 'delete_sale'])->name('sales.pending.delete');
    Route::post('/sales/approve', [SalesController::class, 'approve_sale'])->name('sales.approve');

    // Cancel Sales routes
    Route::get('/sales/cancelled', [SalesController::class, 'cancel_sales_index'])->name('sales.cancelled.index')->middleware('menu.permission');
    Route::get('/sales/cancelled/list', [SalesController::class, 'cancel_sales_list'])->name('sales.cancelled.list');

    // TCS Routes
    Route::get('/tcs', [TCSController::class, 'index'])->name('tcs.index')->middleware('menu.permission');
    Route::get('/tcs/list', [TCSController::class, 'list'])->name('tcs.list');
    Route::post('/tcs/store', [TCSController::class, 'store'])->name('tcs.store');
    Route::get('/tcs/edit', [TCSController::class, 'edit'])->name('tcs.edit');
    Route::post('/tcs/update', [TCSController::class, 'update'])->name('tcs.update');
    Route::post('/tcs/delete', [TCSController::class, 'destroy'])->name('tcs.delete');

    // Quick sale routes
    Route::get('/quicksale', [QuickSaleData::class, 'index'])->name('quicksale.index')->middleware('menu.permission');
    Route::get('/quicksale/list', [QuickSaleData::class, 'list'])->name('quicksale.list');
    Route::get('/quicksale/show/{id}', [QuickSaleData::class, 'show'])->name('quicksale.show');
    Route::get('quicksaleprint/{id}', [QuickSaleData::class, 'quicksaleprint'])->name('quicksale.print');

    // E-Commerce Sales Routes
    Route::get('/ecom-sales', [SalesController::class, 'ecom_index'])->name('ecom.sales.index')->middleware('menu.permission');
    Route::get('/ecom-sales/list', [SalesController::class, 'ecom_list'])->name('ecom.sales.list');
    Route::get('/store-pickup/{id}', [SalesController::class, 'getStorePickup'])->name('store.pickup');
    Route::get('/ecom-cancelled-pending-list', [SalesController::class, 'ecom_cancelled_pending_list'])->name('ecom.cancelled.pending.list');
    Route::get('/ecom-sales/show/{id}', [SalesController::class, 'ecom_show'])->name('ecom.sales.show');

    //E-commerce tracking number range
    Route::post('/shipment-range-store', [SalesController::class, 'shipmentRangeStore'])->name('shipment.range.store');
    Route::get('/bombex-status', [SalesController::class, 'bombexStatus'])->name('bombex.status');


    Route::post('/order/full-payment', [SalesController::class, 'confirmFullPayment'])->name('order.fullpayment');
    Route::post('/orders/update-tracking', [SalesController::class, 'updateTracking'])->name('orders.updateTracking');
    Route::post('/orders/mark-delivered', [SalesController::class, 'markDelivered'])->name('orders.markDelivered');

    //Assign Delivery
    Route::post('/assign-internal-delivery', [SalesController::class, 'assignInternalDelivery'])->name('assign.internal.delivery');


    // Report
    Route::get('/invoice-report', [ReportController::class, 'invoice_index'])->name('invoice.report')->middleware('menu.permission');
    Route::get('/invoice/report/list', [ReportController::class, 'list'])->name('invoice.report.list');
    Route::get('/invoice-report/show/{type}/{id}', [ReportController::class, 'show'])->name('invoice.report.show');
    Route::get('/invoice/store-locations', [ReportController::class, 'storeLocations'])->name('invoice.store.locations');

    Route::get('/inventory-report', [ReportController::class, 'inventory_report'])->name('inventory.report')->middleware('menu.permission');
    Route::get('/inventory-report-list', [ReportController::class, 'inventoryReportList'])->name('inventory.report.list');

    // Activity Logs
    Route::get('/activity-logs', [ReportController::class, 'activityReport'])->name('activity.logs')->middleware('menu.permission');
    Route::get('/activity-logs/list', [ReportController::class, 'activityLogsList'])->name('activity.logs.list');
    Route::get('/activity-logs/filters', [ReportController::class, 'activityLogsFilters'])->name('activity.logs.filters');

    // blog routes
    Route::get('/blog-index', [BlogController::class, 'index'])->name('blog.index')->middleware('menu.permission');
    Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/list', [BlogController::class, 'list'])->name('blog.list');
    Route::get('/blog/view/{id}', [BlogController::class, 'view'])->name('blog.view');
    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blog/update', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');

    //FAQ Routes
    Route::get('/faq-index', [BlogController::class, 'faq_index'])->name('faq.index')->middleware('menu.permission');
    Route::get('faq/list', [BlogController::class, 'faq_list'])->name('faq.list');
    Route::post('faq/store', [BlogController::class, 'faq_store'])->name('faq.store');
    Route::post('faq/update', [BlogController::class, 'faq_update'])->name('faq.update');
    Route::get('faq/view/{id}', [BlogController::class, 'faq_view'])->name('faq.view');
    Route::get('faq/edit/{id}', [BlogController::class, 'faq_edit'])->name('faq.edit');
    Route::delete('faq/delete/{id}', [BlogController::class, 'faq_delete'])->name('faq.delete');

    //Catalogue Routes
    Route::get('/catalogue-index', [FrontSetting::class, 'catalogue_index'])->name('catalogue-index')->middleware('menu.permission');
    Route::post('/catalogue/update', [FrontSetting::class, 'updatecatalogue'])->name('catalogue.update');
});

Route::get('/clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');

    return 'Cache cleared';
});

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');

    return 'Cleared';
});

Route::get('/order/invoice/{order_id}', [SalesController::class, 'invoiceprint'])->name('invoice.print');

// -----------------------------------------------FRONT END------------------------------------------------------- //
// --------------------------------------------------------CONTROLLER------------------------------------------------------- //

Route::get('/about', [FrontEndController::class, 'about'])->name('about');

// Footer Content
Route::get('/store/lower-parel-mumbai', [FrontEndController::class, 'lower_parel_mumbai'])->name('lower_parel_mumbai');
Route::get('/store/bandra-west-mumbai', [FrontEndController::class, 'bandra_west_mumbai'])->name('bandra_west_mumbai');
Route::get('/store/bangalore-karnataka', [FrontEndController::class, 'bangalore_karnataka'])->name('bangalore_karnataka');
Route::get('/store/ahmedabad-gujarat', [FrontEndController::class, 'ahmedabad_gujarat'])->name('ahmedabad_gujarat');

// contact
Route::get('/contact', [FrontEndController::class, 'contact'])->name('contact');
Route::post('addContact_us', [FrontEndController::class, 'addContact_us'])->name('addContact_us');

// store location
Route::get('/store', [FrontEndController::class, 'storeLocator'])->name('store');

// Brand Page
Route::get('/preowned-{brand}', [FrontEndController::class, 'manufacturerProducts'])->name('manufacturer.products');
Route::post('/filter-brand-product', [FrontEndController::class, 'filterBrandProduct'])->name('filterBrandProduct');

// Product Page
Route::get('product/{manufacturerSlug}/{productSlug}/{skuSuffix}', [FrontEndController::class, 'productDetails'])->name('productDetails.seo');
Route::post('addProduct_enquiry', [FrontEndController::class, 'addProduct_enquiry'])->name('addProduct_enquiry');

// All Watch Page
Route::get('/product', [FrontEndController::class, 'product'])->name('product');
Route::post('/filterProduct', [FrontEndController::class, 'filterProduct'])->name('filterProduct');

// NEW ARRIVAL PAGE
Route::get('/arrivals', [FrontEndController::class, 'arrivals'])->name('arrivals');

// Term And Condition Page
Route::get('/terms_and_condtion', [FrontEndController::class, 'terms_and_condtion'])->name('terms_and_condtion');
Route::get('/terms_of_use', [FrontEndController::class, 'terms_of_use'])->name('terms_of_use');
Route::get('/privacy_policy', [FrontEndController::class, 'privacy_policy'])->name('privacy_policy');

// Search
Route::get('/search', [FrontEndController::class, 'frontsearch'])->name('search');

// Trade and Sell
Route::get('/trade', [FrontEndController::class, 'trade'])->name('trade');
Route::post('/send-otp', [FrontEndController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [FrontEndController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/trading/store', [FrontEndController::class, 'trade_store'])->name('trading.store');

Route::get('/sell', [FrontEndController::class, 'sell'])->name('sell');
Route::post('/selling/store', [FrontEndController::class, 'sell_store'])->name('selling.store');

// Blog
Route::get('/blog', [FrontEndController::class, 'blog'])->name('blog');
Route::get('/blog/details/{slug}', [FrontEndController::class, 'blogDetail'])->name('blog.detail');
Route::get('/blog/all-view', [FrontEndController::class, 'blogAllView'])->name('blog.all.view');
Route::get('/blog/brand/{brand}', [FrontEndController::class, 'blogBrandView'])->name('blog.brand.view');
Route::get('/blog/allbrand/view', [FrontEndController::class, 'blogAllBrandView'])->name('blog.all_brand.view');
Route::get('/blog/allfeatures/view', [FrontEndController::class, 'blogAllFeaturesView'])->name('features.all.blog');
Route::get('/blog/trending/view', [FrontEndController::class, 'blogAllTrendingView'])->name('blog.trending.view');


//Faq
Route::get('/all/faq', [FrontEndController::class, 'allfaq'])->name('all.faq');


// -------------------------------------------------------ECOMMERCE FRONT-END-------------------------------------------------------

// ECOMMERCE FRONT-END
Route::get('custlogin-page', [EcomController::class, 'custlogin'])->name('custlogin-page');

Route::post('/cust_register', [EcomController::class, 'custregister'])->name('custregister');
Route::get('/verify-email/{token}', [EcomController::class, 'verifyEmail'])->name('verify.email');
Route::post('/customer_login', [EcomController::class, 'customerlogin'])->name('customer.login');

Route::post('/forgot-custpassword', [EcomController::class, 'forgotcustPassword'])->name('forgot.custpassword');
Route::get('reset-password', [EcomController::class, 'showResetPasswordPage'])->name('cust-reset-password');
Route::post('custupdate-password', [EcomController::class, 'custupdatePassword'])->name('cust-update-password');

Route::get('customerprofile', [EcomController::class, 'customerprofile'])->name('customerprofile');
Route::get('/customer/logout', [EcomController::class, 'customerLogout'])->name('customerlogout');
Route::get('profileinvoice-page', [EcomController::class, 'profileinvoicepage'])->name('profileinvoice-page');
Route::post('/update-profile-photo', [EcomController::class, 'updateProfilePhoto'])->name('update-profile-photo');
Route::post('/update-customer-password', [EcomController::class, 'updatePassword'])->name('update-customer-password');

// Route::middleware(['prevent-back-history'])->group(function () {
Route::post('/update-customer-profile', [EcomController::class, 'updateProfile'])->name('update-customer-profile');
// });

Route::post('/save-customer-address', [EcomController::class, 'saveAddress'])->name('save-customer-address');
Route::post('/update-primary-address', [EcomController::class, 'updatePrimaryAddress'])->name('update.primary.address');
Route::get('/get-single-address', [EcomController::class, 'getSingleAddress'])->name('get.single.address');
Route::post('/delete-address', [EcomController::class, 'deleteAddress'])->name('delete.address');

// Order concept
Route::post('/cart/add-db', [EcomController::class, 'addToDb'])->name('cart.add.db');
Route::post('/get-cart-items', [EcomController::class, 'getCartItems'])->name('get.cart.items');
Route::post('/cart/remove', [EcomController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/show', [EcomController::class, 'showCart'])->name('cart.show');
Route::get('/get-db-cart', [EcomController::class, 'getDBCart'])->name('get.db.cart');
Route::post('side/cart/show', [EcomController::class, 'showsideCart'])->name('sidecart.show');

// cart page
Route::get('cart-page', [EcomController::class, 'cartpage'])->name('cart-page');
Route::post('/check-email', [EcomController::class, 'checkEmail'])->name('check.email');

// Payment

Route::post('/payment/process', [EcomController::class, 'process'])->name('payment.process');
Route::get('invoice-page', [EcomController::class, 'invoicepage'])->name('invoice-page');
Route::get('/order/cancel', [EcomController::class, 'ordercancel'])->name('order-cancel-page');


//order tracking
Route::get('/order-tracking/{tracking_num}/{order_id}', [EcomController::class, 'ordertracking'])->name('ordertracking');
Route::get('/internal-order-tracking/{order_id}', [EcomController::class, 'internal_order_tracking'])->name('internal.order.tracking');
Route::get('/store-pickup-tracking/{order_id}',[EcomController::class, 'store_pickup_tracking'])->name('store.pickup.tracking');

//Wishlist
Route::post('/save-wishlist', [EcomController::class, 'saveWishlist'])->name('save.wishlist');
Route::get('/get-wishlist', [EcomController::class, 'getWishlist'])->name('get.wishlist');
Route::post('/add-wishlist', [EcomController::class, 'addWishlist'])->name('add.wishlist');
Route::post('/remove-wishlist', [EcomController::class, 'removeWishlist'])->name('remove.wishlist');

//CART
Route::get('/cart/panel', [EcomController::class, 'getCartPanel'])->name('cart.panel');


Route::post('/send-email-otp', [EcomController::class, 'sendEmailOtp'])->name('send.email.otp');
Route::post('/verify-email-otp', [EcomController::class, 'verifyEmailOtp'])->name('verify.email.otp');

//Country Cities APi
Route::get('/get-states/{country_id}', [Business_location::class, 'getStates'])->name('get.states');
Route::get('/get-cities/{state_id}', [Business_location::class, 'getCities'])->name('get.cities');

//Pan Verification
Route::post('/verify-pan', [FrontEndController::class, 'verifyPan'])->name('verify.pan');


//export product data
Route::get('/admin/product/export', [ProductController::class, 'export'])->name('product.export');
Route::post('/admin/product/bulk-update-excel', [ProductController::class, 'bulkUpdateExcel'])->name('product.bulk.update.excel');


//Export Product Enquiry data
Route::get('/export-enquiry', [FrontSetting::class, 'export'])->name('enquiry.export');

//export contact us data
Route::get('/contact-export', [FrontSetting::class, 'contact_export'])->name('contact.export');

//Catalogue Create
Route::post('/catalogue/create', [ProductController::class, 'catalogue_create'])->name('catalogue.create');


// 404
Route::fallback(function () {
    return response()->view('frontend.404', [], 404);
});
