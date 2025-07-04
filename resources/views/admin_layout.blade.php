<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<meta name="csrf-token" content={{ csrf_token() }}>

<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<link href="//cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('public/backend/css/monthly.css')}}">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>
<script src="//cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="index.html" class="logo">
        ADMIN
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{asset('public/backend/images/2.png')}}">
                <span class="username">
                    <?php
	
                    $name = Auth::user()->admin_name;
                    if($name){
                        echo $name;
                    }
                    ?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Cá nhân</a></li>
                <li><a href="#"><i class="fa fa-cog"></i>Cài đặt</a></li>
                <li><a href="{{URL::to('/logout-auth')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Slider</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/manage-slider')}}">Liệt kê slider</a></li>
						<li><a href="{{URL::to('/add-slider')}}">Thêm slider</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục Laptop</a></li>
						<li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục Laptop</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục bài viết</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-post')}}">Thêm danh mục bài viết</a></li>
                        <li><a href="{{URL::to('/all-category-post')}}">Liệt kê danh mục bài viết</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Thương hiệu laptop</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-brand-product')}}">Thêm thương hiệu Laptop</a></li>
						<li><a href="{{URL::to('/all-brand-product')}}">Liệt kê thương hiệu Laptop</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
						<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Mã giảm giá</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/insert-coupon')}}">Thêm mã giảm giá</a></li>
                        <li><a href="{{URL::to('/list-coupon')}}">Liệt kê, quản lý mã giảm giá</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Phí vận chuyển</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/delivery')}}">Quản lý phí vận chuyển</a></li>
                        {{-- <li><a href="{{URL::to('/list-coupon')}}">Liệt kê mã giảm giá</a></li> --}}
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Bài viết</span>
                    </a>
                    <ul class="sub">
                         <li><a href="{{URL::to('/add-post')}}">Thêm bài viết </a></li>
                        <li><a href="{{URL::to('/all-post')}}">Liệt kê bài viết</a></li>
                      
                    </ul>
                </li>
                {{-- <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Video</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/video')}}">Thêm Video</a></li>
                    </ul>
                </li> --}}
                @impersonate
                <li>
                    <span><a href="{{URL::to('/impersonate-destroy')}}">Dừng chuyển quyền</a></span>
                </li>
                @endimpersonate
                @hasrole(['admin','author'])
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub">
                         <li><a href="{{URL::to('/add-users')}}">Thêm user</a></li>
                        <li><a href="{{URL::to('/users')}}">Liệt kê user</a></li>
                      
                    </ul>
                </li>
                @endhasrole
                
            </ul>            
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
        @yield('admin_content')
    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>Design by <a target="_blank" href="https://www.facebook.com/phucneet.61">Nguyễn Đình Phúc</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        load_video();
        function load_video() {
            var _token = $('input[name="_token"]').val();
            // alert(pro_id);
            $.ajax({
                url:"{{url('/select-video')}}",
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                    $('#video_load').html(data);
                }
            });
        }
        $(document).on('click', '.btn-add-video', function(){
            var video_title = $('.video_title').val();
            var video_slug = $('.video_slug').val();
            var link_video = $('.link_video').val();
            var video_desc = $('.video_desc').val();
            var _token = $('input[name="_token"]').val();
            // alert(video_title);
            // alert(video_slug);
            // alert(link_video);
            // alert(video_desc);
            $.ajax({
                url: '{{url('/insert-video')}}',
                method: 'POST',
                data: {video_title:video_title, video_slug:video_slug, link_video:link_video, video_desc:video_desc, _token:_token},
                success:function(data){
                    load_video();
                    $('#notify').html('<span class="text-success">Thêm video thành công</span>');
                }
            });
        });
        $(document).on('blur', '.video_edit', function(){
            var video_type = $(this).data('video_type');
            var video_id = $(this).data('video_id');
            // alert(video_type);
            if(video_type == 'video_title'){
                var video_edit = $('#'+video_type+'_'+video_id).text();
                var video_check = video_type;
            }else if(video_type == 'video_desc'){
                var video_edit = $('#'+video_type+'_'+video_id).text();
                var video_check = video_type;
            }else if(video_type == 'link_video'){
                var video_edit = $('#'+video_type+'_'+video_id).text();
                var video_check = video_type;
            }else{
                var video_edit = $('#'+video_type+'_'+video_id).text();
                var video_check = video_type;
            }
            // alert(video_edit);
            $.ajax({
                url: '{{url('/update-video')}}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {video_check:video_check, video_edit:video_edit, video_id:video_id},
                success:function(data){
                    load_video();
                    $('#notify').html('<span class="text-success">Cập nhật video thành công</span>');
                }
            });

        });
            
    
    });
    $(document).on('click', '.btn-delete-video', function(){
        var video_id = $(this).data('video_id');
        if(confirm('Bạn có chắc chắn muốn xóa video này không?')){
            $.ajax({
                url: '{{url('/delete-video')}}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {video_id:video_id},
                success:function(data){
                    load_video();
                    $('#notify').html('<span class="text-alert">Xóa video thành công</span>');
                }
            });
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        load_gallery();
        function load_gallery(){
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();
            // alert(pro_id);
            $.ajax({
                url:"{{url('/select-gallery')}}",
                method:"POST",
                data:{
                    pro_id:pro_id,
                    _token:_token,
                },
                success:function(data){
                    $('#gallery_load').html(data);
                }
            });
        }
        $('#file').change(function() {
            var error = '';
            var files = $('#file')[0].files; // Sử dụng đúng biến 'files'

            if (files.length > 5) {
                error += '<p>Bạn chỉ được chọn tối đa 5 ảnh</p>';
            } else if (files.length === 0) {
                error += '<p>Bạn không được bỏ trống ảnh</p>';
            } else {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > 2000000) { // Kiểm tra kích thước từng file
                        error += '<p>Kích thước ảnh không được lớn hơn 2MB</p>';
                    }
                }
            }

            if (error === '') {
                $('#error_gallery').html(''); // Xóa thông báo lỗi nếu không có lỗi
            } else {
                $('#file').val(''); // Xóa file đã chọn
                $('#error_gallery').html('<span class="text-alert">' + error + '</span>');
                return false;
            }
        });
        $(document).on('blur', '.edit_gal_name', function(){
            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            // alert(gal_id);
            // alert(gal_text);
            $.ajax({
                url: '{{url('/update-gallery-name')}}',
                method: 'POST',
                data: {gal_id:gal_id, gal_text:gal_text, _token:_token},
                success:function(data){
                    load_gallery();
                    $('#error_gallery').html('<span class="text-alert">Cập nhật tên ảnh thành công</span>');
                }
            });
        });
        $(document).on('click', '.delete-gallery', function(){
            var gal_id = $(this).data('gal_id');
            var _token = $('input[name="_token"]').val();
            if(confirm('Bạn có chắc chắn muốn xóa ảnh này không?')){
                $.ajax({
                    url: '{{url('/delete-gallery')}}',
                    method: 'POST',
                    data: {gal_id:gal_id, _token:_token},
                    success:function(data){
                        load_gallery();
                        $('#error_gallery').html('<span class="text-alert">Xóa ảnh thành công</span>');
                    }
                });
            }
        });
        $(document).on('change', '.file_image', function(){
            var gal_id = $(this).data('gal_id');
            var file = document.getElementById("file-"+gal_id).files[0];
            var form_data = new FormData();
            form_data.append("file", file);
            form_data.append("gal_id", gal_id);
            $.ajax({
                url: '{{url('/update-gallery')}}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success:function(data){
                    load_gallery();
                    $('#error_gallery').html('<span class="text-alert">Cập nhật ảnh thành công</span>');
                }
            });
        });
    });
</script>
<script type="text/javascript">
    function ChangeToSlug()
        {
            var slug;
            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                //Xóa các ký tự đặt biệt
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                //Đổi khoảng trắng thành ký tự gạch ngang
                slug = slug.replace(/ /gi, "-");
                //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
                //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                //Xóa các ký tự gạch ngang ở đầu và cuối
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
</script>
<script type="text/javascript">
    $('.update_quantity_order').click(function(){
        var order_product_id = $(this).data('product_id');
        var order_code = $('.order_code').val();
        var order_qty = $('.order_qty_'+order_product_id).val();
        var _token = $('input[name="_token"]').val();
        // alert(order_product_id);
        // alert(order_qty);
        // alert(order_code);
        // alert(_token);
        $.ajax({
            url: '{{url('/update-qty')}}',
            method: 'POST',
            data: {order_product_id:order_product_id, 
                order_code:order_code, 
                order_qty:order_qty, 
                _token:_token
            },
            success:function(data){
                alert('Cập nhật số lượng thành công!');
                location.reload();
            }
        });
    });
</script>
<script type="text/javascript">
    $('.order_details').change(function(){
        var order_status = $(this).val();
        var order_id = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();
        // alert(order_status);
        // alert(order_id);
        // alert(_token);
        //lay ra so luong
        quantity = [];
        $("input[name='product_sales_quantity']").each(function(){
            quantity.push($(this).val());
        });
        //lay ra product id
        order_product_id = [];
        $("input[name='order_product_id']").each(function(){
            order_product_id.push($(this).val());
        });
        // alert(order_product_id);
        j=0;
        for(i=0; i<order_product_id.length; i++){
            //so luong khach dat
            var order_qty = $('.order_qty_'+order_product_id[i]).val();
            //so luong ton kho
            var order_qty_storage = $('.order_qty_storage_'+order_product_id[i]).val();
            
            if(parseInt(order_qty) > parseInt(order_qty_storage)){
                j = j + 1;
                if(j==1){
                    alert('Số lượng tồn kho không đủ!');
                }
                $('.order_qty_'+order_product_id[i]).css('border','1px solid red');
            }
        }
        if(j==0){
            $.ajax({
                url: '{{url('/update-order-qty')}}',
                method: 'POST',
                data: {order_status:order_status, 
                    order_id:order_id, 
                    quantity:quantity, 
                    order_product_id:order_product_id,
                    _token:_token
                },
                success:function(data){
                    alert('Cập nhật Tình trạng đơn hàng thành công!');
                    location.reload();
                }
            });
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        fetch_delivery();
        function fetch_delivery(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/select-feeship')}}',
                method: 'POST',
                data: {
                    _token:_token
                },
                success: function(data){
                    $('#load_delivery').html(data);
                    
                }
            });
        }
        $(document).on('blur', '.fee_feeship_edit', function(){
            var feeship_id = $(this).data('feeship_id');
            var fee_value = $(this).text();
            var _token = $('input[name="_token"]').val();
            // alert(feeship_id);
            // alert(fee_value);
            $.ajax({
                url: '{{url('/update-delivery')}}',
                method: 'POST',
                data: {
                    feeship_id:feeship_id,
                    fee_value:fee_value,
                    _token:_token
                },
                success: function(data){
                    // $('#'+result).html(data);
                    fetch_delivery();
                }
            });
        });
        $('.add_delivery').click(function(){
            var city = $('.city').val();
            var province = $('.province').val();
            var wards = $('.wards').val();
            var fee_ship = $('.fee_ship').val();
            var _token = $('input[name="_token"]').val();
            // alert(city);
            // alert(province);
            // alert(wards);
            // alert(fee_ship);
            $.ajax({
                url: '{{url('/insert-delivery')}}',
                method: 'POST',
                data: {city:city,
                    province:province,
                    wards:wards,
                    fee_ship:fee_ship,
                    _token:_token
                },
                success: function(data){
                    // $('#'+result).html(data);
                    fetch_delivery();
                }
            });
        });
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
                url: '{{url('/select-delivery')}}',
                method: 'POST',
                data: {action:action,ma_id:ma_id,_token:_token},
                success: function(data){
                    $('#'+result).html(data);
                }
            });
        })
    })
</script>
<script src="{{asset('public/backend/js/jquery.form-validator.min.js')}}"></script>
    <script type="text/javascript">
        $.validate ({
            
        });
    </script>
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace( 'ckeditor' );
        CKEDITOR.replace( 'ckeditor1' );
        CKEDITOR.replace( 'ckeditor2' );
        CKEDITOR.replace( 'ckeditor3' );
    </script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
</body>
</html>
