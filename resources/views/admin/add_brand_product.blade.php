@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thương hiệu laptop 
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
                        <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu laptop</label>
                            <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền thương hiệu" class="form-control" name="brand_product_name" id="exampleInputEmail1" placeholder="Tên thương hiệu laptop">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu laptop</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền mô tả thương hiệu" rows="5" class="form-control" name="brand_product_desc" id="exampleInputPassword1" placeholder="Mô tả thương hiệu laptop"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa thương hiệu laptop</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền Từ khóa thương hiệu" rows="5" class="form-control" name="brand_product_keywords" id="exampleInputPassword1" placeholder="Mô tả thương hiệu laptop"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="brand_product_status" class="form-control input-sm m-bot15">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                                
                            </select>
                        </div>
                        
                        <button type="submit" name="add_brand_product" class="btn btn-info">Thêm thương hiệu laptop</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection