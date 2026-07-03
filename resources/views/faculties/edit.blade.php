@extends('layouts.app')

@section('title', 'Таҳрири факултет')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Таҳрири факултет</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('faculties.update', $faculty) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Номи факултет <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $faculty->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Тавсиф</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $faculty->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $faculty->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Фаъол</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('faculties.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Бозгашт</a>
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Нигоҳ доштан</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
