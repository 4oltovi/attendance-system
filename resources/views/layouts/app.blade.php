<!DOCTYPE html>
<html lang="tj"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="csrf-token" content="{{ csrf_token() }}"><meta name="theme-color" content="#1a1f36">
<title>@yield('title','Панели идоракунӣ') - Системаи Ҳозирӣ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root{--sidebar-width:260px}
*{transition:all .2s ease}
body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background:#f0f2f5;overflow-x:hidden}

/* Sidebar */
.sidebar{position:fixed;top:0;left:0;width:var(--sidebar-width);height:100vh;background:linear-gradient(180deg,#1a1f36 0%,#1e293b 100%);z-index:1050;overflow-y:auto;box-shadow:4px 0 15px rgba(0,0,0,.1);transition:transform .3s ease}
.sidebar::-webkit-scrollbar{width:4px}
.sidebar::-webkit-scrollbar-thumb{background:#475569;border-radius:4px}
.sidebar-header{padding:25px 20px;text-align:center;border-bottom:1px solid rgba(255,255,255,.08);background:rgba(255,255,255,.02)}
.sidebar-header h5{color:white;font-weight:700;margin:0;font-size:.9rem;letter-spacing:.5px}
.sidebar-header i{background:linear-gradient(135deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;filter:drop-shadow(0 2px 4px rgba(96,165,250,.3))}
.sidebar-menu{padding:15px 0}
.sidebar-menu .menu-label{color:#64748b;font-size:.65rem;text-transform:uppercase;letter-spacing:1.5px;padding:15px 20px 5px;font-weight:700}
.sidebar-menu a{display:flex;align-items:center;padding:11px 20px;color:#94a3b8;text-decoration:none;font-size:.85rem;border-left:3px solid transparent;margin:1px 0;position:relative;overflow:hidden}
.sidebar-menu a::before{content:'';position:absolute;left:0;top:0;width:100%;height:100%;background:linear-gradient(90deg,rgba(96,165,250,.1),transparent);opacity:0;transition:.3s}
.sidebar-menu a:hover::before{opacity:1}
.sidebar-menu a:hover{color:#e2e8f0;border-left-color:#60a5fa;transform:translateX(3px)}
.sidebar-menu a.active{background:rgba(59,130,246,.1);color:#fff;border-left-color:#3b82f6;font-weight:500}
.sidebar-menu a.active::after{content:'';position:absolute;right:15px;width:6px;height:6px;background:#3b82f6;border-radius:50%}
.sidebar-menu a i{width:20px;margin-right:12px;text-align:center;font-size:.8rem}

/* Overlay */
.sidebar-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1040;backdrop-filter:blur(2px);opacity:0;transition:opacity .3s}
.sidebar-overlay.active{display:block;opacity:1}

/* Main */
.main-content{margin-left:var(--sidebar-width);min-height:100vh}
.topbar{height:65px;background:white;box-shadow:0 2px 10px rgba(0,0,0,.04);display:flex;align-items:center;justify-content:space-between;padding:0 20px;position:sticky;top:0;z-index:999;border-bottom:1px solid #e5e7eb}
.content-area{padding:25px 30px}

/* Mobile Menu Button */
.mobile-menu-btn{display:none;background:none;border:none;font-size:1.4rem;color:#374151;padding:8px;border-radius:8px;margin-right:12px;cursor:pointer}
.mobile-menu-btn:hover{background:#f3f4f6}
.mobile-menu-btn:active{background:#e5e7eb}

/* Cards */
.card{border:none;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.04);transition:transform .2s,box-shadow .2s}
.card:hover{box-shadow:0 4px 20px rgba(0,0,0,.08)}
.card-header{border-bottom:1px solid #f1f5f9}

/* Stat Cards */
.stat-card{border-radius:14px;padding:22px;color:white;position:relative;overflow:hidden;transition:transform .3s,box-shadow .3s}
.stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 25px rgba(0,0,0,.15)}
.stat-card::after{content:'';position:absolute;top:-50%;right:-50%;width:100%;height:100%;background:rgba(255,255,255,.05);border-radius:50%;transform:rotate(45deg)}
.stat-card .stat-icon{position:absolute;right:15px;top:15px;font-size:2.8rem;opacity:.15}
.stat-card .stat-value{font-size:2rem;font-weight:800;text-shadow:0 2px 4px rgba(0,0,0,.1)}
.stat-card .stat-label{font-size:.82rem;opacity:.9;margin-top:3px}

/* Tables */
.table{font-size:.87rem}
.table th{font-weight:600;color:#475569;text-transform:uppercase;font-size:.75rem;letter-spacing:.5px;padding:12px 16px;border-bottom:2px solid #e2e8f0}
.table td{padding:12px 16px;vertical-align:middle}
.table-hover tbody tr:hover{background:linear-gradient(90deg,rgba(59,130,246,.02),transparent)}

/* Buttons */
.btn{border-radius:8px;font-weight:500;font-size:.85rem;padding:8px 16px;transition:all .2s}
.btn:hover{transform:translateY(-1px);box-shadow:0 3px 10px rgba(0,0,0,.1)}
.btn-sm{padding:5px 10px;font-size:.78rem;border-radius:6px}
.btn-primary{background:linear-gradient(135deg,#3b82f6,#2563eb);border:none}
.btn-primary:hover{background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 15px rgba(37,99,235,.3)}
.btn-success{background:linear-gradient(135deg,#22c55e,#16a34a);border:none}
.btn-warning{background:linear-gradient(135deg,#f59e0b,#d97706);border:none}
.btn-danger{background:linear-gradient(135deg,#ef4444,#dc2626);border:none}

/* Badges */
.badge{padding:5px 10px;font-weight:500;font-size:.75rem;border-radius:6px}

/* Form Controls */
.form-control,.form-select{border-radius:8px;border-color:#e2e8f0;padding:10px 14px;font-size:.87rem;transition:border-color .2s,box-shadow .2s}
.form-control:focus,.form-select:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
.form-label{font-weight:500;font-size:.85rem;color:#374151;margin-bottom:6px}

/* Alerts */
.alert{border:none;border-radius:10px;padding:14px 20px;font-size:.87rem}
.alert-success{background:linear-gradient(135deg,rgba(34,197,94,.1),rgba(22,163,74,.05));color:#15803d;border-left:4px solid #22c55e}
.alert-danger{background:linear-gradient(135deg,rgba(239,68,68,.1),rgba(220,38,38,.05));color:#b91c1c;border-left:4px solid #ef4444}

/* Progress */
.progress{border-radius:8px;background:#f1f5f9}
.progress-bar{border-radius:8px;font-weight:600;font-size:.75rem}

/* Pagination */
.pagination{gap:4px}
.pagination .page-link{border-radius:8px;border:none;color:#475569;padding:8px 14px;font-size:.83rem}
.pagination .page-item.active .page-link{background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 2px 8px rgba(37,99,235,.3)}

/* Animations */
@keyframes fadeInUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.content-area>*{animation:fadeInUp .4s ease}

/* ===== MOBILE RESPONSIVE ===== */
@media(max-width:991px){
    .sidebar{transform:translateX(-100%)}
    .sidebar.open{transform:translateX(0)}
    .main-content{margin-left:0}
    .content-area{padding:15px}
    .topbar{padding:0 15px}
    .mobile-menu-btn{display:inline-flex;align-items:center;justify-content:center}
    .stat-card .stat-value{font-size:1.5rem}
    .stat-card{padding:16px}
    .table{font-size:.8rem}
    .table th,.table td{padding:8px 10px}
    .btn{font-size:.8rem;padding:6px 12px}
    .d-flex.justify-content-between{flex-wrap:wrap;gap:10px}
    h5{font-size:1.1rem}
}

@media(max-width:576px){
    .content-area{padding:10px}
    .topbar{height:56px}
    .stat-card .stat-value{font-size:1.3rem}
    .stat-card .stat-label{font-size:.73rem}
    .row.g-3{--bs-gutter-x:.75rem;--bs-gutter-y:.75rem}
    .card{border-radius:10px}
    .table-responsive{font-size:.78rem}
}
</style>
@stack('styles')</head><body>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-graduation-cap" style="font-size:2.2rem;margin-bottom:10px;display:block"></i>
        <h5>Системаи Идоракунии Ҳозирӣ</h5>
        <small style="color:#64748b;font-size:.7rem">Донишгоҳҳо ва Коллеҷҳо</small>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Асосӣ</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i>Панели идоракунӣ</a>

        @can('attendance.create')
        <div class="menu-label">Ҳозирӣ</div>
        <a href="{{ route('attendance.create') }}" class="{{ request()->routeIs('attendance.create*') ? 'active' : '' }}"><i class="fas fa-clipboard-check"></i>Сабти ҳозирӣ</a>
        @endcan
        @can('attendance.view')
        <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.index') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i>Таърихи ҳозирӣ</a>
        @endcan

        <div class="menu-label">Идоракунӣ</div>
        @can('faculties.view')<a href="{{ route('faculties.index') }}" class="{{ request()->routeIs('faculties.*') ? 'active' : '' }}"><i class="fas fa-university"></i>Факултетҳо</a>@endcan
        @can('specialties.view')<a href="{{ route('specialties.index') }}" class="{{ request()->routeIs('specialties.*') ? 'active' : '' }}"><i class="fas fa-book-open"></i>Ихтисосҳо</a>@endcan
        @can('courses.view')<a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}"><i class="fas fa-layer-group"></i>Курсҳо</a>@endcan
        @can('groups.view')<a href="{{ route('groups.index') }}" class="{{ request()->routeIs('groups.*') ? 'active' : '' }}"><i class="fas fa-users"></i>Гурӯҳҳо</a>@endcan
        @can('students.view')<a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}"><i class="fas fa-user-graduate"></i>Донишҷӯён</a>@endcan

        <div class="menu-label">Ҳисоботҳо</div>
        @can('reports.view')<a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i>Ҳисоботҳо</a>@endcan
        @can('statistics.view')<a href="{{ route('statistics.index') }}" class="{{ request()->routeIs('statistics.*') ? 'active' : '' }}"><i class="fas fa-chart-pie"></i>Омори моҳона</a>@endcan

        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('super admin') || Auth::user()->email === 'superadmin@attendance.tj')
        <div class="menu-label">Система</div>
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="fas fa-user-cog"></i>Корбарон</a>
        <a href="{{ route('logs.index') }}" class="{{ request()->routeIs('logs.*') ? 'active' : '' }}"><i class="fas fa-history"></i>Гузориши амалҳо</a>
        @endif
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <header class="topbar">
        <div class="d-flex align-items-center">
            <button class="mobile-menu-btn" id="mobileMenuBtn" type="button">
                <i class="fas fa-bars"></i>
            </button>
            <h6 class="mb-0" style="font-weight:700;color:#1e293b;font-size:1.05rem">@yield('title','Панели идоракунӣ')</h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="text-end d-none d-sm-block">
                <div style="font-weight:600;font-size:.87rem;color:#374151">{{ Auth::user()->name }}</div>
                <div style="font-size:.72rem;color:#9ca3af">@if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('super_admin') || Auth::user()->email === 'superadmin@attendance.tj')Суперадмин@elseif(Auth::user()->hasRole('admin'))Администратор@elseif(Auth::user()->hasRole('dean'))Декан@elseif(Auth::user()->hasRole('supervisor'))Масъули ҳозирӣ@endif</div>
            </div>
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle" style="border-radius:50%;width:38px;height:38px;padding:0;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#e0e7ff,#ede9fe);border:none" data-bs-toggle="dropdown">
                    <i class="fas fa-user" style="color:#6366f1"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="border:none;box-shadow:0 10px 40px rgba(0,0,0,.12);border-radius:10px;padding:8px">
                    <li class="d-sm-none"><span class="dropdown-item-text" style="font-weight:600;font-size:.85rem">{{ Auth::user()->name }}</span></li>
                    <li class="d-sm-none"><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" style="border-radius:6px;padding:10px 15px" href="{{ route('password.change') }}"><i class="fas fa-key me-2 text-primary"></i>Тағйири рамз</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit" class="dropdown-item text-danger" style="border-radius:6px;padding:10px 15px"><i class="fas fa-sign-out-alt me-2"></i>Баромадан</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="content-area">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Mobile sidebar toggle
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const menuBtn = document.getElementById('mobileMenuBtn');

menuBtn.addEventListener('click', function() {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
    // Change icon
    const icon = this.querySelector('i');
    if (sidebar.classList.contains('open')) {
        icon.className = 'fas fa-times';
    } else {
        icon.className = 'fas fa-bars';
    }
});

overlay.addEventListener('click', function() {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    menuBtn.querySelector('i').className = 'fas fa-bars';
});

// Close sidebar when clicking a link (mobile)
document.querySelectorAll('.sidebar-menu a').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 991) {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            menuBtn.querySelector('i').className = 'fas fa-bars';
        }
    });
});
</script>
@stack('scripts')
</body></html>
