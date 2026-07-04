<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole {
    public function handle(Request $request, Closure $next, string ...$roles): Response {
        if (!$request->user()) { abort(403); }
        
        // Superadmin ҲАМЕША дастрасӣ дорад (ҳамаи вариантҳо)
        if ($request->user()->hasRole('superadmin') || 
            $request->user()->hasRole('super_admin') || 
            $request->user()->hasRole('super admin') ||
            $request->user()->email === 'superadmin@attendance.tj') {
            return $next($request);
        }
        
        if (!$request->user()->hasAnyRole($roles)) { 
            abort(403, 'Шумо иҷозати дастрасӣ надоред.'); 
        }
        return $next($request);
    }
}
