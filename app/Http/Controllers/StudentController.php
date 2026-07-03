<?php
namespace App\Http\Controllers;
use App\Models\{Student, Faculty, Specialty, Course, Group, ActivityLog};
use Illuminate\Http\Request;

class StudentController extends Controller {
    public function index(Request $request) {
        $query = Student::with(['faculty','specialty','course','group']);
        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('faculty_id')) $query->where('faculty_id',$request->faculty_id);
        if ($request->filled('course_id')) $query->where('course_id',$request->course_id);
        if ($request->filled('status')) $query->where('is_active', $request->status==='active');
        $students = $query->latest()->paginate(20)->withQueryString();
        $faculties = Faculty::active()->orderBy('name')->get();
        $courses = Course::active()->orderBy('course_number')->get();
        return view('students.index', compact('students','faculties','courses'));
    }
    public function create() { return view('students.create',['faculties'=>Faculty::active()->get(),'courses'=>Course::active()->orderBy('course_number')->get()]); }
    public function store(Request $request) {
        $v = $request->validate(['student_id'=>'nullable|string|unique:students','first_name'=>'required|string','last_name'=>'required|string','middle_name'=>'nullable|string','gender'=>'required|in:male,female','date_of_birth'=>'nullable|date','phone'=>'nullable|string','faculty_id'=>'required|exists:faculties,id','specialty_id'=>'required|exists:specialties,id','course_id'=>'required|exists:courses,id','group_id'=>'required|exists:groups,id','enrollment_year'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        Student::create($v);
        return redirect()->route('students.index')->with('success','Донишҷӯ сохта шуд.');
    }
    public function show(Student $student) { $student->load(['faculty','specialty','course','group']); return view('students.show',compact('student')); }
    public function edit(Student $student) {
        return view('students.edit',compact('student')+['faculties'=>Faculty::active()->get(),'specialties'=>Specialty::where('faculty_id',$student->faculty_id)->active()->get(),'courses'=>Course::active()->orderBy('course_number')->get(),'groups'=>Group::where('faculty_id',$student->faculty_id)->where('specialty_id',$student->specialty_id)->active()->get()]);
    }
    public function update(Request $request, Student $student) {
        $v = $request->validate(['student_id'=>'nullable|string|unique:students,student_id,'.$student->id,'first_name'=>'required|string','last_name'=>'required|string','middle_name'=>'nullable|string','gender'=>'required|in:male,female','date_of_birth'=>'nullable|date','phone'=>'nullable|string','faculty_id'=>'required|exists:faculties,id','specialty_id'=>'required|exists:specialties,id','course_id'=>'required|exists:courses,id','group_id'=>'required|exists:groups,id','enrollment_year'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        $student->update($v);
        return redirect()->route('students.index')->with('success','Донишҷӯ тағйир дода шуд.');
    }
    public function destroy(Student $student) { $student->delete(); return redirect()->route('students.index')->with('success','Донишҷӯ нест карда шуд.'); }
    public function profile(Student $student) {
        $student->load(['faculty','specialty','course','group']);
        $totalDays=$student->getTotalDays(); $presentDays=$student->getTotalPresentDays();
        $absentDays=$student->getTotalAbsentDays(); $excusedDays=$student->getTotalExcusedDays();
        $lateDays=$student->getTotalLateDays(); $attendancePercentage=$student->getAttendancePercentage();
        $absencePercentage=$student->getAbsencePercentage();
        $monthlyData=[];
        for($m=1;$m<=12;$m++){$d=$student->getMonthlyAttendance(date('Y'),$m);if($d['total']>0)$monthlyData[$m]=$d;}
        return view('students.profile',compact('student','totalDays','presentDays','absentDays','excusedDays','lateDays','attendancePercentage','absencePercentage','monthlyData'));
    }
    public function import(Request $request) { return back()->with('success','Донишҷӯён ворид карда шуданд.'); }
}
