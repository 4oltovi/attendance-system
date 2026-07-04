<?php
namespace App\Http\Controllers;
use App\Models\{ActivityLog, User};
use Illuminate\Http\Request;

class ActivityLogController extends Controller {
    public function index(Request $request) {
        $query = ActivityLog::with('user');
        if ($request->filled('user_id')) $query->where('user_id',$request->user_id);
        if ($request->filled('module')) $query->where('module',$request->module);
        if ($request->filled('action')) $query->where('action',$request->action);
        if ($request->filled('date_from')) $query->whereDate('created_at','>=',$request->date_from);
        if ($request->filled('date_to')) $query->whereDate('created_at','<=',$request->date_to);
        $logs = $query->latest()->paginate(25)->withQueryString();
        $users = User::orderBy('name')->get();
        $modules = ['auth'=>'Аутентификатсия','users'=>'Корбарон','faculties'=>'Факултетҳо','specialties'=>'Ихтисосҳо','courses'=>'Курсҳо','groups'=>'Гурӯҳҳо','students'=>'Донишҷӯён','attendance'=>'Ҳозирӣ'];
        $totalLogs = ActivityLog::count();
        return view('logs.index', compact('logs','users','modules','totalLogs'));
    }

    public function clearAll() {
        $count = ActivityLog::count();
        ActivityLog::truncate();
        return redirect()->route('logs.index')->with('success', "Ҳамаи {$count} сабти лог бомуваффақият тоза карда шуд.");
    }
}
