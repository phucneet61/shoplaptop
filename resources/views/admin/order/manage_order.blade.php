@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê đơn hàng 
      </div>

      <div class="row w3-res-tb">
        
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
              
              <th>Thứ tự</th>
              <th>Mã đơn hàng</th>
              <th>Ngày tạo đơn</th>
              <th>Tình trạng đơn hàng</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @php
            $i = 0;
            @endphp
            @foreach ($order as $key => $ord)
            @php
            $i++;
            @endphp
            <tr>
              <td><i>{{$i}}</i></label></td>
              <td>{{$ord->order_code}}</td>
              <td>{{$ord->created_at}}</td>
              <td>@if ($ord->order_status==1)
              Don hang moi
              @else
              Da xu ly
              @endif


              </td>
              
              <td>
                <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active" style="font-size: 27px" ui-toggle-class=""><i class="fa fa-eye text-success text-active"></i></a>
                <a href="{{URL::to('/delete-order/'.$ord->order_code)}}" class="active" style="font-size: 27px" onclick="return confirm('Bạn muốn xóa ?');" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection