<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsMarketing
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->jabatan == 'Marketing') {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'Anda Tidak Punya Akses');
    }
}