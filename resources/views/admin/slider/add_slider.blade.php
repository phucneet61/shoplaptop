@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm slider 
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
                        <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="slider_name">Tên slider</label>
                                <input type="text" class="form-control" id="slider_name" name="slider_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="slider_desc">Mô tả slider</label>
                                <textarea class="form-control" id="slider_desc" name="slider_desc" rows="3" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="slider_image">Hình ảnh</label>
                                <input type="file" class="form-control" id="slider_image" name="slider_image" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="slider_status">Trạng thái</label>
                                <select class="form-control" id="slider_status" name="slider_status">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Thêm slider</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection