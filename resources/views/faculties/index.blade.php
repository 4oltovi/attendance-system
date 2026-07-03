@extends('layouts.app')

@section('title', 'Факултетҳо')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">Рӯйхати факултетҳо</h5>
            <small class="text-muted">Идоракунии факултетҳои муассиса</small>
        </div>
        @can('faculties.create')
        <a href="{{ route('faculties.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Илова кардан
        </a>
        @endcan
    </div>

    <!-- Filters -->
    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('faculties.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" name="search"
                           value="{{ request('search') }}" placeholder="Ҷустуҷӯ бо ном...">
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm" name="status">
                        <option value="">Ҳамаи ҳолатҳо</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Фаъол</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Ғайрифаъол</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-sm btn-outline-primary me-1">
                        <i class="fas fa-search me-1"></i>Ҷустуҷӯ
                    </button>
                    <a href="{{ route('faculties.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-redo me-1"></i>Тоза кардан
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Номи факултет</th>
                            <th class="text-center">Ихтисосҳо</th>
                            <th class="text-center">Гурӯҳҳо</th>
                            <th class="text-center">Донишҷӯён</th>
                            <th class="text-center">Ҳолат</th>
                            <th class="text-center" style="width: 150px;">Амалҳо</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faculties as $index => $faculty)
                        <tr>
                            <td>{{ $faculties->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $faculty->name }}</strong>
                                @if($faculty->description)
                                    <br><small class="text-muted">{{ Str::limit($faculty->description, 50) }}</small>
                                @endif
                            </td>
                            <td class="text-center"><span class="badge bg-info">{{ $faculty->specialties_count }}</span></td>
                            <td class="text-center"><span class="badge bg-primary">{{ $faculty->groups_count }}</span></td>
                            <td class="text-center"><span class="badge bg-success">{{ $faculty->students_count }}</span></td>
                            <td class="text-center">
                                @if($faculty->is_active)
                                    <span class="badge bg-success">Фаъол</span>
                                @else
                                    <span class="badge bg-secondary">Ғайрифаъол</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('faculties.show', $faculty) }}" class="btn btn-sm btn-outline-info" title="Дидан">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('faculties.edit')
                                <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-sm btn-outline-warning" title="Таҳрир">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('faculties.delete')
                                <form action="{{ route('faculties.destroy', $faculty) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Оё мутмаин ҳастед?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Нест кардан">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-university fa-2x mb-2 d-block opacity-50"></i>
                                Факултет ёфт нашуд
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($faculties->hasPages())
        <div class="card-footer bg-white">
            {{ $faculties->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
