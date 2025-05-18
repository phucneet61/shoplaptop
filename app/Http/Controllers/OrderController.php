<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Feeship;
use App\Models\Customer;

use PDF;
class OrderController extends Controller
{
    public function update_qty(Request $request) {
        //update order
        $data = $request->all();
        $order_details = OrderDetails::where('product_id', $data['order_product_id'])->where('order_code', $data['order_code'])->first();
        $order_details->product_sales_quantity = $data['order_qty'];
        $order_details->save();
    }
    public function update_order_qty(Request $request) {
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $previousStatus = $order->order_status; // Lưu trạng thái trước đó
        $order->order_status = $data['order_status'];
        $order->save();
    
        if($data['order_status'] == 2) {
            // Xử lý khi đơn hàng thành công (trừ kho)
            foreach($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $qty = $data['quantity'][$key];
                
                $product->product_quantity -= $qty;
                $product->product_sold += $qty;
                $product->save();
            }
        } elseif($previousStatus == 2 && $data['order_status'] != 2) {
            // Chỉ cộng lại kho nếu trước đó đơn hàng đã thành công (status 2)
            foreach($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $qty = $data['quantity'][$key];
                
                $product->product_quantity += $qty;
                $product->product_sold -= $qty;
                $product->save();
            }
        }
        // Các trường hợp khác không làm gì cả
    }
    public function print_order($order_code) {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($order_code));
        return $pdf->stream();
    }
    
    public function print_order_convert($order_code) {
        // Lấy thông tin đơn hàng giống như hàm view_order
        $order = Order::where('order_code', $order_code)->get();
        
        if ($order->isEmpty()) {
            return "Đơn hàng không tồn tại";
        }
    
        $customer_id = $order[0]->customer_id;
        $shipping_id = $order[0]->shipping_id;
    
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
    
        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
    
        $coupon = null;
        $coupon_condition = null;
        $coupon_number = 0;
    
        if ($order_details->isNotEmpty() && !empty($order_details[0]->product_coupon)) {
            $coupon = Coupon::where('coupon_code', $order_details[0]->product_coupon)->first();
            
            if ($coupon) {
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            }
        }
    
        // Tạo HTML cho PDF
        $output = '
        <style>
            body { font-family: DejaVu Sans, sans-serif; }
            .title { text-align: center; font-weight: bold; font-size: 16px; margin-bottom: 20px; }
            .info { margin-bottom: 15px; }
            .info strong { display: inline-block; width: 150px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            table th { background: #f5f5f5; padding: 8px; border: 1px solid #ddd; }
            table td { padding: 8px; border: 1px solid #ddd; }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .total { font-weight: bold; margin-top: 20px; }
        </style>
        <h1 class="title">HÓA ĐƠN BÁN HÀNG</h1>
        
        <div class="info">
            <strong>Mã đơn hàng:</strong> '.$order_code.'<br>
            <strong>Ngày đặt:</strong> '.$order[0]->created_at.'<br>
        </div>
        
        <h3>Thông tin khách hàng</h3>
        <div class="info">
            <strong>Tên khách hàng:</strong> '.$customer->customer_name.'<br>
            <strong>Số điện thoại:</strong> '.$customer->customer_phone.'<br>
            <strong>Email:</strong> '.$customer->customer_email.'<br>
        </div>
        
        <h3>Thông tin vận chuyển</h3>
        <div class="info">
            <strong>Tên người nhận:</strong> '.$shipping->shipping_name.'<br>
            <strong>Địa chỉ:</strong> '.$shipping->shipping_address.'<br>
            <strong>Số điện thoại:</strong> '.$shipping->shipping_phone.'<br>
            <strong>Email:</strong> '.$shipping->shipping_email.'<br>
            <strong>Ghi chú:</strong> '.$shipping->shipping_notes.'<br>
            <strong>Hình thức thanh toán:</strong> '.($shipping->shipping_method == 0 ? 'Chuyển khoản' : 'Tiền mặt').'<br>
        </div>
        
        <h3>Chi tiết đơn hàng</h3>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>';
        
        $i = 0;
        $total = 0;
        $feeship = 0;
        
        foreach ($order_details as $detail) {
            $i++;
            $subtotal = $detail->product_price * $detail->product_sales_quantity;
            $total += $subtotal;
            $feeship = $detail->product_feeship;
            
            $output .= '
                <tr>
                    <td class="text-center">'.$i.'</td>
                    <td>'.$detail->product_name.'</td>
                    <td class="text-center">'.$detail->product_sales_quantity.'</td>
                    <td class="text-right">'.number_format($detail->product_price, 0, ',', '.').'đ</td>
                    <td class="text-right">'.number_format($subtotal, 0, ',', '.').'đ</td>
                </tr>';
        }
        
        // Tính toán tổng tiền sau coupon
        if ($coupon) {
            if ($coupon_condition == 1) {
                $total_after_coupon = ($total * $coupon_number) / 100;
                $total_coupon = $total - $total_after_coupon + $feeship;
            } else {
                $total_coupon = $total - $coupon_number + $feeship;
            }
        } else {
            $total_coupon = $total + $feeship;
        }
        
        $output .= '
            </tbody>
        </table>
        
        <div class="total">
            <strong>Tổng tiền hàng:</strong> '.number_format($total, 0, ',', '.').'đ<br>';
        
            if ($coupon) {
                $discount_text = $coupon_condition == 1 
                    ? $coupon_number.'%' 
                    : number_format($coupon_number, 0, ',', '.').'đ';
                
                $output .= '
                <strong>Mã giảm giá:</strong> '.$coupon->coupon_code.' ('.$discount_text.')<br>
                <strong>Tiền giảm:</strong> '.number_format($coupon_condition == 1 ? $total_after_coupon : $coupon_number, 0, ',', '.').'đ<br>';
            }
        
        $output .= '
            <strong>Phí vận chuyển:</strong> '.number_format($feeship, 0, ',', '.').'đ<br>
            <strong>Tổng thanh toán:</strong> '.number_format($total_coupon, 0, ',', '.').'đ
        </div>';
        
        $output .= '
        </div>'; // Đóng thẻ div tổng tiền

        // Thêm phần ký tên
        // $output .= '
        //     <div style="margin-top: 50px; display: flex; justify-content: space-between;">
        //         <div style="text-align: center; width: 45%;">
        //             <p><strong>Người lập phiếu</strong></p>
        //             <p style="font-style: italic;">(Ký, ghi rõ họ tên)</p>
        //             <p style="margin-top: 50px;">...................................</p>
        //         </div>
        //         <div style="text-align: center; width: 45%;">
        //             <p><strong>Người nhận</strong></p>
        //             <p style="font-style: italic;">(Ký, ghi rõ họ tên)</p>
        //             <p style="margin-top: 50px;">...................................</p>
        //         </div>
        //     </div>';

        
        return $output;
    }
    public function view_order($order_code) {
        // Lấy thông tin đơn hàng
        $order = Order::where('order_code', $order_code)->get();
        
        // Kiểm tra nếu không có đơn hàng
        if ($order->isEmpty()) {
            return back()->with('error', 'Đơn hàng không tồn tại');
        }
    
        // Lấy thông tin khách hàng và shipping từ đơn hàng đầu tiên
        $customer_id = $order[0]->customer_id;
        $shipping_id = $order[0]->shipping_id;
        $order_status = $order[0]->order_status;
    
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
    
        // Lấy chi tiết đơn hàng
        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
    
        // Xử lý coupon
        $coupon = null;
        $coupon_condition = null;
        $coupon_number = 0;
    
        // Lấy coupon từ order details đầu tiên (nếu có)
        if ($order_details->isNotEmpty() && !empty($order_details[0]->product_coupon)) {
            $coupon = Coupon::where('coupon_code', $order_details[0]->product_coupon)->first();
            
            if ($coupon) {
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            }
        }
    
        return view('admin.order.view_order')->with(compact(
            'order',
            'customer',
            'shipping',
            'order_details',
            'coupon',
            'coupon_condition',
            'coupon_number',
            'order_status'
        ));
    }
    public function manage_order(){
        $order = Order::orderBy('created_at', 'DESC')->get();
        return view('admin.order.manage_order')->with(compact('order'));
    }


}
