<?php
namespace App\Http\Controllers;
use App\Models\{User, ActivityLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller {
    public function index(Request $request) {
        $query = User::with('roles');
        if ($request->filled('search')) $query->where(fn($q)=>$q->where('name','like','%'.$request->search.'%')->orWhere('email','like','%'.$request->search.'%'));
        if ($request->filled('role')) $query->role($request->role);
        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();
        return view('users.index', compact('users','roles'));
    }
    public function create() { return view('users.create',['roles'=>Role::all()]); }
    public function store(Request $request) {
        $v = $request->validate(['name'=>'required|string','email'=>'required|email|unique:users','password'=>'required|min:8|confirmed','phone'=>'nullable|string','position'=>'nullable|string','role'=>'required|exists:roles,name','is_active'=>'boolean']);
        $user = User::create(['name'=>$v['name'],'email'=>$v['email'],'password'=>Hash::make($v['password']),'phone'=>$v['phone']??null,'position'=>$v['position']??null,'is_active'=>$request->has('is_active')]);
        $user->assignRole($v['role']);
        return redirect()->route('users.index')->with('success','Корбар сохта шуд.');
    }
    public function edit(User $user) { return view('users.edit',compact('user')+['roles'=>Role::all()]); }
    public function update(Request $request, User $user) {
        $v = $request->validate(['name'=>'required|string','email'=>'required|email|unique:users,email,'.$user->id,'password'=>'nullable|min:8|confirmed','phone'=>'nullable|string','position'=>'nullable|string','role'=>'required|exists:roles,name','is_active'=>'boolean']);
        $user->update(['name'=>$v['name'],'email'=>$v['email'],'phone'=>$v['phone']??null,'position'=>$v['position']??null,'is_active'=>$request->has('is_active')]);
        if (!empty($v['password'])) $user->update(['password'=>Hash::make($v['password'])]);
        $user->syncRoles([$v['role']]);
        return redirect()->route('users.index')->with('success','Корбар тағйир дода шуд.');
    }
    public function destroy(User $user) {
        if ($user->id===auth()->id()) return back()->with('error','Шумо худро нест карда наметавонед.');
        $user->delete();
        return redirect()->route('users.index')->with('success','Корбар нест карда шуд.');
    }
}
