@extends('layouts.app')
@section('title', 'Таҳрири гурӯҳ')
@section('content')
<div class="container-fluid"><div class="row justify-content-center"><div class="col-md-8"><div class="card">
    <div class="card-header bg-warning text-dark"><h6 class="mb-0"><i class="fas fa-edit me-2"></i>Таҳрири гурӯҳ</h6></div>
    <div class="card-body">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('groups.update', $group) }}">@csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Факултет</label><select class="form-select" id="faculty_id" name="faculty_id" required>@foreach($faculties as $f)<option value="{{ $f->id }}" {{ old('faculty_id',$group->faculty_id)==$f->id?'selected':'' }}>{{ $f->name }}</option>@endforeach</select></div>
                <div class="col-md-6 mb-3"><label class="form-label">Ихтисос</label><select class="form-select" id="specialty_id" name="specialty_id" required>@foreach($specialties as $s)<option value="{{ $s->id }}" {{ old('specialty_id',$group->specialty_id)==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach</select></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Курс</label><select class="form-select" name="course_id" required>@foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id',$group->course_id)==$c->id?'selected':'' }}>{{ $c->display_name }}</option>@endforeach</select></div>
                <div class="col-md-6 mb-3"><label class="form-label">Номи гурӯҳ</label><input type="text" class="form-control" name="name" value="{{ old('name',$group->name) }}" required></div>
            </div>
            <div class="mb-3"><label class="form-label">Соли таҳсил</label><input type="text" class="form-control" name="academic_year" value="{{ old('academic_year',$group->academic_year) }}"></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$group->is_active)?'checked':'' }}><label class="form-check-label">Фаъол</label></div></div>
            <div class="d-flex justify-content-between"><a href="{{ route('groups.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a><button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Нигоҳ доштан</button></div>
        </form>
    </div>
</div></div></div></div>
@endsection
@push('scripts')
<script>
document.getElementById('faculty_id').addEventListener('change', function() {
    fetch(`/api/specialties-by-faculty/${this.value}`).then(r=>r.json()).then(d=>{
        const s=document.getElementById('specialty_id');s.innerHTML='<option value="">Интихоб кунед...</option>';
        d.forEach(i=>s.innerHTML+=`<option value="${i.id}">${i.name}</option>`);
    });
});
</script>
@endpush
