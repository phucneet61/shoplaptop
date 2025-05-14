@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm bài viết 
                </header>
                <div class="panel-body">
                    <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('message',null);
                    }
                    ?>
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-post')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên bài viết</label>
                                <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền tên bài viết" class="form-control" name="post_title" id="slug" onkeyup="ChangeToSlug()" placeholder="Tên thương hiệu laptop" value="{{ old('post_title') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Slug</label>
                                <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Slug không được để trống, nếu sai hãy nhập dấu cách vào tên bài viết và xóa ký tự của nó" class="form-control" name="post_slug" id="convert_slug" placeholder="Slug" readonly value="{{ old('post_slug') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tóm tắt bài viết</label>
                                <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Tóm tắt bài viết không được để trống" rows="5" class="form-control" name="post_desc" id="ckeditor1" placeholder="Mô tả thương hiệu laptop">{{ old('post_desc') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung bài viết</label>
                                <textarea style="resize:none" rows="5" class="form-control" name="post_content" id="ckeditor" placeholder="Mô tả thương hiệu laptop">{{ old('post_content') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta từ khóa</label>
                                <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Từ khóa không được để trống" rows="5" class="form-control" name="post_meta_keywords" id="exampleInputPassword1" placeholder="Mô tả thương hiệu laptop">{{ old('post_meta_keywords') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta nội dung</label>
                                <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền meta nội dung" rows="5" class="form-control" name="post_meta_desc" id="exampleInputPassword1" placeholder="Mô tả thương hiệu laptop">{{ old('post_meta_desc') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                                <input type="file" data-validation="image" data-validation-error-msg="Thêm ảnh" class="form-control" name="post_image" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục bài viết</label>
                                <select name="cate_post_id" class="form-control input-sm m-bot15">
                                    @foreach ($cate_post as $key => $cate)
                                        <option value="{{$cate->cate_post_id}}" {{ old('cate_post_id') == $cate->cate_post_id ? 'selected' : '' }}>{{$cate->cate_post_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="post_status" class="form-control input-sm m-bot15">
                                    <option value="1" {{ old('post_status') == 1 ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ old('post_status') == 0 ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>
                            <button type="submit" name="add_post" class="btn btn-info">Thêm bài viết</button>
                        </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection