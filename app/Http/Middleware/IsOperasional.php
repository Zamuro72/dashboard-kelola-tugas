<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOperasional
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->jabatan == 'Operasional') {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'Anda Tidak Punya Akses');
    }
}