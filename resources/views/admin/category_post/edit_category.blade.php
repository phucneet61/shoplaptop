@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục bài viết 
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
                        <form role="form" action="{{URL::to('/update-category-post/'.$category_post->cate_post_id)}}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền ten danh muc" class="form-control" name="cate_post_name" id="slug" onkeyup="ChangeToSlug()" value="{{$category_post->cate_post_name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Slug</label>
                            <input type="text" class="form-control" name="cate_post_slug" id="convert_slug" placeholder="Slug" value="{{$category_post->cate_post_slug}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền Từ khóa thương hiệu" rows="5" class="form-control" name="cate_post_desc" id="exampleInputPassword1">{{$category_post->cate_post_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="cate_post_status" class="form-control input-sm m-bot15">
                                @if($category_post->cate_post_status==1)
                                <option selected value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                                @else
                                <option selected value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                                @endif
                            </select>
                        </div>
                        
                        <button type="submit" name="update_post_cate" class="btn btn-info">Cập nhật  danh mục bài viết</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection