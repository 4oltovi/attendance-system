<?php
namespace App\Http\Controllers;
use App\Models\{AttendanceSession, AttendanceRecord, Faculty, Course, Group, Student, ActivityLog};
use Illuminate\Http\Request;

class AttendanceController extends Controller {
    public function index(Request $request) {
        $query = AttendanceSession::with(['faculty','specialty','course','group','supervisor']);
        if ($request->filled('date')) $query->whereDate('date',$request->date);
        if ($request->filled('faculty_id')) $query->where('faculty_id',$request->faculty_id);
        if ($request->filled('course_id')) $query->where('course_id',$request->course_id);
        $sessions = $query->latest('date')->paginate(20)->withQueryString();
        $faculties = Faculty::active()->orderBy('name')->get();
        $courses = Course::active()->orderBy('course_number')->get();
        return view('attendance.index', compact('sessions','faculties','courses'));
    }
    public function create() {
        return view('attendance.create',['faculties'=>Faculty::active()->orderBy('name')->get(),'courses'=>Course::active()->orderBy('course_number')->get()]);
    }
    public function store(Request $request) {
        $v = $request->validate(['date'=>'required|date','faculty_id'=>'required|exists:faculties,id','specialty_id'=>'required|exists:specialties,id','course_id'=>'required|exists:courses,id','group_id'=>'required|exists:groups,id','attendance'=>'required|array','attendance.*.student_id'=>'required|exists:students,id','attendance.*.status'=>'required|in:present,absent,excused,late']);
        $existing = AttendanceSession::where('date',$v['date'])->where('group_id',$v['group_id'])->first();
        if ($existing) return back()->with('error','Барои ин гурӯҳ дар ин сана ҳозирӣ аллакай сабт шудааст.')->withInput();
        $session = AttendanceSession::create(['date'=>$v['date'],'faculty_id'=>$v['faculty_id'],'specialty_id'=>$v['specialty_id'],'course_id'=>$v['course_id'],'group_id'=>$v['group_id'],'supervisor_id'=>auth()->id()]);
        foreach ($v['attendance'] as $r) { AttendanceRecord::create(['attendance_session_id'=>$session->id,'student_id'=>$r['student_id'],'status'=>$r['status']]); }
        ActivityLog::log('attendance','attendance','Ҳозирӣ сабт шуд',$session);
        return redirect()->route('attendance.index')->with('success','Ҳозирӣ бомуваффақият сабт шуд.');
    }
    public function show(AttendanceSession $attendance) { $attendance->load(['faculty','specialty','course','group','supervisor','records.student']); return view('attendance.show',compact('attendance')); }
    public function edit(AttendanceSession $attendance) { $attendance->load(['faculty','specialty','course','group','records.student']); return view('attendance.edit',compact('attendance')); }
    public function update(Request $request, AttendanceSession $attendance) {
        $v = $request->validate(['attendance'=>'required|array','attendance.*.record_id'=>'required|exists:attendance_records,id','attendance.*.status'=>'required|in:present,absent,excused,late']);
        foreach($v['attendance'] as $r) { AttendanceRecord::where('id',$r['record_id'])->update(['status'=>$r['status']]); }
        return redirect()->route('attendance.show',$attendance)->with('success','Ҳозирӣ тағйир дода шуд.');
    }
    public function destroy(AttendanceSession $attendance) { $attendance->records()->delete(); $attendance->delete(); return redirect()->route('attendance.index')->with('success','Ҷаласа нест карда шуд.'); }
    public function getStudentsByGroup(Group $group) {
        return response()->json($group->students()->active()->orderBy('last_name')->get()->map(fn($s)=>['id'=>$s->id,'full_name'=>$s->full_name,'student_id'=>$s->student_id]));
    }
}
