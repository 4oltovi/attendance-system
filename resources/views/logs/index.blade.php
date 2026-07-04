@extends('layouts.app')
@section('title', 'Гузориши амалҳо')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Гузориши амалҳо</h5><small class="text-muted">Сабти ҳамаи амалҳои корбарон ({{ $totalLogs }} сабт)</small></div>
        @if($totalLogs > 0)
        <form method="POST" action="{{ route('logs.clear') }}" onsubmit="return confirm('Оё мутмаин ҳастед? Ҳамаи {{ $totalLogs }} сабти лог нест мешавад!')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i>Тоза кардани ҳама ({{ $totalLogs }})</button>
        </form>
        @endif
    </div>

    <!-- Filters -->
    <div class="card mb-3"><div class="card-body py-2">
        <form method="GET" action="{{ route('logs.index') }}" class="row g-2 align-items-center">
            <div class="col-md-2">
                <select class="form-select form-select-sm" name="user_id">
                    <option value="">Ҳамаи корбарон</option>
                    @foreach($users as $u)<option value="{{ $u->id }}" {{ request('user_id')==$u->id?'selected':'' }}>{{ $u->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select form-select-sm" name="module">
                    <option value="">Ҳамаи модулҳо</option>
                    @foreach($modules as $key=>$label)<option value="{{ $key }}" {{ request('module')===$key?'selected':'' }}>{{ $label }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select form-select-sm" name="action">
                    <option value="">Ҳамаи амалҳо</option>
                    <option value="create" {{ request('action')==='create'?'selected':'' }}>Сохтан</option>
                    <option value="update" {{ request('action')==='update'?'selected':'' }}>Тағйир</option>
                    <option value="delete" {{ request('action')==='delete'?'selected':'' }}>Нест кардан</option>
                    <option value="login" {{ request('action')==='login'?'selected':'' }}>Воридшавӣ</option>
                    <option value="logout" {{ request('action')==='logout'?'selected':'' }}>Баромадан</option>
                    <option value="attendance" {{ request('action')==='attendance'?'selected':'' }}>Ҳозирӣ</option>
                </select>
            </div>
            <div class="col-md-2"><input type="date" class="form-control form-control-sm" name="date_from" value="{{ request('date_from') }}" placeholder="Аз сана"></div>
            <div class="col-md-2"><input type="date" class="form-control form-control-sm" name="date_to" value="{{ request('date_to') }}" placeholder="То сана"></div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-search"></i></button>
                <a href="{{ route('logs.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div></div>

    <!-- Table -->
    <div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>#</th><th>Корбар</th><th>Амал</th><th>Модул</th><th>Тавсиф</th><th>IP</th><th>Сана ва вақт</th></tr></thead>
        <tbody>
            @forelse($logs as $i => $log)
            @php $actionColors=['create'=>'success','update'=>'warning','delete'=>'danger','login'=>'info','logout'=>'secondary','attendance'=>'primary']; @endphp
            <tr>
                <td>{{ $logs->firstItem()+$i }}</td>
                <td>@if($log->user)<small><strong>{{ $log->user->name }}</strong></small>@else<small class="text-muted">Система</small>@endif</td>
                <td><span class="badge bg-{{ $actionColors[$log->action] ?? 'secondary' }}">{{ $log->action_label }}</span></td>
                <td><small>{{ $log->module_label }}</small></td>
                <td><small>{{ Str::limit($log->description, 60) }}</small></td>
                <td><small class="text-muted">{{ $log->ip_address }}</small></td>
                <td><small>{{ $log->created_at->format('d.m.Y H:i') }}</small></td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-history fa-2x mb-2 d-block opacity-50"></i>Сабт мавҷуд нест</td></tr>
            @endforelse
        </tbody>
    </table></div></div>
    @if($logs->hasPages())<div class="card-footer bg-white">{{ $logs->links() }}</div>@endif
    </div>
</div>
@endsection
