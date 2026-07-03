@extends('layouts.app')
@section('title', 'Илова кардани корбар')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-8"><div class="card">
    <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-plus me-2"></i>Илова кардани корбари нав</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('users.store') }}">@csrf
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Ном <span class="text-danger">*</span></label><input type="text" class="form-control" name="name" value="{{ old('name') }}" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Почтаи электронӣ <span class="text-danger">*</span></label><input type="email" class="form-control" name="email" value="{{ old('email') }}" required></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Рамз <span class="text-danger">*</span></label><input type="password" class="form-control" name="password" required><small class="text-muted">Ҳадди ақал 8 рамз</small></div>
                <div class="col-md-6 mb-3"><label class="form-label">Тасдиқи рамз <span class="text-danger">*</span></label><input type="password" class="form-control" name="password_confirmation" required></div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Телефон</label><input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="+992..."></div>
                <div class="col-md-4 mb-3"><label class="form-label">Вазифа</label><input type="text" class="form-control" name="position" value="{{ old('position') }}"></div>
                <div class="col-md-4 mb-3"><label class="form-label">Нақш <span class="text-danger">*</span></label>
                    <select class="form-select" name="role" required>
                        @foreach($roles as $role)<option value="{{ $role->name }}" {{ old('role')===$role->name?'selected':'' }}>{{ $role->description ?? $role->name }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',true)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Сохтан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
