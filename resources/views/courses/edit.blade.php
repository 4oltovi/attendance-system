@extends('layouts.app')
@section('title', 'Таҳрири курс')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-8"><div class="card">
    <div class="card-header bg-warning text-dark"><h6 class="mb-0"><i class="fas fa-edit me-2"></i>Таҳрири курс</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('courses.update', $course) }}">@csrf @method('PUT')
            <div class="mb-3"><label class="form-label">Рақами курс <span class="text-danger">*</span></label><input type="number" class="form-control" name="course_number" value="{{ old('course_number',$course->course_number) }}" min="1" max="10" required></div>
            <div class="mb-3"><label class="form-label">Ном</label><input type="text" class="form-control" name="name" value="{{ old('name',$course->name) }}"></div>
            <div class="mb-3"><label class="form-label">Тавсиф</label><textarea class="form-control" name="description" rows="3">{{ old('description',$course->description) }}</textarea></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$course->is_active)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('courses.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Нигоҳ доштан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
