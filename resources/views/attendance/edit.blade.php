@extends('layouts.app')
@section('title', 'Таҳрири ҳозирӣ')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h5 class="mb-1">Таҳрири ҳозирӣ - {{ $attendance->date->format('d.m.Y') }}</h5><small class="text-muted">{{ $attendance->faculty->name }} / {{ $attendance->group->name }}</small></div>
        <a href="{{ route('attendance.show',$attendance) }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Бозгашт</a>
    </div>
    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('attendance.update',$attendance) }}">@csrf @method('PUT')
            <div class="table-responsive"><table class="table table-bordered">
                <thead class="table-light"><tr><th>#</th><th>Ному насаб</th><th class="text-center">Ҳозир</th><th class="text-center">Ғоиб</th><th class="text-center">Сабабнок</th><th class="text-center">Дер</th></tr></thead>
                <tbody>@foreach($attendance->records as $i=>$r)<tr>
                    <td>{{ $i+1 }}</td><td><strong>{{ $r->student->full_name }}</strong><input type="hidden" name="attendance[{{ $i }}][record_id]" value="{{ $r->id }}"></td>
                    <td class="text-center"><input type="radio" class="btn-check" name="attendance[{{ $i }}][status]" id="p_{{ $i }}" value="present" {{ $r->status==='present'?'checked':'' }}><label class="btn btn-sm btn-outline-success" for="p_{{ $i }}"><i class="fas fa-check"></i></label></td>
                    <td class="text-center"><input type="radio" class="btn-check" name="attendance[{{ $i }}][status]" id="a_{{ $i }}" value="absent" {{ $r->status==='absent'?'checked':'' }}><label class="btn btn-sm btn-outline-danger" for="a_{{ $i }}"><i class="fas fa-times"></i></label></td>
                    <td class="text-center"><input type="radio" class="btn-check" name="attendance[{{ $i }}][status]" id="e_{{ $i }}" value="excused" {{ $r->status==='excused'?'checked':'' }}><label class="btn btn-sm btn-outline-warning" for="e_{{ $i }}"><i class="fas fa-file-alt"></i></label></td>
                    <td class="text-center"><input type="radio" class="btn-check" name="attendance[{{ $i }}][status]" id="l_{{ $i }}" value="late" {{ $r->status==='late'?'checked':'' }}><label class="btn btn-sm btn-outline-info" for="l_{{ $i }}"><i class="fas fa-clock"></i></label></td>
                </tr>@endforeach</tbody>
            </table></div>
            <div class="text-end"><button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Нигоҳ доштан</button></div>
        </form>
    </div></div>
</div>
@endsection
