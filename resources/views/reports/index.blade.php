@extends('layouts.app')
@section('title', 'Ҳисоботҳо')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Ҳисоботҳои ҳозирӣ</h5><small class="text-muted">Тавлиди ҳисоботҳо аз рӯи параметрҳои гуногун</small></div>
    </div>

    <!-- Report Form -->
    <div class="card mb-4">
        <div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-filter me-2 text-primary"></i>Параметрҳои ҳисобот</h6></div>
        <div class="card-body">
            <form method="POST" action="{{ route('reports.generate') }}">@csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Навъи ҳисобот <span class="text-danger">*</span></label>
                        <select class="form-select" name="report_type" id="report_type" required>
                            <option value="">Интихоб кунед...</option>
                            <option value="group" {{ (isset($reportType) && $reportType==='group')?'selected':'' }}>Аз рӯи гурӯҳ</option>
                            <option value="faculty" {{ (isset($reportType) && $reportType==='faculty')?'selected':'' }}>Аз рӯи факултет</option>
                            <option value="course" {{ (isset($reportType) && $reportType==='course')?'selected':'' }}>Аз рӯи курс</option>
                            <option value="date_range" {{ (isset($reportType) && $reportType==='date_range')?'selected':'' }}>Аз рӯи сана</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Факултет</label>
                        <select class="form-select" name="faculty_id" id="report_faculty">
                            <option value="">Ҳама</option>
                            @foreach($faculties as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Аз сана</label>
                        <input type="date" class="form-control" name="date_from" value="{{ $dateFrom ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">То сана</label>
                        <input type="date" class="form-control" name="date_to" value="{{ $dateTo ?? '' }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-chart-bar me-1"></i>Тавлид</button>
                    </div>
                </div>

                <!-- Group filter (shown dynamically) -->
                <div class="row g-3 mt-2" id="groupFilterRow" style="display:none;">
                    <div class="col-md-3">
                        <label class="form-label">Гурӯҳ</label>
                        <select class="form-select" name="group_id" id="report_group">
                            <option value="">Аввал факултетро интихоб кунед</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Курс</label>
                        <select class="form-select" name="course_id">
                            <option value="">Ҳама</option>
                            @foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->display_name }}</option>@endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Results -->
    @if(isset($data) && !empty($data))
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-table me-2 text-primary"></i>{{ $data['title'] ?? 'Натиҷаҳо' }}</h6>
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="fas fa-print me-1"></i>Чоп</button>
        </div>
        <div class="card-body p-0">
            @if($reportType === 'group' && isset($data['results']))
            <div class="table-responsive"><table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>#</th><th>Ному насаб</th><th class="text-center">Рӯзҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th class="text-center">Сабабнок</th><th class="text-center">Дер</th><th class="text-center">Фоиз</th></tr></thead>
                <tbody>
                    @foreach($data['results'] as $i => $row)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $row['student']->full_name }}</td>
                        <td class="text-center">{{ $row['total'] }}</td>
                        <td class="text-center"><span class="badge bg-success">{{ $row['present'] }}</span></td>
                        <td class="text-center"><span class="badge bg-danger">{{ $row['absent'] }}</span></td>
                        <td class="text-center"><span class="badge bg-warning">{{ $row['excused'] }}</span></td>
                        <td class="text-center"><span class="badge bg-info">{{ $row['late'] }}</span></td>
                        <td class="text-center">
                            <span class="badge bg-{{ $row['attendance_pct']>=80?'success':($row['attendance_pct']>=60?'warning':'danger') }}">{{ $row['attendance_pct'] }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table></div>

            @elseif(($reportType === 'faculty' || $reportType === 'course') && isset($data['results']))
            <div class="table-responsive"><table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>#</th><th>Гурӯҳ</th><th class="text-center">Сабтҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Фоиз</th></tr></thead>
                <tbody>
                    @foreach($data['results'] as $i => $row)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><strong>{{ $row['group']->name }}</strong></td>
                        <td class="text-center">{{ $row['total_records'] }}</td>
                        <td class="text-center"><span class="badge bg-success">{{ $row['present'] }}</span></td>
                        <td class="text-center">
                            <div class="progress" style="height:20px;min-width:80px"><div class="progress-bar bg-{{ $row['attendance_pct']>=80?'success':($row['attendance_pct']>=60?'warning':'danger') }}" style="width:{{ $row['attendance_pct'] }}%">{{ $row['attendance_pct'] }}%</div></div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table></div>

            @elseif($reportType === 'date_range')
            <div class="p-4"><div class="row g-3">
                <div class="col-md-3"><div class="card bg-primary text-white text-center"><div class="card-body"><h3>{{ $data['sessions_count'] }}</h3><small>Ҷаласаҳо</small></div></div></div>
                <div class="col-md-3"><div class="card bg-success text-white text-center"><div class="card-body"><h3>{{ $data['total_present'] }}</h3><small>Ҳозир</small></div></div></div>
                <div class="col-md-3"><div class="card bg-danger text-white text-center"><div class="card-body"><h3>{{ $data['total_absent'] }}</h3><small>Ғоиб</small></div></div></div>
                <div class="col-md-3"><div class="card bg-info text-white text-center"><div class="card-body"><h3>{{ $data['attendance_pct'] }}%</h3><small>Фоизи ҳозирӣ</small></div></div></div>
            </div></div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.getElementById('report_type').addEventListener('change', function(){
    document.getElementById('groupFilterRow').style.display = (this.value==='group')?'flex':'none';
});
document.getElementById('report_faculty').addEventListener('change', function(){
    if(this.value){fetch(`/api/groups-filter?faculty_id=${this.value}`).then(r=>r.json()).then(d=>{const g=document.getElementById('report_group');g.innerHTML='<option value="">Интихоб...</option>';d.forEach(i=>g.innerHTML+=`<option value="${i.id}">${i.name}</option>`);});}
});
</script>
@endpush
