<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use Auth;
class AuthController extends Controller
{
    public function login_auth(){
        return view('admin.custom_auth.login_auth');
    }
    public function register_auth(){
        return view('admin.custom_auth.register');
    }
    public function logout_auth(){
        Auth::logout();
        return redirect('/login-auth')->with('message','Đăng xuất thành công!');
    }
    public function login(Request $request){
        $this->validate($request, [
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:6',
        ]);
        $data = $request->all();
        if(Auth::attempt(['admin_email' => $data['admin_email'], 'admin_password' => $data['admin_password']])){
            return redirect('/dashboard')->with('message','Đăng nhập thành công!');
        }else{
            return redirect('/login-auth')->with('message','Tài khoản hoặc mật khẩu không đúng!');
        }
            
        // if(Auth::check()){
        //     return redirect('/dashboard');
        // }else{
        //     return redirect('/login-auth')->with('message','Tài khoản hoặc mật khẩu không đúng!');
        // }
    }
    public function register(Request $request){
        $this->validation($request);
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();
        
        //Assign role to the admin
        // $role = Roles::where('name', 'Admin')->first();
        // if ($role) {
        //     $admin->roles()->attach($role);
        // }
        
        return redirect('/register-auth')->with('message','Đăng ký tài khoản thành công!');
    }
    public function validation($request){
        return $this->validate($request, [
            'admin_name' => 'required',
            'admin_phone' => 'required',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:6',
        ]);
    }
}
