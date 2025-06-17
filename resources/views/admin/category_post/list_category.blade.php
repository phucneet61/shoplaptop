@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê danh mục bài viết
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
              <th>Tên danh mục bài viết</th>
              <th>Mô tả danh mục</th>
              <th>Slug</th>
              <th>Hiển thị</th>
              <th style="width:30px;">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($category_post as $key => $cate_post)
            
            
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$cate_post->cate_post_name}}</td>
              <td>{{$cate_post->cate_post_desc}}</td>
              <td>{{$cate_post->cate_post_slug}}</td>
              <td>
                @if ($cate_post->cate_post_status==1)
                Hiển thị
                @else
                Ẩn
                @endif
              </td>
              <td>
                <a href="{{URL::to('/edit-category-post/'.$cate_post->cate_post_id)}}" class="active" style="font-size: 27px" ui-toggle-class=""><i class="fa fa-pencil text-success text-active"></i></a>
                <a href="{{URL::to('/delete-category-post/'.$cate_post->cate_post_id)}}" class="active" style="font-size: 27px" onclick="return confirm('Bạn muốn xóa danh mục bài viết này không?');" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection