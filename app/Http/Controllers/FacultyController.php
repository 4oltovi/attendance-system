<?php
namespace App\Http\Controllers;
use App\Models\{Faculty, ActivityLog};
use Illuminate\Http\Request;

class FacultyController extends Controller {
    public function index(Request $request) {
        $query = Faculty::query();
        if ($request->filled('search')) $query->where('name','like','%'.$request->search.'%');
        if ($request->filled('status')) $query->where('is_active', $request->status === 'active');
        $faculties = $query->withCount(['specialties','groups','students'])->latest()->paginate(15)->withQueryString();
        return view('faculties.index', compact('faculties'));
    }
    public function create() { return view('faculties.create'); }
    public function store(Request $request) {
        $v = $request->validate(['name'=>'required|string|max:255|unique:faculties,name','description'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        $f = Faculty::create($v);
        ActivityLog::log('create','faculties',"Факултети \"{$f->name}\" сохта шуд",$f);
        return redirect()->route('faculties.index')->with('success','Факултет бомуваффақият сохта шуд.');
    }
    public function show(Faculty $faculty) { $faculty->loadCount(['specialties','groups','students']); $faculty->load(['specialties'=>fn($q)=>$q->active()->withCount('students')]); return view('faculties.show',compact('faculty')); }
    public function edit(Faculty $faculty) { return view('faculties.edit', compact('faculty')); }
    public function update(Request $request, Faculty $faculty) {
        $v = $request->validate(['name'=>'required|string|max:255|unique:faculties,name,'.$faculty->id,'description'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        $faculty->update($v);
        ActivityLog::log('update','faculties',"Факултети \"{$faculty->name}\" тағйир дода шуд",$faculty);
        return redirect()->route('faculties.index')->with('success','Факултет бомуваффақият тағйир дода шуд.');
    }
    public function destroy(Faculty $faculty) {
        if ($faculty->students()->count()>0) return back()->with('error','Ин факултет донишҷӯён дорад.');
        $faculty->delete();
        ActivityLog::log('delete','faculties',"Факултет нест карда шуд");
        return redirect()->route('faculties.index')->with('success','Факултет нест карда шуд.');
    }
}
