<?php
namespace App\Http\Controllers;
use App\Models\{Specialty, Faculty, ActivityLog};
use Illuminate\Http\Request;

class SpecialtyController extends Controller {
    public function index(Request $request) {
        $query = Specialty::with('faculty');
        if ($request->filled('search')) $query->where('name','like','%'.$request->search.'%');
        if ($request->filled('faculty_id')) $query->where('faculty_id',$request->faculty_id);
        $specialties = $query->withCount(['groups','students'])->latest()->paginate(15)->withQueryString();
        $faculties = Faculty::active()->orderBy('name')->get();
        return view('specialties.index', compact('specialties','faculties'));
    }
    public function create() { return view('specialties.create', ['faculties'=>Faculty::active()->orderBy('name')->get()]); }
    public function store(Request $request) {
        $v = $request->validate(['faculty_id'=>'required|exists:faculties,id','name'=>'required|string|max:255','description'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        $s = Specialty::create($v);
        ActivityLog::log('create','specialties',"Ихтисоси \"{$s->name}\" сохта шуд",$s);
        return redirect()->route('specialties.index')->with('success','Ихтисос бомуваффақият сохта шуд.');
    }
    public function show(Specialty $specialty) { $specialty->load(['faculty','groups.course']); $specialty->loadCount(['groups','students']); return view('specialties.show',compact('specialty')); }
    public function edit(Specialty $specialty) { return view('specialties.edit', compact('specialty') + ['faculties'=>Faculty::active()->orderBy('name')->get()]); }
    public function update(Request $request, Specialty $specialty) {
        $v = $request->validate(['faculty_id'=>'required|exists:faculties,id','name'=>'required|string|max:255','description'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        $specialty->update($v);
        ActivityLog::log('update','specialties',"Ихтисоси \"{$specialty->name}\" тағйир дода шуд",$specialty);
        return redirect()->route('specialties.index')->with('success','Ихтисос тағйир дода шуд.');
    }
    public function destroy(Specialty $specialty) { $specialty->delete(); return redirect()->route('specialties.index')->with('success','Ихтисос нест карда шуд.'); }
    public function getByFaculty(Faculty $faculty) { return response()->json($faculty->specialties()->active()->orderBy('name')->get(['id','name'])); }
}
