@extends('layouts.app')
@section('title', 'Илова кардани курс')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-8"><div class="card">
    <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-plus me-2"></i>Илова кардани курси нав</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('courses.store') }}">@csrf
            <div class="mb-3"><label class="form-label">Рақами курс <span class="text-danger">*</span></label><input type="number" class="form-control" name="course_number" value="{{ old('course_number') }}" min="1" max="10" required></div>
            <div class="mb-3"><label class="form-label">Ном (ихтиёрӣ)</label><input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Масалан: Курси 1"></div>
            <div class="mb-3"><label class="form-label">Тавсиф</label><textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',true)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('courses.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Сохтан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
