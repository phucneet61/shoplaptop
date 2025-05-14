@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê bài viết
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
              <th>Tiêu đề</th>
              <th>Hình ảnh</th>
              <th>Slug</th>
              <th>Mô tả bài viết</th>
              <th>Từ khóa bài viết</th>
              <th>Danh mục</th>
              <th>Trạng thái</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_post as $key => $post)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{ $post->post_title }}</td>
              <td><img src="{{asset('public/uploads/posts/'.$post->post_image)}}" height="100" width="100"></td>
              <td>{{ $post->post_slug }}</td>
              <td>{!! $post->post_desc !!}</td>
              <td>{{ $post->post_meta_keywords }}</td>
              <td>{{ $post->cate_post->cate_post_name  }}</td> 
              {{-- cate_post la lay tu bang category post co quan he voi post --}}
              <td>
                @if ($post->post_status == 0)
                  <a>
                    <span class="label label-danger" style="font-size:20px;">Ẩn</span>
                  </a>
                @else
                  <a>
                    <span class="label label-success" style="font-size:20px;">Hiển thị</span>
                  </a>
                @endif
              </td>
              <td>
                <a href="{{ URL::to('/edit-post/' . $post->post_id) }}" class="active" style="font-size: 27px" ui-toggle-class="">
                  <i class="fa fa-pencil text-success text-active"></i>
                </a>
                <a href="{{ URL::to('/delete-post/' . $post->post_id) }}" class="active" style="font-size: 27px" onclick="return confirm('Bạn muốn xóa bài viết này không?');" ui-toggle-class="">
                  <i class="fa fa-times text-danger text"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{-- <footer class="panel-footer">
        <div class="row">
          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">Hiển thị {{ $all_post->count() }} bài viết</small>
          </div>
          <div class="col-sm-7 text-right text-center-xs">                
            {{ $all_post->links() }}
          </div>
        </div>
      </footer> --}}
    </div>
  </div>
@endsection