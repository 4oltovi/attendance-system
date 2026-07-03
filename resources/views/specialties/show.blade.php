@extends('layouts.app')
@section('title', 'Ихтисос: ' . $specialty->name)
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">{{ $specialty->name }}</h5><small class="text-muted">Факултет: {{ $specialty->faculty->name }}</small></div>
        <a href="{{ route('specialties.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-6"><div class="card text-center"><div class="card-body"><i class="fas fa-users fa-2x text-primary mb-2"></i><h4>{{ $specialty->groups_count }}</h4><p class="text-muted mb-0">Гурӯҳҳо</p></div></div></div>
        <div class="col-md-6"><div class="card text-center"><div class="card-body"><i class="fas fa-user-graduate fa-2x text-success mb-2"></i><h4>{{ $specialty->students_count }}</h4><p class="text-muted mb-0">Донишҷӯён</p></div></div></div>
    </div>
    <div class="card"><div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-users me-2"></i>Гурӯҳҳо</h6></div><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Ном</th><th>Курс</th><th class="text-center">Ҳолат</th></tr></thead>
        <tbody>@forelse($specialty->groups as $i=>$g)<tr><td>{{ $i+1 }}</td><td>{{ $g->name }}</td><td>{{ $g->course->display_name ?? '-' }}</td><td class="text-center"><span class="badge bg-{{ $g->is_active?'success':'secondary' }}">{{ $g->is_active?'Фаъол':'Ғайрифаъол' }}</span></td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-3">Гурӯҳ нест</td></tr>@endforelse</tbody>
    </table></div></div></div>
</div>
@endsection
