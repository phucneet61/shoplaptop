<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Auth;
use Excel;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Post;
use App\Models\CatePost;
class PostController extends Controller
{
    //start admin
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_post(){
        $this->AuthLogin();
        $cate_post = CatePost::orderBy('cate_post_id', 'desc')->get();
        
        return view('admin.post.add_post')->with(compact('cate_post'));
    }
    public function all_post(){
        $this->AuthLogin();
        $all_post = Post::orderBy('post_id','desc')->get();
        return view('admin.post.list_post')->with(compact('all_post'));
    }
    public function save_post(Request $request) {
        $this->AuthLogin();

        // Lấy tất cả dữ liệu từ request
        $data = $request->all();

        // Tạo một bài viết mới
        $post = new Post();
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->cate_post_id = $data['cate_post_id'];
        $post->post_status = $data['post_status'];

        // Xử lý upload hình ảnh
        if ($request->hasFile('post_image')) {
            $file = $request->file('post_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('public/uploads/posts', $filename); // Lưu ảnh vào thư mục public/uploads/posts
            $post->post_image = $filename;
            // Lưu bài viết vào cơ sở dữ liệu
            $post->save();
    
            // Đặt thông báo thành công
            Session::put('message', 'Thêm bài viết thành công');
    
            // Chuyển hướng về trang danh sách bài viết
            return redirect()->back();
        }else{
            Session::put('message', 'Làm ơn thêm hình ảnh');
            return redirect()->back();
        }

    }
    public function delete_post($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);

        if ($post) {
            // Xóa hình ảnh nếu tồn tại
            $image_path = 'public/uploads/posts/' . $post->post_image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Xóa bài viết
            $post->delete();
            Session::put('message', 'Xóa bài viết thành công');
        } else {
            Session::put('message', 'Bài viết không tồn tại');
        }

        return redirect()->back();
    }
    public function unactive_post($post_id)
    {
        $this->AuthLogin();

        $post = Post::findOrFail($post_id);
        $post->post_status = 0;
        $post->save();

        Session::put('message', 'Ẩn bài viết thành công');
        return redirect('/all-post');
    }
    public function active_post($post_id)
    {
        $this->AuthLogin();

        $post = Post::findOrFail($post_id);
        $post->post_status = 1;
        $post->save();

        Session::put('message', 'Hiển thị bài viết thành công');
        return redirect('/all-post');
    }
    public function edit_post($post_id)
    {
        $this->AuthLogin();

        // Lấy danh mục bài viết
        $cate_post = CatePost::orderBy('cate_post_id', 'desc')->get();

        // Lấy thông tin bài viết cần chỉnh sửa
        $edit_post = Post::findOrFail($post_id);

        return view('admin.post.edit_post', compact('cate_post', 'edit_post'));
    }
    public function update_post(Request $request, $post_id)
    {
        $this->AuthLogin();

        // Lấy bài viết cần cập nhật
        $post = Post::findOrFail($post_id);

        // Cập nhật dữ liệu bài viết
        $post->post_title = $request->post_title;
        $post->post_slug = $request->post_slug;
        $post->post_desc = $request->post_desc;
        $post->post_content = $request->post_content;
        $post->post_meta_keywords = $request->post_meta_keywords;
        $post->post_meta_desc = $request->post_meta_desc;
        $post->cate_post_id = $request->cate_post_id;
        $post->post_status = $request->post_status;

        // Xử lý upload hình ảnh
        if ($request->hasFile('post_image')) {
            // Xóa hình ảnh cũ nếu tồn tại
            if ($post->post_image && file_exists('public/uploads/posts/' . $post->post_image)) {
                unlink('public/uploads/posts/' . $post->post_image);
            }

            // Upload hình ảnh mới
            $file = $request->file('post_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('public/uploads/posts', $filename);
            $post->post_image = $filename;
        }

        // Lưu bài viết
        $post->save();

        Session::put('message', 'Cập nhật bài viết thành công');
        return redirect('/all-post');
    }

    //end admin

    //start user
    public function danh_muc_bai_viet(Request $request, $post_slug){
        $category_post = CatePost::orderBy('cate_post_id','desc')->get();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $catepost = CatePost::where('cate_post_slug', $post_slug)->take(1)->get();
        foreach($catepost as $key => $cate){
            //seo
            $meta_desc = $cate->cate_post_desc;
            $meta_keywords = $cate->cate_post_slug;
            $meta_title = $cate->cate_post_name;
            $cate_id = $cate->cate_post_id;
            $url_canonical = $request->url();
            //seo
        }
        $post = Post::with('cate_post')->where('post_status',1)->where('cate_post_id', $cate_id)->paginate(10);
        return view('pages.baiviet.danhmucbaiviet')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('catepost',$catepost)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider', $slider)
        ->with('post', $post)
        ->with('category_post', $category_post);
        
    }

    public function bai_viet(Request $request, $post_slug){
        $category_post = CatePost::orderBy('cate_post_id','desc')->get();
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        // $catepost = CatePost::where('cate_post_slug', $post_slug)->take(1)->get();
        $post = Post::with('cate_post')->where('post_status',1)->where('post_slug', $post_slug)->take(1)->get();
        foreach($post as $key => $p){
            //seo
            $meta_desc = $p->post_meta_desc;
            $meta_keywords = $p->post_meta_keywords;
            $meta_title = $p->post_title;
            $url_canonical = $request->url();
            $cate_post_id = $p->cate_post_id;
            //seo
        }
        $related = Post::with('cate_post')->where('post_status',1)->where('cate_post_id', $cate_post_id)->whereNotIn('post_slug', [$post_slug])->take(5)->get();
        return view('pages.baiviet.baiviet')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('post',$post)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider', $slider)
        ->with('post', $post)
        ->with('category_post', $category_post)
        ->with('related', $related);
    }
}
