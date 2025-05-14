<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Redirect;
use Session;
class SliderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function manage_slider(){
        $all_slide = Slider::orderBy('slider_id', 'desc')->get();
        return view('admin.slider.list_slider')->with(compact('all_slide'));
    }
    public function add_slider(){
        return view('admin.slider.add_slider');
    }
    public function insert_slider(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        
        $get_image = request('slider_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).".".$get_image->getClientOriginalExtension();

            $get_image->move('public/uploads/slider', $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_status = $data['slider_status'];
            $slider->slider_image = $new_image;
            $slider->slider_desc = $data['slider_desc'];
            $slider->save();
            Session::put('message','Thêm slider thành công');
            return Redirect::to('add-slider');
        }else{
            Session::put('message','Vui lòng chọn ảnh');
            return Redirect::to('add-slider');
        }

        
    }
    public function active_slider($slider_id)
    {
        try {
            $slider = Slider::findOrFail($slider_id);
            $slider->update(['slider_status' => 1]);
            
            return Redirect::back()->with('message', 'Kích hoạt slider thành công!');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Lỗi khi kích hoạt slider: '.$e->getMessage());
        }
    }

    public function unactive_slider($slider_id)
    {
        try {
            $slider = Slider::findOrFail($slider_id);
            $slider->update(['slider_status' => 0]);
            
            return Redirect::back()->with('message', 'Tắt slider thành công!');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Lỗi khi tắt slider: '.$e->getMessage());
        }
    }
}
