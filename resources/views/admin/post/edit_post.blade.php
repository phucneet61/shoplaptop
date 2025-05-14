@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Chỉnh sửa bài viết
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ URL::to('/update-post/' . $edit_post->post_id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="post_title">Tên bài viết</label>
                            <input type="text" class="form-control" name="post_title" id="post_title" value="{{ $edit_post->post_title }}">
                        </div>
                        <div class="form-group">
                            <label for="post_slug">Slug</label>
                            <input type="text" class="form-control" name="post_slug" id="post_slug" value="{{ $edit_post->post_slug }}">
                        </div>
                        <div class="form-group">
                            <label for="post_desc">Tóm tắt bài viết</label>
                            <textarea class="form-control" name="post_desc" id="ckeditor1" rows="5">{{ $edit_post->post_desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="post_content">Nội dung bài viết</label>
                            <textarea class="form-control" name="post_content" id="ckeditor" rows="5">{{ $edit_post->post_content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="post_meta_keywords">Meta từ khóa</label>
                            <textarea class="form-control" name="post_meta_keywords" id="post_meta_keywords" rows="3">{{ $edit_post->post_meta_keywords }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="post_meta_desc">Meta nội dung</label>
                            <textarea class="form-control" name="post_meta_desc" id="post_meta_desc" rows="3">{{ $edit_post->post_meta_desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cate_post_id">Danh mục bài viết</label>
                            <select name="cate_post_id" class="form-control">
                                @foreach ($cate_post as $category)
                                    <option value="{{ $category->cate_post_id }}" {{ $edit_post->cate_post_id == $category->cate_post_id ? 'selected' : '' }}>
                                        {{ $category->cate_post_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="post_image">Hình ảnh</label>
                            <input type="file" name="post_image" class="form-control">
                            @if ($edit_post->post_image)
                                <img src="{{ asset('public/uploads/posts/' . $edit_post->post_image) }}" height="100" width="100">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="post_status">Trạng thái</label>
                            <select name="post_status" class="form-control">
                                <option value="1" {{ $edit_post->post_status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ $edit_post->post_status == 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">Cập nhật bài viết</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection