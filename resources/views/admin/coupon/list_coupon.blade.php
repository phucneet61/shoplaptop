@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê mã giảm giá
      </div>

      <div class="row w3-res-tb">
        {{-- <div class="col-sm-5 m-b-xs">
          <select class="input-sm form-control w-sm inline v-middle">
            <option value="0">Bulk action</option>
            <option value="1">Delete selected</option>
            <option value="2">Bulk edit</option>
            <option value="3">Export</option>
          </select>
          <button class="btn btn-sm btn-default">Apply</button>                
        </div> --}}
        <div class="col-sm-4">
          <?php
          $message = Session::get('message');
          if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message',null);
          }
        ?>
        </div>
        
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="myTable">
          <thead>
            <tr>
              
              <th>Tên mã giảm giá</th>
              <th>Mã giảm giá</th>
              <th>Số lượng mã</th>
              <th>Điều kiện giảm giá</th>
              <th>Số % hoặc tiền giảm</th>
              <th>Tác vụ</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($coupon as $key => $cou)
            
            
            <tr>
              
              <td>{{$cou->coupon_name}}</td>
              <td>{{$cou->coupon_code}}</td>
              <td>{{$cou->coupon_time}}</td>
              <td><span class="text-ellipsis">
                <?php
                if ($cou->coupon_condition == 1) {
                echo 'Giảm theo %';
                } else {
                echo 'Giảm theo tiền';
                }
                ?>
                </span></td>
                <td><span class="text-ellipsis">
                    <?php
                    if ($cou->coupon_condition == 1) {
                    ?>
                    Giảm {{$cou->coupon_number}}%
                    <?php
                    } else {
                    ?>
                    Giảm {{$cou->coupon_number}}k
                    <?php
                    }
                    ?>
                    </span></td>
              
              </span></td>
              <td>
                <a href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active" style="font-size: 27px" onclick="return confirm('Bạn muốn xóa mã này không?');" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection