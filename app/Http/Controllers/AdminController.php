<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Rules\Captcha; 
use Validator;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Social; //sử dụng model Social
use \Laravel\Socialite\Facades\Socialite; //sử dụng Socialite
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    // public function AuthLogin(){
    //     $admin_id = Session::get('admin_id');
    //     if($admin_id){
    //         return Redirect::to('dashboard');
    //     }else{
    //         return Redirect::to('admin')->send();
    //     }
    // }
    // public function index(){
    //     return view('admin_login');
    // }
    // public function show_dashboard(){
    //     $this->AuthLogin();
    //     return view('admin.dashboard');
    // }
    // public function dashboard(Request $request){
    //     $admin_email = $request->admin_email;
    //     $admin_password = md5($request->admin_password);

    //     $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    //     if($result){
    //         Session::put('admin_name',$result->admin_name);
    //         Session::put('admin_id',$result->admin_id);
    //         return Redirect::to('/dashboard');
    //     }else{
    //         Session::put('message','Mật khẩu hoặc tài khoản sai!');
    //         return Redirect::to('/admin');
    //     }
    // }
    // public function logout(){
    //     $this->AuthLogin();
    //     Session::put('admin_name',null);
    //     Session::put('admin_id',null);
    //     return Redirect::to('/admin');
    // }


    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    // public function callback_facebook(){
    //     $provider = Socialite::driver('facebook')->user();
    //     $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
    //     if($account){
    //         //login in vao trang quan tri  
    //         $account_name = Login::where('admin_id',$account->user)->first();
    //         Session::put('admin_name',$account_name->admin_name);
    //         Session::put('admin_id',$account_name->admin_id);
    //         return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    //     }else{

    //         $hieu = new Social([
    //             'provider_user_id' => $provider->getId(),
    //             'provider' => 'facebook'
    //         ]);

    //         $orang = Login::where('admin_email',$provider->getEmail())->first();

    //         if(!$orang){
    //             $orang = Login::create([
    //                 'admin_name' => $provider->getName(),
    //                 'admin_email' => $provider->getEmail(),
    //                 'admin_password' => '',
    //                 'admin_phone' => ''
                    

    //             ]);
    //         }
    //         $hieu->login()->associate($orang);
    //         $hieu->save();

    //         $account_name = Login::where('admin_id',$account->user)->first();

    //         Session::put('admin_name',$account_name->admin_name);
    //         Session::put('admin_id',$account_name->admin_id);
    //         return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    //     } 
    // }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();
        
        if ($account && $account->user) {
            // login vào trang quản trị
            $account_name = Login::where('admin_id', $account->user)->first();
            
            if ($account_name) {
                Session::put('admin_name', $account_name->admin_name);
                Session::put('admin_id', $account_name->admin_id);
                return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
            }
        } 
    
        // Nếu chưa có tài khoản -> tạo mới
        $hieu = new Social([
            'provider_user_id' => $provider->getId(),
            'provider' => 'facebook'
        ]);
    
        $orang = Login::where('admin_email', $provider->getEmail())->first();
    
        if (!$orang) {
            $orang = Login::create([
                'admin_name' => $provider->getName(),
                'admin_email' => $provider->getEmail(),
                'admin_password' => '',
                'admin_phone' => ''
            ]);
        }
    
        $hieu->user = $orang->admin_id; // Gán admin_id vào user
        $hieu->save();
    
        $account_name = Login::where('admin_id', $orang->admin_id)->first();
        
        if ($account_name) {
            Session::put('admin_name', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } else {
            return redirect('/login')->with('error', 'Không tìm thấy tài khoản, vui lòng thử lại.');
        }
    }
    
    public function login_google(){
        return Socialite::driver('google')->redirect();
   }
   public function callback_google(){
    $users = Socialite::driver('google')->stateless()->user();
    $authUser = $this->findOrCreateUser($users, 'google');

    if ($authUser && $authUser->user) {
        $account_name = Login::where('admin_id', $authUser->user)->first();
        if ($account_name) {
            Session::put('admin_name', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }
    }

    return redirect('/login')->with('error', 'Không tìm thấy tài khoản, vui lòng thử lại.');
    }

    public function findOrCreateUser($users, $provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        
        if ($authUser && $authUser->user) {
            return $authUser;
        }
    
        $hieu = new Social([
            'provider_user_id' => $users->id,
            'provider' => strtoupper($provider)
        ]);
    
        $orang = Login::where('admin_email', $users->email)->first();
        if (!$orang) {
            $orang = Login::create([
                'admin_name' => $users->name,
                'admin_email' => $users->email,
                'admin_password' => '',
                'admin_phone' => ''
                
            ]);
        }
    
        $hieu->user = $orang->admin_id;
        $hieu->save();
    
        return $hieu;
    }
    




    public function AuthLogin()
    {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function index()
    {
        return view('admin_login');
    }

    public function show_dashboard()
    {
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request)
    {
        $data = $request->validate([
            //validation laravel 
            'admin_email' => 'required|email',
            'admin_password' => 'required|string',
            'g-recaptcha-response' => new Captcha(), 		//dòng kiểm tra Captcha
        ]);

        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);
        
        $admin = Login::where('admin_email', $admin_email)
                      ->where('admin_password', $admin_password)
                      ->first();

        if ($admin) {
            Session::put('admin_name', $admin->admin_name);
            Session::put('admin_id', $admin->admin_id);
            return Redirect::to('/dashboard');
        } else {
            Session::put('message', 'Mật khẩu hoặc tài khoản sai!');
            return Redirect::to('/admin');
        }
    }

    public function logout()
    {
        $this->AuthLogin();
        Session::forget(['admin_name', 'admin_id']);
        return Redirect::to('/admin');
    }
}
