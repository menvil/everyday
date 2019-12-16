<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Carbon\Factory;
use Carbon\CarbonImmutable;
use Closure;
use Session;
use App;
use Config;

class SetLocale
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
        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        } elseif (in_array(array_key_first(explode('.', $request->getHost())), ['ru','en'])){
            $locale = array_key_first(explode('.', $request->getHost()));
        } else {
            $locale = Config::get('app.locale');
//            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
//
//            if ($locale != 'ru' && $locale != 'en') {
//                $locale = Config::get('app.locale');
//            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
