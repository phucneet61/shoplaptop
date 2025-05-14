<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use DB;
use App\Models\Slider;
use App\Models\CatePost;
use App\Models\Gallery;
use App\Models\Video;
use File;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;

class VideoController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('login-auth')->send();
        }
    }
    public function video(){
        $this->AuthLogin();
        $video = Video::orderBy('video_id', 'DESC')->get();
        return view('admin.video.list_video')->with(compact('video'));
    }
    public function select_video(Request $request){
        // $this->AuthLogin();
        // $data = $request->all();
        $video = Video::orderBy('video_id','DESC')->get();
        $video_count = $video->count();
        $output = '<form>
                        '.csrf_field().'
                        <table class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                <th>STT</th>
                                <th>Tên video</th>
                                <th>Slug video</th>
                                <th>Link</th>
                                <th>Mô tả</th>
                                <th>Demo Video</th>
                                <th style="width:30px;">Quản lý</th>
                                </tr>
                            </thead>
                            <tbody>
        ';
        if($video_count > 0){
            $i = 0;
            foreach($video as $key => $vid){
                $i++;
                $output .= '
                
                
                    <tr>
                        <td>'.$i.'</td>
                        <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_title" class="video_edit" id="video_title_'.$vid->video_id.'">'.$vid->video_title.'</td>
                        
                        <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_slug" class="video_edit" id="video_slug_'.$vid->video_id.'">'.$vid->video_slug.'</td>
                        
                        <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_link" class="video_edit" id="video_link_'.$vid->video_id.'">https://youtu.be/'.$vid->video_link.'</td>
                        
                        <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_desc" class="video_edit" id="video_desc_'.$vid->video_id.'">'.$vid->video_desc.'</td>
                        
                        <td><iframe width="560" height="315" src="https://www.youtube.com/embed/'.$vid->video_link.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></td>
                        <td><button type="button" data-video_id="'.$vid->video_id.'" class="btn btn-xs btn-danger btn-delete-video" >Xóa video</button></td>

                    </tr>
                </form>
                ';
            }
        }else{
            $output .= '
                <tr>
                    <td colspan="3"><center>Chưa có video</center></td>
                </tr>
            ';
        }
        $output .= '
                </tbody>
                </table>
                </form>
            ';
        echo $output;
    }
    public function insert_video(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $video = new Video();
        $sub_link = substr($data['link_video'], 17);
        $video->video_title = $data['video_title'];
        $video->video_slug = $data['video_slug'];
        $video->video_link = $sub_link;
        $video->video_desc = $data['video_desc'];
        $video->save();
    }
    public function update_video(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $video_id = $data['video_id'];
        $video_edit = $data['video_edit'];
        $video_check = $data['video_check'];
        $video = Video::find($video_id);
        if($video_check == 'video_title'){
            $video->video_title = $video_edit;
        }
        else if($video_check == 'video_desc'){
            $video->video_desc = $video_edit;
        }
        else if($video_check == 'video_link'){
            $sub_link = substr($video_edit, 17);
            $video->video_link = $sub_link;
        }
        else{
            $video->video_slug = $video_edit;
        }
        $video->save();
    }
    public function delete_video(Request $request){
        $data = $request->all();
        $video_id = $data['video_id'];
        $video = Video::find($video_id);
        $video->delete();
    }

    public function video_shop(Request $request){
        //category post
        $category_post = CatePost::orderBy('cate_post_id','desc')->where('cate_post_status','1')->get();
        //slider
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(4)->get();
        //seo
        $meta_desc = "Laptop Minh Quân - Trang web mua sắm hàng đầu Việt Nam";
        $meta_keywords = "Laptop Minh Quân, mua hàng online, mua hàng trực tuyến";
        $meta_title = "Video - Laptop Minh Quân";
        $url_canonical = $request->url();
        //--seo


        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();

        $all_video = DB::table('tbl_videos')->paginate(6);
        return view('pages.video.video')
        ->with('category',$cate_product)
        ->with('brand',$brand_product)
        ->with('all_video',$all_video)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('slider', $slider)
        ->with('category_post', $category_post);
    }
}
