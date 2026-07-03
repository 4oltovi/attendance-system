@extends('layouts.app')

@section('title', 'Ихтисосҳо')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Рӯйхати ихтисосҳо</h5><small class="text-muted">Идоракунии ихтисосҳо</small></div>
        @can('specialties.create')
        <a href="{{ route('specialties.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Илова кардан</a>
        @endcan
    </div>

    <div class="card mb-3"><div class="card-body py-2">
        <form method="GET" action="{{ route('specialties.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4"><input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Ҷустуҷӯ..."></div>
            <div class="col-md-4">
                <select class="form-select form-select-sm" name="faculty_id">
                    <option value="">Ҳамаи факултетҳо</option>
                    @foreach($faculties as $f)<option value="{{ $f->id }}" {{ request('faculty_id')==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-search me-1"></i>Ҷустуҷӯ</button>
                <a href="{{ route('specialties.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo me-1"></i>Тоза</a>
            </div>
        </form>
    </div></div>

    <div class="card"><div class="card-body p-0"><div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>#</th><th>Номи ихтисос</th><th>Факултет</th><th class="text-center">Гурӯҳҳо</th><th class="text-center">Донишҷӯён</th><th class="text-center">Ҳолат</th><th class="text-center">Амалҳо</th></tr></thead>
            <tbody>
                @forelse($specialties as $i => $s)
                <tr>
                    <td>{{ $specialties->firstItem() + $i }}</td>
                    <td><strong>{{ $s->name }}</strong></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $s->faculty->name }}</span></td>
                    <td class="text-center"><span class="badge bg-info">{{ $s->groups_count }}</span></td>
                    <td class="text-center"><span class="badge bg-success">{{ $s->students_count }}</span></td>
                    <td class="text-center"><span class="badge bg-{{ $s->is_active?'success':'secondary' }}">{{ $s->is_active?'Фаъол':'Ғайрифаъол' }}</span></td>
                    <td class="text-center">
                        <a href="{{ route('specialties.show',$s) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                        @can('specialties.edit')<a href="{{ route('specialties.edit',$s) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>@endcan
                        @can('specialties.delete')<form action="{{ route('specialties.destroy',$s) }}" method="POST" class="d-inline" onsubmit="return confirm('Оё мутмаин ҳастед?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>@endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-book-open fa-2x mb-2 d-block opacity-50"></i>Ихтисос ёфт нашуд</td></tr>
                @endforelse
            </tbody>
        </table>
    </div></div>
    @if($specialties->hasPages())<div class="card-footer bg-white">{{ $specialties->links() }}</div>@endif
    </div>
</div>
@endsection
