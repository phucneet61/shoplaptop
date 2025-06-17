<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\CategoryPost;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;
//Frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);

//Danh mục sản phẩm trong trang chủ
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_id}', [BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'details_product']);

//Send mail
Route::get('/send-mail', [HomeController::class, 'send_mail']);


//Login Facebook
Route::get('/login-facebook', [AdminController::class, 'login_facebook']);
Route::get('/admin/callback', [AdminController::class, 'callback_facebook']);

//Login Google
Route::get('/login-google', [AdminController::class, 'login_google']);
Route::get('/google/callback', [AdminController::class, 'callback_google']);


//Backend
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);




//Category Product
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

Route::post('/export-csv', [CategoryProduct::class, 'export_csv']);
Route::post('/import-csv', [CategoryProduct::class, 'import_csv']);

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);

//Category Post
Route::get('/add-category-post', [CategoryPost::class, 'add_category_post']);
Route::get('/all-category-post', [CategoryPost::class, 'all_category_post']);
Route::get('/edit-category-post/{cate_post_id}', [CategoryPost::class, 'edit_category_post']);
Route::post('/update-category-post/{cate_post_id}', [CategoryPost::class, 'update_category_post']);
Route::post('/save-category-post', [CategoryPost::class, 'save_category_post']);
Route::get('/delete-category-post/{cate_post_id}', [CategoryPost::class, 'delete_category_post']);

//Post 
Route::get('/add-post', [PostController::class, 'add_post']);
Route::post('/save-post', [PostController::class, 'save_post']);
Route::get('/all-post', [PostController::class, 'all_post']);
Route::get('/delete-post/{post_id}', [PostController::class, 'delete_post']);
Route::get('/edit-post/{post_id}', [PostController::class, 'edit_post']);
Route::post('/update-post/{post_id}', [PostController::class, 'update_post']);
Route::get('/unactive-post/{post_id}', [PostController::class, 'unactive_post']);
Route::get('/active-post/{post_id}', [PostController::class, 'active_post']);
//Bai_Viet
Route::get('/danh-muc-bai-viet/{post_slug}', [PostController::class, 'danh_muc_bai_viet']);
Route::get('/bai-viet/{post_slug}', [PostController::class, 'bai_viet']);






//Brand Product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);

//Product
Route::group(['middleware' => 'auth.roles'], function () {
    Route::get('/add-product', [ProductController::class, 'add_product']);
    Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
    
});
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);

Route::post('/export-product-csv', [ProductController::class, 'export_csv']);
Route::post('/import-product-csv', [ProductController::class, 'import_csv']);

//Coupon
Route::post('/check-coupon', [CartController::class, 'check_coupon']);
Route::get('/unset-coupon', [CouponController::class, 'unset_coupon']);

//Coupon_Admin
Route::get('/insert-coupon', [CouponController::class, 'insert_coupon']);
Route::post('/insert-coupon-code', [CouponController::class, 'insert_coupon_code']);
Route::get('/list-coupon', [CouponController::class, 'list_coupon']);
Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'delete_coupon']);


//Cart
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_to_cart']);
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);

//Add to cart ajax 
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
Route::post('/update-cart-ajax', [CartController::class, 'update_cart_ajax']);
Route::get('/gio-hang', [CartController::class, 'gio_hang']);
Route::get('/delete-cart-ajax/{session_id}', [CartController::class, 'delete_cart_ajax']);
Route::get('/del-all-cart-ajax', [CartController::class, 'delete_all_product_ajax']);

//Checkout
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/login-customer', [CheckoutController::class, 'login_customer']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::post('/confirm-order', [CheckoutController::class, 'confirm_order']);
Route::get('/handcash', [CheckoutController::class, 'hand_cash']);
Route::get('/transaction-cash', [CheckoutController::class, 'transaction_cash']);

//cong thanh toan chuyen khoan 
Route::post('/vnpay', [CheckoutController::class, 'vnpay_payment']);
Route::get('/vnpay-return', [CheckoutController::class, 'vnpay_return']);





//Order 
Route::get('/manage-order', [OrderController::class, 'manage_order']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::get('/print-order/{checkout_code}', [OrderController::class, 'print_order']);
Route::get('/delete-order/{order_id}', [CheckoutController::class, 'delete_order']);

Route::post('/update-order-qty', [OrderController::class, 'update_order_qty']);
Route::post('/update-qty', [OrderController::class, 'update_qty']);



//Delivery backend
Route::get('/delivery',[DeliveryController::class, 'delivery']);
Route::post('/select-delivery',[DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery',[DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship',[DeliveryController::class, 'select_feeship']);
Route::post('/update-delivery',[DeliveryController::class, 'update_delivery']);

//Delivery Frontend
Route::post('/select-delivery-home',[CheckoutController::class, 'select_delivery_home']);
Route::post('/calculate-fee',[CheckoutController::class, 'calculate_fee']);
Route::get('/del-fee-ajax',[CheckoutController::class, 'del_fee_ajax']);

//Banner
Route::get('/manage-slider',[SliderController::class, 'manage_slider']);
Route::get('/add-slider',[SliderController::class, 'add_slider']);
Route::post('/insert-slider', [SliderController::class, 'insert_slider']);
Route::get('/active-slider/{slider_id}', [SliderController::class, 'active_slider'])->name('active.slider');
Route::get('/unactive-slider/{slider_id}', [SliderController::class, 'unactive_slider'])->name('unactive.slider');


//Authentication Roles
Route::get('/register-auth', [AuthController::class, 'register_auth']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login-auth', [AuthController::class, 'login_auth']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout-auth', [AuthController::class, 'logout_auth']);


//Users
Route::get('/users', [UserController::class, 'index'])->middleware('auth.roles'); 
Route::get('/add-users', [UserController::class, 'add_users'])->middleware('auth.roles');
Route::post('/assign-roles',[UserController::class, 'assign_roles'])->middleware('auth.roles');
Route::get('/delete-user-roles/{admin_id}', [UserController::class, 'delete_user_roles'])->middleware('auth.roles');
Route::post('/store-users',[UserController::class, 'store_users'])->middleware('auth.roles');
Route::get('/impersonate/{admin_id}', [UserController::class, 'impersonate']);
Route::get('/impersonate-destroy', [UserController::class, 'impersonate_destroy']);

//Gallery
Route::get('/add-gallery/{product_id}', [GalleryController::class, 'add_gallery']);
Route::post('/select-gallery', [GalleryController::class, 'select_gallery']);
Route::post('/insert-gallery/{pro_id}', [GalleryController::class, 'insert_gallery']);
Route::post('/delete-gallery', [GalleryController::class, 'delete_gallery']);
Route::post('/update-gallery-name', [GalleryController::class, 'update_gallery_name']);
Route::post('/update-gallery', [GalleryController::class, 'update_gallery']);

//Video
Route::get('/video', [VideoController::class, 'video']);
Route::get('/video-shop', [VideoController::class, 'video_shop']);
Route::post('/select-video', [VideoController::class, 'select_video']);
Route::post('/insert-video', [VideoController::class, 'insert_video']);
Route::post('/update-video', [VideoController::class, 'update_video']);
Route::post('/delete-video', [VideoController::class, 'delete_video']);