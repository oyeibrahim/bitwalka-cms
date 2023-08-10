<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userLocale = $request->segment(1);

        $supportedLocale = ['en', 'ar', 'es', 'fr', 'en-NG'];

        $supportedRoutes = ['login', 'register', 'dashboard'];

        //User didn't enter a Locale but rather visited the route directly
        if (in_array($userLocale, $supportedRoutes)) {
            // You can use session or user setting to set initial locale here
            return redirect(url('en/' . $userLocale));
        }

        //Unsupported Locale
        if (!in_array($userLocale, $supportedLocale)) {
            abort(404);
        }

        app()->setLocale($userLocale);
        URL::defaults(['locale' => $userLocale]);

        return $next($request);
    }
}
