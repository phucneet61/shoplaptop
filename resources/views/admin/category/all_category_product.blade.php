@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê danh mục sản phẩm
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
        {{-- <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="button">Go!</button>
            </span>
          </div>
        </div> --}}
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
              <th>Tên danh mục</th>
              <th>Thuộc danh mục</th>
              <th>Hiển thị</th>
              <th>Từ khóa</th>

              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_category_product as $key => $cate_pro)
            
            
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$cate_pro->category_name}}</td>
              <td>
                @if($cate_pro->category_parent == 0) 
                  <span style="color:green">Danh mục cha</span>
                @else

                  @foreach ($category_product as $key => $cate_sub_pro)
                    @if($cate_sub_pro->category_id == $cate_pro->category_parent)
                    <span style="color: red">{{$cate_sub_pro->category_name}}</span>        
                    @endif      
                  @endforeach

                @endif
              </td>
              <td><span class="text-ellipsis">
                <?php
                if ($cate_pro->category_status == 0) {
                    echo '<a href="' . URL::to('/active-category-product/' . $cate_pro->category_id) . '">
                            <span class="label label-danger" style="font-size:20px;">Không</span>
                          </a>';
                } else {
                    echo '<a href="' . URL::to('/unactive-category-product/' . $cate_pro->category_id) . '">
                            <span class="label label-success" style="font-size:20px;">Có</span>
                          </a>';
                }
                ?>
              <td>{{$cate_pro->meta_keywords}}</td>
              
              </span></td>
              <td>
                <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active" style="font-size: 27px" ui-toggle-class=""><i class="fa fa-pencil text-success text-active"></i></a>
                <a href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active" style="font-size: 27px" onclick="return confirm('Bạn muốn xóa danh mục này không?');" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- import data --}}
        <form action="{{url('/import-csv')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="file" accept=".xlsx"><br>
        <input type="submit" value="Import Excel" name="import_csv" class="btn btn-warning">
        </form>
        {{-- export data --}}
        <form action="{{url('/export-csv')}}" method="POST">
            @csrf
        <input type="submit" value="Export Excel" name="export_csv" class="btn btn-success">
        </form>

      </div>
      {{-- <footer class="panel-footer">
        <div class="row">
          
            <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">
              showing {{ $all_category_product->firstItem() }}-{{ $all_category_product->lastItem() }} of {{ $all_category_product->total() }} items
            </small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">                
            {{ $all_category_product->links('pagination::bootstrap-4') }}
            </div>
        </div>
      </footer> --}}
    </div>
  </div>
@endsection