@extends('layout')
@section('content')
@foreach ($product_details as $key => $value)
<div class="product-details"><!--product-details-->
    <style type="text/css">
        .lSSlideOuter .lSPager.lSGallery img {
            display: block;
            height: 100px;
            max-width: 100%;
        }
    </style>
    <div class="col-sm-5">
        <div class="view-product">
            {{-- <img src="{{ URL::to('public/uploads/product/' . $value->product_image) }}" alt="{{ $value->product_name }}" /> --}}
			
            <ul id="imageGallery">
                {{-- <li data-thumb="{{ URL::to('public/uploads/product/' . $value->product_image) }}">
                    <img src="{{ URL::to('public/uploads/product/' . $value->product_image) }}" />
                </li> --}}
                @foreach ($gallery as $gal)
                    <li data-thumb="{{ URL::to('public/uploads/gallery/' . $gal->gallery_image) }}">
                        <img alt="{{$gal->gallery_name}}" src="{{ URL::to('public/uploads/gallery/' . $gal->gallery_image) }}" />
                    </li>
                @endforeach
                
            </ul>
        </div>
        

    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="{{URL::to('public/frontend/images/new.jpg')}}" class="newarrival" alt="" />
            <h2>{{$value->product_name}}</h2>
            <p>Mã Sản phẩm: {{$value->product_id}}</p>
            <img src="{{URL::to('public/frontend/images/rating.png')}}" alt="" />
            <form action="{{URL::to('/save-cart')}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                <input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">
                <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
            <span>
                <span>
                    <span>{{number_format($value->product_price).' đ'}}</span>
                </span>
            <label>Số lượng:</label>
            <input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}"  value="1" />
            <input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
            
            </span>
            <input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">

            </form>
            <p><b>Tình trạng:</b> Còn hàng</p>
            <p><b>Điều kiện:</b> Mới 100%</p>
            <p><b>Thương hiệu:</b> {{$value->brand_name}}</p>
            <p><b>Danh mục:</b> {{$value->category_name}}</p>
            {{-- <a href=""><img src="{{asset('/public/frontend/images/share.png')}}" class="share img-responsive"  alt="" /></a> --}}
            {{-- <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="" data-action="" data-size="" data-share="true"></div> --}}
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->


<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Mô tả sản phẩm</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
            {{-- <li><a href="#reviews" data-toggle="tab">Đánh giá (5)</a></li> --}}
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details" >
            <p>{!!$value->product_desc!!}</p>

            
        </div>
        
        <div class="tab-pane fade" id="companyprofile" >
            <p>{!!$value->product_content!!}</p>
        </div>
        
        
        {{-- <div class="tab-pane fade" id="reviews" >
            
            <div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="" data-numposts="3"></div>
        </div> --}}
        
    </div>
</div><!--/category-tab-->
@endforeach
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm liên quan</h2>
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">	
                @foreach($relate as $lienquan)
                <div class="col-sm-4"><a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_id)}}">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{URL::to('public/uploads/product/'.$lienquan->product_image)}}" alt="" />
                                <h2>{{number_format($lienquan->product_price).' '.'₫'}}</h2>
                                <p>{{$lienquan->product_name}}</p>
                                <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$lienquan->product_id}}" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
           <i class="fa fa-angle-left"></i>
         </a>
         <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
           <i class="fa fa-angle-right"></i>
         </a>			
    </div>
</div><!--/recommended_items-->
@endsection