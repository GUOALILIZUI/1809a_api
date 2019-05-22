<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;


class RequestTimes
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
        echo date("Y-m-d H:i:s");
        echo "<br>";

        $token=$request->input('token');
        $ip=$_SERVER['SERVER_ADDR'];
        $key='requestTime'.$ip.'token'.$token;
        $num=Redis::get($key);
            if($num>10){
                die('调用超过限制');
            }
            print_r($num);echo "<br>";
            Redis::incr($key);
            Redis::expire($key,60);
            return $next($request);
    }
}
