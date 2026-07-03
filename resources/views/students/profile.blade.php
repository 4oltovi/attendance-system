@extends('layouts.app')
@section('title', 'Профил: ' . $student->full_name)
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">{{ $student->full_name }}</h5><small class="text-muted">{{ $student->faculty->name }} / {{ $student->specialty->name }} / {{ $student->group->name }}</small></div>
        <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4"><div class="card text-center h-100"><div class="card-body"><i class="fas fa-calendar fa-2x text-primary mb-2"></i><h3>{{ $totalDays }}</h3><small class="text-muted">Ҳамаи рӯзҳо</small></div></div></div>
        <div class="col-xl-2 col-md-4"><div class="card text-center h-100"><div class="card-body"><i class="fas fa-check-circle fa-2x text-success mb-2"></i><h3 class="text-success">{{ $presentDays }}</h3><small class="text-muted">Ҳозир</small></div></div></div>
        <div class="col-xl-2 col-md-4"><div class="card text-center h-100"><div class="card-body"><i class="fas fa-times-circle fa-2x text-danger mb-2"></i><h3 class="text-danger">{{ $absentDays }}</h3><small class="text-muted">Ғоиб</small></div></div></div>
        <div class="col-xl-2 col-md-4"><div class="card text-center h-100"><div class="card-body"><i class="fas fa-file-alt fa-2x text-warning mb-2"></i><h3 class="text-warning">{{ $excusedDays }}</h3><small class="text-muted">Сабабнок</small></div></div></div>
        <div class="col-xl-2 col-md-4"><div class="card text-center h-100"><div class="card-body"><i class="fas fa-clock fa-2x text-info mb-2"></i><h3 class="text-info">{{ $lateDays }}</h3><small class="text-muted">Дер омад</small></div></div></div>
        <div class="col-xl-2 col-md-4"><div class="card text-center h-100"><div class="card-body"><i class="fas fa-percentage fa-2x text-primary mb-2"></i><h3 class="{{ $attendancePercentage>=80?'text-success':($attendancePercentage>=60?'text-warning':'text-danger') }}">{{ $attendancePercentage }}%</h3><small class="text-muted">Фоизи ҳозирӣ</small></div></div></div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-6"><div class="card"><div class="card-body"><h6 class="mb-3"><i class="fas fa-chart-bar me-2 text-success"></i>Фоизи ҳозирӣ</h6><div class="progress" style="height:30px"><div class="progress-bar bg-success" style="width:{{ $attendancePercentage }}%">{{ $attendancePercentage }}%</div></div></div></div></div>
        <div class="col-md-6"><div class="card"><div class="card-body"><h6 class="mb-3"><i class="fas fa-chart-bar me-2 text-danger"></i>Фоизи ғоибӣ</h6><div class="progress" style="height:30px"><div class="progress-bar bg-danger" style="width:{{ $absencePercentage }}%">{{ $absencePercentage }}%</div></div></div></div></div>
    </div>
    @php $monthNames=[1=>'Январ',2=>'Феврал',3=>'Март',4=>'Апрел',5=>'Май',6=>'Июн',7=>'Июл',8=>'Август',9=>'Сентябр',10=>'Октябр',11=>'Ноябр',12=>'Декабр']; @endphp
    <div class="card"><div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Хулосаи моҳона - {{ date('Y') }}</h6></div><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Моҳ</th><th class="text-center">Рӯзҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th class="text-center">Сабабнок</th><th class="text-center">Дер</th><th class="text-center">Ҳозирӣ%</th></tr></thead>
        <tbody>@forelse($monthlyData as $m=>$d)<tr><td><strong>{{ $monthNames[$m] }}</strong></td><td class="text-center">{{ $d['total'] }}</td><td class="text-center"><span class="badge bg-success">{{ $d['present'] }}</span></td><td class="text-center"><span class="badge bg-danger">{{ $d['absent'] }}</span></td><td class="text-center"><span class="badge bg-warning">{{ $d['excused'] }}</span></td><td class="text-center"><span class="badge bg-info">{{ $d['late'] }}</span></td><td class="text-center"><span class="badge bg-{{ $d['attendance_percentage']>=80?'success':($d['attendance_percentage']>=60?'warning':'danger') }}">{{ $d['attendance_percentage'] }}%</span></td></tr>@empty<tr><td colspan="7" class="text-center text-muted py-3">Маълумот нест</td></tr>@endforelse</tbody>
    </table></div></div></div>
</div>
@endsection
