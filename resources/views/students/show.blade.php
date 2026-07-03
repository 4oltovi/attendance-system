@extends('layouts.app')
@section('title', 'Донишҷӯ: ' . $student->full_name)
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">{{ $student->full_name }}</h5><small class="text-muted">{{ $student->faculty->name }} / {{ $student->group->name }}</small></div>
        <div>
            <a href="{{ route('students.profile',$student) }}" class="btn btn-success btn-sm me-1"><i class="fas fa-chart-line me-1"></i>Профили ҳозирӣ</a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><th class="text-muted" width="40%">Насаб:</th><td><strong>{{ $student->last_name }}</strong></td></tr>
                        <tr><th class="text-muted">Ном:</th><td><strong>{{ $student->first_name }}</strong></td></tr>
                        <tr><th class="text-muted">Номи падар:</th><td>{{ $student->middle_name ?? '-' }}</td></tr>
                        <tr><th class="text-muted">Ҷинс:</th><td>@if($student->gender==='male')<span class="badge bg-primary"><i class="fas fa-mars me-1"></i>Мард</span>@else<span class="badge bg-danger"><i class="fas fa-venus me-1"></i>Зан</span>@endif</td></tr>
                        <tr><th class="text-muted">Санаи таваллуд:</th><td>{{ $student->date_of_birth?->format('d.m.Y') ?? '-' }}</td></tr>
                        <tr><th class="text-muted">Телефон:</th><td>{{ $student->phone ?? '-' }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><th class="text-muted" width="40%">Рақами донишҷӯ:</th><td>{{ $student->student_id ?? '<span class="text-muted">Таъин нашудааст</span>' }}</td></tr>
                        <tr><th class="text-muted">Факултет:</th><td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $student->faculty->name }}</span></td></tr>
                        <tr><th class="text-muted">Ихтисос:</th><td>{{ $student->specialty->name }}</td></tr>
                        <tr><th class="text-muted">Курс:</th><td><span class="badge bg-info">{{ $student->course->display_name }}</span></td></tr>
                        <tr><th class="text-muted">Гурӯҳ:</th><td><span class="badge bg-success">{{ $student->group->name }}</span></td></tr>
                        <tr><th class="text-muted">Соли қабул:</th><td>{{ $student->enrollment_year ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
