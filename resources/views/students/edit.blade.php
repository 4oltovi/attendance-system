@extends('layouts.app')
@section('title', 'Таҳрири донишҷӯ')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-10"><div class="card">
    <div class="card-header bg-warning text-dark"><h6 class="mb-0"><i class="fas fa-edit me-2"></i>Таҳрири донишҷӯ: {{ $student->full_name }}</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('students.update',$student) }}">@csrf @method('PUT')
            <h6 class="text-muted mb-3"><i class="fas fa-user me-1"></i>Маълумоти шахсӣ</h6>
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Насаб *</label><input type="text" class="form-control" name="last_name" value="{{ old('last_name',$student->last_name) }}" required></div>
                <div class="col-md-4 mb-3"><label class="form-label">Ном *</label><input type="text" class="form-control" name="first_name" value="{{ old('first_name',$student->first_name) }}" required></div>
                <div class="col-md-4 mb-3"><label class="form-label">Номи падар</label><input type="text" class="form-control" name="middle_name" value="{{ old('middle_name',$student->middle_name) }}"></div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3"><label class="form-label">Рақами донишҷӯ</label><input type="text" class="form-control" name="student_id" value="{{ old('student_id',$student->student_id) }}"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Ҷинс *</label><select class="form-select" name="gender" required><option value="male" {{ old('gender',$student->gender)==='male'?'selected':'' }}>Мард</option><option value="female" {{ old('gender',$student->gender)==='female'?'selected':'' }}>Зан</option></select></div>
                <div class="col-md-3 mb-3"><label class="form-label">Санаи таваллуд</label><input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth',$student->date_of_birth?->format('Y-m-d')) }}"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Телефон</label><input type="text" class="form-control" name="phone" value="{{ old('phone',$student->phone) }}"></div>
            </div>
            <hr><h6 class="text-muted mb-3"><i class="fas fa-graduation-cap me-1"></i>Маълумоти таҳсилӣ</h6>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Факултет *</label><select class="form-select" id="faculty_id" name="faculty_id" required>@foreach($faculties as $f)<option value="{{ $f->id }}" {{ old('faculty_id',$student->faculty_id)==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach</select></div>
                <div class="col-md-6 mb-3"><label class="form-label">Ихтисос *</label><select class="form-select" id="specialty_id" name="specialty_id" required>@foreach($specialties as $s)<option value="{{ $s->id }}" {{ old('specialty_id',$student->specialty_id)==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach</select></div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Курс *</label><select class="form-select" id="course_id" name="course_id" required>@foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id',$student->course_id)==$c->id?'selected':'' }}>{{ $c->display_name }}</option>@endforeach</select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Гурӯҳ *</label><select class="form-select" id="group_id" name="group_id" required>@foreach($groups as $g)<option value="{{ $g->id }}" {{ old('group_id',$student->group_id)==$g->id?'selected':'' }}>{{ $g->name }}</option>@endforeach</select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Соли қабул</label><input type="text" class="form-control" name="enrollment_year" value="{{ old('enrollment_year',$student->enrollment_year) }}"></div>
            </div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$student->is_active)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('students.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Нигоҳ доштан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
@push('scripts')
<script>
document.getElementById('faculty_id').addEventListener('change',function(){fetch(`/api/specialties-by-faculty/${this.value}`).then(r=>r.json()).then(d=>{const s=document.getElementById('specialty_id');s.innerHTML='<option value="">Интихоб...</option>';d.forEach(i=>s.innerHTML+=`<option value="${i.id}">${i.name}</option>`);});});
</script>
@endpush
