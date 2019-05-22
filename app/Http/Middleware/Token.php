<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use App\Model\CompanyModel;

class Token
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
        if(empty($_GET['appid']) || empty($_GET['key'])){
            $response=[
                'status'=>1,
                'msg'=>'缺少参数'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }


        $ip=$_SERVER['SERVER_ADDR'];
        $key='520zk_token_'.$ip;
        $num=Redis::get($key);
        if($num>6){
            $response=[
                'status'=>3,
                'msg'=>'调用次数受限制'
            ];

            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }


        return $next($request);
    }
}
