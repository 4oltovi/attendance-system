<!DOCTYPE html>
<html lang="tj"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Воридшавӣ - Системаи Ҳозирӣ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#334155 100%);font-family:'Segoe UI',sans-serif;position:relative;overflow:hidden}
body::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle,rgba(59,130,246,.05) 0%,transparent 50%);animation:pulse 15s ease infinite}
@keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.1)}}
.login-wrapper{position:relative;z-index:1}
.login-card{background:rgba(255,255,255,.98);border-radius:20px;box-shadow:0 25px 80px rgba(0,0,0,.4);overflow:hidden;max-width:440px;width:100%;backdrop-filter:blur(20px)}
.login-header{background:linear-gradient(135deg,#1e40af 0%,#3b82f6 50%,#6366f1 100%);color:white;padding:40px 30px;text-align:center;position:relative;overflow:hidden}
.login-header::after{content:'';position:absolute;bottom:-2px;left:0;width:100%;height:4px;background:linear-gradient(90deg,#f59e0b,#ef4444,#8b5cf6,#3b82f6)}
.login-header .logo-icon{font-size:3.5rem;margin-bottom:15px;display:block;text-shadow:0 4px 15px rgba(0,0,0,.2);animation:float 3s ease-in-out infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}
.login-header h3{font-weight:800;font-size:1.3rem;letter-spacing:.5px}
.login-header p{opacity:.85;font-size:.85rem;margin-top:5px}
.login-body{padding:40px 35px}
.form-floating{margin-bottom:20px}
.form-floating .form-control{border-radius:12px;border:2px solid #e2e8f0;padding:16px 14px;height:55px;font-size:.9rem;transition:all .3s}
.form-floating .form-control:focus{border-color:#3b82f6;box-shadow:0 0 0 4px rgba(59,130,246,.1)}
.form-floating label{color:#64748b;font-size:.87rem}
.btn-login{background:linear-gradient(135deg,#3b82f6 0%,#6366f1 100%);border:none;border-radius:12px;padding:14px;font-weight:700;font-size:1rem;letter-spacing:.5px;transition:all .3s;box-shadow:0 4px 15px rgba(59,130,246,.3)}
.btn-login:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(59,130,246,.4);background:linear-gradient(135deg,#2563eb 0%,#4f46e5 100%)}
.btn-login:active{transform:translateY(0)}
.form-check-input:checked{background-color:#3b82f6;border-color:#3b82f6}
.decoration-circles{position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:hidden}
.decoration-circles span{position:absolute;border-radius:50%;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05)}
.decoration-circles span:nth-child(1){width:300px;height:300px;top:-100px;right:-100px}
.decoration-circles span:nth-child(2){width:200px;height:200px;bottom:-50px;left:-50px}
.decoration-circles span:nth-child(3){width:150px;height:150px;top:50%;right:10%}
</style></head><body>
<div class="decoration-circles"><span></span><span></span><span></span></div>
<div class="login-wrapper">
<div class="login-card">
    <div class="login-header">
        <i class="fas fa-graduation-cap logo-icon"></i>
        <h3>Системаи Идоракунии Ҳозирӣ</h3>
        <p>Донишгоҳҳо ва Коллеҷҳо</p>
    </div>
    <div class="login-body">
        @if($errors->any())
        <div class="alert alert-danger" style="border-radius:10px;border:none;border-left:4px solid #ef4444;background:rgba(239,68,68,.08);font-size:.85rem">
            @foreach($errors->all() as $error)<i class="fas fa-exclamation-circle me-1"></i>{{ $error }}<br>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">@csrf
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="email" required autofocus>
                <label for="email"><i class="fas fa-envelope me-2"></i>Почтаи электронӣ</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                <label for="password"><i class="fas fa-lock me-2"></i>Рамз</label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember" style="font-size:.85rem;color:#64748b">Маро дар хотир дор</label>
            </div>
            <button type="submit" class="btn btn-primary btn-login w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Ворид шудан
            </button>
        </form>

        <div class="mt-4 text-center">
            <small style="color:#94a3b8">&copy; {{ date('Y') }} Системаи Идоракунии Ҳозирӣ. Ҳамаи ҳуқуқҳо маҳфузанд.</small>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
