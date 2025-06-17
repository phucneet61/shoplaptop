<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Session;
use Redirect;
session_start();
class CouponController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('login-auth')->send();
        }
    }
    public function insert_coupon(Request $request)
    {
        $this->AuthLogin();
        return view('admin.coupon.insert_coupon');
    }
    public function list_coupon(){
        $this->AuthLogin();
        $coupon = Coupon::all();
        return view('admin.coupon.list_coupon')->with(compact('coupon'));
    }
    public function insert_coupon_code(Request $request)
    {
        $data = $request->all();
        $coupon = new Coupon();
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->save();
        Session::put('message','Thêm mã giảm giá thành công');
        return Redirect::to('insert-coupon');
        
    }

    public function delete_coupon($coupon_id){
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message','Xóa mã giảm giá thành công');
        return Redirect::to('list-coupon');

    }

    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon==true){
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xóa mã khuyến mãi thành công');
        }
    }
}
