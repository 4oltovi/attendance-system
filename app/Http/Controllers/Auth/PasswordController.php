<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class PasswordController extends Controller {
    public function showChangeForm() { return view('auth.change-password'); }
    public function changePassword(Request $request) {
        $request->validate(['current_password'=>['required'],'password'=>['required','min:8','confirmed']]);
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password'=>'Рамзи ҷорӣ нодуруст аст.']);
        }
        Auth::user()->update(['password'=>Hash::make($request->password)]);
        ActivityLog::log('update','auth','Рамзи корбар тағйир дода шуд');
        return back()->with('success','Рамз бомуваффақият тағйир дода шуд.');
    }
}
