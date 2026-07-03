<?php
namespace App\Http\Controllers;
use App\Models\{Course, ActivityLog};
use Illuminate\Http\Request;

class CourseController extends Controller {
    public function index(Request $request) {
        $courses = Course::withCount(['groups','students'])->orderBy('course_number')->paginate(15)->withQueryString();
        return view('courses.index', compact('courses'));
    }
    public function create() { return view('courses.create'); }
    public function store(Request $request) {
        $v = $request->validate(['course_number'=>'required|integer|min:1|max:10|unique:courses','name'=>'nullable|string','description'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        if (empty($v['name'])) $v['name'] = "Курси {$v['course_number']}";
        Course::create($v);
        return redirect()->route('courses.index')->with('success','Курс сохта шуд.');
    }
    public function show(Course $course) { $course->loadCount(['groups','students']); return view('courses.show',compact('course')); }
    public function edit(Course $course) { return view('courses.edit', compact('course')); }
    public function update(Request $request, Course $course) {
        $v = $request->validate(['course_number'=>'required|integer|min:1|max:10|unique:courses,course_number,'.$course->id,'name'=>'nullable|string','description'=>'nullable|string','is_active'=>'boolean']);
        $v['is_active'] = $request->has('is_active');
        $course->update($v);
        return redirect()->route('courses.index')->with('success','Курс тағйир дода шуд.');
    }
    public function destroy(Course $course) { $course->delete(); return redirect()->route('courses.index')->with('success','Курс нест карда шуд.'); }
}
