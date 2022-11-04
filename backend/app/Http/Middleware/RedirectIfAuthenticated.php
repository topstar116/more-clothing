<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // return redirect(RouteServiceProvider::HOME);
                return redirect('/custody/box');
            }
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if(!$request->expactsJson())
        {
            $URI = explore("/", $request->getRequestUri());
            switch($URI[1])
            {
                // ユーザー管理画面のリダイレクト設定
                case 'custody';
                return route('sign-in');

                // 管理者管理画面のリダイレクト設定
                case 'admin';
                return route('admin-login');
            }
        }
    }
}
