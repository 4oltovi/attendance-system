@extends('layouts.app')
@section('title', 'Гурӯҳҳо')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Рӯйхати гурӯҳҳо</h5><small class="text-muted">Идоракунии гурӯҳҳои таҳсилӣ</small></div>
        @can('groups.create')<a href="{{ route('groups.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Илова кардан</a>@endcan
    </div>
    <div class="card mb-3"><div class="card-body py-2">
        <form method="GET" action="{{ route('groups.index') }}" class="row g-2 align-items-center">
            <div class="col-md-3"><input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Ном..."></div>
            <div class="col-md-3"><select class="form-select form-select-sm" name="faculty_id"><option value="">Ҳамаи факултетҳо</option>@foreach($faculties as $f)<option value="{{ $f->id }}" {{ request('faculty_id')==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><select class="form-select form-select-sm" name="course_id"><option value="">Ҳамаи курсҳо</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ request('course_id')==$c->id?'selected':'' }}>{{ $c->display_name }}</option>@endforeach</select></div>
            <div class="col-md-3"><button type="submit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-search"></i></button><a href="{{ route('groups.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo"></i></a></div>
        </form>
    </div></div>
    <div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Гурӯҳ</th><th>Факултет</th><th>Ихтисос</th><th class="text-center">Курс</th><th class="text-center">Донишҷӯён</th><th class="text-center">Ҳолат</th><th class="text-center">Амалҳо</th></tr></thead>
        <tbody>@forelse($groups as $i=>$g)<tr>
            <td>{{ $groups->firstItem()+$i }}</td>
            <td><strong>{{ $g->name }}</strong>@if($g->academic_year)<br><small class="text-muted">{{ $g->academic_year }}</small>@endif</td>
            <td><small>{{ $g->faculty->name }}</small></td><td><small>{{ $g->specialty->name }}</small></td>
            <td class="text-center"><span class="badge bg-primary">{{ $g->course->course_number }}</span></td>
            <td class="text-center"><span class="badge bg-success">{{ $g->students_count }}</span></td>
            <td class="text-center"><span class="badge bg-{{ $g->is_active?'success':'secondary' }}">{{ $g->is_active?'Фаъол':'Ғайрифаъол' }}</span></td>
            <td class="text-center">
                <a href="{{ route('groups.show',$g) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                @can('groups.edit')<a href="{{ route('groups.edit',$g) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>@endcan
                @can('groups.delete')<form action="{{ route('groups.destroy',$g) }}" method="POST" class="d-inline" onsubmit="return confirm('Нест мешавад?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>@endcan
            </td>
        </tr>@empty<tr><td colspan="8" class="text-center py-4 text-muted">Гурӯҳ ёфт нашуд</td></tr>@endforelse</tbody>
    </table></div></div>
    @if($groups->hasPages())<div class="card-footer bg-white">{{ $groups->links() }}</div>@endif
    </div>
</div>
@endsection
