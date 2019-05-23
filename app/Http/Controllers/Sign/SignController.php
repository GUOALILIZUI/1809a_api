<?php

namespace App\Http\Controllers\Sign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UsersModel;
use Illuminate\Support\Facades\Redis;

class SignController extends Controller
{
    //


    public function signLogin(){
        return view('sign.signlogin');
    }

    public function log(Request $request){
        $uid=$request->input('id');

        $key='sign';

        $redis=Redis::setbit($key,$uid,1);
            $response=[
                'status'=>0,
                'msg'=>'签到成功',
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);




    }
    public function index(){
        $key='sign';

        $num= Redis::bitcount($key);

        return view('sign.index',['num'=>$num]);
    }
}
