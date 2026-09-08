<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,RateLimiter};
use Illuminate\Validation\ValidationException;
class AuthController {
public function login(Request $r){
$data=$r->validate(['email'=>'required|email','password'=>'required|string']);
$key='login:'.hash('sha256',mb_strtolower($data['email']).'|'.$r->ip());
if(RateLimiter::tooManyAttempts($key,5))throw ValidationException::withMessages(['email'=>'محاولات كثيرة. حاول بعد دقيقة.']);
if(!Auth::attempt([...$data,'is_admin'=>true])){RateLimiter::hit($key,60);throw ValidationException::withMessages(['email'=>'بيانات الدخول غير صحيحة.']);}
RateLimiter::clear($key);$r->session()->regenerate();return redirect()->intended('/admin');
}
public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect('/');}
}
