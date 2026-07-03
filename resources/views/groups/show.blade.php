@extends('layouts.app')
@section('title', 'Гурӯҳ: ' . $group->name)
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">{{ $group->name }}</h5><small class="text-muted">{{ $group->faculty->name }} / {{ $group->specialty->name }} / {{ $group->course->display_name }}</small></div>
        <a href="{{ route('groups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card text-center"><div class="card-body"><i class="fas fa-user-graduate fa-2x text-primary mb-2"></i><h4>{{ $group->students_count }}</h4><p class="text-muted mb-0">Донишҷӯён</p></div></div></div>
        <div class="col-md-4"><div class="card text-center"><div class="card-body"><i class="fas fa-calendar fa-2x text-info mb-2"></i><h4>{{ $group->academic_year ?? '-' }}</h4><p class="text-muted mb-0">Соли таҳсил</p></div></div></div>
        <div class="col-md-4"><div class="card text-center"><div class="card-body"><i class="fas fa-layer-group fa-2x text-success mb-2"></i><h4>{{ $group->course->display_name }}</h4><p class="text-muted mb-0">Курс</p></div></div></div>
    </div>
    <div class="card"><div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Донишҷӯёни гурӯҳ</h6></div><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Ному насаб</th><th>Ҷинс</th><th>Телефон</th><th class="text-center">Ҳолат</th></tr></thead>
        <tbody>@forelse($group->students as $i=>$s)<tr>
            <td>{{ $i+1 }}</td><td><a href="{{ route('students.profile',$s) }}">{{ $s->full_name }}</a></td>
            <td>{{ $s->gender==='male'?'Мард':'Зан' }}</td><td>{{ $s->phone ?? '-' }}</td>
            <td class="text-center"><span class="badge bg-{{ $s->is_active?'success':'secondary' }}">{{ $s->is_active?'Фаъол':'Ғайрифаъол' }}</span></td>
        </tr>@empty<tr><td colspan="5" class="text-center text-muted py-3">Донишҷӯ нест</td></tr>@endforelse</tbody>
    </table></div></div></div>
</div>
@endsection
