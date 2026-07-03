@extends('layouts.app')
@section('title', 'Таҳрири корбар')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-8"><div class="card">
    <div class="card-header bg-warning text-dark"><h6 class="mb-0"><i class="fas fa-edit me-2"></i>Таҳрири корбар: {{ $user->name }}</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('users.update',$user) }}">@csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Ном <span class="text-danger">*</span></label><input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Почтаи электронӣ <span class="text-danger">*</span></label><input type="email" class="form-control" name="email" value="{{ old('email',$user->email) }}" required></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Рамзи нав</label><input type="password" class="form-control" name="password"><small class="text-muted">Холӣ монед агар тағйир надиҳед</small></div>
                <div class="col-md-6 mb-3"><label class="form-label">Тасдиқи рамз</label><input type="password" class="form-control" name="password_confirmation"></div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Телефон</label><input type="text" class="form-control" name="phone" value="{{ old('phone',$user->phone) }}"></div>
                <div class="col-md-4 mb-3"><label class="form-label">Вазифа</label><input type="text" class="form-control" name="position" value="{{ old('position',$user->position) }}"></div>
                <div class="col-md-4 mb-3"><label class="form-label">Нақш <span class="text-danger">*</span></label>
                    <select class="form-select" name="role" required>
                        @foreach($roles as $role)<option value="{{ $role->name }}" {{ $user->hasRole($role->name)?'selected':'' }}>{{ $role->description ?? $role->name }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$user->is_active)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Нигоҳ доштан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
