@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Home</a></li>
              <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div><!--/breadcrums-->

        {{-- <div class="step-one">
            <h2 class="heading">Step1</h2>
        </div>
        <div class="checkout-options">
            <h3>New User</h3>
            <p>Checkout options</p>
            <ul class="nav">
                <li>
                    <label><input type="checkbox"> Register Account</label>
                </li>
                <li>
                    <label><input type="checkbox"> Guest Checkout</label>
                </li>
                <li>
                    <a href=""><i class="fa fa-times"></i>Cancel</a>
                </li>
            </ul>
        </div><!--/checkout-options--> --}}

        @if (!Auth::check())
            <div class="register-req">
                <p>Hãy đăng ký và đăng nhập để xem lại lịch sử mua hàng.</p>
            </div><!--/register-req-->
        @endif
        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12 clearfix">
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @elseif(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    <div class="table-responsive cart_info">
                        <form action="{{url('/update-cart-ajax')}}" method="POST">
                            @csrf
                        <table class="table table-condensed">
                            <thead>
                                <tr class="cart_menu">
                                    <td class="image">Hình ảnh</td>
                                    <td class="description">Tên sản phẩm</td>
                                    <td class="price">Giá</td>
                                    <td class="quantity">Số lượng</td>
                                    <td class="total">Thành tiền</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($content as $v_content)
                                
                                @endforeach --}}
                                {{-- @php
                                    echo '<pre>';
                                    print_r(Session::get('cart'));
                                    echo '</pre>';
                                @endphp --}}
                                @if (Session::get('cart') == true)
                                
                                
                                @php
                                    $total = 0;
                                @endphp
            
                                @foreach(Session::get('cart') as $key => $cart)
                                @php
                                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td class="cart_product">
                                        <a href=""><img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="50" alt="{{$cart['product_name']}}"></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href=""></a></h4>
                                        <p>{{$cart['product_name']}} </p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">
                                            
                                            <div class="quantity">
                                                
                                                <input class="cart_quantity" type="number" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" size="2" >
                                                
                                            </div>
                                            
                                                                           
                                        </div>
                                    </td>
                                    <td class="cart_total">                           
                                        <p class="cart_total_price">{{number_format($subtotal,0,',','.')}}đ</p>
                                    </td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete" href="{{url('/delete-cart-ajax/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                
                                @endforeach
                                <tr>
                                    <td><input type="submit" name="update_qty" value="Cập nhật giỏ hàng" class="btn btn-default check_out"></td>
                                    <td><a class="btn btn-default check_out" href="{{url('/del-all-cart-ajax')}}">Xóa tất cả giỏ hàng</a></td>
                                    
                                    <td>
                                        @if (Session::get('coupon'))
                                        <a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xóa mã</a>
                                        @endif
                                    </td>
                                    <td colspan="2">
                                        <li>Tổng tiền: <span>{{number_format($total,0,',','.')}}đ</span></li>
                                        
                                        @php
                                            $final_total = $total;
                                            $has_discount = false;
                                        @endphp
                                
                                        <!-- Hiển thị mã giảm giá nếu có -->
                                        @if(Session::get('coupon'))
                                            <li>
                                                @foreach (Session::get('coupon') as $key => $cou)
                                                    @if ($cou['coupon_condition']==1)
                                                        Mã giảm: {{$cou['coupon_number']}}%
                                                        @php
                                                            $discount = ($total*$cou['coupon_number'])/100;
                                                            $final_total -= $discount;
                                                            $has_discount = true;
                                                        @endphp
                                                    @elseif($cou['coupon_condition']==2)
                                                        Mã giảm: {{number_format($cou['coupon_number'],0,',','.')}}đ
                                                        @php
                                                            $final_total -= $cou['coupon_number'];
                                                            $has_discount = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </li>
                                        @endif
                                
                                        <!-- Hiển thị phí vận chuyển nếu có -->
                                        @if (Session::get('fee'))
                                            <li>
                                                <a class="cart_quantity_delete" href="{{url('/del-fee-ajax/')}}"><i class="fa fa-times"></i></a>
                                                Phí vận chuyển: <span>{{number_format(Session::get('fee'),0,',','.')}}đ</span>
                                                @php
                                                    $final_total += Session::get('fee');
                                                @endphp
                                            </li>
                                        @endif
                                
                                        <!-- Hiển thị tổng còn lại -->
                                        <li>Tổng thanh toán: <span>{{ number_format($final_total, 0, ',', '.') }}đ</span></li>
                                        
                                        <!-- Hiển thị thông báo tiết kiệm nếu có mã giảm giá -->
                                        @if($has_discount)
                                            <li class="text-success">
                                                Bạn đã tiết kiệm: <span>{{ number_format($total - $final_total + (Session::get('fee') ?? 0), 0, ',', '.') }}đ</span>
                                            </li>
                                        @endif
                                    </td>
                                    
                                </tr>

                                @else
                                <tr>
                                    <td colspan="5"><center>
                                    @php
                                    echo '<p>Không có sản phẩm nào trong giỏ hàng<p>';
                                    
                                    @endphp
                                    </center></td>
                                    
                                </tr>
                                @endif
                                
            
                            </tbody>
                             
                        </form>
                        @if (Session::get('cart'))
                        <tr>
                            <td>   
                                                        
                                <form method="POST" action="{{url('/check-coupon')}}">
                                    @csrf
                                    <input type="text" name="coupon" placeholder="Nhập mã giảm giá">
                                    <input class="btn btn-default check_coupon" type="submit" name="check_coupon" value="Áp dụng">
                                </form>
                            </td>
                            <td>
                                <td>
                                    <form action="{{url('/vnpay')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="total_vnpay" value="{{ $final_total }}" hidden>
                                        <button type="submit" class="btn btn-default check_out" name="redirect" >Thanh toán VNPAY</button>
                                    </form>
                                </td>
                            </td>
                        </tr>
                        
                        @endif 
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin giao hàng</p>
                        <div class="form-one">
                            <form method="POST">
                                @csrf
                                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email" required value="{{ old('shipping_email') }}">
                                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên" required value="{{ old('shipping_name') }}">
                                <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ" required value="{{ old('shipping_address') }}">
                                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại" required value="{{ old('shipping_phone') }}">
                                <textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú đơn hàng" rows="5" required value="{{ old('shipping_notes') }}"></textarea>
                                
                                @if (Session::get('fee'))
                                <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                                @else
                                <input type="hidden" name="order_fee" class="order_fee" value="25000">
                                @endif

                                @if (Session::get('coupon'))
                                    @foreach (Session::get('coupon') as $key => $cou)
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                                    
                                    @endforeach
                                
                                @else
                                <input type="hidden" name="order_coupon" class="order_coupon" value="0">
                                @endif
                                
                                
                                
                                <div class="">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                                        <select name="payment_select" class="form-control input-sm m-bot15 wards payment_select" required>
                                            <option value="0">Chuyển khoản</option>
                                            <option value="1">Tiền mặt</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">
                            </form>
                            <form>
                                @csrf 
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn thành phố</label>
                                    {{-- doi chieu city o layout_blade --}}
                                    <select name="cỉty" id="city" class="form-control input-sm m-bot15 choose city" required> 
                                        <option value="">--Chọn tỉnh thành phố--</option>
                                        @foreach ($city as $key => $ci)
                                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                        
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn quận huyện</label>
                                    <select name="province" id="province" class="form-control input-sm m-bot15 province choose" required>
                                        <option value="">--Chọn quận huyện--</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn xã phường</label>
                                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards" required>
                                        <option value="">--Chọn xã phường--</option>
                                        
                                    </select>
                                </div>
                                
                                <input type="submit" value="Tính phí vận chuyển" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery">
                            </form>
                            
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        

        {{-- <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="images/cart/one.png" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">Colorblock Scuba</a></h4>
                            <p>Web ID: 1089772</p>
                        </td>
                        <td class="cart_price">
                            <p>$59</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href=""> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href=""> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">$59</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="images/cart/two.png" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">Colorblock Scuba</a></h4>
                            <p>Web ID: 1089772</p>
                        </td>
                        <td class="cart_price">
                            <p>$59</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href=""> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href=""> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">$59</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="images/cart/three.png" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">Colorblock Scuba</a></h4>
                            <p>Web ID: 1089772</p>
                        </td>
                        <td class="cart_price">
                            <p>$59</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href=""> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href=""> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">$59</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Cart Sub Total</td>
                                    <td>$59</td>
                                </tr>
                                <tr>
                                    <td>Exo Tax</td>
                                    <td>$2</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Shipping Cost</td>
                                    <td>Free</td>										
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><span>$61</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> --}}
        
    </div>
</section> <!--/#cart_items-->

@endsection