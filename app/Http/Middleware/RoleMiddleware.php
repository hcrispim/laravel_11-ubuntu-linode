<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response; // Use a classe correta
use Illuminate\Http\Request;

class RoleMiddleware
{
//    public function handle(Request $request, Closure $next, $role)
    public function handle(Request $request, Closure $next, $role):Response
    {
        if($role !== $request->user()->role){
            return redirect('dashboard');
        }
        //dd('middleware executed');
        //dd($request);
        return $next($request);
    }
}
