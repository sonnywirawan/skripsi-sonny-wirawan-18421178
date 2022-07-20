<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Agent;

class ValidateBrowserVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->header('User-Agent'));
        // dd(get_browser_manually());
        // dd(get_browser(null, true));
        // $agent = new Agent();
        // $browser = $agent::browser();
        // $browser_version = $agent::version($browser);
        // $platform = $agent::platform();
        // $platform_version = $agent::version($platform);
        // dd($browser, $browser_version, $platform, $platform_version);
        // dd($request->headers->get('User-Agent'));

        // if($browser == "Chrome") {

        // } else if($browser == "Safari") {

        // } else if($browser == "Edge") {
            
        // }
        // if ($request->headers->get('User-Agent')) {
        //     return redirect('home');
        // }
 
        return $next($request);
    }
}
