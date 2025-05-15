<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Mail;
use Session;
use App\Models\Slider;
use Illuminate\Support\Facades\Redirect;
use App\Models\CatePost;
session_start();
class HomeController extends Controller
{
    public function send_mail(){
        //send mail
        $to_name = "Nguyen Dinh Phuc";
        $to_email = "nguyendinhphuc1002@gmail.com";//send to this email

        $data = array("name"=>"Mail tu tai khoan khach hang","body"=>"Mail gui ve van de hang hoa"); //body of mail.blade.php
    
        Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('test mail nhé');//send this mail with subject
            $message->from($to_email,$to_name);//send from this mail
        });
        //--send mail
        return redirect('/')->with('message','Gửi mail thành công');
    }
    public function index(Request $request){
        //category post
        $category_post = CatePost::orderBy('cate_post_id','desc')->where('cate_post_status','1')->get();
        //slider
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        //seo
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Trang chủ - Laptop Minh Quân";
        $url_canonical = $request->url();
        //--seo


        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status','1')->orderby('product_id','desc')->paginate(6);
        return view('pages.home')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('all_product',$all_product)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider', $slider)
        ->with('category_post', $category_post);
        
    }
    
    public function show(){
        return view('pages.home');
    }
    public function search(Request $request)
    {
        $category_post = CatePost::orderBy('cate_post_id','desc')->get();
        $keywords = $request->keywords_submit;

        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Tìm kiếm - Laptop Minh Quân";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();

        // Truy vấn sản phẩm theo tên sản phẩm, tên danh mục, hoặc tên thương hiệu
        $search_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->where(function ($query) use ($keywords) {
                $query->where('tbl_product.product_name', 'like', '%' . $keywords . '%')
                    ->orWhere('tbl_category_product.category_name', 'like', '%' . $keywords . '%')
                    ->orWhere('tbl_brand_product.brand_name', 'like', '%' . $keywords . '%');
            })
            ->select('tbl_product.*') // chỉ lấy dữ liệu sản phẩm
            ->get();

        return view('pages.sanpham.search')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('search_product', $search_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)
            ->with('slider', $slider)
            ->with('category_post', $category_post);
    }
}
