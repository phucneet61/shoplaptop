@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Video</h2>
    @foreach ($all_video as $key => $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">

            
            <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                        @csrf
                        {{-- <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}"> --}}

                        <a href="">
                        <img src="" alt="" />
                        <h2></h2>
                        <p></p>
                        </a>
                        {{-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a> --}}
                        <input type="button" class="btn btn-default add-to-cart" data-id_video="" name="add-to-cart" value="Xem video">
                        {{-- <input name="qty" type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}" /> --}}
                        </form>
                    </div>
                    {{-- <div class="product-overlay">
                        <div class="overlay-content">
                            <h2>{{number_format($product->product_price).' '.'₫'}}</h2>
                            <p>{{$product->product_name}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                        </div>
                    </div> --}}
            </div>
            
        </div>
    </div>
    @endforeach
    <ul class="pagination pagination-sm m-t-none m-b-none justify-content-center">
        {!! $all_video->appends(request()->query())->links('pagination::bootstrap-4') !!}
    </ul>
    
    
</div><!--features_items-->

@endsection