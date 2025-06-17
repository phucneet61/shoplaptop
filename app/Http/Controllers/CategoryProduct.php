<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImports;
use App\Models\CatePost;
use App\Models\Slider;
use Auth;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Imports\ExcelImport;
use App\Exports\ExcelExport;
use Excel;
use App\Models\CategoryProductModel;
session_start();
class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_product(){
        $this->AuthLogin();
        $category = CategoryProductModel::where('category_parent',0)->orderBy('category_id','desc')->get();
        return view('admin.category.add_category_product')
        ->with(compact('category'));
    }
    public function all_category_product(){
        $this->AuthLogin();
        $category_post = CatePost::all();
        $category_product = CategoryProductModel::where('category_parent',0)->orderBy('category_id','desc')->get();
        $all_category_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $manager_category_product = view('admin.category.all_category_product')
        ->with('all_category_product',$all_category_product)
        ->with('category_product',$category_product);
        return view('admin_layout')
        ->with('admin.category.all_category_product',$manager_category_product)
        ->with('category_post',$category_post);
    }
    public function save_category_product(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_parent'] = $request->category_parent;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;
        
        
        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Ẩn danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Hiện danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $category = CategoryProductModel::orderBy('category_id','desc')->get();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.category.edit_category_product')
        ->with('edit_category_product',$edit_category_product)
        ->with('category',$category);
        return view('admin_layout')->with('admin.category.edit_category_product',$manager_category_product);
    }
    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_parent'] = $request->category_parent;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    //End Function Admin Page
    
    public function show_category_home(Request $request, $category_id){
        $category_post = CatePost::all();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $category_by_id = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
        ->where('tbl_product.category_id',$category_id)->paginate(6);
            $meta_desc = "";
            $meta_keywords = "";
            $meta_title = "";
            $url_canonical = $request->url();
        foreach($category_by_id as $key => $val){
            //seo
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->meta_keywords;
            $meta_title = $val->category_name;
            $url_canonical = $request->url();
            //--seo
        }
        $category_name = DB::table('tbl_category_product')
        ->where('tbl_category_product.category_id',$category_id)->limit(1)->get();
        return view('pages.category.show_category')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('category_by_id',$category_by_id)
        ->with('category_name',$category_name)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider',$slider)
        ->with('category_post',$category_post);
    }
    public function export_csv(){
        return Excel::download(new ExcelExport , 'category_product.xlsx');
    }
    public function import_csv(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ExcelImports, $path);
        return back();
    }
}
 