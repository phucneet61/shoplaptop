@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thương hiệu laptop
                </header>
                <div class="panel-body">
                    <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('message',null);
                    }
                    ?>
                    @foreach ($edit_brand_product as $key => $edit_value)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu laptop</label>
                            <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền thương hiệu" value="{{$edit_value->brand_name}}" class="form-control" name="brand_product_name" id="exampleInputEmail1" placeholder="Tên thương hiệu laptop">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu laptop</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền mô tả thương hiệu" rows="5" class="form-control" name="brand_product_desc" id="exampleInputPassword1" >{{$edit_value->brand_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa thương hiệu laptop</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền Từ khóa thương hiệu" rows="5" class="form-control" name="brand_product_keywords" id="exampleInputPassword1" placeholder="Mô tả thương hiệu laptop">{{$edit_value->meta_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="brand_product_status" class="form-control input-sm m-bot15">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                                
                            </select>
                        </div>
                        <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật thương hiệu laptop</button>
                        </form>
                    </div>
                    @endforeach

                    
                    {{-- <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_brand_product->brand_id)}}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu laptop</label>
                            <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền thương hiệu" value="{{$edit_brand_product->brand_name}}" class="form-control" name="brand_product_name" id="exampleInputEmail1" placeholder="Tên thương hiệu laptop">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu laptop</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền mô tả thương hiệu" rows="5" class="form-control" name="brand_product_desc" id="exampleInputPassword1" >{{$edit_brand_product->brand_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa thương hiệu laptop</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền Từ khóa thương hiệu" rows="5" class="form-control" name="brand_product_keywords" id="exampleInputPassword1" placeholder="Mô tả thương hiệu laptop">{{$edit_brand_product->meta_keywords}}</textarea>
                        </div>
                        
                        <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật thương hiệu laptop</button>
                        </form>
                    </div> --}}
                    

                </div>
            </section>

    </div>
    
</div>
@endsection