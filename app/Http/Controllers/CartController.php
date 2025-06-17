<?php

namespace App\Http\Controllers;


use App\Models\CatePost;
use App\Models\Slider;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
use App\Models\Coupon;
session_start();
class CartController extends Controller
{
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon'])->first();
        if($coupon==true){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                $coupon_session = Session::get('coupon');
                if($coupon_session == true){
                    $is_available = 0;
                    if($is_available == 0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,

                        );
                        Session::put('coupon', $cou);
                    }
                }else{
                    $cou[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,

                    );
                    Session::put('coupon', $cou);
                }
                Session::save();
                return redirect()->back()->with('message','Thêm mã giảm giá thành công!');
            }
        }else{
            return redirect()->back()->with('error','Mã giảm giá không đúng!');
        }
        
    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        
        $cart = Session::get('cart');
    
        if($cart == true){
            $is_available = 0;
    
            foreach($cart as $key => $val){
                if($val['product_id'] == $data['cart_product_id']){
                    // Nếu đã có sản phẩm trong giỏ -> tăng số lượng lên
                    $cart[$key]['product_qty'] += $data['cart_product_qty'];
                    $is_available = 1;
                }
            }
    
            if($is_available == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                    'product_quantity' => $data['cart_product_quantity']
                );
            }
            Session::put('cart',$cart);
    
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                'product_quantity' => $data['cart_product_quantity']
            );
            Session::put('cart',$cart);
        }
    
        Session::save();
    }


    public function gio_hang(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','desc')->get();

        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        //seo
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Gio Hang Ajax";
        $meta_title = "Giỏ hàng - Laptop Minh Quân";
        $url_canonical = $request->url();
        //--seo
        return view('pages.cart.cart_ajax')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider',$slider)
        ->with('category_post', $category_post);
    }

    public function update_cart_ajax(Request $request){
        $data = $request->all();
        $cart = Session::get('cart', []); // Lấy giỏ hàng hiện tại hoặc mảng rỗng
        if($cart==true){
            $message = '';
            foreach($data['cart_qty'] as $key => $qty){
                $i = 0;
                foreach($cart as $session => $cart_item){
                    $i++;
                    if($cart_item['session_id']==$key && $qty<$cart[$session]['product_quantity']){
                        $cart[$session]['product_qty'] = $qty;
                        $message.='<p style="color:blue">'.$i.' Cập nhật số lượng: '.$cart[$session]['product_name'].' thành công </p>';
                    }elseif($cart_item['session_id']==$key && $qty>$cart[$session]['product_quantity']){
                        $message.='<p style="color:red">'.$i.' Cập nhật số lượng: '.$cart[$session]['product_name'].' không thành công </p>';
                    }
                }
            }
            Session::put('cart', $cart); // Cập nhật giỏ hàng
            return redirect()->back()
                ->with('message', $message);

        }else{
            return Redirect::to('/gio-hang')
                ->with('message', 'Cập nhật giỏ hàng không thành công');
        }

    }

    public function delete_cart_ajax($session_id){
        $cart = Session::get('cart', []); // Lấy giỏ hàng hiện tại hoặc mảng rỗng
        if (isset($cart[$session_id])) {
            unset($cart[$session_id]); // Xóa sản phẩm khỏi giỏ hàng
            Session::put('cart', $cart); // Cập nhật giỏ hàng
            Session::save();
            return Redirect::to('/gio-hang')
                ->with('message', 'Xóa sản phẩm khỏi giỏ hàng thành công');
        } else {
            return Redirect::to('/gio-hang')
                ->with('message', 'Xóa sản phẩm khỏi giỏ hàng không thành công');
        }
    }

    public function delete_all_product_ajax(){
        $cart = Session::get('cart', []); // Lấy giỏ hàng hiện tại hoặc mảng rỗng
        if($cart==true){
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()
                ->with('message', 'Xóa tất cả sản phẩm thành công');

        }else{
            return redirect()->back()
                ->with('message', 'Xóa tất cả sản phẩm không thành công');
                
        }
    }// Xóa tất cả sản phẩm khỏi giỏ hàng

    public function save_cart(Request $request){
        // $productId = $request->productid_hidden;
        // $quantity = $request->qty;
        // $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();

        // $data['id'] = $product_info->product_id;
        // $data['qty'] = $quantity;
        // $data['name'] = $product_info->product_name;
        // $data['price'] = $product_info->product_price;
        // $data['weight'] = 0;
        // $data['options']['image'] = $product_info->product_image;
        // Cart::add($data);
        // Cart::setGlobalTax(0);
        // return Redirect::to('/show-cart');
        // Cart::add(['id' => $productId, 'name' => $product_info[0]->product_name, 'qty' => $quantity, 'price' => $product_info[0]->product_price, 'weight' => 0, 'options' => ['image' => $product_info[0]->product_image]]);
        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        Cart::destroy();
    }
    public function show_cart(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','desc')->get();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        //seo
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Giỏ hàng - Laptop Minh Quân";
        $url_canonical = $request->url();
        //--seo
        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider',$slider)
        ->with('category_post',$category_post);
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }
}
