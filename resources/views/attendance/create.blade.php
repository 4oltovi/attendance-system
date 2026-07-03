@extends('layouts.app')
@section('title', 'Сабти ҳозирӣ')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Сабти ҳозирии донишҷӯён</h6></div>
        <div class="card-body">
            <form id="attendanceForm" method="POST" action="{{ route('attendance.store') }}">@csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-2"><label class="form-label">Сана *</label><input type="date" class="form-control" name="date" id="att_date" value="{{ date('Y-m-d') }}" required></div>
                    <div class="col-md-3"><label class="form-label">Факултет *</label><select class="form-select" name="faculty_id" id="att_faculty" required><option value="">Интихоб...</option>@foreach($faculties as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach</select></div>
                    <div class="col-md-2"><label class="form-label">Ихтисос *</label><select class="form-select" name="specialty_id" id="att_specialty" required><option value="">Аввал факултет</option></select></div>
                    <div class="col-md-2"><label class="form-label">Курс *</label><select class="form-select" name="course_id" id="att_course" required><option value="">Интихоб...</option>@foreach($courses as $c)<option value="{{ $c->id }}">{{ $c->display_name }}</option>@endforeach</select></div>
                    <div class="col-md-2"><label class="form-label">Гурӯҳ *</label><select class="form-select" name="group_id" id="att_group" required><option value="">Аввал ихтисос</option></select></div>
                    <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-info w-100" id="loadStudents"><i class="fas fa-search"></i></button></div>
                </div>
                <div id="studentListContainer" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0"><i class="fas fa-users me-2"></i>Донишҷӯён</h6>
                        <div><button type="button" class="btn btn-sm btn-success me-1" id="markAllPresent"><i class="fas fa-check-double me-1"></i>Ҳамаро ҳозир</button><button type="button" class="btn btn-sm btn-danger" id="markAllAbsent"><i class="fas fa-times me-1"></i>Ҳамаро ғоиб</button></div>
                    </div>
                    <div class="table-responsive"><table class="table table-bordered"><thead class="table-light"><tr><th>#</th><th>Ному насаб</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th class="text-center">Сабабнок</th><th class="text-center">Дер омад</th></tr></thead><tbody id="studentTableBody"></tbody></table></div>
                    <div class="d-flex justify-content-between mt-3">
                        <div><span class="badge bg-success me-1" id="countPresent">Ҳозир: 0</span><span class="badge bg-danger me-1" id="countAbsent">Ғоиб: 0</span><span class="badge bg-warning me-1" id="countExcused">Сабабнок: 0</span><span class="badge bg-info" id="countLate">Дер: 0</span></div>
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Сабт кардан</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('att_faculty').addEventListener('change', function(){
    fetch(`/api/specialties-by-faculty/${this.value}`).then(r=>r.json()).then(d=>{const s=document.getElementById('att_specialty');s.innerHTML='<option value="">Интихоб...</option>';d.forEach(i=>s.innerHTML+=`<option value="${i.id}">${i.name}</option>`);});
});
function loadGroups(){const f=document.getElementById('att_faculty').value,s=document.getElementById('att_specialty').value,c=document.getElementById('att_course').value;if(f&&s&&c){fetch(`/api/groups-filter?faculty_id=${f}&specialty_id=${s}&course_id=${c}`).then(r=>r.json()).then(d=>{const g=document.getElementById('att_group');g.innerHTML='<option value="">Интихоб...</option>';d.forEach(i=>g.innerHTML+=`<option value="${i.id}">${i.name}</option>`);});}}
document.getElementById('att_specialty').addEventListener('change',loadGroups);
document.getElementById('att_course').addEventListener('change',loadGroups);
document.getElementById('loadStudents').addEventListener('click',function(){
    const gId=document.getElementById('att_group').value;if(!gId){alert('Гурӯҳро интихоб кунед!');return;}
    fetch(`/api/students-by-group/${gId}`).then(r=>r.json()).then(students=>{
        const tbody=document.getElementById('studentTableBody');tbody.innerHTML='';
        students.forEach((s,i)=>{tbody.innerHTML+=`<tr><td>${i+1}</td><td><strong>${s.full_name}</strong><input type="hidden" name="attendance[${i}][student_id]" value="${s.id}"></td><td class="text-center"><input type="radio" class="btn-check" name="attendance[${i}][status]" id="p_${i}" value="present" checked><label class="btn btn-sm btn-outline-success" for="p_${i}"><i class="fas fa-check"></i></label></td><td class="text-center"><input type="radio" class="btn-check" name="attendance[${i}][status]" id="a_${i}" value="absent"><label class="btn btn-sm btn-outline-danger" for="a_${i}"><i class="fas fa-times"></i></label></td><td class="text-center"><input type="radio" class="btn-check" name="attendance[${i}][status]" id="e_${i}" value="excused"><label class="btn btn-sm btn-outline-warning" for="e_${i}"><i class="fas fa-file-alt"></i></label></td><td class="text-center"><input type="radio" class="btn-check" name="attendance[${i}][status]" id="l_${i}" value="late"><label class="btn btn-sm btn-outline-info" for="l_${i}"><i class="fas fa-clock"></i></label></td></tr>`;});
        document.getElementById('studentListContainer').style.display='block';updateCounts();
        document.querySelectorAll('input[type="radio"]').forEach(r=>r.addEventListener('change',updateCounts));
    });
});
document.getElementById('markAllPresent').addEventListener('click',()=>{document.querySelectorAll('input[value="present"]').forEach(r=>r.checked=true);updateCounts();});
document.getElementById('markAllAbsent').addEventListener('click',()=>{document.querySelectorAll('input[value="absent"]').forEach(r=>r.checked=true);updateCounts();});
function updateCounts(){document.getElementById('countPresent').textContent=`Ҳозир: ${document.querySelectorAll('input[value="present"]:checked').length}`;document.getElementById('countAbsent').textContent=`Ғоиб: ${document.querySelectorAll('input[value="absent"]:checked').length}`;document.getElementById('countExcused').textContent=`Сабабнок: ${document.querySelectorAll('input[value="excused"]:checked').length}`;document.getElementById('countLate').textContent=`Дер: ${document.querySelectorAll('input[value="late"]:checked').length}`;}
</script>
@endpush
