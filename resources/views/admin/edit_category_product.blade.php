@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục sản phẩm
                </header>
                <div class="panel-body">
                    <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('message',null);
                    }
                    ?>
                    @foreach ($edit_category_product as $key => $edit_value)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền danh mục" value="{{$edit_value->category_name}}" class="form-control" name="category_product_name" id="exampleInputEmail1" placeholder="Tên danh mục">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền mô tả danh mục" rows="5" class="form-control" name="category_product_desc" id="exampleInputPassword1" >{{$edit_value->category_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa danh mục</label>
                            <textarea style="resize:none" data-validation="length" data-validation-length="min1" data-validation-error-msg="Điền mô tả danh mục" rows="5" class="form-control" name="category_product_keywords" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$edit_value->meta_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thuộc danh mục</label>
                            <select name="category_parent" class="form-control input-sm m-bot15">
                                <option value="0" {{$edit_value->category_parent == 0 ? 'selected' : ''}}>----Danh mục cha---</option>
                                @foreach ($category as $key => $val)
                                    @if($val->category_parent == 0)
                                        {{-- Hiển thị danh mục cha --}}
                                        <option {{$val->category_id == $edit_value->category_parent ? 'selected' : ''}} value="{{$val->category_id}}">{{$val->category_name}}</option>
                                        
                                        {{-- Hiển thị danh mục con thuộc danh mục cha --}}
                                        @foreach ($category as $key => $val2)
                                            @if($val2->category_parent == $val->category_id)
                                                <option {{$val2->category_id == $edit_value->category_parent ? 'selected' : ''}} value="{{$val2->category_id}}">---|{{$val2->category_name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật danh mục</button>
                        </form>
                    </div>
                    @endforeach

                </div>
            </section>

    </div>
    
</div>
@endsection