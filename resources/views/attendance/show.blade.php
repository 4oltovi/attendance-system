@extends('layouts.app')
@section('title', 'Ҷаласаи ҳозирӣ')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Ҳозирӣ - {{ $attendance->date->format('d.m.Y') }}</h5><small class="text-muted">{{ $attendance->faculty->name }} / {{ $attendance->group->name }}</small></div>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h3 class="text-success">{{ $attendance->present_count }}</h3><small>Ҳозир</small></div></div></div>
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h3 class="text-danger">{{ $attendance->absent_count }}</h3><small>Ғоиб</small></div></div></div>
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h3 class="text-warning">{{ $attendance->excused_count }}</h3><small>Сабабнок</small></div></div></div>
        <div class="col-md-3"><div class="card text-center"><div class="card-body"><h3 class="text-info">{{ $attendance->late_count }}</h3><small>Дер омад</small></div></div></div>
    </div>
    <div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Ному насаб</th><th class="text-center">Вазъият</th></tr></thead>
        <tbody>@foreach($attendance->records as $i=>$r)<tr><td>{{ $i+1 }}</td><td><a href="{{ route('students.profile',$r->student) }}">{{ $r->student->full_name }}</a></td><td class="text-center"><span class="badge bg-{{ $r->status_color }}">{{ $r->status_label }}</span></td></tr>@endforeach</tbody>
    </table></div></div></div>
</div>
@endsection
