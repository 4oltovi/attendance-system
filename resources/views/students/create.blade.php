@extends('layouts.app')
@section('title', 'Илова кардани донишҷӯ')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-10"><div class="card">
    <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-plus me-2"></i>Илова кардани донишҷӯи нав</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('students.store') }}">@csrf
            <h6 class="text-muted mb-3"><i class="fas fa-user me-1"></i>Маълумоти шахсӣ</h6>
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Насаб *</label><input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required></div>
                <div class="col-md-4 mb-3"><label class="form-label">Ном *</label><input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required></div>
                <div class="col-md-4 mb-3"><label class="form-label">Номи падар</label><input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}"></div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3"><label class="form-label">Рақами донишҷӯ</label><input type="text" class="form-control" name="student_id" value="{{ old('student_id') }}"><small class="text-muted">Ихтиёрӣ</small></div>
                <div class="col-md-3 mb-3"><label class="form-label">Ҷинс *</label><select class="form-select" name="gender" required><option value="male" {{ old('gender')==='male'?'selected':'' }}>Мард</option><option value="female" {{ old('gender')==='female'?'selected':'' }}>Зан</option></select></div>
                <div class="col-md-3 mb-3"><label class="form-label">Санаи таваллуд</label><input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}"></div>
                <div class="col-md-3 mb-3"><label class="form-label">Телефон</label><input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="+992..."></div>
            </div>
            <hr><h6 class="text-muted mb-3"><i class="fas fa-graduation-cap me-1"></i>Маълумоти таҳсилӣ</h6>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Факултет *</label><select class="form-select" id="faculty_id" name="faculty_id" required><option value="">Интихоб...</option>@foreach($faculties as $f)<option value="{{ $f->id }}" {{ old('faculty_id')==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach</select></div>
                <div class="col-md-6 mb-3"><label class="form-label">Ихтисос *</label><select class="form-select" id="specialty_id" name="specialty_id" required><option value="">Аввал факултет...</option></select></div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Курс *</label><select class="form-select" id="course_id" name="course_id" required><option value="">Интихоб...</option>@foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id')==$c->id?'selected':'' }}>{{ $c->display_name }}</option>@endforeach</select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Гурӯҳ *</label><select class="form-select" id="group_id" name="group_id" required><option value="">Аввал ихтисос...</option></select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Соли қабул</label><input type="text" class="form-control" name="enrollment_year" value="{{ old('enrollment_year',date('Y')) }}"></div>
            </div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',true)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('students.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Сохтан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
@push('scripts')
<script>
document.getElementById('faculty_id').addEventListener('change',function(){fetch(`/api/specialties-by-faculty/${this.value}`).then(r=>r.json()).then(d=>{const s=document.getElementById('specialty_id');s.innerHTML='<option value="">Интихоб...</option>';d.forEach(i=>s.innerHTML+=`<option value="${i.id}">${i.name}</option>`);});});
function loadGroups(){const f=document.getElementById('faculty_id').value,s=document.getElementById('specialty_id').value,c=document.getElementById('course_id').value;if(f&&s&&c)fetch(`/api/groups-filter?faculty_id=${f}&specialty_id=${s}&course_id=${c}`).then(r=>r.json()).then(d=>{const g=document.getElementById('group_id');g.innerHTML='<option value="">Интихоб...</option>';d.forEach(i=>g.innerHTML+=`<option value="${i.id}">${i.name}</option>`);});}
document.getElementById('specialty_id').addEventListener('change',loadGroups);
document.getElementById('course_id').addEventListener('change',loadGroups);
</script>
@endpush
