<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware(['auth', 'user.active'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'changePassword'])->name('password.update');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('faculties', FacultyController::class);
    Route::resource('specialties', SpecialtyController::class);
    Route::get('/api/specialties-by-faculty/{faculty}', [SpecialtyController::class, 'getByFaculty'])->name('api.specialties.by-faculty');
    Route::resource('courses', CourseController::class);
    Route::resource('groups', GroupController::class);
    Route::get('/api/groups-by-specialty/{specialty}', [GroupController::class, 'getBySpecialty'])->name('api.groups.by-specialty');
    Route::get('/api/groups-filter', [GroupController::class, 'getFiltered'])->name('api.groups.filter');
    Route::resource('students', StudentController::class);
    Route::get('/students/{student}/profile', [StudentController::class, 'profile'])->name('students.profile');
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::resource('attendance', AttendanceController::class);
    Route::post('/attendance/store-session', [AttendanceController::class, 'storeSession'])->name('attendance.store-session');
    Route::get('/api/students-by-group/{group}', [AttendanceController::class, 'getStudentsByGroup'])->name('api.students.by-group');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::post('/statistics/calculate', [StatisticsController::class, 'calculate'])->name('statistics.calculate');
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::delete('/logs/clear', [ActivityLogController::class, 'clearAll'])->name('logs.clear');
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::resource('users', UserController::class);
    });
});
