@extends('layouts.app')
@section('title', 'Курсҳо')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Рӯйхати курсҳо</h5><small class="text-muted">Идоракунии курсҳои таҳсил</small></div>
        @can('courses.create')<a href="{{ route('courses.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Илова кардан</a>@endcan
    </div>
    <div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Рақам</th><th>Ном</th><th class="text-center">Гурӯҳҳо</th><th class="text-center">Донишҷӯён</th><th class="text-center">Ҳолат</th><th class="text-center">Амалҳо</th></tr></thead>
        <tbody>
            @forelse($courses as $i => $c)
            <tr>
                <td>{{ $courses->firstItem()+$i }}</td>
                <td><span class="badge bg-primary fs-6">{{ $c->course_number }}</span></td>
                <td><strong>{{ $c->name ?? "Курси {$c->course_number}" }}</strong></td>
                <td class="text-center"><span class="badge bg-info">{{ $c->groups_count }}</span></td>
                <td class="text-center"><span class="badge bg-success">{{ $c->students_count }}</span></td>
                <td class="text-center"><span class="badge bg-{{ $c->is_active?'success':'secondary' }}">{{ $c->is_active?'Фаъол':'Ғайрифаъол' }}</span></td>
                <td class="text-center">
                    <a href="{{ route('courses.show',$c) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                    @can('courses.edit')<a href="{{ route('courses.edit',$c) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>@endcan
                    @can('courses.delete')<form action="{{ route('courses.destroy',$c) }}" method="POST" class="d-inline" onsubmit="return confirm('Оё мутмаин ҳастед?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>@endcan
                </td>
            </tr>
            @empty<tr><td colspan="7" class="text-center py-4 text-muted">Курс ёфт нашуд</td></tr>@endforelse
        </tbody>
    </table></div></div>
    @if($courses->hasPages())<div class="card-footer bg-white">{{ $courses->links() }}</div>@endif
    </div>
</div>
@endsection
