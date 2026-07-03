@extends('layouts.app')
@section('title', 'Донишҷӯён')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Рӯйхати донишҷӯён</h5><small class="text-muted">Идоракунии донишҷӯёни муассиса</small></div>
        @can('students.create')<a href="{{ route('students.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Илова кардан</a>@endcan
    </div>
    <div class="card mb-3"><div class="card-body py-2">
        <form method="GET" action="{{ route('students.index') }}" class="row g-2 align-items-center">
            <div class="col-md-3"><input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Ҷустуҷӯ..."></div>
            <div class="col-md-3"><select class="form-select form-select-sm" name="faculty_id"><option value="">Факултет</option>@foreach($faculties as $f)<option value="{{ $f->id }}" {{ request('faculty_id')==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach</select></div>
            <div class="col-md-2"><select class="form-select form-select-sm" name="course_id"><option value="">Курс</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ request('course_id')==$c->id?'selected':'' }}>{{ $c->display_name }}</option>@endforeach</select></div>
            <div class="col-md-2"><select class="form-select form-select-sm" name="status"><option value="">Ҳолат</option><option value="active" {{ request('status')==='active'?'selected':'' }}>Фаъол</option><option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Ғайрифаъол</option></select></div>
            <div class="col-md-2"><button type="submit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-search"></i></button><a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo"></i></a></div>
        </form>
    </div></div>
    <div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Ному насаб</th><th>Факултет</th><th>Гурӯҳ</th><th class="text-center">Курс</th><th class="text-center">Ҷинс</th><th class="text-center">Амалҳо</th></tr></thead>
        <tbody>@forelse($students as $i=>$s)<tr>
            <td>{{ $students->firstItem()+$i }}</td>
            <td><a href="{{ route('students.profile',$s) }}" class="text-decoration-none"><strong>{{ $s->full_name }}</strong></a>@if($s->student_id)<br><small class="text-muted">ID: {{ $s->student_id }}</small>@endif</td>
            <td><small>{{ $s->faculty->name }}</small></td>
            <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $s->group->name }}</span></td>
            <td class="text-center"><span class="badge bg-info">{{ $s->course->course_number }}</span></td>
            <td class="text-center">@if($s->gender==='male')<span class="badge bg-primary"><i class="fas fa-mars"></i></span>@else<span class="badge bg-danger"><i class="fas fa-venus"></i></span>@endif</td>
            <td class="text-center">
                <a href="{{ route('students.profile',$s) }}" class="btn btn-sm btn-outline-success" title="Профил"><i class="fas fa-chart-line"></i></a>
                @can('students.edit')<a href="{{ route('students.edit',$s) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>@endcan
                @can('students.delete')<form action="{{ route('students.destroy',$s) }}" method="POST" class="d-inline" onsubmit="return confirm('Нест мешавад?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>@endcan
            </td>
        </tr>@empty<tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-user-graduate fa-2x mb-2 d-block opacity-50"></i>Донишҷӯ ёфт нашуд</td></tr>@endforelse</tbody>
    </table></div></div>
    @if($students->hasPages())<div class="card-footer bg-white">{{ $students->links() }}</div>@endif
    </div>
</div>
@endsection
