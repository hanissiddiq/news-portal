<?php
namespace App\Http\Middleware;
use Closure;

class CheckRole {
    public function handle($request, Closure $next, ...$roles) {
        $user = $request->user();
        if (!$user) return response()->json(['message'=>'Unauthenticated'],401);
        if (!in_array($user->role, $roles)) {
            return response()->json(['message'=>'Forbidden - insufficient role'],403);
        }
        return $next($request);
    }
}
