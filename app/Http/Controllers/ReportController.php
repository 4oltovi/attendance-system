<?php
namespace App\Http\Controllers;
use App\Models\{Faculty, Course, Group, Student, AttendanceRecord, AttendanceSession};
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function index() {
        $faculties = Faculty::active()->orderBy('name')->get();
        $courses = Course::active()->orderBy('course_number')->get();
        return view('reports.index', compact('faculties','courses'));
    }
    public function generate(Request $request) {
        $faculties = Faculty::active()->orderBy('name')->get();
        $courses = Course::active()->orderBy('course_number')->get();
        $reportType = $request->report_type; $dateFrom = $request->date_from; $dateTo = $request->date_to;
        $data = [];
        if ($reportType === 'group' && $request->group_id) {
            $group = Group::find($request->group_id);
            $students = $group->students()->active()->orderBy('last_name')->get();
            $results = [];
            foreach ($students as $student) {
                $query = $student->attendanceRecords();
                if ($dateFrom && $dateTo) $query->whereHas('attendanceSession', fn($q)=>$q->whereBetween('date',[$dateFrom,$dateTo]));
                $records = $query->get(); $total = $records->count();
                $results[] = ['student'=>$student,'total'=>$total,'present'=>$records->where('status','present')->count(),'absent'=>$records->where('status','absent')->count(),'excused'=>$records->where('status','excused')->count(),'late'=>$records->where('status','late')->count(),'attendance_pct'=>$total>0?round((($records->where('status','present')->count()+$records->where('status','late')->count())/$total)*100,2):0];
            }
            $data = ['title'=>"Ҳисоботи гурӯҳ: {$group->name}",'results'=>$results];
        }
        return view('reports.index', compact('faculties','courses','data','reportType','dateFrom','dateTo'));
    }
}
