<?php


namespace App\Http\Controllers;

use App\Models\CatePost;
use App\Models\Feeship;
use App\Models\Slider;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
session_start();
class CheckoutController extends Controller
{
    //User
    public function confirm_order(Request $request){
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);
        
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        
        if(Session::get('cart')){
            foreach(Session::get('cart') as $key => $cart){
                $order_details = new OrderDetails();
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
    }
    public function vnpay_payment(Request $request){
        $data = $request->all();
        $code_cart = rand(0, 9999); //Mã đơn hàng
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/shop-laptop_laravel_9/vnpay-return";
        $vnp_TmnCode = "MBRQ9A0D";//Mã website tại VNPAY 
        $vnp_HashSecret = "78MYQ72GA19CO06ME960JH6ALWT5IYYP"; //Chuỗi bí mật
        
        $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng test';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $data['total_vnpay'] * 100;
        $vnp_Locale = 'vn';
        // $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        
        

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // $returnData = array('code' => '00'
        //     , 'message' => 'success'
        //     , 'data' => $vnp_Url);
        //     if (isset($_POST['redirect'])) {
        //         header('Location: ' . $vnp_Url);
        //         die();
        //     } else {
        //         echo json_encode($returnData);
        //     }
        //     // vui lòng tham khảo thêm tại code demo

        return response()->json([
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url // URL thanh toán VNPAY đã tạo
        ]);

        // Thẻ test:
        //Ngân hàng: NCB
        //Số thẻ: 9704198526191432198
        //Tên chủ thẻ:NGUYEN VAN A
        //Ngày phát hành:07/15
        //Mật khẩu OTP:123456

            
    }
    public function vnpay_return(Request $request) {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode'); // Mã phản hồi từ VNPAY
        $vnp_TxnRef = $request->get('vnp_TxnRef'); // Mã đơn hàng
        $vnp_Amount = $request->get('vnp_Amount') / 100; // Số tiền thanh toán (đã chia lại cho 100)

        if ($vnp_ResponseCode == "00") {
            // Thanh toán thành công
            Session::put('message', 'Thanh toán thành công!');
            return redirect('/transaction-cash'); // Chuyển hướng sang trang handcash
        } else {
            // Thanh toán thất bại
            Session::put('error', 'Thanh toán không thành công. Vui lòng thử lại!');
            return redirect('/checkout'); // Quay lại trang thanh toán
        }
    }
    public function hand_cash(Request $request){
        $category_post = CatePost::all();
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Thanh toán bằng tiền mặt - Laptop Minh Quân";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        return view('pages.checkout.handcash')->with('meta_desc',$meta_desc)
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('slider',$slider)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('category_post',$category_post);
    }
    public function transaction_cash(Request $request){
        $category_post = CatePost::all();
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Thanh toán chuyển khoản thành công - Laptop Minh Quân";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        return view('pages.checkout.handcash')->with('meta_desc',$meta_desc)
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('slider',$slider)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('category_post',$category_post);
    }
    public function login_checkout(Request $request){
        $category_post = CatePost::all();
        //seo
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Đăng nhập - Laptop Minh Quân";
        $url_canonical = $request->url();
        //--seo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        return view('pages.checkout.login_checkout')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider',$slider)
        ->with('category_post',$category_post);
        
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;
        $customer_id = DB::table('tbl_customers')->insertGetId($data);
        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect::to('/checkout');
    }
    public function checkout(Request $request){
        $category_post = CatePost::all();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Thông tin giao hàng - Laptop Minh Quân";
        $url_canonical = $request->url();
        $city = City::orderBy('matp','ASC')->get();
        return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('city',$city)
        ->with('slider',$slider)
        ->with('category_post',$category_post);
    }
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);
        return Redirect::to('/payment');
    }
    public function payment(Request $request){
        $category_post = CatePost::all();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Phương thức thanh toán - Laptop Minh Quân";
        $url_canonical = $request->url();
        return view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('category_post',$category_post);
    }
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');
        }else{
            return Redirect::to('/login-checkout');
        }
    }
    public function order_place(Request $request){
        //insert payment_method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);
        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        //seo
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Thanh toán - Laptop Minh Quân";
        $url_canonical = $request->url();
        //--seo
        //insert order_detail
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method'] == 1){
            echo 'Thanh toán bằng chuyển khoản ngân hàng';
        }elseif($data['payment_method'] == 2){
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
            Cart::destroy();
            return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
        }else{
            echo 'Thanh toán bằng thẻ ghi nợ';
        }
        Cart::destroy();

    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        $output = '';
        
        if($data['action'] == "city"){
            // Xử lý lấy quận huyện
            $select_province = Province::where('matp', $data['ma_id'])
                                      ->orderBy('maqh', 'ASC')
                                      ->get();
            $output .= '<option value="">Chọn quận huyện</option>';
            foreach($select_province as $province) {
                $output .= '<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
            }
        } else {
            // Xử lý lấy xã phường (khi action là province)
            $select_wards = Wards::where('maqh', $data['ma_id'])
                                ->orderBy('xaid', 'ASC')
                                ->get();
            $output .= '<option value="">Chọn phường xã</option>';
            foreach($select_wards as $ward) {
                $output .= '<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
            }
        }
        
        echo $output;
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship > 0){
                    foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{
                    Session::put('fee',25000);
                    Session::save();
                }
            }
        }
    }
    public function del_fee_ajax(Request $request){
        Session::forget('fee');
        return redirect()->back();
    }

    


    // Admin
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manage_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manage_order);
    }
    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*','tbl_payment.*')
        ->first();
        // echo '<pre>';
        // print_r($order_by_id);
        // echo '</pre>';
        $manage_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manage_order_by_id);
    }
    public function delete_order($orderId){
        DB::table('tbl_order')->where('order_id',$orderId)->delete();
        DB::table('tbl_order_details')->where('order_details_id',$orderId)->delete();
        Session::put('message','Xóa đơn hàng thành công');
        return Redirect::to('/manage-order');
    }
    public function unactive_order($orderId){
        DB::table('tbl_order')->where('order_id',$orderId)->update(['order_status'=>0]);
        Session::put('message','Ẩn đơn hàng thành công');
        return Redirect::to('/manage-order');
    }
    public function active_order($orderId){
        DB::table('tbl_order')->where('order_id',$orderId)->update(['order_status'=>1]);
        Session::put('message','Hiển thị đơn hàng thành công');
        return Redirect::to('/manage-order');
    }
}
