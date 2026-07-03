@extends('layouts.app')
@section('title', 'Тағйири рамз')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-key me-2"></i>Тағйири рамз</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <small><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</small><br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-lock me-1 text-muted"></i>Рамзи ҷорӣ
                            </label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="Рамзи ҳозираатонро ворид кунед">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock-open me-1 text-muted"></i>Рамзи нав
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Рамзи навро ворид кунед">
                            <small class="text-muted">Ҳадди ақал 8 рамз бояд дошта бошад</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-double me-1 text-muted"></i>Тасдиқи рамзи нав
                            </label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Рамзи навро такрор кунед">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Тағйир додан
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Баъд аз тағйири рамз, шумо бояд бо рамзи нав ворид шавед.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
