<?php
namespace App\Http\Controllers;
use App\Models\{Faculty, Course, Student, AttendanceRecord, AttendanceSession, MonthlyStatistic};
use Illuminate\Http\Request;

class StatisticsController extends Controller {
    public function index(Request $request) {
        $year = $request->get('year', date('Y')); $month = $request->get('month', date('m'));
        $faculties = Faculty::active()->orderBy('name')->get();
        $courses = Course::active()->orderBy('course_number')->get();
        $query = MonthlyStatistic::with(['student.group','student.faculty'])->where('year',$year)->where('month',$month);
        if ($request->filled('faculty_id')) $query->whereHas('student', fn($q)=>$q->where('faculty_id',$request->faculty_id));
        $statistics = $query->orderByDesc('attendance_percentage')->paginate(25)->withQueryString();
        $totalSessions = AttendanceSession::whereYear('date',$year)->whereMonth('date',$month)->count();
        $totalRecords = 0; $totalPresent = 0; $overallPct = 0;
        $months = [1=>'Январ',2=>'Феврал',3=>'Март',4=>'Апрел',5=>'Май',6=>'Июн',7=>'Июл',8=>'Август',9=>'Сентябр',10=>'Октябр',11=>'Ноябр',12=>'Декабр'];
        return view('statistics.index', compact('statistics','faculties','courses','year','month','months','totalSessions','totalRecords','totalPresent','overallPct'));
    }
    public function calculate(Request $request) {
        $year = $request->year; $month = $request->month;
        $students = Student::active()->get();
        foreach ($students as $student) {
            $records = $student->attendanceRecords()->whereHas('attendanceSession', fn($q)=>$q->whereYear('date',$year)->whereMonth('date',$month))->get();
            $total = $records->count(); if ($total===0) continue;
            MonthlyStatistic::updateOrCreate(['student_id'=>$student->id,'year'=>$year,'month'=>$month],['total_days'=>$total,'present_days'=>$records->where('status','present')->count(),'absent_days'=>$records->where('status','absent')->count(),'excused_days'=>$records->where('status','excused')->count(),'late_days'=>$records->where('status','late')->count(),'attendance_percentage'=>round((($records->where('status','present')->count()+$records->where('status','late')->count())/$total)*100,2),'absence_percentage'=>round(($records->where('status','absent')->count()/$total)*100,2)]);
        }
        return redirect()->route('statistics.index',['year'=>$year,'month'=>$month])->with('success','Омор ҳисоб карда шуд.');
    }
}
