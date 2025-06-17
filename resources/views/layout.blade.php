<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	{{----------- seo ------------}}
    <meta name="description" content="{{$meta_desc}}">
	<meta name="keywords" content="{{$meta_keywords}}">
	<meta name="robots" content="INDEX, FOLLOW">
	<meta name="title" content="{{$meta_title}}">
	<link rel="canonical" href="{{$url_canonical}}">
    <meta name="author" content="">
	<link rel="icon" type="image/x-icon" href="">

	<meta property="og:image" content="">
	<meta property="og:site_name" content="http://localhost/shop-laptop_laravel_9/">
	<meta property="og:description" content="{{$meta_desc}}">
	<meta property="og:title" content="{{$meta_title}}">
	<meta property="og:url" content="{{$url_canonical}}">
	<meta property="og:type" content="website">

	{{----------- end seo ------------}}
    <title>{{$meta_title}}</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
	{{-- <link href="{{asset('public/frontend/css/lightslider.css')}}" rel="stylesheet"> --}}
	<link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">



    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{('public/frontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('public/frontend/images/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('public/frontend/images/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('public/frontend/images/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('public/frontend/images/apple-touch-icon-57-precomposed.png')}}">
</head><!--/head-->

<body>
	

	<header id="header"><!--header-->
		{{-- <div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top--> --}}
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="/shop-laptop_laravel_9"><img style="height: 100px; width: 139px;" src="{{asset('public/frontend/images/laptopminhquan.png')}}" alt="" /></a>
						</div>
						
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="{{URL::to('login-checkout')}}"><i class="fa fa-user"></i> Tài khoản</a></li>
								{{-- <li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li> --}}
								<?php
								$customer_id = Session::get('customer_id');
								$shipping_id = Session::get('shipping_id');
								if($customer_id!=NULL && $shipping_id==NULL){
								?>
								<li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
								}elseif($customer_id!=NULL && $shipping_id!=NULL){
								?>
								<li><a href="{{URL::to('/payment')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
								}else{
								?>
								<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
								}
								?>


								<li><a href="{{URL::to('/gio-hang')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
								<?php
								$customer_id = Session::get('customer_id');
								if($customer_id!=NULL){
								?>
								<li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
								<?php
								}else{
								?>
								<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
								<?php
								}
								?>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach($category as $key => $danhmuc)
                                        <li><a href="{{URL::to('/danh-muc-san-pham/'.$danhmuc->category_id)}}">{{$danhmuc->category_name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										@forelse($category_post as $key => $danhmucbaiviet)
											<li><a href="{{ URL::to('/danh-muc-bai-viet/'.$danhmucbaiviet->cate_post_slug) }}">{{ $danhmucbaiviet->cate_post_name }}</a></li>
										@empty
											<li><a href="#">Không có danh mục bài viết</a></li>
										@endforelse
									</ul>
                                </li> 
								<li><a href="{{URL::to('/gio-hang')}}">Giỏ hàng</a></li>
								{{-- <li><a href="{{URL::to('/video-shop')}}">Videos</a></li> --}}
								<li><a href="contact-us.html">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<form action="{{URL::to('/tim-kiem')}}" method="POST">
							{{ csrf_field() }}
						<div class="search_box pull-right">
							<input type="text" name="keywords_submit" placeholder="Tìm kiếm sản phẩm"/>
							<input type="submit" name="search_items" style="height: 37px; width: 37px; border: 1px solid #ccc; background: #FE980F; color: #fff; font-size: 18px;" value=">>">
						</div>
						</form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						{{-- <ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol> --}}
						
						<div class="carousel-inner">
							@php
							$i = 0;
							@endphp
							@foreach ($slider as $key =>$slide)
							@php
							$i++;
							@endphp
							<div class="item {{$i==1 ? 'active' : ''}}">
								{{-- <div class="col-sm-6">
									
									<p>{{$slide->slider_desc}}</p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div> --}}
								<div class="col-sm-12">
									<img alt="{{$slide->slider_desc}}" src="{{ asset('public/uploads/slider/' . $slide->slider_image) }}" width="100%" class="img img-responsive" alt="" />
									{{-- <img src="{{asset('public/frontend/images/pricing.png')}}"  class="pricing" alt="" /> --}}
								</div>
							</div>
							
							@endforeach
							
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh mục</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							@foreach ($category as $key => $cate)
							<div class="panel panel-default">
								@if ($cate->category_parent == 0)
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#{{$cate->category_id}}">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											{{$cate->category_name}}
										</a>
									</h4>
								</div>
								<div id="{{$cate->category_id}}" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
											@foreach ($category as $key => $cate_sub)
											@if ($cate_sub->category_parent == $cate->category_id)
												<li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}}</a></li>
											@endif
											@endforeach
										</ul>
									</div>
								</div>
								@endif
								
							</div>
							@endforeach
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Thương hiệu</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									@foreach ($brand as $key => $brand)
										<li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> <span class="pull-right"></span>{{ $brand->brand_name }}</a></li>
									@endforeach
									
								</ul>
							</div>
						</div><!--/brands_products-->
						
						{{-- <div class="price-range"><!--price-range-->
							<h2>Price Range</h2>
							<div class="well text-center">
								 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
								 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
							</div>
						</div><!--/price-range--> --}}
						
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					@yield('content')
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>laptop</span>-minhquan</h2>
							<p>Minh Quan Laptop Hai Duong</p>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>1/44 Vũ Hựu, TP Hải Dương</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Dịch vụ</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Hỗ trợ trực tuyến</a></li>
								<li><a href="#">Liên hệ</a></li>
								<li><a href="#">Tình trạng đơn hàng</a></li>
								<li><a href="#">Thay đổi địa chỉ</a></li>
								<li><a href="#">Câu hỏi thường gặp</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Sản phẩm nổi bật</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Laptop Gaming</a></li>
								<li><a href="#">Laptop Văn Phòng</a></li>
								<li><a href="#">Laptop Đồ Họa</a></li>
								<li><a href="#">Phụ Kiện Laptop</a></li>
								<li><a href="#">Laptop Cũ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Chính sách</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Điều khoản sử dụng</a></li>
								<li><a href="#">Chính sách bảo mật</a></li>
								<li><a href="#">Chính sách hoàn tiền</a></li>
								<li><a href="#">Hệ thống thanh toán</a></li>
								<li><a href="#">Hỗ trợ khách hàng</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Về Laptop Minh Quân</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Thông tin công ty</a></li>
								<li><a href="#">Tuyển dụng</a></li>
								<li><a href="#">Địa chỉ cửa hàng</a></li>
								<li><a href="#">Chương trình liên kết</a></li>
								<li><a href="#">Bản quyền</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Nhận thông tin mới nhất</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Nhập email của bạn" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Nhận các thông tin khuyến mãi và sản phẩm mới nhất từ chúng tôi...</p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2025 Laptop Minh Quan. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="https://www.facebook.com/phucneet.61">Dinh Phuc</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
	<script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
	<script src="{{asset('public/frontend/js/sweetalert.js')}}"></script>
	{{-- <script src="{{asset('public/frontend/js/lightslider.js')}}"></script> --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
	<script src="{{asset('public/frontend/js/lightgallery.js')}}"></script>
	<script src="{{asset('public/frontend/js/prettify.js')}}"></script>


	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v22.0">
	</script>
	
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('#imageGallery').lightSlider({
				gallery: true,
				item: 1,
				loop: true,
				thumbItem: 3,
				slideMargin: 0,
				enableDrag: false,
				currentPagerPosition: 'left',
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#imageGallery .lslide'
					});
				}
			});
		});
	</script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.add-to-cart').click(function() {
			var id = $(this).data('id_product');
			var cart_product_id = $('.cart_product_id_' + id).val();
			var cart_product_name = $('.cart_product_name_' + id).val();
			var cart_product_image = $('.cart_product_image_' + id).val();
			var cart_product_quantity = $('.cart_product_quantity_' + id).val();
			var cart_product_price = $('.cart_product_price_' + id).val();
			var cart_product_qty = $('.cart_product_qty_' + id).val();
			var _token = $('input[name="_token"]').val();
			// swal("Thêm sản phẩm vào giỏ hàng thành công", cart_product_name, "success");
			if(parseInt(cart_product_qty) > parseInt(cart_product_quantity)){
				swal("Số lượng sản phẩm trong kho không đủ", "Vui lòng chọn lại số lượng", "error");
				
			}else{
				$.ajax({
					url: '{{ url('/add-cart-ajax') }}',
					method: 'POST',
					data: {
						cart_product_id: cart_product_id,
						cart_product_name: cart_product_name,
						cart_product_image: cart_product_image,
						cart_product_quantity: cart_product_quantity,
						cart_product_price: cart_product_price,
						cart_product_qty: cart_product_qty,
						_token: _token
					},
					success: function(data) {
						swal({
									title: "Đã thêm sản phẩm vào giỏ hàng",
									text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
									showCancelButton: true,
									cancelButtonText: "Xem tiếp",
									confirmButtonClass: "btn-success",
									confirmButtonText: "Đi đến giỏ hàng",
									closeOnConfirm: false
								},
								function() {
									window.location.href = "{{url('/gio-hang')}}";
								});
					}
				});

			}
		});
		
	});
	</script>
<script type="text/javascript">
$(document).ready(function() {
	$('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            
            if(action=='city'){
                result = 'province'
            }else{
                result = 'wards'
            }
            $.ajax({
                url: '{{url('/select-delivery-home')}}',
                method: 'POST',
                data: {action:action,ma_id:ma_id,_token:_token},
                success: function(data){
                    $('#'+result).html(data);
                }
            });
        });
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.calculate_delivery').click(function(){
			var matp = $('.city').val();
			var maqh = $('.province').val();
			var xaid = $('.wards').val();
			var _token = $('input[name="_token"]').val();
			if(matp == '' && maqh == '' && xaid == ''){
				alert('Vui lòng chọn địa chỉ nhận hàng');
			}else{
				$.ajax({
					url: '{{url('/calculate-fee')}}',
					method: 'POST',
					data: {matp:matp,
						maqh:maqh,
						xaid:xaid,
						_token:_token
					},
					success: function(data){
						$('#'+result).html(data);
					}
				});
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.send_order').click(function() {
			swal({
				title: "Xác nhận đơn hàng",
				text: "Đơn hàng sẽ không được hoàn khi đặt, bạn có muốn đặt không?",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Cảm ơn, mua hàng",
				cancelButtonText: "Không, hủy đơn đi",
				closeOnConfirm: false,
				closeOnCancel: false
				},
				function(isConfirm) {
				if (isConfirm) {
					var shipping_email = $('.shipping_email').val();
					var shipping_name = $('.shipping_name').val();
					var shipping_address = $('.shipping_address').val();
					var shipping_phone = $('.shipping_phone' ).val();
					var shipping_notes = $('.shipping_notes' ).val();
					var shipping_method = $('.payment_select' ).val();
					var total_vnpay = $('.total_vnpay').val();
					var order_fee = $('.order_fee').val();
					var order_coupon = $('.order_coupon' ).val();
					var _token = $('input[name="_token"]').val();
					
					$.ajax({
						
						url: '{{ url('/confirm-order') }}',
						method: 'POST',
						data: {
							shipping_email: shipping_email,
							shipping_name: shipping_name,
							shipping_address: shipping_address,
							shipping_phone:shipping_phone,
							shipping_notes: shipping_notes,
							shipping_method: shipping_method,
							total_vnpay: total_vnpay,
							order_fee: order_fee,
							order_coupon: order_coupon,
							_token: _token
						},
						success: function(data) {
							swal("Thành công!", "Đơn hàng của bạn đã được đặt!", "success");
							// Chuyển hướng dựa trên giá trị của shipping_method
							if (shipping_method == '1') {
								window.location.href = "{{ url('/handcash') }}";
							} else if (shipping_method == '0') {
								// Thanh toán qua VNPAY
								$.ajax({
									url: '{{ url('/vnpay') }}',
									method: 'POST',
									data: {
										total_vnpay: total_vnpay, // Tổng tiền thanh toán
										_token: _token
									},
									success: function(response) {
										if (response.data) {
											window.location.href = response.data; // Redirect sang VNPAY
										} else {
											console.error('Không nhận được URL VNPAY');
										}
									},
									error: function(xhr, status, error) {
										console.error('Lỗi khi gọi API VNPAY:', error);
									}
								});
							}
							window.setTimeout(function(){
								location.reload();
							}, 2000)
						}

					});
					
				} else {
					swal("Đã hủy", "Hủy đơn hàng thành công!", "error");
				}
			});
			
			
		});
		
	});
</script>
	
</body>
</html>