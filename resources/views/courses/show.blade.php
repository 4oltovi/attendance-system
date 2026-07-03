@extends('layouts.app')
@section('title', 'Курс: ' . ($course->name ?? "Курси {$course->course_number}"))
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">{{ $course->display_name }}</h5><small class="text-muted">{{ $course->description }}</small></div>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-6"><div class="card text-center"><div class="card-body"><i class="fas fa-users fa-2x text-primary mb-2"></i><h4>{{ $course->groups_count }}</h4><p class="text-muted mb-0">Гурӯҳҳо</p></div></div></div>
        <div class="col-md-6"><div class="card text-center"><div class="card-body"><i class="fas fa-user-graduate fa-2x text-success mb-2"></i><h4>{{ $course->students_count }}</h4><p class="text-muted mb-0">Донишҷӯён</p></div></div></div>
    </div>
</div>
@endsection
