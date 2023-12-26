<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\tbl_admin;
use Session;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    // hiển thị khung đăng nhập cho khách hàng
    function showLoginForm(){
        if(!Session::get('home')){
            return view('frontend.dangnhap');
        }
        else {
            return redirect()->route('home');
        }
        return view('frontend.dangnhap');
    }

    // xử lý đăng nhập cho khách hàng
    function dangnhap(Request $request){
        $data = $request -> all();
        $password = $data['password'];
        if(is_numeric( $data['user_name'])){
            $user = users::where(['phone' => $data['user_name'],'password' => $password])->first();
        }
        else{
            $user = users::where(['email' => $data['user_name'], 'password' => $password])->first();
        }
        if($user) {
            Session::put('home',[
                'id' => $user -> id,
                'email' => $user -> email,
                'password' => $user -> password,
                'name' => $user -> name,
                'phone' => $user -> phone,
            ]);
            if (Session::get('home') != NULL){
                return redirect()->route('home');
            }
            else {
                return redirect()->back();
            }
        }
        else {
            return redirect()->back();
        }
    }

    // hiển thị khung đk cho khách hàng
    function register(){
        return view('frontend.register');
    }

    // xử lý đk tk cho khách hàng
    function registers(Request $request){
        $email = $request->input('email');
        $phone = $request->input('phone');
        $existingPhoneUser = users::where('phone',$phone)->first();
        if ($email) { 
            $existingEmailUser = users::where('email', $email)->first();
            if ($existingEmailUser) {
                return redirect()->route('register')->with('mesage', 'Email đã tồn tại, Vui lòng sử dụng email khác.');
            }
        }
        if ($existingPhoneUser) {
            return redirect()->route('register')->with('mesage', 'Số điện thoại đã tồn tại');
        }  
        $user = new users([
            'name' => $request -> input('name'),
            'email' => $request -> input('email'),
            'password' => $request -> input('password'),
            'phone' => $request -> input('phone'),
        ]);
        $user -> save();
        return redirect('/dangnhap');
    }

    // đăng xuất tài khoản khách hàng
    function logoutuser(){
        Session::forget('home');
        return redirect()->back();
    }

    // hiển thị khung đăng nhập cho quản trị viên
    function login(){
        return view('frontend.login');
    }

    // xử lý đăng nhập cho quản trị viên
    function getlogin(Request $request){
        $data = $request -> all();
        $password = $data['admin_password'];
        $result = tbl_admin::where(['admin_email' => $data['admin_email'], 'admin_password' => $data['admin_password']])->first();
        if($result){
            Session::put('admin_img', $result->image_staff);
            Session::put('admin_name', $result->admin_name);
            Session::put('admin',[
                'admin_id' => $result->id,
                'username' => $result->admin_email,
                'password' => $result->admin_password,
                'admin_name' => $result->admin_name,
                'chuc_vu' => $result->chuc_vu,
            ]);
            if(Session::get('admin') != NULL){
                if(Session::get('admin')['chuc_vu'] == "2"){
                    return redirect()->route('admin');
                }
                elseif(Session::get('admin')['chuc_vu'] == "3"){
                    return redirect()->route('quan-ly-sp');
                }
                elseif(Session::get('admin')['chuc_vu'] == "1"){
                    return redirect()->route('quan-ly-hd');
                }
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
    }

    // đăng xuất tk quản trị
    function logout(){
        Session::forget('admin');
        return redirect()->back();
    }

    // đăng nhập bằng google
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request){
        try {
            $user = Socialite::driver('google')->user();
            $findUser = users::where('google_id', $user->id)->first();
            if ($findUser) {
                Session::put('home', [
                    'id' => $findUser->id,
                    'email' => $findUser->email,
                    'password' => $findUser->password,
                    'name' => $findUser->name,
                    'phone' => $findUser->phone,
                ]);

                return redirect()->intended('/home');
            } else {
                // Tạo tài khoản người dùng mới
                $newUser = users::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456789'),
                ]);

                // Đăng nhập người dùng mới
                Session::put('home', [
                    'id' => $newUser->id,
                    'email' => $newUser->email,
                    'password' => $newUser->password,
                    'name' => $newUser->name,
                    'phone' => $newUser->phone,
                ]);

                return redirect()->intended('/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
