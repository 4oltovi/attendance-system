@extends('layouts.app')
@section('title', 'Омори моҳона')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Омори моҳонаи ҳозирӣ</h5><small class="text-muted">Натиҷаҳои ҳозирии донишҷӯён аз рӯи моҳ</small></div>
        <form method="POST" action="{{ route('statistics.calculate') }}" class="d-inline">@csrf
            <input type="hidden" name="year" value="{{ $year }}">
            <input type="hidden" name="month" value="{{ $month }}">
            <button type="submit" class="btn btn-success" onclick="return confirm('Ҳисобкуниро оғоз мекунед?')"><i class="fas fa-calculator me-1"></i>Ҳисоб кардан</button>
        </form>
    </div>

    <!-- Filters -->
    <div class="card mb-3"><div class="card-body py-2">
        <form method="GET" action="{{ route('statistics.index') }}" class="row g-2 align-items-center">
            <div class="col-md-2">
                <select class="form-select form-select-sm" name="year">
                    @for($y=date('Y');$y>=2020;$y--)<option value="{{ $y }}" {{ $year==$y?'selected':'' }}>{{ $y }}</option>@endfor
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select form-select-sm" name="month">
                    @foreach($months as $num=>$name)<option value="{{ $num }}" {{ $month==$num?'selected':'' }}>{{ $name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-sm" name="faculty_id">
                    <option value="">Ҳамаи факултетҳо</option>
                    @foreach($faculties as $f)<option value="{{ $f->id }}" {{ request('faculty_id')==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-search me-1"></i>Нишон додан</button>
                <a href="{{ route('statistics.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo me-1"></i>Тоза</a>
            </div>
        </form>
    </div></div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h4 class="text-primary">{{ $months[(int)$month] }} {{ $year }}</h4><small class="text-muted">Моҳи интихобшуда</small></div></div></div>
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h4>{{ $totalSessions }}</h4><small class="text-muted">Ҷаласаҳо</small></div></div></div>
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h4 class="text-success">{{ $totalPresent }}</h4><small class="text-muted">Ҳозир</small></div></div></div>
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h4 class="{{ $overallPct>=80?'text-success':($overallPct>=60?'text-warning':'text-danger') }}">{{ $overallPct }}%</h4><small class="text-muted">Фоизи умумӣ</small></div></div></div>
    </div>

    <!-- Statistics Table -->
    <div class="card">
        <div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Омори донишҷӯён</h6></div>
        <div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>#</th><th>Донишҷӯ</th><th>Гурӯҳ</th><th class="text-center">Рӯзҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th class="text-center">Сабабнок</th><th class="text-center">Дер</th><th class="text-center">Ҳозирӣ %</th><th class="text-center">Ғоибӣ %</th></tr></thead>
            <tbody>
                @forelse($statistics as $i => $stat)
                <tr>
                    <td>{{ $statistics->firstItem()+$i }}</td>
                    <td><a href="{{ route('students.profile',$stat->student) }}">{{ $stat->student->full_name }}</a></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $stat->student->group->name ?? '-' }}</span></td>
                    <td class="text-center">{{ $stat->total_days }}</td>
                    <td class="text-center"><span class="badge bg-success">{{ $stat->present_days }}</span></td>
                    <td class="text-center"><span class="badge bg-danger">{{ $stat->absent_days }}</span></td>
                    <td class="text-center"><span class="badge bg-warning">{{ $stat->excused_days }}</span></td>
                    <td class="text-center"><span class="badge bg-info">{{ $stat->late_days }}</span></td>
                    <td class="text-center"><span class="badge bg-{{ $stat->attendance_percentage>=80?'success':($stat->attendance_percentage>=60?'warning':'danger') }}">{{ $stat->attendance_percentage }}%</span></td>
                    <td class="text-center"><span class="badge bg-{{ $stat->absence_percentage<=10?'success':($stat->absence_percentage<=20?'warning':'danger') }}">{{ $stat->absence_percentage }}%</span></td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center py-4 text-muted"><i class="fas fa-chart-pie fa-2x mb-2 d-block opacity-50"></i>Маълумот мавҷуд нест. Лутфан "Ҳисоб кардан"-ро пахш кунед.</td></tr>
                @endforelse
            </tbody>
        </table></div></div>
        @if($statistics->hasPages())<div class="card-footer bg-white">{{ $statistics->links() }}</div>@endif
    </div>
</div>
@endsection
