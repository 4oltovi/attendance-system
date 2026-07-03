<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function showLoginForm() { return view('auth.login'); }
    public function login(Request $request) {
        $credentials = $request->validate(['email'=>['required','email'],'password'=>['required']]);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (!Auth::user()->is_active) { Auth::logout(); return back()->withErrors(['email'=>'Ҳисоби шумо ғайрифаъол аст.']); }
            ActivityLog::log('login','auth','Корбар ба система ворид шуд');
            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors(['email'=>'Маълумоти воридшавӣ нодуруст аст.'])->onlyInput('email');
    }
    public function logout(Request $request) {
        ActivityLog::log('logout','auth','Корбар аз система баромад');
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
