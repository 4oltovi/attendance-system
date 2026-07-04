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
        $reportType = $request->report_type;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $data = [];

        switch ($reportType) {
            case 'group':
                if ($request->group_id) {
                    $data = $this->groupReport($request->group_id, $dateFrom, $dateTo);
                }
                break;

            case 'faculty':
                $facultyId = $request->faculty_id;
                if ($facultyId) {
                    $data = $this->facultyReport($facultyId, $dateFrom, $dateTo);
                } else {
                    // All faculties report
                    $data = $this->allFacultiesReport($dateFrom, $dateTo);
                }
                break;

            case 'course':
                $courseId = $request->course_id;
                if ($courseId) {
                    $data = $this->courseReport($courseId, $dateFrom, $dateTo);
                } else {
                    $data = $this->allCoursesReport($dateFrom, $dateTo);
                }
                break;

            case 'date_range':
                $data = $this->dateRangeReport($dateFrom, $dateTo, $request->faculty_id);
                break;
        }

        return view('reports.index', compact('faculties','courses','data','reportType','dateFrom','dateTo'));
    }

    private function groupReport($groupId, $dateFrom, $dateTo): array
    {
        $group = Group::with('faculty')->find($groupId);
        if (!$group) return [];

        $students = $group->students()->active()->orderBy('last_name')->get();
        $results = [];

        foreach ($students as $student) {
            $query = $student->attendanceRecords();
            if ($dateFrom && $dateTo) {
                $query->whereHas('attendanceSession', fn($q) => $q->whereBetween('date', [$dateFrom, $dateTo]));
            }
            $records = $query->get();
            $total = $records->count();
            $present = $records->where('status', 'present')->count();
            $absent = $records->where('status', 'absent')->count();
            $excused = $records->where('status', 'excused')->count();
            $late = $records->where('status', 'late')->count();

            $results[] = [
                'student' => $student,
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'excused' => $excused,
                'late' => $late,
                'attendance_pct' => $total > 0 ? round((($present + $late) / $total) * 100, 2) : 0,
            ];
        }

        return ['title' => "Ҳисоботи гурӯҳ: {$group->name}", 'type' => 'group', 'results' => $results];
    }

    private function facultyReport($facultyId, $dateFrom, $dateTo): array
    {
        $faculty = Faculty::find($facultyId);
        if (!$faculty) return [];

        $groups = Group::where('faculty_id', $facultyId)->active()->with(['specialty', 'course'])->get();
        $results = [];

        foreach ($groups as $group) {
            $query = AttendanceSession::where('group_id', $group->id);
            if ($dateFrom && $dateTo) {
                $query->whereBetween('date', [$dateFrom, $dateTo]);
            }
            $sessionIds = $query->pluck('id');
            $records = AttendanceRecord::whereIn('attendance_session_id', $sessionIds)->get();
            $total = $records->count();
            $present = $records->where('status', 'present')->count() + $records->where('status', 'late')->count();
            $absent = $records->where('status', 'absent')->count();

            $results[] = [
                'group' => $group,
                'total_students' => $group->students()->active()->count(),
                'total_records' => $total,
                'present' => $present,
                'absent' => $absent,
                'attendance_pct' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            ];
        }

        return ['title' => "Ҳисоботи факултет: {$faculty->name}", 'type' => 'faculty', 'results' => $results];
    }

    private function allFacultiesReport($dateFrom, $dateTo): array
    {
        $faculties = Faculty::active()->get();
        $results = [];

        foreach ($faculties as $faculty) {
            $query = AttendanceSession::where('faculty_id', $faculty->id);
            if ($dateFrom && $dateTo) {
                $query->whereBetween('date', [$dateFrom, $dateTo]);
            }
            $sessionIds = $query->pluck('id');
            $records = AttendanceRecord::whereIn('attendance_session_id', $sessionIds)->get();
            $total = $records->count();
            $present = $records->where('status', 'present')->count() + $records->where('status', 'late')->count();

            $results[] = [
                'faculty' => $faculty,
                'total_students' => $faculty->students()->active()->count(),
                'total_groups' => $faculty->groups()->active()->count(),
                'total_records' => $total,
                'present' => $present,
                'attendance_pct' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            ];
        }

        return ['title' => "Ҳисоботи ҳамаи факултетҳо", 'type' => 'all_faculties', 'results' => $results];
    }

    private function courseReport($courseId, $dateFrom, $dateTo): array
    {
        $course = Course::find($courseId);
        if (!$course) return [];

        $groups = Group::where('course_id', $courseId)->active()->with(['faculty', 'specialty'])->get();
        $results = [];

        foreach ($groups as $group) {
            $query = AttendanceSession::where('group_id', $group->id);
            if ($dateFrom && $dateTo) {
                $query->whereBetween('date', [$dateFrom, $dateTo]);
            }
            $sessionIds = $query->pluck('id');
            $records = AttendanceRecord::whereIn('attendance_session_id', $sessionIds)->get();
            $total = $records->count();
            $present = $records->where('status', 'present')->count() + $records->where('status', 'late')->count();
            $absent = $records->where('status', 'absent')->count();

            $results[] = [
                'group' => $group,
                'total_students' => $group->students()->active()->count(),
                'total_records' => $total,
                'present' => $present,
                'absent' => $absent,
                'attendance_pct' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            ];
        }

        return ['title' => "Ҳисоботи курс: {$course->display_name}", 'type' => 'course', 'results' => $results];
    }

    private function allCoursesReport($dateFrom, $dateTo): array
    {
        $courses = Course::active()->orderBy('course_number')->get();
        $results = [];

        foreach ($courses as $course) {
            $query = AttendanceSession::where('course_id', $course->id);
            if ($dateFrom && $dateTo) {
                $query->whereBetween('date', [$dateFrom, $dateTo]);
            }
            $sessionIds = $query->pluck('id');
            $records = AttendanceRecord::whereIn('attendance_session_id', $sessionIds)->get();
            $total = $records->count();
            $present = $records->where('status', 'present')->count() + $records->where('status', 'late')->count();

            $results[] = [
                'course' => $course,
                'total_groups' => $course->groups()->active()->count(),
                'total_students' => $course->students()->active()->count(),
                'total_records' => $total,
                'present' => $present,
                'attendance_pct' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            ];
        }

        return ['title' => "Ҳисоботи ҳамаи курсҳо", 'type' => 'all_courses', 'results' => $results];
    }

    private function dateRangeReport($dateFrom, $dateTo, $facultyId = null): array
    {
        if (!$dateFrom || !$dateTo) {
            $dateFrom = $dateFrom ?: now()->startOfMonth()->format('Y-m-d');
            $dateTo = $dateTo ?: now()->format('Y-m-d');
        }

        $query = AttendanceSession::with(['group', 'faculty']);
        $query->whereBetween('date', [$dateFrom, $dateTo]);
        if ($facultyId) {
            $query->where('faculty_id', $facultyId);
        }

        $sessions = $query->orderBy('date', 'desc')->get();
        $totalRecords = 0;
        $totalPresent = 0;
        $totalAbsent = 0;
        $totalExcused = 0;
        $totalLate = 0;

        $sessionDetails = [];
        foreach ($sessions as $session) {
            $records = $session->records;
            $sTotal = $records->count();
            $sPresent = $records->where('status', 'present')->count();
            $sAbsent = $records->where('status', 'absent')->count();

            $totalRecords += $sTotal;
            $totalPresent += $sPresent + $records->where('status', 'late')->count();
            $totalAbsent += $sAbsent;
            $totalExcused += $records->where('status', 'excused')->count();
            $totalLate += $records->where('status', 'late')->count();

            $sessionDetails[] = [
                'session' => $session,
                'total' => $sTotal,
                'present' => $sPresent,
                'absent' => $sAbsent,
            ];
        }

        return [
            'title' => "Ҳисобот аз {$dateFrom} то {$dateTo}",
            'type' => 'date_range',
            'sessions_count' => $sessions->count(),
            'total_records' => $totalRecords,
            'total_present' => $totalPresent,
            'total_absent' => $totalAbsent,
            'total_excused' => $totalExcused,
            'total_late' => $totalLate,
            'attendance_pct' => $totalRecords > 0 ? round(($totalPresent / $totalRecords) * 100, 2) : 0,
            'session_details' => $sessionDetails,
        ];
    }
}
