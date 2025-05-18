@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông tin khách hàng
      </div>


      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <?php
          $message = Session::get('message');
          if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message',null);
          }
          ?>
          <thead>
            <tr>
              
              <th>Tên khách hàng</th>
              <th>Số điện thoại</th>
              <th>Email</th>

              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
           {{-- @foreach ($order_by_id as $key => $order_by_id) --}}
            
            
            <tr>
              <td>{{$customer->customer_name}}</td>
              <td>{{$customer->customer_phone}}</td>
              <td>{{$customer->customer_email}}</td>

            </tr>
            {{-- @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>
</div>
<br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin vận chuyển
    </div>


    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên người nhận</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>


            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
         
          
          {{-- @foreach ($order_by_id as $key => $v_content) --}}
          <tr>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>{{$shipping->shipping_notes}}</td>
            <td>@if ($shipping->shipping_method==0)
            Chuyen khoan
            @else
            Tien mat
            @endif</td>

          </tr>
          {{-- @endforeach --}}
        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div>

    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng kho</th>
            <th>Mã giảm giá</th>
            <th>Phí ship</th>
            <th>Số lượng</th>
            <th>Giá sản phẩm</th>
            <th>Tổng tiền</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php
          $i = 0;
          $total = 0;
          @endphp
          @foreach ($order_details as $key => $detail)
          @php
          $i++;
          $subtotal = $detail->product_price * $detail->product_sales_quantity;
          $total += $subtotal;
          @endphp
          <tr class="color_qty_{{$detail->product_id}}">
            <td><i>{{$i}}</i></label></td>
            <td>{{$detail->product_name}}</td>
            <td>{{$detail->product->product_quantity}}</td>
            <td>@if ($detail->product_coupon!='no')
              {{$detail->product_coupon}}
              @else
              Không có mã
            @endif</td>
            <td>{{ number_format($detail->product_feeship, 0, ',','.') }}đ</td>
            <td>
              <input type="number" min="1" {{$order_status==2 ? 'disabled' : ''}} class="order_qty_{{$detail->product_id}}" value="{{$detail->product_sales_quantity}}" name="product_sales_quantity">
              
              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$detail->product_id}}" value="{{$detail->product->product_quantity}}">
              
              <input type="hidden" name="order_code" class="order_code" value="{{$detail->order_code}}">

              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$detail->product_id}}">
              @if ($order_status!=2)
              <button class="btn btn-default update_quantity_order" data-product_id="{{$detail->product_id}}" name="update_quantity_order" >Cập nhật</button>
              
              @endif
            </td>
            <td>{{ number_format($detail->product_price, 0, ',','.') }}đ</td> 
            <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
            
          </tr>
          
          @endforeach
          <tr>
            <td>
              
              @if($coupon)
                @if($coupon_condition == 1)
                    <!-- Giảm theo phần trăm -->
                    @php
                        $total_after_coupon = ($total * $coupon_number) / 100;
                        $total_coupon = $total - $total_after_coupon + $detail->product_feeship;
                        echo 'Tổng giảm: ', number_format($total_after_coupon, 0, ',', '.'), 'đ','</br>';
                    @endphp
                @else
                    <!-- Giảm theo số tiền cố định -->
                    @php
                        $total_coupon = $total - $coupon_number + $detail->product_feeship;
                        echo 'Tổng giảm: ', number_format($total_coupon, 0, ',', '.'), 'đ','</br>';
                    @endphp
                @endif
              @else
                  <!-- Không có coupon -->
                  @php
                      $total_coupon = $total;
                  @endphp
              @endif
              
              Phí ship: {{ number_format($detail->product_feeship, 0, ',', '.') }}đ</br>
              Thanh toán: {{ number_format($total_coupon, 0, ',', '.') }}đ
            </td>
          </tr>
          <tr>
            <td colspan="6">
              @foreach ($order as $key => $or)
               @if ($or->order_status==1)
                <form>
                  @csrf
                  <select class="form-control order_details">
                    <option value="">-----------Chon hinh thuc don hang------------</option>
                    <option id="{{$or->order_id}}" selected value="1">Chua xu ly</option>
                    <option id="{{$or->order_id}}" value="2">Đã xử lý-Đã giao hàng</option>
                    <option id="{{$or->order_id}}" value="3">Hủy đơn hàng-Tạm giữ</option>
                  </select>
                </form>
               @elseif ($or->order_status==2)
               <form>
                @csrf
                <select class="form-control order_details">
                  <option value="">-----------Chon hinh thuc don hang------------</option>
                  <option id="{{$or->order_id}}" value="1">Chua xu ly</option>
                  <option id="{{$or->order_id}}" selected value="2">Đã xử lý-Đã giao hàng</option>
                  <option id="{{$or->order_id}}" value="3">Hủy đơn hàng-Tạm giữ</option>
                </select>
              </form>
               @else
               <form>
                @csrf
                <select class="form-control order_details">
                  <option value="">-----------Chon hinh thuc don hang------------</option>
                  <option id="{{$or->order_id}}" value="1">Chua xu ly</option>
                  <option id="{{$or->order_id}}" value="2">Đã xử lý-Đã giao hàng</option>
                  <option id="{{$or->order_id}}" selected value="3">Hủy đơn hàng-Tạm giữ</option>
                </select>
              </form>
               @endif
              @endforeach
            </td>
          </tr>
        </tbody>
      </table>
      <a target="_blank" href="{{url('/print-order/'.$detail->order_code)}}">In don hang</a>
    </div>
    
  </div>
</div>
<br><br>
{{-- <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div>

    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
        <?php
        $message = Session::get('message');
        if($message){
          echo '<span class="text-alert">'.$message.'</span>';
          Session::put('message',null);
        }
      ?>
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên người đặt</th>
            <th>Tổng giá tiền</th>
            <th>Tình trạng</th>
            <th>Hiển thị</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
         
          
          
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <a href="" class="active" style="font-size: 27px" ui-toggle-class=""><i class="fa fa-pencil text-success text-active"></i></a>
              <a href="" class="active" style="font-size: 27px" onclick="return confirm('Bạn muốn xóa đơn hàng này không?');" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div> --}}
@endsection