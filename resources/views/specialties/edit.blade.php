@extends('layouts.app')
@section('title', 'Таҳрири ихтисос')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-8"><div class="card">
    <div class="card-header bg-warning text-dark"><h6 class="mb-0"><i class="fas fa-edit me-2"></i>Таҳрири ихтисос</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('specialties.update', $specialty) }}">@csrf @method('PUT')
            <div class="mb-3"><label class="form-label">Факултет <span class="text-danger">*</span></label>
                <select class="form-select" name="faculty_id" required>@foreach($faculties as $f)<option value="{{ $f->id }}" {{ old('faculty_id',$specialty->faculty_id)==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label">Номи ихтисос <span class="text-danger">*</span></label><input type="text" class="form-control" name="name" value="{{ old('name',$specialty->name) }}" required></div>
            <div class="mb-3"><label class="form-label">Тавсиф</label><textarea class="form-control" name="description" rows="3">{{ old('description',$specialty->description) }}</textarea></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$specialty->is_active)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('specialties.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Нигоҳ доштан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
