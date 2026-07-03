@extends('layouts.app')
@section('title', 'Таърихи ҳозирӣ')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Таърихи ҳозирӣ</h5><small class="text-muted">Рӯйхати ҷаласаҳои ҳозирӣ</small></div>
        @can('attendance.create')<a href="{{ route('attendance.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Сабти нав</a>@endcan
    </div>
    <div class="card mb-3"><div class="card-body py-2"><form method="GET" action="{{ route('attendance.index') }}" class="row g-2 align-items-center">
        <div class="col-md-2"><input type="date" class="form-control form-control-sm" name="date" value="{{ request('date') }}"></div>
        <div class="col-md-3"><select class="form-select form-select-sm" name="faculty_id"><option value="">Ҳамаи факултетҳо</option>@foreach($faculties as $f)<option value="{{ $f->id }}" {{ request('faculty_id')==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><button type="submit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-search me-1"></i>Филтр</button><a href="{{ route('attendance.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo me-1"></i>Тоза</a></div>
    </form></div></div>
    <div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Сана</th><th>Факултет</th><th>Гурӯҳ</th><th class="text-center">Курс</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th>Масъул</th><th class="text-center">Амалҳо</th></tr></thead>
        <tbody>@forelse($sessions as $i=>$s)<tr>
            <td>{{ $sessions->firstItem()+$i }}</td><td><strong>{{ $s->date->format('d.m.Y') }}</strong></td>
            <td><small>{{ $s->faculty->name }}</small></td><td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $s->group->name }}</span></td>
            <td class="text-center">{{ $s->course->course_number }}</td>
            <td class="text-center"><span class="badge bg-success">{{ $s->present_count }}</span></td>
            <td class="text-center"><span class="badge bg-danger">{{ $s->absent_count }}</span></td>
            <td><small>{{ $s->supervisor->name }}</small></td>
            <td class="text-center">
                <a href="{{ route('attendance.show',$s) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                @can('attendance.edit')<a href="{{ route('attendance.edit',$s) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>@endcan
            </td>
        </tr>@empty<tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-calendar-check fa-2x mb-2 d-block opacity-50"></i>Ҷаласаи ҳозирӣ ёфт нашуд</td></tr>@endforelse</tbody>
    </table></div></div>
    @if($sessions->hasPages())<div class="card-footer bg-white">{{ $sessions->links() }}</div>@endif
    </div>
</div>
@endsection
