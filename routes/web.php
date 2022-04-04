<?php

use Illuminate\Support\Facades\Route;
use App\Models\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function() {
    Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/register','Auth\AdminLoginController@showRegisterForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminLoginController@register')->name('admin.register.submit');
    Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'Auth\AdminController@index')->name('admin.dashboard');
    Route::get('/forget-password', 'Auth\AdminForgotPasswordController@showForgetPasswordForm')->name('admin.forget.password.get');
    Route::post('/forget-password', 'Auth\AdminForgotPasswordController@submitForgetPasswordForm')->name('admin.forget.password.post'); 
    Route::get('/reset-password/{token}', 'Auth\AdminForgotPasswordController@showResetPasswordForm')->name('admin.reset.password.get');
    Route::post('/reset-password', 'Auth\AdminForgotPasswordController@submitResetPasswordForm')->name('admin.reset.password.post');
    Route::get('showupdateform', 'Auth\AdminController@showupdateform')->name('admin.showupdateform');
    Route::post('updateprofile/$admin', 'Auth\AdminController@updateprofile')->name('admin.updateprofile');
    Route::resource('customer', ManageCustomerController::class);
    Route::resource('vendor', ManageVendorController::class);
    Route::resource('users', ManageUsersController::class);
    Route::resource('smenu', AdminMenuController::class);
    Route::resource('scategory', AdminCategoryController::class);
    Route::get('/smenu/{vendor}/vendor', 'AdminMenuController@viewMenu')->name('smenu.vendor');
    Route::post('/customer/{customer}/enable', 'ManageCustomerController@enable')->name('customer.enable');
    Route::post('/customer/{customer}/disable', 'ManageCustomerController@disable')->name('customer.disable');
    Route::post('/vendor/{vendor}/enable', 'ManageVendorController@enable')->name('vendor.enable');
    Route::post('/vendor/{vendor}/disable', 'ManageVendorController@disable')->name('vendor.disable');
    Route::delete('viewAll', [App\Http\Controllers\AdminMenuController::class, 'deleteAll'])->name('smenu.deleteAll');
    Route::delete('menu/{category}', [App\Http\Controllers\AdminCategoryController::class, 'deleteAll'])->name('scategory.deleteAll');
    Route::get('/create/{vendor}', [App\Http\Controllers\AdminCategoryController::class, 'create'])->name('scategories.create');
    Route::get('viewAll/{category}/category', [App\Http\Controllers\AdminCategoryController::class, 'viewAll'])->name('scategory.viewAll');
    Route::get('/{category}/create', [App\Http\Controllers\AdminMenuController::class, 'create'])->name('smenu.create');
    Route::get('/orders/{customer}/customer', 'ManageCustomerController@customerOrders')->name('customer.orders');
    Route::get('/orders/{vendor}/vendor', 'ManageVendorController@vendorOrders')->name('vendor.orders');


});

Route::prefix('vendor')->group(function() {
    Route::get('/vlogin','Auth\VendorLoginController@showLoginForm')->name('vendor.login');
    Route::post('/vlogin', 'Auth\VendorLoginController@login')->name('vendor.login.submit');
    Route::get('/vregister','Auth\VendorLoginController@showRegisterForm')->name('vendor.register');
    Route::post('/vregister', 'Auth\VendorLoginController@register')->name('vendor.register.submit');
    Route::get('vlogout/', 'Auth\VendorLoginController@logout')->name('vendor.logout');
    Route::get('vshowupdateform', 'Auth\VendorController@showupdateform')->name('vendor.showupdateform');
    Route::post('vupdateprofile/$vendor', 'Auth\VendorController@updateprofile')->name('vendor.updateprofile');
    Route::get('/', 'Auth\VendorController@index')->name('vendor.dashboard');
    Route::get('/vforget-password', 'Auth\VendorForgotPasswordController@showForgetPasswordForm')->name('vendor.forget.password.get');
    Route::post('/vforget-password', 'Auth\VendorForgotPasswordController@submitForgetPasswordForm')->name('vendor.forget.password.post'); 
    Route::get('/vreset-password/{token}', 'Auth\VendorForgotPasswordController@showResetPasswordForm')->name('vendor.reset.password.get');
    Route::post('/vreset-password', 'Auth\VendorForgotPasswordController@submitResetPasswordForm')->name('vendor.reset.password.post');
    Route::get('/subvendor', [App\Http\Controllers\Auth\VendorController::class, 'viewsubvendors'])->name('subvendor.index');
    Route::get('/subvendor/create', [App\Http\Controllers\Auth\VendorController::class, 'create'])->name('subvendor.create');
    Route::get('/password/{id}', [App\Http\Controllers\Auth\VendorController::class, 'showpasswordform'])->name('show.password');
    Route::post('/password', [App\Http\Controllers\Auth\VendorController::class, 'savepassword'])->name('send.password');
    Route::post('{subvendor}/enable', [App\Http\Controllers\Auth\VendorController::class, 'enable'])->name('subvendor.enable');
    Route::post('{subvendor}/disable', [App\Http\Controllers\Auth\VendorController::class, 'disable'])->name('subvendor.disable');
    Route::resource('menu', MenuController::class);
    Route::delete('viewAll', [App\Http\Controllers\MenuController::class, 'deleteAll'])->name('menu.deleteAll');
    Route::delete('menu', [App\Http\Controllers\CategoryController::class, 'deleteAll'])->name('category.deleteAll');
    Route::get('/{category}/create', [App\Http\Controllers\MenuController::class, 'create'])->name('menu.create');
    Route::get('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
    Route::get('viewAll/{category}/category', [App\Http\Controllers\CategoryController::class, 'viewAll'])->name('category.viewAll');
    Route::resource('category', CategoryController::class);
    Route::get('/orders', 'Auth\VendorController@vieworder')->name('orders');
    Route::post('{order}/ready', [App\Http\Controllers\Auth\VendorController::class, 'ready'])->name('order.ready');

}); 

Route::prefix('customer')->group(function() {
    Route::get('/clogin','Auth\CustomerLoginController@showLoginForm')->name('customer.login');
    Route::post('/clogin', 'Auth\CustomerLoginController@login')->name('customer.login.submit');
    Route::get('/cregister','Auth\CustomerLoginController@showRegisterForm')->name('customer.register');
    Route::post('/cregister', 'Auth\CustomerLoginController@register')->name('customer.register.submit');
    Route::get('clogout/', 'Auth\CustomerLoginController@logout')->name('customer.logout');
    Route::get('/', 'Auth\CustomerController@index')->name('customer.dashboard');
    Route::get('cshowupdateform', 'Auth\CustomerController@showupdateform')->name('customer.showupdateform');
    Route::post('cupdateprofile/$customer', 'Auth\CustomerController@updateprofile')->name('customer.updateprofile');
    Route::get('/cforget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('customer.forget.password.get');
    Route::post('/cforget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('customer.forget.password.post'); 
    Route::get('/creset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('customer.reset.password.get');
    Route::post('/creset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('customer.reset.password.post');
    Route::get('caccount/verify/{token}', 'Auth\CustomerLoginController@verifyAccount')->name('customer.verify');
    Route::get('menu/{vendor}', 'Auth\CustomerController@menu')->name('menu');  
    Route::get('vendor', 'Auth\CustomerController@vendor')->name('vendor');  
    Route::get('cart', 'Auth\CustomerController@cart')->name('cart');
    Route::get('add-to-cart/{id}', 'Auth\CustomerController@addToCart')->name('add.to.cart');
    Route::patch('update-cart', 'Auth\CustomerController@update')->name('update.cart');
    Route::delete('remove-from-cart', 'Auth\CustomerController@remove')->name('remove.from.cart');
    Route::get('checkout' , 'Auth\CustomerController@checkout')->name('checkout');
    Route::post('order' , 'Auth\CustomerController@order')->name('order');
    Route::get('myorders', 'Auth\CustomerController@myorders')->name('myorders');

});

Route::prefix('subvendor')->group(function() {
    Route::get('/login','Auth\SubVendorLoginController@showLoginForm')->name('subvendor.login');
    Route::post('/login', 'Auth\SubVendorLoginController@login')->name('subvendor.login.submit');
    Route::get('logout/', 'Auth\SubVendorLoginController@logout')->name('subvendor.logout');
    Route::get('/', 'Auth\SubVendorController@index')->name('subvendor.dashboard');
    Route::get('showupdateform', 'Auth\SubVendorController@showupdateform')->name('subvendor.showupdateform');
    Route::post('updateprofile/$vendor', 'Auth\SubVendorController@updateprofile')->name('subvendor.updateprofile');
   }) ;

Route::get('dashboard','Auth\CustomerLoginController@dashboard')->middleware(['auth', 'is_verify_email']); 
Route::get('dashboard', 'Auth\VendorLoginController@dashboard')->middleware(['auth', 'is_verify_email']); 
Route::get('account/verify/{token}', 'Auth\VendorLoginController@verifyAccount')->name('vendor.verify'); 


