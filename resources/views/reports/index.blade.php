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
                        <label class="form-label">Навъи ҳисобот *</label>
                        <select class="form-select" name="report_type" id="report_type" required>
                            <option value="">Интихоб кунед...</option>
                            <option value="faculty" {{ (isset($reportType)&&$reportType==='faculty')?'selected':'' }}>Аз рӯи факултет</option>
                            <option value="course" {{ (isset($reportType)&&$reportType==='course')?'selected':'' }}>Аз рӯи курс</option>
                            <option value="group" {{ (isset($reportType)&&$reportType==='group')?'selected':'' }}>Аз рӯи гурӯҳ</option>
                            <option value="date_range" {{ (isset($reportType)&&$reportType==='date_range')?'selected':'' }}>Аз рӯи сана</option>
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
                <!-- Extra filters -->
                <div class="row g-3 mt-2" id="extraFilters" style="display:none;">
                    <div class="col-md-3" id="groupDiv" style="display:none;">
                        <label class="form-label">Гурӯҳ</label>
                        <select class="form-select" name="group_id" id="report_group"><option value="">Аввал факултет интихоб кунед</option></select>
                    </div>
                    <div class="col-md-3" id="courseDiv" style="display:none;">
                        <label class="form-label">Курс</label>
                        <select class="form-select" name="course_id"><option value="">Ҳама</option>@foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->display_name }}</option>@endforeach</select>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- RESULTS -->
    @if(isset($reportType) && $reportType)
        @if(isset($data) && is_array($data) && !empty($data))
        <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-table me-2 text-primary"></i>{{ $data['title'] ?? 'Натиҷаҳо' }}</h6>
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="fas fa-print me-1"></i>Чоп</button>
        </div>
        <div class="card-body p-0">

            @if(isset($data['type']) && $data['type'] === 'empty')
                <div class="text-center py-4 text-muted"><i class="fas fa-info-circle fa-2x mb-2 d-block opacity-50"></i>{{ $data['message'] ?? 'Маълумот нест' }}</div>

            @elseif(isset($data['type']) && $data['type'] === 'group')
                <div class="table-responsive"><table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>#</th><th>Ному насаб</th><th class="text-center">Рӯзҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th class="text-center">Сабабнок</th><th class="text-center">Дер</th><th class="text-center">Фоиз</th></tr></thead>
                    <tbody>@forelse($data['results'] as $i=>$r)<tr>
                        <td>{{ $i+1 }}</td><td><strong>{{ $r['student']->full_name }}</strong></td>
                        <td class="text-center">{{ $r['total'] }}</td>
                        <td class="text-center"><span class="badge bg-success">{{ $r['present'] }}</span></td>
                        <td class="text-center"><span class="badge bg-danger">{{ $r['absent'] }}</span></td>
                        <td class="text-center"><span class="badge bg-warning">{{ $r['excused'] }}</span></td>
                        <td class="text-center"><span class="badge bg-info">{{ $r['late'] }}</span></td>
                        <td class="text-center"><span class="badge bg-{{ $r['attendance_pct']>=80?'success':($r['attendance_pct']>=60?'warning':'danger') }}">{{ $r['attendance_pct'] }}%</span></td>
                    </tr>@empty<tr><td colspan="8" class="text-center text-muted py-3">Маълумоти ҳозирӣ мавҷуд нест. Аввал ҳозирӣ сабт кунед.</td></tr>@endforelse</tbody>
                </table></div>

            @elseif(isset($data['type']) && $data['type'] === 'faculty')
                <div class="table-responsive"><table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>#</th><th>Гурӯҳ</th><th>Ихтисос</th><th class="text-center">Курс</th><th class="text-center">Донишҷӯён</th><th class="text-center">Сабтҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th class="text-center">Фоиз</th></tr></thead>
                    <tbody>@forelse($data['results'] as $i=>$r)<tr>
                        <td>{{ $i+1 }}</td><td><strong>{{ $r['group_name'] }}</strong></td><td><small>{{ $r['specialty_name'] }}</small></td>
                        <td class="text-center"><span class="badge bg-primary">{{ $r['course_number'] }}</span></td>
                        <td class="text-center">{{ $r['total_students'] }}</td><td class="text-center">{{ $r['total_records'] }}</td>
                        <td class="text-center"><span class="badge bg-success">{{ $r['present'] }}</span></td>
                        <td class="text-center"><span class="badge bg-danger">{{ $r['absent'] }}</span></td>
                        <td class="text-center"><div class="progress" style="height:20px;min-width:70px"><div class="progress-bar bg-{{ $r['attendance_pct']>=80?'success':($r['attendance_pct']>=60?'warning':'danger') }}" style="width:{{ max($r['attendance_pct'],5) }}%">{{ $r['attendance_pct'] }}%</div></div></td>
                    </tr>@empty<tr><td colspan="9" class="text-center text-muted py-3">Маълумоти ҳозирӣ мавҷуд нест</td></tr>@endforelse</tbody>
                </table></div>

            @elseif(isset($data['type']) && $data['type'] === 'all_faculties')
                <div class="table-responsive"><table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>#</th><th>Факултет</th><th class="text-center">Донишҷӯён</th><th class="text-center">Гурӯҳҳо</th><th class="text-center">Сабтҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Фоиз</th></tr></thead>
                    <tbody>@forelse($data['results'] as $i=>$r)<tr>
                        <td>{{ $i+1 }}</td><td><strong>{{ $r['name'] }}</strong></td>
                        <td class="text-center">{{ $r['total_students'] }}</td><td class="text-center">{{ $r['total_groups'] }}</td>
                        <td class="text-center">{{ $r['total_records'] }}</td>
                        <td class="text-center"><span class="badge bg-success">{{ $r['present'] }}</span></td>
                        <td class="text-center"><div class="progress" style="height:20px;min-width:70px"><div class="progress-bar bg-{{ $r['attendance_pct']>=80?'success':($r['attendance_pct']>=60?'warning':'danger') }}" style="width:{{ max($r['attendance_pct'],5) }}%">{{ $r['attendance_pct'] }}%</div></div></td>
                    </tr>@empty<tr><td colspan="7" class="text-center text-muted py-3">Маълумоти ҳозирӣ мавҷуд нест</td></tr>@endforelse</tbody>
                </table></div>

            @elseif(isset($data['type']) && ($data['type'] === 'course' || $data['type'] === 'all_courses'))
                <div class="table-responsive"><table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>#</th>
                        @if($data['type']==='all_courses')<th>Курс</th><th class="text-center">Гурӯҳҳо</th>
                        @else<th>Гурӯҳ</th><th>Факултет</th>@endif
                        <th class="text-center">Донишҷӯён</th><th class="text-center">Сабтҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Фоиз</th></tr></thead>
                    <tbody>@forelse($data['results'] as $i=>$r)<tr>
                        <td>{{ $i+1 }}</td>
                        @if($data['type']==='all_courses')<td><strong>{{ $r['name'] }}</strong></td><td class="text-center">{{ $r['total_groups'] }}</td>
                        @else<td><strong>{{ $r['group_name'] }}</strong></td><td><small>{{ $r['faculty_name'] }}</small></td>@endif
                        <td class="text-center">{{ $r['total_students'] }}</td><td class="text-center">{{ $r['total_records'] }}</td>
                        <td class="text-center"><span class="badge bg-success">{{ $r['present'] }}</span></td>
                        <td class="text-center"><div class="progress" style="height:20px;min-width:70px"><div class="progress-bar bg-{{ $r['attendance_pct']>=80?'success':($r['attendance_pct']>=60?'warning':'danger') }}" style="width:{{ max($r['attendance_pct'],5) }}%">{{ $r['attendance_pct'] }}%</div></div></td>
                    </tr>@empty<tr><td colspan="7" class="text-center text-muted py-3">Маълумоти ҳозирӣ мавҷуд нест</td></tr>@endforelse</tbody>
                </table></div>

            @elseif(isset($data['type']) && $data['type'] === 'date_range')
                <div class="p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-2"><div class="card bg-primary text-white text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $data['sessions_count'] }}</h4><small>Ҷаласаҳо</small></div></div></div>
                        <div class="col-6 col-md-2"><div class="card bg-success text-white text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $data['total_present'] }}</h4><small>Ҳозир</small></div></div></div>
                        <div class="col-6 col-md-2"><div class="card bg-danger text-white text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $data['total_absent'] }}</h4><small>Ғоиб</small></div></div></div>
                        <div class="col-6 col-md-2"><div class="card bg-warning text-white text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $data['total_excused'] }}</h4><small>Сабабнок</small></div></div></div>
                        <div class="col-6 col-md-2"><div class="card bg-info text-white text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $data['total_late'] }}</h4><small>Дер</small></div></div></div>
                        <div class="col-6 col-md-2"><div class="card bg-dark text-white text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $data['attendance_pct'] }}%</h4><small>Фоиз</small></div></div></div>
                    </div>
                    @if(count($data['session_details']) > 0)
                    <div class="table-responsive"><table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th>#</th><th>Сана</th><th>Факултет</th><th>Гурӯҳ</th><th class="text-center">Сабтҳо</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th></tr></thead>
                        <tbody>@foreach($data['session_details'] as $i=>$d)<tr>
                            <td>{{ $i+1 }}</td><td><strong>{{ $d['date'] }}</strong></td>
                            <td><small>{{ $d['faculty_name'] }}</small></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $d['group_name'] }}</span></td>
                            <td class="text-center">{{ $d['total'] }}</td>
                            <td class="text-center"><span class="badge bg-success">{{ $d['present'] }}</span></td>
                            <td class="text-center"><span class="badge bg-danger">{{ $d['absent'] }}</span></td>
                        </tr>@endforeach</tbody>
                    </table></div>
                    @else
                    <p class="text-center text-muted py-3">Дар ин давра ҷаласаи ҳозирӣ сабт нашудааст.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
    </div>
    @else
        <div class="card"><div class="card-body text-center py-4 text-muted">
            <i class="fas fa-info-circle fa-2x mb-3 d-block opacity-50"></i>
            <h6>Маълумот мавҷуд нест</h6>
            <p class="mb-0">Аввал ба "Сабти ҳозирӣ" равед ва ҳозирии ягон гурӯҳро сабт кунед, баъд ин ҷо ҳисобот тавлид кунед.</p>
        </div></div>
    @endif
    @endif
</div>
@endsection

@push('scripts')
<script>
document.getElementById('report_type').addEventListener('change', function(){
    const t=this.value,extra=document.getElementById('extraFilters'),gDiv=document.getElementById('groupDiv'),cDiv=document.getElementById('courseDiv');
    gDiv.style.display='none';cDiv.style.display='none';extra.style.display='none';
    if(t==='group'){gDiv.style.display='block';extra.style.display='flex';}
    else if(t==='course'){cDiv.style.display='block';extra.style.display='flex';}
});
document.getElementById('report_faculty').addEventListener('change', function(){
    if(this.value){fetch(`/api/groups-filter?faculty_id=${this.value}`).then(r=>r.json()).then(d=>{const g=document.getElementById('report_group');g.innerHTML='<option value="">Интихоб...</option>';d.forEach(i=>g.innerHTML+=`<option value="${i.id}">${i.name}</option>`);});}
});
// Auto-trigger if already selected
if(document.getElementById('report_type').value) document.getElementById('report_type').dispatchEvent(new Event('change'));
</script>
@endpush
