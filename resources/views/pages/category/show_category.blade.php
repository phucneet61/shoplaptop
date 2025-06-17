@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
    {{-- <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="" data-action="" data-size="" data-share="true"></div> --}}
    @foreach ($category_name as $key => $name)
    <h2 class="title text-center">{{$name->category_name}}</h2>    
    @endforeach
    @foreach ($category_by_id as $key => $product)
    <div class="col-sm-4"><a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
        <div class="product-image-wrapper">

            <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                        @csrf
                        <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                        <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                        <h2>{{number_format($product->product_price).' '.'₫'}}</h2>
                        <p>{{$product->product_name}}</p>
                        <a href="#" data-id_product="{{$product->product_id}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                        <input name="qty" type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}" />
                        </form>
                    </div>
            </div>
            {{-- <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Thêm yêu thích</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>Thêm so sánh</a></li>
                </ul>
            </div> --}}
        </div>
    </div>
    @endforeach
    
    
</div><!--features_items-->
<ul class="pagination pagination-sm m-t-none m-b-none justify-content-center">
    {!! $category_by_id->appends(request()->query())->links('pagination::bootstrap-4') !!}
</ul>
@endsection