<?php

namespace App\Http\Controllers;

use App\Models\CatePost;
use App\Models\Slider;
use Auth;
use Illuminate\Http\Request;
use DB;
use App\Models\Brand;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class BrandProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product(){
        $this->AuthLogin();
        return view('admin.brand.add_brand_product');
    }
    public function all_brand_product(){
        $this->AuthLogin();
        // $all_brand_product = DB::table('tbl_brand_product')->get(); // static huong doi tuong 
        $all_brand_product = Brand::orderBy('brand_id','desc')->get(); // su dung eloquent
        $manager_brand_product = view('admin.brand.all_brand_product')->with('all_brand_product',$all_brand_product);
        return view('admin_layout')->with('admin.brand.all_brand_product',$manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $this->AuthLogin();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['meta_keywords'] = $request->brand_product_keywords;
        // $data['brand_status'] = $request->brand_product_status;
        
        // DB::table('tbl_brand_product')->insert($data);
        $data = $request->all();
        $brand = new Brand();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->meta_keywords = $data['brand_product_keywords'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        Session::put('message','Thêm thương hiệu laptop thành công');
        return Redirect::to('add-brand-product');
    }
    public function unactive_brand_product($brand_product_id){
        $this->AuthLogin();
        DB::table('tbl_brand_product')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Ẩn thương hiệu laptop thành công');
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this->AuthLogin();
        DB::table('tbl_brand_product')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Hiện thương hiệu laptop thành công');
        return Redirect::to('all-brand-product');
    }
    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();
        // $edit_brand_product = DB::table('tbl_brand_product')->where('brand_id',$brand_product_id)->get();
        $edit_brand_product = Brand::where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.brand.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('admin.brand.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request,$brand_product_id){
        $this->AuthLogin();

        $data = $request->all();
        $brand = Brand::find($brand_product_id);
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->meta_keywords = $data['brand_product_keywords'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['meta_keywords'] = $request->brand_product_keywords;
        // DB::table('tbl_brand_product')->where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập nhật thương hiệu laptop thành công');
        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($brand_product_id){
        $this->AuthLogin();
        DB::table('tbl_brand_product')->where('brand_id',$brand_product_id)->delete();
        Session::put('message','Xóa thương hiệu laptop thành công');
        return Redirect::to('all-brand-product');
    }
    //End Function Admin Page
    public function show_brand_home(Request $request, $brand_id){
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $category_post = CatePost::orderBy('cate_post_id','desc')->where('cate_post_status','1')->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $brand_by_id = DB::table('tbl_product')
        ->join('tbl_brand_product','tbl_product.brand_id','=','tbl_brand_product.brand_id')
        ->where('tbl_product.brand_id',$brand_id)->paginate(6);
        //seo 
        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "";
        $url_canonical = $request->url();
    foreach($brand_by_id as $key => $val){
        $meta_desc = $val->brand_desc;
        $meta_keywords = $val->meta_keywords;
        $meta_title = $val->brand_name;
        $url_canonical = $request->url();
        
    }
        //end seo
        $brand_name = DB::table('tbl_brand_product')
        ->where('tbl_brand_product.brand_id',$brand_id)->limit(1)->get();
        return view('pages.brand.show_brand')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('brand_by_id',$brand_by_id)
        ->with('brand_name',$brand_name)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('category_post',$category_post)
        ->with('slider',$slider);
    } 
}
