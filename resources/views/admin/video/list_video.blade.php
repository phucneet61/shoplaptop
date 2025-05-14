@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê video 
      </div>

      <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
                         
        </div>
          <?php
          $message = Session::get('message');
          if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message',null);
          }
        ?>
        <div class="col-sm-12">
            <div class="position-center">
                <form>
                    {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputEmail1">Tên video</label>
                    <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền tên video" class="form-control video_title" name="video_title" id="slug" onkeyup="ChangeToSlug()" placeholder="Tên thương hiệu laptop" value="{{ old('video_title') }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Slug video</label>
                    <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Slug không được để trống, nếu sai hãy nhập dấu cách vào tên video và xóa ký tự của nó" class="form-control video_slug" name="video_slug" id="convert_slug" placeholder="Slug" readonly value="{{ old('video_slug') }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Link video</label>
                    <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền thương hiệu" class="form-control link_video" name="link_video" id="exampleInputEmail1" placeholder="Tên thương hiệu laptop">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mô tả video</label>
                    <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền Từ khóa thương hiệu" rows="5" class="form-control video_desc" name="video_desc" id="exampleInputPassword1" placeholder="Mô tả thương hiệu laptop"></textarea>
                </div>
                {{-- <div class="form-group">
                    <label for="exampleInputPassword1">Hiển thị</label>
                    <select name="brand_product_status" class="form-control input-sm m-bot15">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                        
                    </select>
                </div> --}}
                
                <button type="button" name="add_brand_product" class="btn btn-info btn-add-video">Thêm video</button>
            </form>
            <div id="notify"></div>
            </div>
        </div>
        
      </div>
      <div class="table-responsive">
        <div id="video_load"></div>
        
      </div>
      
    </div>
    <!-- Modal -->
    <div class="modal fade" id="video_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tên video</h5>
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
            </div>
            <div class="modal-body">
            Video Here
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        </div>
    </div>
  </div>
@endsection