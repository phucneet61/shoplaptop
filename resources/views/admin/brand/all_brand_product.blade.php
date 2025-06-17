@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê thương hiệu laptop 
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
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên thương hiệu</th>
              <th>Hiển thị</th>
              <th>Từ khóa</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_brand_product as $key => $brand_pro)
            
            
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$brand_pro->brand_name}}</td>
              <td><span class="text-ellipsis">
                <?php
                if ($brand_pro->brand_status == 0) {
                    echo '<a href="' . URL::to('/active-brand-product/' . $brand_pro->brand_id) . '">
                            <span class="label label-danger" style="font-size:20px;">Không</span>
                          </a>';
                } else {
                    echo '<a href="' . URL::to('/unactive-brand-product/' . $brand_pro->brand_id) . '">
                            <span class="label label-success" style="font-size:20px;">Có</span>
                          </a>';
                }
                ?>
                </span></td>
              <td>{{$brand_pro->meta_keywords}}</td>
              
              </span></td>
              <td>
                <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active" style="font-size: 27px" ui-toggle-class=""><i class="fa fa-pencil text-success text-active"></i></a>
                <a href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active" style="font-size: 27px" onclick="return confirm('Bạn muốn xóa thương hiệu này không?');" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection