<?php

namespace App\Http\Middleware;

use App\Models\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $lang = ($user && $user->settings) ? $user->settings['locale'] : Cookie::get('locale') ?? Locale::value('format');
        app()->setLocale($lang);

        return $next($request);
    }
}
