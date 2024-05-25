<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        $validToken = DB::table('tokens')
            ->where('token', $token)
            ->first();

        if (!$validToken) {
            return $this->tokenResponses('Invalid token');
        }

        if ($validToken->expires_at <= now()) {
            return $this->tokenResponses('Token expired');
        }

        if ($validToken->used) {
            return $this->tokenResponses('Token already used');
        }

        DB::table('tokens')
            ->where('token', $token)
            ->update(['used' => true]);

        return $next($request);
    }
    private function tokenResponses($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 401);
    }
}
