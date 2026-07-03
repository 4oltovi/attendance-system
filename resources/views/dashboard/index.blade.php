@extends('layouts.app')

@section('title', 'Панели идоракунӣ')

@section('content')
<div class="container-fluid">
    <!-- Top Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-user-graduate stat-icon"></i>
                <div class="stat-value">{{ number_format($totalStudents) }}</div>
                <div class="stat-label">Ҳамаи донишҷӯён</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-university stat-icon"></i>
                <div class="stat-value">{{ $totalFaculties }}</div>
                <div class="stat-label">Факултетҳо</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-book-open stat-icon"></i>
                <div class="stat-value">{{ $totalSpecialties }}</div>
                <div class="stat-label">Ихтисосҳо</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-value">{{ $totalGroups }}</div>
                <div class="stat-label">Гурӯҳҳо</div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance Stats -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                        <i class="fas fa-check text-success"></i>
                    </div>
                    <h3 class="text-success mb-1">{{ $todayPresent }}</h3>
                    <p class="text-muted mb-0 small">Имрӯз ҳозир</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                        <i class="fas fa-times text-danger"></i>
                    </div>
                    <h3 class="text-danger mb-1">{{ $todayAbsent }}</h3>
                    <p class="text-muted mb-0 small">Имрӯз ғоиб</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                        <i class="fas fa-file-alt text-warning"></i>
                    </div>
                    <h3 class="text-warning mb-1">{{ $todayExcused }}</h3>
                    <p class="text-muted mb-0 small">Сабабнок</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                        <i class="fas fa-clock text-info"></i>
                    </div>
                    <h3 class="text-info mb-1">{{ $todayLate }}</h3>
                    <p class="text-muted mb-0 small">Дер омад</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Percentage & Recent Sessions -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-percentage me-2 text-primary"></i>Фоизи ҳозирии имрӯз</h6>
                </div>
                <div class="card-body text-center py-4">
                    <div class="position-relative d-inline-block">
                        <svg viewBox="0 0 36 36" style="width: 130px; height: 130px; transform: rotate(-90deg);">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                  fill="none" stroke="#e9ecef" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                  fill="none" stroke="{{ $todayPercentage >= 80 ? '#22c55e' : ($todayPercentage >= 60 ? '#f59e0b' : '#ef4444') }}"
                                  stroke-width="3" stroke-dasharray="{{ $todayPercentage }}, 100"/>
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <strong class="fs-3">{{ $todayPercentage }}%</strong>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">Аз {{ $todayTotal }} донишҷӯи сабтшуда</p>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Ҷаласаҳои охирин</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Сана</th>
                                    <th>Гурӯҳ</th>
                                    <th>Факултет</th>
                                    <th>Масъул</th>
                                    <th class="text-center">Ҳозир/Ғоиб</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSessions as $session)
                                <tr>
                                    <td><small>{{ $session->date->format('d.m.Y') }}</small></td>
                                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $session->group->name ?? '-' }}</span></td>
                                    <td><small>{{ $session->faculty->name ?? '-' }}</small></td>
                                    <td><small>{{ $session->supervisor->name ?? '-' }}</small></td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $session->present_count }}</span>
                                        <span class="badge bg-danger">{{ $session->absent_count }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-check fa-2x mb-2 d-block opacity-50"></i>
                                        Ҳанӯз ҷаласаи ҳозирӣ сабт нашудааст
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
