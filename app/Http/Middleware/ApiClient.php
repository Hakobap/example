<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ApiClient
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
        $clientId = intval(request('client_id', 0));
        $clientSecret = trim(request('client_secret'));

        if ($clientId && $clientSecret) {
            $isClient  = (bool) DB::table('oauth_clients')->where(['id' => $clientId, 'secret' => $clientSecret])->count();
            if ($isClient) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Please check the client_id and client_secret.']);
    }
}
