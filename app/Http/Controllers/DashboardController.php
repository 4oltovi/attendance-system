<?php
namespace App\Http\Controllers;
use App\Models\{Faculty, Specialty, Group, Student, AttendanceSession, AttendanceRecord};
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index() {
        $today = Carbon::today();
        $totalStudents = Student::active()->count();
        $totalFaculties = Faculty::active()->count();
        $totalSpecialties = Specialty::active()->count();
        $totalGroups = Group::active()->count();
        $todayRecords = AttendanceRecord::whereHas('attendanceSession', fn($q) => $q->whereDate('date', $today));
        $todayPresent = (clone $todayRecords)->where('status','present')->count();
        $todayAbsent = (clone $todayRecords)->where('status','absent')->count();
        $todayExcused = (clone $todayRecords)->where('status','excused')->count();
        $todayLate = (clone $todayRecords)->where('status','late')->count();
        $todayTotal = $todayRecords->count();
        $todayPercentage = $todayTotal > 0 ? round((($todayPresent+$todayLate)/$todayTotal)*100,1) : 0;
        $monthlyStats = []; $facultyStats = collect();
        $recentSessions = AttendanceSession::with(['group','faculty','supervisor'])->latest('date')->take(10)->get();
        return view('dashboard.index', compact('totalStudents','totalFaculties','totalSpecialties','totalGroups','todayPresent','todayAbsent','todayExcused','todayLate','todayTotal','todayPercentage','monthlyStats','facultyStats','recentSessions'));
    }
}
