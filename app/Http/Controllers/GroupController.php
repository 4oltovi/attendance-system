<?php
namespace App\Http\Controllers;
use App\Models\{Group, Faculty, Specialty, Course, ActivityLog};
use Illuminate\Http\Request;

class GroupController extends Controller {
    public function index(Request $request) {
        $query = Group::with(['faculty','specialty','course']);
        if ($request->filled('search')) $query->where('name','like','%'.$request->search.'%');
        if ($request->filled('faculty_id')) $query->where('faculty_id',$request->faculty_id);
        if ($request->filled('course_id')) $query->where('course_id',$request->course_id);
        $groups = $query->withCount('students')->latest()->paginate(15)->withQueryString();
        $faculties = Faculty::active()->orderBy('name')->get();
        $courses = Course::active()->orderBy('course_number')->get();
        return view('groups.index', compact('groups','faculties','courses'));
    }
    public function create() { return view('groups.create',['faculties'=>Faculty::active()->get(),'courses'=>Course::active()->orderBy('course_number')->get()]); }
    public function store(Request $request) {
        $v = $request->validate(['faculty_id'=>'required|exists:faculties,id','specialty_id'=>'required|exists:specialties,id','course_id'=>'required|exists:courses,id','name'=>'required|string|max:255','academic_year'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        Group::create($v);
        return redirect()->route('groups.index')->with('success','Гурӯҳ сохта шуд.');
    }
    public function show(Group $group) { $group->load(['faculty','specialty','course','students'=>fn($q)=>$q->active()->orderBy('last_name')]); $group->loadCount('students'); return view('groups.show',compact('group')); }
    public function edit(Group $group) { return view('groups.edit',compact('group')+['faculties'=>Faculty::active()->get(),'specialties'=>Specialty::where('faculty_id',$group->faculty_id)->active()->get(),'courses'=>Course::active()->orderBy('course_number')->get()]); }
    public function update(Request $request, Group $group) {
        $v = $request->validate(['faculty_id'=>'required|exists:faculties,id','specialty_id'=>'required|exists:specialties,id','course_id'=>'required|exists:courses,id','name'=>'required|string|max:255','academic_year'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        $group->update($v);
        return redirect()->route('groups.index')->with('success','Гурӯҳ тағйир дода шуд.');
    }
    public function destroy(Group $group) { $group->delete(); return redirect()->route('groups.index')->with('success','Гурӯҳ нест карда шуд.'); }
    public function getBySpecialty(Specialty $specialty) { return response()->json($specialty->groups()->active()->orderBy('name')->get(['id','name'])); }
    public function getFiltered(Request $request) {
        $query = Group::active();
        if ($request->filled('faculty_id')) $query->where('faculty_id',$request->faculty_id);
        if ($request->filled('specialty_id')) $query->where('specialty_id',$request->specialty_id);
        if ($request->filled('course_id')) $query->where('course_id',$request->course_id);
        return response()->json($query->orderBy('name')->get(['id','name']));
    }
}
