@extends('layouts.app')
@section('title', 'Корбарон')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Идоракунии корбарон</h5><small class="text-muted">Корбарони система</small></div>
        <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Илова кардан</a>
    </div>

    <!-- Filters -->
    <div class="card mb-3"><div class="card-body py-2">
        <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4"><input type="text" class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Ном ё почта..."></div>
            <div class="col-md-3">
                <select class="form-select form-select-sm" name="role">
                    <option value="">Ҳамаи нақшҳо</option>
                    @foreach($roles as $role)<option value="{{ $role->name }}" {{ request('role')===$role->name?'selected':'' }}>{{ $role->description ?? $role->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-search me-1"></i>Ҷустуҷӯ</button>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo me-1"></i>Тоза</a>
            </div>
        </form>
    </div></div>

    <!-- Table -->
    <div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Ном</th><th>Почта</th><th>Нақш</th><th>Вазифа</th><th class="text-center">Ҳолат</th><th class="text-center">Амалҳо</th></tr></thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td>{{ $users->firstItem()+$i }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td><small>{{ $user->email }}</small></td>
                <td>@foreach($user->roles as $role)<span class="badge bg-primary">{{ $role->description ?? $role->name }}</span>@endforeach</td>
                <td><small>{{ $user->position ?? '-' }}</small></td>
                <td class="text-center"><span class="badge bg-{{ $user->is_active?'success':'secondary' }}">{{ $user->is_active?'Фаъол':'Ғайрифаъол' }}</span></td>
                <td class="text-center">
                    <a href="{{ route('users.edit',$user) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy',$user) }}" method="POST" class="d-inline" onsubmit="return confirm('Оё мутмаин ҳастед?')">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-user-cog fa-2x mb-2 d-block opacity-50"></i>Корбар ёфт нашуд</td></tr>
            @endforelse
        </tbody>
    </table></div></div>
    @if($users->hasPages())<div class="card-footer bg-white">{{ $users->links() }}</div>@endif
    </div>
</div>
@endsection
