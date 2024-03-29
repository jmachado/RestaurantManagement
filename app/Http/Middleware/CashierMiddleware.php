<?php

namespace App\Http\Middleware;

use Closure;

class CashierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->guard('api')->user() != null) {
            if (auth()->guard('api')->user()->type == 'cashier' || auth()->guard('api')->user()->type == 'manager') {
                return $next($request);
            } else {
                return redirect('/#/dashboard');

            }
        }else {
            return redirect('/#/items');
        }
    }
}
