<?php

namespace App\Http\Middleware;

use Closure;
use Facade\FlareClient\Http\Exceptions\BadResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $roles = Auth::user()->roles;
        foreach ($roles as $rol) {
            if ($rol->id == 1) {
                return $next($request);
            }
        }
        $response = [
            'success' => false,
            'message' => 'Desautorizado',
            'data'    => [],
            'total'   => 0
        ];
        return response()->json($response, 425);
    }
}